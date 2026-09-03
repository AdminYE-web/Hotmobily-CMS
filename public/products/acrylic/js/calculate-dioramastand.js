var isSafari = navigator.vendor && navigator.vendor.indexOf('Apple') > -1 &&
navigator.userAgent &&
navigator.userAgent.indexOf('CriOS') == -1 &&
navigator.userAgent.indexOf('FxiOS') == -1;
// price for 10 days
var prd_10d_1side = {
	"size50":[
	{"num":1, "price":1337},
	{"num":2, "price":942},
	{"num":3, "price":858},
	{"num":4, "price":788},
	{"num":5, "price":756},
	{"num":6, "price":729},
	{"num":7, "price":702},
	{"num":8, "price":677},
	{"num":9, "price":654},
	{"num":10, "price":635},
	{"num":20, "price":596},
	{"num":30, "price":577},
	{"num":40, "price":562},
	{"num":50, "price":550},
	{"num":100, "price":480},
	{"num":200, "price":409},
	{"num":300, "price":392},
	{"num":400, "price":381},
	{"num":500, "price":351},
	{"num":1000, "price":330}],
	"size75":[
	{"num":1, "price":1599},
	{"num":2, "price":1373},
	{"num":3, "price":1170},
	{"num":4, "price":1135},
	{"num":5, "price":1104},
	{"num":6, "price":1071},
	{"num":7, "price":1043},
	{"num":8, "price":1071},
	{"num":9, "price":992},
	{"num":10, "price":970},
	{"num":20, "price":946},
	{"num":30, "price":925},
	{"num":40, "price":883},
	{"num":50, "price":845},
	{"num":100, "price":779},
	{"num":200, "price":589},
	{"num":300, "price":494},
	{"num":400, "price":479},
	{"num":500, "price":436},
	{"num":1000, "price":405}],
	"size100":[	
	{"num":1, "price":2106},
	{"num":2, "price":1835},
	{"num":3, "price":1626},
	{"num":4, "price":1512},
	{"num":5, "price":1492},
	{"num":6, "price":1461},
	{"num":7, "price":1433},
	{"num":8, "price":1413},
	{"num":9, "price":1370},
	{"num":10, "price":1327},
	{"num":20, "price":1288},
	{"num":30, "price":1251},
	{"num":40, "price":1217},
	{"num":50, "price":1123},
	{"num":100, "price":1019},
	{"num":200, "price":847},
	{"num":300, "price":693},
	{"num":400, "price":665},
	{"num":500, "price":581},
	{"num":1000, "price":532}]
};

