function get_price_admin() {
    var sizeValue = $('input[name=ItemSize]:checked').val(); // 300x550mm, 350x600mm
    var sizeCode = sizeValue.split('x')[0]; // Extract "300" from "300x550mm"
    var dbKey = 'deskmat_' + sizeCode; // e.g. deskmat_300

    if (window.numUnitPrice && window.numUnitPrice[dbKey]) {
        return window.numUnitPrice[dbKey];
    }
    return [];
}

function calcDeskmat() {
    var vno_of_order = parseInt(document.getElementById('no_of_order').value, 10) || 0;

    var order_pcs = 0;
    if (vno_of_order > 0) {
        var pArr = get_price_admin();
        for (var i = 0, iMax = pArr.length; i < iMax; i++) {
            if (vno_of_order >= parseInt(pArr[i].num)) {
                // Base prices are tax-inclusive in the database, divide by 1.1 for tax-exclusive display
                order_pcs = Math.round(pArr[i].price / 1.1);
                continue;
            }
            break;
        }
    }

    if (vno_of_order > 1000) {
        $('#err_numberOf_mess').html('<span style="color: red">本数は1,000本以下で入力して下さい。1,000以上のお客様は納期をメールにてお問い合わせ下さい。</span>');
    } else {
        $('#err_numberOf_mess').html('');
    }

    var proto_charge = 0;
    if ($('input[name="試作品作成"]:checked').val() != undefined) {
        if (window.numUnitAddPrice && window.numUnitAddPrice['deskmat_sample']) {
            proto_charge = Math.round(window.numUnitAddPrice['deskmat_sample'] / 1.1);
        } else {
            proto_charge = Math.round(7000 / 1.1);
        }
    }

    var trace_charge = 0;
    if ($('input[name="データトレース"]:checked').val() != undefined) {
        if (window.numUnitAddPrice && window.numUnitAddPrice['deskmat_data_trace']) {
            trace_charge = Math.round(window.numUnitAddPrice['deskmat_data_trace'] / 1.1);
        } else {
            trace_charge = Math.round(2000 / 1.1);
        }
    }

    var coating_price = 0;
    if ($('input[name=shape_processing]:checked').val() == "ロック縫いあり") {
        if (window.numUnitAddPrice && window.numUnitAddPrice['deskmat_edge_lock_stitch']) {
            coating_price = Math.round(window.numUnitAddPrice['deskmat_edge_lock_stitch'] / 1.1) * vno_of_order;
        } else {
            coating_price = Math.round(18 / 1.1) * vno_of_order;
        }
    }

    // Set prices
    var StrapPrice = 0;
    if (vno_of_order != "" && vno_of_order > 0) {
        StrapPrice = order_pcs * parseInt(vno_of_order);
    }

    var BeforeTax = StrapPrice + proto_charge + trace_charge + coating_price;
    var tax = Math.floor(BeforeTax * 0.10);
    var grandTotal = BeforeTax + tax;

    // Display values
    $('#unit_price').val(order_pcs);
    $('#textfield7').val(StrapPrice);
    $('#textfield9').val(BeforeTax);
    $('#textfield11').val(grandTotal);

    $('#strapPrice_disp').val(StrapPrice.toLocaleString("en"));
    $('#coating_shape_price').val(coating_price.toLocaleString("en"));
    $('#prd_trace_price').val(trace_charge.toLocaleString("en"));
    $('#prd_sample_price').val(proto_charge.toLocaleString("en"));

    $('#beforeTax_disp').val(BeforeTax.toLocaleString("en"));
    $('#discountDisp').val("0");
    $('#grandTotalDisp').val(grandTotal.toLocaleString("en"));

    $('.prd_total').text(grandTotal.toLocaleString("en"));
}
