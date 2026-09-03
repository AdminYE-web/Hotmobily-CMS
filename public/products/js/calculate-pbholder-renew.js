/**
 * calculate-pbholder-renew.js
 * pbholder Renewal Calculator
 * Replaces client-side calculations with AJAX-based pricing via PHP DB.
 */

// ===== PRICE DATA (kept for fallback if DB/AJAX fails) =====
var price_pbholder_standard = [246, 212, 196, 186, 179, 175, 173];
var price_pbholder_premium = [350, 300, 277, 264, 255, 250, 246];

var speed_surcharge = [
  { num: 100, price: 58 }, { num: 200, price: 45 }, { num: 300, price: 30 }
];

var paperPrice_obj = {
  "1side": [
    { num: 1, price: 1030 }, { num: 10, price: 130 }, { num: 50, price: 50 }, { num: 100, price: 40 }, { num: 500, price: 15 }
  ],
  "2side": [
    { num: 1, price: 1230 }, { num: 10, price: 150 }, { num: 54, price: 54 }, { num: 100, price: 42 }, { num: 500, price: 16 }
  ],
  "tmp": [
    { num: 1, price: 830 }, { num: 10, price: 110 }, { num: 46, price: 46 }, { num: 100, price: 38 }, { num: 500, price: 14 }
  ]
};

var paperPrice = 0;

// ===== STEP NAVIGATION =====
function valid_chk_btn(c) {
  if (check_val(c)) {
    let currentStep = 1;
    if ($("#step2").is(":visible")) {
      currentStep = 2;
    } else if ($("#step3").is(":visible")) {
      currentStep = 3;
    }

    $("#step1").fadeOut("fast");
    $("#step2").fadeOut("fast");
    $("#step3").fadeOut("fast");
    $("#dot-step1").removeClass("active");
    $("#dot-step2").removeClass("active");
    $("#dot-step3").removeClass("active");

    let currentClick = null;
    if (typeof event !== "undefined" && event && event.target) {
      currentClick = $(event.target).text().trim();
    } else {
      currentClick = "redirect";
    }

    if (c === "next") {
      if (currentStep === 1) {
        $("#back").fadeIn("slow");
        $("#next").text("金額計算・見積・注文へ").fadeIn("slow");
        $("#step2").fadeIn("slow");
        $("#dot-step1").addClass("active");
        $("#dot-step2").addClass("active");
      } else if (currentStep === 2) {
        $("#step3").fadeIn("slow");
        $("#back").fadeOut("fast");
        $("#next").fadeOut("fast");
        $("#dot-step1").addClass("active");
        $("#dot-step2").addClass("active");
        $("#dot-step3").addClass("active");
      }
    } else if (c === "back") {
      if (currentStep === 2) {
        $("#next").text("オプション入力へ").fadeIn("slow");
        $("#step1").fadeIn("slow");
        $("#back").fadeOut("fast");
        $("#dot-step1").addClass("active");
      } else {
        $("#back").fadeIn("slow");
        $("#next").text("金額計算・見積・注文へ").fadeIn("slow");
        $("#step2").fadeIn("slow");
        $("#dot-step1").addClass("active");
        $("#dot-step2").addClass("active");
      }
    } else if (c === "step1") {
      $("#next").text("オプション入力へ").fadeIn("slow");
      $("#step1").fadeIn("slow");
      $("#back").fadeOut("fast");
      $("#dot-step1").addClass("active");
    } else if (c === "step2") {
      $("#back").fadeIn("slow");
      $("#next").text("金額計算・見積・注文へ").fadeIn("slow");
      $("#step2").fadeIn("slow");
      $("#dot-step1").addClass("active");
      $("#dot-step2").addClass("active");
    } else if (c === "step3") {
      $("#step3").fadeIn("slow");
      $("#back").fadeOut("fast");
      $("#next").fadeOut("fast");
      $("#dot-step1").addClass("active");
      $("#dot-step2").addClass("active");
      $("#dot-step3").addClass("active");
    }

    $(window).scrollTop($(".step-container").offset().top);

    if (currentClick === "金額計算・見積・注文へ" || currentClick === "redirect") {
      let price_value = setToInputManual();
      if (Object.keys(price_value).length !== 0) {
        $.ajax({
          type: "POST",
          url: "/products/save_calc_data.php",
          data: price_value,
          success: function (response) {
            if (response.status == 200 && response.calculation_token) {
              $("#calculation_token").remove();
              $("<input>")
                .attr({
                  type: "hidden",
                  id: "calculation_token",
                  name: "calculation_token",
                  value: response.calculation_token,
                })
                .appendTo("form#form");
            }
          }
        });
      }
    }
  }
}

