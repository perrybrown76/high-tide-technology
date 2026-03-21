<?php
$pageTitle = 'High Tide Technology LLC — Cybersecurity &amp; IT Solutions';
$pageDescription = 'High Tide Technology LLC — Cybersecurity, IT services, development, telecommunications, project management and training since 2006.';
$headExtra = '<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "LocalBusiness",
    "name": "High Tide Technology LLC",
    "description": "Professional cybersecurity and IT solutions provider since 2006.",
    "url": "https://ihightide.com",
    "email": "info@ihightide.com",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "5151 Hampstead High Street Suite 200",
      "addressLocality": "Montgomery",
      "addressRegion": "AL",
      "addressCountry": "US"
    },
    "foundingDate": "2006"
  }
  </script>';
require 'includes/head.php';
?>
<body>

  <?php include 'includes/nav.php'; ?>

  <!-- Hero -->
  <section class="home-hero">

    <div class="home-hero-inner">
      <div class="hero-left">
        <h1>Professional<br>Solutions<br>for Industry</h1>
        <p>High Tide Technology has been providing cost-efficient technical and professional services personnel to clients since 2006. Development, cybersecurity, telecommunications, project management, and training.</p>
        <div class="hero-cta-group">
          <a href="cyber-security.php" class="btn btn-primary btn-lg">Our Services</a>
          <a href="contact.php" class="btn btn-secondary btn-lg">Contact Us</a>
        </div>
      </div>

      <div class="hero-right">
        <!-- 3D Floating Shield Logo -->
        <div id="logo3d-wrapper">
          <style>
            #logo3d-wrapper {
              --logo-size: min(720px, 80vw);
              display: flex;
              align-items: flex-start;
              justify-content: center;
              width: 100%;
              padding: 0;
              perspective: 1000px;
            }

            #logo3d-scene {
              width: var(--logo-size);
              position: relative;
              transform-style: preserve-3d;
              will-change: transform;
            }

            #logo3d-scene img {
              display: block;
              width: 100%;
              height: auto;
              pointer-events: none;
              user-select: none;
              -webkit-user-drag: none;
            }
            #logo3d-scene {
              transition: filter 0.3s ease;
            }
            #logo3d-scene.hovered {
              filter: drop-shadow(0 18px 40px rgba(1,94,249,0.45));
            }


            @media (max-width: 1024px) {
              #logo3d-wrapper { display: none; }
            }
          </style>

          <div id="logo3d-scene">
            <img src="assets/images/shield-3d.svg" alt="High Tide Technology Shield" />
          </div>

          <script>
            (function () {
              const scene = document.getElementById('logo3d-scene');
              if (!scene) return;

              let tiltX = 0, tiltY = 0;
              let targetTiltX = 0, targetTiltY = 0;
              let floatTime = 0;
              let raf;
              let visible = true;

              function lerp(a, b, t) { return a + (b - a) * t; }

              function render() {
                floatTime += 0.015;

                const floatY    = Math.sin(floatTime) * 10;
                const floatRotX = Math.sin(floatTime * 0.8) * 1.5;
                const floatRotY = Math.cos(floatTime * 0.6) * 1.5;

                tiltX = lerp(tiltX, targetTiltX, 0.07);
                tiltY = lerp(tiltY, targetTiltY, 0.07);

                const totalRotY = floatRotY + tiltX - 10;
                const totalRotX = floatRotX + tiltY + 6;

                scene.style.transform =
                  `translateY(${floatY}px) rotateX(${totalRotX}deg) rotateY(${totalRotY}deg)`;

                raf = requestAnimationFrame(render);
              }

              raf = requestAnimationFrame(render);

              // Pause animation when hero is off-screen
              const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                  if (!raf) raf = requestAnimationFrame(render);
                } else {
                  cancelAnimationFrame(raf);
                  raf = null;
                }
              }, { threshold: 0 });
              observer.observe(scene);

              scene.addEventListener('mouseenter', () => { scene.classList.add('hovered'); });
              scene.addEventListener('mousemove', (e) => {
                const rect = scene.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width;
                const y = (e.clientY - rect.top)  / rect.height;
                targetTiltX =  (x - 0.5) * 24;
                targetTiltY = -(y - 0.5) * 18;
              });
              scene.addEventListener('mouseleave', () => {
                scene.classList.remove('hovered');
                targetTiltX = 0;
                targetTiltY = 0;
              });

              scene.addEventListener('touchmove', (e) => {
                const touch = e.touches[0];
                const rect = scene.getBoundingClientRect();
                const x = (touch.clientX - rect.left) / rect.width;
                const y = (touch.clientY - rect.top)  / rect.height;
                targetTiltX =  (x - 0.5) * 24;
                targetTiltY = -(y - 0.5) * 18;
              }, { passive: true });
              scene.addEventListener('touchend', () => {
                targetTiltX = 0;
                targetTiltY = 0;
              });

            })();
          </script>
        </div>
      </div>
    </div>

  </section>

  <!-- Trust Bar -->
  <section class="trust-bar">
    <h6>Trusted Partnerships</h6>
    <div class="trust-carousel">
      <div class="trust-track">
        <a href="adminbyrequest.php"><img src="assets/images/white-partner-logos/admin-by-request-white.png" alt="AdminByRequest"></a>
        <a href="amazon-web-services-1.php"><img src="assets/images/white-partner-logos/aws-white.png" alt="AWS"></a>
        <a href="brocade.php"><img src="assets/images/white-partner-logos/brocade-white.png" alt="Brocade"></a>
        <a href="carbonite.php"><img src="assets/images/white-partner-logos/carbonite-white.png" alt="Carbonite"></a>
        <a href="cohesity.php"><img src="assets/images/white-partner-logos/cohesity-white.png" alt="Cohesity"></a>
        <a href="cybersaint-1.php"><img src="assets/images/white-partner-logos/cybersaint-white.png" alt="CyberSaint"></a>
        <a href="cylance.php"><img src="assets/images/white-partner-logos/cylance-white.png" alt="Cylance"></a>
        <a href="datto.php"><img src="assets/images/white-partner-logos/datto-white.png" alt="Datto"></a>
        <a href="galileo.php"><img src="assets/images/white-partner-logos/galileo-white.png" alt="Galileo"></a>
        <a href="hbs.php"><img src="assets/images/white-partner-logos/hbs-white.png" alt="HBS"></a>
        <a href="ketch.php"><img src="assets/images/white-partner-logos/ketch-white.png" alt="Ketch"></a>
        <a href="malwarebytes.php"><img src="assets/images/white-partner-logos/malwarebytes-white.png" alt="Malwarebytes"></a>
        <a href="salvagedata.php"><img src="assets/images/white-partner-logos/salvagedata-white.png" alt="SalvageData"></a>
        <a href="sentinel-one.php"><img src="assets/images/white-partner-logos/sentinel-one-white.png" alt="SentinelOne"></a>
        <a href="vectra.php"><img src="assets/images/white-partner-logos/vectra-white.png" alt="Vectra"></a>
        <a href="qualys.php"><img src="assets/images/white-partner-logos/qualsys-white.png" alt="Qualys"></a>
        <!-- Duplicate for seamless loop -->
        <a href="adminbyrequest.php" tabindex="-1" aria-hidden="true"><img src="assets/images/white-partner-logos/admin-by-request-white.png" alt=""></a>
        <a href="amazon-web-services-1.php" tabindex="-1" aria-hidden="true"><img src="assets/images/white-partner-logos/aws-white.png" alt=""></a>
        <a href="brocade.php" tabindex="-1" aria-hidden="true"><img src="assets/images/white-partner-logos/brocade-white.png" alt=""></a>
        <a href="carbonite.php" tabindex="-1" aria-hidden="true"><img src="assets/images/white-partner-logos/carbonite-white.png" alt=""></a>
        <a href="cohesity.php" tabindex="-1" aria-hidden="true"><img src="assets/images/white-partner-logos/cohesity-white.png" alt=""></a>
        <a href="cybersaint-1.php" tabindex="-1" aria-hidden="true"><img src="assets/images/white-partner-logos/cybersaint-white.png" alt=""></a>
        <a href="cylance.php" tabindex="-1" aria-hidden="true"><img src="assets/images/white-partner-logos/cylance-white.png" alt=""></a>
        <a href="datto.php" tabindex="-1" aria-hidden="true"><img src="assets/images/white-partner-logos/datto-white.png" alt=""></a>
        <a href="galileo.php" tabindex="-1" aria-hidden="true"><img src="assets/images/white-partner-logos/galileo-white.png" alt=""></a>
        <a href="hbs.php" tabindex="-1" aria-hidden="true"><img src="assets/images/white-partner-logos/hbs-white.png" alt=""></a>
        <a href="ketch.php" tabindex="-1" aria-hidden="true"><img src="assets/images/white-partner-logos/ketch-white.png" alt=""></a>
        <a href="malwarebytes.php" tabindex="-1" aria-hidden="true"><img src="assets/images/white-partner-logos/malwarebytes-white.png" alt=""></a>
        <a href="salvagedata.php" tabindex="-1" aria-hidden="true"><img src="assets/images/white-partner-logos/salvagedata-white.png" alt=""></a>
        <a href="sentinel-one.php" tabindex="-1" aria-hidden="true"><img src="assets/images/white-partner-logos/sentinel-one-white.png" alt=""></a>
        <a href="vectra.php" tabindex="-1" aria-hidden="true"><img src="assets/images/white-partner-logos/vectra-white.png" alt=""></a>
        <a href="qualys.php" tabindex="-1" aria-hidden="true"><img src="assets/images/white-partner-logos/qualsys-white.png" alt=""></a>
      </div>
    </div>
  </section>

  <!-- Services -->
  <section class="section services-section">
    <div class="container">
      <div class="services-header">
        <h2>Our Services</h2>
        <a href="services.php" class="services-view-all">View all &rarr;</a>
      </div>

      <div class="services-cards">

        <a href="cyber-security.php" class="service-card service-card--blue">
          <div class="service-card-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
          <div class="service-card-body"><h3>Cyber Security</h3><p>Threat assessment, incident response, vulnerability management, and compliance.</p></div>
        </a>

        <a href="development.php" class="service-card service-card--cyan">
          <div class="service-card-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></div>
          <div class="service-card-body"><h3>Development</h3><p>Custom software — websites, mobile apps, cloud, SharePoint, and Azure.</p></div>
        </a>

        <a href="telecommunications.php" class="service-card service-card--magenta">
          <div class="service-card-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg></div>
          <div class="service-card-body"><h3>Telecommunications</h3><p>Network design, engineering, testing, and enterprise infrastructure support.</p></div>
        </a>

        <a href="project-management.php" class="service-card service-card--blue">
          <div class="service-card-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg></div>
          <div class="service-card-body"><h3>Project Management</h3><p>Certified PMs delivering initiatives on time, within scope, and on budget.</p></div>
        </a>

        <a href="training.php" class="service-card service-card--cyan">
          <div class="service-card-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></div>
          <div class="service-card-body"><h3>Training</h3><p>From course development through delivery — technical, cybersecurity, and leadership.</p></div>
        </a>

        <a href="automated-protection.php" class="service-card service-card--magenta">
          <div class="service-card-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg></div>
          <div class="service-card-body"><h3>Automated Protection</h3><p>A proven 7-step approach to industrial control system security — built for modern automation environments.</p></div>
        </a>

        <a href="naic-principles.php" class="service-card service-card--blue">
          <div class="service-card-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg></div>
          <div class="service-card-body"><h3>NAIC Principles</h3><p>Helping insurance companies address NAIC cybersecurity regulatory guidance and ensure compliance.</p></div>
        </a>

        <a href="when-not-if.php" class="service-card service-card--magenta">
          <div class="service-card-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
          <div class="service-card-body"><h3>When, Not If</h3><p>Insurance industry-specific cybersecurity services built around the reality that breaches are inevitable.</p></div>
        </a>

        <a href="target-product-line.php" class="service-card service-card--blue">
          <div class="service-card-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg></div>
          <div class="service-card-body"><h3>TARGET Product Line</h3><p>Purpose-built sentinel appliance providing real-time attack intelligence and multi-threat reporting.</p></div>
        </a>

      </div>
    </div>
  </section>

  <!-- Why High Tide -->
  <section class="section why-section">
    <div class="container">
      <div class="section-header">
        <h2>Why High Tide?</h2>
        <p>Built on the principles of Honesty and Integrity, Respect for the Individual and Responsiveness to Customer Needs.</p>
      </div>

      <div class="stats-grid">
        <div class="stat-item">
          <div class="stat-number">20+</div>
          <div class="stat-label">Years of Service</div>
          <div class="stat-desc">Serving clients since 2006</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">1,000+</div>
          <div class="stat-label">Professionals</div>
          <div class="stat-desc">In our talent network</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">6+</div>
          <div class="stat-label">States</div>
          <div class="stat-desc">Active client presence</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">100%</div>
          <div class="stat-label">Commitment</div>
          <div class="stat-desc">To client satisfaction</div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-strip">
    <div class="container">
      <h2>Ready to Secure Your Business?</h2>
      <p>Let High Tide Technology protect and empower your organization with industry-leading IT and cybersecurity solutions.</p>
      <a href="contact.php" class="btn btn-primary btn-lg">Contact Us</a>
    </div>
  </section>

  <!-- Footer -->

  <?php include 'includes/footer.php'; ?>