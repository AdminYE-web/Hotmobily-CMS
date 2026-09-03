/**
 * renew-calculater.js
 * Printed Rubber Coaster (印刷ラバーコースター) Renewal Calculator
 * Replaces client-side _setToInput_printedrubbercoaster.js with Ajax-based DB pricing.
 *
 * Key differences from rubbercoaster calculator:
 * - Has MoldPrice/special_shape_fee (¥9,350 for オリジナル shape)
 * - Has ItemShape, ItemPrint, ItemColor fields
 * - Uses price_printed_rubber_coaster_standard/rush tiers
 * - Silk print = fixed 33/unit
 * - ALL prices are PRE-TAX; VAT 10% shown as separate line
 * - Uses valid_chk_btn / valid_chk_btn2 step flow
 */

// ===== PRICE DATA (kept for fallback if DB fails) =====
var price_printed_rubber_coaster_standard = [410, 315, 300, 288, 276, 233, 218, 196];
var price_printed_rubber_coaster_rush = [456, 349, 334, 320, 307, 258];

var paperPrice_obj = {
    "1side": [
        { "num": 1, "price": 1030 }, { "num": 2, "price": 530 }, { "num": 3, "price": 363 },
        { "num": 4, "price": 280 }, { "num": 5, "price": 230 }, { "num": 6, "price": 197 },
        { "num": 7, "price": 173 }, { "num": 8, "price": 155 }, { "num": 9, "price": 141 },
        { "num": 10, "price": 130 }, { "num": 20, "price": 80 }, { "num": 30, "price": 63 },
        { "num": 40, "price": 55 }, { "num": 50, "price": 50 }, { "num": 60, "price": 47 },
        { "num": 70, "price": 44 }, { "num": 80, "price": 43 }, { "num": 90, "price": 41 },
        { "num": 100, "price": 40 }, { "num": 200, "price": 26 }, { "num": 300, "price": 21 },
        { "num": 400, "price": 18 }, { "num": 500, "price": 15 }, { "num": 600, "price": 15 },
        { "num": 700, "price": 13 }, { "num": 800, "price": 13 }, { "num": 900, "price": 12 },
        { "num": 1000, "price": 12 }
    ],
    "2side": [
        { "num": 1, "price": 1230 }, { "num": 2, "price": 630 }, { "num": 3, "price": 430 },
        { "num": 4, "price": 330 }, { "num": 5, "price": 270 }, { "num": 6, "price": 230 },
        { "num": 7, "price": 201 }, { "num": 8, "price": 180 }, { "num": 9, "price": 163 },
        { "num": 10, "price": 150 }, { "num": 20, "price": 90 }, { "num": 30, "price": 70 },
        { "num": 40, "price": 60 }, { "num": 50, "price": 54 }, { "num": 60, "price": 50 },
        { "num": 70, "price": 47 }, { "num": 80, "price": 45 }, { "num": 90, "price": 43 },
        { "num": 100, "price": 42 }, { "num": 200, "price": 27 }, { "num": 300, "price": 22 },
        { "num": 400, "price": 19 }, { "num": 500, "price": 16 }, { "num": 600, "price": 16 },
        { "num": 700, "price": 14 }, { "num": 800, "price": 14 }, { "num": 900, "price": 13 },
        { "num": 1000, "price": 13 }
    ],
    "tmp": [
        { "num": 1, "price": 830 }, { "num": 2, "price": 430 }, { "num": 3, "price": 297 },
        { "num": 4, "price": 230 }, { "num": 5, "price": 190 }, { "num": 6, "price": 163 },
        { "num": 7, "price": 144 }, { "num": 8, "price": 130 }, { "num": 9, "price": 119 },
        { "num": 10, "price": 110 }, { "num": 20, "price": 70 }, { "num": 30, "price": 57 },
        { "num": 40, "price": 50 }, { "num": 50, "price": 46 }, { "num": 60, "price": 43 },
        { "num": 70, "price": 41 }, { "num": 80, "price": 40 }, { "num": 90, "price": 39 },
        { "num": 100, "price": 38 }, { "num": 200, "price": 25 }, { "num": 300, "price": 21 },
        { "num": 400, "price": 18 }, { "num": 500, "price": 14 }, { "num": 600, "price": 14 },
        { "num": 700, "price": 12 }, { "num": 800, "price": 12 }, { "num": 900, "price": 11 },
        { "num": 1000, "price": 11 }
    ]
};

