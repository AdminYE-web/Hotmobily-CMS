function setToInput(){
//Delete 2012/04/24 Sineenad R. Start
/*	var price_pcs1 = [525,420,315,252,189,147,105];*/
//    var price_pcs1 = [535,430,325,262,199,157,115];
/*	var price_pcs2 = [788,630,473,378,284,221,158];*/
//	var price_pcs2 = [798,640,483,388,294,231,168];
/*	var price_coaster = [605,504,450,336,265,221,177];*/
//	var price_coaster = [615,514,460,346,275,231,187];	
	//var price_keykaba = [668,537,406,327,248,196,143];	
    //var price_earphone = [535,430,325,262,199,157,115];	
	/*var price_cleaner_print = [380,185,140,100,92,86];*/
	//var price_cleaner_rubber = [420,315,252,189,147,105];	
	//var price_smartphone = [615,514,460,346,275,231,187];
	//var price_extra_colors = [53,42,32,26,21,16,11];	
	/*var price_cleaner_print_color = [30,22,15,10,8,6];*/
	//var price_cleaner_rubber_color = [42,32,26,21,16,11];	
	//var price_keykaba_color = [66,53,40,32,24,19,14];
//Delete 2012/04/24 Sineenad R. End
//Delete 2013/11/20 Monrat H.  Start
/*	var price_pcs1 = [358,294,228,186,143,114,86];
	var price_earphone = [447,379,285,232,179,143,129];
	var price_pcs2 = [537,441,342,279,215,171,129];
	var price_keykaba = [565,429,303,237,189,154,135];	
	//var price_cleaner_rubber = [344,260,209,159,125,92];
	var price_cleaner_rubber = [385,349,279,189,162,149];
	var price_coaster = [525,442,329,265,203,169,155];
	var price_smartphone = [525,442,329,265,203,169,155];	
	var price_extra_colors = [15,12,9,7,6,4,3];
	var price_coaster_colors = [42,33,25,20,16,12,8];
	var price_keykaba_color = [42,33,25,20,16,12,8];
	//var price_cleaner_rubber_color = [33,25,20,16,12,8];
	var price_cleaner_rubber_color = [30,25,20,16,12,8];
*/
//Delete 2013/11/20 Monrat H. End
	var price_pcs1 = [450,365,290,232,185,140,111];
	

	var price_pcs2 = [675,548,435,348,278,210,167];
	var price_earphone = [450,365,290,232,185,140,111];
	var price_keykaba = [565,429,303,237,189,154,135];	
	var price_cleaner_rubber = [385,349,279,189,162,149];
	var price_coaster = [550,460,350,280,220,169,150];
	var price_smartphone = [550,460,350,280,220,169,150];//[525,442,329,265,203,169,155];	
	var price_extra_colors = [39,33,26,20,16,12,8];
	var price_coaster_colors = [42,33,25,20,16,12,8];
	var price_keykaba_color = [42,33,25,20,16,12,8];
	var price_cleaner_rubber_color = [30,25,20,16,12,8];
	
	var price_bracket;
	var basic_charge = 0;
	var mold_charge = 0;
	var proto_shipping_charge = 0;
	var trace_charge = 0;
	var order_pcs = 0;
	var unit_price = 0;
	var strap_price = 0;
	var shipping_charge = 0;
	var before_tax = 0;
	var tax = 0;
	var total = 0;
	var printumu = 0;
	var silkprint = 0;

	//入力値
/*	var cleaner_print = document.getElementById('cleaner_print');//--*/
	var cleaner_rubber = document.getElementById('cleaner_rubber');//--
    var coaster = document.getElementById('coaster');
    var smartphone = document.getElementById('smartphone');
	var vpcs1 = document.getElementById('pcs1');
	var vpcs2 = document.getElementById('pcs2');	
	var vcolor = document.getElementById('color');
	var vNo = document.getElementById('No');
	var vNo2 = document.getElementById('No2');
	var vNo3 = document.getElementById('No3');
	var villus = document.getElementById('illus');
	var villus2 = document.getElementById('illus2'); 
	var vno_of_order = document.getElementById('no_of_order');
/*	var campaign = document.getElementById('campaign_no');*/
	var vprintumu1 = document.getElementById('nashiprint');
	var vprintumu2 = document.getElementById('ariprint');	
	var keykaba = document.getElementById('keykaba');	
	var earphone = document.getElementById('earphone');	

	if(vno_of_order.value != "" && vcolor != ""){

    //Assign price bracket
		if (cleaner_rubber.checked) {
			if (vno_of_order.value >= 5000) price_bracket = 5;
			else if (vno_of_order.value >= 3000) price_bracket = 4;
			else if (vno_of_order.value >= 1000) price_bracket = 3;
			else if (vno_of_order.value >= 500) price_bracket = 2;
			else if (vno_of_order.value >= 300) price_bracket = 1;
			else if (vno_of_order.value >= 200) price_bracket = 0;
		/*} else if (cleaner_print.checked) {
			if (vno_of_order.value >= 5000) price_bracket = 5;
			else if (vno_of_order.value >= 3000) price_bracket = 4;
			else if (vno_of_order.value >= 1000) price_bracket = 3;
			else if (vno_of_order.value >= 500) price_bracket = 2;
			else if (vno_of_order.value >= 300) price_bracket = 1;
			else if (vno_of_order.value >= 200) price_bracket = 0;*/
		} else {
			if (vno_of_order.value >= 5000) price_bracket = 6;
			else if (vno_of_order.value >= 3000) price_bracket = 5;
			else if (vno_of_order.value >= 1000) price_bracket = 4;
			else if (vno_of_order.value >= 500) price_bracket = 3;
			else if (vno_of_order.value >= 300) price_bracket = 2;
			else if (vno_of_order.value >= 100) price_bracket = 1;
			else if (vno_of_order.value >= 50) price_bracket = 0;
		}

		//Unit Price - Item Type
		if (cleaner_rubber.checked) unit_price += price_cleaner_rubber[price_bracket];//--
		/*else if (cleaner_print.checked) unit_price += price_cleaner_print[price_bracket];//--*/
		else if (coaster.checked) unit_price += price_coaster[price_bracket];
		else if (smartphone.checked) unit_price += price_smartphone[price_bracket];
		else if (keykaba.checked) unit_price += price_keykaba[price_bracket];
    	else if (earphone.checked) unit_price += price_earphone[price_bracket];
    	else if (vpcs1.checked) unit_price += price_pcs1[price_bracket];
    	else if (vpcs2.checked) unit_price += price_pcs2[price_bracket];

		//Unit Price - Extra Colors
		if (cleaner_rubber.checked) {
			if (vcolor.value == 4) unit_price += price_cleaner_rubber_color[price_bracket];
			else if(vcolor.value == 5) unit_price += price_cleaner_rubber_color[price_bracket] * 2;
			else if(vcolor.value == 6) unit_price += price_cleaner_rubber_color[price_bracket] * 3;
			else if(vcolor.value == 7) unit_price += price_cleaner_rubber_color[price_bracket] * 4;
			else if(vcolor.value == 8) unit_price += price_cleaner_rubber_color[price_bracket] * 5;
		/*} else if (cleaner_print.checked) {
			if (vcolor.value == 4) unit_price += price_cleaner_print_color[price_bracket];
			else if(vcolor.value == 5) unit_price += price_cleaner_print_color[price_bracket] * 2;
			else if(vcolor.value == 6) unit_price += price_cleaner_print_color[price_bracket] * 3;
			else if(vcolor.value == 7) unit_price += price_cleaner_print_color[price_bracket] * 4;
			else if(vcolor.value == 8) unit_price += price_cleaner_print_color[price_bracket] * 5;*/
		} else if (coaster.checked) {
			if (vcolor.value == 4) unit_price += price_coaster_colors[price_bracket];
			else if(vcolor.value == 5) unit_price += price_coaster_colors[price_bracket] * 2;
			else if(vcolor.value == 6) unit_price += price_coaster_colors[price_bracket] * 3;
			else if(vcolor.value == 7) unit_price += price_coaster_colors[price_bracket] * 4;
			else if(vcolor.value == 8) unit_price += price_coaster_colors[price_bracket] * 5;
		}else if (smartphone.checked) {
			if (vcolor.value == 4) unit_price += price_coaster_colors[price_bracket];
			else if(vcolor.value == 5) unit_price += price_coaster_colors[price_bracket] * 2;
			else if(vcolor.value == 6) unit_price += price_coaster_colors[price_bracket] * 3;
			else if(vcolor.value == 7) unit_price += price_coaster_colors[price_bracket] * 4;
			else if(vcolor.value == 8) unit_price += price_coaster_colors[price_bracket] * 5;
		}else if (keykaba.checked) {
			if (vcolor.value == 4) unit_price += price_keykaba_color[price_bracket];
			else if(vcolor.value == 5) unit_price += price_keykaba_color[price_bracket] * 2;
			else if(vcolor.value == 6) unit_price += price_keykaba_color[price_bracket] * 3;
			else if(vcolor.value == 7) unit_price += price_keykaba_color[price_bracket] * 4;
			else if(vcolor.value == 8) unit_price += price_keykaba_color[price_bracket] * 5;
		} else {
			if (vcolor.value == 4) unit_price += price_extra_colors[price_bracket];
			else if(vcolor.value == 5) unit_price += price_extra_colors[price_bracket] * 2;
			else if(vcolor.value == 6) unit_price += price_extra_colors[price_bracket] * 3;
			else if(vcolor.value == 7) unit_price += price_extra_colors[price_bracket] * 4;
			else if(vcolor.value == 8) unit_price += price_extra_colors[price_bracket] * 5;
		}


		if (vno_of_order.value >= 50 && vno_of_order.value <= 299) {
			basic_charge = 7000;					
		} else {
			basic_charge = 5000;			
		}
		
		
		
		if (vpcs1.checked){
			if(coaster.checked) {
				mold_charge = 17000;
			} else if (smartphone.checked) {
				mold_charge = 17000;
			} else if (keykaba.checked) {
				mold_charge = 28000;
			} else if (cleaner_rubber.checked) {
				mold_charge = 26500;
			} else{
				mold_charge = 14000;
			}
		} else if (vpcs2.checked) {
			mold_charge = 28000;
		}
		if(vNo3.checked){
			proto_shipping_charge = 3600;
		}
		if(villus2.checked){
			trace_charge = 0;
		}
		shipping_charge = 3600;

		///campaign用///
	/*	switch (campaign.value) {
		case "2":
			//basic_charge = 0;
			//shipping_charge = 0;
			//if(vno_of_order.value >= 500 ) mold_charge = 6000;
			alert("３９キャンペーンは２０１０年３月９日を持ちまして終了致しました。");
		    break;
		default:
			break;
		}*/

		if( vprintumu2.checked ){
			printumu = 7000;
			silkprint = vno_of_order.value * 24

		}

		order_pcs = vno_of_order.value;
		strap_price = order_pcs * unit_price;
		before_tax = basic_charge + mold_charge + proto_shipping_charge + 
					 trace_charge + strap_price + shipping_charge + printumu + silkprint;
		tax = Math.floor(before_tax * 0.05);
//		tax = before_tax * 0.05;
		total = before_tax + tax;

		document.getElementById('textfield1').value = formatMoney(basic_charge);
		document.getElementById('textfield2').value = formatMoney(mold_charge);
		document.getElementById('textfield3').value = formatMoney(proto_shipping_charge);
		document.getElementById('textfield4').value = formatMoney(trace_charge);
		document.getElementById('textfield5').value = formatMoney(order_pcs);
		document.getElementById('textfield6').value = formatMoney(unit_price);
		document.getElementById('textfield7').value = formatMoney(strap_price);
		document.getElementById('textfield8').value = formatMoney(shipping_charge);
		document.getElementById('textfield9').value = formatMoney(before_tax);
		document.getElementById('textfield10').value = formatMoney(tax);
		document.getElementById('textfield11').value = formatMoney(total);
		document.getElementById('textfield12').value = formatMoney(printumu);
		document.getElementById('textfield13').value = formatMoney(silkprint);
	}
};

function clearValue(form){
	var obj = this.form;
	obj.priceOf.value = "";
	obj.basicFee.value = "";
	obj.total.value = "";
	obj.tax.value = "";
	obj.grandTotal.value = "";
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