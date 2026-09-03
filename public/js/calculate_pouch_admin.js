var unit_price = 0;
var order_pcs = 0;
var pcs_price = 0;
var before_tax = 0;
var tax = 0;
var vat = 10;
var total = 0;
var proto_charge = 0;
var opp_price = 0;
var TextField7Value = 0;
var TextField9Value = 0;
var DisPrice = 0;

function get_price_admin() {
    var cth_option = $('input[name=cth_option]:checked').val();
    var cth_size = $('input[name=cth_size]:checked').val();
    var opt_code = 'standard';
    if (cth_option === 'プレミアム') opt_code = 'premium';
    else if (cth_option === 'リサイクル材') opt_code = 'recycle';

    var size_code = (cth_size === '100') ? '100' : '90';

    var key = 'pouch_' + opt_code + '_' + size_code;

    if (window.numUnitPrice && window.numUnitPrice[key]) {
        return window.numUnitPrice[key];
    }
    return null;
}

function get_add_price(code) {
    var candidates = Array.isArray(code) ? code : [code];
    for (var i = 0; i < candidates.length; i++) {
        if (window.numUnitAddPrice && window.numUnitAddPrice[candidates[i]]) {
            var tiers = window.numUnitAddPrice[candidates[i]];
            if (tiers.length > 0) return Math.floor(tiers[0].price);
        }
    }
    return 0;
}

function cal_c() {
    var vno_of_order = document.getElementById('qty');
    var qty = 0;
    if (vno_of_order && vno_of_order.value !== "") {
        qty = parseInt(vno_of_order.value, 10);
    }

    var cth_type = $('input[name=cth_type]:checked').val();
    var cth_option = $('input[name=cth_option]:checked').val();
    var cth_size = $('input[name=cth_size]:checked').val();
    var cth_sample = $('input[name=cth_sample]:checked').val();

    var price_tiers = get_price_admin();
    var minimum_qty = 100;
    if (price_tiers && price_tiers.length) {
        var tier_quantities = price_tiers.map(function (tier) {
            return parseInt(tier.num, 10);
        }).filter(function (tier_qty) {
            return tier_qty > 0;
        });
        if (tier_quantities.length) {
            minimum_qty = Math.min.apply(null, tier_quantities);
        }
    }
    $('#err_numberOf_mess').text('数量は' + minimum_qty + '個以上で入力して下さい。');
    $('#err_numberOf_mess').toggle(qty < minimum_qty);
    $('.ord-btn').prop('disabled', qty < minimum_qty);

    // Reset on every recalculation so a previously valid tier cannot survive
    // after the quantity is reduced below the first available tier.
    order_pcs = 0;
    if (qty > 0 && price_tiers) {
        for (var j = 0; j < price_tiers.length; j++) {
            if (qty >= parseInt(price_tiers[j].num)) {
                order_pcs = Math.floor(price_tiers[j].price);
                continue;
            }
            break;
        }
    } else {
        order_pcs = 0;
    }

    var prd_basic_price = 0;

    if (cth_size === "90") {
        $('#prd_size').text('90x180mm.');
    } else if (cth_size === "100") {
        $('#prd_size').text('100x180mm.');
    }

    $('#prd_option').text(cth_type + "(" + cth_option + ")");
    $('#prd_amount').text(qty);

    if (cth_sample === 'あり') {
        proto_charge = get_add_price(['pouch_prototype', 'mc_cloth_prototype']);
        if (proto_charge <= 0) proto_charge = 4500;
        $('#prd_sample').text('あり');
    } else {
        proto_charge = 0;
        $('#prd_sample').text('なし');
    }

    if ($('input[name=cth_opp]:checked').val() === 'あり') {
        // Find packing option price from DB or use fallback
        var opp_unit = 10;
        opp_unit = get_add_price(['pouch_opp_packing_fee', 'opp_packing_fee', 'mc_cloth_opp']) || opp_unit;
        opp_price = opp_unit * qty;
        $('#prd_opp').text('あり');
    } else {
        opp_price = 0;
        $('#prd_opp').text('まとめ包装（0円）');
    }

    TextField7Value = Math.floor(order_pcs) * qty;
    TextField9Value = parseInt(TextField7Value) + proto_charge + opp_price + prd_basic_price;
    DisPrice = 0;

    total = (parseInt(TextField9Value) - parseInt(DisPrice));

    var $up = document.getElementById('unit_price'); if ($up) $up.value = order_pcs;
    var $sp = document.getElementById('textfield7'); if ($sp) $sp.value = TextField7Value;
    var $bt = document.getElementById('textfield9'); if ($bt) $bt.value = TextField9Value;
    var $dis = document.getElementById('textfield_dis'); if ($dis) $dis.value = DisPrice;
    var $gt = document.getElementById('textfield11'); if ($gt) $gt.value = total;

    var $psp = document.getElementById('prd_sample_price'); if ($psp) $psp.value = proto_charge;
    var $pop = document.getElementById('prd_opp_price'); if ($pop) $pop.value = opp_price;

    var $pspDisp = document.getElementById('prd_sample_price_disp'); if ($pspDisp) $pspDisp.value = (proto_charge).toLocaleString('en');
    var $popDisp = document.getElementById('prd_opp_price_disp'); if ($popDisp) $popDisp.value = (opp_price).toLocaleString('en');

    var $prdPrice = document.getElementById('prd_price'); if ($prdPrice) $prdPrice.value = (TextField7Value).toLocaleString('en');
    var $subTotal = document.getElementById('prd_sub_total'); if ($subTotal) $subTotal.value = (TextField9Value).toLocaleString('en');
    var $discount = document.getElementById('discount_disp'); if ($discount) $discount.value = (DisPrice).toLocaleString('en');
    var $total = document.getElementById('prd_total'); if ($total) $total.value = (total).toLocaleString('en');

    $('.prd_total').text(total.toLocaleString('en'));
}

window.calcPouch = cal_c;
