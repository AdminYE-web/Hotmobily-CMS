(() => {
    'use strict';

    function refresh() {
        const tables = Array.from(document.querySelectorAll('[data-custom-table-days]'), table => ({
            table,
            group: table.dataset.customTableDaysGroup,
            toggle: table.querySelector('[data-custom-table-days-toggle]'),
        }));
        const groupToggles = new Map();

        for (const {group, toggle} of tables) {
            if (group && toggle && !groupToggles.has(group)) groupToggles.set(group, toggle);
        }

        for (const {table, group, toggle} of tables) {
            const controller = groupToggles.get(group) || toggle;
            const showDays = controller?.checked ?? true;
            table.toggleAttribute('data-custom-table-days-hidden', !showDays);
            table.querySelectorAll('[data-custom-table-day-count]').forEach(days => {
                days.hidden = !showDays;
            });

            const controls = toggle?.closest('.store-custom-table-days-controls');
            if (!controls) continue;

            const showSwitch = toggle === controller;
            controls.hidden = !showSwitch;
            const intro = controls.closest('.store-custom-table-intro');
            if (!intro) continue;

            intro.classList.toggle('has-switch', showSwitch);
            intro.hidden = !showSwitch && !intro.classList.contains('has-description');
        }
    }

    window.CustomTableBusinessDays = {refresh};
    document.addEventListener('change', event => {
        if (event.target.matches('[data-custom-table-days-toggle]')) refresh();
    });
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', refresh, {once: true});
    } else {
        refresh();
    }
})();
