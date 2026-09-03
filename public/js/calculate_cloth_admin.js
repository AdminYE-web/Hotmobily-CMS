function getClothAdditionalPrice(codes, fallback) {
    var candidates = Array.isArray(codes) ? codes : [codes];
    for (var i = 0; i < candidates.length; i++) {
        var tiers = window.numUnitAddPrice && window.numUnitAddPrice[candidates[i]];
        if (tiers && tiers.length) {
            var price = parseFloat(tiers[0].price);
            if (!isNaN(price)) return price;
        }
    }
    return fallback;
}

function calcCloth() {
    var cth_type = $('input[name=cth_type]:checked').val();
    var cth_option = $('input[name=cth_option]:checked').val();
    var cth_size = $('input[name=cth_size]:checked').val();
    var qty = parseInt($('#qty').val()) || 0;
    var cth_sample = $('input[name=cth_sample]:checked').val() || 'なし';
    var cth_opp = $('input[name=cth_opp]:checked').val() || 'まとめ包装（0円）';

    var m_print = "sublimation_front";
    if (cth_type === "昇華転写両面印刷") m_print = "sublimation_double";
    else if (cth_type === "1色印刷（シルクスクリーン）") m_print = "silk";
    else if (cth_type === "エンボス加工") m_print = "emboss";

    var m_option = cth_option === "プレミアム" ? "prem" : "std";
    var m_size = cth_size === "180" ? "180" : "150";

    var product_code = "cloth_" + m_print + "_" + m_option + "_" + m_size;

    var unit_price = 0;
    var priceList = window.numUnitPrice && window.numUnitPrice[product_code];

    var minimum_qty = 100;
    if (priceList && priceList.length) {
        var tier_quantities = priceList.map(function (tier) {
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

    if (priceList && qty > 0) {
        var sortedPrices = priceList.slice().sort(function (a, b) {
            return b.num - a.num; // highest rate first
        });
        for (var i = 0; i < sortedPrices.length; i++) {
            if (qty >= sortedPrices[i].num) {
                unit_price = sortedPrices[i].price;
                break;
            }
        }
    }

    var prd_basic_price = 0;
    if (cth_type === "1色印刷（シルクスクリーン）") {
        prd_basic_price = getClothAdditionalPrice(['cloth_silkplate_fee', 'cloth_silk_setup'], 3600);
    } else if (cth_type === "エンボス加工") {
        // The service master uses cloth_embossplate_fee (id 222).
        // Keep the fallback aligned with that master so a missing/stale
        // price payload cannot revert the embossing die fee to 4,500 yen.
        prd_basic_price = getClothAdditionalPrice(['cloth_embossplate_fee'], 8000);
    }

    var sample_price = 0;
    if (cth_sample === 'あり') {
        sample_price = getClothAdditionalPrice(['cloth_prototype', 'mc_cloth_prototype'], 4500);
    }

    var opp_price = 0;
    if (cth_opp === 'あり') {
        var opp_unit = getClothAdditionalPrice(['cloth_opp_packing_fee', 'opp_packing_fee', 'mc_cloth_opp'], 10);
        opp_price = opp_unit * qty;
    }

    var base_price = unit_price * qty;
    var before_tax = base_price + prd_basic_price + sample_price + opp_price;

    var discount = 0;
    if ($('#textfield_dis').val() > 0) {
        discount = parseInt($('#textfield_dis').val());
    }

    var total = Math.floor(before_tax - discount);

    // Update UI text
    $('#prd_cth_option').text(cth_option);
    $('#prd_cth_type').text(cth_type);
    $('#prd_size').text(cth_size === "150" ? "150x150mm" : "150x180mm");
    $('#prd_amount').text(qty);
    $('#prd_sample').text(cth_sample === 'あり' ? 'あり' : 'なし');
    $('#prd_opp').text(cth_opp === 'あり' ? 'あり' : 'まとめ包装（0円）');

    // Update form fields
    $('#prd_price_disp').val(base_price.toLocaleString("en"));
    $('#prd_basic_price_disp').val(prd_basic_price.toLocaleString("en"));
    $('#prd_sample_price_disp').val(sample_price.toLocaleString("en"));
    $('#prd_opp_price_disp').val(opp_price.toLocaleString("en"));
    $('#prd_sub_total').val(before_tax.toLocaleString("en"));
    $('#discount_disp').val(discount.toLocaleString("en"));
    $('#prd_total').val(total.toLocaleString("en"));
    $('.prd_total').text(total.toLocaleString("en"));

    $('#unit_price').val(unit_price);
    $('#textfield7').val(base_price);
    $('#prd_basic_price').val(prd_basic_price); // SilkPrint
    $('#prd_mold_price').val(cth_type === 'エンボス加工' ? prd_basic_price : 0); // MoldCharge
    $('#prd_sample_price').val(sample_price); // TraceCharge
    $('#prd_opp_price').val(opp_price); // pricefield10
    $('#textfield9').val(before_tax);
    $('#textfield11').val(total);
}
