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
	// var price_pcs1 = [450,365,290,232,185,140,111];
	// var price_pcs2 = [675,548,435,348,278,210,167];
	var price_strap_standard = [245,235,225,218,179,143,115];
	var price_strap_premium = [719,555,446,339,257,184,140];

	var price_keyholder_standard = [245,235,225,218,179,143,115];
	var price_keyholder_premium = [719,555,446,339,257,184,140];

	var price_earphone_standard = [245,235,225,218,179,143,115];
	var price_earphone_premium = [719,555,446,339,257,184,140];

	var price_keykaba_standard = [255,245,235,228,189,153,125];	//[565,429,303,237,189,154,135]
	var price_keykaba_premium = [729,565,456,349,267,194,150];

	var price_cleaner_rubber_standard = [265,255,245,238,199,163,135];
	var price_cleaner_rubber_premium = [739,575,466,359,277,204,160];

	var price_coaster_standard = [275,265,255,248,209,173,145];
	var price_coaster_premium = [749,585,476,369,287,214,170];

	var price_smartphone_standard = [275,265,255,248,209,173,145];
	var price_smartphone_premium = [749,585,476,369,287,214,170];//[525,442,329,265,203,169,155];	
	// var price_extra_colors = [39,33,26,20,16,12,8];
	// var price_coaster_colors = [42,33,25,20,16,12,8];
	// var price_keykaba_color = [42,33,25,20,16,12,8];
	// var price_cleaner_rubber_color = [30,25,20,16,12,8];
	
	var price_bracket;
	// var basic_charge = 0;
	// var mold_charge = 0;
	var proto_shipping_charge = 0;
	var order_pcs = 0;
	var unit_price = 0;
	var strap_price = 0;
	// var shipping_charge = 0;
	var before_tax = 0;
	var tax = 0;
	var total = 0;
	// var printumu = 0;
	var silkprint = 0;

	//入力値
/*	var cleaner_print = document.getElementById('cleaner_print');//--*/
	// product --->
	var strap = document.getElementById('keitai');
	var keyholder = document.getElementById('keyholder');
	var earphone = document.getElementById('earphone');	
	var keykaba = document.getElementById('keykaba');	
	var cleaner_rubber = document.getElementById('cleaner_rubber');//--
    var coaster = document.getElementById('coaster');
    var smartphone = document.getElementById('smartphone');
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
	var vno_of_order = document.getElementById('no_of_order');
