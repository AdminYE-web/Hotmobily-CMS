function get_add_price(code, current_qty) {
    if (window.numUnitAddPrice && window.numUnitAddPrice[code]) {
        var tiers = window.numUnitAddPrice[code];
        if (tiers.length > 0) {
            if (current_qty !== undefined && current_qty > 0) {
                var sorted = tiers.slice().sort(function (a, b) {
                    return parseInt(a.num, 10) - parseInt(b.num, 10);
                });
                var price = Math.floor(sorted[0].price);
                for (var i = 0; i < sorted.length; i++) {
                    if (current_qty >= parseInt(sorted[i].num, 10)) {
                        price = Math.floor(sorted[i].price);
                    } else {
                        break;
                    }
                }
                return price;
            }
            return Math.floor(tiers[0].price);
        }
    }
    return null;
}

function get_pack_price(nameOrCode) {
    if (window.packaging_fee && window.packaging_fee[nameOrCode]) {
        var tiers = window.packaging_fee[nameOrCode];
        if (tiers.length > 0) return Math.floor(tiers[0].price);
    }
    return null;
}

function get_price_admin() {
    var typeValue = $('input[name=ft_type]:checked').val();
    var dbKey = '';

    // Fallback logic in case DB lookup fails
    var fallback = [];
    if (typeValue === '刺繍') {
        dbKey = 'flighttag_embroidery';
        fallback = [
            { num: 50, price: 670 },
            { num: 100, price: 504 },
            { num: 300, price: 317 },
            { num: 500, price: 265 },
            { num: 1000, price: 213 },
            { num: 3000, price: 164 }
        ];
    } else if (typeValue === 'ジャガード織') {
        dbKey = 'flighttag_jacquard';
        fallback = [
            { num: 50, price: 642 },
            { num: 100, price: 481 },
            { num: 300, price: 282 },
            { num: 500, price: 225 },
            { num: 1000, price: 180 },
            { num: 3000, price: 132 }
        ];
    } else if (typeValue === '昇華転写') {
        dbKey = 'flighttag_sublimation';
        fallback = [
            { num: 50, price: 574 },
            { num: 100, price: 410 },
            { num: 300, price: 254 },
            { num: 500, price: 210 },
            { num: 1000, price: 168 },
            { num: 3000, price: 126 }
        ];
    }

    if (window.numUnitPrice) {
        // 1. Try exact match
        if (window.numUnitPrice[dbKey] && window.numUnitPrice[dbKey].length > 0) {
            return window.numUnitPrice[dbKey];
        }
        // 2. Try match by key prefix or product name
        var keys = Object.keys(window.numUnitPrice);
        for (var i = 0; i < keys.length; i++) {
            var k = keys[i];
            if (typeValue === '刺繍' && (k.indexOf('flighttag_embroidery') !== -1 || k.indexOf('flight_tag_embroidery') !== -1)) {
                if (window.numUnitPrice[k].length > 0) return window.numUnitPrice[k];
            }
            if (typeValue === 'ジャガード織' && (k.indexOf('flighttag_jacquard') !== -1 || k.indexOf('flight_tag_jacquard') !== -1)) {
                if (window.numUnitPrice[k].length > 0) return window.numUnitPrice[k];
            }
            if (typeValue === '昇華転写' && (k.indexOf('flighttag_sublimation') !== -1 || k.indexOf('flight_tag_sublimation') !== -1)) {
                if (window.numUnitPrice[k].length > 0) return window.numUnitPrice[k];
            }
        }
    }

    return fallback;
}

