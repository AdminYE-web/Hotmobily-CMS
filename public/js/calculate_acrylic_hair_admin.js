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
    var vat = 10;

    $('#error_message').text('');
    $('input[value="ご注文情報入力へ"]').prop('disabled', false);

    if (delivery === '6営業日' && qty > 300) {
        $('#error_message').text('6営業日納期では300個までのご注文となります');
        $('input[value="ご注文情報入力へ"]').prop('disabled', true);
        qty = 0;
    }

    var prd_10d_1side = window.numUnitPrice ? (window.numUnitPrice['acrylichairbunch_10d_1side'] || []) : [];
    var prd_6d_1side = window.numUnitPrice ? (window.numUnitPrice['acrylichairbunch_6d_1side'] || []) : [];


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

    function getDbPriceVal(priceObj, key, checkQty) {
        if (!priceObj || typeof priceObj[key] === 'undefined') return null;
        var tiers = priceObj[key];
        for (var i = 0, iMax = tiers.length; i < iMax; i++) {
            if (checkQty >= parseInt(tiers[i].num)) {
                return Math.floor(tiers[i].price);
            }
        }
        return null;
    }

    var paper_price = 0;
    if (paperSelect === 'あり' && paperColor) {
        var dbPaperPrice = null;
        if (paperColor === 'paper-patternA-1') {
            if (typeof window.numUnitAddPrice !== 'undefined') dbPaperPrice = getDbPriceVal(window.numUnitAddPrice, 'mount_printing_single', qty);
            if (dbPaperPrice === null && typeof window.numUnitOptionPrice !== 'undefined') dbPaperPrice = getDbPriceVal(window.numUnitOptionPrice, 'Paper 1 Side', qty);
        } else if (paperColor === 'paper-patternA-2') {
            if (typeof window.numUnitAddPrice !== 'undefined') dbPaperPrice = getDbPriceVal(window.numUnitAddPrice, 'mount_printing_both', qty);
            if (dbPaperPrice === null && typeof window.numUnitOptionPrice !== 'undefined') dbPaperPrice = getDbPriceVal(window.numUnitOptionPrice, 'Paper 2 Side', qty);
        } else {
            if (typeof window.numUnitAddPrice !== 'undefined') dbPaperPrice = getDbPriceVal(window.numUnitAddPrice, 'mount_plain', qty);
            if (dbPaperPrice === null && typeof window.numUnitOptionPrice !== 'undefined') dbPaperPrice = getDbPriceVal(window.numUnitOptionPrice, 'Paper Temp', qty);
        }

        if (dbPaperPrice !== null) {
            paper_price = dbPaperPrice;
        } else {
            // No hardcoded fallback array provided in this file, default to 0 if not found in DB
            paper_price = 0;
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

    var part = $('input[name="acy_part"]:checked').val();

    // Part price calculation
    var partPrice = 0;
    if (part !== undefined && part !== '') {
        var partKey = part;
        var tmp_part = window.numUnitOptionPrice ? window.numUnitOptionPrice[partKey] : [];
        if (!tmp_part || tmp_part.length === 0) {
            tmp_part = window.numUnitOptionPrice ? window.numUnitOptionPrice[partKey + '_0'] : [];
        }
        if (tmp_part && tmp_part.length > 0) {
            partPrice = Math.floor(tmp_part[0].price);
        }
        $('#prd_part').text(part);
    } else {
        $('#prd_part').text('なし');
    }
    var part_total = partPrice * qty;

    // Sum
    var base_total = qty * unit_price;
    var paper_total = qty * paper_price;
    var grand_total = base_total + paper_total + part_total + sample_price + trace_price;

    $('.prd_total').text(grand_total.toLocaleString());
    $('input[name="unit_price"]').val(unit_price);
    $('input[name="StrapPrice"]').val(base_total);
    $('input[name="PaperPrice"]').val(paper_total);
    $('input[name="PartPrice"]').val(part_total);
    $('input[name="ProShipping"]').val(sample_price);
    $('input[name="TraceCharge"]').val(trace_price);
    $('input[name="BeforeTax"]').val(grand_total);
    $('input[name="grandTotal"]').val(grand_total);

    $('#strapPrice_disp').val(base_total.toLocaleString("en"));
    $('#paperPrice_disp').val(paper_total.toLocaleString("en"));
    $('#partPrice_disp').val(part_total.toLocaleString("en"));
    $('#textfield3').val(sample_price);
    var $ptrc = document.getElementById('textfield4'); if ($ptrc) $ptrc.value = trace_price;
    $('#beforeTax_disp').val(grand_total.toLocaleString("en"));
    $('#discountDisp').val((0).toLocaleString("en"));
    $('#grandTotalDisp').val(grand_total.toLocaleString("en"));

    var acy_size = $('input[name="acy_size"]:checked').val() || '';
    $('#prd_size').text(acy_size);
    $('#prd_delivery').text(delivery);
    $('#prd_qty').text(qty);
}

function selectAcrylicPart(elem) {
    var price = $(elem).data('price');
    var name = $(elem).data('name');
    $('#acy_part_price_hidden').val(price);
    $('#prd_part').text(name);
    calcAcrylic();
}

$(document).ready(function () {
    calcAcrylic();
    $('input, select').on('change keyup', calcAcrylic);

    $('#form').on('submit', function (e) {
        // Validate attachment
        if ($('input[name="acy_part"]').length > 0 && !$('input[name="acy_part"]:checked').length) {
            $('#part-error').text('アタッチメントを選択してください。');
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $("#part-error").offset().top - 100
            }, 500);
            return false;
        } else {
            $('#part-error').text('');
        }
    });
});
