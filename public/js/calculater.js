/**********************************
* Description: Javascript for calculation
* CreateDate: Jul.22.2010
* UpdateDate: Feb.01.2013
**********************************/
//Delete 2012/04/24 Sineenad R. Start
	// 個数単価データ


// 個数単価データ
var numUnitPrice = {
			// :: Strap data1 ::		
			"strap1":[
			{"num":100, "price":450},
			{"num":300, "price":365},
			{"num":500, "price":290},
			{"num":1000, "price":232},
			{"num":3000, "price":185},
			{"num":5000, "price":140}
			],
			"strap1DefPrice":111,

			// :: Strap data2 ::		
			"strap2":[
			{"num":100, "price":675},
			{"num":300, "price":548},
			{"num":500, "price":435},
			{"num":1000, "price":348},
			{"num":3000, "price":278},
			{"num":5000, "price":210}
			],
			"strap2DefPrice":167,
			// :: Coaster data ::

			"coaster":[
			{"num":100, "price":550},
			{"num":300, "price":460},
			{"num":500, "price":350},
			{"num":1000, "price":280},
			{"num":3000, "price":220},
			{"num":5000, "price":169}
			],
			"coasterDefPrice":150,
			/*xxx*/						
			"cleaner_rubber":[ 
			{"num":300, "price":385},
			{"num":500, "price":349},
			{"num":1000, "price":279},
			{"num":3000, "price":189},
			{"num":5000, "price":162}
			],
			"cleaner_rubberDefPrice":149,
			"keykaba":[
			{"num":100, "price":565},
			{"num":300, "price":429},
			{"num":500, "price":303},
			{"num":1000, "price":237},
			{"num":3000, "price":189},
			{"num":5000, "price":154}
			],
			"keykabaDefPrice":135
		};
