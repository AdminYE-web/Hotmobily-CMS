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
    ],
    "type_b_40":[
      {"num":100, "price":358},
      {"num":200, "price":306},
      {"num":300, "price":269},
      {"num":400, "price":251},
      {"num":500, "price":213}
    ],
    "type_b_50":[
      {"num":100, "price":371},
      {"num":200, "price":319},
      {"num":300, "price":282},
      {"num":400, "price":264},
      {"num":500, "price":226}
    ],
    "type_b_60":[
      {"num":100, "price":381},
      {"num":200, "price":329},
      {"num":300, "price":293},
      {"num":400, "price":275},
      {"num":500, "price":236}
    ],
    "type_b_70":[
      {"num":100, "price":392},
      {"num":200, "price":339},
      {"num":300, "price":303},
      {"num":400, "price":285},
      {"num":500, "price":246}
    ],
    "type_c_40":[
      {"num":100, "price":430},
      {"num":200, "price":350},
      {"num":300, "price":300},
      {"num":400, "price":285},
      {"num":500, "price":250}
    ],
    "type_c_50":[
      {"num":100, "price":445},
      {"num":200, "price":365},
      {"num":300, "price":315},
      {"num":400, "price":300},
      {"num":500, "price":265}
    ],
    "type_c_60":[
      {"num":100, "price":455},
      {"num":200, "price":375},
      {"num":300, "price":325},
      {"num":400, "price":310},
      {"num":500, "price":275}
    ],
    "type_c_70":[
      {"num":100, "price":465},
      {"num":200, "price":385},
      {"num":300, "price":335},
      {"num":400, "price":320},
      {"num":500, "price":285}
    ],
    "type_d_40":[
      {"num":100, "price":456},
      {"num":200, "price":371},
      {"num":300, "price":318},
      {"num":400, "price":302},
      {"num":500, "price":265}
    ],
    "type_d_50":[
      {"num":100, "price":472},
      {"num":200, "price":387},
      {"num":300, "price":334},
      {"num":400, "price":318},
      {"num":500, "price":281}
    ],
    "type_d_60":[
      {"num":100, "price":482},
      {"num":200, "price":398},
      {"num":300, "price":345},
      {"num":400, "price":329},
      {"num":500, "price":292}
    ],
    "type_d_70":[
      {"num":100, "price":493},
      {"num":200, "price":408},
      {"num":300, "price":355},
      {"num":400, "price":339},
      {"num":500, "price":302}
    ],
    "type_e_40":[
      {"num":500, "price":265}
    ],
    "type_e_50":[
      {"num":500, "price":281}
    ],
    "type_e_60":[
      {"num":500, "price":292}
    ],
    "type_e_70":[
      {"num":500, "price":302}
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
			case "type_b":
			if(this.vno_of_order < 100){
				err_number_of_order = true;
				num = "100本";
				error = false;
			}
			break;
			case "type_c":
			if(this.vno_of_order < 100){
				err_number_of_order = true;
				num = "100本";
				error = false;
			}
			break;
			case "type_d":
			if(this.vno_of_order < 100){
				err_number_of_order = true;
				num = "100本";
				error = false;
			}
			break;
			case "type_e":
			if(this.vno_of_order < 500){
				err_number_of_order = true;
				num = "500本";
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
    else if(itemType == "type_b" && itemSize =="40") {

      if(qty>=1 && qty<=199 ) {
        type_price = numUnitPrice["type_b_40"][0]["price"] * qty;
      }
      else if(qty>=200 && qty<=299 ) {
        type_price = numUnitPrice["type_b_40"][1]["price"] * qty;
      }
      else if(qty>=300 && qty<=399 ) {
        type_price = numUnitPrice["type_b_40"][2]["price"] * qty;
      }
      else if(qty>=400 && qty<=499 ) {
        type_price = numUnitPrice["type_b_40"][3]["price"] * qty;
      }
      else if(qty>=500) {
        type_price = numUnitPrice["type_b_40"][4]["price"] * qty;
      }
    }
    else if(itemType == "type_b" && itemSize =="50") {

      if(qty>=1 && qty<=199 ) {
        type_price = numUnitPrice["type_b_50"][0]["price"] * qty;
      }
      else if(qty>=200 && qty<=299 ) {
        type_price = numUnitPrice["type_b_50"][1]["price"] * qty;
      }
      else if(qty>=300 && qty<=399 ) {
        type_price = numUnitPrice["type_b_50"][2]["price"] * qty;
      }
      else if(qty>=400 && qty<=499 ) {
        type_price = numUnitPrice["type_b_50"][3]["price"] * qty;
      }
      else if(qty>=500) {
        type_price = numUnitPrice["type_b_50"][4]["price"] * qty;
      }
    }
    else if(itemType == "type_b" && itemSize =="60") {

      if(qty>=1 && qty<=199 ) {
        type_price = numUnitPrice["type_b_60"][0]["price"] * qty;
      }
      else if(qty>=200 && qty<=299 ) {
        type_price = numUnitPrice["type_b_60"][1]["price"] * qty;
      }
      else if(qty>=300 && qty<=399 ) {
        type_price = numUnitPrice["type_b_60"][2]["price"] * qty;
      }
      else if(qty>=400 && qty<=499 ) {
        type_price = numUnitPrice["type_b_60"][3]["price"] * qty;
      }
      else if(qty>=500) {
        type_price = numUnitPrice["type_b_60"][4]["price"] * qty;
      }
    }
    else if(itemType == "type_b" && itemSize =="70") {

      if(qty>=1 && qty<=199 ) {
        type_price = numUnitPrice["type_b_70"][0]["price"] * qty;
      }
      else if(qty>=200 && qty<=299 ) {
        type_price = numUnitPrice["type_b_70"][1]["price"] * qty;
      }
      else if(qty>=300 && qty<=399 ) {
        type_price = numUnitPrice["type_b_70"][2]["price"] * qty;
      }
      else if(qty>=400 && qty<=499 ) {
        type_price = numUnitPrice["type_b_70"][3]["price"] * qty;
      }
      else if(qty>=500) {
        type_price = numUnitPrice["type_b_70"][4]["price"] * qty;
      }
    }
    else if(itemType == "type_c" && itemSize =="40") {

      if(qty>=1 && qty<=199 ) {
        type_price = numUnitPrice["type_c_40"][0]["price"] * qty;
      }
      else if(qty>=200 && qty<=299 ) {
        type_price = numUnitPrice["type_c_40"][1]["price"] * qty;
      }
      else if(qty>=300 && qty<=399 ) {
        type_price = numUnitPrice["type_c_40"][2]["price"] * qty;
      }
      else if(qty>=400 && qty<=499 ) {
        type_price = numUnitPrice["type_c_40"][3]["price"] * qty;
      }
      else if(qty>=500) {
        type_price = numUnitPrice["type_c_40"][4]["price"] * qty;
      }
    }
    else if(itemType == "type_c" && itemSize =="50") {

      if(qty>=1 && qty<=199 ) {
        type_price = numUnitPrice["type_c_50"][0]["price"] * qty;
      }
      else if(qty>=200 && qty<=299 ) {
        type_price = numUnitPrice["type_c_50"][1]["price"] * qty;
      }
      else if(qty>=300 && qty<=399 ) {
        type_price = numUnitPrice["type_c_50"][2]["price"] * qty;
      }
      else if(qty>=400 && qty<=499 ) {
        type_price = numUnitPrice["type_c_50"][3]["price"] * qty;
      }
      else if(qty>=500) {
        type_price = numUnitPrice["type_c_50"][4]["price"] * qty;
      }
    }
    else if(itemType == "type_c" && itemSize =="60") {

      if(qty>=1 && qty<=199 ) {
        type_price = numUnitPrice["type_c_60"][0]["price"] * qty;
      }
      else if(qty>=200 && qty<=299 ) {
        type_price = numUnitPrice["type_c_60"][1]["price"] * qty;
      }
      else if(qty>=300 && qty<=399 ) {
        type_price = numUnitPrice["type_c_60"][2]["price"] * qty;
      }
      else if(qty>=400 && qty<=499 ) {
        type_price = numUnitPrice["type_c_60"][3]["price"] * qty;
      }
      else if(qty>=500) {
        type_price = numUnitPrice["type_c_60"][4]["price"] * qty;
      }
    }
    else if(itemType == "type_c" && itemSize =="70") {

      if(qty>=1 && qty<=199 ) {
        type_price = numUnitPrice["type_c_70"][0]["price"] * qty;
      }
      else if(qty>=200 && qty<=299 ) {
        type_price = numUnitPrice["type_c_70"][1]["price"] * qty;
      }
      else if(qty>=300 && qty<=399 ) {
        type_price = numUnitPrice["type_c_70"][2]["price"] * qty;
      }
      else if(qty>=400 && qty<=499 ) {
        type_price = numUnitPrice["type_c_70"][3]["price"] * qty;
      }
      else if(qty>=500) {
        type_price = numUnitPrice["type_c_70"][4]["price"] * qty;
      }
    }
    else if(itemType == "type_d" && itemSize =="40") {

      if(qty>=1 && qty<=199 ) {
        type_price = numUnitPrice["type_d_40"][0]["price"] * qty;
      }
      else if(qty>=200 && qty<=299 ) {
        type_price = numUnitPrice["type_d_40"][1]["price"] * qty;
      }
      else if(qty>=300 && qty<=399 ) {
        type_price = numUnitPrice["type_d_40"][2]["price"] * qty;
      }
      else if(qty>=400 && qty<=499 ) {
        type_price = numUnitPrice["type_d_40"][3]["price"] * qty;
      }
      else if(qty>=500) {
        type_price = numUnitPrice["type_d_40"][4]["price"] * qty;
      }
    }
    else if(itemType == "type_d" && itemSize =="50") {

      if(qty>=1 && qty<=199 ) {
        type_price = numUnitPrice["type_d_50"][0]["price"] * qty;
      }
      else if(qty>=200 && qty<=299 ) {
        type_price = numUnitPrice["type_d_50"][1]["price"] * qty;
      }
      else if(qty>=300 && qty<=399 ) {
        type_price = numUnitPrice["type_d_50"][2]["price"] * qty;
      }
      else if(qty>=400 && qty<=499 ) {
        type_price = numUnitPrice["type_d_50"][3]["price"] * qty;
      }
      else if(qty>=500) {
        type_price = numUnitPrice["type_d_50"][4]["price"] * qty;
      }
    }
    else if(itemType == "type_d" && itemSize =="60") {

      if(qty>=1 && qty<=199 ) {
        type_price = numUnitPrice["type_d_60"][0]["price"] * qty;
      }
      else if(qty>=200 && qty<=299 ) {
        type_price = numUnitPrice["type_d_60"][1]["price"] * qty;
      }
      else if(qty>=300 && qty<=399 ) {
        type_price = numUnitPrice["type_d_60"][2]["price"] * qty;
      }
      else if(qty>=400 && qty<=499 ) {
        type_price = numUnitPrice["type_d_60"][3]["price"] * qty;
      }
      else if(qty>=500) {
        type_price = numUnitPrice["type_d_60"][4]["price"] * qty;
      }
    }
    else if(itemType == "type_d" && itemSize =="70") {
      if(qty>=1 && qty<=199 ) {
        type_price = numUnitPrice["type_d_70"][0]["price"] * qty;
      }
      else if(qty>=200 && qty<=299 ) {
        type_price = numUnitPrice["type_d_70"][1]["price"] * qty;
      }
      else if(qty>=300 && qty<=399 ) {
        type_price = numUnitPrice["type_d_70"][2]["price"] * qty;
      }
      else if(qty>=400 && qty<=499 ) {
        type_price = numUnitPrice["type_d_70"][3]["price"] * qty;
      }
      else if(qty>=500) {
        type_price = numUnitPrice["type_d_70"][4]["price"] * qty;
      }
    }
    else if(itemType == "type_e" && itemSize =="40") {
      if(qty>=500) {
        type_price = numUnitPrice["type_e_40"][0]["price"] * qty;
      }
    }
    else if(itemType == "type_e" && itemSize =="50") {
      if(qty>=500) {
        type_price = numUnitPrice["type_e_50"][0]["price"] * qty;
      }
    }
    else if(itemType == "type_e" && itemSize =="60") {
      if(qty>=500) {
        type_price = numUnitPrice["type_e_60"][0]["price"] * qty;
      }
    }
    else if(itemType == "type_e" && itemSize =="70") {
      if(qty>=500) {
        type_price = numUnitPrice["type_e_70"][0]["price"] * qty;
      }
    }

		document.getElementById('pricefield7').value = formatMoney(type_price);

		// var send_proto = getSendProto();
		// var data_file = getFileFormat();
		// var print_umu = getPrint();
    //
		// if(itemQA == "standard"){
		// 	if(send_proto == "2"){
		// 		proto_charge = 12500;
		// 	}
		// 	if(data_file == "other_file"){
		// 		trace_charge = 8000;
		// 	}
		// 	if(print_umu == "screen"){
		// 		print_charge = this.vno_of_order * 20;
		// 	}
		// }

		// before_tax = strap_price + proto_charge + trace_charge + print_charge;
	  //   tax = Math.floor(before_tax * 0.08);
	  //   total = before_tax + tax;

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

    console.log(getItemSize());

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
    else if(itemType == "type_b" && itemSize == "40") {
				// Default Background White
				document.getElementById('PDTB4_1').style.background = "";
				document.getElementById('PDTB4_2').style.background = "";
				document.getElementById('PDTB4_3').style.background = "";
				document.getElementById('PDTB4_4').style.background = "";
				document.getElementById('PDTB4_5').style.background = "";

				if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('PDTB4_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('PDTB4_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 399) {
					document.getElementById('PDTB4_3').style.background = "pink";
				} else if (this.vno_of_order >= 400 && this.vno_of_order <= 499) {
					document.getElementById('PDTB4_4').style.background = "pink";
				} else {
					document.getElementById('PDTB4_5').style.background = "pink";
				}
		}
    else if(itemType == "type_b" && itemSize == "50") {
				// Default Background White
				document.getElementById('PDTB5_1').style.background = "";
				document.getElementById('PDTB5_2').style.background = "";
				document.getElementById('PDTB5_3').style.background = "";
				document.getElementById('PDTB5_4').style.background = "";
				document.getElementById('PDTB5_5').style.background = "";

				if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('PDTB5_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('PDTB5_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 399) {
					document.getElementById('PDTB5_3').style.background = "pink";
				} else if (this.vno_of_order >= 400 && this.vno_of_order <= 499) {
					document.getElementById('PDTB5_4').style.background = "pink";
				} else {
					document.getElementById('PDTB5_5').style.background = "pink";
				}
		}
    else if(itemType == "type_b" && itemSize == "60") {
				// Default Background White
				document.getElementById('PDTB6_1').style.background = "";
				document.getElementById('PDTB6_2').style.background = "";
				document.getElementById('PDTB6_3').style.background = "";
				document.getElementById('PDTB6_4').style.background = "";
				document.getElementById('PDTB6_5').style.background = "";

				if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('PDTB6_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('PDTB6_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 399) {
					document.getElementById('PDTB6_3').style.background = "pink";
				} else if (this.vno_of_order >= 400 && this.vno_of_order <= 499) {
					document.getElementById('PDTB6_4').style.background = "pink";
				} else {
					document.getElementById('PDTB6_5').style.background = "pink";
				}
		}
    else if(itemType == "type_b" && itemSize == "70") {
				// Default Background White
				document.getElementById('PDTB7_1').style.background = "";
				document.getElementById('PDTB7_2').style.background = "";
				document.getElementById('PDTB7_3').style.background = "";
				document.getElementById('PDTB7_4').style.background = "";
				document.getElementById('PDTB7_5').style.background = "";

				if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('PDTB7_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('PDTB7_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 399) {
					document.getElementById('PDTB7_3').style.background = "pink";
				} else if (this.vno_of_order >= 400 && this.vno_of_order <= 499) {
					document.getElementById('PDTB7_4').style.background = "pink";
				} else {
					document.getElementById('PDTB7_5').style.background = "pink";
				}
		}
    else if(itemType == "type_c" && itemSize == "40") {
				// Default Background White
				document.getElementById('PDTC4_1').style.background = "";
				document.getElementById('PDTC4_2').style.background = "";
				document.getElementById('PDTC4_3').style.background = "";
				document.getElementById('PDTC4_4').style.background = "";
				document.getElementById('PDTC4_5').style.background = "";

				if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('PDTC4_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('PDTC4_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 399) {
					document.getElementById('PDTC4_3').style.background = "pink";
				} else if (this.vno_of_order >= 400 && this.vno_of_order <= 499) {
					document.getElementById('PDTC4_4').style.background = "pink";
				} else {
					document.getElementById('PDTC4_5').style.background = "pink";
				}
		}
    else if(itemType == "type_c" && itemSize == "50") {
				// Default Background White
				document.getElementById('PDTC5_1').style.background = "";
				document.getElementById('PDTC5_2').style.background = "";
				document.getElementById('PDTC5_3').style.background = "";
				document.getElementById('PDTC5_4').style.background = "";
				document.getElementById('PDTC5_5').style.background = "";

				if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('PDTC5_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('PDTC5_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 399) {
					document.getElementById('PDTC5_3').style.background = "pink";
				} else if (this.vno_of_order >= 400 && this.vno_of_order <= 499) {
					document.getElementById('PDTC5_4').style.background = "pink";
				} else {
					document.getElementById('PDTC5_5').style.background = "pink";
				}
		}
    else if(itemType == "type_c" && itemSize == "60") {
				// Default Background White
				document.getElementById('PDTC6_1').style.background = "";
				document.getElementById('PDTC6_2').style.background = "";
				document.getElementById('PDTC6_3').style.background = "";
				document.getElementById('PDTC6_4').style.background = "";
				document.getElementById('PDTC6_5').style.background = "";

				if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('PDTC6_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('PDTC6_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 399) {
					document.getElementById('PDTC6_3').style.background = "pink";
				} else if (this.vno_of_order >= 400 && this.vno_of_order <= 499) {
					document.getElementById('PDTC6_4').style.background = "pink";
				} else {
					document.getElementById('PDTC6_5').style.background = "pink";
				}
		}
    else if(itemType == "type_c" && itemSize == "70") {
				// Default Background White
				document.getElementById('PDTC7_1').style.background = "";
				document.getElementById('PDTC7_2').style.background = "";
				document.getElementById('PDTC7_3').style.background = "";
				document.getElementById('PDTC7_4').style.background = "";
				document.getElementById('PDTC7_5').style.background = "";

				if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('PDTC7_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('PDTC7_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 399) {
					document.getElementById('PDTC7_3').style.background = "pink";
				} else if (this.vno_of_order >= 400 && this.vno_of_order <= 499) {
					document.getElementById('PDTC7_4').style.background = "pink";
				} else {
					document.getElementById('PDTC7_5').style.background = "pink";
				}
		}
    else if(itemType == "type_d" && itemSize == "40") {
				// Default Background White
				document.getElementById('PDTD4_1').style.background = "";
				document.getElementById('PDTD4_2').style.background = "";
				document.getElementById('PDTD4_3').style.background = "";
				document.getElementById('PDTD4_4').style.background = "";
				document.getElementById('PDTD4_5').style.background = "";

				if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('PDTD4_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('PDTD4_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 399) {
					document.getElementById('PDTD4_3').style.background = "pink";
				} else if (this.vno_of_order >= 400 && this.vno_of_order <= 499) {
					document.getElementById('PDTD4_4').style.background = "pink";
				} else {
					document.getElementById('PDTD4_5').style.background = "pink";
				}
		}
    else if(itemType == "type_d" && itemSize == "50") {
				// Default Background White
				document.getElementById('PDTD5_1').style.background = "";
				document.getElementById('PDTD5_2').style.background = "";
				document.getElementById('PDTD5_3').style.background = "";
				document.getElementById('PDTD5_4').style.background = "";
				document.getElementById('PDTD5_5').style.background = "";

				if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('PDTD5_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('PDTD5_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 399) {
					document.getElementById('PDTD5_3').style.background = "pink";
				} else if (this.vno_of_order >= 400 && this.vno_of_order <= 499) {
					document.getElementById('PDTD5_4').style.background = "pink";
				} else {
					document.getElementById('PDTD5_5').style.background = "pink";
				}
		}
    else if(itemType == "type_d" && itemSize == "60") {
				// Default Background White
				document.getElementById('PDTD6_1').style.background = "";
				document.getElementById('PDTD6_2').style.background = "";
				document.getElementById('PDTD6_3').style.background = "";
				document.getElementById('PDTD6_4').style.background = "";
				document.getElementById('PDTD6_5').style.background = "";

				if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('PDTD6_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('PDTD6_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 399) {
					document.getElementById('PDTD6_3').style.background = "pink";
				} else if (this.vno_of_order >= 400 && this.vno_of_order <= 499) {
					document.getElementById('PDTD6_4').style.background = "pink";
				} else {
					document.getElementById('PDTD6_5').style.background = "pink";
				}
		}
    else if(itemType == "type_d" && itemSize == "70") {
				// Default Background White
				document.getElementById('PDTD7_1').style.background = "";
				document.getElementById('PDTD7_2').style.background = "";
				document.getElementById('PDTD7_3').style.background = "";
				document.getElementById('PDTD7_4').style.background = "";
				document.getElementById('PDTD7_5').style.background = "";

				if (this.vno_of_order >= 100 && this.vno_of_order <= 199) {
					document.getElementById('PDTD7_1').style.background = "pink";
				} else if (this.vno_of_order >= 200 && this.vno_of_order <= 299) {
					document.getElementById('PDTD7_2').style.background = "pink";
				} else if (this.vno_of_order >= 300 && this.vno_of_order <= 399) {
					document.getElementById('PDTD7_3').style.background = "pink";
				} else if (this.vno_of_order >= 400 && this.vno_of_order <= 499) {
					document.getElementById('PDTD7_4').style.background = "pink";
				} else {
					document.getElementById('PDTD7_5').style.background = "pink";
				}
		}
    else if(itemType == "type_e" && itemSize == "40") {
        // Default Background White
        document.getElementById('PDTE4_5').style.background = "";

        if (this.vno_of_order >= 500) {
          document.getElementById('PDTE4_5').style.background = "pink";
        }
    }
    else if(itemType == "type_e" && itemSize == "50") {
        // Default Background White
        document.getElementById('PDTE5_5').style.background = "";

        if (this.vno_of_order >= 500) {
          document.getElementById('PDTE5_5').style.background = "pink";
        }
    }
    else if(itemType == "type_e" && itemSize == "60") {
        // Default Background White
        document.getElementById('PDTE6_5').style.background = "";

        if (this.vno_of_order >= 500) {
          document.getElementById('PDTE6_5').style.background = "pink";
        }
    }
    else if(itemType == "type_e" && itemSize == "70") {
        // Default Background White
        document.getElementById('PDTE7_5').style.background = "";

        if (this.vno_of_order >= 500) {
          document.getElementById('PDTE7_5').style.background = "pink";
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
	if (document.getElementById("type_b").checked)
		itemType = "type_b";
	if (document.getElementById("type_c").checked)
		itemType = "type_c";
	if (document.getElementById("type_d").checked)
		itemType = "type_d";
  if (document.getElementById("type_e").checked)
  	itemType = "type_e";

	// (C). Example have
	// document.getElementById("example_have").checked = true;
	// document.getElementById("example_nothave").disabled = true;
	// document.getElementById("example_have").disabled = true;

	hideField("type_a_40");
  hideField("type_a_50");
  hideField("type_a_60");
  hideField("type_a_70");
  hideField("type_b_40");
  hideField("type_b_50");
  hideField("type_b_60");
  hideField("type_b_70");
  hideField("type_c_40");
  hideField("type_c_50");
  hideField("type_c_60");
  hideField("type_c_70");
  hideField("type_d_40");
  hideField("type_d_50");
  hideField("type_d_60");
  hideField("type_d_70");
  hideField("type_e_40");
  hideField("type_e_50");
  hideField("type_e_60");
  hideField("type_e_70");

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
    case "type_b":
		if (sizeOption == "40") {
			showField("type_b_40");
		}
		else if (sizeOption == "50") {
			showField("type_b_50");
		}
    else if (sizeOption == "60") {
			showField("type_b_60");
		}
    else if (sizeOption == "70") {
			showField("type_b_70");
		}
		break;
    case "type_c":
		if (sizeOption == "40") {
			showField("type_c_40");
		}
		else if (sizeOption == "50") {
			showField("type_c_50");
		}
    else if (sizeOption == "60") {
			showField("type_c_60");
		}
    else if (sizeOption == "70") {
			showField("type_c_70");
		}
		break;
    case "type_d":
		if (sizeOption == "40") {
			showField("type_d_40");
		}
		else if (sizeOption == "50") {
			showField("type_d_50");
		}
    else if (sizeOption == "60") {
			showField("type_d_60");
		}
    else if (sizeOption == "70") {
			showField("type_d_70");
		}
		break;
    case "type_e":
		if (sizeOption == "40") {
			showField("type_e_40");
		}
		else if (sizeOption == "50") {
			showField("type_e_50");
		}
    else if (sizeOption == "60") {
			showField("type_e_60");
		}
    else if (sizeOption == "70") {
			showField("type_e_70");
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
  hideField("type_b_40");
  hideField("type_b_50");
  hideField("type_b_60");
  hideField("type_b_70");
  hideField("type_c_40");
  hideField("type_c_50");
  hideField("type_c_60");
  hideField("type_c_70");
  hideField("type_d_40");
  hideField("type_d_50");
  hideField("type_d_60");
  hideField("type_d_70");
  hideField("type_e_40");
  hideField("type_e_50");
  hideField("type_e_60");
  hideField("type_e_70");

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
      case "type_b":
      if (typeOption == "40") {
        showField("type_b_40");
      }
      else if (typeOption == "50") {
        showField("type_b_50");
      }
      else if (typeOption == "60") {
        showField("type_b_60");
      }
      else if (typeOption == "70") {
        showField("type_b_70");
      }
      break;
      case "type_c":
      if (typeOption == "40") {
        showField("type_c_40");
      }
      else if (typeOption == "50") {
        showField("type_c_50");
      }
      else if (typeOption == "60") {
        showField("type_c_60");
      }
      else if (typeOption == "70") {
        showField("type_c_70");
      }
      break;
      case "type_d":
      if (typeOption == "40") {
        showField("type_d_40");
      }
      else if (typeOption == "50") {
        showField("type_d_50");
      }
      else if (typeOption == "60") {
        showField("type_d_60");
      }
      else if (typeOption == "70") {
        showField("type_d_70");
      }
      break;
      case "type_e":
      if (typeOption == "40") {
        showField("type_e_40");
      }
      else if (typeOption == "50") {
        showField("type_e_50");
      }
      else if (typeOption == "60") {
        showField("type_e_60");
      }
      else if (typeOption == "70") {
        showField("type_e_70");
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
  hideField("type_b_40");
  hideField("type_b_50");
  hideField("type_b_60");
  hideField("type_b_70");
  hideField("type_c_40");
  hideField("type_c_50");
  hideField("type_c_60");
  hideField("type_c_70");
  hideField("type_d_40");
  hideField("type_d_50");
  hideField("type_d_60");
  hideField("type_d_70");
  hideField("type_e_40");
  hideField("type_e_50");
  hideField("type_e_60");
  hideField("type_e_70");
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
		switch(itemType){
			case 'type_a':
			case 'type_b':
			case 'type_c':
			case 'type_d':
				sum = Number(proto_charge);
				$('#qty_100').show();$('#qty_200').show();
				$('#qty_300').show();$('#qty_400').show();
				for(rows=0;rows<5;rows++){
					document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((numUnitPrice[itemType+"_"+itemSize][rows]["price"] * qty[rows])+sum)/qty[rows]))+"円";
					document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((numUnitPrice[itemType+"_"+itemSize][rows]["price"] * qty[rows])+sum))+"円";
					tax = Math.floor((numUnitPrice[itemType+"_"+itemSize][rows]["price"] * qty[rows] + sum) * 1.1);
					document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
				}
			break;
			case 'type_e':
				sum = Number(proto_charge);
				$('#qty_100').hide();$('#qty_200').hide();
				$('#qty_300').hide();$('#qty_400').hide();
				for(rows=4;rows<5;rows++){
					document.getElementById( 'price_unit_' + rows ).innerHTML = formatMoney(Math.ceil(((numUnitPrice[itemType+"_"+itemSize][row1]["price"] * qty2[rows])+sum)/qty2[rows]))+"円";
					document.getElementById( 'price_basic_' + rows ).innerHTML = formatMoney(Number((numUnitPrice[itemType+"_"+itemSize][row1]["price"] * qty2[rows])+sum))+"円";
					tax = Math.floor((numUnitPrice[itemType+"_"+itemSize][row1]["price"] * qty2[rows] + sum) * 1.1);
					document.getElementById( 'price_total_' + rows ).innerHTML = formatMoney(tax)+"円";
					row1++;
				}
			break;
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