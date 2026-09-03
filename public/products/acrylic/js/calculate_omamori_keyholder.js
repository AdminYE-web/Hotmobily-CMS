var isSafari = navigator.vendor && navigator.vendor.indexOf('Apple') > -1 &&
navigator.userAgent &&
navigator.userAgent.indexOf('CriOS') == -1 &&
navigator.userAgent.indexOf('FxiOS') == -1;

// // price for 10 days
// var prd_10d_1side = { //prc_delivery = 10 && //prc_screen = 1
// 	"size50":[ //75x50
// 	{"num":1, "price":1109},
// 	{"num":2, "price":1109},
// 	{"num":3, "price":1109},
// 	{"num":4, "price":1109},
// 	{"num":5, "price":475},
// 	{"num":6, "price":475},
// 	{"num":7, "price":475},
// 	{"num":8, "price":475},
// 	{"num":9, "price":475},
// 	{"num":10, "price":387},
// 	{"num":20, "price":344},
// 	{"num":30, "price":325},
// 	{"num":40, "price":325},
// 	{"num":50, "price":304},
// 	{"num":60, "price":304},
// 	{"num":70, "price":271},
// 	{"num":80, "price":271},
// 	{"num":90, "price":271},
// 	{"num":100, "price":247},
// 	{"num":200, "price":241},
// 	{"num":300, "price":237},
// 	{"num":400, "price":237},
// 	{"num":500, "price":227},
// 	{"num":600, "price":227},
// 	{"num":700, "price":227},
// 	{"num":800, "price":227},
// 	{"num":900, "price":227},
// 	{"num":1000, "price":218}],
// 	"size75":[ //70x42
// 	{"num":1, "price":1109},
// 	{"num":2, "price":1109},
// 	{"num":3, "price":1109},
// 	{"num":4, "price":1109},
// 	{"num":5, "price":475},
// 	{"num":6, "price":475},
// 	{"num":7, "price":475},
// 	{"num":8, "price":475},
// 	{"num":9, "price":475},
// 	{"num":10, "price":387},
// 	{"num":20, "price":344},
// 	{"num":30, "price":325},
// 	{"num":40, "price":325},
// 	{"num":50, "price":304},
// 	{"num":60, "price":304},
// 	{"num":70, "price":271},
// 	{"num":80, "price":271},
// 	{"num":90, "price":271},
// 	{"num":100, "price":247},
// 	{"num":200, "price":241},
// 	{"num":300, "price":237},
// 	{"num":400, "price":237},
// 	{"num":500, "price":227},
// 	{"num":600, "price":227},
// 	{"num":700, "price":227},
// 	{"num":800, "price":227},
// 	{"num":900, "price":227},
// 	{"num":1000, "price":218}]
// };

// var prd_10d_2side = { //prc_delivery = 10 && //prc_screen = 2
// 	"size50":[
// 	{"num":1, "price":1386},
// 	{"num":2, "price":1386},
// 	{"num":3, "price":1386},
// 	{"num":4, "price":1386},
// 	{"num":5, "price":589},
// 	{"num":6, "price":589},
// 	{"num":7, "price":589},
// 	{"num":8, "price":589},
// 	{"num":9, "price":589},
// 	{"num":10, "price":478},
// 	{"num":20, "price":425},
// 	{"num":30, "price":401},
// 	{"num":40, "price":401},
// 	{"num":50, "price":376},
// 	{"num":60, "price":376},
// 	{"num":70, "price":334},
// 	{"num":80, "price":334},
// 	{"num":90, "price":334},
// 	{"num":100, "price":304},
// 	{"num":200, "price":296},
// 	{"num":300, "price":292},
// 	{"num":400, "price":292},
// 	{"num":500, "price":279},
// 	{"num":600, "price":279},
// 	{"num":700, "price":279},
// 	{"num":800, "price":279},
// 	{"num":900, "price":279},
// 	{"num":1000, "price":267}],
// 	"size75":[	
// 	{"num":1, "price":1386},
// 	{"num":2, "price":1386},
// 	{"num":3, "price":1386},
// 	{"num":4, "price":1386},
// 	{"num":5, "price":589},
// 	{"num":6, "price":589},
// 	{"num":7, "price":589},
// 	{"num":8, "price":589},
// 	{"num":9, "price":589},
// 	{"num":10, "price":478},
// 	{"num":20, "price":425},
// 	{"num":30, "price":401},
// 	{"num":40, "price":401},
// 	{"num":50, "price":376},
// 	{"num":60, "price":376},
// 	{"num":70, "price":334},
// 	{"num":80, "price":334},
// 	{"num":90, "price":334},
// 	{"num":100, "price":304},
// 	{"num":200, "price":296},
// 	{"num":300, "price":292},
// 	{"num":400, "price":292},
// 	{"num":500, "price":279},
// 	{"num":600, "price":279},
// 	{"num":700, "price":279},
// 	{"num":800, "price":279},
// 	{"num":900, "price":279},
// 	{"num":1000, "price":267}]
// };

