# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What This Is

A static marketing website for **High Tide Technology**, a cybersecurity and IT services company. Hosted on GoDaddy shared hosting. No build system — files are served as-is.

## Running Locally

```
php -S localhost:8000
```

Then open `http://localhost:8000` in a browser.

## Stack

- **HTML/CSS/JS** — vanilla, no frameworks
- **PHP** — contact form only (`contact-handler.php` via PHPMailer + reCAPTCHA v2)
- **Apache** — `.htaccess` handles HTTPS redirects, security headers, cache control

## Architecture

- Each page is a self-contained HTML file (navigation and footer repeated in each)
- **`css/main.css`** — design system: CSS variables, animations, global layout
- **`css/pages.css`** — page-specific overrides
- **`js/main.js`** — mobile nav, smooth scroll, form validation, fetch submission
- **`assets/images/`** — logos and partner brand assets
- **`contact-handler.php`** — JSON API endpoint, CSRF + reCAPTCHA + PHPMailer
- **`vendor/phpmailer/`** — mail library (do not modify)

## Design System

Dark cybersecurity theme defined in `css/main.css` via CSS custom properties:
- Base: `#06080f`
- Neon blue: `#015ef9`, Cyan: `#00d4ff`, Magenta: `#c026d3`
- Fonts: Lato, Space Grotesk (Google Fonts)
- Mobile breakpoint: 768px

## Deployment

Push to GitHub (`main` branch) → manually upload changed files to GoDaddy via FTP or file manager. No CI/CD pipeline.

## Key Contacts

- Repo owner: `perrybrown76` (Perry Brown)
- Contact form emails go to: `perrybrown76@gmail.com`
