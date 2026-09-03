// オリジナル刺繍ワッペン・パッチ
var window_lastCalcResult = null;

var unit_price = 0;

function valid_chk_btn(c) {
    chk_color();
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
    }
}

$("input[name='ft_type']").change(function() {
    if ($(this).val() == "刺繍") {
        $(".only_embro").show();
        $(".color-variation-container").show();
        
        $("input[name='ft_option'][value='ツイル生地']").prop("checked", true);
        
        $("input[name='ft_option'][value='ツイル生地']")
            .parents(".part-content")
            .find(".part-name")
            .removeClass("disabled");
        $("input[name='ft_option'][value='フェルト生地']")
            .parents(".part-content")
            .find(".part-name")
            .removeClass("disabled");
        $("input[name='ft_option'][value='サテン生地']")
            .parents(".part-content")
            .find(".part-name")
            .addClass("disabled");
        $("input[name='ft_option'][value='エンブクロス']")
            .parents(".part-content")
            .find(".part-name")
            .addClass("disabled");
    } else if ($(this).val() == "ジャガード織") {
        $(".only_embro").hide();
        $(".color-variation-container").show();
        
        $("input[name='ft_option']").each(function() {
            $(this).prop("checked", false);
        });
        
        $("input[name='ft_option'][value='ツイル生地']")
            .parents(".part-content")
            .find(".part-name")
            .addClass("disabled");
        $("input[name='ft_option'][value='フェルト生地']")
            .parents(".part-content")
            .find(".part-name")
            .addClass("disabled");
        $("input[name='ft_option'][value='サテン生地']")
            .parents(".part-content")
            .find(".part-name")
            .addClass("disabled");
        $("input[name='ft_option'][value='エンブクロス']")
            .parents(".part-content")
            .find(".part-name")
            .addClass("disabled");
    } else if ($(this).val() == "昇華転写") {
        $(".only_embro").hide();
        $(".color-variation-container").hide();
        
        $("input[name='ft_option'][value='ツイル生地']").prop("checked", true);
        
        $("input[name='ft_option'][value='ツイル生地']")
            .parents(".part-content")
            .find(".part-name")
            .removeClass("disabled");
        $("input[name='ft_option'][value='フェルト生地']")
            .parents(".part-content")
            .find(".part-name")
            .addClass("disabled");
        $("input[name='ft_option'][value='サテン生地']")
            .parents(".part-content")
            .find(".part-name")
            .removeClass("disabled");
        $("input[name='ft_option'][value='エンブクロス']")
            .parents(".part-content")
            .find(".part-name")
            .removeClass("disabled");
    }
});

$("input[name='ft_option']").change(function() {
    // Check the value of the currently selected radio input
    if ($(this).val() == "フェルト生地") {
        // Change options for ft_fabric_color1 to f1-f20
        changeOptionValues("f", 1, "ft_fabric_color1");
        // Change options for ft_fabric_color2 to f21-f40
        if ($("select[name=ft_fabric_color2]").length) {
            changeOptionValues("f", 1, "ft_fabric_color2");
        }
        if ($("input[name='ft_type']:checked").val() == "刺繍") {
            $(".only_embro").show();
        }
    } else if ($(this).val() == "ツイル生地") {
        // Change options for ft_fabric_color1 to t-1-t-20
        changeOptionValues("t", 1, "ft_fabric_color1");
        // Change options for ft_fabric_color2 to t-1-t-20
        if ($("select[name=ft_fabric_color2]").length) {
            changeOptionValues("t", 1, "ft_fabric_color2");
        }
        if ($("input[name='ft_type']:checked").val() == "刺繍") {
            $(".only_embro").show();
        }
    } else {
        $(".only_embro").hide();
    }
});

