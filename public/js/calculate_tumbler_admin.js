// JS calculation logic for admin Tumbler
var unit_price = 0;

function format_number(n) {
    return String(n).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function getTumblerPriceArray(shapeProcessing) {
    if (!window.numUnitPrice) return [];
    var keys = Object.keys(window.numUnitPrice);
    if (keys.length === 0) return [];

    // Attempt to match by name
    var targetKey = keys[0];
    if (shapeProcessing === 'レーザー加工') {
        targetKey = keys.find(k => k.toLowerCase().includes('laser') || k.toLowerCase().includes('レーザー')) || keys[0];
    } else if (shapeProcessing.includes('フルカラー')) {
        targetKey = keys.find(k => k.toLowerCase().includes('color') || k.toLowerCase().includes('uv') || k.toLowerCase().includes('カラー')) || keys[1] || keys[0];
    }

    return window.numUnitPrice[targetKey] || [];
}

function calcTumbler() {
    var shapeProcessing = $('input[name="shape_processing"]:checked').val() || 'レーザー加工';
    var qty = parseInt($('#no_of_order').val().replace(/,/g, ''), 10);
    if (isNaN(qty) || qty < 0) qty = 0;

    var isPrototype = $('input[name="SendPrototype"]:checked').length > 0;
    var isDeFormat = $('input[name="DeFormat"]:checked').length > 0;

    // Fees
    var prototypeFee = isPrototype ? (window.tumblerSamplePrice || 4500) : 0;
    var deFormatFee = isDeFormat ? (window.tumblerTracePrice || 2000) : 0;
    var attachmentFee = 0; // tumbler has no extra attachment options currently

    // Product Base Price
    unit_price = 0;
    var priceArr = getTumblerPriceArray(shapeProcessing);

    if (priceArr.length > 0 && qty > 0) {
        // Iterate ascending. 
        // e.g. [{num:100, price:2089}, {num:200, price:1976}, ...]
        // We find the largest num that is <= qty
        unit_price = priceArr[priceArr.length - 1].price; // default to largest qty price
        for (var i = 0; i < priceArr.length; i++) {
            if (qty < priceArr[i].num) {
                if (i === 0) {
                    unit_price = priceArr[0].price; // if less than min qty, use min price
                } else {
                    unit_price = priceArr[i - 1].price;
                }
                break;
            }
        }
    }

    // if fallback to hardcoded needed when DB is empty:
    if (priceArr.length === 0) {
        var priceA = [1899, 1796, 1707, 1626, 1545, 1473];
        var priceB = [1975, 1897, 1827, 1746, 1666, 1598];
        var qtyScale = [100, 200, 300, 500, 1000, 2000];
        var pArr = (shapeProcessing === 'レーザー加工') ? priceA : priceB;
        if (qty > 0) {
            unit_price = pArr[pArr.length - 1];
            for (var j = 0; j < qtyScale.length; j++) {
                if (qty < qtyScale[j]) {
                    unit_price = (j === 0) ? pArr[0] : pArr[j - 1];
                    break;
                }
            }
        }
    }

    var baseSubtotal = unit_price * qty;
    var totalSubtotal = baseSubtotal + prototypeFee + deFormatFee + (attachmentFee * qty);

    // Apply discount
    var discount = parseInt($('#textfield_dis').val() || 0, 10);
    var grandTotal = totalSubtotal - discount;
    if (grandTotal < 0) grandTotal = 0;

    // Display
    $('#prd_qty').text(qty + '個');
    $('#strapPrice_disp').val(format_number(baseSubtotal));
    $('#prd_trace_price').val(format_number(deFormatFee));
    $('#prd_sample_price').val(format_number(prototypeFee));
    $('#coating_shape_price').val(format_number(attachmentFee)); // tumbler doesn't have shape_price extra per unit 
    $('#beforeTax_disp').val(format_number(totalSubtotal));
    $('#grandTotalDisp').val(format_number(grandTotal));

    // Internal hidden
    $('#unit_price').val(unit_price);
    $('#textfield7').val(baseSubtotal); // strapPrice
    $('#textfield9').val(totalSubtotal);
    $('#textfield11').val(grandTotal);

    // Update main total label
    $('.prd_total').text(format_number(grandTotal));
}
