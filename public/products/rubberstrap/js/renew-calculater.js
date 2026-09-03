/**
 * renew-calculator.js
 * Rubber Strap Renewal Calculator
 * Replaces the old client-side _setToInput_2023.js with Ajax-based pricing via PHP DB.
 * 
 * All UI logic (validation, step navigation, display updates) is preserved.
 * Only the price calculation is moved to server-side.
 */

// ===== PRICE DATA (pre-tax unit prices, kept for fallback if DB fails) =====
// Tax (10%) is applied per-unit before multiplying by qty:
//   taxInclUnit = Math.floor(unit * 1.10)
var price_strap_standard = [437, 358, 279, 230, 183, 133, 115];
var price_strap_premium = [600, 400, 365, 335, 257, 184, 140];

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
var unit_price = 0;
var strap_price = 0;
var before_tax = 0;
var tax = 0;
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
var SpeedShipping = 0;

function getSelectedPartUnitPrice() {
    var selectedPart = $('input[name="part"]:checked');
    if (!selectedPart.length) {
        return 0;
    }

    var label = selectedPart.closest('label');
    var selectedPriceText = ($('#pcs2').is(':checked') || $('#pcs3').is(':checked'))
        ? label.find('.part_price_prm').first().text()
        : label.find('.part_price_std').first().text();
    var selectedNumeric = String(selectedPriceText).replace(/[^\d.-]/g, '');
    return selectedNumeric === '' ? 0 : parseInt(selectedNumeric, 10);

    var itemPcs = $('input[name=ItemPCS]:checked').val() || '';
    var priceText = '';
    if (itemPcs.indexOf('ãƒ—ãƒ¬ãƒŸã‚¢ãƒ ') !== -1 || itemPcs.indexOf('ãƒ•ã‚¡ãƒ³') !== -1) {
        priceText = label.find('.part_price_prm').first().text();
    } else {
        priceText = label.find('.part_price_std').first().text();
    }

    var numeric = String(priceText).replace(/[^\d.-]/g, '');
    return numeric === '' ? 0 : parseInt(numeric, 10);
}

function setSelectedPartFallback(v) {
    var selectedPart = $('input[name="part"]:checked');
    var label = selectedPart.closest('label');
    var partPic = label.find('img').first().attr('src') || label.find('img').first().attr('data-src') || '';

    parts_obj = {
        part_name: v || selectedPart.val() || '',
        part_price: getSelectedPartUnitPrice(),
        part_pic: partPic
    };
}

