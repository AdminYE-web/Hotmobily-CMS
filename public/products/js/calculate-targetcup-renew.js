/**
 * calculate-targetcup-renew.js
 * targetcup Renewal Calculator
 * Replaces client-side calculations with AJAX-based pricing via PHP DB.
 */

// ===== PRICE DATA (kept for fallback if DB/AJAX fails) =====
var price_strap_standard = [811,662,512,450,251,158,140];
var price_strap_premium = [975,796,616,540,302,191,168];

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

var carabiner_O = [56,52,48,41,35,28,27];
var carabiner_M = [149,137,124,112,90,70,67];
var carabiner_L = [214,196,177,161,128,99,94];

var parts_obj;

function format_number(number){
    if (number != "") {
        number = parseInt(number) + 0;
    }
    return number;
}

function getPartData(v) {
    $.get("part-carabiner.php", { c: "passed" } , function(data){
        var duce = $.parseJSON(data);
        for(var i=0; i<duce.length; i++){
            if(duce[i]['part_name'] == v){
                parts_obj = duce[i];
            }
        }
    }).done(function() {
        setToInput();
    });
}

var paperPrice = 0;
var unit_price = 0;
var vat = 10;

// ===== STEP NAVIGATION =====
function valid_chk_btn(c) {
	if(check_val(c)){
		$('#step1').fadeOut('fast');
		$('#step2').fadeOut('fast');
		$('#step3').fadeOut('fast');
		$('#dot-step1').removeClass('active');
		$('#dot-step2').removeClass('active');
		$('#dot-step3').removeClass('active');

		let currentClick = null;
		if (typeof event !== "undefined" && event && event.target) {
			currentClick = $(event.target).text().trim();
		} else {
			currentClick = "redirect";
		}

		switch($('#next').text()){
			case "カラビナ・オプション入力へ":
			if(c=='next' || c=='step2'){
				$('#back').fadeIn('slow');	
				$('#next').text('金額計算・見積・注文へ');
				$('#next').blur();
				$('#step2').fadeIn('slow');
				$('#dot-step1').addClass('active');
				$('#dot-step2').addClass('active');
			}else if(c=='step3'){
				$('#next').text('金額計算・見積・注文へ');
				$('#next').blur();
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
				$('#next').text('カラビナ・オプション入力へ');
				$('#next').blur();
				$('#back').fadeOut('fast');
				$('#dot-step1').addClass('active');
			}else{
				$('#back').fadeIn('slow');	
				$('#next').fadeIn('slow');	
				$('#next').text('金額計算・見積・注文へ');
				$('#next').blur();
				$('#step2').fadeIn('slow');
				$('#dot-step1').addClass('active');
				$('#dot-step2').addClass('active');
			}
		}
		$(window).scrollTop($('.step-container').offset().top);

        if(currentClick === "金額計算・見積・注文へ" || currentClick === "redirect") {
            let price_value = setToInputManual();
            if(Object.keys(price_value).length !== 0) {
                $.ajax({
                    type: "POST",
                    url: "/products/save_calc_data.php",
                    data: price_value,
                    success: function(response) {
                        if(response.status == 200 && response.calculation_token){
                            $('#calculation_token').remove();
                            $('<input>').attr({
                                type: 'hidden',
                                id: 'calculation_token',
                                name: 'calculation_token',
                                value: response.calculation_token
                            }).appendTo('form#form');
                        }	
                    }
                });
            }
        }
	}
}

