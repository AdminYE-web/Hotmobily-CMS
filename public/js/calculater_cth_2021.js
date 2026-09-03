	var i1_std_1 = [210,160,130,100,80,70];
	var i1_std_2 = [220,170,140,110,90,80];
	var i1_prm_1 = [220,170,140,110,90,80];
	var i1_prm_2 = [230,180,150,120,100,90];

	var i2_std_1 = [230,180,150,120,100,90];
	var i2_std_2 = [240,190,160,130,110,100];
	var i2_prm_1 = [240,190,160,130,110,100];
	var i2_prm_2 = [250,200,170,140,120,110];

	var i3_std_1 = [0,100,90,70,50,40];
	var i3_std_2 = [0,110,100,90,60,50];
	var i3_prm_1 = [0,110,100,90,60,50];
	var i3_prm_2 = [0,120,110,100,70,60];

	var i4_std_1 = [160,110,100,80,60,50];
	var i4_std_2 = [170,120,110,90,70,60];
	var i4_prm_1 = [170,120,110,90,70,60];
	var i4_prm_2 = [180,130,120,100,80,70];
	
	var unit_price = 0;

	function valid_chk_btn(c) {
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
					$('#next').text('オプション入力へ');
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

	function check_val(v) {
		var ItemType = $('input[name=ItemType]').val();


		switch($('input[name=cth_type]:checked').val()){
			case "昇華転写片面印刷":$('#type-part-pic').attr('src','img/cth1.jpg');break;
			case "昇華転写両面印刷":$('#type-part-pic').attr('src','img/cth2.jpg');break;
			case "1色印刷（シルクスクリーン）":$('#type-part-pic').attr('src','img/cth3.jpg');break;
			case "エンボス加工":$('#type-part-pic').attr('src','img/cth4.jpg');break;
		}
		if(v=='next'){
			if(!validation_numberOf()){
				return false;
			}else{
				setToInput();
				return true;
			}
		}else{
			setToInput();
			return true;
		}
	}

	function validation_numberOf() {
		//エラー出力用id
		var err_number = document.getElementById('err_numberOf_mess');
		var mess = "";

		err_number.style.display = "";

		//入力値
		var vNumberOfOder = document.getElementById('qty');
		
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
		}else if($('input[name=cth_type]:checked').val()=="1色印刷（シルクスクリーン）" && vNumberOfOder.value < 300){
			mess += "<font color='red'>本数は300本以上で入力して下さい。</font>";
			err_number.innerHTML = mess;
			return false;
		}else {
			err_number.style.display = "none";
			return true;
		}
	}

	var order_pcs = 0;
	var unit_price = 0;
	var pcs_price = 0;
	var before_tax = 0;
	var tax = 0;
	var vat = 10;
	var total = 0;
	var silkprint = 0;
	var TextField7Value = 0;
	var TextField9Value = 0;
	var DisPrice = 0;
	var proto_charge = 0;
	var opp_price = 0;

	function setToInput(){
		clearValue();
		var vno_of_order = document.getElementById('qty');

		if(vno_of_order.value != "" ) {

		// strap
		if ($('input[name=cth_type]:checked').val() == "昇華転写片面印刷") {
			if ($('input[name=cth_option]:checked').val() == "スタンダード") {
				if ($('input[name=cth_size]:checked').val() == "150") {
					if (vno_of_order.value >= 5000) order_pcs = i1_std_1[5];
					else if (vno_of_order.value >= 3000) order_pcs = i1_std_1[4];
					else if (vno_of_order.value >= 1000) order_pcs = i1_std_1[3];
					else if (vno_of_order.value >= 500) order_pcs = i1_std_1[2];
					else if (vno_of_order.value >= 300) order_pcs = i1_std_1[1];
					else if (vno_of_order.value >= 100) order_pcs = i1_std_1[0];
				}else if($('input[name=cth_size]:checked').val() == "180"){
					if (vno_of_order.value >= 5000) order_pcs = i1_std_2[5];
					else if (vno_of_order.value >= 3000) order_pcs = i1_std_2[4];
					else if (vno_of_order.value >= 1000) order_pcs = i1_std_2[3];
					else if (vno_of_order.value >= 500) order_pcs = i1_std_2[2];
					else if (vno_of_order.value >= 300) order_pcs = i1_std_2[1];
					else if (vno_of_order.value >= 100) order_pcs = i1_std_2[0];
				}
			}else if($('input[name=cth_option]:checked').val() == "プレミアム"){
				if ($('input[name=cth_size]:checked').val() == "150") {
					if (vno_of_order.value >= 5000) order_pcs = i1_prm_1[5];
					else if (vno_of_order.value >= 3000) order_pcs = i1_prm_1[4];
					else if (vno_of_order.value >= 1000) order_pcs = i1_prm_1[3];
					else if (vno_of_order.value >= 500) order_pcs = i1_prm_1[2];
					else if (vno_of_order.value >= 300) order_pcs = i1_prm_1[1];
					else if (vno_of_order.value >= 100) order_pcs = i1_prm_1[0];
				}else if($('input[name=cth_size]:checked').val() == "180"){
					if (vno_of_order.value >= 5000) order_pcs = i1_prm_2[5];
					else if (vno_of_order.value >= 3000) order_pcs = i1_prm_2[4];
					else if (vno_of_order.value >= 1000) order_pcs = i1_prm_2[3];
					else if (vno_of_order.value >= 500) order_pcs = i1_prm_2[2];
					else if (vno_of_order.value >= 300) order_pcs = i1_prm_2[1];
					else if (vno_of_order.value >= 100) order_pcs = i1_prm_2[0];
				}
			}
		}

		if ($('input[name=cth_type]:checked').val() == "昇華転写両面印刷") {
			if ($('input[name=cth_option]:checked').val() == "スタンダード") {
				if ($('input[name=cth_size]:checked').val() == "150") {
					if (vno_of_order.value >= 5000) order_pcs = i2_std_1[5];
					else if (vno_of_order.value >= 3000) order_pcs = i2_std_1[4];
					else if (vno_of_order.value >= 1000) order_pcs = i2_std_1[3];
					else if (vno_of_order.value >= 500) order_pcs = i2_std_1[2];
					else if (vno_of_order.value >= 300) order_pcs = i2_std_1[1];
					else if (vno_of_order.value >= 100) order_pcs = i2_std_1[0];
				}else if($('input[name=cth_size]:checked').val() == "180"){
					if (vno_of_order.value >= 5000) order_pcs = i2_std_2[5];
					else if (vno_of_order.value >= 3000) order_pcs = i2_std_2[4];
					else if (vno_of_order.value >= 1000) order_pcs = i2_std_2[3];
					else if (vno_of_order.value >= 500) order_pcs = i2_std_2[2];
					else if (vno_of_order.value >= 300) order_pcs = i2_std_2[1];
					else if (vno_of_order.value >= 100) order_pcs = i2_std_2[0];
				}
			}else if($('input[name=cth_option]:checked').val() == "プレミアム"){
				if ($('input[name=cth_size]:checked').val() == "150") {
					if (vno_of_order.value >= 5000) order_pcs = i2_prm_1[5];
					else if (vno_of_order.value >= 3000) order_pcs = i2_prm_1[4];
					else if (vno_of_order.value >= 1000) order_pcs = i2_prm_1[3];
					else if (vno_of_order.value >= 500) order_pcs = i2_prm_1[2];
					else if (vno_of_order.value >= 300) order_pcs = i2_prm_1[1];
					else if (vno_of_order.value >= 100) order_pcs = i2_prm_1[0];
				}else if($('input[name=cth_size]:checked').val() == "180"){
					if (vno_of_order.value >= 5000) order_pcs = i2_prm_2[5];
					else if (vno_of_order.value >= 3000) order_pcs = i2_prm_2[4];
					else if (vno_of_order.value >= 1000) order_pcs = i2_prm_2[3];
					else if (vno_of_order.value >= 500) order_pcs = i2_prm_2[2];
					else if (vno_of_order.value >= 300) order_pcs = i2_prm_2[1];
					else if (vno_of_order.value >= 100) order_pcs = i2_prm_2[0];
				}
			}
		}

		if ($('input[name=cth_type]:checked').val() == "1色印刷（シルクスクリーン）") {
			if ($('input[name=cth_option]:checked').val() == "スタンダード") {
				if ($('input[name=cth_size]:checked').val() == "150") {
					if (vno_of_order.value >= 5000) order_pcs = i3_std_1[5];
					else if (vno_of_order.value >= 3000) order_pcs = i3_std_1[4];
					else if (vno_of_order.value >= 1000) order_pcs = i3_std_1[3];
					else if (vno_of_order.value >= 500) order_pcs = i3_std_1[2];
					else if (vno_of_order.value >= 300) order_pcs = i3_std_1[1];
					else if (vno_of_order.value >= 100) order_pcs = i3_std_1[0];
				}else if($('input[name=cth_size]:checked').val() == "180"){
					if (vno_of_order.value >= 5000) order_pcs = i3_std_2[5];
					else if (vno_of_order.value >= 3000) order_pcs = i3_std_2[4];
					else if (vno_of_order.value >= 1000) order_pcs = i3_std_2[3];
					else if (vno_of_order.value >= 500) order_pcs = i3_std_2[2];
					else if (vno_of_order.value >= 300) order_pcs = i3_std_2[1];
					else if (vno_of_order.value >= 100) order_pcs = i3_std_2[0];
				}
			}else if($('input[name=cth_option]:checked').val() == "プレミアム"){
				if ($('input[name=cth_size]:checked').val() == "150") {
					if (vno_of_order.value >= 5000) order_pcs = i3_prm_1[5];
					else if (vno_of_order.value >= 3000) order_pcs = i3_prm_1[4];
					else if (vno_of_order.value >= 1000) order_pcs = i3_prm_1[3];
					else if (vno_of_order.value >= 500) order_pcs = i3_prm_1[2];
					else if (vno_of_order.value >= 300) order_pcs = i3_prm_1[1];
					else if (vno_of_order.value >= 100) order_pcs = i3_prm_1[0];
				}else if($('input[name=cth_size]:checked').val() == "180"){
					if (vno_of_order.value >= 5000) order_pcs = i3_prm_2[5];
					else if (vno_of_order.value >= 3000) order_pcs = i3_prm_2[4];
					else if (vno_of_order.value >= 1000) order_pcs = i3_prm_2[3];
					else if (vno_of_order.value >= 500) order_pcs = i3_prm_2[2];
					else if (vno_of_order.value >= 300) order_pcs = i3_prm_2[1];
					else if (vno_of_order.value >= 100) order_pcs = i3_prm_2[0];
				}
			}
		}

		if ($('input[name=cth_type]:checked').val() == "エンボス加工") {
			if ($('input[name=cth_option]:checked').val() == "スタンダード") {
				if ($('input[name=cth_size]:checked').val() == "150") {
					if (vno_of_order.value >= 5000) order_pcs = i4_std_1[5];
					else if (vno_of_order.value >= 3000) order_pcs = i4_std_1[4];
					else if (vno_of_order.value >= 1000) order_pcs = i4_std_1[3];
					else if (vno_of_order.value >= 500) order_pcs = i4_std_1[2];
					else if (vno_of_order.value >= 300) order_pcs = i4_std_1[1];
					else if (vno_of_order.value >= 100) order_pcs = i4_std_1[0];
				}else if($('input[name=cth_size]:checked').val() == "180"){
					if (vno_of_order.value >= 5000) order_pcs = i4_std_2[5];
					else if (vno_of_order.value >= 3000) order_pcs = i4_std_2[4];
					else if (vno_of_order.value >= 1000) order_pcs = i4_std_2[3];
					else if (vno_of_order.value >= 500) order_pcs = i4_std_2[2];
					else if (vno_of_order.value >= 300) order_pcs = i4_std_2[1];
					else if (vno_of_order.value >= 100) order_pcs = i4_std_2[0];
				}
			}else if($('input[name=cth_option]:checked').val() == "プレミアム"){
				if ($('input[name=cth_size]:checked').val() == "150") {
					if (vno_of_order.value >= 5000) order_pcs = i4_prm_1[5];
					else if (vno_of_order.value >= 3000) order_pcs = i4_prm_1[4];
					else if (vno_of_order.value >= 1000) order_pcs = i4_prm_1[3];
					else if (vno_of_order.value >= 500) order_pcs = i4_prm_1[2];
					else if (vno_of_order.value >= 300) order_pcs = i4_prm_1[1];
					else if (vno_of_order.value >= 100) order_pcs = i4_prm_1[0];
				}else if($('input[name=cth_size]:checked').val() == "180"){
					if (vno_of_order.value >= 5000) order_pcs = i4_prm_2[5];
					else if (vno_of_order.value >= 3000) order_pcs = i4_prm_2[4];
					else if (vno_of_order.value >= 1000) order_pcs = i4_prm_2[3];
					else if (vno_of_order.value >= 500) order_pcs = i4_prm_2[2];
					else if (vno_of_order.value >= 300) order_pcs = i4_prm_2[1];
					else if (vno_of_order.value >= 100) order_pcs = i4_prm_2[0];
				}
			}
		}

		switch($('input[name=cth_type]:checked').val()){
			case "昇華転写片面印刷": var prd_basic_price = 0;break;
			case "昇華転写両面印刷": var prd_basic_price = 0;break;
			case "1色印刷（シルクスクリーン）": var prd_basic_price = 3960;break;
			case "エンボス加工": var prd_basic_price = 8800;break;
		}

		$('#sample-prd-prdt').text($('input[name=cth_type]:checked').val()+"("+$('input[name=cth_option]:checked').val()+")");
		$('#prd_production').text($('input[name=cth_type]:checked').val()+"("+$('input[name=cth_option]:checked').val()+")");

		if($('input[name=cth_size]').length && $('input[name=cth_size]:checked').val()!=undefined){
			if($('input[name=cth_size]:checked').val() == "150"){
				$('#sample-prd-size').text('150x150mm.');
				$('#prd_size').text('150x150mm.');
			}else if($('input[name=cth_size]:checked').val() == "180"){
				$('#sample-prd-size').text('150x180mm.');
				$('#prd_size').text('150x180mm.');
			}
		}

		$('#sample-prd-design').text($('input[name=ItemDesign]:checked').val());
		$('#prd_ItemDesign').text($('input[name=ItemDesign]:checked').val());

		$('#sample-prd-qty').text(vno_of_order.value);
		$('#prd_amount').text(vno_of_order.value);

		if($('input[name=cth_sample]:checked').val()!=undefined){
			proto_charge = 4950;
			$('#prd_sample').text('あり');
			$('#sample-prd-samp').text('あり');
		}else{
			$('#prd_sample').text('なし');
			$('#sample-prd-samp').text('なし');
		}

		if($('input[name=cth_opp]:checked').val()!=undefined){
			opp_price = 11*vno_of_order.value;
			$('#prd_opp').text('あり');
			$('#sample-prd-opp').text('あり');
		}else{
			opp_price = 0;
			$('#prd_opp').text('なし');
			$('#sample-prd-opp').text('なし');
		}

		$('#prd_qty').text(vno_of_order.value);

		// Assign Value
		TextField7Value = Math.floor(order_pcs*(1+vat/100))*vno_of_order.value;
		// Amount Before Tax
		TextField9Value = parseInt(TextField7Value) + proto_charge + opp_price + prd_basic_price;

		DisPrice = 0;

		tax = Math.floor(Math.floor(TextField7Value*vat/(100+vat)) + Math.floor(proto_charge*vat/(100+vat))+
			Math.floor(opp_price*vat/(100+vat))+
			Math.floor(prd_basic_price*vat/(100+vat)));
		// tax = tax - Math.floor(tax*vat/100);
		total = (parseInt(TextField9Value)-parseInt(DisPrice));

		document.getElementById('prd_basic_price').value = (prd_basic_price).toLocaleString("en");

		document.getElementById('prd_sample_price').value = (proto_charge).toLocaleString("en");
		document.getElementById('prd_opp_price').value = (opp_price).toLocaleString("en");

		document.getElementById('discount').value = (DisPrice).toLocaleString("en");
		document.getElementById('prd_price').value = (TextField7Value).toLocaleString("en");

		// document.getElementById('textfield8').value = formatMoney(shipping_charge);
		document.getElementById('prd_sub_total').value = (parseInt(TextField9Value)).toLocaleString("en");
		// document.getElementById('textfield10').value = formatMoney(tax);
		document.getElementById('discount').value = (DisPrice).toLocaleString("en");
		document.getElementById('prd_total').value = (total).toLocaleString("en");
		$('.prd_total').text(formatMoney(total).toLocaleString("en"));
		// document.getElementById('textfield12').value = formatMoney(printumu);
	}
};

