var isSafari = navigator.vendor && navigator.vendor.indexOf('Apple') > -1 &&
navigator.userAgent &&
navigator.userAgent.indexOf('CriOS') == -1 &&
navigator.userAgent.indexOf('FxiOS') == -1;
// price for 10 days
var prd_10d_1side = {
	"size110":[
	{"num":1, "price":1944},
	{"num":2, "price":1512},
	{"num":3, "price":1368},
	{"num":4, "price":1296},
	{"num":5, "price":1253},
	{"num":6, "price":1188},
	{"num":7, "price":1142},
	{"num":8, "price":1106},
	{"num":9, "price":1079},
	{"num":10, "price":1040},
	{"num":20, "price":956},
	{"num":30, "price":926},
	{"num":40, "price":911},
	{"num":50, "price":898},
	{"num":60, "price":864},
	{"num":70, "price":840},
	{"num":80, "price":822},
	{"num":90, "price":807},
	{"num":100, "price":797}]
};

// price for 6 days
var prd_6d_1side = {
	"size110":[
	{"num":1, "price":2151},
	{"num":2, "price":1679},
	{"num":3, "price":1518},
	{"num":4, "price":1438},
	{"num":5, "price":1391},
	{"num":6, "price":1319},
	{"num":7, "price":1268},
	{"num":8, "price":1229},
	{"num":9, "price":1198},
	{"num":10, "price":1155},
	{"num":20, "price":1062},
	{"num":30, "price":1029},
	{"num":40, "price":1012},
	{"num":50, "price":998},
	{"num":60, "price":960},
	{"num":70, "price":933},
	{"num":80, "price":913},
	{"num":90, "price":897},
	{"num":100, "price":885}]
};

var paperPrice_obj = {
	"1side":[
	{"num":1, "price":1030},
	{"num":2, "price":530},
	{"num":3, "price":363},
	{"num":4, "price":280},
	{"num":5, "price":230},
	{"num":6, "price":197},
	{"num":7, "price":173},
	{"num":8, "price":155},
	{"num":9, "price":141},
	{"num":10, "price":130},
	{"num":20, "price":80},
	{"num":30, "price":63},
	{"num":40, "price":55},
	{"num":50, "price":50},
	{"num":60, "price":47},
	{"num":70, "price":44},
	{"num":80, "price":43},
	{"num":90, "price":41},
	{"num":100, "price":40},
	{"num":200, "price":26},
	{"num":300, "price":21},
	{"num":400, "price":18},
	{"num":500, "price":15},
	{"num":600, "price":15},
	{"num":700, "price":13},
	{"num":800, "price":13},
	{"num":900, "price":12},
	{"num":1000, "price":12}],
	"2side":[
	{"num":1, "price":1230},
	{"num":2, "price":630},
	{"num":3, "price":430},
	{"num":4, "price":330},
	{"num":5, "price":270},
	{"num":6, "price":230},
	{"num":7, "price":201},
	{"num":8, "price":180},
	{"num":9, "price":163},
	{"num":10, "price":150},
	{"num":20, "price":90},
	{"num":30, "price":70},
	{"num":40, "price":60},
	{"num":50, "price":54},
	{"num":60, "price":50},
	{"num":70, "price":47},
	{"num":80, "price":45},
	{"num":90, "price":43},
	{"num":100, "price":42},
	{"num":200, "price":27},
	{"num":300, "price":22},
	{"num":400, "price":19},
	{"num":500, "price":16},
	{"num":600, "price":16},
	{"num":700, "price":14},
	{"num":800, "price":14},
	{"num":900, "price":13},
	{"num":1000, "price":13}],
	"tmp":[
	{"num":1, "price":830},
	{"num":2, "price":430},
	{"num":3, "price":297},
	{"num":4, "price":230},
	{"num":5, "price":190},
	{"num":6, "price":163},
	{"num":7, "price":144},
	{"num":8, "price":130},
	{"num":9, "price":119},
	{"num":10, "price":110},
	{"num":20, "price":70},
	{"num":30, "price":57},
	{"num":40, "price":50},
	{"num":50, "price":46},
	{"num":60, "price":43},
	{"num":70, "price":41},
	{"num":80, "price":40},
	{"num":90, "price":39},
	{"num":100, "price":38},
	{"num":200, "price":25},
	{"num":300, "price":21},
	{"num":400, "price":18},
	{"num":500, "price":14},
	{"num":600, "price":14},
	{"num":700, "price":12},
	{"num":800, "price":12},
	{"num":900, "price":11},
	{"num":1000, "price":11}]
};

