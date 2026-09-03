/**********************************
* Description: Javascript for calculation
* CreateDate: Mar.03.2018
* UpdateDate: -
**********************************/

// 個数単価データ
var numUnitPrice;
 numUnitPrice = {
    "i1_std_1":[
      {"num":100, "price":210},
      {"num":300, "price":160},
      {"num":500, "price":130},
      {"num":1000, "price":100},
      {"num":3000, "price":80},
      {"num":5000, "price":70}
    ],
    "i1_std_2":[
      {"num":100, "price":220},
      {"num":300, "price":170},
      {"num":500, "price":140},
      {"num":1000, "price":110},
      {"num":3000, "price":90},
      {"num":5000, "price":80}
    ],
    "i1_prm_1":[
      {"num":100, "price":220},
      {"num":300, "price":170},
      {"num":500, "price":140},
      {"num":1000, "price":110},
      {"num":3000, "price":90},
      {"num":5000, "price":80}
    ],
    "i1_prm_2":[
      {"num":100, "price":230},
      {"num":300, "price":180},
      {"num":500, "price":150},
      {"num":1000, "price":120},
      {"num":3000, "price":100},
      {"num":5000, "price":90}
    ],
    "i2_std_1":[
      {"num":100, "price":230},
      {"num":300, "price":180},
      {"num":500, "price":150},
      {"num":1000, "price":120},
      {"num":3000, "price":100},
      {"num":5000, "price":90}
    ],
    "i2_std_2":[
      {"num":100, "price":240},
      {"num":300, "price":190},
      {"num":500, "price":160},
      {"num":1000, "price":130},
      {"num":3000, "price":110},
      {"num":5000, "price":100}
    ],
    "i2_prm_1":[
      {"num":100, "price":240},
      {"num":300, "price":190},
      {"num":500, "price":160},
      {"num":1000, "price":130},
      {"num":3000, "price":110},
      {"num":5000, "price":100}
    ],
    "i2_prm_2":[
      {"num":100, "price":250},
      {"num":300, "price":200},
      {"num":500, "price":170},
      {"num":1000, "price":140},
      {"num":3000, "price":120},
      {"num":5000, "price":110}
    ],
    "i3_std_1":[
      {"num":100, "price":0},
      {"num":300, "price":100},
      {"num":500, "price":90},
      {"num":1000, "price":70},
      {"num":3000, "price":50},
      {"num":5000, "price":40}
    ],
    "i3_std_2":[
      {"num":100, "price":0},
      {"num":300, "price":110},
      {"num":500, "price":100},
      {"num":1000, "price":90},
      {"num":3000, "price":60},
      {"num":5000, "price":50}
    ],
    "i3_prm_1":[
      {"num":100, "price":0},
      {"num":300, "price":110},
      {"num":500, "price":100},
      {"num":1000, "price":90},
      {"num":3000, "price":60},
      {"num":5000, "price":50}
    ],
    "i3_prm_2":[
      {"num":100, "price":0},
      {"num":300, "price":120},
      {"num":500, "price":110},
      {"num":1000, "price":100},
      {"num":3000, "price":70},
      {"num":5000, "price":60}
    ],
    "i4_std_1":[
      {"num":100, "price":160},
      {"num":300, "price":110},
      {"num":500, "price":100},
      {"num":1000, "price":80},
      {"num":3000, "price":60},
      {"num":5000, "price":50}
    ],
    "i4_std_2":[
      {"num":100, "price":170},
      {"num":300, "price":120},
      {"num":500, "price":110},
      {"num":1000, "price":90},
      {"num":3000, "price":70},
      {"num":5000, "price":60}
    ],
    "i4_prm_1":[
      {"num":100, "price":170},
      {"num":300, "price":120},
      {"num":500, "price":110},
      {"num":1000, "price":90},
      {"num":3000, "price":70},
      {"num":5000, "price":60}
    ],
    "i4_prm_2":[
      {"num":100, "price":180},
      {"num":300, "price":130},
      {"num":500, "price":120},
      {"num":1000, "price":100},
      {"num":3000, "price":80},
      {"num":5000, "price":70}
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
		this.typeOrder = $('input[name="ItemType"]');
		this.typeOrder2 = document.getElementsByName('ItemType2');
		this.typeColors = document.getElementsByName('color_s1');
		this.itemSize = document.getElementsByName('ItemSize');
		this.send_proto = document.getElementsByName('example');
		this.packing = document.getElementsByName('packing');
		this.vno_of_order = document.getElementById('no_of_order').value;
	}

	// JSONデータから注文個数と色個数の単価合計を取得
	function getUnitPriceData() {
		var type = getItemType();
		var type2 = getItemType2();
	    var size = getItemSize();
	    var colors = getItemColor();

	    var type_size = type+"_"+type2+"_"+size;

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

		for (var i = 0, iMax = this.unitData.length; i < iMax; i++) {
				// 個数がデータ内の単価個数より大きいかチェック
				if (parseInt(this.vno_of_order) >= parseInt(this.unitData[i].num)) {
					// 購入個数が単価個数以下の場合はこのロジック
					if(type==="i3"){
						unitPrice = this.unitData[i].price+(colors*10);
					}else{
						unitPrice = this.unitData[i].price;
					}
					// 大きかったら次の個数へ
					continue;
				}
				break;
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
		str = $('input[name="ItemType"]:checked').val();
		return str;
	}

	function getItemSize() {
	   var itemSize = document.getElementById("ItemSize").value;
	   return itemSize;
	}
	function getItemColor() {
	   var itemColors = document.getElementById("color_s1").value;
	   return itemColors;
	}
	function getItemType2() {
	   var itemType2 = document.getElementById("ItemType2").value;
	   return itemType2;
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
			case "i1":
			case "i2":
			case "i4":
			if(this.vno_of_order < 100){
				err_number_of_order = true;
				num = "100本";
				error = false;
			}
			break;
			case "i3":
			if(this.vno_of_order < 300){
				err_number_of_order = true;
				num = "300本";
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

		// new
		var itemType = getItemType();
		var itemSize = getItemSize();
		var qty = this.vno_of_order;

		unit_price = qty * getUnitPriceData();

		document.getElementById('pricefield7').value = formatMoney(unit_price);
		if(itemType==="i3"){
	      basic_charge = 3600;
	    }else if(itemType==="i4"){
	      basic_charge = 8000;
	    }else{
		  basic_charge = 0;
	    }

	    if(document.getElementById("example_have").checked){
	      proto_charge = 4500;
	    }
		if(document.getElementById("pack_have").checked){
	      shipping_charge = qty*10;
	    }

    	before_tax = unit_price+type_price+proto_charge+shipping_charge+basic_charge;
	    tax = Math.floor(before_tax * 0.1);
	    total = before_tax + tax;

	    document.getElementById('pricefield5').value = formatMoney(basic_charge);
	    document.getElementById('pricefield8').value = formatMoney(proto_charge);
	    document.getElementById('pricefield9').value = formatMoney(shipping_charge);
	    document.getElementById('pricefield11').value = formatMoney(before_tax);
	    document.getElementById('pricefield12').value = formatMoney(tax);
	    document.getElementById('pricefield13').value = formatMoney(total);
	    table_priceW();
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
		// Default Background White
			for(var o=1;o<=6;o++){
				document.getElementById('CLO_'+o).style.background = "";
			}

			if (this.vno_of_order >= 100 && this.vno_of_order <= 299) {
				document.getElementById('CLO_1').style.background = "pink";
			} else if (this.vno_of_order >= 300 && this.vno_of_order <= 499) {
				document.getElementById('CLO_2').style.background = "pink";
			} else if (this.vno_of_order >= 500 && this.vno_of_order <= 999) {
				document.getElementById('CLO_3').style.background = "pink";
			} else if (this.vno_of_order >= 1000 && this.vno_of_order <= 2999) {
				document.getElementById('CLO_4').style.background = "pink";
			} else if (this.vno_of_order >= 3000 && this.vno_of_order <= 4999) {
				document.getElementById('CLO_5').style.background = "pink";
			}else {
				document.getElementById('CLO_6').style.background = "pink";
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
		for(var o=1;o<=6;o++){
			document.getElementById('CLO_'+o).style.background = "";
		}
		// clear error fields numberOf
		$('#button_pdf').replaceWith('<input id="button_pdf" type="button" style="height: 30px;width: 250px;" value="御見積書PDF出力（社名記載なし）" disabled="true" />');
		$('#button_pdf2').replaceWith('<input id="button_pdf2" type="button" style="height: 30px;width: 250px;" value="御見積書PDF出力（社名記載あり）" disabled="true">');
		$('#cus_detail').hide();
		clearErrFields();
		click_itemtype(getItemType());
		$('#div_estimatePrice').hide();
	}

	function hideField(el) {
		document.getElementById(el).style.display = "none";
	}

	function showField(el) {
		document.getElementById(el).style.display = "";
	}
	function table_priceW(){
		$('#div_estimatePrice').hide();
		var type = getItemType();
		var type2 = getItemType2();
		var size = getItemSize();
		var colors = getItemColor();
		var qty = [100,300,500,1000,3000,5000];
		var tax;
		var rows,row1=0; 
		var sum = 0;
		var basic_charge = 0;
		var proto_charge = 0;
		if(type==="i3"){
	      basic_charge = 3600;
	    }else if(type==="i4"){
	      basic_charge = 8000;
	    }else{
		  basic_charge = 0;
	    }
	    if(document.getElementById("example_have").checked){
	      proto_charge = 4500;
	    }
	 // if(document.getElementById("pack_have").checked){
	 //   shipping_charge = qty*10;
	 // }
		switch(type){
			case 'i1':
			case 'i2':
			case 'i4':
				sum = Number(basic_charge+proto_charge);
				$('#qty_100').show();
				for(rows=0;rows<6;rows++){
					if(!document.getElementById("pack_have").checked){
						document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((numUnitPrice[type+"_"+type2+"_"+size][rows]["price"] * qty[rows])+sum)/qty[rows]))+"円";
						document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((numUnitPrice[type+"_"+type2+"_"+size][rows]["price"] * qty[rows])+sum))+"円";
						tax = Math.floor((numUnitPrice[type+"_"+type2+"_"+size][rows]["price"] * qty[rows] + sum) * 1.1);
						document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
					}else{
						document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((numUnitPrice[type+"_"+type2+"_"+size][rows]["price"] * qty[rows])+sum+(qty[rows]*10))/qty[rows]))+"円";
						document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((numUnitPrice[type+"_"+type2+"_"+size][rows]["price"] * qty[rows])+sum+(qty[rows]*10)))+"円";
						tax = Math.floor((numUnitPrice[type+"_"+type2+"_"+size][rows]["price"] * qty[rows] + sum +(qty[rows]*10)) * 1.1);
						document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
					}
				}
			break;
			case 'i3':
				sum = Number(basic_charge+proto_charge);
				$('#qty_100').hide();
				for(rows=1;rows<6;rows++){
					if(!document.getElementById("pack_have").checked){
						document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil((((numUnitPrice[type+"_"+type2+"_"+size][rows]["price"]+(colors*10)) * qty[rows])+sum)/qty[rows]))+"円";
						document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number(((numUnitPrice[type+"_"+type2+"_"+size][rows]["price"]+(colors*10)) * qty[rows])+sum))+"円";
						tax = Math.floor(((numUnitPrice[type+"_"+type2+"_"+size][rows]["price"]+(colors*10)) * qty[rows] + sum) * 1.1);
						document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
					}else{
						document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil((((numUnitPrice[type+"_"+type2+"_"+size][rows]["price"]+(colors*10)) * qty[rows])+sum+(qty[rows]*10))/qty[rows]))+"円";
						document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number(((numUnitPrice[type+"_"+type2+"_"+size][rows]["price"]+(colors*10)) * qty[rows])+sum+(qty[rows]*10)))+"円";
						tax = Math.floor(((numUnitPrice[type+"_"+type2+"_"+size][rows]["price"]+(colors*10)) * qty[rows] + sum+(qty[rows]*10)) * 1.1);
						document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
					}
					row1++;
				}
			break;
		}
	}
  function clear_field(){
	$('#pricefield5').val('');
    $('#pricefield7').val('');
    $('#pricefield8').val('');
    $('#pricefield9').val('');
    $('#pricefield11').val('');
    $('#pricefield12').val('');
    $('#pricefield13').val('');
    for(var o=1;o<=6;o++){
		document.getElementById('CLO_'+o).style.background = "";
	}
  }

  function WritePriceTable() {
  	clear_field();
  	var loop1;
  	var line;
  	var type = getItemType();
	var type2 = getItemType2();
	var size = getItemSize();
	var colors = getItemColor();

	var type_size = type+"_"+type2+"_"+size;

	this.loop1 = numUnitPrice[type_size];
	if(type==="i3"){
		for(var o=2,i=1;o<=6;o++,i++){
			document.getElementById('CLO_'+o).innerHTML = formatMoney(this.loop1[i].price+(colors*10));
		}
		document.getElementById('CLO_1').innerHTML = "-";
	}else{
		for(var o=1,i=0;o<=6;o++,i++){
			document.getElementById('CLO_'+o).innerHTML = formatMoney(this.loop1[i].price);
		}
	}
  }
  function click_itemtype(clicked) {
  	WritePriceTable();
  	$('#cth1').hide();$('#cth2').hide();
  	$('#cth3').hide();$('#cth4').hide();
  	switch(clicked){
  		case 'i1':$('#color_s').hide();$('#cth1').show();break;
  		case 'i2':$('#color_s').hide();$('#cth2').show();break;
  		case 'i3':$('#color_s').show();$('#cth3').show();break;
  		case 'i4':$('#color_s').hide();$('#cth4').show();break;
  	}
  }
    function clear_d(){
    	clear_field();
        document.getElementById('i1').checked=true;
        document.getElementById('example_nothave').checked=true;
        document.getElementById('pack_nothave').checked=true;
        document.getElementById('color_s1').options[0].selected=true;
        document.getElementById('ItemType2').options[0].selected=true;
        document.getElementById('ItemSize').options[0].selected=true;
        $('#no_of_order').val('');$('#color_s').hide();
    }
    function clear_sub(){
    	clear_field();
        document.getElementById('example_nothave').checked=true;
        document.getElementById('pack_nothave').checked=true;
        document.getElementById('color_s1').options[0].selected=true;
        document.getElementById('ItemType2').options[0].selected=true;
        document.getElementById('ItemSize').options[0].selected=true;
        $('#no_of_order').val('');
    }