var parts_obj;
var paperPrice = 0;
var unit_price = 0;

// ===== GLOBAL PRICE VARIABLES =====
var price_bracket = 0;
var packing_price = 0;
var proto_shipping_charge = 0;
var order_pcs = 0;
var strap_price = 0;
var before_tax = 0;
var tax = 0;
var vat = 10;
var total = 0;
var silkprint = 0;
var partPrice = 0;
var TextField7Value = 0;
var TextField9Value = 0;
var DisPrice = 0;
var proto_charge = 0;
var trace_charge = 0;
var print_charge = 0;
var coating_charge = 0;
var DesignsCharge = 0;
var MaterialCharge = 0;
var special_shape_fee = 0;

// ===== STEP NAVIGATION: valid_chk_btn (3-step with attachment step label) =====
function valid_chk_btn(c) {
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
            case "アタッチメント・オプション入力へ":
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
                } else {
                    $('#step1').fadeIn('slow');
                    $('#dot-step1').addClass('active');
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
                    $('#next').text('アタッチメント・オプション入力へ');
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
    }
}

// ===== STEP NAVIGATION: valid_chk_btn2 (3-step with option step label) =====
function valid_chk_btn2(c) {
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
    }
}

// ===== VALIDATION =====
function check_val(v) {
    var ItemType = $('input[name=ItemType]').val();
    var err_number = document.getElementById('err_numberOf_mess');
    var mess = "";
    err_number.style.display = "";
    var vNumberOfOder = $('#no_of_order');

    if (ItemType == "印刷ラバーコースター") {
        // Check Shape first
        if ($('input[name=ItemShape]').length && $('input[name=ItemShape]:checked').val() == undefined) {
            $('#error_shape').text('【必須】形状タイプをご選択ください');
            return false;
        }
        if ($('input[name=ItemShape]').length) {
            $('#error_shape').text('');
        }

        var dac = $('input[name=ItemPCS]:checked').val();
        var max_leng = 1000;
        if (dac == "スタンダード（スピード7営業日発送）") {
            max_leng = 300;
        }

        if (vNumberOfOder.val() != '') {
            if (vNumberOfOder.val() > max_leng) {
                mess += "<font color='red'>本数は" + max_leng + "本以下で入力して下さい。</font>";
                err_number.innerHTML = mess;
                return false;
            }

            // Check min qty
            if ($('input[name=ItemShape]:checked').val() == "オリジナル" && vNumberOfOder.val() < 100) {
                mess += "<font color='red'>本数は100本以上で入力して下さい。</font>";
                err_number.innerHTML = mess;
                return false;
            } else {
                if (vNumberOfOder.val() < 1) {
                    mess += "<font color='red'>本数は1本以上で入力して下さい。</font>";
                    err_number.innerHTML = mess;
                    return false;
                }
            }

            // Check max qty
            if ($('input[name=ItemShape]:checked').val() == "オリジナル" && vNumberOfOder.val() > 1000) {
                mess += "<font color='red'>本数は1000本以下で入力して下さい。</font>";
                err_number.innerHTML = mess;
                return false;
            } else {
                if (vNumberOfOder.val() > 1000) {
                    mess += "<font color='red'>本数は1000本以下で入力して下さい。</font>";
                    err_number.innerHTML = mess;
                    return false;
                }
            }
        } else {
            if ($('input[name=ItemShape]:checked').val() == "オリジナル") {
                mess += "<font color='red'>本数は100本以上で入力して下さい。</font>";
                err_number.innerHTML = mess;
                return false;
            } else {
                mess += "<font color='red'>本数は1本以上で入力して下さい。</font>";
                err_number.innerHTML = mess;
                return false;
            }
        }
    }

    if (v == 'next') {
        $('#err_numberOf_mess').hide();

        if ($('input[name=ItemPrint]').length && $('input[name=ItemPrint]:checked').val() == undefined) {
            $('#error_print').text('【必須】印刷の有無をご選択ください');
            return false;
        } else if ($('input[name=ItemPCS]').length && $('input[name=ItemPCS]:checked').val() == undefined) {
            $('#error_pcs').text('【必須】ご注文タイプをご選択ください');
            return false;
        } else if ($('input[name=silk_print]').length && $('input[name=silk_print]:checked').val() == undefined) {
            $('#error_silk_print').text('【必須】裏面シルク印刷の有無をご選択ください');
            return false;
        } else if ($('input[name=coating]').length && $('input[name=coating]:checked').val() == undefined) {
            $('#error_coating').text('【必須】汚れ防止加工の有無をご選択ください');
            return false;
        } else if ($('input[name=ItemShape]').length && $('input[name=ItemShape]:checked').val() == undefined) {
            $('#error_shape').text('【必須】形状タイプをご選択ください');
            return false;
        } else if ($('input[name=ItemColor]').length && $('input[name=ItemColor]:checked').val() == undefined) {
            $('#error_color').text('【必須】色タイプをご選択ください');
            return false;
        } else {
            $('#error_pcs').text('');
            $('#error_print').text('');
            $('#error_silk_print').text('');
            if ($('input[name=coating]').length) { $('#error_coating').text(''); }
            if ($('input[name=ItemShape]').length) { $('#error_shape').text(''); }
            if ($('input[name=ItemPrint]').length) { $('#error_print').text(''); }
            if ($('input[name=ItemColor]').length) { $('#error_color').text(''); }

            err_number.innerHTML = '';
            setToInput();
            return true;
        }
    } else {
        return true;
    }
}