// ===== VALIDATION =====
function check_val(v) {
	var ItemType = $('input[name=ItemType]').val();
	var err_number = document.getElementById('err_numberOf_mess');
	var mess = "";
	if (err_number) err_number.style.display = "";

	var vNumberOfOder = $('#no_of_order');

	if($('input[name=ItemDesignVariation]').length){
		switch($('input[name=ItemDesignVariation]:checked').val()){
			case "1種類":
			case "2種類":
				if( vNumberOfOder.val() == '' || vNumberOfOder.val() < 100 ){
					mess += "<font color='red'>本数は100本以上で入力して下さい。</font>";
					if(err_number) err_number.innerHTML = mess;
					return false;
				}
			break;
			case "3種類":
				if( vNumberOfOder.val() == '' || vNumberOfOder.val() < 150 ){
					mess += "<font color='red'>本数は150本以上で入力して下さい。</font>";
					if(err_number) err_number.innerHTML = mess;
					return false;
				}
			break;
			case "4種類":
				if( vNumberOfOder.val() == '' || vNumberOfOder.val() < 200 ){
					mess += "<font color='red'>本数は200本以上で入力して下さい。</font>";
					if(err_number) err_number.innerHTML = mess;
					return false;
				}
			break;
		}
	}
	
	if($('input[name=ItemPCS]:checked').val() == "スタンダード（スピード7営業日発送）"){
		if( vNumberOfOder.val() == '' || vNumberOfOder.val() > 200 ){
			mess += "<font color='red'>本数は200本以下で入力して下さい。</font>";
			if(err_number) err_number.innerHTML = mess;
			return false;
		}
	}

	if(v=='next'){
		if(!validation_numberOf() && $('input[name=ItemPCS]:checked').val()!="ホットモバイリーファン"){
			return false;
		}else{
			$('#err_numberOf_mess').hide();
			if($('input[name=ItemPCS]').length && $('input[name=ItemPCS]:checked').val()==undefined){
				$('#error_pcs').text('【必須】ご注文タイプをご選択ください');
				return false;
			}else if($('input[name=silk_print]').length && ItemType != "ラバータグ" && ItemType != "ペットボトルホルダー" && $('input[name=silk_print]:checked').val()==undefined){
				$('#error_print').text('【必須】裏面シルク印刷の有無をご選択ください');
				return false;
			}else if($('input[name=coating]').length && $('input[name=coating]:checked').val()==undefined){
				$('#error_coating').text('【必須】汚れ防止加工の有無をご選択ください');
				return false;
			}else{
				$('#error_pcs').text('');
				$('#error_print').text('');
				if($('input[name=coating]').length){
					$('#error_coating').text('');
				}
				setToInput();
				return true;
			}
		}
	}else{
		return true;
	}
}