//Get object size
Object.size = function(obj) {
	var size = 0, key;
	for (key in obj) {
		if (obj.hasOwnProperty(key)) size++;
	}
	return size;
};

var paperPrice = 0;
var unit_price = 0;
var vat = 10;
var partPrice = 0;
var sub_total = 0;
var disPrice = 0;
var vat_price = 0;
var total = 0;

function validation(c) {
	if(check_val(c)){
		$('#step1').fadeOut('fast');
		$('#step2').fadeOut('fast');
		$('#step3').fadeOut('fast');
		$('#dot-step1').removeClass('active');
		$('#dot-step2').removeClass('active');
		$('#dot-step3').removeClass('active');

		switch($('#next').text()){
			case "オプション入力へ":
			if(c=='next' || c=='step2'){
				$('#back').fadeIn('slow');
				$('#next').text('金額計算・見積・注文へ');
				$('#step2').fadeIn('slow');
				$('#dot-step1').addClass('active');
				$('#dot-step2').addClass('active');
			}else if(c=='step3'){
				$('#next').text('金額計算・見積・注文へ');
				$('#step3').fadeIn('slow');
				$('#back').fadeOut('fast');
				$('#next').fadeOut('fast');
				$('#dot-step1').addClass('active');
				$('#dot-step2').addClass('active');
				$('#dot-step3').addClass('active');
			}
			break;
			case "金額計算・見積・注文へ":
			if(c=='next'){
				$('#step3').fadeIn('slow');
				$('#back').fadeOut('fast');
				$('#next').fadeOut('fast');
				$('#dot-step1').addClass('active');
				$('#dot-step2').addClass('active');
				$('#dot-step3').addClass('active');
			}else if(c=='back' || c=='step1'){
				$('#next').fadeIn('slow');
				$('#step1').fadeIn('slow');
				$('#next').text('オプション入力へ');
				$('#back').fadeOut('fast');
				$('#dot-step1').addClass('active');
				$('#next').attr('disabled',false);
			}else{
				$('#back').fadeIn('slow');
				$('#next').fadeIn('slow');
				$('#next').text('金額計算・見積・注文へ');
				$('#step2').fadeIn('slow');
				$('#dot-step1').addClass('active');
				$('#dot-step2').addClass('active');
			}
		}
		$(window).scrollTop($('.step-container').offset().top);
	}
}

function check_val(v) {
	if(v=='next'){
		if($('input[name=qty]').val()=="" || $('input[name=qty]').val()<=0 || $('input[name=qty]').val()>100){
			$('#qty-error').text('ご注文は1以上100以下でお願いします。');
			return false;
		}else{
			if($('input[name=qty]').val()<20){
				$('input[name=acy_sample][type="checkbox"]').prop('checked',false);
				$('input[name=acy_sample][type="checkbox"]').removeAttr( "checked" );
				$('#sample-error').text('試作品は20個以上のご注文から受付');
				$('input[name=acy_sample][type="checkbox"]').attr('disabled',true);
			}else{
				$('#sample-error').text('');
				$('input[name=acy_sample]').attr('disabled',false);
			}
			if($('input[name="acy_delivery"]:checked').val()=="6営業日" && $('input[name=qty]').val()>300){
				$('#qty-error').text('6営業日のご注文は300個以下となります');
				return false;
			}else{
				$('#qty-error').text('');
				cal_c();
				return true;
			}
		}
	}else{
		return true;
	}
}

