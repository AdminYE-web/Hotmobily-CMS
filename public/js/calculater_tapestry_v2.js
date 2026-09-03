	// フライトタグ（刺繍タグキーホルダー）

	//Normal
    //Without Tax
    // var priceA1 = [1486, 986, 948, 881, 803, 728, 686, 645, 635];
    // var priceB2 = [1706, 1706, 1065, 1013, 934, 877, 824, 763, 732];
    // var priceB1 = [2004, 2004, 1271, 1213, 1113, 1038, 981, 916, 881];

    var priceA1 = [1634, 1084, 1042, 969, 883, 800, 754, 754, 754];
    var priceB2 = [1876, 1876, 1171, 1114, 1027, 964, 906, 906, 906];
    var priceB1 = [2204, 2204, 1398, 1334, 1224, 1141, 1079, 1079, 1079];

	//Single
	var priceA1Single = [1846, 1754, 1197, 1089, 1001, 894, 854, 853, 854];
    var priceB2Single = [2052, 2052, 1346, 1204, 1133, 1062, 997, 997, 997];
    var priceB1Single = [2422, 2422, 1535, 1483, 1363, 1262, 1188, 1188, 1188];

	//Without Tax
	// var priceA1Single = [1679, 1595, 1089, 990, 910, 813, 776, 776, 776];
    // var priceB2Single = [1866, 1866, 1224, 1095, 1030, 966, 907, 907, 907];
    // var priceB1Single = [2202, 2202, 1396, 1349, 1239, 1148, 1080, 1080, 1080];

	//Double
	var priceA1Double = [2277, 2277, 1457, 1375, 1273, 1212, 1149, 1149, 1149];
    var priceB2Double = [2621, 2621, 1701, 1654, 1545, 1474, 1443, 1443, 1443];
    var priceB1Double = [3419, 3214, 2481, 2173, 1865, 1774, 1699, 1699, 1699];
	
	//Without Tax
	// var priceA1Double = [2070, 2070, 1325, 1250, 1157, 1102, 1045, 1045, 1045];
    // var priceB2Double = [2383, 2383, 1547, 1504, 1405, 1340, 1312, 1312, 1312];
    // var priceB1Double = [3109, 2922, 2256, 1976, 1696, 1613, 1545, 1545, 1545];
	
	var unit_price = 0;

	function valid_chk_btn(c) {
		if(check_val(c)){
			$('#step1').fadeOut('fast');
			$('#step2').fadeOut('fast');
			$('#step3').fadeOut('fast');
			$('#dot-step1').removeClass('active');
			$('#dot-step2').removeClass('active');
			$('#dot-step3').removeClass('active');

			//New condition check button click
			let currentClick = null;
			if (typeof event !== "undefined" && event && event.target) {
				currentClick = $(event.target).text();
			} else {
				currentClick = "redirect";
			}

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

            //New condition check price adapt
            if((currentClick != "" && currentClick !== undefined) && (currentClick === "金額計算・見積・注文へ"))
            {
                let price_value = setToInputManual();
                if(Object.keys(price_value).length !== 0) 
                {
                    $.ajax({
                        type: "POST",
                        url: "/products/save_calc_data.php",
                        data: price_value,
                        success: function(response) 
                        {
                            // console.log(response);
                            if(response.status == 200 && response.calculation_token){
                                $('#calculation_token').remove();
                                $('<input>').attr({
                                    type: 'hidden',
                                    id: 'calculation_token',
                                    name: 'calculation_token',
                                    value: response.calculation_token
                                }).appendTo('form#form');
                            }	
                        },error: function(xhr, status, error) {
                            console.log(error);
                        }	
                    });
                }
            }
			else
			{
				if((currentClick != "" && currentClick !== undefined) && (currentClick === "redirect"))
				{
					let price_items = setToInputManual();
					if(Object.keys(price_items).length !== 0) 
					{
						$.ajax({
							type: "POST",
							url: "/products/save_calc_data.php",
							data: price_items,
							success: function(response) 
							{
								// console.log(response);
								if(response.status == 200 && response.calculation_token){
									$('#calculation_token').remove();
									$('<input>').attr({
										type: 'hidden',
										id: 'calculation_token',
										name: 'calculation_token',
										value: response.calculation_token
									}).appendTo('form#form');
								}	
							},error: function(xhr, status, error) {
								console.log(error);
							}	
						});
					}
				}
			}
		}
	}

	function check_val(v) {
		var ItemType = $('input[name=ItemType]').val();

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

		// var err_pcs = document.getElementById('error_pcs');
		// err_pcs.style.display = "";

		// var err_color = document.getElementById('error_color');
		// err_color.style.display = "";

		// var pcs_opp = document.getElementsByClassName('ItemPCS');
		// var pcsChecked = false;

		// var colors = document.getElementsByClassName('ItemColors');
		// var colorChecked = false;

		// for (var i = 0; i < colors.length; i++) {
		// 	if (colors[i].checked) {
		// 		console.log(colors[i].value);
		// 		colorChecked = true;
		// 		break;
		// 	}
		// }
		
		// for (var i = 0; i < pcs_opp.length; i++) {
		// 	if (pcs_opp[i].checked) {
		// 		pcsChecked = true; 
		// 		break;
		// 	}
		// }

		// if (!pcsChecked) {
		// 	err_pcs.innerHTML = "このオプションを選択してください。";
		// 	return false;
		// } else {
		// 	err_pcs.style.display = "none";
		// }

		// if (!colorChecked) {
		// 	console.log("No color selected");
		// 	err_color.innerHTML = "このオプションを選択してください。";
		// 	return false;
		// } else {
		// 	console.log("Color selected");
		// 	err_color.style.display = "none";
		// }






		//エラー出力用id
		var err_number = document.getElementById('err_numberOf_mess');
		var mess = "";

		err_number.style.display = "";
		let dcp = $('input[name=ItemDesignVariation]:checked').val();

		let min_qty = 1;
		if (dcp == "2種類") {
			min_qty = 2;
		}

		if (dcp == "3種類") {
			min_qty = 3;
		}

		//入力値
		var vNumberOfOder = document.getElementById('no_of_order');

		if(vNumberOfOder.value < 20){
			$("input[name=SendPrototype]").prop('checked', false);
			$("input[name=SendPrototype]").removeAttr('checked');
			$("input[name=SendPrototype]").attr('disabled', true);
			$('#sample-error').text('試作品は20個以上のご注文から受付');
		} else {
			$('#sample-error').text('');
			$("input[name=SendPrototype]").attr('disabled', false);
		}

		if (vNumberOfOder.value < min_qty) {
			mess += "<font color='red'>本数は"+min_qty+"本以上で入力して下さい。</font>";
			err_number.innerHTML = mess;
			return false;
		}
		
		if ( isNaN(vNumberOfOder.value) ) {
			mess += "<font color='red'>半角数値以外が入力されています。</font>";
			err_number.innerHTML = mess;
			return false;
		} else if( vNumberOfOder.value == '' || vNumberOfOder.value < 1 ){
			mess += "<font color='red'>本数は1本以上で入力して下さい。</font>";
			err_number.innerHTML = mess;
			return false;
		} else if( vNumberOfOder.value > 1000 ){
			mess += "<font color='red'>本数は1,000本以下で入力して下さい。1,000以上のお客様は納期をメールにてお問い合わせ下さい。</font>";
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
	var mold_charge = 0;
	var trace_charge = 0;

	var parts_obj;
	var partPrice = 0;
	var paperPrice = 0;
	var unit_price = 0;

	function setToInput()
    {
		clearValue();
		var vno_of_order = document.getElementById('no_of_order');
		var fabricValue = $('input[name=FabricType]:checked').val();

		if(vno_of_order.value != "" && $('input[name=ItemSize]:checked').val() == "A2") { 

			if (fabricValue == '薄手シングルスエード')
			{
				if (vno_of_order.value >= 3000) {
					order_pcs = priceA1Single[8];
				} else if (vno_of_order.value >= 2000) {
					order_pcs = priceA1Single[7];
				} else if (vno_of_order.value >= 1000) {
					order_pcs = priceA1Single[6];
				} else if (vno_of_order.value >= 500) {
					order_pcs = priceA1Single[5];
				} else if (vno_of_order.value >= 300) {
					order_pcs = priceA1Single[4];
				} else if (vno_of_order.value >= 100) {
					order_pcs = priceA1Single[3];
				} else if (vno_of_order.value >= 50) {
					order_pcs = priceA1Single[2];
				} else if (vno_of_order.value >= 10) {
					order_pcs = priceA1Single[1];
				} else if (vno_of_order.value >= 1) {
					order_pcs = priceA1Single[0];
				}
			}
			else if (fabricValue == 'ダブルスエード')
			{
				if (vno_of_order.value >= 3000) {
					order_pcs = priceA1Double[8];
				} else if (vno_of_order.value >= 2000) {
					order_pcs = priceA1Double[7];
				} else if (vno_of_order.value >= 1000) {
					order_pcs = priceA1Double[6];
				} else if (vno_of_order.value >= 500) {
					order_pcs = priceA1Double[5];
				} else if (vno_of_order.value >= 300) {
					order_pcs = priceA1Double[4];
				} else if (vno_of_order.value >= 100) {
					order_pcs = priceA1Double[3];
				} else if (vno_of_order.value >= 50) {
					order_pcs = priceA1Double[2];
				} else if (vno_of_order.value >= 10) {
					order_pcs = priceA1Double[1];
				} else if (vno_of_order.value >= 1) {
					order_pcs = priceA1Double[0];
				}
			}
			else
			{
				if (vno_of_order.value >= 3000) {
					order_pcs = priceA1[8];
				} else if (vno_of_order.value >= 2000) {
					order_pcs = priceA1[7];
				} else if (vno_of_order.value >= 1000) {
					order_pcs = priceA1[6];
				} else if (vno_of_order.value >= 500) {
					order_pcs = priceA1[5];
				} else if (vno_of_order.value >= 300) {
					order_pcs = priceA1[4];
				} else if (vno_of_order.value >= 100) {
					order_pcs = priceA1[3];
				} else if (vno_of_order.value >= 50) {
					order_pcs = priceA1[2];
				} else if (vno_of_order.value >= 10) {
					order_pcs = priceA1[1];
				} else if (vno_of_order.value >= 1) {
					order_pcs = priceA1[0];
				}
			}
			
		}else if(vno_of_order.value != "" && $('input[name=ItemSize]:checked').val() == "B2") {

			if (fabricValue == '薄手シングルスエード')
			{
				if (vno_of_order.value >= 3000) {
					order_pcs = priceB2Single[8];
				} else if (vno_of_order.value >= 2000) {
					order_pcs = priceB2Single[7];
				} else if (vno_of_order.value >= 1000) {
					order_pcs = priceB2Single[6];
				} else if (vno_of_order.value >= 500) {
					order_pcs = priceB2Single[5];
				} else if (vno_of_order.value >= 300) {
					order_pcs = priceB2Single[4];
				} else if (vno_of_order.value >= 100) {
					order_pcs = priceB2Single[3];
				} else if (vno_of_order.value >= 50) {
					order_pcs = priceB2Single[2];
				} else if (vno_of_order.value >= 10) {
					order_pcs = priceB2Single[1];
				} else if (vno_of_order.value >= 1) {
					order_pcs = priceB2Single[0];
				}
			}
			else if (fabricValue == 'ダブルスエード')
			{
				if (vno_of_order.value >= 3000) {
					order_pcs = priceB2Double[8];
				} else if (vno_of_order.value >= 2000) {
					order_pcs = priceB2Double[7];
				} else if (vno_of_order.value >= 1000) {
					order_pcs = priceB2Double[6];
				} else if (vno_of_order.value >= 500) {
					order_pcs = priceB2Double[5];
				} else if (vno_of_order.value >= 300) {
					order_pcs = priceB2Double[4];
				} else if (vno_of_order.value >= 100) {
					order_pcs = priceB2Double[3];
				} else if (vno_of_order.value >= 50) {
					order_pcs = priceB2Double[2];
				} else if (vno_of_order.value >= 10) {
					order_pcs = priceB2Double[1];
				} else if (vno_of_order.value >= 1) {
					order_pcs = priceB2Double[0];
				}
			}
			else
			{
				if (vno_of_order.value >= 3000) {
					order_pcs = priceB2[8];
				} else if (vno_of_order.value >= 2000) {
					order_pcs = priceB2[7];
				} else if (vno_of_order.value >= 1000) {
					order_pcs = priceB2[6];
				} else if (vno_of_order.value >= 500) {
					order_pcs = priceB2[5];
				} else if (vno_of_order.value >= 300) {
					order_pcs = priceB2[4];
				} else if (vno_of_order.value >= 100) {
					order_pcs = priceB2[3];
				} else if (vno_of_order.value >= 50) {
					order_pcs = priceB2[2];
				} else if (vno_of_order.value >= 10) {
					order_pcs = priceB2[1];
				} else if (vno_of_order.value >= 1) {
					order_pcs = priceB2[0];
				}
			}

		} else if(vno_of_order.value != "" && $('input[name=ItemSize]:checked').val() == "B1") {

			if (fabricValue == '薄手シングルスエード')
			{
				if (vno_of_order.value >= 3000) {
					order_pcs = priceB1Single[8];
				} else if (vno_of_order.value >= 2000) {
					order_pcs = priceB1Single[7];
				} else if (vno_of_order.value >= 1000) {
					order_pcs = priceB1Single[6];
				} else if (vno_of_order.value >= 500) {
					order_pcs = priceB1Single[5];
				} else if (vno_of_order.value >= 300) {
					order_pcs = priceB1Single[4];
				} else if (vno_of_order.value >= 100) {
					order_pcs = priceB1Single[3];
				} else if (vno_of_order.value >= 50) {
					order_pcs = priceB1Single[2];
				} else if (vno_of_order.value >= 10) {
					order_pcs = priceB1Single[1];
				} else if (vno_of_order.value >= 1) {
					order_pcs = priceB1Single[0];
				}
			}
			else if (fabricValue == 'ダブルスエード')
			{
				if (vno_of_order.value >= 3000) {
					order_pcs = priceB1Double[8];
				} else if (vno_of_order.value >= 2000) {
					order_pcs = priceB1Double[7];
				} else if (vno_of_order.value >= 1000) {
					order_pcs = priceB1Double[6];
				} else if (vno_of_order.value >= 500) {
					order_pcs = priceB1Double[5];
				} else if (vno_of_order.value >= 300) {
					order_pcs = priceB1Double[4];
				} else if (vno_of_order.value >= 100) {
					order_pcs = priceB1Double[3];
				} else if (vno_of_order.value >= 50) {
					order_pcs = priceB1Double[2];
				} else if (vno_of_order.value >= 10) {
					order_pcs = priceB1Double[1];
				} else if (vno_of_order.value >= 1) {
					order_pcs = priceB1Double[0];
				}
			}
			else
			{
				if (vno_of_order.value >= 3000) {
					order_pcs = priceB1[8];
				} else if (vno_of_order.value >= 2000) {
					order_pcs = priceB1[7];
				} else if (vno_of_order.value >= 1000) {
					order_pcs = priceB1[6];
				} else if (vno_of_order.value >= 500) {
					order_pcs = priceB1[5];
				} else if (vno_of_order.value >= 300) {
					order_pcs = priceB1[4];
				} else if (vno_of_order.value >= 100) {
					order_pcs = priceB1[3];
				} else if (vno_of_order.value >= 50) {
					order_pcs = priceB1[2];
				} else if (vno_of_order.value >= 10) {
					order_pcs = priceB1[1];
				} else if (vno_of_order.value >= 1) {
					order_pcs = priceB1[0];
				}
			}
		}


		$('#sample-prd-pcs').text($('input[name=ItemPCS]:checked').val());
		$('#prd_ItemPCS').text($('input[name=ItemSize]:checked').val());

		if($('input[name=ItemPCS]:checked').val() == "フルカラータイプ") {
			mold_charge = 6600;
		}else{
			mold_charge = 0;
		}

		$('#sample-prd-color').text($('input[name=ItemColors]:checked').val());
		$('#prd_ItemColors').text($('input[name=ItemColors]:checked').val());
		$('#sample-fablic').text($('input[name=FabricType]:checked').val());
		$('#prd_fablic').text($('input[name=FabricType]:checked').val());

		$('#sample-prd-size').text($('input[name=ItemSize]:checked').val());

		$('#sample-prd-qty').text(vno_of_order.value);
		$('#prd_qty').text(vno_of_order.value);


		if($('input[name=ItemDesignVariation]:checked').val()!=undefined){
			$('#prd_DesignVa').text($('input[name=ItemDesignVariation]:checked').val());
		}


		if($('input[name=SendPrototype]:checked').val()!=undefined){

			// if(vno_of_order.value < 20){
			// 	proto_charge = 1200;
			// }else{
			// 	proto_charge = 0;
			// }

			proto_charge = 7500;

			// proto_charge = 0;
			$('#sample-prd-samp').text('あり');
			$('#prd_SendPrototype').text('あり');
		}else{
			$('#sample-prd-samp').text('なし');
			$('#prd_SendPrototype').text('なし');
		}

		if($('input[name=DeFormat]:checked').val()!=undefined){
			$('#sample-prd-trace').text('あり');
			$('#prd_DeFormat').text('あり');
			trace_charge = 2200;
		}else{
			$('#sample-prd-trace').text('なし');
			$('#prd_DeFormat').text('なし');
			trace_charge = 0;
		}

		if($('input[name=ItemOPP]:checked').val()!=undefined){
			opp_price = 8;
			$('#sample-prd-opp').text('あり');
			$('#prd_ItemOPP').text('あり');
		}else{
			opp_price = 0;
			$('#sample-prd-opp').text('なし');
			$('#prd_ItemOPP').text('なし');
		}

		$('#prd_qty').text(vno_of_order.value);
		$('#sample-prd-qty').text(vno_of_order.value);

		console.log("Before: "+ order_pcs);

		//Add vat to unit price
		var inc_vat = parseInt(order_pcs * 10) / 100;
		var inc_vat2 = Math.floor(order_pcs * 10) / 100;
		// order_pcs = Math.floor(order_pcs + inc_vat);
        order_pcs = Math.floor(order_pcs );

		// console.log("Vat1 : " + inc_vat);
		// console.log("Vat2 : " + inc_vat2);
		// console.log("After: " + order_pcs);

		// Assign Value
		TextField7Value = Math.floor(order_pcs)*vno_of_order.value;

		// Amount Before Tax
		// TextField9Value = parseInt(TextField7Value) + trace_charge + proto_charge + (opp_price*vno_of_order.value) + mold_charge;
		TextField9Value = parseInt(TextField7Value) + trace_charge + proto_charge;

		DisPrice = 0;

		// tax = Math.floor(Math.floor((TextField7Value)*vat/(100+vat)) + Math.floor(trace_charge*vat/(100+vat)) + Math.floor(proto_charge*vat/(100+vat))) - Math.floor(DisPrice*vat/(100+vat));
		tax = Math.floor(Math.floor(trace_charge*vat/(100+vat)) + Math.floor(proto_charge*vat/(100+vat))) - Math.floor(DisPrice*vat/(100+vat));

		// tax = tax - Math.floor(tax*vat/100);
		total = (parseInt(TextField9Value)-parseInt(DisPrice));

		document.getElementById('prd_mold_price').value = (mold_charge).toLocaleString("en");
		document.getElementById('prd_trace_price').value = (trace_charge).toLocaleString("en");
		document.getElementById('prd_sample_price').value = (proto_charge).toLocaleString("en");
		// document.getElementById('prd_opp_price').value = (opp_price*vno_of_order.value).toLocaleString("en");

		document.getElementById('prd_price').value = (TextField7Value).toLocaleString("en");

		// document.getElementById('textfield8').value = formatMoney(shipping_charge);
		document.getElementById('prd_sub_total').value = (parseInt(TextField9Value)).toLocaleString("en");
		document.getElementById('discount').value = (parseInt(DisPrice)).toLocaleString("en");
		// document.getElementById('textfield10').value = formatMoney(tax);
		document.getElementById('prd_total').value = (total).toLocaleString("en");
		$('.prd_total').text(formatMoney(total).toLocaleString("en"));
		// document.getElementById('textfield12').value = formatMoney(printumu);
    }

    //New condition check price adapt
    function setToInputManual() 
    {
        clearValue();
        var vno_of_order = document.getElementById('no_of_order');
        var prd = $('#strap').val();
		var fabricValue = $('input[name=FabricType]:checked').val();
    
        if(vno_of_order.value != "" && $('input[name=ItemSize]:checked').val() == "A2") { 

			if (fabricValue == '薄手シングルスエード')
			{
				if (vno_of_order.value >= 3000) {
					order_pcs = priceA1Single[8];
				} else if (vno_of_order.value >= 2000) {
					order_pcs = priceA1Single[7];
				} else if (vno_of_order.value >= 1000) {
					order_pcs = priceA1Single[6];
				} else if (vno_of_order.value >= 500) {
					order_pcs = priceA1Single[5];
				} else if (vno_of_order.value >= 300) {
					order_pcs = priceA1Single[4];
				} else if (vno_of_order.value >= 100) {
					order_pcs = priceA1Single[3];
				} else if (vno_of_order.value >= 50) {
					order_pcs = priceA1Single[2];
				} else if (vno_of_order.value >= 10) {
					order_pcs = priceA1Single[1];
				} else if (vno_of_order.value >= 1) {
					order_pcs = priceA1Single[0];
				}
			}
			else if (fabricValue == 'ダブルスエード')
			{
				if (vno_of_order.value >= 3000) {
					order_pcs = priceA1Double[8];
				} else if (vno_of_order.value >= 2000) {
					order_pcs = priceA1Double[7];
				} else if (vno_of_order.value >= 1000) {
					order_pcs = priceA1Double[6];
				} else if (vno_of_order.value >= 500) {
					order_pcs = priceA1Double[5];
				} else if (vno_of_order.value >= 300) {
					order_pcs = priceA1Double[4];
				} else if (vno_of_order.value >= 100) {
					order_pcs = priceA1Double[3];
				} else if (vno_of_order.value >= 50) {
					order_pcs = priceA1Double[2];
				} else if (vno_of_order.value >= 10) {
					order_pcs = priceA1Double[1];
				} else if (vno_of_order.value >= 1) {
					order_pcs = priceA1Double[0];
				}
			}
			else
			{
				if (vno_of_order.value >= 3000) {
					order_pcs = priceA1[8];
				} else if (vno_of_order.value >= 2000) {
					order_pcs = priceA1[7];
				} else if (vno_of_order.value >= 1000) {
					order_pcs = priceA1[6];
				} else if (vno_of_order.value >= 500) {
					order_pcs = priceA1[5];
				} else if (vno_of_order.value >= 300) {
					order_pcs = priceA1[4];
				} else if (vno_of_order.value >= 100) {
					order_pcs = priceA1[3];
				} else if (vno_of_order.value >= 50) {
					order_pcs = priceA1[2];
				} else if (vno_of_order.value >= 10) {
					order_pcs = priceA1[1];
				} else if (vno_of_order.value >= 1) {
					order_pcs = priceA1[0];
				}
			}
			
		}else if(vno_of_order.value != "" && $('input[name=ItemSize]:checked').val() == "B2") {

			if (fabricValue == '薄手シングルスエード')
			{
				if (vno_of_order.value >= 3000) {
					order_pcs = priceB2Single[8];
				} else if (vno_of_order.value >= 2000) {
					order_pcs = priceB2Single[7];
				} else if (vno_of_order.value >= 1000) {
					order_pcs = priceB2Single[6];
				} else if (vno_of_order.value >= 500) {
					order_pcs = priceB2Single[5];
				} else if (vno_of_order.value >= 300) {
					order_pcs = priceB2Single[4];
				} else if (vno_of_order.value >= 100) {
					order_pcs = priceB2Single[3];
				} else if (vno_of_order.value >= 50) {
					order_pcs = priceB2Single[2];
				} else if (vno_of_order.value >= 10) {
					order_pcs = priceB2Single[1];
				} else if (vno_of_order.value >= 1) {
					order_pcs = priceB2Single[0];
				}
			}
			else if (fabricValue == 'ダブルスエード')
			{
				if (vno_of_order.value >= 3000) {
					order_pcs = priceB2Double[8];
				} else if (vno_of_order.value >= 2000) {
					order_pcs = priceB2Double[7];
				} else if (vno_of_order.value >= 1000) {
					order_pcs = priceB2Double[6];
				} else if (vno_of_order.value >= 500) {
					order_pcs = priceB2Double[5];
				} else if (vno_of_order.value >= 300) {
					order_pcs = priceB2Double[4];
				} else if (vno_of_order.value >= 100) {
					order_pcs = priceB2Double[3];
				} else if (vno_of_order.value >= 50) {
					order_pcs = priceB2Double[2];
				} else if (vno_of_order.value >= 10) {
					order_pcs = priceB2Double[1];
				} else if (vno_of_order.value >= 1) {
					order_pcs = priceB2Double[0];
				}
			}
			else
			{
				if (vno_of_order.value >= 3000) {
					order_pcs = priceB2[8];
				} else if (vno_of_order.value >= 2000) {
					order_pcs = priceB2[7];
				} else if (vno_of_order.value >= 1000) {
					order_pcs = priceB2[6];
				} else if (vno_of_order.value >= 500) {
					order_pcs = priceB2[5];
				} else if (vno_of_order.value >= 300) {
					order_pcs = priceB2[4];
				} else if (vno_of_order.value >= 100) {
					order_pcs = priceB2[3];
				} else if (vno_of_order.value >= 50) {
					order_pcs = priceB2[2];
				} else if (vno_of_order.value >= 10) {
					order_pcs = priceB2[1];
				} else if (vno_of_order.value >= 1) {
					order_pcs = priceB2[0];
				}
			}

		} else if(vno_of_order.value != "" && $('input[name=ItemSize]:checked').val() == "B1") {

			if (fabricValue == '薄手シングルスエード')
			{
				if (vno_of_order.value >= 3000) {
					order_pcs = priceB1Single[8];
				} else if (vno_of_order.value >= 2000) {
					order_pcs = priceB1Single[7];
				} else if (vno_of_order.value >= 1000) {
					order_pcs = priceB1Single[6];
				} else if (vno_of_order.value >= 500) {
					order_pcs = priceB1Single[5];
				} else if (vno_of_order.value >= 300) {
					order_pcs = priceB1Single[4];
				} else if (vno_of_order.value >= 100) {
					order_pcs = priceB1Single[3];
				} else if (vno_of_order.value >= 50) {
					order_pcs = priceB1Single[2];
				} else if (vno_of_order.value >= 10) {
					order_pcs = priceB1Single[1];
				} else if (vno_of_order.value >= 1) {
					order_pcs = priceB1Single[0];
				}
			}
			else if (fabricValue == 'ダブルスエード')
			{
				if (vno_of_order.value >= 3000) {
					order_pcs = priceB1Double[8];
				} else if (vno_of_order.value >= 2000) {
					order_pcs = priceB1Double[7];
				} else if (vno_of_order.value >= 1000) {
					order_pcs = priceB1Double[6];
				} else if (vno_of_order.value >= 500) {
					order_pcs = priceB1Double[5];
				} else if (vno_of_order.value >= 300) {
					order_pcs = priceB1Double[4];
				} else if (vno_of_order.value >= 100) {
					order_pcs = priceB1Double[3];
				} else if (vno_of_order.value >= 50) {
					order_pcs = priceB1Double[2];
				} else if (vno_of_order.value >= 10) {
					order_pcs = priceB1Double[1];
				} else if (vno_of_order.value >= 1) {
					order_pcs = priceB1Double[0];
				}
			}
			else
			{
				if (vno_of_order.value >= 3000) {
					order_pcs = priceB1[8];
				} else if (vno_of_order.value >= 2000) {
					order_pcs = priceB1[7];
				} else if (vno_of_order.value >= 1000) {
					order_pcs = priceB1[6];
				} else if (vno_of_order.value >= 500) {
					order_pcs = priceB1[5];
				} else if (vno_of_order.value >= 300) {
					order_pcs = priceB1[4];
				} else if (vno_of_order.value >= 100) {
					order_pcs = priceB1[3];
				} else if (vno_of_order.value >= 50) {
					order_pcs = priceB1[2];
				} else if (vno_of_order.value >= 10) {
					order_pcs = priceB1[1];
				} else if (vno_of_order.value >= 1) {
					order_pcs = priceB1[0];
				}
			}
		}
    
    
        $('#sample-prd-pcs').text($('input[name=ItemPCS]:checked').val());
        $('#prd_ItemPCS').text($('input[name=ItemSize]:checked').val());
    
        if ($('input[name=ItemPCS]:checked').val() == "フルカラータイプ") {
            mold_charge = 6600;
        } else {
            mold_charge = 0;
        }
    
        $('#sample-prd-color').text($('input[name=ItemColors]:checked').val());
        $('#prd_ItemColors').text($('input[name=ItemColors]:checked').val());
    
        $('#sample-prd-size').text($('input[name=ItemSize]:checked').val());
    
        $('#sample-prd-qty').text(vno_of_order.value);
        $('#prd_qty').text(vno_of_order.value);
    
        if ($('input[name=SendPrototype]:checked').val() != undefined) {
    
            // if(vno_of_order.value < 20){
            // 	proto_charge = 1200;
            // }else{
            // 	proto_charge = 0;
            // }
    
            proto_charge = 7500;
    
            // proto_charge = 0;
            $('#sample-prd-samp').text('あり');
            $('#prd_SendPrototype').text('あり');
        } else {
            $('#sample-prd-samp').text('なし');
            $('#prd_SendPrototype').text('なし');
        }
    
        if ($('input[name=DeFormat]:checked').val() != undefined) {
            $('#sample-prd-trace').text('あり');
            $('#prd_DeFormat').text('あり');
            trace_charge = 2200;
        } else {
            $('#sample-prd-trace').text('なし');
            $('#prd_DeFormat').text('なし');
            trace_charge = 0;
        }
    
        if ($('input[name=ItemOPP]:checked').val() != undefined) {
            opp_price = 8;
            $('#sample-prd-opp').text('あり');
            $('#prd_ItemOPP').text('あり');
        } else {
            opp_price = 0;
            $('#sample-prd-opp').text('なし');
            $('#prd_ItemOPP').text('なし');
        }
    
        $('#prd_qty').text(vno_of_order.value);
        $('#sample-prd-qty').text(vno_of_order.value);
    
        // console.log("Before: "+ order_pcs);
    
        //Add vat to unit price
        var inc_vat = parseInt(order_pcs * 10) / 100;
        // order_pcs = Math.floor(order_pcs + inc_vat);
        order_pcs = Math.floor(order_pcs);
    
        // console.log("After: " + order_pcs);
        // return false;
    
        // Assign Value
        TextField7Value = Math.floor(order_pcs) * vno_of_order.value;
    
        // Amount Before Tax
        // TextField9Value = parseInt(TextField7Value) + trace_charge + proto_charge + (opp_price*vno_of_order.value) + mold_charge;
        TextField9Value = parseInt(TextField7Value) + trace_charge + proto_charge;
    
        DisPrice = 0;
    
        // tax = Math.floor(Math.floor((TextField7Value)*vat/(100+vat)) + Math.floor(trace_charge*vat/(100+vat)) + Math.floor(proto_charge*vat/(100+vat))) - Math.floor(DisPrice*vat/(100+vat));
        tax = Math.floor(Math.floor(trace_charge * vat / (100 + vat)) + Math.floor(proto_charge * vat / (100 + vat))) - Math.floor(DisPrice * vat / (100 + vat));
    
        // tax = tax - Math.floor(tax*vat/100);
        total = (parseInt(TextField9Value) - parseInt(DisPrice));
    
        document.getElementById('prd_mold_price').value = (mold_charge).toLocaleString("en");
        document.getElementById('prd_trace_price').value = (trace_charge).toLocaleString("en");
        document.getElementById('prd_sample_price').value = (proto_charge).toLocaleString("en");
        // document.getElementById('prd_opp_price').value = (opp_price*vno_of_order.value).toLocaleString("en");
    
        document.getElementById('prd_price').value = (TextField7Value).toLocaleString("en");
    
        // document.getElementById('textfield8').value = formatMoney(shipping_charge);
        document.getElementById('prd_sub_total').value = (parseInt(TextField9Value)).toLocaleString("en");
        document.getElementById('discount').value = (parseInt(DisPrice)).toLocaleString("en");
        // document.getElementById('textfield10').value = formatMoney(tax);
        document.getElementById('prd_total').value = (total).toLocaleString("en");
        $('.prd_total').text(formatMoney(total).toLocaleString("en"));
        // document.getElementById('textfield12').value = formatMoney(printumu);

        let shipping_price = 880;
        if (TextField9Value > 11000) {
            shipping_price = 0;
        }

        let sku_name = "";
        if (prd == "オリジナルタペストリー") {
            sku_name = 'tapestry';
        }

        if (sku_name != "")
        {
            return {
                sku: sku_name,
                product: prd,
                qty: vno_of_order.value,
                product_price: TextField7Value,
                mold_price: mold_charge,
                part_price: 0,
                backside_price: 0,
                paper_price: 0,
                prototype_price: proto_charge,
                ai_assistant_price: 0,
                trace_price: trace_charge,
                opp_price: 0,
                process_price: 0,
                color_price: 0,
                print_price: 0,
                coating_price: 0,
                packing_price: 0,
                carabiner_price: 0,
                material_price: 0,
                design_price: 0,
                discount: parseInt(DisPrice),
                shipping: shipping_price,
                vat: 0,
                tax: tax,
                subtotal: TextField9Value,
                total: total
            };
        }
    }

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
	mold_charge = 0;
	trace_charge = 0;
	design_price = 0;

	// document.getElementById('prd_opp_price').value = "";
	document.getElementById('prd_sample_price').value = "";
	document.getElementById('prd_trace_price').value = "";

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
	mold_charge = 0;
	trace_charge = 0;
	design_price = 0;

	// document.getElementById('prd_opp_price').value = "";
	document.getElementById('prd_trace_price').value = "";
	document.getElementById('prd_sample_price').value = "";

	document.getElementById('prd_mold_price').value = "";

	document.getElementById('prd_price').value = "";
	document.getElementById('prd_sub_total').value = "";
	document.getElementById('prd_total').value = "";

	$("input[name=ItemPCS]:first").prop('checked', true);
	
	$("input[name=SendPrototype]").prop('checked', false);
	$("input[name=DeFormat]").prop('checked', false);
	$("input[name=ItemOPP]").prop('checked', false);

	document.getElementById('no_of_order').value = "";
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

function formatNumber(number) {
	if (number >= 0 && number <= 8) {
			// Add leading zero for numbers between 0 and 9
			return '0' + (number+1);
	} else if (number >= 9) {
			// Numbers between 10 and 22 remain unchanged
			return '' + (number+1);
	}
}