function get_price_admin() {
    var sizeValue = $('input[name=ItemSize]:checked').val().toLowerCase(); // a2, b2, b1
    var fabricValue = $('input[name=FabricType]:checked').val();
    var fabric_key = 'thick_suede';
    if (fabricValue === '厚手シングルスエード') {
        fabric_key = 'thick_suede';
    } else if (fabricValue === '薄手シングルスエード') {
        fabric_key = 'light_suede';
    } else if (fabricValue === 'ダブルスエード') {
        fabric_key = 'double_suede';
    }
    var dbKey = 'tapestry_' + fabric_key + '_' + sizeValue;

    if (window.numUnitPrice && window.numUnitPrice[dbKey]) {
        return window.numUnitPrice[dbKey];
    }
    return [];
}

function calcTapestry() {
    var vno_of_order = parseInt(document.getElementById('no_of_order').value, 10) || 0;

    var order_pcs = 0;
    if (vno_of_order > 0) {
        var pArr = get_price_admin();
        for (var i = 0, iMax = pArr.length; i < iMax; i++) {
            if (vno_of_order >= parseInt(pArr[i].num)) {
                order_pcs = Math.floor(pArr[i].price);
                continue;
            }
            break;
        }
    }

    var proto_charge = 0;
    if ($('input[name=SendPrototype]:checked').val() != undefined) {
        proto_charge = 6818;
    }

    // Set prices
    var StrapPrice = 0;
    if (vno_of_order != "" && vno_of_order > 0) {
        StrapPrice = order_pcs * parseInt(vno_of_order);
    }

    var BeforeTax = StrapPrice + proto_charge;
    var grandTotal = BeforeTax;

    // Display values
    $('#unit_price').val(order_pcs);
    $('#textfield7').val(StrapPrice);
    $('#textfield9').val(BeforeTax);
    $('#textfield11').val(grandTotal);

    $('#strapPrice_disp').val(StrapPrice.toLocaleString("en"));
    $('#prd_mold_price').val(0); // Assuming 0
    $('#prd_sample_price').val(proto_charge.toLocaleString("en"));
    $('#beforeTax_disp').val(BeforeTax.toLocaleString("en"));
    $('#discountDisp').val("0");
    $('#grandTotalDisp').val(grandTotal.toLocaleString("en"));

    $('.prd_total').text(grandTotal.toLocaleString("en"));

    var sizeValue = $('input[name=ItemSize]:checked').val();
    var fabricValue = $('input[name=FabricType]:checked').val();
    if (sizeValue && fabricValue) {
        $('#strap').val('オリジナルタペストリー ' + sizeValue + ' ' + fabricValue);
    }
}
