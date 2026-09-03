/**
 * calculate-tumbler-renew.js
 * Original Tumbler Renewal Calculator
 * Handles validation, AJAX calls to PHP DB pricing, and UI updates.
 * Based on calculater_tumbler.js but uses DB pricing + separate VAT 10% display.
 */

var vat = 10;

function formatMoney(num) {
  return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function parseMoney(str) {
  return parseInt(str.toString().replace(/[^\d.]/g, ""), 10) || 0;
}

// --- Promotional period: 20 Apr – 31 May (no charge for prototype & data trace) ---
function isPromoPeriod() {
  var now = new Date();
  var japanNow = new Date(
    now.toLocaleString("en-US", { timeZone: "Asia/Tokyo" })
  );
  var start = new Date(japanNow.getFullYear(), 3, 20, 0, 0, 0);
  var end = new Date(japanNow.getFullYear(), 4, 31, 23, 59, 59);
  return japanNow >= start && japanNow <= end;
}

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
        $("#next").text("アタッチメント・オプション入力へ").fadeIn("slow");
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
      $("#next").text("アタッチメント・オプション入力へ").fadeIn("slow");
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
          },
          error: function (xhr, status, error) {
            console.log(error);
          },
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

  // Shape processing visibility for data trace
  if ($('input[name=shape_processing]:checked').val() == "フルカラー（3DUV印刷）") {
    $('#trace-radio').css('display', 'none');
  } else {
    $('#trace-radio').css('display', 'block');
  }

  // Prototype availability check (100+ only)
  if (parseInt(vNumberOfOder.val(), 10) < 100) {
    $("input[name=SendPrototype]").prop('checked', false);
    $("input[name=SendPrototype]").removeAttr('checked');
    $("input[name=SendPrototype]").attr('disabled', true);
    $('#sample-error').text('試作品は100個以上のご注文から受付');
  } else {
    $('#sample-error').text('');
    $("input[name=SendPrototype]").attr('disabled', false);
  }

  // Min lot = 100
  if (vNumberOfOder.val() == "" || parseInt(vNumberOfOder.val(), 10) < 100) {
    mess += "<font color='red'>本数は100本以上で入力して下さい。</font>";
    if (err_number) err_number.innerHTML = mess;
    return false;
  }

  // Max lot = 2000
  if (parseInt(vNumberOfOder.val(), 10) > 2000) {
    mess += "<font color='red'>本数は2,000本以下で入力して下さい。2,000以上のお客様は納期をメールにてお問い合わせ下さい。</font>";
    if (err_number) err_number.innerHTML = mess;
    return false;
  }

  if (v == "next") {
    $("#err_numberOf_mess").hide();
    if ($("input[name=shape_processing]").length && $("input[name=shape_processing]:checked").val() == undefined) {
      $("#error_message").html("<font color='red'>【必須】加工タイプをご選択ください</font>");
      return false;
    } else {
      $("#error_message").text("");
      setToInput();
      return true;
    }
  } else {
    return true;
  }
}

// ===== MAIN CALCULATOR (AJAX DB-based) =====
function setToInput() {
  clearValue();

  var vno_of_order = document.getElementById("no_of_order");

  if (vno_of_order && vno_of_order.value != "") {
    var shapeVal = $("input[name=shape_processing]:checked").val();
    var prototypeVal = $("input[name=SendPrototype]:checked").val() || "なし";
    var traceVal = $("input[name=DeFormat]:checked").val() || "なし";

    // Update step 1 summary box
    $("#sample-processing").text(shapeVal ? shapeVal : "-");
    $("#sample-prd-qty").text(vno_of_order.value);
    $("#sample-prd-samp").text(prototypeVal === "あり" ? "あり" : "なし");
    $("#sample-prd-trace").text(traceVal === "あり" ? "あり" : "なし");

    // Update step 3 specifications
    $("#prd_Processing").text(shapeVal ? shapeVal : "");
    $("#prd_qty").text(vno_of_order.value);
    $("#prd_SendPrototype").text(prototypeVal === "あり" ? "あり" : "なし");
    $("#prd_DeFormat").text(traceVal === "あり" ? "あり" : "なし");

    // AJAX payload
    var formData = {
      ItemType: $("input[name=ItemType]").val(),
      shape_processing: shapeVal,
      numberOf: vno_of_order.value,
      SendPrototype: prototypeVal,
      DeFormat: traceVal,
      ItemDesignRepeat: $("input[name=ItemDesignRepeat]:checked").val() || "いいえ",
      design_no: $("input[name=design_no]").val() || ""
    };

    // Attach loading state
    $("#prd_price").val("計算中...");
    $("#prd_trace_price").val("計算中...");
    $("#prd_sample_price").val("計算中...");
    $("#prd_sub_total").val("計算中...");
    $("#prd_vat_10").val("計算中...");
    $("#prd_total").val("計算中...");
    $(".prd_total").text("計算中...");

    $.post("/products/tumbler/ajax_calculate_price_tumbler.php", formData, function(response) {
      if (response.success) {
        $("#prd_price").val(formatMoney(response.StrapPrice));
        $("#prd_sample_price").val(formatMoney(response.ProShipping));
        $("#prd_trace_price").val(formatMoney(response.TraceCharge));
        $("#prd_sub_total").val(formatMoney(response.BeforeTax));
        $("#prd_vat_10").val(formatMoney(response.Tax));
        $("#discount").val(formatMoney(response.discount));
        $("#prd_total").val(formatMoney(response.grandTotal));
        $(".prd_total").text(formatMoney(response.grandTotal));

        // Update hidden fields for form submission
        $("#hdn_BeforeTax").val(response.BeforeTax);
        $("#hdn_grandTotal").val(response.grandTotal);
      } else {
        alert("価格の計算中にエラーが発生しました: " + response.error);
      }
    }, "json").fail(function(xhr, status, error) {
      alert("通信エラーが発生しました。");
    });
  }
}