// ===== APPLY PRICE RESPONSE TO UI =====
function applyPriceResponse(response) {
    document.getElementById('textfield7').value = formatMoney(response.StrapPrice);
    if ($('#textfield2').length) {
        document.getElementById('textfield2').value = formatMoney(response.MoldPrice);
    }
    document.getElementById('textfield13').value = formatMoney(response.SilkPrint);
    if ($('#textfield13_2').length) {
        document.getElementById('textfield13_2').value = formatMoney(response.coatingPrice);
    }
    document.getElementById('textfield7_1').value = formatMoney(response.PartPrice);
    document.getElementById('textfield7_2').value = formatMoney(response.PaperPrice);
    document.getElementById('textfield3').value = formatMoney(response.ProShipping);
    document.getElementById('textfield4').value = formatMoney(response.TraceCharge);
    if ($('#DesignsCharge').length) {
        document.getElementById('DesignsCharge').value = formatMoney(response.DesignsCharge);
    }
    if ($('#MaterialCharge').length) {
        document.getElementById('MaterialCharge').value = formatMoney(response.MaterialCharge);
    }
    document.getElementById('textfield9').value = formatMoney(response.BeforeTax);
    if ($('#textfield_tax').length) {
        document.getElementById('textfield_tax').value = formatMoney(response.Tax);
    }
    document.getElementById('textfield_dis').value = formatMoney(response.discount);
    document.getElementById('textfield11').value = formatMoney(response.grandTotal);
    $('.prd_total').text(formatMoney(response.grandTotal));

    // Sync global variables for pdf_rubber.js (quotation PDF export)
    var qty = parseInt($('#no_of_order').val(), 10) || 0;
    TextField7Value = response.StrapPrice || 0;
    TextField9Value = response.BeforeTax || 0;
    tax = response.Tax || 0;
    total = response.grandTotal || 0;
    DisPrice = response.discount || 0;
    proto_charge = response.ProShipping || 0;
    trace_charge = response.TraceCharge || 0;
    print_charge = response.SilkPrint || 0;
    coating_charge = response.coatingPrice || 0;
    DesignsCharge = response.DesignsCharge || 0;
    MaterialCharge = response.MaterialCharge || 0;
    special_shape_fee = response.MoldPrice || 0;
    strap_price = response.StrapPrice || 0;
    partPrice = (qty > 0 && response.PartPrice > 0) ? Math.floor(response.PartPrice / qty) : 0;
    paperPrice = (qty > 0 && response.PaperPrice > 0) ? Math.floor(response.PaperPrice / qty) : 0;
    packing_price = 0;
}

