/**********************************
* Description: Javascript for calculation
* CreateDate: Jul.22.2010
* UpdateDate: Feb.01.2013
**********************************/
//Delete 2012/04/24 Sineenad R. Start
	// 個数単価データ


// 個数単価データ
var numUnitPrice;
 numUnitPrice = {
	"ec1_0":[
		{"num":500, "price":354},					
		{"num":1000, "price":244},
		{"num":2000, "price":195},
      	{"num":3000, "price":170},
		{"num":4000, "price":152},
		{"num":5000, "price":133}
    ],
    "ec2_0":[
		{"num":500, "price":383},					
		{"num":1000, "price":271},
		{"num":2000, "price":219},
      	{"num":3000, "price":210},
		{"num":4000, "price":194},
		{"num":5000, "price":180}
    ],
    "ec3_0":[
		{"num":500, "price":404},	
		{"num":1000, "price":300},
		{"num":2000, "price":255},
      	{"num":3000, "price":245},
		{"num":4000, "price":228},
		{"num":5000, "price":214}
    ],
    "ec4_0":[
		{"num":500, "price":378},					
		{"num":1000, "price":271},
		{"num":2000, "price":219},
      	{"num":3000, "price":195},
		{"num":4000, "price":180},
		{"num":5000, "price":167}
    ],
    "ec5_0":[					
		{"num":500, "price":380},
		{"num":1000, "price":266},
		{"num":2000, "price":222},
      	{"num":3000, "price":205},
		{"num":4000, "price":188},
		{"num":5000, "price":175}
    ],
    "ec6_0":[
		{"num":500, "price":379},					
		{"num":1000, "price":265},
		{"num":2000, "price":221},
      	{"num":3000, "price":212},
		{"num":4000, "price":195},
		{"num":5000, "price":181}
    ],
    "ec7_0":[
		{"num":500, "price":371},					
		{"num":1000, "price":255},
		{"num":2000, "price":210},
      	{"num":3000, "price":200},
		{"num":4000, "price":184},
		{"num":5000, "price":170}
    ],
    "ec8_0":[
		{"num":500, "price":381},					
		{"num":1000, "price":268},
		{"num":2000, "price":224},
      	{"num":3000, "price":214},
		{"num":4000, "price":197},
		{"num":5000, "price":183}
    ],
	"ec1_1":[
		{"num":500, "price":600},										
		{"num":1000, "price":374},
		{"num":2000, "price":273},
      	{"num":3000, "price":233},
		{"num":4000, "price":192},
		{"num":5000, "price":164}
    ],
    "ec2_1":[
		{"num":500, "price":629},										
		{"num":1000, "price":401},
		{"num":2000, "price":298},
      	{"num":3000, "price":272},
		{"num":4000, "price":248},
		{"num":5000, "price":227}
    ],
    "ec3_1":[
		{"num":500, "price":650},						
		{"num":1000, "price":430},
		{"num":2000, "price":333},
      	{"num":3000, "price":304},
		{"num":4000, "price":279},
		{"num":5000, "price":258}
    ],
    "ec4_1":[
		{"num":500, "price":624},										
		{"num":1000, "price":402},
		{"num":2000, "price":298},
      	{"num":3000, "price":258},
		{"num":4000, "price":217},
		{"num":5000, "price":189}
    ],
    "ec5_1":[					
		{"num":500, "price":625},					
		{"num":1000, "price":397},
		{"num":2000, "price":300},
      	{"num":3000, "price":267},
		{"num":4000, "price":242},
		{"num":5000, "price":222}
    ],
    "ec6_1":[
		{"num":500, "price":625},										
		{"num":1000, "price":396},
		{"num":2000, "price":299},
      	{"num":3000, "price":270},
		{"num":4000, "price":245},
		{"num":5000, "price":225}
    ],
    "ec7_1":[
		{"num":500, "price":617},										
		{"num":1000, "price":385},
		{"num":2000, "price":289},
      	{"num":3000, "price":259},
		{"num":4000, "price":235},
		{"num":5000, "price":213}
    ],
    "ec8_1":[
		{"num":500, "price":627},										
		{"num":1000, "price":398},
		{"num":2000, "price":302},
      	{"num":3000, "price":273},
		{"num":4000, "price":248},
		{"num":5000, "price":227}
    ]};
		var typeOrder = "";
		var vno_of_order = "";
		var campaign = "";
		var unitData;
		var colorData;

		// NON
		// document.getElementById('strap_item1').checked = 'checked';
		// document.getElementById('strap_item').disabled = false;
		// ============>

