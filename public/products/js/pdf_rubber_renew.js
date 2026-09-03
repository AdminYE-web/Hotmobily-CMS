var isSafari =
  navigator.vendor &&
  navigator.vendor.indexOf("Apple") > -1 &&
  navigator.userAgent &&
  navigator.userAgent.indexOf("CriOS") == -1 &&
  navigator.userAgent.indexOf("FxiOS") == -1;
function address_fn() {
  // alert($('#zip').val());
  var str = $("#zip").val();
  // var res = str.replace("-", "");
  if (str.length < 7) {
    $("#error").text("郵便番号を7桁で入力してください。");
  } else {
    $("#error").text("");
    $.ajax({
      url: "https://maps.googleapis.com/maps/api/geocode/json",
      dataType: "json",
      crossDomain: true,
      type: "get",
      data: {
        key: "AIzaSyDMDXPiN_mBRVSoneHiivkOAMdHkSg8ZFw",
        address: str,
        language: "ja",
        sensor: false,
      },
      success: function (data) {
        if (data.status == "OK") {
          // APIのレスポンスから住所情報を取得
          var obj = data.results[0].address_components;
          if (obj.length < 4) {
            $("#error").text(
              "自動変換できませんでした。都道府県、以降の住所をご入力下さい",
            );
            $("#address1").val("");
            $("#address2").val("");
            return false;
          } else {
            $("#address1").val(obj[2]["long_name"]);
            $("#address2").val(obj[1]["long_name"]);
            $("#error").text("");
          }
        } else if (data.status == "ZERO_RESULTS") {
          $("#error").text(
            "自動変換できませんでした。都道府県、以降の住所をご入力下さい",
          );
          $("#address1").val("");
          $("#address2").val("");
        }
        console.log(data);
      },
    });
  }
}
function address_fn2() {
  // alert($('#zip').val());
  var str = $("#zip2").val();
  // var res = str.replace("-", "");
  if (str.length < 7) {
    $("#error2").text("郵便番号を7桁で入力してください。");
  } else {
    $("#error2").text("");
    $.ajax({
      url: "https://maps.googleapis.com/maps/api/geocode/json",
      dataType: "json",
      crossDomain: true,
      type: "get",
      data: {
        key: "AIzaSyDMDXPiN_mBRVSoneHiivkOAMdHkSg8ZFw",
        address: str,
        language: "ja",
        sensor: false,
      },
      success: function (data) {
        if (data.status == "OK") {
          // APIのレスポンスから住所情報を取得
          var obj = data.results[0].address_components;
          if (obj.length < 4) {
            $("#error").text(
              "自動変換できませんでした。都道府県、以降の住所をご入力下さい",
            );
            $("#address1").val("");
            $("#address2").val("");
            return false;
          } else {
            $("#address1_2").val(obj[2]["long_name"]);
            $("#address2_2").val(obj[1]["long_name"]);
            $("#error2").text("");
          }
        } else if (data.status == "ZERO_RESULTS") {
          $("#error2").text(
            "自動変換できませんでした。都道府県、以降の住所をご入力下さい",
          );
          $("#address1_2").val("");
          $("#address2_2").val("");
        }
        console.log(data);
      },
    });
  }
}
function validate(tmp) {
  ytag({
    type: "yss_conversion",
    config: {
      yahoo_conversion_id: "1000179237",
      yahoo_conversion_label: "B-vUCIagnVkQr-mfxwM",
      yahoo_conversion_value: "0",
    },
  });

  gtag("event", "conversion", {
    send_to: "AW-1036353231/IGnMCK-CuAEQz_2V7gM",
  });

  if (tmp == "gcd") {
    var cus_name = $("#sname").val();
    var cus_lname = $("#fname").val();
    var crop_name = $("#Corp_Name").val();
    var zip = $("#zip").val();
    var address1 = $("#address1").val();
    var address2 = $("#address2").val();
    var address_street = $("#address_street").val();
    var tel = $("#tel").val();
    var comment = $("#comment").val();
  } else {
    var cus_name = "";
    var cus_lname = "";
    var crop_name = "";
    var zip = "";
    var address1 = "";
    var address2 = "";
    var address_street = "";
    var tel = "";
    var fax = "";
    var comment = "";
  }

  var n = new Date();
  var d = n.getDate();
  var m = n.getMonth();
  var y = n.getFullYear();
  var h = n.getHours();
  var min = n.getMinutes();
  var s = n.getSeconds();

  var qty = document.getElementById("no_of_order").value;

  var filename = "";
  m++;
  var date = y + "年" + m + "月" + d + "日";
  if (m < 10 || d < 10) {
    if (m < 10 && d < 10) {
      filename = "HM_QT_" + y + "0" + m + "0" + d + "_" + h + min + s;
    } else if (m < 10) {
      filename = "HM_QT_" + y + "0" + m + d + "_" + h + min + s;
    } else {
      filename = "HM_QT_" + y + m + "0" + d + "_" + h + min + s;
    }
  } else {
    filename = "HM_QT_" + y + m + d + "_" + h + min + s;
  }

  var itemtype2 = "";
  var item2 = "";
  var example = "";
  var ai_file = "";
  var back_print = "";
  var itemtype_print = "";
  var itemtype_print_qty = 0;
  var itemtype_print_price = 0;
  var itemtype_colors = "";
  var parts = "";
  var parts_price = 0;
  var paper = "なし";
  var paper_price = 0;
  var delivery = "";
  var coating = "";
  var coating_price = 0;
  var packing = "";
  var packing_qty = 0;
  var other = "";
  var other_price = "";
  var delivery_price = 0;

  var variation_price = 0;
  var material_price = 0;
  var example_price = 0,
    ai_file_price = 0,
    back_print_price = 0;

  //A
  var Item = $("input[name='ItemType']").val();

  if (Item == "スマホラバークリーナー") {
    delivery = "量産品製作期間：22営業日";
  }

  if (
    ($('input[name="part"]').length &&
      $('input[name="part"]:checked').val() != undefined) ||
    $('input[name="part"]').val() != "なし"
  ) {
    parts = $('input[name="part"]:checked').val();
    parts_price = partPrice;
  }

  if (
    $('input[name="paper_select"]').length &&
    $('input[name="paper_select"]:checked').val() != undefined
  ) {
    paper = $('input[name="paper"]:checked').val();
    paper_price = paperPrice;
  }

  if (!$("input[name=DeFormat]").is(":checked")) {
    ai_file = "なし";
  } else {
    ai_file = "あり";
  }

  if ($("#nashiprint").length) {
    if ($("#nashiprint").is(":checked")) {
      // back_print = "0"
    } else {
      back_print = "1";
    }
  }

  if ($("input[name=coating]").length) {
    coating = $("input[name=coating]:checked").val();
    coating_price = qty > 0 ? formatMoney(Math.floor(coating_charge / qty)) : 0;
    item2 = "汚れ防止加工";
    delivery =
      "量産品製作期間：100～300個まで13営業日、配送：2日、300～1,000個まで17営業日、配送：2日、3,000個まで25営業日、";
  }

  if ($("input[name=ItemDesignVariation]:checked").length) {
    if ($('input[name="ItemPCS"]').length) {
      if ($('input[name="ItemPCS"]:checked').val() == "スタンダード") {
        $("#ItemType2").text("スタンダード（12色以内）");
        itemtype2 = "スタンダード（12色以内）";
        delivery =
          "量産品製作期間：100～300個まで10営業日、配送：2日、300～1,000個まで14営業日、配送：2日、3,000個まで22営業日～、";
      } else if ($('input[name="ItemPCS"]:checked').val() == "プレミアム") {
        $("#ItemType2").text("プレミアム（18色以内）");
        itemtype2 = "プレミアム（18色以内）";
        parts_price = partPrice;
        delivery =
          "量産品製作期間：100～300個まで19営業日、配送：2日、300～1,000個まで21営業日、配送：2日、3,000個まで29営業日～、";
      } else if (
        $('input[name="ItemPCS"]:checked').val() ==
        "スタンダード（スピード7営業日発送）"
      ) {
        $("#ItemType2").text("スタンダード（スピード7営業日発送）（12色）");
        itemtype2 = "スタンダード（スピード7営業日発送）（12色）";
        delivery = "量産品製作期間：7営業日";
      }
    }
  } else if ($('input[name="ItemPCS"]').length) {
    if (document.getElementsByName("ItemPCS")[0].checked) {
      $("#ItemType2").text("スタンダード（12色以内）");
      itemtype2 = "スタンダード（12色以内）";
    } else if (document.getElementsByName("ItemPCS")[1].checked) {
      $("#ItemType2").text("プレミアム（15色以内）");
      itemtype2 = "プレミアム（15色以内）";
      parts_price = partPrice;
    }
  } else if (Item == "ラバーフォトフレーム（写真立て）") {
    $("#ItemType2").text("スタンダード（15色以内）");
    itemtype2 = "スタンダード（15色以内）";
  }

  if (Item == "印刷ラバーコースター") {
    itemtype2 = $('input[name="ItemPCS"]:checked').val();
  }

  if (!$("input[name=SendPrototype]").is(":checked")) {
    $("#example").text("不要");
    example = "不要";
  } else {
    $("#example").text("必要");
    example = "必要";
    delivery += "、試作品製作期間：6営業日";
  }

  var item_variation = "";
  var item_material = "";

  if ($("input[name=ItemDesignVariation]:checked").length) {
    back_print = $("input[name=silk_print]:checked").val();
    back_print_price = formatMoney(Math.floor(print_charge));

    item_variation = $("input[name=ItemDesignVariation]:checked").val();
    switch (item_variation) {
      case "1種類":
        variation_price = 0;
        break;
      case "2種類":
        variation_price = formatMoney(Math.floor(DesignsCharge));
        break;
      case "3種類":
        variation_price = formatMoney(Math.floor(DesignsCharge / 2));
        break;
      case "4種類":
        variation_price = formatMoney(Math.floor(DesignsCharge / 3));
        break;
    }

    item_material = $("input[name=ItemMaterial]:checked").val();
    material_price = formatMoney(Math.floor(MaterialCharge));
  }

  if (item_material === "" && $("input[name=ItemMaterial]:checked").length) {
    item_material = $("input[name=ItemMaterial]:checked").val();
    material_price = formatMoney(Math.floor(MaterialCharge));
  }

  if (Item == "印刷ラバーストラップ・ラバーキーホルダー") {
    other_price = "本体色:" + qty + ":" + print_charge / qty;
    other = "裏面印刷:" + $("input[name=silk_print]:checked").val();

    other += ",本体色:" + $("input[name=ItemColor]:checked").val();

    other += ",形状タイプ:" + $("input[name=ItemShape]:checked").val();

    other += ",印刷タイプ:" + $("input[name=ItemPrint]:checked").val();

    if ($("input[name=ItemShape]:checked").val() == "オリジナル（60*60）") {
      other_price += ",版型代金:" + 1 + ":" + special_shape_fee;
    }

    if ($("input[name=ItemShape]:checked").val() == "オリジナル") {
      other_price += ",版型代金:" + 1 + ":" + special_shape_fee;
    }

    back_print = "";
    back_print_price = 0;

    delivery =
      "量産品製作期間：100～300個まで10営業日、配送：2日、300～1,000個まで14営業日、配送：2日、3,000個まで22営業日～、";

    if ($('input[name="ItemPCS"]:checked').val() == "スタンダード") {
      $("#ItemType2").text("スタンダード");
      itemtype2 = "スタンダード";
    } else if (
      $('input[name="ItemPCS"]:checked').val() ==
      "スタンダード（スピード7営業日発送）"
    ) {
      $("#ItemType2").text("スタンダード（スピード7営業日発送）");
      itemtype2 = "スタンダード（スピード7営業日発送）";
    }
  }

  if (Item == "印刷ラバーコースター") {
    if ($("input[name=silk_print]:checked").val() == "印刷あり") {
      other_price = "裏面印刷代金:" + qty + ":" + print_charge / qty;

      if ($("input[name=ItemShape]:checked").val() == "オリジナル") {
        other_price += ",版型代金:" + 1 + ":" + special_shape_fee;
      }
    } else {
      if ($("input[name=ItemShape]:checked").val() == "オリジナル") {
        other_price += "版型代金:" + 1 + ":" + special_shape_fee;
      }
    }

    other = "形状タイプ:" + $("input[name=ItemShape]:checked").val();
    other += ",裏面印刷:" + $("input[name=silk_print]:checked").val();
    other += ",本体色:" + $("input[name=ItemColor]:checked").val();

    // if ($("input[name=silk_print]:checked").val() == "印刷あり") {
    //     other_price += ",裏面印刷代金:" + qty + ":" + (print_charge / qty);
    // }

    back_print = "";
    back_print_price = 0;

    // delivery = "量産品製作期間：100～300個まで10営業日、配送：2日、300～1,000個まで14営業日、配送：2日、3,000個まで22営業日～、";

    delivery =
      "量産品製作期間：1～300個まで10営業日、配送：2日、300～1,000個まで14営業日、配送：2日";

    if (TextField9Value < 11000) {
      delivery_price = 880;
    }

  }

  var itemtype_size = "";
  if ($("input[name=ItemSize]").length) {
    itemtype_size = $("input[name=ItemSize]:checked").val();
  }

  var str = TextField7Value;
  // str = str.replace(/,/g, "");
  var item_price = Math.floor(parseInt(str, 10) / qty);
  var discount_quo = formatMoney(Math.floor(DisPrice));
  var sum1_quo = formatMoney(TextField9Value);
  // var sum2_quo = $('#textfield9').val();
  // var sum3_quo = $('#textfield10').val();

  total = total + delivery_price;
  var sum2_quo = 0;
  var sum3_quo = tax;
  var sum4_quo = formatMoney(total);

  if (example == "必要") {
    example_price = formatMoney(Math.floor(proto_charge));
  }
  if (ai_file == "あり") {
    ai_file_price = formatMoney(Math.floor(trace_charge));
  }
  if (back_print == "1") {
    back_print_price = formatMoney(Math.floor(print_charge));
  }

  var packing_charge = 0;
  if ($("input[name=packing]").length) {
    packing = $("input[name=packing]:checked").val();
    packing_charge = packing_price;
    packing_qty = qty;
  }

  var remark = "";
  if ($("input[name=ItemDesignRepeat]:checked").val() == "はい") {
    remark = "過去と同じデザイン:" + $("input[name=design_no]").val();
  }

  $.ajax({
    type: "POST",
    url: "/tcpdf/save_est_renew.php",
    data: {
      //Customer data
      cus_name: cus_name,
      cus_lname: cus_lname,
      crop_name: crop_name,
      zip: zip,
      address1: address1,
      address2: address2,
      address_street: address_street,
      tel: tel,
      comment: comment,
      //Items data
      Item: Item,
      delivery: delivery,
      itemtype2: itemtype2,
      Item2: item2,
      Item2_print: coating,
      itemtype_size: itemtype_size,
      example: example,
      packing: packing,
      packing_qty: packing_qty,
      part: parts,
      paper: paper,
      ai_file: ai_file,
      back_print: back_print,
      item_variation: item_variation,
      item_material: item_material,
      qty: qty,
      itemtype_print: itemtype_print,
      itemtype_print_qty: itemtype_print_qty,
      itemtype_colors: itemtype_colors,
      other: other,
      //Price data
      item_price: item_price,
      sum1_quo: sum1_quo,
      sum2_quo: sum2_quo,
      sum3_quo: sum3_quo,
      sum4_quo: sum4_quo,
      discount: discount_quo,
      delivery_price: delivery_price,
      example_price: example_price,
      ai_file_price: ai_file_price,
      back_print_price: back_print_price,
      Item2_price: coating_price,
      Item2_print_price: 0,
      part_price: parts_price,
      paper_price: paper_price,
      packing_price: packing_charge,
      variation_price: variation_price,
      material_price: material_price,
      itemtype_print_price: itemtype_print_price,
      other_price: other_price,
      //Other
      filename: filename,
      date: date,
      remark: remark,
      save: "yes",
    },
    success: function (data) {
      if (data == "success") {
        if (isSafari) {
          location.href = "/tcpdf/examples/pdf_export_renew.php";
        } else {
          var win = window.open("/tcpdf/examples/pdf_export_renew.php", "_blank");
          win.focus();
          $(".loading").hide();
        }
      } else {
        alert(data);
      }
    },
  });
}
function formatMoney2(inum) {
  if (inum == "0" || inum == "") {
    return inum;
  }
  var s_inum = new String(inum);
  if (s_inum.indexOf("-") == -1) {
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
  } else {
    return s_inum;
  }
}
