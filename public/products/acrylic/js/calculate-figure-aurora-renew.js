/**
 * calculate-figure-aurora-renew.js
 * Aurora Acrylic Stand (オーロラアクリルスタンド) — DB-based price calculator.
 * Replaces hardcoded price arrays with AJAX calls to ajax_calculate_price_figure_aurora.php.
 * Includes hardcoded fallback prices from the original calculate-figure-aurora-ver2.js.
 *
 * Key differences from calculate-figure-aurora-ver2.js:
 * - cal_c() uses AJAX first, falls back to cal_c_local()
 * - writePriceTable() uses AJAX first, falls back to writePriceTable_local()
 * - VAT 10% displayed separately (subtotal pre-tax + tax row + total)
 * - cal_c() called on step1→step2 transition for immediate price display
 */

console.log('[AURORA-RENEW-JS] calculate-figure-aurora-renew.js LOADED (DB-based version)');

var isSafari = navigator.vendor && navigator.vendor.indexOf('Apple') > -1 &&
    navigator.userAgent &&
    navigator.userAgent.indexOf('CriOS') == -1 &&
    navigator.userAgent.indexOf('FxiOS') == -1;

// === Paper prices (same as original) ===
var paperPrice_obj = {
    "1side": [
        {"num":1,"price":1030},{"num":2,"price":530},{"num":3,"price":363},
        {"num":4,"price":280},{"num":5,"price":230},{"num":6,"price":197},
        {"num":7,"price":173},{"num":8,"price":155},{"num":9,"price":141},
        {"num":10,"price":130},{"num":20,"price":80},{"num":30,"price":63},
        {"num":40,"price":55},{"num":50,"price":50},{"num":60,"price":47},
        {"num":70,"price":44},{"num":80,"price":43},{"num":90,"price":41},
        {"num":100,"price":40},{"num":200,"price":26},{"num":300,"price":21},
        {"num":400,"price":18},{"num":500,"price":15},{"num":600,"price":15},
        {"num":700,"price":13},{"num":800,"price":13},{"num":900,"price":12},
        {"num":1000,"price":12}
    ],
    "2side": [
        {"num":1,"price":1230},{"num":2,"price":630},{"num":3,"price":430},
        {"num":4,"price":330},{"num":5,"price":270},{"num":6,"price":230},
        {"num":7,"price":201},{"num":8,"price":180},{"num":9,"price":163},
        {"num":10,"price":150},{"num":20,"price":90},{"num":30,"price":70},
        {"num":40,"price":60},{"num":50,"price":54},{"num":60,"price":50},
        {"num":70,"price":47},{"num":80,"price":45},{"num":90,"price":43},
        {"num":100,"price":42},{"num":200,"price":27},{"num":300,"price":22},
        {"num":400,"price":19},{"num":500,"price":16},{"num":600,"price":16},
        {"num":700,"price":14},{"num":800,"price":14},{"num":900,"price":13},
        {"num":1000,"price":13}
    ],
    "tmp": [
        {"num":1,"price":830},{"num":2,"price":430},{"num":3,"price":297},
        {"num":4,"price":230},{"num":5,"price":190},{"num":6,"price":163},
        {"num":7,"price":144},{"num":8,"price":130},{"num":9,"price":119},
        {"num":10,"price":110},{"num":20,"price":70},{"num":30,"price":57},
        {"num":40,"price":50},{"num":50,"price":46},{"num":60,"price":43},
        {"num":70,"price":41},{"num":80,"price":40},{"num":90,"price":39},
        {"num":100,"price":38},{"num":200,"price":25},{"num":300,"price":21},
        {"num":400,"price":18},{"num":500,"price":14},{"num":600,"price":14},
        {"num":700,"price":12},{"num":800,"price":12},{"num":900,"price":11},
        {"num":1000,"price":11}
    ]
};

// === Hardcoded product prices (fallback from original aurora JS) ===