// ===== MAIN CALCULATOR: AJAX-based =====
function setToInput() {
    clearValue();
    var vno_of_order = document.getElementById("no_of_order");
    var part = $('input[name="part"]:checked').val() || "なし";
    
    // Manage UI elements for part
    if (part != "なし" && part != "カラビナなし" && part != "不要") {
        $('#sample-part-name').text(parts_obj ? parts_obj["part_name"] : part);
        if(parts_obj && parts_obj["part_pic"]) {
            $('#sample-part-pic').html('<img width="135" height="135" id="sample-part-pic" class="picpro" src="'+parts_obj["part_pic"]+'">');
        }
        if (part != "廉価版カラビナ") {
            $('.carabiner-printng').show();
        } else {
            $('.carabiner-printng').hide();
            $('input[name=carabiner_print]:first').prop('checked',true);
        }
    } else {
        $('#sample-part-pic').hide();
        $('#sample-part-name').text('');
        $('.carabiner-printng').hide();
        $('input[name=carabiner_print]:first').prop('checked',true);
    }

    // Manage UI elements for paper
    if($('input[name="paper_select"]').length){
		var paper = $('input[name="paper_select"]:checked').val();
		var paper_color = $('input[name="paper"]:checked').val();

		if(paper!=undefined && paper !== "なし" && paper !== ""){
			$('.paper-container').show();
			if(paper_color!=undefined){
				$('#sample-paper-pic').show();
				$('#sample-paper-pic').attr('src',"/products/acrylic/img/"+paper_color+".jpg");
				$('#sample-paper-name').text(paper_color);
				$('#next').attr('disabled',false);
				$('#back').attr('disabled',false);
				$('#prd_paper').text(paper_color);
				$('#paper-error').text('');
			}else{
				$('#paper-error').text('台紙を選択してください。');
				$('#next').attr('disabled',true);
				$('#back').attr('disabled',true);
			}
		}else{
			$('#sample-paper-pic').hide();
			$('#sample-paper-name').text('なし');
			$('.paper-container').hide();
			$('#paper-error').text('');
			$('#next').attr('disabled',false);
			$('#back').attr('disabled',false);
			$('#prd_paper').text('なし');
			$('input[name="acy_paper"]').prop('checked',false);
			$('input[name="paper"]').prop('checked',false);
		}
	}

    // Packing UI
    if($("input[name=packing]").length){
		if($("input[name=packing]:checked").val()!=undefined && $("input[name=packing]:checked").val()!=""){
			$('#part-error').text('');
			$('#next').attr('disabled',false);
			$('#back').attr('disabled',false);

			$('#sample-part-pic').show();
			if($("input[name=packing]:checked").val() == "白色無地"){
				$('#sample-part-pic').attr("src", "/products/images/frame-packing1.jpg");
			}else{
				$('#sample-part-pic').attr("src", "/products/images/frame-packing2.jpg?v=1.01");
			}
			$('#sample-part-name').text($("input[name=packing]:checked").val());
		}else{
			$('#part-error').text('梱包形態をご選択ください');
			$('#next').attr('disabled',true);
			$('#back').attr('disabled',true);
		}
	}

    if (vno_of_order && vno_of_order.value != "") {
        if ($("input[name=ItemPCS]").length && $("input[name=ItemPCS]:checked").val() != undefined) {
            $("#sample-prd-pcs").text($("input[name=ItemPCS]:checked").val());
            $("#prd_ItemPCS").text($("input[name=ItemPCS]:checked").val());
        }
        if($('input[name=silk_print]').length && $('input[name=silk_print]:checked').val()!=undefined){
            $('#sample-prd-screen').text($('input[name=silk_print]:checked').val());
            $('#prd_silk_print').text($('input[name=silk_print]:checked').val());
        }
        if ($("input[name=coating]").length && $("input[name=coating]:checked").val() != undefined) {
            $("#sample-prd-coating").text($("input[name=coating]:checked").val());
            $("#prd_coating").text($("input[name=coating]:checked").val());
        }
        if ($("input[name=ItemMaterial]").length && $("input[name=ItemMaterial]:checked").val() != undefined) {
            $("#sample-prd-material").text($("input[name=ItemMaterial]:checked").val());
            $("#prd_ItemMaterial").text($("input[name=ItemMaterial]:checked").val());
        }

        $("#sample-prd-qty").text(vno_of_order.value);
        $("#prd_qty").text(vno_of_order.value);

        if ($("input[name=SendPrototype]:checked").val() != undefined) {
            $("#prd_SendPrototype").text("あり");
            $("#sample-prd-samp").text("あり");
        } else {
            $("#prd_SendPrototype").text("なし");
            $("#sample-prd-samp").text("なし");
        }
        if ($("input[name=DeFormat]:checked").val() != undefined) {
            $("#prd_DeFormat").text("あり");
            $("#sample-prd-trace").text("あり");
        } else {
            $("#prd_DeFormat").text("なし");
            $("#sample-prd-trace").text("なし");
        }
        if ($("input[name=ItemDesignVariation]:checked").val() != undefined) {
            $("#prd_ItemDesign").text($("input[name=ItemDesignVariation]:checked").val());
        }

        if($('#prd_part').length) $('#prd_part').text(part);
        if($('#prd_part_printing').length) $('#prd_part_printing').text($('input[name=carabiner_print]:checked').val());

        calculateLocal();
        return;

        var formData = {
            ItemType: $("input[name=ItemType]").val() || "ゴルフターゲットカップ",
            ItemPCS: $("input[name=ItemPCS]:checked").val(),
            numberOf: $("#no_of_order").val(),
            silk_print: $("input[name=silk_print]:checked").val(),
            coating: $("input[name=coating]:checked").val(),
            ItemMaterial: $("input[name=ItemMaterial]:checked").val(),
            ItemDesignVariation: $("input[name=ItemDesignVariation]:checked").val(),
            part: part,
            carabiner_print: $("input[name=carabiner_print]:checked").val(),
            packing: $("input[name=packing]:checked").val(),
            paper_select: $("input[name=paper_select]:checked").val(),
            paper: $("input[name=paper]:checked").val(),
            SendPrototype: $("input[name=SendPrototype]:checked").val(),
            DeFormat: $("input[name=DeFormat]:checked").val(),
            delivery_price: parseMoney($("#textfield_delivery").val() || 0)
        };

        if(document.getElementById("textfield11")) document.getElementById("textfield11").value = "計算中...";
        $(".prd_total").text("計算中...");

        $.post("/products/ajax_calculate_price_targetcup.php", formData, function(response) {
            if (response.success) {
                if(document.getElementById("textfield7")) document.getElementById("textfield7").value = formatMoney(response.StrapPrice);
                if(document.getElementById("textfield13")) document.getElementById("textfield13").value = formatMoney(response.SilkPrint);
                if(document.getElementById("textfield13_2")) document.getElementById("textfield13_2").value = formatMoney(response.coatingPrice);
                if(document.getElementById("textfield13_3")) document.getElementById("textfield13_3").value = formatMoney(response.packingPrice);
                if(document.getElementById("textfield7_1")) document.getElementById("textfield7_1").value = formatMoney(response.PartPrice);
                if(document.getElementById("textfield7_3")) document.getElementById("textfield7_3").value = formatMoney(response.carabinerPrint);
                if(document.getElementById("textfield7_2")) document.getElementById("textfield7_2").value = formatMoney(response.PaperPrice);
                if(document.getElementById("textfield3")) document.getElementById("textfield3").value = formatMoney(response.ProShipping);
                if(document.getElementById("textfield4")) document.getElementById("textfield4").value = formatMoney(response.TraceCharge);
                if(document.getElementById("DesignsCharge")) document.getElementById("DesignsCharge").value = formatMoney(response.DesignsCharge);
                if(document.getElementById("MaterialCharge")) document.getElementById("MaterialCharge").value = formatMoney(response.MaterialCharge);
                
                if(document.getElementById("textfield9")) document.getElementById("textfield9").value = formatMoney(response.BeforeTax);
                if(document.getElementById("textfield_dis")) document.getElementById("textfield_dis").value = formatMoney(response.discount);
                if(document.getElementById("textfield_tax")) document.getElementById("textfield_tax").value = formatMoney(response.Tax);
                if(document.getElementById("textfield11")) document.getElementById("textfield11").value = formatMoney(response.grandTotal);
                $(".prd_total").text(formatMoney(response.grandTotal));
            } else {
                calculateLocal();
            }
        }, "json").fail(function() {
            calculateLocal();
        });
    }
}