// 色数単価データ
	var colUnitPrice = {
		// Strap data1
		"strap1":[
			{"num":100, "price":39},
			{"num":300, "price":33},
			{"num":500, "price":26},
			{"num":1000, "price":20},
			{"num":3000, "price":16},
			{"num":5000, "price":12}
		],
		"strap1DefPrice":8,
		// Strap data2
		"strap2":[
			{"num":100, "price":39},
			{"num":300, "price":33},
			{"num":500, "price":26},
			{"num":1000, "price":20},
			{"num":3000, "price":16},
			{"num":5000, "price":12}
		],
		"strap2DefPrice":8,
		// Coaster
		"coaster":[
			{"num":100, "price":42},
			{"num":300, "price":33},
			{"num":500, "price":25},
			{"num":1000, "price":20},
			{"num":3000, "price":16},
			{"num":5000, "price":12}
		],
		"coasterDefPrice":8,

		// Mobile cleaner rubber
		
		/*xxx*/
		"cleaner_rubber":[
			{"num":300, "price":30},
			{"num":500, "price":25},
			{"num":1000, "price":20},
			{"num":3000, "price":16},
			{"num":5000, "price":12}
		],
		"cleaner_rubberDefPrice":8,
		"keykaba":[
			{"num":100, "price":42},
			{"num":300, "price":33},
			{"num":500, "price":25},
			{"num":1000, "price":20},
			{"num":3000, "price":16},
			{"num":5000, "price":12}
		],
		"keykabaDefPrice":8
	

	};

	var typeOrder = "";
	var itemPCS = "";
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
		// ラジオ選択値
		this.typeOrder = document.getElementsByName('ItemType');
		this.itemPCS = document.getElementsByName('ItemPCS');
		this.send_proto = document.getElementsByName('SendPrototype');
		this.data_file = document.getElementsByName('DeFormat');
		this.print_umu = document.getElementsByName('PrintUmu');

		// 入力値
		this.vcolor = document.getElementById('num_colors').value;
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
		// 単価データ取得
		this.unitData = numUnitPrice[type];
		// 単価データがなかった場合
		if (this.unitData == undefined) {
			return false;
		}

		// 単価
		var unitPrice = 0;
		// 単価色
		var unitColorPrice = 0;

		// 未満データを探す
		for (var i = 0, iMax = this.unitData.length; i < iMax; i++) {

			// 個数がデータ内の単価個数より大きいかチェック
			if (this.vno_of_order >= this.unitData[i].num) {
				// 大きかったら次の個数へ
				continue;
			} 

			// 購入個数が単価個数以下の場合はこのロジック
			unitPrice = this.unitData[i].price;
			break;
		}

		// 一定値より大きい場合はデフォルト値を適用する
		if (unitPrice <= 0) {
			unitPrice = numUnitPrice[type + "DefPrice"];
			if (unitPrice == undefined) {
				return false;
			}
		}

		// ４色以上なら色単価をプラス
		if(this.vcolor > 3) {
			// 色単価データ取得
			this.colorData = colUnitPrice[type];

			// 単価データがなかった場合
			if (this.colorData == undefined) {
				return false;
			}

			// 未満データを探す
			for (var i = 0, iMax = this.colorData.length; i < iMax; i++) {
				// 個数がデータ内の単価個数より大きいかチェック
				if (this.vno_of_order >= this.colorData[i].num) {
					// 大きかったら次の個数へ
					continue;
				}
	
				// 購入個数が単価個数以下の場合はこのロジック
				unitColorPrice = this.colorData[i].price;
				break;
			}
	
			// 一定値より大きい場合はデフォルト値を適用する
			if (unitColorPrice <= 0) {
				unitColorPrice = colUnitPrice[type + "DefPrice"];
				if (unitColorPrice == undefined) {
					return false;
				}
			}
		}
		// 色数 * 単価
		unitColorPrice = unitColorPrice * (this.vcolor - 3);
		ret = unitPrice + unitColorPrice;
		return ret;
	}

	function getPrice(){
		// オブジェクトの取得
		getObjects();
		// 単価テーブルの色クリア
		clearColor();
		// 入力チェック

		

		if(validateCheck()) {
			// 単価の取得
			var priceVal = getUnitPriceData();
			// 単価テーブルの色変更
			setColor(getItemType());
			// 計算
			calc(getItemType());
		}

		console.log('Yeah, Im fine');
	}



	function getItemType() {
			var str = "";
			for(var i=0; i<typeOrder.length; i++){
				if (typeOrder[i].checked) {
					str = typeOrder[i].value;
					break;
				}
			}
			return str;
	}
	
	function getStrapPCS() {
			var str = "";
			for(var i=0; i<itemPCS.length; i++){
				if (itemPCS[i].checked) {
					str = itemPCS[i].value;
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
		if(this.vcolor == '' || !isNumber(this.vcolor) || this.vcolor > 8 || this.vcolor < 1){
			document.getElementById('err_num_colors').innerHTML = "<span style=color:red;>※入力に誤りがあります。1～8の半角英数字で再度ご入力下さい。</span>";
			error = false;
		}
		if(this.vno_of_order == '' || !isNumber(this.vno_of_order)) {
			document.getElementById('err_no_of_order').innerHTML = "<span style=color:red;>※入力に誤りがあります。0?9の半角英数字で再度ご入力下さい。</span>";
			error = false;
		}
		if(getProtoType() == 'non' && this.vno_of_order > 499 ) {
			document.getElementById('err_send_prototype_no3').innerHTML = "<span style=color:red;>※500本以上のご注文では、実物の確認をお願いしています。</span>";
			error = false;
		}
		if(getProtoType() == 'non' && this.vno_of_order > 499 ) {
			document.getElementById('err_send_prototype_no3').innerHTML = "<span style=color:red;>※500本以上のご注文では、実物の確認をお願いしています。</span>";
			error = false;
		}

	

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
			case "coaster":
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
			case "keykaba":
				if(this.vno_of_order < 100){
					err_number_of_order = true;
					num = "100枚";
					error = false;
				}
				break;

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
		document.getElementById('err_num_colors').innerHTML = "";
		document.getElementById('err_no_of_order').innerHTML = "";
		document.getElementById('err_no_of_order').innerHTML = "";
		document.getElementById('err_send_prototype_no3').innerHTML = "";
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
	

		if (this.vno_of_order >= 50 && this.vno_of_order <= 299) {
			basic_charge = 7000;		
		} else {
			basic_charge = 5000;	
		}
		
		if( getStrapPCS() == "2" ){
			mold_charge = 28000;
		} else {
				if(getItemType() == "coaster") {
					mold_charge = 17000;
				} else {
						if (getItemType() == "keykaba"){
							mold_charge = 28000;
						}
							 else {
							mold_charge = 14000;
						}
				}
				
		if (getItemType() == "cleaner_rubber"){
			mold_charge = 26500;
		}
				}

		if(getSendProto() == "pro" ){
			proto_shipping_charge = 0;/*xxx*/
			//proto_shipping_charge = 4500;/*xxx*/
		}

		if( getFileFormat() == "other_file" ){
			//trace_charge = 3000;
			//trace_charge = 10000; change on 06 Dec 2013
			trace_charge = 0;
		}
	
		if( getPrint() == "ari_print" ){
			print_charge = 7000;
			silk_print = this.vno_of_order * 24
		}
		///campaign用///
		/*switch (document.getElementById('campaign_no').value) {
		case "2":
			alert("３９キャンペーンは２０１０年３月９日を持ちまして終了致しました。");
		    break;
		default:
			break;
		}*/

	    strap_price = this.vno_of_order * getUnitPriceData();

		shipping_charge = 4500;

	    /*before_tax = basic_charge + mold_charge + proto_shipping_charge +
				     trace_charge + strap_price + shipping_charge;*/
		before_tax = basic_charge + mold_charge + proto_shipping_charge +
			 trace_charge + strap_price + shipping_charge + silk_print + print_charge ;
	    //tax = before_tax * 0.08;
	    tax = Math.floor(before_tax * 0.08);
	    total = before_tax + tax;
	    document.getElementById('pricefield1').value = formatMoney(basic_charge);
	    document.getElementById('pricefield2').value = formatMoney(mold_charge);
	    document.getElementById('pricefield3').value = formatMoney(proto_shipping_charge);
	    document.getElementById('pricefield4').value = formatMoney(trace_charge);
	    document.getElementById('pricefield5').value = formatMoney(order_pcs);
	    document.getElementById('pricefield6').value = formatMoney(unit_price);
	    document.getElementById('pricefield7').value = formatMoney(strap_price);
	    document.getElementById('pricefield8').value = formatMoney(shipping_charge);
	    document.getElementById('pricefield9').value = formatMoney(before_tax);
	    document.getElementById('pricefield10').value = formatMoney(tax);
	    document.getElementById('pricefield11').value = formatMoney(total);
	    document.getElementById('pricefield12').value = formatMoney(print_charge);
	    document.getElementById('pricefield13').value = formatMoney(silk_print);
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
		var itemPCS = getItemPCS();

		var itemType = getItemType();

		switch(itemType) {
			case "strap":
				// Base color
				if (this.vno_of_order < 300 && itemPCS == "1" ){
						document.getElementById('ST_1').style.background = "pink";
				} else if (this.vno_of_order < 300 && itemPCS == "2"){
						document.getElementById('ST_7').style.background = "pink";
				} else if (this.vno_of_order < 500 && itemPCS == "1" ){
						document.getElementById('ST_2').style.background = "pink";
				} else if (this.vno_of_order < 500 && itemPCS == "2"){
						document.getElementById('ST_8').style.background = "pink";
				} else if (this.vno_of_order < 1000 && itemPCS == "1" ){
						document.getElementById('ST_3').style.background = "pink";
				} else if (this.vno_of_order < 1000 && itemPCS == "2" ){
						document.getElementById('ST_9').style.background = "pink";
				} else if (this.vno_of_order < 3000 && itemPCS == "1" ){
						document.getElementById('ST_4').style.background = "pink";
				} else if (this.vno_of_order < 3000 && itemPCS == "2"){
						document.getElementById('ST_10').style.background = "pink";
				} else if (this.vno_of_order < 5000 && itemPCS == "1" ){
						document.getElementById('ST_5').style.background = "pink";
				} else if (this.vno_of_order < 5000 && itemPCS == "2" ){
						document.getElementById('ST_11').style.background = "pink";
				} else if (this.vno_of_order >= 5000 && itemPCS == "1" ){
						document.getElementById('ST_6').style.background = "pink";
				} else if (this.vno_of_order >= 5000 && itemPCS == "2" ){
						document.getElementById('ST_12').style.background = "pink";
				}

				// Option clor
				if (this.vno_of_order >= 100 && this.vno_of_order < 300) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'ST_C1' ).style.background = "pink";
						}
					}
				} else if (this.vno_of_order >= 300 && this.vno_of_order < 500) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'ST_C2' ).style.background = "pink";
						}
					}
				} else if (this.vno_of_order >= 500 && this.vno_of_order < 1000) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'ST_C3' ).style.background = "pink";
						}
					}
				} else if (this.vno_of_order >= 1000 && this.vno_of_order < 3000) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'ST_C4' ).style.background = "pink";
						}
					}
				} else if (this.vno_of_order >= 3000 && this.vno_of_order < 5000) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'ST_C5' ).style.background = "pink";
						}
					}
				} else if (this.vno_of_order >= 5000) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'ST_C6' ).style.background = "pink";
						}
					}
				}
			break;

			case "coaster":
				// Base color
				if (this.vno_of_order < 300){
					document.getElementById('CS_1').style.background = "pink";
				} else if (this.vno_of_order < 500){
					document.getElementById('CS_2').style.background = "pink";
				} else if (this.vno_of_order < 1000){
					document.getElementById('CS_3').style.background = "pink";
				} else if (this.vno_of_order < 3000){
					document.getElementById('CS_4').style.background = "pink";
				} else if (this.vno_of_order < 5000){
					document.getElementById('CS_5').style.background = "pink";
				} else if (this.vno_of_order >= 5000){
					document.getElementById('CS_6').style.background = "pink";
				}

				// Option clor
				if (this.vno_of_order >= 100 && this.vno_of_order < 300) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'CS_C1' ).style.background = "pink";
						}
					}
				} else if (this.vno_of_order >= 300 && this.vno_of_order < 500) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'CS_C2' ).style.background = "pink";
						}
					}
				} else if (this.vno_of_order >= 500 && this.vno_of_order < 1000) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'CS_C3' ).style.background = "pink";
						}
					}
				} else if (this.vno_of_order >= 1000 && this.vno_of_order < 3000) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'CS_C4' ).style.background = "pink";
						}
					}
				} else if (this.vno_of_order >= 3000 && this.vno_of_order < 5000) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'CS_C5' ).style.background = "pink";
						}
					}
				} else if (this.vno_of_order >= 5000) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'CS_C6' ).style.background = "pink";
						}
					}
				}
			break;
			
			case "cleaner_rubber":
				// Base color xxx
				if (this.vno_of_order < 500){
					document.getElementById('CR_1').style.background = "pink";
				} else if (this.vno_of_order < 1000){
					document.getElementById('CR_2').style.background = "pink";
				} else if (this.vno_of_order < 3000){
					document.getElementById('CR_3').style.background = "pink";
				} else if (this.vno_of_order < 5000){
					document.getElementById('CR_4').style.background = "pink";
				} else if (this.vno_of_order >= 5000){
					document.getElementById('CR_5').style.background = "pink";
				} 

				// Option clor xxx
				if (this.vno_of_order < 500) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'CL_R1' ).style.background = "pink";
						}
					}
				} else if (this.vno_of_order >= 500 && this.vno_of_order < 1000) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'CL_R2' ).style.background = "pink";
						}
					}
				} else if (this.vno_of_order >= 1000 && this.vno_of_order < 3000) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'CL_R3' ).style.background = "pink";
						}
					}
				} else if (this.vno_of_order >= 3000 && this.vno_of_order < 5000) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'CL_R4' ).style.background = "pink";
						}
					}
				} else if (this.vno_of_order >= 5000) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'CL_R5' ).style.background = "pink";
						}
					}
				}
			break;


			case "keykaba":
				// Base color
				if (this.vno_of_order < 300  ){
						document.getElementById('KB_1').style.background = "pink";
				} else if (this.vno_of_order < 500  ){
						document.getElementById('KB_2').style.background = "pink";
				} else if (this.vno_of_order < 1000  ){
						document.getElementById('KB_3').style.background = "pink";
				} else if (this.vno_of_order < 3000  ){
						document.getElementById('KB_4').style.background = "pink";
				} else if (this.vno_of_order < 5000  ){
						document.getElementById('KB_5').style.background = "pink";
				} else if (this.vno_of_order >= 5000  ){
						document.getElementById('KB_6').style.background = "pink";
				}

				// Option clor
				if (this.vno_of_order >= 100 && this.vno_of_order < 300) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'KB_R1' ).style.background = "pink";
						}
					}
				} else if (this.vno_of_order >= 300 && this.vno_of_order < 500) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'KB_R2' ).style.background = "pink";
						}
					}
				} else if (this.vno_of_order >= 500 && this.vno_of_order < 1000) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'KB_R3' ).style.background = "pink";
						}
					}
				} else if (this.vno_of_order >= 1000 && this.vno_of_order < 3000) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'KB_R4' ).style.background = "pink";
						}
					}
				} else if (this.vno_of_order >= 3000 && this.vno_of_order < 5000) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'KB_R5' ).style.background = "pink";
						}
					}
				} else if (this.vno_of_order >= 5000) {
					for(var i = 4; i <= 8; i ++){
						if(vcolor.value == i){
							document.getElementById( (i - 3) + 'KB_R6' ).style.background = "pink";
						}
					}
				}
			break;
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