function cal_c(v) {
	var prodc_day = $('input[name="acy_delivery"]:checked').val();
	var ItemSize = $('input[name="acy_size"]:checked').val();
	var paper = $('input[name="acy_paper_select"]:checked').val();
	var paper_color = $('input[name="acy_paper"]:checked').val();
	var sample = $('input[name="acy_sample"]:checked').val();
	var trace = $('input[name="acy_trace"]:checked').val();
	var qty = $('input[name="qty"]').val();
	var trace_price = 0;

	// Get paper data
	if(paper!=undefined){
		$('.paper-container').show();
		if(paper_color!=undefined){
			$('#sample-paper-pic').show();
			$('#sample-paper-pic').attr('src',"img/"+paper_color+".jpg?v=1.01");
			$('#sample-paper-name').text(paper_color);
			$('#next').attr('disabled',false);
			$('#back').attr('disabled',false);
			$('#prd_paper').text(paper_color);
			$('#paper-error').text('');
			if(paper_color=="paper-patternA-1"){
				var tmp_pp = paperPrice_obj['1side'];
			}else if(paper_color=="paper-patternA-2"){
				var tmp_pp = paperPrice_obj['2side'];
			}else{
				var tmp_pp = paperPrice_obj['tmp'];
			}

			// Get paper price
			for (var i = 0, iMax = tmp_pp.length; i < iMax; i++) {
				if (parseInt(qty) >= parseInt(tmp_pp[i].num)) {
					paperPrice = Math.floor(tmp_pp[i].price*(1+vat/100));
					continue;
				}
				break;
			}
		}else{
			$('#paper-error').text('台紙を選択してください。');
			$('#next').attr('disabled',true);
			$('#back').attr('disabled',true);
		}
	}else{
		$('.paper-container').hide();
		$('#sample-paper-pic').hide();
		$('#sample-paper-name').text('なし');
		$('#paper-error').text('');
		$('#next').attr('disabled',false);
		$('#back').attr('disabled',false);
		$('#prd_paper').text('なし');
		$('input[name="acy_paper_select"]').attr('checked',false);
		$('input[name="acy_paper"]').attr('checked',false);
		paperPrice = 0;
	}

	$('#sample-prd-prdt').text(prodc_day);
	$('#sample-prd-size').text(ItemSize+"mm.");
	$('#sample-prd-qty').text(qty);

	$('#prd_production').text(prodc_day);
	$('#prd_size').text(ItemSize+"mm");
	$('#prd_amount').text(qty);
	if(sample!=undefined){$('#prd_sample').text(sample);$('#sample-prd-samp').text(sample);}else{$('#prd_sample').text('なし');$('#sample-prd-samp').text('なし');}
	if(trace!=undefined){$('#prd_trace').text(trace);trace_price=0;$('#sample-prd-trace').text(trace);}else{$('#prd_trace').text('なし');$('#sample-prd-trace').text('なし');}

	// Get unit price
	for (var i = 0, iMax = get_price().length; i < iMax; i++) {
		if (parseInt(qty) >= parseInt(get_price()[i].num)) {
			unit_price = Math.floor(get_price()[i].price*(1+vat/100));
			continue;
		}
		break;
	}

	// passed
	sub_total = Math.floor(((unit_price*qty)+trace_price+(paperPrice*qty)));
	disPrice = Math.floor(parseInt(sub_total*0.05));

	vat_price = Math.floor((((unit_price*qty)*vat/(100+vat))+trace_price+((paperPrice*qty)*vat/(100+vat))-((disPrice*vat)/(100+vat))));
	// vat_price = vat_price - (vat_price*vat/100);

	total = Math.floor((parseInt(sub_total)-parseInt(disPrice)));

	$('#prd_paper_price').val((paperPrice*qty).toLocaleString("en"));
	$('#prd_sample_price').val('0');
	$('#prd_trace_price').val(trace_price.toLocaleString("en"));
	$('#prd_price').val((unit_price*qty).toLocaleString("en"));

	$('#prd_sub_total').val((sub_total).toLocaleString("en"));
	$('#vat').val(vat.toLocaleString("en"));
	$('#discount').val(disPrice.toLocaleString("en"));
	$('.prd_total').text(total.toLocaleString("en"));
	$('#prd_total').val(total.toLocaleString("en"));
}

function get_price() {
	// Setup price
	switch($('input[name="acy_delivery"]:checked').val()){
		case "10営業日":
		return prd_10d_1side['size110'];
		break;
		case "6営業日":
		return prd_6d_1side['size110'];
		break;
	}
}
// Set amount
var amount = ['1', '5', '10', '20', '30', '50', '70', '100'];
var amount_add = [];

$(function() {
	writePriceTable();cal_c();
});

