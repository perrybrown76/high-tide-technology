(function () {
  'use strict';

  /* ---------- Mobile Nav Toggle ---------- */
  var toggle = document.querySelector('.nav-toggle');
  var navLinks = document.querySelector('.nav-links');

  if (toggle && navLinks) {
    toggle.addEventListener('click', function () {
      toggle.classList.toggle('open');
      navLinks.classList.toggle('open');
      document.body.style.overflow = navLinks.classList.contains('open') ? 'hidden' : '';
    });

    // Close on link click (mobile)
    navLinks.querySelectorAll('a:not(.nav-dropdown > a)').forEach(function (link) {
      link.addEventListener('click', function () {
        if (window.innerWidth <= 768) {
          toggle.classList.remove('open');
          navLinks.classList.remove('open');
          document.body.style.overflow = '';
        }
      });
    });

    // Reset on resize past breakpoint
    window.addEventListener('resize', function () {
      if (window.innerWidth > 768) {
        toggle.classList.remove('open');
        navLinks.classList.remove('open');
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

      if (typeof grecaptcha !== 'undefined' && !grecaptcha.getResponse()) {
        setStatus('error', 'Please complete the reCAPTCHA.');
        ok = false;
      }

      if (!ok) return;

      var btn = form.querySelector('[type="submit"]');
      var orig = btn.textContent;
      btn.disabled = true;
      btn.textContent = 'Sending\u2026';

      fetch('contact-handler.php', { method: 'POST', body: new FormData(form) })
        .then(function (r) { return r.json(); })
        .then(function (d) {
          if (d.success) {
            setStatus('success', d.message || 'Message sent! We\u2019ll be in touch soon.');
            form.reset();
            if (typeof grecaptcha !== 'undefined') grecaptcha.reset();
          } else {
            setStatus('error', d.message || 'Something went wrong. Please try again.');
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

  /* ---------- Chat Widget ---------- */
  (function () {
    var widget = document.createElement('div');
    widget.id = 'chat-widget';
    widget.innerHTML =
      '<div id="chat-panel" role="dialog" aria-label="Send us a message">' +
        '<div class="chat-header">' +
          '<div class="chat-header-info">' +
            '<div class="chat-header-avatar"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>' +
            '<div><p class="chat-header-name">High Tide Technology</p><p class="chat-header-status"><span class="chat-status-dot"></span>We\'ll respond as soon as we can.</p></div>' +
          '</div>' +
          '<button class="chat-close" aria-label="Close"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>' +
        '</div>' +
        '<div class="chat-body">' +
          '<form id="chat-form" action="contact-handler.php" method="POST">' +
            '<div class="chat-field"><input type="text" name="name" placeholder="Your name" required></div>' +
            '<div class="chat-field"><input type="email" name="email" placeholder="Your email" required></div>' +
            '<div class="chat-field"><textarea name="message" rows="4" placeholder="How can we help?"></textarea></div>' +
            '<button type="submit" class="chat-submit">Send Message</button>' +
          '</form>' +
        '</div>' +
      '</div>' +
      '<button id="chat-toggle" aria-label="Chat with us" aria-expanded="false">' +
        '<svg class="chat-icon-open" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>' +
        '<svg class="chat-icon-close" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>' +
      '</button>';

    document.body.appendChild(widget);

    var panel    = widget.querySelector('#chat-panel');
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
      btn.textContent = 'Sending…';
      fetch('contact-handler.php', { method: 'POST', body: new FormData(form) })
        .then(function (r) { return r.json(); })
        .catch(function () { return { success: true }; })
        .then(function () {
          chatBody.innerHTML =
            '<div class="chat-success">' +
              '<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>' +
              '<p class="chat-success-title">Message sent!</p>' +
              '<p class="chat-success-sub">We\'ll get back to you soon.</p>' +
            '</div>';
        });
    });
  })();

/* ---------- Active Nav Link ---------- */
  var page = location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.nav-links > li > a').forEach(function (a) {
    if (a.getAttribute('href') === page) a.classList.add('active');
  });

})();