function getItemPCS() {
		var itemPCS = document.getElementsByName('ItemPCS');
		var str = "";
		for(var i=0; i<itemPCS.length; i++){
			if (itemPCS[i].checked) {
				str = itemPCS[i].value;
				break;
			}
		}
		return str;
}

function getProtoType(){
		// 試作品の送付
		var send_proto = document.getElementsByName('SendPrototype');
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
	for( var i=1; i<=12; i++ ){
		document.getElementById( 'ST_' + i ).style.background = "white";  //strap
		if( i < 7 ){
			document.getElementById( 'CS_' + i ).style.background = "white";  //coaster
			document.getElementById( 'KB_' + i ).style.background = "white";  //keykaba
			
		}
		if( i < 6){
			//console.log('CR_' + i +'<<<<<<<<<<<<<<');
			document.getElementById( 'CR_' + i ).style.background = "white";  //cleaner rubber
		}
		for( var j = 1; j <= 5; j++ ) {/*xxx*/
			if( i < 6 ) {
				//console.log(j + 'CL_R' + i +'<<<<<<<<<<<<<<');
				document.getElementById( j + 'CL_R' + i ).style.background = "white";  //cleaner rubber
			}
			if( i < 7 ){
				document.getElementById( j + 'ST_C' + i ).style.background = "white";
				document.getElementById( j + 'CS_C' + i ).style.background = "white";  //strap, coaster,keykaba
				document.getElementById( j + 'KB_R' + i ).style.background = "white";  //strap, coaster,keykaba
			}
		}

	}	
	// clear error fields
	clearErrFields();
	click_itemtype(getItemType());
	var outputDate = document.getElementById('date_display');
	outputDate.innerHTML = "";
	
}

