// 3D Rubber Prices (100, 300, 500, 1000, 2000, 5000)
// Including tax: [1872, 1315, 1090, 797, 655, 556]
// Excluding tax: [1702, 1196, 991, 725, 596, 506]
var price_candy_sticker_standard = [1872, 1315, 1090, 797, 655, 556];

var paperPrice_obj = {
  "1side": [
    { num: 1, price: 1030 },
    { num: 2, price: 530 },
    { num: 3, price: 363 },
    { num: 4, price: 280 },
    { num: 5, price: 230 },
    { num: 6, price: 197 },
    { num: 7, price: 173 },
    { num: 8, price: 155 },
    { num: 9, price: 141 },
    { num: 10, price: 130 },
    { num: 20, price: 80 },
    { num: 30, price: 63 },
    { num: 40, price: 55 },
    { num: 50, price: 50 },
    { num: 60, price: 47 },
    { num: 70, price: 44 },
    { num: 80, price: 43 },
    { num: 90, price: 41 },
    { num: 100, price: 40 },
    { num: 200, price: 26 },
    { num: 300, price: 21 },
    { num: 400, price: 18 },
    { num: 500, price: 15 },
    { num: 600, price: 15 },
    { num: 700, price: 13 },
    { num: 800, price: 13 },
    { num: 900, price: 12 },
    { num: 1000, price: 12 },
  ],
  "2side": [
    { num: 1, price: 1230 },
    { num: 2, price: 630 },
    { num: 3, price: 430 },
    { num: 4, price: 330 },
    { num: 5, price: 270 },
    { num: 6, price: 230 },
    { num: 7, price: 201 },
    { num: 8, price: 180 },
    { num: 9, price: 163 },
    { num: 10, price: 150 },
    { num: 20, price: 90 },
    { num: 30, price: 70 },
    { num: 40, price: 60 },
    { num: 50, price: 54 },
    { num: 60, price: 50 },
    { num: 70, price: 47 },
    { num: 80, price: 45 },
    { num: 90, price: 43 },
    { num: 100, price: 42 },
    { num: 200, price: 27 },
    { num: 300, price: 22 },
    { num: 400, price: 19 },
    { num: 500, price: 16 },
    { num: 600, price: 16 },
    { num: 700, price: 14 },
    { num: 800, price: 14 },
    { num: 900, price: 13 },
    { num: 1000, price: 13 },
  ],
  tmp: [
    { num: 1, price: 830 },
    { num: 2, price: 430 },
    { num: 3, price: 297 },
    { num: 4, price: 230 },
    { num: 5, price: 190 },
    { num: 6, price: 163 },
    { num: 7, price: 144 },
    { num: 8, price: 130 },
    { num: 9, price: 119 },
    { num: 10, price: 110 },
    { num: 20, price: 70 },
    { num: 30, price: 57 },
    { num: 40, price: 50 },
    { num: 50, price: 46 },
    { num: 60, price: 43 },
    { num: 70, price: 41 },
    { num: 80, price: 40 },
    { num: 90, price: 39 },
    { num: 100, price: 38 },
    { num: 200, price: 25 },
    { num: 300, price: 21 },
    { num: 400, price: 18 },
    { num: 500, price: 14 },
    { num: 600, price: 14 },
    { num: 700, price: 12 },
    { num: 800, price: 12 },
    { num: 900, price: 11 },
    { num: 1000, price: 11 },
  ],
};