function check_val(v) {
    var ItemType = $("input[name=ItemType]").val();

    //set new condition
    var WappenType = $('input[name="ft_type"]:checked').val();
    var $BacksideType = $('#ft_backside_type');

    var disableValue = ['アイロンテープ'];
    $BacksideType.find('option').prop('disabled', false);
    if(WappenType == "ジャガード織")
    {
        disableValue.forEach(v => {
            // $BacksideType.find(`option[value="${v}"]`).prop('disabled', true);
        });
    }

    let $selected = $BacksideType.find('option:selected');
    if ($selected.prop('disabled')) {
        let $firstEnabled = $BacksideType.find('option:not(:disabled)').first();
        if ($firstEnabled.length) {
            $BacksideType.val($firstEnabled.val()).trigger('change');
        } else {
            $BacksideType.val(null).trigger('change');
        }
    }

    if ($("input[name=ft_process]:checked").val() == "オーバーロック仕上げ") {
        $(".overlock_only").show();
    } else {
        $(".overlock_only").hide();
    }
    
    if ($("input[name=ft_backside]").length) {
        if ($("input[name=ft_backside]:checked").val() == "デザインなし") {
            $(".no-designs").show();
        } else {
            $(".no-designs").hide();
        }
    }
    
    // console.log(v)
    if (v == "step3") {
        console.log($("input[name='ft_option']:checked").val());
        if ($("input[name='ft_option']:checked").val() == "フェルト生地") {
            changeOptionValues("f", 1, "ft_fabric_color1");
            // Change options for ft_fabric_color2 to f21-f40
            if ($("select[name=ft_fabric_color2]").length) {
                changeOptionValues("f", 1, "ft_fabric_color2");
            }
            $(".only_embro").show();
        } else if ($("input[name='ft_option']:checked").val() == "ツイル生地") {
            // Change options for ft_fabric_color1 to t-1-t-20
            changeOptionValues("t", 1, "ft_fabric_color1");
            // Change options for ft_fabric_color2 to t-1-t-20
            if ($("select[name=ft_fabric_color2]").length) {
                changeOptionValues("t", 1, "ft_fabric_color2");
            }
            $(".only_embro").show();
        } else {
            // set $("input[name=ft_fabric_color1]:first").prop("checked", true); to checked first radio
            $("input[name=ft_fabric_color1]:first").prop("checked", true);
            $(".only_embro").hide();
        }
    }
    
    if (
        parseInt($("input[name=color_variation]").val()) >
        parseInt($("input[name=color_variation]").attr("max"))
    ) {
        $("input[name=color_variation]").val(
            $("input[name=color_variation]").attr("max")
        );
    } else if (parseInt($("input[name=color_variation]").val()) < 0) {
        $("input[name=color_variation]").val(0);
    }
    
    if (v == "next") {
        if (!validation_numberOf()) {
            return false;
        } else {
            setToInput();
            return true;
        }
    } else {
        setToInput();
        return true;
    }
}

function validation_numberOf() {
    //エラー出力用id
    var err_number = document.getElementById("err_numberOf_mess");
    var mess = "";
    
    err_number.style.display = "";
    
    //入力値
    var vNumberOfOder = document.getElementById("qty");
    
    if (isNaN(vNumberOfOder.value)) {
        mess += "<font color='red'>半角数値以外が入力されています。</font>";
        err_number.innerHTML = mess;
        return false;
    } else if (vNumberOfOder.value == "" || vNumberOfOder.value < 50) {
        mess += "<font color='red'>本数は50本以上で入力して下さい。</font>";
        err_number.innerHTML = mess;
        return false;
    } else if (vNumberOfOder.value > 50000) {
        mess +=
            "<font color='red'>本数は50000本以下で入力して下さい。50000以上のお客様は納期をメールにてお問い合わせ下さい。</font>";
        err_number.innerHTML = mess;
        return false;
    } else {
        err_number.style.display = "none";
        return true;
    }
}

var order_pcs = 0;
var process_price = 0;
var backside_price = 0;
var color_variation_price = 0;
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
var opp_price = 0;

var parts_obj;
var partPrice = 0;
var paperPrice = 0;
var unit_price = 0;

