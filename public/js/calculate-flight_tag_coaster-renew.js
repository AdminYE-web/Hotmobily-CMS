// オリジナル刺繍コースター - DB-based pricing
// Tax-inclusive prices from item_price_master (for offline fallback)
var dbPrices = {
    // flighttagcoaster_embroidery_18_1side (id=395) — same as jacquard 1side
    '1side': [
        { rate: 50, price: 645 },
        { rate: 100, price: 543 },
        { rate: 300, price: 419 },
        { rate: 500, price: 377 },
        { rate: 1000, price: 326 },
        { rate: 3000, price: 281 }
    ],
    // flighttagcoaster_embroidery_18_2side (id=396) — same as jacquard 2side
    '2side': [
        { rate: 50, price: 903 },
        { rate: 100, price: 760 },
        { rate: 300, price: 587 },
        { rate: 500, price: 528 },
        { rate: 1000, price: 457 },
        { rate: 3000, price: 393 }
    ]
};

var unit_price = 0;
var window_lastCalcResult = null; // Store latest calc result for save_calc_data

function valid_chk_btn(c) {
    chk_color();
    if (check_val(c)) {
        $('#step1').fadeOut('fast');
        $('#step2').fadeOut('fast');
        $('#step3').fadeOut('fast');
        $('#dot-step1').removeClass('active');
        $('#dot-step2').removeClass('active');
        $('#dot-step3').removeClass('active');

        //New condition check button click
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

        //New condition check price adapt
        if ((currentClick != "" && currentClick !== undefined) && (currentClick === "金額計算・見積・注文へ")) {
            let price_value = setToInputManual();
            if (price_value && Object.keys(price_value).length !== 0) {
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
                    }, error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            }
        } else {
            if ((currentClick != "" && currentClick !== undefined) && (currentClick === "redirect")) {
                let pk = $('#strap').val();
                if (pk !== undefined && (pk != "刺繍キーホルダー")) {
                    let price_items = setToInputManual();
                    if (price_items && Object.keys(price_items).length !== 0) {
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
                            }, error: function (xhr, status, error) {
                                console.log(error);
                            }
                        });
                    }
                }
            }
        }
    }
}

