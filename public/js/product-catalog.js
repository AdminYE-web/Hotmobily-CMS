(() => {
    function init() {
        document.querySelectorAll('[data-product-catalog]').forEach(root => {
            if (root.dataset.pcBound) return;
            root.dataset.pcBound = '1';
            const cards = [...root.querySelectorAll('[data-pc-categories]')].map(card => ({card, categories:JSON.parse(card.dataset.pcCategories)}));
            const buttons = [...root.querySelectorAll('[data-pc-filter]')];
            const grid = root.querySelector('.pc-grid');
            const resetWrap = root.querySelector('[data-pc-reset-wrap]');
            const activeName = root.querySelector('[data-pc-active-name]');
            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
            let currentCategory = root.dataset.pcDefault || '';
            let isAnimating = false;
            let pendingCategory = null;
            const updateControls = selected => {
                buttons.forEach(button => button.setAttribute('aria-pressed', String(button.dataset.pcFilter === selected)));
                if (resetWrap) resetWrap.hidden = selected === '';
                if (activeName) activeName.textContent = buttons.find(button => button.dataset.pcFilter === selected)?.textContent || '';
            };
            const update = selected => {
                let count = 0;
                cards.forEach(({card,categories}) => {
                    card.hidden = selected !== '' && !categories.includes(selected);
                    if (!card.hidden) count++;
                });
                updateControls(selected);
                root.querySelector('[data-pc-empty]').hidden = count !== 0;
            };
            const applyFilter = selected => {
                // Keep the last request when users switch categories during a transition.
                if (isAnimating) { pendingCategory = selected; return; }
                if (selected === currentCategory) return;
                currentCategory = selected;
                if (reducedMotion.matches) { update(selected); return; }

                isAnimating = true;
                root.classList.add('is-filtering');
                const firstPositions = new Map();
                const hide = [], show = [], stay = [];
                cards.forEach(({card,categories}) => {
                    const visible = selected === '' || categories.includes(selected);
                    if (!card.hidden) firstPositions.set(card, card.getBoundingClientRect());
                    if (!card.hidden && !visible) hide.push(card);
                    else if (card.hidden && visible) show.push(card);
                    else if (visible) stay.push(card);
                });
                updateControls(selected);

                // Match the original: fade/shrink out, reflow, slide, then stagger in.
                hide.forEach(card => {
                    card.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.92)';
                    card.inert = true;
                });
                setTimeout(() => {
                    hide.forEach(card => {
                        card.hidden = true;
                        card.style.transition = '';
                        card.style.opacity = '';
                        card.style.transform = '';
                    });
                    show.forEach(card => {
                        card.hidden = false;
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.92)';
                    });
                    root.querySelector('[data-pc-empty]').hidden = stay.length + show.length !== 0;
                    stay.forEach(card => {
                        const first = firstPositions.get(card), last = card.getBoundingClientRect();
                        const x = first.left - last.left, y = first.top - last.top;
                        if (x || y) {
                            card.style.transition = 'none';
                            card.style.transform = `translate(${x}px, ${y}px)`;
                        }
                    });
                    // Commit the starting positions before playing the transitions.
                    void grid.offsetHeight;
                    requestAnimationFrame(() => {
                        stay.forEach(card => {
                            card.style.transition = 'transform 0.35s cubic-bezier(0.2, 0.8, 0.2, 1)';
                            card.style.transform = '';
                        });
                        show.forEach((card,index) => {
                            card.style.transition = 'opacity 0.28s cubic-bezier(0.2, 0.8, 0.2, 1), transform 0.28s cubic-bezier(0.2, 0.8, 0.2, 1)';
                            card.style.transitionDelay = `${index * 25}ms`;
                            card.style.opacity = '1';
                            card.style.transform = 'scale(1)';
                        });
                        setTimeout(() => {
                            cards.forEach(({card}) => {
                                card.style.transition = '';
                                card.style.transitionDelay = '';
                                card.style.transform = '';
                                card.style.opacity = '';
                                card.inert = false;
                            });
                            root.classList.remove('is-filtering');
                            isAnimating = false;
                            if (pendingCategory !== null) {
                                const next = pendingCategory;
                                pendingCategory = null;
                                applyFilter(next);
                            }
                        }, 380 + show.length * 25);
                    });
                }, hide.length ? 190 : 0);
            };
            buttons.forEach(button => button.addEventListener('click', () => {
                const selected = button.dataset.pcFilter;
                applyFilter(selected !== '' && selected === (pendingCategory ?? currentCategory) ? '' : selected);
            }));
            root.querySelector('[data-pc-reset]')?.addEventListener('click', () => {
                const activeButton = buttons.find(button => button.dataset.pcFilter === (pendingCategory ?? currentCategory));
                applyFilter('');
                activeButton?.focus({preventScroll:true});
            });
            update(currentCategory);
        });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
})();
