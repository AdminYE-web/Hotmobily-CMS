(function () {
    'use strict';

    var root = document.getElementById('admin-order-extras');
    if (!root) return;

    var servicesList = document.getElementById('servicesList') || document.getElementById('admin-services-list');
    var partsList = document.getElementById('partsList') || document.getElementById('admin-parts-list');
    var totalInput = document.getElementById('admin-extras-total');
    var totalDisplay = document.getElementById('admin-extras-total-display');
    var form = root.closest('form');

    function parseMoney(value) {
        var raw = String(value == null ? '' : value).replace(/[^0-9.-]/g, '');
        if (!raw) return 0;
        var number = Number(raw);
        return isFinite(number) ? Math.max(0, number) : 0;
    }

    function formatMoney(value) {
        return Math.round(value).toLocaleString('ja-JP');
    }

    function normalize(value) {
        return String(value || '').trim().toLocaleLowerCase();
    }

    function orderQuantity() {
        var selectors = [
            'input[name="numberOf"]',
            '#no_of_order',
            'input[name="qty"]',
            'input[name="qty_input"]',
            'input[name="num_colors2"]',
            '#qty_input',
            '#num_colors2_hidden'
        ];
        for (var i = 0; i < selectors.length; i++) {
            var input = document.querySelector(selectors[i]);
            if (!input) continue;
            var value = parseInt(String(input.value || '').replace(/,/g, ''), 10);
            if (isFinite(value) && value > 0) return value;
        }
        return 1;
    }

    function calculateTotal() {
        var total = 0;
        var seenServices = {};
        if (servicesList) {
            servicesList.querySelectorAll('.admin-service-row, .service-row').forEach(function (row) {
                var nameInput = row.querySelector('.admin-service-name, .service-input');
                var feeInput = row.querySelector('.admin-service-fee, .fee-input');
                var name = normalize(nameInput && nameInput.value);
                var fee = parseMoney(feeInput && feeInput.value);
                if (!name || seenServices[name]) return;
                seenServices[name] = true;
                total += fee;
            });
        }
        if (partsList) {
            var qty = orderQuantity();
            partsList.querySelectorAll('.admin-part-row, .part-row').forEach(function (row) {
                var nameInput = row.querySelector('.admin-part-name, .part-name-select');
                var feeInput = row.querySelector('.admin-part-fee, .part-fee-input');
                var name = normalize(nameInput && nameInput.value);
                var fee = parseMoney(feeInput && feeInput.value);
                if (!name) return;
                total += fee * qty;
            });
        }
        return Math.round(total);
    }

    function syncTotal() {
        var total = calculateTotal();
        if (totalInput) totalInput.value = String(total);
        if (totalDisplay) totalDisplay.textContent = formatMoney(total);
        return total;
    }

    function clearRow(row) {
        row.querySelectorAll('input').forEach(function (input) {
            input.value = '';
            input.removeAttribute('data-selected');
        });
    }

    function addRow(list, selector) {
        if (!list) return;
        var rows = list.querySelectorAll(selector);
        if (!rows.length || rows.length >= 20) return;
        var clone = rows[rows.length - 1].cloneNode(true);
        clearRow(clone);
        list.appendChild(clone);
        syncTotal();
    }

    function removeRow(list, selector, row) {
        if (!list || !row) return;
        var rows = list.querySelectorAll(selector);
        if (rows.length > 1) row.remove();
        else clearRow(row);
        syncTotal();
    }

    root.addEventListener('click', function (event) {
        var target = event.target.closest ? event.target.closest('button') : null;
        if (!target || !root.contains(target)) return;
        if (target.id === 'adminAddService') {
            addRow(servicesList, '.admin-service-row');
        } else if (target.id === 'adminAddPart') {
            addRow(partsList, '.admin-part-row');
        } else if (target.hasAttribute('data-remove-service')) {
            removeRow(servicesList, '.admin-service-row', target.closest('.admin-service-row'));
        } else if (target.hasAttribute('data-remove-part')) {
            removeRow(partsList, '.admin-part-row', target.closest('.admin-part-row'));
        }
    });

    root.addEventListener('input', function (event) {
        var input = event.target;
        if (input.matches && input.matches('.admin-service-fee, .admin-part-fee')) syncTotal();
        if (input.matches && input.matches('.admin-service-name, .admin-part-name')) syncTotal();
    });

    root.addEventListener('focusin', function (event) {
        var input = event.target;
        if (input.matches && input.matches('.admin-service-fee, .admin-part-fee')) {
            input.value = input.value.replace(/[^0-9.-]/g, '');
        }
    });

    root.addEventListener('focusout', function (event) {
        var input = event.target;
        if (input.matches && input.matches('.admin-service-fee, .admin-part-fee')) {
            if (input.value.trim() !== '') input.value = formatMoney(parseMoney(input.value));
            syncTotal();
        }
    });

    if (form) {
        form.addEventListener('submit', function () {
            syncTotal();
        });
        form.addEventListener('input', function (event) {
            if (event.target.matches && event.target.matches(
                'input[name="numberOf"], #no_of_order, input[name="qty"], input[name="qty_input"], input[name="num_colors2"]'
            )) syncTotal();
        });
        form.addEventListener('change', function (event) {
            if (event.target.matches && event.target.matches(
                'input[name="numberOf"], #no_of_order, input[name="qty"], input[name="qty_input"], input[name="num_colors2"]'
            )) syncTotal();
        });
    }

    syncTotal();
    window.AdminOrderExtras = window.AdminOrderExtras || {};
    window.AdminOrderExtras.calculateTotal = calculateTotal;
})();
