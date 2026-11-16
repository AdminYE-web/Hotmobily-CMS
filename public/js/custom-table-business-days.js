(() => {
    'use strict';
    document.addEventListener('change', event => {
        const toggle = event.target.closest('[data-custom-table-days-toggle]');
        const table = toggle?.closest('[data-custom-table-days]');
        if (!table) return;
        table.querySelectorAll('[data-custom-table-day-count]').forEach(days => { days.hidden = !toggle.checked; });
    });
})();
