// PLUSHIE_PRICING_START
function isValidPlushieQuantity(value) {
  if (typeof value === "string") {
    var trimmedValue = value.trim();
    if (!/^\d+$/.test(trimmedValue)) {
      return false;
    }
    value = Number(trimmedValue);
  }

  return typeof value === "number" && Number.isInteger(value) && value >= 300 && value <= 3000;
}

function getPlushieUnitPrice(quantity) {
  if (!isValidPlushieQuantity(quantity)) {
    return null;
  }

  quantity = Number(quantity);
  if (quantity >= 3000) return 1338;
  if (quantity >= 2000) return 1379;
  if (quantity >= 1000) return 1422;
  if (quantity >= 500) return 1541;
  return 1637;




  // if (quantity <= 300) return 1637;
  // if (quantity <= 500) return 1541;
  // if (quantity <= 1000) return 1422;
  // if (quantity <= 2000) return 1379;
  // return 1338;
}

function calculatePlushieTotals(quantity, attachmentUnitPrice) {
  var unitPrice = getPlushieUnitPrice(quantity);
  var attachmentPrice = Number(attachmentUnitPrice);
  if (unitPrice === null || !Number.isFinite(attachmentPrice) || attachmentPrice < 0) {
    return null;
  }

  quantity = Number(quantity);
  var productTotal = unitPrice * quantity;
  var attachmentTotal = attachmentPrice * quantity;
  var moldFee = 15500;
  var subtotal = productTotal + attachmentTotal + moldFee;
  var tax =
    Math.floor((productTotal * 10) / 110) +
    Math.floor((attachmentTotal * 10) / 110) +
    Math.floor((moldFee * 10) / 110);

  return {
    unitPrice: unitPrice,
    productTotal: productTotal,
    attachmentTotal: attachmentTotal,
    moldFee: moldFee,
    subtotal: subtotal,
    tax: tax,
    total: subtotal,
  };
}
// PLUSHIE_PRICING_END

function valid_chk_btn(c) {
  if (check_val(c)) {
    $("#step1").fadeOut("fast");
    $("#step2").fadeOut("fast");
    $("#step3").fadeOut("fast");
    $("#dot-step1").removeClass("active");
    $("#dot-step2").removeClass("active");
    $("#dot-step3").removeClass("active");

    //New condition check button click
    let currentClick = null;
    if (typeof event !== "undefined" && event && event.target) {
      currentClick = $(event.target).text();
    } else {
      currentClick = "redirect";
    }

    switch ($("#next").text()) {
      case "オプション入力へ":
        if (c == "next" || c == "step2") {
          $("#back").fadeIn("slow");
          $("#next").text("金額計算・見積・注文へ");
          $("#next").blur();
          $("#step2").fadeIn("slow");
          $("#dot-step1").addClass("active");
          $("#dot-step2").addClass("active");
        } else if (c == "step3") {
          $("#next").text("金額計算・見積・注文へ");
          $("#next").blur();
          $("#step3").fadeIn("slow");
          $("#back").fadeOut("fast");
          $("#next").fadeOut("fast");
          $("#dot-step1").addClass("active");
          $("#dot-step2").addClass("active");
          $("#dot-step3").addClass("active");
        }
        break;
      case "金額計算・見積・注文へ":
        if (c == "next") {
          $("#step3").fadeIn("slow");
          $("#back").fadeOut("fast");
          $("#next").fadeOut("fast");
          $("#dot-step1").addClass("active");
          $("#dot-step2").addClass("active");
          $("#dot-step3").addClass("active");
        } else if (c == "back" || c == "step1") {
          $("#next").fadeIn("slow");
          $("#step1").fadeIn("slow");
          $("#next").text("オプション入力へ");
          $("#next").blur();
          $("#back").fadeOut("fast");
          $("#dot-step1").addClass("active");
        } else {
          $("#back").fadeIn("slow");
          $("#next").fadeIn("slow");
          $("#next").text("金額計算・見積・注文へ");
          $("#next").blur();
          $("#step2").fadeIn("slow");
          $("#dot-step1").addClass("active");
          $("#dot-step2").addClass("active");
        }
    }
    $(window).scrollTop($(".step-container").offset().top);

    //New condition check price adapt
    // if (
    //   currentClick != "" &&
    //   currentClick !== undefined &&
    //   currentClick === "金額計算・見積・注文へ"
    // ) {
    //   let price_value = setToInputManual();
    //   if (Object.keys(price_value).length !== 0) {
    //     $.ajax({
    //       type: "POST",
    //       url: "/products/save_calc_data.php",
    //       data: price_value,
    //       success: function (response) {
    //         if (response.status == 200 && response.calculation_token) {
    //           $("#calculation_token").remove();
    //           $("<input>")
    //             .attr({
    //               type: "hidden",
    //               id: "calculation_token",
    //               name: "calculation_token",
    //               value: response.calculation_token,
    //             })
    //             .appendTo("form#form");
    //         }
    //       },
    //       error: function (xhr, status, error) {
    //         console.log(error);
    //       },
    //     });
    //   }
    // } else {
    //   if (
    //     currentClick != "" &&
    //     currentClick !== undefined &&
    //     currentClick === "redirect"
    //   ) {
    //     let pk = $("#strap").val();
    //     if (
    //       pk !== undefined &&
    //       (pk == "ラバーコースター" ||
    //         pk == "ラバースマートフォンスタンド" ||
    //         pk == "ラバータグ" ||
    //         pk == "ペットボトルホルダー" ||
    //         pk == "ラバーケーブルバンド")
    //     ) {
    //       let price_items = setToInputManual();
    //       if (Object.keys(price_items).length !== 0) {
    //         $.ajax({
    //           type: "POST",
    //           url: "/products/save_calc_data.php",
    //           data: price_items,
    //           success: function (response) {
    //             if (response.status == 200 && response.calculation_token) {
    //               $("#calculation_token").remove();
    //               $("<input>")
    //                 .attr({
    //                   type: "hidden",
    //                   id: "calculation_token",
    //                   name: "calculation_token",
    //                   value: response.calculation_token,
    //                 })
    //                 .appendTo("form#form");
    //             }
    //           },
    //           error: function (xhr, status, error) {
    //             console.log(error);
    //           },
    //         });
    //       }
    //     }
    //   }
    // }
  }
}

