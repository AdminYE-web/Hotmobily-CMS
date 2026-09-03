/**
 * calculate_rubberphonestand_admin.js
 * Admin-side pricing calculator for ラバースマホスタンド.
 *
 * - Product unit prices are fetched from window.numUnitPrice (DB-sourced via create-order-rubberphonestand.php)
 * - Paper prices are hardcoded here (copied from _setToInput_2023.js paperPrice_obj)
 * - Additional service prices (coating, prototype, trace, design variation, special material) use window.numUnitAddPrice
 * - Results are written to hidden form fields (StrapPrice, PaperPrice, etc.)
 */

// ---- Utility ----
function format_number(v) {
    var n = parseInt(String(v).replace(/,/g, ''), 10);
    return isNaN(n) ? '' : n;
}
window.format_number = format_number;

// Paper price table — copied 1:1 from _setToInput_2023.js

/* Product-local helpers for create-order-rubberphonestand.php. */
function rbPhoneStandReadPrice(pool, key, qty) {
    if (!pool || !Object.prototype.hasOwnProperty.call(pool, key) || !Array.isArray(pool[key])) return null;
    var tiers = pool[key].slice().sort(function (a, b) { return Number(a.num || 0) - Number(b.num || 0); });
    if (!tiers.length) return null;
    var selected = tiers[0];
    tiers.forEach(function (tier) { if (Number(qty) >= Number(tier.num || 0)) selected = tier; });
    var price = Number(selected.price);
    return isFinite(price) ? Math.floor(price) : null;
}

function rbPhoneStandAddPrice(code, qty, width) {
    var pool = window.numUnitAddPrice;
    if (!pool) return 0;
    var requested = String(code || '');
    var normalized = requested
        .replace(/^rubber_/, '')
        .replace(/^anti_stain$/, 'antistain')
        .replace(/^data_trace$/, 'datatrace')
        .replace(/^color_variation$/, 'colorvariation')
        .replace(/^back_printing_/, 'backprinting_');
    var service = normalized.replace(/^rubberphonestand_(?:s|l)_/, '').replace(/^rubberphonestand_/, '');
    var candidates = [];
    function add(key) { if (key && candidates.indexOf(key) === -1) candidates.push(key); }
    add(requested); add(normalized);
    if (width) {
        add('rubberphonestand_' + width + '_' + service);
        add('rubberphonestand_' + service + '_' + width);
    }
    add('rubberphonestand_' + service); add(service);
    if (service === 'prototype') add('rubber_prototype');
    if (service === 'datatrace') add('rubber_data_trace');
    if (service === 'special_material') add('rubber_special_material');
    for (var i = 0; i < candidates.length; i++) {
        var price = rbPhoneStandReadPrice(pool, candidates[i], qty || 1);
        if (price !== null) return price;
    }
    return 0;
}

function rbPhoneStandManualTotal() {
    if (typeof window.$ !== 'function') return 0;
    var qty = parseInt($('#no_of_order').val() || $('#numberOf').val() || 1, 10) || 1;
    var seen = Object.create(null);
    var total = 0;
    $('#servicesList .service-row').each(function () {
        var name = String($(this).find('.service-input').val() || '').trim();
        var fee = parseFloat(String($(this).find('.fee-input').val() || '').replace(/,/g, ''));
        if (!name || !isFinite(fee)) return;
        var key = name.toLowerCase();
        if (seen[key]) return;
        seen[key] = true;
        total += fee;
    });
    $('#partsList .part-row').each(function () {
        var name = String($(this).find('.part-name-select').val() || '').trim();
        var fee = parseFloat(String($(this).find('.part-fee-input, .fee-input').first().val() || '').replace(/,/g, ''));
        if (!name || !isFinite(fee)) return;
        var key = 'part:' + name.toLowerCase();
        if (seen[key]) return;
        seen[key] = true;
        total += fee * qty;
    });
    return total;
}

// Shared state
var unit_price = 0;
var partPrice = 0;
var paperPrice = 0;
var coatingPrice = 0;
var proShipping = 0;
var traceCharge = 0;
var designsCharge = 0;
var materialCharge = 0;
var sub_total = 0;
var disPrice = 0;
var total = 0;

/**
 * Lookup a price from a tier array: highest tier where qty >= tier.num
 */