function calcFlightTag() {
    var typeValue = $('input[name=ft_type]:checked').val();

    var currentFabric = $("input[name='ft_option']:checked").val();
    var colorMap = [
        { twillPrefix: "108", feltPrefix: "T184" },
        { twillPrefix: "63", feltPrefix: "T223" },
        { twillPrefix: "83", feltPrefix: "T47" },
        { twillPrefix: "76", feltPrefix: "T244" },
        { twillPrefix: "30", feltPrefix: "T142" },
        { twillPrefix: "131", feltPrefix: "T95" },
        { twillPrefix: "78", feltPrefix: "T202" },
        { twillPrefix: "74", feltPrefix: "T258" },
        { twillPrefix: "135", feltPrefix: "T214" },
        { twillPrefix: "32", feltPrefix: "T54" },
        { twillPrefix: "9", feltPrefix: "T122" },
        { twillPrefix: "94", feltPrefix: "T219" },
        { twillPrefix: "35", feltPrefix: "T24" },
        { twillPrefix: "66", feltPrefix: "T218" },
        { twillPrefix: "46", feltPrefix: "T32" },
        { twillPrefix: "52", feltPrefix: "T37" },
        { twillPrefix: "12", feltPrefix: "T198" },
        { twillPrefix: "129", feltPrefix: "T256" },
        { twillPrefix: "123", feltPrefix: "1.2mmBLACA" },
        { twillPrefix: "1", feltPrefix: "T01B" },
        { twillPrefix: "88", feltPrefix: "T199" },
        { twillPrefix: "126", feltPrefix: "T108" }
    ];
    $("input[name='ft_fabric_color1']").each(function (idx) {
        if (idx < colorMap.length) {
            var currentVal = $(this).val();
            if (!currentVal) return;
            var isCurrentlyFelt = currentVal.indexOf(colorMap[idx].feltPrefix) === 0;
            var isCurrentlyTwill = currentVal.indexOf(colorMap[idx].twillPrefix) === 0;
            if (currentFabric === "フェルト生地" && isCurrentlyTwill) {
                $(this).val(currentVal.replace(colorMap[idx].twillPrefix, colorMap[idx].feltPrefix));
                var img = $(this).closest('td').find('img');
                if (img.length > 0) img.attr('src', '../../products/images/flight_tag/wappen-icon-' + (idx < 9 ? '0' + (idx + 1) : (idx + 1)) + '.webp');
            } else if (currentFabric !== "フェルト生地" && isCurrentlyFelt) {
                $(this).val(currentVal.replace(colorMap[idx].feltPrefix, colorMap[idx].twillPrefix));
                var img = $(this).closest('td').find('img');
                if (img.length > 0) img.attr('src', '../../products/images/flight_tag/icon-' + (idx < 9 ? '0' + (idx + 1) : (idx + 1)) + '.webp');
            }
        }
    });
    $("input[name='ft_fabric_color2']").each(function (idx) {
        if (idx < colorMap.length) {
            var currentVal = $(this).val();
            if (!currentVal) return;
            var isCurrentlyFelt = currentVal.indexOf(colorMap[idx].feltPrefix) === 0;
            var isCurrentlyTwill = currentVal.indexOf(colorMap[idx].twillPrefix) === 0;
            if (currentFabric === "フェルト生地" && isCurrentlyTwill) {
                $(this).val(currentVal.replace(colorMap[idx].twillPrefix, colorMap[idx].feltPrefix));
                var img = $(this).closest('td').find('img');
                if (img.length > 0) img.attr('src', '../../products/images/flight_tag/wappen-icon-' + (idx < 9 ? '0' + (idx + 1) : (idx + 1)) + '.webp');
            } else if (currentFabric !== "フェルト生地" && isCurrentlyFelt) {
                $(this).val(currentVal.replace(colorMap[idx].feltPrefix, colorMap[idx].twillPrefix));
                var img = $(this).closest('td').find('img');
                if (img.length > 0) img.attr('src', '../../products/images/flight_tag/icon-' + (idx < 9 ? '0' + (idx + 1) : (idx + 1)) + '.webp');
            }
        }
    });
    if ($("#txt-show-Insatsu1").length > 0) {
        var selectedColor = $("input[name='ft_fabric_color1']:checked").val();
        if (selectedColor) {
            $("#txt-show-Insatsu1").text(selectedColor);
            $("#txt-show-Insatsu1").removeClass("d-none");
        }
    }

    if (typeValue === "ジャガード織" || typeValue === "昇華転写") {
        $('.only_embro').hide();
    } else {
        $('.only_embro').show();
    }

    var vno_of_order = parseInt(document.getElementById('qty').value, 10) || 0;

    var order_pcs = 0;
    if (vno_of_order > 0) {
        var pArr = get_price_admin();
        if (pArr && pArr.length > 0) {
            var sortedPrices = pArr.slice().sort(function (a, b) {
                return parseInt(a.num, 10) - parseInt(b.num, 10);
            });
            order_pcs = Math.floor(sortedPrices[0].price);
            for (var i = 0; i < sortedPrices.length; i++) {
                if (vno_of_order >= parseInt(sortedPrices[i].num, 10)) {
                    order_pcs = Math.floor(sortedPrices[i].price);
                } else {
                    break;
                }
            }
        }
    }

    if (vno_of_order > 50000) {
        $('#err_numberOf_mess').html('<span style="color: red">本数は50000本以下で入力して下さい。50000以上のお客様は納期をメールにてお問い合わせ下さい。</span>');
        $('.ord-btn').prop('disabled', true);
    } else if (vno_of_order < 50 && vno_of_order > 0) {
        $('#err_numberOf_mess').html('<span style="color: red">本数は50本以上で入力して下さい。</span>');
        $('.ord-btn').prop('disabled', true);
    } else if (vno_of_order === 0) {
        $('#err_numberOf_mess').html('');
        $('.ord-btn').prop('disabled', true);
    } else {
        $('#err_numberOf_mess').html('');
        $('.ord-btn').prop('disabled', false);
    }

    var sample_val = $('input[name=ft_sample]:checked').val();
    var proto_charge = 0;
    if ((sample_val === 'あり' || sample_val === '1' || (sample_val !== undefined && sample_val !== 'なし' && sample_val !== '')) && vno_of_order < 300) {
        var db_proto = get_add_price('flighttag_prototype') || get_add_price('flight_tag_prototype');
        proto_charge = (db_proto !== null && db_proto !== undefined && db_proto > 0) ? db_proto : 5000;
    }

    var trace_val = $('input[name=ft_trace]:checked').val();
    var trace_charge = 0;
    if (trace_val === 'あり' || trace_val === '1' || (trace_val !== undefined && trace_val !== 'なし' && trace_val !== '')) {
        var db_trace = get_add_price('flighttag_datatrace') || get_add_price('flighttag_trace_fee');
        trace_charge = (db_trace !== null && db_trace !== undefined && db_trace > 0) ? db_trace : 2000;
    }

    var opp_val = $('input[name=ft_opp]:checked').val();
    var opp_price = 0;
    if (opp_val === 'あり' || opp_val === '1' || (opp_val !== undefined && opp_val !== 'なし' && opp_val !== '')) {
        var db_opp = get_pack_price('opp_individual_pack7') || get_add_price('flighttag_opp');
        var opp_unit = (db_opp !== null && db_opp !== undefined && db_opp > 0) ? db_opp : 7;
        opp_price = opp_unit * vno_of_order;
    }

    var partPriceTotal = 0;
    var part = $('input[name="part"]:checked').val();
    var partPriceUnit = 0;
    if (part != undefined && window.partUnitPrice) {
        if (window.partUnitPrice[part] !== undefined) {
            partPriceUnit = Math.floor(window.partUnitPrice[part].price);
        } else if (window.partUnitPrice['フライトタグ ' + part] !== undefined) {
            partPriceUnit = Math.floor(window.partUnitPrice['フライトタグ ' + part].price);
        } else {
            var pKeys = Object.keys(window.partUnitPrice);
            for (var pi = 0; pi < pKeys.length; pi++) {
                if (pKeys[pi].indexOf(part) !== -1) {
                    partPriceUnit = Math.floor(window.partUnitPrice[pKeys[pi]].price);
                    break;
                }
            }
        }
    }
    if (partPriceUnit === 0) {
        var radioDataPrice = parseInt($('input[name="part"]:checked').attr('data-price'), 10);
        if (!isNaN(radioDataPrice) && radioDataPrice > 0) {
            partPriceUnit = radioDataPrice;
        }
    }
    partPriceTotal = partPriceUnit * vno_of_order;

    // Set prices
    var StrapPrice = 0;
    if (vno_of_order != "" && vno_of_order > 0) {
        StrapPrice = order_pcs * parseInt(vno_of_order);
    }

    // Use admin input for discount if exists
    var dis = parseInt($('#textfield_dis').val(), 10) || 0;

    var BeforeTax = StrapPrice + partPriceTotal + opp_price + proto_charge + trace_charge;
    var grandTotal = BeforeTax - dis;

    // Hidden form fields
    $('#unit_price').val(order_pcs);
    $('#textfield7').val(StrapPrice);
    $('#partPrice').val(partPriceTotal);
    $('#opp_price').val(opp_price);
    $('#textfield3').val(proto_charge);
    $('#textfield4').val(trace_charge);
    $('#textfield9').val(BeforeTax);
    $('#textfield11').val(grandTotal);

    // Display fields
    $('#strapPrice_disp').val(StrapPrice.toLocaleString("en"));
    $('#partPrice_disp').val(partPriceTotal.toLocaleString("en"));
    $('#oppPrice_disp').val(opp_price.toLocaleString("en"));
    $('#prd_trace_price').val(trace_charge.toLocaleString("en"));
    $('#prd_sample_price').val(proto_charge.toLocaleString("en"));

    $('#beforeTax_disp').val(BeforeTax.toLocaleString("en"));
    $('#discountDisp').val(dis.toLocaleString("en"));
    $('#grandTotalDisp').val(grandTotal.toLocaleString("en"));

    $('.prd_total').text(grandTotal.toLocaleString("en"));

    // Update summary table
    $('#prd_ItemDesignRepeat').text($('input[name=ItemDesignRepeat]:checked').val() || 'いいえ');
    $('#prd_design_no').text($('input[name=design_no]').val() || '');
    $('#prd_ft_type').text($('input[name=ft_type]:checked').val() || '');
    $('#prd_ft_fabric_color1').text($('input[name=ft_fabric_color1]:checked').val() || '');
    $('#prd_ft_fabric_color2').text($('input[name=ft_fabric_color2]:checked').val() || '');
    $('#prd_qty').text($('#qty').val() || '');
    $('#prd_part').text($('input[name="part"]:checked').val() || 'なし');
    $('#prd_ft_sample').text($('input[name=ft_sample]:checked').val() || 'なし');
    $('#prd_ft_trace').text($('input[name=ft_trace]:checked').val() || 'なし');
    $('#prd_ft_opp').text($('input[name=ft_opp]:checked').val() || 'なし');
}

