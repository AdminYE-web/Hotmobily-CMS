function productionDate(date){
  var str = date,
  l = str.length-1,
  date_f = new Date(str[0]),
  date_l = new Date(str[l]),
  f = new Date(new Date().toLocaleString("en-US", { timeZone: "Asia/Tokyo" }));
  var date = new Date();
  var dayOfWeekStrJP = [ "日", "月", "火", "水", "木", "金", "土" ] ;
  currentHours = date.getHours();
  currentHours = ("0" + currentHours).slice(-2);
  $('.cld_tb').show();
  $('#date_create').html(add_digi(parseInt(f.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(f.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[f.getDay()]+")</span> "+add_digi(f.getHours())+":"+add_digi(f.getMinutes()));
  $('#date_create2').html(add_digi(parseInt(date_l.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(date_l.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[date_l.getDay()]+")</span>");

  $('#date_create111').html(add_digi(parseInt(f.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(f.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[f.getDay()]+")</span> "+add_digi(f.getHours())+":"+add_digi(f.getMinutes()));
  $('#date_create222').html(add_digi(parseInt(date_l.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(date_l.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[date_l.getDay()]+")</span>");

  $('#date_create2x1').html(add_digi(parseInt(date_l.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(date_l.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[date_l.getDay()]+")</span>");
}

function productionDate2(date){
  var str = date,
  l = str.length-1,
  date_f = new Date(str[0]),
  date_l = new Date(str[1]),
  f = new Date(new Date().toLocaleString("en-US", { timeZone: "Asia/Tokyo" }));
  var date = new Date();
  var dayOfWeekStrJP = [ "日", "月", "火", "水", "木", "金", "土" ] ;
  currentHours = date.getHours();
  currentHours = ("0" + currentHours).slice(-2);
  $('.cld_tb').show();
  $('#date_create_sample1').html(add_digi(parseInt(f.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(f.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[f.getDay()]+")</span> "+add_digi(f.getHours())+":"+add_digi(f.getMinutes()));
  $('#date_create_sample2').html(add_digi(parseInt(date_l.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(date_l.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[date_l.getDay()]+")</span>");
}

function productionDate3(date){
  var str = date,
  l = str.length-1,
  date_f = new Date(str[0]),
  date_l = new Date(str[1]),
  f = new Date(new Date().toLocaleString("en-US", { timeZone: "Asia/Tokyo" }));
  var date = new Date();
  var dayOfWeekStrJP = [ "日", "月", "火", "水", "木", "金", "土" ] ;
  currentHours = date.getHours();
  currentHours = ("0" + currentHours).slice(-2);
  $('.cld_tb').show();
  $('#date_create_speed_1').html(add_digi(parseInt(f.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(f.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[f.getDay()]+")</span> "+add_digi(f.getHours())+":"+add_digi(f.getMinutes()));
  $('#date_create_speed_2').html(add_digi(parseInt(date_l.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(date_l.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[date_l.getDay()]+")</span>");
}

function productionDate4(date){
  var str = date,
  l = str.length-1,
  date_f = new Date(str[0]),
  date_l = new Date(str[l]),
  f = new Date(new Date().toLocaleString("en-US", { timeZone: "Asia/Tokyo" }));
  var date = new Date();
  var dayOfWeekStrJP = [ "日", "月", "火", "水", "木", "金", "土" ] ;
  currentHours = date.getHours();
  currentHours = ("0" + currentHours).slice(-2);
  $('.cld_tb').show();
  $('#date_create77').html(" - "+ add_digi(parseInt(date_l.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(date_l.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[date_l.getDay()]+")</span>");
}

function productionDate5Days(date){
  var str = date,
  l = str.length-1,
  date_f = new Date(str[0]),
  date_l = new Date(str[l]),
  f = new Date(new Date().toLocaleString("en-US", { timeZone: "Asia/Tokyo" }));
  var date = new Date();
  var dayOfWeekStrJP = [ "日", "月", "火", "水", "木", "金", "土" ] ;
  currentHours = date.getHours();
  currentHours = ("0" + currentHours).slice(-2);
  $('.cld_tb').show();

  $('#date_create_5days_1').html(add_digi(parseInt(f.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(f.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[f.getDay()]+")</span> "+add_digi(f.getHours())+":"+add_digi(f.getMinutes()));
  $('#date_create_5days_2').html(add_digi(parseInt(date_l.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(date_l.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[date_l.getDay()]+")</span>");
}

function productionDate7Days(date){
  var str = date,
  l = str.length-1,
  date_f = new Date(str[0]),
  date_l = new Date(str[l]),
  f = new Date(new Date().toLocaleString("en-US", { timeZone: "Asia/Tokyo" }));
  var date = new Date();
  var dayOfWeekStrJP = [ "日", "月", "火", "水", "木", "金", "土" ] ;
  currentHours = date.getHours();
  currentHours = ("0" + currentHours).slice(-2);
  $('.cld_tb').show();

  $('#date_create_7day_1').html(add_digi(parseInt(f.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(f.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[f.getDay()]+")</span> "+add_digi(f.getHours())+":"+add_digi(f.getMinutes()));
  $('#date_create_7day_2').html(add_digi(parseInt(date_l.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(date_l.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[date_l.getDay()]+")</span>");
}

function productionDate11Days(date){
  var str = date,
  l = str.length-1,
  date_f = new Date(str[0]),
  date_l = new Date(str[l]),
  f = new Date(new Date().toLocaleString("en-US", { timeZone: "Asia/Tokyo" }));
  var date = new Date();
  var dayOfWeekStrJP = [ "日", "月", "火", "水", "木", "金", "土" ] ;
  currentHours = date.getHours();
  currentHours = ("0" + currentHours).slice(-2);
  $('.cld_tb').show();

  $('#date_create_11day_1').html(add_digi(parseInt(f.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(f.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[f.getDay()]+")</span> "+add_digi(f.getHours())+":"+add_digi(f.getMinutes()));
  $('#date_create_11day_2').html(add_digi(parseInt(date_l.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(date_l.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[date_l.getDay()]+")</span>");
}

function productionDate12Days(date){
  var str = date,
  l = str.length-1,
  date_f = new Date(str[0]),
  date_l = new Date(str[l]),
  f = new Date(new Date().toLocaleString("en-US", { timeZone: "Asia/Tokyo" }));
  var date = new Date();
  var dayOfWeekStrJP = [ "日", "月", "火", "水", "木", "金", "土" ] ;
  currentHours = date.getHours();
  currentHours = ("0" + currentHours).slice(-2);
  $('.cld_tb').show();

  $('#date_create_12day_1').html(add_digi(parseInt(f.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(f.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[f.getDay()]+")</span> "+add_digi(f.getHours())+":"+add_digi(f.getMinutes()));
  $('#date_create_12day_2').html(add_digi(parseInt(date_l.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(date_l.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[date_l.getDay()]+")</span>");
}

function productionDate15Days(date){
  var str = date,
  l = str.length-1,
  date_f = new Date(str[0]),
  date_l = new Date(str[l]),
  f = new Date(new Date().toLocaleString("en-US", { timeZone: "Asia/Tokyo" }));
  var date = new Date();
  var dayOfWeekStrJP = [ "日", "月", "火", "水", "木", "金", "土" ] ;
  currentHours = date.getHours();
  currentHours = ("0" + currentHours).slice(-2);
  $('.cld_tb').show();

  $('#date_create_15day_1').html(add_digi(parseInt(f.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(f.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[f.getDay()]+")</span> "+add_digi(f.getHours())+":"+add_digi(f.getMinutes()));
  $('#date_create_15day_2').html(add_digi(parseInt(date_l.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(date_l.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[date_l.getDay()]+")</span>");
}

function productionDate16Days(date){
  var str = date,
  l = str.length-1,
  date_f = new Date(str[0]),
  date_l = new Date(str[l]),
  f = new Date(new Date().toLocaleString("en-US", { timeZone: "Asia/Tokyo" }));
  var date = new Date();
  var dayOfWeekStrJP = [ "日", "月", "火", "水", "木", "金", "土" ] ;
  currentHours = date.getHours();
  currentHours = ("0" + currentHours).slice(-2);
  $('.cld_tb').show();

  $('#date_create_16day_1').html(add_digi(parseInt(f.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(f.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[f.getDay()]+")</span> "+add_digi(f.getHours())+":"+add_digi(f.getMinutes()));
  $('#date_create_16day_2').html(add_digi(parseInt(date_l.getMonth()+1))+"<span style='font-size:18px;'>月</span>"+add_digi(date_l.getDate())+"<span style='font-size:18px;'>日("+dayOfWeekStrJP[date_l.getDay()]+")</span>");
}

function formatDate(inputDate) {
  var date = new Date(inputDate);
  var dayOfWeekStrJP = ["日", "月", "火", "水", "木", "金", "土"];
  var formattedDate = add_digi(parseInt(date.getMonth() + 1)) + "/" + add_digi(date.getDate()) + "<span style='font-size:18px;'>(" + dayOfWeekStrJP[date.getDay()] + ")</span>";
  return formattedDate;
}

function add_digi(num){
  if(num<10){
    return "0"+num;
  }else{return num;} 
}

function getJSTInfo() {
  const now = new Date();
  const parts = new Intl.DateTimeFormat('ja-JP', {
    timeZone: 'Asia/Tokyo',
    month: '2-digit',
    day: '2-digit',
    weekday: 'short',
    hour: '2-digit',
    minute: '2-digit',
    hour12: false
  }).formatToParts(now);

  const data = {};
  parts.forEach(({ type, value }) => {
    data[type] = value;
  });

  return `${data.month}月${data.day}日(${data.weekday}) ${data.hour}:${data.minute}`;
}