function lookupPrice(tiers, qty) {
    var result = 0;
    if (!tiers || tiers.length === 0) return result;
    for (var i = 0; i < tiers.length; i++) {
        if (qty >= parseInt(tiers[i].num)) {
            result = Math.floor(tiers[i].price);
        } else {
            break;
        }
    }
    return result;
}

/**
 * Get product unit price tiers from DB-sourced window.numUnitPrice
 * Key is determined by size (小/大) + type (スタンダード/スピード/プレミアム)
 */
function get_phonestand_price() {
    var itemSize = $('input[name="ItemSize"]:checked').val() || '小サイズ';
    var itemPCS = $('input[name="ItemPCS"]:checked').val() || 'スタンダード';

    var sizeKey = (itemSize === '大サイズ') ? 'l' : 's';
    var isSpeed = itemPCS === 'スタンダード（スピード7営業日発送）';
    var typeKey = (itemPCS === 'プレミアム') ? 'premium' : (isSpeed ? 'standard_speed' : 'standard');

    var dbKey = 'rubberphonestand_' + sizeKey + '_' + typeKey;

    if (window.numUnitPrice && window.numUnitPrice[dbKey]) {
        return window.numUnitPrice[dbKey];
    }
    // Keep older installations usable if the dedicated speed product has not
    // been added to their price master yet.
    if (isSpeed && window.numUnitPrice && window.numUnitPrice['rubberphonestand_' + sizeKey + '_standard']) {
        return window.numUnitPrice['rubberphonestand_' + sizeKey + '_standard'];
    }
    return [];
}

/**
 * Get an additional service price (single flat value, qty-independent)
 * Keys: coating, rubber_prototype, rubber_data_trace, rubber_color_variation, rubber_special_material
 */
function get_add_price(code) {
    var size = $('input[name="ItemSize"]:checked').val() || '小サイズ';
    return rbPhoneStandAddPrice(code, 1, size === '大サイズ' ? 'l' : 's');
}

/**
 * Main calculation function — called setToInput() to match customer form convention
 */