// Expose to global scope explicitly (works even in strict-mode contexts)
// and replay any calls that were queued by the head placeholder
window.calcFlightTag = calcFlightTag;
if (window.__calcFlightTagQueue && window.__calcFlightTagQueue.length) {
    window.__calcFlightTagQueue.forEach(function (args) { calcFlightTag.apply(null, args); });
    window.__calcFlightTagQueue = [];

    if ($('input[name=ft_type]:checked').val() == '昇華転写') {
        $('.only_embro').hide();
    } else {
        $('.only_embro').show();
    }
    $('#prd_ft_fabric_color1').text($('input[name=ft_fabric_color1]:checked').val() || '');
    $('#prd_ft_fabric_color2').text($('input[name=ft_fabric_color2]:checked').val() || '');
}

$(document).ready(function () {
    $(document).on("change", "input[name='ft_fabric_color1']", function () {
        if ($("#txt-show-Insatsu1").length > 0) {
            $("#txt-show-Insatsu1").text($(this).val());
            $("#txt-show-Insatsu1").removeClass("d-none");
        }
        $('#prd_ft_fabric_color1').text($(this).val());
    });

    $(document).on("change", "input[name='ft_fabric_color2']", function () {
        $('#prd_ft_fabric_color2').text($(this).val());
    });

    $(document).on("change", "input[name='ft_type']", function () {
        calcFlightTag();
    });

    $(document).on("change", "input[name='ItemDesignRepeat']", function () {
        if ($(this).val() === 'はい') {
            $('.repeat').show();
        } else {
            $('.repeat').hide();
        }
        calcFlightTag();
    });

    // Execute initial calculation on load
    calcFlightTag();
});