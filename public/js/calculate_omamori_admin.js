// Admin-side pricing calculator for オリジナルお守り
// Sourced dynamically from database pricing via window.numUnitPrice['omamori_...']

var parts_obj_admin = null;
var vat = 10;
var unit_price = 0;
var partPrice = 0;
var paperPrice = 0;
var sub_total = 0;
var disPrice = 0;
var total = 0;
var mold_charge = 0;
var proto_charge = 0;
var trace_charge = 0;
var opp_price = 0;

function get_price_admin() {
    var pcs = $('input[name="ItemPCS"]:checked').val() || 'ジャガード織タイプ';
    var dbKey = (pcs === 'フルカラータイプ') ? 'omamori_fullcolor' : 'omamori_jacquard';

    if (window.numUnitPrice && window.numUnitPrice[dbKey]) {
        return window.numUnitPrice[dbKey];
    }
    return [];
}

function get_add_price(code) {
    if (window.numUnitAddPrice && window.numUnitAddPrice[code]) {
        var tiers = window.numUnitAddPrice[code];
        if (tiers.length > 0) return Math.floor(tiers[0].price);
    }
    return 0;
}

function calcOmamori() {
    var pcs = $('input[name="ItemPCS"]:checked').val() || 'ジャガード織タイプ';
    var color = $('input[name="ItemColors"]:checked').val() || '真紅色';
    var qty = parseInt($('#no_of_order').val(), 10) || 0;

    var sample = $('input[name="SendPrototype"]:checked').val() || 'なし';
    var trace = $('input[name="DeFormat"]:checked').val() || 'なし';
    var opp = $('input[name="ItemOPP"]:checked').val() || 'まとめ包装（PVC個包装）';

    // Base price
    var pArr = get_price_admin();
    unit_price = 0;
    for (var i = 0, iMax = pArr.length; i < iMax; i++) {
        if (qty >= parseInt(pArr[i].num)) {
            unit_price = Math.floor(pArr[i].price);
            continue;
        }
        break;
    }

    // Mold charge for Full color
    mold_charge = 0;
    if (pcs === "フルカラータイプ") {
        mold_charge = get_add_price('omamori_fullcolor_platefee') || get_add_price('omamori_fullcolor_plate_fee');
        if (mold_charge === 0) mold_charge = 6000; // fallback tax-exclusive
    }

    // Prototype charge
    proto_charge = 0;
    if (sample === "あり") {
        proto_charge = get_add_price('omamori_prototype') || get_add_price('omamori_sample');
        if (proto_charge === 0) proto_charge = 6000; // fallback tax-exclusive
    }

    // Trace charge
    trace_charge = 0;
    if (trace === "あり") {
        trace_charge = get_add_price('omamori_datatrace') || get_add_price('omamori_data_trace');
        if (trace_charge === 0) trace_charge = 2000; // fallback tax-exclusive
    }

    // OPP charge
    opp_price = 0;
    if (opp === "OPP個包装（PVC個包装）" || opp === "OPP個別包装") {
        opp_price = get_add_price('omamori_opp');
        if (opp_price === 0) opp_price = 7;
    }

    $('#prd_qty').text(qty || '');

    // Subtotal
    var TextField7Value = Math.floor(unit_price * qty); // StrapPrice
    var oppTotal = Math.floor(opp_price * qty);

    sub_total = TextField7Value + mold_charge + proto_charge + trace_charge + oppTotal;

    total = sub_total;

    // Update displays
    $('#unit_price').val(unit_price);
    $('#strapPrice_disp').val(TextField7Value.toLocaleString("en"));

    $('#prd_mold_price').val(mold_charge.toLocaleString("en"));
    $('#prd_trace_price').val(trace_charge.toLocaleString("en"));
    $('#prd_sample_price').val(proto_charge.toLocaleString("en"));
    $('#prd_opp_price').val(oppTotal.toLocaleString("en"));


    $('#beforeTax_disp').val(sub_total.toLocaleString("en"));
    $('#textfield9').val(sub_total); // BeforeTax

    $('#discountDisp').val(disPrice.toLocaleString("en"));
    $('#textfield_dis').val(disPrice); // discount

    $('#grandTotalDisp').val(total.toLocaleString("en"));
    $('#textfield11').val(total); // grandTotal
    $('.prd_total').text(total.toLocaleString('ja'));

    // Hidden field writes
    var $t7 = document.getElementById('textfield7'); if ($t7) $t7.value = TextField7Value; // Base price sum
}