// Select estimate item
function click_itemtype(clicked) {
	switch (clicked) {
		case "strap":
			// base prices
			showField("pricetable_strap");
			hideField("pricetable_coaster");
			//hideField("pricetable_cleaner_print");
			hideField("pricetable_cleaner_rubber");
			// color option prices
			showField("pricetable_color_strap");
			//hideField("pricetable_color_cleaner_print");
			hideField("pricetable_color_coaster");
			hideField("pricetable_color_cleaner_rubber");
			hideField("pricetable_color_keykaba");
			hideField("pricetable_keykaba");

			document.getElementById('strap_item1').disabled = false;
			document.getElementById('strap_item2').disabled = false;
			document.getElementById('nashi_print').disabled = false;
			document.getElementById('ari_print').disabled = false;

		break;

		case "coaster":
			// base prices
			hideField("pricetable_strap");
			showField("pricetable_coaster");
			hideField("pricetable_color_strap");
			//hideField("pricetable_cleaner_print");
			hideField("pricetable_cleaner_rubber");
			// color option prices
			showField("pricetable_color_coaster");
			//hideField("pricetable_color_cleaner_print");
			hideField("pricetable_color_cleaner_rubber");
			hideField("pricetable_color_keykaba");
			hideField("pricetable_keykaba");

			document.getElementById('strap_item1').checked = 'checked';
			document.getElementById('strap_item1').disabled = true;
			document.getElementById('strap_item2').disabled = true;
			document.getElementById('nashi_print').disabled = false;
			document.getElementById('ari_print').disabled = false;

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
			hideField("pricetable_strap");
			hideField("pricetable_coaster");
			//hideField("pricetable_cleaner_print");
			showField("pricetable_cleaner_rubber");
			// color option prices
			hideField("pricetable_color_strap");
			//hideField("pricetable_color_cleaner_print");
			showField("pricetable_color_cleaner_rubber");
			hideField("pricetable_color_coaster");
			hideField("pricetable_color_keykaba");
			hideField("pricetable_keykaba");

			document.getElementById('strap_item1').checked = 'checked';
			document.getElementById('strap_item1').disabled = true;
			document.getElementById('strap_item2').disabled = true;
			//裏面シルク印刷 Disable
			document.getElementById('nashi_print').checked = 'checked';
			document.getElementById('nashi_print').disabled = true;
			document.getElementById('ari_print').disabled = true;


		break;

		case "keykaba":
			// base prices
			hideField("pricetable_strap");
			hideField("pricetable_coaster");
			//hideField("pricetable_cleaner_print");
			hideField("pricetable_cleaner_rubber");
			// color option prices
			hideField("pricetable_color_strap");
			//hideField("pricetable_color_cleaner_print");
			hideField("pricetable_color_cleaner_rubber");
			hideField("pricetable_color_coaster");
			showField("pricetable_color_keykaba");
			showField("pricetable_keykaba");
			document.getElementById('strap_item1').checked = 'checked';
			document.getElementById('strap_item1').disabled = true;
			document.getElementById('strap_item2').disabled = true;

		break;

		case "":
			// base prices
			hideField("pricetable_strap");
			hideField("pricetable_coaster");
			//hideField("pricetable_cleaner_print");
			showField("pricetable_cleaner_rubber");
			// color option prices
			hideField("pricetable_color_strap");
			//hideField("pricetable_color_cleaner_print");
			showField("pricetable_color_cleaner_rubber");
			hideField("pricetable_color_keykaba");
			hideField("pricetable_keykaba");

			document.getElementById('strap_item1').checked = 'checked';
			document.getElementById('strap_item1').disabled = false;
			document.getElementById('strap_item2').disabled = false;
			//裏面シルク印刷 Disable
			document.getElementById('nashi_print').checked = 'checked';
			document.getElementById('nashi_print').disabled = false;
			document.getElementById('ari_print').disabled = false;


		break;


	}
}

function hideField(el) {
	document.getElementById(el).style.display = "none";
}

function showField(el) {
	document.getElementById(el).style.display = "";
}