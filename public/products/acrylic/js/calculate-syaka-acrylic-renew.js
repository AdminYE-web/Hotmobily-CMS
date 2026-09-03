var isSafari = navigator.vendor && navigator.vendor.indexOf('Apple') > -1 &&
navigator.userAgent &&
navigator.userAgent.indexOf('CriOS') == -1 &&
navigator.userAgent.indexOf('FxiOS') == -1;
// price for 10 days
// 

// 

// // price for 6 days
// 

// 






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

		switch($('#next').text()){
			case "アタッチメント・オプション入力へ":
			if(c=='next' || c=='step2'){
				$('#back').fadeIn('slow');	
				$('#next').text('金額計算・見積・注文へ');
				$('#step2').fadeIn('slow');
				$('#dot-step1').addClass('active');
				$('#dot-step2').addClass('active');
				chk_part();
				cal_c();
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
				cal_c();
				// console.log('bb');
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
            // let price_value = calculate_price_manual();
            // if(Object.keys(price_value).length !== 0) 
            // {
            //     $.ajax({
            //         type: "POST",
            //         url: "/products/save_calc_data.php",
            //         data: price_value,
            //         success: function(response) 
            //         {
            //             if(response.status == 200 && response.calculation_token){
            //                 // Append calculation_token to form
            //                 $('#calculation_token').remove();
            //                 $('<input>').attr({
            //                     type: 'hidden',
            //                     id: 'calculation_token',
            //                     name: 'calculation_token',
            //                     value: response.calculation_token
            //                 }).appendTo('form#form');
            //             }	
            //         },error: function(xhr, status, error) {
						
            //         }	
            //     });
            // }
        }
		else
		{
			// if((currentClick != "" && currentClick !== undefined) && (currentClick === "redirect"))
			// {
			// 	let price_items = calculate_price_manual();
			// 	if(Object.keys(price_items).length !== 0) 
			// 	{
			// 		$.ajax({
			// 			type: "POST",
			// 			url: "/products/save_calc_data.php",
			// 			data: price_items,
			// 			success: function(response) 
			// 			{
			// 				if(response.status == 200 && response.calculation_token){
			// 					// Append calculation_token to form
			// 					$('#calculation_token').remove();
			// 					$('<input>').attr({
			// 						type: 'hidden',
			// 						id: 'calculation_token',
			// 						name: 'calculation_token',
			// 						value: response.calculation_token
			// 					}).appendTo('form#form');
			// 				}	
			// 			},error: function(xhr, status, error) {
							
			// 			}	
			// 		});
			// 	}
			// }
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
				$('input[name="acy_sample"][type="checkbox"]').closest('label').css({'pointer-events': 'none', 'opacity': '0.5'});
			}else{
				$('#sample-error').text('※試作品をご希望される場合、ご注文納期とは別に試作品製作時間として6営業日+配送2日が必要になります。ご注文確定後に試作品の有無をご変更されるお客様が多くなっております。納期に余裕の無い場合、試作品のご依頼はご遠慮下さい。');
				$('input[name=acy_sample]').attr('disabled',false);
				$('input[name="acy_sample"][type="checkbox"]').closest('label').css({'pointer-events': 'auto', 'opacity': '1'});
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


/**
 * Main price calculation — uses AJAX to get prices from DB.
 */
function cal_c(v) {
    var qty = $('input[name="qty"]').val();

    // Don't calculate if qty is empty or 0
    if (!qty || parseInt(qty) <= 0) {
        updatePriceDisplay(0, 0, 0, 0, 0, 0, 0, 0, 0);
        $('.prd_total').text('0');
        return;
    }

    var prodc_day = $('input[name="acy_delivery"]:checked').val();
    var ItemSize = $('input[name="acy_size"]').val() || $('input[name="acy_size"]:checked').val() || 70;
    var screen = $('input[name="acy_screen"]:checked').val();
    var part = $('input[name="acy_part"]:checked').val();
    var paper = $('input[name="acy_paper_select"]:checked').val();
    var paper_color = $('input[name="acy_paper"]:checked').val();
    var color = $('input[name="acy_color"]:checked').val();
    
    // Force disable sample switch if qty < 20
    if (parseInt(qty) < 20) {
        $('input[name="acy_sample"][type="checkbox"]').prop('checked', false).removeAttr("checked").attr('disabled', true);
        $('input[name="acy_sample"][type="checkbox"]').closest('label').css({'pointer-events': 'none', 'opacity': '0.5'});
        $('#sample-error').text('試作品は20個以上のご注文から受付');
    } else {
        $('input[name="acy_sample"][type="checkbox"]').attr('disabled', false);
        $('input[name="acy_sample"][type="checkbox"]').closest('label').css({'pointer-events': 'auto', 'opacity': '1'});
        $('#sample-error').text('');
    }

    var sample = $('input[name="acy_sample"]:checked').val();
    var trace = $('input[name="acy_trace"]:checked').val();

    // Update display labels
    $('#sample-prd-size').text('70*70mm');
    $('#sample-prd-screen').text(screen);
    $('#sample-prd-qty').text(qty);
    $('#sample-prd-color').text(color);
    $('#prd_production').text(prodc_day);
    $('#prd_size').text('70*70mm');
    $('#prd_color').text(color);
    $('#prd_print').text(screen);
    $('#prd_amount').text(qty);
    $('#prd_part').text(part);
    if(sample!=undefined){ $('#prd_sample').text(sample); $('#sample-prd-samp').text(sample); } else { $('#prd_sample').text('なし'); $('#sample-prd-samp').text('なし'); }
    if(trace!=undefined){ $('#prd_trace').text(trace); $('#sample-prd-trace').text(trace); } else { $('#prd_trace').text('なし'); $('#sample-prd-trace').text('なし'); }

    // Part display
    if(part!=undefined && parts_obj){
        $('#part-error').text('');
        $('#sample-part-pic').show();
        $('#sample-part-pic').attr('src',parts_obj["part_pic"]);
        $('#sample-part-name').text(parts_obj["part_name"]);
    }else{
        $('#sample-part-pic').hide();
        $('#sample-part-name').text('アタッチメント:なし');
    }

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
    }

        var part_price = 0;
        if(typeof parts_obj !== 'undefined' && parts_obj != null){
            part_price = parseInt(parts_obj.part_price) || 0;
        }
        var paper_price_val = 0;
        if($('input[name="acy_paper_select"]').is(':checked')) {
            paper_price_val = 10;
        }

        $.ajax({
            type: "POST",
            url: "/products/acrylic/ajax_calculate_price_syaka.php",
            dataType: "json",
            data: {
                qty: qty,
                acy_delivery: prodc_day,
                acy_size: ItemSize,
                acy_screen: screen,
                acy_color: color,
                acy_part: part,
                acy_paper_select: paper ? "1" : "",
                acy_paper: paper_color,
                acy_sample: sample,
                acy_trace: trace,
                ItemType: $('#strap').val(),
                part_price: part_price,
                paper_price: paper_price_val
            },
        success: function (data) {
            if (data.status === 200) {
                // Incorporate VAT properly (Tax is returned from DB)
                var vat = 10;
                var tax = data.Tax;
                unit_price = data.unit_price;
                partPrice = data.part_unit_price;
                paperPrice = data.paper_unit_price;
                var prd_part_price = data.prd_part_price;
                var prd_paper_price = data.prd_paper_price;
                var prd_trace_price = data.prd_trace_price;
                sub_total = data.prd_sub_total; // Pre-tax subtotal
                disPrice = data.discount;
                vat_price = tax;
                total = data.prd_total;

                updatePriceDisplay(
                    data.unit_price * qty,
                    prd_part_price,
                    prd_paper_price,
                    prd_trace_price,
                    0,
                    sub_total,
                    disPrice,
                    vat_price,
                    total
                );
            } else {
                console.error("Calculation error: ", data.error);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error: ", error);
        }
    });
}

function updatePriceDisplay(prdPrice, partTotal, paperTotal, tracePrice, samplePrice, subtotalVal, discountVal, taxVal, totalVal) {
    $('#prd_price').val(prdPrice.toLocaleString("en"));
    $('#prd_part_price').val(partTotal.toLocaleString("en"));
    $('#prd_paper_price').val(paperTotal.toLocaleString("en"));
    $('#prd_trace_price').val(tracePrice.toLocaleString("en"));
    $('#prd_sample_price').val('0');

    // Display pre-tax subtotal
    $('#prd_sub_total').val(subtotalVal.toLocaleString("en"));
    $('#discount').val(discountVal.toLocaleString("en"));
    if ($('#prd_tax').length) {
        $('#prd_tax').val(taxVal.toLocaleString("en"));
    }

    $('.prd_total').text(totalVal.toLocaleString("en"));
    $('#prd_total').val(totalVal.toLocaleString("en"));
}

$(function() {			
		if($("#strap").val()=="アクリルキーホルダー"){ //Acrylic Keychain
			getPartData($('input[name="acy_part"]:checked').val());		
		}else if($("#strap").val()=="オリジナルめじるしアクセサリー（アンブレラマーカー）"){ //Acrylic Umbrella
			getPartData2($('input[name="acy_part"]:checked').val());
		}else{
			getPartData3($('input[name="acy_part"]:checked').val());
		}
	});

	function getPartData(v) {
		$.get("part.php", { c: "passed" } , function(data){
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
			if ((mmt != "" && mmt == "MODE_MOD") && (prd_strap == "アクリルキーホルダー")) //Only Acrylic Keychain
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

	function getPartData2(v) 
    {
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

            //Create new token when page load
			let prd_strap = $('#strap').val();
			let mmt = $('#ms_mode').val();
			if ((mmt != "" && mmt == "MODE_MOD") && (prd_strap == "オリジナルめじるしアクセサリー（アンブレラマーカー）")) //Only Umbrella
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

            //Create new token when page load
			let prd_strap = $('#strap').val();
			let mmt = $('#ms_mode').val();
			if ((mmt != "" && mmt == "MODE_MOD") && (prd_strap == "アクリルバッジ")) //Only Badge
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
		    var sku_name = "shakashaka_acrylickeyholder";
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

    delivery = $("input[name=acy_delivery]:checked").val();

    itemtype_size = '70*70mm';

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
	var item_color = $("input[name=acy_color]:checked").val();
    
    var item_price = unit_price;

   	var discount_quo = disPrice;
	   var example_price = 0,ai_file_price = 0;
	
	if(ai_file == "1"){
    	ai_file_price = 2200;
		ai_file_price = ai_file_price.toLocaleString('en');
		sum1_quo = sum1_quo+(2200);
		sum4_quo = (total+2200).toLocaleString("en");
		sum3_quo = vat_price+(2200);
    }


    var sum1_quo = sub_total.toLocaleString("en");
    // var sum2_quo = $('#prd_sub_total').val();
    // var sum3_quo = $('#vat').val();
    var sum2_quo = 0;
    var sum3_quo = vat_price;
    var sum4_quo = total.toLocaleString("en");

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
		"itemtype_colors": item_color,
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
	}else if($("#strap").val()=="オリジナルめじるしアクセサリー（アンブレラマーカー）"){
		getPartData2($('input[name="acy_part"]:checked').val());
	}else{
		getPartData3($('input[name="acy_part"]:checked').val());
	}
	cal_c();
}