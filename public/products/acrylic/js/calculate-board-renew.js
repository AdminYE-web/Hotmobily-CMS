/**
 * calculate-board-renew.js
 * Acrylic Board (アクリルボード) — DB-based price calculator.
 * Replaces hardcoded price arrays with AJAX calls to ajax_calculate_price_board.php.
 *
 * Board differences from keychain renew:
 *   - No part/attachment selection
 *   - No screen (1side/2side) selection
 *   - No size variants (same price for 横向き/縦向き)
 *   - Display: 小計(税抜) → 消費税(10%) → 合計(税込)
 */

var isSafari = navigator.vendor && navigator.vendor.indexOf('Apple') > -1 &&
    navigator.userAgent &&
    navigator.userAgent.indexOf('CriOS') == -1 &&
    navigator.userAgent.indexOf('FxiOS') == -1;

var paperPrice = 0;
var unit_price = 0;
var vat = 10;
var sub_total = 0;
var disPrice = 0;
var vat_price = 0;
var total = 0;

// Get object size
Object.size = function (obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

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

        // Save calculation data when moving to step 3
        if ((currentClick != "" && currentClick !== undefined) && (currentClick === "金額計算・見積・注文へ") && ($('#next').text() == "金額計算・見積・注文へ" && (c == "next"))) {
            let price_value = calculate_price_manual();
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
                        // silent fail
                    }
                });
            }
        } else {
            if ((currentClick != "" && currentClick !== undefined) && (currentClick === "redirect")) {
                let price_items = calculate_price_manual();
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
                            // silent fail
                        }
                    });
                }
            }
        }
    }
}