function setToInput() {
    var itemSize = $('input[name="ItemSize"]:checked').val() || '小サイズ';
    var add_prefix = 'rubberphonestand_' + (itemSize === '大サイズ' ? 'l' : 's');
    var itemPCS = $('input[name="ItemPCS"]:checked').val() || 'スタンダード';
    var qty = parseInt($('#no_of_order').val(), 10) || 0;
    var silkPrint = $('input[name="silk_print"]:checked').val() || '印刷なし';
    var coating = $('input[name="coating"]:checked').val() || '汚れ防止加工なし';
    var designVariation = $('input[name="ItemDesignVariation"]:checked').val() || '1種類';
    var itemMaterial = $('input[name="ItemMaterial"]:checked').val() || '特殊素材なし';
    var sendPrototype = $('input[name="SendPrototype"][type="checkbox"]:checked').val() || $('input[name="SendPrototype"][type="hidden"]').val() || 'なし';
    var deFormat = $('input[name="DeFormat"][type="checkbox"]:checked').val() || $('input[name="DeFormat"][type="hidden"]').val() || 'なし';
    var paperSelect = $('input[name="paper_select"][type="checkbox"]:checked').val() || $('input[name="paper_select"][type="hidden"]').val() || 'なし';
    var paperType = $('input[name="paper"]:checked').val() || '';

    // Speed delivery: coating is not available
    var isSpeed = (itemPCS === 'スタンダード（スピード7営業日発送）');

    // Clear error
    $('#error_message').text('');

    if (qty <= 0) { qty = 0; }

    // ---- 1. Product base price (from DB) ----
    var price_tiers = get_phonestand_price();
    unit_price = (qty > 0) ? lookupPrice(price_tiers, qty) : 0;
    var strapPrice = unit_price * qty;

    // ---- 2. Silk print (裏面印刷) price ----
    var silkPrintPrice = 0;
    if (silkPrint === '単色（シルク）印刷') {
        // Premium: silk print is free; Speed: normal rate
        if (itemPCS !== 'プレミアム') {
            var singlePrice = get_add_price(add_prefix + '_backprinting_single') || get_add_price('back_printing_single');
            var platePrice = get_add_price('silk_plate') || 0;
            silkPrintPrice = (singlePrice * qty) + platePrice;
        }
    } else if (silkPrint === 'フルカラー印刷') {
        silkPrintPrice = qty * (get_add_price(add_prefix + '_backprinting_full') || get_add_price('back_printing_full'));
    }

    // ---- 3. Coating price ----
    coatingPrice = 0;
    // Speed delivery: no coating available
    if (!isSpeed && (coating === '汚れ防止加工あり' || coating === '汚れ防止加工')) {
        coatingPrice = get_add_price(add_prefix + '_antistain') || get_add_price('anti_stain') || get_add_price('coating') || get_add_price('rubber_coating');
    }
    var coatingTotal = coatingPrice * qty;

    // ---- 4. Paper price ----
    paperPrice = 0;
    if (paperSelect === 'あり' && paperType !== '') {
        var tmp_pp;
        var dbPaperKey = 'Paper Temp';
        if (paperType === 'paper-patternA-1') {
            dbPaperKey = 'Paper 1 Side';
        } else if (paperType === 'paper-patternA-2') {
            dbPaperKey = 'Paper 2 Side';
        }
        tmp_pp = window.numUnitOptionPrice ? (window.numUnitOptionPrice[dbPaperKey] || window.numUnitOptionPrice[dbPaperKey + '_0']) : [];
        if (!tmp_pp || tmp_pp.length === 0) {
            tmp_pp = window.numUnitOptionPrice ? (window.numUnitOptionPrice['Paper 1 Side'] || window.numUnitOptionPrice['Paper 1 Side_0']) : [];
        }
        paperPrice = (qty > 0) ? lookupPrice(tmp_pp, qty) : 0;
    }
    var paperTotal = paperPrice * qty;

    // ---- 5. Prototype (試作品) ----
    proShipping = 0;
    if (sendPrototype === 'あり' || sendPrototype === '1') {
        proShipping = get_add_price(add_prefix + '_prototype') || get_add_price('rubber_prototype') || get_add_price('prototype');
        // Premium: prototype is free
        if (itemPCS === 'プレミアム') proShipping = 0;
    }

    // ---- 6. Data trace (データトレース) ----
    traceCharge = 0;
    if (deFormat === 'あり' || deFormat === '1') {
        traceCharge = get_add_price(add_prefix + '_datatrace') || get_add_price('rubber_data_trace') || get_add_price('data_trace');
        // Premium: trace is free
        if (itemPCS === 'プレミアム') traceCharge = 0;
    }

    // ---- 7. Color variation (カラーバリエーション) ----
    designsCharge = 0;
    var designNum = parseInt(designVariation) || 1;
    if (designNum > 1) {
        var variationUnitPrice = get_add_price(add_prefix + '_colorvariation') || get_add_price('rubber_color_variation') || get_add_price('color_variation');
        designsCharge = variationUnitPrice * (designNum - 1);
    }

    // ---- 8. Special material (特殊素材) ----
    materialCharge = 0;
    var materialKey = '';
    switch (itemMaterial) {
        case '特殊素材：蓄光（オレンジ色）': materialKey = add_prefix + '_phosphorescent_orange'; break;
        case '特殊素材：蓄光（緑色）': materialKey = add_prefix + '_phosphorescent_green'; break;
        case '特殊素材：蛍光': materialKey = add_prefix + '_fluorescent'; break;
        case '特殊素材：ラメ': materialKey = add_prefix + '_glitter'; break;
        case '特殊素材：金色': materialKey = add_prefix + '_gold'; break;
        case '特殊素材：銀色': materialKey = add_prefix + '_silver'; break;
    }
    if (materialKey !== '') {
        materialCharge = get_add_price(materialKey) || get_add_price('rubber_special_material') || get_add_price('special_material') || get_add_price('item_material_fee');
        if (materialCharge > 0) materialCharge = materialCharge * qty;
    }

    // ---- Subtotal ----
    var manualServiceTotal = rbPhoneStandManualTotal();
    sub_total = strapPrice + silkPrintPrice + coatingTotal + paperTotal + proShipping + traceCharge + designsCharge + materialCharge + manualServiceTotal;
    disPrice = 0;
    total = sub_total - disPrice;

    // ---- Summary display (spec table) ----
    $('#prd_ItemSize').text(itemSize);
    $('#prd_ItemPCS').text(itemPCS);
    $('#prd_silk_print').text(silkPrint);
    $('#prd_coating').text(coating);
    $('#prd_qty').text(qty);
    $('#prd_paper').text(paperSelect === 'あり' ? (paperType || '未選択') : 'なし');
    $('#prd_SendPrototype').text(sendPrototype === 'あり' ? 'あり' : 'なし');
    $('#prd_DeFormat').text(deFormat === 'あり' ? 'あり' : 'なし');
    $('#prd_ItemDesign').text(designVariation || '1種類');
    $('#prd_ItemMaterial').text(itemMaterial);

    // ---- Price field writes ----
    var $t7 = document.getElementById('textfield7'); if ($t7) $t7.value = strapPrice;
    var $t13 = document.getElementById('textfield13'); if ($t13) $t13.value = silkPrintPrice;
    var $t13_2 = document.getElementById('textfield13_2'); if ($t13_2) $t13_2.value = coatingTotal;
    var $t7_2 = document.getElementById('textfield7_2'); if ($t7_2) $t7_2.value = paperTotal;
    var $t3 = document.getElementById('textfield3'); if ($t3) $t3.value = proShipping;
    var $t4 = document.getElementById('textfield4'); if ($t4) $t4.value = traceCharge;
    var $dc = document.getElementById('DesignsCharge'); if ($dc) $dc.value = designsCharge;
    var $mc = document.getElementById('MaterialCharge'); if ($mc) $mc.value = materialCharge;
    var $t9 = document.getElementById('textfield9'); if ($t9) $t9.value = sub_total;
    var $dis = document.getElementById('textfield_dis'); if ($dis) $dis.value = disPrice;
    var $t11 = document.getElementById('textfield11'); if ($t11) $t11.value = total;
    var $up = document.getElementById('unit_price'); if ($up) $up.value = (qty > 0 ? unit_price : 0);

    // Also write to named form inputs (used by add-order.php)
    $('input[name="StrapPrice"]').val(strapPrice);
    $('input[name="SilkPrint"]').val(silkPrintPrice);
    $('input[name="coatingPrice"]').val(coatingTotal);
    $('input[name="PartPrice"]').val(0);
    $('input[name="PaperPrice"]').val(paperTotal);
    $('input[name="ProShipping"]').val(proShipping);
    $('input[name="TraceCharge"]').val(traceCharge);
    $('input[name="DesignsCharge"]').val(designsCharge);
    $('input[name="MaterialCharge"]').val(materialCharge);
    $('input[name="ManualServiceTotal"]').val(manualServiceTotal);
    $('input[name="BeforeTax"]').val(sub_total);
    $('input[name="grandTotal"]').val(total);

    // Total badge
    $('.prd_total').text(total.toLocaleString('ja'));

    // Show/hide paper preview
    if (paperSelect === 'あり') {
        $('.paper-container').css('display', 'flex');
    } else {
        $('.paper-container').css('display', 'none');
    }
}

