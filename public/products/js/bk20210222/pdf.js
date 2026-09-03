function address_fn(){
  // alert($('#zip').val());
  var str = $('#zip').val();
  // var res = str.replace("-", "");
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
        "key": "AIzaSyDMDXPiN_mBRVSoneHiivkOAMdHkSg8ZFw",
        "address": str,
        "language": "ja",
        "sensor": false
      },
        success: function(data){
          if(data.status == "OK"){
          // APIのレスポンスから住所情報を取得
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
          console.log(data);
        }
      });
  }
}
function address_fn2(){
  // alert($('#zip').val());
  var str = $('#zip2').val();
  // var res = str.replace("-", "");
  if(str.length<7){
    $('#error2').text('郵便番号を7桁で入力してください。');
  }else{
    $('#error2').text('');
  $.ajax({
        url: "https://maps.googleapis.com/maps/api/geocode/json",
        dataType: 'json',
        crossDomain : true,
        type : 'get',
        data: {
          "key": "AIzaSyDMDXPiN_mBRVSoneHiivkOAMdHkSg8ZFw",
          "address": str,
          "language": "ja",
          "sensor": false
        },
        success: function(data){
          if(data.status == "OK"){
          // APIのレスポンスから住所情報を取得
          var obj = data.results[0].address_components;
          if (obj.length < 5) {
            $('#error').text('自動変換できませんでした。都道府県、以降の住所をご入力下さい');
            $('#address1').val("");
            $('#address2').val("");
            return false;
          }else{
            $('#address1_2').val(obj[3]['long_name']);
            $('#address2_2').val(obj[2]['long_name']+obj[1]['long_name']);
            $('#error2').text('');
          }
          }else if(data.status == "ZERO_RESULTS"){
            $('#error2').text('自動変換できませんでした。都道府県、以降の住所をご入力下さい');
            $('#address1_2').val("");
            $('#address2_2').val("");
          }
          console.log(data);
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
    var itemtype2 = "";
    var example = "";
    var ai_file = "";
    var back_print = "";
    //A
    if(document.getElementsByName("ItemType")[0].checked){
      Item = "タイプA"
    }else if(document.getElementsByName("ItemType")[1].checked){
      Item = "タイプB"
    }else if(document.getElementsByName("ItemType")[2].checked){
      Item = "タイプC"
    }else if(document.getElementsByName("ItemType")[3].checked){
      Item = "タイプD"
    }else if(document.getElementsByName("ItemType")[4].checked){
      Item = "タイプE"
    }
    //B
    if($("#ItemSize").val() == "40"){
      itemtype2 = "40mmX40mm"
    }else if($("#ItemSize").val() == "50"){
      itemtype2 = "50mmX50mm"
    }else if($("#ItemSize").val() == "60"){
      itemtype2 = "60mmX60mm"
    }else if($("#ItemSize").val() == "70"){
      itemtype2 = "70mmX70mm"
    }
    //C
    var example_price = 0; 
    if(document.getElementsByName("example")[0].checked){
      example = "不要"
    }else if(document.getElementsByName("example")[1].checked){
      example = "必要"
      example_price = parseFloat($('#pricefield8').val().replace(',', ''));
    }

    var str = $('#pricefield7').val();
    str = str.replace(/,/g, "");
    var item_price = parseInt(str, 10)/qty;

    var sum1_quo = $('#pricefield11').val();
    var sum2_quo = $('#pricefield11').val();
    var sum3_quo = $('#pricefield12').val();
    var sum4_quo = $('#pricefield13').val();

    $.ajax({
      type: "POST",
      url: "/tcpdf/save_est.php",
      data: {
        //Customer data
        "cus_name": cus_name,
        "cus_lname": cus_lname,
        "crop_name": crop_name,
        "zip": zip,
        "address1": address1,
        "address2": address2,
        "address_street": address_street,
        "tel": tel,
        "comment": comment,
        //Items data
        "Item": Item,
        "itemtype2": itemtype2,
        "example": example,
        "qty": qty,
        //Price data
        "item_price": item_price,
        "sum1_quo": sum1_quo,
        "sum2_quo": sum2_quo,
        "sum3_quo": sum3_quo,
        "sum4_quo": sum4_quo,
        "example_price": example_price,
        //Other 
        "filename": filename,
        "date": date,
        "save": "yes"
      },
      success: function(data){
        var win = window.open('/tcpdf/examples/pdf_export.php', '_blank');
        win.focus();
        $('.loading').hide();
      }
    });
}
function formatMoney2(inum){
  if(inum=='0' || inum==''){
    return inum;
  }
  var s_inum=new String(inum);
  if(s_inum.indexOf("-")==-1){
    var s_inumInt=s_inum.split(".",s_inum);
    var l_inum=s_inumInt[0].length;
    var n_inum="";
    for(i=0;i<l_inum;i++){
      if(parseInt(l_inum-i)%3==0){
        if(i==0){
          n_inum+=s_inum.charAt(i);
        }else{
          n_inum+=","+s_inum.charAt(i);
        }
      }else{
        n_inum+=s_inum.charAt(i);
      }
    }
    if(s_inumInt[1]!=undefined){
      n_inum+="."+s_inumInt[1];
    }
    return n_inum;
  }else{
    return s_inum;
  }
}

function validate2(tmp){
  if(tmp=="gcd"){
    var cus_name = $('#sname').val();
    var cus_lname = $('#fname').val();
    var crop_name = $('#Corp_Name').val();
    var zip = $('#zip').val();
    var address1 = $('#address1').val();
    var address2 = $('#address2').val();
    var address_street = $('#address_street').val();
    var tel = $('#tel').val();
    var fax = $('#fax').val();
  }else{
    var cus_name = "";
    var cus_lname = "";
    var crop_name = "";
    var zip = "";
    var address1 ="";
    var address2 = "";
    var address_street = "";
    var tel = "";
    var fax = "";
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
  var date = y+"年"+m+"月"+d+"日";
  m++;
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
    var itemtype_print = "";
    var example = "";
    var p1 = "";
    var itemtype_print_price = 0;
    var itemtype_print_qty = 0;
    //A
    switch($('#ItemType').val()){
      case 'ec1': Item = "円(EC-1)";break;
      case 'ec2': Item = "円(EC-2)";break;
      case 'ec3': Item = "正方形(EC-3)";break;
      case 'ec4': Item = "四角(EC-4)";break;
      case 'ec5': Item = "楕円(EC-5)";break;
      case 'ec6': Item = "ハート(EC-6)";break;
      case 'ec7': Item = "星(EC-7)";break;
      case 'ec8': Item = "ﾕﾆﾎｰﾑ(EC-8)";break;
    }
    //B
    if(document.getElementsByName("ItemPrint")[0].checked){
      switch($("#ItemColor").val()){
        case "0": p1="シルク印刷1色";itemtype_print_qty=1;itemtype_print_price="6,000"; break;
        case "1": p1="シルク印刷2色";itemtype_print_qty=2;itemtype_print_price="6,000"; break;
        case "2": p1="シルク印刷3色";itemtype_print_qty=3;itemtype_print_price="6,000"; break;
        case "3": p1="シルク印刷4色";itemtype_print_qty=4;itemtype_print_price="6,000"; break;
        case "4": p1="シルク印刷5色";itemtype_print_qty=5;itemtype_print_price="6,000"; break;
        case "5": p1="シルク印刷6色";itemtype_print_qty=6;itemtype_print_price="6,000"; break;
        case "6": p1="シルク印刷7色";itemtype_print_qty=7;itemtype_print_price="6,000"; break;
      }
      itemtype_print = 'シルク印刷('+p1+')';
    }else{
      itemtype_print = "オフセット印刷";
      itemtype_print_price="65,000";
      itemtype_print_qty=1;
    }
    //C
    var example_price = 0;
    if(document.getElementsByName("ItemSpeed")[0].checked){
      example = "あり"
      example_price = parseFloat($('#pricefield15').val().replace(',', ''));
    }else if(document.getElementsByName("ItemSpeed")[1].checked){
      example = "なし"
    }

    var str = $('#pricefield7').val();
    str = str.replace(/,/g, "");
    var item_price = parseInt(str, 10)/qty;

    var sum1_quo = $('#pricefield11').val();
    var sum2_quo = $('#pricefield11').val();
    var sum3_quo = $('#pricefield12').val();
    var sum4_quo = $('#pricefield13').val();
    
    $.ajax({
      type: "POST",
      url: "/tcpdf/save_est.php",
      data: {
        //Customer data
        "cus_name": cus_name,
        "cus_lname": cus_lname,
        "crop_name": crop_name,
        "zip": zip,
        "address1": address1,
        "address2": address2,
        "address_street": address_street,
        "tel": tel,
        "fax": fax,
        //Items data
        "Item": Item,
        "example": example,
        "qty": qty,
        "itemtype_print": itemtype_print,
        "itemtype_print_qty": itemtype_print_qty,
        //Price data
        "item_price": item_price,
        "sum1_quo": sum1_quo,
        "sum2_quo": sum2_quo,
        "sum3_quo": sum3_quo,
        "sum4_quo": sum4_quo,
        "example_price": example_price,
        "itemtype_print_price": itemtype_print_price,
        //Other 
        "filename": filename,
        "date": date,
        "save": "yes"
      },
      success: function(data){
        var win = window.open('/tcpdf/examples/pdf_export.php', '_blank');
        win.focus();
        $('.loading').hide();
      }
    });
}