// var prd_10d_3side = { //prc_delivery = 10 && //prc_screen = 3
// 	"size50":[
// 	{"num":1, "price":1231},
// 	{"num":2, "price":1231},
// 	{"num":3, "price":1231},
// 	{"num":4, "price":1231},
// 	{"num":5, "price":1231},
// 	{"num":6, "price":1231},
// 	{"num":7, "price":1231},
// 	{"num":8, "price":1231},
// 	{"num":9, "price":1231},
// 	{"num":10, "price":458},
// 	{"num":20, "price":458},
// 	{"num":30, "price":370},
// 	{"num":40, "price":370},
// 	{"num":50, "price":370},
// 	{"num":60, "price":370},
// 	{"num":70, "price":370},
// 	{"num":80, "price":370},
// 	{"num":90, "price":370},
// 	{"num":100, "price":308},
// 	{"num":200, "price":308},
// 	{"num":300, "price":257},
// 	{"num":400, "price":257},
// 	{"num":500, "price":237},
// 	{"num":600, "price":237},
// 	{"num":700, "price":237},
// 	{"num":800, "price":237},
// 	{"num":900, "price":237},
// 	{"num":1000, "price":224}],
// 	"size75":[	
// 	{"num":1, "price":1231},
// 	{"num":2, "price":1231},
// 	{"num":3, "price":1231},
// 	{"num":4, "price":1231},
// 	{"num":5, "price":1231},
// 	{"num":6, "price":1231},
// 	{"num":7, "price":1231},
// 	{"num":8, "price":1231},
// 	{"num":9, "price":1231},
// 	{"num":10, "price":458},
// 	{"num":20, "price":458},
// 	{"num":30, "price":370},
// 	{"num":40, "price":370},
// 	{"num":50, "price":370},
// 	{"num":60, "price":370},
// 	{"num":70, "price":370},
// 	{"num":80, "price":370},
// 	{"num":90, "price":370},
// 	{"num":100, "price":308},
// 	{"num":200, "price":308},
// 	{"num":300, "price":257},
// 	{"num":400, "price":257},
// 	{"num":500, "price":237},
// 	{"num":600, "price":237},
// 	{"num":700, "price":237},
// 	{"num":800, "price":237},
// 	{"num":900, "price":237},
// 	{"num":1000, "price":224}]
// };

// // price for 6 days
// var prd_6d_1side = { //prc_delivery = 6 && //prc_screen = 1
// 	"size50":[
// 	{"num":1, "price":1227},
// 	{"num":2, "price":1227},
// 	{"num":3, "price":1227},
// 	{"num":4, "price":1227},
// 	{"num":5, "price":527},
// 	{"num":6, "price":527},
// 	{"num":7, "price":527},
// 	{"num":8, "price":527},
// 	{"num":9, "price":527},
// 	{"num":10, "price":428},
// 	{"num":20, "price":379},
// 	{"num":30, "price":358},
// 	{"num":40, "price":358},
// 	{"num":50, "price":336},
// 	{"num":60, "price":336},
// 	{"num":70, "price":300},
// 	{"num":80, "price":300},
// 	{"num":90, "price":300},
// 	{"num":100, "price":273},
// 	{"num":200, "price":265},
// 	{"num":300, "price":262}],
// 	"size75":[	
// 	{"num":1, "price":1227},
// 	{"num":2, "price":1227},
// 	{"num":3, "price":1227},
// 	{"num":4, "price":1227},
// 	{"num":5, "price":527},
// 	{"num":6, "price":527},
// 	{"num":7, "price":527},
// 	{"num":8, "price":527},
// 	{"num":9, "price":527},
// 	{"num":10, "price":428},
// 	{"num":20, "price":379},
// 	{"num":30, "price":358},
// 	{"num":40, "price":358},
// 	{"num":50, "price":336},
// 	{"num":60, "price":336},
// 	{"num":70, "price":300},
// 	{"num":80, "price":300},
// 	{"num":90, "price":300},
// 	{"num":100, "price":273},
// 	{"num":200, "price":265},
// 	{"num":300, "price":262}]
// };