function valid_chk_btn2(c) {
  valid_chk_btn(c);
}

// ===== VALIDATION =====
function check_val(v) {
  var err_number = document.getElementById("err_numberOf_mess");
  var mess = "";
  if (err_number) {
    err_number.style.display = "";
  }
  var vNumberOfOder = $("#no_of_order");

  if (vNumberOfOder.val() == "" || parseInt(vNumberOfOder.val(), 10) < 100) {
    mess += "<font color='red'>本数は100本以上で入力して下さい。</font>";
    if (err_number) err_number.innerHTML = mess;
    return false;
  }

  if ($("input[name=ItemDesignVariation]").length) {
    switch ($("input[name=ItemDesignVariation]:checked").val()) {
      case "1種類":
      case "2種類":
        if (parseInt(vNumberOfOder.val(), 10) < 100) {
          mess += "<font color='red'>本数は100本以上で入力して下さい。</font>";
          if (err_number) err_number.innerHTML = mess;
          return false;
        } else {
          $("#err_numberOf_mess").hide();
        }
        break;
      case "3種類":
        if (parseInt(vNumberOfOder.val(), 10) < 150) {
          mess += "<font color='red'>本数は150本以上で入力して下さい。</font>";
          if (err_number) err_number.innerHTML = mess;
          return false;
        }
        break;
      case "4種類":
      case "5種類":
        if (parseInt(vNumberOfOder.val(), 10) < 200) {
          mess += "<font color='red'>本数は200本以上で入力して下さい。</font>";
          if (err_number) err_number.innerHTML = mess;
          return false;
        }
        break;
    }
  }

  if ($("input[name=ItemPCS]:checked").val() == "スタンダード（スピード7営業日発送）") {
    if (vNumberOfOder.val() == "" || parseInt(vNumberOfOder.val(), 10) > 300) {
      mess += "<font color='red'>本数は300本以下で入力して下さい。</font>";
      if (err_number) err_number.innerHTML = mess;
      return false;
    }
  }

  if (v == "next") {
    $("#err_numberOf_mess").hide();
    if ($("input[name=ItemPCS]").length && $("input[name=ItemPCS]:checked").val() == undefined) {
      $("#error_pcs").text("【必須】ご注文タイプをご選択ください");
      return false;
    } else if ($("input[name=coating]").length && $("input[name=coating]:checked").val() == undefined) {
      $("#error_coating").text("【必須】汚れ防止加工の有無をご選択ください");
      return false;
    } else if ($("input[name=ItemMaterial]").length && $("input[name=ItemMaterial]:checked").val() == undefined) {
      $("#error_material").text("【必須】特殊素材の有無をご選択ください");
      return false;
    } else {
      $("#error_pcs").text("");
      if ($("input[name=coating]").length) $("#error_coating").text("");
      if ($("input[name=ItemMaterial]").length) $("#error_material").text("");
      setToInput();
      return true;
    }
  } else {
    return true;
  }
}