// ===== LOCAL CALCULATOR FALLBACK =====
function calculateLocal() {
    var vno_of_order = document.getElementById("no_of_order");
    if (!vno_of_order || vno_of_order.value == "") return;

    var qty = parseInt(vno_of_order.value, 10);
    var order_pcs = 0;
    var selectedPCS = $("input[name=ItemPCS]:checked").val();

    if (selectedPCS == "プレミアム") {
        if (qty >= 5000) order_pcs = price_strap_premium[6];
        else if (qty >= 3000) order_pcs = price_strap_premium[5];
        else if (qty >= 1000) order_pcs = price_strap_premium[4];
        else if (qty >= 500) order_pcs = price_strap_premium[3];
        else if (qty >= 300) order_pcs = price_strap_premium[2];
        else if (qty >= 200) order_pcs = price_strap_premium[1];
        else if (qty >= 100) order_pcs = price_strap_premium[0];
    } else {
        if (qty >= 5000) order_pcs = price_strap_standard[6];
        else if (qty >= 3000) order_pcs = price_strap_standard[5];
        else if (qty >= 1000) order_pcs = price_strap_standard[4];
        else if (qty >= 500) order_pcs = price_strap_standard[3];
        else if (qty >= 300) order_pcs = price_strap_standard[2];
        else if (qty >= 200) order_pcs = price_strap_standard[1];
        else if (qty >= 100) order_pcs = price_strap_standard[0];
    }

    if (selectedPCS == "スタンダード（スピード7営業日発送）") {
        order_pcs += 110;
    }

    var localStrapPrice = order_pcs * qty;

    var print_charge = 0;
    if ($("input[name=silk_print]:checked").val() == "単色（シルク）印刷") print_charge = 30 * qty;
    else if ($("input[name=silk_print]:checked").val() == "フルカラー印刷") print_charge = 50 * qty;

    var localCoating = 0;
    if ($("input[name=coating]:checked").val() == "汚れ防止加工あり") localCoating = 70 * qty;

    var localPacking = 0;
    if ($("input[name=packing]:checked").val() == "白色無地") localPacking = 30 * qty;

    var localMaterial = 0;
    if ($("input[name=ItemMaterial]:checked").val() == "特殊素材あり") localMaterial = 30 * qty;

    var part = $('input[name="part"]:checked').val();
    var partPrice = 0;
    if (part == "廉価版カラビナ") {
        if (qty >= 5000) partPrice = carabiner_O[6];
        else if (qty >= 3000) partPrice = carabiner_O[5];
        else if (qty >= 1000) partPrice = carabiner_O[4];
        else if (qty >= 500) partPrice = carabiner_O[3];
        else if (qty >= 300) partPrice = carabiner_O[2];
        else if (qty >= 200) partPrice = carabiner_O[1];
        else if (qty >= 100) partPrice = carabiner_O[0];
    } else if (part == "高級版Mサイズ") {
        if (qty >= 5000) partPrice = carabiner_M[6];
        else if (qty >= 3000) partPrice = carabiner_M[5];
        else if (qty >= 1000) partPrice = carabiner_M[4];
        else if (qty >= 500) partPrice = carabiner_M[3];
        else if (qty >= 300) partPrice = carabiner_M[2];
        else if (qty >= 200) partPrice = carabiner_M[1];
        else if (qty >= 100) partPrice = carabiner_M[0];
    } else if (part == "高級版Lサイズ") {
        if (qty >= 5000) partPrice = carabiner_L[6];
        else if (qty >= 3000) partPrice = carabiner_L[5];
        else if (qty >= 1000) partPrice = carabiner_L[4];
        else if (qty >= 500) partPrice = carabiner_L[3];
        else if (qty >= 300) partPrice = carabiner_L[2];
        else if (qty >= 200) partPrice = carabiner_L[1];
        else if (qty >= 100) partPrice = carabiner_L[0];
    }
    partPrice = partPrice * qty;

    var carabiner_print = 0;
    if (part != "" && part != "廉価版カラビナ" && part != "カラビナなし" && part != "なし" && part != undefined) {
        if ($('input[name=carabiner_print]:checked').val() == "刻印あり（表）") carabiner_print = 20 * qty;
        else if ($('input[name=carabiner_print]:checked').val() == "刻印あり（表+裏）") carabiner_print = 30 * qty;
    }

    var localPaper = 0;
    if ($('input[name="paper_select"]:checked').val() != undefined && $('input[name="paper_select"]:checked').val() != "なし") {
        var paper_color = $('input[name="paper"]:checked').val();
        var tmp_pp = paperPrice_obj['tmp'];
        if(paper_color == "paper-patternA-1") tmp_pp = paperPrice_obj['1side'];
        else if(paper_color == "paper-patternA-2") tmp_pp = paperPrice_obj['2side'];
        
        var paperUnit = 0;
        for (var i = 0; i < tmp_pp.length; i++) {
            if (qty >= parseInt(tmp_pp[i].num)) {
                paperUnit = tmp_pp[i].price;
            }
        }
        localPaper = paperUnit * qty;
    }

    var localProto = 0;
    if (selectedPCS != "プレミアム" && $("input[name=SendPrototype]:checked").val() != undefined) {
        localProto = 8000;
    }

    var localTrace = 0;
    if (selectedPCS != "プレミアム" && $("input[name=DeFormat]:checked").val() != undefined) {
        localTrace = 8000;
    }

    var localDesign = 0;
    var designVal = $("input[name=ItemDesignVariation]:checked").val();
    if (designVal == "2種類") localDesign = 3000;
    else if (designVal == "3種類") localDesign = 6000;
    else if (designVal == "4種類") localDesign = 9000;

    var discount = 0;
    var beforeTax = localStrapPrice + print_charge + localCoating + localPacking + partPrice + carabiner_print + localPaper + localProto + localTrace + localDesign + localMaterial;
    var subtotal = Math.max(0, beforeTax - discount);
    var localTax = Math.floor(subtotal * 0.10);
    var grandTotal = subtotal + localTax;

    if(document.getElementById("textfield7")) document.getElementById("textfield7").value = formatMoney(localStrapPrice);
    if(document.getElementById("textfield13")) document.getElementById("textfield13").value = formatMoney(print_charge);
    if(document.getElementById("textfield13_2")) document.getElementById("textfield13_2").value = formatMoney(localCoating);
    if(document.getElementById("textfield13_3")) document.getElementById("textfield13_3").value = formatMoney(localPacking);
    if(document.getElementById("textfield7_1")) document.getElementById("textfield7_1").value = formatMoney(partPrice);
    if(document.getElementById("textfield7_3")) document.getElementById("textfield7_3").value = formatMoney(carabiner_print);
    if(document.getElementById("textfield7_2")) document.getElementById("textfield7_2").value = formatMoney(localPaper);
    if(document.getElementById("textfield3")) document.getElementById("textfield3").value = formatMoney(localProto);
    if(document.getElementById("textfield4")) document.getElementById("textfield4").value = formatMoney(localTrace);
    if(document.getElementById("DesignsCharge")) document.getElementById("DesignsCharge").value = formatMoney(localDesign);
    if(document.getElementById("MaterialCharge")) document.getElementById("MaterialCharge").value = formatMoney(localMaterial);
    
    if(document.getElementById("textfield9")) document.getElementById("textfield9").value = formatMoney(subtotal);
    if(document.getElementById("textfield_dis")) document.getElementById("textfield_dis").value = formatMoney(discount);
    if(document.getElementById("textfield_tax")) document.getElementById("textfield_tax").value = formatMoney(localTax);
    if(document.getElementById("textfield11")) document.getElementById("textfield11").value = formatMoney(grandTotal);
    $(".prd_total").text(formatMoney(grandTotal));
}

