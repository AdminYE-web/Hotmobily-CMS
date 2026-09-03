/*
 * Complete admin calculator for create-order-printedrubberstrap_keyholder.php.
 * Printed rubber strap/keyholder has its own price keys and calculation path.
 */
(function (window, $) {
    'use strict';
    var PRODUCT_PREFIX = 'printedrubberstrap';

    function readPrice(pool, key, qty) {
        if (!pool || !Object.prototype.hasOwnProperty.call(pool, key) || !Array.isArray(pool[key])) return null;
        var tiers = pool[key].slice().sort(function (a, b) { return Number(a.num || 0) - Number(b.num || 0); });
        if (!tiers.length) return null;
        var selected = tiers[0];
        tiers.forEach(function (tier) { if (Number(qty) >= Number(tier.num || 0)) selected = tier; });
        var price = Number(selected.price);
        return isFinite(price) ? Math.floor(price) : null;
    }

    function normalize(value) {
        return String(value || '')
            .replace(/^rubber_/, '')
            .replace(/^anti_stain$/, 'antistain')
            .replace(/^data_trace$/, 'datatrace')
            .replace(/^color_variation$/, 'colorvariation')
            .replace(/^back_printing_/, 'backprinting_');
    }

    function addPrice(code, qty) {
        var pool = window.numUnitAddPrice;
        if (!pool) return 0;
        var requested = String(code || '');
        var normalized = normalize(requested);
        var service = normalized.replace(new RegExp('^' + PRODUCT_PREFIX + '_'), '');
        var candidates = [];
        function add(key) { if (key && candidates.indexOf(key) === -1) candidates.push(key); }
        add(requested); add(normalized); add(PRODUCT_PREFIX + '_' + service); add(service);
        if (service === 'prototype') add('rubber_prototype');
        if (service === 'datatrace') add('rubber_data_trace');
        if (service === 'special_material') add('rubber_special_material');
        for (var i = 0; i < candidates.length; i++) {
            var price = readPrice(pool, candidates[i], qty || 1);
            if (price !== null) return price;
        }
        return 0;
    }

    function unitPrice(itemPcs, qty) {
        var mode = itemPcs === 'スタンダード（スピード7営業日発送）' ? 'speed' : 'standard';
        var keys = [
            PRODUCT_PREFIX + '_' + mode,
            mode === 'speed' ? 'printedrubberstrap_rush' : '',
            PRODUCT_PREFIX + '_standard'
        ];
        for (var i = 0; i < keys.length; i++) {
            var price = readPrice(window.numUnitPrice, keys[i], qty);
            if (price !== null) return price;
        }
        var fallback = mode === 'speed'
            ? [319, 303, 288, 276, 253, 210]
            : [287, 273, 259, 248, 227, 189, 167, 158];
        var thresholds = mode === 'speed' ? [1, 10, 30, 50, 100, 300] : [1, 10, 30, 50, 100, 300, 500, 1000];
        var selected = fallback[0];
        for (var j = 0; j < thresholds.length; j++) {
            if (qty >= thresholds[j]) selected = fallback[j];
        }
        return selected;
    }

    function optionPrice(key, qty) {
        return readPrice(window.numUnitOptionPrice, key, qty)
            || readPrice(window.numUnitOptionPrice, key + '_0', qty)
            || 0;
    }

    function partPrice(part, qty) {
        if (!part) return 0;
        if (typeof window.getPartPriceFromGlobalArrays === 'function') {
            var value = window.getPartPriceFromGlobalArrays(part);
            if (value !== undefined && isFinite(Number(value))) return Number(value);
        }
        return optionPrice(part, qty);
    }

    function paperPrice(paper, qty) {
        var key = paper === 'paper-patternA-1' ? 'mount_printing_single'
            : (paper === 'paper-patternA-2' ? 'mount_printing_both' : 'mount_plain');
        var price = addPrice(key, qty);
        if (price > 0) return price;
        var optionKey = paper === 'paper-patternA-1' ? 'Paper 1 Side'
            : (paper === 'paper-patternA-2' ? 'Paper 2 Side' : 'Paper Temp');
        return optionPrice(optionKey, qty);
    }

    function manualServiceTotal(qty) {
        if (typeof $ !== 'function') return 0;
        var seen = Object.create(null);
        var total = 0;
        $('#servicesList .service-row').each(function () {
            var name = String($(this).find('.service-input').val() || '').trim();
            var fee = parseFloat(String($(this).find('.fee-input').val() || '').replace(/,/g, ''));
            if (!name || !isFinite(fee)) return;
            var key = name.toLowerCase();
            if (seen[key]) return;
            seen[key] = true; total += fee;
        });
        $('#partsList .part-row').each(function () {
            var name = String($(this).find('.part-name-select').val() || '').trim();
            var fee = parseFloat(String($(this).find('.part-fee-input, .fee-input').first().val() || '').replace(/,/g, ''));
            if (!name || !isFinite(fee)) return;
            var key = 'part:' + name.toLowerCase();
            if (seen[key]) return;
            seen[key] = true; total += fee * qty;
        });
        return total;
    }

    function money(value) {
        var number = Number(value);
        return isFinite(number) ? Math.floor(number).toLocaleString('ja-JP') : '0';
    }

    function setValue(selector, value) { if ($(selector).length) $(selector).val(value); }
    function setText(selector, value) { if ($(selector).length) $(selector).text(value == null ? '' : value); }

    function setToInput() {
        var itemPcs = $('input[name="ItemPCS"]:checked').val() || 'スタンダード';
        var shape = $('input[name="ItemShape"]:checked').val() || '';
        var print = $('input[name="ItemPrint"]:checked').val() || '';
        var color = $('input[name="ItemColor"]:checked').val() || '';
        var material = $('input[name="ItemMaterial"]:checked').val() || '特殊素材なし';
        var silk = $('input[name="silk_print"]:checked').val() || '裏面印刷なし';
        var coating = $('input[name="coating"]:checked').val() || '汚れ防止加工なし';
        var part = $('input[name="part"]:checked').val() || '';
        var paperSelect = $('input[name="paper_select"]:checked').val() || 'なし';
        var paper = $('input[name="paper"]:checked').val() || '';
        var prototype = $('input[name="SendPrototype"]:checked').val() || 'なし';
        var qty = parseInt($('#no_of_order').val(), 10) || 0;
        var unit = qty > 0 ? unitPrice(itemPcs, qty) : 0;
        var baseTotal = unit * qty;
        var partTotal = partPrice(part, qty) * qty;
        var paperTotal = paperSelect === 'あり' && paper ? paperPrice(paper, qty) * qty : 0;
        var silkUnit = silk === '裏面印刷あり' || silk === '印刷あり'
            ? addPrice('back_printing_full', qty)
            : 0;
        var silkTotal = silkUnit * qty;
        var coatingTotal = coating === '汚れ防止加工あり' ? addPrice('anti_stain', qty) * qty : 0;
        var materialMap = {
            '特殊素材：蓄光（オレンジ色）': 'phosphorescent_orange',
            '特殊素材：蓄光（緑色）': 'phosphorescent_green',
            '特殊素材：蛍光': 'fluorescent',
            '特殊素材：ラメ': 'glitter',
            '特殊素材：金色': 'gold',
            '特殊素材：銀色': 'silver'
        };
        var materialUnit = materialMap[material]
            ? (addPrice(materialMap[material], qty) || addPrice('item_material_fee', qty))
            : 0;
        var materialTotal = materialUnit * qty;
        // The original shape fee is a flat mold fee.  It must be persisted in
        // textfield2 (the legacy/admin field used by the order finalizer), not
        // DesignsCharge, which is reserved for design/color variations.
        var moldTotal = 0;
        if (shape.indexOf('オリジナル') !== -1) {
            moldTotal = addPrice('printedrubberstrap_originalplate', 1)
                || addPrice('original_shape_plate_fee', 1)
                || addPrice('originalplate', 1)
                || 8500;
        }
        var prototypeTotal = prototype === 'あり' && shape.indexOf('オリジナル') !== -1
            ? addPrice('prototype', 1) || 8000
            : 0;
        var total = baseTotal + partTotal + paperTotal + silkTotal + coatingTotal + materialTotal
            + moldTotal + prototypeTotal + manualServiceTotal(qty);

        setText('#prd_ItemPCS', itemPcs); setText('#prd_ItemShape', shape);
        setText('#prd_ItemPrint', print); setText('#prd_ItemColor', color);
        setText('#prd_ItemMaterial', material); setText('#prd_silk_print', silk);
        setText('#prd_coating', coating); setText('#prd_part', part || 'なし');
        setText('#prd_paper', paperSelect === 'あり' ? (paper || '未選択') : 'なし');
        setText('#prd_SendPrototype', prototype === 'あり' ? 'あり' : 'なし');
        setText('#prd_qty', qty);

        setValue('input[name="unit_price"]', unit);
        setValue('input[name="StrapPrice"]', baseTotal);
        setValue('input[name="ItemPCSFee"]', 0); setValue('input[name="ItemSizeFee"]', 0);
        setValue('input[name="PartPrice"]', partTotal); setValue('input[name="PaperPrice"]', paperTotal);
        setValue('input[name="SilkPrint"]', silkTotal); setValue('input[name="coatingPrice"]', coatingTotal);
        setValue('input[name="MaterialCharge"]', materialTotal);
        // Printed rubber strap/keyholder has no design-variation charge.  Keep
        // this explicitly zero so an old value cannot create a second add-on.
        setValue('input[name="DesignsCharge"]', 0);
        setValue('input[name="textfield2"]', moldTotal);
        setValue('input[name="ProShipping"]', prototypeTotal); setValue('input[name="TraceCharge"]', 0);
        setValue('input[name="BeforeTax"]', total); setValue('input[name="grandTotal"]', total);
        setValue('#textfield7', money(baseTotal)); setValue('#textfield7_1', money(partTotal));
        setValue('#textfield7_2', money(paperTotal)); setValue('#textfield13', money(silkTotal));
        setValue('#textfield13_2', money(coatingTotal)); setValue('#MaterialCharge', money(materialTotal));
        setValue('#DesignsCharge', money(0)); setValue('#mold_display', money(moldTotal)); setValue('#textfield3', money(prototypeTotal));
        setValue('#textfield4', money(0)); setValue('#textfield9', money(total));
        setValue('#textfield11', money(total)); $('.prd_total').text(money(total));
        $('.paper-container').css('display', paperSelect === 'あり' ? 'flex' : 'none');
    }

    function check_val(direction) {
        if (direction !== 'next') return true;
        var qty = parseInt($('#no_of_order').val(), 10);
        if (!isFinite(qty) || qty < 1 || qty > 50000) {
            $('#err_numberOf_mess').html('<font color="red">本数は1本以上、50000本以内で入力して下さい。</font>').show();
            return false;
        }
        $('#err_numberOf_mess').empty().hide();
        return true;
    }

    if (typeof window.format_number !== 'function') {
        window.format_number = function (value) {
            var number = parseInt(String(value || '').replace(/,/g, ''), 10);
            return isNaN(number) ? '' : number;
        };
    }
    window.setToInput = setToInput;
    window.calc = setToInput;
    window.check_val = check_val;

    $(function () {
        setToInput();
        $('input, select').on('change keyup', setToInput);
    });
})(window, window.jQuery);
