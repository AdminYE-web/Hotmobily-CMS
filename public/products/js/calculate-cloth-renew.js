function valid_chk_btn(c) {
  if (check_val(c)) {
    $('#step1').fadeOut('fast');
    $('#step2').fadeOut('fast');
    $('#step3').fadeOut('fast');
    $('#dot-step1').removeClass('active');
    $('#dot-step2').removeClass('active');
    $('#dot-step3').removeClass('active');

    switch ($('#next').text()) {
      case 'オプション入力へ':
        if (c === 'next' || c === 'step2') {
          $('#back').fadeIn('slow');
          $('#next').text('金額計算・見積・注文へ').blur();
          $('#step2').fadeIn('slow');
          $('#dot-step1').addClass('active');
          $('#dot-step2').addClass('active');
        } else if (c === 'step3') {
          $('#next').text('金額計算・見積・注文へ').blur();
          $('#step3').fadeIn('slow');
          $('#back').fadeOut('fast');
          $('#next').fadeOut('fast');
          $('#dot-step1').addClass('active');
          $('#dot-step2').addClass('active');
          $('#dot-step3').addClass('active');
        }
        break;
      case '金額計算・見積・注文へ':
        if (c === 'next') {
          $('#step3').fadeIn('slow');
          $('#back').fadeOut('fast');
          $('#next').fadeOut('fast');
          $('#dot-step1').addClass('active');
          $('#dot-step2').addClass('active');
          $('#dot-step3').addClass('active');
          setToInput();
        } else if (c === 'back' || c === 'step1') {
          $('#next').fadeIn('slow');
          $('#step1').fadeIn('slow');
          $('#next').text('オプション入力へ').blur();
          $('#back').fadeOut('fast');
          $('#dot-step1').addClass('active');
        } else {
          $('#back').fadeIn('slow');
          $('#next').fadeIn('slow');
          $('#next').text('金額計算・見積・注文へ').blur();
          $('#step2').fadeIn('slow');
          $('#dot-step1').addClass('active');
          $('#dot-step2').addClass('active');
        }
        break;
    }
    if ($('.step-container').length) {
      $(window).scrollTop($('.step-container').offset().top);
    }
  }
}

function check_val(v) {
  updateTypeImage();
  if (v === 'next' && !validation_numberOf()) {
    return false;
  }
  setToInput();
  return true;
}

function updateTypeImage() {
  switch ($('input[name=cth_type]:checked').val()) {
    case '昇華転写片面印刷': $('#type-part-pic').attr('src', 'img/cth1.jpg'); break;
    case '昇華転写両面印刷': $('#type-part-pic').attr('src', 'img/cth2.jpg'); break;
    case '1色印刷（シルクスクリーン）': $('#type-part-pic').attr('src', 'img/cth3.jpg'); break;
    case 'エンボス加工': $('#type-part-pic').attr('src', 'img/cth4.jpg'); break;
  }
}

function validation_numberOf() {
  var errNumber = document.getElementById('err_numberOf_mess');
  var qty = parseInt($('#qty').val(), 10);
  if (errNumber) errNumber.style.display = '';

  if (isNaN(qty)) {
    if (errNumber) errNumber.innerHTML = "<font color='red'>半角数値以外が入力されています。</font>";
    return false;
  }
  if (!qty || qty < 100) {
    if (errNumber) errNumber.innerHTML = "<font color='red'>本数は100本以上で入力して下さい。</font>";
    return false;
  }
  if (qty > 50000) {
    if (errNumber) errNumber.innerHTML = "<font color='red'>本数は50000本以下で入力して下さい。</font>";
    return false;
  }
  if ($('input[name=cth_type]:checked').val() === '1色印刷（シルクスクリーン）' && qty < 300) {
    if (errNumber) errNumber.innerHTML = "<font color='red'>本数は300本以上で入力して下さい。</font>";
    return false;
  }
  $('#err_numberOf_mess').hide();
  return true;
}

