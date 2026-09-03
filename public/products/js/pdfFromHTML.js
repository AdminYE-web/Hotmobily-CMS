function HTMLtoPDF(filename) {
  if(detectIE()=="11"||detectIE()=="12"||detectIE()=="13"||detectIE()=="14"){
    var contents = $("#pdf_content").html();
    GrabzIt("YTUxZjhkMTI4NjgzNDk0NjhmMDY5NTQzN2U4ZTIwOTI=").ConvertHTML('<html><head><title>DIV Contents</title>'+
      '<style>body {line-height: 1.4;font-family: "ヒラギノ角ゴ Pro W3", "Hiragino Kaku Gothic Pro", "メイリオ", Meiryo, Osaka, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif;-webkit-text-size-adjust: 100%;}#pdf_content{max-width: 1285px;  font-size: 12px;font-family:Osaka, "ＭＳ ゴシック", Verdana;}strong{ font-weight: 100;}'+
      '.img_strap{  width: 722px;}.head{  width: 300px;}.head p{  max-width: 100%;  font-size: 12px;'+
      '  text-align: left;  margin-top: -5px;}p{  max-width: 100%;  font-size: 12px; '+
      ' text-align: center;  margin-top: 0px;}.left{  max-width: 100%;  font-size: 12px; '+
      ' text-align: left;  margin-top: 0px;}p b{  font-size: 20px;  text-decoration: underline;'+
      '  text-align: center;  margin-top: 0px;}.table_show{  width: 1028px;  border: 1px solid black;  '+
      'border-collapse: collapse;}.table_show td{  border: 1px solid black;  font-size: 12px;}.table_show2{'+
      ' width: 1028px;  border-collapse: collapse;}.table_show2 td{  font-size: 12px;}table_last{ '+
      ' width: 1028px;  border-spacing: 0px 0px;}.table_last_td{  border: 1px solid black;  width: 150px;'+
      '  font-size: 12px;}.table_cal{  width: 1028px;  font-size: 12px;  border: 1px solid black;  border-collapse: collapse;}.tab_bor td,th{  border: 1px solid black;}'+
      '.w150{  width: 150px;}.w528{  width: 528px;}.w100{  width: 100px;}'+
      '.w250{  width: 250px;}.w365{  width: 365px;}.w480{  width: 480px;}b{  font-size: 12px;}'+
      '.center{    text-align: center;}.right{    text-align: right;}#img_hm{content:url(http://hotmobily.jp/estimate/img/img_hb.png);}</style></head><body>'+contents+'</body></html>',
    {"format": "pdf", "download": 0,"filename":filename+".pdf"}).Create();
    setTimeout(function(){       
      var n = localStorage.getItem('id').indexOf("-");
      var res = localStorage.getItem('id').substring(n);
      // var x = location.href = "https://api.grabz.it/services/getjspicture.ashx?id=NGI1N2I3NWVhMzFkNDA1OTkxNDhlNGMxODU1ZGE3ZjY="+res+"&fileName="+filename+".pdf";
      $.ajax("https://api.grabz.it/services/getjspicture.ashx?id=YTUxZjhkMTI4NjgzNDk0NjhmMDY5NTQzN2U4ZTIwOTI="+res+"&fileName="+filename+".pdf", {
          statusCode: {
            304: function() {
              alert('Not working');
            },
            200: function() {
              window.open(
                "https://api.grabz.it/services/getjspicture.ashx?id=YTUxZjhkMTI4NjgzNDk0NjhmMDY5NTQzN2U4ZTIwOTI="+res+"&fileName="+filename+".pdf",
                '_blank' // <- This is what makes it open in a new window.
              );
            }
          }
        });
      // alert(res)
    }, 14000);
    localStorage.removeItem('id');
  }else{
    var contents = $("#pdf_content").html();
    GrabzIt("YTUxZjhkMTI4NjgzNDk0NjhmMDY5NTQzN2U4ZTIwOTI=").ConvertHTML('<html><head><title>DIV Contents</title>'+
      '<style>body {line-height: 1.4;font-family: "ヒラギノ角ゴ Pro W3", "Hiragino Kaku Gothic Pro", "メイリオ", Meiryo, Osaka, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif;-webkit-text-size-adjust: 100%;}#pdf_content{max-width: 1285px;  font-size: 12px;font-family:Osaka, "ＭＳ ゴシック", Verdana;} strong{ font-weight: 100;}'+
      '.img_strap{  width: 722px;}.head{  width: 300px;}.head p{  max-width: 100%;  font-size: 12px;'+
      '  text-align: left;  margin-top: -5px;}p{  max-width: 100%;  font-size: 12px; '+
      ' text-align: center;  margin-top: 0px;}.left{  max-width: 100%;  font-size: 12px; '+
      ' text-align: left;  margin-top: 0px;}p b{  font-size: 20px;  text-decoration: underline;'+
      '  text-align: center;  margin-top: 0px;}.table_show{  width: 1028px;  border: 1px solid black;  '+
      'border-collapse: collapse;}.table_show td{  border: 1px solid black;  font-size: 12px;}.table_show2{'+
      ' width: 1028px;  border-collapse: collapse;}.table_show2 td{  font-size: 12px;}table_last{ '+
      ' width: 1028px;  border-spacing: 0px 0px;}.table_last_td{  border: 1px solid black;  width: 150px;'+
      '  font-size: 12px;}.table_cal{  width: 1028px;  font-size: 12px;  border: 1px solid black;  border-collapse: collapse;}.tab_bor td,th{  border: 1px solid black;}'+
      '.w150{  width: 150px;}.w528{  width: 528px;}.w100{  width: 100px;}'+
      '.w250{  width: 250px;}.w365{  width: 365px;}.w480{  width: 480px;}b{  font-size: 12px;}'+
      '.center{    text-align: center;}.right{    text-align: right;}#img_hm{content:url(http://hotmobily.jp/estimate/img/img_hb.png);}</style></head><body>'+contents+'</body></html>',
     {"format": "pdf", "download": 1,"filename":filename+".pdf"}).Create();
  }
}
function detectIE() {
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf('MSIE ');
    if (msie > 0) {
        // IE 10 or older => return version number
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }

    var trident = ua.indexOf('Trident/');
    if (trident > 0) {
        // IE 11 => return version number
        var rv = ua.indexOf('rv:');
        return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }

    var edge = ua.indexOf('Edge/');
    if (edge > 0) {
       // Edge (IE 12+) => return version number
       return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
    }

    // other browser
    return false;
}