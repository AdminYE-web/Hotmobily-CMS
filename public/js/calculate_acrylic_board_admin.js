function calcAcrylic() {
    var delivery = $('input[name="acy_delivery"]:checked').val() || '';
    var paperSelect = $('input[name="acy_paper_select"]:checked').val() || '不要';
    var paperColor = $('input[name="acy_paper"]:checked').val() || '';
    var sample = $('input[name="SendPrototype"]:checked').val() || '不要';
    var trace = $('input[name="DeFormat"]:checked').val() || '不要';
    var qtyStr = $('input[name="numberOf"]').val() || '0';
    var qty = parseInt(qtyStr, 10);
    if (isNaN(qty) || qty <= 0) {
        qty = 0;
    }

    $('#error_message').text('');
    $('input[value="ご注文情報入力へ"]').prop('disabled', false);

    if (delivery === '6営業日' && qty > 300) {
        $('#error_message').text('6営業日納期では300個までのご注文となります');
        $('input[value="ご注文情報入力へ"]').prop('disabled', true);
        qty = 0;
    } else if (qty > 1000) {
        $('#error_message').text('最大注文数量は1000個です');
        $('input[value="ご注文情報入力へ"]').prop('disabled', true);
        qty = 0;
    }

    var prd_10d_1side = window.numUnitPrice ? (window.numUnitPrice['acrylicboard_10d_1side'] || []) : [];
    var prd_6d_1side = window.numUnitPrice ? (window.numUnitPrice['acrylicboard_6d_1side'] || []) : [];


    var priceArr = prd_10d_1side;
    if (delivery === '6営業日') {
        priceArr = prd_6d_1side;
    }

    var unit_price = 0;
    for (var i = 0; i < priceArr.length; i++) {
        if (qty >= priceArr[i].num) {
            unit_price = priceArr[i].price;
        } else {
            break;
        }
    }

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

    function get_add_price(code) {
        if (window.numUnitAddPrice && window.numUnitAddPrice[code]) {
            var tiers = window.numUnitAddPrice[code];
            if (tiers.length > 0) return Math.floor(tiers[0].price);
        }
        return 0;
    }

    var sample_price = 0; // Free for acrylic products
    var trace_price = 0;  // Free for acrylic products

    // Sum
    var base_total = qty * unit_price;
    var paper_total = qty * paper_price;
    var grand_total = base_total + paper_total + sample_price + trace_price;

    $('#product_total').text(grand_total.toLocaleString());
    $('input[name="unit_price"]').val(unit_price);
    $('input[name="StrapPrice"]').val(base_total);
    $('input[name="PaperPrice"]').val(paper_total);
    $('input[name="PartPrice"]').val(0);
    $('input[name="ProShipping"]').val(sample_price);
    $('input[name="TraceCharge"]').val(trace_price);
    $('input[name="BeforeTax"]').val(grand_total);
    $('input[name="grandTotal"]').val(grand_total);

    $('#strapPrice_disp').val(base_total.toLocaleString());
    $('#paperPrice_disp').val(paper_total.toLocaleString());
    $('#partPrice_disp').val('0');
    $('#textfield3').val(sample_price.toLocaleString());
    $('#textfield4').val(trace_price.toLocaleString());
    $('#beforeTax_disp').val(grand_total.toLocaleString());
    $('#grandTotalDisp').val(grand_total.toLocaleString());

    var acy_size = $('input[name="acy_size"]:checked').val() || '';
    $('#prd_size').text(acy_size);
    $('#prd_delivery').text(delivery);
    $('#prd_qty').text(qty);
}

$(document).ready(function () {
    calcAcrylic();
    $('input, select').on('change keyup', calcAcrylic);
});
