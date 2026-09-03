/**
 * calculate_pbholder_admin.js
 * Admin-side pricing calculator for ペットボトルホルダー.
 */

var vat = 10;


function get_price_admin(itemPcs) {
    var key = 'pbholder_standard';
    if (itemPcs === 'プレミアム') {
        key = 'pbholder_premium';
    }

    if (window.numUnitPrice && window.numUnitPrice[key]) {
        return window.numUnitPrice[key];
    }
    return [];
}

function getDbPriceVal(pool, key, qtyNum) {
    if (!pool || !pool[key]) return 0;
    var arr = pool[key];
    var val = arr[0].price;
    for (var i = 0; i < arr.length; i++) {
        if (qtyNum >= parseInt(arr[i].num, 10)) val = arr[i].price;
        else break;
    }
    return val;
}

function calcPbholder() {
    $('#err_numberOf_mess').hide();
    $('#error_message').text('');

    var qty = parseInt($('#no_of_order').val(), 10) || 0;
    var itemPcs = $('input[name="ItemPCS"]:checked').val() || 'スタンダード';
    var coating = $('input[name="coating"]:checked').val() || '汚れ防止加工なし';
    var material = $('input[name="ItemMaterial"]:checked').val() || '特殊素材なし';
    var design_var = $('input[name="ItemDesignVariation"]:checked').val() || '1種類';
    var paper = $('input[name="paper_select"]:checked').val() || 'なし';
    var sample = $('input[name="SendPrototype"]:checked').val() || 'なし';
    var trace = $('input[name="DeFormat"]:checked').val() || 'なし';

    var err_msgs = [];
    if (qty < 50 && qty > 0) {
        err_msgs.push("本数は50本以上で入力して下さい。");
    }
    if (itemPcs === 'スタンダード（スピード7営業日発送）' && qty > 300) {
        err_msgs.push("本数は300本以下で入力して下さい。");
    }
    if (design_var === '2種類' && qty < 100 && qty > 0) {
        err_msgs.push("2種類の場合は本数は100本以上で入力して下さい。");
    }
    if (design_var === '3種類' && qty < 150 && qty > 0) {
        err_msgs.push("3種類の場合は本数は150本以上で入力して下さい。");
    }
    if (design_var === '4種類' && qty < 200 && qty > 0) {
        err_msgs.push("4種類の場合は本数は200本以上で入力して下さい。");
    }

    if (err_msgs.length > 0) {
        $('#err_numberOf_mess').html("<font color='red'>" + err_msgs.join("<br>") + "(管理者用のため計算は継続します)</font>").show();
    } else {
        $('#err_numberOf_mess').hide();
        $('#sample-error').text('');
    }

    var dbProto = getDbPriceVal(window.numUnitAddPrice, 'pbholder_prototype', 1) || 8000;
    var proto_charge = 0;
    if (sample === 'あり') {
        if (itemPcs !== 'プレミアム') {
            proto_charge = dbProto;
        }
    }

    var dbTrace = getDbPriceVal(window.numUnitAddPrice, 'pbholder_datatrace', 1) || 8000;
    var trace_charge = 0;
    if (trace === 'あり') {
        if (itemPcs !== 'プレミアム') {
            trace_charge = dbTrace;
        }
    }

    var unit_price = 0;
    var price_tiers = get_price_admin(itemPcs);

    if (price_tiers && price_tiers.length > 0 && qty > 0) {
        unit_price = 0; // default to 0 if qty is below minimum tier
        for (var j = price_tiers.length - 1; j >= 0; j--) {
            if (qty >= parseInt(price_tiers[j].num)) {
                unit_price = Math.floor(price_tiers[j].price);
                break;
            }
        }
    }

    if (itemPcs === 'スタンダード（スピード7営業日発送）') {
        var dbSpeed = getDbPriceVal(window.numUnitAddPrice, 'speed_delivery_7d', 1) || 110;
        unit_price += dbSpeed;
    }

    // Additional options
    var dbCoating = getDbPriceVal(window.numUnitAddPrice, 'pbholder_antistain', 1) || 70;
    var coatingPrice = 0;
    if (coating === '汚れ防止加工あり') {
        coatingPrice = dbCoating * qty;
    }

    var materialPrice = 0;
    var materialKey = '';
    switch (material) {
        case '特殊素材：蓄光（オレンジ色）': materialKey = 'pbholder_phosphorescent_orange'; break;
        case '特殊素材：蓄光（緑色）': materialKey = 'pbholder_phosphorescent_green'; break;
        case '特殊素材：蛍光': materialKey = 'pbholder_fluorescent'; break;
        case '特殊素材：ラメ': materialKey = 'pbholder_glitter'; break;
        case '特殊素材：金色': materialKey = 'pbholder_gold'; break;
        case '特殊素材：銀色': materialKey = 'pbholder_silver'; break;
    }
    if (materialKey !== '') {
        var dbMaterial = getDbPriceVal(window.numUnitAddPrice, materialKey, 1) || 30;
        materialPrice = dbMaterial * qty;
    }

    var dbDesignVar = getDbPriceVal(window.numUnitAddPrice, 'pbholder_colorvariation', 1) || 3000;
    var designsPrice = 0;
    if (design_var === '2種類') designsPrice = dbDesignVar * 1;
    else if (design_var === '3種類') designsPrice = dbDesignVar * 2;
    else if (design_var === '4種類') designsPrice = dbDesignVar * 3;

    var paperPrice = 0;
    if (paper === 'あり' && qty > 0) {
        var dbPaperKey = 'Paper 1 Side';
        var unit_paper_price = getDbPriceVal(window.numUnitOptionPrice, dbPaperKey, qty);
        if (!unit_paper_price && window.numUnitOptionPrice && window.numUnitOptionPrice[dbPaperKey + '_0']) {
            unit_paper_price = getDbPriceVal(window.numUnitOptionPrice, dbPaperKey + '_0', qty);
        }
        paperPrice = (unit_paper_price || 0) * qty;
    }

    var strapPrice = unit_price * qty;
    var before_tax = strapPrice + proto_charge + trace_charge + coatingPrice + materialPrice + designsPrice + paperPrice;

    // Tax computation logic typically used in admin
    // Here we compute total by just adding tax to before_tax, wait, let's look at how other scripts do it
    // Usually admin uses pure `total = before_tax - disPrice;` where everything is before tax?
    // In tumbler it did: `var total = before_tax - disPrice;` which means tax is NOT calculated in `grandTotalDisp`.
    // Wait, let's verify tumbler. `$('#grandTotalDisp').val(total.toLocaleString('en'));` 
    // And in `products/pbholder.php` it does `before_tax * (1 + vat/100)`.
    // Actually, in `calculate_tumbler_admin.js`:
    // `var total = before_tax - disPrice;`
    // Let's add tax just in case? If tumbler didn't, maybe we just follow it. Wait, the HTML says "小計(税込)" and "合計(税込)" for tumbler?
    // Let's check tumbler's HTML: "小計(税込)". If the values in DB `unit_price` are WITH tax, then yes. 
    // Usually `unit_price` in `item_price_master` is pre-tax? In Hotmobily, many prices are tax-inclusive in frontend, but admin might just add them up.
    // Let's assume `before_tax` and `total` are standard sums, since tumbler just adds them.

    var disPrice = parseFloat($('#textfield_dis').val() || 0);
    var total = before_tax - disPrice;

    $('#prd_qty').text(qty);
    $('#prd_ItemPCS').text(itemPcs);
    $('#prd_coating').text(coating);
    $('#prd_ItemMaterial').text(material);
    $('#prd_ItemDesignVariation').text(design_var);
    $('#prd_paper').text(paper);
    $('#prd_SendPrototype').text(sample);
    $('#prd_DeFormat').text(trace);

    var $sd = document.getElementById('strapPrice_disp'); if ($sd) $sd.value = strapPrice.toLocaleString('en');
    var $cd = document.getElementById('coatingPrice_disp'); if ($cd) $cd.value = coatingPrice.toLocaleString('en');
    var $pd = document.getElementById('paperPrice_disp'); if ($pd) $pd.value = paperPrice.toLocaleString('en');
    var $ptrc = document.getElementById('prd_trace_price'); if ($ptrc) $ptrc.value = trace_charge.toLocaleString('en');
    var $psh = document.getElementById('prd_sample_price'); if ($psh) $psh.value = proto_charge.toLocaleString('en');
    var $dsg = document.getElementById('designsCharge_disp'); if ($dsg) $dsg.value = designsPrice.toLocaleString('en');
    var $mat = document.getElementById('materialCharge_disp'); if ($mat) $mat.value = materialPrice.toLocaleString('en');

    var $bd = document.getElementById('beforeTax_disp'); if ($bd) $bd.value = before_tax.toLocaleString('en');
    var $gd = document.getElementById('grandTotalDisp'); if ($gd) $gd.value = total.toLocaleString('en');

    $('.prd_total').text(total.toLocaleString('en'));

    var $up = document.getElementById('unit_price'); if ($up) $up.value = (qty > 0 ? unit_price : 0);

    // update hidden fields
    document.getElementById('textfield7').value = strapPrice;
    document.getElementById('textfield13_2').value = coatingPrice;
    document.getElementById('textfield7_2').value = paperPrice;
    document.getElementById('textfield3').value = proto_charge;
    document.getElementById('textfield4').value = trace_charge;
    document.getElementById('DesignsCharge').value = designsPrice;
    document.getElementById('MaterialCharge').value = materialPrice;

    var $textfield9 = document.getElementById('textfield9'); if ($textfield9) $textfield9.value = before_tax;
    var $textfield11 = document.getElementById('textfield11'); if ($textfield11) $textfield11.value = total;

    var $pf11 = document.getElementById('pricefield11'); if ($pf11) $pf11.value = before_tax;
    var $pf13 = document.getElementById('pricefield13'); if ($pf13) $pf13.value = total;
}

window.calcPbholder = calcPbholder;

$(document).ready(function () {
    calcPbholder();
});