// ===== MAIN CALCULATOR: Ajax-based =====
function setToInput() {
    clearValue();

    var ItemType = $('input[name=ItemType]').val();
    var vno_of_order = document.getElementById('no_of_order');

    // Get paper data (client-side display)
    if ($('input[name="paper_select"]').length) {
        var paper = $('input[name="paper_select"]:checked').val();
        var paper_color = $('input[name="paper"]:checked').val();
        if (paper != undefined) {
            $('.paper-container').show();
            if (paper_color != undefined) {
                $('#sample-paper-pic').show();
                $('#sample-paper-pic').attr('src', "/products/acrylic/img/" + paper_color + ".jpg");
                $('#sample-paper-name').text(paper_color);
                $('#next').attr('disabled', false);
                $('#back').attr('disabled', false);
                $('#prd_paper').text(paper_color);
                $('#paper-error').text('');
                var tmp_pp = paperPrice_obj['1side'];
                if (paper_color == "paper-patternA-1") tmp_pp = paperPrice_obj['1side'];
                else if (paper_color == "paper-patternA-2") tmp_pp = paperPrice_obj['2side'];
                else tmp_pp = paperPrice_obj['tmp'];
                for (var i = 0, iMax = tmp_pp.length; i < iMax; i++) {
                    if (parseInt(vno_of_order.value) >= parseInt(tmp_pp[i].num)) {
                        paperPrice = Math.floor(tmp_pp[i].price); // pre-tax
                        continue;
                    }
                    break;
                }
            } else {
                $('#paper-error').text('台紙を選択してください。');
                $('#next').attr('disabled', true);
                $('#back').attr('disabled', true);
            }
        } else {
            $('#sample-paper-pic').hide();
            $('#sample-paper-name').text('なし');
            $('.paper-container').hide();
            $('#paper-error').text('');
            $('#next').attr('disabled', false);
            $('#back').attr('disabled', false);
            $('#prd_paper').text('なし');
            $('input[name="acy_paper"]').prop('checked', false);
            $('input[name="paper"]').prop('checked', false);
            paperPrice = 0;
        }
    }

    // Only proceed to pricing if quantity is set
    if (vno_of_order.value != "") {
        // Update UI display fields
        if ($('#sample-prd-shape').length) {
            if ($('input[name=ItemShape]').length && $('input[name=ItemShape]:checked').val() != undefined) {
                $('#sample-prd-shape').text($('input[name=ItemShape]:checked').val());
                $('#prd_ItemShape').text($('input[name=ItemShape]:checked').val());
            }
        }
        if ($('#sample-prd-print_type').length || $('#prd-print-type').length) {
            if ($('input[name=ItemPrint]').length && $('input[name=ItemPrint]:checked').val() != undefined) {
                $('#sample-prd-print_type').text($('input[name=ItemPrint]:checked').val());
                $('#prd-print-type').text($('input[name=ItemPrint]:checked').val());
            }
        }
        if ($('#sample-prd-color_tank').length || $('#prd-color-tank').length) {
            if ($('input[name=ItemColor]').length && $('input[name=ItemColor]:checked').val() != undefined) {
                $('#sample-prd-color_tank').text($('input[name=ItemColor]:checked').val());
                $('#prd-color-tank').text($('input[name=ItemColor]:checked').val());
            }
        }

        if ($('input[name=ItemPCS]').length && $('input[name=ItemPCS]:checked').val() != undefined) {
            $('#sample-prd-pcs').text($('input[name=ItemPCS]:checked').val());
        }
        if ($('input[name=silk_print]').length && $('input[name=silk_print]:checked').val() != undefined) {
            $('#sample-prd-screen').text($('input[name=silk_print]:checked').val());
            $('#prd_silk_print').text($('input[name=silk_print]:checked').val());
        }
        if ($('input[name=coating]').length && $('input[name=coating]:checked').val() != undefined) {
            $('#sample-prd-coating').text($('input[name=coating]:checked').val());
            $('#prd_coating').text($('input[name=coating]:checked').val());
        }
        if ($('input[name=ItemShape]').length && $('input[name=ItemShape]:checked').val() != undefined) {
            $('#prd_shape_custom').text($('input[name=ItemShape]:checked').val());
        }

        $('#sample-prd-qty').text(vno_of_order.value);

        if ($('input[name=SendPrototype]:checked').val() != undefined) {
            $('#prd_SendPrototype').text('あり');
            $('#sample-prd-samp').text('あり');
        } else {
            $('#prd_SendPrototype').text('なし');
            $('#sample-prd-samp').text('なし');
        }

        if ($('input[name=DeFormat]:checked').val() != undefined) {
            $('#prd_DeFormat').text('あり');
            $('#sample-prd-trace').text('あり');
        } else {
            $('#prd_DeFormat').text('なし');
            $('#sample-prd-trace').text('なし');
        }

        if ($('input[name=ItemDesignVariation]:checked').val() != undefined) {
            $('#prd_ItemDesign').text($('input[name=ItemDesignVariation]:checked').val());
        }
        if ($('input[name=ItemMaterial]:checked').val() != undefined) {
            $('#prd_ItemMaterial').text($('input[name=ItemMaterial]:checked').val());
        }
        if ($('#prd_ItemPCS').length) {
            $('#prd_ItemPCS').text($('input[name=ItemPCS]:checked').val());
        }
        $('#prd_qty').text(vno_of_order.value);

        // Packing display
        if ($("input[name=packing]").length) {
            if ($("input[name=packing]:checked").val() != undefined && $("input[name=packing]:checked").val() != "") {
                $('#part-error').text('');
                $('#next').attr('disabled', false);
                $('#back').attr('disabled', false);
                $('#sample-part-pic').show();
                if ($("input[name=packing]:checked").val() == "白色無地") {
                    $('#sample-part-pic').attr("src", "/products/images/frame-packing1.jpg");
                } else {
                    $('#sample-part-pic').attr("src", "/products/images/frame-packing2.jpg?v=1.01");
                }
                $('#sample-part-name').text($("input[name=packing]:checked").val());
            } else {
                $('#part-error').text('梱包形態をご選択ください');
                $('#next').attr('disabled', true);
                $('#back').attr('disabled', true);
            }
        }

        // ===== AJAX PRICE CALCULATION =====
        var formData = {
            ItemType: $('input[name=ItemType]').val(),
            ItemPCS: $('input[name=ItemPCS]:checked').val(),
            numberOf: $('#no_of_order').val(),
            silk_print: $('input[name=silk_print]:checked').val(),
            coating: $('input[name=coating]:checked').val(),
            ItemMaterial: $('input[name=ItemMaterial]:checked').val(),
            ItemDesignVariation: $('input[name=ItemDesignVariation]:checked').val(),
            paper_select: $('input[name="paper_select"]:checked').val(),
            paper: $('input[name="paper"]:checked').val(),
            SendPrototype: $('input[name=SendPrototype]:checked').val(),
            DeFormat: $('input[name=DeFormat]:checked').val(),
            ItemShape: $('input[name=ItemShape]:checked').val(),
            ItemPrint: $('input[name=ItemPrint]:checked').val(),
            ItemColor: $('input[name=ItemColor]:checked').val()
        };

        // Attach loading state
        $('.prd_total').text('計算中...');

        $.post('/products/printedrubbercoaster/ajax_calculate_price.php', formData, function(response) {
            if (response.success) {
                applyPriceResponse(response);
            } else {
                console.warn('DB pricing failed, using local calculation:', response.error);
                calculateLocal();
            }
        }, 'json').fail(function(jqXHR) {
            var used = false;
            try {
                var raw = jqXHR.responseText || '';
                var jsonMatch = raw.match(/\{[\s\S]*\}$/);
                if (jsonMatch) {
                    var parsed = JSON.parse(jsonMatch[0]);
                    if (parsed && parsed.success) {
                        console.info('Ajax call failed but response contained valid price data, using it.');
                        applyPriceResponse(parsed);
                        used = true;
                    }
                }
            } catch (e) { /* ignore parse errors */ }
            if (!used) {
                console.warn('Ajax call failed, using local calculation:', jqXHR.responseText);
                calculateLocal();
            }
        });
    }
}

