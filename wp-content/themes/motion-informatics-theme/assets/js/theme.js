/**
 * Motion Informatics — Theme JavaScript
 * Handles: dark mode, accessibility toolbar, mobile menu,
 *          scroll animations, FAQ accordion, forms (AJAX)
 */

(function () {
    'use strict';

    // ── REFERRER TRACKING ─────────────────────────────────────────────────────
    // Records which page the visitor came FROM before they open Contact Us.
    // Stored in sessionStorage and written into the hidden source_page field
    // at form submit time, so Monday CRM receives the true originating page.
    (function () {
        if (document.referrer) {
            try {
                var refHost = new URL(document.referrer).hostname;
                if (refHost === window.location.hostname) {
                    sessionStorage.setItem('mi_source_page', document.referrer);
                }
            } catch (e) {}
        }
        if (!sessionStorage.getItem('mi_source_page')) {
            sessionStorage.setItem('mi_source_page', window.location.href);
        }
    })();


    // ── DARK MODE DISABLED — always light ─────────────────────────────────────

    const html = document.documentElement;
    html.classList.remove('dark');
    localStorage.removeItem('mi-dark-mode');


    // ── ACCESSIBILITY WIDGET — OPEN / CLOSE PANEL ────────────────────────────

    var a11yTrigger = document.getElementById('a11y-trigger');
    var a11yPanel   = document.getElementById('a11y-panel');

    if (a11yTrigger && a11yPanel) {
        a11yTrigger.addEventListener('click', function (e) {
            e.stopPropagation();
            var isOpen = a11yPanel.style.display !== 'none';
            a11yPanel.style.display = isOpen ? 'none' : 'block';
            a11yTrigger.setAttribute('aria-expanded', !isOpen);
            a11yTrigger.style.transform = isOpen ? '' : 'scale(1.1)';
            a11yTrigger.style.boxShadow = isOpen
                ? '0 4px 20px rgba(63,62,111,0.5)'
                : '0 6px 28px rgba(63,62,111,0.7)';
        });

        // Close on outside click
        document.addEventListener('click', function (e) {
            if (!a11yTrigger.contains(e.target) && !a11yPanel.contains(e.target)) {
                a11yPanel.style.display = 'none';
                a11yTrigger.setAttribute('aria-expanded', 'false');
                a11yTrigger.style.transform = '';
            }
        });

        // Close on Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && a11yPanel.style.display !== 'none') {
                a11yPanel.style.display = 'none';
                a11yTrigger.setAttribute('aria-expanded', 'false');
                a11yTrigger.focus();
            }
        });
    }


    // ── ACCESSIBILITY TOOLBAR ─────────────────────────────────────────────────

    const A11Y_KEY    = 'mi-a11y';
    const a11yStates  = JSON.parse(localStorage.getItem(A11Y_KEY) || '{}');
    let   fontSize    = a11yStates.fontSize || 100;

    function saveA11y() {
        localStorage.setItem(A11Y_KEY, JSON.stringify(a11yStates));
    }

    function applyA11yState(key, active) {
        const classMap = {
            contrast:  'a11y-high-contrast',
            grayscale: 'a11y-grayscale',
            dyslexia:  'a11y-dyslexia',
            stopAnim:  'a11y-stop-anim',
        };
        if (classMap[key]) html.classList.toggle(classMap[key], active);
        const btn = document.getElementById('a11y-' + key.replace(/([A-Z])/g, '-$1').toLowerCase());
        if (btn) btn.setAttribute('aria-pressed', active ? 'true' : 'false');
    }

    // Restore saved states
    if (a11yStates.contrast)  applyA11yState('contrast',  true);
    if (a11yStates.grayscale) applyA11yState('grayscale', true);
    if (a11yStates.dyslexia)  applyA11yState('dyslexia',  true);
    if (a11yStates.stopAnim)  applyA11yState('stopAnim',  true);
    if (fontSize !== 100)     html.style.fontSize = fontSize + '%';

    function toggleA11y(key, btnId) {
        const btn = document.getElementById(btnId);
        if (!btn) return;
        btn.addEventListener('click', function () {
            a11yStates[key] = !a11yStates[key];
            applyA11yState(key, a11yStates[key]);
            saveA11y();
        });
    }

    toggleA11y('contrast',  'a11y-contrast');
    toggleA11y('grayscale', 'a11y-grayscale');
    toggleA11y('dyslexia',  'a11y-dyslexia');
    toggleA11y('stopAnim',  'a11y-stop-anim');

    // Font size controls
    const FONT_MIN = 80, FONT_MAX = 140, FONT_STEP = 10;

    function setFontSize(size) {
        fontSize = Math.min(FONT_MAX, Math.max(FONT_MIN, size));
        html.style.fontSize = fontSize + '%';
        a11yStates.fontSize = fontSize;
        saveA11y();
    }

    var elFontDec  = document.getElementById('a11y-font-decrease');
    var elFontInc  = document.getElementById('a11y-font-increase');
    var elFontRst  = document.getElementById('a11y-font-reset');

    if (elFontDec) elFontDec.addEventListener('click', function () { setFontSize(fontSize - FONT_STEP); });
    if (elFontInc) elFontInc.addEventListener('click', function () { setFontSize(fontSize + FONT_STEP); });
    if (elFontRst) elFontRst.addEventListener('click', function () { setFontSize(100); });

    // Reset all
    var elReset = document.getElementById('a11y-reset');
    if (elReset) {
        elReset.addEventListener('click', function () {
            Object.keys(a11yStates).forEach(function (k) { delete a11yStates[k]; });
            ['a11y-high-contrast','a11y-grayscale','a11y-dyslexia','a11y-stop-anim'].forEach(function (cls) {
                html.classList.remove(cls);
            });
            html.style.fontSize = '';
            fontSize = 100;
            ['a11y-contrast','a11y-grayscale','a11y-dyslexia','a11y-stop-anim'].forEach(function (id) {
                var b = document.getElementById(id);
                if (b) b.setAttribute('aria-pressed', 'false');
            });
            localStorage.removeItem(A11Y_KEY);
        });
    }


    // ── MOBILE MENU ────────────────────────────────────────────────────────────

    const menuBtn    = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', function () {
            const isExpanded = menuBtn.getAttribute('aria-expanded') === 'true';
            menuBtn.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.classList.toggle('hidden', isExpanded);
            mobileMenu.classList.toggle('is-open', !isExpanded);
            if (!isExpanded) {
                const firstLink = mobileMenu.querySelector('a, button');
                if (firstLink) firstLink.focus();
            }
        });

        document.addEventListener('click', function (e) {
            if (!menuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                menuBtn.setAttribute('aria-expanded', 'false');
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('is-open');
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && menuBtn.getAttribute('aria-expanded') === 'true') {
                menuBtn.setAttribute('aria-expanded', 'false');
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('is-open');
                menuBtn.focus();
            }
        });
    }


    // ── SCROLL ENTRANCE ANIMATIONS ────────────────────────────────────────────

    if ('IntersectionObserver' in window) {
        const animObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    animObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        document.querySelectorAll('[data-animate]').forEach(function (el) {
            animObserver.observe(el);
        });
    } else {
        // Fallback: show all immediately
        document.querySelectorAll('[data-animate]').forEach(function (el) {
            el.classList.add('is-visible');
        });
    }


    // ── HERO PARALLAX ─────────────────────────────────────────────────────────

    const heroParallax = document.querySelector('.hero-parallax');
    if (heroParallax && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        window.addEventListener('scroll', function () {
            const scrolled = window.pageYOffset;
            heroParallax.style.transform = 'scale(1.05) translateY(' + (scrolled * 0.25) + 'px)';
        }, { passive: true });
    }


    // ── FAQ ACCORDION ──────────────────────────────────────────────────────────

    function initAccordion(triggerSelector) {
        const triggers = document.querySelectorAll(triggerSelector);
        triggers.forEach(function (trigger) {
            trigger.addEventListener('click', function () {
                const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
                const panel      = document.getElementById(trigger.getAttribute('aria-controls'));
                const icon       = trigger.querySelector('.material-symbols-outlined');

                triggers.forEach(function (t) {
                    const p  = document.getElementById(t.getAttribute('aria-controls'));
                    const ic = t.querySelector('.material-symbols-outlined');
                    t.setAttribute('aria-expanded', 'false');
                    if (p)  p.classList.add('hidden');
                    if (ic) ic.classList.remove('rotate-180');
                });

                if (!isExpanded) {
                    trigger.setAttribute('aria-expanded', 'true');
                    if (panel) panel.classList.remove('hidden');
                    if (icon)  icon.classList.add('rotate-180');
                }
            });

            trigger.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    trigger.click();
                }
            });
        });
    }

    initAccordion('.faq-trigger');
    initAccordion('.spec-trigger');


    // ── SMOOTH SCROLL ─────────────────────────────────────────────────────────

    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                if (!target.hasAttribute('tabindex')) target.setAttribute('tabindex', '-1');
                target.focus({ preventScroll: true });
            }
        });
    });


    // ── CONTACT FORM — dynamic type switching ────────────────────────────────

    const contactForm = document.getElementById('mi-contact-form');
    if (contactForm) {
        const sectionPatient = document.getElementById('mi-section-patient');
        const sectionPro     = document.getElementById('mi-section-pro');
        const hiddenType     = document.getElementById('mi_hidden_user_type');

        function miSwitchType(type, keepStatus) {
            const isPat = type === 'patient';
            sectionPatient.classList.toggle('hidden', !isPat);
            sectionPro.classList.toggle('hidden', isPat);
            sectionPatient.querySelectorAll('input,textarea,select').forEach(function(el){ el.disabled = !isPat; });
            sectionPro.querySelectorAll('input,textarea,select').forEach(function(el){ el.disabled = isPat; });
            if (hiddenType) hiddenType.value = type;

            // Clear any leftover status message from a previous tab/submission
            // (skipped when called right after a successful submit, so the
            // success message stays visible instead of being wiped instantly)
            if (!keepStatus) {
                var statusEl = document.getElementById('contact-form-status');
                if (statusEl) {
                    statusEl.classList.add('hidden');
                    statusEl.textContent = '';
                }
            }
            // Clear leftover red-border invalid states from a previous failed validation
            contactForm.querySelectorAll('[aria-invalid="true"]').forEach(function(el){
                el.removeAttribute('aria-invalid');
                el.classList.remove('border-red-500');
            });

            // Update switcher button styles
            document.querySelectorAll('.mi-type-btn').forEach(function(btn){
                const active = btn.dataset.type === type;
                btn.classList.toggle('bg-white', active);
                btn.classList.toggle('dark:bg-slate-700', active);
                btn.classList.toggle('shadow-sm', active);
                btn.classList.toggle('!text-[#3f3e6f]', active);
                btn.classList.toggle('text-slate-500', !active);
            });
        }

        document.querySelectorAll('.mi-type-btn').forEach(function(btn) {
            btn.addEventListener('click', function() { miSwitchType(this.dataset.type); });
        });

        // Init — patient is default
        miSwitchType('patient');

        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const statusEl  = document.getElementById('contact-form-status');
            const submitBtn = contactForm.querySelector('[type="submit"]');

            // Auto-add https:// to the company URL if the user forgot it
            // (avoids a confusing silent failure on type="url" validation)
            var companyUrlField = contactForm.querySelector('#company_url');
            if (companyUrlField && companyUrlField.value && !/^https?:\/\//i.test(companyUrlField.value)) {
                companyUrlField.value = 'https://' + companyUrlField.value.trim();
            }

            if (!validateForm(contactForm)) {
                var badField = contactForm.dataset.firstInvalidLabel;
                showFormStatus(statusEl, false, badField
                    ? 'Please check the "' + badField + '" field — it\'s missing or invalid.'
                    : 'Please fill in all required fields.');
                return;
            }
            submitBtn.disabled = true;
            submitBtn.textContent = 'Sending...';

            // Fill source_page with the page the user navigated FROM
            var srcField = contactForm.querySelector('[name="source_page"]');
            if (srcField) srcField.value = sessionStorage.getItem('mi_source_page') || document.referrer || window.location.href;

            const formData = new FormData(contactForm);
            formData.append('action', 'mi_contact_form');
            formData.append('nonce', (typeof MI !== 'undefined') ? MI.nonce : '');

            var siteKey = (typeof MI !== 'undefined' && MI.recaptchaSiteKey) ? MI.recaptchaSiteKey : '';

            var doSubmit = function (token) {
                if (token) formData.set('g-recaptcha-response', token);

                fetch((typeof MI !== 'undefined') ? MI.ajaxUrl : '/wp-admin/admin-ajax.php', {
                    method: 'POST', body: formData, credentials: 'same-origin',
                })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    showFormStatus(statusEl, data.success, data.data ? data.data.message : '');
                    if (data.success) {
                        contactForm.reset();
                        miSwitchType('patient', true);
                    }
                })
                .catch(function () {
                    showFormStatus(statusEl, false, 'Something went wrong. Please try again.');
                })
                .finally(function () {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Send Inquiry <span class="material-symbols-outlined" aria-hidden="true">send</span>';
                });
            };

            if (siteKey && typeof grecaptcha !== 'undefined') {
                grecaptcha.ready(function () {
                    grecaptcha.execute(siteKey, { action: 'contact' }).then(doSubmit);
                });
            } else {
                doSubmit('');
            }
        });
    }


    // ── DISTRIBUTOR FORM (AJAX) ───────────────────────────────────────────────

    const distForm = document.getElementById('mi-distributor-form');
    if (distForm) {
        distForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const statusEl  = document.getElementById('dist-form-status');
            const submitBtn = distForm.querySelector('[type="submit"]');
            if (!validateForm(distForm)) return;
            submitBtn.disabled = true;

            // Fill source_page with the page the user navigated FROM
            var srcFieldDist = distForm.querySelector('[name="source_page"]');
            if (srcFieldDist) srcFieldDist.value = sessionStorage.getItem('mi_source_page') || document.referrer || window.location.href;

            const formData = new FormData(distForm);
            // Route through the same Contact handler so payload + webhook are identical.
            formData.append('action', 'mi_contact_form');
            formData.append('nonce', (typeof MI !== 'undefined') ? MI.nonce : '');

            var siteKeyDist = (typeof MI !== 'undefined' && MI.recaptchaSiteKey) ? MI.recaptchaSiteKey : '';

            var doDistSubmit = function (token) {
                if (token) formData.set('g-recaptcha-response', token);

                fetch((typeof MI !== 'undefined') ? MI.ajaxUrl : '/wp-admin/admin-ajax.php', {
                    method: 'POST', body: formData, credentials: 'same-origin',
                })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    showFormStatus(statusEl, data.success, data.data ? data.data.message : '');
                    if (data.success) distForm.reset();
                })
                .catch(function () {
                    showFormStatus(statusEl, false, 'Something went wrong. Please try again.');
                })
                .finally(function () { submitBtn.disabled = false; });
            };

            if (siteKeyDist && typeof grecaptcha !== 'undefined') {
                grecaptcha.ready(function () {
                    grecaptcha.execute(siteKeyDist, { action: 'distributor' }).then(doDistSubmit);
                });
            } else {
                doDistSubmit('');
            }
        });
    }


    // ── NEWSLETTER FORM ───────────────────────────────────────────────────────

    const newsletterForm = document.getElementById('footer-newsletter');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const emailInput = newsletterForm.querySelector('input[type="email"]');
            if (!emailInput || !emailInput.validity.valid) {
                emailInput.setAttribute('aria-invalid', 'true');
                emailInput.focus();
                return;
            }
            emailInput.value = '';
            emailInput.setAttribute('placeholder', 'Thank you for subscribing!');
            setTimeout(function () { emailInput.setAttribute('placeholder', 'Email address'); }, 3000);
        });
    }


    // ── NAV ACTIVE STATE ─────────────────────────────────────────────────────

    (function highlightNav() {
        const currentPath = window.location.pathname;
        document.querySelectorAll('nav a[href]').forEach(function (link) {
            try {
                const linkPath = new URL(link.href).pathname;
                if (currentPath === linkPath || (linkPath !== '/' && currentPath.startsWith(linkPath))) {
                    link.classList.add('text-primary', 'dark:text-accent-teal');
                    link.setAttribute('aria-current', 'page');
                }
            } catch (e) { /* skip */ }
        });
    })();


    // ── HELPERS ───────────────────────────────────────────────────────────────

    function validateForm(form) {
        const requiredFields = form.querySelectorAll('[required]');
        let valid = true;
        let firstInvalidLabel = '';
        requiredFields.forEach(function (field) {
            if (field.disabled) return; // skip fields in the currently hidden section
            if (!field.validity.valid) {
                field.setAttribute('aria-invalid', 'true');
                field.classList.add('border-red-500');
                if (valid) {
                    field.focus();
                    var lbl = form.querySelector('label[for="' + field.id + '"]');
                    firstInvalidLabel = lbl ? lbl.textContent.replace('*', '').trim() : (field.name || field.id);
                }
                valid = false;
            } else {
                field.removeAttribute('aria-invalid');
                field.classList.remove('border-red-500');
            }
        });
        form.dataset.firstInvalidLabel = firstInvalidLabel;
        return valid;
    }

    function showFormStatus(el, success, message) {
        if (!el) return;
        el.className = '';
        el.classList.add(
            'p-4', 'rounded-lg', 'text-sm', 'font-medium',
            success ? 'bg-green-50' : 'bg-red-50',
            success ? 'text-green-700' : 'text-red-700'
        );
        el.textContent = message;
        el.classList.remove('hidden');
        el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

})();
