function getMkiAdditionalPrice(codes, fallback) {
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

function calcMKI() {
    var item_type = $('input[name=item_type]:checked').val();
    var cth_type = $('input[name=cth_type]:checked').val();
    var cth_size = $('input[name=cth_size]:checked').val();
    var qty = parseInt($('#qty').val()) || 0;

    var cth_color = $('input[name=cth_color]:checked').val();
    var cth_sewing = $('select[name=cth_sewing_color]').val();
    var cth_sample = $('input[name=cth_sample]:checked').val() || 'なし';
    var cth_opp = $('input[name=cth_opp]:checked').val() || 'まとめ包装（0円）';

    var product_code = "";
    var m_type = item_type === "リサイクル材" ? "recycle" : "virgin";

    // Handle UI condition logic based on customer form rules
    if (m_type === "recycle") {
        // Recycle material: disable Emboss
        $('input[name=cth_type][value="エンボス加工"]').prop('disabled', true);
        if (cth_type === "エンボス加工") {
            $('input[name=cth_type][value="昇華転写片面印刷"]').prop('checked', true);
            cth_type = "昇華転写片面印刷";
        }

        // Recycle material: color must be 05WHITE
        $.each($('input[name=cth_color]'), function () {
            if ($(this).val() !== "05WHITE") {
                $(this).closest('.part-content').hide();
            } else {
                $(this).prop('checked', true);
                cth_color = "05WHITE";
            }
        });
    } else {
        // Virgin material
        $('input[name=cth_type][value="エンボス加工"]').prop('disabled', false);

        if (cth_type === "昇華転写片面印刷" || cth_type === "昇華転写両面印刷") {
            // Sublimation: color must be 05WHITE
            $.each($('input[name=cth_color]'), function () {
                if ($(this).val() !== "05WHITE") {
                    $(this).closest('.part-content').hide();
                } else {
                    $(this).prop('checked', true);
                    cth_color = "05WHITE";
                }
            });
        } else {
            // Silk or Emboss: show all colors
            var wasHidden = false;
            $.each($('input[name=cth_color]'), function () {
                if (!$(this).closest('.part-content').is(':visible')) {
                    $(this).closest('.part-content').show();
                    wasHidden = true;
                }
            });
            if (wasHidden) {
                $('input[name=cth_color][value="01LUNOR BROWN"]').prop('checked', true);
                cth_color = "01LUNOR BROWN";
            }
        }
    }
    var m_size = cth_size === "180" ? "180" : "150";
    var m_print = "sublimation_front";
    if (cth_type === "昇華転写両面印刷") m_print = "sublimation_double";
    else if (cth_type === "1色印刷（シルクスクリーン）") m_print = "silk";
    else if (cth_type === "エンボス加工") m_print = "emboss";

    product_code = "mki_" + m_type + "_" + m_size + "_" + m_print;
    // For original mapping without 'mki_' if needed:
    var search_code1 = product_code;
    var search_code2 = product_code;

    // Find unit price
    var unit_price = 0;
    var priceList = (window.numUnitPrice && (window.numUnitPrice[search_code1] || window.numUnitPrice[search_code2])) || null;

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
        // prices is ordered by rate ASC, but wait we need to find the correct tier
        // standard is usually highest rate first or we need to sort descending to find matching rate
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
        prd_basic_price = getMkiAdditionalPrice(['mki_silkplate_fee', 'mki_silk_setup'], 4500);
    } else if (cth_type === "エンボス加工") {
        prd_basic_price = getMkiAdditionalPrice(['mki_embossplate_fee', 'mki_emboss_setup'], 7000);
    }

    var sample_price = 0;
    if (cth_sample === 'あり') {
        sample_price = getMkiAdditionalPrice(['mki_prototype', 'mc_cloth_prototype'], 4500);
    }

    var opp_price = 0;
    if (cth_opp === 'あり') {
        var opp_unit = getMkiAdditionalPrice(['mki_opp_packing_fee', 'opp_packing_fee', 'mc_cloth_opp'], 10);
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
    $('#prd_item_type').text(item_type);
    $('#prd_cth_type').text(cth_type);
    $('#prd_size').text(cth_size === "150" ? "150x150mm" : "150x180mm");
    $('#prd_color').text(cth_color);
    $('#prd_sewing').text(cth_sewing);
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