function setToInputManual() {
  var vno_of_order = document.getElementById("no_of_order");
  if (!vno_of_order || vno_of_order.value == "") {
    return {};
  }
  return {
    ItemType: $("input[name=ItemType]").val(),
    shape_processing: $("input[name=shape_processing]:checked").val(),
    numberOf: vno_of_order.value,
    SendPrototype: $("input[name=SendPrototype]:checked").val() || "なし",
    DeFormat: $("input[name=DeFormat]:checked").val() || "なし",
    ItemDesignRepeat: $("input[name=ItemDesignRepeat]:checked").val() || "いいえ",
    design_no: $("input[name=design_no]").val() || "",
    prd_price: parseMoney($("#prd_price").val()),
    prd_sample_price: parseMoney($("#prd_sample_price").val()),
    prd_trace_price: parseMoney($("#prd_trace_price").val()),
    BeforeTax: parseMoney($("#prd_sub_total").val()),
    Tax: parseMoney($("#prd_vat_10").val() || Math.floor(parseMoney($("#prd_sub_total").val()) * 0.10)),
    grandTotal: parseMoney($("#prd_total").val()),
    prd_sub_total: parseMoney($("#prd_sub_total").val()),
    prd_total: parseMoney($("#prd_total").val()),
    discount: parseMoney($("#discount").val())
  };
}

function clearValue() {
  $("#prd_price").val("");
  $("#prd_trace_price").val("");
  $("#prd_sample_price").val("");
  $("#prd_sub_total").val("");
  $("#prd_vat_10").val("");
  $("#prd_total").val("");
  $("#discount").val("");
  $(".prd_total").text("0");
}

function format_number(val) {
  var num = parseInt(val.toString().replace(/[^\d.]/g, ""), 10);
  if (isNaN(num)) return "";
  return num;
}

///comma////
function formatMoney(inum) {
  if (inum == '0' || inum == '') {
    return inum;
  }
  var s_inum = new String(inum);
  var s_inumInt = s_inum.split(".", s_inum);
  var l_inum = s_inumInt[0].length;
  var n_inum = "";
  for (i = 0; i < l_inum; i++) {
    if (parseInt(l_inum - i) % 3 == 0) {
      if (i == 0) {
        n_inum += s_inum.charAt(i);
      } else {
        n_inum += "," + s_inum.charAt(i);
      }
    } else {
      n_inum += s_inum.charAt(i);
    }
  }
  if (s_inumInt[1] != undefined) {
    n_inum += "." + s_inumInt[1];
  }
  return n_inum;
}

$(document).ready(function() {
  // Bind inputs to automatically calculate pricing when changed in visible steps
  $("#no_of_order").on("change keyup", function() {
    if ($("#step1").is(":visible")) {
      check_val("step1");
    }
  });

  $("input[name=shape_processing]").on("change", function() {
    if ($("#step1").is(":visible")) {
      check_val("step1");
    }
  });

  $("input[name=SendPrototype], input[name=DeFormat]").on("change", function() {
    setToInput();
  });
});
