(() => {
    function init() {
        document.querySelectorAll('[data-attachment-gallery]').forEach(root => {
            const grid = root.querySelector('[data-ag-grid]');
            if (!grid || root.dataset.agBound) return;
            root.dataset.agBound = '1';
            const toggle = root.querySelector('[data-ag-toggle]');
            const wrap = root.querySelector('[data-ag-toggle-wrap]');
            const viewport = root.querySelector('[data-ag-viewport]');
            let expanded = false;
            const update = () => {
                const overflow = root.dataset.agCollapsible === '1' && grid.scrollHeight > Number(root.dataset.agHeight) + 1;
                root.classList.toggle('is-collapsed', overflow && !expanded);
                wrap.hidden = !overflow;
                toggle.setAttribute('aria-expanded', String(!overflow || expanded));
                toggle.textContent = expanded ? toggle.dataset.agLess : toggle.dataset.agMore;
                // Clipped cards must not receive keyboard focus while collapsed.
                const boundary = viewport.getBoundingClientRect().top + Number(root.dataset.agHeight);
                grid.querySelectorAll('.ag-item').forEach(item => {
                    const clipped = overflow && !expanded && item.getBoundingClientRect().bottom > boundary;
                    item.querySelectorAll('a, button').forEach(control => {
                        if (clipped) control.setAttribute('tabindex', '-1');
                        else control.removeAttribute('tabindex');
                    });
                });
            };
            toggle.addEventListener('click', () => {
                const top = root.getBoundingClientRect().top;
                expanded = !expanded;
                update();
                if (!expanded && top < 0) root.scrollIntoView({block:'start'});
            });
            root.querySelectorAll('[data-ag-zoom]').forEach(button => button.addEventListener('click', () => button.closest('[data-ag-item]').querySelector('[data-store-image-modal-trigger]').click()));
            grid.querySelectorAll('img').forEach(img => {
                const failed = () => { img.hidden = true; img.nextElementSibling.hidden = false; };
                img.addEventListener('error', failed);
                if (img.complete && !img.naturalWidth) failed();
            });
            if (window.ResizeObserver) new ResizeObserver(update).observe(grid);
            else window.addEventListener('resize', update);
            update();
        });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
})();
