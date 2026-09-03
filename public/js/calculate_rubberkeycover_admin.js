/* Product-local helpers for create-order-rubberkeycover.php. */
function rbKeyCoverReadPrice(pool, key, qty) {
    if (!pool || !Object.prototype.hasOwnProperty.call(pool, key) || !Array.isArray(pool[key])) return null;
    var tiers = pool[key].slice().sort(function (a, b) { return Number(a.num || 0) - Number(b.num || 0); });
    if (!tiers.length) return null;
    var selected = tiers[0];
    tiers.forEach(function (tier) { if (Number(qty) >= Number(tier.num || 0)) selected = tier; });
    var price = Number(selected.price);
    return isFinite(price) ? Math.floor(price) : null;
}

function rbKeyCoverAddPrice(code, qty) {
    var pool = window.numUnitAddPrice;
    if (!pool) return 0;
    var requested = String(code || '');
    var normalized = requested
        .replace(/^rubber_/, '')
        .replace(/^anti_stain$/, 'antistain')
        .replace(/^data_trace$/, 'datatrace')
        .replace(/^color_variation$/, 'colorvariation')
        .replace(/^back_printing_/, 'backprinting_');
    var service = normalized.replace(/^rubberkeycover_/, '');
    var candidates = [];
    function add(key) { if (key && candidates.indexOf(key) === -1) candidates.push(key); }
    add(requested); add(normalized); add('rubberkeycover_' + service); add(service);
    if (service === 'prototype') add('rubber_prototype');
    if (service === 'datatrace') add('rubber_data_trace');
    if (service === 'special_material') add('rubber_special_material');
    for (var i = 0; i < candidates.length; i++) {
        var price = rbKeyCoverReadPrice(pool, candidates[i], qty || 1);
        if (price !== null) return price;
    }
    return 0;
}

