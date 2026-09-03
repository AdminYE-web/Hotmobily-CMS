/*
 * Complete admin calculator for create-order-rubberkeyholder.php.
 * All product-specific lookup and total logic lives in this file.
 */
(function (window, $) {
    'use strict';
    var PRODUCT_PREFIX = 'rubberkeyholder';

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

    function addPrice(code, qty, width) {
        var pool = window.numUnitAddPrice;
        if (!pool) return 0;
        var requested = String(code || '');
        var normalized = normalize(requested);
        var service = normalized
            .replace(new RegExp('^' + PRODUCT_PREFIX + '_(?:3|5)_'), '')
            .replace(new RegExp('^' + PRODUCT_PREFIX + '_'), '');
        var candidates = [];
        function add(key) { if (key && candidates.indexOf(key) === -1) candidates.push(key); }
        add(requested); add(normalized);
        if (width) {
            add(PRODUCT_PREFIX + '_' + width + '_' + service);
            add(PRODUCT_PREFIX + '_' + service + '_' + width);
        }
        add(PRODUCT_PREFIX + '_' + service); add(service);
        if (service === 'prototype') add('rubber_prototype');
        if (service === 'datatrace') add('rubber_data_trace');
        if (service === 'special_material') add('rubber_special_material');
        for (var i = 0; i < candidates.length; i++) {
            var price = readPrice(pool, candidates[i], qty || 1);
            if (price !== null) return price;
        }
        return 0;
    }

    function unitPrice(itemPcs, width, qty) {
        var mode = itemPcs === 'プレミアム'
            ? 'premium'
            : (itemPcs === 'スタンダード（スピード7営業日発送）' ? 'speed' : 'standard');
        var candidates = [
            mode === 'speed' ? PRODUCT_PREFIX + '_standard_speed_' + width : '',
            mode === 'speed' ? PRODUCT_PREFIX + '_' + width + '_standard_speed' : '',
            PRODUCT_PREFIX + '_' + mode + '_' + width,
            PRODUCT_PREFIX + '_' + width + '_' + mode,
            PRODUCT_PREFIX + '_' + mode,
            mode === 'speed' ? PRODUCT_PREFIX + '_standard' : ''
        ];
        for (var i = 0; i < candidates.length; i++) {
            var price = readPrice(window.numUnitPrice, candidates[i], qty);
            if (price !== null) return price;
        }
        return 0;
    }

    function optionPrice(key, qty) {
        return readPrice(window.numUnitOptionPrice, key, qty)
            || readPrice(window.numUnitOptionPrice, key + '_0', qty)
            || 0;
    }

    function selectedPartPrice(part, qty) {
        if (!part) return 0;
        if (typeof window.getPartPriceFromGlobalArrays === 'function') {
            var price = window.getPartPriceFromGlobalArrays(part);
            if (price !== undefined && isFinite(Number(price))) return Number(price);
        }
        return optionPrice(part, qty);
    }

    function paperPrice(paper, qty, width) {
        var key = paper === 'paper-patternA-1' ? 'mount_printing_single'
            : (paper === 'paper-patternA-2' ? 'mount_printing_both' : 'mount_plain');
        var price = addPrice(key, qty, width);
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
        var itemSize = $('input[name="ItemSize"]:checked').val() || '通常（80*80/3mm厚）';
        var width = itemSize.indexOf('5mm') !== -1 ? '5' : '3';
        var material = $('input[name="ItemMaterial"]:checked').val() || '特殊素材なし';
        var silk = $('input[name="silk_print"]:checked').val() || '印刷なし';
        var coating = $('input[name="coating"]:checked').val() || '汚れ防止加工なし';
        var variation = $('input[name="ItemDesignVariation"]:checked').val() || '1種類';
        var paperSelect = $('input[name="paper_select"]:checked').val() || 'なし';
        var paper = $('input[name="paper"]:checked').val() || '';
        var prototype = $('input[name="SendPrototype"]:checked').val() || 'なし';
        var trace = $('input[name="DeFormat"]:checked').val() || 'なし';
        var part = $('input[name="part"]:checked').val() || '';
        var qty = parseInt($('#no_of_order').val(), 10) || 0;
        var designCount = parseInt(variation, 10) || 1;
        var unit = qty > 0 ? unitPrice(itemPcs, width, qty) : 0;
        var baseTotal = unit * qty;
        var partTotal = selectedPartPrice(part, qty) * qty;
        var paperTotal = paperSelect === 'あり' && paper ? paperPrice(paper, qty, width) * qty : 0;
        var silkUnit = silk === '単色（シルク）印刷'
            ? addPrice('back_printing_single', qty, width)
            : (silk === 'フルカラー印刷' ? addPrice('back_printing_full', qty, width) : 0);
        var silkTotal = itemPcs === 'プレミアム' ? 0 : silkUnit * qty;
        var coatingTotal = coating === '汚れ防止加工あり' ? addPrice('anti_stain', qty, width) * qty : 0;
        var materialMap = {
            '特殊素材：蓄光（オレンジ色）': 'phosphorescent_orange',
            '特殊素材：蓄光（緑色）': 'phosphorescent_green',
            '特殊素材：蛍光': 'fluorescent',
            '特殊素材：ラメ': 'glitter',
            '特殊素材：金色': 'gold',
            '特殊素材：銀色': 'silver'
        };
        var materialUnit = materialMap[material]
            ? (addPrice(materialMap[material], qty, width) || addPrice('item_material_fee', qty, width))
            : 0;
        var materialTotal = materialUnit * qty;
        var designTotal = designCount > 1
            ? (addPrice('color_variation', designCount, width) || 3000 * (designCount - 1))
            : 0;
        var prototypeTotal = prototype === 'あり' && itemPcs !== 'プレミアム' ? addPrice('prototype', 1, width) : 0;
        var traceTotal = trace === 'あり' && itemPcs !== 'プレミアム' ? addPrice('data_trace', 1, width) : 0;
        var total = baseTotal + partTotal + paperTotal + silkTotal + coatingTotal + materialTotal
            + designTotal + prototypeTotal + traceTotal + manualServiceTotal(qty);

        setText('#prd_ItemPCS', itemPcs); setText('#prd_ItemSize', itemSize);
        setText('#prd_silk_print', silk); setText('#prd_coating', coating);
        setText('#prd_ItemDesign', variation); setText('#prd_ItemMaterial', material);
        setText('#prd_part', part || 'なし');
        setText('#prd_paper', paperSelect === 'あり' ? (paper || '未選択') : 'なし');
        setText('#prd_SendPrototype', prototype === 'あり' ? 'あり' : 'なし');
        setText('#prd_DeFormat', trace === 'あり' ? 'あり' : 'なし'); setText('#prd_qty', qty);

        setValue('input[name="unit_price"]', unit);
        setValue('input[name="StrapPrice"]', baseTotal);
        setValue('input[name="ItemPCSFee"]', 0); setValue('input[name="ItemSizeFee"]', 0);
        setValue('input[name="SilkPrint"]', silkTotal); setValue('input[name="PartPrice"]', partTotal);
        setValue('input[name="PaperPrice"]', paperTotal); setValue('input[name="coatingPrice"]', coatingTotal);
        setValue('input[name="ProShipping"]', prototypeTotal); setValue('input[name="TraceCharge"]', traceTotal);
        setValue('input[name="DesignsCharge"]', designTotal); setValue('input[name="MaterialCharge"]', materialTotal);
        setValue('input[name="BeforeTax"]', total); setValue('input[name="grandTotal"]', total);
        setValue('#textfield7', money(baseTotal)); setValue('#display_ItemPCSFee', money(0));
        setValue('#display_ItemSizeFee', money(0)); setValue('#textfield13', money(silkTotal));
        setValue('#textfield7_1', money(partTotal)); setValue('#textfield7_2', money(paperTotal));
        setValue('#textfield13_2', money(coatingTotal)); setValue('#textfield3', money(prototypeTotal));
        setValue('#textfield4', money(traceTotal)); setValue('#DesignsCharge', money(designTotal));
        setValue('#MaterialCharge', money(materialTotal)); setValue('#textfield9', money(total));
        setValue('#textfield11', money(total)); $('.prd_total').text(money(total));
        $('.paper-container').css('display', paperSelect === 'あり' ? 'flex' : 'none');
    }

    function check_val(direction) {
        if (direction === 'back' || direction === 'step1' || direction === 'step2' || direction === 'step3') return true;
        var qty = parseInt($('#no_of_order').val(), 10);
        var width = ($('input[name="ItemSize"]:checked').val() || '').indexOf('5mm') !== -1 ? '5' : '3';
        var tiers = window.numUnitPrice && window.numUnitPrice[PRODUCT_PREFIX + '_standard_' + width];
        if (!Array.isArray(tiers)) tiers = window.numUnitPrice && window.numUnitPrice[PRODUCT_PREFIX + '_' + width + '_standard'];
        if (!Array.isArray(tiers)) tiers = window.numUnitPrice && window.numUnitPrice[PRODUCT_PREFIX + '_standard'];
        var min = tiers && tiers.length ? Math.min.apply(null, tiers.map(function (tier) { return Number(tier.num); })) : 100;
        if (!isFinite(qty) || qty < min || qty > 50000) {
            $('#err_numberOf_mess').html('<font color="red">本数は' + min + '本以上、50000本以内で入力して下さい。</font>').show();
            return false;
        }
        $('#err_numberOf_mess').empty().hide(); return true;
    }

    function valid_chk_btn(direction) {
        if (!check_val(direction)) return;
        if (direction === 'back' || direction === 'step1') {
            $('#step2, #step3').hide(); $('#step1').show(); $('#back').hide();
            $('#next').show().text('アタッチメント・オプション入力へ');
        } else if (direction === 'next' && $('#step1').is(':visible')) {
            $('#step1, #step3').hide(); $('#step2').show(); $('#back, #next').show();
            $('#next').text('金額計算・見積・注文へ');
        } else {
            $('#step1, #step2').hide(); $('#step3').show(); $('#back, #next').hide();
        }
        setToInput();
    }

    function getPartData(partName) { if (partName) setToInput(); }

    function type_special_disabled(mode) {
        if (mode === 't1') {
            $('.pcs_option').show();
            $('#ariprint, #fcprint').prop('disabled', true);
            $('#nashiprint').prop('checked', true);
            $('#coating1').prop('disabled', true);
            $('#coating0').prop('checked', true);
            $('#no_of_order').val('10').prop('readonly', true);
            $('input[name="ItemSize"], input[name="paper_select"], input[name="SendPrototype"], input[name="DeFormat"]').prop('disabled', true);
            $('#button_pdf2').prop('disabled', true);
            return;
        }
        $('.pcs_option').hide();
        $('#pcs3').prop('checked', false);
        $('#ariprint, #fcprint').prop('disabled', false);
        $('#no_of_order').prop('readonly', false);
        $('input[name="ItemSize"], input[name="paper_select"], input[name="SendPrototype"], input[name="DeFormat"]').prop('disabled', false);
        $('#button_pdf2, .btn-next').prop('disabled', false);
        if ($('#pcs4').is(':checked')) {
            $('#coating0').prop('checked', true);
            $('#coating1').prop('disabled', true);
        } else {
            $('#coating1').prop('disabled', false);
        }
    }

    function click_typeorder_enabled() {
        $('.part_price_std').show();
        $('.part_price_prm').hide();
        type_special_disabled('f1');
    }

    function click_typeorder_disabled() {
        $('.part_price_std').hide();
        $('.part_price_prm').show();
        type_special_disabled('f1');
    }
    if (typeof window.format_number !== 'function') {
        window.format_number = function (value) {
            var number = parseInt(String(value || '').replace(/,/g, ''), 10);
            return isNaN(number) ? '' : number;
        };
    }
    window.setToInput = setToInput; window.calc = setToInput; window.getPartData = getPartData;
    window.check_val = check_val; window.valid_chk_btn = valid_chk_btn;
    window.type_special_disabled = type_special_disabled;
    window.click_typeorder_enabled = click_typeorder_enabled;
    window.click_typeorder_disabled = click_typeorder_disabled;

    $(function () {
        type_special_disabled($('#pcs3').is(':checked') ? 't1' : 'f1');
        setToInput();
        $('input, select').on('change keyup', setToInput);
    });
})(window, window.jQuery);
