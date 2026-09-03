var price_strap_standard = [811,662,512,450,251,158,140];
var price_strap_premium = [975,796,616,540,302,191,168];

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

var carabiner_O = [56,52,48,41,35,28,27];
var carabiner_M = [149,137,124,112,90,70,67];
var carabiner_L = [214,196,177,161,128,99,94];

var parts_obj;
var paperPrice = 0;
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
			case "カラビナ・オプション入力へ":
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
				$('#next').text('カラビナ・オプション入力へ');
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

	//エラー出力用id
	var err_number = document.getElementById('err_numberOf_mess');
	var mess = "";

	err_number.style.display = "";

	//入力値
	var vNumberOfOder = $('#no_of_order');

	if($('input[name=ItemDesignVariation]').length){
		switch($('input[name=ItemDesignVariation]:checked').val()){
			case "1種類":
			case "2種類":
				if( vNumberOfOder.val() == '' || vNumberOfOder.val() < 100 ){
					mess += "<font color='red'>本数は100本以上で入力して下さい。</font>";
					err_number.innerHTML = mess;
					return false;
				}
			break;
			case "3種類":
				if( vNumberOfOder.val() == '' || vNumberOfOder.val() < 150 ){
					mess += "<font color='red'>本数は150本以上で入力して下さい。</font>";
					err_number.innerHTML = mess;
					return false;
				}
			break;
			case "4種類":
				if( vNumberOfOder.val() == '' || vNumberOfOder.val() < 200 ){
					mess += "<font color='red'>本数は200本以上で入力して下さい。</font>";
					err_number.innerHTML = mess;
					return false;
				}
			break;
		}
	}
	
	if($('input[name=ItemPCS]:checked').val() == "スタンダード（スピード7営業日発送）"){
		if( vNumberOfOder.val() == '' || vNumberOfOder.val() > 200 ){
			mess += "<font color='red'>本数は200本以下で入力して下さい。</font>";
			err_number.innerHTML = mess;
			return false;
		}
	}

	if(v=='next'){
		if(!validation_numberOf() && $('input[name=ItemPCS]:checked').val()!="ホットモバイリーファン"){
			return false;
		}else{

			$('#err_numberOf_mess').hide();
			if($('input[name=ItemPCS]').length && $('input[name=ItemPCS]:checked').val()==undefined){
				$('#error_pcs').text('【必須】ご注文タイプをご選択ください');
				return false;
			}else if($('input[name=silk_print]').length && ItemType != "ラバータグ" && ItemType != "ペットボトルホルダー" && $('input[name=silk_print]:checked').val()==undefined){
				$('#error_print').text('【必須】裏面シルク印刷の有無をご選択ください');
				return false;
			}else if($('input[name=coating]').length && $('input[name=coating]:checked').val()==undefined){
				$('#error_coating').text('【必須】汚れ防止加工の有無をご選択ください');
				return false;
			}else{
				$('#error_pcs').text('');
				$('#error_print').text('');
				if($('input[name=coating]').length){
					$('#error_coating').text('');
				}
				setToInput();
				return true;
			}
		}
	}else{
		return true;
	}
}

var price_bracket = 0;
var packing_price = 0;
var proto_shipping_charge = 0;
var order_pcs = 0;
var unit_price = 0;
var strap_price = 0;
var before_tax = 0;
var tax = 0;
var vat = 10;
var total = 0;
var silkprint = 0;
var partPrice = 0;
var carabiner_print = 0;
var TextField7Value = 0;
var TextField9Value = 0;
var DisPrice = 0;
var proto_charge = 0;
var trace_charge = 0;
var print_charge = 0;
var coating_charge = 0;

var DesignsCharge = 0;
var MaterialCharge = 0;


