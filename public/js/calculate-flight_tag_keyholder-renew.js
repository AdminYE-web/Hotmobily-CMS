// ===== Flight Tag Keyholder (刺繍キーホルダー) - Renew Calculator =====
// Uses DB-based pricing with AJAX, shows tax-exclusive + VAT 10% separately.
// Product code: flight_tag_keyholder

// Base price tiers (tax-exclusive)
var wp_1 = [450, 348, 224, 182, 131, 86];

var order_pcs = 0;
var process_price = 0;
var backside_price = 0;
var color_variation_price = 0;
var unit_price = 0;
var pcs_price = 0;
var before_tax = 0;
var tax = 0;
var vat = 10;
var total = 0;
var silkprint = 0;
var TextField7Value = 0;
var TextField9Value = 0;
var DisPrice = 0;
var proto_charge = 0;
var trace_charge = 0;
var opp_price = 0;
var design_price = 0;

var parts_obj;
var partPrice = 0;
var paperPrice = 0;

// ===== STEP NAVIGATION =====
function valid_chk_btn(c) {
    chk_color();
    if (check_val(c)) {
        $('#step1').fadeOut('fast');
        $('#step2').fadeOut('fast');
        $('#step3').fadeOut('fast');
        $('#dot-step1').removeClass('active');
        $('#dot-step2').removeClass('active');
        $('#dot-step3').removeClass('active');

        var currentClick = null;
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
                    setToInput();
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

        // Determine if we're entering step 3
        var enteringStep3 = false;
        if (c == 'step3') {
            enteringStep3 = true;
        }
        if ((currentClick != "" && currentClick !== undefined) && (currentClick === "金額計算・見積・注文へ")) {
            enteringStep3 = true;
        }
        if ((currentClick != "" && currentClick !== undefined) && (currentClick === "redirect")) {
            enteringStep3 = true;
        }

        if (enteringStep3) {
            // Always calculate prices when entering step 3
            setToInput();

            // Also save calculation data
            setTimeout(function() {
                var price_value = setToInputManual();
                if (Object.keys(price_value).length !== 0) {
                    $.ajax({
                        type: "POST",
                        url: "/products/save_calc_data.php",
                        data: price_value,
                        success: function(response) {
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
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            }, 1500); // Wait for AJAX price calculation to complete first
        }
    }
}

// ===== VALIDATION =====
function check_val(v) {
    var err = false;
    var err_min = document.getElementById('err_min');
    var err_number = document.getElementById('err_number');
    var qty = parseInt($('#qty').val()) || 0;

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

    // Update fabric color values when ft_option changes
    $("input[name='ft_option']").off('change.fabricColor').on('change.fabricColor', function() {
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

    // On step3, ensure fabric color values match the selected fabric type
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

    if (err_min) {
        if (qty < 50) {
            err_min.style.display = "block";
            err = true;
        } else {
            err_min.style.display = "none";
        }
    }

    if (err_number) {
        if (qty > 99999) {
            err_number.style.display = "block";
            err = true;
        } else {
            err_number.style.display = "none";
        }
    }

    if (err) return false;
    if (v == 'back' || v == 'step1' || v == 'step2' || v == 'step3') {
        return true;
    }
    return validation_numberOf();
}

function validation_numberOf() {
    var qty = parseInt($('#qty').val()) || 0;
    var err_min = document.getElementById('err_min');
    var err_number = document.getElementById('err_number');

    if (qty < 50) {
        if (err_min) err_min.style.display = "block";
        return false;
    }
    if (qty > 99999) {
        if (err_number) err_number.style.display = "block";
        return false;
    }
    if (err_min) err_min.style.display = "none";
    if (err_number) err_number.style.display = "none";
    return true;
}

// ===== UI UPDATE from AJAX response =====
function updateUIPrice(res) {
    document.getElementById('prd_price').value = res.StrapPrice.toLocaleString("en");
    document.getElementById('prd_mold_price').value = res.MoldPrice.toLocaleString("en");
    document.getElementById('prd_process_price').value = res.ProcessPrice.toLocaleString("en");

    if ($('#prd_backside_price').length) {
        document.getElementById('prd_backside_price').value = res.BacksidePrice.toLocaleString("en");
    }
    if ($('#prd_color_price').length) {
        document.getElementById('prd_color_price').value = res.ColorPrice.toLocaleString("en");
    }
    if ($('#prd_part_price').length) {
        document.getElementById('prd_part_price').value = res.PartPrice.toLocaleString("en");
    }

    document.getElementById('prd_sample_price').value = res.ProShipping.toLocaleString("en");
    document.getElementById('prd_trace_price').value = res.TraceCharge.toLocaleString("en");
    document.getElementById('prd_opp_price').value = res.OPPPrice.toLocaleString("en");

    document.getElementById('prd_sub_total').value = res.BeforeTax.toLocaleString("en");
    if ($('#prd_tax').length) {
        document.getElementById('prd_tax').value = res.Tax.toLocaleString("en");
    }
    document.getElementById('discount').value = res.discount.toLocaleString("en");
    document.getElementById('prd_total').value = res.grandTotal.toLocaleString("en");
    $('.prd_total').text(res.grandTotal.toLocaleString("en"));

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
    $('input[name=MoldPrice]').val(res.MoldPrice);
    $('input[name=ProcessPrice]').val(res.ProcessPrice);
    $('input[name=BacksidePrice]').val(res.BacksidePrice || 0);
    $('input[name=ColorPrice]').val(res.ColorPrice || 0);
    $('input[name=PartPrice]').val(res.PartPrice);
    $('input[name=ProShipping]').val(res.ProShipping);
    $('input[name=TraceCharge]').val(res.TraceCharge);
    $('input[name=OPPPrice]').val(res.OPPPrice);
    $('input[name=discount]').val(res.discount || 0);
}

// ===== MAIN PRICING - setToInput (called on option changes) =====
function setToInput() {
    clearValue();
    var vno_of_order = document.getElementById('qty');

    if (vno_of_order.value != "") {
        var qty = parseInt(vno_of_order.value);

        // ── Collect form data ──
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
        var colorVariation = 0;
        if ($('input[name=color_variation]').length) {
            colorVariation = parseInt($('input[name=color_variation]').val()) || 0;
        }
        var ftSample = $('input[name=ft_sample]:checked').val() || 'なし';
        var ftTrace = $('input[name=ft_trace]:checked').val() || 'なし';
        var ftOpp = $('input[name=ft_opp]:checked').val() || 'なし';
        var keisai = '';
        if ($('input[name=keisai]:checked').length) {
            keisai = $('input[name=keisai]:checked').val();
        }

        // Get part price
        if ($('input[name="part"]').length && parts_obj != undefined) {
            var part = $('input[name="part"]:checked').val();
            if (part != undefined) {
                partPrice = parseInt(parts_obj["part_price"]) || 0;
                $('#sample-part-pic').show();
                $('#sample-part-pic').attr('src', parts_obj["part_pic"]);
                $('#sample-part-name').text(parts_obj["part_name"]);
            } else {
                part = "";
                partPrice = 0;
                $('#sample-part-pic').hide();
                $('#sample-part-name').text('');
            }
        }

        // Display info
        $('#sample-prd-prdt').text($('input[name=ItemType]').val());
        $('#prd_production').text($('input[name=ItemType]').val());
        $('#sample-prd-type').text(ftType);
        $('#prd_type').text(ftType);

        if ($(".template_free").length && ($('input[name=template_code]').length && $('input[name=template_code]').val() != "")) {
            $('#sample-prd-temp').text($('input[name=template_code]').val());
        }

        $('#prd_material').text($('input[name=ft_option]:checked').val());

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
            if (ftBackside == "デザインあり") {
                $('#prd_backside').text(ftBackside);
            } else {
                if ($('select[name=ft_backside_type]').length) {
                    $('#prd_backside').text(ftBacksideType || 'デザインなし');
                } else {
                    $('#prd_backside').text(ftBackside);
                }
            }
        }

        if ($('input[name=ft_sample]:checked').val() != undefined) {
            $('#prd_sample').text('あり');
            $('#sample-prd-samp').text('あり');
        } else {
            $('#prd_sample').text('なし');
            $('#sample-prd-samp').text('なし');
        }

        if ($('input[name=ft_trace]:checked').val() != undefined) {
            $('#prd_trace').text('あり');
        } else {
            $('#prd_trace').text('なし');
        }

        if ($('input[name=ft_opp]:checked').val() != undefined) {
            $('#prd_opp').text('あり');
            $('#sample-prd-opp').text('あり');
        } else {
            $('#prd_opp').text('なし');
            $('#sample-prd-opp').text('なし');
        }

        $('#prd_qty').text(qty);
        if ($('#prd_part').length) {
            if ($('input[name=ft_attach_type]').length) {
                $('#prd_part').text((part || '') + "(" + $('input[name=ft_attach_type]:checked').val() + ")");
            } else {
                $('#prd_part').text(part || 'なし');
            }
        }

        if ($('input[name=color_variation]').length) {
            $('#prd_color_variation').text(colorVariation);
        }

        if ($('input[name=keisai]:checked').length) {
            $('#prd_web').text(keisai);
        }

        // ===== AJAX PRICE CALCULATION =====
        var formData = {
            ItemType: $('input[name=ItemType]').val(),
            ft_type: ftType,
            ft_size: ftSize,
            ft_backside: ftBackside,
            ft_backside_type: ftBacksideType,
            ft_process: ftProcess,
            color_variation: colorVariation,
            numberOf: qty,
            part: part || 'なし',
            ft_sample: ftSample,
            ft_trace: ftTrace,
            ft_opp: ftOpp,
            keisai: keisai
        };

        $('.total-price .prd_total').text('計算中...');

        $.post('/products/ajax_calculate_price_flight_tag_keyholder.php', formData, function(response) {
            if (response.success) {
                updateUIPrice(response);
            } else {
                console.warn('DB pricing failed, using local calculation:', response.error);
                calculateOffline({
                    qty: qty,
                    ft_type: ftType,
                    ft_size: ftSize,
                    ft_backside: ftBackside,
                    ft_backside_type: ftBacksideType,
                    ft_process: ftProcess,
                    color_variation: colorVariation,
                    ft_sample: ftSample,
                    ft_trace: ftTrace,
                    ft_opp: ftOpp,
                    keisai: keisai
                });
            }
        }, 'json').fail(function(jqXHR) {
            console.warn('Ajax call failed, using local calculation:', jqXHR.responseText);
            calculateOffline({
                qty: qty,
                ft_type: ftType,
                ft_size: ftSize,
                ft_backside: ftBackside,
                ft_backside_type: ftBacksideType,
                ft_process: ftProcess,
                color_variation: colorVariation,
                ft_sample: ftSample,
                ft_trace: ftTrace,
                ft_opp: ftOpp,
                keisai: keisai
            });
        });
    }
}

// ===== OFFLINE FALLBACK CALCULATION =====
function calculateOffline(data) {
    var qty = data.qty;
    var order_pcs_local = 0;

    // wp_1 tiers are tax-exclusive
    if (qty >= 3000) order_pcs_local = wp_1[5];
    else if (qty >= 1000) order_pcs_local = wp_1[4];
    else if (qty >= 500) order_pcs_local = wp_1[3];
    else if (qty >= 300) order_pcs_local = wp_1[2];
    else if (qty >= 100) order_pcs_local = wp_1[1];
    else if (qty >= 50) order_pcs_local = wp_1[0];

    // Size adjustment: +15 per cm above 5cm (tax-exclusive)
    var ftSize = parseInt(data.ft_size) || 5;
    var adjustedUnit = order_pcs_local + (15 * (ftSize - 5));

    // Backside multiplier
    var backsideMult = 1.0;
    if (data.ft_backside !== 'デザインなし' && data.ft_backside !== '') {
        backsideMult = 1.4;
    }
    var finalUnit = adjustedUnit * backsideMult;
    var strapPrice = Math.floor(finalUnit * qty);

    // Mold price: 4400 tax-incl → 4000 tax-excl
    var moldPrice = Math.round(4400 / 1.1);

    // Process price: オーバーロック = 55/unit tax-incl
    var localProcessPrice = 0;
    if (data.ft_process && data.ft_process.indexOf('オーバーロック') !== -1) {
        localProcessPrice = Math.round((55 / 1.1) * qty);
    }

    // Backside price
    var localBacksidePrice = 0;
    var bsMap = {
        'マジックテープ': 55, 'アイロンテープ': 11, '接着シール': 55, 'クレジット印字': 55
    };
    if (data.ft_backside_type && bsMap[data.ft_backside_type]) {
        localBacksidePrice = Math.round((bsMap[data.ft_backside_type] / 1.1) * qty);
    }

    // Color variation price
    var localColorPrice = 0;
    var cv = parseInt(data.color_variation) || 0;
    if (cv > 3) {
        localColorPrice = Math.round(((cv - 3) * 22 / 1.1) * qty);
    }

    // Part price (already tax-exclusive)
    var localPartPrice = partPrice * qty;

    // Prototype: 5500 tax-incl → 5000 tax-excl
    var localProShipping = 0;
    if (data.ft_sample == "あり" && qty < 300) {
        localProShipping = Math.round(5500 / 1.1);
    }

    // Trace: 2200 tax-incl → 2000 tax-excl
    var localTraceCharge = 0;
    if (data.ft_trace == "あり") {
        localTraceCharge = Math.round(2200 / 1.1);
    }

    // OPP: 7/unit tax-exclusive
    var localOppPrice = 0;
    if (data.ft_opp == "あり") {
        localOppPrice = 7 * qty;
    }

    // Discount (WEB掲載)
    var localDiscount = 0;
    if (data.keisai === '製作実績の掲載を許可する') {
        localDiscount = Math.round(5500 / 1.1);
    }

    var beforeTax = strapPrice + moldPrice + localProcessPrice + localBacksidePrice
        + localColorPrice + localPartPrice + localProShipping + localTraceCharge + localOppPrice;
    var subtotal = Math.max(0, beforeTax - localDiscount);
    var localTax = Math.floor(subtotal * 0.10);
    var grandTotal = subtotal + localTax;

    var res = {
        StrapPrice: strapPrice,
        MoldPrice: moldPrice,
        ProcessPrice: localProcessPrice,
        BacksidePrice: localBacksidePrice,
        ColorPrice: localColorPrice,
        PartPrice: localPartPrice,
        ProShipping: localProShipping,
        TraceCharge: localTraceCharge,
        OPPPrice: localOppPrice,
        BeforeTax: subtotal,
        Tax: localTax,
        grandTotal: grandTotal,
        discount: localDiscount
    };

    updateUIPrice(res);
}

// ===== setToInputManual (for save_calc_data) =====
function setToInputManual() {
    var vno_of_order = document.getElementById('qty');
    var prd = $('#strap').val();

    if (vno_of_order.value != "") {
        var qty = parseInt(vno_of_order.value);
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
        var colorVariation = 0;
        if ($('input[name=color_variation]').length) {
            colorVariation = parseInt($('input[name=color_variation]').val()) || 0;
        }
        var ftSample = $('input[name=ft_sample]:checked').val() || 'なし';
        var ftTrace = $('input[name=ft_trace]:checked').val() || 'なし';
        var ftOpp = $('input[name=ft_opp]:checked').val() || 'なし';
        var keisai = '';
        if ($('input[name=keisai]:checked').length) {
            keisai = $('input[name=keisai]:checked').val();
        }

        if ($('input[name="part"]').length && parts_obj != undefined) {
            var part = $('input[name="part"]:checked').val();
            if (part != undefined) {
                partPrice = parseInt(parts_obj["part_price"]) || 0;
                $('#sample-part-pic').show();
                $('#sample-part-pic').attr('src', parts_obj["part_pic"]);
                $('#sample-part-name').text(parts_obj["part_name"]);
            } else {
                part = "";
                partPrice = 0;
                $('#sample-part-pic').hide();
                $('#sample-part-name').text('');
            }
        }

        $('#sample-prd-prdt').text(prd);
        $('#prd_production').text(prd);
        $('#sample-prd-type').text(ftType);
        $('#prd_type').text(ftType);

        if ($(".template_free").length && ($('input[name=template_code]').length && $('input[name=template_code]').val() != "")) {
            $('#sample-prd-temp').text($('input[name=template_code]').val());
        }

        $('#prd_material').text($('input[name=ft_option]:checked').val());
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
            if (ftBackside == "デザインあり") {
                $('#prd_backside').text(ftBackside);
            } else {
                if ($('select[name=ft_backside_type]').length) {
                    $('#prd_backside').text(ftBacksideType || 'デザインなし');
                } else {
                    $('#prd_backside').text(ftBackside);
                }
            }
        }

        if ($('input[name=ft_sample]:checked').val() != undefined) {
            $('#prd_sample').text('あり');
            $('#sample-prd-samp').text('あり');
        } else {
            $('#prd_sample').text('なし');
            $('#sample-prd-samp').text('なし');
        }

        if ($('input[name=ft_trace]:checked').val() != undefined) {
            $('#prd_trace').text('あり');
        } else {
            $('#prd_trace').text('なし');
        }

        if ($('input[name=ft_opp]:checked').val() != undefined) {
            $('#prd_opp').text('あり');
            $('#sample-prd-opp').text('あり');
        } else {
            $('#prd_opp').text('なし');
            $('#sample-prd-opp').text('なし');
        }

        $('#prd_qty').text(qty);
        if ($('#prd_part').length) {
            if ($('input[name=ft_attach_type]').length) {
                $('#prd_part').text((part || '') + "(" + $('input[name=ft_attach_type]:checked').val() + ")");
            } else {
                $('#prd_part').text(part || 'なし');
            }
        }

        if ($('input[name=color_variation]').length) {
            $('#prd_color_variation').text(colorVariation);
        }

        if ($('input[name=keisai]:checked').length) {
            $('#prd_web').text(keisai);
        }

        // ===== Read already-computed values from hidden fields (set by setToInput) =====
        // Return data for save_calc_data
        var shipping_price = 880;
        var beforeTaxVal = parseInt($('input[name=BeforeTax]').val()) || 0;
        if ((beforeTaxVal + parseInt($('input[name=Tax]').val() || 0)) > 11000) {
            shipping_price = 0;
        }

        return {
            sku: 'flight-tag-keyholder',
            product: prd,
            qty: qty,
            product_price: parseInt($('input[name=StrapPrice]').val()) || 0,
            mold_price: parseInt($('input[name=MoldPrice]').val()) || 0,
            part_price: parseInt($('input[name=PartPrice]').val()) || 0,
            backside_price: parseInt($('input[name=BacksidePrice]').val()) || 0,
            paper_price: 0,
            prototype_price: parseInt($('input[name=ProShipping]').val()) || 0,
            ai_assistant_price: 0,
            trace_price: parseInt($('input[name=TraceCharge]').val()) || 0,
            opp_price: parseInt($('input[name=OPPPrice]').val()) || 0,
            process_price: parseInt($('input[name=ProcessPrice]').val()) || 0,
            color_price: parseInt($('input[name=ColorPrice]').val()) || 0,
            discount: parseInt($('input[name=discount]').val()) || 0,
            shipping: shipping_price,
            vat: parseInt($('input[name=Tax]').val()) || 0,
            tax: parseInt($('input[name=Tax]').val()) || 0,
            subtotal: beforeTaxVal,
            total: parseInt($('input[name=grandTotal]').val()) || 0
        };
    }
    return {};
}

// ===== CLEAR/RESET =====
function clearValue() {
    order_pcs = 0;
    unit_price = 0;
    pcs_price = 0;
    before_tax = 0;
    tax = 0;
    total = 0;
    silkprint = 0;
    TextField7Value = 0;
    TextField9Value = 0;
    DisPrice = 0;
    proto_charge = 0;
    trace_charge = 0;
    opp_price = 0;
    process_price = 0;
    backside_price = 0;
    color_variation_price = 0;
    design_price = 0;

    document.getElementById('prd_opp_price').value = "";
    document.getElementById('prd_sample_price').value = "";
    document.getElementById('prd_trace_price').value = "";
    if (document.getElementById('prd_mold_price')) {
        document.getElementById('prd_mold_price').value = "";
    }
    if (document.getElementById('prd_process_price')) {
        document.getElementById('prd_process_price').value = "";
    }
    if (document.getElementById('prd_backside_price')) {
        document.getElementById('prd_backside_price').value = "";
    }
    if (document.getElementById('prd_color_price')) {
        document.getElementById('prd_color_price').value = "";
    }
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
    partPrice = 0;
    document.getElementById('qty').value = "";

    $("input[name=ft_type]:first").prop('checked', true);
    $("input[name=ft_option]:first").prop('checked', true);

    $("input[name=ft_sample]").prop('checked', false);
    $("input[name=ft_opp]").prop('checked', false);
    $("input[name=ft_trace]").prop('checked', false);
    $("input[name=ft_process]:first").prop('checked', true);

    if ($("input[name=ft_backside]").length) {
        $("input[name=ft_backside]:first").prop('checked', true);
    }

    if ($('select[name=ft_size]').length) {
        $('select[name=ft_size]').val("5");
    }
}

///comma////
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

///input only number////
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

// ===== PART DATA LOADING =====
function getPartData(v) {
    $.get("part_flight_tag_keyholder.php", { c: "passed" }, function(data) {
        var duce = $.parseJSON(data);
        for (var i = 0; i < duce.length; i++) {
            if (duce[i]['part_name'] == v) {
                parts_obj = duce[i];
            }
        }
    }).done(function() {
        setToInput();

        // Check case click back (MODE_MOD)
        if (typeof tmp !== "undefined" && tmp != "" && tmp == "MODE_MOD") {
            var items = setToInputManual();
            if (Object.keys(items).length !== 0) {
                $.ajax({
                    type: "POST",
                    url: "/products/save_calc_data.php",
                    data: items,
                    success: function(response) {
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
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }
        }
    });
}

// ===== COLOR HANDLING =====
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

$(function() {
    $('.STD_printing_color1, .STD_printing_color2').click(function() {
        chk_color();
    });

    $('#form input, #form select').on('change', function() {
        setToInput();
    });
});

function formatNumber(number) {
    if (number >= 0 && number <= 8) {
        return '0' + (number + 1);
    } else if (number >= 9) {
        return '' + (number + 1);
    }
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
        $("select[name='" + selectName + "'] option").each(function(index) {
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
                $('.STD_printing_color1').each(function(index) {
                    $(this).attr('value', color_f_arr[index]);
                    if ($(this).closest('td').find('img').attr('src') != undefined) {
                        $(this).closest('td').find('img').attr('src', 'images/flight_tag/icon-' + formatNumber(index) + '.webp');
                    }
                });
            } else {
                $('.STD_printing_color1').each(function(index) {
                    $(this).attr('value', color_t_arr[index]);
                    if ($(this).closest('td').find('img').attr('src') != undefined) {
                        $(this).closest('td').find('img').attr('src', 'images/flight_tag/wappen-icon-' + formatNumber(index) + '.webp');
                    }
                });
            }
        }
        if ($('.STD_printing_color2').length) {
            if (prefix == "t") {
                $('.STD_printing_color2').each(function(index) {
                    $(this).attr('value', color_f_arr[index]);
                    if ($(this).closest('td').find('img').attr('src') != undefined) {
                        $(this).closest('td').find('img').attr('src', 'images/flight_tag/icon-' + formatNumber(index) + '.webp');
                    }
                });
            } else {
                $('.STD_printing_color2').each(function(index) {
                    $(this).attr('value', color_t_arr[index]);
                    if ($(this).closest('td').find('img').attr('src') != undefined) {
                        $(this).closest('td').find('img').attr('src', 'images/flight_tag/wappen-icon-' + formatNumber(index) + '.webp');
                    }
                });
            }
        }
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

function comSubmit(action, target, form) {
    document.form.action = action;
    document.form.target = target;
    document.form.submit();
}