function rbKeyCoverManualTotal() {
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

function calcRubberKeyCover() {
    var itemPcs = $('input[name="ItemPCS"]:checked').val() || 'スタンダード';
    var material = $('input[name="ItemMaterial"]:checked').val() || '特殊素材なし';
    var silkPrint = $('input[name="silk_print"]:checked').val() || '印刷なし';
    var coating = $('input[name="coating"]:checked').val() || '汚れ防止加工なし';
    var designVariation = $('input[name="ItemDesignVariation"]:checked').val() || '1種類';
    var paperSelect = $('input[name="paper_select"]:checked').val() || 'なし';
    var paperColor = $('input[name="paper"]:checked').val() || '';
    var packing = $('input[name="packing"]:checked').val() || 'OPP袋';
    var sample = $('input[name="SendPrototype"]:checked').val() || 'なし';
    var trace = $('input[name="DeFormat"]:checked').val() || 'なし';
    var part = $('input[name="part"]:checked').val() || '';
    var partDataPrice = parseFloat($('input[name="part"]:checked').attr('data-price')) || 0;

    var qtyStr = $('input[name="numberOf"]').val() || '0';
    var qty = parseInt(qtyStr, 10);
    if (isNaN(qty) || qty <= 0) {
        qty = 0;
    }

    var vat = 10;

    $('#error_message').text('');
    $('.ord-btn').prop('disabled', false);

    var priceCode = 'rubberkeycover_standard';
    if (itemPcs === 'プレミアム') {
        priceCode = 'rubberkeycover_premium';
    } else if (itemPcs === 'スタンダード（スピード7営業日発送）') {
        priceCode = 'rubberkeycover_standard_speed';
    }

    var priceArr = window.numUnitPrice ? (window.numUnitPrice[priceCode] || []) : [];
    var hasDedicatedSpeedPrice = itemPcs === 'スタンダード（スピード7営業日発送）' && priceArr.length > 0;

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

    if (itemPcs === 'スタンダード（スピード7営業日発送）' && !hasDedicatedSpeedPrice) {
        unit_price += get_add_price_by_qty('speed_shipping_rubber3mm', qty);
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
        if (tmp_pp) {
            for (var i = 0; i < tmp_pp.length; i++) {
                if (qty >= tmp_pp[i].num) {
                    paper_price = tmp_pp[i].price;
                } else {
                    break;
                }
            }
        }
    }
    var paper_total = qty * paper_price;

    var part_price = 0;
    if (part) {
        var partKey = part;
        var tmp_part = window.numUnitOptionPrice ? window.numUnitOptionPrice[partKey] : [];
        if (tmp_part && tmp_part.length > 0) {
            for (var i = 0; i < tmp_part.length; i++) {
                if (qty >= tmp_part[i].num) {
                    part_price = Math.floor(tmp_part[i].price);
                } else {
                    break;
                }
            }
        } else {
            part_price = partDataPrice;
        }
    }
    var part_total = qty * part_price;

    function get_add_price(code) {
        return rbKeyCoverAddPrice(code, 1);
    }

    function get_add_price_by_qty(code, current_qty) {
        return rbKeyCoverAddPrice(code, current_qty);
    }

    var sample_price = 0;
    if (sample === 'あり') {
        sample_price = get_add_price('rubberkeycover_prototype') || get_add_price('rubber_prototype') || get_add_price('prototype');
        if (itemPcs === 'プレミアム') {
            sample_price = 0;
        }
    }

    var trace_price = 0;
    if (trace === 'あり') {
        trace_price = get_add_price('rubberkeycover_datatrace') || get_add_price('rubber_data_trace') || get_add_price('data_trace');
        if (itemPcs === 'プレミアム') {
            trace_price = 0;
        }
    }

    var material_total = 0;
    var materialKey = '';
    switch (material) {
        case '特殊素材：蓄光（オレンジ色）': materialKey = 'rubberkeycover_phosphorescent_orange'; break;
        case '特殊素材：蓄光（緑色）': materialKey = 'rubberkeycover_phosphorescent_green'; break;
        case '特殊素材：蛍光': materialKey = 'rubberkeycover_fluorescent'; break;
        case '特殊素材：ラメ': materialKey = 'rubberkeycover_glitter'; break;
        case '特殊素材：金色': materialKey = 'rubberkeycover_gold'; break;
        case '特殊素材：銀色': materialKey = 'rubberkeycover_silver'; break;
    }
    if (materialKey !== '') {
        var materialPrice = get_add_price(materialKey) || get_add_price('rubber_special_material') || get_add_price('special_material');
        material_total = qty * materialPrice;
    }

    var coating_total = 0;
    if (coating === '汚れ防止加工あり') {
        var coatingPrice = get_add_price('rubberkeycover_antistain') || get_add_price('anti_stain') || get_add_price('coating') || get_add_price('rubber_coating');
        coating_total = qty * coatingPrice;
    }

    var silk_total = 0;
    if (silkPrint === '単色（シルク）印刷') {
        var singlePrice = get_add_price('rubberkeycover_backprinting_single') || get_add_price('back_printing_single');
        var platePrice = get_add_price('silk_plate') || 0; // Plate fee
        silk_total = qty * singlePrice + platePrice;
    } else if (silkPrint === 'フルカラー印刷') {
        var fullPrice = get_add_price('rubberkeycover_backprinting_full') || get_add_price('back_printing_full');
        silk_total = qty * fullPrice;
    }

    var packing_total = 0;
    if (packing === '台紙＋OPP袋個別包装' && paperSelect === 'あり') {
        packing_total = 0;
        var pkg = window.packaging_fee ? window.packaging_fee[packing] : [];
        if (pkg && pkg.length > 0) {
            packing_total = qty * Math.floor(pkg[0].price);
        }
    }

    var design_charge = 0;
    var variationUnitPrice = get_add_price('rubberkeycover_colorvariation') || get_add_price('color_variation') || get_add_price('rubber_color_variation') || 3000;
    if (designVariation === '2種類') design_charge = variationUnitPrice;
    else if (designVariation === '3種類') design_charge = variationUnitPrice * 2;
    else if (designVariation === '4種類') design_charge = variationUnitPrice * 3;

    var manual_service_total = rbKeyCoverManualTotal();
    var grand_total = base_total + paper_total + part_total + sample_price + trace_price + material_total + coating_total + silk_total + design_charge + packing_total + manual_service_total;

    $('.prd_total').text(grand_total.toLocaleString());
    $('input[name="unit_price"]').val(unit_price);
    $('input[name="StrapPrice"]').val(base_total);
    $('input[name="PaperPrice"]').val(paper_total);
    $('input[name="PartPrice"]').val(part_total);
    $('input[name="printingPrice"]').val(packing_total);
    $('input[name="SilkPrint"]').val(silk_total);
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
    $('#partPrice_disp').val(part_total.toLocaleString("en"));
    if ($('#textfield7_1').length) {
        $('#textfield7_1').val(part_total.toLocaleString("en"));
    }
    $('#silkPrice_disp').val(silk_total.toLocaleString("en"));
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
    $('#prd_silk_print').text(silkPrint);
    $('#prd_coating').text(coating);
    $('#prd_ItemDesign').text(designVariation);
    $('#prd_part').text(part);
    $('#prd_qty').text(qty);
}

function setToInput() {
    calcRubberKeyCover();
}

function getPartData(partName) {
    if (partName) setToInput();
}

function check_val(direction) {
    if (direction === 'back' || direction === 'step1' || direction === 'step2' || direction === 'step3') return true;
    var qty = parseInt($('#no_of_order').val(), 10);
    if (!isFinite(qty) || qty < 1 || qty > 50000) {
        $('#err_numberOf_mess').html('<font color="red">本数は1本以上、50000本以内で入力して下さい。</font>').show();
        return false;
    }
    $('#err_numberOf_mess').empty().hide();
    return true;
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

window.setToInput = setToInput;
window.calc = setToInput;
window.getPartData = getPartData;
window.check_val = check_val;
window.valid_chk_btn = valid_chk_btn;
window.type_special_disabled = type_special_disabled;
window.click_typeorder_enabled = click_typeorder_enabled;
window.click_typeorder_disabled = click_typeorder_disabled;

$(document).ready(function () {
    type_special_disabled($('#pcs3').is(':checked') ? 't1' : 'f1');
    setToInput();
    $('input, select').on('change keyup', setToInput);
});