// ===== MAIN CALCULATOR: AJAX-based =====
function setToInput() {
  clearValue();
  var vno_of_order = document.getElementById("no_of_order");

  // Get paper data
  if ($('input[name="paper_select"]').length) {
    var paper = $('input[name="paper_select"]:checked').val();
    var paper_color = $('input[name="paper"]:checked').val();

    if (paper != undefined && paper !== "なし" && paper !== "") {
      $(".paper-container").show();
      if (paper_color != undefined) {
        $("#sample-paper-pic").show();
        $("#sample-paper-pic").attr("src", "/products/acrylic/img/" + paper_color + ".jpg");
        $("#sample-paper-name").text(paper_color);
        $("#next").attr("disabled", false);
        $("#back").attr("disabled", false);
        $("#prd_paper").text(paper_color);
        $("#paper-error").text("");
        
        var tmp_pp = paperPrice_obj["1side"];
        if (paper_color == "paper-patternA-1") {
          tmp_pp = paperPrice_obj["1side"];
        } else if (paper_color == "paper-patternA-2") {
          tmp_pp = paperPrice_obj["2side"];
        } else {
          tmp_pp = paperPrice_obj["tmp"];
        }
        for (var i = 0, iMax = tmp_pp.length; i < iMax; i++) {
          if (parseInt(vno_of_order.value, 10) >= parseInt(tmp_pp[i].num, 10)) {
            paperPrice = Math.floor(tmp_pp[i].price);
            continue;
          }
          break;
        }
      } else {
        $("#paper-error").text("台紙を選択してください。");
        $("#next").attr("disabled", true);
        $("#back").attr("disabled", true);
      }
    } else {
      $("#sample-paper-pic").hide();
      $("#sample-paper-name").text("なし");
      $(".paper-container").hide();
      $("#paper-error").text("");
      $("#next").attr("disabled", false);
      $("#back").attr("disabled", false);
      $("#prd_paper").text("なし");
      $('input[name="paper"]').prop("checked", false);
      paperPrice = 0;
    }
  }

  if (vno_of_order && vno_of_order.value != "") {
    if ($("input[name=ItemPCS]").length && $("input[name=ItemPCS]:checked").val() != undefined) {
      $("#sample-prd-pcs").text($("input[name=ItemPCS]:checked").val());
      $("#prd_ItemPCS").text($("input[name=ItemPCS]:checked").val());
    }

    if ($("input[name=coating]").length && $("input[name=coating]:checked").val() != undefined) {
      $("#sample-prd-coating").text($("input[name=coating]:checked").val());
      $("#prd_coating").text($("input[name=coating]:checked").val());
    }

    if ($("input[name=ItemMaterial]").length && $("input[name=ItemMaterial]:checked").val() != undefined) {
      $("#sample-prd-material").text($("input[name=ItemMaterial]:checked").val());
      $("#prd_ItemMaterial").text($("input[name=ItemMaterial]:checked").val());
    }

    $("#sample-prd-qty").text(vno_of_order.value);
    $("#prd_qty").text(vno_of_order.value);

    if ($("input[name=SendPrototype]:checked").val() != undefined) {
      $("#prd_SendPrototype").text("あり");
      $("#sample-prd-samp").text("あり");
    } else {
      $("#prd_SendPrototype").text("なし");
      $("#sample-prd-samp").text("なし");
    }

    if ($("input[name=DeFormat]:checked").val() != undefined) {
      $("#prd_DeFormat").text("あり");
      $("#sample-prd-trace").text("あり");
    } else {
      $("#prd_DeFormat").text("なし");
      $("#sample-prd-trace").text("なし");
    }

    if ($("input[name=ItemDesignVariation]:checked").val() != undefined) {
      $("#prd_ItemDesign").text($("input[name=ItemDesignVariation]:checked").val());
    }

    // AJAX payload
    var formData = {
      ItemType: $("input[name=ItemType]").val() || "ペットボトルホルダー",
      ItemPCS: $("input[name=ItemPCS]:checked").val(),
      numberOf: $("#no_of_order").val(),
      coating: $("input[name=coating]:checked").val(),
      ItemMaterial: $("input[name=ItemMaterial]:checked").val(),
      ItemDesignVariation: $("input[name=ItemDesignVariation]:checked").val(),
      part: "なし",
      paper_select: $("input[name=paper_select]:checked").val(),
      paper: $("input[name=paper]:checked").val(),
      SendPrototype: $("input[name=SendPrototype]:checked").val(),
      DeFormat: $("input[name=DeFormat]:checked").val(),
      delivery_price: parseMoney($("#textfield_delivery").val() || 0)
    };

    $("#textfield11").val("計算中...");
    $(".prd_total").text("計算中...");

    $.post("/products/ajax_calculate_price_pbholder.php", formData, function(response) {
      if (response.success) {
        if(document.getElementById("textfield7")) document.getElementById("textfield7").value = formatMoney(response.StrapPrice);
        if(document.getElementById("textfield13_2")) document.getElementById("textfield13_2").value = formatMoney(response.coatingPrice);
        if(document.getElementById("textfield7_2")) document.getElementById("textfield7_2").value = formatMoney(response.PaperPrice);
        if(document.getElementById("textfield3")) document.getElementById("textfield3").value = formatMoney(response.ProShipping);
        if(document.getElementById("textfield4")) document.getElementById("textfield4").value = formatMoney(response.TraceCharge);
        if(document.getElementById("DesignsCharge")) document.getElementById("DesignsCharge").value = formatMoney(response.DesignsCharge);
        if(document.getElementById("MaterialCharge")) document.getElementById("MaterialCharge").value = formatMoney(response.MaterialCharge);
        if(document.getElementById("textfield9")) document.getElementById("textfield9").value = formatMoney(response.BeforeTax);
        if(document.getElementById("textfield_dis")) document.getElementById("textfield_dis").value = formatMoney(response.discount);
        if(document.getElementById("textfield_tax")) document.getElementById("textfield_tax").value = formatMoney(response.Tax);
        if(document.getElementById("textfield11")) document.getElementById("textfield11").value = formatMoney(response.grandTotal);
        $(".prd_total").text(formatMoney(response.grandTotal));
      } else {
        calculateLocal();
      }
    }, "json").fail(function() {
      calculateLocal();
    });
  }
}

