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
			// :: Strap data1 :: // standard
			"strap":[
			{"num":100, "price":340},
			{"num":200, "price":220},
			{"num":300, "price":210},
			{"num":500, "price":200},
			{"num":1000, "price":160},
			{"num":3000, "price":135},
			{"num":5000, "price":115}
			],

			// :: Strap data2 :: // premuim
			"strap_premium":[
			{"num":100, "price":719},
			{"num":200, "price":555},
			{"num":300, "price":446},
			{"num":500, "price":339},
			{"num":1000, "price":257},
			{"num":3000, "price":184},
			{"num":5000, "price":140}
			],

			// :: Coaster data :: // standard
			"coaster":[
			{"num":100, "price":650},
			{"num":200, "price":530},
			{"num":300, "price":385},
			{"num":500, "price":325},
			{"num":1000, "price":234},
			{"num":3000, "price":177},
			{"num":5000, "price":149}
			],

			// coaster premium //
			"coaster_premium":[
			{"num":100, "price":840},
			{"num":200, "price":677},
			{"num":300, "price":513},
			{"num":500, "price":393},
			{"num":1000, "price":295},
			{"num":3000, "price":214},
			{"num":5000, "price":179}
			],

			// cleaner standard //
			"cleaner_rubber":[
			{"num":300, "price":469},
			{"num":500, "price":351},
			{"num":1000, "price":225},
			{"num":3000, "price":174},
			{"num":5000, "price":156}
			],

			// cleaner premium //
			"cleaner_rubber_premium":[
			{"num":300, "price":544},
			{"num":500, "price":411},
			{"num":1000, "price":273},
			{"num":3000, "price":210},
			{"num":5000, "price":180}
			],

			// keykaba standard //
			"keykaba":[
			{"num":100, "price":889},
			{"num":200, "price":682},
			{"num":300, "price":474},
			{"num":500, "price":348},
			{"num":1000, "price":256},
			{"num":3000, "price":191},
			{"num":5000, "price":143}
			],

			// keykaba premium //
			"keykaba_premium":[
			{"num":100, "price":988},
			{"num":200, "price":769},
			{"num":300, "price":549},
			{"num":500, "price":408},
			{"num":1000, "price":304},
			{"num":3000, "price":227},
			{"num":5000, "price":167}
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

		// NON
		// document.getElementById('strap_item1').checked = 'checked';
		// document.getElementById('strap_item').disabled = false;
		// ============>

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
		this.vno_of_order = document.getElementById('no_of_order').value;

		//this.campaign = document.getElementById('campaign_no').value;
	}

	// JSONデータから注文個数と色個数の単価合計を取得
	function getUnitPriceData() {
		var type = getItemType();

		if(type == "strap"){
			type = type + getStrapPCS();
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

		// 未満データを探す
		// for (var i = 0, iMax = this.unitData.length; i < iMax; i++) {

		// 	// 個数がデータ内の単価個数より大きいかチェック check price/pcs
		// 	if (this.vno_of_order >= this.unitData[i].num) {
		// 		// 大きかったら次の個数へ
		// 		continue;
		// 	}

		// 	// 購入個数が単価個数以下の場合はこのロジック
		// 	unitPrice = this.unitData[i].price;
		// 	break;
		// }

		// 一定値より大きい場合はデフォルト値を適用する
		if (unitPrice <= 0) {
			unitPrice = numUnitPrice[type + "DefPrice"];
			if (unitPrice == undefined) {
				return false;
			}
		}

		// ４色以上なら色単価をプラス 4color
		// if(this.vcolor > 3) {
		// 	// 色単価データ取得
		// 	this.colorData = colUnitPrice[type];

		// 	// 単価データがなかった場合 no unit price
		// 	if (this.colorData == undefined) {
		// 		return false;
		// 	}

			// 未満データを探す
			// for (var i = 0, iMax = this.colorData.length; i < iMax; i++) {
			// 	// 個数がデータ内の単価個数より大きいかチェック
			// 	if (this.vno_of_order >= this.colorData[i].num) {
			// 		// 大きかったら次の個数へ
			// 		continue;
			// 	}

			// 	// 購入個数が単価個数以下の場合はこのロジック
			// 	unitColorPrice = this.colorData[i].price;
			// 	break;
			// }

			// // 一定値より大きい場合はデフォルト値を適用する
			// if (unitColorPrice <= 0) {
			// 	unitColorPrice = colUnitPrice[type + "DefPrice"];
			// 	if (unitColorPrice == undefined) {
			// 		return false;
			// 	}
			// }
		// }
		// 色数 * 単価 total price
		// unitColorPrice = unitColorPrice * (this.vcolor - 3);
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

			$('#button_pdf').replaceWith('<input id="button_pdf" type="button" style="cursor:pointer;height: 30px;width: 250px;" onclick="javascript:validate();$(\'.loading\').show()" value="御見積書PDF出力（社名記載なし）"/>');
			$('#button_pdf2').replaceWith('<input id="button_pdf2" type="button" style="cursor:pointer;height: 30px;width: 250px;" onclick="javascript:$(\'#cus_detail\').toggle();" value="御見積書PDF出力（社名記載あり）">');

			setColor(getItemType());
			// 計算 calculate
			calc(getItemType());
			$('#div_estimatePrice').show();
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
			case "strap":
			if(this.vno_of_order < 100){
				err_number_of_order = true;
				num = "100本";
				error = false;
			}
			break;
			case "strap_premium":
			if(this.vno_of_order < 100){
				err_number_of_order = true;
				num = "100本";
				error = false;
			}
			break;
			case "coaster":
			if(this.vno_of_order < 100){
				err_number_of_order = true;
				num = "100枚";
				error = false;
			}
			break;
			case "coaster_premium":
			if(this.vno_of_order < 100){
				err_number_of_order = true;
				num = "100枚";
				error = false;
			}
			break;
			case "cleaner_rubber":
			if(this.vno_of_order < 300){
				err_number_of_order = true;
				num = "300本";
				error = false;
			}
			break;
			case "cleaner_rubber_premium":
			if(this.vno_of_order < 300){
				err_number_of_order = true;
				num = "300本";
				error = false;
			}
			break;
			case "keykaba":
			if(this.vno_of_order < 100){
				err_number_of_order = true;
				num = "100枚";
				error = false;
			}
			break;
			case "keykaba_premium":
			if(this.vno_of_order < 100){
				err_number_of_order = true;
				num = "100枚";
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
		var strap_price = 0;
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
		var itemQA = getItemQA();
		var qty = this.vno_of_order;


		if(itemType == "strap" && itemQA =="standard") {

			if(qty>=1 && qty<=199 ) {
				strap_price = numUnitPrice["strap"][0]["price"] * qty;
			}
			else if(qty>=200 && qty<=299 ) {
				strap_price = numUnitPrice["strap"][1]["price"] * qty;
			}
			else if(qty>=300 && qty<=499 ) {
				strap_price = numUnitPrice["strap"][2]["price"] * qty;
			}
			else if(qty>=500 && qty<=999 ) {
				strap_price = numUnitPrice["strap"][3]["price"] * qty;
			}
			else if(qty>=1000 && qty<=2999 ) {
				strap_price = numUnitPrice["strap"][4]["price"] * qty;
			}
			else if(qty>=3000 && qty<=4999 ) {
				strap_price = numUnitPrice["strap"][5]["price"] * qty;
			}
			else if(qty>=5000 ) {
				strap_price = numUnitPrice["strap"][6]["price"] * qty;
			}
		}
		else if(itemType == "strap" && itemQA =="premium") {

			if(qty>=1 && qty<=199 ) {
				strap_price = numUnitPrice["strap_premium"][0]["price"] * qty;
			}
			else if(qty>=200 && qty<=299 ) {
				strap_price = numUnitPrice["strap_premium"][1]["price"] * qty;
			}
			else if(qty>=300 && qty<=499 ) {
				strap_price = numUnitPrice["strap_premium"][2]["price"] * qty;
			}
			else if(qty>=500 && qty<=999 ) {
				strap_price = numUnitPrice["strap_premium"][3]["price"] * qty;
			}
			else if(qty>=1000 && qty<=2999 ) {
				strap_price = numUnitPrice["strap_premium"][4]["price"] * qty;
			}
			else if(qty>=3000 && qty<=4999 ) {
				strap_price = numUnitPrice["strap_premium"][5]["price"] * qty;
			}
			else if(qty>=5000 ) {
				strap_price = numUnitPrice["strap_premium"][6]["price"] * qty;
			}
		}
		else if (itemType == "keykaba" && itemQA == "standard"){

			if(qty>=1 && qty<=199 ) {
				strap_price = numUnitPrice["keykaba"][0]["price"] * qty;
			}
			else if(qty>=200 && qty<=299 ) {
				strap_price = numUnitPrice["keykaba"][1]["price"] * qty;
			}
			else if(qty>=300 && qty<=499 ) {
				strap_price = numUnitPrice["keykaba"][2]["price"] * qty;
			}
			else if(qty>=500 && qty<=999 ) {
				strap_price = numUnitPrice["keykaba"][3]["price"] * qty;
			}
			else if(qty>=1000 && qty<=2999 ) {
				strap_price = numUnitPrice["keykaba"][4]["price"] * qty;
			}
			else if(qty>=3000 && qty<=4999 ) {
				strap_price = numUnitPrice["keykaba"][5]["price"] * qty;
			}
			else if(qty>=5000 ) {
				strap_price = numUnitPrice["keykaba"][6]["price"] * qty;
			}
		}
		else if (itemType == "keykaba" && itemQA == "premium"){

			if(qty>=1 && qty<=199 ) {
				strap_price = numUnitPrice["keykaba_premium"][0]["price"] * qty;
			}
			else if(qty>=200 && qty<=299 ) {
				strap_price = numUnitPrice["keykaba_premium"][1]["price"] * qty;
			}
			else if(qty>=300 && qty<=499 ) {
				strap_price = numUnitPrice["keykaba_premium"][2]["price"] * qty;
			}
			else if(qty>=500 && qty<=999 ) {
				strap_price = numUnitPrice["keykaba_premium"][3]["price"] * qty;
			}
			else if(qty>=1000 && qty<=2999 ) {
				strap_price = numUnitPrice["keykaba_premium"][4]["price"] * qty;
			}
			else if(qty>=3000 && qty<=4999 ) {
				strap_price = numUnitPrice["keykaba_premium"][5]["price"] * qty;
			}
			else if(qty>=5000 ) {
				strap_price = numUnitPrice["keykaba_premium"][6]["price"] * qty;
			}
		}
		else if (itemType == "cleaner_rubber" && itemQA == "standard"){

			if(qty>=300 && qty<=499 ) {
				strap_price = numUnitPrice["cleaner_rubber"][0]["price"] * qty;
			}
			else if(qty>=500 && qty<=999 ) {
				strap_price = numUnitPrice["cleaner_rubber"][1]["price"] * qty;
			}
			else if(qty>=1000 && qty<=2999 ) {
				strap_price = numUnitPrice["cleaner_rubber"][2]["price"] * qty;
			}
			else if(qty>=3000 && qty<=4999 ) {
				strap_price = numUnitPrice["cleaner_rubber"][3]["price"] * qty;
			}
			else if(qty>=5000 ) {
				strap_price = numUnitPrice["cleaner_rubber"][4]["price"] * qty;
			}
		}
		else if (itemType == "cleaner_rubber" && itemQA == "premium"){

			if(qty>=300 && qty<=499 ) {
				strap_price = numUnitPrice["cleaner_rubber_premium"][0]["price"] * qty;
			}
			else if(qty>=500 && qty<=999 ) {
				strap_price = numUnitPrice["cleaner_rubber_premium"][1]["price"] * qty;
			}
			else if(qty>=1000 && qty<=2999 ) {
				strap_price = numUnitPrice["cleaner_rubber_premium"][2]["price"] * qty;
			}
			else if(qty>=3000 && qty<=4999 ) {
				strap_price = numUnitPrice["cleaner_rubber_premium"][3]["price"] * qty;
			}
			else if(qty>=5000 ) {
				strap_price = numUnitPrice["cleaner_rubber_premium"][4]["price"] * qty;
			}
		}
		else if (itemType == "coaster" && itemQA == "standard"){

			if(qty>=1 && qty<=199 ) {
				strap_price = numUnitPrice["coaster"][0]["price"] * qty;
			}
			else if(qty>=200 && qty<=299 ) {
				strap_price = numUnitPrice["coaster"][1]["price"] * qty;
			}
			else if(qty>=300 && qty<=499 ) {
				strap_price = numUnitPrice["coaster"][2]["price"] * qty;
			}
			else if(qty>=500 && qty<=999 ) {
				strap_price = numUnitPrice["coaster"][3]["price"] * qty;
			}
			else if(qty>=1000 && qty<=2999 ) {
				strap_price = numUnitPrice["coaster"][4]["price"] * qty;
			}
			else if(qty>=3000 && qty<=4999 ) {
				strap_price = numUnitPrice["coaster"][5]["price"] * qty;
			}
			else if(qty>=5000 ) {
				strap_price = numUnitPrice["coaster"][6]["price"] * qty;
			}
		}
		else if (itemType == "coaster" && itemQA == "premium"){

			if(qty>=1 && qty<=199 ) {
				strap_price = numUnitPrice["coaster_premium"][0]["price"] * qty;
			}
			else if(qty>=200 && qty<=299 ) {
				strap_price = numUnitPrice["coaster_premium"][1]["price"] * qty;
			}
			else if(qty>=300 && qty<=499 ) {
				strap_price = numUnitPrice["coaster_premium"][2]["price"] * qty;
			}
			else if(qty>=500 && qty<=999 ) {
				strap_price = numUnitPrice["coaster_premium"][3]["price"] * qty;
			}
			else if(qty>=1000 && qty<=2999 ) {
				strap_price = numUnitPrice["coaster_premium"][4]["price"] * qty;
			}
			else if(qty>=3000 && qty<=4999 ) {
				strap_price = numUnitPrice["coaster_premium"][5]["price"] * qty;
			}
			else if(qty>=5000 ) {
				strap_price = numUnitPrice["coaster_premium"][6]["price"] * qty;
			}
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

		var itemType = getItemType();

		if(itemType == "strap" && itemQA == "standard") {


				// Default Background White
				document.getElementById('ST_1').style.background = "";
				document.getElementById('ST_2').style.background = "";
				document.getElementById('ST_3').style.background = "";
				document.getElementById('ST_4').style.background = "";
				document.getElementById('ST_5').style.background = "";
				document.getElementById('ST_6').style.background = "";
				document.getElementById('ST_7').style.background = "";

				if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('ST_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('ST_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 499) {
					document.getElementById('ST_3').style.background = "pink";
				} else if (this.vno_of_order >= 500 && this.vno_of_order <= 999) {
					document.getElementById('ST_4').style.background = "pink";
				} else if (this.vno_of_order >= 1000 && this.vno_of_order <= 2999) {
					document.getElementById('ST_5').style.background = "pink";
				} else if (this.vno_of_order >= 3000 && this.vno_of_order <= 4999) {
					document.getElementById('ST_6').style.background = "pink";
				} else {
					document.getElementById('ST_7').style.background = "pink";
				}
		}
		else if(itemType == "strap" && itemQA == "premium")
		{
				// Default Background White
				document.getElementById('STP_1').style.background = "";
				document.getElementById('STP_2').style.background = "";
				document.getElementById('STP_3').style.background = "";
				document.getElementById('STP_4').style.background = "";
				document.getElementById('STP_5').style.background = "";
				document.getElementById('STP_6').style.background = "";
				document.getElementById('STP_7').style.background = "";

				if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('STP_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('STP_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 499) {
					document.getElementById('STP_3').style.background = "pink";
				} else if (this.vno_of_order >= 500 && this.vno_of_order <= 999) {
					document.getElementById('STP_4').style.background = "pink";
				} else if (this.vno_of_order >= 1000 && this.vno_of_order <= 2999) {
					document.getElementById('STP_5').style.background = "pink";
				} else if (this.vno_of_order >= 3000 && this.vno_of_order <= 4999) {
					document.getElementById('STP_6').style.background = "pink";
				} else {
					document.getElementById('STP_7').style.background = "pink";
				}
		}
		else if(itemType == "keykaba" && itemQA == "standard")
		{

				// Default Background White
				document.getElementById('KB_1').style.background = "";
				document.getElementById('KB_2').style.background = "";
				document.getElementById('KB_3').style.background = "";
				document.getElementById('KB_4').style.background = "";
				document.getElementById('KB_5').style.background = "";
				document.getElementById('KB_6').style.background = "";
				document.getElementById('KB_7').style.background = "";

				if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('KB_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('KB_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 499) {
					document.getElementById('KB_3').style.background = "pink";
				} else if (this.vno_of_order >= 500 && this.vno_of_order <= 999) {
					document.getElementById('KB_4').style.background = "pink";
				} else if (this.vno_of_order >= 1000 && this.vno_of_order <= 2999) {
					document.getElementById('KB_5').style.background = "pink";
				} else if (this.vno_of_order >= 3000 && this.vno_of_order <= 4999) {
					document.getElementById('KB_6').style.background = "pink";
				} else {
					document.getElementById('KB_7').style.background = "pink";
				}
		}
		else if(itemType == "keykaba" && itemQA == "premium")
		{

				// Default Background White
				document.getElementById('KBP_1').style.background = "";
				document.getElementById('KBP_2').style.background = "";
				document.getElementById('KBP_3').style.background = "";
				document.getElementById('KBP_4').style.background = "";
				document.getElementById('KBP_5').style.background = "";
				document.getElementById('KBP_6').style.background = "";
				document.getElementById('KBP_7').style.background = "";

				if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('KBP_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('KBP_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 499) {
					document.getElementById('KBP_3').style.background = "pink";
				} else if (this.vno_of_order >= 500 && this.vno_of_order <= 999) {
					document.getElementById('KBP_4').style.background = "pink";
				} else if (this.vno_of_order >= 1000 && this.vno_of_order <= 2999) {
					document.getElementById('KBP_5').style.background = "pink";
				} else if (this.vno_of_order >= 3000 && this.vno_of_order <= 4999) {
					document.getElementById('KBP_6').style.background = "pink";
				} else {
					document.getElementById('KBP_7').style.background = "pink";
				}
		}
		else if(itemType == "cleaner_rubber" && itemQA == "standard")
		{
				// Default Background White
				document.getElementById('CR_1').style.background = "";
				document.getElementById('CR_2').style.background = "";
				document.getElementById('CR_3').style.background = "";
				document.getElementById('CR_4').style.background = "";
				document.getElementById('CR_5').style.background = "";

				if (this.vno_of_order >= 300 && this.vno_of_order <= 499) {
					document.getElementById('CR_1').style.background = "pink";
				} else if (this.vno_of_order >= 500 && this.vno_of_order <= 999) {
					document.getElementById('CR_2').style.background = "pink";
				} else if (this.vno_of_order >= 1000 && this.vno_of_order <= 2999) {
					document.getElementById('CR_3').style.background = "pink";
				} else if (this.vno_of_order >= 3000 && this.vno_of_order <= 4999) {
					document.getElementById('CR_4').style.background = "pink";
				} else {
					document.getElementById('CR_5').style.background = "pink";
				}
		}
		else if(itemType == "cleaner_rubber" && itemQA == "premium")
		{
				// Default Background White
				document.getElementById('CRP_1').style.background = "";
				document.getElementById('CRP_2').style.background = "";
				document.getElementById('CRP_3').style.background = "";
				document.getElementById('CRP_4').style.background = "";
				document.getElementById('CRP_5').style.background = "";

				if (this.vno_of_order >= 300 && this.vno_of_order <= 499) {
					document.getElementById('CRP_1').style.background = "pink";
				} else if (this.vno_of_order >= 500 && this.vno_of_order <= 999) {
					document.getElementById('CRP_2').style.background = "pink";
				} else if (this.vno_of_order >= 1000 && this.vno_of_order <= 2999) {
					document.getElementById('CRP_3').style.background = "pink";
				} else if (this.vno_of_order >= 3000 && this.vno_of_order <= 4999) {
					document.getElementById('CRP_4').style.background = "pink";
				} else {
					document.getElementById('CRP_5').style.background = "pink";
				}
		}
		else if(itemType == "coaster" && itemQA == "standard")
		{
				// Default Background White
				document.getElementById('CS_1').style.background = "";
				document.getElementById('CS_2').style.background = "";
				document.getElementById('CS_3').style.background = "";
				document.getElementById('CS_4').style.background = "";
				document.getElementById('CS_5').style.background = "";
				document.getElementById('CS_6').style.background = "";
				document.getElementById('CS_7').style.background = "";

				if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('CS_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('CS_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 499) {
					document.getElementById('CS_3').style.background = "pink";
				} else if (this.vno_of_order >= 500 && this.vno_of_order <= 999) {
					document.getElementById('CS_4').style.background = "pink";
				} else if (this.vno_of_order >= 1000 && this.vno_of_order <= 2999) {
					document.getElementById('CS_5').style.background = "pink";
				} else if (this.vno_of_order >= 3000 && this.vno_of_order <= 4999) {
					document.getElementById('CS_6').style.background = "pink";
				} else {
					document.getElementById('CS_7').style.background = "pink";
				}
		}
		else if(itemType == "coaster" && itemQA == "premium")
		{
				// Default Background White
				document.getElementById('CSP_1').style.background = "";
				document.getElementById('CSP_2').style.background = "";
				document.getElementById('CSP_3').style.background = "";
				document.getElementById('CSP_4').style.background = "";
				document.getElementById('CSP_5').style.background = "";
				document.getElementById('CSP_6').style.background = "";
				document.getElementById('CSP_7').style.background = "";

				if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('CSP_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('CSP_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 499) {
					document.getElementById('CSP_3').style.background = "pink";
				} else if (this.vno_of_order >= 500 && this.vno_of_order <= 999) {
					document.getElementById('CSP_4').style.background = "pink";
				} else if (this.vno_of_order >= 1000 && this.vno_of_order <= 2999) {
					document.getElementById('CSP_5').style.background = "pink";
				} else if (this.vno_of_order >= 3000 && this.vno_of_order <= 4999) {
					document.getElementById('CSP_6').style.background = "pink";
				} else {
					document.getElementById('CSP_7').style.background = "pink";
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

		this.typeOrder = document.getElementsByName('ItemType');

	//clear color strap
	for( var i=1; i<=7; i++ ){
			document.getElementById( 'ST_' + i ).style.background = "";  //strap
			document.getElementById( 'KB_' + i ).style.background = "";  //keykab
			document.getElementById( 'CS_' + i ).style.background = "";  //coaster
		if(i<6){
			document.getElementById( 'CR_' + i ).style.background = "";  //cleaner rubber
		}
	}

	for( var j = 1; j<=7; j++ ) {
			document.getElementById( 'STP_' + j ).style.background = "";
			document.getElementById( 'KBP_' + j ).style.background = "";
			document.getElementById( 'CSP_' + j ).style.background = "";
		if(j<6){
			document.getElementById( 'CRP_' + j ).style.background = "";
		}
	}
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

	itemType = "strap";
	if (document.getElementById("keykaba").checked)
		itemType = "keykaba";
	if (document.getElementById("cleaner_rubber").checked)
		itemType = "cleaner_rubber";
	if (document.getElementById("coaster").checked)
		itemType = "coaster";

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

	// Default hidefield standard
	hideField("pricetable_strap_standard");
	hideField("pricetable_keykaba_standard");
	hideField("pricetable_cleaner_rubber_standard");
	hideField("pricetable_coaster_standard");

	// Default hidefield premium
	hideField("pricetable_strap_premium");
	hideField("pricetable_keykaba_premium");
	hideField("pricetable_cleaner_rubber_premium");
	hideField("pricetable_coaster_premium");

	switch (itemType) {
		case "strap":
		if (typeOption == "standard") {
			showField("pricetable_strap_standard");
			document.getElementById("screen1").disabled = false;
		}

		if (typeOption == "premium") {
			showField("pricetable_strap_premium");
		}
		break;
		case "keykaba":
		if (typeOption == "standard") {
			showField("pricetable_keykaba_standard");
			document.getElementById("screen1").disabled = false;
		}

		if (typeOption == "premium") {
			showField("pricetable_keykaba_premium");
		}
		break;
		case "cleaner_rubber":
		if (typeOption == "standard") {
			showField("pricetable_cleaner_rubber_standard");
			document.getElementById("example_nothave").checked = true;
			document.getElementById("ai_file").checked = true;
			document.getElementById("screen1").checked = true;
			document.getElementById("screen1").disabled = true;
		}

		if (typeOption == "premium") {
			showField("pricetable_cleaner_rubber_premium");
			document.getElementById("example_have").checked = true;
			document.getElementById("example_have").disabled = true;
			document.getElementById("ai_file").checked = true;
			document.getElementById("ai_file").disabled = true;
			document.getElementById("screen1").checked = true;
			document.getElementById("screen1").disabled = true;
		}
		break;
		case "coaster":
		if (typeOption == "standard") {
			showField("pricetable_coaster_standard");
			document.getElementById("screen1").disabled = false;
		}

		if (typeOption == "premium") {
			showField("pricetable_coaster_premium");
		}
		break;
	}
}

function click_typeorder_enabled(typeOption) {

	itemType = "strap";
	if (document.getElementById("keykaba").checked)
		itemType = "keykaba";
	if (document.getElementById("cleaner_rubber").checked)
		itemType = "cleaner_rubber";
	if (document.getElementById("coaster").checked)
		itemType = "coaster";

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

	// Default hidefield standard
	hideField("pricetable_strap_standard");
	hideField("pricetable_keykaba_standard");
	hideField("pricetable_cleaner_rubber_standard");
	hideField("pricetable_coaster_standard");

	// Default hidefield premium
	hideField("pricetable_strap_premium");
	hideField("pricetable_keykaba_premium");
	hideField("pricetable_cleaner_rubber_premium");
	hideField("pricetable_coaster_premium");

	switch (itemType) {
		case "strap":
		if (typeOption == "standard") {
			showField("pricetable_strap_standard");
			document.getElementById("screen1").disabled = false;
		}

		if (typeOption == "premium") {
			showField("pricetable_strap_premium");
		}
		break;
		case "keykaba":
		if (typeOption == "standard") {
			showField("pricetable_keykaba_standard");
			document.getElementById("screen1").disabled = false;
		}

		if (typeOption == "premium") {
			showField("pricetable_keykaba_premium");
		}
		break;
		case "cleaner_rubber":
		if (typeOption == "standard") {
			showField("pricetable_cleaner_rubber_standard");
			document.getElementById("screen1").disabled = true;
			document.getElementById("screen2").disabled = true;
		}

		if (typeOption == "premium") {
			showField("pricetable_cleaner_rubber_premium");
			document.getElementById("example_have").checked = true;
			document.getElementById("example_have").disabled = true;
			document.getElementById("ai_file").disabled = true;
			document.getElementById("screen1").disabled = true;
		}
		break;
		case "coaster":
		if (typeOption == "standard") {
			showField("pricetable_coaster_standard");
			document.getElementById("screen1").disabled = false;
		}

		if (typeOption == "premium") {
			showField("pricetable_coaster_premium");
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

	// Default hidefield standard
	hideField("pricetable_strap_standard");
	hideField("pricetable_keykaba_standard");
	hideField("pricetable_cleaner_rubber_standard");
	hideField("pricetable_coaster_standard");

	// Default hidefield premium
	hideField("pricetable_strap_premium");
	hideField("pricetable_keykaba_premium");
	hideField("pricetable_cleaner_rubber_premium");
	hideField("pricetable_coaster_premium");

	switch (clicked) {
		case "strap":
			// base prices
			// showField("pricetable_strap");
			// hideField("pricetable_coaster");
			// //hideField("pricetable_cleaner_print");
			// hideField("pricetable_cleaner_rubber");
			// // color option prices
			// hideField("pricetable_color_strap");
			// //hideField("pricetable_color_cleaner_print");
			// hideField("pricetable_color_coaster");
			// hideField("pricetable_color_cleaner_rubber");
			// hideField("pricetable_color_keykaba");
			// hideField("pricetable_keykaba");
			if (typeOption == "standard") {
				showField("pricetable_strap_standard");
				document.getElementById("screen1").disabled = false;
				document.getElementById("screen2").disabled = false;
			}

			if (typeOption == "premium") {
				showField("pricetable_strap_premium");
				document.getElementById("screen2").checked = true;
			}

			// document.getElementById('strap_item1').checked = 'checked';
			// document.getElementById('strap_item1').disabled = true;
			//document.getElementById('strap_item2').disabled = false;
			//document.getElementById('nashi_print').disabled = false;
			//document.getElementById('ari_print').disabled = false;
			break;

			case "coaster":
			// base prices
			// hideField("pricetable_strap");
			// showField("pricetable_coaster");
			// hideField("pricetable_color_strap");
			// //hideField("pricetable_cleaner_print");
			// hideField("pricetable_cleaner_rubber");
			// // color option prices
			// hideField("pricetable_color_coaster");
			// //hideField("pricetable_color_cleaner_print");
			// hideField("pricetable_color_cleaner_rubber");
			// hideField("pricetable_color_keykaba");
			// hideField("pricetable_keykaba");
			if (typeOption == "standard") {
				showField("pricetable_coaster_standard");
				document.getElementById("screen1").disabled = false;
				document.getElementById("screen2").disabled = false;
			}
			if (typeOption == "premium") {
				showField("pricetable_coaster_premium");
				document.getElementById("screen2").checked = true;
			}

			// document.getElementById('strap_item1').checked = 'checked';
			// document.getElementById('strap_item1').disabled = true;
			//document.getElementById('strap_item2').disabled = true;
			//document.getElementById('nashi_print').disabled = false;
			//document.getElementById('ari_print').disabled = false;
			break;

		/*case "cleaner_print":
			// base prices
			hideField("pricetable_strap");
			hideField("pricetable_coaster");
			showField("pricetable_cleaner_print");
			hideField("pricetable_cleaner_rubber");
			// color option prices
			hideField("pricetable_color_strap");
			showField("pricetable_color_cleaner_print");
			hideField("pricetable_color_cleaner_rubber");
			document.getElementById('strap_item1').checked = 'checked';
			document.getElementById('strap_item1').disabled = true;
			document.getElementById('strap_item2').disabled = true;
			break;*/

			case "cleaner_rubber":
			// base prices
			// hideField("pricetable_strap");
			// hideField("pricetable_coaster");
			// //hideField("pricetable_cleaner_print");
			// showField("pricetable_cleaner_rubber");
			// // color option prices
			// hideField("pricetable_color_strap");
			// //hideField("pricetable_color_cleaner_print");
			// hideField("pricetable_color_cleaner_rubber");
			// hideField("pricetable_color_coaster");
			// hideField("pricetable_color_keykaba");
			// hideField("pricetable_keykaba");
			if (typeOption == "standard") {
				showField("pricetable_cleaner_rubber_standard");
				document.getElementById("screen1").disabled = true;
				document.getElementById("screen2").disabled = true;
			}

			if (typeOption == "premium") {
				showField("pricetable_cleaner_rubber_premium");
				document.getElementById("screen1").checked = true;
				document.getElementById("screen1").disabled = true;
			}

			// document.getElementById('strap_item1').checked = 'checked';
			// document.getElementById('strap_item1').disabled = true;
			//document.getElementById('strap_item2').disabled = true;
			//裏面シルク印刷 Disable
			//document.getElementById('nashi_print').checked = 'checked';
			//document.getElementById('nashi_print').disabled = true;
			//document.getElementById('ari_print').disabled = true;
			break;

			case "keykaba":
			// base prices
			// hideField("pricetable_strap");
			// hideField("pricetable_coaster");
			// //hideField("pricetable_cleaner_print");
			// hideField("pricetable_cleaner_rubber");

			// color option prices
			// NON
			// hideField("pricetable_color_strap");
			// =============>

			//hideField("pricetable_color_cleaner_print");

			// NON
			// hideField("pricetable_color_cleaner_rubber");
			// hideField("pricetable_color_coaster");
			// hideField("pricetable_color_keykaba");
			// =================>

			// showField("pricetable_keykaba");
			if (typeOption == "standard") {
				showField("pricetable_keykaba_standard");
				document.getElementById("screen1").disabled = false;
				document.getElementById("screen2").disabled = false;
			}
			if (typeOption == "premium") {
				showField("pricetable_keykaba_premium");
				document.getElementById("screen2").checked = true;
			}

			// NON
			// document.getElementById('strap_item1').checked = 'checked';
			// document.getElementById('strap_item1').disabled = true;
			// ================>
			//document.getElementById('strap_item2').disabled = true;
			break;

			// case "":
			// // base prices
			// hideField("pricetable_strap");
			// hideField("pricetable_coaster");
			// //hideField("pricetable_cleaner_print");
			// showField("pricetable_cleaner_rubber");
			// // color option prices
			// hideField("pricetable_color_strap");
			// //hideField("pricetable_color_cleaner_print");
			// hideField("pricetable_color_cleaner_rubber");
			// hideField("pricetable_color_keykaba");
			// hideField("pricetable_keykaba");

			// document.getElementById('strap_item1').checked = 'checked';
			// document.getElementById('strap_item1').disabled = false;
			//document.getElementById('strap_item2').disabled = false;
			//裏面シルク印刷 Disable
			//document.getElementById('nashi_print').checked = 'checked';
			//document.getElementById('nashi_print').disabled = false;
			//document.getElementById('ari_print').disabled = false;
			break;
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
		var QA_val = "";
		if(itemQA=="premium"){
			QA_val = "_premium";
		}
		var qty = [100,200,300,500,1000,3000,5000]
		var qty2 = [0,0,300,500,1000,3000,5000]
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

		if(items=="strap"){
			for(rows=0;rows<7;rows++){
				document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(numUnitPrice["strap"][rows]["price"] * qty[rows])+"円";
				document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(numUnitPrice["strap"][rows]["price"])+"円";
				tax = Math.floor((numUnitPrice["strap"][rows]["price"] * qty[rows]) * 1.1);
				document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
			}
		}else{
			switch(itemType){
				case 'cleaner_rubber':
				console.log(itemType)	
				console.log(QA_val)	
				sum = Number(proto_charge + trace_charge);
				$('#qty_100').hide();
				$('#qty_200').hide();
					for(rows=2;rows<7;rows++){
						document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((numUnitPrice[itemType+QA_val][row1]["price"] * qty2[rows])+Number(sum+(print_charge*qty2[rows])))/qty2[rows]))+"円";
						document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((numUnitPrice[itemType+QA_val][row1]["price"] * qty2[rows])+sum+(print_charge*qty2[rows])))+"円";
						tax = Math.floor((numUnitPrice[itemType+QA_val][row1]["price"] * qty2[rows] + sum + (print_charge*qty2[rows])) * 1.1);
						document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
						row1++;
					}

				break;
				default:
				sum = Number(proto_charge + trace_charge);
				$('#qty_100').show();
				$('#qty_200').show();
				for(rows=0;rows<7;rows++){
					document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((numUnitPrice[itemType+QA_val][rows]["price"] * qty[rows])+Number(sum+(print_charge*qty[rows])))/qty[rows]))+"円";
					document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((numUnitPrice[itemType+QA_val][rows]["price"] * qty[rows])+sum+(print_charge*qty[rows])))+"円";
					tax = Math.floor((numUnitPrice[itemType+QA_val][rows]["price"] * qty[rows] + sum+(print_charge*qty[rows])) * 1.1);
					document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
				} 
				break;
			}
			
		}
	}
	function clear_valCal(){
		$('#pricefield7').val('')
		$('#pricefield8').val('')
		$('#pricefield9').val('')
		$('#pricefield10').val('')
		$('#pricefield11').val('')
		$('#pricefield12').val('')
		$('#pricefield13').val('')
		$('#div_estimatePrice').hide()
	}