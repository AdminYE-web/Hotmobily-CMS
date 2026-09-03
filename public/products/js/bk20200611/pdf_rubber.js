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
            if (obj.length < 4) {
              $('#error').text('自動変換できませんでした。都道府県、以降の住所をご入力下さい');
              $('#address1').val("");
              $('#address2').val("");
              return false;
            }else{
              $('#address1').val(obj[2]['long_name']);
              $('#address2').val(obj[1]['long_name']);
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
          if (obj.length < 4) {
            $('#error').text('自動変換できませんでした。都道府県、以降の住所をご入力下さい');
            $('#address1').val("");
            $('#address2').val("");
            return false;
          }else{
            $('#address1_2').val(obj[2]['long_name']);
            $('#address2_2').val(obj[1]['long_name']);
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
    var fax = "";
    var comment = "";
  }
  
  var n = new Date();
  var d = n.getDate();
  var m = n.getMonth();
  var y = n.getFullYear();
  var h = n.getHours();
  var min = n.getMinutes()
  var s = n.getSeconds();
  if(screen.width<=768){
    if(document.querySelector("input[name=numberOf]:checked").value=='0'){
      var qty = document.getElementById('no_of_order_other').value;
    }else{
      var qty = document.querySelector("input[name=numberOf]:checked").value;
    }
  }else{
    var qty = document.getElementById('no_of_order').value;
  }
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

    var itemtype2 = "";
    var example = "";
    var ai_file = "";
    var back_print = "";
    //A
    var Item = $("input[name='ItemType']").val();

    //B
    if(document.getElementsByName("ItemPCS")[0].checked){
      $('#ItemType2').text('スタンダード（12色以内）')
      itemtype2 = "スタンダード（12色以内）"
    }else if(document.getElementsByName("ItemPCS")[1].checked){
      $('#ItemType2').text('プレミアム（15色以内）')
      itemtype2 = "プレミアム（15色以内）"
    }

    //C
    if(document.getElementsByName("SendPrototype")[0].checked){
      $('#example').text('なし')
      example = "なし"
    }else if(document.getElementsByName("SendPrototype")[1].checked){
      $('#example').text('あり')
      example = "あり"
    }

    //D
    if(document.getElementsByName("DeFormat")[0].checked){
      ai_file = "0"
    }else if(document.getElementsByName("DeFormat")[1].checked){
      ai_file = "1"
    }
    //E
    if(document.getElementsByName("silk_print")[0].checked){
      back_print = "0"
    }else if(document.getElementsByName("silk_print")[1].checked){
      back_print = "1"
    }
    
    var str = $('#textfield7').val();
    str = str.replace(/,/g, "");
    var item_price = parseInt(str, 10)/qty;

    var sum1_quo = $('#textfield9').val();
    var sum2_quo = $('#textfield9').val();
    var sum3_quo = $('#textfield10').val();
    var sum4_quo = $('#textfield11').val();
    var example_price = 0,ai_file_price = 0,back_print_price = 0;

    if(example == "あり"){
      example_price = $('#textfield3').val();
    }
    if(ai_file == "1"){
      ai_file_price = $('#textfield4').val();
    }
    if(back_print == "1"){
      back_print_price = $('#textfield13').val();
    }

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
        "ai_file": ai_file,
        "back_print": back_print,
        "qty": qty,
        //Price data
        "item_price": item_price,
        "sum1_quo": sum1_quo,
        "sum2_quo": sum2_quo,
        "sum3_quo": sum3_quo,
        "sum4_quo": sum4_quo,
        "example_price": example_price,
        "ai_file_price": ai_file_price,
        "back_print_price": back_print_price,
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