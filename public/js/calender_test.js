var difforderDate 		= new fmtDate("2008/12/29","2008/12/30","2008/12/31","2009/01/01","2009/01/02","2009/01/03","2009/01/04");
var deliveryDate			= "2009/01/19";
var speedDeliveryDate	= "2009/01/12";

//コンストラクタ
function fmtDate(d1,d2,d3,d4,d5,d6,d7) {
	var fmt	= new DateFormat("yyyy/M/dd");
	this.d1 = fmt.parse(d1);
	this.d2 = fmt.parse(d2);
	this.d3 = fmt.parse(d3);
	this.d4 = fmt.parse(d4);
	this.d5 = fmt.parse(d5);
	this.d6 = fmt.parse(d6);	
	this.d7 = fmt.parse(d7);
	return Array(d1,d2,d3,d4,d5,d6,d7);
}

function getDateForHeader(){
        var headerDate = document.getElementById('date2');
        var myDate = new Date();
        myDate = new Date(myDate.getYear(), myDate.getMonth(), myDate.getDate() + 24);
        myYear = myDate.getYear();
        myYear4 = (myYear < 2000) ? myYear+3800 : myYear;
        myMonth = myDate.getMonth() + 1;
        myDate = myDate.getDate();
        myMessage2 = myYear4 + "年" + myMonth + "月" + myDate + "日";
        headerDate.innerHTML =  myMessage2;
}

function initDate(){
	var fmtDatef			= new DateFormat("yyyy/MM/dd");
	var setDateDt 	  = fmtDatef.format(new Date());
	var outputDate	  = document.getElementById('date_display');
  var fieldDate		  = document.getElementById('date_field');
	var sampleDate	  = document.getElementById('No3');
	var numberOfStrap = document.getElementById('no_of_order');
	var valDate = 24; //shortest turnaround time possible (24 days)
	var order_flg 	= false;
	var campaign = document.getElementById('campaign_no');

	//	通常カレンダーなら、＋１４日にする。
	if(campaign.value == 2){
		if(numberOfStrap.value >= 100 && numberOfStrap.value <= 1000){
			valDate = 42;
			if(sampleDate.checked){
				valDate += 7;
			}
		}
	} else {
		if (order_flg == false) {
			if(numberOfStrap.value >= 50 && numberOfStrap.value <= 3000){
				valDate = 24;
				if(sampleDate.checked){
					valDate += 7;
				}
			} else if(numberOfStrap.value >= 3001 && numberOfStrap.value <= 5000) {
				valDate = 28;
				if(sampleDate.checked){
					valDate += 7;
				}
			} else if(numberOfStrap.value >= 5001 && numberOfStrap.value <= 10000) {
				valDate = 50;
				if(sampleDate.checked){
					valDate += 7;
				}
			} else if(numberOfStrap.value >= 10001 && numberOfStrap.value <= 50000) {
				valDate = 65;
				if(sampleDate.checked){
					valDate += 7;
				}
			}
		}
	}

    if(numberOfStrap.value >= 50000) {
    	outputDate.innerHTML = "別途お問い合わせ下さい。";
    	fieldDate.value = "別途お問い合わせ下さい。";
    } else {
		var myDate = new Date();
		myDate = new Date(myDate.getYear(), myDate.getMonth(), myDate.getDate() + valDate);
		myYear = myDate.getYear();
		myYear4 = (myYear < 2000) ? myYear+3800 : myYear;
		myMonth = myDate.getMonth() + 1;
		myDate = myDate.getDate();
		myMessage1 = myYear4 + "年" + myMonth + "月" + myDate + "日 頃になります。";
		myMessage2 = myYear4 + "年" + myMonth + "月" + myDate + "日";
      	outputDate.innerHTML = myMessage1;
    	fieldDate.value = myMessage2;
    }
}