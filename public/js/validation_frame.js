/*20200430*/
/*********** input validation ***********/ 
function validation(){	
         
    var number_result = validation_numberOf();

	if (number_result && (document.getElementById('pcs1').checked==true||document.getElementById('pcs2').checked==true)) {
		$('#error_message').text('');
		return false;
	}
	else{
		$('#error_message').text('ご注文タイプをお選びください。');
        return true;
	}
}


function validation_numberOf() {
	//エラー出力用id
	var err_number = document.getElementById('err_numberOf_mess');
	var mess = "";

	err_number.style.display = "";

	//入力値
	var vNumberOfOder = document.getElementById('no_of_order');
	
	if ( isNaN(vNumberOfOder.value) ) {
		mess += "<font color='red'>半角数値以外が入力されています。</font>";
		err_number.innerHTML = mess;
		return false;
	} else if( vNumberOfOder.value == '' || vNumberOfOder.value < 30 ){
		mess += "<font color='red'>本数は30本以上で入力して下さい。</font>";
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

/************** format *****************/
///check bt////
function check_agree(){
	//non
	// var obj1 = document.getElementById('file1');
	//==>
	var obj2 = document.getElementById('file2');
	var obj3 = document.getElementById('design_filename');
	var vitemkeyholder = document.getElementById('keyholder');
	var vitemcoaster = document.getElementById('coaster');
	var vitemcleaner_rubber = document.getElementById('cleaner_rubber');
	var vitemkeykaba = document.getElementById('keykaba');
	var vitemearphone = document.getElementById('earphone');

   var obj4 = document.getElementById('pcs1')
   var obj5 = document.getElementById('pcs2')
   var obj6 = document.getElementById('nashiprint')
   var obj7 =  document.getElementById('ariprint')
 
    if(document.form.agree[0].checked){
      document.form.cmdSubmit.disabled= false;
    } else {
      document.form.cmdSubmit.disabled= true;
    }

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