var prd_10d_2side = {
	"size50":[
	{"num":1, "price":1600},
	{"num":2, "price":1160},
	{"num":3, "price":953},
	{"num":4, "price":875},
	{"num":5, "price":841},
	{"num":6, "price":809},
	{"num":7, "price":779},
	{"num":8, "price":753},
	{"num":9, "price":728},
	{"num":10, "price":704},
	{"num":20, "price":662},
	{"num":30, "price":642},
	{"num":40, "price":624},
	{"num":50, "price":611},
	{"num":100, "price":534},
	{"num":200, "price":454},
	{"num":300, "price":433},
	{"num":400, "price":416},
	{"num":500, "price":381},
	{"num":1000, "price":362}],
	"size75":[	
	{"num":1, "price":1774},
	{"num":2, "price":1523},
	{"num":3, "price":1296},
	{"num":4, "price":1259},
	{"num":5, "price":1224},
	{"num":6, "price":1186},
	{"num":7, "price":1156},
	{"num":8, "price":1127},
	{"num":9, "price":1098},
	{"num":10, "price":1073},
	{"num":20, "price":1048},
	{"num":30, "price":1024},
	{"num":40, "price":979},
	{"num":50, "price":938},
	{"num":100, "price":865},
	{"num":200, "price":652},
	{"num":300, "price":557},
	{"num":400, "price":539},
	{"num":500, "price":497},
	{"num":1000, "price":464}],
	"size100":[		
	{"num":1, "price":2314},
	{"num":2, "price":2016},
	{"num":3, "price":1787},
	{"num":4, "price":1662},
	{"num":5, "price":1639},
	{"num":6, "price":1606},
	{"num":7, "price":1575},
	{"num":8, "price":1553},
	{"num":9, "price":1504},
	{"num":10, "price":1458},
	{"num":20, "price":1414},
	{"num":30, "price":1375},
	{"num":40, "price":1336},
	{"num":50, "price":1223},
	{"num":100, "price":1119},
	{"num":200, "price":931},
	{"num":300, "price":773},
	{"num":400, "price":742},
	{"num":500, "price":655},
	{"num":1000, "price":602}]
};
// price for 6 days
var prd_6d_1side = {
	"size50":[
	{"num":1, "price":1536},
	{"num":2, "price":1091},
	{"num":3, "price":995},
	{"num":4, "price":914},
	{"num":5, "price":877},
	{"num":6, "price":847},
	{"num":7, "price":815},
	{"num":8, "price":785},
	{"num":9, "price":759},
	{"num":10, "price":735},
	{"num":20, "price":690},
	{"num":30, "price":669},
	{"num":40, "price":651},
	{"num":50, "price":638},
	{"num":100, "price":557},
	{"num":200, "price":454},
	{"num":300, "price":436}],
	"size75":[	
	{"num":1, "price":1853},
	{"num":2, "price":1591},
	{"num":3, "price":1355},
	{"num":4, "price":1315},
	{"num":5, "price":1280},
	{"num":6, "price":1243},
	{"num":7, "price":1208},
	{"num":8, "price":1179},
	{"num":9, "price":1150},
	{"num":10, "price":1125},
	{"num":20, "price":1097},
	{"num":30, "price":1072},
	{"num":40, "price":1024},
	{"num":50, "price":981},
	{"num":100, "price":904},
	{"num":200, "price":654},
	{"num":300, "price":549}],
	"size100":[	
	{"num":1, "price":2439},
	{"num":2, "price":2127},
	{"num":3, "price":1884},
	{"num":4, "price":1752},
	{"num":5, "price":1720},
	{"num":6, "price":1695},
	{"num":7, "price":1659},
	{"num":8, "price":1639},
	{"num":9, "price":1588},
	{"num":10, "price":1538},
	{"num":20, "price":1494},
	{"num":30, "price":1449},
	{"num":40, "price":1409},
	{"num":50, "price":1301},
	{"num":100, "price":1181},
	{"num":200, "price":941},
	{"num":300, "price":770}]
};

