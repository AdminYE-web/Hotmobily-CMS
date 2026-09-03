// Admin pricing script for 印刷ラバーコースター (Printed Rubber Coaster)
// DB-first: all prices resolved from window.numUnitPrice / window.numUnitAddPrice
// injected as JSON by create-order-printedrubbercoaster.php.
//
// DB price codes (item_price_master / additional_service):
//   Unit price  : printedrubbercoaster_standard (product_id=197)
//                 printedrubbercoaster_rush      (product_id=198)
//   Services    : rubber_prototype  → proto_charge   (flat ¥8,000)
//                 rubber_data_trace → trace_charge   (flat ¥8,000)
//                 anti_stain        → coating_charge (¥70 / unit)
//                 back_printing_single→ print_charge (¥30 × qty)
//                 color_variation   → DesignsCharge  (¥3,000 per extra design)
//                 item_material_fee → MaterialCharge (¥30 / unit)
//   Special shape: オリジナル → special_shape_fee = ¥9,350 (hardcoded – no DB entry)

// ===== Globals =====
var price_bracket = 0;
var packing_price = 0;
var proto_shipping_charge = 0;
var order_pcs = 0;
var strap_price = 0;
var before_tax = 0;
var tax = 0;
var vat = 10;
var total = 0;
var silkprint = 0;
var partPrice = 0;
var paperPrice = 0;
var TextField7Value = 0;
var TextField9Value = 0;
var DisPrice = 0;
var proto_charge = 0;
var trace_charge = 0;
var print_charge = 0;
var coating_charge = 0;
var MaterialCharge = 0;
var special_shape_fee = 0;

// Paper price tiers (not in item_price_master – kept hardcoded per existing pattern)

// ===== Helpers =====
function clearValue() {
    price_bracket = 0;
    packing_price = 0;
    proto_shipping_charge = 0;
    order_pcs = 0;
    strap_price = 0;
    before_tax = 0;
    tax = 0;
    total = 0;
    silkprint = 0;
    partPrice = 0;
    paperPrice = 0;
    TextField7Value = 0;
    TextField9Value = 0;
    DisPrice = 0;
    proto_charge = 0;
    trace_charge = 0;
    print_charge = 0;
    coating_charge = 0;
    MaterialCharge = 0;
    special_shape_fee = 0;
}

function formatMoney(n) {
    if (isNaN(n) || n === '' || n === null) return 0;
    return Math.floor(Number(n)).toLocaleString('ja-JP');
}

function getAdminManualServiceTotal() {
    if (typeof window.$ === 'undefined' || !$('#servicesList').length) return 0;
    var parseFee = function (value) {
        var parsed = parseFloat(String(value || '').replace(/[^0-9.-]/g, ''));
        return isNaN(parsed) ? null : parsed;
    };
    var qtyValue = parseInt($('#no_of_order').val() || $('#num_colors4').val(), 10);
    if (isNaN(qtyValue) || qtyValue <= 0) qtyValue = 1;
    var seen = {};
    var sum = 0;
    $('#servicesList .service-row').each(function () {
        var name = String($(this).find('.service-input').val() || '').trim();
        var fee = parseFee($(this).find('.fee-input').val());
        var key = name.toLowerCase();
        if (!name || fee === null || seen[key]) return;
        seen[key] = true;
        sum += fee;
    });
    $('#partsList .part-row').each(function () {
        var name = String($(this).find('.part-name-select').val() || '').trim();
        var fee = parseFee($(this).find('.part-fee-input').val());
        if (!name || fee === null) return;
        sum += fee * qtyValue;
    });
    return sum;
}

function printedRubberCoasterReadAddPrice(key, qty) {
    var pool = window.numUnitAddPrice;
    if (!pool || !Object.prototype.hasOwnProperty.call(pool, key) || !Array.isArray(pool[key])) return null;
    var tiers = pool[key].slice().sort(function (a, b) { return Number(a.num || 0) - Number(b.num || 0); });
    if (!tiers.length) return null;
    var selected = tiers[0];
    tiers.forEach(function (tier) { if (Number(qty) >= Number(tier.num || 0)) selected = tier; });
    var price = Number(selected.price);
    return isFinite(price) ? Math.floor(price) : null;
}

