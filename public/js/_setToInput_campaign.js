	var price_strap_standard = [360,235,225,218,179,143,115];
	var price_strap_premium = [719,555,446,339,257,184,140];

	var price_keyholder_standard = [360,235,225,218,179,143,115];
	var price_keyholder_premium = [719,555,446,339,257,184,140];

	var price_earphone_standard = [360,235,225,218,179,143,115];
	var price_earphone_premium = [719,555,446,339,257,184,140];

	var price_keykaba_standard = [889,682,474,348,256,191,143];	
	var price_keykaba_premium = [988,769,549,408,304,227,167];

	var price_cleaner_rubber_standard = [469,351,225,174,156];
	var price_cleaner_rubber_premium = [544,411,273,210,180];

	var price_coaster_standard = [650,530,385,325,234,177,149];
	var price_coaster_premium = [840,677,513,393,295,214,179];
	
	function setToInput(){
		clearValue();
		var price_bracket = 0;
		var proto_shipping_charge = 0;
		var order_pcs = 0;
		var unit_price = 0;
		var strap_price = 0;
		var before_tax = 0;
		var tax = 0;
		var total = 0;
		var silkprint = 0;

		var strap = document.getElementById('strap');
		var keyholder = document.getElementById('keyholder');
		var earphone = document.getElementById('earphone');
		var keykaba = document.getElementById('keykaba');
	var cleaner_rubber = document.getElementById('cleaner_rubber');//--
	var coaster = document.getElementById('coaster');
    // Quality
    var vpcs1 = document.getElementById('pcs1');
    var vpcs2 = document.getElementById('pcs2');
	// ----------->
	// var vcolor = document.getElementById('color');
	var vNo = document.getElementById('No');
	var vNo2 = document.getElementById('No2');
	var vNo3 = document.getElementById('No3');
	var villus = document.getElementById('illus');
	var villus2 = document.getElementById('illus2');
	if(screen.width<=768){
		if(document.querySelector("input[name=numberOf]:checked").value=='0'){
			var vno_of_order = document.getElementById('no_of_order_other');
		}else{
			var vno_of_order = document.querySelector("input[name=numberOf]:checked");
		}
	}else{
		var vno_of_order = document.getElementById('no_of_order');
	}
	var vprintumu1 = document.getElementById('nashiprint');
	var vprintumu2 = document.getElementById('ariprint');


	if(vno_of_order.value != "" ) {

		// strap
		if (strap.checked) {
			if (vpcs1.checked) {
				if (vno_of_order.value >= 5000) order_pcs = price_strap_standard[6];
				else if (vno_of_order.value >= 3000) order_pcs = price_strap_standard[5];
				else if (vno_of_order.value >= 1000) order_pcs = price_strap_standard[4];
				else if (vno_of_order.value >= 500) order_pcs = price_strap_standard[3];
				else if (vno_of_order.value >= 300) order_pcs = price_strap_standard[2];
				else if (vno_of_order.value >= 200) order_pcs = price_strap_standard[1];
				else if (vno_of_order.value >= 100) order_pcs = price_strap_standard[0];
			}
			if (vpcs2.checked) {
				if (vno_of_order.value >= 5000) order_pcs = price_strap_premium[6];
				else if (vno_of_order.value >= 3000) order_pcs = price_strap_premium[5];
				else if (vno_of_order.value >= 1000) order_pcs = price_strap_premium[4];
				else if (vno_of_order.value >= 500) order_pcs = price_strap_premium[3];
				else if (vno_of_order.value >= 300) order_pcs = price_strap_premium[2];
				else if (vno_of_order.value >= 200) order_pcs = price_strap_premium[1];
				else if (vno_of_order.value >= 100) order_pcs = price_strap_premium[0];
			}
		}
		// keyholder
		else if (keyholder.checked) {
			if (vpcs1.checked){
				if (vno_of_order.value >=5000) order_pcs = price_keyholder_standard[6];
				else if(vno_of_order.value >=3000) order_pcs = price_keyholder_standard[5];
				else if(vno_of_order.value >=1000) order_pcs = price_keyholder_standard[4];
				else if(vno_of_order.value >=500) order_pcs = price_keyholder_standard[3];
				else if(vno_of_order.value >=300) order_pcs = price_keyholder_standard[2];
				else if(vno_of_order.value >=200) order_pcs = price_keyholder_standard[1];
				else if(vno_of_order.value >=100) order_pcs = price_keyholder_standard[0];
			}
			if (vpcs2.checked) {
				if (vno_of_order.value >=5000) order_pcs = price_keyholder_premium[6];
				else if(vno_of_order.value >=3000) order_pcs = price_keyholder_premium[5];
				else if(vno_of_order.value >=1000) order_pcs = price_keyholder_premium[4];
				else if(vno_of_order.value >=500) order_pcs = price_keyholder_premium[3];
				else if(vno_of_order.value >=300) order_pcs = price_keyholder_premium[2];
				else if(vno_of_order.value >=200) order_pcs = price_keyholder_premium[1];
				else if(vno_of_order.value >=100) order_pcs = price_keyholder_premium[0];
			}
		}
		//earphoe
		else if (earphone.checked) {
			if (vpcs1.checked){
				if (vno_of_order.value >=5000) order_pcs = price_earphone_standard[6];
				else if(vno_of_order.value >=3000) order_pcs = price_earphone_standard[5];
				else if(vno_of_order.value >=1000) order_pcs = price_earphone_standard[4];
				else if(vno_of_order.value >=500) order_pcs = price_earphone_standard[3];
				else if(vno_of_order.value >=300) order_pcs = price_earphone_standard[2];
				else if(vno_of_order.value >=200) order_pcs = price_earphone_standard[1];
				else if(vno_of_order.value >=100) order_pcs = price_earphone_standard[0];
			}
			if (vpcs2.checked) {
				if (vno_of_order.value >=5000) order_pcs = price_earphone_premium[6];
				else if(vno_of_order.value >=3000) order_pcs = price_earphone_premium[5];
				else if(vno_of_order.value >=1000) order_pcs = price_earphone_premium[4];
				else if(vno_of_order.value >=500) order_pcs = price_earphone_premium[3];
				else if(vno_of_order.value >=300) order_pcs = price_earphone_premium[2];
				else if(vno_of_order.value >=200) order_pcs = price_earphone_premium[1];
				else if(vno_of_order.value >=100) order_pcs = price_earphone_premium[0];
			}
		}
		//keykaba
		else if (keykaba.checked) {
			if (vpcs1.checked){
				if (vno_of_order.value >=5000) order_pcs = price_keykaba_standard[6];
				else if(vno_of_order.value >=3000) order_pcs = price_keykaba_standard[5];
				else if(vno_of_order.value >=1000) order_pcs = price_keykaba_standard[4];
				else if(vno_of_order.value >=500) order_pcs = price_keykaba_standard[3];
				else if(vno_of_order.value >=300) order_pcs = price_keykaba_standard[2];
				else if(vno_of_order.value >=200) order_pcs = price_keykaba_standard[1];
				else if(vno_of_order.value >=100) order_pcs = price_keykaba_standard[0];
			}
			if (vpcs2.checked) {
				if (vno_of_order.value >=5000) order_pcs = price_keykaba_premium[6];
				else if(vno_of_order.value >=3000) order_pcs = price_keykaba_premium[5];
				else if(vno_of_order.value >=1000) order_pcs = price_keykaba_premium[4];
				else if(vno_of_order.value >=500) order_pcs = price_keykaba_premium[3];
				else if(vno_of_order.value >=300) order_pcs = price_keykaba_premium[2];
				else if(vno_of_order.value >=200) order_pcs = price_keykaba_premium[1];
				else if(vno_of_order.value >=100) order_pcs = price_keykaba_premium[0];
			}
		}
		//cleaner_rubber
		else if (cleaner_rubber.checked) {
			if (vpcs1.checked){
				if (vno_of_order.value >=5000) order_pcs = price_cleaner_rubber_standard[4];
				else if(vno_of_order.value >=3000) order_pcs = price_cleaner_rubber_standard[3];
				else if(vno_of_order.value >=1000) order_pcs = price_cleaner_rubber_standard[2];
				else if(vno_of_order.value >=500) order_pcs = price_cleaner_rubber_standard[1];
				else if(vno_of_order.value >=300) order_pcs = price_cleaner_rubber_standard[0];
			}
			if (vpcs2.checked) {
				if (vno_of_order.value >=5000) order_pcs = price_cleaner_rubber_premium[4];
				else if(vno_of_order.value >=3000) order_pcs = price_cleaner_rubber_premium[3];
				else if(vno_of_order.value >=1000) order_pcs = price_cleaner_rubber_premium[2];
				else if(vno_of_order.value >=500) order_pcs = price_cleaner_rubber_premium[1];
				else if(vno_of_order.value >=300) order_pcs = price_cleaner_rubber_premium[0];
			}
		}
		//coaster
		else if (coaster.checked) {
			if (vpcs1.checked){
				if (vno_of_order.value >=5000) order_pcs = price_coaster_standard[6];
				else if(vno_of_order.value >=3000) order_pcs = price_coaster_standard[5];
				else if(vno_of_order.value >=1000) order_pcs = price_coaster_standard[4];
				else if(vno_of_order.value >=500) order_pcs = price_coaster_standard[3];
				else if(vno_of_order.value >=300) order_pcs = price_coaster_standard[2];
				else if(vno_of_order.value >=200) order_pcs = price_coaster_standard[1];
				else if(vno_of_order.value >=100) order_pcs = price_coaster_standard[0];
			}
			if (vpcs2.checked) {
				if (vno_of_order.value >=5000) order_pcs = price_coaster_premium[6];
				else if(vno_of_order.value >=3000) order_pcs = price_coaster_premium[5];
				else if(vno_of_order.value >=1000) order_pcs = price_coaster_premium[4];
				else if(vno_of_order.value >=500) order_pcs = price_coaster_premium[3];
				else if(vno_of_order.value >=300) order_pcs = price_coaster_premium[2];
				else if(vno_of_order.value >=200) order_pcs = price_coaster_premium[1];
				else if(vno_of_order.value >=100) order_pcs = price_coaster_premium[0];
			}
		}

		this.optStandard = document.getElementById('pcs1');
		this.optPremium = document.getElementById('pcs2');
		this.send_proto = document.getElementById('No3');
		this.data_file = document.getElementById('illus2');
		this.print_umu = document.getElementById('ariprint');

		var proto_charge = 0;
		var trace_charge = 0;
		var print_charge = 0;

		if(optStandard.checked){
			if(send_proto.checked){ proto_charge = 8000; }
			if(data_file.checked){ trace_charge = 8000; }
			if(print_umu.checked){ print_charge = vno_of_order.value * 20;}
		}

		// Assign Value
		var TextField5Value = vno_of_order.value;
		var TextField6Value = order_pcs;
		var TextField7Value = TextField5Value * TextField6Value;
		// Amount Before Tax
		var TextField9Value = parseInt(TextField7Value) + proto_charge + trace_charge + print_charge;

		if(vno_of_order.value < 1000){
			var dis_c = Math.floor(TextField9Value * 0.15);
		}else if(vno_of_order.value >= 1000){
			var dis_c = Math.floor(TextField9Value * 0.10);
		}

		var after_d = TextField9Value - dis_c;
		tax = Math.floor(after_d * 0.1);

		total = parseInt(after_d) + tax;

		// document.getElementById('textfield1').value = formatMoney(basic_charge);
		// document.getElementById('textfield2').value = formatMoney(mold_charge);
		document.getElementById('textfield5').value = formatMoney(TextField5Value);
		document.getElementById('textfield6').value = formatMoney(TextField6Value);
		document.getElementById('textfield7').value = formatMoney(TextField7Value);
		document.getElementById('textfield3').value = formatMoney(proto_charge);
		document.getElementById('textfield4').value = formatMoney(trace_charge);
		document.getElementById('textfield13').value = formatMoney(print_charge);
		// document.getElementById('textfield8').value = formatMoney(shipping_charge);
		document.getElementById('textfield9').value = formatMoney(TextField9Value);
		document.getElementById('pricefield_n1').value = formatMoney(dis_c);
		document.getElementById('pricefield_n2').value = formatMoney(after_d);
		document.getElementById('textfield10').value = formatMoney(tax);
		document.getElementById('textfield11').value = formatMoney(total);
		// document.getElementById('textfield12').value = formatMoney(printumu);
		// $('#div_estimatePrice').show();
		}
	};

	function clearValue(){
		document.getElementById('textfield5').value = "";
		document.getElementById('textfield6').value = "";
		document.getElementById('textfield7').value = "";

		document.getElementById('textfield3').value = "";
		document.getElementById('textfield4').value = "";
		document.getElementById('textfield13').value = "";
		
		$('#pricefield_n1').val('')
		$('#pricefield_n2').val('')

		document.getElementById('textfield9').value = "";
		document.getElementById('textfield10').value = "";
		document.getElementById('textfield11').value = "";
		$('#div_estimatePrice').hide();
	}


	//New Function Write All Price Table
	function table_priceW(){
		$('#div_estimatePrice').hide();
		var itemType = $("*[name='ItemType']:checked").attr('id');
		var itemQA = $('input[name=ItemPCS]:checked').val();
		var QA_val = "";
		if(itemQA=="プレミアム"){
			QA_val = "premium";
		}else{
			QA_val = "standard";
		}
		var qty = [100,200,300,500,1000,3000,5000]
		var qty2 = [0,0,300,500,1000,3000,5000]
		var tax;
		var rows,row1=0; 
		var sum = 0;
		var proto_charge = 0;
		var trace_charge = 0;
		var print_charge = 0;
		if(QA_val == "standard"){
			if($('input[name=SendPrototype]:checked').val() == "必要"){
				proto_charge = 8000;
			}
			if($('input[name=DeFormat]:checked').val() == "その他"){
				trace_charge = 8000;
			}
			if($('input[name=silk_print]:checked').val() == "シルク印刷あり"){
				print_charge = 20;
			}
		}
		switch(itemType){
			case 'cleaner_rubber':
			sum = Number(proto_charge + trace_charge);
			$('#qty_100').hide();
			$('#qty_200').hide();
			for(rows=2;rows<7;rows++){
				if(QA_val=="standard"){
					document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((price_cleaner_rubber_standard[row1] * qty2[rows])+Number(sum+(print_charge*qty2[rows])))/qty2[rows]))+"円";
					document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((price_cleaner_rubber_standard[row1] * qty2[rows])+sum+(print_charge*qty2[rows])))+"円";
					tax = Math.floor((price_cleaner_rubber_standard[row1] * qty2[rows] + sum + (print_charge*qty2[rows])) * 1.1);
					document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
					row1++;
				}else{
					document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((price_cleaner_rubber_premium[row1] * qty2[rows])+Number(sum+(print_charge*qty2[rows])))/qty2[rows]))+"円";
					document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((price_cleaner_rubber_premium[row1] * qty2[rows])+sum+(print_charge*qty2[rows])))+"円";
					tax = Math.floor((price_cleaner_rubber_premium[row1] * qty2[rows] + sum + (print_charge*qty2[rows])) * 1.1);
					document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
					row1++;
				}
			}
			break;
			case 'strap':
			sum = Number(proto_charge + trace_charge);
			$('#qty_100').show();
			$('#qty_200').show();
			console.log()
			for(rows=0;rows<7;rows++){
				if(QA_val=="standard"){
					document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((price_strap_standard[row1] * qty[rows])+Number(sum+(print_charge*qty[rows])))/qty[rows]))+"円";
					document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((price_strap_standard[row1] * qty[rows])+sum+(print_charge*qty[rows])))+"円";
					tax = Math.floor((price_strap_standard[row1] * qty[rows] + sum + (print_charge*qty[rows])) * 1.1);
					document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
					row1++;
				}else{
					document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((price_strap_premium[row1] * qty[rows])+Number(sum+(print_charge*qty[rows])))/qty[rows]))+"円";
					document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((price_strap_premium[row1] * qty[rows])+sum+(print_charge*qty[rows])))+"円";
					tax = Math.floor((price_strap_premium[row1] * qty[rows] + sum + (print_charge*qty[rows])) * 1.1);
					document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
					row1++;
				}
			}
			break;
			case 'keyholder':
			sum = Number(proto_charge + trace_charge);
			$('#qty_100').show();
			$('#qty_200').show();
			for(rows=0;rows<7;rows++){
				if(QA_val=="standard"){
					document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((price_keyholder_standard[row1] * qty[rows])+Number(sum+(print_charge*qty[rows])))/qty[rows]))+"円";
					document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((price_keyholder_standard[row1] * qty[rows])+sum+(print_charge*qty[rows])))+"円";
					tax = Math.floor((price_keyholder_standard[row1] * qty[rows] + sum + (print_charge*qty[rows])) * 1.1);
					document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
					row1++;
				}else{
					document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((price_keyholder_premium[row1] * qty[rows])+Number(sum+(print_charge*qty[rows])))/qty[rows]))+"円";
					document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((price_keyholder_premium[row1] * qty[rows])+sum+(print_charge*qty[rows])))+"円";
					tax = Math.floor((price_keyholder_premium[row1] * qty[rows] + sum + (print_charge*qty[rows])) * 1.1);
					document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
					row1++;
				}
			}
			break;
			case 'earphone':
			sum = Number(proto_charge + trace_charge);
			$('#qty_100').show();
			$('#qty_200').show();
			for(rows=0;rows<7;rows++){
				if(QA_val=="standard"){
					document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((price_earphone_standard[row1] * qty[rows])+Number(sum+(print_charge*qty[rows])))/qty[rows]))+"円";
					document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((price_earphone_standard[row1] * qty[rows])+sum+(print_charge*qty[rows])))+"円";
					tax = Math.floor((price_earphone_standard[row1] * qty[rows] + sum + (print_charge*qty[rows])) * 1.1);
					document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
					row1++;
				}else{
					document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((price_earphone_premium[row1] * qty[rows])+Number(sum+(print_charge*qty[rows])))/qty[rows]))+"円";
					document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((price_earphone_premium[row1] * qty[rows])+sum+(print_charge*qty[rows])))+"円";
					tax = Math.floor((price_earphone_premium[row1] * qty[rows] + sum + (print_charge*qty[rows])) * 1.1);
					document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
					row1++;
				}
			}
			break;
			case 'keykaba':
			sum = Number(proto_charge + trace_charge);
			$('#qty_100').show();
			$('#qty_200').show();
			for(rows=0;rows<7;rows++){
				if(QA_val=="standard"){
					document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((price_keykaba_standard[row1] * qty[rows])+Number(sum+(print_charge*qty[rows])))/qty[rows]))+"円";
					document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((price_keykaba_standard[row1] * qty[rows])+sum+(print_charge*qty[rows])))+"円";
					tax = Math.floor((price_keykaba_standard[row1] * qty[rows] + sum + (print_charge*qty[rows])) * 1.1);
					document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
					row1++;
				}else{
					document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((price_keykaba_premium[row1] * qty[rows])+Number(sum+(print_charge*qty[rows])))/qty[rows]))+"円";
					document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((price_keykaba_premium[row1] * qty[rows])+sum+(print_charge*qty[rows])))+"円";
					tax = Math.floor((price_keykaba_premium[row1] * qty[rows] + sum + (print_charge*qty[rows])) * 1.1);
					document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
					row1++;
				}
			}
			break;
			case 'coaster':
			sum = Number(proto_charge + trace_charge);
			$('#qty_100').show();
			$('#qty_200').show();
			for(rows=0;rows<7;rows++){
				if(QA_val=="standard"){
					document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((price_coaster_standard[row1] * qty[rows])+Number(sum+(print_charge*qty[rows])))/qty[rows]))+"円";
					document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((price_coaster_standard[row1] * qty[rows])+sum+(print_charge*qty[rows])))+"円";
					tax = Math.floor((price_coaster_standard[row1] * qty[rows] + sum + (print_charge*qty[rows])) * 1.1);
					document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
					row1++;
				}else{
					document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((price_coaster_premium[row1] * qty[rows])+Number(sum+(print_charge*qty[rows])))/qty[rows]))+"円";
					document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((price_coaster_premium[row1] * qty[rows])+sum+(print_charge*qty[rows])))+"円";
					tax = Math.floor((price_coaster_premium[row1] * qty[rows] + sum + (print_charge*qty[rows])) * 1.1);
					document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
					row1++;
				}
			}
			break;
		}
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