function updateHiddenFields(res) {
    let form = $('form#form');
    let hiddenFields = {
        'StrapPrice': res.StrapPrice,
        'MoldPrice': res.MoldPrice,
        'BeforeTax': res.BeforeTax,
        'Tax': res.Tax,
        'grandTotal': res.grandTotal,
        'ProcessPrice': res.ProcessPrice,
        'BacksidePrice': res.BacksidePrice,
        'ColorPrice': res.ColorPrice,
        'PartPrice': res.PartPrice,
        'ProShipping': res.ProShipping,
        'TraceCharge': res.TraceCharge,
        'OPPPrice': res.OPPPrice,
        'discount': res.discount,
        'numberOf': $('#qty').val()
    };
    for (let key in hiddenFields) {
        let val = hiddenFields[key];
        let input = form.find('input[name="' + key + '"]');
        if (input.length === 0) {
            $('<input>').attr({type: 'hidden', name: key, value: val}).appendTo(form);
        } else {
            input.val(val);
        }
    }
}

function updateUIPrice(res) {
    if (res.StrapPrice !== undefined) {
        document.getElementById('prd_price').value = parseInt(res.StrapPrice).toLocaleString("en");
    }
    
    document.getElementById('prd_sample_price').value = parseInt(res.ProShipping).toLocaleString("en");
    document.getElementById('prd_trace_price').value = parseInt(res.TraceCharge).toLocaleString("en");
    document.getElementById('prd_opp_price').value = parseInt(res.OPPPrice).toLocaleString("en");
    document.getElementById('prd_process_price').value = parseInt(res.ProcessPrice).toLocaleString("en");
    document.getElementById('prd_mold_price').value = parseInt(res.MoldPrice).toLocaleString("en");
    document.getElementById('prd_color_price').value = parseInt(res.ColorPrice).toLocaleString("en");
    
    if ($('#prd_backside_price').length) {
        document.getElementById('prd_backside_price').value = parseInt(res.BacksidePrice).toLocaleString("en");
    }
    if ($('#prd_part_price').length) {
        document.getElementById('prd_part_price').value = parseInt(res.PartPrice).toLocaleString("en");
    }
    
    document.getElementById('prd_sub_total').value = parseInt(res.BeforeTax).toLocaleString("en");
    document.getElementById('discount').value = parseInt(res.discount).toLocaleString("en");
    
    if ($('#prd_tax').length) {
        document.getElementById('prd_tax').value = parseInt(res.Tax).toLocaleString("en");
    }
    
    document.getElementById('prd_total').value = parseInt(res.grandTotal).toLocaleString("en");
    $(".prd_total").text(parseInt(res.grandTotal).toLocaleString("en"));

    updateHiddenFields(res);
}