// var prd_6d_2side = { //prc_delivery = 6 && //prc_screen = 2
// 	"size50":[ //75x50
// 	{"num":1, "price":1534},
// 	{"num":2, "price":1534},
// 	{"num":3, "price":1534},
// 	{"num":4, "price":1534},
// 	{"num":5, "price":653},
// 	{"num":6, "price":653},
// 	{"num":7, "price":653},
// 	{"num":8, "price":653},
// 	{"num":9, "price":653},
// 	{"num":10, "price":529},
// 	{"num":20, "price":469},
// 	{"num":30, "price":444},
// 	{"num":40, "price":444},
// 	{"num":50, "price":416},
// 	{"num":60, "price":416},
// 	{"num":70, "price":369},
// 	{"num":80, "price":369},
// 	{"num":90, "price":369},
// 	{"num":100, "price":336},
// 	{"num":200, "price":326},
// 	{"num":300, "price":322}],
// 	"size75":[	
// 	{"num":1, "price":1534},
// 	{"num":2, "price":1534},
// 	{"num":3, "price":1534},
// 	{"num":4, "price":1534},
// 	{"num":5, "price":653},
// 	{"num":6, "price":653},
// 	{"num":7, "price":653},
// 	{"num":8, "price":653},
// 	{"num":9, "price":653},
// 	{"num":10, "price":529},
// 	{"num":20, "price":469},
// 	{"num":30, "price":444},
// 	{"num":40, "price":444},
// 	{"num":50, "price":416},
// 	{"num":60, "price":416},
// 	{"num":70, "price":369},
// 	{"num":80, "price":369},
// 	{"num":90, "price":369},
// 	{"num":100, "price":336},
// 	{"num":200, "price":326},
// 	{"num":300, "price":322}],
// };

// var prd_6d_3side = { //prc_delivery = 6 && //prc_screen = 3
// 	"size50":[ //75x50
// 	{"num":1, "price":1257},
// 	{"num":2, "price":1257},
// 	{"num":3, "price":1257},
// 	{"num":4, "price":1257},
// 	{"num":5, "price":1257},
// 	{"num":6, "price":1257},
// 	{"num":7, "price":1257},
// 	{"num":8, "price":1257},
// 	{"num":9, "price":1257},
// 	{"num":10, "price":540},
// 	{"num":20, "price":540},
// 	{"num":30, "price":540},
// 	{"num":40, "price":540},
// 	{"num":50, "price":438},
// 	{"num":60, "price":438},
// 	{"num":70, "price":438},
// 	{"num":80, "price":438},
// 	{"num":90, "price":438},
// 	{"num":100, "price":375},
// 	{"num":200, "price":375},
// 	{"num":300, "price":300}],
// 	"size75":[	
// 	{"num":1, "price":1257},
// 	{"num":2, "price":1257},
// 	{"num":3, "price":1257},
// 	{"num":4, "price":1257},
// 	{"num":5, "price":1257},
// 	{"num":6, "price":1257},
// 	{"num":7, "price":1257},
// 	{"num":8, "price":1257},
// 	{"num":9, "price":1257},
// 	{"num":10, "price":540},
// 	{"num":20, "price":540},
// 	{"num":30, "price":540},
// 	{"num":40, "price":540},
// 	{"num":50, "price":438},
// 	{"num":60, "price":438},
// 	{"num":70, "price":438},
// 	{"num":80, "price":438},
// 	{"num":90, "price":438},
// 	{"num":100, "price":375},
// 	{"num":200, "price":375},
// 	{"num":300, "price":300}],
// };

