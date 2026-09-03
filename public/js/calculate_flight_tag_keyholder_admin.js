function get_fee_admin(name, default_fee) {
    if (window.feeArrayAdmin && window.feeArrayAdmin[name] !== undefined) {
        return parseInt(window.feeArrayAdmin[name], 10);
    }
    return parseInt(default_fee, 10);
}

function get_price_admin() {
    var typeValue = $('input[name=ft_type]:checked').val();
    var dbKey = 'flight_tag_keyholder';

    // Fallback logic in case DB lookup fails
    var fallback = [
        { num: 50, price: 450 },
        { num: 100, price: 348 },
        { num: 300, price: 224 },
        { num: 500, price: 182 },
        { num: 1000, price: 131 },
        { num: 3000, price: 86 }
    ];

    if (window.numUnitPrice) {
        if (window.numUnitPrice[dbKey]) return window.numUnitPrice[dbKey];
    }

    return fallback;
}

function calcFlightTag() {
    var currentFabric = $("input[name='ft_option']:checked").val();
    var colorMap = [
        { twillPrefix: "108", feltPrefix: "T184" },
        { twillPrefix: "63", feltPrefix: "T223" },
        { twillPrefix: "83", feltPrefix: "T47" },
        { twillPrefix: "76", feltPrefix: "T244" },
        { twillPrefix: "30", feltPrefix: "T142" },
        { twillPrefix: "131", feltPrefix: "T95" },
        { twillPrefix: "78", feltPrefix: "T202" },
        { twillPrefix: "74", feltPrefix: "T258" },
        { twillPrefix: "135", feltPrefix: "T214" },
        { twillPrefix: "32", feltPrefix: "T54" },
        { twillPrefix: "9", feltPrefix: "T122" },
        { twillPrefix: "94", feltPrefix: "T219" },
        { twillPrefix: "35", feltPrefix: "T24" },
        { twillPrefix: "66", feltPrefix: "T218" },
        { twillPrefix: "46", feltPrefix: "T32" },
        { twillPrefix: "52", feltPrefix: "T37" },
        { twillPrefix: "12", feltPrefix: "T198" },
        { twillPrefix: "129", feltPrefix: "T256" },
        { twillPrefix: "123", feltPrefix: "1.2mmBLACA" },
        { twillPrefix: "1", feltPrefix: "T01B" },
        { twillPrefix: "88", feltPrefix: "T199" },
        { twillPrefix: "126", feltPrefix: "T108" }
    ];
    $("input[name='ft_fabric_color1']").each(function (idx) {
        if (idx < colorMap.length) {
            var currentVal = $(this).val();
            if (!currentVal) return;
            var isCurrentlyFelt = currentVal.indexOf(colorMap[idx].feltPrefix) === 0;
            var isCurrentlyTwill = currentVal.indexOf(colorMap[idx].twillPrefix) === 0;
            if (currentFabric === "フェルト生地" && isCurrentlyTwill) {
                $(this).val(currentVal.replace(colorMap[idx].twillPrefix, colorMap[idx].feltPrefix));
                var img = $(this).closest('td').find('img');
                if (img.length > 0) img.attr('src', '../../products/images/flight_tag/wappen-icon-' + (idx < 9 ? '0' + (idx + 1) : (idx + 1)) + '.webp');
            } else if (currentFabric !== "フェルト生地" && isCurrentlyFelt) {
                $(this).val(currentVal.replace(colorMap[idx].feltPrefix, colorMap[idx].twillPrefix));
                var img = $(this).closest('td').find('img');
                if (img.length > 0) img.attr('src', '../../products/images/flight_tag/icon-' + (idx < 9 ? '0' + (idx + 1) : (idx + 1)) + '.webp');
            }
        }
    });
    $("input[name='ft_fabric_color2']").each(function (idx) {
        if (idx < colorMap.length) {
            var currentVal = $(this).val();
            if (!currentVal) return;
            var isCurrentlyFelt = currentVal.indexOf(colorMap[idx].feltPrefix) === 0;
            var isCurrentlyTwill = currentVal.indexOf(colorMap[idx].twillPrefix) === 0;
            if (currentFabric === "フェルト生地" && isCurrentlyTwill) {
                $(this).val(currentVal.replace(colorMap[idx].twillPrefix, colorMap[idx].feltPrefix));
                var img = $(this).closest('td').find('img');
                if (img.length > 0) img.attr('src', '../../products/images/flight_tag/wappen-icon-' + (idx < 9 ? '0' + (idx + 1) : (idx + 1)) + '.webp');
            } else if (currentFabric !== "フェルト生地" && isCurrentlyFelt) {
                $(this).val(currentVal.replace(colorMap[idx].feltPrefix, colorMap[idx].twillPrefix));
                var img = $(this).closest('td').find('img');
                if (img.length > 0) img.attr('src', '../../products/images/flight_tag/icon-' + (idx < 9 ? '0' + (idx + 1) : (idx + 1)) + '.webp');
            }
        }
    });
    if ($("#txt-show-Insatsu1").length > 0) {
        var selectedColor = $("input[name='ft_fabric_color1']:checked").val();
        if (selectedColor) {
            $("#txt-show-Insatsu1").text(selectedColor);
            $("#txt-show-Insatsu1").removeClass("d-none");
        }
    }

    var vno_of_order = parseInt(document.getElementById('qty').value, 10) || 0;

    if (vno_of_order > 0) {
        if (vno_of_order > 50000) {
            $('#err_numberOf_mess').html('<span style="color: red">本数は50000本までです。50000本以上をご希望の場合はお問い合わせください。</span>');
        } else if (vno_of_order < 50) {
            $('#err_numberOf_mess').html('<span style="color: red">本数は50本以上で入力して下さい。</span>');
        } else {
            $('#err_numberOf_mess').html('');
        }
    } else {
        $('#err_numberOf_mess').html('');
    }

    var base_price = 0;
    if (vno_of_order > 0) {
        var pArr = get_price_admin();
        for (var i = 0, iMax = pArr.length; i < iMax; i++) {
            if (vno_of_order >= parseInt(pArr[i].num)) {
                base_price = parseFloat(pArr[i].price);
                continue;
            }
            break;
        }
    }

    var size_input = $('input[name=ft_size]').val() || '';
    var size_num = parseInt(size_input.replace(/[^0-9]/g, ''), 10);
    if (isNaN(size_num)) size_num = 10;

    var processing = $('input[name="ft_process"]:checked').val() || 'ヒートカット加工';
    var backside = $('input[name="ft_backside"]:checked').val() || 'デザインあり';
    var opp = $('input[name="ft_opp"]:checked').val() || 'なし';
    var trace = $('input[name="ft_trace"]:checked').val() || 'なし';
    var proto = $('input[name="ft_sample"]:checked').val() || 'なし';

    var order_pcs = 0;
    if (base_price > 0) {
        var multiplier = 1.0;
        if (backside === 'デザインあり') {
            multiplier = 1.4;
        }
        order_pcs = Math.floor((base_price + (15 * (size_num - 5))) * multiplier);
    }

    var process_price = 0;
    if (processing === 'メロウ加工') {
        process_price = get_fee_admin('メロウ加工', 50);
    } else if (processing === 'オーバーロック仕上げ') {
        process_price = get_fee_admin('オーバーロック仕上げ', 50);
    }

    var backside_price = 0;
    var backside_type = $('select[name="ft_backside_type"]').val() || '';
    if (backside_type === 'クレジット印字') {
        backside_price = get_fee_admin('クレジット印字', 50);
    }

    var proto_charge = 0;
    if (proto === 'あり') {
        proto_charge = get_fee_admin('試作品', 5000);
    }

    var trace_charge = 0;
    if (trace === 'あり') {
        trace_charge = get_fee_admin('データトレース', 2000);
    }

    var opp_price = 0;
    if (opp === 'あり') {
        opp_price = get_fee_admin('OPP個別包装', 7);
    }

    var color_variation_price = 0;
    var cvNum = parseInt($('input[name="color_variation"]').val(), 10) || 1;
    if (cvNum > 3) {
        color_variation_price = (cvNum - 3) * get_fee_admin('糸色追加料金（1色あたり）', 20);
    }

    var part = $('input[name="part"]:checked').val() || 'なし';
    var partPriceUnit = parseInt($('input[name="part"]:checked').attr('data-price'), 10);
    if (isNaN(partPriceUnit)) {
        partPriceUnit = 0;
        if (part != undefined && window.partUnitPrice && window.partUnitPrice[part]) {
            partPriceUnit = window.partUnitPrice[part].price;
        } else {
            if (part === '二重リング') partPriceUnit = 20;
            else if (part === 'ナスカン') partPriceUnit = 40;
            else if (part === 'マツバ') partPriceUnit = 20;
            else if (part === 'ボールチェーン') partPriceUnit = 30;
        }
    }
    partPriceUnit = Math.floor(partPriceUnit);
    var partPriceTotal = partPriceUnit * vno_of_order;

    var StrapPrice = 0;
    if (vno_of_order > 0) {
        StrapPrice = order_pcs * vno_of_order;
    }

    var mold_charge = (vno_of_order > 0) ? get_fee_admin('刺繍版代', 4000) : 0;

    var BeforeTax = StrapPrice + mold_charge + proto_charge +
        (opp_price * vno_of_order) + trace_charge +
        partPriceTotal + (process_price * vno_of_order) +
        (backside_price * vno_of_order) + (color_variation_price * vno_of_order);

    var grandTotal = BeforeTax;

    $('#unit_price').val(order_pcs);
    $('#textfield7').val(StrapPrice);
    $('#textfield3').val(proto_charge);
    $('#textfield4').val(trace_charge);
    $('#opp_price').val(opp_price * vno_of_order);
    $('#partPrice').val(partPriceTotal);
    $('#mold_price').val(mold_charge);
    $('#process_price').val(process_price * vno_of_order);
    $('#backside_price').val(backside_price * vno_of_order);
    $('#color_price').val(color_variation_price * vno_of_order);
    $('#textfield9').val(BeforeTax);
    $('#textfield11').val(grandTotal);

    if ($('#strapPrice_disp').length) $('#strapPrice_disp').val(StrapPrice.toLocaleString("en"));
    if ($('#partPrice_disp').length) $('#partPrice_disp').val(partPriceTotal.toLocaleString("en"));
    if ($('#oppPrice_disp').length) $('#oppPrice_disp').val((opp_price * vno_of_order).toLocaleString("en"));
    if ($('#prd_trace_price').length) $('#prd_trace_price').val(trace_charge.toLocaleString("en"));
    if ($('#prd_sample_price').length) $('#prd_sample_price').val(proto_charge.toLocaleString("en"));

    if ($('#prd_mold_price').length) $('#prd_mold_price').val(mold_charge.toLocaleString("en"));
    if ($('#prd_process_price').length) $('#prd_process_price').val((process_price * vno_of_order).toLocaleString("en"));
    if ($('#prd_backside_price').length) $('#prd_backside_price').val((backside_price * vno_of_order).toLocaleString("en"));
    if ($('#prd_color_price').length) $('#prd_color_price').val((color_variation_price * vno_of_order).toLocaleString("en"));

    $('#beforeTax_disp').val(BeforeTax.toLocaleString("en"));
    $('#grandTotalDisp').val(grandTotal.toLocaleString("en"));

    $('.prd_total').text(grandTotal.toLocaleString("en"));
}

window.calcFlightTag = calcFlightTag;
if (window.__calcFlightTagQueue && window.__calcFlightTagQueue.length) {
    window.__calcFlightTagQueue.forEach(function (args) { calcFlightTag.apply(null, args); });
    window.__calcFlightTagQueue = [];

    if ($('input[name=ft_type]:checked').val() == '昇華転写') {
        $('.only_embro').hide();
    } else {
        $('.only_embro').show();
    }
    $('#prd_ft_fabric_color1').text($('input[name=ft_fabric_color1]:checked').val());
    $('#prd_ft_fabric_color2').text($('input[name=ft_fabric_color2]:checked').val());
    $('#prd_ft_printing_color1').text($('input[name=ft_printing_color1]:checked').val());
    $('#prd_ft_printing_color2').text($('input[name=ft_printing_color2]:checked').val());
}

$(document).ready(function () {
    $(document).on("change", "input[name='ft_fabric_color1']", function () {
        if ($("#txt-show-Insatsu1").length > 0) {
            $("#txt-show-Insatsu1").text($(this).val());
            $("#txt-show-Insatsu1").removeClass("d-none");
        }
    });
});
