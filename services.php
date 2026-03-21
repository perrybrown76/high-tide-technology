<?php
$pageTitle = 'Services | High Tide Technology';
$pageDescription = 'High Tide Technology Services — Cybersecurity, development, telecommunications, project management, training, and more.';
require 'includes/head.php';
?>
<body>

  <?php include 'includes/nav.php'; ?>

  <!-- Page Hero -->
  <section class="page-hero service-hero">
    <div class="container">
      <div class="partner-hero-text">
        <h1>Our Services</h1>
        <p>High Tide Technology delivers professional technical and cybersecurity services across nine disciplines — from threat defense and software development to project management and workforce training.</p>
      </div>
    </div>
  </section>

  <div class="neon-line"></div>

  <!-- Services Grid -->
  <section class="section page-content">
    <div class="container">
      <div class="services-cards services-cards--large">

        <a href="cyber-security.php" class="service-card service-card--blue">
          <div class="service-card-head">
            <div class="service-card-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
            <h3>Cyber Security</h3>
          </div>
          <p>End-to-end protection across your organization — from assessment to active defense.</p>
          <ul class="service-card-bullets">
            <li>Threat assessment &amp; vulnerability management</li>
            <li>Incident response &amp; digital forensics</li>
            <li>Compliance &amp; information assurance audits</li>
          </ul>
        </a>

        <a href="development.php" class="service-card service-card--cyan">
          <div class="service-card-head">
            <div class="service-card-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></div>
            <h3>Development</h3>
          </div>
          <p>Custom software built to your requirements — responsive, scalable, and data-driven.</p>
          <ul class="service-card-bullets">
            <li>Responsive web &amp; mobile applications</li>
            <li>Cloud, SharePoint &amp; Azure solutions</li>
            <li>Database design &amp; custom integrations</li>
          </ul>
        </a>

        <a href="telecommunications.php" class="service-card service-card--magenta">
          <div class="service-card-head">
            <div class="service-card-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg></div>
            <h3>Telecommunications</h3>
          </div>
          <p>Enterprise network expertise from design through deployment and ongoing management.</p>
          <ul class="service-card-bullets">
            <li>Network planning &amp; engineering</li>
            <li>Infrastructure design &amp; deployment</li>
            <li>Telecommunications systems management</li>
          </ul>
        </a>

        <a href="project-management.php" class="service-card service-card--blue">
          <div class="service-card-head">
            <div class="service-card-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg></div>
            <h3>Project Management</h3>
          </div>
          <p>Certified professionals who deliver complex IT initiatives on time and within budget.</p>
          <ul class="service-card-bullets">
            <li>Program &amp; project planning</li>
            <li>Schedule, scope &amp; budget management</li>
            <li>Stakeholder reporting &amp; governance</li>
          </ul>
        </a>

        <a href="training.php" class="service-card service-card--cyan">
          <div class="service-card-head">
            <div class="service-card-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></div>
            <h3>Training</h3>
          </div>
          <p>Full-spectrum training partnership from curriculum design through real-world delivery.</p>
          <ul class="service-card-bullets">
            <li>Course development &amp; curriculum design</li>
            <li>Technical &amp; cybersecurity instruction</li>
            <li>Leadership &amp; professional development</li>
          </ul>
        </a>

        <a href="automated-protection.php" class="service-card service-card--magenta">
          <div class="service-card-head">
            <div class="service-card-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg></div>
            <h3>Automated Protection</h3>
          </div>
          <p>A proven 7-step framework securing industrial control and automation environments.</p>
          <ul class="service-card-bullets">
            <li>ICS &amp; operational technology (OT) security</li>
            <li>Automated threat detection &amp; response</li>
            <li>Regulatory compliance management</li>
          </ul>
        </a>

        <a href="naic-principles.php" class="service-card service-card--blue">
          <div class="service-card-head">
            <div class="service-card-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></div>
            <h3>NAIC Principles</h3>
          </div>
          <p>Helping insurance companies meet NAIC cybersecurity regulatory requirements.</p>
          <ul class="service-card-bullets">
            <li>Insurance Data Security Model Law compliance</li>
            <li>Regulatory gap analysis &amp; remediation</li>
            <li>Ongoing cybersecurity program support</li>
          </ul>
        </a>

        <a href="when-not-if.php" class="service-card service-card--cyan">
          <div class="service-card-head">
            <div class="service-card-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
            <h3>When, Not If</h3>
          </div>
          <p>Insurance industry-specific services built on the reality that breaches will happen.</p>
          <ul class="service-card-bullets">
            <li>Breach preparedness planning &amp; exercises</li>
            <li>NAIC Cyber Security Principles alignment</li>
            <li>Consumer data protection strategy</li>
          </ul>
        </a>

        <a href="target-product-line.php" class="service-card service-card--magenta">
          <div class="service-card-head">
            <div class="service-card-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg></div>
            <h3>TARGET Product Line</h3>
          </div>
          <p>Proprietary appliance-based intelligence delivering continuous network threat visibility.</p>
          <ul class="service-card-bullets">
            <li>Purpose-built network sentinel appliance</li>
            <li>Real-time threat &amp; intrusion monitoring</li>
            <li>Cloud-based multi-threat intelligence dashboard</li>
          </ul>
        </a>

      </div>
    </div>
  </section>

  <!-- CTA Strip -->
  <section class="cta-strip">
    <div class="container">
      <h2>Ready to Get Started?</h2>
      <p>Let High Tide Technology's team of professionals put the right solution to work for your organization.</p>
      <a href="contact.php" class="btn btn-primary btn-lg">Contact Us</a>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>