// 10 days - 1 side
var prd_10d_1side = {
    "size50":[
    {"num":1,"price":1337},{"num":2,"price":942},{"num":3,"price":858},{"num":4,"price":788},
    {"num":5,"price":756},{"num":6,"price":729},{"num":7,"price":702},{"num":8,"price":677},{"num":9,"price":654},
    {"num":10,"price":635},{"num":20,"price":596},{"num":30,"price":577},{"num":40,"price":562},
    {"num":50,"price":550},{"num":100,"price":480},{"num":200,"price":409},{"num":300,"price":392},
    {"num":400,"price":381},{"num":500,"price":351},{"num":1000,"price":330}],
    "size75":[
    {"num":1,"price":1599},{"num":2,"price":1373},{"num":3,"price":1170},{"num":4,"price":1135},
    {"num":5,"price":1104},{"num":6,"price":1071},{"num":7,"price":1043},{"num":8,"price":1017},{"num":9,"price":992},
    {"num":10,"price":970},{"num":20,"price":946},{"num":30,"price":925},{"num":40,"price":883},
    {"num":50,"price":845},{"num":100,"price":779},{"num":200,"price":589},{"num":300,"price":494},
    {"num":400,"price":479},{"num":500,"price":436},{"num":1000,"price":405}],
    "size100":[
    {"num":1,"price":2106},{"num":2,"price":1835},{"num":3,"price":1626},{"num":4,"price":1512},
    {"num":5,"price":1492},{"num":6,"price":1461},{"num":7,"price":1433},{"num":8,"price":1413},{"num":9,"price":1370},
    {"num":10,"price":1327},{"num":20,"price":1288},{"num":30,"price":1251},{"num":40,"price":1217},
    {"num":50,"price":1123},{"num":100,"price":1019},{"num":200,"price":847},{"num":300,"price":693},
    {"num":400,"price":665},{"num":500,"price":581},{"num":1000,"price":532}]
};

// 10 days - 2 side
var prd_10d_2side = {
    "size50":[
    {"num":1,"price":1392},{"num":2,"price":1010},{"num":3,"price":830},{"num":4,"price":762},
    {"num":5,"price":732},{"num":6,"price":704},{"num":7,"price":679},{"num":8,"price":656},{"num":9,"price":634},
    {"num":10,"price":613},{"num":20,"price":576},{"num":30,"price":559},{"num":40,"price":544},
    {"num":50,"price":532},{"num":100,"price":465},{"num":200,"price":454},{"num":300,"price":433},
    {"num":400,"price":416},{"num":500,"price":381},{"num":1000,"price":362}],
    "size75":[
    {"num":1,"price":1543},{"num":2,"price":1325},{"num":3,"price":1128},{"num":4,"price":1096},
    {"num":5,"price":1065},{"num":6,"price":1033},{"num":7,"price":1006},{"num":8,"price":981},{"num":9,"price":956},
    {"num":10,"price":934},{"num":20,"price":912},{"num":30,"price":891},{"num":40,"price":852},
    {"num":50,"price":816},{"num":100,"price":753},{"num":200,"price":652},{"num":300,"price":557},
    {"num":400,"price":539},{"num":500,"price":497},{"num":1000,"price":464}],
    "size100":[
    {"num":1,"price":2013},{"num":2,"price":1754},{"num":3,"price":1555},{"num":4,"price":1446},
    {"num":5,"price":1422},{"num":6,"price":1397},{"num":7,"price":1370},{"num":8,"price":1351},{"num":9,"price":1309},
    {"num":10,"price":1269},{"num":20,"price":1231},{"num":30,"price":1196},{"num":40,"price":1163},
    {"num":50,"price":1073},{"num":100,"price":974},{"num":200,"price":931},{"num":300,"price":773},
    {"num":400,"price":742},{"num":500,"price":655},{"num":1000,"price":602}]
};

// 6 days - 1 side
var prd_6d_1side = {
    "size50":[
    {"num":1,"price":1536},{"num":2,"price":1091},{"num":3,"price":995},{"num":4,"price":914},
    {"num":5,"price":877},{"num":6,"price":847},{"num":7,"price":815},{"num":8,"price":785},{"num":9,"price":759},
    {"num":10,"price":735},{"num":20,"price":690},{"num":30,"price":669},{"num":40,"price":651},
    {"num":50,"price":638},{"num":100,"price":557},{"num":200,"price":454},{"num":300,"price":436}],
    "size75":[
    {"num":1,"price":1853},{"num":2,"price":1591},{"num":3,"price":1355},{"num":4,"price":1315},
    {"num":5,"price":1280},{"num":6,"price":1243},{"num":7,"price":1208},{"num":8,"price":1179},{"num":9,"price":1150},
    {"num":10,"price":1125},{"num":20,"price":1097},{"num":30,"price":1072},{"num":40,"price":1024},
    {"num":50,"price":981},{"num":100,"price":904},{"num":200,"price":654},{"num":300,"price":549}],
    "size100":[
    {"num":1,"price":2439},{"num":2,"price":2127},{"num":3,"price":1884},{"num":4,"price":1752},
    {"num":5,"price":1720},{"num":6,"price":1695},{"num":7,"price":1659},{"num":8,"price":1639},{"num":9,"price":1588},
    {"num":10,"price":1538},{"num":20,"price":1494},{"num":30,"price":1449},{"num":40,"price":1409},
    {"num":50,"price":1301},{"num":100,"price":1181},{"num":200,"price":941},{"num":300,"price":770}]
};

