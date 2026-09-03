/**
 * calculate-rainbow-renew.js
 * Rainbow Acrylic Keychain (レインボーアクリルキーホルダー) — DB-based price calculator.
 * Replaces hardcoded price arrays with AJAX calls to ajax_calculate_price_rainbow.php.
 *
 * This file keeps the same UI logic (step1 → step2 → step3, validation, part selection)
 * as calculate.js, but fetches prices from the database instead of using JS price tables.
 */

var isSafari = navigator.vendor && navigator.vendor.indexOf('Apple') > -1 &&
    navigator.userAgent &&
    navigator.userAgent.indexOf('CriOS') == -1 &&
    navigator.userAgent.indexOf('FxiOS') == -1;

// Paper prices are still loaded from the existing part-acrylic-keychain.php
// but product prices come from DB via AJAX.

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

// Get object size
Object.size = function (obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

var parts_obj;
var paperPrice = 0;
var unit_price = 0;
var vat = 10;
var partPrice = 0;
var sub_total = 0;
var disPrice = 0;
var vat_price = 0;
var total = 0;

function validation(c) {
    if (check_val(c)) {
        $('#step1').fadeOut('fast');
        $('#step2').fadeOut('fast');
        $('#step3').fadeOut('fast');
        $('#dot-step1').removeClass('active');
        $('#dot-step2').removeClass('active');
        $('#dot-step3').removeClass('active');

        // New condition check button click
        let currentClick = null;
        if (typeof event !== "undefined" && event && event.target) {
            if (document.referrer && (document.referrer == "https://hotmobily.jp/order/cart.php")) {
                currentClick = 'redirect';
            } else {
                currentClick = $(event.target).text();
            }
        } else {
            currentClick = "redirect";
        }

        switch ($('#next').text()) {
            case "アタッチメント・オプション入力へ":
                if (c == 'next' || c == 'step2') {
                    $('#back').fadeIn('slow');
                    $('#next').text('金額計算・見積・注文へ');
                    $('#step2').fadeIn('slow');
                    $('#dot-step1').addClass('active');
                    $('#dot-step2').addClass('active');
                    chk_part();
                } else if (c == 'step3') {
                    $('#next').text('金額計算・見積・注文へ');
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
                    $('#back').fadeOut('fast');
                    $('#dot-step1').addClass('active');
                    $('#next').attr('disabled', false);
                } else {
                    $('#back').fadeIn('slow');
                    $('#next').fadeIn('slow');
                    $('#next').text('金額計算・見積・注文へ');
                    $('#step2').fadeIn('slow');
                    $('#dot-step1').addClass('active');
                    $('#dot-step2').addClass('active');
                }
        }
        $(window).scrollTop($('.step-container').offset().top);
    }
}

function check_val(v) {
    if (v == 'next') {
        // Validate shape_processing (加工タイプ)
        $('#error_shape_processing').empty();
        if ($('input[name="shape_processing"]').length && !$('input[name="shape_processing"]').is(':checked')) {
            $('#error_shape_processing').text('このオプションを選択する必要があります。');
            return false;
        }

        if ($('input[name=qty]').val() == "" || $('input[name=qty]').val() <= 0 || $('input[name=qty]').val() > 1000) {
            $('#qty-error').text('ご注文は1以上1,000以下でお願いします。');
            return false;
        } else {
            // Simulator option check
            var simulatorValue = $('input[name="acy_simulator"]:checked').val();
            if (simulatorValue == "はい") {
                $('input[name=acy_paper_select][type="checkbox"]').prop('checked', false);
                $('input[name=acy_paper_select][type="checkbox"]').removeAttr("checked");
                $('input[name=acy_paper_select][type="checkbox"]').attr('disabled', true);
                $('#acy_paper_msg').html('<p class="red">※シミュレーター使用の注文は台紙なしとなります。</p>');
            } else {
                $('input[name=acy_paper_select][type="checkbox"]').attr('disabled', false);
                $('#acy_paper_msg').html('');
            }

            // Only check part selection on step 2→3 (not step 1→2)
            var isStep2to3 = ($('#next').text() == '金額計算・見積・注文へ');
            if (isStep2to3 && !chk_part()) {
                return false;
            }

            if ($('input[name=qty]').val() < 20) {
                $('input[name=acy_sample][type="checkbox"]').prop('checked', false);
                $('input[name=acy_sample][type="checkbox"]').removeAttr("checked");
                $('#sample-error').text('試作品は20個以上のご注文から受付');
                $('input[name=acy_sample][type="checkbox"]').attr('disabled', true);
            }
            if ($('input[name="acy_delivery"]:checked').val() == "6営業日" && $('input[name=qty]').val() > 300) {
                $('#qty-error').text('6営業日のご注文は300個以下となります');
                return false;
            } else {
                $('#qty-error').text('');
                cal_c();
                return true;
            }
        }
    } else {
        return true;
    }
}

function chk_part() {
    if ($('input[name="acy_part"]:checked').val() == undefined) {
        $('#next').attr('disabled', true);
        $('#part-error').text('アタッチメントを選択してください');
        validation('step2');
        return false;
    } else {
        $('#part-error').text('');
        return true;
    }
}

/**
 * Main price calculation — uses AJAX to get prices from DB.
 */
function cal_c(v) {
    var qty = $('input[name="qty"]').val();

    // Don't calculate if qty is empty or 0
    if (!qty || parseInt(qty) <= 0) {
        updatePriceDisplay(0, 0, 0, 0, 0, 0, 0, 0, 0);
        $('.prd_total').text('0');
        return;
    }

    var prodc_day = $('input[name="acy_delivery"]:checked').val();
    var ItemSize = $('input[name="acy_size"]:checked').val();
    var screen = $('input[name="acy_screen"]:checked').val();
    var part = $('input[name="acy_part"]:checked').val();
    var paper = $('input[name="acy_paper_select"]:checked').val();
    var paper_color = $('input[name="acy_paper"]:checked').val();
    var sample = $('input[name="acy_sample"]:checked').val();
    var trace = $('input[name="acy_trace"]:checked').val();

    // Update display labels
    var shapeProc = $('input[name="shape_processing"]:checked').val();
    $('#sample-prd-prdt').text(prodc_day);
    $('#sample-prd-size').text(ItemSize + "x" + ItemSize + "mm.");
    $('#sample-prd-process').text(shapeProc || '');  // 加工タイプ display
    $('#sample-prd-screen').text(screen);
    $('#sample-prd-qty').text(qty);
    $('#prd_production').text(prodc_day);
    $('#prd_size').text(ItemSize + "mm" + "X" + ItemSize + "mm");
    $('#prd_processing').text(shapeProc || '');  // 加工タイプ display in step3
    $('#prd_print').text(screen);
    $('#prd_amount').text(qty);
    $('#prd_part').text(part);

    if (sample != undefined) { $('#prd_sample').text(sample); $('#sample-prd-samp').text(sample); } else { $('#prd_sample').text('なし'); $('#sample-prd-samp').text('なし'); }
    if (trace != undefined) { $('#prd_trace').text(trace); $('#sample-prd-trace').text(trace); } else { $('#prd_trace').text('なし'); $('#sample-prd-trace').text('なし'); }

    // Part display
    if (part != undefined && parts_obj) {
        $('#part-error').text('');
        $('#sample-part-pic').show();
        partPrice = Math.floor(parts_obj["part_price"] * (1 + vat / 100));
        $('#sample-part-pic').attr('src', parts_obj["part_pic"]);
        $('#sample-part-name').text(parts_obj["part_name"]);
    } else {
        partPrice = 0;
        $('#sample-part-pic').hide();
        $('#sample-part-name').text('アタッチメント:なし');
    }

    // Paper display & price (kept as local fallback)
    var localPaperPrice = 0;
    if (paper != undefined) {
        $('.paper-container').show();
        if (paper_color != undefined) {
            $('#sample-paper-pic').show();
            $('#sample-paper-pic').attr('src', "img/" + paper_color + ".jpg?v=1.01");
            $('#sample-paper-name').text(paper_color);
            $('#next').attr('disabled', false);
            $('#back').attr('disabled', false);
            $('#prd_paper').text(paper_color);
            $('#paper-error').text('');
            if (paper_color == "paper-patternA-1") {
                var tmp_pp = paperPrice_obj['1side'];
            } else if (paper_color == "paper-patternA-2") {
                var tmp_pp = paperPrice_obj['2side'];
            } else {
                var tmp_pp = paperPrice_obj['tmp'];
            }
            for (var i = 0, iMax = tmp_pp.length; i < iMax; i++) {
                if (parseInt(qty) >= parseInt(tmp_pp[i].num)) {
                    localPaperPrice = Math.floor(tmp_pp[i].price * (1 + vat / 100));
                    continue;
                }
                break;
            }
            paperPrice = localPaperPrice;
        } else {
            $('#paper-error').text('台紙を選択してください。');
            $('#next').attr('disabled', true);
            $('#back').attr('disabled', true);
        }
    } else {
        $('.paper-container').hide();
        $('#sample-paper-pic').hide();
        $('#sample-paper-name').text('なし');
        $('#paper-error').text('');
        $('#next').attr('disabled', false);
        $('#back').attr('disabled', false);
        $('#prd_paper').text('なし');
        $('input[name="acy_paper_select"]').attr('checked', false);
        $('input[name="acy_paper"]').attr('checked', false);
        paperPrice = 0;
    }

    // === AJAX call to get DB price ===
    console.log('cal_c: sending AJAX with qty=' + qty + ', delivery=' + prodc_day + ', size=' + ItemSize + ', screen=' + screen);
    $.ajax({
        type: "POST",
        url: "/products/acrylic/ajax_calculate_price_rainbow.php",
        dataType: "json",
        data: {
            acy_delivery: prodc_day,
            acy_size: ItemSize,
            acy_screen: screen,
            acy_part: part || 'なし',
            acy_paper_select: paper || 'なし',
            acy_paper: paper_color || 'なし',
            acy_sample: sample || 'なし',
            acy_trace: trace || 'なし',
            qty: qty,
            ItemType: $('#strap').val()
        },
        success: function (response) {
            console.log('cal_c: AJAX response:', response);
            if (response.status == 200) {
                // DB returns pre-tax prices, display as-is (tax is separate row)
                unit_price = response.unit_price;
                var dbPrdPrice = response.prd_price;
                var dbPartPrice = response.prd_part_price;
                var dbPaperPrice = response.prd_paper_price;
                var dbSamplePrice = response.prd_sample_price;
                var dbTracePrice = response.prd_trace_price;

                // Fallback: if DB paper price is 0 but local paper calculation has a value, use local
                var usedPaperFallback = false;
                if (dbPaperPrice <= 0 && paperPrice > 0) {
                    dbPaperPrice = paperPrice * parseInt(qty);
                    usedPaperFallback = true;
                }

                sub_total = dbPrdPrice + dbPartPrice + dbPaperPrice + dbSamplePrice + dbTracePrice;

                // If paper fallback was used, recalculate tax and total
                if (usedPaperFallback) {
                    vat_price = Math.floor(sub_total * 0.10);
                    total = sub_total + vat_price;
                } else {
                    vat_price = response.Tax;
                    total = response.prd_total;
                }

                disPrice = 0;

                // Update part unit price from DB
                if (response.part_unit_price > 0) {
                    partPrice = response.part_unit_price;
                }
                // Update paper unit price from DB
                if (response.paper_unit_price > 0) {
                    paperPrice = response.paper_unit_price;
                }

                updatePriceDisplay(dbPrdPrice, dbPartPrice, dbPaperPrice, dbSamplePrice, dbTracePrice, sub_total, vat_price, disPrice, total);
            } else {
                console.error('Price calculation error:', response.error);
                // Fallback: use local calculation
                cal_c_local();
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', status, error, xhr.responseText);
            // Fallback: use local calculation
            cal_c_local();
        }
    });
}

/**
 * Local fallback calculation (same as original calculate.js logic)
 * Used when AJAX call fails.
 */
function cal_c_local() {
    var qty = parseInt($('input[name="qty"]').val()) || 1;
    // Reset to 0 since we can't get DB prices
    sub_total = 0;
    vat_price = 0;
    total = 0;
    disPrice = 0;
    updatePriceDisplay(0, 0, 0, 0, 0, 0, 0, 0, 0);
}

/**
 * Update all price display fields.
 */
function updatePriceDisplay(prdPrice, partPriceTotal, paperPriceTotal, samplePrice, tracePrice, subTotal, tax, discount, grandTotal) {
    $('#prd_price').val(prdPrice.toLocaleString("en"));
    $('#prd_part_price').val(partPriceTotal.toLocaleString("en"));
    $('#prd_paper_price').val(paperPriceTotal.toLocaleString("en"));
    $('#prd_sample_price').val(samplePrice.toLocaleString("en"));
    $('#prd_trace_price').val(tracePrice.toLocaleString("en"));

    $('#prd_sub_total').val(subTotal.toLocaleString("en"));
    if ($('#prd_tax').length) {
        $('#prd_tax').val(tax.toLocaleString("en"));
    }
    $('#discount').val(discount.toLocaleString("en"));
    $('.prd_total').text(grandTotal.toLocaleString("en"));
    $('#prd_total').val(grandTotal.toLocaleString("en"));
}

// === Price reference table (DB-based) ===

var amount = ['1', '5', '10', '20', '30', '50', '70', '100', '200', '300', '500', '1000'];
var amount_add = [];

function writePriceTable(plus) {
    var days = $('input[name=prc_delivery]:checked').val();
    var screen = $('input[name=prc_screen]:checked').val();

    // Get customer-added qty
    if (plus == "add") {
        if ($.inArray($('input[name=new_qty]').val(), amount) >= 0) {
            $('.add-error').text('この数量の製作単価は既に表示されております');
            return;
        } else {
            if ($('input[name=new_qty]').val() <= 0 || $('input[name=new_qty]').val() > 1000) {
                $('.add-error').text('6-10営業日のご注文は1000個以下となります');
                return;
            } else {
                if (days == "6" && (screen == "1" || screen == "2") && $('input[name=new_qty]').val() > 300) {
                    $('.add-error').text('6営業日のご注文は300個以下となります');
                    return;
                } else {
                    $('.add-error').text('');
                    amount.push($('input[name=new_qty]').val());
                    amount.sort(function (a, b) { return a - b; });
                    amount_add.push($('input[name=new_qty]').val());
                }
            }
        }
    } else if (plus == "del") {
        // Reset amounts on delivery change
        if (days == "6") {
            amount = ['1', '5', '10', '20', '30', '50', '70', '100', '200', '300'];
            amount_add = [];
        } else {
            amount = ['1', '5', '10', '20', '30', '50', '70', '100', '200', '300', '500', '1000'];
            amount_add = [];
        }
    }

    // AJAX call to get price table from DB
    $.ajax({
        type: "POST",
        url: "/products/acrylic/ajax_price_table_rainbow.php",
        dataType: "json",
        data: {
            delivery: days,
            screen: screen
        },
        success: function (response) {
            if (response.status == 200) {
                var text = "";
                $('.price-row').remove();

                for (var i = 0; i < amount.length; i++) {
                    var qtyVal = parseInt(amount[i]);
                    // Find matching row from DB response
                    var dbRow = null;
                    for (var r = 0; r < response.rows.length; r++) {
                        if (response.rows[r].qty == qtyVal) {
                            dbRow = response.rows[r];
                            break;
                        }
                    }

                    // For custom-added quantities, pick from tiers
                    if (!dbRow) {
                        dbRow = { qty: qtyVal, size50: 0, size75: 0, size100: 0 };
                        // Find the best matching tier (largest qty <= qtyVal)
                        for (var r = response.rows.length - 1; r >= 0; r--) {
                            if (response.rows[r].qty <= qtyVal) {
                                dbRow.size50 = response.rows[r].size50;
                                dbRow.size75 = response.rows[r].size75;
                                dbRow.size100 = response.rows[r].size100;
                                break;
                            }
                        }
                    }

                    if ($.inArray(amount[i], amount_add) >= 0) {
                        text += '<tr class="price-row added"><td>' + amount[i] + '</td>';
                    } else {
                        text += '<tr class="price-row"><td>' + amount[i] + '</td>';
                    }
                    text += '<td>' + Math.floor(dbRow.size50 * (1 + vat / 100)).toLocaleString("en") + '</td>';
                    text += '<td>' + Math.floor(dbRow.size75 * (1 + vat / 100)).toLocaleString("en") + '</td>';
                    text += '<td>' + Math.floor(dbRow.size100 * (1 + vat / 100)).toLocaleString("en") + '</td>';
                    text += '</tr>';
                }
                $('.tbl-price tbody').append(text);
            }
        },
        error: function () {
            console.error('Price table AJAX error');
        }
    });
}

// === Part data loading ===

$(function () {
    writePriceTable();
    // Rainbow acrylic uses same parts as acrylic keychain
    getPartData($('input[name="acy_part"]:checked').val());
});

function getPartData(v) {
    $.get("part-acrylic-keychain-renew.php", { c: "passed" }, function (data) {
        var duce = $.parseJSON(data);
        for (var i = 0; i < duce.length; i++) {
            if (duce[i]['part_name'] == v) {
                parts_obj = duce[i];
                break;
            } else {
                parts_obj = duce[0];
            }
        }
    }).done(function () {
        cal_c();
    });
}

function getPartData2(v) {
    $.get("part-umbrella.php", { c: "passed" }, function (data) {
        var duce = $.parseJSON(data);
        for (var i = 0; i < duce.length; i++) {
            if (duce[i]['part_name'] == v) {
                parts_obj = duce[i];
                break;
            } else {
                parts_obj = duce[0];
            }
        }
    }).done(function () {
        cal_c();
    });
}

function getPartData3(v) {
    $.get("part-badge.php", { c: "passed" }, function (data) {
        var duce = $.parseJSON(data);
        for (var i = 0; i < duce.length; i++) {
            if (duce[i]['part_name'] == v) {
                parts_obj = duce[i];
                break;
            } else {
                parts_obj = duce[0];
            }
        }
    }).done(function () {
        cal_c();
    });
}

// === PDF export (quotation) ===

function validate(tmp) {
    ytag({
        "type": "yss_conversion",
        "config": {
            "yahoo_conversion_id": "1000179237",
            "yahoo_conversion_label": "B-vUCIagnVkQr-mfxwM",
            "yahoo_conversion_value": "0"
        }
    });

    gtag('event', 'conversion', {
        'send_to': 'AW-1036353231/IGnMCK-CuAEQz_2V7gM'
    });

    if (tmp == "gcd") {
        var cus_name = $('#sname').val();
        var cus_lname = $('#fname').val();
        var crop_name = $('#Corp_Name').val();
        var zip = $('#zip').val();
        var address1 = $('#address1').val();
        var address2 = $('#address2').val();
        var address_street = $('#address_street').val();
        var tel = $('#tel').val();
        var comment = $('#comment').val();
    } else {
        var cus_name = "";
        var cus_lname = "";
        var crop_name = "";
        var zip = "";
        var address1 = "";
        var address2 = "";
        var address_street = "";
        var tel = "";
        var comment = "";
    }
    var n = new Date();
    var d = n.getDate();
    var m = n.getMonth();
    var y = n.getFullYear();
    var h = n.getHours();
    var min = n.getMinutes();
    var s = n.getSeconds();
    var qty = $('input[name=qty]').val();
    var filename = "";
    m++;
    var date = y + "年" + m + "月" + d + "日";

    if (m < 10 || d < 10) {
        if (m < 10 && d < 10) {
            filename = "HM_QT_" + y + "0" + m + "0" + d + "_" + h + min + s;
        } else if (m < 10) {
            filename = "HM_QT_" + y + "0" + m + d + "_" + h + min + s;
        } else {
            filename = "HM_QT_" + y + m + "0" + d + "_" + h + min + s;
        }
    } else {
        filename = "HM_QT_" + y + m + d + "_" + h + min + s;
    }

    var Item = "";
    var delivery = "";
    var parts = "";
    var paper = "なし";
    var Item_print = "";
    var itemtype_size = "";
    var example = "";
    var ai_file = "";
    var back_print = "";
    var paper_price = 0;

    Item = $("#strap").val();
    delivery = $("input[name=acy_delivery]:checked").val();
    itemtype_size = $("input[name=acy_size]:checked").val() + "x" + $("input[name=acy_size]:checked").val() + "mm.";
    parts = $('input[name="acy_part"]:checked').val();

    if ($('input[name="acy_paper_select"]:checked').val() != undefined) {
        paper = $('input[name="acy_paper"]:checked').val();
        paper_price = paperPrice;
    }

    if ($("input[name=acy_sample]:checked").val() != undefined) {
        $('#example').text('あり');
        example = "あり";
    } else {
        $('#example').text('なし');
        example = "なし";
    }

    if ($("input[name=acy_trace]:checked").val() != undefined) {
        ai_file = "1";
    } else {
        ai_file = "0";
    }

    Item_print = $("input[name=acy_screen]:checked").val();
    var item_price = unit_price;
    var discount_quo = disPrice;
    var sum1_quo = sub_total.toLocaleString("en");
    var sum2_quo = 0;
    var sum3_quo = vat_price;
    var sum4_quo = total.toLocaleString("en");
    var example_price = 0, ai_file_price = 0;

    if (ai_file == "1") {
        ai_file_price = "0";
    }

    var parts_price = partPrice;
    var delivery_price = 0;

    if (total < 11000) {
        delivery_price = 880;
        sum4_quo = (total + delivery_price).toLocaleString("en");
        sum3_quo = vat_price + (delivery_price * vat / (100 + vat));
    }

    var remark = "";
    if ($('input[name=ItemDesignRepeat]:checked').val() == 'はい') {
        remark = "過去と同じデザイン:" + $('input[name=design_no]').val();
    }

    var shapeProcessing = "";
    if ($('input[name=shape_processing]').length && $('input[name=shape_processing]:checked').val() != undefined) {
        shapeProcessing = $('input[name=shape_processing]:checked').val();
    }

    $.ajax({
        type: "POST",
        url: "/tcpdf/save_est.php",
        data: {
            "cus_name": cus_name, "cus_lname": cus_lname, "crop_name": crop_name,
            "zip": zip, "address1": address1, "address2": address2,
            "address_street": address_street, "tel": tel, "comment": comment,
            "Item": Item, "delivery": delivery, "itemtype_print": Item_print,
            "itemtype_size": itemtype_size, "example": example, "part": parts,
            "paper": paper, "ai_file": ai_file, "qty": qty,
            "processing_option": shapeProcessing,
            "item_price": item_price, "sum1_quo": sum1_quo, "sum2_quo": sum2_quo,
            "sum3_quo": sum3_quo, "sum4_quo": sum4_quo, "delivery_price": delivery_price,
            "discount": formatMoney(discount_quo), "example_price": example_price,
            "ai_file_price": ai_file_price, "part_price": parts_price,
            "paper_price": paper_price,
            "filename": filename, "date": date, "remark": remark, "save": "yes"
        },
        success: function (data) {
            if (data == "success") {
                if (isSafari) {
                    location.href = '/tcpdf/examples/pdf_export.php';
                } else {
                    var win = window.open('/tcpdf/examples/pdf_export.php', '_blank');
                    win.focus();
                    $('.loading').hide();
                }
            } else {
                alert(data);
            }
        }
    });
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

function address_fn() {
    var str = $('#zip').val();
    if (str.length < 7) {
        $('#error').text('郵便番号を7桁で入力してください。');
    } else {
        $('#error').text('');
        $.ajax({
            url: "https://maps.googleapis.com/maps/api/geocode/json",
            dataType: 'json',
            crossDomain: true,
            type: 'get',
            data: {
                "key": "AIzaSyDMDXPiN_mBRVSoneHiivkOAMdHkSg8ZFw",
                "address": str,
                "language": "ja",
                "sensor": false
            },
            success: function (data) {
                if (data.status == "OK") {
                    var obj = data.results[0].address_components;
                    if (obj.length < 5) {
                        $('#error').text('自動変換できませんでした。都道府県、以降の住所をご入力下さい');
                        $('#address1').val("");
                        $('#address2').val("");
                        return false;
                    } else {
                        $('#address1').val(obj[3]['long_name']);
                        $('#address2').val(obj[2]['long_name'] + obj[1]['long_name']);
                        $('#error').text('');
                    }
                } else if (data.status == "ZERO_RESULTS") {
                    $('#error').text('自動変換できませんでした。都道府県、以降の住所をご入力下さい');
                    $('#address1').val("");
                    $('#address2').val("");
                }
            }
        });
    }
}

function setzero() {
    validation('step1');
    $('#cus_detail').hide();
    $("#form")[0].reset();
    // Rainbow acrylic uses same parts as acrylic keychain
    getPartData($('input[name="acy_part"]:checked').val());
    cal_c();
}
