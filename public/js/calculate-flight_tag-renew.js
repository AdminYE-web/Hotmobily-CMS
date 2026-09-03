// Flight Tag Calculator (Renewed with DB Pricing + separate VAT 10%)

var ft_1 = [737, 554, 349, 291, 234, 180]; // Embroidery
var ft_2 = [706, 529, 310, 248, 198, 145]; // Jacquard
var ft_3 = [631, 451, 279, 231, 185, 139]; // Sublimation

var unit_price = 0;
var order_pcs = 0;
var before_tax = 0;
var tax = 0;
var total = 0;
var parts_obj;
var partPrice = 0;
var vat = 10;

function valid_chk_btn(c) {
    chk_color();
    if (check_val(c)) {
        $('#step1').fadeOut('fast');
        $('#step2').fadeOut('fast');
        $('#step3').fadeOut('fast');
        $('#dot-step1').removeClass('active');
        $('#dot-step2').removeClass('active');
        $('#dot-step3').removeClass('active');

        let currentClick = null;
        if (typeof event !== "undefined" && event && event.target) {
            currentClick = $(event.target).text();
        } else {
            currentClick = "redirect";
        }

        switch ($('#next').text()) {
            case "オプション入力へ":
                if (c == 'next' || c == 'step2') {
                    $('#back').fadeIn('slow');
                    $('#next').text('金額計算・見積・注文へ');
                    $('#next').blur();
                    $('#step2').fadeIn('slow');
                    $('#dot-step1').addClass('active');
                    $('#dot-step2').addClass('active');
                } else if (c == 'step3') {
                    $('#next').text('金額計算・見積・注文へ');
                    $('#next').blur();
                    $('#step3').fadeIn('slow');
                    $('#back').fadeOut('fast');
                    $('#next').fadeOut('fast');
                    $('#dot-step1').addClass('active');
                    $('#dot-step2').addClass('active');
                    $('#dot-step3').addClass('active');
                }
                break;
            case "金額計算・見積・注文へ":
                if (c == 'next') {
                    $('#step3').fadeIn('slow');
                    $('#back').fadeOut('fast');
                    $('#next').fadeOut('fast');
                    $('#dot-step1').addClass('active');
                    $('#dot-step2').addClass('active');
                    $('#dot-step3').addClass('active');
                } else if (c == 'back' || c == 'step1') {
                    $('#next').fadeIn('slow');
                    $('#step1').fadeIn('slow');
                    $('#next').text('オプション入力へ');
                    $('#next').blur();
                    $('#back').fadeOut('fast');
                    $('#dot-step1').addClass('active');
                } else {
                    $('#back').fadeIn('slow');
                    $('#next').fadeIn('slow');
                    $('#next').text('金額計算・見積・注文へ');
                    $('#next').blur();
                    $('#step2').fadeIn('slow');
                    $('#dot-step1').addClass('active');
                    $('#dot-step2').addClass('active');
                }
        }
        $(window).scrollTop($('.step-container').offset().top);

        if ((currentClick != "" && currentClick !== undefined) && (currentClick === "金額計算・見積・注文へ")) {
            let price_value = setToInputManual();
            if (Object.keys(price_value).length !== 0) {
                $.ajax({
                    type: "POST",
                    url: "/products/save_calc_data.php",
                    data: price_value,
                    success: function (response) {
                        if (response.status == 200 && response.calculation_token) {
                            $('#calculation_token').remove();
                            $('<input>').attr({
                                type: 'hidden',
                                id: 'calculation_token',
                                name: 'calculation_token',
                                value: response.calculation_token
                            }).appendTo('form#form');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            }
        } else {
            if ((currentClick != "" && currentClick !== undefined) && (currentClick === "redirect")) {
                let price_items = setToInputManual();
                if (Object.keys(price_items).length !== 0) {
                    $.ajax({
                        type: "POST",
                        url: "/products/save_calc_data.php",
                        data: price_items,
                        success: function (response) {
                            if (response.status == 200 && response.calculation_token) {
                                $('#calculation_token').remove();
                                $('<input>').attr({
                                    type: 'hidden',
                                    id: 'calculation_token',
                                    name: 'calculation_token',
                                    value: response.calculation_token
                                }).appendTo('form#form');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            }
        }
    }
}

function check_val(v) {
    var ItemType = $('input[name=ItemType]').val();

    if ($('input[name=ft_process]:checked').val() == "オーバーロック仕上げ") {
        $('.overlock_only').show();
    } else {
        $('.overlock_only').hide();
    }

    if ($('input[name=ft_backside]').length) {
        if ($('input[name=ft_backside]:checked').val() == "デザインなし") {
            $('.no-designs').show();
        } else {
            $('.no-designs').hide();
        }
    }

    $("input[name='ft_option']").on('change', function () {
        if ($(this).val() == 'フェルト生地') {
            changeOptionValues("f", 1, "ft_fabric_color1");
            if ($('select[name=ft_fabric_color2]').length) {
                changeOptionValues("f", 1, "ft_fabric_color2");
            }
        } else if ($(this).val() == 'ツイル生地') {
            changeOptionValues("t", 1, "ft_fabric_color1");
            if ($('select[name=ft_fabric_color2]').length) {
                changeOptionValues("t", 1, "ft_fabric_color2");
            }
        }
    });

    if (v == "step3") {
        chk_color();
        if ($("input[name='ft_option']:checked").val() == 'フェルト生地') {
            changeOptionValues("f", 1, "ft_fabric_color1");
            if ($('select[name=ft_fabric_color2]').length) {
                changeOptionValues("f", 1, "ft_fabric_color2");
            }
        } else if ($("input[name='ft_option']:checked").val() == 'ツイル生地') {
            changeOptionValues("t", 1, "ft_fabric_color1");
            if ($('select[name=ft_fabric_color2]').length) {
                changeOptionValues("t", 1, "ft_fabric_color2");
            }
        }
    }

    if ($('input[name=ft_type]:checked').val() == "ジャガード織" || $('input[name=ft_type]:checked').val() == "昇華転写") {
        $('.only_embro').hide();
    } else {
        $('.only_embro').show();
    }

    if (v == 'next') {
        if (!validation_numberOf()) {
            return false;
        } else {
            setToInput();
            return true;
        }
    } else {
        setToInput();
        return true;
    }
}

function validation_numberOf() {
    var err_number = document.getElementById('err_numberOf_mess');
    var mess = "";
    err_number.style.display = "";

    var vNumberOfOder = document.getElementById('qty');
    var val = parseInt(vNumberOfOder.value);

    if (isNaN(val)) {
        mess += "<font color='red'>半角数値以外が入力されています。</font>";
        err_number.innerHTML = mess;
        return false;
    } else if (val < 50) {
        mess += "<font color='red'>本数は50本以上で入力して下さい。</font>";
        err_number.innerHTML = mess;
        return false;
    } else if (val > 50000) {
        mess += "<font color='red'>本数は50000本以下で入力して下さい。50000以上のお客様は納期をメールにてお問い合わせ下さい。</font>";
        err_number.innerHTML = mess;
        return false;
    } else {
        err_number.style.display = "none";
        return true;
    }
}

function getPartData(v) {
    if ($('input[name=ItemType]').val() == "フライトタグ（刺繍タグキーホルダー）") {
        $.get("part_flight_tag.php", { c: "passed" }, function (data) {
            try {
                var duce = $.parseJSON(data);
                for (var i = 0; i < duce.length; i++) {
                    if (duce[i]['part_name'] == v) {
                        parts_obj = duce[i];
                    }
                }
            } catch (e) {
                parts_obj = { "part_name": v, "part_price": (v == "銀色ナスカン" ? 20 : 0) };
            }
        }).fail(function () {
            parts_obj = { "part_name": v, "part_price": (v == "銀色ナスカン" ? 20 : 0) };
        }).always(function () {
            setToInput();
        });
    } else if ($('input[name=ItemType]').val() == "刺繍キーホルダー") {
        $.get("part_flight_tag_keyholder.php", { c: "passed" }, function (data) {
            try {
                var duce = $.parseJSON(data);
                for (var i = 0; i < duce.length; i++) {
                    if (duce[i]['part_name'] == v) {
                        parts_obj = duce[i];
                    }
                }
            } catch (e) {
                parts_obj = { "part_name": v, "part_price": (v == "銀色ナスカン" ? 20 : 0) };
            }
        }).fail(function () {
            parts_obj = { "part_name": v, "part_price": (v == "銀色ナスカン" ? 20 : 0) };
        }).always(function () {
            setToInput();
        });
    }
}

function setToInput() {
    clearValue();
    var vno_of_order = document.getElementById('qty');
    if (vno_of_order.value == "") return;

    var qty = parseInt(vno_of_order.value);
    var itemType = $('input[name=ItemType]').val();
    var ft_type = $('input[name=ft_type]:checked').val();
    var ft_option = $('input[name=ft_option]:checked').val();
    var ft_fabric_color1 = $('select[name=ft_fabric_color1] option:selected').text();
    if ($('input[name=ft_fabric_color1]:checked').val() != undefined) {
        ft_fabric_color1 = $('input[name=ft_fabric_color1]:checked').val();
    }
    var ft_fabric_color2 = "";
    if ($('#prd_fabric_color2').length) {
        ft_fabric_color2 = ($('select[name=ft_fabric_color2] option:selected').val() == "" ? "表と同じ" : $('select[name=ft_fabric_color2] option:selected').text());
        if ($('input[name=ft_fabric_color2]:checked').val() != undefined) {
            ft_fabric_color2 = $('input[name=ft_fabric_color2]:checked').val();
        }
    }
    var ft_process = $('input[name=ft_process]:checked').val() + ($('input[name=ft_process]:checked').val() != "オーバーロック仕上げ" ? "" :
        ($('select[name=ft_overlock_color]').length ? "(" + $('select[name=ft_overlock_color] option:selected').val() + ")" : ""));

    var part = $('input[name="part"]:checked').val() || "なし";
    var ft_attach_type = $('input[name=ft_attach_type]:checked').val() || "";

    var ft_sample = $('input[name=ft_sample]:checked').val() || "なし";
    var ft_trace = $('input[name=ft_trace]:checked').val() || "なし";
    var ft_opp = $('input[name=ft_opp]:checked').val() || "なし";

    // Set UI specifications
    $('#sample-prd-prdt').text(itemType);
    $('#prd_production').text(itemType);
    $('#sample-prd-type').text(ft_type);
    $('#prd_type').text(ft_type);
    $('#prd_material').text(ft_option);
    $('#prd_fabric_color1').text(ft_fabric_color1);
    if ($('#prd_fabric_color2').length) {
        $('#prd_fabric_color2').text(ft_fabric_color2);
    }
    $('#prd_processing').text(ft_process);
    $('#sample-prd-qty').text(qty);
    $('#prd_amount').text(qty);

    if (parts_obj != undefined) {
        partPrice = parseInt(parts_obj["part_price"]) || 0;
        if (part != "なし") {
            $('#sample-part-pic').show();
            $('#sample-part-pic').attr('src', parts_obj["part_pic"]);
            $('#sample-part-name').text(parts_obj["part_name"]);
        } else {
            $('#sample-part-pic').hide();
            $('#sample-part-name').text('');
        }
    } else {
        partPrice = (part == "銀色ナスカン" ? 20 : 0);
    }

    if (part != "なし") {
        $('#prd_part').text(part + (ft_attach_type != "" ? "(" + ft_attach_type + ")" : ""));
    } else {
        $('#prd_part').text("なし");
    }

    $('#prd_sample').text(ft_sample);
    $('#sample-prd-samp').text(ft_sample);
    $('#prd_trace').text(ft_trace);
    $('#prd_opp').text(ft_opp);
    $('#sample-prd-opp').text(ft_opp);
    $('#prd_qty').text(qty);

    var deliveryPrice = 880;
    var postData = {
        ItemType: itemType,
        ft_type: ft_type,
        ft_option: ft_option,
        ft_fabric_color1: ft_fabric_color1,
        ft_fabric_color2: ft_fabric_color2,
        ft_process: ft_process,
        part: part,
        ft_attach_type: ft_attach_type,
        ft_sample: ft_sample,
        ft_trace: ft_trace,
        ft_opp: ft_opp,
        qty: qty,
        delivery_price: deliveryPrice
    };

    // Call AJAX first
    $.ajax({
        type: "POST",
        url: "/products/ajax_calculate_price_flight_tag.php",
        data: postData,
        dataType: "json",
        success: function (res) {
            if (res.success) {
                updateUIPrice(res);
            } else {
                calculateOffline(postData);
            }
        },
        error: function () {
            calculateOffline(postData);
        }
    });
}

function updateUIPrice(res) {
    document.getElementById('prd_price').value = parseInt(res.StrapPrice).toLocaleString("en");
    if (document.getElementById('prd_part_price')) {
        document.getElementById('prd_part_price').value = parseInt(res.PartPrice).toLocaleString("en");
    }
    document.getElementById('prd_sample_price').value = parseInt(res.ProShipping).toLocaleString("en");
    document.getElementById('prd_trace_price').value = parseInt(res.TraceCharge).toLocaleString("en");
    document.getElementById('prd_opp_price').value = parseInt(res.OPPPrice).toLocaleString("en");
    document.getElementById('prd_sub_total').value = parseInt(res.BeforeTax).toLocaleString("en");
    if (document.getElementById('prd_tax')) {
        document.getElementById('prd_tax').value = parseInt(res.Tax).toLocaleString("en");
    }
    document.getElementById('discount').value = parseInt(res.discount).toLocaleString("en");
    document.getElementById('prd_total').value = parseInt(res.grandTotal).toLocaleString("en");
    $('.prd_total').text(parseInt(res.grandTotal).toLocaleString("en"));

    // Set hidden fields
    updateHiddenFields(res);
}

function updateHiddenFields(res) {
    if (!$('input[name=BeforeTax]').length) $('<input>').attr({ type: 'hidden', name: 'BeforeTax' }).appendTo('form#form');
    if (!$('input[name=Tax]').length) $('<input>').attr({ type: 'hidden', name: 'Tax' }).appendTo('form#form');
    if (!$('input[name=grandTotal]').length) $('<input>').attr({ type: 'hidden', name: 'grandTotal' }).appendTo('form#form');
    if (!$('input[name=StrapPrice]').length) $('<input>').attr({ type: 'hidden', name: 'StrapPrice' }).appendTo('form#form');
    if (!$('input[name=PartPrice]').length) $('<input>').attr({ type: 'hidden', name: 'PartPrice' }).appendTo('form#form');
    if (!$('input[name=ProShipping]').length) $('<input>').attr({ type: 'hidden', name: 'ProShipping' }).appendTo('form#form');
    if (!$('input[name=TraceCharge]').length) $('<input>').attr({ type: 'hidden', name: 'TraceCharge' }).appendTo('form#form');
    if (!$('input[name=OPPPrice]').length) $('<input>').attr({ type: 'hidden', name: 'OPPPrice' }).appendTo('form#form');
    if (!$('input[name=MoldPrice]').length) $('<input>').attr({ type: 'hidden', name: 'MoldPrice' }).appendTo('form#form');
    if (!$('input[name=ProcessPrice]').length) $('<input>').attr({ type: 'hidden', name: 'ProcessPrice' }).appendTo('form#form');
    if (!$('input[name=BacksidePrice]').length) $('<input>').attr({ type: 'hidden', name: 'BacksidePrice' }).appendTo('form#form');
    if (!$('input[name=ColorPrice]').length) $('<input>').attr({ type: 'hidden', name: 'ColorPrice' }).appendTo('form#form');
    if (!$('input[name=discount]').length) $('<input>').attr({ type: 'hidden', name: 'discount' }).appendTo('form#form');
    if (!$('input[name=numberOf]').length) $('<input>').attr({ type: 'hidden', name: 'numberOf' }).appendTo('form#form');

    $('input[name=BeforeTax]').val(res.BeforeTax);
    $('input[name=Tax]').val(res.Tax);
    $('input[name=grandTotal]').val(res.grandTotal);
    $('input[name=StrapPrice]').val(res.StrapPrice);
    $('input[name=PartPrice]').val(res.PartPrice);
    $('input[name=ProShipping]').val(res.ProShipping);
    $('input[name=TraceCharge]').val(res.TraceCharge);
    $('input[name=OPPPrice]').val(res.OPPPrice);
    $('input[name=MoldPrice]').val(res.MoldPrice || 0);
    $('input[name=ProcessPrice]').val(res.ProcessPrice || 0);
    $('input[name=BacksidePrice]').val(res.BacksidePrice || 0);
    $('input[name=ColorPrice]').val(res.ColorPrice || 0);
    $('input[name=discount]').val(res.discount || 0);
    $('input[name=numberOf]').val($('#qty').val());
}

function calculateOffline(data) {
    var qty = data.qty;
    var order_pcs = 0;

    if (data.ft_type == "刺繍") {
        if (qty >= 3000) order_pcs = ft_1[5];
        else if (qty >= 1000) order_pcs = ft_1[4];
        else if (qty >= 500) order_pcs = ft_1[3];
        else if (qty >= 300) order_pcs = ft_1[2];
        else if (qty >= 100) order_pcs = ft_1[1];
        else if (qty >= 50) order_pcs = ft_1[0];
    } else if (data.ft_type == "ジャガード織") {
        if (qty >= 3000) order_pcs = ft_2[5];
        else if (qty >= 1000) order_pcs = ft_2[4];
        else if (qty >= 500) order_pcs = ft_2[3];
        else if (qty >= 300) order_pcs = ft_2[2];
        else if (qty >= 100) order_pcs = ft_2[1];
        else if (qty >= 50) order_pcs = ft_2[0];
    } else {
        if (qty >= 3000) order_pcs = ft_3[5];
        else if (qty >= 1000) order_pcs = ft_3[4];
        else if (qty >= 500) order_pcs = ft_3[3];
        else if (qty >= 300) order_pcs = ft_3[2];
        else if (qty >= 100) order_pcs = ft_3[1];
        else if (qty >= 50) order_pcs = ft_3[0];
    }

    // Convert tax-inclusive base prices to tax-exclusive
    var strapPrice = Math.round((order_pcs / 1.1) * qty);

    // partPrice (from parts_obj) is already tax-exclusive (e.g. ナスカン=20),
    // so use it directly without dividing by 1.1
    var localPartPrice = partPrice * qty;
    
    var proShipping = 0;
    if (data.ft_sample == "あり" && qty < 300) {
        proShipping = Math.round(5500 / 1.1);
    }
    
    var traceCharge = 0;
    if (data.ft_trace == "あり") {
        traceCharge = Math.round(2200 / 1.1);
    }

    // OPP packing fee: 7円/unit tax-exclusive
    var oppPrice = 0;
    if (data.ft_opp == "あり") {
        oppPrice = 7 * qty;
    }

    var discount = 0;
    var beforeTax = strapPrice + localPartPrice + proShipping + traceCharge + oppPrice;
    var subtotal = Math.max(0, beforeTax - discount);
    var localTax = Math.floor(subtotal * 0.10);
    var grandTotal = subtotal + localTax;

    var res = {
        StrapPrice: strapPrice,
        PartPrice: localPartPrice,
        ProShipping: proShipping,
        TraceCharge: traceCharge,
        OPPPrice: oppPrice,
        BeforeTax: subtotal,
        Tax: localTax,
        grandTotal: grandTotal,
        discount: discount,
        delivery_price: 880
    };

    updateUIPrice(res);
}

function setToInputManual() {
    var vno_of_order = document.getElementById('qty');
    var prd = $('#strap').val();

    if (vno_of_order.value != "") {
        var beforeTaxVal = parseInt($('input[name=BeforeTax]').val()) || 0;
        var taxVal = parseInt($('input[name=Tax]').val()) || 0;
        var totalVal = parseInt($('input[name=grandTotal]').val()) || 0;
        var strapPriceVal = parseInt($('input[name=StrapPrice]').val()) || 0;
        var partPriceVal = parseInt($('input[name=PartPrice]').val()) || 0;
        var proShippingVal = parseInt($('input[name=ProShipping]').val()) || 0;
        var traceChargeVal = parseInt($('input[name=TraceCharge]').val()) || 0;
        var oppPriceVal = parseInt($('input[name=OPPPrice]').val()) || 0;
        var discountVal = parseInt($('input[name=discount]').val()) || 0;

        var shipping_price = 880;
        if (totalVal > 11000) {
            shipping_price = 0;
        }

        var sku_name = 'flight-tag';

        return {
            sku: sku_name,
            product: prd,
            qty: vno_of_order.value,
            product_price: strapPriceVal,
            mold_price: 0,
            part_price: partPriceVal,
            backside_price: 0,
            paper_price: 0,
            prototype_price: proShippingVal,
            ai_assistant_price: 0,
            trace_price: traceChargeVal,
            opp_price: oppPriceVal,
            process_price: 0,
            color_price: 0,
            discount: discountVal,
            shipping: shipping_price,
            vat: 10,
            tax: taxVal,
            subtotal: beforeTaxVal,
            total: totalVal
        };
    }
    return {};
}

function changeOptionValues(prefix, startIndex, selectName) {
    var color_f_arr = [
        '108 （赤色）', '63 （緑）', '83 （紺藍）', '76 （紅赤）', '30 （オレンジ色）',
        '131 （えんじ）', '78 （藤紫）', '74 （紫色）', '135 （山吹色）', '32 （黄色）',
        '9 （ピンク）', '94 （茶色）', '35（黄緑色）', '66（ビリジアン）', '46（スカイブルー）',
        '52（青色））', '12（牡丹色）', '129（灰色）', '123（黒色）', '1（白）',
        '88（ネイビー）', '126（ダークブルー）'
    ];
    var color_t_arr = [
        'T184（赤色）', 'T223（緑色）', 'T47（紺藍）', 'T244（紅赤）', 'T142（オレンジ色）',
        'T95（えんじ）', 'T202（藤紫）', 'T258（紫色）', 'T214（山吹色）', 'T54（黄色）',
        'T122（ピンク）', 'T219（茶色）', 'T24（黄緑色）', 'T218（ビリジアン）', 'T32（スカイブルー）',
        'T37（青色）', 'T198（牡丹色）', 'T256（灰色）', '1.2mmBLACA（黒色）', 'T01B（白）',
        'T199（ネイビー）', 'T108（ダークブルー）'
    ];

    if ($("select[name='" + selectName + "'] option").length) {
        $("select[name='" + selectName + "'] option").each(function (index) {
            if ($(this).val() != "表と同じ") {
                var newValue = (prefix === "f") ? prefix + "-" + (index + startIndex) : prefix + "-" + (index + startIndex);
                $(this).text(newValue);
            } else {
                --startIndex;
            }
        });
    } else if ($('input[name=ft_fabric_color1]:checked').val() != undefined) {
        if ($('.STD_printing_color1').length) {
            if (prefix == "t") {
                $('.STD_printing_color1').each(function (index) {
                    $(this).attr('value', color_f_arr[index]);
                    if ($(this).closest('td').find('img').attr('src') != undefined) {
                        $(this).closest('td').find('img').attr('src', 'images/flight_tag/icon-' + formatNumber(index) + '.webp');
                    }
                })
            } else {
                $('.STD_printing_color1').each(function (index) {
                    $(this).attr('value', color_t_arr[index]);
                    if ($(this).closest('td').find('img').attr('src') != undefined) {
                        $(this).closest('td').find('img').attr('src', 'images/flight_tag/wappen-icon-' + formatNumber(index) + '.webp');
                    }
                })
            }
        }
        if ($('.STD_printing_color2').length) {
            if (prefix == "t") {
                $('.STD_printing_color2').each(function (index) {
                    $(this).attr('value', color_f_arr[index]);
                    if ($(this).closest('td').find('img').attr('src') != undefined) {
                        $(this).closest('td').find('img').attr('src', 'images/flight_tag/icon-' + formatNumber(index) + '.webp');
                    }
                })
            } else {
                $('.STD_printing_color2').each(function (index) {
                    $(this).attr('value', color_t_arr[index]);
                    if ($(this).closest('td').find('img').attr('src') != undefined) {
                        $(this).closest('td').find('img').attr('src', 'images/flight_tag/wappen-icon-' + formatNumber(index) + '.webp');
                    }
                })
            }
        }
    }
}

function clearValue() {
    unit_price = 0;
    before_tax = 0;
    tax = 0;
    total = 0;
    partPrice = 0;

    document.getElementById('prd_opp_price').value = "";
    document.getElementById('prd_sample_price').value = "";
    document.getElementById('prd_trace_price').value = "";
    if (document.getElementById('prd_part_price')) {
        document.getElementById('prd_part_price').value = "";
    }

    document.getElementById('prd_price').value = "";
    document.getElementById('prd_sub_total').value = "";
    if (document.getElementById('prd_tax')) {
        document.getElementById('prd_tax').value = "";
    }
    if (document.getElementById('discount')) {
        document.getElementById('discount').value = "";
    }
    document.getElementById('prd_total').value = "";
}

function setzero() {
    clearValue();
    $("input[name=ft_type]:first").prop('checked', true);
    $("input[name=ft_option]:first").prop('checked', true);
    $("input[name=ft_sample]").prop('checked', false);
    $("input[name=ft_trace]").prop('checked', false);
    $("input[name=ft_opp]").prop('checked', false);
    document.getElementById('qty').value = "";
}

function formatMoney(inum) {
    if (inum == '0' || inum == '') {
        return inum;
    }
    var s_inum = new String(inum);
    var s_inumInt = s_inum.split(".", s_inum);
    var l_inum = s_inumInt[0].length;
    var n_inum = "";
    for (i = 0; i < l_inum; i++) {
        if (parseInt(l_inum - i) % 3 == 0) {
            if (i == 0) {
                n_inum += s_inum.charAt(i);
            } else {
                n_inum += "," + s_inum.charAt(i);
            }
        } else {
            n_inum += s_inum.charAt(i);
        }
    }
    if (s_inumInt[1] != undefined) {
        n_inum += "." + s_inumInt[1];
    }
    return n_inum;
}

function check_num() {
    m = String.fromCharCode(event.keyCode);
    if ("0123456789\b\r".indexOf(m, 0) < 0) return false;
    return true;
}

function format_number(number) {
    if (number != "") {
        number = parseInt(number) + 0;
    }
    return number;
}

function chk_color() {
    var color_1 = "";
    var color_2 = "";

    if ($('input[name=ft_fabric_color1]:checked').val() != undefined) {
        color_1 = $('input[name=ft_fabric_color1]:checked').val();
        if ($('input[name=ft_fabric_color1]:checked').parent().find('img').attr('src') != "") {
            $('#img-show-Insatsu1').removeClass('d-none');
            $('#img-show-Insatsu1').attr('src', $('input[name=ft_fabric_color1]:checked').parent().find('img').attr('src'));
            $('#txt-show-Insatsu1').removeClass('d-none');
            $('#txt-show-Insatsu1').text(color_1);
        }
        if (color_1 == "PANTONE/DIC指定") {
            $('#img-show-Insatsu1').addClass('d-none');
            $('#img-show-Insatsu1').attr('src', "");
            $('#txt-show-Insatsu1').removeClass('d-none');
            $('#txt-show-Insatsu1').text('PANTONE/DIC指定');
        }
        $('#prd_fabric_color1').text(color_1);
    }
    if ($('input[name=ft_fabric_color2]:checked').val() != undefined) {
        color_2 = $('input[name=ft_fabric_color2]:checked').val();
        if ($('input[name=ft_fabric_color2]:checked').parent().find('img').attr('src') != "") {
            $('#img-show-Insatsu2').removeClass('d-none');
            $('#img-show-Insatsu2').attr('src', $('input[name=ft_fabric_color2]:checked').parent().find('img').attr('src'));
            $('#txt-show-Insatsu2').removeClass('d-none');
            $('#txt-show-Insatsu2').text(color_2);
        }
        if (color_2 == "PANTONE/DIC指定") {
            $('#img-show-Insatsu2').addClass('d-none');
            $('#img-show-Insatsu2').attr('src', "");
            $('#txt-show-Insatsu2').removeClass('d-none');
            $('#txt-show-Insatsu2').text('PANTONE/DIC指定');
        }
        $('#prd_fabric_color2').text(color_2);
    }
}

$(function () {
    $('.STD_printing_color1, .STD_printing_color2').click(function () {
        chk_color();
    });
});

function formatNumber(number) {
    if (number >= 0 && number <= 8) {
        return '0' + (number + 1);
    } else if (number >= 9) {
        return '' + (number + 1);
    }
}