/*	var campaign = document.getElementById('campaign_no');*/
	var vprintumu1 = document.getElementById('nashiprint');
	var vprintumu2 = document.getElementById('ariprint');	
	

	if(vno_of_order.value != "" ) {
    //Assign price bracket
    	// ========================================================================>
		// if (strap.checked) {
		// 	if (vno_of_order.value >= 5000) price_bracket = 6;
		// 	else if (vno_of_order.value >= 3000) price_bracket = 5;
		// 	else if (vno_of_order.value >= 1000) price_bracket = 4;
		// 	else if (vno_of_order.value >= 500) price_bracket = 3;
		// 	else if (vno_of_order.value >= 300) price_bracket = 2;
		// 	else if (vno_of_order.value >= 200) price_bracket = 1;
		// 	else if (vno_of_order.value >= 100) price_bracket = 0;
		/*} else if (cleaner_print.checked) {
			if (vno_of_order.value >= 5000) price_bracket = 5;
			else if (vno_of_order.value >= 3000) price_bracket = 4;
			else if (vno_of_order.value >= 1000) price_bracket = 3;
			else if (vno_of_order.value >= 500) price_bracket = 2;
			else if (vno_of_order.value >= 300) price_bracket = 1;
			else if (vno_of_order.value >= 200) price_bracket = 0;*/
		// } else {
		// 	if (vno_of_order.value >= 5000) price_bracket = 6;
		// 	else if (vno_of_order.value >= 3000) price_bracket = 5;
		// 	else if (vno_of_order.value >= 1000) price_bracket = 4;
		// 	else if (vno_of_order.value >= 500) price_bracket = 3;
		// 	else if (vno_of_order.value >= 300) price_bracket = 2;
		// 	else if (vno_of_order.value >= 200) price_bracket = 1;
		// 	else if (vno_of_order.value >= 100) price_bracket = 0;
		// }
		let price_bracket = 0 ;

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
				if (vno_of_order.value >=5000) order_pcs = price_cleaner_rubber_standard[6];
				else if(vno_of_order.value >=3000) order_pcs = price_cleaner_rubber_standard[5];
				else if(vno_of_order.value >=1000) order_pcs = price_cleaner_rubber_standard[4];
				else if(vno_of_order.value >=500) order_pcs = price_cleaner_rubber_standard[3];
				else if(vno_of_order.value >=300) order_pcs = price_cleaner_rubber_standard[2];
				else if(vno_of_order.value >=200) order_pcs = price_cleaner_rubber_standard[1];
				else if(vno_of_order.value >=100) order_pcs = price_cleaner_rubber_standard[0];
			}
			if (vpcs2.checked) {
				if (vno_of_order.value >=5000) order_pcs = price_cleaner_rubber_premium[6];
				else if(vno_of_order.value >=3000) order_pcs = price_cleaner_rubber_premium[5];
				else if(vno_of_order.value >=1000) order_pcs = price_cleaner_rubber_premium[4];
				else if(vno_of_order.value >=500) order_pcs = price_cleaner_rubber_premium[3];
				else if(vno_of_order.value >=300) order_pcs = price_cleaner_rubber_premium[2];
				else if(vno_of_order.value >=200) order_pcs = price_cleaner_rubber_premium[1];
				else if(vno_of_order.value >=100) order_pcs = price_cleaner_rubber_premium[0];
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
		//smartphone
		else if (smartphone.checked) {
			if (vpcs1.checked){
				if (vno_of_order.value >=5000) order_pcs = price_smartphone_standard[6];
				else if(vno_of_order.value >=3000) order_pcs = price_smartphone_standard[5];
				else if(vno_of_order.value >=1000) order_pcs = price_smartphone_standard[4];
				else if(vno_of_order.value >=500) order_pcs = price_smartphone_standard[3];
				else if(vno_of_order.value >=300) order_pcs = price_smartphone_standard[2];
				else if(vno_of_order.value >=200) order_pcs = price_smartphone_standard[1];
				else if(vno_of_order.value >=100) order_pcs = price_smartphone_standard[0];
			}
			if (vpcs2.checked) {
				if (vno_of_order.value >=5000) order_pcs = price_smartphone_premium[6];
				else if(vno_of_order.value >=3000) order_pcs = price_smartphone_premium[5];
				else if(vno_of_order.value >=1000) order_pcs = price_smartphone_premium[4];
				else if(vno_of_order.value >=500) order_pcs = price_smartphone_premium[3];
				else if(vno_of_order.value >=300) order_pcs = price_smartphone_premium[2];
				else if(vno_of_order.value >=200) order_pcs = price_smartphone_premium[1];
				else if(vno_of_order.value >=100) order_pcs = price_smartphone_premium[0];
			}
		}

		// ========================================================================>

		//Unit Price - Item Type
		// if (cleaner_rubber.checked) unit_price += price_cleaner_rubber[price_bracket];//--
		// /*else if (cleaner_print.checked) unit_price += price_cleaner_print[price_bracket];//--*/
		// else if (coaster.checked) unit_price += price_coaster[price_bracket];
		// else if (smartphone.checked) unit_price += price_smartphone[price_bracket];
		// else if (keykaba.checked) unit_price += price_keykaba[price_bracket];
  //   	else if (earphone.checked) unit_price += price_earphone[price_bracket];
    	// else if (vpcs1.checked) unit_price += price_pcs1[price_bracket];
    	// else if (vpcs2.checked) unit_price += price_pcs2[price_bracket];

		//Unit Price - Extra Colors
		// if (cleaner_rubber.checked) {
		// 	if (vcolor.value == 4) unit_price += price_cleaner_rubber_color[price_bracket];
		// 	else if(vcolor.value == 5) unit_price += price_cleaner_rubber_color[price_bracket] * 2;
		// 	else if(vcolor.value == 6) unit_price += price_cleaner_rubber_color[price_bracket] * 3;
		// 	else if(vcolor.value == 7) unit_price += price_cleaner_rubber_color[price_bracket] * 4;
		// 	else if(vcolor.value == 8) unit_price += price_cleaner_rubber_color[price_bracket] * 5;
		// /*} else if (cleaner_print.checked) {
		// 	if (vcolor.value == 4) unit_price += price_cleaner_print_color[price_bracket];
		// 	else if(vcolor.value == 5) unit_price += price_cleaner_print_color[price_bracket] * 2;
		// 	else if(vcolor.value == 6) unit_price += price_cleaner_print_color[price_bracket] * 3;
		// 	else if(vcolor.value == 7) unit_price += price_cleaner_print_color[price_bracket] * 4;
		// 	else if(vcolor.value == 8) unit_price += price_cleaner_print_color[price_bracket] * 5;*/
		// } else if (coaster.checked) {
		// 	if (vcolor.value == 4) unit_price += price_coaster_colors[price_bracket];
		// 	else if(vcolor.value == 5) unit_price += price_coaster_colors[price_bracket] * 2;
		// 	else if(vcolor.value == 6) unit_price += price_coaster_colors[price_bracket] * 3;
		// 	else if(vcolor.value == 7) unit_price += price_coaster_colors[price_bracket] * 4;
		// 	else if(vcolor.value == 8) unit_price += price_coaster_colors[price_bracket] * 5;
		// }else if (smartphone.checked) {
		// 	if (vcolor.value == 4) unit_price += price_coaster_colors[price_bracket];
		// 	else if(vcolor.value == 5) unit_price += price_coaster_colors[price_bracket] * 2;
		// 	else if(vcolor.value == 6) unit_price += price_coaster_colors[price_bracket] * 3;
		// 	else if(vcolor.value == 7) unit_price += price_coaster_colors[price_bracket] * 4;
		// 	else if(vcolor.value == 8) unit_price += price_coaster_colors[price_bracket] * 5;
		// }else if (keykaba.checked) {
		// 	if (vcolor.value == 4) unit_price += price_keykaba_color[price_bracket];
		// 	else if(vcolor.value == 5) unit_price += price_keykaba_color[price_bracket] * 2;
		// 	else if(vcolor.value == 6) unit_price += price_keykaba_color[price_bracket] * 3;
		// 	else if(vcolor.value == 7) unit_price += price_keykaba_color[price_bracket] * 4;
		// 	else if(vcolor.value == 8) unit_price += price_keykaba_color[price_bracket] * 5;
		// } else {
		// 	if (vcolor.value == 4) unit_price += price_extra_colors[price_bracket];
		// 	else if(vcolor.value == 5) unit_price += price_extra_colors[price_bracket] * 2;
		// 	else if(vcolor.value == 6) unit_price += price_extra_colors[price_bracket] * 3;
		// 	else if(vcolor.value == 7) unit_price += price_extra_colors[price_bracket] * 4;
		// 	else if(vcolor.value == 8) unit_price += price_extra_colors[price_bracket] * 5;
		// }


		// if (vno_of_order.value >= 50 && vno_of_order.value <= 299) {
		// 	basic_charge = 7000;					
		// } else {
		// 	basic_charge = 5000;			
		// }
		
		
		
		// if (vpcs1.checked){
		// 	if(coaster.checked) {
		// 		mold_charge = 17000;
		// 	} else if (smartphone.checked) {
		// 		mold_charge = 17000;
		// 	} else if (keykaba.checked) {
		// 		mold_charge = 28000;
		// 	} else if (cleaner_rubber.checked) {
		// 		mold_charge = 26500;
		// 	} else{
		// 		mold_charge = 14000;
		// 	}
		// } else if (vpcs2.checked) {
		// 	mold_charge = 28000;
		// }
		// if(vNo3.checked){
		// 	//proto_shipping_charge = 4500; xxx
		// 	proto_shipping_charge = 0;
		// }
		// if(villus2.checked){
		// 	trace_charge = 0;
		// }
		// shipping_charge = 4500;

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

		// if( vprintumu2.checked ){
		// 	printumu = 7000;
		// 	silkprint = vno_of_order.value * 24

		// }

		this.optStandard = document.getElementById('pcs1');
		this.optPremium = document.getElementById('pcs2');
		this.send_proto = document.getElementById('No3');
		this.data_file = document.getElementById('illus2');
		this.print_umu = document.getElementById('ariprint');

		var proto_charge = 0;
		var trace_charge = 0;
		var print_charge = 0;

		if(optStandard.checked){
			if(send_proto.checked){ proto_charge = 12500; }
			if(data_file.checked){ trace_charge = 8000; }
			if(print_umu.checked){ print_charge = vno_of_order.value * 20;}
		}

		// Assign Value
		let TextField5Value = vno_of_order.value;
		let TextField6Value = order_pcs;
		let TextField7Value = TextField5Value * TextField6Value;
		// Amount Before Tax
		let TextField9Value = parseInt(TextField7Value) + proto_charge + trace_charge + print_charge;
		tax = Math.floor(parseInt(TextField9Value) * 0.08);
		total = parseInt(TextField9Value) + tax;

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
		document.getElementById('textfield10').value = formatMoney(tax);
		document.getElementById('textfield11').value = formatMoney(total);
		// document.getElementById('textfield12').value = formatMoney(printumu);
		
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

this.typeOrder = document.getElementsByName('ItemType');

function click_typeorder_enabled(typeOption) {

	let itemType = "strap";
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
	if  (document.getElementById("smartphone").checked)
		itemType = "smartphone";

	document.getElementById("No").checked = true;
	document.getElementById("No").disabled = false;
	document.getElementById("No3").disabled = false;

	document.getElementById("illus").checked = true;
	document.getElementById("illus").disabled = false;
	document.getElementById("illus2").disabled = false;

	document.getElementById("nashiprint").checked = true;
	document.getElementById("nashiprint").disabled = false;
	document.getElementById("ariprint").disabled = false;
}


function click_typeorder_disabled(typeOption) {

	let itemType = "strap";
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
	if  (document.getElementById("smartphone").checked)
		itemType = "smartphone";

	document.getElementById("No3").checked = true;
	document.getElementById("No").disabled = true;
	document.getElementById("No3").disabled = true;

	document.getElementById("illus").checked = true;
	document.getElementById("illus").disabled = true;
	document.getElementById("illus2").disabled = true;

	document.getElementById("ariprint").checked = true;
	document.getElementById("ariprint").disabled = true;
	document.getElementById("nashiprint").disabled = true;
}