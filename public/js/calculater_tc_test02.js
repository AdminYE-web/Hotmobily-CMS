// Target Cup Calculator

var carabiner_price = 0;
var carabiner_print = 0;
var numUnitPrice = {
	// :: Strap data1 :: // standard
	"target":[
		{"num":100, "price":812},
		{"num":200, "price":663},
		{"num":300, "price":513},
		{"num":500, "price":450},
		{"num":1000, "price":252},
		{"num":3000, "price":159},
		{"num":5000, "price":140}
	],

	// :: Strap data2 :: // premuim
	"target_premium":[
		{"num":100, "price":975},
		{"num":200, "price":796},
		{"num":300, "price":616},
		{"num":500, "price":540},
		{"num":1000, "price":302},
		{"num":3000, "price":191},
		{"num":5000, "price":168}
	]
};

var numCarabinerPrice = {
	// :: Strap data1 :: // standard
	"carabiner_O":[
		{"num":100, "price":56},
		{"num":200, "price":52},
		{"num":300, "price":48},
		{"num":500, "price":41},
		{"num":1000, "price":35},
		{"num":3000, "price":28},
		{"num":5000, "price":27}
	],

	// :: Strap data2 :: // premuim
	"carabiner_M":[
		{"num":100, "price":149},
		{"num":200, "price":137},
		{"num":300, "price":124},
		{"num":500, "price":112},
		{"num":1000, "price":90},
		{"num":3000, "price":70},
		{"num":5000, "price":67}
	],

	// :: Strap data2 :: // premuim
	"carabiner_L":[
		{"num":100, "price":214},
		{"num":200, "price":196},
		{"num":300, "price":177},
		{"num":500, "price":161},
		{"num":1000, "price":128},
		{"num":3000, "price":99},
		{"num":5000, "price":94}
	],
};

var paperPrice_obj = {
	"1side":[
		{"num":100, "price":40},
		{"num":200, "price":26},
		{"num":300, "price":21},
		{"num":400, "price":18},
		{"num":500, "price":15},
		{"num":700, "price":13},
		{"num":900, "price":12},
	],
	"2side":[	
		{"num":100, "price":42},
		{"num":200, "price":27},
		{"num":300, "price":22},
		{"num":400, "price":19},
		{"num":500, "price":16},
		{"num":700, "price":14},
		{"num":900, "price":13},
	],
	"tmp":[		
		{"num":100, "price":38},
		{"num":200, "price":25},
		{"num":300, "price":21},
		{"num":400, "price":18},
		{"num":500, "price":14},
		{"num":700, "price":12},
		{"num":900, "price":11},
	]
};

// Form Button 
function valid_chk_btn(c) {
	if(check_val(c)){
		$('#step1').fadeOut('fast');
		$('#step2').fadeOut('fast');
		$('#step3').fadeOut('fast');
		$('#dot-step1').removeClass('active');
		$('#dot-step2').removeClass('active');
		$('#dot-step3').removeClass('active');

		switch($('#next').text()){
			case "アタッチメント・オプション入力へ":
			if(c=='next' || c=='step2'){
				$('#back').fadeIn('slow');	
				$('#next').text('金額計算・見積・注文へ');
				$('#next').blur();
				$('#step2').fadeIn('slow');
				$('#dot-step1').addClass('active');
				$('#dot-step2').addClass('active');
			}else if(c=='step3'){
				$('#next').text('金額計算・見積・注文へ');
				$('#next').blur();
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
				$('#next').text('アタッチメント・オプション入力へ');
				$('#next').blur();
				$('#back').fadeOut('fast');
				$('#dot-step1').addClass('active');
			}else{
				$('#back').fadeIn('slow');	
				$('#next').fadeIn('slow');	
				$('#next').text('金額計算・見積・注文へ');
				$('#next').blur();
				$('#step2').fadeIn('slow');
				$('#dot-step1').addClass('active');
				$('#dot-step2').addClass('active');
			}
		}
		$(window).scrollTop($('.step-container').offset().top);
	}
}