// ===== LOCAL CALCULATOR FALLBACK =====
function calculateLocal() {
  var vno_of_order = document.getElementById("no_of_order");
  if (!vno_of_order || vno_of_order.value == "") return;

  var qty = parseInt(vno_of_order.value, 10);
  var order_pcs = 0;
  var selectedPCS = $("input[name=ItemPCS]:checked").val();

  if (selectedPCS == "プレミアム") {
    if (qty >= 5000) order_pcs = price_pbholder_premium[6];
    else if (qty >= 3000) order_pcs = price_pbholder_premium[5];
    else if (qty >= 1000) order_pcs = price_pbholder_premium[4];
    else if (qty >= 500) order_pcs = price_pbholder_premium[3];
    else if (qty >= 300) order_pcs = price_pbholder_premium[2];
    else if (qty >= 200) order_pcs = price_pbholder_premium[1];
    else if (qty >= 100) order_pcs = price_pbholder_premium[0];
  } else {
    if (qty >= 5000) order_pcs = price_pbholder_standard[6];
    else if (qty >= 3000) order_pcs = price_pbholder_standard[5];
    else if (qty >= 1000) order_pcs = price_pbholder_standard[4];
    else if (qty >= 500) order_pcs = price_pbholder_standard[3];
    else if (qty >= 300) order_pcs = price_pbholder_standard[2];
    else if (qty >= 200) order_pcs = price_pbholder_standard[1];
    else if (qty >= 100) order_pcs = price_pbholder_standard[0];
  }

  var speedSurchargeUnit = 0;
  if (selectedPCS == "スタンダード（スピード7営業日発送）") {
    if (qty >= 300) speedSurchargeUnit = speed_surcharge[2].price;
    else if (qty >= 200) speedSurchargeUnit = speed_surcharge[1].price;
    else if (qty >= 100) speedSurchargeUnit = speed_surcharge[0].price;
  }

  var localStrapPrice = (order_pcs + speedSurchargeUnit) * qty;

  var localCoating = 0;
  if ($("input[name=coating]:checked").val() == "汚れ防止加工あり") {
    localCoating = 70 * qty;
  }

  var localMaterial = 0;
  if ($("input[name=ItemMaterial]:checked").val() == "特殊素材あり") {
    localMaterial = 50 * qty;
  }

  var localProto = 0;
  if (selectedPCS != "プレミアム" && $("input[name=SendPrototype]:checked").val() != undefined) {
    localProto = 8000;
  }

  var localTrace = 0;
  if (selectedPCS != "プレミアム" && $("input[name=DeFormat]:checked").val() != undefined) {
    localTrace = 8000;
  }

  var localPaper = paperPrice * qty;

  var localDesign = 0;
  var designVal = $("input[name=ItemDesignVariation]:checked").val();
  if (designVal == "2種類") localDesign = 3000;
  else if (designVal == "3種類") localDesign = 6000;
  else if (designVal == "4種類") localDesign = 9000;
  else if (designVal == "5種類") localDesign = 12000;

  var discount = 0;
  var beforeTax = localStrapPrice + localCoating + localMaterial + localPaper + localProto + localTrace + localDesign;
  var subtotal = Math.max(0, beforeTax - discount);
  var localTax = Math.floor(subtotal * 0.10);
  var grandTotal = subtotal + localTax;

  if(document.getElementById("textfield7")) document.getElementById("textfield7").value = formatMoney(localStrapPrice);
  if(document.getElementById("textfield13_2")) document.getElementById("textfield13_2").value = formatMoney(localCoating);
  if(document.getElementById("textfield7_2")) document.getElementById("textfield7_2").value = formatMoney(localPaper);
  if(document.getElementById("textfield3")) document.getElementById("textfield3").value = formatMoney(localProto);
  if(document.getElementById("textfield4")) document.getElementById("textfield4").value = formatMoney(localTrace);
  if (document.getElementById("DesignsCharge")) document.getElementById("DesignsCharge").value = formatMoney(localDesign);
  if (document.getElementById("MaterialCharge")) document.getElementById("MaterialCharge").value = formatMoney(localMaterial);
  if(document.getElementById("textfield9")) document.getElementById("textfield9").value = formatMoney(subtotal);
  if(document.getElementById("textfield_dis")) document.getElementById("textfield_dis").value = formatMoney(discount);
  if(document.getElementById("textfield_tax")) document.getElementById("textfield_tax").value = formatMoney(localTax);
  if(document.getElementById("textfield11")) document.getElementById("textfield11").value = formatMoney(grandTotal);
  $(".prd_total").text(formatMoney(grandTotal));
}