function printedRubberCoasterAddPrice(code, qty) {
    var requested = String(code || '');
    var normalized = requested
        .replace(/^rubber_/, '')
        .replace(/^anti_stain$/, 'antistain')
        .replace(/^data_trace$/, 'datatrace')
        .replace(/^color_variation$/, 'colorvariation')
        .replace(/^back_printing_/, 'backprinting_');
    var service = normalized.replace(/^printedrubbercoaster_/, '');
    var candidates = [];
    function add(key) { if (key && candidates.indexOf(key) === -1) candidates.push(key); }
    add(requested); add(normalized); add('printedrubbercoaster_' + service); add(service);
    if (service === 'prototype') add('rubber_prototype');
    if (service === 'datatrace') add('rubber_data_trace');
    if (service === 'special_material') add('rubber_special_material');
    for (var i = 0; i < candidates.length; i++) {
        var price = printedRubberCoasterReadAddPrice(candidates[i], qty || 1);
        if (price !== null) return price;
    }
    return null;
}

/**
 * Look up the highest-matching tier price from a DB pool.
 * pool  : e.g. window.numUnitPrice or window.numUnitAddPrice
 * key   : exact key or substring to find
 * qty   : order quantity (for tier matching)
 */
function getDbPriceVal(pool, key, qty) {
    if (typeof pool === 'undefined' || !pool) return null;

    if (pool === window.numUnitAddPrice) {
        var productPrice = printedRubberCoasterAddPrice(key, qty);
        if (productPrice !== null) return productPrice;
    }

    var tiers = null;

    // Exact key match first
    if (pool[key]) {
        tiers = pool[key];
    } else {
        // Substring search
        var found = Object.keys(pool).find(function (k) { return k.indexOf(key) !== -1; });
        if (found) tiers = pool[found];
    }

    if (!tiers || !Array.isArray(tiers)) return null;

    // Sort descending so we pick the highest applicable tier
    var sorted = tiers.slice().sort(function (a, b) { return b.num - a.num; });
    for (var i = 0; i < sorted.length; i++) {
        if (qty >= sorted[i].num) return parseFloat(sorted[i].price);
    }
    // qty < smallest tier – return the smallest tier's price
    if (sorted.length > 0) return parseFloat(sorted[sorted.length - 1].price);
    return null;
}