// Alias so onclick="setToInput()" works from form buttons
window.setToInput = setToInput;

$(document).ready(function () {
    // Paper checkbox toggle
    $('input[name="paper_select"]').on('change', function () {
        if ($(this).is(':checked')) {
            $('.paper-container').css('display', 'flex');
            if ($('#paper-preview').children().length === 0) {
                $('#paper-preview').load('/products/paper_preview.php');
            }
        } else {
            $('.paper-container').css('display', 'none');
        }
        setToInput();
    });

    // Speed delivery: disable coating option
    $('input[name="ItemPCS"]').on('change', function () {
        var isSpeed = ($(this).val() === 'スタンダード（スピード7営業日発送）');
        if (isSpeed) {
            $('#coating1').prop('disabled', true);
            if ($('#coating1').is(':checked')) {
                $('#coating0').prop('checked', true);
            }
        } else {
            $('#coating1').prop('disabled', false);
        }
        setToInput();
    });

    // Initial calculation
    setToInput();
});

// --- Added for validation and step progression ---
function check_val(c) {
    if (c === 'back' || c === 'step1' || c === 'step2' || c === 'step3') {
        return true;
    }

    var err_number = document.getElementById("err_numberOf_mess");
    var mess = "";
    if (err_number) err_number.style.display = "";

    var vNumberOfOder = $("#no_of_order").val();

    if (isNaN(vNumberOfOder)) {
        mess += "<font color='red'>半角数値以外が入力されています。</font>";
        if (err_number) err_number.innerHTML = mess;
        return false;
    }

    if (vNumberOfOder > 50000) {
        mess += "<font color='red'>本数は50000本以内で入力して下さい。50000以上のお客様は納期をメールにてお問い合わせ下さい。</font>";
        if (err_number) err_number.innerHTML = mess;
        return false;
    }

    if ($("input[name=ItemDesignVariation]").length) {
        switch ($("input[name=ItemDesignVariation]:checked").val()) {
            case "1種類":
                if (vNumberOfOder == "" || vNumberOfOder < 100) {
                    mess += "<font color='red'>本数は100本以上で入力して下さい。</font>";
                    if (err_number) err_number.innerHTML = mess;
                    return false;
                }
                break;
            case "2種類":
                if (vNumberOfOder == "" || vNumberOfOder < 100) {
                    mess += "<font color='red'>本数は100本以上で入力して下さい。</font>";
                    if (err_number) err_number.innerHTML = mess;
                    return false;
                }
                break;
            case "3種類":
                if (vNumberOfOder == "" || vNumberOfOder < 150) {
                    mess += "<font color='red'>本数は150本以上で入力して下さい。</font>";
                    if (err_number) err_number.innerHTML = mess;
                    return false;
                }
                break;
            case "4種類":
                if (vNumberOfOder == "" || vNumberOfOder < 200) {
                    mess += "<font color='red'>本数は200本以上で入力して下さい。</font>";
                    if (err_number) err_number.innerHTML = mess;
                    return false;
                }
                break;
        }
    } else {
        if (vNumberOfOder == "" || vNumberOfOder < 100) {
            mess += "<font color='red'>本数は100本以上で入力して下さい。</font>";
            if (err_number) err_number.innerHTML = mess;
            return false;
        }
    }

    if (err_number) err_number.style.display = "none";
    return true;
}

