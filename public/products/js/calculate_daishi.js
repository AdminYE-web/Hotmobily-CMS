var daishi_price = {
  "Custom1side":[
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
  {"num":1000, "price":12},
  {"num":1500, "price":12},
  {"num":2000, "price":12},
  {"num":2500, "price":12},
  {"num":3000, "price":12},],

  "Custom2side":[
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
  {"num":1000, "price":13},
  {"num":1500, "price":13},
  {"num":2000, "price":13},
  {"num":2500, "price":13},
  {"num":3000, "price":13},],

  "tmplate":[
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
  {"num":1000, "price":11},
  {"num":1500, "price":11},
  {"num":2000, "price":11},
  {"num":2500, "price":11},
  {"num":3000, "price":11},]
};

var amount = ['1','2','3','4','5','6','7','8','9','10','20','30','40','50','60','70','80','90','100','200','300','400','500','600','700','800','900','1000','1500','2000','2500','3000'];
var vat = 10;
function createPriceTable() {
  daishi_type = $('input[name="daishi"]:checked').val();
  if(daishi_type == "2side"){var price = 'Custom2side';}
  else if(daishi_type == "1side"){var price = 'Custom1side';}
  else if(daishi_type == "template"){var price = 'tmplate';}
  $('.price-row').remove();
  for (var i = 0 ; i < amount.length ; i++) {
    var unit_price = Math.floor(daishi_price[price][i]["price"]*(1+vat/100));
    var total_price = Math.floor(unit_price*daishi_price[price][i]["num"]);
    $('.daishi').append('<tr class="price-row"><td>'+formatMoney(amount[i])+'</td><td>'+formatMoney(unit_price)+'</td><td>'+formatMoney(total_price)+'</td></tr>');
  }
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