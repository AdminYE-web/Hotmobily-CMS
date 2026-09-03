function productionDate(date){
  var str = date,
  l = str.length-1,
  date_f = new Date(str[0]),
  date_l = new Date(str[4])
  f = new Date();
  var date = new Date();
  currentHours = date.getHours();
  currentHours = ("0" + currentHours).slice(-2);
  $('.cld_tb').show();
  $('#date_create').text(add_digi(parseInt(f.getMonth()+1))+"/"+add_digi(f.getDate())+" "+add_digi(f.getHours())+":"+add_digi(f.getMinutes()));
  $('#date_create2').text(add_digi(parseInt(date_l.getMonth()+1))+"/"+add_digi(date_l.getDate()));
}
function add_digi(num){
  if(num<10){
    return "0"+num;
  }else{return num;} 
}