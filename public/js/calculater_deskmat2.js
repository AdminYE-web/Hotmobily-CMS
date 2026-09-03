	// フライトタグ（刺繍タグキーホルダー）

    var priceA = [1069, 1075, 1068, 915, 818, 806];
    var priceB = [1069, 1075, 1076, 980, 925, 913];
	
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
            let currentClick = $(event.target).text(); 

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
		
		if ( isNaN(vNumberOfOder.value) ) {
			mess += "<font color='red'>半角数値以外が入力されています。</font>";
			err_number.innerHTML = mess;
			return false;
		} else if( vNumberOfOder.value == '' || vNumberOfOder.value < 30 ){
			mess += "<font color='red'>本数は30本以上で入力して下さい。</font>";
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

	function setToInput(){
		clearValue();
		var vno_of_order = document.getElementById('no_of_order');

		if(vno_of_order.value != "" && $('input[name=ItemSize]:checked').val() == "300x550mm") { 

			if (vno_of_order.value >= 1000) {
				order_pcs = priceA[5];
			} else if (vno_of_order.value >= 500) {
				order_pcs = priceA[4];
			} else if (vno_of_order.value >= 300) {
				order_pcs = priceA[3];
			} else if (vno_of_order.value >= 100) {
				order_pcs = priceA[2];
			} else if (vno_of_order.value >= 50) {
				order_pcs = priceA[1];
			} else if (vno_of_order.value >= 30) {
				order_pcs = priceA[0];
			}
			
		}else if(vno_of_order.value != "" && $('input[name=ItemSize]:checked').val() == "350x600mm") {

			if (vno_of_order.value >= 1000) {
				order_pcs = priceB[5];
			} else if (vno_of_order.value >= 500) {
				order_pcs = priceB[4];
			} else if (vno_of_order.value >= 300) {
				order_pcs = priceB[3];
			} else if (vno_of_order.value >= 100) {
				order_pcs = priceB[2];
			} else if (vno_of_order.value >= 50) {
				order_pcs = priceB[1];
			} else if (vno_of_order.value >= 30) {
				order_pcs = priceB[0];
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

		$('#sample-prd-size').text($('input[name=ItemSize]:checked').val());

        if($('input[name=shape_processing]').length && $('input[name=shape_processing]:checked').val()!=undefined){
            $('#sample-processing').text($('input[name=shape_processing]:checked').val());
            $('#prd_Processing').text($('input[name=shape_processing]:checked').val());
        }

		$('#sample-prd-qty').text(vno_of_order.value);
		$('#prd_qty').text(vno_of_order.value);

		if($('input[name=SendPrototype]:checked').val()!=undefined){

			// if(vno_of_order.value < 20){
			// 	proto_charge = 1200;
			// }else{
			// 	proto_charge = 0;
			// }

			proto_charge = 7700;

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

		var coating_price = 0;
		if ($('input[name=shape_processing]:checked').val() == "ロック縫いあり") {
			coating_price = (20 * vno_of_order.value);
		}	

		// console.log("Before: "+ order_pcs);

		//Add vat to unit price
		var inc_vat = parseInt(order_pcs * 10) / 100;
		// order_pcs = Math.floor(order_pcs + inc_vat);
		order_pcs = Math.floor(order_pcs);

		// console.log("After: " + order_pcs);
		// return false;

		// Assign Value
		TextField7Value = Math.floor(order_pcs)*vno_of_order.value;

		// Amount Before Tax
		// TextField9Value = parseInt(TextField7Value) + trace_charge + proto_charge + (opp_price*vno_of_order.value) + mold_charge;
		TextField9Value = parseInt(TextField7Value) + trace_charge + proto_charge;

		DisPrice = 0;

		// tax = Math.floor(Math.floor((TextField7Value)*vat/(100+vat)) + Math.floor(trace_charge*vat/(100+vat)) + Math.floor(proto_charge*vat/(100+vat))) - Math.floor(DisPrice*vat/(100+vat));
		tax = Math.floor(Math.floor(trace_charge*vat/(100+vat)) + Math.floor(proto_charge*vat/(100+vat))) - Math.floor(DisPrice*vat/(100+vat));

		// tax = tax - Math.floor(tax*vat/100);
		total = ( (parseInt(TextField9Value)-parseInt(DisPrice)) + parseInt(coating_price) );

		document.getElementById('coating_shape_price').value = (coating_price).toLocaleString("en");
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
    };

    function setToInputManual(){
		clearValue();
		var vno_of_order = document.getElementById('no_of_order');
        var prd = $('#strap').val();

		if(vno_of_order.value != "" && $('input[name=ItemSize]:checked').val() == "300x550mm") { 

			if (vno_of_order.value >= 1000) {
				order_pcs = priceA[5];
			} else if (vno_of_order.value >= 500) {
				order_pcs = priceA[4];
			} else if (vno_of_order.value >= 300) {
				order_pcs = priceA[3];
			} else if (vno_of_order.value >= 100) {
				order_pcs = priceA[2];
			} else if (vno_of_order.value >= 50) {
				order_pcs = priceA[1];
			} else if (vno_of_order.value >= 30) {
				order_pcs = priceA[0];
			}
			
		}else if(vno_of_order.value != "" && $('input[name=ItemSize]:checked').val() == "350x600mm") {

			if (vno_of_order.value >= 1000) {
				order_pcs = priceB[5];
			} else if (vno_of_order.value >= 500) {
				order_pcs = priceB[4];
			} else if (vno_of_order.value >= 300) {
				order_pcs = priceB[3];
			} else if (vno_of_order.value >= 100) {
				order_pcs = priceB[2];
			} else if (vno_of_order.value >= 50) {
				order_pcs = priceB[1];
			} else if (vno_of_order.value >= 30) {
				order_pcs = priceB[0];
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

		$('#sample-prd-size').text($('input[name=ItemSize]:checked').val());

        if($('input[name=shape_processing]').length && $('input[name=shape_processing]:checked').val()!=undefined){
            $('#sample-processing').text($('input[name=shape_processing]:checked').val());
            $('#prd_Processing').text($('input[name=shape_processing]:checked').val());
        }

		$('#sample-prd-qty').text(vno_of_order.value);
		$('#prd_qty').text(vno_of_order.value);

		if($('input[name=SendPrototype]:checked').val()!=undefined){

			// if(vno_of_order.value < 20){
			// 	proto_charge = 1200;
			// }else{
			// 	proto_charge = 0;
			// }

			proto_charge = 7700;

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

        let have_coating = false;
		var coating_price = 0;
		if ($('input[name=shape_processing]:checked').val() == "ロック縫いあり") {
			coating_price = (20 * vno_of_order.value);
            have_coating = true;
		}	

		// console.log("Before: "+ order_pcs);

		//Add vat to unit price
		var inc_vat = parseInt(order_pcs * 10) / 100;
		// order_pcs = Math.floor(order_pcs + inc_vat);
		order_pcs = Math.floor(order_pcs);

		// console.log("After: " + order_pcs);
		// return false;

		// Assign Value
		TextField7Value = Math.floor(order_pcs)*vno_of_order.value;

		// Amount Before Tax
		// TextField9Value = parseInt(TextField7Value) + trace_charge + proto_charge + (opp_price*vno_of_order.value) + mold_charge;
		TextField9Value = parseInt(TextField7Value) + trace_charge + proto_charge;

		DisPrice = 0;

		// tax = Math.floor(Math.floor((TextField7Value)*vat/(100+vat)) + Math.floor(trace_charge*vat/(100+vat)) + Math.floor(proto_charge*vat/(100+vat))) - Math.floor(DisPrice*vat/(100+vat));
		tax = Math.floor(Math.floor(trace_charge*vat/(100+vat)) + Math.floor(proto_charge*vat/(100+vat))) - Math.floor(DisPrice*vat/(100+vat));

		// tax = tax - Math.floor(tax*vat/100);
		total = ( (parseInt(TextField9Value)-parseInt(DisPrice)) + parseInt(coating_price) );

		document.getElementById('coating_shape_price').value = (coating_price).toLocaleString("en");
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

        return {
            sku: 'deskmat',
            product: prd,
            qty: vno_of_order.value,
            product_price: TextField7Value,
            mold_price: 0,
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
            coating_price: (have_coating ? coating_price : 0),
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