// 6 days - 2 side
var prd_6d_2side = {
    "size50":[
    {"num":1,"price":1532},{"num":2,"price":1121},{"num":3,"price":921},{"num":4,"price":846},
    {"num":5,"price":813},{"num":6,"price":783},{"num":7,"price":754},{"num":8,"price":729},{"num":9,"price":704},
    {"num":10,"price":681},{"num":20,"price":640},{"num":30,"price":621},{"num":40,"price":604},
    {"num":50,"price":591},{"num":100,"price":516},{"num":200,"price":504},{"num":300,"price":481}],
    "size75":[
    {"num":1,"price":1713},{"num":2,"price":1471},{"num":3,"price":1252},{"num":4,"price":1217},
    {"num":5,"price":1183},{"num":6,"price":1148},{"num":7,"price":1117},{"num":8,"price":1089},{"num":9,"price":1062},
    {"num":10,"price":1038},{"num":20,"price":1014},{"num":30,"price":990},{"num":40,"price":946},
    {"num":50,"price":906},{"num":100,"price":836},{"num":200,"price":724},{"num":300,"price":619}],
    "size100":[
    {"num":1,"price":2236},{"num":2,"price":1947},{"num":3,"price":1726},{"num":4,"price":1605},
    {"num":5,"price":1578},{"num":6,"price":1551},{"num":7,"price":1521},{"num":8,"price":1501},{"num":9,"price":1454},
    {"num":10,"price":1408},{"num":20,"price":1368},{"num":30,"price":1328},{"num":40,"price":1292},
    {"num":50,"price":1192},{"num":100,"price":1082},{"num":200,"price":1034},{"num":300,"price":858}]
};

// === Object.size helper ===
Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

// === Global variables ===
var parts_obj;
var paperPrice = 0;
var unit_price = 0;
var vat = 10;
var partPrice = 0;
var sub_total = 0;
var disPrice = 0;
var vat_price = 0;
var total = 0;

// === Validation & step transition ===

