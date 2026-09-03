var mkiTiers = [100, 300, 500, 1000, 3000, 5000];
var mkiPrices = {
  'バージン材': {
    '昇華転写片面印刷': { '150': [266, 224, 190, 150, 124, 120], '180': [290, 248, 210, 168, 141, 134] },
    '昇華転写両面印刷': { '150': [292, 252, 218, 177, 148, 142], '180': [316, 272, 239, 191, 162, 153] },
    '1色印刷（シルクスクリーン）': { '150': [0, 188, 160, 127, 107, 99], '180': [0, 208, 178, 142, 119, 110] },
    'エンボス加工': { '150': [0, 216, 185, 147, 121, 112], '180': [0, 233, 201, 158, 135, 125] }
  },
  'リサイクル材': {
    '昇華転写片面印刷': { '150': [306, 255, 218, 173, 144, 136], '180': [332, 285, 242, 194, 162, 154] },
    '昇華転写両面印刷': { '150': [330, 286, 246, 199, 166, 162], '180': [358, 310, 274, 220, 186, 176] },
    '1色印刷（シルクスクリーン）': { '150': [0, 199, 169, 134, 112, 105], '180': [0, 219, 188, 150, 125, 117] },
    'エンボス加工': { '150': [0, 224, 193, 153, 129, 119], '180': [0, 246, 210, 166, 143, 133] }
  }
};

$(function () {
  check_val('init');
  $('#product_form').on('submit', function () {
    setToInputManual();
  });
});

function showMkiStep(step) {
  $('#step1, #step2, #step3').fadeOut('fast');
  $('#dot-step1, #dot-step2, #dot-step3').removeClass('active');

  if (step === 1) {
    $('#step1').fadeIn('slow');
    $('#back').fadeOut('fast');
    $('#next').fadeIn('slow').text('オプション入力へ').blur();
    $('#dot-step1').addClass('active');
    return;
  }

  if (step === 2) {
    $('#step2').fadeIn('slow');
    $('#back').fadeIn('slow');
    $('#next').fadeIn('slow').text('金額計算・見積・注文へ').blur();
    $('#dot-step1, #dot-step2').addClass('active');
    return;
  }

  $('#step3').fadeIn('slow');
  $('#back, #next').fadeOut('fast');
  $('#dot-step1, #dot-step2, #dot-step3').addClass('active');
}

function valid_chk_btn(command) {
  if (!check_val(command)) return false;

  if (command === 'step1' || command === 'back') {
    showMkiStep(1);
  } else if (command === 'step2') {
    showMkiStep(2);
  } else if (command === 'step3') {
    showMkiStep(3);
  } else if ($('#step1').is(':visible')) {
    showMkiStep(2);
  } else {
    showMkiStep(3);
  }

  if ($('.step-container').length) {
    $(window).scrollTop($('.step-container').offset().top);
  }
  return true;
}

function selectedValue(name, fallback) {
  var checked = $('input[name="' + name + '"]:checked').val();
  return checked || fallback || '';
}

function moneyNumber(value) {
  var parsed = parseInt(String(value || '0').replace(/,/g, ''), 10);
  return isNaN(parsed) ? 0 : parsed;
}

function formatMoney(value) {
  return moneyNumber(value).toLocaleString();
}

function setField(id, value) {
  $('#' + id).val(formatMoney(value));
  $('.' + id).text(formatMoney(value));
}

function buildMkiPayload() {
  return {
    ItemType: $('#strap').val(),
    item_type: selectedValue('item_type', 'バージン材'),
    cth_type: selectedValue('cth_type', '昇華転写片面印刷'),
    cth_color: selectedValue('cth_color', 'WHITE'),
    cth_sewing_color: selectedValue('cth_sewing_color', 'WHITE'),
    cth_size: selectedValue('cth_size', '150'),
    qty: $('#qty').val(),
    cth_sample: selectedValue('cth_sample', ''),
    cth_opp: selectedValue('cth_opp', ''),
    ItemDesignRepeat: selectedValue('ItemDesignRepeat', ''),
    design_no: $('#design_no').val()
  };
}

function fallbackProductCode(payload) {
  var material = payload.item_type === 'リサイクル材' ? 'recycle' : 'virgin';
  var production = 'sublimation_front';
  if (payload.cth_type === '昇華転写両面印刷') production = 'sublimation_double';
  if (payload.cth_type === '1色印刷（シルクスクリーン）') production = 'silk';
  if (payload.cth_type === 'エンボス加工') production = 'emboss';
  // DB code order: mki_{material}_{size}_{kind}
  return 'mki_' + material + '_' + payload.cth_size + '_' + production;
}