function setToInput()
{
	clearValue();
	var ItemType = $('input[name=ItemType]').val();
	var vno_of_order = document.getElementById('no_of_order');

	// Get part price
	if($('input[name="part"]').length){
		var part = $('input[name="part"]:checked').val();

		if(part!=undefined ){
			switch(part){
				case "廉価版カラビナ":
					if (vno_of_order.value >= 5000) partPrice = Math.floor(carabiner_O[6]*(1+vat/100));
					else if (vno_of_order.value >= 3000) partPrice = Math.floor(carabiner_O[5]*(1+vat/100));
					else if (vno_of_order.value >= 1000) partPrice = Math.floor(carabiner_O[4]*(1+vat/100));
					else if (vno_of_order.value >= 500) partPrice = Math.floor(carabiner_O[3]*(1+vat/100));
					else if (vno_of_order.value >= 300) partPrice = Math.floor(carabiner_O[2]*(1+vat/100));
					else if (vno_of_order.value >= 200) partPrice = Math.floor(carabiner_O[1]*(1+vat/100));
					else if (vno_of_order.value >= 100) partPrice = Math.floor(carabiner_O[0]*(1+vat/100));
				break;
				case "高級版Mサイズ":
					if (vno_of_order.value >= 5000) partPrice = Math.floor(carabiner_M[6]*(1+vat/100));
					else if (vno_of_order.value >= 3000) partPrice = Math.floor(carabiner_M[5]*(1+vat/100));
					else if (vno_of_order.value >= 1000) partPrice = Math.floor(carabiner_M[4]*(1+vat/100));
					else if (vno_of_order.value >= 500) partPrice = Math.floor(carabiner_M[3]*(1+vat/100));
					else if (vno_of_order.value >= 300) partPrice = Math.floor(carabiner_M[2]*(1+vat/100));
					else if (vno_of_order.value >= 200) partPrice = Math.floor(carabiner_M[1]*(1+vat/100));
					else if (vno_of_order.value >= 100) partPrice = Math.floor(carabiner_M[0]*(1+vat/100));
				break;
				case "高級版Lサイズ":
					if (vno_of_order.value >= 5000) partPrice = Math.floor(carabiner_L[6]*(1+vat/100));
					else if (vno_of_order.value >= 3000) partPrice = Math.floor(carabiner_L[5]*(1+vat/100));
					else if (vno_of_order.value >= 1000) partPrice = Math.floor(carabiner_L[4]*(1+vat/100));
					else if (vno_of_order.value >= 500) partPrice = Math.floor(carabiner_L[3]*(1+vat/100));
					else if (vno_of_order.value >= 300) partPrice = Math.floor(carabiner_L[2]*(1+vat/100));
					else if (vno_of_order.value >= 200) partPrice = Math.floor(carabiner_L[1]*(1+vat/100));
					else if (vno_of_order.value >= 100) partPrice = Math.floor(carabiner_L[0]*(1+vat/100));
				break;
			}

			$('#sample-part-name').text(parts_obj["part_name"]);
			if(part != "カラビナなし"){
				$('#sample-part-pic').html('<img width="135" height="135" id="sample-part-pic" class="picpro" src="'+parts_obj["part_pic"]+'">');
			}else{
				$('#sample-part-pic').html('');
			}

			if(part != "" && part != "廉価版カラビナ" && part != "カラビナなし"){
				$('.carabiner-printng').show();
				if($('input[name=carabiner_print]:checked').val()=="刻印あり（表）") {
					carabiner_print = Math.floor(20*(1+vat/100));
				}
				else if($('input[name=carabiner_print]:checked').val()=="刻印あり（表+裏）") {
					carabiner_print = Math.floor(30*(1+vat/100));
				}
			}else{
				$('.carabiner-printng').hide();
				$('input[name=carabiner_print]:first').prop('checked',true);
				carabiner_print = 0;
			}
		}else{
			part = "";
			partPrice = 0;
			$('#sample-part-pic').hide();
			$('#sample-part-name').text('');
			$('.carabiner-printng').hide();
			$('input[name=carabiner_print]:first').prop('checked',true);
			carabiner_print = 0;
		}
	}

	// Get paper data
	if($('input[name="paper_select"]').length){
		var paper = $('input[name="paper_select"]:checked').val();
		var paper_color = $('input[name="paper"]:checked').val();

		if(paper!=undefined){
			$('.paper-container').show();
			if(paper_color!=undefined){
				$('#sample-paper-pic').show();
				$('#sample-paper-pic').attr('src',"/products/acrylic/img/"+paper_color+".jpg");
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
				for (var i = 0, iMax = tmp_pp.length; i < iMax; i++) {
					if (parseInt(vno_of_order.value) >= parseInt(tmp_pp[i].num)) {
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
			$('#sample-paper-pic').hide();
			$('#sample-paper-name').text('なし');
			$('.paper-container').hide();
			$('#paper-error').text('');
			$('#next').attr('disabled',false);
			$('#back').attr('disabled',false);
			$('#prd_paper').text('なし');
			$('input[name="acy_paper"]').prop('checked',false);
			$('input[name="paper"]').prop('checked',false);
			paperPrice = 0;
		}
	}

	if(vno_of_order.value != "" ) {
		if ($('#pcs1').is(':checked') || $('#pcs4').is(':checked')) {
			if (vno_of_order.value >= 5000) order_pcs = price_strap_standard[6];
			else if (vno_of_order.value >= 3000) order_pcs = price_strap_standard[5];
			else if (vno_of_order.value >= 1000) order_pcs = price_strap_standard[4];
			else if (vno_of_order.value >= 500) order_pcs = price_strap_standard[3];
			else if (vno_of_order.value >= 300) order_pcs = price_strap_standard[2];
			else if (vno_of_order.value >= 200) order_pcs = price_strap_standard[1];
			else if (vno_of_order.value >= 100) order_pcs = price_strap_standard[0];
		}
		if ($('#pcs2').is(':checked')) {
			if (vno_of_order.value >= 5000) order_pcs = price_strap_premium[6];
			else if (vno_of_order.value >= 3000) order_pcs = price_strap_premium[5];
			else if (vno_of_order.value >= 1000) order_pcs = price_strap_premium[4];
			else if (vno_of_order.value >= 500) order_pcs = price_strap_premium[3];
			else if (vno_of_order.value >= 300) order_pcs = price_strap_premium[2];
			else if (vno_of_order.value >= 200) order_pcs = price_strap_premium[1];
			else if (vno_of_order.value >= 100) order_pcs = price_strap_premium[0];
		}
	}

	if($('input[name=ItemPCS]').length && $('input[name=ItemPCS]:checked').val()!=undefined){
		$('#sample-prd-pcs').text($('input[name=ItemPCS]:checked').val());
	}
	
	// For All rubber product can silk print back side
	if($('input[name=silk_print]').length && $('input[name=silk_print]:checked').val()!=undefined){
		$('#sample-prd-screen').text($('input[name=silk_print]:checked').val());
		$('#prd_silk_print').text($('input[name=silk_print]:checked').val());
	}

	// For rubber coating
	if($('input[name=coating]').length && $('input[name=coating]:checked').val()!=undefined){
		$('#sample-prd-coating').text($('input[name=coating]:checked').val());
		$('#prd_coating').text($('input[name=coating]:checked').val());
		if($('input[name=coating]:checked').val() == "汚れ防止加工なし"){
			coating_charge = 0;
		}else{
			coating_charge = Math.floor(70*(1+vat/100));
		}
	}

	if($("input[name=packing]").length){
		if($("input[name=packing]:checked").val()!=undefined && $("input[name=packing]:checked").val()!=""){
			$('#part-error').text('');
			$('#next').attr('disabled',false);
			$('#back').attr('disabled',false);

			$('#sample-part-pic').show();
			if($("input[name=packing]:checked").val() == "白色無地"){
				$('#sample-part-pic').attr("src", "/products/images/frame-packing1.jpg");
				packing_price = Math.floor(30*(1+vat/100));
			}else{
				$('#sample-part-pic').attr("src", "/products/images/frame-packing2.jpg?v=1.01");
				packing_price = 0;
			}
			$('#sample-part-name').text($("input[name=packing]:checked").val());
		}else{
			$('#part-error').text('梱包形態をご選択ください');
			$('#next').attr('disabled',true);
			$('#back').attr('disabled',true);
		}
	}

	$('#sample-prd-qty').text(vno_of_order.value);

	if($('#ariprint').length){
		this.print_umu = document.getElementById('ariprint');
	}

	if($('#fcprint').length){
		this.print_fc = document.getElementById('fcprint');
	}

	if($('input[name=SendPrototype]:checked').val()!=undefined){
		$('#prd_SendPrototype').text('あり');
		$('#sample-prd-samp').text('あり');
	}else{
		$('#prd_SendPrototype').text('なし');
		$('#sample-prd-samp').text('なし');
	}

	if($('input[name=DeFormat]:checked').val()!=undefined){
		$('#prd_DeFormat').text('あり');
		$('#sample-prd-trace').text('あり');
	}else{
		$('#prd_DeFormat').text('なし');
		$('#sample-prd-trace').text('なし');
	}

	if($('input[name=ItemDesignVariation]:checked').val()!=undefined){
		$('#prd_ItemDesign').text($('input[name=ItemDesignVariation]:checked').val());
	}

	if($('input[name=ItemMaterial]:checked').val()!=undefined){
		$('#prd_ItemMaterial').text($('input[name=ItemMaterial]:checked').val());
	}

	if($('#pcs1').length){
		if(($('#pcs1').is(':checked') || $('#pcs4').is(':checked'))){
			if($('input[name=SendPrototype]:checked').val()!=undefined){ proto_charge = Math.floor(8000*(1+vat/100)); }
			if($('input[name=DeFormat]:checked').val()!=undefined){ trace_charge = Math.floor(8000*(1+vat/100)); }
			if(print_umu.checked){ print_charge = (vno_of_order.value)*Math.floor(30*(1+vat/100));}
			if($('#fcprint').length && print_fc.checked){ print_charge = (vno_of_order.value)*Math.floor(50*(1+vat/100));}
			click_typeorder_enabled();
		}else{
			click_typeorder_disabled();
		}
	}

	if($('#pcs4').is(':checked')){
		order_pcs += 110;
	}

	if($('input[name=ItemMaterial]:checked').length && $('input[name=ItemMaterial]:checked').val() == "特殊素材あり"){
		MaterialCharge = Math.floor(30*(1+vat/100));
	}else{
		MaterialCharge = 0;
	}

	if($('input[name=ItemDesignVariation]:checked').length){
		switch($('input[name=ItemDesignVariation]:checked').val()){
			case "2種類":
				DesignsCharge = Math.floor(3000*(1+vat/100));
				break;
			case "3種類":
				DesignsCharge = Math.floor(6000*(1+vat/100));
				break;
			case "4種類":
				DesignsCharge = Math.floor(9000*(1+vat/100));
				break;
			default:
				DesignsCharge = 0;
			break;
		}
	}

	if($('#prd_ItemPCS').length){
		$('#prd_ItemPCS').text($('input[name=ItemPCS]:checked').val());
	}
	
	$('#prd_qty').text(vno_of_order.value);
	if($('#prd_part').length){
		if(part == ""){
			prd_part = "なし";
		}
		$('#prd_part').text(part);
	}
	if($('#prd_part_printing').length){
		$('#prd_part_printing').text($('input[name=carabiner_print]:checked').val());
	}

	// Assign Value
	TextField7Value = Math.floor(order_pcs*(1+vat/100))*vno_of_order.value;
	// Amount Before Tax
	TextField9Value = parseInt(TextField7Value) + proto_charge + trace_charge +
	print_charge + coating_charge*vno_of_order.value + (partPrice*vno_of_order.value) + (carabiner_print*vno_of_order.value)+
	(paperPrice*vno_of_order.value) + MaterialCharge*vno_of_order.value + DesignsCharge + packing_price*vno_of_order.value;

	DisPrice = 0;

	tax = Math.floor(Math.floor(TextField7Value*vat/(100+vat)) + 
		Math.floor(proto_charge*vat/(100+vat))+
		Math.floor(trace_charge*vat/(100+vat)) +
		 Math.floor(print_charge*vat/(100+vat))+
		Math.floor(coating_charge*vno_of_order.value*vat/(100+vat)) +
		Math.floor(packing_price*vno_of_order.value*vat/(100+vat)) +
		Math.floor((partPrice*vno_of_order.value)*vat/(100+vat))+ 
		Math.floor((carabiner_print*vno_of_order.value)*vat/(100+vat))+ 
		Math.floor((MaterialCharge*vno_of_order.value)*vat/(100+vat))+ 
		Math.floor((DesignsCharge)*vat/(100+vat))+ 
		Math.floor((paperPrice*vno_of_order.value)*vat/(100+vat)));
	// tax = tax - Math.floor(tax*vat/100);
	total = (parseInt(TextField9Value)-parseInt(DisPrice));

	// document.getElementById('textfield1').value = formatMoney(basic_charge);
	// document.getElementById('textfield2').value = formatMoney(mold_charge);
	document.getElementById('textfield7').value = formatMoney(TextField7Value);

	document.getElementById('textfield7_1').value = formatMoney(partPrice*vno_of_order.value);
	document.getElementById('textfield7_3').value = formatMoney(carabiner_print*vno_of_order.value);

	document.getElementById('textfield7_2').value = formatMoney(paperPrice*vno_of_order.value);

	document.getElementById('textfield3').value = formatMoney(proto_charge);
	document.getElementById('textfield4').value = formatMoney(trace_charge);
	document.getElementById('textfield_dis').value = formatMoney(DisPrice);
	document.getElementById('textfield13').value = formatMoney(print_charge);

	if($('#textfield13_2').length){
		document.getElementById('textfield13_2').value = formatMoney(coating_charge*vno_of_order.value);
	}

	if($('#textfield13_3').length){
		document.getElementById('textfield13_3').value = formatMoney(packing_price*vno_of_order.value);
	}

	if($('#DesignsCharge').length){
		document.getElementById('DesignsCharge').value = formatMoney(DesignsCharge);
	}
	if($('#MaterialCharge').length){
		document.getElementById('MaterialCharge').value = formatMoney(MaterialCharge*vno_of_order.value);
	}

	// document.getElementById('textfield8').value = formatMoney(shipping_charge);
	document.getElementById('textfield9').value = formatMoney(parseInt(TextField9Value));
	// document.getElementById('textfield10').value = formatMoney(tax);
	document.getElementById('textfield11').value = formatMoney(total);
	$('.prd_total').text(formatMoney(total));
	// document.getElementById('textfield12').value = formatMoney(printumu);
}

function setToInputManual()
{
	clearValue();
	var ItemType = $('input[name=ItemType]').val();
	var vno_of_order = document.getElementById('no_of_order');
    var prd = $('#strap').val();

	// Get part price
	if($('input[name="part"]').length){
		var part = $('input[name="part"]:checked').val();

		if(part!=undefined ){
			switch(part){
				case "廉価版カラビナ":
					if (vno_of_order.value >= 5000) partPrice = Math.floor(carabiner_O[6]*(1+vat/100));
					else if (vno_of_order.value >= 3000) partPrice = Math.floor(carabiner_O[5]*(1+vat/100));
					else if (vno_of_order.value >= 1000) partPrice = Math.floor(carabiner_O[4]*(1+vat/100));
					else if (vno_of_order.value >= 500) partPrice = Math.floor(carabiner_O[3]*(1+vat/100));
					else if (vno_of_order.value >= 300) partPrice = Math.floor(carabiner_O[2]*(1+vat/100));
					else if (vno_of_order.value >= 200) partPrice = Math.floor(carabiner_O[1]*(1+vat/100));
					else if (vno_of_order.value >= 100) partPrice = Math.floor(carabiner_O[0]*(1+vat/100));
				break;
				case "高級版Mサイズ":
					if (vno_of_order.value >= 5000) partPrice = Math.floor(carabiner_M[6]*(1+vat/100));
					else if (vno_of_order.value >= 3000) partPrice = Math.floor(carabiner_M[5]*(1+vat/100));
					else if (vno_of_order.value >= 1000) partPrice = Math.floor(carabiner_M[4]*(1+vat/100));
					else if (vno_of_order.value >= 500) partPrice = Math.floor(carabiner_M[3]*(1+vat/100));
					else if (vno_of_order.value >= 300) partPrice = Math.floor(carabiner_M[2]*(1+vat/100));
					else if (vno_of_order.value >= 200) partPrice = Math.floor(carabiner_M[1]*(1+vat/100));
					else if (vno_of_order.value >= 100) partPrice = Math.floor(carabiner_M[0]*(1+vat/100));
				break;
				case "高級版Lサイズ":
					if (vno_of_order.value >= 5000) partPrice = Math.floor(carabiner_L[6]*(1+vat/100));
					else if (vno_of_order.value >= 3000) partPrice = Math.floor(carabiner_L[5]*(1+vat/100));
					else if (vno_of_order.value >= 1000) partPrice = Math.floor(carabiner_L[4]*(1+vat/100));
					else if (vno_of_order.value >= 500) partPrice = Math.floor(carabiner_L[3]*(1+vat/100));
					else if (vno_of_order.value >= 300) partPrice = Math.floor(carabiner_L[2]*(1+vat/100));
					else if (vno_of_order.value >= 200) partPrice = Math.floor(carabiner_L[1]*(1+vat/100));
					else if (vno_of_order.value >= 100) partPrice = Math.floor(carabiner_L[0]*(1+vat/100));
				break;
			}

			$('#sample-part-name').text(parts_obj["part_name"]);
			if(part != "カラビナなし"){
				$('#sample-part-pic').html('<img width="135" height="135" id="sample-part-pic" class="picpro" src="'+parts_obj["part_pic"]+'">');
			}else{
				$('#sample-part-pic').html('');
			}

			if(part != "" && part != "廉価版カラビナ" && part != "カラビナなし"){
				$('.carabiner-printng').show();
				if($('input[name=carabiner_print]:checked').val()=="刻印あり（表）") {
					carabiner_print = Math.floor(20*(1+vat/100));
				}
				else if($('input[name=carabiner_print]:checked').val()=="刻印あり（表+裏）") {
					carabiner_print = Math.floor(30*(1+vat/100));
				}
			}else{
				$('.carabiner-printng').hide();
				$('input[name=carabiner_print]:first').prop('checked',true);
				carabiner_print = 0;
			}
		}else{
			part = "";
			partPrice = 0;
			$('#sample-part-pic').hide();
			$('#sample-part-name').text('');
			$('.carabiner-printng').hide();
			$('input[name=carabiner_print]:first').prop('checked',true);
			carabiner_print = 0;
		}
	}

	// Get paper data
	if($('input[name="paper_select"]').length){
		var paper = $('input[name="paper_select"]:checked').val();
		var paper_color = $('input[name="paper"]:checked').val();

		if(paper!=undefined){
			$('.paper-container').show();
			if(paper_color!=undefined){
				$('#sample-paper-pic').show();
				$('#sample-paper-pic').attr('src',"/products/acrylic/img/"+paper_color+".jpg");
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
				for (var i = 0, iMax = tmp_pp.length; i < iMax; i++) {
					if (parseInt(vno_of_order.value) >= parseInt(tmp_pp[i].num)) {
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
			$('#sample-paper-pic').hide();
			$('#sample-paper-name').text('なし');
			$('.paper-container').hide();
			$('#paper-error').text('');
			$('#next').attr('disabled',false);
			$('#back').attr('disabled',false);
			$('#prd_paper').text('なし');
			$('input[name="acy_paper"]').prop('checked',false);
			$('input[name="paper"]').prop('checked',false);
			paperPrice = 0;
		}
	}

	if(vno_of_order.value != "" ) {
		if ($('#pcs1').is(':checked') || $('#pcs4').is(':checked')) {
			if (vno_of_order.value >= 5000) order_pcs = price_strap_standard[6];
			else if (vno_of_order.value >= 3000) order_pcs = price_strap_standard[5];
			else if (vno_of_order.value >= 1000) order_pcs = price_strap_standard[4];
			else if (vno_of_order.value >= 500) order_pcs = price_strap_standard[3];
			else if (vno_of_order.value >= 300) order_pcs = price_strap_standard[2];
			else if (vno_of_order.value >= 200) order_pcs = price_strap_standard[1];
			else if (vno_of_order.value >= 100) order_pcs = price_strap_standard[0];
		}
		if ($('#pcs2').is(':checked')) {
			if (vno_of_order.value >= 5000) order_pcs = price_strap_premium[6];
			else if (vno_of_order.value >= 3000) order_pcs = price_strap_premium[5];
			else if (vno_of_order.value >= 1000) order_pcs = price_strap_premium[4];
			else if (vno_of_order.value >= 500) order_pcs = price_strap_premium[3];
			else if (vno_of_order.value >= 300) order_pcs = price_strap_premium[2];
			else if (vno_of_order.value >= 200) order_pcs = price_strap_premium[1];
			else if (vno_of_order.value >= 100) order_pcs = price_strap_premium[0];
		}
	}

	if($('input[name=ItemPCS]').length && $('input[name=ItemPCS]:checked').val()!=undefined){
		$('#sample-prd-pcs').text($('input[name=ItemPCS]:checked').val());
	}
	
	// For All rubber product can silk print back side
	if($('input[name=silk_print]').length && $('input[name=silk_print]:checked').val()!=undefined){
		$('#sample-prd-screen').text($('input[name=silk_print]:checked').val());
		$('#prd_silk_print').text($('input[name=silk_print]:checked').val());
	}

	// For rubber coating
	if($('input[name=coating]').length && $('input[name=coating]:checked').val()!=undefined){
		$('#sample-prd-coating').text($('input[name=coating]:checked').val());
		$('#prd_coating').text($('input[name=coating]:checked').val());
		if($('input[name=coating]:checked').val() == "汚れ防止加工なし"){
			coating_charge = 0;
		}else{
			coating_charge = Math.floor(70*(1+vat/100));
		}
	}

	if($("input[name=packing]").length){
		if($("input[name=packing]:checked").val()!=undefined && $("input[name=packing]:checked").val()!=""){
			$('#part-error').text('');
			$('#next').attr('disabled',false);
			$('#back').attr('disabled',false);

			$('#sample-part-pic').show();
			if($("input[name=packing]:checked").val() == "白色無地"){
				$('#sample-part-pic').attr("src", "/products/images/frame-packing1.jpg");
				packing_price = Math.floor(30*(1+vat/100));
			}else{
				$('#sample-part-pic').attr("src", "/products/images/frame-packing2.jpg?v=1.01");
				packing_price = 0;
			}
			$('#sample-part-name').text($("input[name=packing]:checked").val());
		}else{
			$('#part-error').text('梱包形態をご選択ください');
			$('#next').attr('disabled',true);
			$('#back').attr('disabled',true);
		}
	}

	$('#sample-prd-qty').text(vno_of_order.value);

	if($('#ariprint').length){
		this.print_umu = document.getElementById('ariprint');
	}

	if($('#fcprint').length){
		this.print_fc = document.getElementById('fcprint');
	}

	if($('input[name=SendPrototype]:checked').val()!=undefined){
		$('#prd_SendPrototype').text('あり');
		$('#sample-prd-samp').text('あり');
	}else{
		$('#prd_SendPrototype').text('なし');
		$('#sample-prd-samp').text('なし');
	}

	if($('input[name=DeFormat]:checked').val()!=undefined){
		$('#prd_DeFormat').text('あり');
		$('#sample-prd-trace').text('あり');
	}else{
		$('#prd_DeFormat').text('なし');
		$('#sample-prd-trace').text('なし');
	}

	if($('input[name=ItemDesignVariation]:checked').val()!=undefined){
		$('#prd_ItemDesign').text($('input[name=ItemDesignVariation]:checked').val());
	}

	if($('input[name=ItemMaterial]:checked').val()!=undefined){
		$('#prd_ItemMaterial').text($('input[name=ItemMaterial]:checked').val());
	}

	if($('#pcs1').length){
		if(($('#pcs1').is(':checked') || $('#pcs4').is(':checked'))){
			if($('input[name=SendPrototype]:checked').val()!=undefined){ proto_charge = Math.floor(8000*(1+vat/100)); }
			if($('input[name=DeFormat]:checked').val()!=undefined){ trace_charge = Math.floor(8000*(1+vat/100)); }
			if(print_umu.checked){ print_charge = (vno_of_order.value)*Math.floor(30*(1+vat/100));}
			if($('#fcprint').length && print_fc.checked){ print_charge = (vno_of_order.value)*Math.floor(50*(1+vat/100));}
			click_typeorder_enabled();
		}else{
			click_typeorder_disabled();
		}
	}

	if($('#pcs4').is(':checked')){
		order_pcs += 110;
	}

	if($('input[name=ItemMaterial]:checked').length && $('input[name=ItemMaterial]:checked').val() == "特殊素材あり"){
		MaterialCharge = Math.floor(30*(1+vat/100));
	}else{
		MaterialCharge = 0;
	}

	if($('input[name=ItemDesignVariation]:checked').length){
		switch($('input[name=ItemDesignVariation]:checked').val()){
			case "2種類":
				DesignsCharge = Math.floor(3000*(1+vat/100));
				break;
			case "3種類":
				DesignsCharge = Math.floor(6000*(1+vat/100));
				break;
			case "4種類":
				DesignsCharge = Math.floor(9000*(1+vat/100));
				break;
			default:
				DesignsCharge = 0;
			break;
		}
	}

	if($('#prd_ItemPCS').length){
		$('#prd_ItemPCS').text($('input[name=ItemPCS]:checked').val());
	}
	
	$('#prd_qty').text(vno_of_order.value);
	if($('#prd_part').length){
		if(part == ""){
			prd_part = "なし";
		}
		$('#prd_part').text(part);
	}
	if($('#prd_part_printing').length){
		$('#prd_part_printing').text($('input[name=carabiner_print]:checked').val());
	}

	// Assign Value
	TextField7Value = Math.floor(order_pcs*(1+vat/100))*vno_of_order.value;
	// Amount Before Tax
	TextField9Value = parseInt(TextField7Value) + proto_charge + trace_charge +
	print_charge + coating_charge*vno_of_order.value + (partPrice*vno_of_order.value) + (carabiner_print*vno_of_order.value)+
	(paperPrice*vno_of_order.value) + MaterialCharge*vno_of_order.value + DesignsCharge + packing_price*vno_of_order.value;

	DisPrice = 0;

	tax = Math.floor(Math.floor(TextField7Value*vat/(100+vat)) + 
		Math.floor(proto_charge*vat/(100+vat))+
		Math.floor(trace_charge*vat/(100+vat)) +
		 Math.floor(print_charge*vat/(100+vat))+
		Math.floor(coating_charge*vno_of_order.value*vat/(100+vat)) +
		Math.floor(packing_price*vno_of_order.value*vat/(100+vat)) +
		Math.floor((partPrice*vno_of_order.value)*vat/(100+vat))+ 
		Math.floor((carabiner_print*vno_of_order.value)*vat/(100+vat))+ 
		Math.floor((MaterialCharge*vno_of_order.value)*vat/(100+vat))+ 
		Math.floor((DesignsCharge)*vat/(100+vat))+ 
		Math.floor((paperPrice*vno_of_order.value)*vat/(100+vat)));
	// tax = tax - Math.floor(tax*vat/100);
	total = (parseInt(TextField9Value)-parseInt(DisPrice));

	// document.getElementById('textfield1').value = formatMoney(basic_charge);
	// document.getElementById('textfield2').value = formatMoney(mold_charge);
	document.getElementById('textfield7').value = formatMoney(TextField7Value);

	document.getElementById('textfield7_1').value = formatMoney(partPrice*vno_of_order.value);
	document.getElementById('textfield7_3').value = formatMoney(carabiner_print*vno_of_order.value);

	document.getElementById('textfield7_2').value = formatMoney(paperPrice*vno_of_order.value);

	document.getElementById('textfield3').value = formatMoney(proto_charge);
	document.getElementById('textfield4').value = formatMoney(trace_charge);
	document.getElementById('textfield_dis').value = formatMoney(DisPrice);
	document.getElementById('textfield13').value = formatMoney(print_charge);

    let have_coating = false;
	if($('#textfield13_2').length){
		document.getElementById('textfield13_2').value = formatMoney(coating_charge*vno_of_order.value);
        have_coating = true;
	}

    let have_packing = false;
	if($('#textfield13_3').length){
		document.getElementById('textfield13_3').value = formatMoney(packing_price*vno_of_order.value);
        have_packing = true;
	}

    let have_design = false;
	if($('#DesignsCharge').length){
		document.getElementById('DesignsCharge').value = formatMoney(DesignsCharge);
        have_design = true;
	}

    let have_material = false;
	if($('#MaterialCharge').length){
		document.getElementById('MaterialCharge').value = formatMoney(MaterialCharge*vno_of_order.value);
        have_material = true;
	}

	// document.getElementById('textfield8').value = formatMoney(shipping_charge);
	document.getElementById('textfield9').value = formatMoney(parseInt(TextField9Value));
	// document.getElementById('textfield10').value = formatMoney(tax);
	document.getElementById('textfield11').value = formatMoney(total);
	$('.prd_total').text(formatMoney(total));
	// document.getElementById('textfield12').value = formatMoney(printumu);

    let shipping_price = 880;
    if (TextField9Value > 11000) {
        shipping_price = 0;
    }

    let sku_name = "";
    if (prd == "ゴルフターゲットカップ") {
        sku_name = 'targetcup';
    }

    if (sku_name != "")
    {
        return {
            sku: sku_name,
            product: prd,
            qty: vno_of_order.value,
            product_price: TextField7Value,
            mold_price: 0,
            part_price: (partPrice * vno_of_order.value),
            backside_price: 0,
            paper_price: (paperPrice*vno_of_order.value),
            prototype_price: proto_charge,
            ai_assistant_price: 0,
            trace_price: trace_charge,
            opp_price: 0,
            process_price: 0,
            color_price: 0,
            print_price: print_charge,
            coating_price: (have_coating ? coating_charge*vno_of_order.value : 0),
            packing_price: (have_packing ? (packing_price*vno_of_order.value) : 0),
            carabiner_price: (carabiner_print*vno_of_order.value),
            material_price: (have_material ? (MaterialCharge*vno_of_order.value) : 0),
            design_price: (have_design ? DesignsCharge : 0),
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
TextField7Value = 0;
TextField9Value = 0;
DisPrice = 0;
proto_charge = 0;
coating_charge = 0;
packing_price = 0;
trace_charge = 0;
print_charge = 0;

document.getElementById('textfield7').value = "";

document.getElementById('textfield7_1').value = "";
document.getElementById('textfield7_2').value = "";

document.getElementById('textfield3').value = "";
document.getElementById('textfield4').value = "";
document.getElementById('textfield13').value = "";

if($('#textfield13_2').length){
	document.getElementById('textfield13_2').value = "";
}

if($('#DesignsCharge').length){
	document.getElementById('DesignsCharge').value = "";
}
if($('#MaterialCharge').length){
	document.getElementById('MaterialCharge').value = "";
}

// document.getElementById('textfield9').value = "";
// document.getElementById('textfield10').value = "";
document.getElementById('textfield11').value = "";
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

// standard
function click_typeorder_enabled() {
	// $('.part_price_std').show();
	// $('.part_price_prm').hide();
	type_special_disabled('f1');
}

// premium
function click_typeorder_disabled() {
// $('.part_price_std').hide();
// $('.part_price_prm').show();
type_special_disabled('f1');
}

function type_special_disabled(c){
if(c == 't1'){
	var amount;
	// Get order amount in database 
	$.get("/count_order.php", function(data){
		amount = $.parseJSON(data);
	}).done(function() {
		// Show status
		$('.pcs_option').fadeIn();
		if(amount == 0){
			$('#pcs_txt').text('受付中です。ご注文頂けます');
			$('#pcs_status').attr('class','pcs_01');
		}else if(amount < 5){
			$('#pcs_txt').text('今週の受付数はあと1～2件です');
			$('#pcs_status').attr('class','pcs_02');
		}else{
			$('#pcs_txt').text('今週の受付数量を越えております為、ご注文停止中です');
			$('#pcs_status').attr('class','pcs_03');
			$('.btn-next').attr('disabled',true);
		}
		// Set disable
		$("#ariprint").attr('disabled',true);
		$("#fcprint").attr('disabled',true);
		$("#nashiprint").prop('checked',true);
		if($("#coating1").length){
			$("#coating1").attr('disabled',true);
			$("#coating0").prop('checked',true);
		}
		$("#no_of_order").val('10');
		$("#no_of_order").attr('readonly',true);
		// $('.part_price_std').hide();
		// $('.part_price_prm').show();
		$('input[name=paper_select]').attr('disabled',true);
		$('input[name=SendPrototype]').attr('disabled',true);
		$('input[name=DeFormat]').prop('checked',true);
		$('input[name=DeFormat]').attr('disabled',true);
		$("#button_pdf2").attr('disabled',true);
	});
}else{
	$('#pcs3').attr('checked',false);
	$('.pcs_option').hide();
	$("#ariprint").attr('disabled',false);
	$("#fcprint").attr('disabled',false);

	if($('input[name=ItemPCS]:checked').val()=="スタンダード（スピード7営業日発送）"){
		if($("#coating1").length){
			$("#coating0").prop('checked',true);
			$("#coating1").attr('disabled',true);
		}
	}else{
		if($("#coating1").length){
			$("#coating1").attr('disabled',false);
		}
	}
	$("#no_of_order").attr('readonly',false);
	$('input[name=paper_select]').attr('disabled',false);
	$('input[name=SendPrototype]').attr('disabled',false);
	$('input[name=DeFormat]').attr('disabled',false);
	$("#button_pdf2").attr('disabled',false);
	$('.btn-next').attr('disabled',false);
}
}

function getPartData(v) {
$.get("part-carabiner.php", { c: "passed" } , function(data){
	var duce = $.parseJSON(data);
	for(var i=0;i<duce.length;i++){
		if(duce[i]['part_name']==v){
			parts_obj = duce[i];
		}
	}
}).done(function() {
	setToInput();

	//check case click back
	let prd_strap = $('#strap').val();
	let mmt = $('#ms_mode').val();
	if (mmt != "" && mmt == "MODE_MOD" && (prd_strap == "ゴルフターゲットカップ"))
	{
		let items = setToInputManual();
		if(Object.keys(items).length !== 0) 
		{
			$.ajax({
				type: "POST",
				url: "/products/save_calc_data.php",
				data: items,
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
	
})
}