this.typeOrder = document.getElementsByName('ItemType');

function click_typeorder_enabled(typeOption) {

	itemType = "strap";
	if (document.getElementById("keyholder").checked)
		itemType = "keyholder";
	if (document.getElementById("earphone").checked)
		itemType = "earphone";
	if (document.getElementById("keykaba").checked)
		itemType = "keykaba";
	if  (document.getElementById("cleaner_rubber").checked)
		itemType = "cleaner_rubber";
	if  (document.getElementById("coaster").checked)
		itemType = "coaster";

	document.getElementById("No").checked = true;
	document.getElementById("No").disabled = false;
	document.getElementById("No3").disabled = false;

	document.getElementById("illus").checked = true;
	document.getElementById("illus").disabled = false;
	document.getElementById("illus2").disabled = false;

	document.getElementById("nashiprint").checked = true;
	document.getElementById("nashiprint").disabled = false;
	document.getElementById("ariprint").disabled = false;

	switch (itemType) {
		case "strap":
		case "keyholder":
		case "earphone":
		case "keykaba":
		case "coaster":
		if (typeOption == "standard"){
			document.getElementById("nashiprint").disabled = false;
		}
		if (typeOption == "premium"){
			document.getElementById("nashiprint").disabled = true;
		}
		break;

		case "cleaner_rubber":
		if (typeOption == "standard"){
			document.getElementById("nashiprint").disabled = true;
			document.getElementById("ariprint").disabled = true;
		}
		if (typeOption == "premium"){
			document.getElementById("No3").checked = true;
			document.getElementById("No3").disabled = true;
			document.getElementById("illus2").disabled = true;
			document.getElementById("nashiprint").disabled = true;
		}
		break;
	}
}


