/**
 * calculate_acrylic_admin.js
 * Admin-side pricing calculator for アクリルキーホルダー (Acrylic Keychain).
 *
 * Mirrors products/acrylic/js/calculate.js exactly:
 *   - Same price tables (prd_10d_1side, prd_10d_2side, prd_6d_1side, prd_6d_2side)
 *   - Same paperPrice_obj
 *   - Same cal_c() logic and field names
 * Adapted for admin:
 *   - Quantity field is #no_of_order (name="numberOf"), not name="qty"
 *   - Results written to hidden form fields (StrapPrice, PaperPrice, etc.)
 *   - parts_obj is set via selectAcrylicPart() from data-price/data-name on radio
 */

// ─── Shared state (mirrors calculate.js globals) ────────────────────────────
var parts_obj_admin = null;   // set by selectAcrylicPart()
var vat = 10;
var unit_price = 0;
var partPrice = 0;
var paperPrice = 0;
var sub_total = 0;
var disPrice = 0;
var total = 0;

// ─── get_price(): same switch logic as calculate.js ─────────────────────────
// function get_price_admin() {
//     var delivery = $('input[name="acy_delivery"]:checked').val();
//     var screen = $('input[name="acy_screen"]:checked').val();
//     var size = $('input[name="acy_size"]:checked').val();
//     var key = 'size' + size;

//     if (delivery === '10営業日') {
//         return screen === '片面印刷' ? prd_10d_1side[key] : prd_10d_2side[key];
//     } else {
//         return screen === '片面印刷' ? prd_6d_1side[key] : prd_6d_2side[key];
//     }
// }

function get_price_admin() {
    var delivery = $('input[name="acy_delivery"]:checked').val() || '10営業日';
    var screen = $('input[name="acy_screen"]:checked').val() || '片面印刷';
    var size = $('input[name="acy_size"]:checked').val() || '50';

    var d_key = (delivery === '6営業日') ? '6d' : '10d';
    var p_key = (screen === '両面印刷') ? '2side' : '1side';
    var dbKey = 'acrylickeyholder_' + d_key + '_' + p_key + '_' + size;

    if (window.numUnitPrice) {
        if (window.numUnitPrice[dbKey]) {
            return window.numUnitPrice[dbKey];
        }
        var keys = Object.keys(window.numUnitPrice);
        for (var i = 0; i < keys.length; i++) {
            if (keys[i].indexOf(d_key) !== -1 && keys[i].indexOf(p_key) !== -1 && keys[i].endsWith('_' + size)) {
                return window.numUnitPrice[keys[i]];
            }
        }
        if (keys.length > 0) return window.numUnitPrice[keys[0]];
    }
    return [];
}

