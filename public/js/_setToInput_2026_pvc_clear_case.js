// Rubber printed
var price_printed_rubber_standard = [287, 273, 259, 248, 227, 189, 167, 158];
var price_printed_rubber_rush = [319, 303, 288, 276, 253, 210];

//Rubber Printted Coaster
var price_printed_rubber_coaster_standard = [410, 315, 300, 288, 276, 233, 218, 196];
var price_printed_rubber_coaster_rush = [456, 349, 334, 320, 307, 258];

// PVC Case Clear or Gritter
var price_pvc_clear = [688, 624, 453, 434, 382];

// PVC Case Aurora
var price_pvc_aurora = [798, 769, 561, 493, 476];

var paperPrice_obj = {
    "1side": [
        { "num": 1, "price": 1030 },
        { "num": 2, "price": 530 },
        { "num": 3, "price": 363 },
        { "num": 4, "price": 280 },
        { "num": 5, "price": 230 },
        { "num": 6, "price": 197 },
        { "num": 7, "price": 173 },
        { "num": 8, "price": 155 },
        { "num": 9, "price": 141 },
        { "num": 10, "price": 130 },
        { "num": 20, "price": 80 },
        { "num": 30, "price": 63 },
        { "num": 40, "price": 55 },
        { "num": 50, "price": 50 },
        { "num": 60, "price": 47 },
        { "num": 70, "price": 44 },
        { "num": 80, "price": 43 },
        { "num": 90, "price": 41 },
        { "num": 100, "price": 40 },
        { "num": 200, "price": 26 },
        { "num": 300, "price": 21 },
        { "num": 400, "price": 18 },
        { "num": 500, "price": 15 },
        { "num": 600, "price": 15 },
        { "num": 700, "price": 13 },
        { "num": 800, "price": 13 },
        { "num": 900, "price": 12 },
        { "num": 1000, "price": 12 }],
    "2side": [
        { "num": 1, "price": 1230 },
        { "num": 2, "price": 630 },
        { "num": 3, "price": 430 },
        { "num": 4, "price": 330 },
        { "num": 5, "price": 270 },
        { "num": 6, "price": 230 },
        { "num": 7, "price": 201 },
        { "num": 8, "price": 180 },
        { "num": 9, "price": 163 },
        { "num": 10, "price": 150 },
        { "num": 20, "price": 90 },
        { "num": 30, "price": 70 },
        { "num": 40, "price": 60 },
        { "num": 50, "price": 54 },
        { "num": 60, "price": 50 },
        { "num": 70, "price": 47 },
        { "num": 80, "price": 45 },
        { "num": 90, "price": 43 },
        { "num": 100, "price": 42 },
        { "num": 200, "price": 27 },
        { "num": 300, "price": 22 },
        { "num": 400, "price": 19 },
        { "num": 500, "price": 16 },
        { "num": 600, "price": 16 },
        { "num": 700, "price": 14 },
        { "num": 800, "price": 14 },
        { "num": 900, "price": 13 },
        { "num": 1000, "price": 13 }],
    "tmp": [
        { "num": 1, "price": 830 },
        { "num": 2, "price": 430 },
        { "num": 3, "price": 297 },
        { "num": 4, "price": 230 },
        { "num": 5, "price": 190 },
        { "num": 6, "price": 163 },
        { "num": 7, "price": 144 },
        { "num": 8, "price": 130 },
        { "num": 9, "price": 119 },
        { "num": 10, "price": 110 },
        { "num": 20, "price": 70 },
        { "num": 30, "price": 57 },
        { "num": 40, "price": 50 },
        { "num": 50, "price": 46 },
        { "num": 60, "price": 43 },
        { "num": 70, "price": 41 },
        { "num": 80, "price": 40 },
        { "num": 90, "price": 39 },
        { "num": 100, "price": 38 },
        { "num": 200, "price": 25 },
        { "num": 300, "price": 21 },
        { "num": 400, "price": 18 },
        { "num": 500, "price": 14 },
        { "num": 600, "price": 14 },
        { "num": 700, "price": 12 },
        { "num": 800, "price": 12 },
        { "num": 900, "price": 11 },
        { "num": 1000, "price": 11 }]
};