// ===== Main calc function =====
function setToInput() {
    clearValue();

    var vno_of_order = document.getElementById('no_of_order');
    if (!vno_of_order || vno_of_order.value === '') return;

    var qty = parseInt(vno_of_order.value, 10);
    if (isNaN(qty)) return;
    if (qty < 0) qty = 0;

    // ── 1. Unit price from DB ─────────────────────────────────────────────
    // pcs1 = スタンダード  → printedrubbercoaster_standard  (product_id 18)
    // pcs4 = スピード発送  → printedrubbercoaster_speed     (product_id 19)
    var dbUnitKey = null;
    if ($('#pcs1').is(':checked')) dbUnitKey = 'printedrubbercoaster_standard';
    if ($('#pcs4').is(':checked')) dbUnitKey = 'printedrubbercoaster_speed';

    if (dbUnitKey) {
        var dbPrice = getDbPriceVal(window.numUnitPrice, dbUnitKey, qty);
        if (dbPrice !== null) {
            order_pcs = dbPrice;
        }
    }

    // ── 2. Paper (台紙) ────────────────────────────────────────────────────
    if ($('input[name="paper_select"]').length) {
        var paper = $('input[name="paper_select"]:checked').val();
        var paper_color = $('input[name="paper"]:checked').val();
        if (paper === 'あり') {
            $('.paper-container').show();
            if (paper_color !== undefined) {
                $('#prd_paper').text(paper_color);
                $('#paper-error').text('');

                let dbPaperPrice = null;
                if (paper_color === 'paper-patternA-1') {
                    dbPaperPrice = getDbPriceVal(window.numUnitAddPrice, 'mount_printing_single', qty);
                    if (dbPaperPrice === null && typeof window.numUnitOptionPrice !== 'undefined') dbPaperPrice = getDbPriceVal(window.numUnitOptionPrice, 'Paper 1 Side', qty);
                } else if (paper_color === 'paper-patternA-2') {
                    dbPaperPrice = getDbPriceVal(window.numUnitAddPrice, 'mount_printing_both', qty);
                    if (dbPaperPrice === null && typeof window.numUnitOptionPrice !== 'undefined') dbPaperPrice = getDbPriceVal(window.numUnitOptionPrice, 'Paper 2 Side', qty);
                } else {
                    dbPaperPrice = getDbPriceVal(window.numUnitAddPrice, 'mount_plain', qty);
                    if (dbPaperPrice === null && typeof window.numUnitOptionPrice !== 'undefined') dbPaperPrice = getDbPriceVal(window.numUnitOptionPrice, 'Paper Temp', qty);
                }
                paperPrice = dbPaperPrice !== null ? dbPaperPrice : 0;
            } else {
                $('#paper-error').text('台紙を選択してください。');
            }
        } else {
            $('.paper-container').css('display', 'none');
            $('#prd_paper').text('なし');
            paperPrice = 0;
        }
    }

    // ── 3. オリジナル形状 fee ──────────────────────────────────────────
    var itemShape = $('input[name=ItemShape]:checked').val();
    if (itemShape === 'オリジナル') {
        var dbPlate = getDbPriceVal(window.numUnitAddPrice, 'printedrubbercoaster_originalplate', 1)
            || getDbPriceVal(window.numUnitAddPrice, 'originalplate', 1);
        special_shape_fee = (dbPlate !== null) ? dbPlate : 9350;
    }

    // ── 4. 裏面印刷 (silk print) – DB: printedrubbercoaster_backprinting_full ¥50/unit ──────
    var silkVal = $('input[name=silk_print]:checked').val();
    if (silkVal === '印刷あり' || silkVal === 'フルカラー印刷') {
        var dbPrint = getDbPriceVal(window.numUnitAddPrice, 'printedrubbercoaster_backprinting_full', 1)
            || getDbPriceVal(window.numUnitAddPrice, 'backprinting_full', 1)
            || getDbPriceVal(window.numUnitAddPrice, 'back_printing_full', 1);
        print_charge = (dbPrint !== null) ? dbPrint * qty : 50 * qty;
    }

    // ── 5. 汚れ防止加工 – DB: printedrubbercoaster_antistain ¥70/unit ──────
    var coatVal = $('input[name=coating]:checked').val();
    if (coatVal === '汚れ防止加工あり') {
        var dbCoat = getDbPriceVal(window.numUnitAddPrice, 'printedrubbercoaster_antistain', 1)
            || getDbPriceVal(window.numUnitAddPrice, 'antistain', 1)
            || getDbPriceVal(window.numUnitAddPrice, 'anti_stain', 1);
        coating_charge = (dbCoat !== null) ? dbCoat : 70;
    }

    // ── 6. 試作品 – DB: printedrubbercoaster_prototype ¥8,000 ──────────────
    var protoVal = $('input[name=SendPrototype]:checked').val();
    if (protoVal === 'あり') {
        var dbProto = getDbPriceVal(window.numUnitAddPrice, 'printedrubbercoaster_prototype', 1)
            || getDbPriceVal(window.numUnitAddPrice, 'prototype', 1)
            || getDbPriceVal(window.numUnitAddPrice, 'rubber_prototype', 1);
        proto_charge = (dbProto !== null) ? dbProto : 8000;
    }

    // ── 7. データトレース – DB: printedrubbercoaster_datatrace ¥8,000 ────────
    var traceVal = $('input[name=DeFormat]:checked').val();
    if (traceVal === 'あり') {
        var dbTrace = getDbPriceVal(window.numUnitAddPrice, 'printedrubbercoaster_datatrace', 1)
            || getDbPriceVal(window.numUnitAddPrice, 'datatrace', 1)
            || getDbPriceVal(window.numUnitAddPrice, 'rubber_data_trace', 1);
        trace_charge = (dbTrace !== null) ? dbTrace : 8000;
    }

    // ── 8. 特殊素材 – DB: printedrubbercoaster_phosphorescent_orange, etc. ─────
    var matVal = $('input[name=ItemMaterial]:checked').val() || '';
    if (matVal !== '' && matVal !== '特殊素材なし') {
        var matKey = '';
        if (matVal === '特殊素材：蓄光（オレンジ色）') matKey = 'printedrubbercoaster_phosphorescent_orange';
        else if (matVal === '特殊素材：蓄光（緑色）') matKey = 'printedrubbercoaster_phosphorescent_green';
        else if (matVal === '特殊素材：蛍光') matKey = 'printedrubbercoaster_fluorescent';
        else if (matVal === '特殊素材：ラメ') matKey = 'printedrubbercoaster_glitter';
        else if (matVal === '特殊素材：金色') matKey = 'printedrubbercoaster_gold';
        else if (matVal === '特殊素材：銀色') matKey = 'printedrubbercoaster_silver';

        var dbMat = matKey ? getDbPriceVal(window.numUnitAddPrice, matKey, 1) : null;
        if (dbMat === null) dbMat = getDbPriceVal(window.numUnitAddPrice, 'item_material_fee', 1);
        MaterialCharge = (dbMat !== null) ? dbMat : 30;
    }

    // ── 9. Spec display labels ──────────────────────────────────────────
    if ($('#prd_ItemPCS').length) $('#prd_ItemPCS').text($('input[name=ItemPCS]:checked').val() || '');
    if ($('#prd_ItemShape').length && itemShape) $('#prd_ItemShape').text(itemShape);
    if ($('#prd_ItemPrint').length) $('#prd_ItemPrint').text($('input[name=ItemPrint]:checked').val() || '');
    if ($('#prd_ItemColor').length) $('#prd_ItemColor').text($('input[name=ItemColor]:checked').val() || '');
    if ($('#prd_silk_print').length) $('#prd_silk_print').text($('input[name=silk_print]:checked').val() || '');
    if ($('#prd_coating').length) $('#prd_coating').text($('input[name=coating]:checked').val() || '');
    if ($('#prd_qty').length) $('#prd_qty').text(qty);
    if ($('#prd_SendPrototype').length) {
        $('#prd_SendPrototype').text($('input[name=SendPrototype]:checked').val() === 'あり' ? 'あり' : 'なし');
    }
    if ($('#prd_DeFormat').length) {
        $('#prd_DeFormat').text($('input[name=DeFormat]:checked').val() === 'あり' ? 'あり' : 'なし');
    }
    if ($('#prd_ItemMaterial').length) {
        $('#prd_ItemMaterial').text(matVal || '特殊素材なし');
    }

    // ── 10. Totals ────────────────────────────────────────────────────────
    TextField7Value = Math.round(order_pcs) * qty;

    var manual_service_total = getAdminManualServiceTotal();
    TextField9Value = TextField7Value
        + proto_charge
        + trace_charge
        + print_charge
        + (coating_charge * qty)
        + (paperPrice * qty)
        + (MaterialCharge * qty)
        + special_shape_fee
        + manual_service_total;

    total = TextField9Value - DisPrice;

    // ── 11. Write to form fields ──────────────────────────────────────────
    if ($('#textfield7').length) document.getElementById('textfield7').value = formatMoney(TextField7Value);
    if ($('#textfield7_2').length) document.getElementById('textfield7_2').value = formatMoney(paperPrice * qty);
    if ($('#textfield2').length) $('#textfield2').val(special_shape_fee > 0 ? formatMoney(special_shape_fee) : '0');
    if ($('#textfield2_display').length) $('#textfield2_display').val(special_shape_fee > 0 ? formatMoney(special_shape_fee) : '0');
    if ($('#MoldCharge').length) $('#MoldCharge').val(special_shape_fee > 0 ? formatMoney(special_shape_fee) : '0');
    if ($('#textfield13').length) document.getElementById('textfield13').value = formatMoney(print_charge);
    if ($('#textfield13_2').length) document.getElementById('textfield13_2').value = formatMoney(coating_charge * qty);
    if ($('#textfield3').length) document.getElementById('textfield3').value = formatMoney(proto_charge);
    if ($('#textfield4').length) document.getElementById('textfield4').value = formatMoney(trace_charge);
    if ($('#textfield_dis').length) document.getElementById('textfield_dis').value = formatMoney(DisPrice);
    if ($('#MaterialCharge').length) document.getElementById('MaterialCharge').value = formatMoney(MaterialCharge * qty);
    if ($('#textfield9').length) document.getElementById('textfield9').value = formatMoney(TextField9Value);
    if ($('#textfield11').length) document.getElementById('textfield11').value = formatMoney(total);
    $('.prd_total').text(formatMoney(total));

    // Update hidden unit_price field used by add-order.php / quotation_add_item_handler.php
    $('input[name="unit_price"]').val(Math.round(order_pcs));

    // Trigger services table refresh if present
    if (typeof appendServicesToTable === 'function') appendServicesToTable();
}

// Alias so tryRecalc() can call this
window.calc = setToInput;
