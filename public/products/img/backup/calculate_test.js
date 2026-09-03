	$(function(){
		$('#cal_case').click(function(){
			get_case_price();
		});
	});
	var num0=0;
	var num1=50;
	var num2=100;
	var num3=300;
	var num4=500;
	var num5=1000;
	var num6=3000;

	var numUnitCardPrice = {
		"1Card":[{"num":num0, "price":0},
			{"num":num1, "price":0},
			{"num":num2, "price":0},
			{"num":num3, "price":0},
			{"num":num4, "price":0},
			{"num":num5, "price":0},
			{"num":num6, "price":0}
		],
		"2Card":[{"num":num0, "price":12},
			{"num":num1, "price":12},
			{"num":num2, "price":10},
			{"num":num3, "price":10},
			{"num":num4, "price":10},
			{"num":num5, "price":9},
			{"num":num6, "price":9}
		],
		"3Card":[{"num":num0, "price":12},
			{"num":num1, "price":12},
			{"num":num2, "price":10},
			{"num":num3, "price":10},
			{"num":num4, "price":10},
			{"num":num5, "price":9},
			{"num":num6, "price":9}
		],
		"4Card":[{"num":num0, "price":17},
			{"num":num1, "price":17},
			{"num":num2, "price":14},
			{"num":num3, "price":14},
			{"num":num4, "price":14},
			{"num":num5, "price":13},
			{"num":num6, "price":13}
		],
		"5Card":[{"num":num0, "price":20},
			{"num":num1, "price":20},
			{"num":num2, "price":16},
			{"num":num3, "price":16},
			{"num":num4, "price":16},
			{"num":num5, "price":15},
			{"num":num6, "price":15}
		],
		"6Card":[{"num":num0, "price":12},
			{"num":num1, "price":12},
			{"num":num2, "price":10},
			{"num":num3, "price":10},
			{"num":num4, "price":10},
			{"num":num5, "price":9},
			{"num":num6, "price":9}
		],
		"7Card":[{"num":num0, "price":12},
			{"num":num1, "price":12},
			{"num":num2, "price":10},
			{"num":num3, "price":10},
			{"num":num4, "price":10},
			{"num":num5, "price":9},
			{"num":num6, "price":9}
		],
		"8Card":[{"num":num0, "price":20},
			{"num":num1, "price":20},
			{"num":num2, "price":16},
			{"num":num3, "price":16},
			{"num":num4, "price":16},
			{"num":num5, "price":15},
			{"num":num6, "price":15}
		],
		"9Card":[{"num":num0, "price":25},
			{"num":num1, "price":25},
			{"num":num2, "price":21},
			{"num":num3, "price":21},
			{"num":num4, "price":21},
			{"num":num5, "price":19},
			{"num":num6, "price":19}
		],
		"10Card":[{"num":num0, "price":20},
			{"num":num1, "price":20},
			{"num":num2, "price":20},
			{"num":num3, "price":20},
			{"num":num4, "price":15},
			{"num":num5, "price":15},
			{"num":num6, "price":15}
		],
		"11Card":[{"num":num0, "price":20},
			{"num":num1, "price":20},
			{"num":num2, "price":20},
			{"num":num3, "price":20},
			{"num":num4, "price":12},
			{"num":num5, "price":12},
			{"num":num6, "price":12}
		],
		"12Card":[{"num":num0, "price":8},
			{"num":num1, "price":8},
			{"num":num2, "price":8},
			{"num":num3, "price":8},
			{"num":num4, "price":8},
			{"num":num5, "price":8},
			{"num":num6, "price":8}
		]
	};

function get_case_price(){
	var casePrice = 0;var qty = $('#qty_case') .val();
	switch(Case.val()){
				case "ID_STD_1":
				case "ID_STD_2":
				case "ID_STD_3":
					var caseData = numUnitCardPrice['1Card'];
					get_case_remark();
				break;
				case "ID_1_N":
				case "ID_1_NZ":var caseData = numUnitCardPrice['2Card'];get_case_remark();break;
				case "ID_2_N":var caseData = numUnitCardPrice['3Card'];get_case_remark();break;
				case "ID_3_N":var caseData = numUnitCardPrice['4Card'];get_case_remark();break;
				case "ID_4_N":
				case "ID_4_NZ":var caseData = numUnitCardPrice['5Card'];get_case_remark();break;
				case "ID_5_NZ":var caseData = numUnitCardPrice['6Card'];get_case_remark();break;
				case "ID_6_N":
				case "ID_6_NZ":var caseData = numUnitCardPrice['7Card'];get_case_remark();break;
				case "ID_8_N":var caseData = numUnitCardPrice['8Card'];get_case_remark();break;
				case "ID_9_N":var caseData = numUnitCardPrice['9Card'];get_case_remark();break;
				case "ID_F001":case "ID_F002":var caseData = numUnitCardPrice['10Card'];get_case_remark();break;
				case "ID_F003":case "ID_F004":var caseData = numUnitCardPrice['11Card'];get_case_remark();break;
				case "ID_AC01":case "ID_AC02":
				var caseData = numUnitCardPrice['12Card'];get_case_remark();break;
			}
	if (caseData == undefined) {
		var caseData = 0;
	}
	for (var i = 0, iMax = caseData.length; i < iMax; i++) {
		if (parseInt(qty) >= parseInt(caseData[i].num)) {
			casePrice = caseData[i].price;
			continue;
		}
		break;
	}
	$("#show-price").text("ประเภทซองใส่บัตรพนักงาน: "+Case.find('option:selected').text()+" ราคาต่อชิ้น "+r_num(casePrice)+" บาท จำนวน "+qty+" ชิ้น รวมทั้งสิ้น "+r_num(casePrice*qty)+" บาท");
}

function get_case_remark(){

	$("#show-remark").text('หมายเหตุ: แถมฟรีเมื่อสั่งซื้อพร้อมสายคล้องบัตร, หมายเหตุ: ราคานี้เป็นราคาเมื่อสั่งซื้อพร้อมสายคล้องบัตร หากต้องการสั่งซื้อเฉพาะซองใส่บัตรราคานี้ยังไม่รวมค่าจัดส่ง');
}
