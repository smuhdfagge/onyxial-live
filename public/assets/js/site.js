/* Onyx Investment Advisory — site interactions (no dependencies) */
(function () {
    'use strict';

    var doc = document.documentElement;
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ---------- Sticky header shadow + back-to-top ---------- */
    var header = document.querySelector('[data-header]');
    var toTop = document.querySelector('[data-to-top]');
    function onScroll() {
        var y = window.scrollY || window.pageYOffset;
        if (header) header.classList.toggle('is-scrolled', y > 40);
        if (toTop) toTop.classList.toggle('is-visible', y > 600);
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
    if (toTop) toTop.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
    });

    /* ---------- Mobile navigation ---------- */
    var navToggle = document.querySelector('[data-nav-toggle]');
    function closeNav() {
        doc.classList.remove('nav-open');
        document.body.classList.remove('nav-open');
        if (navToggle) {
            navToggle.setAttribute('aria-expanded', 'false');
            navToggle.setAttribute('aria-label', 'Open menu');
        }
    }
    if (navToggle) {
        navToggle.addEventListener('click', function () {
            var open = !document.body.classList.contains('nav-open');
            document.body.classList.toggle('nav-open', open);
            navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            navToggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
        });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeNav(); });
        window.addEventListener('resize', function () { if (window.innerWidth > 1040) closeNav(); });
    }

    document.querySelectorAll('[data-drop-toggle]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var item = btn.closest('[data-drop]');
            var open = !item.classList.contains('is-open');
            item.classList.toggle('is-open', open);
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    });

    /* ---------- Reveal on scroll ---------- */
    var revealEls = document.querySelectorAll('[data-reveal], [data-steps]');
    if ('IntersectionObserver' in window && !reduceMotion) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-in');
                    io.unobserve(entry.target);
                }
            });
        }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
        revealEls.forEach(function (el) { io.observe(el); });
    } else {
        revealEls.forEach(function (el) { el.classList.add('is-in'); });
    }

    /* ---------- Animated counters ---------- */
    var counters = document.querySelectorAll('[data-count]');
    function formatNum(n, decimals) {
        return n.toLocaleString('en-NG', { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
    }
    function runCounter(el) {
        var target = parseFloat(el.getAttribute('data-count')) || 0;
        var decimals = (String(target).split('.')[1] || '').length;
        if (reduceMotion) { el.textContent = formatNum(target, decimals); return; }
        var start = null, dur = 1800;
        function step(ts) {
            if (!start) start = ts;
            var p = Math.min((ts - start) / dur, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = formatNum(target * eased, decimals);
            if (p < 1) requestAnimationFrame(step);
        }
        el.textContent = formatNum(0, decimals);
        requestAnimationFrame(step);
    }
    if ('IntersectionObserver' in window) {
        var co = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) { runCounter(entry.target); co.unobserve(entry.target); }
            });
        }, { threshold: 0.4 });
        counters.forEach(function (el) { co.observe(el); });
    }

    /* ---------- FAQ accordion ---------- */
    document.querySelectorAll('[data-accordion] .acc__btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var panel = document.getElementById(btn.getAttribute('aria-controls'));
            var open = btn.getAttribute('aria-expanded') === 'true';
            btn.setAttribute('aria-expanded', open ? 'false' : 'true');
            if (panel) panel.hidden = open;
        });
    });

    /* ---------- Lightbox ---------- */
    var groups = {};
    document.querySelectorAll('[data-lightbox]').forEach(function (a) {
        var g = a.getAttribute('data-lightbox');
        (groups[g] = groups[g] || []).push(a);
    });
    if (Object.keys(groups).length) {
        var box = document.createElement('div');
        box.className = 'lightbox';
        box.setAttribute('role', 'dialog');
        box.setAttribute('aria-modal', 'true');
        box.setAttribute('aria-label', 'Image viewer');
        box.innerHTML =
            '<button class="lightbox__btn lightbox__close" type="button" aria-label="Close">' + svg('M18 6 6 18M6 6l12 12') + '</button>' +
            '<button class="lightbox__btn lightbox__prev" type="button" aria-label="Previous image">' + svg('m15 6-6 6 6 6') + '</button>' +
            '<img class="lightbox__img" alt="">' +
            '<button class="lightbox__btn lightbox__next" type="button" aria-label="Next image">' + svg('m9 6 6 6-6 6') + '</button>' +
            '<p class="lightbox__cap"></p>';
        document.body.appendChild(box);
        var img = box.querySelector('.lightbox__img');
        var cap = box.querySelector('.lightbox__cap');
        var current = [], index = 0, lastFocus = null;

        function show(i) {
            index = (i + current.length) % current.length;
            var a = current[index];
            img.src = a.getAttribute('href');
            img.alt = (a.querySelector('img') || {}).alt || '';
            cap.textContent = a.getAttribute('data-caption') || '';
            var multi = current.length > 1;
            box.querySelector('.lightbox__prev').style.display = multi ? '' : 'none';
            box.querySelector('.lightbox__next').style.display = multi ? '' : 'none';
        }
        function open(group, i) {
            lastFocus = document.activeElement;
            current = groups[group];
            show(i);
            box.classList.add('is-open');
            document.body.style.overflow = 'hidden';
            box.querySelector('.lightbox__close').focus();
        }
        function close() {
            box.classList.remove('is-open');
            document.body.style.overflow = '';
            if (lastFocus) lastFocus.focus();
        }
        Object.keys(groups).forEach(function (g) {
            groups[g].forEach(function (a, i) {
                a.addEventListener('click', function (e) { e.preventDefault(); open(g, i); });
            });
        });
        box.querySelector('.lightbox__close').addEventListener('click', close);
        box.querySelector('.lightbox__prev').addEventListener('click', function () { show(index - 1); });
        box.querySelector('.lightbox__next').addEventListener('click', function () { show(index + 1); });
        box.addEventListener('click', function (e) { if (e.target === box) close(); });
        document.addEventListener('keydown', function (e) {
            if (!box.classList.contains('is-open')) return;
            if (e.key === 'Escape') close();
            if (e.key === 'ArrowLeft') show(index - 1);
            if (e.key === 'ArrowRight') show(index + 1);
        });
    }
    function svg(d) {
        return '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="' + d + '"/></svg>';
    }

    /* ---------- Copy link ---------- */
    document.querySelectorAll('[data-copy]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var text = btn.getAttribute('data-copy');
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(function () {
                    btn.setAttribute('aria-label', 'Link copied');
                    btn.style.background = '#042755'; btn.style.color = '#fff';
                    setTimeout(function () { btn.removeAttribute('style'); btn.setAttribute('aria-label', 'Copy link'); }, 1600);
                });
            }
        });
    });

    /* ---------- Form: stop double submits ---------- */
    document.querySelectorAll('[data-form]').forEach(function (form) {
        form.addEventListener('submit', function () {
            var btn = form.querySelector('button[type="submit"]');
            if (btn) { btn.disabled = true; btn.style.opacity = '.7'; btn.firstChild.textContent = 'Sending… '; }
        });
    });
})();
