/**
 * calculate-coaster-renew.js
 * DB-based price calculator for アクリルコースター (Acrylic Coaster).
 *
 * Key differences from badge/keychain:
 * - AJAX endpoints: ajax_calculate_price_coaster.php, ajax_price_table_coaster.php
 * - NO parts/attachments
 * - Single size: 90x90mm
 * - Screen: always 片面印刷 (1side)
 * - Step flow: Step1 (納期・サイズ) → Step2 (台紙等) → Step3 (製品仕様・製作料金)
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
        { "num": 400, "price": 19 }, { "num": 500, "price": 16 }, { "num": 600, "price": 16 },
        { "num": 700, "price": 14 }, { "num": 800, "price": 14 }, { "num": 900, "price": 13 },
        { "num": 1000, "price": 13 }
    ]
};

Object.size = function (obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

var paperPrice = 0;
var unit_price = 0;
var vat = 10;
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
            case "オプション入力へ":
                if (c == 'next' || c == 'step2') {
                    $('#back').fadeIn('slow');
                    $('#next').text('金額計算・見積・注文へ');
                    $('#step2').fadeIn('slow');
                    $('#dot-step1').addClass('active');
                    $('#dot-step2').addClass('active');
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
    }
}

function check_val(v) {
    if (v == 'next') {
        if ($('input[name=qty]').val() == "" || $('input[name=qty]').val() <= 0 || $('input[name=qty]').val() > 1000) {
            $('#qty-error').text('ご注文は1以上1,000以下でお願いします。');
            return false;
        } else {
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

/**
 * Main price calculation — uses AJAX to get prices from DB.
 * Coaster: single size (90x90mm), no parts, 片面印刷 only.
 */
