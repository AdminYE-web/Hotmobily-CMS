function get_price_admin() {
    var typeValue = $('input[name=ft_type]:checked').val();
    var dbKey = 'flight_tag_coaster';

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
        var keys = Object.keys(window.numUnitPrice);
        for (var i = 0; i < keys.length; i++) {
            var k = keys[i];
            if (k.indexOf('flight_tag_coaster') !== -1) return window.numUnitPrice[k];
        }
    }

    return fallback;
}

function calcFlightTagCoaster() {
    var typeValue = $("input[name='ft_type']:checked").val();

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

    if (typeValue === "刺繍") {
        $(".color-variation-container").show();
        $("input[name='ft_option'][value='ツイル生地']").parent().removeClass("disabled");
        $("input[name='ft_option'][value='フェルト生地']").parent().removeClass("disabled");
        $("input[name='ft_option'][value='サテン生地']").parent().addClass("disabled");
        $("input[name='ft_option'][value='エンブクロス']").parent().addClass("disabled");
    } else if (typeValue === "ジャガード織") {
        $(".color-variation-container").show();
        $("input[name='ft_option']").parent().addClass("disabled");
    }

    if ($("input[name='ft_option']:checked").parent().hasClass('disabled') || !$("input[name='ft_option']:checked").length) {
        $("input[name='ft_option']").each(function () {
            if (!$(this).parent().hasClass('disabled')) {
                $(this).prop('checked', true);
                return false;
            }
        });
    }

    var fabric = $("input[name='ft_option']:checked").val();
    if (fabric === "サテン生地" || fabric === "エンブクロス") {
        $('.only_embro').hide();
    } else {
        $('.only_embro').show();
    }

    function get_add_price(code) {
        if (window.numUnitAddPrice && window.numUnitAddPrice[code]) {
            var tiers = window.numUnitAddPrice[code];
            if (tiers.length > 0) return Math.floor(tiers[0].price);
        }
        return 0;
    }

    var vno_of_order = parseInt(document.getElementById('qty').value, 10) || 0;
    var hasValidOrderQty = vno_of_order >= 50 && vno_of_order <= 50000;

    var order_pcs = 0;
    if (vno_of_order > 0) {
        var pArr = get_price_admin();
        if (pArr.length > 0) order_pcs = Math.floor(pArr[0].price);
        for (var i = 0, iMax = pArr.length; i < iMax; i++) {
            if (vno_of_order >= parseInt(pArr[i].num)) {
                order_pcs = Math.floor(pArr[i].price);
                continue;
            }
            break;
        }
    }

    if ($("select[name=ft_size] option:selected").val() != undefined) {
        if (!$('input[name=ft_backside]').length || $('input[name=ft_backside]:checked').val() == "デザインなし") {
            order_pcs = Math.floor((order_pcs + (15 * ($('select[name=ft_size] option:selected').val() - 5))) * 1.1);
        } else {
            order_pcs = Math.floor(((order_pcs + (15 * ($('select[name=ft_size] option:selected').val() - 5))) * 1.4) * 1.1);
        }
    }

    if (vno_of_order > 50000) {
        $('#err_numberOf_mess').html('<span style="color: red">本数は50000本以下で入力して下さい。50000以上のお客様は納期をメールにてお問い合わせ下さい。</span>');
        $('.ord-btn').prop('disabled', true);
    } else if (vno_of_order < 50 && vno_of_order > 0) {
        $('#err_numberOf_mess').html('<span style="color: red">本数は50本以上で入力して下さい。</span>');
        $('.ord-btn').prop('disabled', true);
    } else if (vno_of_order === 0) {
        $('#err_numberOf_mess').html('');
        $('.ord-btn').prop('disabled', true);
    } else {
        $('#err_numberOf_mess').html('');
        $('.ord-btn').prop('disabled', false);
    }

    var proto_charge = 0;
    if ($('input[name=ft_sample]:checked').val() != undefined && vno_of_order < 300) {
        proto_charge = 5000;
    }

    var trace_charge = 0;
    if ($('input[name=ft_trace]:checked').val() != undefined) {
        trace_charge = 2000;
    }

    var opp_price = 0;
    if ($('input[name=ft_opp]:checked').val() != undefined) {
        opp_price = 8 * vno_of_order;
    }

    var process_price = 0;
    if ($("input[name=ft_process]:checked").val() == "オーバーロック仕上げ") {
        process_price = 55 * vno_of_order;
    }

    var backside_price = 0;
    if ($("input[name=ft_backside]:checked").val() == "デザインなし") {
        if ($("select[name=ft_backside_type] option:selected").val() == "クレジット印字") {
            backside_price = 55 * vno_of_order;
        }
    }

    var color_variation_price = 0;
    var cv = parseInt($("input[name=color_variation]").val(), 10) || 1;
    if (cv > 3) {
        color_variation_price = (cv - 3) * 22 * vno_of_order;
    }

    var strap_price = order_pcs * vno_of_order;
    var plate_fee = 0;
    if (vno_of_order > 0 && $("input[name='ItemDesignRepeat']:checked").val() !== "はい") {
        plate_fee = 4000;
        if ($("input[name=ft_type]:checked").val() === "昇華転写") {
            plate_fee = 0;
        }
    }

    var item_total_before_tax = strap_price + plate_fee + proto_charge + trace_charge + opp_price + process_price + backside_price + color_variation_price;

    var $discountField = $('#textfield_dis');
    if ($discountField.data('baseDiscount') === undefined) {
        $discountField.data('baseDiscount', parseInt($discountField.val(), 10) || 0);
    }
    var discount = parseInt($discountField.data('baseDiscount'), 10) || 0;
    if (hasValidOrderQty && $('input[name=keisai]:checked').length && $('input[name=keisai]:checked').val() === '製作実績の掲載を許可する') {
        // discount += 5000; // Removed per user request
    }

    var prd_opp = $('input[name=ft_opp]:checked').length ? $('input[name=ft_opp]:checked').val() : "なし";
    $("#prd_ft_opp").html(prd_opp + (prd_opp === 'あり' ? " (＋@8円)" : ""));

    var prd_keisai = $('input[name=keisai]:checked').length ? $('input[name=keisai]:checked').val() : "";
    $("#prd_keisai").html(prd_keisai);

    var prd_template = $('#template_code').val() || "";
    $("#prd_template_code").html(prd_template);

    if (discount > item_total_before_tax) {
        discount = item_total_before_tax;
    }
    var item_total = item_total_before_tax - discount;

    $('#unit_price').val(order_pcs);
    $('#textfield7').val(strap_price);              // StrapPrice
    $('#textfield3').val(proto_charge);             // ProShipping
    $('#textfield4').val(trace_charge);             // TraceCharge
    $('#textfield9').val(item_total_before_tax);    // BeforeTax
    $('#textfield11').val(item_total);              // grandTotal
    $('#opp_price').val(opp_price);
    $discountField.val(discount);

    $('#plateFee').val(plate_fee);
    $('#processPrice').val(process_price);
    $('#backsidePrice').val(backside_price);
    $('#colorVariationPrice').val(color_variation_price);

    $('#strapPrice_disp').val(strap_price.toLocaleString("en"));
    $('#oppPrice_disp').val(opp_price.toLocaleString("en"));
    $('#prd_sample_price').val(proto_charge.toLocaleString("en"));
    $('#prd_trace_price').val(trace_charge.toLocaleString("en"));
    $('#beforeTax_disp').val(item_total_before_tax.toLocaleString("en"));
    $('#discountDisp').val(discount.toLocaleString("en"));
    $('#grandTotalDisp').val(item_total.toLocaleString("en"));

    if ($("input[name=ft_backside]:checked").length) {
        var bs_text = $("input[name=ft_backside]:checked").val() || "";
        if (bs_text === "デザインなし") {
            bs_text += $("select[name=ft_backside_type]").length ? " (" + $("select[name=ft_backside_type] option:selected").val() + ")" : "";
        }
        $("#prd_backside").text(bs_text);
    }
    $("#prd_processing").text($("input[name=ft_process]:checked").val() || "");
    $("#prd_material").text($("input[name=ft_option]:checked").val() || "");
    $("#prd_qty").text($("#qty").val() || "");
}

// Expose to global scope explicitly
window.calcFlightTagCoaster = calcFlightTagCoaster;
if (window.__calcFlightTagCoasterQueue && window.__calcFlightTagCoasterQueue.length) {
    window.__calcFlightTagCoasterQueue.forEach(function (args) { calcFlightTagCoaster.apply(null, args); });
    window.__calcFlightTagCoasterQueue = [];

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