// ===== FALLBACK: Local calculation (all pre-tax) =====
function calculateLocal() {
    var ItemType = $('input[name=ItemType]').val();
    var vno_of_order = document.getElementById('no_of_order');
    var qty = parseInt(vno_of_order.value) || 0;
    var localOrderPcs = 0;
    var localMoldPrice = 0;

    // Printed rubber coaster pricing tiers (pre-tax unit price)
    if ($('#pcs1').is(':checked')) {
        if (qty >= 1000) localOrderPcs = price_printed_rubber_coaster_standard[7];
        else if (qty >= 500) localOrderPcs = price_printed_rubber_coaster_standard[6];
        else if (qty >= 300) localOrderPcs = price_printed_rubber_coaster_standard[5];
        else if (qty >= 100) localOrderPcs = price_printed_rubber_coaster_standard[4];
        else if (qty >= 50) localOrderPcs = price_printed_rubber_coaster_standard[3];
        else if (qty >= 30) localOrderPcs = price_printed_rubber_coaster_standard[2];
        else if (qty >= 10) localOrderPcs = price_printed_rubber_coaster_standard[1];
        else if (qty >= 1) localOrderPcs = price_printed_rubber_coaster_standard[0];
    }
    if ($('#pcs4').is(':checked')) {
        if (qty >= 300) localOrderPcs = price_printed_rubber_coaster_rush[5];
        else if (qty >= 100) localOrderPcs = price_printed_rubber_coaster_rush[4];
        else if (qty >= 50) localOrderPcs = price_printed_rubber_coaster_rush[3];
        else if (qty >= 30) localOrderPcs = price_printed_rubber_coaster_rush[2];
        else if (qty >= 10) localOrderPcs = price_printed_rubber_coaster_rush[1];
        else if (qty >= 1) localOrderPcs = price_printed_rubber_coaster_rush[0];
    }

    // StrapPrice = unit * qty (pre-tax)
    var localStrapPrice = localOrderPcs * qty;

    // MoldPrice / special_shape_fee for オリジナル
    if ($('input[name=ItemShape]:checked').val() == "オリジナル") {
        localMoldPrice = 8500; // pre-tax
    }

    // Silk print — 33/unit pre-tax
    var localSilk = 0;
    if ($('input[name=silk_print]:checked').val() == "印刷あり") {
        localSilk = 33 * qty;
    }

    // Coating — 70/unit pre-tax
    var localCoating = 0;
    if ($('input[name=coating]:checked').val() != undefined && $('input[name=coating]:checked').val() != "汚れ防止加工なし") {
        localCoating = 70 * qty;
    }

    // Prototype — flat 8000 pre-tax
    var localProto = 0;
    if ($('input[name=SendPrototype]:checked').val() != undefined) {
        localProto = 8000;
    }

    // Trace — flat 8000 pre-tax
    var localTrace = 0;
    if ($('input[name=DeFormat]:checked').val() != undefined) {
        localTrace = 8000;
    }

    // Design variation — flat fee pre-tax
    var localDesign = 0;
    var designVal = $('input[name=ItemDesignVariation]:checked').val();
    if (designVal == "2種類") localDesign = 3000;
    else if (designVal == "3種類") localDesign = 6000;
    else if (designVal == "4種類") localDesign = 9000;

    // Special material — 30/unit pre-tax
    var localMaterial = 0;
    if ($('input[name=ItemMaterial]:checked').val() == "特殊素材あり") {
        localMaterial = 30 * qty;
    }

    // Paper — pre-tax
    var localPaper = paperPrice * qty;

    // Packing — 30/unit pre-tax
    var localPacking = 0;
    if ($("input[name=packing]").length && $("input[name=packing]:checked").val() == "白色無地") {
        localPacking = 30 * qty;
    }

    // No part for printed coaster
    var localPart = 0;

    // Discount
    var localDiscount = 0;

    // Subtotal (pre-tax)
    var beforeTax = localStrapPrice + localMoldPrice + localSilk + localCoating + localPart + localPaper
                  + localProto + localTrace + localDesign + localMaterial + localPacking;
    var subtotal = Math.max(0, beforeTax - localDiscount);

    // VAT 10% from subtotal
    var localTax = Math.floor(subtotal * 0.10);
    var localTotal = subtotal + localTax;

    // Apply to form fields
    document.getElementById('textfield7').value = formatMoney(localStrapPrice);
    if ($('#textfield2').length) {
        document.getElementById('textfield2').value = formatMoney(localMoldPrice);
    }
    document.getElementById('textfield13').value = formatMoney(localSilk);
    if ($('#textfield13_2').length) {
        document.getElementById('textfield13_2').value = formatMoney(localCoating);
    }
    document.getElementById('textfield7_1').value = formatMoney(localPart);
    document.getElementById('textfield7_2').value = formatMoney(localPaper);
    document.getElementById('textfield3').value = formatMoney(localProto);
    document.getElementById('textfield4').value = formatMoney(localTrace);
    if ($('#DesignsCharge').length) {
        document.getElementById('DesignsCharge').value = formatMoney(localDesign);
    }
    if ($('#MaterialCharge').length) {
        document.getElementById('MaterialCharge').value = formatMoney(localMaterial);
    }
    document.getElementById('textfield9').value = formatMoney(subtotal);
    if ($('#textfield_tax').length) {
        document.getElementById('textfield_tax').value = formatMoney(localTax);
    }
    document.getElementById('textfield_dis').value = formatMoney(localDiscount);
    document.getElementById('textfield11').value = formatMoney(localTotal);
    $('.prd_total').text(formatMoney(localTotal));

    TextField7Value = localStrapPrice;
    TextField9Value = subtotal;
    tax = localTax;
    total = localTotal;
    DisPrice = localDiscount;
    proto_charge = localProto;
    trace_charge = localTrace;
    print_charge = localSilk;
    coating_charge = localCoating;
    DesignsCharge = localDesign;
    MaterialCharge = localMaterial;
    special_shape_fee = localMoldPrice;
    strap_price = localStrapPrice;
    partPrice = (localPart > 0 && qty > 0) ? Math.floor(localPart / qty) : 0;
    paperPrice = (localPaper > 0 && qty > 0) ? Math.floor(localPaper / qty) : 0;
    packing_price = 0;
}