function validation(c) {
    console.log('[AURORA-RENEW-JS] validation() called with:', c, '| #next text:', $('#next').text());
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
            case "台座・オプション入力へ":
                if (c == 'next' || c == 'step2') {
                    $('#back').fadeIn('slow');
                    $('#next').text('金額計算・見積・注文へ');
                    $('#step2').fadeIn('slow');
                    $('#dot-step1').addClass('active');
                    $('#dot-step2').addClass('active');
                    chk_part();

                    // New condition display part depend on size
                    if ($('input[name="acy_size"]:checked').val() != "" && $('input[name="acy_size"]:checked').val() !== undefined) {
                        if ($('input[name="acy_size"]:checked').val() == "50") {
                            $('#_base-cust').empty().text('20');
                            $('#p_base-ellp').empty().text('【定型】楕円 40x20mm 印刷なし');
                            $('#p_base-cir').empty().text('【定型】円 40x40mm 印刷なし');
                            $('#p_base-prereg').empty().text('【定型】長方形 40x20mm 印刷なし');
                            $('#p_base-reg').empty().text('【定型】正方形 40x40mm 印刷なし');

                            $('.vv_base-ellp').empty().val('【定型】楕円 40x20mm 印刷なし');
                            $('.vv_base-cir').empty().val('【定型】円 40x40mm 印刷なし');
                            $('.vv_base-prereg').empty().val('【定型】長方形 40x20mm 印刷なし');
                            $('.vv_base-reg').empty().val('【定型】正方形 40x40mm 印刷なし');
                        }

                        if ($('input[name="acy_size"]:checked').val() == "75") {
                            $('#_base-cust').empty().text('40');
                            $('#p_base-ellp').empty().text('【定型】楕円 60x30mm 印刷なし');
                            $('#p_base-cir').empty().text('【定型】円 60x60mm 印刷なし');
                            $('#p_base-prereg').empty().text('【定型】長方形 60x30mm 印刷なし');
                            $('#p_base-reg').empty().text('【定型】正方形 60x60mm 印刷なし');

                            $('.vv_base-ellp').empty().val('【定型】楕円 60x30mm 印刷なし');
                            $('.vv_base-cir').empty().val('【定型】円 60x60mm 印刷なし');
                            $('.vv_base-prereg').empty().val('【定型】長方形 60x30mm 印刷なし');
                            $('.vv_base-reg').empty().val('【定型】正方形 60x60mm 印刷なし');
                        }

                        if ($('input[name="acy_size"]:checked').val() == "100") {
                            $('#_base-cust').empty().text('80');
                            $('#p_base-ellp').empty().text('【定型】楕円 75x40mm 印刷なし');
                            $('#p_base-cir').empty().text('【定型】円 75x75mm 印刷なし');
                            $('#p_base-prereg').empty().text('【定型】長方形 75x40mm 印刷なし');
                            $('#p_base-reg').empty().text('【定型】正方形 75x75mm 印刷なし');

                            $('.vv_base-ellp').empty().val('【定型】楕円 75x40mm 印刷なし');
                            $('.vv_base-cir').empty().val('【定型】円 75x75mm 印刷なし');
                            $('.vv_base-prereg').empty().val('【定型】長方形 75x40mm 印刷なし');
                            $('.vv_base-reg').empty().val('【定型】正方形 75x75mm 印刷なし');
                        }
                    }

                    // Calculate price immediately on step1→step2 transition
                    cal_c();

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
                    $('#next').text('台座・オプション入力へ');
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

        // New condition check price adapt (save_calc_data)
        if ((currentClick != "" && currentClick !== undefined) && (currentClick === "金額計算・見積・注文へ") && ($('#next').text() == "金額計算・見積・注文へ" && (c == "next"))) {
            let price_value = calculate_price_manual();
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
                    }, error: function (xhr, status, error) {}
                });
            }
        } else {
            if ((currentClick != "" && currentClick !== undefined) && (currentClick === "redirect")) {
                let price_items = calculate_price_manual();
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
                        }, error: function (xhr, status, error) {}
                    });
                }
            }
        }
    }
}

function check_val(v) {
    console.log('[AURORA-RENEW-JS] check_val() called with:', v, '| qty:', $('input[name=qty]').val());
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
        $('#part-error').text('台座を選択してください');
        validation('step2');
        return false;
    } else {
        $('#part-error').text('');
        return true;
    }
}

// === Price calculation (AJAX + local fallback) ===