var parts_obj;
var paperPrice = 0;
var unit_price = 0;

function valid_chk_btn(c) {
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

        //New condition check price adapt
        // if ((currentClick != "" && currentClick !== undefined) && (currentClick === "金額計算・見積・注文へ")) {
        //     let price_value = setToInputManual();
        //     if (Object.keys(price_value).length !== 0) {
        //         $.ajax({
        //             type: "POST",
        //             url: "/products/save_calc_data.php",
        //             data: price_value,
        //             success: function (response) {
        //                 if (response.status == 200 && response.calculation_token) {
        //                     $('#calculation_token').remove();
        //                     $('<input>').attr({
        //                         type: 'hidden',
        //                         id: 'calculation_token',
        //                         name: 'calculation_token',
        //                         value: response.calculation_token
        //                     }).appendTo('form#form');
        //                 }
        //             }, error: function (xhr, status, error) {
        //                 console.log(error);
        //             }
        //         });
        //     }
        // }
        // else {
        //     if ((currentClick != "" && currentClick !== undefined) && (currentClick === "redirect")) {
        //         let pk = $('#strap').val();
        //         if (pk !== undefined && (pk == "ラバーコースター" || pk == "ラバースマートフォンスタンド" || pk == "ラバータグ" || pk == "ペットボトルホルダー" || pk == "ラバーケーブルバンド")) {
        //             let price_items = setToInputManual();
        //             if (Object.keys(price_items).length !== 0) {
        //                 $.ajax({
        //                     type: "POST",
        //                     url: "/products/save_calc_data.php",
        //                     data: price_items,
        //                     success: function (response) {
        //                         if (response.status == 200 && response.calculation_token) {
        //                             $('#calculation_token').remove();
        //                             $('<input>').attr({
        //                                 type: 'hidden',
        //                                 id: 'calculation_token',
        //                                 name: 'calculation_token',
        //                                 value: response.calculation_token
        //                             }).appendTo('form#form');
        //                         }
        //                     }, error: function (xhr, status, error) {
        //                         console.log(error);
        //                     }
        //                 });
        //             }
        //         }
        //     }
        // }

    }
}

function valid_chk_btn2(c) {
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
            currentClick = $(event.target).text();   // value from click
        } else {
            currentClick = "redirect";               // value from redirect
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
        // if ((currentClick != "" && currentClick !== undefined) && (currentClick === "金額計算・見積・注文へ")) {
        //     let price_value = setToInputManual();
        //     if (Object.keys(price_value).length !== 0) {
        //         $.ajax({
        //             type: "POST",
        //             url: "/products/save_calc_data.php",
        //             data: price_value,
        //             success: function (response) {
        //                 if (response.status == 200 && response.calculation_token) {
        //                     $('#calculation_token').remove();
        //                     $('<input>').attr({
        //                         type: 'hidden',
        //                         id: 'calculation_token',
        //                         name: 'calculation_token',
        //                         value: response.calculation_token
        //                     }).appendTo('form#form');
        //                 }
        //             }, error: function (xhr, status, error) {
        //                 console.log(error);
        //             }
        //         });
        //     }
        // }
        // else {
        //     if ((currentClick != "" && currentClick !== undefined) && (currentClick === "redirect")) {
        //         let pk = $('#strap').val();
        //         if (pk !== undefined && (pk == "ラバーコースター" || pk == "ラバースマートフォンスタンド" || pk == "ラバータグ" || pk == "ペットボトルホルダー")) {
        //             let price_items = setToInputManual();
        //             if (Object.keys(price_items).length !== 0) {
        //                 $.ajax({
        //                     type: "POST",
        //                     url: "/products/save_calc_data.php",
        //                     data: price_items,
        //                     success: function (response) {
        //                         if (response.status == 200 && response.calculation_token) {
        //                             $('#calculation_token').remove();
        //                             $('<input>').attr({
        //                                 type: 'hidden',
        //                                 id: 'calculation_token',
        //                                 name: 'calculation_token',
        //                                 value: response.calculation_token
        //                             }).appendTo('form#form');
        //                         }
        //                     }, error: function (xhr, status, error) {
        //                         console.log(error);
        //                     }
        //                 });
        //             }
        //         }
        //     }
        // }
    }
}

