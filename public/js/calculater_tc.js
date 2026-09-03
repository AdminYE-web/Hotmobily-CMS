/**********************************
* Description: Javascript for calculation
* CreateDate: Jul.22.2010
* UpdateDate: Feb.01.2013
**********************************/
//Delete 2012/04/24 Sineenad R. Start
	// 個数単価データ


// 個数単価データ
var carabiner_price = 0;
var carabiner_print = 0;
var numUnitPrice = {
			// :: Strap data1 :: // standard
			"target":[
			{"num":100, "price":812},
			{"num":200, "price":663},
			{"num":300, "price":513},
			{"num":500, "price":450},
			{"num":1000, "price":252},
			{"num":3000, "price":159},
			{"num":5000, "price":140}
			],

			// :: Strap data2 :: // premuim
			"target_premium":[
			{"num":100, "price":975},
			{"num":200, "price":796},
			{"num":300, "price":616},
			{"num":500, "price":540},
			{"num":1000, "price":302},
			{"num":3000, "price":191},
			{"num":5000, "price":168}
			]
		};

		var numCarabinerPrice = {
			// :: Strap data1 :: // standard
			"carabiner_O":[
			{"num":100, "price":56},
			{"num":200, "price":52},
			{"num":300, "price":48},
			{"num":500, "price":41},
			{"num":1000, "price":35},
			{"num":3000, "price":28},
			{"num":5000, "price":27}
			],

			// :: Strap data2 :: // premuim
			"carabiner_M":[
			{"num":100, "price":149},
			{"num":200, "price":137},
			{"num":300, "price":124},
			{"num":500, "price":112},
			{"num":1000, "price":90},
			{"num":3000, "price":70},
			{"num":5000, "price":67}
			],

			// :: Strap data2 :: // premuim
			"carabiner_L":[
			{"num":100, "price":214},
			{"num":200, "price":196},
			{"num":300, "price":177},
			{"num":500, "price":161},
			{"num":1000, "price":128},
			{"num":3000, "price":99},
			{"num":5000, "price":94}
			],
		};

		var typeOrder = "";
		var itemQA = "";
		var send_proto = "";
		var data_file ="";
		var print_umu ="";
		var vcolor = "";
		var vno_of_order = "";
		var campaign = "";
		var unitData;
		var colorData;