// ===== CLEAR =====
function clearValue() {
    price_bracket = 0;
    proto_shipping_charge = 0;
    order_pcs = 0;
    unit_price = 0;
    strap_price = 0;
    before_tax = 0;
    tax = 0;
    total = 0;
    silkprint = 0;
    partPrice = 0;
    paperPrice = 0;
    TextField7Value = 0;
    TextField9Value = 0;
    DisPrice = 0;
    proto_charge = 0;
    coating_charge = 0;
    packing_price = 0;
    trace_charge = 0;
    print_charge = 0;
    DesignsCharge = 0;
    MaterialCharge = 0;
    special_shape_fee = 0;

    document.getElementById('textfield7').value = "";
    if ($('#textfield2').length) {
        document.getElementById('textfield2').value = "";
    }
    document.getElementById('textfield13').value = "";
    if ($('#textfield13_2').length) {
        document.getElementById('textfield13_2').value = "";
    }
    document.getElementById('textfield7_1').value = "";
    document.getElementById('textfield7_2').value = "";
    document.getElementById('textfield3').value = "";
    document.getElementById('textfield4').value = "";
    if ($('#DesignsCharge').length) {
        document.getElementById('DesignsCharge').value = "";
    }
    if ($('#MaterialCharge').length) {
        document.getElementById('MaterialCharge').value = "";
    }
    if ($('#textfield_tax').length) {
        document.getElementById('textfield_tax').value = "";
    }
    document.getElementById('textfield9').value = "";
    document.getElementById('textfield11').value = "";
}