// debug
function getObjects() {
		// ラジオ選択値 radio button
		this.typeOrder = document.getElementsByName('ItemType');
		// 入力値 input number
		this.vno_of_order = document.getElementById('no_of_order').value;
		//this.campaign = document.getElementById('campaign_no').value;
	}

	function getPrice(){
		// オブジェクトの取得
		getObjects();
		// 単価テーブルの色クリア

		clearColor();

		// 入力チェック input check

		if(validateCheck()) {
			// 単価テーブルの色変更 changcolor unit price table

			// $('#button_pdf').replaceWith('<input id="button_pdf" type="button" style="cursor:pointer;height: 30px;width: 250px;" onclick="javascript:validate();$(\'.loading\').show();" value="御見積書PDF出力（社名記載なし）"/>');
			// $('#button_pdf2').replaceWith('<input id="button_pdf2" type="button" style="cursor:pointer;height: 30px;width: 250px;" onclick="javascript:$(\'#cus_detail\').toggle();" value="御見積書PDF出力（社名記載あり）">');
			// 計算 calculate
			calc();
			setColor();
			// $('#div_estimatePrice').show();
		}
	}

	function getItemType() {
		var str = "";
		for(var i=0; i < typeOrder.length; i++){
			if (typeOrder[i].selected) {
				str = typeOrder[i].value;
				break;
			}
		}
		return str;
	}

  function getItemPrint() {
    var itemPrint = $("input[name='ItemPrint']:checked").val();
    return itemPrint;
	}

  function validateCheck() {
		var type = $("#ItemType").val();
		// エラーフラグ Error flag
		var error = true;
		// 注文本数エラー表示フラグ Error flg in number of order
		var err_number_of_order = false;

		// err clear
		clear_color()

		if(this.vno_of_order == '' || !isNumber(this.vno_of_order)) {
			document.getElementById('err_no_of_order').innerHTML = "<span style=color:red;>※入力に誤りがあります。0?9の半角英数字で再度ご入力下さい。</span>";
			error = false;
		}

		// 注文個数チェック Check number of order
		var num = "";
		if(this.vno_of_order < 500){
			err_number_of_order = true;
			num = "500本";
			error = false;
		}

		// ====================>
		if(err_number_of_order){
			document.getElementById('err_no_of_order').innerHTML = "<span style=color:red;>※最低注文数は" + num + "となっております。</span>";
		}
		if(vno_of_order.value > 30000){
			document.getElementById('err_no_of_order').innerHTML = "<span style=color:red;>※50000以上のロット数でのお客様は納期をメールにてお問い合わせ下さい。</span>";
			error = false;
		}
		return error;
	}

	function clearErrFields() {
		document.getElementById('err_no_of_order').innerHTML = "";
	}

	function isNumber(strInput) {
		var digit = "0123456789";
		var temp;
		for (var i=0; i<strInput.length; i++) {
			temp = strInput.substring(i,i+1);
			if (digit.indexOf(temp) == -1) return false;
		}
		return true;
	};


	function calc() {
		// 初期化
		var unit_price = 0;
		var basic_charge = 0;
		var mold_charge = 0;
		var proto_shipping_charge = 0;
		var trace_charge = 0;
		var order_pcs = 0;
		var type_price = 0;
		var shipping_charge = 0;
		var before_tax = 0;
		var tax = 0;
		var total = 0;
		var print_charge = 0;
		var silk_print = 0;
		var proto_charge = 0;

		var itemType = $("#ItemType").val();
		var itemPrint = getItemPrint();
		var itemColor = Number($("#ItemColor").val());
		var qty = this.vno_of_order;
		if(itemPrint=="0") {
			for(var i = 0;i<numUnitPrice[itemType+"_"+itemPrint].length;i++){
				if(qty>=numUnitPrice[itemType+"_"+itemPrint][i]["num"]){
					type_price = parseInt(numUnitPrice[itemType+"_"+itemPrint][i]["price"]+($("#ItemColor").val()*10)) * qty;
					continue;
				}
				break;
			}
			($("#ItemColor").val()==0)?silk_print = 6000:silk_print = 6000*(itemColor+1);
		}
		else{
			for(var i = 0;i<numUnitPrice[itemType+"_"+itemPrint].length;i++){
				if(qty>=numUnitPrice[itemType+"_"+itemPrint][i]["num"]){
					type_price = numUnitPrice[itemType+"_"+itemPrint][i]["price"] * qty;
					continue;
				}
				break;
			}
			silk_print = 65000
		}		
		if($("input[name=ItemSpeed]:checked").val()==0){
			proto_charge = (type_price+silk_print)*0.1;
		}
		document.getElementById('pricefield7').value = formatMoney(type_price);

    	before_tax = type_price+silk_print+proto_charge;
	    tax = Math.floor(before_tax * 0.1);
	    total = before_tax + tax;
		document.getElementById('pricefield15').value = formatMoney(proto_charge);
	    document.getElementById('pricefield5').value = formatMoney(silk_print);
	    document.getElementById('pricefield11').value = formatMoney(before_tax);
	    document.getElementById('pricefield12').value = formatMoney(tax);
	    document.getElementById('pricefield13').value = formatMoney(total);
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

// リファクタ対象　ここから
function setColor(){
		// 注文本数 number of order
		var vno_of_order = document.getElementById('no_of_order');
		// type of mobile strap

		if (this.vno_of_order >= 500 && this.vno_of_order <= 999) {
			document.getElementById('PD_1').style.background = "pink";
		} else if (this.vno_of_order >= 1000 && this.vno_of_order <= 1999) {
			document.getElementById('PD_2').style.background = "pink";
		} else if (this.vno_of_order >= 2000 && this.vno_of_order <= 2999) {
			document.getElementById('PD_3').style.background = "pink";
		} else if (this.vno_of_order >= 3000 && this.vno_of_order <= 3999) {
			document.getElementById('PD_4').style.background = "pink";
		} else if (this.vno_of_order >= 4000 && this.vno_of_order <= 4999) {
			document.getElementById('PD_5').style.background = "pink";
		} else{
			document.getElementById('PD_6').style.background = "pink";
		}
}

// リファクタ対象　ここまで

function showField() {
	document.getElementById('f1').style.display = "";
}

	/*
	* Description: Check inputed number
	*	Return: true/false
	*/

	function check_num(e){
		var keyPressed;
		if(window.event){
				keyPressed = window.event.keyCode; // IE
				if ((keyPressed < 48 || keyPressed > 57) && keyPressed != 0 && keyPressed != 8){
					keyPressed = false;
				}
			}else{
			keyPressed = e.which; // Firefox
			if ((keyPressed < 48 || keyPressed > 57) && keyPressed != 0 && keyPressed != 8){
				keyPressed = e.preventDefault();
			}
		}
	}

	//clear 0 first char
	function format_number(number){
		if (number !=""){
			number = parseInt(number)+0;
		}
		return number;
	}

	function getType() {
		var typeOrder = document.getElementsByName('ItemType');
		var str = "";
		for(var i=0; i<typeOrder.length; i++){
			if (typeOrder[i].checked) {
				str = typeOrder[i].value;
				break;
			}
		}
		return str;
	}

function clearColor(){

	this.typeOrder = document.getElementsByName('ItemType');

	//clear color type_a - type_d
	for( var i=1; i<=6; i++ ){
		document.getElementById( 'PD' + "_" + i).style.background = "";
	}

	// clear error fields numberOf
	// $('#button_pdf').replaceWith('<input id="button_pdf" type="button" style="height: 30px;width: 250px;" value="御見積書PDF出力（社名記載なし）" disabled="true" />');
	// $('#button_pdf2').replaceWith('<input id="button_pdf2" type="button" style="height: 30px;width: 250px;" value="御見積書PDF出力（社名記載あり）" disabled="true">');
	// $('#cus_detail').hide();
	clearErrFields();
	clear_field();
	// $('#div_estimatePrice').hide();
}


// Select estimate item
function click_itemtype() {
	clear_color();
	var itemType = $("#ItemType").val();
	var print = $("input[name='ItemPrint']:checked").val();
	if($("input[name='ItemPrint']:checked").val() == 0){
		for (var j = 0, k = numUnitPrice[itemType+"_"+print].length; j < k ; j++) {
			document.getElementById( 'PD_' + parseInt(j+1) ).innerHTML = formatMoney(parseInt(numUnitPrice[itemType+"_"+print][j]["price"]+($("#ItemColor").val()*10)));
		}
	}else if($("input[name='ItemPrint']:checked").val() == 1){
		for (var j = 0, k = numUnitPrice[itemType+"_"+print].length; j < k ; j++) {
			document.getElementById( 'PD_' + parseInt(j+1) ).innerHTML = formatMoney(numUnitPrice[itemType+"_"+print][j]["price"]);
		}
	}else{
		for (var j = 0, k = numUnitPrice[itemType+"_0"].length; j < k ; j++) {
			document.getElementById( 'PD_' + parseInt(j+1) ).innerHTML = formatMoney(numUnitPrice[itemType+"_0"][j]["price"]);
		}
	}
	switch(itemType){
		case 'ec1':$('#type_it').text('円(EC-1)');break;
		case 'ec2':$('#type_it').text('円(EC-2)');break;
		case 'ec3':$('#type_it').text('正方形(EC-3)');break;
		case 'ec4':$('#type_it').text('四角(EC-4)');break;
		case 'ec5':$('#type_it').text('楕円(EC-5)');break;
		case 'ec6':$('#type_it').text('ハート(EC-6)');break;
		case 'ec7':$('#type_it').text('星(EC-7)');break;
		case 'ec8':$('#type_it').text('ﾕﾆﾎｰﾑ(EC-8)');break;
	}
	$('#ec1').hide();$('#ec2').hide();$('#ec3').hide();$('#ec4').hide();$('#ec5').hide();$('#ec6').hide();$('#ec7').hide();$('#ec8').hide();
	$('#'+itemType).show();
}
function chg_itemColor() {
	clear_color()
	var print = $("input[name='ItemPrint']:checked").val();
	var itemType = $("#ItemType").val();
	if($("input[name='ItemPrint']:checked").val() == 0){
		for (var j = 0, k = numUnitPrice[itemType+"_"+print].length; j < k ; j++) {
			document.getElementById( 'PD_' + parseInt(j+1) ).innerHTML = formatMoney(parseInt(numUnitPrice[itemType+"_"+print][j]["price"]+($("#ItemColor").val()*10)));
		}
	}else if($("input[name='ItemPrint']:checked").val() == 1){
		for (var j = 0, k = numUnitPrice[itemType+"_"+print].length; j < k ; j++) {
			document.getElementById( 'PD_' + parseInt(j+1) ).innerHTML = formatMoney(numUnitPrice[itemType+"_"+print][j]["price"]);
		}
	}else{
		for (var j = 0, k = numUnitPrice[itemType+"_0"].length; j < k ; j++) {
			document.getElementById( 'PD_' + parseInt(j+1) ).innerHTML = formatMoney(numUnitPrice[itemType+"_0"][j]["price"]);
		}
	}
}
	function hideField(el) {
		document.getElementById(el).style.display = "none";
	}

	function showField(el) {
		document.getElementById(el).style.display = "";
	}

	// function table_priceW(){
	// 	// $('#div_estimatePrice').hide();
	// 	var itemType = $('input[name=ItemType]:checked').val();
	// 	var qty = [500,1000,2000,3000,4000,5000]
	// 	var tax;
	// 	var rows,row1=0; 
	// 	var sum = 0;
	// 	var proto_charge = 0;
	// 	if($('input[name=example]:checked').val() == "2"){
	// 		proto_charge = 4500;
	// 	}
	// 	switch(itemType){
	// 		case 'type_a':
	// 		case 'type_b':
	// 		case 'type_c':
	// 		case 'type_d':
	// 			sum = Number(proto_charge);
	// 			$('#qty_100').show();$('#qty_200').show();
	// 			$('#qty_300').show();$('#qty_400').show();
	// 			for(rows=0;rows<5;rows++){
	// 				document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((numUnitPrice[itemType+"_"+itemSize][rows]["price"] * qty[rows])+sum)/qty[rows]))+"円";
	// 				document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((numUnitPrice[itemType+"_"+itemSize][rows]["price"] * qty[rows])+sum))+"円";
	// 				tax = Math.floor((numUnitPrice[itemType+"_"+itemSize][rows]["price"] * qty[rows] + sum) * 1.08);
	// 				document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
	// 			}
	// 		break;
	// 		case 'type_e':
	// 			sum = Number(proto_charge);
	// 			$('#qty_100').hide();$('#qty_200').hide();
	// 			$('#qty_300').hide();$('#qty_400').hide();
	// 			for(rows=4;rows<5;rows++){
	// 				document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((numUnitPrice[itemType+"_"+itemSize][row1]["price"] * qty2[rows])+sum)/qty2[rows]))+"円";
	// 				document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((numUnitPrice[itemType+"_"+itemSize][row1]["price"] * qty2[rows])+sum))+"円";
	// 				tax = Math.floor((numUnitPrice[itemType+"_"+itemSize][row1]["price"] * qty2[rows] + sum) * 1.08);
	// 				document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
	// 				row1++;
	// 			}
	// 		break;
	// 	}
	// 		clear_field();
	// }
function clear_field(){
	$('#pricefield5').val('');
    $('#pricefield7').val('');
    $('#pricefield11').val('');
    $('#pricefield12').val('');
    $('#pricefield13').val('');
    $('#pricefield15').val('');
  }
  function write_price(){
  	for (var j = 0, k = numUnitPrice["ec1_0"].length; j < k ; j++) {
		document.getElementById( 'PD_' + parseInt(j+1) ).innerHTML = formatMoney(numUnitPrice["ec1_0"][j]["price"]);
	}
	$('#type_it').text('円(EC-1)');
  }
  function clear_color(){
  	// Default Background White
	document.getElementById('PD_1').style.background = "";
	document.getElementById('PD_2').style.background = "";
	document.getElementById('PD_3').style.background = "";
	document.getElementById('PD_4').style.background = "";
	document.getElementById('PD_5').style.background = "";
	document.getElementById('PD_6').style.background = "";
  	clear_field();
  }