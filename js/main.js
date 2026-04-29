(function () {
  'use strict';

  /* ---------- Mobile Nav Toggle ---------- */
  var toggle = document.querySelector('.nav-toggle');
  var navLinks = document.querySelector('.nav-links');

  if (toggle && navLinks) {
    toggle.addEventListener('click', function () {
      var isOpen = toggle.classList.toggle('open');
      navLinks.classList.toggle('open');
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });

    // Close on link click (mobile)
    navLinks.querySelectorAll('a:not(.nav-dropdown > a)').forEach(function (link) {
      link.addEventListener('click', function () {
        if (window.innerWidth <= 768) {
          toggle.classList.remove('open');
          navLinks.classList.remove('open');
          toggle.setAttribute('aria-expanded', 'false');
          document.body.style.overflow = '';
        }
      });
    });

    // Reset on resize past breakpoint
    window.addEventListener('resize', function () {
      if (window.innerWidth > 768) {
        toggle.classList.remove('open');
        navLinks.classList.remove('open');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
        document.querySelectorAll('.nav-dropdown.open').forEach(function (d) {
          d.classList.remove('open');
        });
      }
    });
  }

  /* ---------- Mobile Dropdown Toggle ---------- */
  document.querySelectorAll('.nav-dropdown > a').forEach(function (trigger) {
    trigger.addEventListener('click', function (e) {
      if (window.innerWidth <= 768) {
        e.preventDefault();
        var parent = this.parentElement;
        // Close siblings
        document.querySelectorAll('.nav-dropdown.open').forEach(function (d) {
          if (d !== parent) d.classList.remove('open');
        });
        parent.classList.toggle('open');
      }
    });
  });

  /* ---------- Header Scroll ---------- */
  var header = document.querySelector('.site-header');
  if (header) {
    window.addEventListener('scroll', function () {
      if (window.pageYOffset > 40) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    }, { passive: true });
  }

  /* ---------- Smooth Scroll ---------- */
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      var id = this.getAttribute('href');
      if (id === '#') { e.preventDefault(); return; }
      var target = document.querySelector(id);
      if (target) {
        e.preventDefault();
        var top = target.getBoundingClientRect().top + window.pageYOffset - 80;
        window.scrollTo({ top: top, behavior: 'smooth' });
      }
    });
  });

  /* ---------- Contact Form ---------- */
  var form = document.getElementById('contact-form');
  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var ok = true;

      form.querySelectorAll('.form-group').forEach(function (g) { g.classList.remove('error'); });

      var name = form.querySelector('[name="name"]');
      if (name && name.value.trim().length < 2) { flagError(name, 'Please enter your name.'); ok = false; }

      var email = form.querySelector('[name="email"]');
      if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) { flagError(email, 'Please enter a valid email.'); ok = false; }

      var msg = form.querySelector('[name="message"]');
      if (msg && msg.value.trim().length < 10) { flagError(msg, 'Message must be at least 10 characters.'); ok = false; }

      if (!ok) return;

      var btn = form.querySelector('[type="submit"]');
      var orig = btn.textContent;
      btn.disabled = true;
      btn.textContent = 'Sending\u2026';

      var body = new URLSearchParams(new FormData(form)).toString();
      fetch('/', { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: body })
        .then(function (r) {
          if (r.ok) {
            setStatus('success', 'Message sent! We\u2019ll be in touch soon.');
            form.reset();
          } else {
            setStatus('error', 'Something went wrong. Please try again.');
          }
        })
        .catch(function () { setStatus('error', 'Network error. Please try again later.'); })
        .finally(function () { btn.disabled = false; btn.textContent = orig; });
    });
  }

  function flagError(el, msg) {
    var g = el.closest('.form-group');
    if (g) {
      g.classList.add('error');
      var err = g.querySelector('.form-error');
      if (err) err.textContent = msg;
    }
  }

  function setStatus(type, msg) {
    var el = document.querySelector('.form-status');
    if (el) { el.className = 'form-status ' + type; el.textContent = msg; }
  }

  /* ---------- Trust Logo Carousel ---------- */
  (function () {
    var carousel = document.querySelector('.trust-carousel');
    var track    = document.querySelector('.trust-track');
    if (!carousel || !track) return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    var halfWidth = 0;
    var x         = 0;
    var lastTs    = null;
    var paused    = false;
    var DURATION  = 52000; // ms to scroll one full half-width

    function measure() {
      var items = track.querySelectorAll('a');
      var half  = Math.floor(items.length / 2);
      var w = 0;
      for (var i = 0; i < half; i++) w += items[i].getBoundingClientRect().width;
      return w;
    }

    function tick(ts) {
      if (lastTs !== null && !paused && halfWidth > 0) {
        x -= (halfWidth / DURATION) * (ts - lastTs);
        if (x <= -halfWidth) x += halfWidth;
        track.style.transform = 'translateX(' + x + 'px)';
      }
      lastTs = ts;
      requestAnimationFrame(tick);
    }

    carousel.addEventListener('mouseenter', function () { paused = true; });
    carousel.addEventListener('mouseleave', function () { paused = false; });

    // Touch / swipe support
    var touchStartX = 0;
    var touchStartXPos = 0;
    var resumeTimer = null;

    function scheduleResume() {
      clearTimeout(resumeTimer);
      resumeTimer = setTimeout(function () { paused = false; }, 2000);
    }

    carousel.addEventListener('touchstart', function (e) {
      touchStartX    = e.touches[0].clientX;
      touchStartXPos = x;
      paused = true;
      clearTimeout(resumeTimer);
    }, { passive: true });

    carousel.addEventListener('touchmove', function (e) {
      var delta = e.touches[0].clientX - touchStartX;
      x = touchStartXPos + delta;
      // keep x within bounds so the loop stays seamless
      if (x > 0) x -= halfWidth;
      if (x < -halfWidth) x += halfWidth;
      track.style.transform = 'translateX(' + x + 'px)';
    }, { passive: true });

    carousel.addEventListener('touchend', scheduleResume);
    carousel.addEventListener('touchcancel', scheduleResume);

    function start() {
      halfWidth = measure();
      requestAnimationFrame(tick);
    }

    if (document.readyState === 'complete') { start(); }
    else { window.addEventListener('load', start); }
  })();

  /* ---------- Third-party Widgets ---------- */
  function loadScript(src, attrs) {
    var s = document.createElement('script');
    s.src = src;
    s.async = true;
    if (attrs) Object.keys(attrs).forEach(function(k) { s.setAttribute(k, attrs[k]); });
    document.body.appendChild(s);
  }
  loadScript('https://cdn.trustedsite.com/js/1.js?position=bottomLeft&offset=15', { crossorigin: '' });

  /* ---------- Floating Contact Widget ----------
     Reuses the old chat-widget styles; submits to Netlify Forms as
     form-name="quick-contact". Netlify picks up the form from the
     hidden <form netlify> in index.html at deploy time. */
  (function () {
    var widget = document.createElement('div');
    widget.id = 'chat-widget';
    widget.innerHTML =
      '<div id="chat-panel" role="dialog" aria-label="Send us a message">' +
        '<div class="chat-header">' +
          '<div class="chat-header-info">' +
            '<div class="chat-header-avatar"><svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>' +
            '<div><p class="chat-header-name">High Tide Technology</p><p class="chat-header-status"><span class="chat-status-dot"></span>We\'ll respond as soon as we can.</p></div>' +
          '</div>' +
          '<button class="chat-close" aria-label="Close"><svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>' +
        '</div>' +
        '<div class="chat-body">' +
          '<form id="chat-form" name="quick-contact" method="POST" data-netlify="true" netlify-honeypot="website">' +
            '<input type="hidden" name="form-name" value="quick-contact">' +
            '<div class="sr-only" aria-hidden="true"><label for="chat-website">Website</label><input type="text" id="chat-website" name="website" tabindex="-1" autocomplete="off"></div>' +
            '<div class="chat-field"><label for="chat-name" class="sr-only">Your name</label><input type="text" id="chat-name" name="name" placeholder="Your name" maxlength="100" required></div>' +
            '<div class="chat-field"><label for="chat-email" class="sr-only">Your email</label><input type="email" id="chat-email" name="email" placeholder="Your email" maxlength="254" required></div>' +
            '<div class="chat-field"><label for="chat-message" class="sr-only">Your message</label><textarea id="chat-message" name="message" rows="4" placeholder="How can we help?" maxlength="5000" required></textarea></div>' +
            '<button type="submit" class="chat-submit">Send Message</button>' +
          '</form>' +
        '</div>' +
      '</div>' +
      '<button id="chat-toggle" aria-label="Chat with us" aria-expanded="false">' +
        '<svg aria-hidden="true" class="chat-icon-open" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>' +
        '<svg aria-hidden="true" class="chat-icon-close" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>' +
      '</button>';

    document.body.appendChild(widget);

    var panel     = widget.querySelector('#chat-panel');
    var toggleBtn = widget.querySelector('#chat-toggle');
    var closeBtn  = widget.querySelector('.chat-close');
    var form      = widget.querySelector('#chat-form');
    var chatBody  = widget.querySelector('.chat-body');

    function open()  { panel.classList.add('open');  toggleBtn.setAttribute('aria-expanded', 'true');  toggleBtn.classList.add('open'); }
    function close() { panel.classList.remove('open'); toggleBtn.setAttribute('aria-expanded', 'false'); toggleBtn.classList.remove('open'); }

    toggleBtn.addEventListener('click', function () { panel.classList.contains('open') ? close() : open(); });
    closeBtn.addEventListener('click', close);

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var btn = form.querySelector('.chat-submit');
      btn.disabled = true;
      btn.textContent = 'Sending\u2026';

      var body = new URLSearchParams(new FormData(form)).toString();
      fetch('/', { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: body })
        .then(function (r) {
          if (!r.ok) throw new Error('submit failed');
          chatBody.innerHTML =
            '<div class="chat-success">' +
              '<svg aria-hidden="true" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>' +
              '<p class="chat-success-title">Message sent!</p>' +
              '<p class="chat-success-sub">We\'ll get back to you soon.</p>' +
            '</div>';
        })
        .catch(function () {
          btn.disabled = false;
          btn.textContent = 'Send Message';
          alert('Sorry, something went wrong. Please try again or email us directly.');
        });
    });
  })();

