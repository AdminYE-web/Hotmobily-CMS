(() => {
    function init() {
        document.querySelectorAll('[data-price-matrix]').forEach(root => {
            if (root.dataset.pmBound) return;
            root.dataset.pmBound = '1';
            const data = JSON.parse(root.querySelector('[data-pm-data]').textContent);
            root.addEventListener('change', event => {
                if (!event.target.matches('[data-pm-choice]')) return;
                const selections = Object.fromEntries([...root.querySelectorAll('[data-pm-choice]:checked')].map(input => [input.dataset.pmChoice, input.value]));
                const variant = data.variants.find(v => data.option_groups.every(group => v.selections[group.id] === selections[group.id]));
                const rows = variant?.rows || [];
                const body = root.querySelector('tbody');
                body.replaceChildren();
                rows.forEach(row => {
                    const tr = document.createElement('tr');
                    const quantity = document.createElement('th');
                    quantity.scope = 'row';
                    quantity.textContent = row.quantity;
                    tr.append(quantity);
                    data.sizes.forEach(size => {
                        const td = document.createElement('td');
                        td.textContent = row.prices[size.id] ?? '—';
                        tr.append(td);
                    });
                    body.append(tr);
                });
                root.querySelector('[data-pm-table]').hidden = rows.length === 0;
                root.querySelector('[data-pm-empty]').hidden = rows.length > 0;
            });
        });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
})();
