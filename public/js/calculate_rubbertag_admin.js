/* Product-local helpers for create-order-rubbertag.php. */
function rbTagReadPrice(pool, key, qty) {
    if (!pool || !Object.prototype.hasOwnProperty.call(pool, key) || !Array.isArray(pool[key])) return null;
    var tiers = pool[key].slice().sort(function (a, b) { return Number(a.num || 0) - Number(b.num || 0); });
    if (!tiers.length) return null;
    var selected = tiers[0];
    tiers.forEach(function (tier) { if (Number(qty) >= Number(tier.num || 0)) selected = tier; });
    var price = Number(selected.price);
    return isFinite(price) ? Math.floor(price) : null;
}

function rbTagAddPrice(code, qty) {
    var pool = window.numUnitAddPrice;
    if (!pool) return 0;
    var requested = String(code || '');
    var normalized = requested
        .replace(/^rubber_/, '')
        .replace(/^anti_stain$/, 'antistain')
        .replace(/^data_trace$/, 'datatrace')
        .replace(/^color_variation$/, 'colorvariation')
        .replace(/^back_printing_/, 'backprinting_');
    var service = normalized.replace(/^rubbertag_/, '');
    var candidates = [];
    function add(key) { if (key && candidates.indexOf(key) === -1) candidates.push(key); }
    add(requested); add(normalized); add('rubbertag_' + service); add(service);
    if (service === 'prototype') add('rubber_prototype');
    if (service === 'datatrace') add('rubber_data_trace');
    if (service === 'special_material') add('rubber_special_material');
    for (var i = 0; i < candidates.length; i++) {
        var price = rbTagReadPrice(pool, candidates[i], qty || 1);
        if (price !== null) return price;
    }
    return 0;
}