var prd_6d_2side = {
	"size50":[
	{"num":1, "price":1838},
	{"num":2, "price":1344},
	{"num":3, "price":1104},
	{"num":4, "price":1014},
	{"num":5, "price":974},
	{"num":6, "price":939},
	{"num":7, "price":904},
	{"num":8, "price":874},
	{"num":9, "price":844},
	{"num":10, "price":816},
	{"num":20, "price":767},
	{"num":30, "price":744},
	{"num":40, "price":723},
	{"num":50, "price":708},
	{"num":100, "price":618},
	{"num":200, "price":504},
	{"num":300, "price":481}],
	"size75":[	
	{"num":1, "price":2054},
	{"num":2, "price":1764},
	{"num":3, "price":1501},
	{"num":4, "price":1459},
	{"num":5, "price":1419},
	{"num":6, "price":1377},
	{"num":7, "price":1339},
	{"num":8, "price":1306},
	{"num":9, "price":1273},
	{"num":10, "price":1245},
	{"num":20, "price":1216},
	{"num":30, "price":1188},
	{"num":40, "price":1135},
	{"num":50, "price":1086},
	{"num":100, "price":1003},
	{"num":200, "price":724},
	{"num":300, "price":619}],
	"size100":[
	{"num":1, "price":2682},
	{"num":2, "price":2336},
	{"num":3, "price":2070},
	{"num":4, "price":1925},
	{"num":5, "price":1893},
	{"num":6, "price":1861},
	{"num":7, "price":1824},
	{"num":8, "price":1800},
	{"num":9, "price":1744},
	{"num":10, "price":1689},
	{"num":20, "price":1641},
	{"num":30, "price":1592},
	{"num":40, "price":1549},
	{"num":50, "price":1430},
	{"num":100, "price":1298},
	{"num":200, "price":1034},
	{"num":300, "price":858}]
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

var parts_obj;
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

		//New condition check button click
		let currentClick = null;
		if (typeof event !== "undefined" && event && event.target) {
			if (document.referrer && (document.referrer == "https://hotmobily.jp/order/cart.php")) {
				currentClick = 'redirect';
			} else {
				currentClick = $(event.target).text();
			}

		} else {
			currentClick = "redirect";
		}

		switch($('#next').text()){
			case "台座・オプション入力へ":
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
				$('#next').text('台座・オプション入力へ');
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

		//New condition check price adapt
        if((currentClick != "" && currentClick !== undefined) && (currentClick === "金額計算・見積・注文へ") && ($('#next').text() == "金額計算・見積・注文へ" && (c == "next")))
        {
            let price_value = calculate_price_manual();
            if(Object.keys(price_value).length !== 0) 
            {
                $.ajax({
                    type: "POST",
                    url: "/products/save_calc_data.php",
                    data: price_value,
                    success: function(response) 
                    {
                        if(response.status == 200 && response.calculation_token){
                            // Append calculation_token to form
                            $('#calculation_token').remove();
                            $('<input>').attr({
                                type: 'hidden',
                                id: 'calculation_token',
                                name: 'calculation_token',
                                value: response.calculation_token
                            }).appendTo('form#form');
                        }	
                    },error: function(xhr, status, error) {
						
                    }	
                });
            }
        }
		else
		{
			if((currentClick != "" && currentClick !== undefined) && (currentClick === "redirect"))
			{
				let price_items = calculate_price_manual();
				if(Object.keys(price_items).length !== 0) 
				{
					$.ajax({
						type: "POST",
						url: "/products/save_calc_data.php",
						data: price_items,
						success: function(response) 
						{
							if(response.status == 200 && response.calculation_token){
								// Append calculation_token to form
								$('#calculation_token').remove();
								$('<input>').attr({
									type: 'hidden',
									id: 'calculation_token',
									name: 'calculation_token',
									value: response.calculation_token
								}).appendTo('form#form');
							}	
						},error: function(xhr, status, error) {
							
						}	
					});
				}
			}
		}
	}
}

