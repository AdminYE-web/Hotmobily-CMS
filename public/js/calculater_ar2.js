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

		"type_a_40":[
			{"num":100, "price":260},
			{"num":200, "price":240},
			{"num":300, "price":220},
      {"num":400, "price":200},
			{"num":500, "price":160}
    ],
    "type_a_50":[
			{"num":100, "price":270},
			{"num":200, "price":250},
			{"num":300, "price":230},
      {"num":400, "price":210},
			{"num":500, "price":170}
    ],
    "type_a_60":[
			{"num":100, "price":280},
			{"num":200, "price":260},
			{"num":300, "price":240},
      {"num":400, "price":220},
			{"num":500, "price":180}
    ],
    "type_a_70":[
			{"num":100, "price":290},
			{"num":200, "price":270},
			{"num":300, "price":250},
      {"num":400, "price":230},
			{"num":500, "price":190}
    ]
		};



		var typeOrder = "";
		var itemSize = "";
		var send_proto = "";
		var vcolor = "";
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
		this.itemSize = document.getElementsByName('ItemSize');
		this.send_proto = document.getElementsByName('example');
		this.data_file = document.getElementsByName('DeFormat');
		// 入力値 input number
		// this.vcolor = document.getElementById('num_colors').value;
		this.vno_of_order = document.getElementById('no_of_order').value;

		//this.campaign = document.getElementById('campaign_no').value;
	}

	// JSONデータから注文個数と色個数の単価合計を取得
	function getUnitPriceData() {
		var type = getItemType();
    var size = getItemSize();

    var type_size = type+"_"+size

		var ret = 0;
		// 単価データ取得 unit price
		this.unitData = numUnitPrice[type_size];
		// 単価データがなかった場合 if no unit price
		if (this.unitData == undefined) {
			return false;
		}

		// 単価 variable
		var unitPrice = 0;
		// 単価色
		var unitColorPrice = 0;

		if (unitPrice <= 0) {
			unitPrice = numUnitPrice[type + "DefPrice"];
			if (unitPrice == undefined) {
				return false;
			}
		}

		ret = unitPrice;
		return ret;
	}


	function getPrice(){
		// オブジェクトの取得
		getObjects();
		// 単価テーブルの色クリア

		clearColor();

		// 入力チェック input check

		if(validateCheck()) {
			// 単価の取得 unit price
			var priceVal = getUnitPriceData();
			// 単価テーブルの色変更 changcolor unit price table

			$('#button_pdf').replaceWith('<input id="button_pdf" type="button" style="cursor:pointer;height: 30px;width: 250px;" onclick="javascript:validate();$(\'.loading\').show();" value="御見積書PDF出力（社名記載なし）"/>');
			$('#button_pdf2').replaceWith('<input id="button_pdf2" type="button" style="cursor:pointer;height: 30px;width: 250px;" onclick="javascript:$(\'#cus_detail\').toggle();" value="御見積書PDF出力（社名記載あり）">');

			setColor(getItemType());
			// 計算 calculate
			calc(getItemType());
			$('#div_estimatePrice').show();
		}
	}

	function getItemType() {
		var str = "";
		for(var i=0; i < typeOrder.length; i++){
			if (typeOrder[i].checked) {
				str = typeOrder[i].value;
				break;
			}
		}
		return str;
	}

  function getItemSize() {
    var itemSize = document.getElementById("ItemSize").value;
    return itemSize;
	}

	function getSendProto(){
			// 試作品の送付
			var str = "";
			for(var i=0; i<send_proto.length; i++){
				if (send_proto[i].checked) {
					str = send_proto[i].value;
					break;
				}
			}
			return str;
		}

		function validateCheck() {
		var type = getItemType();
		// エラーフラグ Error flag
		var error = true;
		// 注文本数エラー表示フラグ Error flg in number of order
		var err_number_of_order = false;

		// err clear
		clearErrFields();

		// 数値チェック check null and numbers
		// if(this.vcolor == '' || !isNumber(this.vcolor) || this.vcolor > 8 || this.vcolor < 1){
		// 	document.getElementById('err_num_colors').innerHTML = "<span style=color:red;>※入力に誤りがあります。1～8の半角英数字で再度ご入力下さい。</span>";
		// 	error = false;

		if(this.vno_of_order == '' || !isNumber(this.vno_of_order)) {
			document.getElementById('err_no_of_order').innerHTML = "<span style=color:red;>※入力に誤りがあります。0?9の半角英数字で再度ご入力下さい。</span>";
			error = false;
		}
		// if (getProtoType() == '1' && this.vno_of_order >499){
		// 	document.getElementById('err_example_have').innerHTML = "<span style=color:red;>※500本以上のご注文では、実物の確認をお願いしています。</span>";
		// 	error = false;
		// }

		// 注文個数チェック Check number of order
		var num = "";
		switch (type) {
			case "type_a":
			if(this.vno_of_order < 100){
				err_number_of_order = true;
				num = "100本";
				error = false;
			}
			break;
		}
		// new condition
		// if (this.vno_of_order >= 500) {
		// 	document.getElementById("example_have").checked = true;
		// }

		// ====================>
		if(err_number_of_order){
			document.getElementById('err_no_of_order').innerHTML = "<span style=color:red;>※最低注文数は" + num + "となっております。</span>";
		}
		if(vno_of_order.value > 50000){
			document.getElementById('err_no_of_order').innerHTML = "<span style=color:red;>※50000以上のロット数でのお客様は納期をメールにてお問い合わせ下さい。</span>";
			error = false;
		}
		return error;
	}

	function clearErrFields() {
		//document.getElementById('err_num_colors').innerHTML = "";
		document.getElementById('err_no_of_order').innerHTML = "";
		// document.getElementById('err_example_have').innerHTML = "";
		//document.getElementById('err_send_prototype_no3').innerHTML = "";
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


	function calc(val) {

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


		// if (this.vno_of_order >= 50 && this.vno_of_order <= 299) {
		// 	basic_charge = 7000;
		// } else {
		// 	basic_charge = 5000;
		// }


		// new
		var itemType = getItemType();
		var itemSize = getItemSize();
		var qty = this.vno_of_order;


		if(itemType == "type_a" && itemSize=="40") {
			if(qty>=1 && qty<=199 ) {
				type_price = numUnitPrice["type_a_40"][0]["price"] * qty;
			}
			else if(qty>=200 && qty<=299 ) {
				type_price = numUnitPrice["type_a_40"][1]["price"] * qty;
			}
			else if(qty>=300 && qty<=399 ) {
				type_price = numUnitPrice["type_a_40"][2]["price"] * qty;
			}
			else if(qty>=400 && qty<=499 ) {
				type_price = numUnitPrice["type_a_40"][3]["price"] * qty;
			}
			else if(qty>=500) {
				type_price = numUnitPrice["type_a_40"][4]["price"] * qty;
			}
		}
		else if(itemType == "type_a" && itemSize =="50") {

      if(qty>=1 && qty<=199 ) {
				type_price = numUnitPrice["type_a_50"][0]["price"] * qty;
			}
			else if(qty>=200 && qty<=299 ) {
				type_price = numUnitPrice["type_a_50"][1]["price"] * qty;
			}
			else if(qty>=300 && qty<=399 ) {
				type_price = numUnitPrice["type_a_50"][2]["price"] * qty;
			}
			else if(qty>=400 && qty<=499 ) {
				type_price = numUnitPrice["type_a_50"][3]["price"] * qty;
			}
			else if(qty>=500) {
				type_price = numUnitPrice["type_a_50"][4]["price"] * qty;
			}
		}
    else if(itemType == "type_a" && itemSize =="60") {

      if(qty>=1 && qty<=199 ) {
				type_price = numUnitPrice["type_a_60"][0]["price"] * qty;
			}
			else if(qty>=200 && qty<=299 ) {
				type_price = numUnitPrice["type_a_60"][1]["price"] * qty;
			}
			else if(qty>=300 && qty<=399 ) {
				type_price = numUnitPrice["type_a_60"][2]["price"] * qty;
			}
			else if(qty>=400 && qty<=499 ) {
				type_price = numUnitPrice["type_a_60"][3]["price"] * qty;
			}
			else if(qty>=500) {
				type_price = numUnitPrice["type_a_60"][4]["price"] * qty;
			}
		}
    else if(itemType == "type_a" && itemSize =="70") {

      if(qty>=1 && qty<=199 ) {
				type_price = numUnitPrice["type_a_70"][0]["price"] * qty;
			}
			else if(qty>=200 && qty<=299 ) {
				type_price = numUnitPrice["type_a_70"][1]["price"] * qty;
			}
			else if(qty>=300 && qty<=399 ) {
				type_price = numUnitPrice["type_a_70"][2]["price"] * qty;
			}
			else if(qty>=400 && qty<=499 ) {
				type_price = numUnitPrice["type_a_70"][3]["price"] * qty;
			}
			else if(qty>=500) {
				type_price = numUnitPrice["type_a_70"][4]["price"] * qty;
			}
		}


		document.getElementById('pricefield7').value = formatMoney(type_price);

    if(document.getElementById("example_have").checked){
      proto_charge = 4500;
    }


    before_tax = type_price+proto_charge;
	    tax = Math.floor(before_tax * 0.1);
	    total = before_tax + tax;

	    document.getElementById('pricefield8').value = formatMoney(proto_charge);
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
		// 利用色数 number of colors
		var vcolor = document.getElementById('num_colors');
		// type of mobile strap
		var itemSize = getItemSize();

		var itemType = getItemType();

		if(itemType == "type_a" && itemSize == "40") {
				// Default Background White
				document.getElementById('PDTA4_1').style.background = "";
				document.getElementById('PDTA4_2').style.background = "";
				document.getElementById('PDTA4_3').style.background = "";
				document.getElementById('PDTA4_4').style.background = "";
				document.getElementById('PDTA4_5').style.background = "";

				if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('PDTA4_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('PDTA4_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 399) {
					document.getElementById('PDTA4_3').style.background = "pink";
				} else if (this.vno_of_order >= 400 && this.vno_of_order <= 499) {
					document.getElementById('PDTA4_4').style.background = "pink";
				} else {
					document.getElementById('PDTA4_5').style.background = "pink";
				}
		}
		else if(itemType == "type_a" && itemSize == "50")
		{
				// Default Background White
        document.getElementById('PDTA5_1').style.background = "";
				document.getElementById('PDTA5_2').style.background = "";
				document.getElementById('PDTA5_3').style.background = "";
				document.getElementById('PDTA5_4').style.background = "";
				document.getElementById('PDTA5_5').style.background = "";

        if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('PDTA5_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('PDTA5_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 399) {
					document.getElementById('PDTA5_3').style.background = "pink";
				} else if (this.vno_of_order >= 400 && this.vno_of_order <= 499) {
					document.getElementById('PDTA5_4').style.background = "pink";
				} else {
					document.getElementById('PDTA5_5').style.background = "pink";
				}
		}
    else if(itemType == "type_a" && itemSize == "60")
		{
				// Default Background White
        document.getElementById('PDTA6_1').style.background = "";
				document.getElementById('PDTA6_2').style.background = "";
				document.getElementById('PDTA6_3').style.background = "";
				document.getElementById('PDTA6_4').style.background = "";
				document.getElementById('PDTA6_5').style.background = "";

        if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('PDTA6_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('PDTA6_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 399) {
					document.getElementById('PDTA6_3').style.background = "pink";
				} else if (this.vno_of_order >= 400 && this.vno_of_order <= 499) {
					document.getElementById('PDTA6_4').style.background = "pink";
				} else {
					document.getElementById('PDTA6_5').style.background = "pink";
				}
		}
    else if(itemType == "type_a" && itemSize == "70")
		{
				// Default Background White
        document.getElementById('PDTA7_1').style.background = "";
				document.getElementById('PDTA7_2').style.background = "";
				document.getElementById('PDTA7_3').style.background = "";
				document.getElementById('PDTA7_4').style.background = "";
				document.getElementById('PDTA7_5').style.background = "";

        if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('PDTA7_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('PDTA7_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 399) {
					document.getElementById('PDTA7_3').style.background = "pink";
				} else if (this.vno_of_order >= 400 && this.vno_of_order <= 499) {
					document.getElementById('PDTA7_4').style.background = "pink";
				} else {
					document.getElementById('PDTA7_5').style.background = "pink";
				}
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

	function getItemSize() {
		var itemSize = document.getElementById("ItemSize").value;
		return itemSize;
	}

	function getDataFormat() {
		//入稿データファイル
		var data_file = document.getElementsByName('DeFormat');
		var str = "";
		for(var i=0; i<data_file.length; i++){
			if (data_file[i].checked) {
				str = data_file[i].value;
				break;
			}
		}
		return str;
	}

	function clearColor(){

		this.typeOrder = document.getElementsByName('ItemType');

	//clear color type_a - type_d
	for( var i=4; i<=7; i++ ){
    for( var j=1; j<=5; j++ ){
			document.getElementById( 'PDTA' + i + "_" + j).style.background = "";
			document.getElementById( 'PDTB' + i + "_" + j).style.background = "";
			document.getElementById( 'PDTC' + i + "_" + j).style.background = "";
      document.getElementById( 'PDTD' + i + "_" + j).style.background = "";
		}
	}
  //clear color type_e
  for( var o=4; o<=7; o++ ){
    for( var p=5; p<=5; p++ ){
			document.getElementById( 'PDTE' + o + "_" + p).style.background = "";
		}
	}

	// clear error fields numberOf
	$('#button_pdf').replaceWith('<input id="button_pdf" type="button" style="height: 30px;width: 250px;" value="御見積書PDF出力（社名記載なし）" disabled="true" />');
	$('#button_pdf2').replaceWith('<input id="button_pdf2" type="button" style="height: 30px;width: 250px;" value="御見積書PDF出力（社名記載あり）" disabled="true">');
	$('#cus_detail').hide();
	clearErrFields();
	click_itemtype(getItemType());
	$('#div_estimatePrice').hide();
}

function clearColor2(){

  this.typeOrder = document.getElementsByName('ItemType');

//clear color type_a - type_d
for( var i=4; i<=7; i++ ){
  for( var j=1; j<=5; j++ ){
    document.getElementById( 'PDTA' + i + "_" + j).style.background = "";
    document.getElementById( 'PDTB' + i + "_" + j).style.background = "";
    document.getElementById( 'PDTC' + i + "_" + j).style.background = "";
    document.getElementById( 'PDTD' + i + "_" + j).style.background = "";
  }
}
//clear color type_e
for( var o=4; o<=7; o++ ){
  for( var p=5; p<=5; p++ ){
    document.getElementById( 'PDTE' + o + "_" + p).style.background = "";
  }
}

// clear error fields numberOf
clearErrFields();
click_itemtype2();
}

// New function 14-08-2559 --->
function click_sizeorder(sizeOption) {

	itemType = "type_a";

	// (C). Example have
	// document.getElementById("example_have").checked = true;
	// document.getElementById("example_nothave").disabled = true;
	// document.getElementById("example_have").disabled = true;

	hideField("type_a_40");
  hideField("type_a_50");
  hideField("type_a_60");
  hideField("type_a_70");

	switch (itemType) {
		case "type_a":
		if (sizeOption == "40") {
			showField("type_a_40");
		}
		else if (sizeOption == "50") {
			showField("type_a_50");
		}
    else if (sizeOption == "60") {
			showField("type_a_60");
		}
    else if (sizeOption == "70") {
			showField("type_a_70");
		}
		break;
    }
}


// Select estimate item
function click_itemtype(clicked) {
  typeOption = "40";
	if (document.getElementById("ItemSize").value == "50")
		typeOption = "50";
  if (document.getElementById("ItemSize").value == "60")
  	typeOption = "60";
  if (document.getElementById("ItemSize").value == "70")
    typeOption = "70";

	// Default hidefield standard
  hideField("type_a_40");
  hideField("type_a_50");
  hideField("type_a_60");
  hideField("type_a_70");

	switch (clicked) {
      case "type_a":
      if (typeOption == "40") {
        showField("type_a_40");
      }
      else if (typeOption == "50") {
        showField("type_a_50");
      }
      else if (typeOption == "60") {
        showField("type_a_60");
      }
      else if (typeOption == "70") {
        showField("type_a_70");
      }
      break;
    }
}

function click_itemtype2() {
	// Default hidefield standard
  showField("type_a_40");
  hideField("type_a_50");
  hideField("type_a_60");
  hideField("type_a_70");
}

	function hideField(el) {
		document.getElementById(el).style.display = "none";
	}

	function showField(el) {
		document.getElementById(el).style.display = "";
	}
	function table_priceW(){
		$('#div_estimatePrice').hide();
		var itemType = $('input[name=ItemType]:checked').val();
		var itemSize = $('#ItemSize').val();
		var qty = [100,200,300,400,500]
		var qty2 = [0,0,0,0,500]
		var tax;
		var rows,row1=0; 
		var sum = 0;
		var proto_charge = 0;
		if($('input[name=example]:checked').val() == "2"){
			proto_charge = 4500;
		}
		sum = Number(proto_charge);
		$('#qty_100').show();$('#qty_200').show();
		$('#qty_300').show();$('#qty_400').show();
		for(rows=0;rows<5;rows++){
			document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((numUnitPrice[itemType+"_"+itemSize][rows]["price"] * qty[rows])+sum)/qty[rows]))+"円";
			document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((numUnitPrice[itemType+"_"+itemSize][rows]["price"] * qty[rows])+sum))+"円";
			tax = Math.floor((numUnitPrice[itemType+"_"+itemSize][rows]["price"] * qty[rows] + sum) * 1.1);
			document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
		}
		clear_field();
	}
function clear_field(){
    $('#pricefield7').val('');
    $('#pricefield8').val('');
    $('#pricefield11').val('');
    $('#pricefield12').val('');
    $('#pricefield13').val('');
  }