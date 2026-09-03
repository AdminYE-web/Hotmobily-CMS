function get_price_admin() {
    var typeValue = $('input[name=ft_type]:checked').val();
    var ftSize = $("select[name=ft_size] option:selected").val() || '5';
    var dbKey = '';

    // Fallback logic in case DB lookup fails
    var fallback = [];
    if (typeValue === '刺繍') {
        dbKey = 'wappen_embroidery_' + ftSize;
        fallback = [
            { num: 50, price: 450 },
            { num: 100, price: 348 },
            { num: 300, price: 224 },
            { num: 500, price: 182 },
            { num: 1000, price: 131 },
            { num: 3000, price: 86 }
        ];
    } else if (typeValue === 'ジャガード織') {
        dbKey = 'wappen_jacquard_' + ftSize;
        fallback = [
            { num: 50, price: 450 },
            { num: 100, price: 348 },
            { num: 300, price: 224 },
            { num: 500, price: 182 },
            { num: 1000, price: 131 },
            { num: 3000, price: 86 }
        ];
    } else if (typeValue === '昇華転写') {
        dbKey = 'wappen_sublimation';
        fallback = [
            { num: 50, price: 580 },
            { num: 100, price: 380 },
            { num: 300, price: 200 },
            { num: 500, price: 170 },
            { num: 1000, price: 160 },
            { num: 3000, price: 140 }
        ];
    }

    if (window.numUnitPrice) {
        if (window.numUnitPrice[dbKey]) return window.numUnitPrice[dbKey];
        var keys = Object.keys(window.numUnitPrice);
        for (var i = 0; i < keys.length; i++) {
            var k = keys[i];
            if (typeValue === '刺繍' && k === dbKey) return window.numUnitPrice[k];
            if (typeValue === 'ジャガード織' && k === dbKey) return window.numUnitPrice[k];
            if (typeValue === '昇華転写' && (k.indexOf('wappen_sublimation') !== -1)) return window.numUnitPrice[k];
        }
    }

    return fallback;
}