function check_val(v) {
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

    $("input[name='ft_option']").off('change').change(function () {
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

    if (parseInt($('input[name=color_variation]').val()) > parseInt($('input[name=color_variation]').attr('max'))) {
        $('input[name=color_variation]').val($('input[name=color_variation]').attr('max'));
    } else if (parseInt($('input[name=color_variation]').val()) < 0) {
        $('input[name=color_variation]').val(0);
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

    if (isNaN(vNumberOfOder.value)) {
        mess += "<font color='red'>半角数値以外が入力されています。</font>";
        err_number.innerHTML = mess;
        return false;
    } else if (vNumberOfOder.value == '' || vNumberOfOder.value < 50) {
        mess += "<font color='red'>本数は50本以上で入力して下さい。</font>";
        err_number.innerHTML = mess;
        return false;
    } else if (vNumberOfOder.value > 50000) {
        mess += "<font color='red'>本数は50000本以下で入力して下さい。50000以上のお客様は納期をメールにてお問い合わせ下さい。</font>";
        err_number.innerHTML = mess;
        return false;
    } else {
        err_number.style.display = "none";
        return true;
    }
}

function updateUIPrice(res) {
    window_lastCalcResult = res; // Store for save_calc_data

    document.getElementById('prd_price').value = parseInt(res.StrapPrice).toLocaleString("en");
    document.getElementById('prd_mold_price').value = parseInt(res.MoldPrice).toLocaleString("en");
    document.getElementById('prd_process_price').value = parseInt(res.ProcessPrice).toLocaleString("en");
    if ($('#prd_backside_price').length) {
        document.getElementById('prd_backside_price').value = parseInt(res.BacksidePrice).toLocaleString("en");
    }
    document.getElementById('prd_color_price').value = parseInt(res.ColorPrice).toLocaleString("en");
    if ($('#prd_part_price').length) {
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

    $('input[name=BeforeTax]').val(res.BeforeTax);
    $('input[name=Tax]').val(res.Tax);
    $('input[name=grandTotal]').val(res.grandTotal);
    $('input[name=StrapPrice]').val(res.StrapPrice);
    $('input[name=PartPrice]').val(res.PartPrice);
    $('input[name=ProShipping]').val(res.ProShipping);
    $('input[name=TraceCharge]').val(res.TraceCharge);
    $('input[name=OPPPrice]').val(res.OPPPrice);
    $('input[name=MoldPrice]').val(res.MoldPrice);
    $('input[name=ProcessPrice]').val(res.ProcessPrice);
    $('input[name=BacksidePrice]').val(res.BacksidePrice);
    $('input[name=ColorPrice]').val(res.ColorPrice);
    $('input[name=discount]').val(res.discount);
}

function calculateOffline(data) {
    var qty = parseInt(data.qty) || 0;

    // Determine side: デザインあり = 2side, デザインなし = 1side
    var sideKey = (data.ft_backside === 'デザインなし') ? '1side' : '2side';
    var tiers = dbPrices[sideKey];

    // Pick tier price (tax-inclusive from DB)
    var pickedPriceTaxInc = tiers[0].price; // default to smallest tier
    for (var i = 0; i < tiers.length; i++) {
        if (tiers[i].rate <= qty) {
            pickedPriceTaxInc = tiers[i].price;
        }
    }

    // Convert to tax-exclusive
    var unitPriceTaxEx = pickedPriceTaxInc / 1.1;
    var strapPrice = Math.floor(unitPriceTaxEx * qty);

    var moldPrice = Math.round(4400 / 1.1);
    
    var processPrice = 0;
    if (data.ft_process && data.ft_process.indexOf('オーバーロック') !== -1) {
        processPrice = Math.round((55 / 1.1) * qty);
    }

    var backsidePrice = 0;
    if (data.ft_backside_type) {
        var bsMap = { 'マジックテープ': 55, 'アイロンテープ': 11, '接着シール': 55, 'クレジット印字': 55 };
        if (bsMap[data.ft_backside_type]) {
            backsidePrice = Math.round((bsMap[data.ft_backside_type] / 1.1) * qty);
        }
    }

    var colorPrice = 0;
    var cv = parseInt(data.color_variation) || 0;
    if (cv > 3) {
        colorPrice = Math.round(((cv - 3) * 22 / 1.1) * qty);
    }

    var partPrice = 0; // Coaster no parts

    var protoCharge = 0;
    if (data.ft_sample == 'あり' && qty < 300) {
        protoCharge = Math.round(5500 / 1.1);
    }

    var traceCharge = 0;
    if (data.ft_trace == 'あり') {
        traceCharge = Math.round(2200 / 1.1);
    }

    var oppPrice = 0;
    if (data.ft_opp == 'あり') {
        oppPrice = 7 * qty;
    }

    var discount = 0;
    if (data.keisai == '製作実績の掲載を許可する') {
        discount = Math.round(5500 / 1.1);
    }

    var beforeTax = strapPrice + moldPrice + processPrice + backsidePrice + colorPrice + partPrice + protoCharge + traceCharge + oppPrice;
    var subtotal = Math.max(0, beforeTax - discount);
    var tax = Math.floor(subtotal * 0.10);
    var grandTotal = subtotal + tax;

    var res = {
        StrapPrice: strapPrice,
        MoldPrice: moldPrice,
        ProcessPrice: processPrice,
        BacksidePrice: backsidePrice,
        ColorPrice: colorPrice,
        PartPrice: partPrice,
        ProShipping: protoCharge,
        TraceCharge: traceCharge,
        OPPPrice: oppPrice,
        BeforeTax: subtotal,
        Tax: tax,
        grandTotal: grandTotal,
        discount: discount,
        qty: qty
    };

    updateUIPrice(res);
}

function setToInput() {
    clearValue();
    var vno_of_order = document.getElementById('qty');

    if (vno_of_order.value != "") {
        var qty = parseInt(vno_of_order.value) || 0;
        var ItemType = $('input[name=ItemType]').val();
        var ftType = $('input[name=ft_type]:checked').val() || '刺繍';
        var ftSize = parseInt($('select[name=ft_size] option:selected').val()) || 5;
        
        var ftBackside = 'デザインなし';
        if ($('input[name=ft_backside]:checked').length) {
            ftBackside = $('input[name=ft_backside]:checked').val();
        }
        
        var ftBacksideType = '';
        if ($('select[name=ft_backside_type]').length) {
            ftBacksideType = $('select[name=ft_backside_type] option:selected').val() || '';
        }

        var ftProcess = $('input[name=ft_process]:checked').val() || 'ヒートカット仕上げ';
        var colorVariation = parseInt($('input[name=color_variation]').val()) || 0;
        var ftSample = $('input[name=ft_sample]:checked').val() || 'なし';
        var ftTrace = $('input[name=ft_trace]:checked').val() || 'なし';
        var ftOpp = $('input[name=ft_opp]:checked').val() || 'なし';
        
        var keisai = '';
        if ($('input[name=keisai]:checked').length) {
            keisai = $('input[name=keisai]:checked').val();
        }

        // Update Text Fields in UI for recap
        $('#sample-prd-prdt').text(ItemType);
        $('#prd_production').text(ItemType);
        $('#sample-prd-type').text(ftType);
        $('#prd_type').text(ftType);

        if ($(".template_free").length && ($('input[name=template_code]').length && $('input[name=template_code]').val() != "")) {
            $('#sample-prd-temp').text($('input[name=template_code]').val());
        }

        if ($('input[name=ft_option]:checked').length) {
            $('#prd_material').text($('input[name=ft_option]:checked').val());
        }

        $('#prd_fabric_color1').text($('select[name=ft_fabric_color1] option:selected').text());
        if ($('input[name=ft_fabric_color1]:checked').val() != undefined) {
            $('#prd_fabric_color1').text($('input[name=ft_fabric_color1]:checked').val());
        }
        if ($('#prd_fabric_color2').length) {
            $('#prd_fabric_color2').text(($('select[name=ft_fabric_color2] option:selected').val() == "" ? "表と同じ" : $('select[name=ft_fabric_color2] option:selected').text()));
            if ($('input[name=ft_fabric_color2]:checked').val() != undefined) {
                $('#prd_fabric_color2').text($('input[name=ft_fabric_color2]:checked').val());
            }
        }

        if ($('select[name=ft_size]').length) {
            $('#prd_size').text(ftSize + "cm.");
        }

        $('#prd_processing').text(ftProcess + (ftProcess != "オーバーロック仕上げ" ? "" :
            ($('select[name=ft_overlock_color]').length ? "(" + $('select[name=ft_overlock_color] option:selected').val() + ")" : "")));

        $('#sample-prd-qty').text(qty);
        $('#prd_amount').text(qty);

        if ($('input[name=ft_backside]').length) {
            if (ftBackside == "デザインあり" || ftBackside == "ロック式の安全ピン" || ftBackside == "バタフライクラッチ") {
                $('#prd_backside').text(ftBackside);
            } else {
                if ($('select[name=ft_backside_type]').length) {
                    $('#prd_backside').text(ftBacksideType || 'デザインなし');
                } else {
                    $('#prd_backside').text(ftBackside);
                }
            }
        } else {
            if ($('select[name=ft_backside_type]').length) {
                $('#prd_backside').text(ftBacksideType || '加工なし');
            }
        }

        if (ftSample != "なし") {
            $('#prd_sample').text('あり');
            $('#sample-prd-samp').text('あり');
        } else {
            $('#prd_sample').text('なし');
            $('#sample-prd-samp').text('なし');
        }

        if (ftTrace != "なし") {
            $('#prd_trace').text('あり');
        } else {
            $('#prd_trace').text('なし');
        }

        if (ftOpp != "なし") {
            $('#prd_opp').text('あり');
            $('#sample-prd-opp').text('あり');
        } else {
            $('#prd_opp').text('なし');
            $('#sample-prd-opp').text('なし');
        }

        $('#prd_qty').text(qty);
        
        if ($('input[name=color_variation]').length) {
            $('#prd_color_variation').text(colorVariation);
        }

        if ($('input[name=keisai]:checked').length) {
            $('#prd_web').text(keisai);
        }

        var formData = {
            ItemType: ItemType,
            ft_type: ftType,
            ft_size: ftSize,
            ft_backside: ftBackside,
            ft_backside_type: ftBacksideType,
            ft_process: ftProcess,
            color_variation: colorVariation,
            numberOf: qty,
            qty: qty,
            ft_sample: ftSample,
            ft_trace: ftTrace,
            ft_opp: ftOpp,
            keisai: keisai
        };

        $('.total-price .prd_total').text('計算中...');

        $.post('/products/ajax_calculate_price_flight_tag_coaster.php', formData, function(response) {
            if (response.success) {
                updateUIPrice(response);
            } else {
                console.warn('DB pricing failed, using local calculation:', response.error);
                calculateOffline(formData);
            }
        }, 'json').fail(function(jqXHR) {
            console.warn('Ajax call failed, using local calculation:', jqXHR.responseText);
            calculateOffline(formData);
        });
    }
}

function setToInputManual() {
    var vno_of_order = document.getElementById('qty');
    var prd = $('#strap').val();
    
    if (vno_of_order.value != "" && window_lastCalcResult != null) {
        var qty = parseInt(vno_of_order.value) || 0;
        var r = window_lastCalcResult;
        
        let shipping_price = 880;
        if (r.BeforeTax > 11000) { // Tax-exclusive comparison is correct since standard was tax-inclusive >11000 but we assume before tax > 11000 or grand total > 11000? Let's use 11000. Wait, actually we can just check if grandTotal >= 11000.
            shipping_price = 0;
        }
        if (r.grandTotal >= 11000) {
            shipping_price = 0;
        }

        let sku_name = "flight-tag-coaster";
        
        if (sku_name != "") {
            return {
                sku: sku_name,
                product: prd || '刺繍コースター', 
                qty: qty,  
                product_price: r.StrapPrice, 
                mold_price: r.MoldPrice,
                part_price: r.PartPrice,
                backside_price: r.BacksidePrice, 
                paper_price: 0,
                prototype_price: r.ProShipping,
                ai_assistant_price: 0,
                trace_price: r.TraceCharge,
                opp_price: r.OPPPrice,
                process_price: r.ProcessPrice, 
                color_price: r.ColorPrice, 
                discount: r.discount,
                shipping: shipping_price,
                vat: r.Tax, // Pass VAT correctly
                tax: r.Tax, 
                subtotal: r.BeforeTax,
                total: r.grandTotal
            };
        }
    }
    return {};
}

function changeOptionValues(prefix, startIndex, selectName) {
    var color_f_arr = [
        '108 （赤色）', '63 （緑）', '83 （紺藍）', '76 （紅赤）', '30 （オレンジ色）',
        '131 （えんじ）', '78 （藤紫）', '74 （紫色）', '135 （山吹色）', '32 （黄色）',
        '9 （ピンク）', '94 （茶色）', '35（黄緑色）', '66（ビリジアン）', '46（スカイブルー）',
        '52（青色）', '12（牡丹色）', '129（灰色）', '123（黒色）', '1（白）',
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
                var newValue = prefix + "-" + (index + startIndex);
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
    document.getElementById('prd_opp_price').value = "";
    document.getElementById('prd_sample_price').value = "";
    document.getElementById('prd_price').value = "";
    document.getElementById('prd_sub_total').value = "";
    document.getElementById('prd_total').value = "";
}

function setzero() {
    clearValue();
    document.getElementById('prd_opp_price').value = "";
    document.getElementById('prd_trace_price').value = "";
    document.getElementById('prd_sample_price').value = "";
    document.getElementById('prd_price').value = "";
    document.getElementById('prd_sub_total').value = "";
    document.getElementById('prd_total').value = "";

    $("input[name=ft_type]:first").prop('checked', true);
    $("input[name=ft_option]:first").prop('checked', true);
    $("input[name=ft_sample]").prop('checked', false);
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

function getPartData(v) {
    setToInput();
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
})

function formatNumber(number) {
    if (number >= 0 && number <= 8) {
        return '0' + (number + 1);
    } else if (number >= 9) {
        return '' + (number + 1);
    }
}

function pre_set(elm) {
    $('html, body').animate({
        scrollTop: $("#form").offset().top
    }, 1000);

    var size = $(elm).attr('data-size');
    var qty = $(elm).attr('data-qty');
    var side = $(elm).attr('data-side');

    $('select[name=ft_size]').val(size);
    $('input[name=qty]').val(qty);

    if (side != "") {
        $('input[name=ft_backside]:eq(' + side + ')').prop('checked', true);
    }
    check_val('next');
}