function cal_c(v) {
    var qty = $('input[name="qty"]').val();

    var prodc_day = $('input[name="acy_delivery"]:checked').val();
    var ItemSize = $('input[name="acy_size"]:checked').val();
    var screen = $('input[name="acy_screen"]:checked').val();
    var part = $('input[name="acy_part"]:checked').val();
    var paper = $('input[name="acy_paper_select"]:checked').val();
    var paper_color = $('input[name="acy_paper"]:checked').val();
    var sample = $('input[name="acy_sample"]:checked').val();
    var trace = $('input[name="acy_trace"]:checked').val();
    var type = $('input[name="acy_cat"]:checked').val();
    var trace_price = 0;

    // Get part price
    if (part != undefined && parts_obj) {
        $('#part-error').text('');
        $('#sample-part-pic').show();
        partPrice = Math.floor(parts_obj["part_price"]);
        $('#sample-part-pic').attr('src', parts_obj["part_pic"]);
        $('#sample-part-name').text(parts_obj["part_name"]);
        $('#prd_part').text(parts_obj["part_name"]);
    } else {
        partPrice = 0;
        $('#sample-part-pic').hide();
        $('#sample-part-name').text('台座:なし');
    }

    // Get paper data
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

    // Update spec display
    $('#sample-prd-prdt').text(prodc_day);
    $('#sample-prd-size').text(ItemSize + "x" + ItemSize + "mm.");
    $('#sample-prd-type').text(type);
    $('#prd_type').text(type);
    $('#sample-prd-screen').text(screen);
    $('#sample-prd-qty').text(qty);
    $('#prd_production').text(prodc_day);
    $('#prd_size').text(ItemSize + "mm" + "X" + ItemSize + "mm");
    $('#prd_print').text(screen);
    $('#prd_amount').text(qty);
    if (sample != undefined) { $('#prd_sample').text(sample); $('#sample-prd-samp').text(sample); } else { $('#prd_sample').text('なし'); $('#sample-prd-samp').text('なし'); }
    if (trace != undefined) { $('#prd_trace').text(trace); trace_price = 0; $('#sample-prd-trace').text(trace); } else { $('#prd_trace').text('なし'); $('#sample-prd-trace').text('なし'); }

    // Don't calculate if qty is empty or 0
    if (!qty || parseInt(qty) <= 0) {
        updatePriceDisplay(0, 0, 0, 0, 0, 0, 0, 0, 0);
        $('.prd_total').text('0');
        return;
    }

    // === AJAX call to get DB price ===
    console.log('cal_c: sending AJAX with qty=' + qty + ', delivery=' + prodc_day + ', size=' + ItemSize + ', screen=' + screen);
    $.ajax({
        type: "POST",
        url: "/products/acrylic/ajax_calculate_price_figure_aurora.php",
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
            if (response.status == 200 && response.unit_price > 0) {
                unit_price = response.unit_price;
                var dbPrdPrice = response.prd_price;
                var dbPartPrice = response.prd_part_price;
                var dbPaperPrice = response.prd_paper_price;
                var dbSamplePrice = response.prd_sample_price;
                var dbTracePrice = response.prd_trace_price;
                var localOverride = false;

                // Fallback: if DB part price is 0 but local part calculation has a value, use local
                if (dbPartPrice <= 0 && partPrice > 0) {
                    dbPartPrice = partPrice * parseInt(qty);
                    localOverride = true;
                }

                // Fallback: if DB paper price is 0 but local paper calculation has a value, use local
                if (dbPaperPrice <= 0 && paperPrice > 0) {
                    dbPaperPrice = paperPrice * parseInt(qty);
                    localOverride = true;
                }

                // Recalculate totals if local overrides were applied
                if (localOverride) {
                    sub_total = dbPrdPrice + dbPartPrice + dbPaperPrice + dbSamplePrice + dbTracePrice;
                    disPrice = response.discount;
                    sub_total = Math.max(0, sub_total - disPrice);
                    vat_price = Math.floor(sub_total * vat / 100);
                    total = sub_total + vat_price;
                } else {
                    sub_total = response.prd_sub_total;
                    vat_price = response.Tax;
                    disPrice = response.discount;
                    total = response.prd_total;
                }

                updatePriceDisplay(dbPrdPrice, dbPartPrice, dbPaperPrice, dbSamplePrice, dbTracePrice, sub_total, vat_price, disPrice, total);
            } else {
                console.warn('cal_c: DB returned no price data (product not in DB yet), using local fallback');
                cal_c_local();
            }
        },
        error: function (xhr, status, error) {
            console.warn('cal_c: AJAX failed (' + error + '), using local fallback');
            cal_c_local();
        }
    });
}

/**
 * Local fallback price calculation using hardcoded price tables.
 */