function click_typeorder_disabled(typeOption) {

	itemType = "strap";
	if (document.getElementById("keyholder").checked)
		itemType = "keyholder";
	if (document.getElementById("earphone").checked)
		itemType = "earphone";
	if (document.getElementById("keykaba").checked)
		itemType = "keykaba";
	if  (document.getElementById("cleaner_rubber").checked)
		itemType = "cleaner_rubber";
	if  (document.getElementById("coaster").checked)
		itemType = "coaster";

	document.getElementById("No3").checked = true;
	document.getElementById("No").disabled = true;
	document.getElementById("No3").disabled = true;

	document.getElementById("illus").checked = true;
	document.getElementById("illus").disabled = true;
	document.getElementById("illus2").disabled = true;

	document.getElementById("ariprint").checked = true;
	document.getElementById("ariprint").disabled = true;
	document.getElementById("nashiprint").disabled = true;

	switch (itemType) {
		case "strap":
		case "keyholder":
		case "keykaba":
		case "coaster":
		case "earphone":
		if (typeOption == "standard"){
			document.getElementById("nashiprint").disabled = false;
		}
		if (typeOption == "premium"){
			document.getElementById("nashiprint").disabled = true;
		}
		break;

		case "cleaner_rubber":
		if (typeOption == "standard"){
			document.getElementById("No").checked = true;
			document.getElementById("nashiprint").checked  = true;
		}
		if (typeOption == "premium"){
			document.getElementById("nashiprint").checked = true;
		}
		break;
	}
}

function click_itemtype(clicked) {

	typeOption = "standard";
	if (document.getElementById("pcs2").checked)
		typeOption = "premium";

	switch(clicked){

		case "strap":
		case "keyholder":
		case "earphone":
		case "keykaba":
		case "coaster":
		if (typeOption == "standard"){
			document.getElementById("nashiprint").disabled = false;
			document.getElementById("ariprint").disabled = false;
		}
		if (typeOption == "premium"){
			document.getElementById("ariprint").disabled = true;
			document.getElementById("ariprint").checked = true;
		}
		break;

		case "cleaner_rubber":
		if (typeOption == "standard"){
			document.getElementById("nashiprint").disabled = true;
			document.getElementById("ariprint").disabled = true;
		}
		if (typeOption == "premium"){
			document.getElementById("nashiprint").checked = true;
			document.getElementById("nashiprint").disabled = true;
		}
		break;
	}
}