function fallbackUnit(payload) {
  var qty = Math.max(0, moneyNumber(payload.qty));
  var table = (((mkiPrices[payload.item_type] || {})[payload.cth_type] || {})[payload.cth_size]) || [];
  var index = 0;
  for (var i = 0; i < mkiTiers.length; i++) {
    if (qty >= mkiTiers[i]) index = i;
  }
  return moneyNumber(table[index]);
}

function calculateLocal(payload) {
  var qty = Math.max(0, moneyNumber(payload.qty));
  var unit = fallbackUnit(payload);
  var basic = 0;
  if (payload.cth_type === '1色印刷（シルクスクリーン）') basic = 4500;
  if (payload.cth_type === 'エンボス加工') basic = 7000;
  var price = unit * qty;
  var sample = payload.cth_sample ? 4500 : 0;

  var opp = payload.cth_opp ? qty * 10 : 0;
  var beforeTax = basic + price + sample + opp;
  var tax = Math.floor(beforeTax * 0.10);
  return {
    product_code: fallbackProductCode(payload),
    unit_price: unit,
    prd_basic_price: basic,
    prd_price: price,
    prd_sample_price: sample,
    prd_opp_price: opp,
    BeforeTax: beforeTax,
    Tax: tax,
    discount: 0,
    grandTotal: beforeTax + tax
  };
}

function fillPrices(data) {
  $('#product_code').val(data.product_code || '');
  $('#unit_price').val(moneyNumber(data.unit_price));
  setField('prd_basic_price', data.prd_basic_price);
  setField('prd_price', data.prd_price);
  setField('prd_sample_price', data.prd_sample_price);
  setField('prd_opp_price', data.prd_opp_price);
  setField('BeforeTax', data.BeforeTax);
  setField('Tax', data.Tax);
  setField('discount', data.discount);
  setField('grandTotal', data.grandTotal);
  $('.prd_total').text(formatMoney(data.grandTotal));
}

function updateProductSummary(payload) {
  $('#sample-prd-prdt, #prd_production').text(payload.cth_type || '-');
  $('#sample-prd-color, #prd_color').text(payload.cth_color || '-');
  $('#sample-prd-sewing-color, #prd_sewing_color').text(payload.cth_sewing_color || '-');
  $('#sample-prd-size, #prd_size').text(payload.cth_size ? payload.cth_size + 'mm' : '-');
  $('#sample-prd-qty, #prd_amount').text(payload.qty ? payload.qty + '個' : '-');
  $('#sample-prd-samp, #prd_sample').text(payload.cth_sample ? 'あり' : 'なし');
  $('#sample-prd-opp, #prd_opp').text(payload.cth_opp ? 'あり' : 'なし');
}

function calculateMkiPrice(payload) {
  updateProductSummary(payload);
  fillPrices(calculateLocal(payload));
  $.ajax({
    url: '/products/ajax_calculate_price_mki.php',
    type: 'POST',
    dataType: 'json',
    data: payload
  }).done(function (res) {
    if (res && res.success) {
      fillPrices(res);
    }
  });
}

function updateMkiAvailability() {
  var material = selectedValue('item_type', 'バージン材');
  if (material === 'リサイクル材') {
    $('#cth_type3').prop('disabled', true);
    if ($('#cth_type3').is(':checked')) {
      $('#cth_type0').prop('checked', true);
    }
  } else {
    $('#cth_type3').prop('disabled', false);
  }
}

function validation_numberOf() {
  var payload = buildMkiPayload();
  var qty = moneyNumber(payload.qty);
  if (qty < 100 || qty > 50000) return false;
  if ((payload.cth_type === '1色印刷（シルクスクリーン）' || payload.cth_type === 'エンボス加工') && qty < 300) return false;
  return true;
}

function check_val() {
  updateMkiAvailability();
  var payload = buildMkiPayload();
  calculateMkiPrice(payload);
  return validation_numberOf();
}

function setToInputManual() {
  var payload = buildMkiPayload();
  var price = calculateLocal(payload);
  fillPrices(price);
  $('#mki_db_priced').val('1');
  $('input[name="prd_sub_total"]').remove();
  $('input[name="prd_total"]').remove();
  $('<input>', { type: 'hidden', name: 'prd_sub_total', value: price.BeforeTax }).appendTo('#product_form');
  $('<input>', { type: 'hidden', name: 'prd_total', value: price.grandTotal }).appendTo('#product_form');
  return true;
}

function clearValue() {
  $('#qty').val('');
  check_val('clear');
}

function setzero() {
  fillPrices(calculateLocal(buildMkiPayload()));
}

function setToInput() {
  return setToInputManual();
}

function comSubmit(action, target, form) {
  document.form.action = action;
  document.form.target = target;
  setToInputManual();
  document.form.submit();
}