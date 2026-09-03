function calcPVC() {
    var ItemSize = $('input[name="ItemSize"]:checked').val() || 'スタンダート';
    var ItemPCS = $('input[name="ItemPCS"]:checked').val() || '無色透明';
    var ItemDesign = $('input[name="ItemDesign"]:checked').val() || '1種類';
    var paper = $('input[name="paper_select"]:checked').val() || 'なし';
    var sample = $('input[name="SendPrototype"]:checked').val() || 'なし';

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
    var sizeKey = (ItemSize === 'スモール') ? 'small' : 'standard';
    var fullKey = 'pvczipcase_' + sizeKey;

    var priceArr = window.numUnitPrice ? (window.numUnitPrice[fullKey] || []) : [];

    var unit_price = 0;
    for (var i = 0; i < priceArr.length; i++) {
        if (qty >= priceArr[i].num) {
            unit_price = priceArr[i].price;
        } else {
            break;
        }
    }

    function get_add_price(code) {
        if (window.numUnitAddPrice && window.numUnitAddPrice[code]) {
            var tiers = window.numUnitAddPrice[code];
            if (tiers.length > 0) return Math.floor(tiers[0].price);
        }
        return 0;
    }

    // Additional services
    var pcs_price = 0;
    if (ItemPCS === 'ラメ入り') {
        var addPcsUnit = get_add_price('pvczipcase_glitter_sheet');
        if (addPcsUnit === 0) addPcsUnit = 10; // Fallback to approx 10 if missing
        pcs_price = addPcsUnit * qty;
    }

    var design_price = 0;
    if (ItemDesign !== '1種類') {
        var numDesigns = parseInt(ItemDesign.replace(/[^0-9]/g, '')) || 1;
        if (numDesigns > 1) {
            var addDesignUnit = get_add_price('pvczipcase_designvariation');
            if (addDesignUnit === 0) addDesignUnit = 500; // Fallback to 500
            design_price = addDesignUnit * (numDesigns - 1);
        }
    }

    var sample_price = 0;
    if (sample === 'あり') {
        var addSampleUnit = get_add_price('pvczipcase_prototype');
        if (addSampleUnit === 0) addSampleUnit = 8000;
        sample_price = addSampleUnit;
    }

    var paper_price = 0;
    if (paper === 'あり') {
        var addPaperUnit = get_add_price('paper_fee');
        if (addPaperUnit === 0) addPaperUnit = 15;
        paper_price = addPaperUnit * qty;
    }

    // Sum
    var base_total = qty * unit_price;
    var grand_total = base_total + pcs_price + design_price + sample_price + paper_price;

    $('.prd_total').text(grand_total.toLocaleString());
    $('input[name="unit_price"]').val(unit_price);
    $('input[name="StrapPrice"]').val(base_total);
    $('input[name="PcsPrice"]').val(pcs_price);
    $('input[name="PaperPrice"]').val(paper_price);
    $('input[name="DesignsCharge"]').val(design_price);
    $('input[name="ProShipping"]').val(sample_price);

    // Set both BeforeTax and grandTotal to tax-exclusive total (tax is calculated on backend)
    $('input[name="BeforeTax"]').val(grand_total);
    $('input[name="grandTotal"]').val(grand_total);

    $('#strapPrice_disp').val(base_total.toLocaleString());
    $('#pcsPrice_disp').val(pcs_price.toLocaleString());
    $('#paperPrice_disp').val(paper_price.toLocaleString());
    $('#designPrice_disp').val(design_price.toLocaleString());
    $('#textfield3_disp').val(sample_price.toLocaleString());
    $('#beforeTax_disp').val(grand_total.toLocaleString());
    $('#grandTotalDisp').val(grand_total.toLocaleString());

    $('#prd_size').text(ItemSize);
    $('#prd_pcs').text(ItemPCS);
    $('#prd_design').text(ItemDesign);
    $('#prd_qty').text(qty);
    $('#prd_paper').text(paper);
}

$(document).ready(function () {
    calcPVC();
    $('input, select').on('change keyup', calcPVC);

    // Toggle design_no input visibility based on ItemDesignRepeat
    $('input[name="ItemDesignRepeat"]').on('change', function () {
        if ($(this).val() === 'はい') {
            $('.repeat').show();
        } else {
            $('.repeat').hide();
        }
    });
});