function check_val(v) {
    var ItemType = $('input[name=ItemType]').val();

    //エラー出力用id
    var err_number = document.getElementById('err_numberOf_mess');
    var mess = "";

    // console.log('dsdsds')

    err_number.style.display = "";

    //入力値
    var vNumberOfOder = $('#no_of_order');
    if (ItemType == "PVCクリアマルチケース") 
    {

        //Check Type
        if ($('input[name=ItemCat]').length && $('input[name=ItemCat]:checked').val() == undefined) {
            $('#error_cat').text('【必須】情報を選択してください。');
            return false;
        }

        if ($('input[name=ItemCat]').length) {
            $('#error_cat').text('');
        }


        //Check Hatome
        if ($('input[name=ItemMaterial]').length && $('input[name=ItemMaterial]:checked').val() == undefined) {
            $('#error_mat').text('【必須】情報を選択してください。');
            return false;
        }

        if ($('input[name=ItemMaterial]').length) {
            $('#error_mat').text('');
        }

        //Check Part
        if ($('#next').text() === "金額計算・見積・注文へ" || v === 'step3') {
            if ($('input[name=part]').length && $('input[name=part]:checked').val() == undefined) {
                $('#error_part').text('【必須】アタッチメントを選択してください。');
                return false;
            }

            if ($('input[name=part]').length) {
                $('#error_part').text('');
            }
        }

        let max_leng = 1000;
        if (vNumberOfOder.val() != '') 
        {

            if (vNumberOfOder.val() > max_leng) {
                mess += "<font color='red'>本数は"+max_leng+"本以下で入力して下さい。</font>";
                err_number.innerHTML = mess;
                return false;
            }


            if (vNumberOfOder.val() < 50) {
                mess += "<font color='red'>本数は50本以上で入力して下さい。</font>";
                err_number.innerHTML = mess;
                return false;
            }

            if (vNumberOfOder.val() > 1000) {
                mess += "<font color='red'>本数は1000本以下で入力して下さい。</font>";
                err_number.innerHTML = mess;
                return false;
            }
        }
        else 
        {
            mess += "<font color='red'>本数は50本以上で入力して下さい。</font>";
            err_number.innerHTML = mess;
            return false;
        }

        // $('#err_numberOf_mess').hide();
    }

    // if (ItemType == "印刷ラバーコースター") {
    //     if (vNumberOfOder.val() == '' || vNumberOfOder.val() > 1000) {
    //         mess += "<font color='red'>本数は1000本以下で入力して下さい。</font>";
    //         err_number.innerHTML = mess;
    //         return false;
    //     }
    // }

    if (v == 'next') {

        err_number.innerHTML = ''
        setToInput();
        return true;

    } else {
        return true;
    }
}

var price_bracket = 0;
var packing_price = 0;
var proto_shipping_charge = 0;
var order_pcs = 0;
var unit_price = 0;
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
var hatome_fee = 0;