function check_val(v) {
    if (v == 'next') {
        if ($('input[name=qty]').val() == "" || $('input[name=qty]').val() <= 0 || $('input[name=qty]').val() > 1000) {
            $('#qty-error').text('ご注文は1以上1000以下でお願いします。');
            return false;
        } else {
            if ($('input[name=qty]').val() < 20) {
                $('input[name=acy_sample][type="checkbox"]').prop('checked', false);
                $('input[name=acy_sample][type="checkbox"]').removeAttr("checked");
                $('#sample-error').text('試作品は20個以上のご注文から受付');
                $('input[name=acy_sample][type="checkbox"]').attr('disabled', true);
            } else {
                $('#sample-error').text('');
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

/**
 * Main price calculation — uses AJAX to get prices from DB.
 * Board version: no part, no screen.
 */
function cal_c(v) {
    var qty = $('input[name="qty"]').val();

    // Don't calculate if qty is empty or 0
    if (!qty || parseInt(qty) <= 0) {
        updatePriceDisplay(0, 0, 0, 0, 0, 0, 0);
        $('.prd_total').text('0');
        return;
    }

    var prodc_day = $('input[name="acy_delivery"]:checked').val();
    var boardType = $('input[name="acy_size"]:checked').val();
    var sample = $('input[name="acy_sample"]:checked').val();
    var trace = $('input[name="acy_trace"]:checked').val();

    // Update display labels
    $('#sample-prd-prdt').text(prodc_day);
    $('#sample-prd-size').text(boardType);
    $('#sample-prd-qty').text(qty);
    $('#prd_production').text(prodc_day);
    $('#prd_size').text(boardType);
    $('#prd_amount').text(qty);

    if (sample != undefined) { $('#prd_sample').text(sample); $('#sample-prd-samp').text(sample); } else { $('#prd_sample').text('なし'); $('#sample-prd-samp').text('なし'); }
    if (trace != undefined) { $('#prd_trace').text(trace); $('#sample-prd-trace').text(trace); } else { $('#prd_trace').text('なし'); $('#sample-prd-trace').text('なし'); }

    // === AJAX call to get DB price ===
    $.ajax({
        type: "POST",
        url: "/products/acrylic/ajax_calculate_price_board.php",
        dataType: "json",
        data: {
            acy_delivery: prodc_day,
            acy_size: boardType,
            acy_sample: sample || 'なし',
            acy_trace: trace || 'なし',
            qty: qty,
            ItemType: $('#strap').val()
        },
        success: function (response) {
            if (response.status == 200) {
                // DB returns pre-tax prices
                unit_price = response.unit_price;
                var dbPrdPrice = response.prd_price;
                var dbSamplePrice = response.prd_sample_price;
                var dbTracePrice = response.prd_trace_price;

                sub_total = response.prd_sub_total;
                vat_price = response.Tax;
                total = response.prd_total;
                disPrice = response.discount || 0;

                updatePriceDisplay(dbPrdPrice, dbSamplePrice, dbTracePrice, sub_total, vat_price, disPrice, total);
            } else {
                console.error('Price calculation error:', response.error);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', status, error, xhr.responseText);
        }
    });
}

/**
 * Update all price display fields.
 * Board version: 商品代金 → 試作品 → データ作成補助 → 小計(税抜) → 消費税(10%) → 合計(税込)
 */
function updatePriceDisplay(prdPrice, samplePrice, tracePrice, subTotal, tax, discount, grandTotal) {
    $('#prd_price').val(prdPrice.toLocaleString("en"));
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

/**
 * Build price data for save_calc_data.php
 */
function calculate_price_manual() {
    var prodc_day = $('input[name="acy_delivery"]:checked').val();
    var boardType = $('input[name="acy_size"]:checked').val();
    var sample = $('input[name="acy_sample"]:checked').val();
    var trace = $('input[name="acy_trace"]:checked').val();
    var qty = $('input[name="qty"]').val();
    var prd = $('#strap').val();

    if (!qty || parseInt(qty) <= 0) return {};

    var shipping_price = 880;
    if (sub_total > 11000) {
        shipping_price = 0;
    }

    return {
        sku: 'acrylic-board',
        product: prd,
        qty: qty,
        product_price: Math.floor(unit_price * parseInt(qty)),
        part_price: 0,
        paper_price: 0,
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

// === Price reference table (DB-based) ===

var amount = ['1', '5', '10', '20', '30', '50', '70', '100', '200', '300', '500', '1000'];
var amount_add = [];

function writePriceTable(plus) {
    var days = $('input[name=prc_delivery]:checked').val();

    // Get customer-added qty
    if (plus == "add") {
        if ($.inArray($('input[name=new_qty]').val(), amount) >= 0) {
            $('.add-error').text('この数量の製作単価は既に表示されております');
            return;
        } else {
            if ($('input[name=new_qty]').val() <= 0 || $('input[name=new_qty]').val() > 1000) {
                $('.add-error').text('ご注文は1000個以下となります');
                return;
            } else {
                $('.add-error').text('');
                amount.push($('input[name=new_qty]').val());
                amount.sort(function (a, b) { return a - b; });
                amount_add.push($('input[name=new_qty]').val());
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
        url: "/products/acrylic/ajax_price_table_board.php",
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
                    // Find matching row from DB response
                    var dbRow = null;
                    for (var r = 0; r < response.rows.length; r++) {
                        if (response.rows[r].qty == qtyVal) {
                            dbRow = response.rows[r];
                            break;
                        }
                    }

                    // For custom-added quantities, pick from tiers (largest qty <= qtyVal)
                    if (!dbRow) {
                        dbRow = { qty: qtyVal, price: 0 };
                        for (var r = response.rows.length - 1; r >= 0; r--) {
                            if (response.rows[r].qty <= qtyVal) {
                                dbRow.price = response.rows[r].price;
                                break;
                            }
                        }
                    }

                    if ($.inArray(amount[i], amount_add) >= 0) {
                        text += '<tr class="price-row added"><td>' + amount[i] + '</td>';
                    } else {
                        text += '<tr class="price-row"><td>' + amount[i] + '</td>';
                    }
                    // Display pre-tax price
                    text += '<td>' + dbRow.price.toLocaleString("en") + '</td>';
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

// === Initialization ===
$(function () {
    // writePriceTable();  // Price table is commented out in board, uncomment if needed
    cal_c();
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
    var Item_print = "";
    var itemtype_size = "";
    var example = "";
    var ai_file = "";
    var paper_price = 0;

    Item = $("#strap").val();
    delivery = $("input[name=acy_delivery]:checked").val();
    itemtype_size = $("input[name=acy_size]:checked").val();

    // Board has no part
    var parts = "なし";

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

    var parts_price = 0;
    var delivery_price = 0;

    if (total < 11000) {
        delivery_price = 880;
        sum4_quo = (total + delivery_price).toLocaleString("en");
        sum3_quo = vat_price + Math.floor(delivery_price * vat / (100 + vat));
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
            "itemtype_size": itemtype_size, "example": example, "part": parts,
            "paper": paper, "ai_file": ai_file, "qty": qty,
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
    cal_c();
}