// price for 10 days
var prd_10d_1side = { //prc_delivery = 10 && //prc_screen = 1
	"size50":[ //75x50
	{"num":1, "price":1145},
	{"num":2, "price":1145},
	{"num":3, "price":1145},
	{"num":4, "price":1145},
	{"num":5, "price":698},
	{"num":6, "price":698},
	{"num":7, "price":698},
	{"num":8, "price":698},
	{"num":9, "price":698},
	{"num":10, "price":590},
	{"num":20, "price":438},
	{"num":30, "price":394},
	{"num":40, "price":394},
	{"num":50, "price":367},
	{"num":60, "price":367},
	{"num":70, "price":336},
	{"num":80, "price":336},
	{"num":90, "price":336},
	{"num":100, "price":336},
	{"num":200, "price":308},
	{"num":300, "price":280},
	{"num":400, "price":280},
	{"num":500, "price":257},
	{"num":600, "price":257},
	{"num":700, "price":257},
	{"num":800, "price":257},
	{"num":900, "price":257},
	{"num":1000, "price":245}],
};

var prd_10d_2side = { //prc_delivery = 10 && //prc_screen = 2
	"size50":[
	{"num":1, "price":1817},
	{"num":2, "price":1817},
	{"num":3, "price":1817},
	{"num":4, "price":1817},
	{"num":5, "price":876},
	{"num":6, "price":876},
	{"num":7, "price":876},
	{"num":8, "price":876},
	{"num":9, "price":876},
	{"num":10, "price":838},
	{"num":20, "price":712},
	{"num":30, "price":620},
	{"num":40, "price":620},
	{"num":50, "price":534},
	{"num":60, "price":534},
	{"num":70, "price":493},
	{"num":80, "price":493},
	{"num":90, "price":493},
	{"num":100, "price":438},
	{"num":200, "price":384},
	{"num":300, "price":325},
	{"num":400, "price":325},
	{"num":500, "price":295},
	{"num":600, "price":295},
	{"num":700, "price":295},
	{"num":800, "price":295},
	{"num":900, "price":295},
	{"num":1000, "price":281}],
};

var prd_10d_3side = { //prc_delivery = 10 && //prc_screen = 3
	"size50":[
	{"num":1, "price":1622},
	{"num":2, "price":1622},
	{"num":3, "price":1622},
	{"num":4, "price":1622},
	{"num":5, "price":886},
	{"num":6, "price":886},
	{"num":7, "price":886},
	{"num":8, "price":886},
	{"num":9, "price":886},
	{"num":10, "price":863},
	{"num":20, "price":863},
	{"num":30, "price":821},
	{"num":40, "price":821},
	{"num":50, "price":717},
	{"num":60, "price":717},
	{"num":70, "price":688},
	{"num":80, "price":688},
	{"num":90, "price":688},
	{"num":100, "price":660},
	{"num":200, "price":604},
	{"num":300, "price":487},
	{"num":400, "price":487},
	{"num":500, "price":449},
	{"num":600, "price":449},
	{"num":700, "price":449},
	{"num":800, "price":449},
	{"num":900, "price":449},
	{"num":1000, "price":431}],
};

// price for 6 days
var prd_6d_1side = { //prc_delivery = 6 && //prc_screen = 1
	"size50":[
	{"num":1, "price":1604},
	{"num":2, "price":1604},
	{"num":3, "price":1604},
	{"num":4, "price":1604},
	{"num":5, "price":775},
	{"num":6, "price":775},
	{"num":7, "price":775},
	{"num":8, "price":775},
	{"num":9, "price":775},
	{"num":10, "price":655},
	{"num":20, "price":487},
	{"num":30, "price":438},
	{"num":40, "price":438},
	{"num":50, "price":407},
	{"num":60, "price":407},
	{"num":70, "price":373},
	{"num":80, "price":373},
	{"num":90, "price":373},
	{"num":100, "price":373},
	{"num":200, "price":343},
	{"num":300, "price":311}],
};

var prd_6d_2side = { //prc_delivery = 6 && //prc_screen = 2
	"size50":[ //75x50
	{"num":1, "price":2017},
	{"num":2, "price":2017},
	{"num":3, "price":2017},
	{"num":4, "price":2017},
	{"num":5, "price":973},
	{"num":6, "price":973},
	{"num":7, "price":973},
	{"num":8, "price":973},
	{"num":9, "price":973},
	{"num":10, "price":930},
	{"num":20, "price":791},
	{"num":30, "price":688},
	{"num":40, "price":688},
	{"num":50, "price":593},
	{"num":60, "price":593},
	{"num":70, "price":548},
	{"num":80, "price":548},
	{"num":90, "price":548},
	{"num":100, "price":487},
	{"num":200, "price":427},
	{"num":300, "price":361}],
};