function setToInput() {
    clearValue();

    var ItemType = $('input[name=ItemType]').val();

    // Quality
    if ($('#pcs1').length) {
        var vpcs1 = document.getElementById('pcs1');
    }
    if ($('#pcs2').length) {
        var vpcs2 = document.getElementById('pcs2');
    }
    // ----------->
    var vno_of_order = document.getElementById('no_of_order');

    var ItemCat = $('input[name=ItemCat]:checked').val();
    var Hatome = $('input[name=ItemMaterial]:checked').val();

    // Get part price
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
            partPrice = Math.floor(parts_obj['part_price'] * (1 + vat / 100));
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

    // Get paper data
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
                if (paper_color == "paper-patternA-1") {
                    var tmp_pp = paperPrice_obj['1side'];
                } else if (paper_color == "paper-patternA-2") {
                    var tmp_pp = paperPrice_obj['2side'];
                } else {
                    var tmp_pp = paperPrice_obj['tmp'];
                }
                for (var i = 0, iMax = tmp_pp.length; i < iMax; i++) {
                    if (parseInt(vno_of_order.value) >= parseInt(tmp_pp[i].num)) {
                        paperPrice = Math.floor(tmp_pp[i].price * (1 + vat / 100));
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

    if (vno_of_order.value != "") {

        // Printed rubber coaster
        if (ItemType == "PVCクリアマルチケース") 
        {

            if (ItemCat == "クリアタイプ" || ItemCat == "ラメタイプ" || ItemCat == "半透明タイプ")
            {
                if (vno_of_order.value >= 1000) order_pcs = price_pvc_clear[4];
                else if (vno_of_order.value >= 500) order_pcs = price_pvc_clear[3];
                else if (vno_of_order.value >= 300) order_pcs = price_pvc_clear[2];
                else if (vno_of_order.value >= 100) order_pcs = price_pvc_clear[1];
                else if (vno_of_order.value >= 50) order_pcs = price_pvc_clear[0];
            }
            else if (ItemCat == "オーロラタイプ")
            {
                if (vno_of_order.value >= 1000) order_pcs = price_pvc_aurora[4];
                else if (vno_of_order.value >= 500) order_pcs = price_pvc_aurora[3];
                else if (vno_of_order.value >= 300) order_pcs = price_pvc_aurora[2];
                else if (vno_of_order.value >= 100) order_pcs = price_pvc_aurora[1];
                else if (vno_of_order.value >= 50) order_pcs = price_pvc_aurora[0];
            }

            if (Hatome == "金属製スナップボタン") { 
                hatome_fee = Math.floor(22 * vno_of_order.value);
            }

            if ($('#sample-prd-shape').length) {
                if ($('input[name=ItemShape]').length && $('input[name=ItemShape]:checked').val() != undefined) {
                    $('#sample-prd-shape').text($('input[name=ItemShape]:checked').val());
                    $('#prd_ItemShape').text($('input[name=ItemShape]:checked').val());
                }
            }
            if ($('#sample-prd-print').length) {
                if ($('input[name=ItemPrint]').length && $('input[name=ItemPrint]:checked').val() != undefined) {
                    $('#sample-prd-print').text($('input[name=ItemPrint]:checked').val());
                    $('#prd_ItemPrint').text($('input[name=ItemPrint]:checked').val());
                }
            }
            if ($('#sample-prd-color').length) {
                if ($('input[name=ItemColor]').length && $('input[name=ItemColor]:checked').val() != undefined) {
                    $('#sample-prd-color').text($('input[name=ItemColor]:checked').val());
                    $('#prd_ItemColor').text($('input[name=ItemColor]:checked').val());
                }
            }
        }

        $('#sample-prd-size').text('60x110mm');
        $('#prd_ItemSize').text('60x110mm');

        if ($('input[name=ItemCat]').length && $('input[name=ItemCat]:checked').val() != undefined) {
            $('#sample-prd-type').text($('input[name=ItemCat]:checked').val());
            $('#prd_ItemCat').text($('input[name=ItemCat]:checked').val());
        }

        if ($('input[name=ItemMaterial]').length && $('input[name=ItemMaterial]:checked').val() != undefined) {
            $('#sample-prd-hatome').text($('input[name=ItemMaterial]:checked').val());
            $('#prd_ItemMat').text($('input[name=ItemMaterial]:checked').val());
        }


        // if ($('input[name=shape_processing]').length && $('input[name=shape_processing]:checked').val() != undefined) {
        //     $('#prd_shape_border').text($('input[name=shape_processing]:checked').val());
        // }

        if ($("input[name=packing]").length) {
            if ($("input[name=packing]:checked").val() != undefined && $("input[name=packing]:checked").val() != "") {
                $('#part-error').text('');
                $('#next').attr('disabled', false);
                $('#back').attr('disabled', false);

                $('#sample-part-pic').show();
                if ($("input[name=packing]:checked").val() == "白色無地") {
                    $('#sample-part-pic').attr("src", "/products/images/frame-packing1.jpg");
                    packing_price = Math.floor(30 * (1 + vat / 100));
                } else {
                    $('#sample-part-pic').attr("src", "/products/images/frame-packing2.jpg?v=1.01");
                    packing_price = 0;
                }
                $('#sample-part-name').text($("input[name=packing]:checked").val());
            } else {
                $('#part-error').text('梱包形態をご選択ください');
                $('#next').attr('disabled', true);
                $('#back').attr('disabled', true);
            }
        }

        $('#sample-prd-qty').text(vno_of_order.value);

        if ($('#ariprint').length) {
            this.print_umu = document.getElementById('ariprint');
        }

        if ($('#fcprint').length) {
            this.print_fc = document.getElementById('fcprint');
        }

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

        if ($('input[name=SendPrototype]:checked').val() != undefined) {
            proto_charge = Math.floor(0);
        }
        if ($('input[name=DeFormat]:checked').val() != undefined) {
            trace_charge = Math.floor(2200);
        }
        partPrice = 0;


        if ($('#prd_ItemPCS').length) {
            $('#prd_ItemPCS').text($('input[name=ItemPCS]:checked').val());
        }

        $('#prd_qty').text(vno_of_order.value);
        if ($('#prd_part').length) {
            $('#prd_part').text(part);
        }

        // Assign Value
        if ($('input[name=ItemType]').val() == "印刷ラバーストラップ・ラバーキーホルダー" || $('input[name=ItemType]').val() == "印刷ラバーコースター") {
            TextField7Value = Math.round(order_pcs * (1 + vat / 100)) * vno_of_order.value;
        } else {
            TextField7Value = Math.floor(order_pcs * (1 + vat / 100)) * vno_of_order.value;
        }
        // Amount Before Tax
        TextField9Value = parseInt(TextField7Value) + proto_charge + trace_charge +
            print_charge + coating_charge * vno_of_order.value + (partPrice * vno_of_order.value) +
            (paperPrice * vno_of_order.value) + MaterialCharge * vno_of_order.value + DesignsCharge + packing_price * vno_of_order.value + special_shape_fee + hatome_fee;

        // discount setup by timer
        let timer = new Date().toISOString();

        let startDate = new Date("2024-01-24T00:00:00");
        let endDate = new Date("2024-02-16T23:59:00");

        if (timer > startDate.toISOString() && timer < endDate.toISOString()) {
            DisPrice = Math.floor(parseInt(TextField9Value * 0.05));
        }

        tax = Math.floor(Math.floor(TextField7Value * vat / (100 + vat)) +
            Math.floor(proto_charge) +
            Math.floor(trace_charge) +
            Math.floor(hatome_fee)+
            Math.floor(packing_price * vno_of_order.value * vat / (100 + vat)) +
            Math.floor((partPrice * vno_of_order.value) * vat / (100 + vat)) +
            Math.floor((MaterialCharge * vno_of_order.value) * vat / (100 + vat)) +
            Math.floor((DesignsCharge) * vat / (100 + vat)) +
            Math.floor((paperPrice * vno_of_order.value) * vat / (100 + vat))) -
            Math.floor(DisPrice * vat / (100 + vat));
        // tax = tax - Math.floor(tax*vat/100);
        total = (parseInt(TextField9Value) - parseInt(DisPrice));

        // document.getElementById('textfield1').value = formatMoney(basic_charge);
        // document.getElementById('textfield2').value = formatMoney(mold_charge);
        if ($('#textfield2').length) {
            document.getElementById('textfield2').value = formatMoney(special_shape_fee);
        }

        console.log('Hatome: '+ hatome_fee);

        document.getElementById('textfield7').value = formatMoney(TextField7Value);
        document.getElementById('textfield12').value = formatMoney(hatome_fee);

        document.getElementById('textfield7_1').value = formatMoney(partPrice * vno_of_order.value);
        // document.getElementById('textfield7_2').value = formatMoney(paperPrice * vno_of_order.value);

        document.getElementById('textfield3').value = formatMoney(proto_charge);
        document.getElementById('textfield4').value = formatMoney(trace_charge);
        document.getElementById('textfield_dis').value = formatMoney(DisPrice);
        // document.getElementById('textfield13').value = formatMoney(print_charge);

        if ($('#textfield13_2').length) {
            document.getElementById('textfield13_2').value = formatMoney(coating_charge * vno_of_order.value);
        }

        if ($('#textfield13_3').length) {
            document.getElementById('textfield13_3').value = formatMoney(packing_price * vno_of_order.value);
        }

        if ($('#DesignsCharge').length) {
            document.getElementById('DesignsCharge').value = formatMoney(DesignsCharge);
        }
        if ($('#MaterialCharge').length) {
            document.getElementById('MaterialCharge').value = formatMoney(MaterialCharge * vno_of_order.value);
        }

        // document.getElementById('textfield8').value = formatMoney(shipping_charge);
        document.getElementById('textfield9').value = formatMoney(parseInt(TextField9Value));
        // document.getElementById('textfield10').value = formatMoney(tax);
        document.getElementById('textfield11').value = formatMoney(total);
        $('.prd_total').text(formatMoney(total));
        // document.getElementById('textfield12').value = formatMoney(printumu);
    }
}

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

    document.getElementById('textfield7').value = "";

    document.getElementById('textfield7_1').value = "";
    // document.getElementById('textfield7_2').value = "";

    document.getElementById('textfield3').value = "";
    document.getElementById('textfield4').value = "";
    // document.getElementById('textfield13').value = "";

    if ($('#textfield13_2').length) {
        document.getElementById('textfield13_2').value = "";
    }

    if ($('#DesignsCharge').length) {
        document.getElementById('DesignsCharge').value = "";
    }
    if ($('#MaterialCharge').length) {
        document.getElementById('MaterialCharge').value = "";
    }

    // document.getElementById('textfield9').value = "";
    // document.getElementById('textfield10').value = "";
    document.getElementById('textfield11').value = "";


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

//clear 0 first char
function format_number(number) {
    if (number != "") {
        number = parseInt(number) + 0;
    }
    return number;
}


this.typeOrder = document.getElementsByName('ItemType');

// standard
function click_typeorder_enabled() {
    $('.part_price_std').show();
    $('.part_price_prm').hide();
    //type_special_disabled('f1');
}

// premium
function click_typeorder_disabled() {
    $('.part_price_std').hide();
    $('.part_price_prm').show();
    //type_special_disabled('f1');
}

function type_special_disabled(c) {
    if (c == 't1') {
        var amount;
        // Get order amount in database 
        $.get("/count_order.php", function (data) {
            amount = $.parseJSON(data);
        }).done(function () {
            // Show status
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
            // Set disable
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

function getPartData(v) {
    $.get("part.php", { c: "passed" }, function (data) {
        var duce = $.parseJSON(data);
        for (var i = 0; i < duce.length; i++) {
            if (duce[i]['part_name'] == v) {
                parts_obj = duce[i];
            }
        }
    }).done(function () {
        setToInput();

        //check case click back
        let prd_strap = $('#strap').val();
        // if (tmp != "" && tmp == "MODE_MOD" && (prd_strap != "ラバーコースター" && prd_strap != "ラバースマートフォンスタンド" && prd_strap != "ラバータグ" && prd_strap != "ペットボトルホルダー")) {
        //     let items = setToInputManual();
        //     if (Object.keys(items).length !== 0) {
        //         $.ajax({
        //             type: "POST",
        //             url: "/products/save_calc_data.php",
        //             data: items,
        //             success: function (response) {
        //                 if (response.status == 200 && response.calculation_token) {
        //                     $('#calculation_token').remove();
        //                     $('<input>').attr({
        //                         type: 'hidden',
        //                         id: 'calculation_token',
        //                         name: 'calculation_token',
        //                         value: response.calculation_token
        //                     }).appendTo('form#form');
        //                 }
        //             }, error: function (xhr, status, error) {
        //                 console.log(error);
        //             }
        //         });
        //     }
        // }

    })
}






