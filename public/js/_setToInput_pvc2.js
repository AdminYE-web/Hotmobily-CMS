var price_1 = [869,649,605,572,517,484,366,256,220,177,134,114,97];
var price_2 = [781,583,550,517,462,440,330,220,186,132,106,94,81];

var unit_price = 0;

function valid_chk_btn(c) {
    if(check_val(c)){
        $('#step1').fadeOut('fast');
        $('#step2').fadeOut('fast');
        $('#step3').fadeOut('fast');
        $('#dot-step1').removeClass('active');
        $('#dot-step2').removeClass('active');
        $('#dot-step3').removeClass('active');

        //New condition check button click
        let currentClick = $(event.target).text(); 

        switch($('#next').text()){
            case "オプション入力へ":
            if(c=='next' || c=='step2'){
                $('#back').fadeIn('slow');	
                $('#next').text('金額計算・見積・注文へ');
                $('#next').blur();
                $('#step2').fadeIn('slow');
                $('#dot-step1').addClass('active');
                $('#dot-step2').addClass('active');
            }else if(c=='step3'){
                $('#next').text('金額計算・見積・注文へ');
                $('#next').blur();
                $('#step3').fadeIn('slow');
                $('#back').fadeOut('fast');	
                $('#next').fadeOut('fast');	
                $('#dot-step1').addClass('active');
                $('#dot-step2').addClass('active');
                $('#dot-step3').addClass('active');
            }
            break;
            case "金額計算・見積・注文へ":
            if(c=='next'){
                $('#step3').fadeIn('slow');
                $('#back').fadeOut('fast');	
                $('#next').fadeOut('fast');	
                $('#dot-step1').addClass('active');
                $('#dot-step2').addClass('active');
                $('#dot-step3').addClass('active');
            }else if(c=='back' || c=='step1'){
                $('#next').fadeIn('slow');	
                $('#step1').fadeIn('slow');
                $('#next').text('オプション入力へ');
                $('#next').blur();
                $('#back').fadeOut('fast');
                $('#dot-step1').addClass('active');
            }else{
                $('#back').fadeIn('slow');	
                $('#next').fadeIn('slow');	
                $('#next').text('金額計算・見積・注文へ');
                $('#next').blur();
                $('#step2').fadeIn('slow');
                $('#dot-step1').addClass('active');
                $('#dot-step2').addClass('active');
            }
        }
        $(window).scrollTop($('.step-container').offset().top);

        //New condition check price adapt
        if((currentClick != "" && currentClick !== undefined) && (currentClick === "金額計算・見積・注文へ"))
        {
            let price_value = setToInputManual();
            if(Object.keys(price_value).length !== 0) 
            {
                $.ajax({
                    type: "POST",
                    url: "/products/save_calc_data.php",
                    data: price_value,
                    success: function(response) 
                    {
                        // console.log(response);
                        if(response.status == 200 && response.calculation_token){
                            $('#calculation_token').remove();
                            $('<input>').attr({
                                type: 'hidden',
                                id: 'calculation_token',
                                name: 'calculation_token',
                                value: response.calculation_token
                            }).appendTo('form#form');
                        }	
                    },error: function(xhr, status, error) {
                        console.log(error);
                    }	
                });
            }
        }
        
    }
}