function setToInput() {
    clearValue();
    var vno_of_order = document.getElementById('qty');

    if (vno_of_order.value != "") {
        var formData = $('form#form').serialize();
        $.ajax({
            type: "POST",
            url: "/products/ajax_calculate_price_wappen.php",
            data: formData,
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    window_lastCalcResult = {
                        ItemType: $('input[name=ItemType]').val(),
                        BeforeTax: res.BeforeTax,
                        Tax: res.Tax,
                        grandTotal: res.grandTotal,
                        discount: res.discount,
                        qty: $('#qty').val()
                    };
                    updateUIPrice(res);
                }
            },
            error: function(err) {
                console.log("Pricing error: ", err);
            }
        });
        
        var ItemType = $('input[name=ItemType]').val();
        var ftType = $('input[name=ft_type]:checked').val() || '刺繍';
        var ftSize = parseInt($('select[name=ft_size] option:selected').val()) || 5;
        
        var ftBackside = 'デザインなし';
        if ($('input[name=ft_backside]:checked').length) {
            ftBackside = $('input[name=ft_backside]:checked').val();
        }
        
        var ftBacksideType = '';
        if ($('select[name=ft_backside_type]').length) {
            ftBacksideType = $('select[name=ft_backside_type] option:selected').val() || '';
        }

        var ftProcess = $('input[name=ft_process]:checked').val() || 'ヒートカット仕上げ';
        var ftSample = $('input[name=ft_sample]:checked').val() || 'なし';
        var ftTrace = $('input[name=ft_trace]:checked').val() || 'なし';
        var ftOpp = $('input[name=ft_opp]:checked').val() || 'なし';
        
        $('#sample-prd-prdt').text(ItemType);
        $('#prd_production').text(ItemType);
        $('#sample-prd-type').text(ftType);
        $('#prd_type').text(ftType);

        if ($('input[name=ft_option]:checked').length) {
            $('#prd_material').text($('input[name=ft_option]:checked').val());
        }

        $('#prd_fabric_color1').text($('select[name=ft_fabric_color1] option:selected').text());
        if ($('input[name=ft_fabric_color1]:checked').val() != undefined) {
            $('#prd_fabric_color1').text($('input[name=ft_fabric_color1]:checked').val());
        }
        if ($('#prd_fabric_color2').length) {
            $('#prd_fabric_color2').text(($('select[name=ft_fabric_color2] option:selected').val() == "" ? "表と同じ" : $('select[name=ft_fabric_color2] option:selected').text()));
            if ($('input[name=ft_fabric_color2]:checked').val() != undefined) {
                $('#prd_fabric_color2').text($('input[name=ft_fabric_color2]:checked').val());
            }
        }

        if ($('select[name=ft_size]').length) {
            $('#prd_size').text(ftSize + "cm.");
        }

        $('#prd_processing').text(ftProcess + (ftProcess != "オーバーロック仕上げ" ? "" :
            ($('select[name=ft_overlock_color]').length ? "(" + $('select[name=ft_overlock_color] option:selected').val() + ")" : "")));

        $('#sample-prd-qty').text(vno_of_order.value);
        $('#prd_amount').text(vno_of_order.value);

        if ($('input[name=ft_backside]').length) {
            if (ftBackside == "デザインあり" || ftBackside == "ロック式の安全ピン" || ftBackside == "バタフライクラッチ") {
                $('#prd_backside').text(ftBackside);
            } else {
                if ($('select[name=ft_backside_type]').length) {
                    $('#prd_backside').text(ftBacksideType || 'デザインなし');
                } else {
                    $('#prd_backside').text(ftBackside);
                }
            }
        } else {
            if ($('select[name=ft_backside_type]').length) {
                $('#prd_backside').text(ftBacksideType || '加工なし');
            }
        }

        if (ftSample != "なし") {
            $('#prd_sample').text('あり');
            $('#sample-prd-samp').text('あり');
        } else {
            $('#prd_sample').text('なし');
            $('#sample-prd-samp').text('なし');
        }

        if (ftTrace != "なし") {
            $('#prd_trace').text('あり');
        } else {
            $('#prd_trace').text('なし');
        }

        if (ftOpp != "なし") {
            $('#prd_opp').text('あり');
            $('#sample-prd-opp').text('あり');
        } else {
            $('#prd_opp').text('なし');
            $('#sample-prd-opp').text('なし');
        }
    }
}
function changeOptionValues(prefix, startIndex, selectName) {
    var color_f_arr = [
        "108 （赤色）",
        "63 （緑）",
        "83 （紺藍）",
        "76 （紅赤）",
        "30 （オレンジ色）",
        "131 （えんじ）",
        "78 （藤紫）",
        "74 （紫色）",
        "135 （山吹色）",
        "32 （黄色）",
        "9 （ピンク）",
        "94 （茶色）",
        "35（黄緑色）",
        "66（ビリジアン）",
        "46（スカイブルー）",
        "52（青色）",
        "12（牡丹色）",
        "129（灰色）",
        "123（黒色）",
        "1（白）",
        "88（ネイビー）",
        "126（ダークブルー）",
    ];
    var color_t_arr = [
        "T184（赤色）",
        "T223（緑色）",
        "T47（紺藍）",
        "T244（紅赤）",
        "T142（オレンジ色）",
        "T95（えんじ）",
        "T202（藤紫）",
        "T258（紫色）",
        "T214（山吹色）",
        "T54（黄色）",
        "T122（ピンク）",
        "T219（茶色）",
        "T24（黄緑色）",
        "T218（ビリジアン）",
        "T32（スカイブルー）",
        "T37（青色）",
        "T198（牡丹色）",
        "T256（灰色）",
        "1.2mmBLACA（黒色）",
        "T01B（白）",
        "T199（ネイビー）",
        "T108（ダークブルー）",
    ];
    // Loop through options for the specified select name
    if ($("select[name='" + selectName + "'] option").length) {
        $("select[name='" + selectName + "'] option").each(function(index) {
            if ($(this).val() != "表と同じ") {
                var newValue =
                    prefix === "f" ?
                    prefix + "-" + (index + startIndex) :
                    prefix + "-" + (index + startIndex);
                $(this).text(newValue);
            } else {
                --startIndex;
            }
        });
    } else if ($("input[name=ft_fabric_color1]:checked").val() != undefined) {
        if ($(".STD_printing_color1").length) {
            if (prefix == "t") {
                $(".STD_printing_color1").each(function(index) {
                    // console.log($(this).closest('td').find('img').attr('src'));
                    $(this).attr("value", color_f_arr[index]);
                    if ($(this).closest("td").find("img").attr("src") != undefined) {
                        $(this)
                            .closest("td")
                            .find("img")
                            .attr(
                                "src",
                                "images/flight_tag/icon-" + formatNumber(index) + ".webp"
                            );
                    }
                });
            } else {
                $(".STD_printing_color1").each(function(index) {
                    // console.log($(this).closest('td').find('img').attr('src'));
                    $(this).attr("value", color_t_arr[index]);
                    if ($(this).closest("td").find("img").attr("src") != undefined) {
                        $(this)
                            .closest("td")
                            .find("img")
                            .attr(
                                "src",
                                "images/flight_tag/wappen-icon-" + formatNumber(index) + ".webp"
                            );
                    }
                });
            }
        }
        if ($(".STD_printing_color2").length) {
            if (prefix == "t") {
                $(".STD_printing_color2").each(function(index) {
                    // console.log($(this).closest('td').find('img').attr('src'));
                    $(this).attr("value", color_f_arr[index]);
                    if ($(this).closest("td").find("img").attr("src") != undefined) {
                        $(this)
                            .closest("td")
                            .find("img")
                            .attr(
                                "src",
                                "images/flight_tag/icon-" + formatNumber(index) + ".webp"
                            );
                    }
                });
            } else {
                $(".STD_printing_color2").each(function(index) {
                    // console.log($(this).closest('td').find('img').attr('src'));
                    $(this).attr("value", color_t_arr[index]);
                    if ($(this).closest("td").find("img").attr("src") != undefined) {
                        $(this)
                            .closest("td")
                            .find("img")
                            .attr(
                                "src",
                                "images/flight_tag/wappen-icon-" + formatNumber(index) + ".webp"
                            );
                    }
                });
            }
        }
    }
}