var prd_6d_3side = { //prc_delivery = 6 && //prc_screen = 3
	"size50":[ //75x50
	{"num":1, "price":1801},
	{"num":2, "price":1801},
	{"num":3, "price":1801},
	{"num":4, "price":1801},
	{"num":5, "price":984},
	{"num":6, "price":984},
	{"num":7, "price":984},
	{"num":8, "price":984},
	{"num":9, "price":984},
	{"num":10, "price":959},
	{"num":20, "price":959},
	{"num":30, "price":912},
	{"num":40, "price":912},
	{"num":50, "price":796},
	{"num":60, "price":796},
	{"num":70, "price":764},
	{"num":80, "price":764},
	{"num":90, "price":764},
	{"num":100, "price":733},
	{"num":200, "price":671},
	{"num":300, "price":541}],
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

		// console.log($('#next').text());

		switch($('#next').text()){
			case "アタッチメント・オプション入力へ":
			if(c=='next' || c=='step2'){
				$('#back').fadeIn('slow');	
				$('#next').text('金額計算・見積・注文へ');
				$('#step2').fadeIn('slow');
				$('#dot-step1').addClass('active');
				$('#dot-step2').addClass('active');
				chk_part();

				//New condition display part depend on size
				if ($('input[name="acy_size"]:checked').val() != "" && $('input[name="acy_size"]:checked').val() !== undefined)
				{
					if ($('input[name="acy_size"]:checked').val() == "75x50mm（叶結び紐）") {
						$('.type_b').css('display', 'none');
						$('.type_a').css('display', 'block');

						if ($('#ms_mode').val() != "") {
						} else {
							$('input[name="acy_part"]').prop('checked', false);
							$('#sample-part-pic').hide();
							$('#sample-part-name').text('アタッチメント:なし');
						}
					}

					if ($('input[name="acy_size"]:checked').val() == "70x42mm（鈴付き紐）") {
						$('.type_a').css('display', 'none');
						$('.type_b').css('display', 'block');

						if ($('#ms_mode').val() != "") {
						} else {
							$('input[name="acy_part"]').prop('checked', false);
							$('#sample-part-pic').hide();
							$('#sample-part-name').text('アタッチメント:なし');
						}
					}
				}

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
		if($('input[name=qty]').val()=="" || $('input[name=qty]').val()<=0 || $('input[name=qty]').val()>1000){
			$('#qty-error').text('ご注文は1以上1,000以下でお願いします。');
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
			}else{
				$('#sample-error').text('※試作品をご希望される場合、ご注文納期とは別に試作品製作時間として6営業日+配送2日が必要になります。ご注文確定後に試作品の有無をご変更されるお客様が多くなっております。納期に余裕の無い場合、試作品のご依頼はご遠慮下さい。');
				$('input[name=acy_sample]').attr('disabled',false);
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
		$('#part-error').text('');
		return true;
	}
}

function cal_c(v) {
	var prodc_day = $('input[name="acy_delivery"]:checked').val();
	var ItemSize = $('input[name="acy_size"]:checked').val();
	var screen = $('input[name="acy_screen"]:checked').val();
	var part = $('input[name="acy_part"]:checked').val();
	var paper = $('input[name="acy_paper_select"]:checked').val();
	var paper_color = $('input[name="acy_paper"]:checked').val();
	var sample = $('input[name="acy_sample"]:checked').val();
	var trace = $('input[name="acy_trace"]:checked').val();
	var qty = $('input[name="qty"]').val();
	var trace_price = 0;

    // console.log(parts_obj);

	// Get part price
	if(part!=undefined){
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
	$('#sample-prd-size').text(ItemSize);
	$('#sample-prd-screen').text(screen);
	$('#sample-prd-qty').text(qty);

	$('#prd_production').text(prodc_day);
	$('#prd_size').text(ItemSize);
	$('#prd_print').text(screen);
	$('#prd_amount').text(qty);
	$('#prd_part').text(part);
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

	//set special price for paper backing
    const current_now = new Date(); // current date/time
    const period_start = new Date("2025-11-01");
    const period_end = new Date("2025-11-30");

    // if (current_now >= period_start && current_now <= period_end) {
    //     paperPrice= 0;
    // }

	// passed
	sub_total = Math.floor(((unit_price*qty)+trace_price+(partPrice*qty)+(paperPrice*qty)));

	// discount setup by timer
	let timer = new Date().toISOString();
	
	let startDate = new Date("2024-01-24T00:00:00");
	let endDate = new Date("2024-02-16T23:59:00");
	
	if (timer > startDate.toISOString() && timer < endDate.toISOString()) {
		disPrice = Math.floor(parseInt(sub_total*0.05));
	} 

	vat_price = Math.floor((((unit_price*qty)*vat/(100+vat))+trace_price+((partPrice*qty)*vat/(100+vat))+((paperPrice*qty)*vat/(100+vat))))-Math.floor(disPrice*vat/(100+vat));
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
	var part = $('input[name="acy_part"]:checked').val();
	var paper = $('input[name="acy_paper_select"]:checked').val();
	var paper_color = $('input[name="acy_paper"]:checked').val();
	var sample = $('input[name="acy_sample"]:checked').val();
	var trace = $('input[name="acy_trace"]:checked').val();
	var qty = $('input[name="qty"]').val();
	var prd = $('#strap').val();
	var trace_price = 0;

    // console.log(parts_obj);

	// Get part price
	if(part!=undefined){
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
	$('#sample-prd-size').text(ItemSize);
	$('#sample-prd-screen').text(screen);
	$('#sample-prd-qty').text(qty);

	$('#prd_production').text(prodc_day);
	$('#prd_size').text(ItemSize);
	$('#prd_print').text(screen);
	$('#prd_amount').text(qty);
	$('#prd_part').text(part);
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

	//set special price for paper backing
    const current_now = new Date(); // current date/time
    const period_start = new Date("2025-11-01");
    const period_end = new Date("2025-11-30");

    // if (current_now >= period_start && current_now <= period_end) {
    //     paperPrice= 0;
    // }

	// passed
	sub_total = Math.floor(((unit_price*qty)+trace_price+(partPrice*qty)+(paperPrice*qty)));

	// discount setup by timer
	let timer = new Date().toISOString();
	
	let startDate = new Date("2024-01-24T00:00:00");
	let endDate = new Date("2024-02-16T23:59:00");
	
	if (timer > startDate.toISOString() && timer < endDate.toISOString()) {
		disPrice = Math.floor(parseInt(sub_total*0.05));
	} 

	vat_price = Math.floor((((unit_price*qty)*vat/(100+vat))+trace_price+((partPrice*qty)*vat/(100+vat))+((paperPrice*qty)*vat/(100+vat))))-Math.floor(disPrice*vat/(100+vat));
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
		sku: 'omamori-keyholder',
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

function get_price() 
{
	// Setup price
	switch($('input[name="acy_delivery"]:checked').val()){
		case "10営業日": 
		switch($('input[name="acy_screen"]:checked').val()){
			case "片面印刷・オーロラ加工なし":
				return prd_10d_1side['size50'];
			// switch($('input[name="acy_size"]:checked').val()){
			// 	case '75x50': return prd_10d_1side['size50']; break;
			// 	case '70x42': return prd_10d_1side['size75']; break;
			// }
			break;
			case "両面印刷：オーロラ加工なし":
				return prd_10d_2side['size50'];
			// switch($('input[name="acy_size"]:checked').val()){
			// 	case '75x50': return prd_10d_2side['size50']; break;
			// 	case '70x42': return prd_10d_2side['size75']; break;
			// }
			break;
			case "片面印刷・オーロラ加工あり":
				return prd_10d_3side['size50'];
			// switch($('input[name="acy_size"]:checked').val()){
			// 	case '75x50': return prd_10d_3side['size50']; break;
			// 	case '70x42': return prd_10d_3side['size75']; break;
			// }
			break;
		}
		break;
		case "6営業日": 
		switch($('input[name="acy_screen"]:checked').val()){
			case "片面印刷・オーロラ加工なし":
				return prd_6d_1side['size50'];
			// switch($('input[name="acy_size"]:checked').val()){
			// 	case '75x50': return prd_6d_1side['size50']; break;
			// 	case '70x42': return prd_6d_1side['size75']; break;
			// }
			break;
			case "両面印刷：オーロラ加工なし":
				return prd_6d_2side['size50'];
			// switch($('input[name="acy_size"]:checked').val()){
			// 	case '75x50': return prd_6d_2side['size50']; break;
			// 	case '70x42': return prd_6d_2side['size75']; break;
			// }
			break;
			case "片面印刷・オーロラ加工あり":
				return prd_6d_3side['size50'];
			// switch($('input[name="acy_size"]:checked').val()){
			// 	case '75x50': return prd_6d_3side['size50']; break;
			// 	case '70x42': return prd_6d_3side['size75']; break;
			// }
			break;
		}
		break;
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
		}else if (days == "10" && screen == "3") {
			var price = prd_10d_3side;
		}else if (days == "6" && screen == "3") {
			var price = prd_6d_3side;
		}

		//Get customer add new qty 
		if(plus == "add"){
			if($.inArray($('input[name=new_qty]').val(),amount)>=0){
				$('.add-error').text('この数量の製作単価は既に表示されております');
			}else{
				if($('input[name=new_qty]').val()<=0 || $('input[name=new_qty]').val()>1000){
					$('.add-error').text('6-10営業日のご注文は1000個以下となります');
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

		console.log(price);

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
						// var price1 = Math.floor(price[tmp[j]][k].price*(1+vat/100));
						// var price1 = Math.ceil(price[tmp[j]][k].price*(1+vat/100));
						var price1 = Math.floor(price[tmp[j]][k].price);
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
		if($("#strap").val()=="アクリルキーホルダー" || $("#strap").val()=="オーロラアクリルキーホルダー"){ //Add Acrylic Aurora
			getPartData($('input[name="acy_part"]:checked').val());		
		}else if($("#strap").val()=="アクリルアンブレラマーカー"){
			getPartData2($('input[name="acy_part"]:checked').val());
		}else if ($("#strap").val()=="お守りアクリルキーホルダー"){ 
			getPartDataOmamori($('input[name="acy_part"]:checked').val());
		}else{
			getPartData3($('input[name="acy_part"]:checked').val());
		}
	});

	function getPartData(v) 
	{
		//set special price for paper backing
        const breaking_now = new Date(); // current date/time
        const breaking_st = new Date("2025-11-01");
        const breaking_ed = new Date("2025-11-30");

        let part_url = "part.php";
        // if (breaking_now >= breaking_st && breaking_now <= breaking_ed) {
        //     part_url = "part-event.php";
        // }

		$.get(part_url, { c: "passed" } , function(data){
			var duce = $.parseJSON(data);
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
		})
	}

	function getPartData2(v) {
		$.get("part-umbrella.php", { c: "passed" } , function(data){
			var duce = $.parseJSON(data);
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
		})
	}

	function getPartData3(v) {
		$.get("part-badge.php", { c: "passed" } , function(data){
			var duce = $.parseJSON(data);
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
		})
	}

	//get part attachment for omamori
	function getPartDataOmamori(v)
	{
		$.get("part-omamori.php", { c: "passed" } , function(data){
			var duce = $.parseJSON(data);
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
			if ((mmt != "" && mmt == "MODE_MOD") && (prd_strap == "お守りアクリルキーホルダー")) //Only Omamori Keyholder
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

	Item = 'お守りアクリルキーホルダー';

    delivery = $("input[name=acy_delivery]:checked").val();

    // itemtype_size = $("input[name=acy_size]:checked").val()+"x"+$("input[name=acy_size]:checked").val()+"mm.";
	itemtype_size = $("input[name=acy_size]:checked").val();

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
	if($("#strap").val()=="アクリルキーホルダー"){
		getPartData($('input[name="acy_part"]:checked').val());
	}else if($("#strap").val()=="アクリルアンブレラマーカー"){
		getPartData2($('input[name="acy_part"]:checked').val());
	}else if($("#strap").val()=="お守りアクリルキーホルダー"){
		getPartDataOmamori($('input[name="acy_part"]:checked').val());
	}else{
		getPartData3($('input[name="acy_part"]:checked').val());
	}
	cal_c();
}