// Form Validation
function check_val(v) {
	var ItemType = $('input[name=ItemType]').val();
	if(v=='next'){
		setCarabiner();
		if(!validation_numberOf()){
			return false;
		}else{
			$('#err_numberOf_mess').hide();
			if($('input[name="ItemQA"]:checked').val()==undefined){
				$('#error_pcs').text('【必須】ご注文タイプをご選択ください');
				return false;
			}else if($('input[name="carabiner"]:checked').val()==undefined){
				$('#error_carabiner').text('【必須】カラビナの有無をご選択ください');
				return false;
			}else if($('input[name="carabiner"]:checked').val()=="1" && $('input[name="carabiner_type"]:checked').val()==undefined){
				$('#cbtp-error').text('【必須】カラビナ種別を選択してください。');
				return false;
			}else if($('input[name="carabiner"]:checked').val()=="1" && $('input[name="carabiner_type"]:checked').val()!=undefined && $('input[name="carabiner_color"]:checked').val()==undefined){
				$('#cbcl-error').text('【必須】カラビナ色を選択してください。');
				return false;
			}else if($('input[name="SilkPrint"]:checked').val()==undefined){
				$('#error_print').text('【必須】裏面シルク印刷の有無をご選択ください');
				return false;
			}else if($('input[name="coating"]').length && $('input[name=coating]:checked').val()==undefined){
				$('#error_coating').text('【必須】汚れ防止加工の有無をご選択ください');
				return false;
			}else{
				$('#error_pcs').text('');
				$('#error_carabiner').text('');
				$('#cbtp-error').text('');
				$('#cbcl-error').text('');
				$('#error_print').text('');
				if($('input[name=coating]').length){$('#error_coating').text('');}
			}
			setToInput();
			return true;
		}
	}else{
		return true;
	}
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

function table_priceW(items){
	var itemType = $('input[name=ItemType]:checked').val();
	var itemQA = $('input[name=ItemQA]:checked').val();
	var QA_val = "";
	if(itemQA=="プレミアム"){
		QA_val = "_premium";
	}
	
	if(item="carabiner"){
		if($('input[name=carabiner_type]:checked').val()=="高級版Mサイズ" || $('input[name=carabiner_type]:checked').val()=="高級版Lサイズ"){
			$('input[name=carabiner_print]').prop('disabled',false);
		}else{
			$('input[name=carabiner_print]:first').prop('checked',true);
			$('input[name=carabiner_print]').not(':first').prop('disabled',true);
		}
	}
}

// Carabiner Check
var cbcl_name = "";
function setCarabiner() {
	var carabiner_color = $('input[name="carabiner_color"]:checked').val();
	var carabiner_type = $('input[name="carabiner_type"]:checked').val();
	var carabiner = $('input[name="carabiner"]:checked').val();
	var cb_low = $('input[name="carabiner_color"][id="lowp"]');
	var cb_ls = $('input[name="carabiner_color"][id="lSize"]');
	var cb_ms = $('input[name="carabiner_color"][id="mSize"]');

	var carabiner_color_name = ["シルバー","ルビーレッド - 光沢","ブラック - 光沢","シルバー - 光沢","ルビーレッド - 艶消し","ブラック - 艶消し","シルバー - 艶消し"];

	if ($('input[name="carabiner_type"]:checked').val()!=undefined) {
		$('#prd_engrave').text($('input[name="carabiner_print"]:checked').val());
	} else {
		$('prd_engrave').text('-');
	}

	if (carabiner == "0") {
		$('#sample-carabiner-pic').hide();
		$('#sample-carabiner-name').text('なし');
		$('#prd_carabiner').text('なし');
		$('input[name="carabiner_color"]').prop('checked',false);
		$('input[name="carabiner_type"]').prop('checked',false);
		$('#prd_engrave').text('-');
	} else if (carabiner == "1") {
		if (carabiner_type == undefined) {
			$('#sample-carabiner-pic').hide();
			$('#sample-carabiner-name').text('なし');
			$('input[name="carabiner_color"]').prop('checked',false);
			cb_low.prop("disabled",false);
			cb_ms.prop("disabled",false);
			cb_ls.prop("disabled",false);
		} else if (carabiner_type != undefined) {
			if (carabiner_type == "廉価版カラビナ") {
				cb_low.prop("disabled",false);
				cb_ms.prop("disabled",true).prop('checked',false);
				cb_ls.prop("disabled",true).prop('checked',false);
				$('#prd_engrave').text('刻印なし');
			} else if (carabiner_type == "高級版Mサイズ") {
				cb_ms.prop("disabled",false);
				cb_ls.prop("disabled",true).prop('checked',false);
				cb_low.prop("disabled",true).prop('checked',false);
			} else if (carabiner_type == "高級版Lサイズ") {
				cb_ls.prop("disabled",false);
				cb_low.prop("disabled",true).prop('checked',false);
				cb_ms.prop("disabled",true).prop('checked',false);
			}

			if (carabiner_color == undefined) {
				$('#sample-carabiner-pic').hide();
				$('#sample-carabiner-name').text('なし');
				$('#prd_carabiner').text('なし');
				$('#prd_engrave').text('-');
			} else if (carabiner_color != undefined) {
				if ($('input[name="carabiner_color"]:checked').attr("id") == $('input[name="carabiner_type"]:checked').attr("id")) {
					$('#sample-carabiner-pic').show();
					$('#sample-carabiner-pic').attr('src','/products/carabiner/images/'+carabiner_color+'.jpg');
					
					if (carabiner_color == "carabiner-lowprice") {
						cbcl_name = carabiner_color_name[0];
					} else if (carabiner_color == "carabiner-m-gloss-ruby-red" || carabiner_color == "carabiner-l-gloss-ruby-red") {
						cbcl_name = carabiner_color_name[1];
					} else if (carabiner_color == "carabiner-m-gloss-black" || carabiner_color == "carabiner-l-gloss-black") {
						cbcl_name = carabiner_color_name[2];
					} else if (carabiner_color == "carabiner-m-gloss-silver" || carabiner_color == "carabiner-l-gloss-silver") {
						cbcl_name = carabiner_color_name[3];
					} else if (carabiner_color == "carabiner-m-matte-ruby-red" || carabiner_color == "carabiner-l-matte-ruby-red") {
						cbcl_name = carabiner_color_name[4];
					} else if (carabiner_color == "carabiner-m-matte-black" || carabiner_color == "carabiner-l-matte-black") {
						cbcl_name = carabiner_color_name[5];
					} else if (carabiner_color == "carabiner-m-matte-silver" || carabiner_color == "carabiner-l-matte-silver") {
						cbcl_name = carabiner_color_name[6];
					}

					$('#sample-carabiner-name').text(carabiner_type+' ('+cbcl_name+')');
					$('#prd_carabiner').text(carabiner_type+' ('+cbcl_name+')');
				} else {
					$('#sample-carabiner-pic').hide();
					$('#sample-carabiner-name').text('なし');
					$('#prd_carabiner').text('なし');
					$('#prd_engrave').text('-');
					$('input[name="carabiner_color"]').prop('checked',false);
				}
			}
		}
	} else {
		$('#sample-carabiner-pic').hide();
		$('#sample-carabiner-name').text('なし');
		$('#prd_carabiner').text('なし');
		$('#prd_engrave').text('-');
	}
}

// Paper / Order Type / Number of Order / Silkprinting / Coating / Prototype / Data Trace
function setToInput() {
	var paper = $('input[name="paper_select"]:checked').val();
	var paper_color = $('input[name="paper"]:checked').val();
	var vno_of_order = $('input[name="numberOf"]').val();
	var coating = $('input[name=coating]:checked').val();
	var order_type = $('input[name=ItemQA]:checked').val();
	var silk_print = $('input[name=SilkPrint]:checked').val();
	var vat = 10;

	// Order Type / Number of Order / Silk Printing
	$('#sample-prd-pcs').text(order_type);
	$('#prd_ItemPCS').text(order_type);
	$('#prd_qty').text(vno_of_order).val();
	$('#sample-prd-qty').text(vno_of_order).val();
	$('#sample-prd-screen').text(silk_print);
	$('#prd_silk_print').text(silk_print);

	// Coating / Antifouling
	if($('input[name=coating]').length && coating!=undefined){
		$('#sample-prd-coating').text(coating);
		$('#prd_coating').text(coating);
	}
	// Prototype
	if($('input[name=SendPrototype]:checked').val()!=undefined){
		$('#prd_SendPrototype').text('あり');
		$('#sample-prd-samp').text('あり');
	}else{
		$('#prd_SendPrototype').text('なし');
		$('#sample-prd-samp').text('なし');
	}
	//Data Trace
	if($('input[name=DeFormat]:checked').val()!=undefined){
		$('#prd_DeFormat').text('あり');
		$('#sample-prd-trace').text('あり');
	}else{
		$('#prd_DeFormat').text('なし');
		$('#sample-prd-trace').text('なし');
	}
	// Get paper data
	if(paper!=undefined){
		$('.paper-container').show();
		if(paper_color!=undefined){
			$('#sample-paper-pic').show();
			$('#sample-paper-pic').attr('src','/products/acrylic/img/'+paper_color+'.jpg');
			$('#sample-paper-name').text(paper_color);
			$('#next').attr('disabled',false);
			$('#back').attr('disabled',false);
			$('#prd_paper').text(paper_color);
			$('#paper-error').text('');
			$('#paper-error').css('display','none');
		}else{
			$('#paper-error').text('台紙を選択してください。');
			$('#paper-error').css('display','block');
			$('#next').attr('disabled',true);
			$('#back').attr('disabled',true);
		}
	}else{
		$('#sample-paper-pic').hide();
		$('#sample-paper-name').text('なし');
		$('.paper-container').hide();
		$('#paper-error').text('');
		$('#paper-error').css('display','none');
		$('#next').attr('disabled',false);
		$('#back').attr('disabled',false);
		$('#prd_paper').text('なし');
		$('input[name="paper"]').prop('checked',false);
	}
}

function format_number(number){
		if (number !=""){
			number = parseInt(number)+0;
		}
		return number;
	}

/*********** input validation ***********/
function validation(){

        var number_result = validation_numberOf();
        // var prototype_result = validation_prototype();


	if (number_result) {
		return false;}
	else{
        return true;
	}
}


function validation_numberOf() {
	var vNumberOfOder = document.getElementById('no_of_order');

	//エラー出力用id
	var err_number = document.getElementById('err_numberOf_mess');
	var mess = "";

	err_number.style.display = "";

	if ( isNaN(vNumberOfOder.value) ) {
		mess += "<font color='red'>半角数値以外が入力されています。</font>";
		err_number.innerHTML = mess;
		return false;
	} else if( vNumberOfOder.value == '' || vNumberOfOder.value < 100 ){
		mess += "<font color='red'>本数は100本以上で入力して下さい。</font>";
		err_number.innerHTML = mess;
		return false;
	} else if( vNumberOfOder.value > 50000 ){
		mess += "<font color='red'>本数は50000本以下で入力して下さい。50000以上のお客様は納期をメールにてお問い合わせ下さい。</font>";
		err_number.innerHTML = mess;
		return false;
        } else {
		err_number.style.display = "none";
		return true;
	}
}

/************** format *****************/
///check bt////
function check_agree(){

    if(document.form.agree[0].checked){
      document.form.cmdSubmit.disabled= false;
    } else {
      document.form.cmdSubmit.disabled= true;
    }

}

function hideField(el) {
	document.getElementById(el).style.display = "none";
        switch (el) {
            case 'design_upload_span': 		document.getElementById('design_upload').value = ""; break;
            case 'design_filename_span': 	document.getElementById('design_filename').value = ""; break;
        }
}

function showField(el) {
	document.getElementById(el).style.display = "";
}

function clearValue(){
	price_bracket = 0;
	proto_shipping_charge = 0;
	order_pcs = 0;
	unit_price = 0;
	strap_price = 0;
	before_tax = 0;
	tax = 0;
	total = 0;
	silkprint = 0;
	partPrice = 0;
	paperPrice = 0;
	DisPrice = 0;
	proto_charge = 0;
	coating_charge = 0;
	trace_charge = 0;
	print_charge = 0;

	$('#form')[0].reset();
	$('.cb_type').hide();
	$('.cb_color1').hide();
	$('.cb_color2').hide();
	$('.cb_color3').hide();
	$('input[name="ItemQA"]').removeAttr('checked');
	$('input[name="carabiner"]').removeAttr('checked');
	$('input[name="carabiner_type"]').removeAttr('checked');
	$('input[name="carabiner_color"]').removeAttr('checked');
	$('input[name="carabiner_print"]').removeAttr('checked');
	$('input[name="SilkPrint"]').removeAttr('checked');
	$('input[name="coating"]').removeAttr('checked');
	$('input[name="numberOf"]').val('');
	$('input[name="paper_select"]').removeAttr('checked');
	$('input[name="paper"]').removeAttr('checked');
	$('input[name="SendPrototype"]').removeAttr('checked');
	$('input[name="DeFormat"]').removeAttr('checked');
	setCarabiner();
	setToInput();
	calc();
	$('#pricefield7').val('');
	$('#pricefield7_n1').val('');
	$('#pricefield7_n2').val('');
	$('#pricefield10').val('');
	$('#pricefield15').val('');
	$('#pricefield14').val('');
	$('#pricefield8').val('');
	$('#pricefield9').val('');
	$('#pricefield11').val('');
	$('#pricefield12').val('');
	$('#pricefield13').val('');
	$('#sample-prd-pcs').text('-');
	$('#sample-prd-screen').text('-');
	$('#sample-prd-samp').text('-');
	$('#sample-prd-trace').text('-');
	$('#sample-prd-qty').text('-');
}

var unit_price = 0;
var basic_charge = 0;
var mold_charge = 0;
var proto_shipping_charge = 0;
var trace_charge = 0;
var order_pcs = 0;
var strap_price = 0;
var shipping_charge = 0;
var before_tax = 0;
var coating_charge = 0;
var paperPrice = 0;	
var total = 0;
var print_charge = 0;
var silk_print = 0;
var proto_charge = 0;
var vat = 10;
var tax = 0;

function calc() {
	var order_type	= $('input[name="ItemQA"]:checked').val();
	var qty			= $('input[name="numberOf"]').val();
	var select_cb	= $('input[name="carabiner"]:checked').val();
	var cb_type 	= $('input[name="carabiner_type"]:checked').val();
	var cb_print 	= $('input[name="carabiner_print"]:checked').val();

// Strap Price / Carabiner Price
	if(order_type=="スタンダード"){
		if(qty>=100 && qty<=199){
			strap_price = numUnitPrice["target"][0]["price"];
		}else if(qty>=200 && qty<=299) {
			strap_price = numUnitPrice["target"][1]["price"];
		}else if(qty>=300 && qty<=499) {
			strap_price = numUnitPrice["target"][2]["price"];
		}else if(qty>=500 && qty<=999) {
			strap_price = numUnitPrice["target"][3]["price"];
		}else if(qty>=1000 && qty<=2999) {
			strap_price = numUnitPrice["target"][4]["price"];
		}else if(qty>=3000 && qty<=4999) {
			strap_price = numUnitPrice["target"][5]["price"];
		}else if(qty>=5000) {
			strap_price = numUnitPrice["target"][6]["price"];
		}
	}else if(order_type=="プレミアム") {
		if(qty>=100 && qty<=199 ) {
			strap_price = numUnitPrice["target_premium"][0]["price"];
		}else if(qty>=200 && qty<=299) {
			strap_price = numUnitPrice["target_premium"][1]["price"];
		}else if(qty>=300 && qty<=499) {
			strap_price = numUnitPrice["target_premium"][2]["price"];
		}else if(qty>=500 && qty<=999) {
			strap_price = numUnitPrice["target_premium"][3]["price"];
		}else if(qty>=1000 && qty<=2999) {
			strap_price = numUnitPrice["target_premium"][4]["price"];
		}else if(qty>=3000 && qty<=4999) {
			strap_price = numUnitPrice["target_premium"][5]["price"];
		}else if(qty>=5000) {
			strap_price = numUnitPrice["target_premium"][6]["price"];
		}
	}

	if(select_cb=="1"){
		var carabiner_txt = "";
		carabiner_print = 0;
		carabiner_price = 0;

	//Get carabiner print price
		switch(cb_type){
			case '廉価版カラビナ':
				carabiner_txt = "carabiner_O";
				carabiner_fld = "CBO_";
				break;
			case '高級版Mサイズ':
				carabiner_txt = "carabiner_M";
				carabiner_fld = "CBM_";
				if(cb_print == "刻印あり（表）") {carabiner_print = 20;}
				else if(cb_print == "刻印あり（表+裏）") {carabiner_print = 30;}
				break;

			case '高級版Lサイズ':
			carabiner_txt = "carabiner_L";
			carabiner_fld = "CBL_";
			if(cb_print == "刻印あり（表）") {carabiner_print = 20;}
			else if(cb_print == "刻印あり（表+裏）") {carabiner_print = 30;}
			break;
		}

	//Get carabiner price
		if(qty>=100 && qty<=199 ) {
			carabiner_price = numCarabinerPrice[carabiner_txt][0]["price"];
		}else if(qty>=200 && qty<=299 ) {
			carabiner_price = numCarabinerPrice[carabiner_txt][1]["price"];
		}else if(qty>=300 && qty<=499 ) {
			carabiner_price = numCarabinerPrice[carabiner_txt][2]["price"];
		}else if(qty>=500 && qty<=999 ) {
			carabiner_price = numCarabinerPrice[carabiner_txt][3]["price"];
		}else if(qty>=1000 && qty<=2999 ) {
			carabiner_price = numCarabinerPrice[carabiner_txt][4]["price"];
		}else if(qty>=3000 && qty<=4999 ) {
			carabiner_price = numCarabinerPrice[carabiner_txt][5]["price"];
		}else if(qty>=5000) {
			carabiner_price = numCarabinerPrice[carabiner_txt][6]["price"];
		}

	}else{
			carabiner_print = 0;
			carabiner_price = 0;
	}

	strap_price 	= Math.floor(strap_price*(1+vat/100)) * qty; 
	carabiner_price = Math.floor(carabiner_price*(1+vat/100)) * qty; 
	carabiner_print = Math.floor(carabiner_print*(1+vat/100)) * qty; 

// Paper Price
	var paper 		= $('input[name="paper_select"]:checked').val();
	var paper_color = $('input[name="paper"]:checked').val();
	var tmp_pp		= "";
	
	if(paper!=undefined && paper_color!=undefined) {
		if(paper_color=="paper-patternA-1"){
			tmp_pp = "1side";
		}else if(paper_color=="paper-patternA-2"){
			tmp_pp = "2side";
		}else{
			tmp_pp = "tmp";
		}

		if(qty>=100 && qty<=199){
			paperPrice = paperPrice_obj[tmp_pp][0]["price"];
		}else if(qty>=200 && qty<=299){
			paperPrice = paperPrice_obj[tmp_pp][1]["price"];
		}else if(qty>=300 && qty<=399){
			paperPrice = paperPrice_obj[tmp_pp][2]["price"];
		}else if(qty>=400 && qty<=499){
			paperPrice = paperPrice_obj[tmp_pp][3]["price"];
		}else if(qty>=500 && qty<=699){
			paperPrice = paperPrice_obj[tmp_pp][4]["price"];
		}else if(qty>=700 && qty<=899){
			paperPrice = paperPrice_obj[tmp_pp][5]["price"];
		}else if(qty>=900){
			paperPrice = paperPrice_obj[tmp_pp][6]["price"];
		}
	} else {paperPrice = 0;}

	paperPrice = Math.floor(paperPrice*(1+vat/100)) * qty;

//Coating Price
	var coating = $('input[name="coating"]:checked').val();

	if(coating == "汚れ防止加工あり"){
		coating_charge = Math.floor(70*(1+vat/100)) * qty;
	} else {coating_charge = 0;}

// Prototype / DataTrace / SilkPrint
	var send_proto  = $('input[name="SendPrototype"]:checked').val();
	var data_file	= $('input[name="DeFormat"]:checked').val();
	var print_umu 	= $('input[name="SilkPrint"]:checked').val();

	if(order_type == "スタンダード"){
		if(send_proto == "あり"){
			proto_charge = Math.floor(8000*(1+vat/100));
		}
		if(data_file == "あり"){
			trace_charge = Math.floor(8000*(1+vat/100));
		}
		if(print_umu == "シルク印刷あり"){
			print_charge = Math.floor((qty * 20)*(1+vat/100));
		}
	} else if(order_type == "プレミアム"){
		if(send_proto == "あり"){
			proto_charge = 0;
		}
		if(data_file == "あり"){
			trace_charge = 0;
		}
		if(print_umu == "シルク印刷あり"){
			print_charge = 0;
		}
	}

	before_tax = strap_price + carabiner_price + carabiner_print + coating_charge + paperPrice + proto_charge + trace_charge + print_charge ;

	tax = Math.floor(Math.floor(strap_price*vat/(100+vat)) + Math.floor(carabiner_price*vat/(100+vat)) + 
		Math.floor(carabiner_print*vat/(100+vat)) + Math.floor(coating_charge*vat/(100+vat)) + 
		Math.floor(proto_charge*vat/(100+vat)) + Math.floor(trace_charge*vat/(100+vat)) + 
		Math.floor(print_charge*vat/(100+vat)) + Math.floor(paperPrice*vat/(100+vat)));
	// tax = tax - Math.floor(tax*vat/100); // not used

	var disc_price =  0;

	total = before_tax - disc_price;

	document.getElementById('pricefield7').value = formatMoney(strap_price);
	document.getElementById('pricefield7_n1').value = formatMoney(carabiner_price);
	document.getElementById('pricefield7_n2').value = formatMoney(carabiner_print);
	document.getElementById('pricefield8').value = formatMoney(proto_charge);
	document.getElementById('pricefield9').value = formatMoney(trace_charge);
	document.getElementById('pricefield10').value = formatMoney(print_charge);
	document.getElementById('pricefield11').value = formatMoney(before_tax);
	document.getElementById('pricefield12').value = formatMoney(disc_price);
	document.getElementById('pricefield13').value = formatMoney(total);
	document.getElementById('pricefield14').value = formatMoney(paperPrice);
	document.getElementById('pricefield15').value = formatMoney(coating_charge);
	$('.prd_total').text(formatMoney(total));

//Check Price
	console.log('before_tax: ' + before_tax);
	console.log('tax: ' + tax);
}