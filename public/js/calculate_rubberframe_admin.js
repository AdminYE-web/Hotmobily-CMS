/* Product-local helpers for create-order-rubberframe.php. */
function rbFrameReadPrice(pool, key, qty) {
    if (!pool || !Object.prototype.hasOwnProperty.call(pool, key) || !Array.isArray(pool[key])) return null;
    var tiers = pool[key].slice().sort(function (a, b) { return Number(a.num || 0) - Number(b.num || 0); });
    if (!tiers.length) return null;
    var selected = tiers[0];
    tiers.forEach(function (tier) { if (Number(qty) >= Number(tier.num || 0)) selected = tier; });
    var price = Number(selected.price);
    return isFinite(price) ? Math.floor(price) : null;
}

function rbFrameAddPrice(code, qty) {
    var pool = window.numUnitAddPrice;
    if (!pool) return 0;
    var requested = String(code || '');
    var normalized = requested
        .replace(/^rubber_/, '')
        .replace(/^anti_stain$/, 'antistain')
        .replace(/^data_trace$/, 'datatrace')
        .replace(/^color_variation$/, 'colorvariation')
        .replace(/^back_printing_/, 'backprinting_');
    var service = normalized.replace(/^rubberphotoframe_/, '');
    var candidates = [];
    function add(key) { if (key && candidates.indexOf(key) === -1) candidates.push(key); }
    add(requested); add(normalized); add('rubberphotoframe_' + service); add(service);
    if (service === 'prototype') add('rubber_prototype');
    if (service === 'datatrace') add('rubber_data_trace');
    for (var i = 0; i < candidates.length; i++) {
        var price = rbFrameReadPrice(pool, candidates[i], qty || 1);
        if (price !== null) return price;
    }
    return 0;
}

function rbFrameManualTotal() {
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

function calcRubberFrame() {
    var packagingLabels = window.rubberFramePackagingLabels || {};
    var giftBoxLabel = packagingLabels.giftBox || '化粧箱　白色無地';
    var packing = $('input[name="packing"]:checked').val() || giftBoxLabel;
    var sample = $('input[name="SendPrototype"]:checked').val() || 'なし';
    var trace = $('input[name="DeFormat"]:checked').val() || 'なし';

    var qtyStr = $('input[name="numberOf"]').val() || '0';
    var qty = parseInt(qtyStr, 10);
    if (isNaN(qty) || qty <= 0) {
        qty = 0;
    }

    var vat = 10;

    $('#error_message').text('');
    $('.ord-btn').prop('disabled', false);

    var priceCode = 'rubberphotoframe';

    var priceArr = window.numUnitPrice ? (window.numUnitPrice[priceCode] || []) : [];

    var minQty = 30;
    if (priceArr.length > 0) {
        minQty = parseInt(priceArr[0].num, 10);
    }

    if (qty < minQty) {
        $('#error_message').text('数量は最低' + minQty + '個からになります。');
        $('.ord-btn').prop('disabled', true);
    } else if (qty > 50000) {
        $('#error_message').text('数量が50000個を超えています。50000個以上の場合は別途ご相談ください。');
        $('.ord-btn').prop('disabled', true);
    }

    var unit_price = 0;
    for (var i = 0; i < priceArr.length; i++) {
        if (qty >= priceArr[i].num) {
            unit_price = priceArr[i].price;
        } else {
            break;
        }
    }

    var base_total = qty * unit_price;

    function get_add_price(code) {
        return rbFrameAddPrice(code, 1);
    }

    var packing_price = 0;
    var isGiftBox = packing === giftBoxLabel
        || packing === '白色無地'
        || packing === '化粧箱 白色無地'
        || packing === '化粧箱　白色無地'
        || (packing.indexOf('化粧箱') !== -1 && packing.indexOf('OPP') === -1);
    if (isGiftBox) {
        var pkg = window.packaging_fee ? (window.packaging_fee[packing] || window.packaging_fee[giftBoxLabel] || window.packaging_fee['化粧箱 白色無地'] || window.packaging_fee['白色無地']) : [];
        if (pkg && pkg.length > 0) {
            packing_price = Math.floor(pkg[0].price);
        }
    }
    var packing_total = qty * packing_price;

    var sample_price = 0;
    if (sample === 'あり') {
        sample_price = get_add_price('rubber_prototype') || get_add_price('prototype');
    }

    var trace_price = 0;
    if (trace === 'あり') {
        trace_price = get_add_price('rubber_data_trace') || get_add_price('data_trace');
    }

    var manual_service_total = rbFrameManualTotal();
    var grand_total = base_total + packing_total + sample_price + trace_price + manual_service_total;

    $('.prd_total').text(grand_total.toLocaleString());
    $('input[name="unit_price"]').val(unit_price);
    $('input[name="StrapPrice"]').val(base_total);
    $('input[name="pricefield_packing"]').val(packing_total);
    $('input[name="PartPrice"]').val(0);
    $('input[name="PaperPrice"]').val(0);
    $('input[name="ProShipping"]').val(sample_price);
    $('input[name="TraceCharge"]').val(trace_price);
    $('input[name="MaterialCharge"]').val(0);
    $('input[name="coatingPrice"]').val(0);
    $('input[name="DesignsCharge"]').val(0);
    $('input[name="ManualServiceTotal"]').val(manual_service_total);
    $('input[name="BeforeTax"]').val(grand_total);
    $('input[name="grandTotal"]').val(grand_total);

    $('#strapPrice_disp').val(base_total.toLocaleString("en"));
    $('#printingPrice_disp').val(packing_total.toLocaleString("en"));
    $('#textfield3').val((sample_price).toLocaleString("en"));
    $('#textfield4').val((trace_price).toLocaleString("en"));
    $('#beforeTax_disp').val(grand_total.toLocaleString("en"));
    $('#discountDisp').val((0).toLocaleString("en"));
    $('#grandTotalDisp').val(grand_total.toLocaleString("en"));

    $('#prd_packing').text(packing);
    $('#prd_qty').text(qty);
    $('#prd_SendPrototype').text(sample);
    $('#prd_DeFormat').text(trace);
}

$(document).ready(function () {
    calcRubberFrame();
    $('input, select').on('change keyup', calcRubberFrame);
});
