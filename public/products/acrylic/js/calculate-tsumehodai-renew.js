var isSafari = navigator.vendor && navigator.vendor.indexOf('Apple') > -1 &&
navigator.userAgent &&
navigator.userAgent.indexOf('CriOS') == -1 &&
navigator.userAgent.indexOf('FxiOS') == -1;
// price for 10 days
// var prd_10d_1side = {
// 	"size50":[
// 	{"num":1, "price":900},
// 	{"num":2, "price":572},
// 	{"num":3, "price":462},
// 	{"num":4, "price":407},
// 	{"num":5, "price":374},
// 	{"num":6, "price":353},
// 	{"num":7, "price":337},
// 	{"num":8, "price":325},
// 	{"num":9, "price":316},
// 	{"num":10, "price":299},
// 	{"num":20, "price":264},
// 	{"num":30, "price":251},
// 	{"num":40, "price":240},
// 	{"num":50, "price":232},
// 	{"num":60, "price":218},
// 	{"num":70, "price":207},
// 	{"num":80, "price":200},
// 	{"num":90, "price":193},
// 	{"num":100, "price":189},
// 	{"num":200, "price":176},
// 	{"num":300, "price":171},
// 	{"num":400, "price":165},
// 	{"num":500, "price":162},
// 	{"num":600, "price":159},
// 	{"num":700, "price":157},
// 	{"num":800, "price":155},
// 	{"num":900, "price":154},
// 	{"num":1000, "price":153}],
// 	"size75":[
// 	{"num":1, "price":990},
// 	{"num":2, "price":630},
// 	{"num":3, "price":510},
// 	{"num":4, "price":450},
// 	{"num":5, "price":414},
// 	{"num":6, "price":390},
// 	{"num":7, "price":373},
// 	{"num":8, "price":360},
// 	{"num":9, "price":350},
// 	{"num":10, "price":334},
// 	{"num":20, "price":295},
// 	{"num":30, "price":278},
// 	{"num":40, "price":267},
// 	{"num":50, "price":259},
// 	{"num":60, "price":242},
// 	{"num":70, "price":229},
// 	{"num":80, "price":220},
// 	{"num":90, "price":212},
// 	{"num":100, "price":207},
// 	{"num":200, "price":201},
// 	{"num":300, "price":198},
// 	{"num":400, "price":192},
// 	{"num":500, "price":189},
// 	{"num":600, "price":186},
// 	{"num":700, "price":184},
// 	{"num":800, "price":182},
// 	{"num":900, "price":181},
// 	{"num":1000, "price":180}],
// 	"size100":[	
// 	{"num":1, "price":1080},
// 	{"num":2, "price":729},
// 	{"num":3, "price":612},
// 	{"num":4, "price":554},
// 	{"num":5, "price":518},
// 	{"num":6, "price":495},
// 	{"num":7, "price":478},
// 	{"num":8, "price":466},
// 	{"num":9, "price":456},
// 	{"num":10, "price":433},
// 	{"num":20, "price":394},
// 	{"num":30, "price":376},
// 	{"num":40, "price":361},
// 	{"num":50, "price":349},
// 	{"num":60, "price":335},
// 	{"num":70, "price":324},
// 	{"num":80, "price":317},
// 	{"num":90, "price":310},
// 	{"num":100, "price":306},
// 	{"num":200, "price":293},
// 	{"num":300, "price":288},
// 	{"num":400, "price":266},
// 	{"num":500, "price":252},
// 	{"num":600, "price":249},
// 	{"num":700, "price":247},
// 	{"num":800, "price":245},
// 	{"num":900, "price":244},
// 	{"num":1000, "price":243}]
// };

// var prd_10d_2side = {
// 	"size50":[
// 	{"num":1, "price":1125},
// 	{"num":2, "price":716},
// 	{"num":3, "price":579},
// 	{"num":4, "price":509},
// 	{"num":5, "price":468},
// 	{"num":6, "price":441},
// 	{"num":7, "price":422},
// 	{"num":8, "price":406},
// 	{"num":9, "price":395},
// 	{"num":10, "price":373},
// 	{"num":20, "price":330},
// 	{"num":30, "price":313},
// 	{"num":40, "price":300},
// 	{"num":50, "price":290},
// 	{"num":60, "price":272},
// 	{"num":70, "price":259},
// 	{"num":80, "price":249},
// 	{"num":90, "price":242},
// 	{"num":100, "price":236},
// 	{"num":200, "price":221},
// 	{"num":300, "price":214},
// 	{"num":400, "price":207},
// 	{"num":500, "price":203},
// 	{"num":600, "price":199},
// 	{"num":700, "price":196},
// 	{"num":800, "price":194},
// 	{"num":900, "price":193},
// 	{"num":1000, "price":191}],
// 	"size75":[	
// 	{"num":1, "price":1242},
// 	{"num":2, "price":788},
// 	{"num":3, "price":639},
// 	{"num":4, "price":563},
// 	{"num":5, "price":518},
// 	{"num":6, "price":488},
// 	{"num":7, "price":467},
// 	{"num":8, "price":450},
// 	{"num":9, "price":438},
// 	{"num":10, "price":417},
// 	{"num":20, "price":369},
// 	{"num":30, "price":347},
// 	{"num":40, "price":334},
// 	{"num":50, "price":324},
// 	{"num":60, "price":302},
// 	{"num":70, "price":286},
// 	{"num":80, "price":275},
// 	{"num":90, "price":265},
// 	{"num":100, "price":259},
// 	{"num":200, "price":251},
// 	{"num":300, "price":248},
// 	{"num":400, "price":240},
// 	{"num":500, "price":236},
// 	{"num":600, "price":233},
// 	{"num":700, "price":230},
// 	{"num":800, "price":228},
// 	{"num":900, "price":226},
// 	{"num":1000, "price":225}],
// 	"size100":[		
// 	{"num":1, "price":1350},
// 	{"num":2, "price":914},
// 	{"num":3, "price":765},
// 	{"num":4, "price":693},
// 	{"num":5, "price":648},
// 	{"num":6, "price":620},
// 	{"num":7, "price":598},
// 	{"num":8, "price":583},
// 	{"num":9, "price":570},
// 	{"num":10, "price":541},
// 	{"num":20, "price":492},
// 	{"num":30, "price":470},
// 	{"num":40, "price":451},
// 	{"num":50, "price":437},
// 	{"num":60, "price":418},
// 	{"num":70, "price":406},
// 	{"num":80, "price":396},
// 	{"num":90, "price":388},
// 	{"num":100, "price":383},
// 	{"num":200, "price":367},
// 	{"num":300, "price":360},
// 	{"num":400, "price":332},
// 	{"num":500, "price":315},
// 	{"num":600, "price":311},
// 	{"num":700, "price":309},
// 	{"num":800, "price":307},
// 	{"num":900, "price":305},
// 	{"num":1000, "price":304}]
// };

