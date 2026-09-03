
/*********** input validation ***********/ 
function validation(){	
        
        var number_result = validation_numberOf();
        // var prototype_result = validation_prototype();


	if (number_result) {
		return false;}
	else{
        return true;
	}
}


function validation_numberOf() {
	//入力値
	var vNumberOfOder = document.getElementById('no_of_order');

	//エラー出力用id
	var err_number = document.getElementById('err_numberOf_mess');
	var mess = "";

	err_number.style.display = "";
	
	var cleaner_rubber = document.getElementById('cleaner_rubber');
	if (cleaner_rubber.checked) {
		if (vNumberOfOder.value == '' ||  vNumberOfOder.value < 300) {
			mess += "<font color='red'>本数は3００本以上で入力して下さい</font>";
			err_number.innerHTML = mess;
			return false;
		}
	}
	if ( isNaN(vNumberOfOder.value) ) {
		mess += "<font color='red'>半角数値以外が入力されています。</font>";
		err_number.innerHTML = mess;
		return false;
	} else if( vNumberOfOder.value == '' || vNumberOfOder.value < 100 ){
		mess += "<font color='red'>本数は100本以上で入力して下さい。</font>";
		err_number.innerHTML = mess;
		return false;
	} else if( vNumberOfOder.value > 50000 ){
		mess += "<font color='red'>本数は50000本以下で入力して下さい。50000以上のお客様は納期をメールにてお問い合わせ下さい。</font>";
		err_number.innerHTML = mess;
		return false;
        } else {
		err_number.style.display = "none";
		return true;
	}
	
	
}

// function validation_prototype() {
// 	//入力値
// 	var vprototype = document.getElementById('SendPrototype');
// 	var vNumberOfOder = document.getElementById('no_of_order');
	
// 	//エラー出力用id
// 	var err_prototype = document.getElementById('err_prototype_mess');
// 	var mess = "";

// 	err_prototype.style.display = "";

// 	if ( document.getElementById('No').checked && vNumberOfOder.value > 499  ) {
// 		mess += "<font color='red'>500本以上のご注文では、実物の確認をお願いしています。</font>";
// 		err_prototype.innerHTML = mess;
// 		return false;
// 	} else {
// 		err_prototype.style.display = "none";
// 		return true;
// 	}
// }
/************** format *****************/
///check bt////
function check_agree(){
	//non
	// var obj1 = document.getElementById('file1');
	//==>
	var obj2 = document.getElementById('file2');
	var obj3 = document.getElementById('design_filename');

	var vitemkeitai = document.getElementById('keitai');
	var vitemkeyholder = document.getElementById('keyholder');
	var vitemcoaster = document.getElementById('coaster');
	var vitemcleaner_rubber = document.getElementById('cleaner_rubber');
	var vitemsmartphone = document.getElementById('smartphone');
	var vitemkeykaba = document.getElementById('keykaba');
	var vitemearphone = document.getElementById('earphone');

   var obj4 = document.getElementById('pcs1')
   // var obj5 = document.getElementById('pcs2')
   var obj6 = document.getElementById('nashiprint')
   var obj7 =  document.getElementById('ariprint')
   
   //non
	// obj1.disabled=true;
	// obj2.disabled=true;
	// obj3.readonly=true;
	//==>

	if ( vitemcoaster.checked)
	{
           obj4.checked = 'checked';
           obj4disabled = true;
           //obj5.disabled = true;
           obj6.disabled = false;
           obj7.disabled = false;
	}else if( vitemcleaner_rubber.checked ){
           obj4.checked = 'checked';
           obj4.disabled = true;
           //obj5.disabled = true;
           obj6.checked = 'checked';
           obj6.disabled = true;
           obj7.disabled = true;
	}else if( vitemsmartphone.checked ){
           obj4.checked = 'checked';
           obj4.disabled = true;
           //obj5.disabled = true;
           obj6.disabled = false;
           obj7.disabled = false;
	}else if( vitemkeitai.checked ){
            obj4.disabled = false;
            //obj5.disabled = false;
            obj6.disabled = false;
            obj7.disabled = false;
   }else if( vitemkeyholder.checked ){
           obj4disabled = false;
           //obj5.disabled = false;
           obj6.disabled = false;
           obj7.disabled = false;
   }else if( vitemearphone.checked ){
           obj4.checked = 'checked';
           obj4disabled = true;
           //obj5.disabled = true;
           obj6.disabled = false;
           obj7.disabled = false;
   }else if( vitemkeykaba.checked ){
           obj4.checked = 'checked';
           obj4disabled = true;
           //obj5.disabled = true;
           obj6.disabled = false;
           obj7.disabled = false;
	}
    if(document.form.agree[0].checked){
      document.form.cmdSubmit.disabled= false;
    } else {
      document.form.cmdSubmit.disabled= true;
    }

}

function checkDesignFields() {
	// //ファイル名指定
	// var obj = document.getElementById('file2');
	// //添付ファイル指定
	// var obj2 = document.getElementById('file3');
	
	// if(obj.checked && !obj2.checked){
	// 	//ファイル名の表示
 //                hideField('design_upload_span');
 //                showField('design_filename_span');
	// } else if(!obj.checked && obj2.checked){
	// 	//添付ファイル指定表示
 //                hideField('design_filename_span');
 //                showField('design_upload_span');
	// } else {
 //                hideField('design_filename_span');
 //                hideField('design_upload_span');
	// }	
}


function hideField(el) {
	document.getElementById(el).style.display = "none";
        switch (el) {
            case 'design_upload_span':          document.getElementById('design_upload').value = ""; break;
            case 'design_filename_span':	document.getElementById('design_filename').value = ""; break;
        }
}

function showField(el) {
	document.getElementById(el).style.display = "";
}