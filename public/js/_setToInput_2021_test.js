	var price_strap_standard = [340,220,210,200,160,135,115];
	var price_strap_premium = [719,555,446,339,257,184,140];

	var price_keyholder_standard = [340,220,210,200,160,135,115];
	var price_keyholder_premium = [719,555,446,339,257,184,140];

	var price_earphone_standard = [340,220,210,200,160,135,115];
	var price_earphone_premium = [719,555,446,339,257,184,140];

	var price_keykaba_standard = [889,682,474,348,256,191,143];	
	var price_keykaba_premium = [988,769,549,408,304,227,167];

	var price_cleaner_rubber_standard = [560,410,350,290,240,174,156];
	var price_cleaner_rubber_premium = [1150,990,637,850,390,226,190];

	var price_coaster_standard = [650,530,385,325,234,177,149];
	var price_coaster_premium = [840,677,513,393,295,214,179];

	var price_phonestand_s_standard = [850,678,505,416,297,224,198];
	var price_phonestand_s_premium = [1105,881,657,499,356,269,238];

	var price_phonestand_l_standard = [1066,884,622,526,399,288,263];
	var price_phonestand_l_premium = [1386,1097,809,631,479,346,316];

	var price_tag_standard = [272,176,168,160,128,108,92];
	var price_tag_premium = [575,444,357,271,206,147,112];

	var price_targetcup_standard = [812,663,513,450,252,159,140];
	var price_targetcup_premium = [975,796,616,540,302,191,168];
	
	var carabinerPrice_obj = {
		"lowPrice":[
		{"num":100, "price":56},
		{"num":200, "price":52},
		{"num":300, "price":48},
		{"num":500, "price":41},
		{"num":1000, "price":35},
		{"num":3000, "price":28},
		{"num":5000, "price":27}
		],
		"LuxM":[
		{"num":100, "price":149},
		{"num":200, "price":137},
		{"num":300, "price":124},
		{"num":500, "price":112},
		{"num":1000, "price":90},
		{"num":3000, "price":70},
		{"num":5000, "price":67}
		],
		"LuxL":[
		{"num":100, "price":214},
		{"num":200, "price":196},
		{"num":300, "price":177},
		{"num":500, "price":161},
		{"num":1000, "price":128},
		{"num":3000, "price":99},
		{"num":5000, "price":94}
		]
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

	var parts_obj;
	var paperPrice = 0;
	var unit_price = 0;
	var carabinerPrice = 0;

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

	function valid_chk_btn2(c) {
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
		if(v=='next'){
			if(!validation_numberOf() && $('input[name=ItemPCS]:checked').val()!="ホットモバイリーファン"){
				return false;
			}else{
				$('#err_numberOf_mess').hide();
				if($('input[name=ItemPCS]:checked').val()==undefined){
					$('#error_pcs').text('【必須】ご注文タイプをご選択ください');
					return false;
				}else if(ItemType != "ラバータグ" && $('input[name=silk_print]:checked').val()==undefined){
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
	var TextField7Value = 0;
	var TextField9Value = 0;
	var DisPrice = 0;
	var proto_charge = 0;
	var trace_charge = 0;
	var print_charge = 0;
	var coating_charge = 0;

	function setToInput(){
		clearValue();

		var ItemType = $('input[name=ItemType]').val();

		// Carabiner
		var carabiner = $('input[name="carabiner_select"]:checked').val();
		var carabiner_type = $('input[name="carabiner"]:checked').val();

		// Mount
		var paper = $('input[name="paper_select"]:checked').val();
		var paper_color = $('input[name="paper"]:checked').val();

	    // Quality
	    var vpcs1 = document.getElementById('pcs1');
	    var vpcs2 = document.getElementById('pcs2');
		// ----------->
		var vno_of_order = document.getElementById('no_of_order');

		// Get part price
		var part = $('input[name="part"]:checked').val();
		if(part!=undefined && ItemType != "ラバーコースター" && ItemType != "ラバースマートフォンスタンド" && ItemType != "ラバータグ" ){
			partPrice = Math.floor(parts_obj["part_price"]*(1+vat/100));
			$('#sample-part-pic').show();
			$('#sample-part-pic').attr('src',parts_obj["part_pic"]);
			$('#sample-part-name').text(parts_obj["part_name"]);
		}else{
			part = "";
			partPrice = 0;
			$('#sample-part-pic').hide();
			$('#sample-part-name').text('');
		}

		//Get Carabiner data
		if(carabiner!=undefined){
			$('.carabiner_container').show();
			if (carabiner_type!=undefined){
				$('#sample-carabiner-pic').show();
				$('#sample-carabiner-pic').attr('src','/products/carabiner/images/'+carabiner_type+".jpg");
				$('#sample-carabiner-name').text(carabiner_type);
				$('#next').attr('disabled',false);
				$('#back').attr('disabled',false);
				$('#prd_carabiner').text(carabiner_type);
				$('#carabiner-error').text('');
				if (carabiner_type=="carabiner-lowprice") {
					var tmp_cb = carabinerPrice_obj['lowPrice'];
				} else if (carabiner_type=="carabiner-m-gloss-red"||carabiner_type=="carabiner-m-gloss-black"||carabiner_type=="carabiner-m-gloss-silver"||carabiner_type=="carabiner-m-matte-red"||carabiner_type=="carabiner-m-matte-black"||carabiner_type=="carabiner-m-matte-silver") {
					var tmp_cb = carabinerPrice_obj['LuxM'];
				} else if (carabiner_type=="carabiner-l-gloss-red"||carabiner_type=="carabiner-l-gloss-black"||carabiner_type=="carabiner-l-gloss-silver"||carabiner_type=="carabiner-l-matte-red"||carabiner_type=="carabiner-l-matte-black"||carabiner_type=="carabiner-l-matte-silver") {
					var tmp_cb = carabinerPrice_obj['LuxL'];
				}
				// Get Carabiner Price
				for (var j = 0, jMax = tmp_cb.length; j < jMax; j++) {
					if (parseInt(vno_of_order.value) >= parseInt(tmp_cb[j].num)) {
						carabinerPrice = Math.floor(tmp_cb[j].price*(1+vat/100));
						continue;
					}
					break;
				}
			} else {
				$('#carabiner-error').text('カラビナを選択してください。');
				$('#next').attr('disabled',true);
				$('#back').attr('disabled',true);
			}
		} else {
			$('#sample-carabiner-pic').hide();
			$('#sample-carabiner-name').text('なし');
			$('.carabiner-container').hide();
			$('#carabiner-error').text('');
			$('#next').attr('disabled',false);
			$('#back').attr('disabled',false);
			$('#prd_carabiner').text('なし');
			$('input[name="acy_carabiner"]').prop('checked',false);
			$('input[name="carabiner"]').prop('checked',false);
			carabinerPrice = 0;
		}

		// Get paper data
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
				if(paper_color=="paper-paetternA"){
					var tmp_pp = paperPrice_obj['1side'];
				}else if(paper_color=="paper-paetternB"){
					var tmp_pp = paperPrice_obj['2side'];
				}else{
					var tmp_pp = paperPrice_obj['tmp'];
				}
				
				// Get paper price
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

		if(vno_of_order.value != "" ) {

		// strap
		if (ItemType == "ラバーストラップ") {
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
		else if (ItemType == "ラバーキーホルダー") {
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
		else if (ItemType == "ラバーイヤホンホルダー") {
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
		else if (ItemType == "ラバーキーカバー") {
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
		else if (ItemType == "スマホラバークリーナー") {
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
		else if (ItemType == "ラバーコースター") {
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
		//phone stand
		else if (ItemType == "ラバースマートフォンスタンド") {
			if (vpcs1.checked && $('input[name=ItemSize]:checked').val()=='小サイズ'){
				if (vno_of_order.value >=5000) order_pcs = price_phonestand_s_standard[6];
				else if(vno_of_order.value >=3000) order_pcs = price_phonestand_s_standard[5];
				else if(vno_of_order.value >=1000) order_pcs = price_phonestand_s_standard[4];
				else if(vno_of_order.value >=500) order_pcs = price_phonestand_s_standard[3];
				else if(vno_of_order.value >=300) order_pcs = price_phonestand_s_standard[2];
				else if(vno_of_order.value >=200) order_pcs = price_phonestand_s_standard[1];
				else if(vno_of_order.value >=100) order_pcs = price_phonestand_s_standard[0];
			}
			if (vpcs2.checked && $('input[name=ItemSize]:checked').val()=='小サイズ') {
				if (vno_of_order.value >=5000) order_pcs = price_phonestand_s_premium[6];
				else if(vno_of_order.value >=3000) order_pcs = price_phonestand_s_premium[5];
				else if(vno_of_order.value >=1000) order_pcs = price_phonestand_s_premium[4];
				else if(vno_of_order.value >=500) order_pcs = price_phonestand_s_premium[3];
				else if(vno_of_order.value >=300) order_pcs = price_phonestand_s_premium[2];
				else if(vno_of_order.value >=200) order_pcs = price_phonestand_s_premium[1];
				else if(vno_of_order.value >=100) order_pcs = price_phonestand_s_premium[0];
			}
			if (vpcs1.checked && $('input[name=ItemSize]:checked').val()=='大サイズ'){
				if (vno_of_order.value >=5000) order_pcs = price_phonestand_l_standard[6];
				else if(vno_of_order.value >=3000) order_pcs = price_phonestand_l_standard[5];
				else if(vno_of_order.value >=1000) order_pcs = price_phonestand_l_standard[4];
				else if(vno_of_order.value >=500) order_pcs = price_phonestand_l_standard[3];
				else if(vno_of_order.value >=300) order_pcs = price_phonestand_l_standard[2];
				else if(vno_of_order.value >=200) order_pcs = price_phonestand_l_standard[1];
				else if(vno_of_order.value >=100) order_pcs = price_phonestand_l_standard[0];
			}
			if (vpcs2.checked && $('input[name=ItemSize]:checked').val()=='大サイズ') {
				if (vno_of_order.value >=5000) order_pcs = price_phonestand_l_premium[6];
				else if(vno_of_order.value >=3000) order_pcs = price_phonestand_l_premium[5];
				else if(vno_of_order.value >=1000) order_pcs = price_phonestand_l_premium[4];
				else if(vno_of_order.value >=500) order_pcs = price_phonestand_l_premium[3];
				else if(vno_of_order.value >=300) order_pcs = price_phonestand_l_premium[2];
				else if(vno_of_order.value >=200) order_pcs = price_phonestand_l_premium[1];
				else if(vno_of_order.value >=100) order_pcs = price_phonestand_l_premium[0];
			}
		}

		else if (ItemType == "ラバータグ") {
			if (vpcs1.checked) {
				if (vno_of_order.value >= 5000) order_pcs = price_tag_standard[6];
				else if (vno_of_order.value >= 3000) order_pcs = price_tag_standard[5];
				else if (vno_of_order.value >= 1000) order_pcs = price_tag_standard[4];
				else if (vno_of_order.value >= 500) order_pcs = price_tag_standard[3];
				else if (vno_of_order.value >= 300) order_pcs = price_tag_standard[2];
				else if (vno_of_order.value >= 200) order_pcs = price_tag_standard[1];
				else if (vno_of_order.value >= 100) order_pcs = price_tag_standard[0];
			}
			if (vpcs2.checked) {
				if (vno_of_order.value >= 5000) order_pcs = price_tag_premium[6];
				else if (vno_of_order.value >= 3000) order_pcs = price_tag_premium[5];
				else if (vno_of_order.value >= 1000) order_pcs = price_tag_premium[4];
				else if (vno_of_order.value >= 500) order_pcs = price_tag_premium[3];
				else if (vno_of_order.value >= 300) order_pcs = price_tag_premium[2];
				else if (vno_of_order.value >= 200) order_pcs = price_tag_premium[1];
				else if (vno_of_order.value >= 100) order_pcs = price_tag_premium[0];
			}
		}

		$('#sample-prd-pcs').text($('input[name=ItemPCS]:checked').val());

		// For rubber phone stand size
		if($('input[name=ItemSize]').length && $('input[name=ItemSize]:checked').val()!=undefined){
			$('#sample-prd-size').text($('input[name=ItemSize]:checked').val());
			$('#prd_ItemSize').text($('input[name=ItemSize]:checked').val());
		}
		// For rubber cleaner back side color
		if($('input[name=back_side_color]:checked').val()!=undefined){
			$('#sample-prd-cloth').text($('input[name=back_side_color]:checked').val());
			$('#prd_cloth').text($('input[name=back_side_color]:checked').val());
		}
		// For All rubber product can silk print back side
		if(ItemType != "ラバータグ" && $('input[name=silk_print]:checked').val()!=undefined){
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

		$('#sample-prd-qty').text(vno_of_order.value);

		this.optStandard = document.getElementById('pcs1');
		this.print_umu = document.getElementById('ariprint');

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
		if(optStandard.checked && ItemType != "スマホラバークリーナー" && ItemType != "ラバータグ"){
			if($('input[name=SendPrototype]:checked').val()!=undefined){ proto_charge = Math.floor(8000*(1+vat/100)); }
			if($('input[name=DeFormat]:checked').val()!=undefined){ trace_charge = Math.floor(8000*(1+vat/100)); }
			if(print_umu.checked){ print_charge = Math.floor((vno_of_order.value*20)*(1+vat/100));}
			click_typeorder_enabled();
		}else if(optStandard.checked && ItemType == "スマホラバークリーナー" && ItemType != "ラバータグ"){
			if($('input[name=SendPrototype]:checked').val()!=undefined){ proto_charge = Math.floor(8000*(1+vat/100)); }
			if($('input[name=DeFormat]:checked').val()!=undefined){ trace_charge = Math.floor(8000*(1+vat/100)); }
			click_typeorder_enabled();
		}else if($('input[name=ItemPCS]:checked').val()=="ホットモバイリーファン"){
			type_special_disabled('t1');
			$('#prd_DeFormat').text('あり');
			$('#sample-prd-trace').text('あり');
			order_pcs = 900;
			partPrice = 0;
		}else{
			partPrice = 0;
			click_typeorder_disabled();
		}

		$('#prd_ItemPCS').text($('input[name=ItemPCS]:checked').val());
		$('#prd_qty').text(vno_of_order.value);
		$('#prd_part').text(part);

		// Assign Value
		TextField7Value = Math.floor(order_pcs*(1+vat/100))*vno_of_order.value;
		// Amount Before Tax
		TextField9Value = parseInt(TextField7Value) + proto_charge + trace_charge +
		print_charge + coating_charge*vno_of_order.value + (partPrice*vno_of_order.value) + (paperPrice*vno_of_order.value);

		DisPrice = 0;

		tax = Math.floor(Math.floor(TextField7Value*vat/(100+vat)) + Math.floor(proto_charge*vat/(100+vat))+
		 Math.floor(trace_charge*vat/(100+vat)) + Math.floor(print_charge*vat/(100+vat))+
		 Math.floor(coating_charge*vno_of_order.value*vat/(100+vat)) +
		 Math.floor((partPrice*vno_of_order.value)*vat/(100+vat))+ 
		 Math.floor((paperPrice*vno_of_order.value)*vat/(100+vat)));
		tax = tax - Math.floor(tax*vat/100);
		total = (parseInt(TextField9Value)-parseInt(DisPrice));

		// document.getElementById('textfield1').value = formatMoney(basic_charge);
		// document.getElementById('textfield2').value = formatMoney(mold_charge);
		document.getElementById('textfield7').value = formatMoney(TextField7Value);

		document.getElementById('textfield7_1').value = formatMoney(partPrice*vno_of_order.value);
		document.getElementById('textfield7_2').value = formatMoney(paperPrice*vno_of_order.value);

		document.getElementById('textfield3').value = formatMoney(proto_charge);
		document.getElementById('textfield4').value = formatMoney(trace_charge);
		document.getElementById('textfield_dis').value = formatMoney(DisPrice);
		document.getElementById('textfield13').value = formatMoney(print_charge);

		if($('#textfield13_2').length){
			document.getElementById('textfield13_2').value = formatMoney(coating_charge*vno_of_order.value);
		}

		// document.getElementById('textfield8').value = formatMoney(shipping_charge);
		document.getElementById('textfield9').value = formatMoney(parseInt(TextField9Value));
		// document.getElementById('textfield10').value = formatMoney(tax);
		document.getElementById('textfield11').value = formatMoney(total);
		$('.prd_total').text(formatMoney(total));
		// document.getElementById('textfield12').value = formatMoney(printumu);
	}
};

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
	$('.part_price_std').show();
	$('.part_price_prm').hide();
	type_special_disabled('f1');
}

// premium
function click_typeorder_disabled() {
	$('.part_price_std').hide();
	$('.part_price_prm').show();
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
			}
			// Set disable
			$("#ariprint").attr('disabled',true);
			$("#nashiprint").prop('checked',true);
			if($("#coating1").length){
				$("#coating1").attr('disabled',true);
				$("#coating0").prop('checked',true);
			}
			$("#no_of_order").val('10');
			$("#no_of_order").attr('readonly',true);
			$('.part_price_std').hide();
			$('.part_price_prm').show();
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
		if($("#coating1").length){
			$("#coating1").attr('disabled',false);
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
	$.get("part.php", { c: "passed" } , function(data){
		var duce = $.parseJSON(data);
		for(var i=0;i<duce.length;i++){
			if(duce[i]['part_name']==v){
				parts_obj = duce[i];
			}
		}
	}).done(function() {
		setToInput();
	})
}