function valid_chk_btn(c) {
    if (check_val(c)) {
        $("#step1").fadeOut("fast");
        $("#step2").fadeOut("fast");
        $("#step3").fadeOut("fast");
        $("#dot-step1").removeClass("active");
        $("#dot-step2").removeClass("active");
        $("#dot-step3").removeClass("active");

        switch ($("#next").text()) {
            case "アタッチメント・オプション入力へ":
                if (c == "next" || c == "step2") {
                    $("#back").fadeIn("slow");
                    $("#step2").fadeIn("slow");
                    $("#next").text("金額計算・見積・注文へ");
                    $("#next").blur();
                    $("#dot-step1").addClass("active");
                    $("#dot-step2").addClass("active");
                } else if (c == "step3") {
                    $("#step3").fadeIn("slow");
                    $("#next").text("金額計算・見積・注文へ");
                    $("#next").blur();
                    $("#back").fadeOut("fast");
                    $("#next").fadeOut("fast");
                    $("#dot-step1").addClass("active");
                    $("#dot-step2").addClass("active");
                    $("#dot-step3").addClass("active");
                }
                break;
            case "金額計算・見積・注文へ":
                if (c == "next") {
                    $("#step3").fadeIn("slow");
                    $("#back").fadeOut("fast");
                    $("#next").fadeOut("fast");
                    $("#dot-step1").addClass("active");
                    $("#dot-step2").addClass("active");
                    $("#dot-step3").addClass("active");
                } else if (c == "back" || c == "step1") {
                    $("#next").fadeIn("slow");
                    $("#step1").fadeIn("slow");
                    $("#next").text("アタッチメント・オプション入力へ");
                    $("#next").blur();
                    $("#back").fadeOut("fast");
                    $("#dot-step1").addClass("active");
                } else {
                    $("#back").fadeIn("slow");
                    $("#next").fadeIn("slow");
                    $("#step2").fadeIn("slow");
                    $("#next").text("金額計算・見積・注文へ");
                    $("#next").blur();
                    $("#dot-step1").addClass("active");
                    $("#dot-step2").addClass("active");
                }
                break;
        }
    }
}
