// Legacy hardcoded item tiers removed.
// setToInput() now resolves unit prices from DB-fed pools (window.numUnitPrice / window.numUnitAddPrice).

var parts_obj;
var paperPrice = 0;
var unit_price = 0;

/**
 * getMinQty()
 * Returns the effective minimum order quantity for the current product.
 * It scans window.numUnitPrice (DB-fed price pool) to find the smallest
 * tier quantity (num) across all keys. If any tier is below 100 the price
 * engine can handle that quantity, so we allow it.
 * Falls back to 100 when the pool is unavailable or all tiers are >= 100.
 */
function getMinQty() {
    var DEFAULT_MIN = 100;
    if (
        typeof window.numUnitPrice === 'undefined' ||
        !window.numUnitPrice ||
        Object.keys(window.numUnitPrice).length === 0
    ) {
        return DEFAULT_MIN;
    }
    var globalMin = DEFAULT_MIN;
    Object.keys(window.numUnitPrice).forEach(function (key) {
        var tiers = window.numUnitPrice[key];
        if (!Array.isArray(tiers)) return;
        tiers.forEach(function (tier) {
            var n = parseInt(tier.num, 10);
            if (!isNaN(n) && n > 0 && n < globalMin) {
                globalMin = n;
            }
        });
    });
    return globalMin;
}
function getDbPriceVal(pool, keyOrMatch, qty) {
    if (typeof pool === 'undefined' || !pool) return null;

    if (pool === window.numUnitAddPrice && typeof window.$ !== 'undefined' && $("input[name=ItemType]").length) {
        var itype = $("input[name=ItemType]").val();
        var prefix = "";
        if (itype === "ラバーコースター") prefix = "rubbercoaster_";
        else if (itype === "ラバーキーホルダー") prefix = "rubberkeyholder_";
        else if (itype === "ラバーストラップ") prefix = "rubberstrap_";
        else if (itype === "印刷ラバーコースター") prefix = "printedrubbercoaster_";
        else if (itype === "印刷ラバーストラップ・ラバーキーホルダー") prefix = "printedrubberstrap_";

        if (prefix !== "") {
            var prefixKey = prefix + keyOrMatch;
            prefixKey = prefixKey.replace(prefix + "rubber_", prefix);
            prefixKey = prefixKey.replace(prefix + "anti_stain", prefix + "antistain");
            prefixKey = prefixKey.replace(prefix + "data_trace", prefix + "datatrace");
            prefixKey = prefixKey.replace(prefix + "color_variation", prefix + "colorvariation");
            prefixKey = prefixKey.replace(prefix + "back_printing_", prefix + "backprinting_");

            if (pool[prefixKey]) {
                let arr = pool[prefixKey].slice().sort((a, b) => b.num - a.num);
                for (let i = 0; i < arr.length; i++) {
                    if (qty >= arr[i].num) return parseFloat(arr[i].price);
                }
            }
        }
    }

    if (pool[keyOrMatch]) {
        let arr = pool[keyOrMatch].slice().sort((a, b) => b.num - a.num);
        for (let i = 0; i < arr.length; i++) {
            if (qty >= arr[i].num) return parseFloat(arr[i].price);
        }
    }
    let searchTerm = keyOrMatch.replace(/^rubber_/g, '').replace('data_trace', 'datatrace').replace('anti_stain', 'antistain');
    let targetKey = Object.keys(pool).find(k => k.includes(searchTerm));
    if (targetKey && pool[targetKey]) {
        let arr = pool[targetKey].slice().sort((a, b) => b.num - a.num);
        for (let i = 0; i < arr.length; i++) {
            if (qty >= arr[i].num) return parseFloat(arr[i].price);
        }
    }
    return null;
}
function getDbUnitByMode(itemType, mode, qty) {
    if (!mode) return null;
    // Determine width suffix from #big_size checkbox (5mm = '5', 3mm = '3')
    var widthSfx = ($("#big_size").length && $("#big_size").is(":checked")) ? "5" : "3";
    // Prefer product-specific DB keys to avoid accidental match from other products.
    if (itemType == "ラバーストラップ") {
        var exactKey;
        if (mode === "speed") {
            exactKey = "rubberstrap_standard_speed_" + widthSfx;
        } else if (mode === "premium") {
            exactKey = "rubberstrap_premium_" + widthSfx;
        } else {
            exactKey = "rubberstrap_standard_" + widthSfx;
        }
        var v = getDbPriceVal(window.numUnitPrice, exactKey, qty);
        if (v !== null) return v;
    }
    if (itemType == "ラバーキーホルダー") {
        var exactKey;
        if (mode === "speed") {
            exactKey = "rubberkeyholder_standard_speed_" + widthSfx;
        } else if (mode === "premium") {
            exactKey = "rubberkeyholder_premium_" + widthSfx;
        } else {
            exactKey = "rubberkeyholder_standard_" + widthSfx;
        }
        var v = getDbPriceVal(window.numUnitPrice, exactKey, qty);
        if (v !== null) return v;
    }
    // Printed rubber strap/keyholder: speed is a completely separate price tier (not standard + surcharge)
    if (itemType == "印刷ラバーストラップ・ラバーキーホルダー") {
        var exactKey = (mode === "speed") ? "printedrubberstrap_speed" : "printedrubberstrap_standard";
        var v = getDbPriceVal(window.numUnitPrice, exactKey, qty);
        if (v !== null) return v;
    }
    // Fallback to legacy generic key matching.
    return getDbPriceVal(window.numUnitPrice, mode, qty);
}

function valid_chk_btn(c) {
    if (check_val(c)) {
        $("#step1").fadeOut("fast");
        $("#step2").fadeOut("fast");
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
            case "アタッチメント・オプション入力へ":
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
                    $("#next").text("アタッチメント・オプション入力へ");
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
                        pk == "ペットボトルホルダー" ||
                        pk == "ラバーケーブルバンド")
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

function valid_chk_btn2(c) {
    if (check_val(c)) {
        $("#step1").fadeOut("fast");
        $("#step2").fadeOut("fast");
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

    if ($("input[name=ItemDesignVariation]").length) {
        switch ($("input[name=ItemDesignVariation]:checked").val()) {
            case "1種類":
                if (
                    (vNumberOfOder.val() == "" || vNumberOfOder.val() < 100) &&
                    ItemType != "ラバーコースター" &&
                    ItemType == "印刷ラバーストラップ・ラバーキーホルダー" &&
                    $("input[name=ItemShape]").length &&
                    $("input[name=ItemShape]:checked").val() == "オリジナル（60*60）"
                ) {
                    mess += "<font color='red'>本数は100本以上で入力して下さい。</font>";
                    err_number.innerHTML = mess;
                    return false;
                } else if (
                    (vNumberOfOder.val() == "" || vNumberOfOder.val() < 1) &&
                    $("input[name=ItemPCS]:checked").val() != "プレミアム"
                ) {
                    mess += "<font color='red'>本数は1本以上で入力して下さい。</font>";
                    err_number.innerHTML = mess;
                    return false;
                } else if (
                    (vNumberOfOder.val() == "" || vNumberOfOder.val() < 100) &&
                    ItemType == "ラバーコースター" &&
                    $("input[name=ItemPCS]:checked").val() == "プレミアム"
                ) {
                    mess += "<font color='red'>本数は100本以上で入力して下さい。</font>";
                    err_number.innerHTML = mess;
                    return false;
                } else {
                    $("#err_numberOf_mess").hide();
                }
                break;
            case "2種類":
                if (vNumberOfOder.val() == "" || vNumberOfOder.val() < 100) {
                    mess += "<font color='red'>本数は100本以上で入力して下さい。</font>";
                    err_number.innerHTML = mess;
                    return false;
                }
                break;
            case "3種類":
                if (vNumberOfOder.val() == "" || vNumberOfOder.val() < 150) {
                    mess += "<font color='red'>本数は150本以上で入力して下さい。</font>";
                    err_number.innerHTML = mess;
                    return false;
                }
                break;
            case "4種類":
                if (vNumberOfOder.val() == "" || vNumberOfOder.val() < 200) {
                    mess += "<font color='red'>本数は200本以上で入力して下さい。</font>";
                    err_number.innerHTML = mess;
                    return false;
                }
                break;
        }
    } else {
        if (
            (vNumberOfOder.val() == "" || vNumberOfOder.val() < 100) &&
            ItemType == "印刷ラバーストラップ・ラバーキーホルダー" &&
            $("input[name=ItemShape]").length &&
            $("input[name=ItemShape]:checked").val() == "オリジナル（60*60）"
        ) {
            mess += "<font color='red'>本数は100本以上で入力して下さい。</font>";
            err_number.innerHTML = mess;
            return false;
        } else if (
            (vNumberOfOder.val() == "" || vNumberOfOder.val() < 1) &&
            ItemType == "印刷ラバーストラップ・ラバーキーホルダー"
        ) {
            mess += "<font color='red'>本数は1本以上で入力して下さい。</font>";
            err_number.innerHTML = mess;
            return false;
        }
    }

    if (
        $("input[name=ItemPCS]:checked").val() ==
        "スタンダード（スピード7営業日発送）"
    ) {
        if (vNumberOfOder.val() == "" || vNumberOfOder.val() > 300) {
            mess += "<font color='red'>本数は300本以下で入力して下さい。</font>";
            err_number.innerHTML = mess;
            return false;
        }
    }

    if (ItemType == "印刷ラバーストラップ・ラバーキーホルダー") {
        if (vNumberOfOder.val() == "" || vNumberOfOder.val() > 1000) {
            mess += "<font color='red'>本数は1000本以下で入力して下さい。</font>";
            err_number.innerHTML = mess;
            return false;
        }
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
                $("#error_print").text("【必須】裏面シルク印刷の有無をご選択ください");
                return false;
            } else if (
                $("input[name=coating]").length &&
                $("input[name=coating]:checked").val() == undefined
            ) {
                $("#error_coating").text("【必須】汚れ防止加工の有無をご選択ください");
                return false;
            } else {
                $("#error_pcs").text("");
                $("#error_print").text("");
                if ($("input[name=coating]").length) {
                    $("#error_coating").text("");
                }
                setToInput();
                return true;
            }
        }
    } else {
        return true;
    }
}

// ============================================================
// Form submit guard: block submission if スタンダード（スピード7営業日発送）
// is selected and qty > 300. Covers the direct submit button
// that bypasses the step-by-step Next / check_val() flow.
// ============================================================
$(document).on("submit", "#form", function (e) {
    var pcsVal = $("input[name=ItemPCS]:checked").val();
    var qty = parseInt($("#no_of_order").val(), 10);
    var errEl = document.getElementById("err_numberOf_mess");

    // --- Max check: スタンダード（スピード7営業日発送） => max 300 ---
    if (pcsVal === "スタンダード（スピード7営業日発送）") {
        if (isNaN(qty) || qty > 300) {
            e.preventDefault();
            if (errEl) {
                errEl.style.display = "";
                errEl.innerHTML = "<font color='red'>本数は300本以下で入力して下さい。</font>";
            }
            $("#no_of_order")[0].scrollIntoView({ behavior: "smooth", block: "center" });
            return false;
        }
    }

    // --- Min check: dynamic minimum from DB price tiers ---
    var dynMin = getMinQty();
    if (isNaN(qty) || qty < dynMin) {
        e.preventDefault();
        if (errEl) {
            errEl.style.display = "";
            errEl.innerHTML = "<font color='red'>本数は" + dynMin + "本以上で入力して下さい。</font>";
        }
        $("#no_of_order")[0].scrollIntoView({ behavior: "smooth", block: "center" });
        return false;
    }
});

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
var ItemPCSFee = 0;
var ItemSizeFee = 0;