// ===== MANUAL DATA PREPARATION FOR SAVE_CALC_DATA =====
function setToInputManual() {
    var vno_of_order = document.getElementById("no_of_order");
    if (!vno_of_order || vno_of_order.value == "") return {};
  
    return {
        ItemType: $("input[name=ItemType]").val() || "ゴルフターゲットカップ",
        ItemPCS: $("input[name=ItemPCS]:checked").val(),
        numberOf: $("#no_of_order").val(),
        silk_print: $("input[name=silk_print]:checked").val(),
        coating: $("input[name=coating]:checked").val(),
        ItemMaterial: $("input[name=ItemMaterial]:checked").val(),
        ItemDesignVariation: $("input[name=ItemDesignVariation]:checked").val(),
        part: $("input[name=part]:checked").val() || "なし",
        carabiner_print: $("input[name=carabiner_print]:checked").val(),
        packing: $("input[name=packing]:checked").val(),
        paper_select: $("input[name=paper_select]:checked").val(),
        paper: $("input[name=paper]:checked").val(),
        SendPrototype: $("input[name=SendPrototype]:checked").val(),
        DeFormat: $("input[name=DeFormat]:checked").val(),
        StrapPrice: parseMoney($("#textfield7").val()),
        SilkPrint: parseMoney($("#textfield13").val()),
        coatingPrice: parseMoney($("#textfield13_2").val()),
        packingPrice: document.getElementById("textfield13_3") ? parseMoney($("#textfield13_3").val()) : 0,
        PartPrice: parseMoney($("#textfield7_1").val()),
        carabinerPrint: parseMoney($("#textfield7_3").val()),
        PaperPrice: parseMoney($("#textfield7_2").val()),
        ProShipping: parseMoney($("#textfield3").val()),
        TraceCharge: parseMoney($("#textfield4").val()),
        DesignsCharge: document.getElementById("DesignsCharge") ? parseMoney($("#DesignsCharge").val()) : 0,
        MaterialCharge: document.getElementById("MaterialCharge") ? parseMoney($("#MaterialCharge").val()) : 0,
        BeforeTax: parseMoney($("#textfield9").val()),
        discount: parseMoney($("#textfield_dis").val()),
        Tax: parseMoney($("#textfield_tax").val() || 0),
        grandTotal: parseMoney($("#textfield11").val())
    };
}