// ===== STEP NAVIGATION =====
function valid_chk_btn(c) {
    if (check_val(c)) {
        $('#step1').fadeOut('fast');
        $('#step2').fadeOut('fast');
        $('#step3').fadeOut('fast');
        $('#dot-step1').removeClass('active');
        $('#dot-step2').removeClass('active');
        $('#dot-step3').removeClass('active');

        switch ($('#next').text()) {
            case "アタッチメント・オプション入力へ":
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

// ===== VALIDATION =====
function check_val(v) {
    var ItemType = $('input[name=ItemType]').val();
    var err_number = document.getElementById('err_numberOf_mess');
    var mess = "";
    err_number.style.display = "";
    var vNumberOfOder = $('#no_of_order');

    if ($('input[name=ItemDesignVariation]').length) {
        switch ($('input[name=ItemDesignVariation]:checked').val()) {
            case "1種類":
                if ((vNumberOfOder.val() == '' || vNumberOfOder.val() < 100) && (ItemType != "ラバーコースター")) {
                    mess += "<font color='red'>本数は100本以上で入力して下さい。</font>";
                    err_number.innerHTML = mess;
                    return false;
                } else if ((vNumberOfOder.val() == '' || vNumberOfOder.val() < 1) && $('input[name=ItemPCS]:checked').val() != "プレミアム") {
                    mess += "<font color='red'>本数は1本以上で入力して下さい。</font>";
                    err_number.innerHTML = mess;
                    return false;
                } else if ((vNumberOfOder.val() == '' || vNumberOfOder.val() < 100) && ItemType == "ラバーコースター" && $('input[name=ItemPCS]:checked').val() == "プレミアム") {
                    mess += "<font color='red'>本数は100本以上で入力して下さい。</font>";
                    err_number.innerHTML = mess;
                    return false;
                } else {
                    $('#err_numberOf_mess').hide();
                }
                break;
            case "2種類":
                if (vNumberOfOder.val() == '' || vNumberOfOder.val() < 100) {
                    mess += "<font color='red'>本数は100本以上で入力して下さい。</font>";
                    err_number.innerHTML = mess;
                    return false;
                }
                break;
            case "3種類":
                if (vNumberOfOder.val() == '' || vNumberOfOder.val() < 150) {
                    mess += "<font color='red'>本数は150本以上で入力して下さい。</font>";
                    err_number.innerHTML = mess;
                    return false;
                }
                break;
            case "4種類":
                if (vNumberOfOder.val() == '' || vNumberOfOder.val() < 200) {
                    mess += "<font color='red'>本数は200本以上で入力して下さい。</font>";
                    err_number.innerHTML = mess;
                    return false;
                }
                break;
        }
    }

    if ($('input[name=ItemPCS]:checked').val() == "スタンダード（スピード7営業日発送）") {
        if (vNumberOfOder.val() == '' || vNumberOfOder.val() > 300) {
            mess += "<font color='red'>本数は300本以下で入力して下さい。</font>";
            err_number.innerHTML = mess;
            return false;
        }
    }

    if (v == 'next') {
        if ($('input[name=ItemPCS]:checked').val() != "ホットモバイリーファン" && $('input[name=ItemType]').val() != "ラバーコースター") {
            if (!validation_numberOf()) {
                return false;
            } else {
                $('#err_numberOf_mess').hide();
                if ($('input[name=ItemPCS]').length && $('input[name=ItemPCS]:checked').val() == undefined) {
                    $('#error_pcs').text('【必須】ご注文タイプをご選択ください');
                    return false;
                } else if ($('input[name=silk_print]').length && ItemType != "ラバータグ" && ItemType != "ペットボトルホルダー" && $('input[name=silk_print]:checked').val() == undefined) {
                    $('#error_print').text('【必須】裏面シルク印刷の有無をご選択ください');
                    return false;
                } else if ($('input[name=coating]').length && $('input[name=coating]:checked').val() == undefined) {
                    $('#error_coating').text('【必須】汚れ防止加工の有無をご選択ください');
                    return false;
                } else {
                    $('#error_pcs').text('');
                    $('#error_print').text('');
                    if ($('input[name=coating]').length) {
                        $('#error_coating').text('');
                    }
                    setToInput(); // <-- Triggers Ajax price calculation now
                    return true;
                }
            }
        } else {
            $('#err_numberOf_mess').hide();
            if ($('input[name=ItemPCS]').length && $('input[name=ItemPCS]:checked').val() == undefined) {
                $('#error_pcs').text('【必須】ご注文タイプをご選択ください');
                return false;
            } else if ($('input[name=silk_print]').length && ItemType != "ラバータグ" && ItemType != "ペットボトルホルダー" && $('input[name=silk_print]:checked').val() == undefined) {
                $('#error_print').text('【必須】裏面シルク印刷の有無をご選択ください');
                return false;
            } else if ($('input[name=coating]').length && $('input[name=coating]:checked').val() == undefined) {
                $('#error_coating').text('【必須】汚れ防止加工の有無をご選択ください');
                return false;
            } else {
                $('#error_pcs').text('');
                $('#error_print').text('');
                if ($('input[name=coating]').length) {
                    $('#error_coating').text('');
                }
                setToInput(); // <-- Triggers Ajax price calculation now
                return true;
            }
        }
    } else {
        return true;
    }
}

// ===== MAIN CALCULATOR: Ajax-based =====
function setToInput() {
    clearValue();

    var ItemType = $('input[name=ItemType]').val();
    var vno_of_order = document.getElementById('no_of_order');

    // Get part price / UI updates (client-side only)
    if ($('input[name="part"]').length) {
        var part = $('input[name="part"]:checked').val();
        if (ItemType == "ラバーキーホルダー" && $('#big_size').is(':checked')) {
            $("input[name='part'][value='リング黒色']").parents(".flex-item").hide();
            if (part == "リング黒色") {
                $("input[name='part'][value='リング小（チェーン）']").prop('checked', true);
                getPartData('リング小（チェーン）');
                $('#sample-part-pic').attr('src', parts_obj["part_pic"]);
                $('#sample-part-name').text(parts_obj["part_name"]);
            }
        } else {
            $("input[name='part'][value='リング黒色']").parents(".flex-item").show();
        }
        if (part != undefined && ItemType != "ラバーコースター" && ItemType != "ラバースマートフォンスタンド" && ItemType != "ラバータグ" && ItemType != "ペットボトルホルダー") {
            $('#sample-part-pic').show();
            if (parts_obj) {
                $('#sample-part-pic').attr('src', parts_obj["part_pic"]);
                $('#sample-part-name').text(parts_obj["part_name"]);
            }
        } else {
            part = "";
            $('#sample-part-pic').hide();
            $('#sample-part-name').text('');
        }
    }

    // Get paper data (client-side)
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
                        paperPrice = Math.floor(tmp_pp[i].price);
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

    // Only proceed to Ajax pricing if quantity is set
    if (vno_of_order.value != "") {
        // Update UI display fields
        if ($('input[name=ItemPCS]').length && $('input[name=ItemPCS]:checked').val() != undefined) {
            $('#sample-prd-pcs').text($('input[name=ItemPCS]:checked').val());
        }

        if (ItemType == "ラバーストラップ" || ItemType == "ラバーキーホルダー" || ItemType == "ラバーイヤホンホルダー" || ItemType == "ラバージビッツ") {
            if ($('#big_size').length && $('#big_size').is(':checked')) {
                $('#sample-prd-size').text($('input[name=ItemSize]:checked').val());
                $('#prd_ItemSize').text($('input[name=ItemSize]:checked').val());
            } else if ($('input[name=ItemSize]').length && $('input[name=ItemSize]:checked').val() != undefined) {
                $('#sample-prd-size').text($('input[name=ItemSize]:checked').val());
                $('#prd_ItemSize').text($('input[name=ItemSize]:checked').val());
            }
        }

        if ($('input[name=ItemSize]').length && $('input[name=ItemSize]:checked').val() != undefined) {
            $('#sample-prd-size').text($('input[name=ItemSize]:checked').val());
            $('#prd_ItemSize').text($('input[name=ItemSize]:checked').val());
        }

        if ($('input[name=silk_print]').length && ItemType != "ラバータグ" && ItemType != "ペットボトルホルダー" && $('input[name=silk_print]:checked').val() != undefined) {
            $('#sample-prd-screen').text($('input[name=silk_print]:checked').val());
            $('#prd_silk_print').text($('input[name=silk_print]:checked').val());
        }

        if ($('input[name=coating]').length && $('input[name=coating]:checked').val() != undefined) {
            $('#sample-prd-coating').text($('input[name=coating]:checked').val());
            $('#prd_coating').text($('input[name=coating]:checked').val());
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
        if ($('#prd_part').length) {
            $('#prd_part').text($('input[name="part"]:checked').val());
        }

        // ===== AJAX PRICE CALCULATION =====
        var formData = {
            ItemType: $('input[name=ItemType]').val(),
            ItemPCS: $('input[name=ItemPCS]:checked').val(),
            numberOf: $('#no_of_order').val(),
            ItemSize: $('input[name=ItemSize]:checked').val(),
            silk_print: $('input[name=silk_print]:checked').val(),
            coating: $('input[name=coating]:checked').val(),
            ItemMaterial: $('input[name=ItemMaterial]:checked').val(),
            ItemDesignVariation: $('input[name=ItemDesignVariation]:checked').val(),
            part: $('input[name="part"]:checked').val(),
            part_price: getSelectedPartUnitPrice(),
            paper_select: $('input[name="paper_select"]:checked').val(),
            paper: $('input[name="paper"]:checked').val(),
            SendPrototype: $('input[name=SendPrototype]:checked').val(),
            DeFormat: $('input[name=DeFormat]:checked').val(),
            delivery_price: parseMoney($('#textfield_delivery').val())
        };

        // Attach loading state
        $('.total-price .prd_total').text('計算中...');

        $.post('/products/rubberstrap/ajax_calculate_price.php', formData, function(response) {
            if (response.success) {
                // Populate all price fields matching the old JS
                document.getElementById('textfield7').value = formatMoney(response.StrapPrice);
                document.getElementById('textfield7_1').value = formatMoney(response.PartPrice);
                document.getElementById('textfield7_2').value = formatMoney(response.PaperPrice);
                document.getElementById('textfield3').value = formatMoney(response.ProShipping);
                document.getElementById('textfield4').value = formatMoney(response.TraceCharge);
                document.getElementById('textfield13').value = formatMoney(response.SilkPrint);
                if ($('#textfield13_2').length) {
                    document.getElementById('textfield13_2').value = formatMoney(response.coatingPrice);
                }
                if ($('#DesignsCharge').length) {
                    document.getElementById('DesignsCharge').value = formatMoney(response.DesignsCharge);
                }
                if ($('#MaterialCharge').length) {
                    document.getElementById('MaterialCharge').value = formatMoney(response.MaterialCharge);
                }
                // SpeedShipping row visibility and value
                if ($('#SpeedShipping').length) {
                    document.getElementById('SpeedShipping').value = formatMoney(response.SpeedShipping);
                    if (response.SpeedShipping && response.SpeedShipping > 0) {
                        $('#row_speed_shipping').show();
                    } else {
                        $('#row_speed_shipping').hide();
                    }
                }
                document.getElementById('textfield9').value = formatMoney(response.BeforeTax);
                if ($('#textfield_delivery').length) {
                    document.getElementById('textfield_delivery').value = formatMoney(response.delivery_price || 0);
                }
                document.getElementById('textfield_dis').value = formatMoney(response.discount);
                if ($('#textfield_tax').length) {
                    document.getElementById('textfield_tax').value = formatMoney(response.Tax);
                }
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
                SpeedShipping = response.SpeedShipping || 0;
                strap_price = response.StrapPrice || 0;
                partPrice = (qty > 0 && response.PartPrice > 0) ? Math.floor(response.PartPrice / qty) : 0;
                paperPrice = (qty > 0 && response.PaperPrice > 0) ? Math.floor(response.PaperPrice / qty) : 0;
                packing_price = 0;
            } else {
                // Fallback: calculate locally
                console.warn('DB pricing failed, using local calculation:', response.error);
                calculateLocal();
            }
        }, 'json').fail(function(jqXHR) {
            console.warn('Ajax call failed, using local calculation:', jqXHR.responseText);
            calculateLocal();
        });
    }
}

// ===== FALLBACK: Local calculation (mirrors original setToInput) =====
function calculateLocal() {
    var ItemType = $('input[name=ItemType]').val();
    var vno_of_order = document.getElementById('no_of_order');
    var order_pcs = 0;

    if (ItemType == "ラバーストラップ" || ItemType == "ラバージビッツ") {
        if ($('#pcs1').is(':checked') || $('#pcs4').is(':checked')) {
            if (vno_of_order.value >= 5000) order_pcs = price_strap_standard[6];
            else if (vno_of_order.value >= 3000) order_pcs = price_strap_standard[5];
            else if (vno_of_order.value >= 1000) order_pcs = price_strap_standard[4];
            else if (vno_of_order.value >= 500) order_pcs = price_strap_standard[3];
            else if (vno_of_order.value >= 300) order_pcs = price_strap_standard[2];
            else if (vno_of_order.value >= 200) order_pcs = price_strap_standard[1];
            else if (vno_of_order.value >= 100) order_pcs = price_strap_standard[0];
        }
        if ($('#pcs2').is(':checked')) {
            if (vno_of_order.value >= 5000) order_pcs = price_strap_premium[6];
            else if (vno_of_order.value >= 3000) order_pcs = price_strap_premium[5];
            else if (vno_of_order.value >= 1000) order_pcs = price_strap_premium[4];
            else if (vno_of_order.value >= 500) order_pcs = price_strap_premium[3];
            else if (vno_of_order.value >= 300) order_pcs = price_strap_premium[2];
            else if (vno_of_order.value >= 200) order_pcs = price_strap_premium[1];
            else if (vno_of_order.value >= 100) order_pcs = price_strap_premium[0];
        }
    }

    if (ItemType == "ラバーストラップ" || ItemType == "ラバーキーホルダー" || ItemType == "ラバーイヤホンホルダー" || ItemType == "ラバージビッツ") {
        if ($('#pcs4').is(':checked')) {
            if (vno_of_order.value >= 300) order_pcs += 30;
            else if (vno_of_order.value >= 200) order_pcs += 44;
            else if (vno_of_order.value >= 100) order_pcs += 57;
        }
    }

    if ($('#big_size').length && $('#big_size').is(':checked')) {
        if ($('#pcs1').is(':checked') || $('#pcs4').is(':checked')) {
            order_pcs = Math.floor(order_pcs * 1.2);
        } else if ($('#pcs2').is(':checked')) {
            order_pcs = Math.floor(order_pcs * 1.1);
        }
    }

    var localStrapPrice = Math.floor(order_pcs) * vno_of_order.value;
    var localSilk = 0;
    if ($('#ariprint').length && document.getElementById('ariprint') && document.getElementById('ariprint').checked) {
        localSilk = vno_of_order.value * 30;
    }
    if ($('#fcprint').length && document.getElementById('fcprint') && document.getElementById('fcprint').checked) {
        localSilk = vno_of_order.value * 50;
    }

    var localCoating = 0;
    if ($('input[name=coating]:checked').val() == "汚れ防止加工あり") {
        localCoating = 70 * vno_of_order.value;
    }

    var localProto = 0;
    if ($('input[name=SendPrototype]:checked').val() != undefined) {
        localProto = 8000;
    }
    var localTrace = 0;
    if ($('input[name=DeFormat]:checked').val() != undefined) {
        localTrace = 8000;
    }

    if ($('input[name=ItemPCS]:checked').val() == "プレミアム") {
        localSilk = 0;
        localProto = 0;
        localTrace = 0;
    }

    var localPart = 0;
    if (parts_obj && $('input[name="part"]:checked').val()) {
        localPart = Math.floor(parts_obj["part_price"]) * vno_of_order.value;
    }

    var localDesign = 0;
    var designVal = $('input[name=ItemDesignVariation]:checked').val();
    if (designVal == "2種類") localDesign = 3000;
    else if (designVal == "3種類") localDesign = 6000;
    else if (designVal == "4種類") localDesign = 9000;

    var localMaterial = 0;
    if ($('input[name=ItemMaterial]:checked').val() == "特殊素材あり") {
        localMaterial = 30 * vno_of_order.value;
    }

    var localPaper = paperPrice * vno_of_order.value;
    var discount = 0;
    var localDelivery = parseMoney($('#textfield_delivery').val());
    var beforeTax = localStrapPrice + localSilk + localCoating + localPart + localPaper + localProto + localTrace + localDesign + localMaterial;
    var subtotal = Math.max(0, beforeTax - discount);
    var localTax = Math.floor(subtotal * 0.10);
    var grandTotal = subtotal + localDelivery + localTax;

    document.getElementById('textfield7').value = formatMoney(localStrapPrice);
    document.getElementById('textfield7_1').value = formatMoney(localPart);
    document.getElementById('textfield7_2').value = formatMoney(localPaper);
    document.getElementById('textfield3').value = formatMoney(localProto);
    document.getElementById('textfield4').value = formatMoney(localTrace);
    document.getElementById('textfield13').value = formatMoney(localSilk);
    if ($('#textfield13_2').length) {
        document.getElementById('textfield13_2').value = formatMoney(localCoating);
    }
    if ($('#DesignsCharge').length) {
        document.getElementById('DesignsCharge').value = formatMoney(localDesign);
    }
    if ($('#MaterialCharge').length) {
        document.getElementById('MaterialCharge').value = formatMoney(localMaterial);
    }
    // SpeedShipping: hide row in local fallback (no DB data available)
    if ($('#SpeedShipping').length) {
        document.getElementById('SpeedShipping').value = '';
        $('#row_speed_shipping').hide();
    }
    document.getElementById('textfield9').value = formatMoney(subtotal);
    if ($('#textfield_delivery').length) {
        document.getElementById('textfield_delivery').value = formatMoney(localDelivery);
    }
    document.getElementById('textfield_dis').value = formatMoney(discount);
    if ($('#textfield_tax').length) {
        document.getElementById('textfield_tax').value = formatMoney(localTax);
    }
    document.getElementById('textfield11').value = formatMoney(grandTotal);
    $('.prd_total').text(formatMoney(grandTotal));

    // Sync global variables for pdf_rubber.js (quotation PDF export)
    TextField7Value = localStrapPrice;
    TextField9Value = subtotal;
    tax = localTax;
    total = grandTotal;
    DisPrice = discount;
    proto_charge = localProto;
    trace_charge = localTrace;
    print_charge = localSilk;
    coating_charge = localCoating;
    DesignsCharge = localDesign;
    MaterialCharge = localMaterial;
    strap_price = localStrapPrice;
    partPrice = (localPart > 0 && vno_of_order.value > 0) ? Math.floor(localPart / vno_of_order.value) : 0;
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
    SpeedShipping = 0;

    document.getElementById('textfield7').value = "";
    document.getElementById('textfield7_1').value = "";
    document.getElementById('textfield7_2').value = "";
    document.getElementById('textfield3').value = "";
    document.getElementById('textfield4').value = "";
    document.getElementById('textfield13').value = "";
    if ($('#textfield13_2').length) {
        document.getElementById('textfield13_2').value = "";
    }
    if ($('#DesignsCharge').length) {
        document.getElementById('DesignsCharge').value = "";
    }
    if ($('#MaterialCharge').length) {
        document.getElementById('MaterialCharge').value = "";
    }
    if ($('#SpeedShipping').length) {
        document.getElementById('SpeedShipping').value = "";
        $('#row_speed_shipping').hide();
    }
    if ($('#textfield_delivery').length) {
        document.getElementById('textfield_delivery').value = "";
    }
    if ($('#textfield_tax').length) {
        document.getElementById('textfield_tax').value = "";
    }
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
    $('.part_price_std').show();
    $('.part_price_prm').hide();
    type_special_disabled('f1');
}

function click_typeorder_disabled() {
    $('.part_price_std').hide();
    $('.part_price_prm').show();
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
            if ($("input[name=ItemSize]").length) {
                $("#big_size").attr('disabled', true);
                $("#normal_size").prop('checked', true);
            }
            $("#no_of_order").val('10');
            $("#no_of_order").attr('readonly', true);
            $('.part_price_std').hide();
            $('.part_price_prm').show();
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
        if ($("input[name=ItemSize]").length) {
            $("#big_size").attr('disabled', false);
        }
        $("#no_of_order").attr('readonly', false);
        $('input[name=paper_select]').attr('disabled', false);
        $('input[name=SendPrototype]').attr('disabled', false);
        $('input[name=DeFormat]').attr('disabled', false);
        $("#button_pdf2").attr('disabled', false);
        $('.btn-next').attr('disabled', false);
    }
}

// ===== PART DATA =====
function getPartData(v) {
    setSelectedPartFallback(v);

    $.get("/products/acrylic/part.php", { c: "passed" }, function(data) {
        try {
            var duce = $.parseJSON(data);
            for (var i = 0; i < duce.length; i++) {
                if (duce[i]['part_name'] == v) {
                    parts_obj = duce[i];
                }
            }
        } catch (e) {
            console.warn('Part data parse failed, using selected part fallback:', e);
        }
    }).always(function() {
        setToInput();
    });
}

// ===== OVERRIDE: Redirect PDF export to renew version =====
// pdf_rubber.js (loaded after this file via defer) defines validate()
// with hardcoded URL /tcpdf/examples/pdf_export.php and /tcpdf/save_est.php.
// After all deferred scripts load, we wrap validate() to redirect both to their renew versions.
document.addEventListener('DOMContentLoaded', function() {
    if (typeof validate === 'function') {
        var _origValidate = validate;
        validate = function(tmp) {
            // Temporarily intercept window.open to redirect PDF URL
            var _origOpen = window.open;
            window.open = function(url, target) {
                if (url === '/tcpdf/examples/pdf_export.php') {
                    url = '/tcpdf/examples/pdf_export_renew.php';
                }
                var w = _origOpen.call(window, url, target);
                window.open = _origOpen; // Restore
                return w;
            };

            // Temporarily intercept $.ajax to redirect save_est URL
            var _origAjax = $.ajax;
            $.ajax = function(options) {
                if (options && options.url === '/tcpdf/save_est.php') {
                    options.url = '/tcpdf/save_est_renew.php';
                }
                var xhr = _origAjax.apply(this, arguments);
                $.ajax = _origAjax; // Restore
                return xhr;
            };

            // Force non-Safari path so window.open is used (which we've intercepted)
            var _wasSafari = window.isSafari;
            window.isSafari = false;

            _origValidate(tmp);

            // Restore after AJAX has had time to complete
            setTimeout(function() {
                window.isSafari = _wasSafari;
                window.open = _origOpen;
                $.ajax = _origAjax;
            }, 30000);
        };
    }
});