function check_val(v) {
    var ItemType = $('input[name=ItemType]').val();
    if(v=='next'){
        if(!validation_numberOf()){
            return false;
        }else{
            if($('#no_of_order').val()<20){
                $('input[name=SendPrototype][type="checkbox"]').prop('checked',false);	
                $('input[name=SendPrototype][type="checkbox"]').removeAttr( "checked" );	
                $('#sample-error').text('試作品は20個以上のご注文から受付');
                $('input[name=SendPrototype]').attr('disabled',true);
                
            }else{
                $('#sample-error').text('※試作品をご希望される場合、ご注文納期とは別に試作品製作時間として6営業日+配送2日が必要になります。ご注文確定後に試作品の有無をご変更されるお客様が多くなっております。納期に余裕の無い場合、試作品のご依頼はご遠慮下さい。');
                $('input[name=SendPrototype]').attr('disabled',false);
            }

            if($('input[name=ItemSize]:checked').val()==undefined){
                $('#error_size').text('大きさを選択してください。');
                return false;
            }else{
                $('#error_size').text('');
            }

            if($('input[name=ItemPCS]:checked').val()==undefined){
                $('#error_pcs').text('シートを選択してください。');
                return false;
            }else{
                $('#error_pcs').text('');
            }

            if($('input[name=ItemDesign]:checked').val()==undefined){
                $('#error_variation').text('デザインバリエーションを選択してください。');
                return false;
            }else{
                $('#error_variation').text('');
            }

            if($('input[name=ItemSize]:checked').val()!=undefined &&
                $('input[name=ItemPCS]:checked').val()!=undefined && 
                $('input[name=ItemDesign]:checked').val()!=undefined){
                setToInput();
            return true;
        }
    }
}else{
    setToInput();
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
    } else if( vNumberOfOder.value == '' || vNumberOfOder.value < 1 ){
        mess += "<font color='red'>本数は1本以上で入力して下さい。</font>";
        err_number.innerHTML = mess;
        return false;
    } else if( vNumberOfOder.value > 50000 ){
        mess += "<font color='red'>本数は50000本以下で入力して下さい。50000以上のお客様は納期をメールにてお問い合わせ下さい。</font>";
        err_number.innerHTML = mess;
        return false;

    }else if($('input[name=ItemDesign]:checked').val()!="1種類"){
        switch($('input[name=ItemDesign]:checked').val()){
            case "2種類": 
            if(vNumberOfOder.value < 2){
                mess += "<font color='red'>本数は2本以上で入力して下さい。</font>";
                err_number.innerHTML = mess;
                return false;
            }else{
                err_number.style.display = "none";
                return true;
            }
            break;
            case "3種類":  
            if(vNumberOfOder.value < 3){
                mess += "<font color='red'>本数は3本以上で入力して下さい。</font>";
                err_number.innerHTML = mess;
                return false;
            }else{
                err_number.style.display = "none";
                return true;
            }
            break;
            case "4種類":  
            if(vNumberOfOder.value < 4){
                mess += "<font color='red'>本数は4本以上で入力して下さい。</font>";
                err_number.innerHTML = mess;
                return false;
            }else{
                err_number.style.display = "none";
                return true;
            }
            break;
            case "5種類":  
            if(vNumberOfOder.value < 5){
                mess += "<font color='red'>本数は5本以上で入力して下さい。</font>";
                err_number.innerHTML = mess;
                return false;
            }else{
                err_number.style.display = "none";
                return true;
            }
            break;
        }
    }else {
        err_number.style.display = "none";
        return true;
    }
}

var order_pcs = 0;
var unit_price = 0;
var pcs_price = 0;
var before_tax = 0;
var tax = 0;
var vat = 10;
var total = 0;
var silkprint = 0;
var TextField7Value = 0;
var TextField9Value = 0;
var DisPrice = 0;
var proto_charge = 0;
var design_price = 0;

