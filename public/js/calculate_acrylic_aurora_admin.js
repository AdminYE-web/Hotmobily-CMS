/**
 * calculate_acrylic_aurora_admin.js
 * Admin-side pricing calculator for オーロラアクリルフィギュアスタンド (Aurora Acrylic Figure Stand).
 *
 * Sourced dynamically from database pricing:
 *   - Fetches rates dynamically from window.numUnitPrice['acrylicfigstand_aurora_...']
 *   - Same paperPrice_obj and calculations as customer-side calculate-figure-aurora-ver2.js
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
    var delivery = $('input[name="acy_delivery"]:checked').val() || '10営業日';
    var print = $('input[name="acy_screen"]:checked').val() || '片面印刷';
    var size = $('input[name="acy_size"]:checked').val() || '50';

    var d_key = (delivery === '6営業日') ? '6d' : '10d';
    var p_key = (print === '両面印刷') ? '2side' : '1side';
    var dbKey = 'aurora_acrylickeyholder_' + d_key + '_' + p_key + '_' + size;

    if (window.numUnitPrice && window.numUnitPrice[dbKey]) {
        return window.numUnitPrice[dbKey];
    }
    // Fallback static pool matching DB (dummy values for safety)
    return [
        { "num": 1, "price": 0 }, { "num": 1000, "price": 0 }
    ];
}

// Pricing calculation logic
function cal_c() {
    var prodc_day = $('input[name="acy_delivery"]:checked').val() || '10営業日';
    var size_val = $('input[name="acy_size"]:checked').val() || '50';
    var ItemSize = size_val + 'mm × ' + size_val + 'mm';
    var cat = $('input[name="acy_cat"]:checked').val() || 'ピンクベース加工';
    var part = $('input[name="acy_part"]:checked').val();
    var paper = $('input[name="acy_paper_select"]:checked').val(); // 'あり' or undefined
    var paper_color = $('input[name="acy_paper"]:checked').val();
    var print = $('input[name="acy_screen"]:checked').val() || '片面印刷';
    var sample = $('input[name="SendPrototype"]:checked').val() || 'なし';
    var trace = $('input[name="DeFormat"]:checked').val() || 'なし';

    // Admin uses #no_of_order (name="numberOf")
    var qty = parseInt($('#no_of_order').val(), 10) || 0;

    $('#error_message').text('');
    $('input[value="ご注文情報入力へ"]').prop('disabled', false);

    if (prodc_day === '6営業日' && qty > 300) {
        $('#error_message').text('6営業日納期では300個までのご注文となります');
        $('input[value="ご注文情報入力へ"]').prop('disabled', true);
        qty = 0;
    } else if (qty > 1000) {
        $('#error_message').text('最大注文数量は1000個です');
        $('input[value="ご注文情報入力へ"]').prop('disabled', true);
        qty = 0;
    }

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
        if (part === '【オリジナル】印刷あり') {
            partKey += '_' + size_val;
        }
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
        $('.paper-options').show();
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
            $('#prd_paper').text('未選択');
        }
    } else {
        $('.paper-options').hide();
        paperPrice = 0;
        $('#prd_paper').text('なし');
    }

    // Summary display
    $('#prd_delivery').text(prodc_day);
    $('#prd_print').text(print);
    $('#prd_size').text(ItemSize);
    $('#prd_cat').text(cat);
    $('#prd_qty').text(qty);

    if (prodc_day === '6営業日' && qty > 300) {
        $('#error_message').html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> 6営業日の場合は、300個までしか注文できません。');
        qty = 0; // Force prices to 0
        $('.ord-btn').prop('disabled', true).css('opacity', '0.5').css('pointer-events', 'none');
    } else {
        $('#error_message').html('');
        $('.ord-btn').prop('disabled', false).css('opacity', '1').css('pointer-events', 'auto');
    }

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

    // Hidden field writes
    var $t7 = document.getElementById('textfield7'); if ($t7) $t7.value = (unit_price * qty); // Base price sum
    var $t72 = document.getElementById('textfield7_2'); if ($t72) $t72.value = (paperPrice * qty);        // Paper sum
    var $psh = document.getElementById('acy_prototype_price'); if ($psh) $psh.value = sample_price;   // ProShipping
    var $pshDisp = document.getElementById('textfield3'); if ($pshDisp) $pshDisp.value = sample_price;
    var $ptrc = document.getElementById('acy_trace_price'); if ($ptrc) $ptrc.value = trace_price;   // TraceCharge
    var $ptrcDisp = document.getElementById('textfield4'); if ($ptrcDisp) $ptrcDisp.value = trace_price;
    var $ptp = document.getElementById('acy_part_total'); if ($ptp) $ptp.value = (partPrice * qty);   // PartPrice

    var BeforeTax = sub_total;
    var $t9 = document.getElementById('textfield9'); if ($t9) $t9.value = BeforeTax;
    var $t11 = document.getElementById('textfield11'); if ($t11) $t11.value = BeforeTax;

    var $up = document.getElementById('unit_price'); if ($up) $up.value = (qty > 0 ? unit_price : 0);
    var $dis = document.getElementById('textfield_dis'); if ($dis) $dis.value = disPrice;              // discount
    var $gt = document.getElementById('textfield11'); if ($gt) $gt.value = total;                 // grandTotal
    var $pf11 = document.getElementById('pricefield11'); if ($pf11) $pf11.value = sub_total;
    var $pf13 = document.getElementById('pricefield13'); if ($pf13) $pf13.value = total;

    // Display fields (Matches other admin calculation scripts)
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
