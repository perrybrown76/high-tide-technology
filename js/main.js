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

  /* ---------- Active Nav Link ---------- */
  var page = location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.nav-links > li > a').forEach(function (a) {
    if (a.getAttribute('href') === page) a.classList.add('active');
  });

})();