var parts_obj;
var paperPrice = 0;
var unit_price = 0;

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
  var ItemType = $("input[name=ItemType]").val();

  //エラー出力用id
  var err_number = document.getElementById("err_numberOf_mess");
  var mess = "";

  err_number.style.display = "";

  //入力値
  var vNumberOfOder = $("#no_of_order");
  var orderVal = parseInt(vNumberOfOder.val(), 10);

  if (vNumberOfOder.val() == "" || isNaN(orderVal) || orderVal < 100) {
    mess += "<font color='red'>数量は100個以上で入力して下さい。</font>";
    err_number.innerHTML = mess;
    return false;
  } else if (orderVal > 5000) {
    mess += "<font color='red'>数量は5,000個以下で入力して下さい。5,000個以上をご希望の場合はお問い合わせください。</font>";
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
        } else if (
          $("#step2").is(":visible") &&
          $("input[name=acy_part]").length &&
          $("input[name=acy_part]:checked").val() == undefined
        ) {
          $("#part-error").text("【必須】アタッチメントをご選択ください");
          return false;
        } else if (
          $('input[name="acy_paper_select"]:checked').val() == "あり" &&
          $('input[name="acy_paper"]:checked').val() == undefined
        ) {
          $("#paper-error").text("【必須】台紙をご選択ください");
          return false;
        } else {
          // console.log('no error');
          $("#error_pcs").text("");
          $("#error_print").text("");
          $("#part-error").text("");
          $("#paper-error").text("");
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
var candy_daishe_price = 0;

function setToInput() {
  clearValue();

  var ItemType = $("input[name=ItemType]").val();

  // Quality
  if ($("#pcs1").length) {
    var vpcs1 = document.getElementById("pcs1");
  }
  if ($("#pcs2").length) {
    var vpcs2 = document.getElementById("pcs2");
  }
  // ----------->
  var vno_of_order = document.getElementById("no_of_order");
  part = '';
  paperPrice = 0;

  // Get part price
  if ($('input[name="acy_part"]').length) {
    var part = $('input[name="acy_part"]:checked').val();
    if (part != undefined && typeof parts_obj !== "undefined" && parts_obj && parts_obj["part_price"] !== undefined) {
      partPrice = Math.floor(parseInt(parts_obj["part_price"]) * (1 + vat / 100));
      $("#sample-part-pic").show();
      $("#sample-part-pic").attr("src", parts_obj["part_pic"]);
      $("#sample-part-name").text("アタッチメント:" + parts_obj["part_name"]);
      $("#sample-prd-attachment").text(parts_obj["part_name"]);
    } else {
      partPrice = 0;
      if (part != undefined) {
        $("#sample-prd-attachment").text(part);
      }
    }
  }

  // Get paper data
  if ($('input[name="acy_paper_select"]:checked').val() == "あり" || $('input[name="paper_select"]:checked').val() == "あり") {
    $(".paper-container").show();
    var paper_color = $('input[name="acy_paper"]:checked').val() || $('input[name="paper"]:checked').val();

    if (paper_color != undefined && paper_color != "") {
      $("#sample-paper-pic").show();
      $("#sample-paper-pic").attr(
        "src",
        "/products/acrylic/img/" + paper_color + ".jpg"
      );
      $("#sample-paper-name").text(paper_color);
      $("#next").attr("disabled", false);
      $("#back").attr("disabled", false);
      $("#prd_paper").text(paper_color);
      $("#prd_CandyDaishe").text(paper_color);
      $("#paper-error").text("");
      if (paper_color == "paper-patternA-1") {
        var tmp_pp = paperPrice_obj["1side"];
      } else if (paper_color == "paper-patternA-2") {
        var tmp_pp = paperPrice_obj["2side"];
      } else {
        var tmp_pp = paperPrice_obj["tmp"];
      }
      for (var i = 0, iMax = tmp_pp.length; i < iMax; i++) {
        if (vno_of_order && parseInt(vno_of_order.value) >= parseInt(tmp_pp[i].num)) {
          paperPrice = Math.floor(tmp_pp[i].price * (1 + vat / 100));
          continue;
        }
        break;
      }
    } else {
      $("#sample-paper-pic").hide();
      $("#sample-paper-name").text("なし");
      $("#prd_paper").text("なし");
      $("#prd_CandyDaishe").text("なし");
      $("#paper-error").text("台紙を選択してください。");
      paperPrice = 0;
    }
  } else {
    $("#sample-paper-pic").hide();
    $("#sample-paper-name").text("なし");
    $(".paper-container").hide();
    $("#paper-error").text("");
    $("#next").attr("disabled", false);
    $("#back").attr("disabled", false);
    $("#prd_paper").text("なし");
    $("#prd_CandyDaishe").text("なし");
    $('input[name="acy_paper"]').prop("checked", false);
    $('input[name="paper"]').prop("checked", false);
    paperPrice = 0;
  }

  if (vno_of_order && vno_of_order.value != "") {
    var qtyNum = parseInt(vno_of_order.value, 10);
    if (qtyNum >= 5000)
        order_pcs = price_candy_sticker_standard[5];
    else if (qtyNum >= 2000)
        order_pcs = price_candy_sticker_standard[4];
    else if (qtyNum >= 1000)
        order_pcs = price_candy_sticker_standard[3];
    else if (qtyNum >= 500)
        order_pcs = price_candy_sticker_standard[2];
    else if (qtyNum >= 300)
        order_pcs = price_candy_sticker_standard[1];
    else if (qtyNum >= 100)
        order_pcs = price_candy_sticker_standard[0];

    special_shape_fee = 195000;


    // $("#sample-prd-screen").text($("input[name=silk_print]:checked").val());
    //   $("#prd_silk_print").text($("input[name=silk_print]:checked").val());


    $("#sample-prd-pcs").text(vno_of_order.value);
    $('#prd_ItemPCS').text(vno_of_order.value);

    if ($("input[name=SendPrototype]:checked").val() != undefined) {
      $("#prd_SendPrototype").text("あり");
      $("#sample-prd-samp").text("あり");
    } else {
      $("#prd_SendPrototype").text("なし");
      $("#sample-prd-samp").text("なし");
    }

    if ($("input[name=DeFormat]:checked").val() != undefined && $("input[name=DeFormat]:checked").val() == "あり") {
      $("#prd_DeFormat").text("あり");
      $("#sample-prd-3d-data-creation").text("あり");
      $("#sample-prd-trace").text("あり");
      trace_charge = 25000;
    } else {
      $("#prd_DeFormat").text("なし");
      $("#sample-prd-3d-data-creation").text("なし");
      $("#sample-prd-trace").text("なし");
      trace_charge = 0;
    }

    if ($("input[name=CandySticker_Daishe]:checked").val() != undefined) {
      $("#prd_CandyDaishe").text("あり");
      $("#sample-prd-candydaishe").text("あり");
    } else {
      $("#prd_CandyDaishe").text("なし");
      $("#sample-prd-candydaishe").text("なし");
    }


    if ($("input[name=SendPrototype]:checked").val() != undefined) {
        proto_charge = Math.floor(8000 * (1 + vat / 100));
    }

    if ($("#prd_ItemPCS").length) {
      $("#prd_ItemPCS").text($("input[name=ItemPCS]:checked").val());
    }

    $("#prd_qty").text(vno_of_order.value);
    if ($("#prd_part").length) {
      $("#prd_part").text(part || $('input[name="acy_part"]:checked').val() || "");
    }
    if ($("#sample-prd-attachment").length) {
      $("#sample-prd-attachment").text(part || $('input[name="acy_part"]:checked').val() || "-");
    }

    if ($("input[name=CandySticker_Daishe]:checked").val() !== undefined) {
        candy_daishe_price = Math.floor(33 * vno_of_order.value);
    } else {
        candy_daishe_price = 0;
    }

    // Assign Value
    TextField7Value = Math.floor(order_pcs) * vno_of_order.value;

    // Amount Before Tax
    TextField9Value =
      parseInt(TextField7Value) +
      proto_charge +
      trace_charge +
      print_charge +
      candy_daishe_price +
      coating_charge * vno_of_order.value +
      partPrice * vno_of_order.value +
      paperPrice * vno_of_order.value +
      MaterialCharge * vno_of_order.value +
      DesignsCharge +
      packing_price * vno_of_order.value +
      special_shape_fee;

    // discount setup by timer
    let timer = new Date().toISOString();

    let startDate = new Date("2024-01-24T00:00:00");
    let endDate = new Date("2024-02-16T23:59:00");

    if (timer > startDate.toISOString() && timer < endDate.toISOString()) {
      DisPrice = Math.floor(parseInt(TextField9Value * 0.05));
    }

    tax =
      Math.floor(
        Math.floor((TextField7Value * vat) / (100 + vat)) +
        Math.floor((proto_charge * vat) / (100 + vat)) +
        Math.floor((trace_charge * vat) / (100 + vat)) +
        Math.floor((print_charge * vat) / (100 + vat)) +
        Math.floor(candy_daishe_price) +
        Math.floor(
          (coating_charge * vno_of_order.value * vat) / (100 + vat),
        ) +
        Math.floor((packing_price * vno_of_order.value * vat) / (100 + vat)) +
        Math.floor((partPrice * vno_of_order.value * vat) / (100 + vat)) +
        Math.floor(
          (MaterialCharge * vno_of_order.value * vat) / (100 + vat),
        ) +
        Math.floor((DesignsCharge * vat) / (100 + vat)) +
        Math.floor((special_shape_fee * vat) / (100 + vat)) +
        Math.floor((paperPrice * vno_of_order.value * vat) / (100 + vat)),
      ) - Math.floor((DisPrice * vat) / (100 + vat));
    // tax = tax - Math.floor(tax*vat/100);
    total = parseInt(TextField9Value) - parseInt(DisPrice);

    // document.getElementById('textfield1').value = formatMoney(basic_charge);
    // document.getElementById('textfield2').value = formatMoney(mold_charge);
    if ($("#textfield2").length) {
      document.getElementById("textfield2").value =
        formatMoney(special_shape_fee);
    }
    document.getElementById("textfield7").value = formatMoney(TextField7Value);

    document.getElementById("textfield7_1").value = formatMoney(
      partPrice * vno_of_order.value,
    );
    // document.getElementById("textfield7_2").value = formatMoney(
    //   paperPrice * vno_of_order.value,
    // );

    document.getElementById("textfield_candy").value = formatMoney(
      paperPrice * vno_of_order.value,
    );

    document.getElementById("textfield3").value = formatMoney(proto_charge);
    if ($("#textfield4").length) {
      document.getElementById("textfield4").value = formatMoney(trace_charge);
    }
    document.getElementById("textfield_dis").value = formatMoney(DisPrice);
    document.getElementById("textfield13").value = formatMoney(print_charge);

    if ($("#textfield13_2").length) {
      document.getElementById("textfield13_2").value = formatMoney(
        coating_charge * vno_of_order.value,
      );
    }

    if ($("#textfield13_3").length) {
      document.getElementById("textfield13_3").value = formatMoney(
        packing_price * vno_of_order.value,
      );
    }

    if ($("#DesignsCharge").length) {
      document.getElementById("DesignsCharge").value =
        formatMoney(DesignsCharge);
    }
    if ($("#MaterialCharge").length) {
      document.getElementById("MaterialCharge").value = formatMoney(
        MaterialCharge * vno_of_order.value,
      );
    }

    // document.getElementById('textfield8').value = formatMoney(shipping_charge);
    document.getElementById("textfield9").value = formatMoney(
      parseInt(TextField9Value),
    );
    // document.getElementById('textfield10').value = formatMoney(tax);
    document.getElementById("textfield11").value = formatMoney(total);
    $(".prd_total").text(formatMoney(total));
    // document.getElementById('textfield12').value = formatMoney(printumu);
  }
}


function clearValue() {
  price_bracket = 0;
  proto_shipping_charge = 0;
  order_pcs = 0;
  unit_price = 0;
  strap_price = 0;
  before_tax = 0;
  tax = 0;
  total = 0;
  silkprint = 0;
  partPrice = 0;
  paperPrice = 0;
  TextField7Value = 0;
  TextField9Value = 0;
  DisPrice = 0;
  proto_charge = 0;
  coating_charge = 0;
  packing_price = 0;
  trace_charge = 0;
  print_charge = 0;
  special_shape_fee = 0;

  if ($("#textfield2").length) {
    document.getElementById("textfield2").value = "";
  }
  document.getElementById("textfield7").value = "";

  document.getElementById("textfield7_1").value = "";
//   document.getElementById("textfield7_2").value = "";

  document.getElementById("textfield3").value = "";
  if ($("#textfield4").length) {
    document.getElementById("textfield4").value = "";
  }
  document.getElementById("textfield13").value = "";

  if ($("#textfield13_2").length) {
    document.getElementById("textfield13_2").value = "";
  }

  if ($("#DesignsCharge").length) {
    document.getElementById("DesignsCharge").value = "";
  }
  if ($("#MaterialCharge").length) {
    document.getElementById("MaterialCharge").value = "";
  }

  if ($("#sample-prd-attachment").length) {
    $("#sample-prd-attachment").text("-");
  }

  // document.getElementById('textfield9').value = "";
  // document.getElementById('textfield10').value = "";
  document.getElementById("textfield11").value = "";
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
  if (number != "") {
    number = parseInt(number) + 0;
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

function getPartData(v) {
  if (!v) {
    parts_obj = undefined;
    partPrice = 0;
    $("#sample-part-pic").hide();
    $("#sample-part-name").text("アタッチメント:なし");
    $("#sample-prd-attachment").text("-");
    return;
  }

  $("#part-error").text("");
  parts_obj = undefined;
  $.get("part-3d-rubber.php", { c: "passed" }, function (data) {
    var duce = $.parseJSON(data);
    for (var i = 0; i < duce.length; i++) {
      if (duce[i]["part_name"] == v) {
        parts_obj = duce[i];
        break;
      }
    }
  }).done(function () {
    setToInput();
  });
}

$(document).ready(function () {
  var initPart = $('input[name="acy_part"]:checked').val();
  if (initPart) {
    getPartData(initPart);
  }
});
