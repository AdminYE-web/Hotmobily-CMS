/**
 * calculate-griptok-renew.js
 * DB-based price calculator for アクリルスマホグリップトック (Acrylic Grip Holder).
 *
 * Key features:
 * - AJAX endpoints: ajax_calculate_price_griptok.php, ajax_price_table_griptok.php
 * - Part loading: part-griptok.php (via getPartData4)
 * - Product codes: acrylicgripholder_{delivery}_{side}_{size}
 * - Screen: always 片面印刷 (fixed, not selectable)
 * - Size: 50 or 75
 * - Tax display: pre-tax subtotal → 10% tax → total with tax
 */

var isSafari = navigator.vendor && navigator.vendor.indexOf('Apple') > -1 &&
    navigator.userAgent &&
    navigator.userAgent.indexOf('CriOS') == -1 &&
    navigator.userAgent.indexOf('FxiOS') == -1;

// Paper prices (local fallback)
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

// ─── Price display helper ───────────────────────────────────────────
function updatePriceDisplay(prdPrice, partPriceTotal, paperPriceTotal, samplePrice, tracePrice, subTotal, tax, discount, grandTotal) {
    $('#prd_price').val(prdPrice.toLocaleString("en"));
    $('#prd_part_price').val(partPriceTotal.toLocaleString("en"));
    $('#prd_paper_price').val(paperPriceTotal.toLocaleString("en"));
    $('#prd_sample_price').val(samplePrice.toLocaleString("en"));
    $('#prd_trace_price').val(tracePrice.toLocaleString("en"));
    $('#prd_sub_total').val(subTotal.toLocaleString("en"));
    $('#Tax').val(tax.toLocaleString("en"));
    $('#discount').val(discount.toLocaleString("en"));
    $('.prd_total').text(grandTotal.toLocaleString("en"));
    $('#prd_total').val(grandTotal.toLocaleString("en"));
}

// ─── Step validation / navigation ───────────────────────────────────
function validation(c) {
    if (check_val(c)) {
        $('#step1').fadeOut('fast');
        $('#step2').fadeOut('fast');
        $('#step3').fadeOut('fast');
        $('#dot-step1').removeClass('active');
        $('#dot-step2').removeClass('active');
        $('#dot-step3').removeClass('active');

        // Detect current click
        var currentClick = null;
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
            case "オプション入力へ":
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
                    $('#next').text('オプション入力へ');
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

        // Save calc data on step transition
        if ((currentClick != "" && currentClick !== undefined) && (currentClick === "金額計算・見積・注文へ") && ($('#next').text() == "金額計算・見積・注文へ" && (c == "next"))) {
            var price_value = calculate_price_manual();
            if (Object.keys(price_value).length !== 0) {
                $.ajax({
                    type: "POST",
                    url: "/products/save_calc_data.php",
                    data: price_value,
                    success: function (response) {
                        if (response.status == 200 && response.calculation_token) {
                            $('#calculation_token').remove();
                            $('<input>').attr({ type: 'hidden', id: 'calculation_token', name: 'calculation_token', value: response.calculation_token }).appendTo('form#form');
                        }
                    }
                });
            }
        } else if ((currentClick != "" && currentClick !== undefined) && (currentClick === "redirect")) {
            var price_items = calculate_price_manual();
            if (Object.keys(price_items).length !== 0) {
                $.ajax({
                    type: "POST",
                    url: "/products/save_calc_data.php",
                    data: price_items,
                    success: function (response) {
                        if (response.status == 200 && response.calculation_token) {
                            $('#calculation_token').remove();
                            $('<input>').attr({ type: 'hidden', id: 'calculation_token', name: 'calculation_token', value: response.calculation_token }).appendTo('form#form');
                        }
                    }
                });
            }
        }
    }
}