function setToInput()
{
    clearValue();

    var ItemType = $('input[name=ItemType]').val();

    // Size
    var size1 = document.getElementById('size1');
    var size2 = document.getElementById('size2');
    // Quality
    var vpcs1 = document.getElementById('pcs1');
    var vpcs2 = document.getElementById('pcs2');
    // ----------->
    var vno_of_order = document.getElementById('no_of_order');

    if(vno_of_order.value != "" ) {

    // strap
    if (ItemType == "オリジナルテンチャックケース") {
        if (size1.checked) {
            if (vno_of_order.value >= 10000) order_pcs = price_1[12];
            else if (vno_of_order.value >= 5000) order_pcs = price_1[11];
            else if (vno_of_order.value >= 3000) order_pcs = price_1[10];
            else if (vno_of_order.value >= 1000) order_pcs = price_1[9];
            else if (vno_of_order.value >= 500) order_pcs = price_1[8];
            else if (vno_of_order.value >= 300) order_pcs = price_1[7];
            else if (vno_of_order.value >= 100) order_pcs = price_1[6];
            else if (vno_of_order.value >= 50) order_pcs = price_1[5];
            else if (vno_of_order.value >= 40) order_pcs = price_1[4];
            else if (vno_of_order.value >= 30) order_pcs = price_1[3];
            else if (vno_of_order.value >= 20) order_pcs = price_1[2];
            else if (vno_of_order.value >= 10) order_pcs = price_1[1];
            else if (vno_of_order.value >= 1) order_pcs = price_1[0];
        }
        if (size2.checked) {
            if (vno_of_order.value >= 10000) order_pcs = price_2[12];
            else if (vno_of_order.value >= 5000) order_pcs = price_2[11];
            else if (vno_of_order.value >= 3000) order_pcs = price_2[10];
            else if (vno_of_order.value >= 1000) order_pcs = price_2[9];
            else if (vno_of_order.value >= 500) order_pcs = price_2[8];
            else if (vno_of_order.value >= 300) order_pcs = price_2[7];
            else if (vno_of_order.value >= 100) order_pcs = price_2[6];
            else if (vno_of_order.value >= 50) order_pcs = price_2[5];
            else if (vno_of_order.value >= 40) order_pcs = price_2[4];
            else if (vno_of_order.value >= 30) order_pcs = price_2[3];
            else if (vno_of_order.value >= 20) order_pcs = price_2[2];
            else if (vno_of_order.value >= 10) order_pcs = price_2[1];
            else if (vno_of_order.value >= 1) order_pcs = price_2[0];
        }
    }

    // For rubber phone stand size
    if($('input[name=ItemSize]').length && $('input[name=ItemSize]:checked').val()!=undefined){
        $('#sample-prd-size').text($('input[name=ItemSize]:checked').val());
        $('#prd_ItemSize').text($('input[name=ItemSize]:checked').val());
    }

    $('#sample-prd-pcs').text($('input[name=ItemPCS]:checked').val());
    $('#prd_ItemPCS').text($('input[name=ItemPCS]:checked').val());

    $('#sample-prd-design').text($('input[name=ItemDesign]:checked').val());
    $('#prd_ItemDesign').text($('input[name=ItemDesign]:checked').val());

    $('#sample-prd-qty').text(vno_of_order.value);

    if($('input[name=SendPrototype]:checked').val()!=undefined){
        $('#prd_SendPrototype').text('あり');
        $('#sample-prd-samp').text('あり');
    }else{
        $('#prd_SendPrototype').text('なし');
        $('#sample-prd-samp').text('なし');
    }
    
    if($('input[name=SendPrototype]:checked').val()!=undefined){ proto_charge = Math.floor(8000*(1+vat/100)); }	

    if($('input[name=ItemPCS]:checked').val()=="ラメ入り"){
        pcs_price = 10*vno_of_order.value;
    }

    if($('input[name=ItemDesign]:checked').val()!="1種類"){
        switch($('input[name=ItemDesign]:checked').val()){
            case "2種類": design_price = 500; break;
            case "3種類": design_price = 500*2; break;
            case "4種類": design_price = 500*3; break;
            case "5種類": design_price = 500*4; break;
        }
    }else{
        design_price = 0;
    }

    $('#prd_qty').text(vno_of_order.value);

    // Assign Value
    TextField7Value = Math.floor(order_pcs)*vno_of_order.value;
    // Amount Before Tax
    TextField9Value = parseInt(TextField7Value) + proto_charge + design_price + pcs_price;

    // discount setup by timer
    let timer = new Date().toISOString();
    
    let startDate = new Date("2024-01-24T00:00:00");
    let endDate = new Date("2024-02-16T23:59:00");
    
    if (timer > startDate.toISOString() && timer < endDate.toISOString()) {
        DisPrice = Math.floor(parseInt(TextField9Value*0.05));
    } 

    tax = Math.floor(Math.floor(TextField7Value*vat/(100+vat)) + Math.floor(proto_charge*vat/(100+vat))+
        Math.floor(pcs_price*vat/(100+vat)) + Math.floor(design_price*vat/(100+vat)));
    // tax = tax - Math.floor(tax*vat/100);
    total = (parseInt(TextField9Value)-parseInt(DisPrice));

    document.getElementById('textfield7').value = formatMoney(TextField7Value);

    document.getElementById('textfield3').value = formatMoney(proto_charge);
    document.getElementById('textfield4').value = formatMoney(design_price);

    document.getElementById('textfield_dis').value = formatMoney(DisPrice);
    document.getElementById('textfield13').value = formatMoney(pcs_price);

    // document.getElementById('textfield8').value = formatMoney(shipping_charge);
    document.getElementById('textfield9').value = formatMoney(parseInt(TextField9Value));
    // document.getElementById('textfield10').value = formatMoney(tax);
    document.getElementById('textfield11').value = formatMoney(total);
    $('.prd_total').text(formatMoney(total));
    // document.getElementById('textfield12').value = formatMoney(printumu);
}
};