// ===== FORMAT HELPERS =====
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

function parseMoney(value) {
    var numeric = String(value || '').replace(/[^\d.-]/g, '');
    return numeric === '' ? 0 : parseInt(numeric, 10);
}

function format_number(number) {
    if (number != "") {
        number = parseInt(number) + 0;
    }
    return number;
}

// ===== TYPE ORDER HANDLERS =====
function click_typeorder_enabled() {
    type_special_disabled('f1');
}

function click_typeorder_disabled() {
    type_special_disabled('f1');
}

function type_special_disabled(c) {
    if (c == 't1') {
        var amount;
        $.get("/count_order.php", function(data) {
            amount = $.parseJSON(data);
        }).done(function() {
            $('.pcs_option').fadeIn();
            if (amount == 0) {
                $('#pcs_txt').text('受付中です。ご注文頂けます');
                $('#pcs_status').attr('class', 'pcs_01');
            } else if (amount < 5) {
                $('#pcs_txt').text('今週の受付数はあと1～2件です');
                $('#pcs_status').attr('class', 'pcs_02');
            } else {
                $('#pcs_txt').text('今週の受付数量を越えております為、ご注文停止中です');
                $('#pcs_status').attr('class', 'pcs_03');
                $('.btn-next').attr('disabled', true);
            }
            $("#ariprint").attr('disabled', true);
            $("#fcprint").attr('disabled', true);
            $("#nashiprint").prop('checked', true);
            if ($("#coating1").length) {
                $("#coating1").attr('disabled', true);
                $("#coating0").prop('checked', true);
            }
            $("#no_of_order").val('10');
            $("#no_of_order").attr('readonly', true);
            $('input[name=paper_select]').attr('disabled', true);
            $('input[name=SendPrototype]').attr('disabled', true);
            $('input[name=DeFormat]').prop('checked', true);
            $('input[name=DeFormat]').attr('disabled', true);
            $("#button_pdf2").attr('disabled', true);
        });
    } else {
        $('#pcs3').attr('checked', false);
        $('.pcs_option').hide();
        $("#ariprint").attr('disabled', false);
        $("#fcprint").attr('disabled', false);
        if ($('input[name=ItemPCS]:checked').val() == "スタンダード（スピード7営業日発送）") {
            if ($("#coating1").length) {
                $("#coating0").prop('checked', true);
                $("#coating1").attr('disabled', true);
            }
        } else {
            if ($("#coating1").length) {
                $("#coating1").attr('disabled', false);
            }
        }
        $("#no_of_order").attr('readonly', false);
        $('input[name=paper_select]').attr('disabled', false);
        if ($('input[name=ItemShape]:checked').val() === 'オリジナル') {
            $('input[name=SendPrototype]').attr('disabled', false);
        } else {
            $('input[name=SendPrototype]').prop('checked', false).attr('disabled', true);
            $('#SampleCheckbox').siblings('.switch_off_button').addClass('switch_off').removeClass('switch_on');
        }
        $('input[name=DeFormat]').attr('disabled', false);
        $("#button_pdf2").attr('disabled', false);
        $('.btn-next').attr('disabled', false);
    }
}

$(document).ready(function() {
    $('input[name="ItemShape"]').change(function() {
        if ($(this).val() === 'オリジナル') {
            $('input[name=SendPrototype]').attr('disabled', false);
        } else {
            $('input[name=SendPrototype]').prop('checked', false).attr('disabled', true);
            $('#SampleCheckbox').siblings('.switch_off_button').addClass('switch_off').removeClass('switch_on');
            if (typeof clearValue === 'function') {
                clearValue();
            }
        }
    });
});
