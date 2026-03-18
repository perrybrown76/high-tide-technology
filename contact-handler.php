<?php
/**
 * High Tide Technology — Contact Form Handler
 *
 * PHPMailer-based contact form processor with CSRF protection,
 * reCAPTCHA validation, and input sanitization.
 *
 * Hosting note: GoDaddy shared hosting supports PHP mail() by default,
 * so SMTP configuration is optional. SMTP settings are commented out below.
 *
 * Fallback note: If PHP mail is unavailable or unreliable, consider using
 * Formspree (https://formspree.io) as a drop-in replacement. Point the
 * form action to your Formspree endpoint and remove this handler.
 *
 * TODO: Implement rate limiting — see notes at bottom of file.
 */

session_start();

// Set JSON response header
header('Content-Type: application/json; charset=utf-8');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed. Only POST requests are accepted.'
    ]);
    exit;
}

// ---------------------------------------------------------------------------
// CSRF Validation
// ---------------------------------------------------------------------------
if (
    !isset($_POST['csrf_token']) ||
    !isset($_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid or missing CSRF token. Please refresh the page and try again.'
    ]);
    exit;
}

// Invalidate used token to prevent replay
unset($_SESSION['csrf_token']);

// ---------------------------------------------------------------------------
// reCAPTCHA v2 Server-Side Verification
// ---------------------------------------------------------------------------

// TODO: Replace with your reCAPTCHA secret key from https://www.google.com/recaptcha/admin
$recaptchaSecret = 'YOUR_RECAPTCHA_SECRET_KEY_HERE';

$recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

if (empty($recaptchaResponse)) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'Please complete the reCAPTCHA verification.'
    ]);
    exit;
}

$verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
$verifyData = http_build_query([
    'secret'   => $recaptchaSecret,
    'response' => $recaptchaResponse,
    'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
]);

$verifyResult = file_get_contents($verifyUrl . '?' . $verifyData);
$captchaData  = json_decode($verifyResult, true);

if (!$captchaData || empty($captchaData['success'])) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'reCAPTCHA verification failed. Please try again.'
    ]);
    exit;
}

// ---------------------------------------------------------------------------
// Input Sanitization & Validation
// ---------------------------------------------------------------------------

/**
 * Sanitize a string input: trim, strip tags, encode special characters.
 */
function sanitizeInput(string $value): string
{
    $value = trim($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    return $value;
}

// Required fields
$name  = sanitizeInput($_POST['name'] ?? '');
$email = sanitizeInput($_POST['email'] ?? '');

// Optional field
$message = sanitizeInput($_POST['message'] ?? '');

if ($name === '') {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'Name is required.'
    ]);
    exit;
}

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'A valid email address is required.'
    ]);
    exit;
}

// Extra guard: reject email values that contain newlines (header injection)
if (preg_match('/[\r\n]/', $email) || preg_match('/[\r\n]/', $name)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid characters detected in input.'
    ]);
    exit;
}

// ---------------------------------------------------------------------------
// Send Email via PHPMailer
// ---------------------------------------------------------------------------

// PHPMailer autoloader — legacy standalone install
require 'vendor/phpmailer/PHPMailerAutoload.php';
// If using Composer autoload instead, replace the line above with:
// require 'vendor/autoload.php';

$mail = new PHPMailer;

// --- SMTP Configuration (optional on GoDaddy) ---
// GoDaddy shared hosting supports PHP mail() natively, so SMTP is not
// required. Uncomment and fill in the block below if you need SMTP.
//
// $mail->isSMTP();
// $mail->Host       = 'smtp.example.com';    // TODO: SMTP server hostname
// $mail->SMTPAuth   = true;
// $mail->Username   = 'user@example.com';    // TODO: SMTP username
// $mail->Password   = 'your-password-here';  // TODO: SMTP password
// $mail->SMTPSecure = 'tls';                 // 'tls' (port 587) or 'ssl' (port 465)
// $mail->Port       = 587;                   // TODO: SMTP port

// Sender (server default / no-reply address — never raw user input)
$mail->setFrom('noreply@ihightide.com', 'High Tide Technology');

// Recipient
$mail->addAddress('perrybrown76@gmail.com');

// Reply-To uses the validated, sanitized sender email
$mail->addReplyTo($email, $name);

// Subject — uses sanitized name only
$mail->Subject = 'Contact Form Submission from ' . $name;

// HTML body
$mail->isHTML(true);
$mail->CharSet = 'UTF-8';

$messageBody = $message !== '' ? nl2br($message) : '<em>No message provided.</em>';

$mail->Body = <<<HTML
<html>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2 style="color: #0a3d62;">New Contact Form Submission</h2>
    <table style="border-collapse: collapse; width: 100%; max-width: 600px;">
        <tr>
            <td style="padding: 8px 12px; font-weight: bold; border-bottom: 1px solid #ddd;">Name</td>
            <td style="padding: 8px 12px; border-bottom: 1px solid #ddd;">{$name}</td>
        </tr>
        <tr>
            <td style="padding: 8px 12px; font-weight: bold; border-bottom: 1px solid #ddd;">Email</td>
            <td style="padding: 8px 12px; border-bottom: 1px solid #ddd;">{$email}</td>
        </tr>
        <tr>
            <td style="padding: 8px 12px; font-weight: bold; vertical-align: top;">Message</td>
            <td style="padding: 8px 12px;">{$messageBody}</td>
        </tr>
    </table>
    <p style="margin-top: 20px; font-size: 12px; color: #999;">
        Sent via the contact form at ihightide.com
    </p>
</body>
</html>
HTML;

// Plain-text fallback
$mail->AltBody = "Name: {$name}\nEmail: {$email}\nMessage: " . ($message !== '' ? $message : '(none)');

if ($mail->send()) {
    echo json_encode([
        'success' => true,
        'message' => 'Thank you! Your message has been sent successfully.'
    ]);
} else {
    // Log the error server-side; do not expose internals to the client
    error_log('PHPMailer error: ' . $mail->ErrorInfo);
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Sorry, your message could not be sent. Please try again later.'
    ]);
}

// ---------------------------------------------------------------------------
// Rate Limiting — Future Implementation Notes
// ---------------------------------------------------------------------------
//
// On GoDaddy shared hosting, options for rate limiting include:
//
// 1. Session-based: Store a timestamp in $_SESSION after each successful
//    submission and reject requests within a cooldown window (e.g., 60s).
//
// 2. File-based: Write IP + timestamp to a flat file or SQLite database
//    and check before processing. Clean up stale entries periodically.
//
// 3. Cloudflare: Place the site behind Cloudflare (free tier) to get
//    built-in DDoS protection and rate limiting rules.
//
// 4. reCAPTCHA alone provides a baseline bot deterrent but does not
//    prevent a determined user from submitting repeatedly.
