/**
 * calculate_acrylic_syaka_admin.js
 * Admin-side pricing calculator for シャカシャカアクリルキーホルダー (Shakashaka Acrylic Keyholder).
 *
 * Sourced dynamically from database pricing:
 *   - Fetches rates dynamically from window.numUnitPrice['acryliccoaster']
 *   - Same paperPrice_obj and calculations as customer-side calculate-syaka-acrylic.js
 *   - Results written to hidden form fields (StrapPrice, PaperPrice, etc.)
 */

// Paper price table (copied 1:1 from calculate-syaka-acrylic.js)

// Shared state
var vat = 10;
var unit_price = 0;
var paperPrice = 0;
var sub_total = 0;
var disPrice = 0;
var total = 0;

// Resolve price array dynamically from DB pricing map
function get_price_admin() {
    var delivery = $('input[name="acy_delivery"]:checked').val() || '10営業日';
    var d_key = (delivery === '6営業日') ? '6d' : '10d';
    var dbKey = 'acryliccoaster_' + d_key + '_90';

    if (window.numUnitPrice) {
        if (window.numUnitPrice[dbKey]) {
            return window.numUnitPrice[dbKey];
        }
        var keys = Object.keys(window.numUnitPrice);
        for (var i = 0; i < keys.length; i++) {
            if (keys[i].indexOf(d_key) !== -1) return window.numUnitPrice[keys[i]];
        }
        if (keys.length > 0) return window.numUnitPrice[keys[0]];
    }
    return [];
}

// Pricing calculation logic
function cal_c() {
    var prodc_day = $('input[name="acy_delivery"]:checked').val() || '10営業日';
    var ItemSize = '90mm x 90mm'; // Fixed size for Shakashaka keyholder

    var part = $('input[name="acy_part"]:checked').val();
    var paper = $('input[name="acy_paper_select"]:checked').val(); // 'あり' or undefined
    var paper_color = $('input[name="acy_paper"]:checked').val();

    // Admin uses #no_of_order (name="qty")
    var qty = parseInt($('#no_of_order').val(), 10) || 0;
    if (qty > 1000) {
        qty = 1000;
        $('#no_of_order').val(qty);
    }
    var sample = $('input[name="SendPrototype"]:checked').val()
        || $('input[name="acy_sample"]:checked').val()
        || 'なし';
    var trace = $('input[name="DeFormat"]:checked').val()
        || $('input[name="acy_trace"]:checked').val()
        || 'なし';

    function get_add_price(code) {
        if (window.numUnitAddPrice && window.numUnitAddPrice[code]) {
            var tiers = window.numUnitAddPrice[code];
            if (tiers.length > 0) return Math.floor(tiers[0].price);
        }
        return 0;
    }

    var sample_price = 0; // Free for acrylic products
    var trace_price = 0;  // Free for acrylic products

    // Paper price calculation
    if (paper !== undefined && paper === 'あり') {
        if (paper_color !== undefined) {
            var tmp_pp;
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
    sub_total = Math.floor((unit_price * qty) + sample_price + trace_price + (paperPrice * qty));
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
    var $bt = document.getElementById('textfield9'); if ($bt) $bt.value = sub_total;             // BeforeTax
    var $dis = document.getElementById('textfield_dis'); if ($dis) $dis.value = disPrice;              // discount
    var $gt = document.getElementById('textfield11'); if ($gt) $gt.value = total;                 // grandTotal
    var $pf11 = document.getElementById('pricefield11'); if ($pf11) $pf11.value = sub_total;
    var $pf13 = document.getElementById('pricefield13'); if ($pf13) $pf13.value = total;

    // Display fields
    var $sd = document.getElementById('strapPrice_disp'); if ($sd) $sd.value = (unit_price * qty).toLocaleString("en");
    var $pd = document.getElementById('paperPrice_disp'); if ($pd) $pd.value = (paperPrice * qty).toLocaleString("en");
    var $bd = document.getElementById('beforeTax_disp'); if ($bd) $bd.value = sub_total.toLocaleString("en");
    var $dd = document.getElementById('discountDisp'); if ($dd) $dd.value = disPrice.toLocaleString("en");
    var $gd = document.getElementById('grandTotalDisp'); if ($gd) $gd.value = total.toLocaleString("en");

    // Total badge
    $('.prd_total').text(total.toLocaleString('ja'));
}

window.calcAcrylic = cal_c;

$(document).ready(function () {
    cal_c();
});