function cal_c_local() {
    var qty = parseInt($('input[name="qty"]').val()) || 1;
    var trace = $('input[name="acy_trace"]:checked').val();
    var trace_price = 0;

    // Get unit price from hardcoded tables
    var priceArr = get_price();
    unit_price = 0;
    if (priceArr) {
        for (var i = 0, iMax = priceArr.length; i < iMax; i++) {
            if (parseInt(qty) >= parseInt(priceArr[i].num)) {
                unit_price = Math.floor(priceArr[i].price);
                continue;
            }
            break;
        }
    }

    // Calculate totals — subtotal is pre-tax, tax and total separate
    sub_total = Math.floor((unit_price * qty) + trace_price + (partPrice * qty) + (paperPrice * qty));
    disPrice = 0;
    vat_price = Math.floor(sub_total * vat / 100);
    total = Math.floor(sub_total + vat_price - disPrice);

    // Update display
    updatePriceDisplay(
        (unit_price * qty),
        (partPrice * qty),
        (paperPrice * qty),
        0,
        trace_price,
        sub_total,
        vat_price,
        disPrice,
        total
    );
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

// === Price reference table (DB-based with local fallback) ===

var amount = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100', '200', '300', '400', '500', '600', '700', '800', '900', '1000'];
var amount_add = [];

$(function () {
    writePriceTable();
    getPartData();
});

function writePriceTable(plus) {
    var days = $('input[name=prc_delivery]:checked').val();
    var screen = $('input[name=prc_screen]:checked').val();

    // Handle custom qty add/del
    if (plus == "add") {
        if ($.inArray($('input[name=new_qty]').val(), amount) >= 0) {
            $('.add-error').text('この数量の製作単価は既に表示されております');
        } else {
            if ($('input[name=new_qty]').val() <= 0 || $('input[name=new_qty]').val() > 1000) {
                $('.add-error').text('6-10営業日のご注文は1000個以下となります');
            } else {
                if (days == "6" && (screen == "1" || screen == "2") && $('input[name=new_qty]').val() > 300) {
                    $('.add-error').text('6営業日のご注文は300個以下となります');
                } else {
                    $('.add-error').text('');
                    amount.push($('input[name=new_qty]').val());
                    amount.sort(function (a, b) { return a - b; });
                    amount_add.push($('input[name=new_qty]').val());
                }
            }
        }
    } else {
        if (days == "6" && (screen == "1" || screen == "2") && plus == "del") {
            amount = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100', '200', '300'];
            amount_add = [];
        } else if (days == "10" && (screen == "1" || screen == "2") && plus == "del") {
            amount = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100', '200', '300', '400', '500', '600', '700', '800', '900', '1000'];
            amount_add = [];
        }
    }

    // Try AJAX first for price table
    $.ajax({
        type: "GET",
        url: "/products/acrylic/ajax_price_table_figure_aurora.php",
        dataType: "json",
        data: { delivery: days, screen: screen },
        success: function (response) {
            if (response.status == 200 && response.prices) {
                writePriceTable_db(response.prices, plus);
            } else {
                writePriceTable_local(plus);
            }
        },
        error: function () {
            writePriceTable_local(plus);
        }
    });
}

function writePriceTable_db(prices, plus) {
    var text = "";
    $('.price-row').remove();

    for (var i = 0; i < amount.length; i++) {
        if ($.inArray(amount[i], amount_add) >= 0) {
            text += '<tr class="price-row added"><td>' + amount[i] + '</td>';
        } else {
            text += '<tr class="price-row"><td>' + amount[i] + '</td>';
        }
        var sizes = ['size50', 'size75', 'size100'];
        for (var j = 0; j < sizes.length; j++) {
            var tiers = prices[sizes[j]] || [];
            var price1 = 0;
            for (var k = 0; k < tiers.length; k++) {
                if (parseInt(amount[i]) >= parseInt(tiers[k].num)) {
                    price1 = Math.floor(tiers[k].price);
                    continue;
                }
                break;
            }
            text += '<td>' + price1 + '</td>';
        }
        text += '</tr>';
    }
    $('.tbl-price tbody').append(text);
}

function writePriceTable_local(plus) {
    var days = $('input[name=prc_delivery]:checked').val();
    var screen = $('input[name=prc_screen]:checked').val();

    if (days == "10" && screen == "1") {
        var price = prd_10d_1side;
    } else if (days == "10" && screen == "2") {
        var price = prd_10d_2side;
    } else if (days == "6" && screen == "1") {
        var price = prd_6d_1side;
    } else if (days == "6" && screen == "2") {
        var price = prd_6d_2side;
    }

    var text = "";
    $('.price-row').remove();

    for (var i = 0; i < amount.length; i++) {
        if ($.inArray(amount[i], amount_add) >= 0) {
            text += '<tr class="price-row added"><td>' + amount[i] + '</td>';
        } else {
            text += '<tr class="price-row"><td>' + amount[i] + '</td>';
        }
        for (var j = 0; j < Object.size(price); j++) {
            var tmp = Object.keys(price);
            for (var k = 0, iMax = price[tmp[j]].length; k < iMax; k++) {
                if (parseInt(amount[i]) >= parseInt(price[tmp[j]][k].num)) {
                    var price1 = Math.floor(price[tmp[j]][k].price);
                    continue;
                }
                break;
            }
            text += '<td>' + price1 + '</td>';
        }
        text += '</tr>';
    }
    $('.tbl-price tbody').append(text);
}

// === Part data loading (uses part-base-aurora.php) ===

var part_name_global;
function getPartData() {
    $.get("part-base-aurora.php", { c: "passed", s: $('input[name="acy_size"]:checked').val() }, function (data) {
        var duce = $.parseJSON(data);
        for (var i = 0; i < duce.length; i++) {
            if (duce[i]['part_id'] == $('input[name="acy_part"]:checked').attr('id')) {
                parts_obj = duce[i];
                break;
            } else {
                parts_obj = duce[0];
            }
        }
        part_name_global = duce;
    }).done(function () {
        cal_c();

        // Create new token when page load (MODE_MOD)
        let prd_strap = $('#strap').val();
        if ($('#ms_mode').val() != "" && $('#ms_mode').val() == "MODE_MOD" && (prd_strap == "オーロラアクリルスタンド")) {
            let items = calculate_price_manual();
            if (Object.keys(items).length !== 0) {
                $.ajax({
                    type: "POST",
                    url: "/products/save_calc_data.php",
                    data: items,
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
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.warn('getPartData: AJAX to part-base-aurora.php failed (' + textStatus + '), calling cal_c() anyway');
        cal_c();
    });
}

// === calculate_price_manual for save_calc_data ===

function calculate_price_manual(v) {
    var prodc_day = $('input[name="acy_delivery"]:checked').val();
    var ItemSize = $('input[name="acy_size"]:checked').val();
    var screen = $('input[name="acy_screen"]:checked').val();
    var part = $('input[name="acy_part"]:checked').val();
    var paper = $('input[name="acy_paper_select"]:checked').val();
    var paper_color = $('input[name="acy_paper"]:checked').val();
    var sample = $('input[name="acy_sample"]:checked').val();
    var trace = $('input[name="acy_trace"]:checked').val();
    var qty = $('input[name="qty"]').val();
    var prd = $('#strap').val();
    var trace_price = 0;

    let proto_charge = 0;
    let ai_price = 0;

    let shipping_price = 880;
    if (sub_total > 11000) {
        shipping_price = 0;
    }

    return {
        sku: 'acrylic-figure-aurora',
        product: prd,
        qty: qty,
        product_price: Math.floor(unit_price * qty),
        part_price: (partPrice * qty),
        paper_price: (paperPrice * qty),
        prototype_price: proto_charge,
        ai_assistant_price: ai_price,
        trace_price: trace_price,
        discount: disPrice,
        shipping: shipping_price,
        vat: vat_price,
        subtotal: sub_total,
        total: total
    };
}

/**
 * Get the correct local price array based on delivery/screen/size radio buttons.
 */
function get_price() {
    switch ($('input[name="acy_delivery"]:checked').val()) {
        case "10営業日":
            switch ($('input[name="acy_screen"]:checked').val()) {
                case "片面印刷":
                    switch ($('input[name="acy_size"]:checked').val()) {
                        case '50': return prd_10d_1side['size50'];
                        case '75': return prd_10d_1side['size75'];
                        case '100': return prd_10d_1side['size100'];
                    }
                    break;
                case "両面印刷":
                    switch ($('input[name="acy_size"]:checked').val()) {
                        case '50': return prd_10d_2side['size50'];
                        case '75': return prd_10d_2side['size75'];
                        case '100': return prd_10d_2side['size100'];
                    }
                    break;
            }
            break;
        case "6営業日":
            switch ($('input[name="acy_screen"]:checked').val()) {
                case "片面印刷":
                    switch ($('input[name="acy_size"]:checked').val()) {
                        case '50': return prd_6d_1side['size50'];
                        case '75': return prd_6d_1side['size75'];
                        case '100': return prd_6d_1side['size100'];
                    }
                    break;
                case "両面印刷":
                    switch ($('input[name="acy_size"]:checked').val()) {
                        case '50': return prd_6d_2side['size50'];
                        case '75': return prd_6d_2side['size75'];
                        case '100': return prd_6d_2side['size100'];
                    }
                    break;
            }
            break;
    }
    return prd_10d_1side['size50']; // default fallback
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

    Item = "オーロラアクリルスタンド";
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

// === Utility functions ===

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
                console.log(data);
            }
        });
    }
}

function setzero() {
    validation('step1'); $('#cus_detail').hide();
    $("#form")[0].reset();
    getPartData();
    cal_c();
}

function chk_base() {
    var i = 0;
    $('.base_group.picpro').each(function () {
        $("span", this).text(part_name_global[i]["part_name"]);
        $(this).parent().find(".part_price").text(part_name_global[i]["part_price"] * 1.1);
        $(this).parent().find("input").val(part_name_global[i]["part_name"]);
        i++;
    });
}

function comSubmit(action, target, form) {
    document.form.action = action;
    document.form.target = target;
    document.form.submit();
}