var special_shape_fee = 0;

function setHiddenField(name, value) {
    let $el = $("input[name='" + name + "']");
    if ($el.length === 0) {
        $("<input>")
            .attr({
                type: "hidden",
                name: name,
            })
            .appendTo("form#form");
        $el = $("input[name='" + name + "']");
    }
    $el.val(value);
}

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

    // --- 300-qty real-time limit for スタンダード（スピード7営業日発送） ---
    if (
        $("input[name=ItemPCS]:checked").val() === "スタンダード（スピード7営業日発送）" &&
        vno_of_order && vno_of_order.value !== "" &&
        parseInt(vno_of_order.value, 10) > 300
    ) {
        var _errEl = document.getElementById("err_numberOf_mess");
        if (_errEl) {
            _errEl.style.display = "";
            _errEl.innerHTML = "<font color='red'>本数は300本以下で入力して下さい。</font>";
        }
        return; // stop price recalculation
    }
    // --- end 300-limit real-time guard ---

    // --- Dynamic minimum real-time check ---
    if (vno_of_order && vno_of_order.value !== "") {
        var _dynMin = getMinQty();
        var _curQty = parseInt(vno_of_order.value, 10);
        if (!isNaN(_curQty) && _curQty < _dynMin) {
            var _errEl2 = document.getElementById("err_numberOf_mess");
            if (_errEl2) {
                _errEl2.style.display = "";
                _errEl2.innerHTML = "<font color='red'>本数は" + _dynMin + "本以上で入力して下さい。</font>";
            }
            return; // stop price recalculation
        } else {
            // Clear minimum error if now valid
            var _errEl2 = document.getElementById("err_numberOf_mess");
            if (_errEl2 && _errEl2.innerHTML.indexOf("以上") !== -1) {
                _errEl2.innerHTML = "";
                _errEl2.style.display = "none";
            }
        }
    }
    // --- end dynamic minimum real-time guard ---

    // Get part price
    if ($('input[name="part"]').length) {
        var part = $('input[name="part"]:checked').val();
        if (ItemType == "ラバーキーホルダー" && $("#big_size").is(":checked")) {
            $("input[name='part'][value='リング黒色']").parents(".flex-item").hide();
            if (part == "リング黒色") {
                $("input[name='part'][value='リング小（チェーン）']").prop(
                    "checked",
                    true,
                );
                part = "リング小（チェーン）";
                getPartData("リング小（チェーン）");
                const switchedPic = $("input[name='part']:checked").closest("label").find("img.picpro").attr("src");
                if (switchedPic) $("#sample-part-pic").attr("src", switchedPic);
                $("#sample-part-name").text(part);
            }
        } else {
            $("input[name='part'][value='リング黒色']").parents(".flex-item").show();
        }

        if (
            part != undefined &&
            ItemType != "ラバーコースター" &&
            ItemType != "ラバースマートフォンスタンド" &&
            ItemType != "ラバータグ" &&
            ItemType != "ペットボトルホルダー"
        ) {
            let directPartPrice = null;
            if (typeof getPartPriceFromGlobalArrays === "function") {
                const p = getPartPriceFromGlobalArrays(part);
                if (p !== null && p !== undefined && !isNaN(parseFloat(p))) {
                    directPartPrice = Math.floor(parseFloat(p));
                }
            }
            if (directPartPrice !== null) {
                partPrice = directPartPrice;
                $("#sample-part-pic").show();
                const selectedPic = $("input[name='part']:checked").closest("label").find("img.picpro").attr("src");
                if (selectedPic) $("#sample-part-pic").attr("src", selectedPic);
                $("#sample-part-name").text(part);
            } else if (typeof parts_obj !== "undefined" && parts_obj && parts_obj["part_name"] == part) {
                partPrice = Math.floor(parts_obj["part_price"]);
                $("#sample-part-pic").show();
                $("#sample-part-pic").attr("src", parts_obj["part_pic"]);
                $("#sample-part-name").text(parts_obj["part_name"]);
            } else {
                getPartData(part);
                partPrice = 0;
            }
        } else {
            part = "";
            partPrice = 0;
            $("#sample-part-pic").hide();
            $("#sample-part-name").text("");
        }
    }

    // Get paper data
    if ($('input[name="paper_select"]').length) {
        var paper = $('input[name="paper_select"]:checked').val();
        var paper_color = $('input[name="paper"]:checked').val();

        if (paper != undefined) {
            $(".paper-container").css("display", "flex");
            if (paper_color != undefined) {
                $("#sample-paper-pic").show();
                $("#sample-paper-pic").attr(
                    "src",
                    "/products/acrylic/img/" + paper_color + ".jpg",
                );
                $("#sample-paper-name").text(paper_color);
                $("#next").attr("disabled", false);
                $("#back").attr("disabled", false);
                $("#prd_paper").text(paper_color);
                $("#paper-error").text("");
                let dbPaperPrice = null;
                if (paper_color == "paper-patternA-1") {
                    dbPaperPrice = getDbPriceVal(window.numUnitAddPrice, 'mount_printing_single', parseInt(vno_of_order.value));
                    if (dbPaperPrice === null && typeof window.numUnitOptionPrice !== 'undefined') {
                        dbPaperPrice = getDbPriceVal(window.numUnitOptionPrice, 'Paper 1 Side', parseInt(vno_of_order.value));
                    }

                } else if (paper_color == "paper-patternA-2") {
                    dbPaperPrice = getDbPriceVal(window.numUnitAddPrice, 'mount_printing_both', parseInt(vno_of_order.value));
                    if (dbPaperPrice === null && typeof window.numUnitOptionPrice !== 'undefined') {
                        dbPaperPrice = getDbPriceVal(window.numUnitOptionPrice, 'Paper 2 Side', parseInt(vno_of_order.value));
                    }

                } else {
                    dbPaperPrice = getDbPriceVal(window.numUnitAddPrice, 'mount_plain', parseInt(vno_of_order.value));
                    if (dbPaperPrice === null && typeof window.numUnitOptionPrice !== 'undefined') {
                        dbPaperPrice = getDbPriceVal(window.numUnitOptionPrice, 'Paper Temp', parseInt(vno_of_order.value));
                    }

                }

                paperPrice = dbPaperPrice !== null ? dbPaperPrice : 0;
            } else {
                $("#paper-error").text("台紙を選択してください。");
                $("#next").attr("disabled", true);
                $("#back").attr("disabled", true);
            }
        } else {
            $("#sample-paper-pic").hide();
            $("#sample-paper-name").text("なし");
            $(".paper-container").css("display", "none");
            $("#paper-error").text("");
            $("#next").attr("disabled", false);
            $("#back").attr("disabled", false);
            $("#prd_paper").text("なし");
            $('input[name="acy_paper"]').prop("checked", false);
            $('input[name="paper"]').prop("checked", false);
            paperPrice = 0;
        }
    }

    if (vno_of_order.value != "") {
        var hasDbUnitPricePool =
            typeof window.numUnitPrice !== "undefined" &&
            window.numUnitPrice &&
            Object.keys(window.numUnitPrice).length > 0;
        // Legacy hardcoded tier ladder disabled (DB-only pricing).
        // strap
        if (
            false && !hasDbUnitPricePool &&
            (
                ItemType == "ラバーストラップ" ||
                ItemType == "ラバージビッツ" ||
                ItemType == "ラバーケーブルバンド"
            )
        ) {
            if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_strap_standard[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_strap_standard[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_strap_standard[4];
                else if (vno_of_order.value >= 500) order_pcs = price_strap_standard[3];
                else if (vno_of_order.value >= 300) order_pcs = price_strap_standard[2];
                else if (vno_of_order.value >= 200) order_pcs = price_strap_standard[1];
                else if (vno_of_order.value >= 100) order_pcs = price_strap_standard[0];
            }
            if ($("#pcs2").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_strap_premium[6];
                else if (vno_of_order.value >= 3000) order_pcs = price_strap_premium[5];
                else if (vno_of_order.value >= 1000) order_pcs = price_strap_premium[4];
                else if (vno_of_order.value >= 500) order_pcs = price_strap_premium[3];
                else if (vno_of_order.value >= 300) order_pcs = price_strap_premium[2];
                else if (vno_of_order.value >= 200) order_pcs = price_strap_premium[1];
                else if (vno_of_order.value >= 100) order_pcs = price_strap_premium[0];
            }
        }
        // keyholder
        else if (false && ItemType == "ラバーキーホルダー") {
            if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_keyholder_standard[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_keyholder_standard[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_keyholder_standard[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_keyholder_standard[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_keyholder_standard[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_keyholder_standard[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_keyholder_standard[0];
            }
            if ($("#pcs2").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_keyholder_premium[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_keyholder_premium[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_keyholder_premium[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_keyholder_premium[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_keyholder_premium[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_keyholder_premium[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_keyholder_premium[0];
            }
        }
        //earphoe
        else if (ItemType == "ラバーイヤホンホルダー") {
            if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_earphone_standard[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_earphone_standard[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_earphone_standard[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_earphone_standard[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_earphone_standard[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_earphone_standard[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_earphone_standard[0];
            }
            if ($("#pcs2").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_earphone_premium[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_earphone_premium[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_earphone_premium[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_earphone_premium[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_earphone_premium[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_earphone_premium[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_earphone_premium[0];
            }
        }
        //keykaba
        else if (ItemType == "ラバーキーカバー") {
            if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
                var dbKeykabaStd = getDbPriceVal(window.numUnitPrice, "rubberkeycover_standard", parseInt(vno_of_order.value));
                if (dbKeykabaStd !== null) order_pcs = dbKeykabaStd;
            }
            if ($("#pcs2").is(":checked")) {
                var dbKeykabaPrm = getDbPriceVal(window.numUnitPrice, "rubberkeycover_premium", parseInt(vno_of_order.value));
                if (dbKeykabaPrm !== null) order_pcs = dbKeykabaPrm;
            }
        }
        //cleaner_rubber
        else if (ItemType == "スマホラバークリーナー") {
            if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
                if (vno_of_order.value >= 5000)
                    order_pcs = price_cleaner_rubber_standard[7];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_cleaner_rubber_standard[6];
                else if (vno_of_order.value >= 2000)
                    order_pcs = price_cleaner_rubber_standard[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_cleaner_rubber_standard[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_cleaner_rubber_standard[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_cleaner_rubber_standard[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_cleaner_rubber_standard[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_cleaner_rubber_standard[0];
            }
            if ($("#pcs2").is(":checked")) {
                if (vno_of_order.value >= 5000)
                    order_pcs = price_cleaner_rubber_premium[7];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_cleaner_rubber_premium[6];
                else if (vno_of_order.value >= 2000)
                    order_pcs = price_cleaner_rubber_premium[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_cleaner_rubber_premium[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_cleaner_rubber_premium[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_cleaner_rubber_premium[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_cleaner_rubber_premium[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_cleaner_rubber_premium[0];
            }
        }
        //coaster
        else if (ItemType == "ラバーコースター") {
            if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
                var dbCoasterStd = getDbPriceVal(window.numUnitPrice, "rubbercoaster_standard", parseInt(vno_of_order.value));
                if (dbCoasterStd !== null) order_pcs = dbCoasterStd;
            }
            if ($("#pcs2").is(":checked")) {
                var dbCoasterPrm = getDbPriceVal(window.numUnitPrice, "rubbercoaster_premium", parseInt(vno_of_order.value));
                if (dbCoasterPrm !== null) order_pcs = dbCoasterPrm;
            }
        }
        //targetcup (ゴルフターゲットカップ)
        else if (ItemType.indexOf("ターゲットカップ") !== -1) {
            var qty = parseInt(vno_of_order.value);
            if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
                var dbTcStd = getDbPriceVal(window.numUnitPrice, "targetcup_standard", qty);
                if (dbTcStd !== null) order_pcs = dbTcStd;
            }
            if ($("#pcs2").is(":checked")) {
                var dbTcPrm = getDbPriceVal(window.numUnitPrice, "targetcup_premium", qty);
                if (dbTcPrm !== null) order_pcs = dbTcPrm;
            }
            // Speed delivery surcharge (pcs4)
            if ($("#pcs4").is(":checked")) {
                var dbSpeedDel = getDbPriceVal(window.numUnitAddPrice, "targetcup_standard_speeddelivery", qty);
                if (dbSpeedDel !== null) order_pcs += dbSpeedDel;
            }
        }
        //phone stand
        else if (ItemType == "ラバースマートフォンスタンド") {
            if (
                ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) &&
                $("input[name=ItemSize]:checked").val() == "小サイズ"
            ) {
                if (vno_of_order.value >= 5000)
                    order_pcs = price_phonestand_s_standard[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_phonestand_s_standard[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_phonestand_s_standard[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_phonestand_s_standard[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_phonestand_s_standard[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_phonestand_s_standard[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_phonestand_s_standard[0];
            }
            if (
                $("#pcs2").is(":checked") &&
                $("input[name=ItemSize]:checked").val() == "小サイズ"
            ) {
                if (vno_of_order.value >= 5000)
                    order_pcs = price_phonestand_s_premium[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_phonestand_s_premium[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_phonestand_s_premium[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_phonestand_s_premium[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_phonestand_s_premium[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_phonestand_s_premium[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_phonestand_s_premium[0];
            }
            if (
                ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) &&
                $("input[name=ItemSize]:checked").val() == "大サイズ"
            ) {
                if (vno_of_order.value >= 5000)
                    order_pcs = price_phonestand_l_standard[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_phonestand_l_standard[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_phonestand_l_standard[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_phonestand_l_standard[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_phonestand_l_standard[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_phonestand_l_standard[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_phonestand_l_standard[0];
            }
            if (
                $("#pcs2").is(":checked") &&
                $("input[name=ItemSize]:checked").val() == "大サイズ"
            ) {
                if (vno_of_order.value >= 5000)
                    order_pcs = price_phonestand_l_premium[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_phonestand_l_premium[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_phonestand_l_premium[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_phonestand_l_premium[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_phonestand_l_premium[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_phonestand_l_premium[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_phonestand_l_premium[0];
            }
        }
        // rubber tag
        else if (ItemType == "ラバータグ") {
            if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_tag_standard[6];
                else if (vno_of_order.value >= 3000) order_pcs = price_tag_standard[5];
                else if (vno_of_order.value >= 1000) order_pcs = price_tag_standard[4];
                else if (vno_of_order.value >= 500) order_pcs = price_tag_standard[3];
                else if (vno_of_order.value >= 300) order_pcs = price_tag_standard[2];
                else if (vno_of_order.value >= 200) order_pcs = price_tag_standard[1];
                else if (vno_of_order.value >= 100) order_pcs = price_tag_standard[0];
            }
            if ($("#pcs2").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_tag_premium[6];
                else if (vno_of_order.value >= 3000) order_pcs = price_tag_premium[5];
                else if (vno_of_order.value >= 1000) order_pcs = price_tag_premium[4];
                else if (vno_of_order.value >= 500) order_pcs = price_tag_premium[3];
                else if (vno_of_order.value >= 300) order_pcs = price_tag_premium[2];
                else if (vno_of_order.value >= 200) order_pcs = price_tag_premium[1];
                else if (vno_of_order.value >= 100) order_pcs = price_tag_premium[0];
            }
        }

        // rubber pbholder
        else if (ItemType == "ペットボトルホルダー") {
            if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_pbholder_standard[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_pbholder_standard[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_pbholder_standard[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_pbholder_standard[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_pbholder_standard[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_pbholder_standard[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_pbholder_standard[0];
            }
            if ($("#pcs2").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_pbholder_premium[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_pbholder_premium[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_pbholder_premium[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_pbholder_premium[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_pbholder_premium[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_pbholder_premium[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_pbholder_premium[0];
            }
        }

        // rubber photo frame
        else if (ItemType == "ラバーフォトフレーム（写真立て）") {
            if (vno_of_order.value >= 5000) order_pcs = price_rubber_frame[6];
            else if (vno_of_order.value >= 3000) order_pcs = price_rubber_frame[5];
            else if (vno_of_order.value >= 1000) order_pcs = price_rubber_frame[4];
            else if (vno_of_order.value >= 500) order_pcs = price_rubber_frame[3];
            else if (vno_of_order.value >= 300) order_pcs = price_rubber_frame[2];
            else if (vno_of_order.value >= 200) order_pcs = price_rubber_frame[1];
            else if (vno_of_order.value >= 30) order_pcs = price_rubber_frame[0];
        }

        // Printed rubber
        else if (ItemType == "印刷ラバーストラップ・ラバーキーホルダー") {
            if ($("#pcs1").is(":checked")) {
                if (vno_of_order.value >= 1000)
                    order_pcs = price_printed_rubber_standard[7];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_printed_rubber_standard[6];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_printed_rubber_standard[5];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_printed_rubber_standard[4];
                else if (vno_of_order.value >= 50)
                    order_pcs = price_printed_rubber_standard[3];
                else if (vno_of_order.value >= 30)
                    order_pcs = price_printed_rubber_standard[2];
                else if (vno_of_order.value >= 10)
                    order_pcs = price_printed_rubber_standard[1];
                else if (vno_of_order.value >= 1)
                    order_pcs = price_printed_rubber_standard[0];
            }
            if ($("#pcs4").is(":checked")) {
                if (vno_of_order.value >= 300) order_pcs = price_printed_rubber_rush[5];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_printed_rubber_rush[4];
                else if (vno_of_order.value >= 50)
                    order_pcs = price_printed_rubber_rush[3];
                else if (vno_of_order.value >= 30)
                    order_pcs = price_printed_rubber_rush[2];
                else if (vno_of_order.value >= 10)
                    order_pcs = price_printed_rubber_rush[1];
                else if (vno_of_order.value >= 1)
                    order_pcs = price_printed_rubber_rush[0];
            }

            // Speed delivery (pcs4) is incompatible with anti-stain coating (coating adds 3-5 business days)
            if ($("#pcs4").is(":checked")) {
                // Force coating to なし and disable the あり option
                $("#coating1").prop("disabled", true).prop("checked", false);
                $("#coating0").prop("checked", true);
                var $coatingNote = $("#coating_speed_note");
                if ($coatingNote.length === 0) {
                    $coatingNote = $("<span id='coating_speed_note' style='color:orange;font-size:12px;display:block;margin-top:4px;'>※スピード便では汚れ防止加工を選択できません</span>");
                    $("#error_coating").after($coatingNote);
                }
                $coatingNote.show();
            } else {
                $("#coating1").prop("disabled", false);
                $("#coating_speed_note").hide();
            }

            if ($("input[name=ItemShape]:checked").val() == "オリジナル（60*60）") {
                let dbMold = getDbPriceVal(window.numUnitAddPrice, 'printedrubberstrap_original_shape_plate_fee', 1);
                special_shape_fee = dbMold !== null ? dbMold : 8500;
                $("input[name=SendPrototype]").prop("disabled", true);
            } else {
                special_shape_fee = 0;
                $("input[name=SendPrototype]").prop("disabled", false);
            }

            var silkPrintVal = $("input[name=silk_print]:checked").val();
            let qtyNumForPrint1 = parseInt(vno_of_order.value);
            if (silkPrintVal == "単色（シルク）印刷") {
                let dbPrint = getDbPriceVal(window.numUnitAddPrice, 'back_printing_single', 1);
                print_charge = dbPrint !== null ? dbPrint * qtyNumForPrint1 : 30 * qtyNumForPrint1;
            } else if (silkPrintVal == "フルカラー印刷") {
                let dbPrint = getDbPriceVal(window.numUnitAddPrice, 'back_printing_full', 1);
                print_charge = dbPrint !== null ? dbPrint * qtyNumForPrint1 : 50 * qtyNumForPrint1;
            } else if (silkPrintVal == "裏面印刷あり" || silkPrintVal == "印刷あり") {
                let dbPrint = getDbPriceVal(window.numUnitAddPrice, 'back_printing_full', 1);
                print_charge = dbPrint !== null ? dbPrint * qtyNumForPrint1 : 50 * qtyNumForPrint1;
            } else {
                print_charge = 0;
            }

            if ($("#sample-prd-shape").length) {
                if (
                    $("input[name=ItemShape]").length &&
                    $("input[name=ItemShape]:checked").val() != undefined
                ) {
                    $("#sample-prd-shape").text($("input[name=ItemShape]:checked").val());
                    $("#prd_ItemShape").text($("input[name=ItemShape]:checked").val());
                }
            }
            if ($("#sample-prd-print").length) {
                if (
                    $("input[name=ItemPrint]").length &&
                    $("input[name=ItemPrint]:checked").val() != undefined
                ) {
                    $("#sample-prd-print").text($("input[name=ItemPrint]:checked").val());
                    $("#prd_ItemPrint").text($("input[name=ItemPrint]:checked").val());
                }
            }
            if ($("#sample-prd-color").length) {
                if (
                    $("input[name=ItemColor]").length &&
                    $("input[name=ItemColor]:checked").val() != undefined
                ) {
                    $("#sample-prd-color").text($("input[name=ItemColor]:checked").val());
                    $("#prd_ItemColor").text($("input[name=ItemColor]:checked").val());
                }
            }
        }
        if (
            $("input[name=ItemPCS]").length &&
            $("input[name=ItemPCS]:checked").val() != undefined
        ) {
            $("#sample-prd-pcs").text($("input[name=ItemPCS]:checked").val());
        }

        if (
            ItemType == "ラバーストラップ" ||
            ItemType == "ラバーキーホルダー" ||
            ItemType == "ラバーイヤホンホルダー" ||
            ItemType == "ラバージビッツ" ||
            ItemType == "ラバーケーブルバンド"
        ) {
            if ($("#pcs4").is(":checked")) {
                if (vno_of_order.value >= 300) order_pcs += 30;
                else if (vno_of_order.value >= 200) order_pcs += 44;
                else if (vno_of_order.value >= 100) order_pcs += 57;
            }
        } else if (ItemType == "ラバーコースター") {
            if ($("#pcs4").is(":checked")) {
                if (vno_of_order.value >= 300) order_pcs += 36;
                else if (vno_of_order.value >= 200) order_pcs += 49;
                else if (vno_of_order.value >= 100) order_pcs += 62;
                else if (vno_of_order.value >= 80) order_pcs += 74;
                else if (vno_of_order.value > 10) order_pcs += 87;
            }
        } else {
            if (
                $("#pcs4").is(":checked") &&
                ItemType != "印刷ラバーストラップ・ラバーキーホルダー"
            ) {
                order_pcs += 110;
            }
        }

        // For rubber size
        if (
            $("input[name=ItemSize]").length &&
            $("input[name=ItemSize]:checked").val() != undefined
        ) {
            $("#sample-prd-size").text($("input[name=ItemSize]:checked").val());
            $("#prd_ItemSize").text($("input[name=ItemSize]:checked").val());
            // Note: Product Master is already separated by size, no size multiplier needed on order_pcs
        }
        // For rubber cleaner back side color
        if (
            $("input[name=back_side_color]").length &&
            $("input[name=back_side_color]:checked").val() != undefined
        ) {
            $("#sample-prd-cloth").text(
                $("input[name=back_side_color]:checked").val(),
            );
            $("#prd_cloth").text($("input[name=back_side_color]:checked").val());
        }
        // For All rubber product can silk print back side
        if (
            $("input[name=silk_print]").length &&
            ItemType != "ラバータグ" &&
            ItemType != "ペットボトルホルダー" &&
            $("input[name=silk_print]:checked").val() != undefined
        ) {
            $("#sample-prd-screen").text($("input[name=silk_print]:checked").val());
            $("#prd_silk_print").text($("input[name=silk_print]:checked").val());
        }

        // For rubber coating
        if (
            $("input[name=coating]").length &&
            $("input[name=coating]:checked").val() != undefined
        ) {
            $("#sample-prd-coating").text($("input[name=coating]:checked").val());
            $("#prd_coating").text($("input[name=coating]:checked").val());
            if ($("input[name=coating]:checked").val() == "汚れ防止加工なし") {
                coating_charge = 0;
            } else {
                coating_charge = Math.floor(70);
            }
        }

        if ($("input[name=packing]").length) {
            if (
                $("input[name=packing]:checked").val() != undefined &&
                $("input[name=packing]:checked").val() != ""
            ) {
                $("#part-error").text("");
                $("#next").attr("disabled", false);
                $("#back").attr("disabled", false);

                $("#sample-part-pic").show();
                if ($("input[name=packing]:checked").val() == "白色無地") {
                    $("#sample-part-pic").attr(
                        "src",
                        "/products/images/frame-packing1.jpg",
                    );
                    packing_price = Math.floor(30);
                } else {
                    $("#sample-part-pic").attr(
                        "src",
                        "/products/images/frame-packing2.jpg?v=1.01",
                    );
                    packing_price = 0;
                }
                $("#sample-part-name").text($("input[name=packing]:checked").val());
            } else {
                $("#part-error").text("梱包形態をご選択ください");
                $("#next").attr("disabled", true);
                $("#back").attr("disabled", true);
            }
        }

        $("#sample-prd-qty").text(vno_of_order.value);

        if ($("#ariprint").length) {
            this.print_umu = document.getElementById("ariprint");
        }

        if ($("#fcprint").length) {
            this.print_fc = document.getElementById("fcprint");
        }

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
            $("#prd_ItemDesign").text(
                $("input[name=ItemDesignVariation]:checked").val(),
            );
        }

        if ($("input[name=ItemMaterial]:checked").val() != undefined) {
            $("#prd_ItemMaterial").text($("input[name=ItemMaterial]:checked").val());

            // For ラバーコースター: shape_type (形状タイプ) and shape_processing (フチ加工)
            if ($("input[name=shape_type]").length && $("input[name=shape_type]:checked").val() != undefined) {
                $("#prd_shape_custom").text($("input[name=shape_type]:checked").val());
                $("#sample-shape").text($("input[name=shape_type]:checked").val());
            }
            if ($("input[name=shape_processing]").length && $("input[name=shape_processing]:checked").val() != undefined) {
                $("#prd_shape_border").text($("input[name=shape_processing]:checked").val());
                $("#sample-shape-border").text($("input[name=shape_processing]:checked").val());
            }
        }

        if ($("#pcs1").length) {
            if (
                ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) &&
                ItemType != "印刷ラバーストラップ・ラバーキーホルダー"
            ) {
                click_typeorder_enabled();
            } else if (
                ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) &&
                ItemType == "印刷ラバーストラップ・ラバーキーホルダー"
            ) {
                // Do nothing specific for this product type
            } else if (
                $("input[name=ItemPCS]:checked").val() == "ホットモバイリーファン"
            ) {
                type_special_disabled("t1");
                $("#prd_DeFormat").text("あり");
                $("#sample-prd-trace").text("あり");
                order_pcs = 900;
            } else {
                click_typeorder_disabled();
            }
        }

        if (
            $("input[name=ItemMaterial]:checked").length &&
            $("input[name=ItemMaterial]:checked").val().indexOf("特殊素材：") !== -1
        ) {
            let orderQty = parseInt(vno_of_order.value) || 1;
            var matStr = $("input[name=ItemMaterial]:checked").val();
            var materialKey = '';
            switch (matStr) {
                case '特殊素材：蓄光（オレンジ色）': materialKey = 'phosphorescent_orange'; break;
                case '特殊素材：蓄光（緑色）': materialKey = 'phosphorescent_green'; break;
                case '特殊素材：蛍光': materialKey = 'fluorescent'; break;
                case '特殊素材：ラメ': materialKey = 'glitter'; break;
                case '特殊素材：金色': materialKey = 'gold'; break;
                case '特殊素材：銀色': materialKey = 'silver'; break;
            }
            let dbMat = null;
            // This product's named material pools contain legacy/overridden rows
            // (including prototype-fee values). The canonical material service
            // rate is the safe source for printed rubber strap/keyholder.
            if (ItemType === "印刷ラバーストラップ・ラバーキーホルダー") {
                dbMat = getDbPriceVal(window.numUnitAddPrice, 'item_material_fee', orderQty);
                if (dbMat === null && materialKey !== '') {
                    dbMat = getDbPriceVal(window.numUnitAddPrice, materialKey, orderQty);
                }
            } else if (materialKey !== '') {
                dbMat = getDbPriceVal(window.numUnitAddPrice, materialKey, orderQty);
            }
            if (dbMat === null) dbMat = getDbPriceVal(window.numUnitAddPrice, 'rubber_special_material', orderQty);
            if (dbMat === null) dbMat = getDbPriceVal(window.numUnitAddPrice, 'special_material', orderQty);
            MaterialCharge = (dbMat !== null) ? dbMat : Math.floor(30);
        } else {
            MaterialCharge = 0;
        }

        if ($("input[name=ItemDesignVariation]:checked").length) {
            switch ($("input[name=ItemDesignVariation]:checked").val()) {
                case "2種類":
                    {
                        let dbD2 = getDbPriceVal(window.numUnitAddPrice, 'color_variation', 2);
                        DesignsCharge = dbD2 !== null ? dbD2 : Math.floor(3000);
                    }
                    break;
                case "3種類":
                    {
                        let dbD3 = getDbPriceVal(window.numUnitAddPrice, 'color_variation', 3);
                        DesignsCharge = dbD3 !== null ? dbD3 : Math.floor(6000);
                    }
                    break;
                case "4種類":
                    {
                        let dbD4 = getDbPriceVal(window.numUnitAddPrice, 'color_variation', 4);
                        DesignsCharge = dbD4 !== null ? dbD4 : Math.floor(9000);
                    }
                    break;
                default:
                    DesignsCharge = 0;
                    break;
            }
        }

        if ($("#prd_ItemPCS").length) {
            $("#prd_ItemPCS").text($("input[name=ItemPCS]:checked").val());
        }

        $("#prd_qty").text(vno_of_order.value);
        if ($("#prd_part").length) {
            $("#prd_part").text(part);
        }

        let qtyNum = parseInt(vno_of_order.value) || 0;
        let mode = "";
        let base_order_pcs = 0;
        let selected_order_pcs = 0;
        let speed_fee_unit = 0;
        if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
            mode = "standard";
        } else if ($("#pcs2").is(":checked")) {
            mode = "premium";
        }

        // For 印刷ラバーストラップ・ラバーキーホルダー, pcs4 (speed) uses a dedicated speed price tier
        // — it is NOT standard + speed surcharge. Override mode to 'speed' so the correct DB key is used.
        if (ItemType == "印刷ラバーストラップ・ラバーキーホルダー" && $("#pcs4").is(":checked")) {
            mode = "speed";
        }
        // For rubber strap/keyholder, pcs4 also uses a dedicated speed product price
        if ((ItemType == "ラバーストラップ" || ItemType == "ラバーキーホルダー") && $("#pcs4").is(":checked")) {
            mode = "speed";
        }

        if (mode !== "") {
            let dbBase = getDbUnitByMode(ItemType, "standard", qtyNum);
            let dbSelected = getDbUnitByMode(ItemType, mode, qtyNum);
            if (dbSelected !== null) selected_order_pcs = dbSelected;
            else selected_order_pcs = order_pcs;
            if (dbBase !== null) base_order_pcs = dbBase;
            else base_order_pcs = selected_order_pcs;
            if ($("#pcs4").is(":checked") && ItemType == "ラバーコースター") {
                // Rubber coaster speed is still an additional service fee
                let dbSpeed = getDbPriceVal(window.numUnitAddPrice, "speed_shipping_rubbercoaster", qtyNum);
                if (dbSpeed !== null) speed_fee_unit = dbSpeed;
            }
            // Note: rubber strap/keyholder speed is now priced as the product itself (speed product code).
            // No additional speed_fee_unit needed for those product types.
        } else {
            base_order_pcs = order_pcs;
            selected_order_pcs = order_pcs;
        }
        let pcs_diff_unit = Math.max(0, selected_order_pcs - base_order_pcs);
        // Rubber strap & Keyholder: premium and speed modes must use that price as the full base price
        // (not standard base + ItemPCSFee diff).
        if ((ItemType == "ラバーストラップ" || ItemType == "ラバーキーホルダー") && (mode === "premium" || mode === "speed")) {
            pcs_diff_unit = 0;
            base_order_pcs = selected_order_pcs;
        }
        // Printed rubber strap speed: the speed price IS the full product price (not standard + surcharge).
        if (ItemType == "印刷ラバーストラップ・ラバーキーホルダー" && mode === "speed") {
            pcs_diff_unit = 0;
            base_order_pcs = selected_order_pcs;
        }
        ItemPCSFee = (pcs_diff_unit + speed_fee_unit) * qtyNum;
        order_pcs = base_order_pcs;

        // Product Master is already separated by size in DB, size fee is included in base unit price
        ItemSizeFee = 0;

        let dbProto = getDbPriceVal(window.numUnitAddPrice, 'rubber_prototype', 1);
        if ($("input[name=SendPrototype]:checked").length && $("input[name=SendPrototype]:checked").val() !== "なし" && $("input[name=SendPrototype]:checked").val() !== "試作品なし") {
            proto_charge = (dbProto !== null && dbProto > 0) ? dbProto : 6000;
        }

        let dbTrace = getDbPriceVal(window.numUnitAddPrice, 'rubber_data_trace', 1);
        if ($("input[name=DeFormat]:checked").length && $("input[name=DeFormat]:checked").val() !== "なし" && $("input[name=DeFormat]:checked").val() !== "データトレースなし") {
            trace_charge = (dbTrace !== null && dbTrace > 0) ? dbTrace : 2000;
        }

        if ($("input[name=coating]:checked").val() != undefined && $("input[name=coating]:checked").val() != "汚れ防止加工なし") {
            let dbCoating = getDbPriceVal(window.numUnitAddPrice, 'anti_stain', 1);
            coating_charge = dbCoating !== null ? dbCoating : 70;
        }

        let printUmuEl = document.getElementById("ariprint");
        if (printUmuEl && printUmuEl.checked) {
            let dbPrint = getDbPriceVal(window.numUnitAddPrice, 'back_printing_single', 1);
            if (dbPrint !== null) print_charge = qtyNum * dbPrint;
            else print_charge = 30 * qtyNum; // fallback ¥33 (tax incl)
        }
        let printFcEl = document.getElementById("fcprint");
        if (printFcEl && printFcEl.checked) {
            let dbPrint = getDbPriceVal(window.numUnitAddPrice, 'back_printing_full', 1);
            if (dbPrint !== null) print_charge = qtyNum * dbPrint;
            else print_charge = 50 * qtyNum;
        }

        if (mode === "premium") {
            proto_charge = 0;
            trace_charge = 0;
            print_charge = 0;
        }

        if ($("input[name=packing]").length && $("input[name=packing]:checked").val() == "白色無地") {
            if (typeof window.packaging_fee !== 'undefined' && Object.keys(window.packaging_fee).length > 0) {
                let pk = Object.keys(window.packaging_fee)[0];
                let dbPack = getDbPriceVal(window.packaging_fee, pk, 1);
                if (dbPack !== null) packing_price = dbPack;
            }
        }

        if (document.getElementById("unit_price")) {
            document.getElementById("unit_price").value = order_pcs;
        }
        setHiddenField("ItemPCSFee", ItemPCSFee);
        setHiddenField("ItemSizeFee", ItemSizeFee);
        setHiddenField("ItemMaterialFee", MaterialCharge * qtyNum);
        setHiddenField("PartPrice", partPrice * qtyNum);

        // Assign Value
        if (
            $("input[name=ItemType]").val() ==
            "印刷ラバーストラップ・ラバーキーホルダー"
        ) {
            TextField7Value =
                Math.round(order_pcs) * vno_of_order.value;
        } else {
            TextField7Value =
                Math.floor(order_pcs) * vno_of_order.value;
        }
        if (ItemType == "ラバーコースター") {
            if (vno_of_order.value <= 10) {
                if (!$("#pcs4").is(":checked")) {
                    TextField7Value = Math.floor(18000);
                } else {
                    TextField7Value = Math.floor(21000);
                }
            } else {
                TextField7Value =
                    Math.floor(order_pcs) * vno_of_order.value;
            }
        }
        // Amount Before Tax
        TextField9Value =
            parseInt(TextField7Value) +
            ItemPCSFee +
            ItemSizeFee +
            proto_charge +
            trace_charge +
            print_charge +
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
                Math.floor((ItemPCSFee * vat) / (100 + vat)) +
                Math.floor((ItemSizeFee * vat) / (100 + vat)) +
                Math.floor((proto_charge * vat) / (100 + vat)) +
                Math.floor((trace_charge * vat) / (100 + vat)) +
                Math.floor((print_charge * vat) / (100 + vat)) +
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
        if ($("#textfield7").length) {
            document.getElementById("textfield7").value = formatMoney(TextField7Value);
        }

        if ($("#textfield7_1").length) {
            document.getElementById("textfield7_1").value = formatMoney(
                partPrice * vno_of_order.value,
            );
        }
        if ($("#textfield7_2").length) {
            document.getElementById("textfield7_2").value = formatMoney(
                paperPrice * vno_of_order.value,
            );
        }

        if ($("#textfield3").length) {
            document.getElementById("textfield3").value = formatMoney(proto_charge);
        }
        if ($("#textfield4").length) {
            document.getElementById("textfield4").value = formatMoney(trace_charge);
        }
        if ($("#textfield_dis").length) {
            document.getElementById("textfield_dis").value = formatMoney(DisPrice);
        }
        if ($("#textfield13").length) {
            document.getElementById("textfield13").value = formatMoney(print_charge);
        }

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
        if ($("#textfield9").length) {
            document.getElementById("textfield9").value = formatMoney(
                parseInt(TextField9Value),
            );
        }
        if ($("#display_ItemPCSFee").length) {
            document.getElementById("display_ItemPCSFee").value = formatMoney(ItemPCSFee);
        }
        if ($("#display_ItemSizeFee").length) {
            document.getElementById("display_ItemSizeFee").value = formatMoney(ItemSizeFee);
        }
        if ($("#textfield13_3").length) {
            document.getElementById("textfield13_3").value = formatMoney(packing_price * vno_of_order.value);
        }
        // document.getElementById('textfield10').value = formatMoney(tax);
        if ($("#textfield11").length) {
            document.getElementById("textfield11").value = formatMoney(total);
        }
        setHiddenField("pricefield11", parseInt(TextField9Value));
        setHiddenField("pricefield13", total);
        setHiddenField("ItemPCSFee", ItemPCSFee);
        setHiddenField("ItemSizeFee", ItemSizeFee);
        $(".prd_total").text(formatMoney(total));
        // document.getElementById('textfield12').value = formatMoney(printumu);
    }
}

function setToInputManual() {
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
    var prd = $("#strap").val();

    // Get part price
    if ($('input[name="part"]').length) {
        var part = $('input[name="part"]:checked').val();
        if (ItemType == "ラバーキーホルダー" && $("#big_size").is(":checked")) {
            $("input[name='part'][value='リング黒色']").parents(".flex-item").hide();
            if (part == "リング黒色") {
                $("input[name='part'][value='リング小（チェーン）']").prop(
                    "checked",
                    true,
                );
                part = "リング小（チェーン）";
                getPartData("リング小（チェーン）");
                const switchedPic = $("input[name='part']:checked").closest("label").find("img.picpro").attr("src");
                if (switchedPic) $("#sample-part-pic").attr("src", switchedPic);
                $("#sample-part-name").text(part);
            }
        } else {
            $("input[name='part'][value='リング黒色']").parents(".flex-item").show();
        }

        if (
            part != undefined &&
            ItemType != "ラバーコースター" &&
            ItemType != "ラバースマートフォンスタンド" &&
            ItemType != "ラバータグ" &&
            ItemType != "ペットボトルホルダー"
        ) {
            let directPartPrice = null;
            if (typeof getPartPriceFromGlobalArrays === "function") {
                const p = getPartPriceFromGlobalArrays(part);
                if (p !== null && p !== undefined && !isNaN(parseFloat(p))) {
                    directPartPrice = Math.floor(parseFloat(p));
                }
            }
            if (directPartPrice !== null) {
                partPrice = directPartPrice;
                $("#sample-part-pic").show();
                const selectedPic = $("input[name='part']:checked").closest("label").find("img.picpro").attr("src");
                if (selectedPic) $("#sample-part-pic").attr("src", selectedPic);
                $("#sample-part-name").text(part);
            } else if (typeof parts_obj !== "undefined" && parts_obj && parts_obj["part_name"] == part) {
                partPrice = Math.floor(parts_obj["part_price"]);
                $("#sample-part-pic").show();
                $("#sample-part-pic").attr("src", parts_obj["part_pic"]);
                $("#sample-part-name").text(parts_obj["part_name"]);
            } else {
                getPartData(part);
                partPrice = 0;
            }
        } else {
            part = "";
            partPrice = 0;
            $("#sample-part-pic").hide();
            $("#sample-part-name").text("");
        }
    }

    // Get paper data
    if ($('input[name="paper_select"]').length) {
        var paper = $('input[name="paper_select"]:checked').val();
        var paper_color = $('input[name="paper"]:checked').val();

        if (paper != undefined) {
            $(".paper-container").show();
            if (paper_color != undefined) {
                $("#sample-paper-pic").show();
                $("#sample-paper-pic").attr(
                    "src",
                    "/products/acrylic/img/" + paper_color + ".jpg",
                );
                $("#sample-paper-name").text(paper_color);
                $("#next").attr("disabled", false);
                $("#back").attr("disabled", false);
                $("#prd_paper").text(paper_color);
                $("#paper-error").text("");
                let dbPaperPrice = null;
                if (paper_color == "paper-patternA-1") {
                    dbPaperPrice = getDbPriceVal(window.numUnitAddPrice, 'mount_printing_single', parseInt(vno_of_order.value));
                    if (dbPaperPrice === null && typeof window.numUnitOptionPrice !== 'undefined') {
                        dbPaperPrice = getDbPriceVal(window.numUnitOptionPrice, 'Paper 1 Side', parseInt(vno_of_order.value));
                    }

                } else if (paper_color == "paper-patternA-2") {
                    dbPaperPrice = getDbPriceVal(window.numUnitAddPrice, 'mount_printing_both', parseInt(vno_of_order.value));
                    if (dbPaperPrice === null && typeof window.numUnitOptionPrice !== 'undefined') {
                        dbPaperPrice = getDbPriceVal(window.numUnitOptionPrice, 'Paper 2 Side', parseInt(vno_of_order.value));
                    }

                } else {
                    dbPaperPrice = getDbPriceVal(window.numUnitAddPrice, 'mount_plain', parseInt(vno_of_order.value));
                    if (dbPaperPrice === null && typeof window.numUnitOptionPrice !== 'undefined') {
                        dbPaperPrice = getDbPriceVal(window.numUnitOptionPrice, 'Paper Temp', parseInt(vno_of_order.value));
                    }

                }

                paperPrice = dbPaperPrice !== null ? dbPaperPrice : 0;
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
            $('input[name="acy_paper"]').prop("checked", false);
            $('input[name="paper"]').prop("checked", false);
            paperPrice = 0;
        }
    }

    if (vno_of_order.value != "") {
        var hasDbUnitPricePool =
            typeof window.numUnitPrice !== "undefined" &&
            window.numUnitPrice &&
            Object.keys(window.numUnitPrice).length > 0;
        // Legacy hardcoded tier ladder disabled (DB-only pricing).
        if (
            false && !hasDbUnitPricePool &&
            (
                ItemType == "ラバーストラップ" ||
                ItemType == "ラバージビッツ" ||
                ItemType == "ラバーケーブルバンド"
            )
        ) {
            if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_strap_standard[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_strap_standard[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_strap_standard[4];
                else if (vno_of_order.value >= 500) order_pcs = price_strap_standard[3];
                else if (vno_of_order.value >= 300) order_pcs = price_strap_standard[2];
                else if (vno_of_order.value >= 200) order_pcs = price_strap_standard[1];
                else if (vno_of_order.value >= 100) order_pcs = price_strap_standard[0];
            }
            if ($("#pcs2").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_strap_premium[6];
                else if (vno_of_order.value >= 3000) order_pcs = price_strap_premium[5];
                else if (vno_of_order.value >= 1000) order_pcs = price_strap_premium[4];
                else if (vno_of_order.value >= 500) order_pcs = price_strap_premium[3];
                else if (vno_of_order.value >= 300) order_pcs = price_strap_premium[2];
                else if (vno_of_order.value >= 200) order_pcs = price_strap_premium[1];
                else if (vno_of_order.value >= 100) order_pcs = price_strap_premium[0];
            }
        }
        // keyholder
        else if (false && ItemType == "ラバーキーホルダー") {
            if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_keyholder_standard[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_keyholder_standard[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_keyholder_standard[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_keyholder_standard[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_keyholder_standard[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_keyholder_standard[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_keyholder_standard[0];
            }
            if ($("#pcs2").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_keyholder_premium[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_keyholder_premium[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_keyholder_premium[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_keyholder_premium[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_keyholder_premium[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_keyholder_premium[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_keyholder_premium[0];
            }
        }
        //earphoe
        else if (ItemType == "ラバーイヤホンホルダー") {
            if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_earphone_standard[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_earphone_standard[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_earphone_standard[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_earphone_standard[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_earphone_standard[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_earphone_standard[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_earphone_standard[0];
            }
            if ($("#pcs2").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_earphone_premium[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_earphone_premium[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_earphone_premium[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_earphone_premium[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_earphone_premium[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_earphone_premium[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_earphone_premium[0];
            }
        }
        //keykaba
        else if (ItemType == "ラバーキーカバー") {
            if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
                var dbKeykabaStd = getDbPriceVal(window.numUnitPrice, "rubberkeycover_standard", parseInt(vno_of_order.value));
                if (dbKeykabaStd !== null) order_pcs = dbKeykabaStd;
            }
            if ($("#pcs2").is(":checked")) {
                var dbKeykabaPrm = getDbPriceVal(window.numUnitPrice, "rubberkeycover_premium", parseInt(vno_of_order.value));
                if (dbKeykabaPrm !== null) order_pcs = dbKeykabaPrm;
            }
        }
        //cleaner_rubber
        else if (ItemType == "スマホラバークリーナー") {
            if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
                if (vno_of_order.value >= 5000)
                    order_pcs = price_cleaner_rubber_standard[7];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_cleaner_rubber_standard[6];
                else if (vno_of_order.value >= 2000)
                    order_pcs = price_cleaner_rubber_standard[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_cleaner_rubber_standard[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_cleaner_rubber_standard[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_cleaner_rubber_standard[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_cleaner_rubber_standard[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_cleaner_rubber_standard[0];
            }
            if ($("#pcs2").is(":checked")) {
                if (vno_of_order.value >= 5000)
                    order_pcs = price_cleaner_rubber_premium[7];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_cleaner_rubber_premium[6];
                else if (vno_of_order.value >= 2000)
                    order_pcs = price_cleaner_rubber_premium[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_cleaner_rubber_premium[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_cleaner_rubber_premium[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_cleaner_rubber_premium[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_cleaner_rubber_premium[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_cleaner_rubber_premium[0];
            }
        }
        //coaster
        else if (ItemType == "ラバーコースター") {
            if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_coaster_standard[14];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_coaster_standard[13];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_coaster_standard[12];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_coaster_standard[11];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_coaster_standard[10];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_coaster_standard[9];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_coaster_standard[8];
                else if (vno_of_order.value >= 90)
                    order_pcs = price_coaster_standard[7];
                else if (vno_of_order.value >= 80)
                    order_pcs = price_coaster_standard[6];
                else if (vno_of_order.value >= 70)
                    order_pcs = price_coaster_standard[5];
                else if (vno_of_order.value >= 60)
                    order_pcs = price_coaster_standard[4];
                else if (vno_of_order.value >= 50)
                    order_pcs = price_coaster_standard[3];
                else if (vno_of_order.value >= 40)
                    order_pcs = price_coaster_standard[2];
                else if (vno_of_order.value >= 30)
                    order_pcs = price_coaster_standard[1];
                else if (vno_of_order.value > 10) order_pcs = price_coaster_standard[0];
            }
            if ($("#pcs2").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_coaster_premium[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_coaster_premium[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_coaster_premium[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_coaster_premium[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_coaster_premium[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_coaster_premium[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_coaster_premium[0];
            }
        }
        //phone stand
        else if (ItemType == "ラバースマートフォンスタンド") {
            if (
                ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) &&
                $("input[name=ItemSize]:checked").val() == "小サイズ"
            ) {
                if (vno_of_order.value >= 5000)
                    order_pcs = price_phonestand_s_standard[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_phonestand_s_standard[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_phonestand_s_standard[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_phonestand_s_standard[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_phonestand_s_standard[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_phonestand_s_standard[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_phonestand_s_standard[0];
            }
            if (
                $("#pcs2").is(":checked") &&
                $("input[name=ItemSize]:checked").val() == "小サイズ"
            ) {
                if (vno_of_order.value >= 5000)
                    order_pcs = price_phonestand_s_premium[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_phonestand_s_premium[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_phonestand_s_premium[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_phonestand_s_premium[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_phonestand_s_premium[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_phonestand_s_premium[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_phonestand_s_premium[0];
            }
            if (
                ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) &&
                $("input[name=ItemSize]:checked").val() == "大サイズ"
            ) {
                if (vno_of_order.value >= 5000)
                    order_pcs = price_phonestand_l_standard[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_phonestand_l_standard[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_phonestand_l_standard[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_phonestand_l_standard[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_phonestand_l_standard[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_phonestand_l_standard[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_phonestand_l_standard[0];
            }
            if (
                $("#pcs2").is(":checked") &&
                $("input[name=ItemSize]:checked").val() == "大サイズ"
            ) {
                if (vno_of_order.value >= 5000)
                    order_pcs = price_phonestand_l_premium[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_phonestand_l_premium[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_phonestand_l_premium[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_phonestand_l_premium[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_phonestand_l_premium[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_phonestand_l_premium[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_phonestand_l_premium[0];
            }
        }
        // rubber tag
        else if (ItemType == "ラバータグ") {
            if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_tag_standard[6];
                else if (vno_of_order.value >= 3000) order_pcs = price_tag_standard[5];
                else if (vno_of_order.value >= 1000) order_pcs = price_tag_standard[4];
                else if (vno_of_order.value >= 500) order_pcs = price_tag_standard[3];
                else if (vno_of_order.value >= 300) order_pcs = price_tag_standard[2];
                else if (vno_of_order.value >= 200) order_pcs = price_tag_standard[1];
                else if (vno_of_order.value >= 100) order_pcs = price_tag_standard[0];
            }
            if ($("#pcs2").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_tag_premium[6];
                else if (vno_of_order.value >= 3000) order_pcs = price_tag_premium[5];
                else if (vno_of_order.value >= 1000) order_pcs = price_tag_premium[4];
                else if (vno_of_order.value >= 500) order_pcs = price_tag_premium[3];
                else if (vno_of_order.value >= 300) order_pcs = price_tag_premium[2];
                else if (vno_of_order.value >= 200) order_pcs = price_tag_premium[1];
                else if (vno_of_order.value >= 100) order_pcs = price_tag_premium[0];
            }
        }

        // rubber pbholder
        else if (ItemType == "ペットボトルホルダー") {
            if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_pbholder_standard[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_pbholder_standard[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_pbholder_standard[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_pbholder_standard[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_pbholder_standard[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_pbholder_standard[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_pbholder_standard[0];
            }
            if ($("#pcs2").is(":checked")) {
                if (vno_of_order.value >= 5000) order_pcs = price_pbholder_premium[6];
                else if (vno_of_order.value >= 3000)
                    order_pcs = price_pbholder_premium[5];
                else if (vno_of_order.value >= 1000)
                    order_pcs = price_pbholder_premium[4];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_pbholder_premium[3];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_pbholder_premium[2];
                else if (vno_of_order.value >= 200)
                    order_pcs = price_pbholder_premium[1];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_pbholder_premium[0];
            }
        }

        // rubber photo frame
        else if (ItemType == "ラバーフォトフレーム（写真立て）") {
            if (vno_of_order.value >= 5000) order_pcs = price_rubber_frame[6];
            else if (vno_of_order.value >= 3000) order_pcs = price_rubber_frame[5];
            else if (vno_of_order.value >= 1000) order_pcs = price_rubber_frame[4];
            else if (vno_of_order.value >= 500) order_pcs = price_rubber_frame[3];
            else if (vno_of_order.value >= 300) order_pcs = price_rubber_frame[2];
            else if (vno_of_order.value >= 200) order_pcs = price_rubber_frame[1];
            else if (vno_of_order.value >= 30) order_pcs = price_rubber_frame[0];
        }

        // Printed rubber
        else if (ItemType == "印刷ラバーストラップ・ラバーキーホルダー") {
            if ($("#pcs1").is(":checked")) {
                if (vno_of_order.value >= 1000)
                    order_pcs = price_printed_rubber_standard[7];
                else if (vno_of_order.value >= 500)
                    order_pcs = price_printed_rubber_standard[6];
                else if (vno_of_order.value >= 300)
                    order_pcs = price_printed_rubber_standard[5];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_printed_rubber_standard[4];
                else if (vno_of_order.value >= 50)
                    order_pcs = price_printed_rubber_standard[3];
                else if (vno_of_order.value >= 30)
                    order_pcs = price_printed_rubber_standard[2];
                else if (vno_of_order.value >= 10)
                    order_pcs = price_printed_rubber_standard[1];
                else if (vno_of_order.value >= 1)
                    order_pcs = price_printed_rubber_standard[0];
            }
            if ($("#pcs4").is(":checked")) {
                if (vno_of_order.value >= 300) order_pcs = price_printed_rubber_rush[5];
                else if (vno_of_order.value >= 100)
                    order_pcs = price_printed_rubber_rush[4];
                else if (vno_of_order.value >= 50)
                    order_pcs = price_printed_rubber_rush[3];
                else if (vno_of_order.value >= 30)
                    order_pcs = price_printed_rubber_rush[2];
                else if (vno_of_order.value >= 10)
                    order_pcs = price_printed_rubber_rush[1];
                else if (vno_of_order.value >= 1)
                    order_pcs = price_printed_rubber_rush[0];
            }

            if ($("input[name=ItemShape]:checked").val() == "オリジナル（60*60）") {
                let dbMold = getDbPriceVal(window.numUnitAddPrice, 'printedrubberstrap_original_shape_plate_fee', 1);
                special_shape_fee = dbMold !== null ? dbMold : 8500;
                $("input[name=SendPrototype]").prop("checked", false);
                $("input[name=SendPrototype]").prop("disabled", true);
            } else {
                special_shape_fee = 0;
                $("input[name=SendPrototype]").prop("disabled", false);
            }

            var silkPrintVal = $("input[name=silk_print]:checked").val();
            let qtyNumForPrint2 = parseInt(vno_of_order.value);
            if (silkPrintVal == "単色（シルク）印刷") {
                let dbPrint = getDbPriceVal(window.numUnitAddPrice, 'back_printing_single', 1);
                print_charge = dbPrint !== null ? dbPrint * qtyNumForPrint2 : 30 * qtyNumForPrint2;
            } else if (silkPrintVal == "フルカラー印刷") {
                let dbPrint = getDbPriceVal(window.numUnitAddPrice, 'back_printing_full', 1);
                print_charge = dbPrint !== null ? dbPrint * qtyNumForPrint2 : 50 * qtyNumForPrint2;
            } else if (silkPrintVal == "裏面印刷あり" || silkPrintVal == "印刷あり") {
                let dbPrint = getDbPriceVal(window.numUnitAddPrice, 'back_printing_full', 1);
                print_charge = dbPrint !== null ? dbPrint * qtyNumForPrint2 : 50 * qtyNumForPrint2;
            } else {
                print_charge = 0;
            }
        }
        if (
            $("input[name=ItemPCS]").length &&
            $("input[name=ItemPCS]:checked").val() != undefined
        ) {
            $("#sample-prd-pcs").text($("input[name=ItemPCS]:checked").val());
        }

        if (
            ItemType == "ラバーストラップ" ||
            ItemType == "ラバーキーホルダー" ||
            ItemType == "ラバーイヤホンホルダー" ||
            ItemType == "ラバージビッツ" ||
            ItemType == "ラバーケーブルバンド"
        ) {
            if ($("#pcs4").is(":checked")) {
                if (vno_of_order.value >= 300) order_pcs += 30;
                else if (vno_of_order.value >= 200) order_pcs += 44;
                else if (vno_of_order.value >= 100) order_pcs += 57;
            }
        } else if (ItemType == "ラバーコースター") {
            if ($("#pcs4").is(":checked")) {
                if (vno_of_order.value >= 300) order_pcs += 36;
                else if (vno_of_order.value >= 200) order_pcs += 49;
                else if (vno_of_order.value >= 100) order_pcs += 62;
                else if (vno_of_order.value >= 80) order_pcs += 74;
                else if (vno_of_order.value > 10) order_pcs += 87;
            }
        } else {
            if ($("#pcs4").is(":checked")) {
                order_pcs += 110;
            }
        }

        // For rubber size
        if (
            $("input[name=ItemSize]").length &&
            $("input[name=ItemSize]:checked").val() != undefined
        ) {
            $("#sample-prd-size").text($("input[name=ItemSize]:checked").val());
            $("#prd_ItemSize").text($("input[name=ItemSize]:checked").val());
            // Note: Product Master is already separated by size, no size multiplier needed on order_pcs
        }
        // For rubber cleaner back side color
        if (
            $("input[name=back_side_color]").length &&
            $("input[name=back_side_color]:checked").val() != undefined
        ) {
            $("#sample-prd-cloth").text(
                $("input[name=back_side_color]:checked").val(),
            );
            $("#prd_cloth").text($("input[name=back_side_color]:checked").val());
        }
        // For All rubber product can silk print back side
        if (
            $("input[name=silk_print]").length &&
            ItemType != "ラバータグ" &&
            ItemType != "ペットボトルホルダー" &&
            $("input[name=silk_print]:checked").val() != undefined
        ) {
            $("#sample-prd-screen").text($("input[name=silk_print]:checked").val());
            $("#prd_silk_print").text($("input[name=silk_print]:checked").val());
        }

        // For rubber coating
        if (
            $("input[name=coating]").length &&
            $("input[name=coating]:checked").val() != undefined
        ) {
            $("#sample-prd-coating").text($("input[name=coating]:checked").val());
            $("#prd_coating").text($("input[name=coating]:checked").val());
            if ($("input[name=coating]:checked").val() == "汚れ防止加工なし") {
                coating_charge = 0;
            } else {
                coating_charge = Math.floor(70);
            }
        }

        if ($("input[name=packing]").length) {
            if (
                $("input[name=packing]:checked").val() != undefined &&
                $("input[name=packing]:checked").val() != ""
            ) {
                $("#part-error").text("");
                $("#next").attr("disabled", false);
                $("#back").attr("disabled", false);

                $("#sample-part-pic").show();
                if ($("input[name=packing]:checked").val() == "白色無地") {
                    $("#sample-part-pic").attr(
                        "src",
                        "/products/images/frame-packing1.jpg",
                    );
                    packing_price = Math.floor(30);
                } else {
                    $("#sample-part-pic").attr(
                        "src",
                        "/products/images/frame-packing2.jpg?v=1.01",
                    );
                    packing_price = 0;
                }
                $("#sample-part-name").text($("input[name=packing]:checked").val());
            } else {
                $("#part-error").text("梱包形態をご選択ください");
                $("#next").attr("disabled", true);
                $("#back").attr("disabled", true);
            }
        }

        $("#sample-prd-qty").text(vno_of_order.value);

        if ($("#ariprint").length) {
            this.print_umu = document.getElementById("ariprint");
        }

        if ($("#fcprint").length) {
            this.print_fc = document.getElementById("fcprint");
        }

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
            $("#prd_ItemDesign").text(
                $("input[name=ItemDesignVariation]:checked").val(),
            );
        }

        if ($("input[name=ItemMaterial]:checked").val() != undefined) {
            $("#prd_ItemMaterial").text($("input[name=ItemMaterial]:checked").val());
        }

        if ($("#pcs1").length) {
            if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
                click_typeorder_enabled();
            } else if (
                $("input[name=ItemPCS]:checked").val() == "ホットモバイリーファン"
            ) {
                type_special_disabled("t1");
                $("#prd_DeFormat").text("あり");
                $("#sample-prd-trace").text("あり");
                order_pcs = 900;
            } else {
                click_typeorder_disabled();
            }
        }

        if (
            $("input[name=ItemMaterial]:checked").length &&
            $("input[name=ItemMaterial]:checked").val().indexOf("特殊素材：") !== -1
        ) {
            let orderQty = parseInt(vno_of_order.value) || 1;
            var matStr = $("input[name=ItemMaterial]:checked").val();
            var materialKey = '';
            switch (matStr) {
                case '特殊素材：蓄光（オレンジ色）': materialKey = 'phosphorescent_orange'; break;
                case '特殊素材：蓄光（緑色）': materialKey = 'phosphorescent_green'; break;
                case '特殊素材：蛍光': materialKey = 'fluorescent'; break;
                case '特殊素材：ラメ': materialKey = 'glitter'; break;
                case '特殊素材：金色': materialKey = 'gold'; break;
                case '特殊素材：銀色': materialKey = 'silver'; break;
            }
            let dbMat = null;
            // Keep the admin/manual calculation identical to setToInput().
            if (ItemType === "印刷ラバーストラップ・ラバーキーホルダー") {
                dbMat = getDbPriceVal(window.numUnitAddPrice, 'item_material_fee', orderQty);
                if (dbMat === null && materialKey !== '') {
                    dbMat = getDbPriceVal(window.numUnitAddPrice, materialKey, orderQty);
                }
            } else if (materialKey !== '') {
                dbMat = getDbPriceVal(window.numUnitAddPrice, materialKey, orderQty);
            }
            if (dbMat === null) dbMat = getDbPriceVal(window.numUnitAddPrice, 'rubber_special_material', orderQty);
            if (dbMat === null) dbMat = getDbPriceVal(window.numUnitAddPrice, 'special_material', orderQty);
            MaterialCharge = (dbMat !== null) ? dbMat : Math.floor(30);
        } else {
            MaterialCharge = 0;
        }

        if ($("input[name=ItemDesignVariation]:checked").length) {
            switch ($("input[name=ItemDesignVariation]:checked").val()) {
                case "2種類":
                    {
                        let dbD2 = getDbPriceVal(window.numUnitAddPrice, 'color_variation', 2);
                        DesignsCharge = dbD2 !== null ? dbD2 : Math.floor(3000);
                    }
                    break;
                case "3種類":
                    {
                        let dbD3 = getDbPriceVal(window.numUnitAddPrice, 'color_variation', 3);
                        DesignsCharge = dbD3 !== null ? dbD3 : Math.floor(6000);
                    }
                    break;
                case "4種類":
                    {
                        let dbD4 = getDbPriceVal(window.numUnitAddPrice, 'color_variation', 4);
                        DesignsCharge = dbD4 !== null ? dbD4 : Math.floor(9000);
                    }
                    break;
                default:
                    DesignsCharge = 0;
                    break;
            }
        }

        if ($("#prd_ItemPCS").length) {
            $("#prd_ItemPCS").text($("input[name=ItemPCS]:checked").val());
        }

        $("#prd_qty").text(vno_of_order.value);
        if ($("#prd_part").length) {
            $("#prd_part").text(part);
        }



































        let qtyNum = parseInt(vno_of_order.value) || 0;
        let mode = "";
        let base_order_pcs = 0;
        let selected_order_pcs = 0;
        let speed_fee_unit = 0;
        if ($("#pcs1").is(":checked") || $("#pcs4").is(":checked")) {
            mode = "standard";
        } else if ($("#pcs2").is(":checked")) {
            mode = "premium";
        }

        if (mode !== "") {
            let dbBase = getDbUnitByMode(ItemType, "standard", qtyNum);
            let dbSelected = getDbUnitByMode(ItemType, mode, qtyNum);
            if (dbSelected !== null) selected_order_pcs = dbSelected;
            else selected_order_pcs = order_pcs;
            if (dbBase !== null) base_order_pcs = dbBase;
            else base_order_pcs = selected_order_pcs;
            if ($("#pcs4").is(":checked")) {
                let speedKey = (ItemType == "ラバーコースター") ? "speed_shipping_rubbercoaster" : "speed_shipping_rubber3mm";
                let dbSpeed = getDbPriceVal(window.numUnitAddPrice, speedKey, qtyNum);
                if (dbSpeed !== null) speed_fee_unit = dbSpeed;
            }
        } else {
            base_order_pcs = order_pcs;
            selected_order_pcs = order_pcs;
        }
        let pcs_diff_unit = Math.max(0, selected_order_pcs - base_order_pcs);
        // Rubber strap & Keyholder: premium must use premium as base price (not standard base + ItemPCSFee).
        if ((ItemType == "ラバーストラップ" || ItemType == "ラバーキーホルダー") && mode === "premium") {
            pcs_diff_unit = 0;
            base_order_pcs = selected_order_pcs;
        }
        ItemPCSFee = (pcs_diff_unit + speed_fee_unit) * qtyNum;
        order_pcs = base_order_pcs;

        // Product Master is already separated by size in DB, size fee is included in base unit price
        ItemSizeFee = 0;

        let isPremiumMode = ($("#pcs2").length && $("#pcs2").is(":checked"));

        if (isPremiumMode) {
            proto_charge = 0;
            trace_charge = 0;
        } else {
            let dbProto = getDbPriceVal(window.numUnitAddPrice, 'rubber_prototype', 1);
            if ($("input[name=SendPrototype]:checked").length && $("input[name=SendPrototype]:checked").val() !== "なし" && $("input[name=SendPrototype]:checked").val() !== "試作品なし") {
                proto_charge = (dbProto !== null && dbProto > 0) ? dbProto : 6000;
            }

            let dbTrace = getDbPriceVal(window.numUnitAddPrice, 'rubber_data_trace', 1);
            if ($("input[name=DeFormat]:checked").length && $("input[name=DeFormat]:checked").val() !== "なし" && $("input[name=DeFormat]:checked").val() !== "データトレースなし") {
                trace_charge = (dbTrace !== null && dbTrace > 0) ? dbTrace : 2000;
            }
        }

        if ($("input[name=coating]:checked").val() != undefined && $("input[name=coating]:checked").val() != "汚れ防止加工なし") {
            let dbCoating = getDbPriceVal(window.numUnitAddPrice, 'anti_stain', 1);
            coating_charge = dbCoating !== null ? dbCoating : 70;
        }

        if (isPremiumMode) {
            print_charge = 0;
        } else {
            let printUmuEl = document.getElementById("ariprint");
            if (printUmuEl && printUmuEl.checked) {
                let dbPrint = getDbPriceVal(window.numUnitAddPrice, 'back_printing_single', 1);
                print_charge = dbPrint !== null ? qtyNum * dbPrint : 30 * qtyNum;
            }
            let printFcEl = document.getElementById("fcprint");
            if (printFcEl && printFcEl.checked) {
                let dbPrint = getDbPriceVal(window.numUnitAddPrice, 'back_printing_full', 1);
                print_charge = dbPrint !== null ? qtyNum * dbPrint : 50 * qtyNum;
            }
        }

        if ($("input[name=packing]").length && $("input[name=packing]:checked").val() == "白色無地") {
            if (typeof window.packaging_fee !== 'undefined' && Object.keys(window.packaging_fee).length > 0) {
                let pk = Object.keys(window.packaging_fee)[0];
                let dbPack = getDbPriceVal(window.packaging_fee, pk, 1);
                if (dbPack !== null) packing_price = dbPack;
            }
        }

        if (document.getElementById("unit_price")) {
            document.getElementById("unit_price").value = order_pcs;
        }
        setHiddenField("ItemPCSFee", ItemPCSFee);
        setHiddenField("ItemSizeFee", ItemSizeFee);
        setHiddenField("ItemMaterialFee", MaterialCharge * qtyNum);
        setHiddenField("PartPrice", partPrice * qtyNum);

        // Assign Value
        if (
            $("input[name=ItemType]").val() ==
            "印刷ラバーストラップ・ラバーキーホルダー"
        ) {
            TextField7Value =
                Math.round(order_pcs) * vno_of_order.value;
        } else {
            TextField7Value =
                Math.floor(order_pcs) * vno_of_order.value;
        }
        if (ItemType == "ラバーコースター") {
            if (vno_of_order.value <= 10) {
                if (!$("#pcs4").is(":checked")) {
                    TextField7Value = Math.floor(18000);
                } else {
                    TextField7Value = Math.floor(21000);
                }
            } else {
                TextField7Value =
                    Math.floor(order_pcs) * vno_of_order.value;
            }
        }
        // Amount Before Tax
        TextField9Value =
            parseInt(TextField7Value) +
            ItemPCSFee +
            ItemSizeFee +
            proto_charge +
            trace_charge +
            print_charge +
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
                Math.floor((ItemPCSFee * vat) / (100 + vat)) +
                Math.floor((ItemSizeFee * vat) / (100 + vat)) +
                Math.floor((proto_charge * vat) / (100 + vat)) +
                Math.floor((trace_charge * vat) / (100 + vat)) +
                Math.floor((print_charge * vat) / (100 + vat)) +
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
        document.getElementById("textfield7_2").value = formatMoney(
            paperPrice * vno_of_order.value,
        );

        document.getElementById("textfield3").value = formatMoney(proto_charge);
        document.getElementById("textfield4").value = formatMoney(trace_charge);
        document.getElementById("textfield_dis").value = formatMoney(DisPrice);
        document.getElementById("textfield13").value = formatMoney(print_charge);

        let have_coating = false;
        if ($("#textfield13_2").length) {
            document.getElementById("textfield13_2").value = formatMoney(
                coating_charge * vno_of_order.value,
            );
            have_coating = true;
        }

        let have_packing = false;
        if ($("#textfield13_3").length) {
            document.getElementById("textfield13_3").value = formatMoney(
                packing_price * vno_of_order.value,
            );
            have_packing = true;
        }

        let have_design = false;
        if ($("#DesignsCharge").length) {
            document.getElementById("DesignsCharge").value =
                formatMoney(DesignsCharge);
            have_design = true;
        }

        let have_material = false;
        if ($("#MaterialCharge").length) {
            document.getElementById("MaterialCharge").value = formatMoney(
                MaterialCharge * vno_of_order.value,
            );
            have_material = true;
        }

        // document.getElementById('textfield8').value = formatMoney(shipping_charge);
        document.getElementById("textfield9").value = formatMoney(
            parseInt(TextField9Value),
        );
        // document.getElementById('textfield10').value = formatMoney(tax);
        document.getElementById("textfield11").value = formatMoney(total);
        setHiddenField("pricefield11", parseInt(TextField9Value));
        setHiddenField("pricefield13", total);
        $(".prd_total").text(formatMoney(total));
        // document.getElementById('textfield12').value = formatMoney(printumu);

        let shipping_price = 880;
        if (TextField9Value > 11000) {
            shipping_price = 0;
        }

        let sku_name = "";
        if (prd == "ペットボトルホルダー") {
            sku_name = "pbholder";
        }

        if (prd == "ラバーイヤホンホルダー") {
            sku_name = "cableholder";
        }

        if (prd == "ラバージビッツ") {
            sku_name = "rubberjibbitzs";
        }

        if (prd == "ラバータグ") {
            sku_name = "rubbertag";
        }

        if (prd == "ラバーフォトフレーム（写真立て）") {
            sku_name = "rubber-frame";
        }

        if (prd == "ラバーキーカバー") {
            sku_name = "keycover";
        }

        if (prd == "ラバーケーブルバンド") {
            sku_name = "rubber-cableband";
        }

        if (prd == "ラバーストラップ") {
            sku_name = "rubberstrap";
        }

        if (prd == "ラバーキーホルダー") {
            sku_name = "rubberkeyholder";
        }

        if (prd == "ラバーコースター") {
            sku_name = "rubbercoaster";
        }

        if (prd == "印刷ラバーストラップ・ラバーキーホルダー") {
            sku_name = "printed-rubber";
        }

        if (sku_name != "") {
            return {
                sku: sku_name,
                product: prd,
                qty: vno_of_order.value,
                product_price: TextField7Value,
                mold_price: special_shape_fee > 0 ? special_shape_fee : 0,
                part_price: partPrice * vno_of_order.value,
                backside_price: 0,
                paper_price: paperPrice * vno_of_order.value,
                prototype_price: proto_charge,
                ai_assistant_price: 0,
                trace_price: trace_charge,
                opp_price: 0,
                process_price: 0,
                color_price: 0,
                print_price: print_charge,
                coating_price: have_coating ? coating_charge * vno_of_order.value : 0,
                packing_price: have_packing ? packing_price * vno_of_order.value : 0,
                carabiner_price: 0,
                material_price: have_material ? MaterialCharge * vno_of_order.value : 0,
                design_price: have_design ? DesignsCharge : 0,
                item_pcs_fee: ItemPCSFee,
                item_size_fee: ItemSizeFee,
                item_material_fee: have_material ? MaterialCharge * vno_of_order.value : 0,
                discount: parseInt(DisPrice),
                shipping: shipping_price,
                vat: 0,
                tax: tax,
                subtotal: TextField9Value,
                total: total,
            };
        }
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
    ItemPCSFee = 0;
    ItemSizeFee = 0;

    if ($("#textfield7").length) {
        document.getElementById("textfield7").value = "";
    }

    if ($("#textfield7_1").length) {
        document.getElementById("textfield7_1").value = "";
    }
    if ($("#textfield7_2").length) {
        document.getElementById("textfield7_2").value = "";
    }

    if ($("#textfield3").length) {
        document.getElementById("textfield3").value = "";
    }
    if ($("#textfield4").length) {
        document.getElementById("textfield4").value = "";
    }
    if ($("#textfield13").length) {
        document.getElementById("textfield13").value = "";
    }

    if ($("#textfield13_2").length) {
        document.getElementById("textfield13_2").value = "";
    }

    if ($("#DesignsCharge").length) {
        document.getElementById("DesignsCharge").value = "";
    }
    if ($("#MaterialCharge").length) {
        document.getElementById("MaterialCharge").value = "";
    }

    // document.getElementById('textfield9').value = "";
    // document.getElementById('textfield10').value = "";
    if ($("#textfield11").length) {
        document.getElementById("textfield11").value = "";
    }
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
    var ItemType = $("#strap").val() || "";
    var partUrl = "/products/rubberstrap/part_admin.php";

    if (ItemType === "印刷ラバーストラップ・ラバーキーホルダー") {
        partUrl = "/products/printedrubberstrap_keyholder/part_admin.php";
    } else if (ItemType === "ラバーキーホルダー") {
        partUrl = "/products/rubberkeyholder/part_admin.php";
    } else if (ItemType.indexOf("ラバークリーナー") !== -1) {
        partUrl = "/products/rubbercleaner/part_admin.php";
    } else if (ItemType.indexOf("ゴルフターゲットカップ") !== -1 || ItemType.indexOf("ターゲットカップ") !== -1) {
        partUrl = "/products/targetcup/part_admin.php";
    }

    $.ajax({
        url: partUrl,
        method: "GET",
        data: { c: "passed" },
        dataType: "json",
        success: function (data) {
            var duce = [];
            if (Array.isArray(data)) {
                duce = data;
            } else if (typeof data === "string") {
                try {
                    duce = JSON.parse(data);
                } catch (e) {
                    duce = [];
                }
            }
            for (var i = 0; i < duce.length; i++) {
                if (duce[i]["part_name"] == v) {
                    parts_obj = duce[i];
                }
            }
        },
    }).done(function () {
        setToInput();

        //check case click back
        let prd_strap = $("#strap").val();
        if (
            typeof tmp !== 'undefined' &&
            tmp != "" &&
            tmp == "MODE_MOD" &&
            prd_strap != "ラバーコースター" &&
            prd_strap != "ラバースマートフォンスタンド" &&
            prd_strap != "ラバータグ" &&
            prd_strap != "ペットボトルホルダー"
        ) {
            let items = setToInputManual();
            if (Object.keys(items).length !== 0) {
                $.ajax({
                    type: "POST",
                    url: "/products/save_calc_data.php",
                    data: items,
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
    });
}