//New condition check price adapt
function setToInputManual() {
    clearValue();

    var ItemType = $('input[name=ItemType]').val();
    var prd = $('#strap').val();

    // Size
    var size1 = document.getElementById('size1');
    var size2 = document.getElementById('size2');
    // Quality
    var vpcs1 = document.getElementById('pcs1');
    var vpcs2 = document.getElementById('pcs2');
    // ----------->
    var vno_of_order = document.getElementById('no_of_order');

    if (vno_of_order.value != "") {

        // strap
        if (ItemType == "オリジナルテンチャックケース") {
            if (size1.checked) {
                if (vno_of_order.value >= 10000) order_pcs = price_1[12];
                else if (vno_of_order.value >= 5000) order_pcs = price_1[11];
                else if (vno_of_order.value >= 3000) order_pcs = price_1[10];
                else if (vno_of_order.value >= 1000) order_pcs = price_1[9];
                else if (vno_of_order.value >= 500) order_pcs = price_1[8];
                else if (vno_of_order.value >= 300) order_pcs = price_1[7];
                else if (vno_of_order.value >= 100) order_pcs = price_1[6];
                else if (vno_of_order.value >= 50) order_pcs = price_1[5];
                else if (vno_of_order.value >= 40) order_pcs = price_1[4];
                else if (vno_of_order.value >= 30) order_pcs = price_1[3];
                else if (vno_of_order.value >= 20) order_pcs = price_1[2];
                else if (vno_of_order.value >= 10) order_pcs = price_1[1];
                else if (vno_of_order.value >= 1) order_pcs = price_1[0];
            }
            if (size2.checked) {
                if (vno_of_order.value >= 10000) order_pcs = price_2[12];
                else if (vno_of_order.value >= 5000) order_pcs = price_2[11];
                else if (vno_of_order.value >= 3000) order_pcs = price_2[10];
                else if (vno_of_order.value >= 1000) order_pcs = price_2[9];
                else if (vno_of_order.value >= 500) order_pcs = price_2[8];
                else if (vno_of_order.value >= 300) order_pcs = price_2[7];
                else if (vno_of_order.value >= 100) order_pcs = price_2[6];
                else if (vno_of_order.value >= 50) order_pcs = price_2[5];
                else if (vno_of_order.value >= 40) order_pcs = price_2[4];
                else if (vno_of_order.value >= 30) order_pcs = price_2[3];
                else if (vno_of_order.value >= 20) order_pcs = price_2[2];
                else if (vno_of_order.value >= 10) order_pcs = price_2[1];
                else if (vno_of_order.value >= 1) order_pcs = price_2[0];
            }
        }

        // For rubber phone stand size
        if ($('input[name=ItemSize]').length && $('input[name=ItemSize]:checked').val() != undefined) {
            $('#sample-prd-size').text($('input[name=ItemSize]:checked').val());
            $('#prd_ItemSize').text($('input[name=ItemSize]:checked').val());
        }

        $('#sample-prd-pcs').text($('input[name=ItemPCS]:checked').val());
        $('#prd_ItemPCS').text($('input[name=ItemPCS]:checked').val());

        $('#sample-prd-design').text($('input[name=ItemDesign]:checked').val());
        $('#prd_ItemDesign').text($('input[name=ItemDesign]:checked').val());

        $('#sample-prd-qty').text(vno_of_order.value);

        if ($('input[name=SendPrototype]:checked').val() != undefined) {
            $('#prd_SendPrototype').text('あり');
            $('#sample-prd-samp').text('あり');
        } else {
            $('#prd_SendPrototype').text('なし');
            $('#sample-prd-samp').text('なし');
        }

        if ($('input[name=SendPrototype]:checked').val() != undefined) {
            proto_charge = Math.floor(8000 * (1 + vat / 100));
        }

        if ($('input[name=ItemPCS]:checked').val() == "ラメ入り") {
            pcs_price = 10 * vno_of_order.value;
        }

        if ($('input[name=ItemDesign]:checked').val() != "1種類") {
            switch ($('input[name=ItemDesign]:checked').val()) {
                case "2種類":
                    design_price = 500;
                    break;
                case "3種類":
                    design_price = 500 * 2;
                    break;
                case "4種類":
                    design_price = 500 * 3;
                    break;
                case "5種類":
                    design_price = 500 * 4;
                    break;
            }
        } else {
            design_price = 0;
        }

        $('#prd_qty').text(vno_of_order.value);

        // Assign Value
        TextField7Value = Math.floor(order_pcs) * vno_of_order.value;
        // Amount Before Tax
        TextField9Value = parseInt(TextField7Value) + proto_charge + design_price + pcs_price;

        // discount setup by timer
        let timer = new Date().toISOString();

        let startDate = new Date("2024-01-24T00:00:00");
        let endDate = new Date("2024-02-16T23:59:00");

        if (timer > startDate.toISOString() && timer < endDate.toISOString()) {
            DisPrice = Math.floor(parseInt(TextField9Value * 0.05));
        }

        tax = Math.floor(Math.floor(TextField7Value * vat / (100 + vat)) + Math.floor(proto_charge * vat / (100 + vat)) +
            Math.floor(pcs_price * vat / (100 + vat)) + Math.floor(design_price * vat / (100 + vat)));
        // tax = tax - Math.floor(tax*vat/100);
        total = (parseInt(TextField9Value) - parseInt(DisPrice));

        document.getElementById('textfield7').value = formatMoney(TextField7Value);

        document.getElementById('textfield3').value = formatMoney(proto_charge);
        document.getElementById('textfield4').value = formatMoney(design_price);

        document.getElementById('textfield_dis').value = formatMoney(DisPrice);
        document.getElementById('textfield13').value = formatMoney(pcs_price);

        // document.getElementById('textfield8').value = formatMoney(shipping_charge);
        document.getElementById('textfield9').value = formatMoney(parseInt(TextField9Value));
        // document.getElementById('textfield10').value = formatMoney(tax);
        document.getElementById('textfield11').value = formatMoney(total);
        $('.prd_total').text(formatMoney(total));
        // document.getElementById('textfield12').value = formatMoney(printumu);

        let shipping_price = 880;
        if (TextField9Value > 11000) {
            shipping_price = 0;
        }

        let sku_name = "";
        if (prd == "オリジナルテンチャックケース") {
            sku_name = 'pvczipcase';
        }

        if (sku_name != "")
        {
            return {
                sku: sku_name,
                product: prd,
                qty: vno_of_order.value,
                product_price: TextField7Value,
                mold_price: 0,
                part_price: 0,
                backside_price: 0,
                paper_price: 0,
                prototype_price: proto_charge,
                ai_assistant_price: 0,
                trace_price: 0,
                opp_price: 0,
                process_price: 0,
                color_price: 0,
                print_price: 0,
                coating_price: 0,
                packing_price: 0,
                carabiner_price: 0,
                material_price: 0,
                design_price: design_price,
                discount: parseInt(DisPrice),
                shipping: shipping_price,
                vat: 0,
                tax: tax,
                subtotal: TextField9Value,
                total: total
            };
        }

    }
};