function rbTagManualTotal() {
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

function calcRubberTag() {
    var itemPcs = $('input[name="ItemPCS"]:checked').val() || 'スタンダード';
    var material = $('input[name="ItemMaterial"]:checked').val() || '特殊素材なし';
    var coating = $('input[name="coating"]:checked').val() || '汚れ防止加工なし';
    var designVariation = $('input[name="ItemDesignVariation"]:checked').val() || '1種類';
    var paperSelect = $('input[name="paper_select"]:checked').val() || 'なし';
    var paperColor = $('input[name="paper"]:checked').val() || '';
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

    var priceCode = 'rubbertag_standard';
    if (itemPcs === 'プレミアム') {
        priceCode = 'rubbertag_premium';
    }

    var priceArr = window.numUnitPrice ? (window.numUnitPrice[priceCode] || []) : [];

    var minQty = 100;
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

    if (itemPcs === 'スタンダード（スピード7営業日発送）') {
        // Speed has a dedicated product table in current data. Keep the
        // standard tiers as a legacy fallback so an older database never
        // renders a zero product price.
        var speedPriceArr = window.numUnitPrice ? (window.numUnitPrice.rubbertag_standard_speed || []) : [];
        if (speedPriceArr.length > 0) {
            priceCode = 'rubbertag_standard_speed';
            priceArr = speedPriceArr;
            unit_price = 0;
            for (var j = 0; j < priceArr.length; j++) {
                if (qty >= priceArr[j].num) {
                    unit_price = priceArr[j].price;
                } else {
                    break;
                }
            }
        }
    }

    var base_total = qty * unit_price;


    var paper_price = 0;
    if (paperSelect === 'あり' && paperColor) {
        var dbPaperKey = 'Paper Temp';
        if (paperColor === 'paper-patternA-1') {
            dbPaperKey = 'Paper 1 Side';
        } else if (paperColor === 'paper-patternA-2') {
            dbPaperKey = 'Paper 2 Side';
        }
        var tmp_pp = window.numUnitOptionPrice ? (window.numUnitOptionPrice[dbPaperKey] || window.numUnitOptionPrice[dbPaperKey + '_0']) : [];
        if (!tmp_pp || tmp_pp.length === 0) {
            tmp_pp = window.numUnitOptionPrice ? (window.numUnitOptionPrice['Paper 1 Side'] || window.numUnitOptionPrice['Paper 1 Side_0']) : [];
        }
        for (var i = 0; i < tmp_pp.length; i++) {
            if (qty >= tmp_pp[i].num) {
                paper_price = tmp_pp[i].price;
            } else {
                break;
            }
        }
    }
    var paper_total = qty * paper_price;

    function get_add_price(code) {
        return rbTagAddPrice(code, 1);
    }

    function get_add_price_by_qty(code, current_qty) {
        return rbTagAddPrice(code, current_qty);
    }

    var sample_price = 0;
    if (sample === 'あり') {
        sample_price = get_add_price('rubbertag_prototype') || get_add_price('rubber_prototype') || get_add_price('prototype');
        if (itemPcs === 'プレミアム') {
            sample_price = 0;
        }
    }

    var trace_price = 0;
    if (trace === 'あり') {
        trace_price = get_add_price('rubbertag_datatrace') || get_add_price('rubber_data_trace') || get_add_price('data_trace');
        if (itemPcs === 'プレミアム') {
            trace_price = 0;
        }
    }

    var material_total = 0;
    var materialKey = '';
    switch (material) {
        case '特殊素材：蓄光（オレンジ色）': materialKey = 'rubbertag_phosphorescent_orange'; break;
        case '特殊素材：蓄光（緑色）': materialKey = 'rubbertag_phosphorescent_green'; break;
        case '特殊素材：蛍光': materialKey = 'rubbertag_fluorescent'; break;
        case '特殊素材：ラメ': materialKey = 'rubbertag_glitter'; break;
        case '特殊素材：金色': materialKey = 'rubbertag_gold'; break;
        case '特殊素材：銀色': materialKey = 'rubbertag_silver'; break;
    }
    if (materialKey !== '') {
        var materialPrice = get_add_price(materialKey) || get_add_price('rubber_special_material') || get_add_price('special_material') || get_add_price('item_material_fee');
        material_total = qty * materialPrice;
    }

    var coating_total = 0;
    if (coating === '汚れ防止加工あり') {
        var coatingPrice = get_add_price('rubbertag_antistain') || get_add_price('anti_stain') || get_add_price('coating') || get_add_price('rubber_coating');
        coating_total = qty * coatingPrice;
    }

    var design_charge = 0;
    var designNum = parseInt(designVariation) || 1;
    if (designNum > 1) {
        var variationUnitPrice = get_add_price('rubbertag_colorvariation') || get_add_price('rubber_color_variation') || get_add_price('color_variation');
        design_charge = variationUnitPrice * (designNum - 1);
    }

    var manual_service_total = rbTagManualTotal();
    var grand_total = base_total + paper_total + sample_price + trace_price + material_total + coating_total + design_charge + manual_service_total;

    $('.prd_total').text(grand_total.toLocaleString());
    $('input[name="unit_price"]').val(unit_price);
    $('input[name="StrapPrice"]').val(base_total);
    $('input[name="PaperPrice"]').val(paper_total);
    $('input[name="PartPrice"]').val(0);
    $('input[name="ProShipping"]').val(sample_price);
    $('input[name="TraceCharge"]').val(trace_price);
    $('input[name="MaterialCharge"]').val(material_total);
    $('input[name="coatingPrice"]').val(coating_total);
    $('input[name="DesignsCharge"]').val(design_charge);
    $('input[name="ManualServiceTotal"]').val(manual_service_total);
    $('input[name="BeforeTax"]').val(grand_total);
    $('input[name="grandTotal"]').val(grand_total);

    $('#strapPrice_disp').val(base_total.toLocaleString("en"));
    $('#paperPrice_disp').val(paper_total.toLocaleString("en"));
    $('#textfield3').val((sample_price).toLocaleString("en"));
    $('#textfield4').val((trace_price).toLocaleString("en"));
    $('#MaterialCharge_disp').val(material_total.toLocaleString("en"));
    $('#coatingPrice_disp').val(coating_total.toLocaleString("en"));
    $('#DesignsCharge_disp').val(design_charge.toLocaleString("en"));
    $('#beforeTax_disp').val(grand_total.toLocaleString("en"));
    $('#discountDisp').val((0).toLocaleString("en"));
    $('#grandTotalDisp').val(grand_total.toLocaleString("en"));

    $('#prd_ItemPCS').text(itemPcs);
    $('#prd_ItemMaterial').text(material);
    $('#prd_coating').text(coating);
    $('#prd_ItemDesign').text(designVariation);
    $('#prd_qty').text(qty);
}

$(document).ready(function () {
    calcRubberTag();
    $('input, select').on('change keyup', calcRubberTag);
});