function setToInput() {
  clearValue();
  if (!$('#qty').val()) return;
  updateProductSummary();

  $('#prd_total').val('計算中...');
  $('.prd_total').text('計算中...');

  $.post('/products/ajax_calculate_price_cloth.php', buildClothPayload(), function (response) {
    if (response && response.success) {
      fillPrices(response);
    } else {
      calculateLocal();
    }
  }, 'json').fail(function () {
    calculateLocal();
  });
}

function buildClothPayload() {
  return {
    ItemType: $('input[name=ItemType]').val(),
    cth_type: $('input[name=cth_type]:checked').val(),
    cth_option: $('input[name=cth_option]:checked').val(),
    cth_size: $('input[name=cth_size]:checked').val(),
    qty: $('#qty').val(),
    cth_sample: $('input[name=cth_sample]:checked').val(),
    cth_opp: $('input[name=cth_opp]:checked').val()
  };
}

function updateProductSummary() {
  var type = $('input[name=cth_type]:checked').val() || '';
  var option = $('input[name=cth_option]:checked').val() || '';
  var size = $('input[name=cth_size]:checked').val() || '';
  var qty = $('#qty').val();
  var sample = $('input[name=cth_sample]:checked').val() === 'あり' ? 'あり' : 'なし';
  var opp = $('input[name=cth_opp]:checked').val() === 'あり' ? 'あり' : 'なし';

  $('#prd_production').text(type + (option ? ' / ' + option : ''));
  $('#prd_size').text(size === '180' ? '150x180mm.' : '150x150mm.');
  $('#prd_amount').text(qty);
  $('#prd_sample').text(sample);
  $('#prd_opp').text(opp);
  $('#sample-prd-samp').text(sample);
  $('#sample-prd-opp').text(opp);
}

function fillPrices(response) {
  $('#prd_basic_price').val(formatMoney(response.prd_basic_price || 0));
  $('#prd_price').val(formatMoney(response.prd_price || 0));
  $('#prd_sample_price').val(formatMoney(response.prd_sample_price || 0));
  $('#prd_opp_price').val(formatMoney(response.prd_opp_price || 0));
  $('#prd_sub_total').val(formatMoney(response.BeforeTax || 0));
  $('#textfield_tax').val(formatMoney(response.Tax || 0));
  $('#discount').val(formatMoney(response.discount || 0));
  $('#prd_total').val(formatMoney(response.grandTotal || 0));
  $('.prd_total').text(formatMoney(response.grandTotal || 0));
}

function calculateLocal() {
  var qty = parseInt($('#qty').val(), 10) || 0;
  if (!qty) return;
  var unit = fallbackUnit(qty);
  var type = $('input[name=cth_type]:checked').val();
  var basic = type === '1色印刷（シルクスクリーン）' ? 3600 : (type === 'エンボス加工' ? 8000 : 0);
  var product = unit * qty;
  var sample = $('input[name=cth_sample]:checked').val() === 'あり' ? 4500 : 0;
  var opp = $('input[name=cth_opp]:checked').val() === 'あり' ? 10 * qty : 0;
  var subtotal = basic + product + sample + opp;
  var tax = Math.floor(subtotal * 0.10);
  fillPrices({
    prd_basic_price: basic,
    prd_price: product,
    prd_sample_price: sample,
    prd_opp_price: opp,
    BeforeTax: subtotal,
    Tax: tax,
    discount: 0,
    grandTotal: subtotal + tax
  });
}