function clearValue(){
	order_pcs = 0;
	unit_price = 0;
	pcs_price = 0;
	before_tax = 0;
	tax = 0;
	total = 0;
	silkprint = 0;
	TextField7Value = 0;
	TextField9Value = 0;
	DisPrice = 0;
	proto_charge = 0;
	trace_charge = 0;
	design_price = 0;

	document.getElementById('prd_basic_price').value = "";

	document.getElementById('prd_opp_price').value = "";
	document.getElementById('prd_sample_price').value = "";

	document.getElementById('discount').value = "";
	document.getElementById('prd_price').value = "";
	document.getElementById('prd_sub_total').value = "";
	document.getElementById('prd_total').value = "";
}

function setzero(){
	order_pcs = 0;
	unit_price = 0;
	pcs_price = 0;
	before_tax = 0;
	tax = 0;
	total = 0;
	silkprint = 0;
	TextField7Value = 0;
	TextField9Value = 0;
	DisPrice = 0;
	proto_charge = 0;
	trace_charge = 0;
	design_price = 0;

	document.getElementById('prd_basic_price').value = "";

	document.getElementById('prd_opp_price').value = "";
	document.getElementById('prd_sample_price').value = "";

	document.getElementById('discount').value = "";
	document.getElementById('prd_price').value = "";
	document.getElementById('prd_sub_total').value = "";
	document.getElementById('prd_total').value = "";

	$("input[name=cth_type]:first").prop('checked', true);
	$("input[name=cth_option]:first").prop('checked', true);
	$("input[name=cth_size]:first").prop('checked', true);
	
	$("input[name=cth_sample]").prop('checked', false);
	$("input[name=cth_opp]").prop('checked', false);

	document.getElementById('qty').value = "";
}

///comma////
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

///input only number////
function check_num()
{
	m = String.fromCharCode(event.keyCode);
	if("0123456789\b\r".indexOf(m, 0) < 0) return false;
	return true;
}

//clear 0 first char
function format_number(number){
	if (number !=""){
		number = parseInt(number)+0;
	}
	return number;
}