function check_val(v) {
	if(v=='next'){
		if (
    $('input[name=qty]').val() == "" ||
    $('input[name=qty]').val() < 1 ||
    $('input[name=qty]').val() > 1000
) {
    $('#qty-error').text('ご注文は5以上200以下でお願いします。');
    return false;
}else{
			if($('input[name=qty]').val()<20){
				$('input[name=acy_sample][type="checkbox"]').prop('checked',false);	
				$('input[name=acy_sample][type="checkbox"]').removeAttr( "checked" );	
				$('#sample-error').text('試作品は20個以上のご注文から受付');
				$('input[name=acy_sample][type="checkbox"]').attr('disabled',true);
			}else{
				$('#sample-error').text('※試作品をご希望される場合、ご注文納期とは別に試作品製作時間として6営業日+配送2日が必要になります。ご注文確定後に試作品の有無をご変更されるお客様が多くなっております。納期に余裕の無い場合、試作品のご依頼はご遠慮下さい。');
				$('input[name=acy_sample]').attr('disabled',false);
			}
			if($('input[name="acy_delivery"]:checked').val()=="6営業日" && $('input[name=qty]').val()>200){
    $('#qty-error').text('6営業日のご注文は200個以下となります');
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

function chk_part(){
	return true;
}

function cal_c(v) {
	var prodc_day = $('input[name="acy_delivery"]:checked').val();
	var ItemSize = $('input[name="acy_size"]:checked').val();
	var screen = $('input[name="acy_screen"]:checked').val();
	var paper = $('input[name="acy_paper_select"]:checked').val();
	var paper_color = $('input[name="acy_paper"]:checked').val();
	var sample = $('input[name="acy_sample"]:checked').val();
	var trace = $('input[name="acy_trace"]:checked').val();
	var qty = $('input[name="qty"]').val();
	var type = $('input[name="acy_cat"]:checked').val();
	var trace_price = 0;
	var displaySize = getDioramastandDisplaySize(ItemSize);

	partPrice = 0;
	$('#sample-part-pic').hide();
	$('#sample-part-name').text('\u53F0\u5EA7:\u306A\u3057');
	$('#prd_part').text('\u306A\u3057');

	// Get paper data
	if(paper!=undefined){
		$('.paper-container').show();
		if(paper_color!=undefined){
			$('#sample-paper-pic').show();
			$('#sample-paper-pic').attr('src',"https://hotmobily.jp/products/acrylic/img/"+paper_color+".jpg?v=1.01");
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
	$('#sample-prd-size').text(displaySize);
	$('#sample-prd-screen').text(screen);
	$('#sample-prd-qty').text(qty);
	$('#sample-prd-type').text(type);

	$('#prd_production').text(prodc_day);
	$('#prd_size').text(displaySize);
	$('#prd_type').text(type);
	$('#prd_print').text(screen);
	$('#prd_amount').text(qty);
	if(sample!=undefined){$('#prd_sample').text(sample);$('#sample-prd-samp').text(sample);}else{$('#prd_sample').text('なし');$('#sample-prd-samp').text('なし');}
	if(trace!=undefined){$('#prd_trace').text(trace);trace_price=0;$('#sample-prd-trace').text(trace);}else{$('#prd_trace').text('なし');$('#sample-prd-trace').text('なし');}

	// Get unit price
	for (var i = 0, iMax = get_price().length; i < iMax; i++) {
		if (parseInt(qty) >= parseInt(get_price()[i].num)) {
			// unit_price = Math.floor(get_price()[i].price*(1+vat/100));
			unit_price = Math.floor(get_price()[i].price);
			continue;
		}
		break;
	}

	// passed
	sub_total = Math.floor(((unit_price*qty)+trace_price+(partPrice*qty)+(paperPrice*qty)));
	// discount setup by timer
	let timer = new Date().toISOString();
	
	let startDate = new Date("2024-01-24T00:00:00");
	let endDate = new Date("2024-02-16T23:59:00");
	
	if (timer > startDate.toISOString() && timer < endDate.toISOString()) {
		disPrice = Math.floor(parseInt(sub_total*0.05));
	} 

	vat_price = Math.floor((((unit_price*qty))+trace_price+((partPrice*qty)*vat/(100+vat))+((paperPrice*qty)*vat/(100+vat))));
	// vat_price = vat_price - (vat_price*vat/100);

	total = Math.floor((parseInt(sub_total)-parseInt(disPrice)));

	$('#prd_part_price').val((partPrice*qty).toLocaleString("en"));
	$('#prd_paper_price').val((paperPrice*qty).toLocaleString("en"));
	$('#prd_sample_price').val('0');
	$('#prd_trace_price').val(trace_price.toLocaleString("en"));
	$('#prd_price').val((unit_price*qty).toLocaleString("en"));

	$('#prd_sub_total').val((sub_total).toLocaleString("en"));
	// $('#vat').val(vat_price.toLocaleString("en"));
	$('#discount').val(disPrice.toLocaleString("en"));
	$('.prd_total').text(total.toLocaleString("en"));
	$('#prd_total').val(total.toLocaleString("en"));
}

//New condition check price adapt
function calculate_price_manual(v) {
	var prodc_day = $('input[name="acy_delivery"]:checked').val();
	var ItemSize = $('input[name="acy_size"]:checked').val();
	var screen = $('input[name="acy_screen"]:checked').val();
	var paper = $('input[name="acy_paper_select"]:checked').val();
	var paper_color = $('input[name="acy_paper"]:checked').val();
	var sample = $('input[name="acy_sample"]:checked').val();
	var trace = $('input[name="acy_trace"]:checked').val();
	var qty = $('input[name="qty"]').val();
	var prd = $('#strap').val();
	var trace_price = 0;
	var displaySize = getDioramastandDisplaySize(ItemSize);

	partPrice = 0;
	$('#sample-part-pic').hide();
	$('#sample-part-name').text('\u53F0\u5EA7:\u306A\u3057');
	$('#prd_part').text('\u306A\u3057');

	// Get paper data
	if(paper!=undefined){
		$('.paper-container').show();
		if(paper_color!=undefined){
			$('#sample-paper-pic').show();
			$('#sample-paper-pic').attr('src',"https://hotmobily.jp/products/acrylic/img/"+paper_color+".jpg?v=1.01");
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
	$('#sample-prd-size').text(displaySize);
	$('#sample-prd-screen').text(screen);
	$('#sample-prd-qty').text(qty);

	$('#prd_production').text(prodc_day);
	$('#prd_size').text(displaySize);
	$('#prd_print').text(screen);
	$('#prd_amount').text(qty);
	if(sample!=undefined){$('#prd_sample').text(sample);$('#sample-prd-samp').text(sample);}else{$('#prd_sample').text('なし');$('#sample-prd-samp').text('なし');}
	if(trace!=undefined){$('#prd_trace').text(trace);trace_price=0;$('#sample-prd-trace').text(trace);}else{$('#prd_trace').text('なし');$('#sample-prd-trace').text('なし');}

	// Get unit price
	for (var i = 0, iMax = get_price().length; i < iMax; i++) {
		if (parseInt(qty) >= parseInt(get_price()[i].num)) {
			unit_price = Math.floor(get_price()[i].price);
			continue;
		}
		break;
	}

	// passed
	sub_total = Math.floor(((unit_price*qty)+trace_price+(partPrice*qty)+(paperPrice*qty)));
	// discount setup by timer
	let timer = new Date().toISOString();
	
	let startDate = new Date("2024-01-24T00:00:00");
	let endDate = new Date("2024-02-16T23:59:00");
	
	if (timer > startDate.toISOString() && timer < endDate.toISOString()) {
		disPrice = Math.floor(parseInt(sub_total*0.05));
	} 

	vat_price = Math.floor((((unit_price*qty)*vat/(100+vat))+trace_price+((partPrice*qty)*vat/(100+vat))+((paperPrice*qty)*vat/(100+vat))));
	// vat_price = vat_price - (vat_price*vat/100);

	total = Math.floor((parseInt(sub_total)-parseInt(disPrice)));

	$('#prd_part_price').val((partPrice*qty).toLocaleString("en"));
	$('#prd_paper_price').val((paperPrice*qty).toLocaleString("en"));
	$('#prd_sample_price').val('0');
	$('#prd_trace_price').val(trace_price.toLocaleString("en"));
	$('#prd_price').val((unit_price*qty).toLocaleString("en"));

	$('#prd_sub_total').val((sub_total).toLocaleString("en"));
	// $('#vat').val(vat_price.toLocaleString("en"));
	$('#discount').val(disPrice.toLocaleString("en"));
	$('.prd_total').text(total.toLocaleString("en"));
	$('#prd_total').val(total.toLocaleString("en"));

	let proto_charge = 0;
    let ai_price = 0;

    let shipping_price = 880;
    if (sub_total > 11000) {
        shipping_price = 0;
    }

    return {
		sku: 'acrylic-figure',
        product: prd,
        qty: qty,
        product_price: Math.floor(unit_price*qty),
        part_price: (partPrice*qty),
        paper_price: (paperPrice*qty),
        prototype_price: proto_charge,
        ai_assistant_price: ai_price,
        trace_price: trace_price,
        discount: disPrice,
        shipping: shipping_price,
        vat: vat_price,
        subtotal: sub_total,
        total: total
    };
}

function get_price() {
	var sizeKey = getDioramastandPriceSizeKey($('input[name="acy_size"]:checked').val());

	switch($('input[name="acy_screen"]:checked').val()){
		case "片面印刷":
			return prd_1side[sizeKey];
		case "両面印刷":
			return prd_2side[sizeKey];
	}

	return [];
}

function getDioramastandPriceSizeKey(size) {
	switch(size){
		case '100': return 'size100';
		case '150': return 'size150';
		case '200': return 'size200';
		case '50': return 'size100';
		case '75': return 'size150';
		default: return 'size100';
	}
}

function getDioramastandDisplaySize(size) {
	switch(size){
		case '100': return '100x100mm以内';
		case '150': return '150x200mm以内';
		case '200': return '200x270mm以内';
		case '50': return '100x100mm以内';
		case '75': return '150x200mm以内';
		default: return '100x100mm以内';
	}
}

function getDioramastandPartSizeValue(size) {
	switch(size){
		case '100': return '50';
		case '150': return '75';
		case '200': return '100';
		default: return size;
	}
}
// Set amount
var amount = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100', '200', '300', '400', '500', '600', '700', '800', '900', '1000'];
var amount_add = [];

$(function() {
	writePriceTable();
	getPartData();
});

var prd_1side = {
    size100: [
        { num: '1', price: 1496 },
        { num: '5', price: 1238 },
        { num: '10', price: 770 },
        { num: '50', price: 666 },
        { num: '100', price: 588 },
        { num: '200', price: 530 },
        { num: '300', price: 496 },
        { num: '500', price: 454 },
        { num: '1000', price: 398 }
    ],
    size150: [
        { num: '1', price: 2974 },
        { num: '5', price: 2286 },
        { num: '10', price: 1923 },
        { num: '50', price: 1664 },
        { num: '100', price: 1469 },
        { num: '200', price: 1346 },
        { num: '300', price: 1245 },
        { num: '500', price: 1153 },
        { num: '1000', price: 1012 }
    ],
    size200: [
        { num: '1', price: 3429 },
        { num: '5', price: 2797 },
        { num: '10', price: 2495 },
        { num: '50', price: 2312 },
        { num: '100', price: 2204 },
        { num: '200', price: 2064 },
        { num: '300', price: 1889 },
        { num: '500', price: 1751 },
        { num: '1000', price: 1623 }
    ]
};

var prd_2side = {
    size100: [
        { num: '1', price: 1647 },
        { num: '5', price: 1054 },
        { num: '10', price: 953 },
        { num: '50', price: 782 },
        { num: '100', price: 727 },
        { num: '200', price: 606 },
        { num: '300', price: 572 },
        { num: '500', price: 534 },
        { num: '1000', price: 496 }
    ],
    size150: [
        { num: '1', price: 3263 },
        { num: '5', price: 2506 },
        { num: '10', price: 2107 },
        { num: '50', price: 1822 },
        { num: '100', price: 1646 },
        { num: '200', price: 1504 },
        { num: '300', price: 1397 },
        { num: '500', price: 1298 },
        { num: '1000', price: 1141 }
    ],
    size200: [
        { num: '1', price: 3944 },
        { num: '5', price: 3214 },
        { num: '10', price: 2865 },
        { num: '50', price: 2603 },
        { num: '100', price: 2459 },
        { num: '200', price: 2154 },
        { num: '300', price: 1997 },
        { num: '500', price: 1874 },
        { num: '1000', price: 1742 }
    ]
};

var amount = [];
var amount_add = [];

function writePriceTable() {
    var screen = $('input[name=prc_screen]:checked').val();
    var price = {};

    if (screen == "1") {
        price = prd_1side;
        amount = ['1', '5', '10', '50', '100', '200','300','500','1000'];
    } else if (screen == "2") {
        price = prd_2side;
        amount = ['1', '5', '10', '50', '100', '200','300','500','1000'];
    }

    var text = "";
    $('.price-row').remove();

    var priceKeys = Object.keys(price);

    for (var i = 0; i < amount.length; i++) {
        text += '<tr class="price-row"><td>' + amount[i] + '</td>';

        for (var j = 0; j < priceKeys.length; j++) {
            var key = priceKeys[j];
            var price1 = '';

            for (var k = 0; k < price[key].length; k++) {
                if (parseInt(amount[i]) >= parseInt(price[key][k].num)) {
                    price1 = Math.floor(price[key][k].price);
                    continue;
                }
                break;
            }

            text += '<td>' + price1 + '</td>';
        }

        text += '</tr>';
    }

    $('.tbl-price tbody').html(text);
}
function getPartData() 
{
	parts_obj = null;
	cal_c();

		//Create new token when page load
		let prd_strap = $('#strap').val();

		if ($('#ms_mode').val() != "" && $('#ms_mode').val() == "MODE_MOD" && (prd_strap == "アクリルフィギュアスタンド")) //Only Figure
        {
			let items = calculate_price_manual();
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

	
}
//PDF export
function validate(tmp){ 
	ytag({
		"type": "yss_conversion",
		"config": {
			"yahoo_conversion_id": "1000179237",
			"yahoo_conversion_label": "B-vUCIagnVkQr-mfxwM",
			"yahoo_conversion_value": "0"
		}
	});

	gtag('event', 'conversion', {
		'send_to': 'AW-1036353231/IGnMCK-CuAEQz_2V7gM'
	});
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
    Item = $('#strap').val();
    delivery = $("input[name=acy_delivery]:checked").val();
    itemtype_size = getDioramastandDisplaySize($("input[name=acy_size]:checked").val());

    parts = "\u306A\u3057";
	var acy_cat = $('input[name="acy_cat"]:checked').val();

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
    //E
    Item_print = $("input[name=acy_screen]:checked").val();
    
    var item_price = unit_price;

   	var discount_quo = disPrice;

    var sum1_quo = sub_total.toLocaleString("en");
    // var sum2_quo = $('#prd_sub_total').val();
    // var sum3_quo = $('#vat').val();
    var sum2_quo = 0;
    var sum3_quo = vat_price;
    var sum4_quo = total.toLocaleString("en");

    var example_price = 0,ai_file_price = 0;

    if(ai_file == "1"){
    	ai_file_price = "0";
    }

    var parts_price = 0;
    var delivery_price = 0;

    if(total < 11000){
    	delivery_price = 880;
    	sum4_quo = (total+delivery_price).toLocaleString("en");
    	sum3_quo = vat_price+(delivery_price*vat/(100+vat));
    }
    
    var remark = "";
    if($('input[name=ItemDesignRepeat]:checked').val() == 'はい'){
      remark = "過去と同じデザイン:"+$('input[name=design_no]').val();
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
		"acy_cat": acy_cat,
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
        "remark": remark,
        "save": "yes"
      },
      success: function(data){
        
		if(data=="success"){
			if(isSafari){
				location.href = '/tcpdf/examples/pdf_export.php';
			  }else{
				var win = window.open('/tcpdf/examples/pdf_export.php', '_blank');
				win.focus();
				$('.loading').hide();
			  }
		}else{
			alert(data);
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
	getPartData();
	cal_c();
}
