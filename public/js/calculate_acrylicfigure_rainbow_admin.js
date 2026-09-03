// Admin-side pricing calculator for アクリルスタンド
// Sourced dynamically from database pricing via window.numUnitPrice['acrylicfigstand_...']


var parts_obj_admin = null;
var vat = 10;
var unit_price = 0;
var partPrice = 0;
var paperPrice = 0;
var sub_total = 0;
var disPrice = 0;
var total = 0;

function get_price_admin() {
    var delivery = $('input[name="acy_delivery"]:checked').val() || '10営業日';
    var print = $('input[name="acy_screen"]:checked').val() || '片面印刷';
    var size = $('input[name="acy_size"]:checked').val() || '50';

    var d_key = (delivery === '6営業日') ? '6d' : '10d';
    var p_key = (print === '両面印刷') ? '2side' : '1side';

    var dbKey = 'acrylicfigstand_rainbow_' + d_key + '_' + p_key + '_' + size;

    if (window.numUnitPrice && window.numUnitPrice[dbKey]) {
        return window.numUnitPrice[dbKey];
    }
    return [];
}

function calcAcrylic() {
    var prodc_day = $('input[name="acy_delivery"]:checked').val() || '10営業日';
    var size_val = $('input[name="acy_size"]:checked').val() || '50';
    var ItemSize = size_val;
    var shape_proc = $('input[name="acy_cat"]:checked').val() || 'ノーマルタイプ';

    var part = $('input[name="acy_part"]:checked').val();
    var paper = $('input[name="acy_paper_select"]:checked').val();
    var paper_color = $('input[name="acy_paper"]:checked').val();
    var print = $('input[name="acy_screen"]:checked').val() || '片面印刷';

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

    $('#prd_delivery').text(prodc_day);
    $('#prd_size').text(ItemSize + "x" + ItemSize + "mm.");
    $('#prd_shape_processing').text(shape_proc);
    $('#prd_print').text(print);
    $('#prd_qty').text(qty || '');

    var sample = $('input[name="SendPrototype"]:checked').val();
    var trace = $('input[name="DeFormat"]:checked').val();
    if (sample === 'あり') $('#prd_SendPrototype').text(sample);
    else $('#prd_SendPrototype').text('なし');

    if (trace === 'あり') $('#prd_DeFormat').text(trace);
    else $('#prd_DeFormat').text('なし');

    var pArr = get_price_admin();
    unit_price = 0;
    for (var i = 0, iMax = pArr.length; i < iMax; i++) {
        if (qty >= parseInt(pArr[i].num)) {
            // DB has raw price ex-vat, so we floor it
            unit_price = Math.floor(pArr[i].price);
            continue;
        }
        break;
    }

    // Subtotal
    sub_total = Math.floor((unit_price * qty) + sample_price + trace_price + (partPrice * qty) + (paperPrice * qty));

    var timer = new Date().toISOString();
    var startDate = new Date("2024-01-24T00:00:00");
    var endDate = new Date("2024-02-16T23:59:00");
    disPrice = 0;
    if (timer > startDate.toISOString() && timer < endDate.toISOString()) {
        disPrice = Math.floor(parseInt(sub_total * 0.05));
    }

    total = Math.floor(parseInt(sub_total) - parseInt(disPrice));

    $('#unit_price').val(unit_price);
    $('#strapPrice_disp').val(Math.floor(unit_price * qty).toLocaleString("en"));
    $('#partPrice_disp').val((partPrice * qty).toLocaleString("en"));
    // Hidden field writes
    var $t7 = document.getElementById('textfield7'); if ($t7) $t7.value = (unit_price * qty); // Base price sum
    var $t72 = document.getElementById('textfield7_2'); if ($t72) $t72.value = (paperPrice * qty);        // Paper sum
    var $psh = document.getElementById('acy_prototype_price'); if ($psh) $psh.value = sample_price;   // ProShipping
    var $pshDisp = document.getElementById('textfield3'); if ($pshDisp) $pshDisp.value = sample_price;
    var $ptrc = document.getElementById('acy_trace_price'); if ($ptrc) $ptrc.value = trace_price;   // TraceCharge
    var $ptrcDisp = document.getElementById('textfield4'); if ($ptrcDisp) $ptrcDisp.value = trace_price;
    var $ptp = document.getElementById('acy_part_total'); if ($ptp) $ptp.value = (partPrice * qty);   // PartPrice

    $('#beforeTax_disp').val(sub_total.toLocaleString("en"));
    $('#textfield9').val(sub_total);

    $('#discountDisp').val(disPrice.toLocaleString("en"));
    $('#textfield_dis').val(disPrice);

    $('#grandTotalDisp').val(total.toLocaleString("en"));
    $('#textfield11').val(total);
    $('.prd_total').text(total.toLocaleString('ja'));


}

function selectAcrylicPart(elem) {
    var $el = $(elem);
    parts_obj_admin = {
        part_name: $el.data('name'),
        part_price: parseFloat($el.data('price')) || 0,
        part_pic: $el.data('pic')
    };
    $('#acy_part_price_hidden').val(parts_obj_admin.part_price);
    calcAcrylic();
}

$(document).ready(function () {
    calcAcrylic();
});