// // price for 6 days
// var prd_6d_1side = {
// 	"size50":[
// 	{"num":1, "price":999},
// 	{"num":2, "price":635},
// 	{"num":3, "price":513},
// 	{"num":4, "price":452},
// 	{"num":5, "price":416},
// 	{"num":6, "price":392},
// 	{"num":7, "price":374},
// 	{"num":8, "price":361},
// 	{"num":9, "price":351},
// 	{"num":10, "price":332},
// 	{"num":20, "price":293},
// 	{"num":30, "price":278},
// 	{"num":40, "price":266},
// 	{"num":50, "price":258},
// 	{"num":60, "price":242},
// 	{"num":70, "price":230},
// 	{"num":80, "price":222},
// 	{"num":90, "price":215},
// 	{"num":100, "price":210},
// 	{"num":200, "price":196},
// 	{"num":300, "price":190}],
// 	"size75":[	
// 	{"num":1, "price":1098},
// 	{"num":2, "price":702},
// 	{"num":3, "price":567},
// 	{"num":4, "price":500},
// 	{"num":5, "price":461},
// 	{"num":6, "price":434},
// 	{"num":7, "price":414},
// 	{"num":8, "price":401},
// 	{"num":9, "price":389},
// 	{"num":10, "price":371},
// 	{"num":20, "price":327},
// 	{"num":30, "price":308},
// 	{"num":40, "price":297},
// 	{"num":50, "price":288},
// 	{"num":60, "price":268},
// 	{"num":70, "price":255},
// 	{"num":80, "price":244},
// 	{"num":90, "price":236},
// 	{"num":100, "price":230},
// 	{"num":200, "price":223},
// 	{"num":300, "price":220}],
// 	"size100":[	
// 	{"num":1, "price":1197},
// 	{"num":2, "price":810},
// 	{"num":3, "price":681},
// 	{"num":4, "price":614},
// 	{"num":5, "price":576},
// 	{"num":6, "price":551},
// 	{"num":7, "price":531},
// 	{"num":8, "price":518},
// 	{"num":9, "price":507},
// 	{"num":10, "price":481},
// 	{"num":20, "price":438},
// 	{"num":30, "price":418},
// 	{"num":40, "price":401},
// 	{"num":50, "price":388},
// 	{"num":60, "price":372},
// 	{"num":70, "price":360},
// 	{"num":80, "price":352},
// 	{"num":90, "price":345},
// 	{"num":100, "price":340},
// 	{"num":200, "price":326},
// 	{"num":300, "price":320}]
// };

// var prd_6d_2side = {
// 	"size50":[
// 	{"num":1, "price":1251},
// 	{"num":2, "price":792},
// 	{"num":3, "price":642},
// 	{"num":4, "price":656},
// 	{"num":5, "price":520},
// 	{"num":6, "price":489},
// 	{"num":7, "price":468},
// 	{"num":8, "price":451},
// 	{"num":9, "price":439},
// 	{"num":10, "price":416},
// 	{"num":20, "price":366},
// 	{"num":30, "price":348},
// 	{"num":40, "price":333},
// 	{"num":50, "price":323},
// 	{"num":60, "price":302},
// 	{"num":70, "price":288},
// 	{"num":80, "price":277},
// 	{"num":90, "price":269},
// 	{"num":100, "price":262},
// 	{"num":200, "price":245},
// 	{"num":300, "price":237}],
// 	"size75":[	
// 	{"num":1, "price":1377},
// 	{"num":2, "price":878},
// 	{"num":3, "price":708},
// 	{"num":4, "price":626},
// 	{"num":5, "price":576},
// 	{"num":6, "price":542},
// 	{"num":7, "price":518},
// 	{"num":8, "price":501},
// 	{"num":9, "price":486},
// 	{"num":10, "price":463},
// 	{"num":20, "price":409},
// 	{"num":30, "price":386},
// 	{"num":40, "price":371},
// 	{"num":50, "price":360},
// 	{"num":60, "price":336},
// 	{"num":70, "price":318},
// 	{"num":80, "price":305},
// 	{"num":90, "price":295},
// 	{"num":100, "price":288},
// 	{"num":200, "price":279},
// 	{"num":300, "price":275}],
// 	"size100":[
// 	{"num":1, "price":1494},
// 	{"num":2, "price":1013},
// 	{"num":3, "price":852},
// 	{"num":4, "price":767},
// 	{"num":5, "price":720},
// 	{"num":6, "price":689},
// 	{"num":7, "price":663},
// 	{"num":8, "price":647},
// 	{"num":9, "price":634},
// 	{"num":10, "price":601},
// 	{"num":20, "price":547},
// 	{"num":30, "price":522},
// 	{"num":40, "price":502},
// 	{"num":50, "price":485},
// 	{"num":60, "price":465},
// 	{"num":70, "price":451},
// 	{"num":80, "price":440},
// 	{"num":90, "price":431},
// 	{"num":100, "price":425},
// 	{"num":200, "price":408},
// 	{"num":300, "price":400}]
// };