function cal_c(v) {
    var qty = $('input[name="qty"]').val();

    if (!qty || parseInt(qty) <= 0) {
        updatePriceDisplay(0, 0, 0, 0, 0, 0, 0, 0);
        $('.prd_total').text('0');
        return;
    }

    var prodc_day = $('input[name="acy_delivery"]:checked').val();
    var ItemSize = $('input[name="acy_size"]:checked').val();
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

    if (sample != undefined) { $('#prd_sample').text(sample); $('#sample-prd-samp').text(sample); } else { $('#prd_sample').text('なし'); $('#sample-prd-samp').text('なし'); }
    if (trace != undefined) { $('#prd_trace').text(trace); $('#sample-prd-trace').text(trace); } else { $('#prd_trace').text('なし'); $('#sample-prd-trace').text('なし'); }

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

    // === AJAX call to get DB price (coaster endpoint) ===
    $.ajax({
        type: "POST",
        url: "/products/acrylic/ajax_calculate_price_coaster.php",
        dataType: "json",
        data: {
            acy_delivery: prodc_day,
            acy_size: ItemSize,
            acy_screen: '片面印刷',
            acy_part: 'なし',
            acy_paper_select: paper || 'なし',
            acy_paper: paper_color || 'なし',
            acy_sample: sample || 'なし',
            acy_trace: trace || 'なし',
            qty: qty,
            ItemType: $('#strap').val()
        },
        success: function (response) {
            if (response.status == 200) {
                unit_price = response.unit_price;
                var dbPrdPrice = response.prd_price;
                var dbPaperPrice = response.prd_paper_price;
                var dbSamplePrice = response.prd_sample_price;
                var dbTracePrice = response.prd_trace_price;

                sub_total = dbPrdPrice + dbPaperPrice + dbSamplePrice + dbTracePrice;
                vat_price = response.Tax;
                total = response.prd_total;
                disPrice = 0;

                if (response.paper_unit_price > 0) {
                    paperPrice = response.paper_unit_price;
                }

                updatePriceDisplay(dbPrdPrice, dbPaperPrice, dbSamplePrice, dbTracePrice, sub_total, vat_price, disPrice, total);
            } else {
                console.error('Price calculation error:', response.error);
                cal_c_local();
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', status, error);
            cal_c_local();
        }
    });
}

/**
 * Local fallback calculation when AJAX fails.
 */
function cal_c_local() {
    console.warn('cal_c_local: Using local fallback (DB unavailable).');
    var qty = parseInt($('input[name="qty"]').val()) || 1;

    // Paper price from local paperPrice_obj (already computed in cal_c)
    var localPaperTotal = paperPrice * qty;

    sub_total = localPaperTotal;
    disPrice = 0;
    vat_price = Math.floor(sub_total * 0.10);
    total = sub_total + vat_price;

    updatePriceDisplay(0, localPaperTotal, 0, 0, sub_total, vat_price, disPrice, total);
}

/**
 * Update all price display fields.
 * Coaster has no part price row.
 */
function updatePriceDisplay(prdPrice, paperPriceTotal, samplePrice, tracePrice, subTotal, tax, discount, grandTotal) {
    $('#prd_price').val(prdPrice.toLocaleString("en"));
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

    if (plus == "add") {
        if ($.inArray($('input[name=new_qty]').val(), amount) >= 0) {
            $('.add-error').text('この数量の製作単価は既に表示されております');
            return;
        } else {
            if ($('input[name=new_qty]').val() <= 0 || $('input[name=new_qty]').val() > 1000) {
                $('.add-error').text('6-10営業日のご注文は1000個以下となります');
                return;
            } else {
                if (days == "6" && $('input[name=new_qty]').val() > 300) {
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
        if (days == "6") {
            amount = ['1', '5', '10', '20', '30', '50', '70', '100', '200', '300'];
            amount_add = [];
        } else {
            amount = ['1', '5', '10', '20', '30', '50', '70', '100', '200', '300', '500', '1000'];
            amount_add = [];
        }
    }

    // AJAX call to get price table from DB (coaster endpoint — single size column)
    $.ajax({
        type: "POST",
        url: "/products/acrylic/ajax_price_table_coaster.php",
        dataType: "json",
        data: {
            delivery: days
        },
        success: function (response) {
            if (response.status == 200) {
                var text = "";
                $('.price-row').remove();

                for (var i = 0; i < amount.length; i++) {
                    var qtyVal = parseInt(amount[i]);
                    var dbRow = null;
                    for (var r = 0; r < response.rows.length; r++) {
                        if (response.rows[r].qty == qtyVal) {
                            dbRow = response.rows[r];
                            break;
                        }
                    }

                    if (!dbRow) {
                        dbRow = { qty: qtyVal, size90: 0 };
                        for (var r = response.rows.length - 1; r >= 0; r--) {
                            if (response.rows[r].qty <= qtyVal) {
                                dbRow.size90 = response.rows[r].size90;
                                break;
                            }
                        }
                    }

                    if ($.inArray(amount[i], amount_add) >= 0) {
                        text += '<tr class="price-row added"><td>' + amount[i] + '</td>';
                    } else {
                        text += '<tr class="price-row"><td>' + amount[i] + '</td>';
                    }
                    text += '<td>' + Math.floor(dbRow.size90 * (1 + vat / 100)).toLocaleString("en") + '</td>';
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

// === Init ===

$(function () {
    writePriceTable();
});

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
    var paper = "なし";
    var Item_print = "片面印刷";
    var itemtype_size = "";
    var example = "";
    var ai_file = "";
    var paper_price = 0;

    Item = $("#strap").val();
    delivery = $("input[name=acy_delivery]:checked").val();
    itemtype_size = $("input[name=acy_size]:checked").val() + "x" + $("input[name=acy_size]:checked").val() + "mm.";

    if ($('input[name="acy_paper_select"]:checked').val() == 'あり') {
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
            "cus_name": cus_name, "cus_lname": cus_lname, "crop_name": crop_name,
            "zip": zip, "address1": address1, "address2": address2,
            "address_street": address_street, "tel": tel, "comment": comment,
            "Item": Item, "delivery": delivery, "itemtype_print": Item_print,
            "itemtype_size": itemtype_size, "example": example, "part": "なし",
            "paper": paper, "ai_file": ai_file, "qty": qty,
            "item_price": item_price, "sum1_quo": sum1_quo, "sum2_quo": sum2_quo,
            "sum3_quo": sum3_quo, "sum4_quo": sum4_quo, "delivery_price": delivery_price,
            "discount": formatMoney(discount_quo), "example_price": example_price,
            "ai_file_price": ai_file_price, "part_price": 0,
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
    cal_c();
}

// Save calc data for sales order sync
function calculate_price_manual(type) {
    var prodc_day = $('input[name="acy_delivery"]:checked').val();
    var ItemSize = $('input[name="acy_size"]:checked').val();
    var paper = $('input[name="acy_paper_select"]:checked').val();
    var paper_color = $('input[name="acy_paper"]:checked').val();
    var sample = $('input[name="acy_sample"]:checked').val();
    var trace = $('input[name="acy_trace"]:checked').val();
    var qty = $('input[name="qty"]').val();

    $.ajax({
        type: "POST",
        url: "/products/acrylic/save_calc_data.php",
        dataType: "json",
        data: {
            sku: 'acrylic-coaster',
            acy_delivery: prodc_day,
            acy_size: ItemSize,
            acy_screen: '片面印刷',
            acy_part: 'なし',
            acy_paper_select: paper || 'なし',
            acy_paper: paper_color || 'なし',
            acy_sample: sample || 'なし',
            acy_trace: trace || 'なし',
            qty: qty,
            ItemType: $('#strap').val(),
            unit_price: unit_price,
            prd_price: $('#prd_price').val(),
            prd_part_price: 0,
            prd_paper_price: $('#prd_paper_price').val(),
            prd_sample_price: $('#prd_sample_price').val(),
            prd_trace_price: $('#prd_trace_price').val(),
            prd_sub_total: sub_total,
            Tax: vat_price,
            prd_total: total,
            discount: disPrice
        },
        success: function (response) {
            console.log('Calc data saved:', response);
        }
    });
}
