$(function(){
    if(mobile_chk){
      $('#btn_cal').replaceWith('<input type="button" class="btn ord-btn" value="注文内容確定" id="btn_cal" onclick="Javascript:if (!validation()) { setToInput(); }next_area(\'keisai\')" />');
      $('#menu_sample').replaceWith('<td class="TableRight" id="menu_sample"><label class="control control--radio"><input type="radio" name="SendPrototype" id="No" value="不要" onclick="next_area(\'SendPrototype\')" '+noNeed_checked+' />不要<span class="control__indicator"></span></label>      <label class="control control--radio"><input type="radio" name="SendPrototype" id="No3" value="必要" onclick="next_area(\'SendPrototype\')" '+sendActual_checked+' />必要<span class="control__indicator"></span></label><font color="red">※プレミアムは実物校正代金が無料</font></td>')
      $('#menu_file').replaceWith('<td class="TableRight" id="menu_file"><label class="control control--radio"><input type="radio" name="DeFormat" id="illus" value="イラストレータファイル" onclick="next_area(\'DeFormat\')" '+illus_checked+' />イラストレータファイル<span class="control__indicator"></span></label><label class="control control--radio"><input type="radio" name="DeFormat" id="illus2" value="その他" onclick="next_area(\'DeFormat\')" '+others_checked+' />その他<span class="control__indicator"></span></label><font color="red">※プレミアムはトレース代金が無料</font></td>')
      $('#menu_print').replaceWith('<td class="TableRight" id="menu_print"><label class="control control--radio"><input type="radio" name="silk_print" id="nashiprint" value="シルク印刷なし" onclick="next_area(\'silk_print\')" '+nashiprint_checked+' />シルク印刷なし<span class="control__indicator"></span></label><label class="control control--radio"><input type="radio" name="silk_print" id="ariprint" value="シルク印刷あり" onclick="next_area(\'silk_print\')" '+ariprint_checked+' />シルク印刷あり<span class="control__indicator"></span></label><font color="red">※プレミアムはシルク印刷代金が無料</font></td>')
      $('#qty').replaceWith('<td class="TableRight" id="qty"><label>'+
        '<label class="control control--radio"><input type="radio" name="numberOf" id="no_of_order_100" class="right" onclick="next_area(\'numberOf\');show_input(\'hide\');" value="100" '+$select_100+'/>100本<span class="control__indicator"></span></label>'+
        '<br />'+
        '<label class="control control--radio"><input type="radio" name="numberOf" id="no_of_order_200" class="right" onclick="next_area(\'numberOf\');show_input(\'hide\');" value="200" '+$select_200+'/>200本<span class="control__indicator"></span></label>'+
        '<br />'+
        '<label class="control control--radio"><input type="radio" name="numberOf" id="no_of_order_300" class="right" onclick="next_area(\'numberOf\');show_input(\'hide\');" value="300" '+$select_300+'/>300本<span class="control__indicator"></span></label>'+
        '<br />'+
        '<label class="control control--radio"><input type="radio" name="numberOf" id="no_of_order_400" class="right" onclick="next_area(\'numberOf\');show_input(\'hide\');" value="400" '+$select_400+'/>400本<span class="control__indicator"></span></label>'+
        '<br />'+
        '<label class="control control--radio"><input type="radio" name="numberOf" id="no_of_order_500" class="right" onclick="next_area(\'numberOf\');show_input(\'hide\');" value="500" '+$select_500+'/>500本<span class="control__indicator"></span></label>'+
        '<br />'+
        '<label class="control control--radio"><input type="radio" name="numberOf" id="no_of_order_0" class="right" onclick="next_area(\'numberOf\');show_input(\'show\');" value="0" '+$select_0+'/>500個以上のご注文<span class="control__indicator"></span></label>'+
        '<div style="'+display_other+'" id="number_other"><input type="number" name="numberOfother" id="no_of_order_other" value="'+numberOfother+'">本</div></label><div id="err_numberOf_mess">'+mrErrMsgList+'</div></td>');
      if(mode == "MODE_MOD"){
        $("#area2").show();
        $("#area3").show();
        $("#area4").show();
        $("#area5").show();
        $("#area6").show();
        $("#area7").show();
        $("#menu2").show();
        $("#menu3").show();
        $("#menu4").show();
        table_priceW();$('#div_estimatePrice').show();
      }
      if(items=="携帯クリーナー（ラバー）"){
        $('#qty').append('<span id="error_cleaner" style="color:red;">※携帯クリーナー（ラバー）の最小注文個数は300個からです</span>') 
        document.getElementById('no_of_order_100').disabled = true;
        document.getElementById('no_of_order_200').disabled = true;
      }
    }else{
     $('#btn_cal').replaceWith('<input type="button" class="btn ord-btn" value="計算" id="btn_cal" onclick="Javascript:check_select()" />'); 
     if(mode == "MODE_MOD"){
      table_priceW();$('#div_estimatePrice').show();
    }
  }
});
function next_area(tmp){
  if(screen.width<=768){
    switch(tmp){
      case 'itemType': 
      $("#area2").show();
      if($('input[name="ItemType"]:checked').val()=="携帯クリーナー（ラバー）"){
        $('#no_of_order_100').prop('disabled',true);
        $('#no_of_order_200').prop('disabled',true);
        $('#qty').append('<span id="error_cleaner" style="color:red;">※携帯クリーナー（ラバー）の最小注文個数は300個からです</span>')
      }else{
        $('#no_of_order_100').prop('disabled',false);
        $('#no_of_order_200').prop('disabled',false);
        $('#error_cleaner').text('');
      }
      break;
      case 'ItemPCS': $("#area3").show();$("#area4").show();$("#area5").show();$("#area6").show();$("#menu3").show();break;
                // case 'SendPrototype': $("#area4").show();break;
                // case 'DeFormat': $("#area5").show();break;
                // case 'silk_print': $("#area6").show();break;
                case 'numberOf': $("#area7").show();break;
                case 'keisai': $("#menu2").show();$("#menu4").show();break;
              }
            }
          }
          function show_input(type){
            switch(type){
              case 'show': $('#number_other').show();break;
              case 'hide': $('#number_other').hide();break;
            }
          }
          function check_select(){
            if($('input[name=ItemType]:checked').val()!=undefined&&$('input[name=ItemPCS]:checked').val()!=undefined){
    // console.log($('input[name=ItemType]:checked').val())
    if (!validation()){
      setToInput(); 
      $('#error_message').text('');
    };
  }else{
    validation()
    $('#error_message').text('ご注文商品、ご注文タイプをお選びください。');
  }
}
$(document).ready(function(){
  $("#show_pic").click(function(){
    $("#next").show();
  });
  $("#hide_pic").click(function(){
    $("#next").hide();
  });
});
$('#submit-btn').click(function(){
  $('#submit-btn').val('確認中');
  $("#submit-btn" ).prop( "disabled", true );
  var myForm = document.getElementById('form');
  formData = new FormData(myForm);

  $.ajax({
      url: "ajax_php_file.php", // Url to which the request is send
      type: 'POST',
      processData: false, // important
      contentType: false, // important
      data: formData,     // To send DOMDocument or non processed data file it is set to false
      success: function(data)   // A function to be called if request succeeds
      {
        if(data){
          $('#result').append(data)
          $('input[type=file]').val('');
        }
        $('#submit-btn').val('確定');
        $("#submit-btn" ).prop( "disabled", false );
      }
    });
})
function remove(tmp){
    // alert(tmp)
    $.ajax({
      url: "ajax_php_file_delete.php", // Url to which the request is send
      type: 'GET',
      data: {session: tmp},    // To send DOMDocument or non processed data file it is set to false
      success: function(data)   // A function to be called if request succeeds
      {
        location.reload();
      }
    });
  }