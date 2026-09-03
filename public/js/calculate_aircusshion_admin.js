function calcPouch() {
    var ItemSize = $('input[name="ItemSize"]:checked').val() || '100x150mm';
    var ItemColors = $('input[name="ItemColors"]:checked').val() || 'クリア';
    var air_items = $('input[name="air_items"]:checked').val() || '丸型';
    var sample = $('input[name="SendPrototype"]:checked').val() || 'なし';
    var opp = $('input[name="ItemOPP"]:checked').val() || $('input[name="ItemOPP"][type="hidden"]').val() || 'OPPまとめ包装';
    var deformat = $('input[name="DeFormat"]:checked').val() || 'なし';

    var qtyStr = $('input[name="numberOf"]').val() || '0';
    var qty = parseInt(qtyStr, 10);
    if (isNaN(qty) || qty <= 0) {
        qty = 0;
    }

    $('#error_message').text('');
    $('input[value="ご注文情報入力へ"]').prop('disabled', false);

    if (qty > 50000) {
        $('#error_message').text('最大注文数量は50000個です');
        $('input[value="ご注文情報入力へ"]').prop('disabled', true);
        qty = 0;
    }

    // Resolve base product key
    var sizeKey = (ItemSize === '160x204mm') ? '160' : '100';
    var fullKey = 'aircushionpouch_' + sizeKey;

    var priceArr = window.numUnitPrice ? (window.numUnitPrice[fullKey] || []) : [];

    var unit_price = 0;
    for (var i = 0; i < priceArr.length; i++) {
        if (qty >= priceArr[i].num) {
            unit_price = priceArr[i].price;
        } else {
            break;
        }
    }

    function get_add_price(code, quantity) {
        if (window.numUnitAddPrice && window.numUnitAddPrice[code]) {
            var tiers = window.numUnitAddPrice[code];
            var price = 0;
            for (var j = 0; j < tiers.length; j++) {
                if ((quantity || 0) >= tiers[j].num) {
                    price = tiers[j].price;
                } else {
                    break;
                }
            }
            if (price > 0) return Math.floor(price);
        }
        return 0;
    }

    // Additional services
    var pcs_price = 0; // OPP cost is stored in PcsPrice in form
    if (opp === 'あり' || opp === 'OPP個別包装（7円）') {
        var addOppUnit = 7; // Fixed at 7 per piece
        pcs_price = addOppUnit * qty;
    }

    var design_price = 0; // Data Trace is stored in DesignsCharge in form
    if (deformat === 'あり') {
        var addTraceUnit = get_add_price('aircushionpouch_datatrace', qty);
        if (addTraceUnit === 0) addTraceUnit = 2000;
        design_price = addTraceUnit;
    }

    var sample_price = 0;
    if (sample === 'あり') {
        var addSampleUnit = get_add_price('aircushionpouch_prototype', qty);
        if (addSampleUnit === 0) addSampleUnit = 11819;
        sample_price = addSampleUnit;
    }

    // Removed paper price

    // Sum
    var base_total = qty * unit_price;
    var grand_total = base_total + pcs_price + design_price + sample_price;

    $('.prd_total').text(grand_total.toLocaleString());
    $('input[name="unit_price"]').val(unit_price);
    $('input[name="StrapPrice"]').val(base_total);
    $('input[name="PcsPrice"]').val(pcs_price);
    $('input[name="TraceCharge"]').val(design_price);
    $('input[name="ProShipping"]').val(sample_price);

    // Set both BeforeTax and grandTotal to tax-exclusive total (tax is calculated on backend)
    $('input[name="BeforeTax"]').val(grand_total);
    $('input[name="grandTotal"]').val(grand_total);

    $('#strapPrice_disp').val(base_total.toLocaleString());
    $('#pcsPrice_disp').val(pcs_price.toLocaleString());
    $('#designPrice_disp').val(design_price.toLocaleString());
    $('#textfield3_disp').val(sample_price.toLocaleString());
    $('#beforeTax_disp').val(grand_total.toLocaleString());
    $('#grandTotalDisp').val(grand_total.toLocaleString());

    $('#prd_size').text(ItemSize);
    $('#prd_colors').text(ItemColors);
    $('#prd_air_items').text(air_items);
    $('#prd_qty').text(qty);
    $('#prd_opp').text(opp);
    $('#prd_deformat').text(deformat);
}

$(document).ready(function () {
    calcPouch();
    $('input, select').on('change keyup', calcPouch);

    // Toggle design_no input visibility based on ItemDesignRepeat
    $('input[name="ItemDesignRepeat"]').on('change', function () {
        if ($(this).val() === 'はい') {
            $('.repeat').show();
        } else {
            $('.repeat').hide();
        }
    });
});