function valid_chk_btn2(c) {
  if (check_val(c)) {
    $("#step1").fadeOut("fast");
    $("#step2").fadeOut("fast");
    $("#step3").fadeOut("fast");
    $("#dot-step1").removeClass("active");
    $("#dot-step2").removeClass("active");
    $("#dot-step3").removeClass("active");

    //New condition check button click
    let currentClick = null;
    if (typeof event !== "undefined" && event && event.target) {
      currentClick = $(event.target).text(); // value from click
    } else {
      currentClick = "redirect"; // value from redirect
    }

    switch ($("#next").text()) {
      case "オプション入力へ":
        if (c == "next" || c == "step2") {
          $("#back").fadeIn("slow");
          $("#next").text("金額計算・見積・注文へ");
          $("#next").blur();
          $("#step2").fadeIn("slow");
          $("#dot-step1").addClass("active");
          $("#dot-step2").addClass("active");
        } else if (c == "step3") {
          $("#next").text("金額計算・見積・注文へ");
          $("#next").blur();
          $("#step3").fadeIn("slow");
          $("#back").fadeOut("fast");
          $("#next").fadeOut("fast");
          $("#dot-step1").addClass("active");
          $("#dot-step2").addClass("active");
          $("#dot-step3").addClass("active");
        }
        break;
      case "金額計算・見積・注文へ":
        if (c == "next") {
          $("#step3").fadeIn("slow");
          $("#back").fadeOut("fast");
          $("#next").fadeOut("fast");
          $("#dot-step1").addClass("active");
          $("#dot-step2").addClass("active");
          $("#dot-step3").addClass("active");
        } else if (c == "back" || c == "step1") {
          $("#next").fadeIn("slow");
          $("#step1").fadeIn("slow");
          $("#next").text("オプション入力へ");
          $("#next").blur();
          $("#back").fadeOut("fast");
          $("#dot-step1").addClass("active");
        } else {
          $("#back").fadeIn("slow");
          $("#next").fadeIn("slow");
          $("#next").text("金額計算・見積・注文へ");
          $("#next").blur();
          $("#step2").fadeIn("slow");
          $("#dot-step1").addClass("active");
          $("#dot-step2").addClass("active");
        }
    }
    $(window).scrollTop($(".step-container").offset().top);

    //New condition check price adapt
    if (
      currentClick != "" &&
      currentClick !== undefined &&
      currentClick === "金額計算・見積・注文へ"
    ) {
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
    } else {
      if (
        currentClick != "" &&
        currentClick !== undefined &&
        currentClick === "redirect"
      ) {
        let pk = $("#strap").val();
        if (
          pk !== undefined &&
          (pk == "ラバーコースター" ||
            pk == "ラバースマートフォンスタンド" ||
            pk == "ラバータグ" ||
            pk == "ペットボトルホルダー")
        ) {
          let price_items = setToInputManual();
          if (Object.keys(price_items).length !== 0) {
            $.ajax({
              type: "POST",
              url: "/products/save_calc_data.php",
              data: price_items,
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
  }
}

function check_val(v) {
  var plushieQuantity = $("#no_of_order").val();
  if (!isValidPlushieQuantity(plushieQuantity)) {
    var quantityMessage = "本数は300本以上で入力して下さい。";
    // $("#error_message").text(quantityMessage);
    $("#err_numberOf_mess").html("<font color='red'>" + quantityMessage + "</font>").show();
    return false;
  }

  $("#error_message").text("");
  $("#err_numberOf_mess").empty().hide();
  setToInput();
  return true;

  var ItemType = $("input[name=ItemType]").val();

  //エラー出力用id
  var err_number = document.getElementById("err_numberOf_mess");
  var mess = "";

  err_number.style.display = "";

  //入力値
  var vNumberOfOder = $("#no_of_order");

    if (
      (vNumberOfOder.val() == "" || vNumberOfOder.val() < 500)) {
      mess += "<font color='red'>本数は500本以上で入力して下さい。</font>";
      err_number.innerHTML = mess;
      return false;
    }


  if (v == "next") {


    if (
      $("input[name=ItemPCS]:checked").val() != "ホットモバイリーファン" &&
      $("input[name=ItemType]").val() != "ラバーコースター"
    ) {
      if (
        $("input[name=ItemType]").val() !=
        "印刷ラバーストラップ・ラバーキーホルダー" &&
        !validation_numberOf()
      ) {
        return false;
      } else {
        $("#err_numberOf_mess").hide();
        if (
          $("input[name=ItemPCS]").length &&
          $("input[name=ItemPCS]:checked").val() == undefined
        ) {
          $("#error_pcs").text("【必須】ご注文タイプをご選択ください");
          return false;
        } else if (
          $("input[name=silk_print]").length &&
          ItemType != "ラバータグ" &&
          ItemType != "ペットボトルホルダー" &&
          $("input[name=silk_print]:checked").val() == undefined
        ) {
          $("#error_print").text(
            "【必須】裏面シルク印刷の有無をご選択ください",
          );
          return false;
        } else if (
          $("input[name=coating]").length &&
          $("input[name=coating]:checked").val() == undefined
        ) {
          $("#error_coating").text(
            "【必須】汚れ防止加工の有無をご選択ください",
          );
          return false;
        } else if (
          $("input[name=ItemShape]").length &&
          $("input[name=ItemShape]:checked").val() == undefined
        ) {
          $("#error_shape").text("【必須】形状タイプをご選択ください");
          return false;
        } else if (
          $("input[name=ItemPrint]").length &&
          $("input[name=ItemPrint]:checked").val() == undefined
        ) {
          $("#error_print").text("【必須】印刷の有無をご選択ください");
          return false;
        } else if (
          $("input[name=ItemColor]").length &&
          $("input[name=ItemColor]:checked").val() == undefined
        ) {
          $("#error_color").text("【必須】色タイプをご選択ください");
          return false;
        } else {
          // console.log('no error');
          $("#error_pcs").text("");
          $("#error_print").text("");
          if ($("input[name=coating]").length) {
            $("#error_coating").text("");
          }
          if ($("input[name=ItemShape]").length) {
            $("#error_shape").text("");
          }
          if ($("input[name=ItemPrint]").length) {
            $("#error_print").text("");
          }
          if ($("input[name=ItemColor]").length) {
            $("#error_color").text("");
          }
          setToInput();
          return true;
        }
      }
    } else {
        $("#err_numberOf_mess").hide();
        $("#error_pcs").text("");
        $("#error_print").text("");
        if ($("input[name=coating]").length) {
          $("#error_coating").text("");
        }
        setToInput();
        return true;
    }
  } else {
    setToInput();
    return true;
  }
}

var price_bracket = 0;
var packing_price = 0;
var proto_shipping_charge = 0;
var order_pcs = 0;
var unit_price = 0;
var strap_price = 0;
var before_tax = 0;
var tax = 0;
var vat = 10;
var total = 0;
var silkprint = 0;
var partPrice = 0;
var TextField7Value = 0;
var TextField9Value = 0;
var DisPrice = 0;
var proto_charge = 0;
var trace_charge = 0;
var print_charge = 0;
var coating_charge = 0;

var DesignsCharge = 0;
var MaterialCharge = 0;

var special_shape_fee = 0;
var mold_charge = 15500;
var part = "";

function setPlushieField(id, value) {
  var field = document.getElementById(id);
  if (field) {
    field.value = value;
  }
}

function clearPlushieTotals() {
  setPlushieField("textfield2", "");
  setPlushieField("textfield7", "");
  setPlushieField("textfield7_1", "");
  setPlushieField("textfield9", "");
  setPlushieField("textfield_dis", "");
  setPlushieField("textfield11", "");
  $(".prd_total").text("0");
}

function getSelectedPlushiePart() {
  var selectedPart = $("input[name=part]:checked");
  var name = selectedPart.length ? selectedPart.val() : "なし";
  var price = Number(selectedPart.attr("data-price"));

  return {
    name: name || "なし",
    price: Number.isFinite(price) && price >= 0 ? price : 0,
    image: selectedPart.attr("data-image") || "",
  };
}

function updatePlushiePartDisplay(selectedPart) {
  var displayName = selectedPart.name || "なし";
  $("#sample-prd-part, #sample-part-name, #prd_part").text(displayName);

  // if (selectedPart.name === "なし" || !selectedPart.image) {
  if (!selectedPart.image) {
    $("#sample-part-pic").hide().attr("src", "");
  } else {
    $("#sample-part-pic").attr("src", selectedPart.image).show();
  }
}

function setToInput() {
  var quantity = $("#no_of_order").val();
  if (!isValidPlushieQuantity(quantity)) {
    clearPlushieTotals();
    return null;
  }

  var selectedPart = getSelectedPlushiePart();
  var totals = calculatePlushieTotals(quantity, selectedPart.price);
  if (!totals) {
    clearPlushieTotals();
    return null;
  }

  part = selectedPart.name === "なし" ? "" : selectedPart.name;
  partPrice = selectedPart.price;
  order_pcs = totals.unitPrice;
  TextField7Value = totals.productTotal;
  TextField9Value = totals.subtotal;
  DisPrice = 0;
  tax = totals.tax;
  total = totals.total;

  $("#sample-prd-pcs, #prd_qty").text(quantity);
  updatePlushiePartDisplay(selectedPart);
  setPlushieField("textfield2", formatMoney(totals.moldFee));
  setPlushieField("textfield7", formatMoney(totals.productTotal));
  setPlushieField("textfield7_1", formatMoney(totals.attachmentTotal));
  setPlushieField("textfield9", formatMoney(totals.subtotal));
  setPlushieField("textfield_dis", "0");
  setPlushieField("textfield11", formatMoney(totals.total));
  $(".prd_total").text(formatMoney(totals.total));
  return totals;
}

function setToInputManual() {
  setToInput();
  return {};
}


function clearValue() {
  part = "";
  partPrice = 0;
  order_pcs = 0;
  TextField7Value = 0;
  TextField9Value = 0;
  DisPrice = 0;
  tax = 0;
  total = 0;
  $("#no_of_order").val("");
  $("input[name=part][value='なし']").prop("checked", true);
  $("input[name=ItemDesignRepeat][value='いいえ']").prop("checked", true);
  $("input[name=design_no]").val("");
  $(".repeat").hide();
  $("#sample-prd-pcs, #prd_qty").text("-");
  updatePlushiePartDisplay({
    name: "なし",
    price: 0,
    image: "",
  });
  clearPlushieTotals();
  $("#error_message").text("");
  $("#err_numberOf_mess").empty().hide();
  $("#step1").show();
  $("#step2, #step3").hide();
  $("#dot-step1").addClass("active");
  $("#dot-step2, #dot-step3").removeClass("active");
  $("#back").hide();
  $("#next").show().text("オプション入力へ");
  $("#modal-ord").prop("checked", false);
  return;
}

///comma////
function formatMoney(inum) {
  if (inum == "0" || inum == "") {
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

///input only number////
function check_num() {
  m = String.fromCharCode(event.keyCode);
  if ("0123456789\b\r".indexOf(m, 0) < 0) return false;
  return true;
}

//clear 0 first char
function format_number(number) {
  if (number === "" || number === null || number === undefined) {
    return number;
  }

  var value = String(number).trim();
  if (/^\d+$/.test(value)) {
    return String(Number(value));
  }

  return number;
}

this.typeOrder = document.getElementsByName("ItemType");

// standard
function click_typeorder_enabled() {
  $(".part_price_std").show();
  $(".part_price_prm").hide();
  type_special_disabled("f1");
}

// premium
function click_typeorder_disabled() {
  $(".part_price_std").hide();
  $(".part_price_prm").show();
  type_special_disabled("f1");
}

function type_special_disabled(c) {
  if (c == "t1") {
    var amount;
    // Get order amount in database
    $.get("/count_order.php", function (data) {
      amount = $.parseJSON(data);
    }).done(function () {
      // Show status
      $(".pcs_option").fadeIn();
      if (amount == 0) {
        $("#pcs_txt").text("受付中です。ご注文頂けます");
        $("#pcs_status").attr("class", "pcs_01");
      } else if (amount < 5) {
        $("#pcs_txt").text("今週の受付数はあと1～2件です");
        $("#pcs_status").attr("class", "pcs_02");
      } else {
        $("#pcs_txt").text(
          "今週の受付数量を越えております為、ご注文停止中です",
        );
        $("#pcs_status").attr("class", "pcs_03");
        $(".btn-next").attr("disabled", true);
      }
      // Set disable
      $("#ariprint").attr("disabled", true);
      $("#fcprint").attr("disabled", true);
      $("#nashiprint").prop("checked", true);
      if ($("#coating1").length) {
        $("#coating1").attr("disabled", true);
        $("#coating0").prop("checked", true);
      }
      if ($("input[name=ItemSize]").length) {
        $("#big_size").attr("disabled", true);
        $("#normal_size").prop("checked", true);
      }
      $("#no_of_order").val("10");
      $("#no_of_order").attr("readonly", true);
      $(".part_price_std").hide();
      $(".part_price_prm").show();
      $("input[name=paper_select]").attr("disabled", true);
      $("input[name=SendPrototype]").attr("disabled", true);
      $("input[name=DeFormat]").prop("checked", true);
      $("input[name=DeFormat]").attr("disabled", true);
      $("#button_pdf2").attr("disabled", true);
    });
  } else {
    $("#pcs3").attr("checked", false);
    $(".pcs_option").hide();
    $("#ariprint").attr("disabled", false);
    $("#fcprint").attr("disabled", false);

    if (
      $("input[name=ItemPCS]:checked").val() ==
      "スタンダード（スピード7営業日発送）"
    ) {
      if ($("#coating1").length) {
        $("#coating0").prop("checked", true);
        $("#coating1").attr("disabled", true);
      }
    } else {
      if ($("#coating1").length) {
        $("#coating1").attr("disabled", false);
      }
    }
    if ($("input[name=ItemSize]").length) {
      $("#big_size").attr("disabled", false);
    }
    $("#no_of_order").attr("readonly", false);
    $("input[name=paper_select]").attr("disabled", false);
    $("input[name=SendPrototype]").attr("disabled", false);
    $("input[name=DeFormat]").attr("disabled", false);
    $("#button_pdf2").attr("disabled", false);
    $(".btn-next").attr("disabled", false);
  }
}

function getPartData() {
  setToInput();
}

/*

    //check case click back
    // let prd_strap = $("#strap").val();
    // if (
    //   tmp != "" &&
    //   tmp == "MODE_MOD" &&
    //   prd_strap != "ラバーコースター" &&
    //   prd_strap != "ラバースマートフォンスタンド" &&
    //   prd_strap != "ラバータグ" &&
    //   prd_strap != "ペットボトルホルダー"
    // ) {
    //   let items = setToInputManual();
    //   if (Object.keys(items).length !== 0) {
    //     $.ajax({
    //       type: "POST",
    //       url: "/products/save_calc_data.php",
    //       data: items,
    //       success: function (response) {
    //         if (response.status == 200 && response.calculation_token) {
    //           $("#calculation_token").remove();
    //           $("<input>")
    //             .attr({
    //               type: "hidden",
    //               id: "calculation_token",
    //               name: "calculation_token",
    //               value: response.calculation_token,
    //             })
    //             .appendTo("form#form");
    //         }
    //       },
    //       error: function (xhr, status, error) {
    //         console.log(error);
    //       },
    //     });
    //   }
    // }
  });
}
*/