// ===== CLEAR =====
function clearValue() {
    var tf7 = document.getElementById("textfield7"); if (tf7) tf7.value = "";
    var tf13 = document.getElementById("textfield13"); if (tf13) tf13.value = "";
    var tf13_2 = document.getElementById("textfield13_2"); if (tf13_2) tf13_2.value = "";
    var tf13_3 = document.getElementById("textfield13_3"); if (tf13_3) tf13_3.value = "";
    var tf7_1 = document.getElementById("textfield7_1"); if (tf7_1) tf7_1.value = "";
    var tf7_3 = document.getElementById("textfield7_3"); if (tf7_3) tf7_3.value = "";
    var tf7_2 = document.getElementById("textfield7_2"); if (tf7_2) tf7_2.value = "";
    var tf3 = document.getElementById("textfield3"); if (tf3) tf3.value = "";
    var tf4 = document.getElementById("textfield4"); if (tf4) tf4.value = "";
    var dc = document.getElementById("DesignsCharge"); if (dc) dc.value = "";
    var mc = document.getElementById("MaterialCharge"); if (mc) mc.value = "";
    var tf9 = document.getElementById("textfield9"); if (tf9) tf9.value = "";
    var tfd = document.getElementById("textfield_dis"); if (tfd) tfd.value = "";
    var tft = document.getElementById("textfield_tax"); if (tft) tft.value = "";
    var tf11 = document.getElementById("textfield11"); if (tf11) tf11.value = "";
    $(".prd_total").text("0");
}