/* ---------- Active Nav Link ---------- */
  var page = location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.nav-links > li > a').forEach(function (a) {
    if (a.getAttribute('href') === page) a.classList.add('active');
  });

  /* ---------- 3D Logo (homepage hero) ---------- */
  (function () {
    var scene = document.getElementById('logo3d-scene');
    if (!scene) return;

    var tiltX = 0, tiltY = 0;
    var targetTiltX = 0, targetTiltY = 0;
    var floatTime = 0;
    var raf;

    function lerp(a, b, t) { return a + (b - a) * t; }

    function render() {
      floatTime += 0.015;
      var floatY    = Math.sin(floatTime) * 10;
      var floatRotX = Math.sin(floatTime * 0.8) * 1.5;
      var floatRotY = Math.cos(floatTime * 0.6) * 1.5;
      tiltX = lerp(tiltX, targetTiltX, 0.07);
      tiltY = lerp(tiltY, targetTiltY, 0.07);
      var totalRotY = floatRotY + tiltX - 10;
      var totalRotX = floatRotX + tiltY + 6;
      scene.style.transform = 'translateY(' + floatY + 'px) rotateX(' + totalRotX + 'deg) rotateY(' + totalRotY + 'deg)';
      raf = requestAnimationFrame(render);
    }

    raf = requestAnimationFrame(render);

    var observer = new IntersectionObserver(function (entries) {
      if (entries[0].isIntersecting) {
        if (!raf) raf = requestAnimationFrame(render);
      } else {
        cancelAnimationFrame(raf);
        raf = null;
      }
    }, { threshold: 0 });
    observer.observe(scene);

    scene.addEventListener('mouseenter', function () { scene.classList.add('hovered'); });
    scene.addEventListener('mousemove', function (e) {
      var rect = scene.getBoundingClientRect();
      var x = (e.clientX - rect.left) / rect.width;
      var y = (e.clientY - rect.top) / rect.height;
      targetTiltX =  (x - 0.5) * 24;
      targetTiltY = -(y - 0.5) * 18;
    });
    scene.addEventListener('mouseleave', function () {
      scene.classList.remove('hovered');
      targetTiltX = 0;
      targetTiltY = 0;
    });
    scene.addEventListener('touchmove', function (e) {
      var touch = e.touches[0];
      var rect = scene.getBoundingClientRect();
      var x = (touch.clientX - rect.left) / rect.width;
      var y = (touch.clientY - rect.top) / rect.height;
      targetTiltX =  (x - 0.5) * 24;
      targetTiltY = -(y - 0.5) * 18;
    }, { passive: true });
    scene.addEventListener('touchend', function () {
      targetTiltX = 0;
      targetTiltY = 0;
    });
  })();

  /* ---------- Cookie Banner ---------- */
  (function () {
    var banner = document.getElementById('cookie-banner');
    if (!banner) return;

    var STORAGE_KEY = 'htt-cookie-consent';
    var stored;
    try { stored = localStorage.getItem(STORAGE_KEY); } catch (e) { stored = null; }
    if (stored === 'accept' || stored === 'decline') return;

    banner.hidden = false;
    requestAnimationFrame(function () {
      requestAnimationFrame(function () { banner.classList.add('visible'); });
    });

    banner.addEventListener('click', function (e) {
      var target = e.target.closest('[data-cookie-action]');
      if (!target) return;
      var choice = target.getAttribute('data-cookie-action');
      try { localStorage.setItem(STORAGE_KEY, choice); } catch (err) {}
      banner.classList.remove('visible');
      setTimeout(function () { banner.hidden = true; }, 500);
    });
  })();

})();