function clearValue() {
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
    
    document.getElementById("prd_opp_price").value = "";
    document.getElementById("prd_sample_price").value = "";
    
    document.getElementById("prd_price").value = "";
    document.getElementById("prd_sub_total").value = "";
    document.getElementById("prd_total").value = "";
}

function setzero() {
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
    
    document.getElementById("prd_opp_price").value = "";
    document.getElementById("prd_trace_price").value = "";
    document.getElementById("prd_sample_price").value = "";
    
    document.getElementById("prd_price").value = "";
    document.getElementById("prd_sub_total").value = "";
    document.getElementById("prd_total").value = "";
    
    $("input[name=ft_type]:first").prop("checked", true);
    $("input[name=ft_option]:first").prop("checked", true);
    
    $("input[name=ft_sample]").prop("checked", false);
    $("input[name=ft_opp]").prop("checked", false);
    
    document.getElementById("qty").value = "";
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

function getPartData(v) {
    if (
        $("input[name=ItemType]").val() == "フライトタグ（刺繍タグキーホルダー）"
    ) {
        $.get("part_flight_tag.php", {
            c: "passed"
        }, function(data) {
            var duce = $.parseJSON(data);
            for (var i = 0; i < duce.length; i++) {
                if (duce[i]["part_name"] == v) {
                    parts_obj = duce[i];
                }
            }
        }).done(function() {
            setToInput();
        });
    } else if ($("input[name=ItemType]").val() == "刺繍キーホルダー") {
        $.get("part_flight_tag_keyholder.php", {
            c: "passed"
        }, function(data) {
            var duce = $.parseJSON(data);
            for (var i = 0; i < duce.length; i++) {
                if (duce[i]["part_name"] == v) {
                    parts_obj = duce[i];
                }
            }
        }).done(function() {
            setToInput();
        });
    }
}

function chk_color() {
    var color_1 = "";
    var color_2 = "";
    
    if ($("input[name=ft_fabric_color1]:checked").val() != undefined) {
        color_1 = $("input[name=ft_fabric_color1]:checked").val();
        if (
            $("input[name=ft_fabric_color1]:checked")
            .parent()
            .find("img")
            .attr("src") != ""
        ) {
            $("#img-show-Insatsu1").removeClass("d-none");
            $("#img-show-Insatsu1").attr(
                "src",
                $("input[name=ft_fabric_color1]:checked")
                .parent()
                .find("img")
                .attr("src")
            );
            $("#txt-show-Insatsu1").removeClass("d-none");
            $("#txt-show-Insatsu1").text(color_1);
        }
        if (color_1 == "PANTONE/DIC指定") {
            $("#img-show-Insatsu1").addClass("d-none");
            $("#img-show-Insatsu1").attr("src", "");
            $("#txt-show-Insatsu1").removeClass("d-none");
            $("#txt-show-Insatsu1").text("PANTONE/DIC指定");
        }
        $("#prd_fabric_color1").text(color_1);
    }
    if ($("input[name=ft_fabric_color2]:checked").val() != undefined) {
        color_2 = $("input[name=ft_fabric_color2]:checked").val();
        if (
            $("input[name=ft_fabric_color2]:checked")
            .parent()
            .find("img")
            .attr("src") != ""
        ) {
            $("#img-show-Insatsu2").removeClass("d-none");
            $("#img-show-Insatsu2").attr(
                "src",
                $("input[name=ft_fabric_color2]:checked")
                .parent()
                .find("img")
                .attr("src")
            );
            $("#txt-show-Insatsu2").removeClass("d-none");
            $("#txt-show-Insatsu2").text(color_2);
        }
        if (color_2 == "PANTONE/DIC指定") {
            $("#img-show-Insatsu2").addClass("d-none");
            $("#img-show-Insatsu2").attr("src", "");
            $("#txt-show-Insatsu2").removeClass("d-none");
            $("#txt-show-Insatsu2").text("PANTONE/DIC指定");
        }
        $("#prd_fabric_color2").text(color_2);
    }
}

$(function() {
    $(".STD_printing_color1, .STD_printing_color2").click(function() {
        chk_color();
    });
});

function formatNumber(number) {
    if (number >= 0 && number <= 8) {
        // Add leading zero for numbers between 0 and 9
        return "0" + (number + 1);
    } else if (number >= 9) {
        // Numbers between 10 and 22 remain unchanged
        return "" + (number + 1);
    }
}

function pre_set(elm) {
    $("html, body").animate({
            scrollTop: $("#form").offset().top,
        },
        1000
    );
    
    var size = $(elm).attr("data-size");
    var qty = $(elm).attr("data-qty");
    var side = $(elm).attr("data-side");
    
    $("select[name=ft_size]").val(size);
    $("input[name=qty]").val(qty);
    
    if (side != "") {
        $("input[name=ft_backside]:eq(" + side + ")").prop("checked", true);
    }
    check_val("next");
}