function fallbackUnit(qty) {
  var type = $('input[name=cth_type]:checked').val();
  var option = $('input[name=cth_option]:checked').val();
  var size = $('input[name=cth_size]:checked').val() === '180' ? '180' : '150';
  var table = {
    '昇華転写片面印刷': {
      'スタンダード': { '150': [[100,210],[300,160],[500,130],[1000,100],[3000,80],[5000,70]], '180': [[100,220],[300,170],[500,140],[1000,110],[3000,90],[5000,80]] },
      'プレミアム': { '150': [[100,220],[300,170],[500,140],[1000,110],[3000,90],[5000,80]], '180': [[100,230],[300,180],[500,150],[1000,120],[3000,100],[5000,90]] }
    },
    '昇華転写両面印刷': {
      'スタンダード': { '150': [[100,230],[300,180],[500,150],[1000,120],[3000,100],[5000,90]], '180': [[100,240],[300,190],[500,160],[1000,130],[3000,110],[5000,100]] },
      'プレミアム': { '150': [[100,240],[300,190],[500,160],[1000,130],[3000,110],[5000,100]], '180': [[100,250],[300,200],[500,170],[1000,140],[3000,120],[5000,110]] }
    },
    '1色印刷（シルクスクリーン）': {
      'スタンダード': { '150': [[300,100],[500,90],[1000,70],[3000,50],[5000,40]], '180': [[300,110],[500,100],[1000,90],[3000,60],[5000,50]] },
      'プレミアム': { '150': [[300,110],[500,100],[1000,90],[3000,60],[5000,50]], '180': [[300,120],[500,110],[1000,100],[3000,70],[5000,60]] }
    },
    'エンボス加工': {
      'スタンダード': { '150': [[100,160],[300,110],[500,100],[1000,80],[3000,60],[5000,50]], '180': [[100,170],[300,120],[500,110],[1000,90],[3000,70],[5000,60]] },
      'プレミアム': { '150': [[100,170],[300,120],[500,110],[1000,90],[3000,70],[5000,60]], '180': [[100,180],[300,130],[500,120],[1000,100],[3000,80],[5000,70]] }
    }
  };
  var tiers = (((table[type] || {})[option] || {})[size]) || [];
  var unit = 0;
  for (var i = 0; i < tiers.length; i++) {
    if (qty >= tiers[i][0]) unit = tiers[i][1];
  }
  return unit;
}

function setToInputManual() {
  if (!$('#qty').val()) return {};
  var payload = buildClothPayload();
  payload.prd_basic_price = parseMoney($('#prd_basic_price').val());
  payload.prd_price = parseMoney($('#prd_price').val());
  payload.prd_sample_price = parseMoney($('#prd_sample_price').val());
  payload.prd_opp_price = parseMoney($('#prd_opp_price').val());
  payload.BeforeTax = parseMoney($('#prd_sub_total').val());
  payload.Tax = parseMoney($('#textfield_tax').val());
  payload.discount = parseMoney($('#discount').val());
  payload.grandTotal = parseMoney($('#prd_total').val());
  payload.unit_price = payload.qty ? Math.round(payload.prd_price / parseInt(payload.qty, 10)) : 0;
  return payload;
}

function clearValue() {
  $('#prd_basic_price').val('');
  $('#prd_price').val('');
  $('#prd_sample_price').val('');
  $('#prd_opp_price').val('');
  $('#prd_sub_total').val('');
  $('#textfield_tax').val('');
  $('#discount').val('');
  $('#prd_total').val('');
  $('.prd_total').text('0');
}

function setzero() {
  clearValue();
  $('input[name=cth_type]:first').prop('checked', true);
  $('input[name=cth_option]:first').prop('checked', true);
  $('input[name=cth_size]:first').prop('checked', true);
  $('#qty').val('');
  $('input[name=cth_sample], input[name=cth_opp]').prop('checked', false);
}

function formatMoney(value) {
  var num = parseInt(value || 0, 10);
  return num.toLocaleString('en');
}

function parseMoney(value) {
  var numeric = String(value || '').replace(/[^\d.-]/g, '');
  return numeric === '' ? 0 : parseInt(numeric, 10);
}

function format_number(number) {
  if (number !== '') number = parseInt(number, 10) + 0;
  return number;
}

$(function () {
  $('.switch_off_button').click(function (e) {
    if ($(this).hasClass('switch_off')) {
      $(this).find('input[type=checkbox]').prop('checked', true);
      $(this).find('input[type=hidden]').prop('disabled', true);
      $(this).removeClass('switch_off').addClass('switch_on');
    } else {
      $(this).find('input[type=checkbox]').prop('checked', false);
      $(this).find('input[type=hidden]').prop('disabled', false);
      $(this).removeClass('switch_on').addClass('switch_off');
    }
    if (e.target.tagName !== 'INPUT') {
      var cb = $(this).find('input[type=checkbox]');
      if (cb.length && typeof cb[0].onclick === 'function') cb[0].onclick();
    }
  });
});