// debug
function getObjects() {
		// ラジオ選択値 radio button
		this.typeOrder = document.getElementsByName('ItemType');
		this.itemQA = document.getElementsByName('ItemQA');
		this.send_proto = document.getElementsByName('example');
		this.data_file = document.getElementsByName('DeFormat');
		this.print_umu = document.getElementsByName('Screen');

		// 入力値 input number
		// this.vcolor = document.getElementById('num_colors').value;
		if(screen.width<=768){
			if(document.querySelector("input[name=numberOf]:checked").value=='0'){
				this.vno_of_order = document.getElementById('no_of_order_other').value;
			}else{
				this.vno_of_order = document.querySelector("input[name=numberOf]:checked").value;
			}
		}else{
			this.vno_of_order = document.getElementById('no_of_order').value;
		}

		//this.campaign = document.getElementById('campaign_no').value;
	}

	// JSONデータから注文個数と色個数の単価合計を取得
	function getUnitPriceData() {
		var type = getItemType();

		if(type == "target"){
			type = type + "_" + getStrapPCS();
		}

		var ret = 0;
		// 単価データ取得 unit price
		this.unitData = numUnitPrice[type];
		// 単価データがなかった場合 if no unit price
		if (this.unitData == undefined) {
			return false;
		}

		// 単価 variable
		var unitPrice = 0;
		// 単価色
		var unitColorPrice = 0;

		// 一定値より大きい場合はデフォルト値を適用する
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

			$('#button_pdf').replaceWith('<input id="button_pdf" type="button" style="cursor:pointer;height: 30px;width: 200px;" onclick="javascript:validate();$(\'.loading\').show()" value="御見積書PDF出力（社名記載なし）"/>');
			$('#button_pdf2').replaceWith('<input id="button_pdf2" type="button" style="cursor:pointer;height: 30px;width: 200px;" onclick="javascript:$(\'#cus_detail\').toggle();" value="御見積書PDF出力（社名記載あり）">');
			$('#button_order').prop('disabled',false);
			// 計算 calculate
			calc(getItemType());
			table_priceW();
		}
		console.log('Yeah, Im fine');
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

	function getStrapPCS() {
		var str = "";
		for(var i=0; i<itemQA.length; i++){
			if (itemQA[i].checked) {
				str = itemQA[i].value;
				break;
			}
		}
		return str;
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

		function getFileFormat() {
			//入稿データファイル
			var str = "";
			for(var i=0; i<data_file.length; i++){
				if (data_file[i].checked) {
					str = data_file[i].value;
					break;
				}
			}
			return str;
		}

		function getPrint() {
			var str = "";
			for(var i=0; i<print_umu.length; i++){
				if (print_umu[i].checked) {
					str = print_umu[i].value;
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

		if(this.vno_of_order == '' || !isNumber(this.vno_of_order)) {
			document.getElementById('err_no_of_order').innerHTML = "<span style=color:red;>※入力に誤りがあります。0?9の半角英数字で再度ご入力下さい。</span>";
			error = false;
		}

		// 注文個数チェック Check number of order
		var num = "";
		if(this.vno_of_order < 100){
			err_number_of_order = true;
			num = "100本";
			error = false;
		}

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

	var tax = 0;

	function calc(val) {

		// 初期化
		var unit_price = 0;
		var basic_charge = 0;
		var mold_charge = 0;
		var proto_shipping_charge = 0;
		var trace_charge = 0;
		var order_pcs = 0;
		var strap_price = 0;
		var shipping_charge = 0;
		var before_tax = 0;
		
		var total = 0;
		var print_charge = 0;
		var silk_print = 0;
		var proto_charge = 0;
		var vat = 10;

		// new
		var itemType = getItemType();
		var itemQA = getItemQA();
		var qty = this.vno_of_order;


		if(itemType == "target" && itemQA =="standard") {

			if(qty>=1 && qty<=199 ) {
				strap_price = numUnitPrice["target"][0]["price"];
			}
			else if(qty>=200 && qty<=299 ) {
				strap_price = numUnitPrice["target"][1]["price"];
			}
			else if(qty>=300 && qty<=499 ) {
				strap_price = numUnitPrice["target"][2]["price"];
			}
			else if(qty>=500 && qty<=999 ) {
				strap_price = numUnitPrice["target"][3]["price"];
			}
			else if(qty>=1000 && qty<=2999 ) {
				strap_price = numUnitPrice["target"][4]["price"];
			}
			else if(qty>=3000 && qty<=4999 ) {
				strap_price = numUnitPrice["target"][5]["price"];
			}
			else if(qty>=5000 ) {
				strap_price = numUnitPrice["target"][6]["price"];
			}
		}
		else if(itemType == "target" && itemQA =="premium") {

			if(qty>=1 && qty<=199 ) {
				strap_price = numUnitPrice["target_premium"][0]["price"];
			}
			else if(qty>=200 && qty<=299 ) {
				strap_price = numUnitPrice["target_premium"][1]["price"];
			}
			else if(qty>=300 && qty<=499 ) {
				strap_price = numUnitPrice["target_premium"][2]["price"];
			}
			else if(qty>=500 && qty<=999 ) {
				strap_price = numUnitPrice["target_premium"][3]["price"];
			}
			else if(qty>=1000 && qty<=2999 ) {
				strap_price = numUnitPrice["target_premium"][4]["price"];
			}
			else if(qty>=3000 && qty<=4999 ) {
				strap_price = numUnitPrice["target_premium"][5]["price"];
			}
			else if(qty>=5000 ) {
				strap_price = numUnitPrice["target_premium"][6]["price"];
			}
		}

		if($('input[name=carabiner]:checked').val()=="1")
		{
			var carabiner_txt = "";
			carabiner_print = 0;
			carabiner_price = 0;
			
			//Get carabiner print price
			switch($('input[name=carabiner_type]:checked').val()){
				case '廉価版カラビナ':
				carabiner_txt = "carabiner_O";
				carabiner_fld = "CBO_";
				break;

				case '高級版Mサイズ':
				carabiner_txt = "carabiner_M";
				carabiner_fld = "CBM_";
				if($('input[name=carabiner_print]:checked').val()=="1") {carabiner_print = 20;}
				else if($('input[name=carabiner_print]:checked').val()=="2") {carabiner_print = 30;}
				break;

				case '高級版Lサイズ':
				carabiner_txt = "carabiner_L";
				carabiner_fld = "CBL_";
				if($('input[name=carabiner_print]:checked').val()=="1") {carabiner_print = 20;}
				else if($('input[name=carabiner_print]:checked').val()=="2") {carabiner_print = 30;}
				break;
			}
			//Get carabiner price
			if(qty>=1 && qty<=199 ) {
				carabiner_price = numCarabinerPrice[carabiner_txt][0]["price"];
			}
			else if(qty>=200 && qty<=299 ) {
				carabiner_price = numCarabinerPrice[carabiner_txt][1]["price"];
			}
			else if(qty>=300 && qty<=499 ) {
				carabiner_price = numCarabinerPrice[carabiner_txt][2]["price"];
			}
			else if(qty>=500 && qty<=999 ) {
				carabiner_price = numCarabinerPrice[carabiner_txt][3]["price"];
			}
			else if(qty>=1000 && qty<=2999 ) {
				carabiner_price = numCarabinerPrice[carabiner_txt][4]["price"];
			}
			else if(qty>=3000 && qty<=4999 ) {
				carabiner_price = numCarabinerPrice[carabiner_txt][5]["price"];
			}
			else if(qty>=5000 ) {
				carabiner_price = numCarabinerPrice[carabiner_txt][6]["price"];
			}
		}else{
			carabiner_print = 0;
			carabiner_price = 0;
		}

		strap_price = Math.floor(strap_price*(1+vat/100)) * qty; 
		carabiner_price = Math.floor(carabiner_price*(1+vat/100)) * qty; 
		carabiner_print = Math.floor(carabiner_print*(1+vat/100)) * qty; 

		document.getElementById('pricefield7').value = formatMoney(strap_price);
		document.getElementById('pricefield7_n1').value = formatMoney(carabiner_price);
		document.getElementById('pricefield7_n2').value = formatMoney(carabiner_print);

		var send_proto = getSendProto();
		var data_file = getFileFormat();
		var print_umu = getPrint();

		if(itemQA == "standard"){
			if(send_proto == "2"){
				proto_charge = Math.floor(8000*(1+vat/100));
			}
			if(data_file == "other_file"){
				trace_charge = Math.floor(8000*(1+vat/100));
			}
			if(print_umu == "screen"){
				print_charge = Math.floor((this.vno_of_order * 20)*(1+vat/100));
			}
		}
		

		before_tax = strap_price + proto_charge + trace_charge + print_charge+ carabiner_price+ carabiner_print;

		tax = Math.floor(Math.floor(strap_price*vat/(100+vat)) + Math.floor(proto_charge*vat/(100+vat))+
			Math.floor(trace_charge*vat/(100+vat)) + Math.floor(print_charge*vat/(100+vat))+
			Math.floor((carabiner_price)*vat/(100+vat))+ Math.floor((carabiner_print)*vat/(100+vat)));
		// tax = tax - Math.floor(tax*vat/100);

		var disc_price =  0;

		total = before_tax - disc_price;

		document.getElementById('pricefield8').value = formatMoney(proto_charge);
		document.getElementById('pricefield9').value = formatMoney(trace_charge);
		document.getElementById('pricefield10').value = formatMoney(print_charge);
		document.getElementById('pricefield11').value = formatMoney(before_tax);
		document.getElementById('pricefield12').value = formatMoney(disc_price);
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

// リファクタ対象　ここまで

function showField() {
	document.getElementById('f1').style.display = "";
}

//New Function Write All Price Table
function table_priceW(items){
	var itemType = $('input[name=ItemType]:checked').val();
	var itemQA = $('input[name=ItemQA]:checked').val();
	var QA_val = "";
	if(itemQA=="premium"){
		QA_val = "_premium";
	}
	
	if(item="carabiner"){
		if($('input[name=carabiner_type]:checked').val()=="高級版Mサイズ" || $('input[name=carabiner_type]:checked').val()=="高級版Lサイズ"){
			$('input[name=carabiner_print]').prop('disabled',false);
		}else{
			$('input[name=carabiner_print]:first').prop('checked',true);
			$('input[name=carabiner_print]').not(':first').prop('disabled',true);
		}
	}
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

	function getItemQA() {
		var itemQA = document.getElementsByName('ItemQA');
		var str = "";
		for(var i=0; i<itemQA.length; i++){
			if (itemQA[i].checked) {
				str = itemQA[i].value;
				break;
			}
		}
		return str;
	}

	function getProtoType(){
		// 試作品の送付
		var send_proto = document.getElementsByName('example');
		var str = "";
		for(var i=0; i<send_proto.length; i++){
			if (send_proto[i].checked) {
				str = send_proto[i].value;
				break;
			}
		}
		return str;
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
	// clear error fields
	clearErrFields();
	click_itemtype(getItemType());
	var outputDate = document.getElementById('date_display');
	outputDate.innerHTML = "";
	$('#button_pdf').replaceWith('<input id="button_pdf" type="button" style="height: 30px;width: 250px;" value="御見積書PDF出力（社名記載なし）" disabled="true" />');
	$('#button_pdf2').replaceWith('<input id="button_pdf2" type="button" style="height: 30px;width: 250px;" value="御見積書PDF出力（社名記載あり）" disabled="true">');
	$('#cus_detail').hide();
	$('#div_estimatePrice').hide();
}

// New function 14-08-2559 --->
function click_typeorder_disabled(typeOption) {

	itemType = "target";

	// (C). Example have
	document.getElementById("example_have").checked = true;
	document.getElementById("example_nothave").disabled = true;
	document.getElementById("example_have").disabled = true;

	// (D). Result
	document.getElementById("ai_file").checked = true;
	document.getElementById("ai_file").disabled = true;
	document.getElementById("other_file").disabled = true;

	// (E). Result
	document.getElementById("screen2").checked = true;
	document.getElementById("screen2").disabled = true;
	document.getElementById("screen1").disabled = true;

	switch (itemType) {
		case "target":
		if (typeOption == "standard") {
			document.getElementById("screen1").disabled = false;
		}
		break;
	}
}

function click_typeorder_enabled(typeOption) {

	itemType = "target";

	// (C). Example have
	document.getElementById("example_nothave").checked = true;
	document.getElementById("example_nothave").disabled = false;
	document.getElementById("example_have").disabled = false;

	// (D). Result
	document.getElementById("ai_file").checked = true;
	document.getElementById("ai_file").disabled = false;
	document.getElementById("other_file").disabled = false;

	// (E). Result
	document.getElementById("screen1").checked = true;
	document.getElementById("screen2").disabled = false;
	document.getElementById("screen1").disabled = false;

	switch (itemType) {
		case "target":
		if (typeOption == "standard") {
			document.getElementById("screen1").disabled = false;
		}
		break;
	}
}
// --------------------------->


// Select estimate item
function click_itemtype(clicked) {

	typeOption = "standard";
	if (document.getElementById("Quality2").checked)
		typeOption = "premium";

	switch (clicked) {
		case "target":
		if (typeOption == "standard") {
			document.getElementById("screen1").disabled = false;
			document.getElementById("screen2").disabled = false;
		}

		if (typeOption == "premium") {
			document.getElementById("screen2").checked = true;
		}
		break;
	}
}

function hideField(el) {
	document.getElementById(el).style.display = "none";
}

function showField(el) {
	document.getElementById(el).style.display = "";
}

function clear_valCal(){
	clearColor();
	$('#pricefield7').val('')
	$('#pricefield7_n1').val('')
	$('#pricefield7_n2').val('')
	$('#pricefield8').val('')
	$('#pricefield9').val('')
	$('#pricefield10').val('')
	$('#pricefield11').val('')
	$('#pricefield12').val('')
	$('#pricefield13').val('')
	$('#div_estimatePrice').hide()
}