// ===== MANUAL DATA PREPARATION FOR SAVE_CALC_DATA =====
function setToInputManual() {
  var vno_of_order = document.getElementById("no_of_order");
  if (!vno_of_order || vno_of_order.value == "") return {};

  return {
    ItemType: $("input[name=ItemType]").val() || "ペットボトルホルダー",
    ItemPCS: $("input[name=ItemPCS]:checked").val(),
    numberOf: $("#no_of_order").val(),
    coating: $("input[name=coating]:checked").val(),
    ItemMaterial: $("input[name=ItemMaterial]:checked").val(),
    ItemDesignVariation: $("input[name=ItemDesignVariation]:checked").val(),
    part: "なし",
    paper_select: $("input[name=paper_select]:checked").val(),
    paper: $("input[name=paper]:checked").val(),
    SendPrototype: $("input[name=SendPrototype]:checked").val(),
    DeFormat: $("input[name=DeFormat]:checked").val(),
    StrapPrice: parseMoney($("#textfield7").val()),
    coatingPrice: parseMoney($("#textfield13_2").val()),
    PaperPrice: parseMoney($("#textfield7_2").val()),
    ProShipping: parseMoney($("#textfield3").val()),
    TraceCharge: parseMoney($("#textfield4").val()),
    DesignsCharge: document.getElementById("DesignsCharge") ? parseMoney($("#DesignsCharge").val()) : 0,
    MaterialCharge: document.getElementById("MaterialCharge") ? parseMoney($("#MaterialCharge").val()) : 0,
    BeforeTax: parseMoney($("#textfield9").val()),
    discount: parseMoney($("#textfield_dis").val()),
    Tax: parseMoney($("#textfield_tax").val() || 0),
    grandTotal: parseMoney($("#textfield11").val())
  };
}

// ===== CLEAR =====
function clearValue() {
  var tf7 = document.getElementById("textfield7"); if (tf7) tf7.value = "";
  var tf13_2 = document.getElementById("textfield13_2"); if (tf13_2) tf13_2.value = "";
  var tf7_2 = document.getElementById("textfield7_2"); if (tf7_2) tf7_2.value = "";
  var tf3 = document.getElementById("textfield3"); if (tf3) tf3.value = "";
  var tf4 = document.getElementById("textfield4"); if (tf4) tf4.value = "";
  var dc = document.getElementById("DesignsCharge"); if (dc) dc.value = "";
  var mc = document.getElementById("MaterialCharge"); if (mc) mc.value = "";
  var tf9 = document.getElementById("textfield9"); if (tf9) tf9.value = "";
  var tfd = document.getElementById("textfield_dis"); if (tfd) tfd.value = "";
  var tft = document.getElementById("textfield_tax"); if (tft) tft.value = "";
  var tf11 = document.getElementById("textfield11"); if (tf11) tf11.value = "";
  $(".prd_total").text("0");
}

// ===== FORMAT HELPERS =====
function formatMoney(inum) {
  if (inum == "0" || inum == "") return inum;
  var s_inum = new String(inum);
  var s_inumInt = s_inum.split(".", s_inum);
  var l_inum = s_inumInt[0].length;
  var n_inum = "";
  for (let i = 0; i < l_inum; i++) {
    if (parseInt(l_inum - i, 10) % 3 == 0) {
      if (i == 0) n_inum += s_inum.charAt(i);
      else n_inum += "," + s_inum.charAt(i);
    } else {
      n_inum += s_inum.charAt(i);
    }
  }
  if (s_inumInt[1] != undefined) n_inum += "." + s_inumInt[1];
  return n_inum;
}

function parseMoney(value) {
  var numeric = String(value || "").replace(/[^\d.-]/g, "");
  return numeric === "" ? 0 : parseInt(numeric, 10);
}

function click_typeorder_enabled() {
  type_special_disabled("f1");
}
function click_typeorder_disabled() {
  type_special_disabled("f1");
}
function type_special_disabled(c) {
  $("#pcs3").attr("checked", false);
  $(".pcs_option").hide();
}
