/**********************************
* Description: Javascript for calculation
* CreateDate: Jul.22.2010
* UpdateDate: Feb.01.2013
**********************************/
//Delete 2012/04/24 Sineenad R. Start
	// 個数単価データ


// 個数単価データ
var numUnitPrice = {
			// :: Strap data1 :: // standard
			"phone_stand_s":[
			{"num":100, "price":850},
			{"num":200, "price":678},
			{"num":300, "price":505},
			{"num":500, "price":416},
			{"num":1000, "price":297},
			{"num":3000, "price":224},
			{"num":5000, "price":198}
			],

			// :: Strap data2 :: // premuim
			"phone_stand_s_premium":[
			{"num":100, "price":1105},
			{"num":200, "price":881},
			{"num":300, "price":657},
			{"num":500, "price":499},
			{"num":1000, "price":356},
			{"num":3000, "price":269},
			{"num":5000, "price":238}
			],

			"phone_stand_l":[
			{"num":100, "price":1066},
			{"num":200, "price":884},
			{"num":300, "price":622},
			{"num":500, "price":526},
			{"num":1000, "price":399},
			{"num":3000, "price":288},
			{"num":5000, "price":263}
			],

			// :: Strap data2 :: // premuim
			"phone_stand_l_premium":[
			{"num":100, "price":1386},
			{"num":200, "price":1097},
			{"num":300, "price":809},
			{"num":500, "price":631},
			{"num":1000, "price":479},
			{"num":3000, "price":346},
			{"num":5000, "price":316}
			]
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

	function getPrice(){
		// オブジェクトの取得
		getObjects();
		// 単価テーブルの色クリア

		clearColor();

		// 入力チェック input check

		if(validateCheck()) {
			$('#button_pdf').replaceWith('<input id="button_pdf" type="button" style="cursor:pointer;height: 30px;width: 200px;" onclick="javascript:validate();$(\'.loading\').show()" value="御見積書PDF出力（社名記載なし）"/>');
			$('#button_pdf2').replaceWith('<input id="button_pdf2" type="button" style="cursor:pointer;height: 30px;width: 200px;" onclick="javascript:$(\'#cus_detail\').toggle();" value="御見積書PDF出力（社名記載あり）">');
			$('#button_order').prop('disabled',false);
			setColor(getItemType());
			// 計算 calculate
			calc(getItemType());
			$('#div_estimatePrice').show();
			table_priceW();
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
		var tax = 0;
		var total = 0;
		var print_charge = 0;
		var silk_print = 0;
		var proto_charge = 0;

		// new
		var itemType = getItemType();
		var itemSize = $('input[name=ItemSize]:checked').val();
		var itemQA = getItemQA();
		var qty = this.vno_of_order;
		var price_name = "";

		if(itemType == "phone_stand" && itemQA =="standard" && itemSize == "小サイズ") {
			price_name = "phone_stand_s";
		}
		else if(itemType == "phone_stand" && itemQA =="premium" && itemSize == "小サイズ") {
			price_name = "phone_stand_s_premium";
		}
		else if(itemType == "phone_stand" && itemQA =="standard" && itemSize == "大サイズ") {
			price_name = "phone_stand_l";
		}
		else if(itemType == "phone_stand" && itemQA =="premium" && itemSize == "大サイズ") {
			price_name = "phone_stand_l_premium";
		}

		if(qty>=1 && qty<=199 ) {
			strap_price = numUnitPrice[price_name][0]["price"] * qty;
		}
		else if(qty>=200 && qty<=299 ) {
			strap_price = numUnitPrice[price_name][1]["price"] * qty;
		}
		else if(qty>=300 && qty<=499 ) {
			strap_price = numUnitPrice[price_name][2]["price"] * qty;
		}
		else if(qty>=500 && qty<=999 ) {
			strap_price = numUnitPrice[price_name][3]["price"] * qty;
		}
		else if(qty>=1000 && qty<=2999 ) {
			strap_price = numUnitPrice[price_name][4]["price"] * qty;
		}
		else if(qty>=3000 && qty<=4999 ) {
			strap_price = numUnitPrice[price_name][5]["price"] * qty;
		}
		else if(qty>=5000 ) {
			strap_price = numUnitPrice[price_name][6]["price"] * qty;
		}

		document.getElementById('pricefield7').value = formatMoney(strap_price);

		var send_proto = getSendProto();
		var data_file = getFileFormat();
		var print_umu = getPrint();

		if(itemQA == "standard"){
			if(send_proto == "2"){
				proto_charge = 8000;
			}
			if(data_file == "other_file"){
				trace_charge = 8000;
			}
			if(print_umu == "screen"){
				print_charge = this.vno_of_order * 20;
			}
		}

		before_tax = strap_price + proto_charge + trace_charge + print_charge;
		tax = Math.floor(before_tax * 0.1);
		total = before_tax + tax;

		document.getElementById('pricefield8').value = formatMoney(proto_charge);
		document.getElementById('pricefield9').value = formatMoney(trace_charge);
		document.getElementById('pricefield10').value = formatMoney(print_charge);
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
	var itemQA = getItemQA();

	click_typeorder();

	var itemSize = $('input[name=ItemSize]:checked').val();

	var product_type = "";
	var itemType = getItemType();

	if(itemType == "phone_stand" && itemQA =="standard" && itemSize == "小サイズ") {
		product_type = "ST_s_";
	}
	else if(itemType == "phone_stand" && itemQA =="premium" && itemSize == "小サイズ") {
		product_type = "STP_s_";
	}
	else if(itemType == "phone_stand" && itemQA =="standard" && itemSize == "大サイズ") {
		product_type = "ST_l_";
	}
	else if(itemType == "phone_stand" && itemQA =="premium" && itemSize == "大サイズ") {
		product_type = "STP_l_";
	}
	// Default Background White
	document.getElementById(product_type+'1').style.background = "";
	document.getElementById(product_type+'2').style.background = "";
	document.getElementById(product_type+'3').style.background = "";
	document.getElementById(product_type+'4').style.background = "";
	document.getElementById(product_type+'5').style.background = "";
	document.getElementById(product_type+'6').style.background = "";
	document.getElementById(product_type+'7').style.background = "";
	// Set pick background for selected item.
	if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
		document.getElementById(product_type+'1').style.background = "pink";
	} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
		document.getElementById(product_type+'2').style.background = "pink";
	} else if (this.vno_of_order >= 300 && this.vno_of_order <= 499) {
		document.getElementById(product_type+'3').style.background = "pink";
	} else if (this.vno_of_order >= 500 && this.vno_of_order <= 999) {
		document.getElementById(product_type+'4').style.background = "pink";
	} else if (this.vno_of_order >= 1000 && this.vno_of_order <= 2999) {
		document.getElementById(product_type+'5').style.background = "pink";
	} else if (this.vno_of_order >= 3000 && this.vno_of_order <= 4999) {
		document.getElementById(product_type+'6').style.background = "pink";
	} else {
		document.getElementById(product_type+'7').style.background = "pink";
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
	//clear color strap
	for( var i=1; i<=7; i++ ){
		document.getElementById( 'ST_s_' + i ).style.background = "";
		document.getElementById( 'STP_s_' + i ).style.background = "";
		document.getElementById( 'ST_l_' + i ).style.background = "";
		document.getElementById( 'STP_l_' + i ).style.background = "";
	}
	// clear error fields
	clearErrFields();
	var outputDate = document.getElementById('date_display');
	outputDate.innerHTML = "";
	$('#button_pdf').replaceWith('<input id="button_pdf" type="button" style="height: 30px;width: 250px;" value="御見積書PDF出力（社名記載なし）" disabled="true" />');
	$('#button_pdf2').replaceWith('<input id="button_pdf2" type="button" style="height: 30px;width: 250px;" value="御見積書PDF出力（社名記載あり）" disabled="true">');
	$('#button_order').prop('disabled',true);
	$('#cus_detail').hide();
	$('#div_estimatePrice').hide();
}

// New function 14-08-2559 --->
function click_typeorder(typeOption) {
	var itemSize = $('input[name=ItemSize]:checked').val();
	var size = "";
	if(itemSize == "小サイズ"){
		size = 's';
	}else{
		size = 'l';
	}
	// Default hidefield standard
	hideField("pricetable_strap_s_standard");

	// Default hidefield premium
	hideField("pricetable_strap_s_premium");

	// Default hidefield standard
	hideField("pricetable_strap_l_standard");

	// Default hidefield premium
	hideField("pricetable_strap_l_premium");


	if (typeOption == "standard") {
		showField("pricetable_strap_"+size+"_standard");
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
	}else if (typeOption == "premium") {
		showField("pricetable_strap_"+size+"_premium");
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
	}else{
		showField("pricetable_strap_"+size+"_"+getItemQA());
	}
}


	function hideField(el) {
		document.getElementById(el).style.display = "none";
	}

	function showField(el) {
		document.getElementById(el).style.display = "";
	}

	//New Function Write All Price Table
	function table_priceW(items){
		var itemType = $('input[name=ItemType]:checked').val();
		var itemQA = $('input[name=ItemQA]:checked').val();
		var itemSize = $('input[name=ItemSize]:checked').val();
		var size = "";
		if(itemSize == "小サイズ"){
			size = '_s';
		}else{
			size = '_l';
		}
		var QA_val = "";
		if(itemQA=="premium"){
			QA_val = "_premium";
		}
		var qty = [100,200,300,500,1000,3000,5000]
		var tax;
		var rows,row1=0; 
		var sum = 0;
		var proto_charge = 0;
		var trace_charge = 0;
		var print_charge = 0;

		if(itemQA == "standard"){
			if($('input[name=example]:checked').val() == "2"){
				proto_charge = 8000;
			}
			if($('input[name=DeFormat]:checked').val() == "other_file"){
				trace_charge = 8000;
			}
			if($('input[name=Screen]:checked').val() == "screen"){
				print_charge = 20;
			}
		}

		if(items=="phone_stand"){
			for(rows=0;rows<7;rows++){
				document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(numUnitPrice["phone_stand"+size][rows]["price"] * qty[rows])+"円";
				document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(numUnitPrice["phone_stand"+size][rows]["price"])+"円";
				tax = Math.floor((numUnitPrice["phone_stand"+size][rows]["price"] * qty[rows]) * 1.1);
				document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
			}
		}else{
			switch(itemType){
				default:
				sum = Number(proto_charge + trace_charge);
				for(rows=0;rows<7;rows++){
					document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((numUnitPrice["phone_stand"+size+QA_val][rows]["price"] * qty[rows])+Number(sum+(print_charge*qty[rows])))/qty[rows]))+"円";
					document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((numUnitPrice["phone_stand"+size+QA_val][rows]["price"] * qty[rows])+sum+(print_charge*qty[rows])))+"円";
					tax = Math.floor((numUnitPrice["phone_stand"+size+QA_val][rows]["price"] * qty[rows] + sum+(print_charge*qty[rows])) * 1.1);
					document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
				} 
				break;
			}
		}
	}
	function clear_valCal(){
		clearColor();
		$('#pricefield7').val('')
		$('#pricefield8').val('')
		$('#pricefield9').val('')
		$('#pricefield10').val('')
		$('#pricefield11').val('')
		$('#pricefield12').val('')
		$('#pricefield13').val('')
		$('#div_estimatePrice').hide()
		//hidden carabiner price table
		$('#pricetable_carabiner_o').hide();
		$('#pricetable_carabiner_m').hide();
		$('#pricetable_carabiner_l').hide();
	}