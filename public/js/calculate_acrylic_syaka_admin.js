/**
 * calculate_acrylic_syaka_admin.js
 * Admin-side pricing calculator for シャカシャカアクリルキーホルダー (Shakashaka Acrylic Keyholder).
 *
 * Sourced dynamically from database pricing:
 *   - Fetches rates dynamically from window.numUnitPrice['shakashaka_acrylickeyholder']
 *   - Same paperPrice_obj and calculations as customer-side calculate-syaka-acrylic.js
 *   - Results written to hidden form fields (StrapPrice, PaperPrice, etc.)
 */

// Paper price table (copied 1:1 from calculate-syaka-acrylic.js)

// Shared state
var parts_obj_admin = null;   // set by selectAcrylicPart()
var vat = 10;
var unit_price = 0;
var partPrice = 0;
var paperPrice = 0;
var sub_total = 0;
var disPrice = 0;
var total = 0;

// Resolve price array dynamically from DB pricing map
function get_price_admin() {
    if (window.numUnitPrice && window.numUnitPrice['shakashaka_acrylickeyholder']) {
        return window.numUnitPrice['shakashaka_acrylickeyholder'];
    }
    return [];
}

// Pricing calculation logic
function cal_c() {
    var prodc_day = $('input[name="acy_delivery"]:checked').val() || '10営業日';
    var ItemSize = '70mm × 70mm'; // Fixed size for Shakashaka keyholder
    var color = $('input[name="acy_color"]:checked').val() || 'ゴールド';
    var part = $('input[name="acy_part"]:checked').val();
    var paper = $('input[name="acy_paper_select"]:checked').val(); // 'あり' or undefined
    var paper_color = $('input[name="acy_paper"]:checked').val();

    // Admin uses #no_of_order (name="numberOf")
    var qty = parseInt($('#no_of_order').val(), 10) || 0;
    var sample = $('input[name="SendPrototype"]:checked').val() || 'なし';
    var trace = $('input[name="DeFormat"]:checked').val() || 'なし';

    function get_add_price(code) {
        if (window.numUnitAddPrice && window.numUnitAddPrice[code]) {
            var tiers = window.numUnitAddPrice[code];
            if (tiers.length > 0) return Math.floor(tiers[0].price);
        }
        return 0;
    }

    var sample_price = 0; // Free for acrylic products
    var trace_price = 0;  // Free for acrylic products

    // Part price calculation
    if (part !== undefined && part !== '') {
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
        $('#prd_part').text(part);
    } else {
        partPrice = 0;
        $('#prd_part').text('なし');
    }

    // Paper price calculation
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
            paperPrice = 0;
        }
    } else {
        paperPrice = 0;
        $('#prd_paper').text('なし');
    }

    // Summary display
    $('#prd_delivery').text(prodc_day);
    $('#prd_size').text(ItemSize);
    $('#prd_color').text(color);
    $('#prd_qty').text(qty);

    // Unit price calculation
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

    // Subtotal
    sub_total = Math.floor((unit_price * qty) + sample_price + trace_price + (partPrice * qty) + (paperPrice * qty));
    disPrice = 0; // no campaign discount for admin
    total = Math.floor(sub_total - disPrice);

    // Write to hidden form fields
    var $up = document.getElementById('unit_price'); if ($up) $up.value = (qty > 0 ? unit_price : 0);
    var $sp = document.getElementById('textfield7'); if ($sp) $sp.value = (unit_price * qty);   // StrapPrice
    var $pp = document.getElementById('textfield7_2'); if ($pp) $pp.value = (paperPrice * qty);   // PaperPrice
    var $psh = document.getElementById('acy_prototype_price'); if ($psh) $psh.value = sample_price;   // ProShipping
    var $pshDisp = document.getElementById('textfield3'); if ($pshDisp) $pshDisp.value = sample_price;
    var $ptrc = document.getElementById('acy_trace_price'); if ($ptrc) $ptrc.value = trace_price;   // TraceCharge
    var $ptrcDisp = document.getElementById('textfield4'); if ($ptrcDisp) $ptrcDisp.value = trace_price;
    var $ptp = document.getElementById('acy_part_total'); if ($ptp) $ptp.value = (partPrice * qty);   // PartPrice
    var $bt = document.getElementById('textfield9'); if ($bt) $bt.value = sub_total;             // BeforeTax
    var $dis = document.getElementById('textfield_dis'); if ($dis) $dis.value = disPrice;              // discount
    var $gt = document.getElementById('textfield11'); if ($gt) $gt.value = total;                 // grandTotal
    var $pf11 = document.getElementById('pricefield11'); if ($pf11) $pf11.value = sub_total;
    var $pf13 = document.getElementById('pricefield13'); if ($pf13) $pf13.value = total;

    // Display fields
    var $sd = document.getElementById('strapPrice_disp'); if ($sd) $sd.value = (unit_price * qty);
    var $ptd = document.getElementById('partPrice_disp'); if ($ptd) $ptd.value = (partPrice * qty);
    var $pd = document.getElementById('paperPrice_disp'); if ($pd) $pd.value = (paperPrice * qty);
    var $bd = document.getElementById('beforeTax_disp'); if ($bd) $bd.value = sub_total;
    var $gd = document.getElementById('grandTotalDisp'); if ($gd) $gd.value = total;

    // Total badge
    $('.prd_total').text(total.toLocaleString('ja'));
}

window.calcAcrylic = cal_c;

// Part selection handler
window.selectAcrylicPart = function (el) {
    var price = parseFloat($(el).data('price') || 0);
    var name = $(el).data('name') || '';
    parts_obj_admin = {
        part_price: price,
        part_name: name,
        part_pic: $(el).data('pic') || ''
    };
    $('#acy_part_price_hidden').val(price);
    $('#prd_part').text(name);
    cal_c();
};

$(document).ready(function () {
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
