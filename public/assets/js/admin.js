/* Onyx admin dashboard interactions */
(function () {
    'use strict';

    /* Sidebar on small screens */
    var shell = document.querySelector('[data-shell]');
    var toggle = document.querySelector('[data-side-toggle]');
    var scrim = document.querySelector('[data-scrim]');
    if (toggle && shell) {
        toggle.addEventListener('click', function () { shell.classList.toggle('side-open'); });
        if (scrim) scrim.addEventListener('click', function () { shell.classList.remove('side-open'); });
    }

    /* User dropdown */
    document.querySelectorAll('[data-dropdown]').forEach(function (dd) {
        var btn = dd.querySelector('[data-dropdown-toggle]');
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var open = dd.classList.toggle('is-open');
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        document.addEventListener('click', function () { dd.classList.remove('is-open'); btn.setAttribute('aria-expanded', 'false'); });
    });

    /* Confirm before deleting */
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!window.confirm(form.getAttribute('data-confirm'))) e.preventDefault();
        });
    });

    /* Hide success message after a few seconds */
    var flash = document.querySelector('[data-flash]');
    if (flash) setTimeout(function () { flash.style.transition = 'opacity .4s'; flash.style.opacity = '0'; setTimeout(function () { flash.remove(); }, 400); }, 4000);

    /* Rich text editors (Quill) */
    function initRich() {
        if (!window.Quill) return;
        document.querySelectorAll('[data-rich]').forEach(function (wrap) {
            var el = wrap.querySelector('[data-rich-editor]');
            var input = wrap.querySelector('[data-rich-input]');
            var quill = new Quill(el, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ header: [2, 3, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['link', 'blockquote'],
                        ['clean']
                    ]
                }
            });
            var sync = function () {
                var html = quill.root.innerHTML;
                input.value = (html === '<p><br></p>') ? '' : html;
            };
            quill.on('text-change', sync);
            var form = wrap.closest('form');
            if (form) form.addEventListener('submit', sync);
        });
    }
    if (document.readyState === 'complete') initRich(); else window.addEventListener('load', initRich);

    /* Image preview before upload */
    document.querySelectorAll('[data-upload]').forEach(function (wrap) {
        var input = wrap.querySelector('[data-upload-input]');
        var preview = wrap.querySelector('[data-upload-preview]');
        input.addEventListener('change', function () {
            var file = input.files && input.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function (e) {
                preview.classList.remove('is-empty');
                preview.innerHTML = '<img src="' + e.target.result + '" alt="">';
            };
            reader.readAsDataURL(file);
        });
    });

    /* Slug from title (new items only) */
    document.querySelectorAll('[data-slug-from]').forEach(function (slug) {
        var src = document.getElementById(slug.getAttribute('data-slug-from'));
        if (!src || slug.hasAttribute('data-slug-locked')) return;
        var touched = slug.value !== '';
        slug.addEventListener('input', function () { touched = true; });
        src.addEventListener('input', function () {
            if (touched) return;
            slug.value = src.value.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '')
                .replace(/&/g, ' and ').replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '').slice(0, 120);
        });
    });

    /* Character counters for SEO fields */
    document.querySelectorAll('[data-counter-for]').forEach(function (counter) {
        var input = document.getElementById(counter.getAttribute('data-counter-for'));
        var max = parseInt(counter.getAttribute('data-max'), 10);
        if (!input) return;
        var update = function () {
            var n = input.value.length;
            counter.textContent = n + ' / ' + max;
            counter.classList.toggle('is-over', n > max);
        };
        input.addEventListener('input', update);
        update();
    });

    /* Live search-result preview */
    var serpTitle = document.querySelector('[data-serp-title]');
    var serpDesc = document.querySelector('[data-serp-desc]');
    var titleIn = document.querySelector('[data-serp-title-input]');
    var descIn = document.querySelector('[data-serp-desc-input]');
    var mainTitle = document.getElementById('f-title') || document.getElementById('f-name');
    function updateSerp() {
        if (serpTitle) serpTitle.textContent = (titleIn && titleIn.value) || (mainTitle && mainTitle.value) || 'Page title';
        if (serpDesc && descIn && descIn.value) serpDesc.textContent = descIn.value;
    }
    [titleIn, descIn, mainTitle].forEach(function (el) { if (el) el.addEventListener('input', updateSerp); });

    /* Label / value rows */
    document.querySelectorAll('[data-facts]').forEach(function (box) {
        box.addEventListener('click', function (e) {
            var add = e.target.closest('[data-facts-add]');
            var remove = e.target.closest('[data-facts-remove]');
            if (add) {
                var rows = box.querySelectorAll('[data-facts-row]');
                var clone = rows[rows.length - 1].cloneNode(true);
                clone.querySelectorAll('input').forEach(function (i) { i.value = ''; });
                box.insertBefore(clone, add);
                clone.querySelector('input').focus();
            }
            if (remove) {
                var row = remove.closest('[data-facts-row]');
                if (box.querySelectorAll('[data-facts-row]').length > 1) row.remove();
                else row.querySelectorAll('input').forEach(function (i) { i.value = ''; });
            }
        });
    });

    /* Settings tabs (remembers the tab in the URL) */
    var tabsForm = document.querySelector('[data-tabs]');
    if (tabsForm) {
        var tabs = tabsForm.querySelectorAll('[data-tab]');
        var panels = tabsForm.querySelectorAll('[data-panel]');
        var tabInput = tabsForm.querySelector('[data-tab-input]');
        var show = function (key) {
            var found = false;
            tabs.forEach(function (t) { var on = t.getAttribute('data-tab') === key; t.setAttribute('aria-selected', on ? 'true' : 'false'); found = found || on; });
            if (!found) return;
            panels.forEach(function (p) { p.hidden = p.getAttribute('data-panel') !== key; });
            if (tabInput) tabInput.value = key;
            history.replaceState(null, '', '#' + key);
        };
        tabs.forEach(function (t) { t.addEventListener('click', function () { show(t.getAttribute('data-tab')); }); });
        if (location.hash) show(location.hash.slice(1));
    }

    /* Drag-and-drop photo upload */
    document.querySelectorAll('[data-dropzone]').forEach(function (zone) {
        var input = zone.querySelector('[data-dropzone-input]');
        ['dragenter', 'dragover'].forEach(function (ev) { zone.addEventListener(ev, function (e) { e.preventDefault(); zone.classList.add('is-over'); }); });
        ['dragleave', 'drop'].forEach(function (ev) { zone.addEventListener(ev, function (e) { e.preventDefault(); zone.classList.remove('is-over'); }); });
        zone.addEventListener('drop', function (e) {
            if (e.dataTransfer && e.dataTransfer.files.length) { input.files = e.dataTransfer.files; zone.submit(); }
        });
    });

    /* Warn about unsaved changes */
    document.querySelectorAll('[data-edit-form]').forEach(function (form) {
        var dirty = false;
        form.addEventListener('input', function () { dirty = true; });
        form.addEventListener('change', function () { dirty = true; });
        form.addEventListener('submit', function () { dirty = false; });
        window.addEventListener('beforeunload', function (e) { if (dirty) { e.preventDefault(); e.returnValue = ''; } });
    });
})();
