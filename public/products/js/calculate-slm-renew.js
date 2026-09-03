function valid_chk_btn(c) {
  if (!check_val(c)) {
    return false;
  }

  if (c === 'step1' || c === 'back') {
    showSlmStep(1);
  } else if (c === 'step2') {
    showSlmStep(2);
  } else if (c === 'step3') {
    showSlmStep(3);
  } else if ($('#step1').is(':visible')) {
    showSlmStep(2);
  } else {
    showSlmStep(3);
  }

  if ($('.step-container').length) {
    $(window).scrollTop($('.step-container').offset().top);
  }
  return true;
}

function showSlmStep(step) {
  $('#step1,#step2,#step3').fadeOut('fast');
  $('#dot-step1,#dot-step2,#dot-step3').removeClass('active');

  if (step === 1) {
    $('#step1').fadeIn('slow');
    $('#back').fadeOut('fast');
    $('#next').fadeIn('slow').text('オプション入力へ').blur();
    $('#dot-step1').addClass('active');
  } else if (step === 2) {
    $('#step2').fadeIn('slow');
    $('#back').fadeIn('slow');
    $('#next').fadeIn('slow').text('金額計算・見積・注文へ').blur();
    $('#dot-step1,#dot-step2').addClass('active');
  } else {
    $('#step3').fadeIn('slow');
    $('#back,#next').fadeOut('fast');
    $('#dot-step1,#dot-step2,#dot-step3').addClass('active');
    setToInput();
  }
}

function check_val(v) {
  if (v === 'next' && !validation_numberOf()) {
    return false;
  }
  setToInput();
  return true;
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
  $('#err_numberOf_mess').hide();
  return true;
}

function setToInput() {
  clearValue();
  if (!$('#qty').val()) return;
  updateProductSummary();

  $('#prd_total').val('計算中...');
  $('.prd_total').text('計算中...');

  $.post('/products/ajax_calculate_price_slm.php', buildSlmPayload(), function (response) {
    if (response && response.success) {
      fillPrices(response);
    } else {
      calculateLocal();
    }
  }, 'json').fail(function () {
    calculateLocal();
  });
}

function buildSlmPayload() {
  return {
    ItemType: $('input[name=ItemType]').val(),
    cth_type: $('input[name=cth_type]:checked').val(),
    cth_sewing_color: $('select[name=cth_sewing_color]').val(),
    cth_size: $('input[name=cth_size]:checked').val(),
    qty: $('#qty').val(),
    cth_sample: $('input[name=cth_sample]:checked').val(),
    cth_opp: $('input[name=cth_opp]:checked').val(),
    ItemDesignRepeat: $('input[name=ItemDesignRepeat]:checked').val(),
    design_no: $('input[name=design_no]').val()
  };
}

function updateProductSummary() {
  var type = $('input[name=cth_type]:checked').val() || '';
  var sewingColor = $('select[name=cth_sewing_color]').val() || '';
  var size = $('input[name=cth_size]:checked').val() || '';
  var qty = $('#qty').val();
  var sample = $('input[name=cth_sample]:checked').length ? $('input[name=cth_sample]:checked').val() : 'なし';
  var opp = $('input[name=cth_opp]:checked').length ? $('input[name=cth_opp]:checked').val() : 'なし';

  $('#sample-prd-prdt').text(type);
  $('#prd_production').text(type);
  $('#sample-prd-sewing-color').text(sewingColor);
  $('#prd_sewing_color').text(sewingColor);
  $('#sample-prd-size').text(size === '180' ? '150x180mm.' : '150x150mm.');
  $('#prd_size').text(size === '180' ? '150x180mm.' : '150x150mm.');
  $('#sample-prd-qty').text(qty);
  $('#prd_amount').text(qty);
  $('#prd_sample').text(sample);
  $('#prd_opp').text(opp);
  $('#sample-prd-samp').text(sample);
  $('#sample-prd-opp').text(opp);
  $('#prd_qty').text(qty);
}

function fillPrices(response) {
  $('#product_code').val(response.product_code || '');
  $('#unit_price').val(response.unit_price || 0);
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
  var product = unit * qty;
  var sample = $('input[name=cth_sample]:checked').length ? 4500 : 0;
  var opp = $('input[name=cth_opp]:checked').length ? 10 * qty : 0;
  var subtotal = product + sample + opp;
  var tax = Math.floor(subtotal * 0.10);
  fillPrices({
    product_code: fallbackProductCode(),
    unit_price: unit,
    prd_basic_price: 0,
    prd_price: product,
    prd_sample_price: sample,
    prd_opp_price: opp,
    BeforeTax: subtotal,
    Tax: tax,
    discount: 0,
    grandTotal: subtotal + tax
  });
}

function fallbackProductCode() {
  var size = $('input[name=cth_size]:checked').val() === '180' ? '180' : '150';
  return 'slm_recycle_' + size;
}

function fallbackUnit(qty) {
  var size = $('input[name=cth_size]:checked').val() === '180' ? '180' : '150';
  // Fallback prices are tax-exclusive (税抜), converted from original 税込 values via floor(税込/1.1)
  var table = {
    '150': [[100,292],[300,250],[500,215],[1000,170],[3000,142],[5000,136]],
    '180': [[100,307],[300,262],[500,227],[1000,183],[3000,153],[5000,149]]
  };
  var tiers = table[size] || [];
  var unit = 0;
  for (var i = 0; i < tiers.length; i++) {
    if (qty >= tiers[i][0]) unit = tiers[i][1];
  }
  return unit;
}

function setToInputManual() {
  if (!$('#qty').val()) return {};
  var payload = buildSlmPayload();
  payload.product_code = $('#product_code').val();
  payload.unit_price = parseMoney($('#unit_price').val());
  payload.prd_basic_price = parseMoney($('#prd_basic_price').val());
  payload.prd_price = parseMoney($('#prd_price').val());
  payload.prd_sample_price = parseMoney($('#prd_sample_price').val());
  payload.prd_opp_price = parseMoney($('#prd_opp_price').val());
  payload.BeforeTax = parseMoney($('#prd_sub_total').val());
  payload.Tax = parseMoney($('#textfield_tax').val());
  payload.discount = parseMoney($('#discount').val());
  payload.grandTotal = parseMoney($('#prd_total').val());
  payload.prd_sub_total = payload.BeforeTax;
  payload.prd_total = payload.grandTotal;
  return payload;
}

function clearValue() {
  $('#product_code').val('');
  $('#unit_price').val('');
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
  $('select[name=cth_sewing_color]').prop('selectedIndex', 0);
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
