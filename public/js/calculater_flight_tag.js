// フライトタグ（刺繍タグキーホルダー）
var ft_1 = [616, 467, 352, 247, 181, 137];
var ft_2 = [693, 506, 264, 214, 170, 132];

// オリジナル刺繍ワッペン・パッチ
var wp_1 = [616, 467, 352, 247, 181, 137];
var wp_2 = [693, 506, 264, 214, 170, 132];

// 刺繍キーホルダー
var kh_1 = [616, 467, 352, 247, 181, 137];
var kh_2 = [693, 506, 264, 214, 170, 132];

// オリジナル刺繍バッジ
var bg_1 = [616, 467, 352, 247, 181, 137];
var bg_2 = [693, 506, 264, 214, 170, 132];

// 刺繍コースター
var ct_1 = [616, 467, 352, 247, 181, 137];
var ct_2 = [693, 506, 264, 214, 170, 132];

var unit_price = 0;

function valid_chk_btn(c) {
	chk_color();
	if (check_val(c)) {
		$('#step1').fadeOut('fast');
		$('#step2').fadeOut('fast');
		$('#step3').fadeOut('fast');
		$('#dot-step1').removeClass('active');
		$('#dot-step2').removeClass('active');
		$('#dot-step3').removeClass('active');

		switch ($('#next').text()) {
			case "オプション入力へ":
				if (c == 'next' || c == 'step2') {
					$('#back').fadeIn('slow');
					$('#next').text('金額計算・見積・注文へ');
					$('#next').blur();
					$('#step2').fadeIn('slow');
					$('#dot-step1').addClass('active');
					$('#dot-step2').addClass('active');
				} else if (c == 'step3') {
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
				if (c == 'next') {
					$('#step3').fadeIn('slow');
					$('#back').fadeOut('fast');
					$('#next').fadeOut('fast');
					$('#dot-step1').addClass('active');
					$('#dot-step2').addClass('active');
					$('#dot-step3').addClass('active');
				} else if (c == 'back' || c == 'step1') {
					$('#next').fadeIn('slow');
					$('#step1').fadeIn('slow');
					$('#next').text('オプション入力へ');
					$('#next').blur();
					$('#back').fadeOut('fast');
					$('#dot-step1').addClass('active');
				} else {
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
	}
}

function check_val(v) {
	var ItemType = $('input[name=ItemType]').val();

	if ($('input[name=ft_process]:checked').val() == "オーバーロック仕上げ") {
		$('.overlock_only').show();
	} else {
		$('.overlock_only').hide();
	}

	if ($('input[name=ft_backside]').length) {
		if ($('input[name=ft_backside]:checked').val() == "デザインなし") {
			$('.no-designs').show();
		} else {
			$('.no-designs').hide();
		}
	}

	$("input[name='ft_option']").on('change', function () {
		// Check the value of the currently selected radio input
		if ($(this).val() == 'フェルト生地') {
			// Change options for ft_fabric_color1 to f1-f20
			changeOptionValues("f", 1, "ft_fabric_color1");
			// Change options for ft_fabric_color2 to f21-f40
			if ($('select[name=ft_fabric_color2]').length) {
				changeOptionValues("f", 1, "ft_fabric_color2");
			}
		} else if ($(this).val() == 'ツイル生地') {
			// Change options for ft_fabric_color1 to t-1-t-20
			changeOptionValues("t", 1, "ft_fabric_color1");
			// Change options for ft_fabric_color2 to t-1-t-20
			if ($('select[name=ft_fabric_color2]').length) {
				changeOptionValues("t", 1, "ft_fabric_color2");
			}
		}
	});

	// console.log(v)
	if (v == "step3") {
		console.log($("input[name='ft_option']:checked").val());
		chk_color();
		if ($("input[name='ft_option']:checked").val() == 'フェルト生地') {
			changeOptionValues("f", 1, "ft_fabric_color1");
			// Change options for ft_fabric_color2 to f21-f40
			if ($('select[name=ft_fabric_color2]').length) {
				changeOptionValues("f", 1, "ft_fabric_color2");
			}
		} else if ($("input[name='ft_option']:checked").val() == 'ツイル生地') {
			// Change options for ft_fabric_color1 to t-1-t-20
			changeOptionValues("t", 1, "ft_fabric_color1");
			// Change options for ft_fabric_color2 to t-1-t-20
			if ($('select[name=ft_fabric_color2]').length) {
				changeOptionValues("t", 1, "ft_fabric_color2");
			}
		}
	}

	if ($('input[name=ft_type]:checked').val() == "ジャガード織") {
		$('.only_embro').hide();
	} else {
		$('.only_embro').show();
	}

	if (v == 'next') {
		if (!validation_numberOf()) {
			return false;
		} else {
			setToInput();
			return true;
		}
	} else {
		setToInput();
		return true;
	}
}

function validation_numberOf() {
	//エラー出力用id
	var err_number = document.getElementById('err_numberOf_mess');
	var mess = "";

	err_number.style.display = "";

	//入力値
	var vNumberOfOder = document.getElementById('qty');

	if (isNaN(vNumberOfOder.value)) {
		mess += "<font color='red'>半角数値以外が入力されています。</font>";
		err_number.innerHTML = mess;
		return false;
	} else if (vNumberOfOder.value == '' || vNumberOfOder.value < 50) {
		mess += "<font color='red'>本数は50本以上で入力して下さい。</font>";
		err_number.innerHTML = mess;
		return false;
	} else if (vNumberOfOder.value > 50000) {
		mess += "<font color='red'>本数は50000本以下で入力して下さい。50000以上のお客様は納期をメールにてお問い合わせ下さい。</font>";
		err_number.innerHTML = mess;
		return false;
	} else {
		err_number.style.display = "none";
		return true;
	}
}

var order_pcs = 0;
var unit_price = 0;
var pcs_price = 0;
var before_tax = 0;
var tax = 0;
var vat = 10;
var total = 0;
var silkprint = 0;
var TextField7Value = 0;
var TextField9Value = 0;
var DisPrice = 0;
var proto_charge = 0;
var opp_price = 0;

var parts_obj;
var partPrice = 0;
var paperPrice = 0;
var unit_price = 0;

function setToInput() {
	clearValue();
	var vno_of_order = document.getElementById('qty');

	if (vno_of_order.value != "") {


		if ($('input[name=ItemType]').val() == "フライトタグ（刺繍タグキーホルダー）") {
			if ($('input[name=ft_type]:checked').val() == "刺繍") {
				if (vno_of_order.value >= 3000) order_pcs = ft_1[5];
				else if (vno_of_order.value >= 1000) order_pcs = ft_1[4];
				else if (vno_of_order.value >= 500) order_pcs = ft_1[3];
				else if (vno_of_order.value >= 300) order_pcs = ft_1[2];
				else if (vno_of_order.value >= 100) order_pcs = ft_1[1];
				else if (vno_of_order.value >= 50) order_pcs = ft_1[0];
			} else if ($('input[name=ft_type]:checked').val() == "ジャガード織") {
				if (vno_of_order.value >= 3000) order_pcs = ft_2[5];
				else if (vno_of_order.value >= 1000) order_pcs = ft_2[4];
				else if (vno_of_order.value >= 500) order_pcs = ft_2[3];
				else if (vno_of_order.value >= 300) order_pcs = ft_2[2];
				else if (vno_of_order.value >= 100) order_pcs = ft_2[1];
				else if (vno_of_order.value >= 50) order_pcs = ft_2[0];
			}
		}

		if ($('input[name=ItemType]').val() == "オリジナル刺繍ワッペン・パッチ") {
			if ($('input[name=ft_type]:checked').val() == "刺繍") {
				if (vno_of_order.value >= 3000) order_pcs = wp_1[5];
				else if (vno_of_order.value >= 1000) order_pcs = wp_1[4];
				else if (vno_of_order.value >= 500) order_pcs = wp_1[3];
				else if (vno_of_order.value >= 300) order_pcs = wp_1[2];
				else if (vno_of_order.value >= 100) order_pcs = wp_1[1];
				else if (vno_of_order.value >= 50) order_pcs = wp_1[0];
			} else if ($('input[name=ft_type]:checked').val() == "ジャガード織") {
				if (vno_of_order.value >= 3000) order_pcs = wp_2[5];
				else if (vno_of_order.value >= 1000) order_pcs = wp_2[4];
				else if (vno_of_order.value >= 500) order_pcs = wp_2[3];
				else if (vno_of_order.value >= 300) order_pcs = wp_2[2];
				else if (vno_of_order.value >= 100) order_pcs = wp_2[1];
				else if (vno_of_order.value >= 50) order_pcs = wp_2[0];
			}
		}

		if ($('input[name=ItemType]').val() == "刺繍キーホルダー") {
			if ($('input[name=ft_type]:checked').val() == "刺繍") {
				if (vno_of_order.value >= 3000) order_pcs = kh_1[5];
				else if (vno_of_order.value >= 1000) order_pcs = kh_1[4];
				else if (vno_of_order.value >= 500) order_pcs = kh_1[3];
				else if (vno_of_order.value >= 300) order_pcs = kh_1[2];
				else if (vno_of_order.value >= 100) order_pcs = kh_1[1];
				else if (vno_of_order.value >= 50) order_pcs = kh_1[0];
			} else if ($('input[name=ft_type]:checked').val() == "ジャガード織") {
				if (vno_of_order.value >= 3000) order_pcs = kh_2[5];
				else if (vno_of_order.value >= 1000) order_pcs = kh_2[4];
				else if (vno_of_order.value >= 500) order_pcs = kh_2[3];
				else if (vno_of_order.value >= 300) order_pcs = kh_2[2];
				else if (vno_of_order.value >= 100) order_pcs = kh_2[1];
				else if (vno_of_order.value >= 50) order_pcs = kh_2[0];
			}
		}

		if ($('input[name=ItemType]').val() == "オリジナル刺繍バッジ") {
			if ($('input[name=ft_type]:checked').val() == "刺繍") {
				if (vno_of_order.value >= 3000) order_pcs = kh_1[5];
				else if (vno_of_order.value >= 1000) order_pcs = kh_1[4];
				else if (vno_of_order.value >= 500) order_pcs = kh_1[3];
				else if (vno_of_order.value >= 300) order_pcs = kh_1[2];
				else if (vno_of_order.value >= 100) order_pcs = kh_1[1];
				else if (vno_of_order.value >= 50) order_pcs = kh_1[0];
			} else if ($('input[name=ft_type]:checked').val() == "ジャガード織") {
				if (vno_of_order.value >= 3000) order_pcs = kh_2[5];
				else if (vno_of_order.value >= 1000) order_pcs = kh_2[4];
				else if (vno_of_order.value >= 500) order_pcs = kh_2[3];
				else if (vno_of_order.value >= 300) order_pcs = kh_2[2];
				else if (vno_of_order.value >= 100) order_pcs = kh_2[1];
				else if (vno_of_order.value >= 50) order_pcs = kh_2[0];
			}
		}

		if ($('input[name=ItemType]').val() == "刺繍コースター") {
			if ($('input[name=ft_type]:checked').val() == "刺繍") {
				if (vno_of_order.value >= 3000) order_pcs = ct_1[5];
				else if (vno_of_order.value >= 1000) order_pcs = ct_1[4];
				else if (vno_of_order.value >= 500) order_pcs = ct_1[3];
				else if (vno_of_order.value >= 300) order_pcs = ct_1[2];
				else if (vno_of_order.value >= 100) order_pcs = ct_1[1];
				else if (vno_of_order.value >= 50) order_pcs = ct_1[0];
			} else if ($('input[name=ft_type]:checked').val() == "ジャガード織") {
				if (vno_of_order.value >= 3000) order_pcs = ct_2[5];
				else if (vno_of_order.value >= 1000) order_pcs = ct_2[4];
				else if (vno_of_order.value >= 500) order_pcs = ct_2[3];
				else if (vno_of_order.value >= 300) order_pcs = ct_2[2];
				else if (vno_of_order.value >= 100) order_pcs = ct_2[1];
				else if (vno_of_order.value >= 50) order_pcs = ct_2[0];
			}
		}

		// Get part price
		if ($('input[name="part"]').length && parts_obj != undefined) {
			var part = $('input[name="part"]:checked').val();

			if (part != undefined) {
				partPrice = Math.floor(parts_obj["part_price"] * (1 + vat / 100));
				$('#sample-part-pic').show();
				$('#sample-part-pic').attr('src', parts_obj["part_pic"]);
				$('#sample-part-name').text(parts_obj["part_name"]);
			} else {
				part = "";
				partPrice = 0;
				$('#sample-part-pic').hide();
				$('#sample-part-name').text('');
			}
		}

		$('#sample-prd-prdt').text($('input[name=ItemType]').val());
		$('#prd_production').text($('input[name=ItemType]').val());

		$('#sample-prd-type').text($('input[name=ft_type]:checked').val());
		$('#prd_type').text($('input[name=ft_type]:checked').val());

		$('#prd_material').text($('input[name=ft_option]:checked').val());


		if ($('input[name=ft_fabric_color1]:checked').val() != undefined) {

		}


		if ($('input[name=ft_fabric_color2]:checked').val() != undefined) {

		}
	}

	$('#prd_processing').text($('input[name=ft_process]:checked').val() + ($('input[name=ft_process]:checked').val() != "オーバーロック仕上げ" ? "" :
		($('select[name=ft_overlock_color]').length ? "(" + $('select[name=ft_overlock_color] option:selected').val() + ")" : "")));

	$('#sample-prd-qty').text(vno_of_order.value);
	$('#prd_amount').text(vno_of_order.value);

	if ($('input[name=ft_backside]').length) {
		if ($('input[name=ft_backside]:checked').val() == "デザインあり" || $('input[name=ft_backside]:checked').val() == "ロック式の安全ピン") {
			$('#prd_backside').text($('input[name=ft_backside]:checked').val());
		} else {
			if ($('select[name=ft_backside_type]').length) {
				$('#prd_backside').text($('select[name=ft_backside_type] option:selected').val());
			} else {
				$('#prd_backside').text($('input[name=ft_backside]:checked').val());
			}
		}
	} else {
		if ($('select[name=ft_backside_type]').length) {
			$('#prd_backside').text($('select[name=ft_backside_type] option:selected').val());
		}
	}

	if ($('input[name=ft_sample]:checked').val() != undefined) {
		if (vno_of_order.value < 300) {
			proto_charge = 5500;
		} else {
			proto_charge = 0;
		}
		// proto_charge = 0;
		$('#prd_sample').text('あり');
		$('#sample-prd-samp').text('あり');
	} else {
		$('#prd_sample').text('なし');
		$('#sample-prd-samp').text('なし');
	}

	if ($('input[name=ft_trace]:checked').val() != undefined) {
		trace_charge = 2200;
		$('#prd_trace').text('あり');
	} else {
		$('#prd_trace').text('なし');
	}

	if ($('input[name=ft_opp]:checked').val() != undefined) {
		opp_price = 8;
		$('#prd_opp').text('あり');
		$('#sample-prd-opp').text('あり');
	} else {
		opp_price = 0;
		$('#prd_opp').text('なし');
		$('#sample-prd-opp').text('なし');
	}

	$('#prd_qty').text(vno_of_order.value);
	if ($('#prd_part').length) {
		if ($('input[name=ft_attach_type]').length) {
			$('#prd_part').text(part + "(" + $('input[name=ft_attach_type]:checked').val() + ")");
		} else {
			$('#prd_part').text(part);
		}
	}

	// Assign Value
	TextField7Value = Math.floor(order_pcs) * vno_of_order.value;
	// Amount Before Tax
	TextField9Value = parseInt(TextField7Value) + proto_charge + (opp_price * vno_of_order.value) + trace_charge + (partPrice * vno_of_order.value);

	DisPrice = 0;

	// discount setup by timer
	let timer = new Date().toISOString();

	let startDate = new Date("2024-01-24T00:00:00");
	let endDate = new Date("2024-02-16T23:59:00");

	if (timer > startDate.toISOString() && timer < endDate.toISOString()) {
		DisPrice = Math.floor(parseInt(TextField9Value * 0.05));
	}

	tax = Math.floor(Math.floor((TextField7Value) * vat / (100 + vat)) + Math.floor(proto_charge * vat / (100 + vat)) + Math.floor(trace_charge * vat / (100 + vat)) + Math.floor((partPrice * vno_of_order.value) * vat / (100 + vat)) +
		Math.floor((opp_price * vno_of_order.value) * vat / (100 + vat))) - Math.floor(DisPrice * vat / (100 + vat));


	// tax = tax - Math.floor(tax*vat/100);
	total = (parseInt(TextField9Value) - parseInt(DisPrice));

	document.getElementById('prd_sample_price').value = (proto_charge).toLocaleString("en");
	document.getElementById('prd_trace_price').value = (trace_charge).toLocaleString("en");
	document.getElementById('prd_opp_price').value = (opp_price * vno_of_order.value).toLocaleString("en");
	if ($('#prd_part_price').length) {
		document.getElementById('prd_part_price').value = ((partPrice * vno_of_order.value)).toLocaleString("en");
	}

	document.getElementById('prd_price').value = (TextField7Value).toLocaleString("en");

	// document.getElementById('textfield8').value = formatMoney(shipping_charge);
	document.getElementById('prd_sub_total').value = (parseInt(TextField9Value)).toLocaleString("en");
	document.getElementById('discount').value = (parseInt(DisPrice)).toLocaleString("en");
	// document.getElementById('textfield10').value = formatMoney(tax);
	document.getElementById('prd_total').value = (total).toLocaleString("en");
	$('.prd_total').text(formatMoney(total).toLocaleString("en"));
	// document.getElementById('textfield12').value = formatMoney(printumu);
}
};

function changeOptionValues(prefix, startIndex, selectName) {
	var color_f_arr = [
		'108 （赤色）', '63 （緑）', '83 （紺藍）', '76 （紅赤）', '30 （オレンジ色）',
		'131 （えんじ）', '78 （藤紫）', '74 （紫色）', '135 （山吹色）', '32 （黄色）',
		'9 （ピンク）', '94 （茶色）', '35（黄緑色）', '66（ビリジアン）', '46（スカイブルー）',
		'52（青色））', '12（牡丹色）', '129（灰色）', '123（黒色）', '1（白）',
		'88（ネイビー）', '126（ダークブルー）'
	];
	var color_t_arr = [
		'T184（赤色）', 'T223（緑色）', 'T47（紺藍）', 'T244（紅赤）', 'T142（オレンジ色）',
		'T95（えんじ）', 'T202（藤紫）', 'T258（紫色）', 'T214（山吹色）', 'T54（黄色）',
		'T122（ピンク）', 'T219（茶色）', 'T24（黄緑色）', 'T218（ビリジアン）', 'T32（スカイブルー）',
		'T37（青色）', 'T198（牡丹色）', 'T256（灰色）', '1.2mmBLACA（黒色）', 'T01B（白）',
		'T199（ネイビー）', 'T108（ダークブルー）'
	];
	// Loop through options for the specified select name
	if ($("select[name='" + selectName + "'] option").length) {
		$("select[name='" + selectName + "'] option").each(function (index) {
			if ($(this).val() != "表と同じ") {
				var newValue = (prefix === "f") ? prefix + "-" + (index + startIndex) : prefix + "-" + (index + startIndex);
				$(this).text(newValue);
			} else {
				--startIndex;
			}
		});
	} else if ($('input[name=ft_fabric_color1]:checked').val() != undefined) {
		if ($('.STD_printing_color1').length) {
			if (prefix == "t") {
				$('.STD_printing_color1').each(function (index) {
					// console.log($(this).closest('td').find('img').attr('src'));
					$(this).attr('value', color_f_arr[index]);
					if ($(this).closest('td').find('img').attr('src') != undefined) {
						$(this).closest('td').find('img').attr('src', 'images/flight_tag/icon-' + formatNumber(index) + '.webp');
					}
				})
			} else {
				$('.STD_printing_color1').each(function (index) {
					// console.log($(this).closest('td').find('img').attr('src'));
					$(this).attr('value', color_t_arr[index]);
					if ($(this).closest('td').find('img').attr('src') != undefined) {
						$(this).closest('td').find('img').attr('src', 'images/flight_tag/wappen-icon-' + formatNumber(index) + '.webp');
					}
				})
			}
		}
		if ($('.STD_printing_color2').length) {
			if (prefix == "t") {
				$('.STD_printing_color2').each(function (index) {
					// console.log($(this).closest('td').find('img').attr('src'));
					$(this).attr('value', color_f_arr[index]);
					if ($(this).closest('td').find('img').attr('src') != undefined) {
						$(this).closest('td').find('img').attr('src', 'images/flight_tag/icon-' + formatNumber(index) + '.webp');
					}
				})
			} else {
				$('.STD_printing_color2').each(function (index) {
					// console.log($(this).closest('td').find('img').attr('src'));
					$(this).attr('value', color_t_arr[index]);
					if ($(this).closest('td').find('img').attr('src') != undefined) {
						$(this).closest('td').find('img').attr('src', 'images/flight_tag/wappen-icon-' + formatNumber(index) + '.webp');
					}
				})
			}
		}
	}

}

function clearValue() {
	order_pcs = 0;
	unit_price = 0;
	pcs_price = 0;
	before_tax = 0;
	tax = 0;
	total = 0;
	silkprint = 0;
	TextField7Value = 0;
	TextField9Value = 0;
	DisPrice = 0;
	proto_charge = 0;
	trace_charge = 0;
	design_price = 0;

	document.getElementById('prd_opp_price').value = "";
	document.getElementById('prd_sample_price').value = "";

	document.getElementById('prd_price').value = "";
	document.getElementById('prd_sub_total').value = "";
	document.getElementById('prd_total').value = "";
}

function setzero() {
	order_pcs = 0;
	unit_price = 0;
	pcs_price = 0;
	before_tax = 0;
	tax = 0;
	total = 0;
	silkprint = 0;
	TextField7Value = 0;
	TextField9Value = 0;
	DisPrice = 0;
	proto_charge = 0;
	trace_charge = 0;
	design_price = 0;

	document.getElementById('prd_opp_price').value = "";
	document.getElementById('prd_trace_price').value = "";
	document.getElementById('prd_sample_price').value = "";

	document.getElementById('prd_price').value = "";
	document.getElementById('prd_sub_total').value = "";
	document.getElementById('prd_total').value = "";

	$("input[name=ft_type]:first").prop('checked', true);
	$("input[name=ft_option]:first").prop('checked', true);

	$("input[name=ft_sample]").prop('checked', false);
	$("input[name=ft_opp]").prop('checked', false);

	document.getElementById('qty').value = "";
}

///comma////
function formatMoney(inum) {
	if (inum == '0' || inum == '') {
		return inum;
	}
	var s_inum = new String(inum);
	var s_inumInt = s_inum.split(".", s_inum);
	var l_inum = s_inumInt[0].length;
	var n_inum = "";
	for (i = 0; i < l_inum; i++) {
		if (parseInt(l_inum - i) % 3 == 0) {
			if (i == 0) {
				n_inum += s_inum.charAt(i);
			} else {
				n_inum += "," + s_inum.charAt(i);
			}
		} else {
			n_inum += s_inum.charAt(i);
		}
	}
	if (s_inumInt[1] != undefined) {
		n_inum += "." + s_inumInt[1];
	}
	return n_inum;
}

///input only number////
function check_num() {
	m = String.fromCharCode(event.keyCode);
	if ("0123456789\b\r".indexOf(m, 0) < 0) return false;
	return true;
}

//clear 0 first char
function format_number(number) {
	if (number != "") {
		number = parseInt(number) + 0;
	}
	return number;
}

function getPartData(v) {
	if ($('input[name=ItemType]').val() == "フライトタグ（刺繍タグキーホルダー）") {
		$.get("part_flight_tag.php", { c: "passed" }, function (data) {
			var duce = $.parseJSON(data);
			for (var i = 0; i < duce.length; i++) {
				if (duce[i]['part_name'] == v) {
					parts_obj = duce[i];
				}
			}
		}).done(function () {
			setToInput();
		})
	} else if ($('input[name=ItemType]').val() == "刺繍キーホルダー") {
		$.get("part_flight_tag_keyholder.php", { c: "passed" }, function (data) {
			var duce = $.parseJSON(data);
			for (var i = 0; i < duce.length; i++) {
				if (duce[i]['part_name'] == v) {
					parts_obj = duce[i];
				}
			}
		}).done(function () {
			setToInput();
		})
	}

}

function chk_color() {
	var color_1 = "";
	var color_2 = "";

	if ($('input[name=ft_fabric_color1]:checked').val() != undefined) {
		color_1 = $('input[name=ft_fabric_color1]:checked').val();
		if ($('input[name=ft_fabric_color1]:checked').parent().find('img').attr('src') != "") {
			$('#img-show-Insatsu1').removeClass('d-none');
			$('#img-show-Insatsu1').attr('src', $('input[name=ft_fabric_color1]:checked').parent().find('img').attr('src'));
			$('#txt-show-Insatsu1').removeClass('d-none');
			$('#txt-show-Insatsu1').text(color_1);
		}
		if (color_1 == "PANTONE/DIC指定") {
			$('#img-show-Insatsu1').addClass('d-none');
			$('#img-show-Insatsu1').attr('src', "");
			$('#txt-show-Insatsu1').removeClass('d-none');
			$('#txt-show-Insatsu1').text('PANTONE/DIC指定');
		}

	}
	if ($('input[name=ft_fabric_color2]:checked').val() != undefined) {
		color_2 = $('input[name=ft_fabric_color2]:checked').val();
		if ($('input[name=ft_fabric_color2]:checked').parent().find('img').attr('src') != "") {
			$('#img-show-Insatsu2').removeClass('d-none');
			$('#img-show-Insatsu2').attr('src', $('input[name=ft_fabric_color2]:checked').parent().find('img').attr('src'));
			$('#txt-show-Insatsu2').removeClass('d-none');
			$('#txt-show-Insatsu2').text(color_2);
		}
		if (color_2 == "PANTONE/DIC指定") {
			$('#img-show-Insatsu2').addClass('d-none');
			$('#img-show-Insatsu2').attr('src', "");
			$('#txt-show-Insatsu2').removeClass('d-none');
			$('#txt-show-Insatsu2').text('PANTONE/DIC指定');
		}

	}
}


$(function () {
	$('.STD_printing_color1, .STD_printing_color2').click(function () {
		chk_color();
	});
})

function formatNumber(number) {
	if (number >= 0 && number <= 8) {
		// Add leading zero for numbers between 0 and 9
		return '0' + (number + 1);
	} else if (number >= 9) {
		// Numbers between 10 and 22 remain unchanged
		return '' + (number + 1);
	}

	if ($('input[name=ft_type]:checked').val() == '昇華転写') {
		$('.only_embro').hide();
	} else {
		$('.only_embro').show();
	}
	$('#prd_fabric_color1').text($('input[name=ft_fabric_color1]:checked').val());
	$('#prd_fabric_color2').text($('input[name=ft_fabric_color2]:checked').val());
	$('#prd_printing_color1').text($('input[name=ft_printing_color1]:checked').val());
	$('#prd_printing_color2').text($('input[name=ft_printing_color2]:checked').val());
}
