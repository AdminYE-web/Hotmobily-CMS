// This file handles mapping the calculation results into the hidden input fields 
// required by the sales-order system (Control_Rubber_Renew.php -> cart)

function setToInput() {
    var ItemType = "リサイクル原糸マイクロファイバークロス";
    var ItemType_val = $('input[name="ItemType_val"]:checked').length > 0 ? $('input[name="ItemType_val"]:checked').val() : $('input[name="ItemType"]:checked').val();
    
    // Map ItemType properly to the readable string for cart
    if(ItemType_val === "i1"){
      ItemType += " (昇華転写片面印刷)";
    }else if(ItemType_val === "i2"){
      ItemType += " (昇華転写両面印刷)";
    }
    
    var sizeText = ($("#ItemSize").val() == "1") ? "150mmx150mm" : "150mmx180mm";
    
    var example = (document.getElementById("example_have") && document.getElementById("example_have").checked) ? "1" : "0";
    var packing = (document.getElementById("pack_have") && document.getElementById("pack_have").checked) ? "OPP個別包装" : "なし";

    var qty = $('#no_of_order').val();

    var base_price = $('#pricefield11').val().replace(/,/g, '');
    var tax = $('#pricefield_tax').val().replace(/,/g, '');
    if(!tax) {
        tax = Math.floor(parseInt(base_price, 10) * 0.10);
    }
    var total_price = $('#pricefield13').val().replace(/,/g, '');

    // Map to hidden inputs
    $('#ItemType_hidden').val(ItemType);
    $('#ItemSize_hidden').val(sizeText);
    $('#ItemPCS_hidden').val(''); 
    
    $('#numberOf_hidden').val(qty);
    
    $('#total_price_hidden').val(base_price);
    $('#BeforeTax_hidden').val(base_price);
    $('#Tax_hidden').val(tax);
    $('#grandTotal_hidden').val(total_price);
    
    $('#example_hidden').val(example);
    $('#packing_hidden').val(packing);
    
    return true;
}