var prd_price = {
	"1side":[
	{"num":1, "price":3500},
	{"num":2, "price":3500},
	{"num":3, "price":3500},
	{"num":4, "price":3500},
	{"num":5, "price":3500},
	{"num":6, "price":3500},
	{"num":7, "price":3500},
	{"num":8, "price":3500},
	{"num":9, "price":3500},
	{"num":10, "price":3500},
	{"num":20, "price":3500},
	{"num":30, "price":3500},
	{"num":40, "price":3500},
	{"num":50, "price":3500},
	{"num":60, "price":3500},
	{"num":70, "price":3500},
	{"num":80, "price":3500},
	{"num":90, "price":3500},
	{"num":100, "price":3500},
	{"num":200, "price":3500},
	{"num":300, "price":3500},
	{"num":400, "price":3500},
	{"num":500, "price":3500},
	{"num":600, "price":3500},
	{"num":700, "price":3500},
	{"num":800, "price":3500},
	{"num":900, "price":3500},
	{"num":1000, "price":3500}],
	"2side":[
	{"num":1, "price":4500},
	{"num":2, "price":4500},
	{"num":3, "price":4500},
	{"num":4, "price":4500},
	{"num":5, "price":4500},
	{"num":6, "price":4500},
	{"num":7, "price":4500},
	{"num":8, "price":4500},
	{"num":9, "price":4500},
	{"num":10, "price":4500},
	{"num":20, "price":4500},
	{"num":30, "price":4500},
	{"num":40, "price":4500},
	{"num":50, "price":4500},
	{"num":60, "price":4500},
	{"num":70, "price":4500},
	{"num":80, "price":4500},
	{"num":90, "price":4500},
	{"num":100, "price":4500},
	{"num":200, "price":4500},
	{"num":300, "price":4500},
	{"num":400, "price":4500},
	{"num":500, "price":4500},
	{"num":600, "price":4500},
	{"num":700, "price":4500},
	{"num":800, "price":4500},
	{"num":900, "price":4500},
	{"num":1000, "price":4500}],
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

function resetStep2Selections() {
	$('input[name="acy_part"]').prop('checked', false);
	$('input[name="qoa"]').prop('disabled', false).val('');
	$('input[name="acy_sample"][type="checkbox"]').prop('checked', false).attr('disabled', false);
	$('input[name="acy_trace"][type="checkbox"]').prop('checked', false);
	$('input[name="acy_paper_select"]').prop('checked', false);
	$('input[name="acy_paper"]').prop('checked', false);

	$('#part-error').text('');
	$('#qoa-error').text('');
	$('#sample-error').text('');
	$('#paper-error').text('');

	parts_obj = undefined;
	partPrice = 0;
	paperPrice = 0;

	cal_c();
}

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
			case "アタッチメント・オプション入力へ":
			if(c=='next' || c=='step2'){
				$('#back').fadeIn('slow');	
				$('#next').text('金額計算・見積・注文へ');
				$('#step2').fadeIn('slow');
				$('#dot-step1').addClass('active');
				$('#dot-step2').addClass('active');
				chk_part();
				cal_c();
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
				cal_c();
				// console.log('bb');
			}else if(c=='back' || c=='step1'){
				resetStep2Selections();
				$('#next').fadeIn('slow');	
				$('#step1').fadeIn('slow');
				$('#next').text('アタッチメント・オプション入力へ');
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
            // let price_value = calculate_price_manual();
            // if(Object.keys(price_value).length !== 0) 
            // {
            //     $.ajax({
            //         type: "POST",
            //         url: "/products/save_calc_data.php",
            //         data: price_value,
            //         success: function(response) 
            //         {
            //             if(response.status == 200 && response.calculation_token){
            //                 // Append calculation_token to form
            //                 $('#calculation_token').remove();
            //                 $('<input>').attr({
            //                     type: 'hidden',
            //                     id: 'calculation_token',
            //                     name: 'calculation_token',
            //                     value: response.calculation_token
            //                 }).appendTo('form#form');
            //             }	
            //         },error: function(xhr, status, error) {
						
            //         }	
            //     });
            // }
        }
		else
		{
			// if((currentClick != "" && currentClick !== undefined) && (currentClick === "redirect"))
			// {
			// 	let price_items = calculate_price_manual();
			// 	if(Object.keys(price_items).length !== 0) 
			// 	{
			// 		$.ajax({
			// 			type: "POST",
			// 			url: "/products/save_calc_data.php",
			// 			data: price_items,
			// 			success: function(response) 
			// 			{
			// 				if(response.status == 200 && response.calculation_token){
			// 					// Append calculation_token to form
			// 					$('#calculation_token').remove();
			// 					$('<input>').attr({
			// 						type: 'hidden',
			// 						id: 'calculation_token',
			// 						name: 'calculation_token',
			// 						value: response.calculation_token
			// 					}).appendTo('form#form');
			// 				}	
			// 			},error: function(xhr, status, error) {
							
			// 			}	
			// 		});
			// 	}
			// }
		}

	}
}

