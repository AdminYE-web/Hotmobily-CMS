var isSafari = navigator.vendor && navigator.vendor.indexOf('Apple') > -1 &&
                   navigator.userAgent &&
                   navigator.userAgent.indexOf('CriOS') == -1 &&
                   navigator.userAgent.indexOf('FxiOS') == -1;

function address_fn(){
  var str = $('#zip').val();
  if(str.length<7){
    $('#error').text('郵便番号を7桁で入力してください。');
  }else{
    $('#error').text('');
    $.ajax({
      url: "https://maps.googleapis.com/maps/api/geocode/json",
      dataType: 'json',
      crossDomain : true,
      type : 'get',
      data: {
        "address": str,
        "language": "ja",
        "sensor": false
      },
        success: function(data){
          if(data.status == "OK"){
          var obj = data.results[0].address_components;
            if (obj.length < 5) {
              $('#error').text('自動変換できませんでした。都道府県、以降の住所をご入力下さい');
              $('#address1').val("");
              $('#address2').val("");
              return false;
            }else{
              $('#address1').val(obj[3]['long_name']);
              $('#address2').val(obj[2]['long_name']+obj[1]['long_name']);
              $('#error').text('');
            }
          }else if(data.status == "ZERO_RESULTS"){
            $('#error').text('自動変換できませんでした。都道府県、以降の住所をご入力下さい');
            $('#address1').val("");
            $('#address2').val("");
          }
        }
      });
  }
}

function validate(tmp){
  if(tmp=="gcd"){
    var cus_name = $('#sname').val();
    var cus_lname = $('#fname').val();
    var crop_name = $('#Corp_Name').val();
    var zip = $('#zip').val();
    var address1 = $('#address1').val();
    var address2 = $('#address2').val();
    var address_street = $('#address_street').val();
    var tel = $('#tel').val();
    var comment = $('#comment').val();
  }else{
    var cus_name = "";
    var cus_lname = "";
    var crop_name = "";
    var zip = "";
    var address1 ="";
    var address2 = "";
    var address_street = "";
    var tel = "";
    var comment = "";
  }
  var n = new Date();
  var d = n.getDate();
  var m = n.getMonth();
  var y = n.getFullYear();
  var h = n.getHours();
  var min = n.getMinutes()
  var s = n.getSeconds();
  var qty = $('#no_of_order').val()
  var filename = "";
  m++;
  var date = y+"年"+m+"月"+d+"日";
  
    if(m<10||d<10){
      if(m<10&&d<10){
        filename = "HM_QT_"+y+"0"+m+"0"+d+"_"+h+min+s;
      }else if(m<10){
        filename = "HM_QT_"+y+"0"+m+d+"_"+h+min+s;
      }else{
        filename = "HM_QT_"+y+m+"0"+d+"_"+h+min+s;
      }
    }else{
      filename = "HM_QT_"+y+m+d+"_"+h+min+s;
    }

    var Item = "";
    var itemtype_size = "";
    var example = "";
    var packing = "";
    
    // Item Type
    var selectedItemType = $('input[name="ItemType_val"]:checked').length > 0 ? $('input[name="ItemType_val"]:checked').val() : $('input[name="ItemType"]:checked').val();
    if(selectedItemType === "i1"){
      Item = "リサイクル原糸マイクロファイバークロス (昇華転写片面印刷)";
    }else if(selectedItemType === "i2"){
      Item = "リサイクル原糸マイクロファイバークロス (昇華転写両面印刷)";
    }    
    
    // Size
    if($("#ItemSize").val() == "1"){
      itemtype_size = "150mmx150mm";
    }else if($("#ItemSize").val() == "2"){
      itemtype_size = "150mmx180mm";
    }
    
    // Example
    var example_price = 0;
    if(document.getElementById("example_have") && document.getElementById("example_have").checked){
      example = "必要";
      var str_ex = $('#pricefield8').val();
      if(str_ex) example_price = parseInt(str_ex.replace(/,/g, ""), 10);
    }else{
      example = "不要";
    }
    
    // Packing
    var packing_price = 0;
    if(document.getElementById("pack_have") && document.getElementById("pack_have").checked){
      packing = "必要";
      var str_pk = $('#pricefield9').val();
      if(str_pk) packing_price = parseInt(str_pk.replace(/,/g, ""), 10);
    }else{
      packing = "不要";
    }

    var delivery = "量産品製作期間：100個まで9営業日、300個まで11営業日、500個まで13営業日、1000個まで16営業日、3000個まで20営業日、5000個まで23営業日 配送期間：1～2日／試作品製作期間：8営業日";
    
    var str_price = $('#pricefield7').val();
    var item_price = 0;
    if(str_price){
        item_price = Math.floor(parseInt(str_price.replace(/,/g, ""), 10) / qty);
    }

    var discount_quo = $('#pricefield12').val();
    if(discount_quo) discount_quo = parseInt(discount_quo.replace(/,/g, ""), 10);

    var sum1_quo = $('#pricefield11').val();
    if(sum1_quo) sum1_quo = parseInt(sum1_quo.replace(/,/g, ""), 10);
    
    var sum2_quo = 0; // Tax is calculated cleanly
    
    var sum3_quo = $('#pricefield_tax').val();
    if(sum3_quo) {
        sum3_quo = parseInt(sum3_quo.replace(/,/g, ""), 10);
    } else {
        sum3_quo = Math.floor((sum1_quo - (discount_quo || 0)) * 0.10);
    }
    
    var sum4_quo = $('#pricefield13').val();
    if(sum4_quo) sum4_quo = parseInt(sum4_quo.replace(/,/g, ""), 10);

    var block_price = 0;
    var str_block = $('#pricefield5').val();
    if(str_block) block_price = parseInt(str_block.replace(/,/g, ""), 10);
    
    $.ajax({
      type: "POST",
      url: "/tcpdf/save_est.php",
      data: {
        "cus_name": cus_name,
        "cus_lname": cus_lname,
        "crop_name": crop_name,
        "zip": zip,
        "address1": address1,
        "address2": address2,
        "address_street": address_street,
        "tel": tel,
        "comment": comment,
        
        "filename": filename,
        "date": date,
        "Item": Item,
        "itemtype_size": itemtype_size,
        "qty": qty,
        "delivery": delivery,
        "example": example,
        "example_price": example_price,
        "packing": packing,
        "packing_price": packing_price,
        
        "item_price": item_price,
        "discount_quo": discount_quo,
        "sum1_quo": sum1_quo,
        "sum2_quo": sum2_quo,
        "sum3_quo": sum3_quo,
        "sum4_quo": sum4_quo,
        
        "basic_charge": block_price
      },
      dataType: "json",
      success: function(data){
         $('.loading').hide();
         var str = "https://hotmobily.jp/tcpdf/pdf_quotation.php?fname="+filename;
         window.location = str;
      },
      error: function (xhr, ajaxOptions, thrownError) {
        $('.loading').hide();
        console.log(xhr.status);
        console.log(thrownError);
      }
    });
}
