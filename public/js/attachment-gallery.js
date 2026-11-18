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
                const mode = root.dataset.agMode || (root.dataset.agCollapsible === '1' ? 'height' : 'all');
                const items = [...grid.querySelectorAll('.ag-item')];
                const limit = Math.max(1, Number(root.dataset.agVisibleItems) || 6);
                const overflow = mode === 'items'
                    ? items.length > limit
                    : mode === 'height' && root.dataset.agCollapsible !== '0' && grid.scrollHeight > Number(root.dataset.agHeight) + 1;
                const collapsed = overflow && !expanded;
                root.classList.toggle('is-collapsed', collapsed && mode === 'height');
                root.classList.toggle('is-items-collapsed', collapsed && mode === 'items');
                wrap.hidden = !overflow || root.dataset.agShowToggle === '0';
                toggle.setAttribute('aria-expanded', String(!collapsed));
                toggle.textContent = expanded ? toggle.dataset.agLess : toggle.dataset.agMore;
                // Items beyond the selected count are removed from layout and keyboard navigation.
                items.forEach((item, index) => {
                    const hiddenByCount = mode === 'items' && collapsed && index >= limit;
                    item.hidden = hiddenByCount;
                    const clippedByHeight = mode === 'height' && collapsed && item.getBoundingClientRect().bottom > viewport.getBoundingClientRect().top + Number(root.dataset.agHeight);
                    item.querySelectorAll('a, button').forEach(control => {
                        if (hiddenByCount || clippedByHeight) control.setAttribute('tabindex', '-1');
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
            if (window.ResizeObserver && (root.dataset.agMode === 'height' || !root.dataset.agMode)) new ResizeObserver(update).observe(grid);
            else window.addEventListener('resize', update);
            update();
        });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
})();
