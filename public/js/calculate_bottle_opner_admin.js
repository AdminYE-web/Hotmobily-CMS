var bottle = [];

if (typeof window.numUnitPrice !== 'undefined' && window.numUnitPrice.length > 0) {
    bottle = window.numUnitPrice;
} else if (typeof numUnitPrice !== 'undefined' && numUnitPrice.length > 0) {
    bottle = numUnitPrice;
} else {
    // Default fallback based on calculater_bottle.js
    // bottle = [400, 250, 120, 100, 95, 93, 89];
}

var order_pcs = 0;
var unit_price = 0;
var pcs_price = 0;
var before_tax = 0;
var tax = 0;
var vat = 10;
var total = 0;
var TextField7Value = 0;
var TextField9Value = 0;
var DisPrice = 0;
var proto_charge = 0;
var opp_price = 0;

function calcBottleOpner() {
    clearValue();
    var vno_of_order = document.getElementById('no_of_order');

    var qty = parseInt(vno_of_order.value, 10) || 0;

    $('#err_no_of_order').text('');
    $('.ord-btn').prop('disabled', false);

    var qty = parseInt(vno_of_order.value, 10) || 0;

    $('#err_no_of_order').text('');
    $('.ord-btn').prop('disabled', false);

    if (qty < 50) {
        $('#err_no_of_order').text('最低注文数は 50個です。');
        $('.ord-btn').prop('disabled', true);
    } else if (qty > 50000) {
        $('#err_no_of_order').text('最大注文数は 50000個です。');
        $('.ord-btn').prop('disabled', true);
    }

    if (qty >= 5000) order_pcs = bottle[6] || 89;
    else if (qty >= 3000) order_pcs = bottle[5] || 93;
    else if (qty >= 2000) order_pcs = bottle[4] || 95;
    else if (qty >= 1000) order_pcs = bottle[3] || 100;
    else if (qty >= 500) order_pcs = bottle[2] || 120;
    else if (qty >= 100) order_pcs = bottle[1] || 250;
    else if (qty >= 50) order_pcs = bottle[0] || 400;
    else order_pcs = bottle[0] || 400;

    var pcs_val = $('input[name=ItemPCS]:checked').val();
    if (pcs_val == "ミックスカラー注文") {
        $('.color_area').hide();
        $('input[name=ItemColors]').prop('checked', false);
        $('#prd_ItemColors').text('-');
    } else {
        $('.color_area').show();
        $('#prd_ItemColors').text($('input[name=ItemColors]:checked').val() || '');
    }

    $('#prd_ItemPCS').text($('input[name=ItemPCS]:checked').val() || '');
    $('#prd_qty').text(vno_of_order.value);

    if ($('input[name=SendPrototype]:checked').val() === 'あり') {
        if (vno_of_order.value < 300) {
            proto_charge = 6000;
        } else {
            proto_charge = 0;
        }
        $('#prd_SendPrototype').text('あり');
    } else {
        $('#prd_SendPrototype').text('なし');
    }

    if ($('input[name=DeFormat]:checked').val() === 'あり') {
        $('#prd_DeFormat').text('あり');
    } else {
        $('#prd_DeFormat').text('なし');
    }

    if ($('input[name=ItemOPP]:checked').val() === 'OPP個別包装（7円）') {
        opp_price = 7;
        $('#prd_ItemOPP').text('OPP個別包装（7円）');
    } else {
        opp_price = 0;
        $('#prd_ItemOPP').text('まとめ包装（0円）');
    }

    var qty = parseInt(vno_of_order.value) || 0;

    // Assign Value
    TextField7Value = Math.floor(order_pcs) * qty;

    // Amount Before Tax
    TextField9Value = parseInt(TextField7Value) + proto_charge + (opp_price * qty);

    var rawDis = $('#textfield_dis').val() || "0";
    DisPrice = parseInt(String(rawDis).replace(/,/g, '')) || 0;

    total = parseInt(TextField9Value) - parseInt(DisPrice);

    tax = Math.floor(total * vat / 100);

    document.getElementById('prd_sample_price').value = proto_charge;
    document.getElementById('prd_opp_price').value = (opp_price * qty);

    // Write internal input fields expected by add-order.php
    $('#textfield7').val(TextField7Value);
    $('#textfield9').val(TextField9Value);
    $('#textfield_dis').val(DisPrice);
    $('#textfield11').val(total);
    $('#unit_price').val(order_pcs);

    $('.prd_total').text(formatMoney(total));

    // Execute any queued calls from early loads
    if (window.__calcBottleOpnerQueue && window.__calcBottleOpnerQueue.length > 0) {
        window.__calcBottleOpnerQueue = [];
    }
}

function clearValue() {
    order_pcs = 0;
    unit_price = 0;
    pcs_price = 0;
    before_tax = 0;
    tax = 0;
    total = 0;
    TextField7Value = 0;
    TextField9Value = 0;
    DisPrice = 0;
    proto_charge = 0;
    opp_price = 0;

    $('#prd_sample_price').val("");
    $('#prd_opp_price').val("");

    $('#textfield7').val("");
    $('#textfield9').val("");
    $('#textfield11').val("");

    $('.prd_total').text("0");
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

$(document).ready(function () {
    calcBottleOpner();
});