function clearColor() {
    // optional ui reset
}
function clear_valCal() {
    // optional ui reset
}

// ===== FORMAT HELPERS =====
function formatMoney(inum) {
    if (inum == "0" || inum == "") return inum;
    var s_inum = new String(inum);
    var s_inumInt = s_inum.split(".", s_inum);
    var l_inum = s_inumInt[0].length;
    var n_inum = "";
    for (let i = 0; i < l_inum; i++) {
        if (parseInt(l_inum - i, 10) % 3 == 0) {
            if (i == 0) n_inum += s_inum.charAt(i);
            else n_inum += "," + s_inum.charAt(i);
        } else {
            n_inum += s_inum.charAt(i);
        }
    }
    if (s_inumInt[1] != undefined) n_inum += "." + s_inumInt[1];
    return n_inum;
}

function parseMoney(value) {
    var numeric = String(value || "").replace(/[^\d.-]/g, "");
    return numeric === "" ? 0 : parseInt(numeric, 10);
}

function click_typeorder_enabled() {
    // enable some logic
}
function click_typeorder_disabled() {
    // disable some logic
}

$(function(){
	$('.switch_off_button').click(function(e){
		if ($(this).hasClass("switch_off")) {
			$(this).find('input[type=checkbox]').prop('checked',true);
			$(this).find("input[type=hidden]").prop('disabled', true);
			$(this).removeClass("switch_off");
			$(this).addClass("switch_on");
		}else{
			$(this).find('input[type=checkbox]').prop('checked',false);
			$(this).find("input[type=hidden]").prop('disabled', false);
			$(this).removeClass("switch_on");
			$(this).addClass("switch_off");
		}
		
		if(e.target.tagName != 'INPUT'){
			let cb = $(this).find('input[type=checkbox]');
			if (cb.length > 0 && typeof cb[0].onclick === 'function') {
				cb[0].onclick();
			} else {
				cb.trigger('change');
			}
		}
	});
});