function calcWappen() {
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
    } else if (typeValue === "昇華転写") {
        $(".color-variation-container").hide();
        $("input[name='ft_option'][value='ツイル生地']").parent().removeClass("disabled");
        $("input[name='ft_option'][value='フェルト生地']").parent().addClass("disabled");
        $("input[name='ft_option'][value='サテン生地']").parent().removeClass("disabled");
        $("input[name='ft_option'][value='エンブクロス']").parent().removeClass("disabled");
    }

    if ($("input[name='ft_option']:checked").parent().hasClass('disabled') || !$("input[name='ft_option']:checked").length) {
        $("input[name='ft_option']").each(function () {
            if (!$(this).parent().hasClass('disabled')) {
                $(this).prop('checked', true);
                return false;
            }
        });
    }

    if (typeValue === "昇華転写") {
        $('.only_embro').hide();
    } else {
        var fabric = $("input[name='ft_option']:checked").val();
        if (fabric === "サテン生地" || fabric === "エンブクロス") {
            $('.only_embro').hide();
        } else {
            $('.only_embro').show();
        }
    }

    if ($("input[name=ft_process]:checked").val() == "オーバーロック仕上げ") {
        $(".overlock_only").show();
    } else {
        $(".overlock_only").hide();
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

    // Note: size-based price difference is now baked into each wappen_embroidery_{size}
    // product_master row — no manual surcharge calculation needed.

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
        trace_charge = get_add_price("wappen_trace_fee") || 2000;
    }

    var opp_price = 0;
    if ($('input[name=ft_opp]:checked').val() != undefined) {
        opp_price = 7 * vno_of_order;
    }

    var process_price = 0;
    if ($("input[name=ft_process]:checked").val() == "オーバーロック仕上げ") {
        process_price = (get_add_price("wappen_edge_overlock") || 50) * vno_of_order;
    }

    var backside_price = 0;
    var backsideType = $("input[name=ft_backside_type]:checked").val() || $("select[name=ft_backside_type] option:selected").val();
    if (backsideType == "マジックテープ" || backsideType == "接着シール" || backsideType == "クレジット印字") {
        backside_price = (get_add_price("wappen_back_velcro") || 50) * vno_of_order;
    } else if (backsideType == "アイロンテープ") {
        backside_price = (get_add_price("wappen_back_iron") || 10) * vno_of_order;
    }

    var color_variation_price = 0;
    var cv = parseInt($("input[name=color_variation]").val(), 10) || 1;
    if (cv > 3) {
        color_variation_price = (cv - 3) * (get_add_price("wappen_thread_addcolor") || 20) * vno_of_order;
    }

    var strap_price = order_pcs * vno_of_order;
    var plate_fee = (vno_of_order > 0) ? (get_add_price("wappen_plate_fee") || 4000) : 0;
    if ($("input[name=ft_type]:checked").val() == "昇華転写") {
        plate_fee = 0; // 昇華転写 has no plate fee
    }

    var item_total_before_tax = strap_price + plate_fee + proto_charge + trace_charge + opp_price + process_price + backside_price + color_variation_price;

    var prd_opp = $('input[name=ft_opp]:checked').length ? $('input[name=ft_opp]:checked').val() : "なし";
    $("#prd_ft_opp").html(prd_opp + (prd_opp === 'あり' ? " (＋@7円)" : ""));

    var prd_template = $('#template_code').val() || "";
    $("#prd_template_code").html(prd_template);

    var item_total = item_total_before_tax;

    $('#unit_price').val(order_pcs);
    $('#textfield7').val(strap_price);              // StrapPrice
    $('#textfield3').val(proto_charge);             // ProShipping
    $('#textfield4').val(trace_charge);             // TraceCharge
    $('#textfield9').val(item_total_before_tax);    // BeforeTax
    $('#textfield11').val(item_total);              // grandTotal
    $('#opp_price').val(opp_price);

    $('#plateFee').val(plate_fee);
    $('#processPrice').val(process_price);
    $('#backsidePrice').val(backside_price);
    $('#colorVariationPrice').val(color_variation_price);

    $('#strapPrice_disp').val(strap_price.toLocaleString("en"));
    $('#oppPrice_disp').val(opp_price.toLocaleString("en"));
    $('#prd_sample_price').val(proto_charge.toLocaleString("en"));
    $('#prd_trace_price').val(trace_charge.toLocaleString("en"));
    $('#beforeTax_disp').val(item_total_before_tax.toLocaleString("en"));
    $('#grandTotalDisp').val(item_total.toLocaleString("en"));

    $('#plateFee_disp').val(plate_fee.toLocaleString("en"));
    $('#processPrice_disp').val(process_price.toLocaleString("en"));
    $('#backsidePrice_disp').val(backside_price.toLocaleString("en"));
    $('#colorVariationPrice_disp').val(color_variation_price.toLocaleString("en"));

    var tax_included_total = item_total;
    $('.prd_total').text(tax_included_total.toLocaleString('ja-JP'));

    // Setup summary displays
    if ($("select[name=ft_size]").length) {
        $("#prd_size").text($("select[name=ft_size] option:selected").val() + "cm.");
    }
    $("#prd_ft_fabric_color1").text($("input[name=ft_fabric_color1]:checked").val());
    if ($("select[name=ft_backside_type]").length) {
        $("#prd_backside").text($("select[name=ft_backside_type] option:selected").val());
    } else if ($("input[name=ft_backside_type]").length) {
        $("#prd_backside").text($("input[name=ft_backside_type]:checked").val());
    }
    $("#prd_processing").text($("input[name=ft_process]:checked").val());
    $("#prd_material").text($("input[name=ft_option]:checked").val());
    $("#prd_qty").text($("#qty").val() || "");
}

// Expose to global scope explicitly (works even in strict-mode contexts)
// and replay any calls that were queued by the head placeholder
window.calcWappen = calcWappen;
if (window.__calcWappenQueue && window.__calcWappenQueue.length) {
    window.__calcWappenQueue.forEach(function (args) { calcWappen.apply(null, args); });
    window.__calcWappenQueue = [];
}

$(document).ready(function () {
    $(document).on("change", "input[name='ft_fabric_color1']", function () {
        if ($("#txt-show-Insatsu1").length > 0) {
            $("#txt-show-Insatsu1").text($(this).val());
            $("#txt-show-Insatsu1").removeClass("d-none");
        }
    });
});