// ─── cal_c(): mirrors calculate.js cal_c() exactly ──────────────────────────
function cal_c() {
    var prodc_day = $('input[name="acy_delivery"]:checked').val() || '10営業日';
    var ItemSize = $('input[name="acy_size"]:checked').val() || '50';
    var screen = $('input[name="acy_screen"]:checked').val() || '片面印刷';
    var part = $('input[name="acy_part"]:checked').val();
    var paper = $('input[name="acy_paper_select"]:checked').val(); // 'あり' or undefined
    var paper_color = $('input[name="acy_paper"]:checked').val();
    var sample = $('input[name="SendPrototype"]:checked').val()
        || $('input[name="acy_sample"]:checked').val()
        || 'なし';
    var trace = $('input[name="DeFormat"]:checked').val()
        || $('input[name="acy_trace"]:checked').val()
        || 'なし';

    // Admin uses #no_of_order / name="numberOf"
    var qty = parseInt($('#no_of_order').val(), 10) || 0;

    function get_add_price(code) {
        if (window.numUnitAddPrice && window.numUnitAddPrice[code]) {
            var tiers = window.numUnitAddPrice[code];
            if (tiers.length > 0) return Math.floor(tiers[0].price);
        }
        return 0;
    }
    var sample_price = 0;
    var trace_price = 0;

    // ── Part price (mirrors calculate.js lines 652-662) ──────────────────
    if (part !== undefined && part !== '') {
        if (parts_obj_admin && parts_obj_admin.part_price !== undefined) {
            partPrice = Math.floor(parts_obj_admin.part_price);
        } else {
            var partKey = part;
            var tmp_part = window.numUnitOptionPrice ? window.numUnitOptionPrice[partKey] : [];
            if (!tmp_part || tmp_part.length === 0) {
                tmp_part = window.numUnitOptionPrice ? window.numUnitOptionPrice[partKey + '_0'] : [];
            }
            if (tmp_part && tmp_part.length > 0) {
                partPrice = Math.floor(tmp_part[0].price);
            } else {
                partPrice = 0;
            }
        }
        $('#prd_part').text(part);
    } else {
        partPrice = 0;
        $('#prd_part').text('なし');
    }

    // ── Paper price (mirrors calculate.js lines 664-707) ─────────────────
    if (paper !== undefined && paper === 'あり') {
        if (paper_color !== undefined) {
            var tmp_pp;
            var dbPaperKey = 'Paper Temp';
            if (paper_color === 'paper-patternA-1') dbPaperKey = 'Paper 1 Side';
            else if (paper_color === 'paper-patternA-2') dbPaperKey = 'Paper 2 Side';

            tmp_pp = window.numUnitOptionPrice ? (window.numUnitOptionPrice[dbPaperKey] || window.numUnitOptionPrice[dbPaperKey + '_0']) : [];
            if (!tmp_pp || tmp_pp.length === 0) {
                tmp_pp = window.numUnitOptionPrice ? (window.numUnitOptionPrice['Paper 1 Side'] || window.numUnitOptionPrice['Paper 1 Side_0']) : [];
            }
            for (var i = 0, iMax = tmp_pp.length; i < iMax; i++) {
                if (qty >= parseInt(tmp_pp[i].num)) {
                    paperPrice = Math.floor(tmp_pp[i].price);
                    continue;
                }
                break;
            }
            $('#prd_paper').text(paper_color);
        } else {
            // paper selected but no color chosen yet
            paperPrice = 0;
        }
    } else {
        paperPrice = 0;
        $('#prd_paper').text('なし');
    }

    // ── Summary display (mirrors calculate.js lines 709-720) ─────────────
    $('#prd_delivery').text(prodc_day);
    $('#prd_size').text(ItemSize + 'mm × ' + ItemSize + 'mm');
    $('#prd_screen').text(screen);
    $('#prd_qty').text(qty);

    // ── Unit price (mirrors calculate.js lines 722-729) ──────────────────
    var price_tiers = get_price_admin();
    if (price_tiers && qty > 0) {
        for (var j = 0, jMax = price_tiers.length; j < jMax; j++) {
            if (qty >= parseInt(price_tiers[j].num)) {
                unit_price = Math.floor(price_tiers[j].price);
                continue;
            }
            break;
        }
    } else {
        unit_price = 0;
    }

    // ── Sub-total (mirrors calculate.js line 732) ─────────────────────────
    sub_total = Math.floor((unit_price * qty) + sample_price + trace_price + (partPrice * qty) + (paperPrice * qty));

    disPrice = 0;  // no campaign discount for admin
    total = Math.floor(sub_total - disPrice);

    // ── Write to admin hidden form fields ─────────────────────────────────
    // These names are read by add-order.php / quotation_add_item_handler.php
    var $up = document.getElementById('unit_price'); if ($up) $up.value = (qty > 0 ? unit_price : 0);
    var $sp = document.getElementById('textfield7'); if ($sp) $sp.value = (unit_price * qty);   // StrapPrice
    var $pp = document.getElementById('textfield7_2'); if ($pp) $pp.value = (paperPrice * qty);   // PaperPrice
    var $psh = document.getElementById('acy_prototype_price') || document.getElementById('textfield3');
    if ($psh) $psh.value = sample_price;   // ProShipping
    var $pshDisp = document.getElementById('textfield3');
    if ($pshDisp && $pshDisp !== $psh) $pshDisp.value = sample_price;
    var $ptrc = document.getElementById('acy_trace_price') || document.getElementById('textfield4');
    if ($ptrc) $ptrc.value = trace_price;   // TraceCharge
    var $ptrcDisp = document.getElementById('textfield4');
    if ($ptrcDisp && $ptrcDisp !== $ptrc) $ptrcDisp.value = trace_price;
    var $ptp = document.getElementById('acy_part_total'); if ($ptp) $ptp.value = (partPrice * qty);   // PartPrice
    var $bt = document.getElementById('textfield9'); if ($bt) $bt.value = sub_total;             // BeforeTax
    var $dis = document.getElementById('textfield_dis'); if ($dis) $dis.value = disPrice;              // discount
    var $gt = document.getElementById('textfield11'); if ($gt) $gt.value = total;                 // grandTotal
    var $pf11 = document.getElementById('pricefield11'); if ($pf11) $pf11.value = sub_total;
    var $pf13 = document.getElementById('pricefield13'); if ($pf13) $pf13.value = total;

    // ── Mirror to display (read-only) inputs ──────────────────────────────
    var $sd = document.getElementById('strapPrice_disp'); if ($sd) $sd.value = (unit_price * qty);
    var $ptd = document.getElementById('partPrice_disp'); if ($ptd) $ptd.value = (partPrice * qty);
    var $pd = document.getElementById('paperPrice_disp'); if ($pd) $pd.value = (paperPrice * qty);
    var $bd = document.getElementById('beforeTax_disp'); if ($bd) $bd.value = sub_total;
    var $gd = document.getElementById('grandTotalDisp'); if ($gd) $gd.value = total;

    // ── Running total badge ───────────────────────────────────────────────
    $('.prd_total').text(total.toLocaleString('ja'));
}

// Expose as window.calcAcrylic so the PHP page inline script can call it
window.calcAcrylic = cal_c;

// ─── Part selection (called onclick from each attachment radio) ──────────────
window.selectAcrylicPart = function (el) {
    var price = parseFloat($(el).data('price') || 0);
    var name = $(el).data('name') || '';
    // Store as parts_obj_admin (mirrors parts_obj in calculate.js)
    parts_obj_admin = {
        part_price: price,
        part_name: name,
        part_pic: $(el).data('pic') || ''
    };
    $('#acy_part_price_hidden').val(price);
    $('#prd_part').text(name);
    cal_c();
};

// ─── Auto-run on DOM ready ────────────────────────────────────────────────────
$(document).ready(function () {
    // Restore parts_obj_admin if a part is already checked (edit mode)
    var checkedPart = $('input[name="acy_part"]:checked');
    if (checkedPart.length) {
        parts_obj_admin = {
            part_price: parseFloat(checkedPart.data('price') || 0),
            part_name: checkedPart.data('name') || '',
            part_pic: checkedPart.data('pic') || ''
        };
        $('#acy_part_price_hidden').val(parts_obj_admin.part_price);
    }
    cal_c();
});