function writePriceTable(plus) {
		// Get Delivery date
		var days = $('input[name=prc_delivery]:checked').val();

		if(days == "10"){
			var price = prd_10d_1side;
		}else if (days == "6") {
			var price = prd_6d_1side;
		}

		//Get customer add new qty
		if(plus == "add"){
			if($.inArray($('input[name=new_qty]').val(),amount)>=0){
				$('.add-error').text('この数量の製作単価は既に表示されております');
			}else{
				if($('input[name=new_qty]').val()<=0 || $('input[name=new_qty]').val()>100){
					$('.add-error').text('6-10営業日のご注文は100個以下となります');
				}else{
					$('.add-error').text('');
					amount.push($('input[name=new_qty]').val());
					amount.sort(function(a, b){return a-b});
					amount_add.push($('input[name=new_qty]').val());
				}
			}
		}else{
			amount = ['1', '5', '10', '20', '30', '50', '70', '100'];
			amount_add = [];
		}

		// setup table
		var text = "";
		$('.price-row').remove();

		// write table
		for(var i=0;i<amount.length;i++){
			if($.inArray( amount[i], amount_add )>=0){
				text+='<tr class="price-row added"><td>'+amount[i]+'</td>';
			}else{
				text+='<tr class="price-row"><td>'+amount[i]+'</td>';
			}
			for(var j=0;j<Object.size(price);j++){
				var tmp = Object.keys(price);
				for (var k = 0, iMax = price[tmp[j]].length; k < iMax; k++) {
					if (parseInt(amount[i]) >= parseInt(price[tmp[j]][k].num)) {
						var price1 = Math.floor(price[tmp[j]][k].price*(1+vat/100));
						continue;
					}
					break;
				}
				text+='<td>'+price1+'</td>'
			}
			text+='</tr>';
		}
		$('.tbl-price tbody').append(text);
	}

//PDF export
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
  var qty = $('input[name=qty]').val()
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
    var delivery = "";
    var parts = "";
    var paper = "なし";
    var Item_print = "";
    var itemtype_size = "";
    var example = "";
    var ai_file = "";
    var back_print = "";
    var paper_price = 0;
    //A
    Item = "アクリルスマホスタンド";

    delivery = $("input[name=acy_delivery]:checked").val();

    itemtype_size = $("input[name=acy_size]:checked").val()+"mm.";

    if($('input[name="acy_paper_select"]:checked').val()!=undefined){
    	paper = $('input[name="acy_paper"]:checked').val();
    	paper_price = paperPrice;
    }
    //C
    if($("input[name=acy_sample]:checked").val()!=undefined){
      $('#example').text('あり')
      example = "あり"
    }else{
      $('#example').text('なし')
      example = "なし"
    }

    //D
    if($("input[name=acy_trace]:checked").val()!=undefined){
      ai_file = "1"
    }else{
      ai_file = "0"
    }

    var item_price = unit_price;

   	var discount_quo = disPrice;

    var sum1_quo = sub_total.toLocaleString("en");
    // var sum2_quo = $('#prd_sub_total').val();
    // var sum3_quo = $('#vat').val();
    var sum2_quo = 0;
    var sum3_quo = vat_price;
    var sum4_quo = total.toLocaleString("en");

    var example_price = 0,ai_file_price = 0;

    var parts_price = 0;
    var delivery_price = 0;

    if(total < 11000){
    	delivery_price = 880;
    	sum4_quo = (total+delivery_price).toLocaleString("en");
    	sum3_quo = vat_price+(delivery_price*vat/(100+vat));
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
        "delivery": delivery,
        "itemtype_print": Item_print,
        "itemtype_size": itemtype_size,
        "example": example,
        "part": parts,
        "paper": paper,
        "ai_file": ai_file,
        "qty": qty,
        //Price data
        "item_price": item_price,
        "sum1_quo": sum1_quo,
        "sum2_quo": sum2_quo,
        "sum3_quo": sum3_quo,
        "sum4_quo": sum4_quo,
        "delivery_price": delivery_price,
        "discount": formatMoney(discount_quo),
        "example_price": example_price,
        "ai_file_price": ai_file_price,
        "part_price": parts_price,
        "paper_price": paper_price,
        //Other
        "filename": filename,
        "date": date,
        "save": "yes"
      },
      success: function(data){
        if(isSafari){
          location.href = '/tcpdf/examples/pdf_export.php';
        }else{
          var win = window.open('/tcpdf/examples/pdf_export.php', '_blank');
          win.focus();
          $('.loading').hide();
        }
      }
    });
}

function formatMoney(inum){
	if(inum=='0' || inum==''){
		return inum;
	}
	var s_inum=new String(inum);
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
}

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

function setzero() {
	validation('step1');$('#cus_detail').hide();
	$("#form")[0].reset();
	cal_c();
}
