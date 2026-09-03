<?php
/* date create : 2018-06-08 */
/* function lang change */
function lang($txt,$lang){
	if($lang == "th"||$lang == "en"){
		switch ($txt) {
			case "ye":echo "บริษัทยู แอนด์ เอิร์ธ ซิสเท็ม จำกัด";break;
			case "wellcome":echo "ยินดีต้อนรับ";break;
			case "home":echo "หน้าหลัก";break;
			case "product":echo "สินค้าทั้งหมด";break;
			case "orders":
			case "order":echo "สั่งซื้อสินค้า";break;
			case "aboutus":echo "เกี่ยวกับเรา";break;
			case "contact":echo "ติดต่อเรา";break;
			case "hotitem":echo ":: สินค้ายอดนิยม ::";break;
			case "sale":echo "ติดต่อฝ่ายขาย";break;
			case "customer":echo ":: ลูกค้าของเรา ::";break;
			case "seeother":echo "ดูเพิ่มเติม";break;
			case "premium":echo "สายคล้องคอพนักงานแบบพรีเมี่ยม";break;
			case "poly":echo "สายคล้องคอพนักงานผ้าโพลีเอสเตอร์";break;
			case "nylon":echo "สายคล้องคอพนักงานผ้าไนลอน";break;
			case "fullcolor":echo "สายคล้องคอพนักงานสกรีนแบบซับลิเมชั่น";break;
			case "carabiner":echo "คาราบิเนอร์";break;
			case "tel":echo "โทร";break;
			case "fax":echo "แฟกซ์";break;
			case "work_day":echo "จันทร์-ศุกร์";break;
			case "lanyard":echo "สายคล้องคอพนักงาน";break;
			case "other":echo "สินค้าอื่นๆ";break;
			case "moredetail":echo "รายละเอียดเพิ่มเติม";break;
			case "casecard":echo "ซองใสใส่บัตรพนักงาน";break;
			case "pucase":echo "ซองหนังใส่บัตรพนักงาน";break;
			case "color":echo "สีเชือก";break;
			case "detail":echo "รายละเอียด";break;
			case "inquiry":echo "แบบฟอร์มคำถาม";break;
			case "subject":echo "หัวข้อ";break;
			case "about_prd":echo "สินค้าหรือบริการ";break;
			case "urgent":echo "เร่งด่วน";break;
			case "sale_request":echo "นัดหมายฝ่ายขาย";break;
			case "others":echo "อื่นๆ";break;
			case "typing":echo "กรอกที่นี่...";break;
			case "name":echo "ชื่อ - นามสกุล";break;
			case "company":echo "บริษัท";break;
			case "email":echo "อีเมล์";break;
			case "phone":echo "เบอร์โทรศัพท์";break;
			case "message":echo "ข้อความ";break;
			case "contact_id":echo "รหัสการติดต่อ";break;
			case "product_name":echo "ชื่อสินค้า";break;
			case "product_size":echo "ขนาดเชือก";break;
			case "product_color":echo "สีเชือก";break;
			case "product_part":echo "พาร์ทเชือก";break;
			case "cus_name":echo "ชื่อลูกค้า";break;
			case "color_use":echo "สีที่ใช้";break;
			case "part_use":echo "พาร์ทที่ใช้";break;
			case "other_detail":echo "ดูรายละเอียดเพิ่มเติม";break;
			case "click_here":echo "คลิกที่นี่";break;
		}
	}
	// else if($lang == "en"){
	// 	switch ($txt) {
	// 		case "ye":echo "You And Earth Co.,Ltd";break;
	// 		case "wellcome":echo "Welcome";break;
	// 		case "home":echo "HOME";break;
	// 		case "product":echo "PRODUCT";break;
	// 		case "orders":echo "ORDERS";break;
	// 		case "aboutus":echo "ABOUT US";break;
	// 		case "contact":echo "CONTACT US";break;
	// 		case "hotitem":echo ":: HOTITEM ::";break;
	// 		case "sale":echo "contact sale";break;
	// 		case "customer":echo ":: CUSTOMER ::";break;
	// 		case "order":echo "order";break;
	// 		case "seeother":echo "see more";break;
	// 		case "premium":echo "Premium Lanyard";break;
	// 		case "poly":echo "Polyester Lanyard";break;
	// 		case "nylon":echo "Nylon Lanyard";break;
	// 		case "fullcolor":echo "Sublimation Lanyard";break;
	// 		case "tel":echo "Tel";break;
	// 		case "fax":echo "Fax";break;
	// 		case "work_day":echo "Mon-Fri";break;
	// 		case "lanyard":echo "Lanyard";break;
	// 		case "other":echo "Other products";break;
	// 		case "moredetail":echo "More detail";break;
	// 		case "casecard":echo "Case card";break;
	// 		case "pucase":echo "PU case card";break;
	// 		case "color":echo "Lanyard color";break;
	// 		case "detail":echo "Lanyard detail";break;
	// 		case "inquiry":echo "Inquiry form";break;
	// 		case "subject":echo "Subject";break;
	// 		case "about_prd":echo "สินค้าหรือบริการ";break;
	// 		case "urgent":echo "Urgent";break;
	// 		case "sale_request":echo "Sale request";break;
	// 		case "others":echo "Other";break;
	// 		case "typing":echo "typing here...";break;
	// 		case "name":echo "Name";break;
	// 		case "company":echo "Company";break;
	// 		case "email":echo "E-mail";break;
	// 		case "phone":echo "Phone";break;
	// 		case "message":echo "Message";break;
	// 		case "contact_id":echo "Contact id";break;
	// 		case "product_name":echo "Product name";break;
	// 		case "product_size":echo "Product size";break;
	// 		case "product_color":echo "Product color";break;
	// 		case "product_part":echo "Product parts";break;
	// 		case "cus_name":echo "Customer name";break;
	// 		case "color_use":echo "Color's use";break;
	// 		case "part_use":echo "Part's use";break;
	// 		case "other_detail":echo "More detail";break;
	// 		case "click_here":echo "click here";break;
	// 	}
	// }
}
function ttt($txt){
	switch ($txt) {
		case "font":return "พิมพ์ด้านหน้าอย่างเดียว";break;
		case "all":return "พิมพ์หน้าหลัง";break;
		case "premium":return "สายคล้องคอพนักงานแบบพรีเมี่ยม";break;
		case "poly":return "สายคล้องคอพนักงานผ้าโพลีเอสเตอร์";break;
		case "nylon":return "สายคล้องคอพนักงานผ้าไนลอน";break;
		case "fullcolor":return "สายคล้องคอพนักงานสกรีนแบบซับลิเมชั่น";break;
		case "n_1":return "ตะขอ(N-1)";break;
		case "n_14":return "ตะขอ(N-14)";break;
		case "n_7":return "ตะขอ(N-7)";break;
		case "n_4":return "ตะขอ(N-4)";break;
		case "n_15a":return "คลิปยูโร(N-15-A)";break;
		case "n_15b":return "คลิปยูโร(N-15-B)";break;
		case "n_10":return "ตัวหนีบ(N-10)";break;
		case "n_20":return "ตะขอPVC(N-20)";break;
		case "clip_steel":return "คลิปหนีบ(Steel Clip)";break;
		case "PM1_1":return "คลิปดำ";break;
		case "PM1_2":return "คลิปขาว";break;
		case "S_1":return "ตัวเลื่อนปรับความยาวA";break;
		case "S_2":return "ตัวเลื่อนปรับความยาวB";break;
		case "S_3":return "ตัวเลื่อนปรับความยาวC";break;
		case "S_4":return "ตัวเลื่อนปรับความยาวE";break;
		case "S_7":return "ตัวล็อคแบบหนีบ";break;
		case "B_1":return "กล้ามปูB_1";break;
		case "M_1":return "สายคล้องโทรศัพท์";break;
		case "SP_1":return "เซฟตี้พาร์ท";break;
		case "ID_STD_1":return "ซองใส่บัตรแบบอ่อน";break;
		case "ID_STD_2":return "ซองใส่บัตรแบบอ่อน STD-2";break;
		case "ID_STD_3":return "ซองใส่บัตรแบบอ่อน STD-3";break;
		case "ID_1_N":return "ซองใส่บัตรแบบอ่อน 1_N";break;
		case "ID_1_NZ":return "ซองใส่บัตรแบบอ่อน 1_NZ";break;
		case "ID_2_N":return "ซองใส่บัตรแบบอ่อน 2_N";break;
		case "ID_3_N":return "ซองใส่บัตรแบบอ่อน 3_N";break;
		case "ID_4_N":return "ซองใส่บัตรแบบอ่อน 4_N";break;
		case "ID_4_NZ":return "ซองใส่บัตรแบบอ่อน 4_N";break;
		case "ID_5_NZ":return "ซองใส่บัตรแบบอ่อน 5_N";break;
		case "ID_6_N":return "ซองใส่บัตรแบบอ่อน 6_N";break;
		case "ID_6_NZ":return "ซองใส่บัตรแบบอ่อน 6_NZ";break;
		case "ID_8_N":return "ซองใส่บัตรแบบอ่อน 8_N";break;
		case "ID_9_N":return "ซองใส่บัตรแบบอ่อน 9_N";break;
		case "ID_AC01":return "ซองใส่บัตรแบบอ่อน AC01";break;
		case "ID_AC02":return "ซองใส่บัตรแบบอ่อน AC02";break;
		case "ID_F001":return "ซองใส่บัตรแบบกรอบแข็ง F001";break;
		case "ID_F002":return "ซองใส่บัตรแบบกรอบแข็ง F002";break;
		case "ID_F003":return "ซองใส่บัตรแบบกรอบแข็ง F003";break;
		case "ID_F004":return "ซองใส่บัตรแบบกรอบแข็ง F004";break;
		case "none":return "ไม่รับซองใส่บัตร";break;
		case "pastic_part":return "ตะขอพลาสติก(N-12)";break;
		case "mobile_01":return "สายห้อยโทรศัพท์มือถือ(แบบถอดได้)";break;
		case "Oring":return "ห่วงวงกลม";break;
		case "D_ring":return "ห่วงครึ่งวงกลม";break;
	}
}

/* cont of images, js, css version */
$img_v = 1.00;
$css_v = 1.00;
$js_v = 1.00;
$url = "//hotstrapthai.com";
?>