function clearValue(){
order_pcs = 0;
unit_price = 0;
pcs_price = 0;
before_tax = 0;
tax = 0;
total = 0;
silkprint = 0;
TextField7Value = 0;
TextField9Value = 0;
DisPrice = 0;
proto_charge = 0;
trace_charge = 0;
design_price = 0;

document.getElementById('textfield7').value = "";

document.getElementById('textfield3').value = "";
document.getElementById('textfield4').value = "";
document.getElementById('textfield13').value = "";

document.getElementById('textfield9').value = "";
document.getElementById('textfield_dis').value = "";
document.getElementById('textfield11').value = "";

$.each($('.group-container label'),function() {
    if($(this).find('input').is(':checked')){
        $(this).addClass('active');
    }else{
        $(this).removeClass('active');
    }
});

if($('input[name=ItemDesign]:checked').val()!=undefined && $('input[name=ItemDesign]:checked').val()!="1種類"){
}else{
    $('#error_variation').html('デザインバリエーションを選択してください。');
}

}

///comma////
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

///input only number////
function check_num()
{
m = String.fromCharCode(event.keyCode);
if("0123456789\b\r".indexOf(m, 0) < 0) return false;
return true;
}

//clear 0 first char
function format_number(number){
if (number !=""){
    number = parseInt(number)+0;
}
return number;
}