function check_val(v) {
	// Toggle .repeat div based on acy_repeat selection
	if ($('input[name="acy_repeat"]:checked').val() == 'はい') {
		$('.repeat').show();
	} else {
		$('.repeat').hide();
	}

	if(v=='next'){
		if($('input[name=qty]').val()=="" || $('input[name=qty]').val()<=0 || $('input[name=qty]').val()>100){
			$('#qty-error').text('ご注文は1以上100以下でお願いします。');
			return false;
		}else{

			if(!chk_part()){
				return false;
			}
			if($('input[name=qty]').val()<20){
				$('input[name=acy_sample][type="checkbox"]').prop('checked',false);	
				$('input[name=acy_sample][type="checkbox"]').removeAttr( "checked" );	
				$('#sample-error').text('試作品は20個以上のご注文から受付');
				$('input[name=acy_sample][type="checkbox"]').attr('disabled',true);
				$('input[name="acy_sample"][type="checkbox"]').closest('label').css({'pointer-events': 'none', 'opacity': '0.5'});
			}else{
				$('#sample-error').text('※試作品をご希望される場合、ご注文納期とは別に試作品製作時間として6営業日+配送2日が必要になります。ご注文確定後に試作品の有無をご変更されるお客様が多くなっております。納期に余裕の無い場合、試作品のご依頼はご遠慮下さい。');
				$('input[name=acy_sample]').attr('disabled',false);
				$('input[name="acy_sample"][type="checkbox"]').closest('label').css({'pointer-events': 'auto', 'opacity': '1'});
			}
			if($('input[name="acy_delivery"]:checked').val()=="6営業日" && $('input[name=qty]').val()>300){
				$('#qty-error').text('6営業日のご注文は300個以下となります');
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
	if($('input[name="acy_part"]:checked').val()==undefined){
		$('#next').attr('disabled',true);
		$('#part-error').text('アタッチメントを選択してください');
		validation('step2');
		return false;
	}else{
		if ($('input[name="acy_part"]:checked').val() != 'なし') {
			var qty_val = parseInt($('input[name=qty]').val()) || 0;
			var qoa_val = parseInt($('input[name=qoa]').val()) || 0;

			// จำกัด qoa สูงสุดที่ 10 เสมอ
			var qoa_max = 10;

			// update max attribute dynamically
			$('input[name=qoa]').attr('max', qoa_max);

			if($('input[name=qoa]').val() == "" || qoa_val <= 0 || qoa_val > qoa_max){
				$('#next').attr('disabled',true);
				$('#qoa-error').text('アタッチメント数量はアクリル詰め放題1点につき10個までとなります。');
				validation('step2');
				return false;
			}else{
				$('#qoa-error').text('');
			}
		}else{
			$('#qoa-error').text('');
		}
		$('#part-error').text('');
		return true;
	}
}

function cal_c(v) {
	var prodc_day = $('input[name="acy_delivery"]:checked').val();
	var ItemSize = $('input[name="acy_size"]:checked').val();
	var screen = $('input[name="acy_screen"]:checked').val();
	if (screen === undefined) {
		screen = $('input[name="acy_print"]:checked').val();
	}
	var part = $('input[name="acy_part"]:checked').val();
	var paper = $('input[name="acy_paper_select"]:checked').val();
	var paper_color = $('input[name="acy_paper"]:checked').val();
	var qty = $('input[name="qty"]').val();
	
	// Force disable sample switch if qty < 20
	if(parseInt(qty) < 20){
		$('input[name="acy_sample"][type="checkbox"]').prop('checked', false).removeAttr("checked").attr('disabled', true);
		$('input[name="acy_sample"][type="checkbox"]').closest('label').css({'pointer-events': 'none', 'opacity': '0.5'});
		$('#sample-error').text('試作品は20個以上のご注文から受付');
	} else {
		$('input[name="acy_sample"][type="checkbox"]').attr('disabled', false);
		$('input[name="acy_sample"][type="checkbox"]').closest('label').css({'pointer-events': 'auto', 'opacity': '1'});
		$('#sample-error').text('');
	}

	var sample = $('input[name="acy_sample"]:checked').val();
	var trace = $('input[name="acy_trace"]:checked').val();
	var qoa = $('input[name="qoa"]').val() || 0;
	var color = $('input[name="acy_color"]:checked').val();
	var trace_price = 0;

	// Update total attachment count display (qty × qoa)
	var total_att = (parseInt(qty) || 0) * (parseInt(qoa) || 0);
	$('#total-attachment-count').text('アタッチメントの合計数量 : ' + total_att + '）');

	// console.log(paper);

	// Get part price
	if(part!=undefined){
		if(part == 'なし') {
			$('input[name="qoa"]').prop('disabled', false).prop('readonly', true).val(0);
			qoa = 0;
		} else {
			$('input[name="qoa"]').prop('disabled', false).prop('readonly', false);
		}
		$('#part-error').text('');
		$('#sample-part-pic').show();
		partPrice = Math.floor(parts_obj["part_price"]*(1+vat/100));
		$('#sample-part-pic').attr('src',parts_obj["part_pic"]);
		$('#sample-part-name').text(parts_obj["part_name"]);
	}else{
		partPrice = 0;
		$('#sample-part-pic').hide();
		$('#sample-part-name').text('アタッチメント:なし');
	}

	// Get paper data
	if(paper!=undefined){
		$('.paper-container').show();
		if(paper_color!=undefined){
			$('#sample-paper-pic').show();
			$('#sample-paper-pic').attr('src',"img/"+paper_color+".jpg?v=1.01");
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

	$('#sample-prd-size').text('70*70mm');
	$('#sample-prd-screen').text(screen);
	$('#sample-prd-print').text(screen);
	$('#sample-prd-qty').text(qty);
	$('#sample-prd-color').text(color);
	$('#sample-prd-part').html('詰め放題1枚あたり' + qoa + '個<br>（合計数量 : ' + total_att + '）');

	$('#prd_production').text(prodc_day);
	$('#prd_size').text('70*70mm');
	$('#prd_color').text(screen);
	$('#prd_print').text(screen);
	$('#prd_amount').text(qty);
	$('#prd_part').text(part);
	$('#prd_qoa').html('詰め放題1枚あたり' + (qoa || 0) + '個<br>（合計数量 : ' + total_att + '）');
	if(sample!=undefined){$('#prd_sample').text(sample);$('#sample-prd-samp').text(sample);}else{$('#prd_sample').text('なし');$('#sample-prd-samp').text('なし');}
	
	if(trace!=undefined){$('#prd_trace').text(trace);trace_price=2200;$('#sample-prd-trace').text(trace);}else{$('#prd_trace').text('なし');$('#sample-prd-trace').text('なし');}

	// console.log(trace_price);
	// Get unit price
	for (var i = 0, iMax = get_price().length; i < iMax; i++) {
		if (parseInt(qty) >= parseInt(get_price()[i].num)) {
			unit_price = Math.floor(get_price()[i].price*(1+vat/100));
			continue;
		}
		break;
	}

	// console.log(unit_price);

	// passed
	sub_total = Math.floor(((unit_price*qty)+trace_price+(partPrice*qoa*qty)+(paperPrice*qty)));

	// discount setup by timer
	let timer = new Date().toISOString();
	
	let startDate = new Date("2024-01-24T00:00:00");
	let endDate = new Date("2024-02-16T23:59:00");
	
	if (timer > startDate.toISOString() && timer < endDate.toISOString()) {
		disPrice = Math.floor(parseInt(sub_total*0.05));
	} 

	vat_price = Math.floor((((unit_price*qty)*vat/(100+vat))+trace_price+((partPrice*qoa)*vat/(100+vat))+((paperPrice*qty)*vat/(100+vat))))-Math.floor(disPrice*vat/(100+vat));
	// vat_price = vat_price - (vat_price*vat/100);

	total = Math.floor((parseInt(sub_total)-parseInt(disPrice)));

	$('#prd_part_price').val((partPrice*qoa*qty).toLocaleString("en"));
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
if (screen === undefined) {
    screen = $('input[name="acy_print"]:checked').val();
}
	var part = $('input[name="acy_part"]:checked').val();
	var paper = $('input[name="acy_paper_select"]:checked').val();
	var paper_color = $('input[name="acy_paper"]:checked').val();
	var qty = $('input[name="qty"]').val();
	
	// Force disable sample switch if qty < 20
	if(parseInt(qty) < 20){
		$('input[name="acy_sample"][type="checkbox"]').prop('checked', false).removeAttr("checked").attr('disabled', true);
		$('input[name="acy_sample"][type="checkbox"]').closest('label').css({'pointer-events': 'none', 'opacity': '0.5'});
	} else {
		$('input[name="acy_sample"][type="checkbox"]').attr('disabled', false);
		$('input[name="acy_sample"][type="checkbox"]').closest('label').css({'pointer-events': 'auto', 'opacity': '1'});
	}

	var sample = $('input[name="acy_sample"]:checked').val();
	var trace = $('input[name="acy_trace"]:checked').val();
	var qoa = $('input[name="qoa"]').val() || 0;
    var prd = $('#strap').val();
	var color = $('input[name="acy_color"]:checked').val();
	var trace_price = 0;

	// Get part price
	if(part!=undefined){
		if(part == 'なし') {
			$('input[name="qoa"]').prop('disabled', false).prop('readonly', true).val(0);
			qoa = 0;
		} else {
			$('input[name="qoa"]').prop('disabled', false).prop('readonly', false);
		}
		$('#part-error').text('');
		$('#sample-part-pic').show();
		partPrice = Math.floor(parts_obj["part_price"]*(1+vat/100));
		$('#sample-part-pic').attr('src',parts_obj["part_pic"]);
		$('#sample-part-name').text(parts_obj["part_name"]);
	}else{
		partPrice = 0;
		$('#sample-part-pic').hide();
		$('#sample-part-name').text('アタッチメント:なし');
	}

	// Get paper data
	if(paper!=undefined){
		$('.paper-container').show();
		if(paper_color!=undefined){
			$('#sample-paper-pic').show();
			$('#sample-paper-pic').attr('src',"img/"+paper_color+".jpg?v=1.01");
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
	$('#sample-prd-color').text(color);
	$('#sample-prd-size').text('70*70mm');
	$('#sample-prd-screen').text(screen);
	$('#sample-prd-print').text(screen);
	$('#sample-prd-qty').text(qty);
	$('#sample-prd-part').html('詰め放題1枚あたり' + qoa + '個<br>（合計数量 : ' + total_att + '）');

	$('#prd_production').text(prodc_day);
	$('#prd_size').text('70*70mm');
	$('#prd_color').text(screen);
	$('#prd_amount').text(qty);
	$('#prd_part').text(part);
	$('#prd_qoa').html('詰め放題1枚あたり' + (qoa || 0) + '個<br>（合計数量 : ' + total_att + '）');
	if(sample!=undefined){$('#prd_sample').text(sample);$('#sample-prd-samp').text(sample);}else{$('#prd_sample').text('なし');$('#sample-prd-samp').text('なし');}
	if(trace!=undefined){$('#prd_trace').text(trace);trace_price=0;$('#sample-prd-trace').text(trace);}else{$('#prd_trace').text('なし');$('#sample-prd-trace').text('なし');}

	// Get unit price
	for (var i = 0, iMax = get_price().length; i < iMax; i++) {
		if (parseInt(qty) >= parseInt(get_price()[i].num)) {
			unit_price = Math.floor(get_price()[i].price*(1+vat/100));
			continue;
		}
		break;
	}

	// passed
	sub_total = Math.floor(((unit_price*qty)+trace_price+(partPrice*qoa)+(paperPrice*qty)));

	// discount setup by timer
	let timer = new Date().toISOString();
	
	let startDate = new Date("2024-01-24T00:00:00");
	let endDate = new Date("2024-02-16T23:59:00");
	
	if (timer > startDate.toISOString() && timer < endDate.toISOString()) {
		disPrice = Math.floor(parseInt(sub_total*0.05));
	} 

	vat_price = Math.floor((((unit_price*qty)*vat/(100+vat))+trace_price+((partPrice*qoa)*vat/(100+vat))+((paperPrice*qty)*vat/(100+vat))))-Math.floor(disPrice*vat/(100+vat));
	// vat_price = vat_price - (vat_price*vat/100);

	total = Math.floor((parseInt(sub_total)-parseInt(disPrice)));

	$('#prd_part_price').val((partPrice*qoa).toLocaleString("en"));
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

    let sku_name = "";
    if (prd == "アクリルキーホルダー") {
        sku_name = 'acrylic-keychain';
    }

    if (prd == "オリジナルめじるしアクセサリー（アンブレラマーカー）") {
        sku_name = 'acrylic-umbrella';
    }

    if (prd == "アクリルバッジ") {
        sku_name = 'acrylic-badge';
    }

    if(sku_name != "")
    {
        return {
            sku: sku_name,
            product: prd,
            qty: qty,
            product_price: Math.floor(unit_price*qty),
            part_price: (partPrice*qoa),
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
}

function get_price() {
	var screen = $('input[name="acy_screen"]:checked').val();
	if (screen === undefined) {
		screen = $('input[name="acy_print"]:checked').val();
	}

	if (screen == "両面印刷") {
		return prd_price['2side'];
	} else {
		// Default to 1side (片面印刷) if undefined or selected 1side
		return prd_price['1side'];
	}
}
// Set amount
var amount = ['1', '5', '10', '20', '30', '50', '70', '100', '200', '300', '500', '1000'];
var amount_add = [];

function writePriceTable(plus) {
		// Get Delivery date
		var days = $('input[name=prc_delivery]:checked').val();
		// Get Screen
		var screen = $('input[name=prc_screen]:checked').val();

		if(days == "10" && screen == "1"){
			var price = prd_10d_1side;
		}else if (days == "10" && screen == "2") {
			var price = prd_10d_2side;
		}else if (days == "6" && screen == "1") {
			var price = prd_6d_1side;
		}else if (days == "6" && screen == "2") {
			var price = prd_6d_2side;
		}

		//Get customer add new qty 
		if(plus == "add"){
			if($.inArray($('input[name=new_qty]').val(),amount)>=0){
				$('.add-error').text('この数量の製作単価は既に表示されております');
			}else{
				if($('input[name=new_qty]').val()<=0 || $('input[name=new_qty]').val()>100){
					$('.add-error').text('6-10営業日のご注文は100個以下となります');
				}else{
					if (days == "6" && (screen == "1"||screen == "2") && $('input[name=new_qty]').val()>300) {
						$('.add-error').text('6営業日のご注文は300個以下となります');
					}else{
						$('.add-error').text('');
						amount.push($('input[name=new_qty]').val());
						amount.sort(function(a, b){return a-b});
						amount_add.push($('input[name=new_qty]').val());
					}
				}
			}
		}else{
			//reset amount
			if (days == "6" && (screen == "1" || screen == "2") && plus == "del") {
				amount = ['1', '5', '10', '20', '30', '50', '70', '100', '200', '300'];
				amount_add = [];
			}else if (days == "10" &&  (screen == "1" || screen == "2") && plus == "del") {
				amount = ['1', '5', '10', '20', '30', '50', '70', '100', '200', '300', '500', '1000'];
				amount_add = [];
			}
		}
		
		// setup table
		var text = ""; 
		$('.price-row').remove();

		// write table
		for(var i=0;i<amount.length;i++){
			if($.inArray( amount[i], amount_add )>=0){
				text+='<tr class="price-row added"><td>'+amount[i]+'</td>';
			}else{
				text+='<tr class="price-row"><td>'+amount[i]+'</td>';
			}
			for(var j=0;j<Object.size(price);j++){
				var tmp = Object.keys(price);
				for (var k = 0, iMax = price[tmp[j]].length; k < iMax; k++) {
					if (parseInt(amount[i]) >= parseInt(price[tmp[j]][k].num)) {
						var price1 = Math.floor(price[tmp[j]][k].price*(1+vat/100));
						continue;
					}
					break;
				}
				text+='<td>'+price1+'</td>'
			}
			text+='</tr>';
		}
		$('.tbl-price tbody').append(text);
	}

	$(function() {			
		writePriceTable();
		if($("#strap").val()=="アクリル詰め放題"){ //Acrylic Keychain
			getPartData($('input[name="acy_part"]:checked').val());		
		}else if($("#strap").val()=="オリジナルめじるしアクセサリー（アンブレラマーカー）"){ //Acrylic Umbrella
			getPartData2($('input[name="acy_part"]:checked').val());
		}else{
			getPartData3($('input[name="acy_part"]:checked').val());
		}
	});

	function getPartData(v) {
		$.get("part-tsumehodai-renew.php", { c: "passed" } , function(data){
			var duce = (typeof data === "string") ? $.parseJSON(data) : data;
			for(var i=0;i<duce.length;i++){
				if(duce[i]['part_name']==v){
					parts_obj = duce[i];
					break;
				}else{
					parts_obj = duce[0];
				}
			}
		}).done(function() {
			cal_c();

            //Create new token when page load
			let prd_strap = $('#strap').val();
			let mmt = $('#ms_mode').val();
			if ((mmt != "" && mmt == "MODE_MOD") && (prd_strap == "アクリルキーホルダー")) //Only Acrylic Keychain
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
		})
	}

	function getPartData2(v) 
    {
		$.get("part-umbrella.php", { c: "passed" } , function(data){
			var duce = (typeof data === "string") ? $.parseJSON(data) : data;
			for(var i=0;i<duce.length;i++){
				if(duce[i]['part_name']==v){
					parts_obj = duce[i];
					break;
				}else{
					parts_obj = duce[0];
				}
			}
		}).done(function() {
			cal_c();

            //Create new token when page load
			let prd_strap = $('#strap').val();
			let mmt = $('#ms_mode').val();
			if ((mmt != "" && mmt == "MODE_MOD") && (prd_strap == "オリジナルめじるしアクセサリー（アンブレラマーカー）")) //Only Umbrella
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

		})
	}

	function getPartData3(v) {
		$.get("part-badge.php", { c: "passed" } , function(data){
			var duce = (typeof data === "string") ? $.parseJSON(data) : data;
			for(var i=0;i<duce.length;i++){
				if(duce[i]['part_name']==v){
					parts_obj = duce[i];
					break;
				}else{
					parts_obj = duce[0];
				}
			}
		}).done(function() {
			cal_c();

            //Create new token when page load
			let prd_strap = $('#strap').val();
			let mmt = $('#ms_mode').val();
			if ((mmt != "" && mmt == "MODE_MOD") && (prd_strap == "アクリルバッジ")) //Only Badge
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
		})
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
	var qoa = $('input[name="qoa"]').val() || 0;
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
    Item = $("#strap").val();

    delivery = $("input[name=acy_delivery]:checked").val();

    itemtype_size = '148mm×210mm';

    parts = $('input[name="acy_part"]:checked').val();

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
	if (Item_print === undefined) {
		Item_print = $("input[name=acy_print]:checked").val();
	}

	var item_color = $("input[name=acy_color]:checked").val();
    
    var item_price = unit_price;

   	var discount_quo = disPrice;
	   var example_price = 0,ai_file_price = 0;
	
	if(ai_file == "1"){
    	ai_file_price = 2200;
		ai_file_price = ai_file_price.toLocaleString('en');
		sum1_quo = sum1_quo+(2200);
		sum4_quo = (total+2200).toLocaleString("en");
		sum3_quo = vat_price+(2200);
    }


    var sum1_quo = sub_total.toLocaleString("en");
    // var sum2_quo = $('#prd_sub_total').val();
    // var sum3_quo = $('#vat').val();
    var sum2_quo = 0;
    var sum3_quo = vat_price;
    var sum4_quo = total.toLocaleString("en");

    var parts_price = partPrice;
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
		"itemtype_colors": item_color,
        "example": example,
        "part": parts,
        "paper": paper,
        "ai_file": ai_file,
        "qty": qty,
        "qoa": qoa,
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
	if($("#strap").val()=="アクリルキーホルダー"){
		getPartData($('input[name="acy_part"]:checked').val());
	}else if($("#strap").val()=="オリジナルめじるしアクセサリー（アンブレラマーカー）"){
		getPartData2($('input[name="acy_part"]:checked').val());
	}else{
		getPartData3($('input[name="acy_part"]:checked').val());
	}
	cal_c();
}

/* DB pricing override for tsumehodai-renew */
(function () {
    var NONE = '\u306a\u3057';
    var PRINT_FRONT = '\u7247\u9762\u5370\u5237';
    var TSUME_SIZE = '148mm\u00d7210mm';
    var ATTACHMENT_NONE = '\u30a2\u30bf\u30c3\u30c1\u30e1\u30f3\u30c8:\u306a\u3057';
    var QOA_LABEL = '\u8a70\u3081\u653e\u984c1\u679a\u3042\u305f\u308a';
    var PCS = '\u500b';
    var TOTAL_LABEL_OPEN = '\uff08\u5408\u8a08\u6570\u91cf : ';
    var TOTAL_LABEL_CLOSE = '\uff09';

    function tsumehodaiNumber(value) {
        if (value === undefined || value === null || value === '') return 0;
        return parseFloat(String(value).replace(/[,\s]/g, '')) || 0;
    }

    function tsumehodaiMoney(value) {
        return Math.floor(tsumehodaiNumber(value)).toLocaleString('en');
    }

    function tsumehodaiSelected(name) {
        return $('input[name="' + name + '"]:checked').val();
    }

    function tsumehodaiSyncPrint() {
        var print = tsumehodaiSelected('acy_print') || tsumehodaiSelected('acy_screen') || PRINT_FRONT;
        $('#acy_screen_proxy').val(print);
        return print;
    }

    function tsumehodaiIsNone(value) {
        return !value || value === NONE || String(value).indexOf(NONE) !== -1;
    }

    function tsumehodaiPartUnit(part) {
        if (tsumehodaiIsNone(part) || !parts_obj) return 0;
        return Math.floor(tsumehodaiNumber(parts_obj.part_price));
    }

    function tsumehodaiQoaText(qoa, totalAtt) {
        return QOA_LABEL + qoa + PCS + '<br>' + TOTAL_LABEL_OPEN + totalAtt + TOTAL_LABEL_CLOSE;
    }

    function tsumehodaiUpdateDisplay(data, input) {
        var qty = parseInt(input.qty, 10) || 0;
        var qoa = parseInt(input.qoa, 10) || 0;
        var part = input.acy_part || NONE;
        var print = input.acy_print || PRINT_FRONT;
        var sample = input.acy_sample || NONE;
        var trace = input.acy_trace || NONE;
        var totalAtt = qty * qoa;

        $('#sample-prd-size').text(TSUME_SIZE);
        $('#sample-prd-screen').text(print);
        $('#sample-prd-print').text(print);
        $('#sample-prd-qty').text(qty);
        $('#sample-prd-part').html(tsumehodaiQoaText(qoa, totalAtt));
        $('#sample-prd-samp').text(sample);
        $('#sample-prd-trace').text(trace);

        $('#prd_size').text(TSUME_SIZE);
        $('#prd_color').text(print);
        $('#prd_print').text(print);
        $('#prd_amount').text(qty);
        $('#prd_part').text(part);
        $('#prd_qoa').html(tsumehodaiQoaText(qoa, totalAtt));
        $('#prd_sample').text(sample);
        $('#prd_trace').text(trace);

        $('#prd_price').val(tsumehodaiMoney(data.prd_price));
        $('#prd_part_price').val(tsumehodaiMoney(data.prd_part_price));
        $('#prd_paper_price').val(tsumehodaiMoney(data.prd_paper_price));
        $('#prd_sample_price').val(tsumehodaiMoney(data.prd_sample_price));
        $('#prd_trace_price').val(tsumehodaiMoney(data.prd_trace_price));
        $('#prd_sub_total').val(tsumehodaiMoney(data.prd_sub_total));
        $('#prd_tax').val(tsumehodaiMoney(data.Tax));
        $('#discount').val(tsumehodaiMoney(data.discount));
        $('.prd_total').text(tsumehodaiMoney(data.prd_total));
        $('#prd_total').val(tsumehodaiMoney(data.prd_total));

        unit_price = Math.floor(tsumehodaiNumber(data.unit_price));
        partPrice = Math.floor(tsumehodaiNumber(data.part_unit_price));
        paperPrice = Math.floor(tsumehodaiNumber(data.paper_unit_price));
        sub_total = Math.floor(tsumehodaiNumber(data.prd_sub_total));
        disPrice = Math.floor(tsumehodaiNumber(data.discount));
        vat_price = Math.floor(tsumehodaiNumber(data.Tax));
        total = Math.floor(tsumehodaiNumber(data.prd_total));
    }

    function tsumehodaiBuildInput() {
        var qty = $('input[name="qty"]').val();
        var qoa = $('input[name="qoa"]').val() || 0;
        var part = tsumehodaiSelected('acy_part');
        var print = tsumehodaiSyncPrint();
        var sample = tsumehodaiSelected('acy_sample');
        var trace = tsumehodaiSelected('acy_trace');
        var paperSelect = tsumehodaiSelected('acy_paper_select');
        var paper = tsumehodaiSelected('acy_paper');

        if (tsumehodaiIsNone(part)) {
            $('input[name="qoa"]').prop('disabled', false).prop('readonly', true).val(0);
            qoa = 0;
        } else {
            $('input[name="qoa"]').prop('disabled', false).prop('readonly', false);
        }

        if (part !== undefined && parts_obj) {
            $('#part-error').text('');
            $('#sample-part-pic').show().attr('src', parts_obj.part_pic);
            $('#sample-part-name').text(parts_obj.part_name || part);
        } else {
            $('#sample-part-pic').hide();
            $('#sample-part-name').text(ATTACHMENT_NONE);
        }

        return {
            ItemType: $('#strap').val(),
            acy_print: print,
            acy_screen: print,
            acy_size: $('input[name="acy_size"]').val() || TSUME_SIZE,
            acy_part: part,
            acy_paper_select: paperSelect,
            acy_paper: paper,
            acy_sample: sample,
            acy_trace: trace,
            qty: qty,
            qoa: qoa,
            part_price: tsumehodaiPartUnit(part),
            paper_price: 0
        };
    }

    function tsumehodaiClearPrices() {
        $('#prd_price,#prd_part_price,#prd_paper_price,#prd_sample_price,#prd_trace_price,#prd_sub_total,#prd_tax,#discount,#prd_total').val('0');
        $('.prd_total').text('0');
    }

    window.cal_c = function () {
        var input = tsumehodaiBuildInput();
        var qty = parseInt(input.qty, 10) || 0;
        if (qty <= 0) {
            tsumehodaiClearPrices();
            return;
        }

        $.ajax({
            type: 'POST',
            url: '/products/acrylic/ajax_calculate_price_tsumehodai.php',
            data: input,
            dataType: 'json',
            success: function (data) {
                if (data && data.status === 200) {
                    tsumehodaiUpdateDisplay(data, input);
                } else {
                    console.error('Tsumehodai price response error', data);
                    tsumehodaiClearPrices();
                }
            },
            error: function (xhr, status, error) {
                console.error('Tsumehodai price AJAX error', status, error, xhr.responseText);
                tsumehodaiClearPrices();
            }
        });
    };

    
    window.chk_part = function () {
        var part = tsumehodaiSelected('acy_part');
        var qoaVal = parseInt($('input[name="qoa"]').val(), 10) || 0;
        var qoaMax = 10;

        if (part === undefined) {
            var stillOnStep1 = $('#step1').is(':visible') && !$('#step2').is(':visible');
            if (stillOnStep1) {
                $('#part-error').text('');
                $('#qoa-error').text('');
                $('#next').attr('disabled', false);
                return true;
            }
            $('#next').attr('disabled', true);
            $('#part-error').text('\u30a2\u30bf\u30c3\u30c1\u30e1\u30f3\u30c8\u3092\u9078\u629e\u3057\u3066\u304f\u3060\u3055\u3044');
            return false;
        }

        $('input[name="qoa"]').attr('max', qoaMax);
        if (tsumehodaiIsNone(part)) {
            $('input[name="qoa"]').prop('disabled', false).prop('readonly', true).val(0);
            $('#qoa-error').text('');
            $('#part-error').text('');
            $('#next').attr('disabled', false);
            return true;
        }

        $('input[name="qoa"]').prop('disabled', false).prop('readonly', false);
        if (qoaVal <= 0 || qoaVal > qoaMax) {
            $('#next').attr('disabled', true);
            $('#qoa-error').text('\u30a2\u30bf\u30c3\u30c1\u30e1\u30f3\u30c8\u6570\u91cf\u306f\u30a2\u30af\u30ea\u30eb\u8a70\u3081\u653e\u984c1\u70b9\u306b\u3064\u304d10\u500b\u307e\u3067\u3068\u306a\u308a\u307e\u3059\u3002');
            return false;
        }

        $('#qoa-error').text('');
        $('#part-error').text('');
        $('#next').attr('disabled', false);
        return true;
    };
    window.calculate_price_manual = function () {
        return {};
    };

    $(document).on('change input', 'input[name="acy_print"], input[name="qty"], input[name="qoa"], input[name="acy_sample"], input[name="acy_trace"], input[name="acy_part"]', function () {
        window.chk_part();
        window.cal_c();
    });
})();