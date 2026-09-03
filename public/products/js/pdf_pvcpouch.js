var isSafari = navigator.vendor && navigator.vendor.indexOf('Apple') > -1 &&
                   navigator.userAgent &&
                   navigator.userAgent.indexOf('CriOS') == -1 &&
                   navigator.userAgent.indexOf('FxiOS') == -1;
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
  var qty = $('#qty').val()
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
    var Item2 = "";
    var itemtype2 = "";
    var itemtype_size = "";
    var itemtype_colors = "";
    var example = "";
    var ai_file = "";
    var packing = "";
    var delivery = "";
    var back_print = "";
    var material = "";
    var back_print_price = 0;
    var itemtype_print = "";
    var Item2_print = "";
    var itemtype_print_price = 0;
    var itemtype_print_qty = 1;
    var parts = "";
    var parts_price = 0;
    var discount_quo = 0,ai_file_price = 0;
    var variation_price = 0;

    Item = $("input[name=ItemType]").val();

    delivery = "量産品製作期間：10営業日、配送期間：1～2日、";

    if($('#prd_fabric_color2').length && $('#prd_fabric_color2').is(":visible")){
      if($('input[name=pvc_color2]:checked').val() != undefined){
        itemtype_colors = "（表）"+ $('input[name=pvc_color1]:checked').val()+",（裏）"+$('input[name=pvc_color2]:checked').val();
			}
    }else{
      if($('#prd_fabric_color1').length && $('input[name=pvc_color1]:checked').val() != undefined && $('#prd_fabric_color1').is(":visible") ){
        itemtype_colors = $('input[name=pvc_color1]:checked').val();
      }
    }

    Item2 = "ジッパー色";
    Item2_print = $('input[name=pvc_zip]:checked').val();

    //C
    var example_price = 0;
    if($('input[name=pvc_sample]:checked').val()!=undefined){
      example = "あり";
      example_price = $('#prd_sample_price').val();
      delivery += "試作品製作期間：7営業日、";
    }else{
      example = "なし";
    }

    var packing_price = 0;
    if($('input[name=pvc_opp]:checked').val()!="あり"){
      packing = "なし"
    }else{
      packing = "あり"
      packing_price = 0;
    }

    if(!$('input[name=pvc_trace]').is(':checked')){
      ai_file = "なし"
    }else{
      ai_file = "あり"
      ai_file_price = formatMoney(trace_charge);
    }

    itemtype_print = $('input[name=ItemPrinting]:checked').val();
    if(itemtype_print == "印刷あり"){
      itemtype_print_price = parseInt(color_charged*$("input[name=ItemDesign]:checked").val());
      itemtype_print_qty = qty;
    }else{
      itemtype_print_price = "";
    }

    var item_variation = "";

    if($('input[name=ItemDesign]:checked').length){
      item_variation = $("input[name=ItemDesign]:checked").val()+"色"; 
      variation_price = formatMoney(Math.floor(4400));
    }
  
    var str = TextField7Value;
    // str = str.replace(/,/g, "");
    var item_price = Math.floor(parseInt(str, 10)/qty);

    var sum1_quo = formatMoney(TextField9Value);
    // var sum2_quo = $('#textfield9').val();
    // var sum3_quo = $('#textfield10').val();
    var sum2_quo = 0;
    var sum3_quo = tax;
    var sum4_quo = formatMoney(total);
    
    var remark = "";
    if($('input[name=ItemDesignRepeat]:checked').val() == 'はい'){
      remark = "過去と同じデザイン:"+$('input[name=design_no]').val();
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
        "Item2": Item2,
        "delivery": delivery,
        "itemtype2": itemtype2,
        "itemtype_size": itemtype_size,
        "itemtype_colors": itemtype_colors,
        "example": example,
        "qty": qty,
        "itemtype_print": itemtype_print,
        "itemtype_print_qty": itemtype_print_qty,
        "ai_file": ai_file,
        "packing": packing,
        "back_print": back_print,
        "Item2_print": Item2_print,
        "packing_qty": qty,
        "part": parts,
        "item_material": material,
        "item_variation": item_variation,
        //Price data
        "item_price": item_price,
        "sum1_quo": sum1_quo,
        "sum2_quo": sum2_quo,
        "sum3_quo": sum3_quo,
        "sum4_quo": sum4_quo,
        "discount": discount_quo,
        "example_price": example_price,
        "ai_file_price": ai_file_price,
        "itemtype_print_price": itemtype_print_price,
        "packing_price": packing_price,
        "variation_price": variation_price,
        "part_price": parts_price,
        "back_print_price": back_print_price,
        //Other 
        "filename": filename,
        "date": date,
        "remark": remark,
        "save": "yes"
      },
      success: function(data){
        
		if(data=="success"){
			if(isSafari){
				location.href = '/tcpdf/examples/pdf_export.php';
			  }else{
				var win = window.open('/tcpdf/examples/pdf_export.php', '_blank');
				win.focus();
				$('.loading').hide();
			  }
		}else{
			alert(data);
		}
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