function check_val(v) {
    if (v == 'next') {
        if ($('input[name=qty]').val() == "" || $('input[name=qty]').val() <= 0 || $('input[name=qty]').val() > 1000) {
            $('#qty-error').text('ご注文は1以上1,000以下でお願いします。');
            return false;
        } else {
            var isStep2to3 = ($('#next').text() == '金額計算・見積・注文へ');
            if (isStep2to3 && !chk_part()) {
                return false;
            }
            if ($('input[name=qty]').val() < 20) {
                $('input[name=acy_sample][type="checkbox"]').prop('checked', false);
                $('input[name=acy_sample][type="checkbox"]').removeAttr("checked");
                $('#sample-error').text('試作品は20個以上のご注文から受付');
                $('input[name=acy_sample][type="checkbox"]').attr('disabled', true);
            } else {
                $('#sample-error').text('※試作品をご希望される場合、ご注文納期とは別に試作品製作時間として6営業日+配送2日が必要になります。ご注文確定後に試作品の有無をご変更されるお客様が多くなっております。納期に余裕の無い場合、試作品のご依頼はご遠慮下さい。');
                $('input[name=acy_sample]').attr('disabled', false);
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

// ─── Main calculation (AJAX → DB) with local fallback ──────────────
function cal_c() {
    var qty = $('input[name="qty"]').val();

    if (!qty || parseInt(qty) <= 0) {
        updatePriceDisplay(0, 0, 0, 0, 0, 0, 0, 0, 0);
        $('.prd_total').text('0');
        return;
    }

    var prodc_day = $('input[name="acy_delivery"]:checked').val();
    var ItemSize = $('input[name="acy_size"]:checked').val();
    var screen = $('input[name="acy_screen"]').val() || '片面印刷';
    var part = $('input[name="acy_part"]:checked').val();
    var paper = $('input[name="acy_paper_select"]:checked').val();
    var paper_color = $('input[name="acy_paper"]:checked').val();
    var sample = $('input[name="acy_sample"]:checked').val();
    var trace = $('input[name="acy_trace"]:checked').val();

    // Update display labels
    $('#sample-prd-prdt').text(prodc_day);
    $('#sample-prd-size').text(ItemSize + "x" + ItemSize + "mm.");
    $('#sample-prd-qty').text(qty);
    $('#prd_production').text(prodc_day);
    $('#prd_size').text(ItemSize + "mm" + "X" + ItemSize + "mm");
    $('#prd_amount').text(qty);
    $('#prd_part').text(part || 'なし');

    if (sample != undefined) { $('#prd_sample').text(sample); $('#sample-prd-samp').text(sample); } else { $('#prd_sample').text('なし'); $('#sample-prd-samp').text('なし'); }
    if (trace != undefined) { $('#prd_trace').text(trace); $('#sample-prd-trace').text(trace); } else { $('#prd_trace').text('なし'); $('#sample-prd-trace').text('なし'); }

    // Part display
    if (part != undefined && parts_obj) {
        $('#part-error').text('');
        $('#sample-part-pic').show();
        $('#sample-part-pic').attr('src', parts_obj["part_pic"]);
        $('#sample-part-name').text(parts_obj["part_name"]);
    } else {
        $('#sample-part-pic').hide();
        $('#sample-part-name').text('アタッチメント:なし');
    }

    // Paper display & price (local fallback)
    var localPaperPrice = 0;
    if (paper != undefined && $('input[name="acy_paper_select"]:checked').val() == 'あり') {
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
        paperPrice = 0;
    }

    // AJAX DB price calculation
    $.ajax({
        type: "POST",
        url: "/products/acrylic/ajax_calculate_price_griptok.php",
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
        dataType: "json",
        success: function (data) {
            if (data && data.status === 200) {
                unit_price = data.unit_price;
                partPrice = data.part_unit_price || 0;
                var prdPrice = data.prd_price;
                var partPriceTotal = data.prd_part_price;
                var paperPriceDB = data.prd_paper_price;
                var samplePriceVal = data.prd_sample_price;
                var tracePriceVal = data.prd_trace_price;
                var subTotalVal = data.prd_sub_total;
                var taxVal = data.Tax;
                var discountVal = data.discount;
                var totalVal = data.prd_total;

                sub_total = subTotalVal;
                disPrice = discountVal;
                total = totalVal;
                vat_price = taxVal;

                updatePriceDisplay(prdPrice, partPriceTotal, paperPriceDB, samplePriceVal, tracePriceVal, subTotalVal, taxVal, discountVal, totalVal);
            } else {
                cal_c_local();
            }
        },
        error: function () {
            cal_c_local();
        }
    });
}

// ─── Local fallback calculation (JSON-based) ───────────────────────
function cal_c_local() {
    var prodc_day = $('input[name="acy_delivery"]:checked').val();
    var ItemSize = $('input[name="acy_size"]:checked').val();
    var part = $('input[name="acy_part"]:checked').val();
    var qty = $('input[name="qty"]').val();
    var trace_price = 0;
    var localPartPrice = 0;

    if (part != undefined && parts_obj) {
        localPartPrice = Math.floor(parts_obj["part_price"] * (1 + vat / 100));
    }

    // Note: local fallback doesn't have full price table
    // It uses 0 as unit_price if no local JSON data is available
    unit_price = 0;
    partPrice = localPartPrice;

    sub_total = Math.floor(((unit_price * qty) + trace_price + (partPrice * qty) + (paperPrice * qty)));
    disPrice = 0;
    vat_price = Math.floor(sub_total * vat / (100 + vat));
    total = Math.floor(parseInt(sub_total) - parseInt(disPrice));

    updatePriceDisplay(
        unit_price * qty,
        partPrice * qty,
        paperPrice * qty,
        0,
        trace_price,
        sub_total,
        vat_price,
        disPrice,
        total
    );
}

// ─── calculate_price_manual (for save_calc_data) ──────────────────
function calculate_price_manual() {
    var prodc_day = $('input[name="acy_delivery"]:checked').val();
    var ItemSize = $('input[name="acy_size"]:checked').val();
    var part = $('input[name="acy_part"]:checked').val();
    var paper = $('input[name="acy_paper_select"]:checked').val();
    var paper_color = $('input[name="acy_paper"]:checked').val();
    var sample = $('input[name="acy_sample"]:checked').val();
    var trace = $('input[name="acy_trace"]:checked').val();
    var qty = $('input[name="qty"]').val();
    var prd = $('#strap').val();

    var shipping_price = 880;
    if (sub_total > 11000) {
        shipping_price = 0;
    }

    return {
        sku: 'acrylic-griptok',
        product: prd,
        qty: qty,
        product_price: Math.floor(unit_price * qty),
        part_price: (partPrice * qty),
        paper_price: (paperPrice * qty),
        prototype_price: 0,
        ai_assistant_price: 0,
        trace_price: 0,
        discount: disPrice,
        shipping: shipping_price,
        vat: vat_price,
        subtotal: sub_total,
        total: total
    };
}

// ─── Price Table (AJAX from DB) ──────────────────────────────────
var amount = ['1', '5', '10', '20', '30', '50', '70', '100', '200', '300', '500', '1000'];
var amount_add = [];

function writePriceTable(plus) {
    var days = $('input[name=prc_delivery]:checked').val();

    if (plus == "add") {
        if ($.inArray($('input[name=new_qty]').val(), amount) >= 0) {
            $('.add-error').text('この数量の製作単価は既に表示されております');
        } else {
            if ($('input[name=new_qty]').val() <= 0 || $('input[name=new_qty]').val() > 1000) {
                $('.add-error').text('6-10営業日のご注文は1000個以下となります');
            } else {
                if (days == "6" && $('input[name=new_qty]').val() > 300) {
                    $('.add-error').text('6営業日のご注文は300個以下となります');
                } else {
                    $('.add-error').text('');
                    amount.push($('input[name=new_qty]').val());
                    amount.sort(function (a, b) { return a - b });
                    amount_add.push($('input[name=new_qty]').val());
                }
            }
        }
    } else {
        if (days == "6" && plus == "del") {
            amount = ['1', '5', '10', '20', '30', '50', '70', '100', '200', '300'];
            amount_add = [];
        } else if (days == "10" && plus == "del") {
            amount = ['1', '5', '10', '20', '30', '50', '70', '100', '200', '300', '500', '1000'];
            amount_add = [];
        }
    }

    // Fetch from DB
    $.ajax({
        type: "GET",
        url: "/products/acrylic/ajax_price_table_griptok.php",
        data: { delivery: days },
        dataType: "json",
        success: function (data) {
            if (data && data.status === 200) {
                renderPriceTable(data.rows, days);
            }
        }
    });
}

function renderPriceTable(rows, days) {
    var text = "";
    $('.price-row').remove();

    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var qtyStr = String(row.qty);
        if ($.inArray(qtyStr, amount_add) >= 0) {
            text += '<tr class="price-row added"><td>' + qtyStr + '</td>';
        } else {
            text += '<tr class="price-row"><td>' + qtyStr + '</td>';
        }
        // Size 50
        var p50 = Math.floor(row.size50 * (1 + vat / 100));
        text += '<td>' + p50 + '</td>';
        // Size 75
        var p75 = Math.floor(row.size75 * (1 + vat / 100));
        text += '<td>' + p75 + '</td>';
        text += '</tr>';
    }
    $('.tbl-price tbody').append(text);
}

// ─── Part data loader ──────────────────────────────────────────────
$(function () {
    writePriceTable();
    getPartData4($('input[name="acy_part"]:checked').val());
});

function getPartData4(v) {
    $.get("part-griptok.php", { c: "passed" }, function (data) {
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

        // Create new token when page load (MODE_MOD)
        var prd_strap = $('#strap').val();
        var mmt = $('#ms_mode').val();
        if ((mmt != "" && mmt == "MODE_MOD") && (prd_strap == "アクリルグリップホルダー" || prd_strap == "アクリルスマホグリップトック")) {
            var items = calculate_price_manual();
            if (Object.keys(items).length !== 0) {
                $.ajax({
                    type: "POST",
                    url: "/products/save_calc_data.php",
                    data: items,
                    success: function (response) {
                        if (response.status == 200 && response.calculation_token) {
                            $('#calculation_token').remove();
                            $('<input>').attr({ type: 'hidden', id: 'calculation_token', name: 'calculation_token', value: response.calculation_token }).appendTo('form#form');
                        }
                    }
                });
            }
        }
    });
}

// ─── PDF export / estimate ──────────────────────────────────────────
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

    Item_print = '片面印刷';

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

    $.ajax({
        type: "POST",
        url: "/tcpdf/save_est.php",
        data: {
            "cus_name": cus_name,
            "cus_lname": cus_lname,
            "crop_name": crop_name,
            "zip": zip,
            "address1": address1,
            "address2": address2,
            "address_street": address_street,
            "tel": tel,
            "comment": comment,
            "Item": Item,
            "delivery": delivery,
            "itemtype_print": Item_print,
            "itemtype_size": itemtype_size,
            "example": example,
            "part": parts,
            "paper": paper,
            "ai_file": ai_file,
            "qty": qty,
            "item_price": item_price,
            "sum1_quo": sum1_quo,
            "sum2_quo": sum2_quo,
            "sum3_quo": sum3_quo,
            "sum4_quo": sum4_quo,
            "delivery_price": delivery_price,
            "discount": formatMoney(discount_quo),
            "example_price": example_price,
            "ai_file_price": ai_file_price,
            "part_price": parts_price,
            "paper_price": paper_price,
            "filename": filename,
            "date": date,
            "remark": remark,
            "save": "yes"
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
    validation('step1'); $('#cus_detail').hide();
    $("#form")[0].reset();
    cal_c();
}
