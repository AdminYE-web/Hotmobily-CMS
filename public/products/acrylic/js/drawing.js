var lineWidth = 7; //カットラインサイズ

(function () {
  var formelement = document.getElementById("createpng");
  formelement.addEventListener("click", changePNG, false);

  ///////////////////////////////////////////////////////////
  function changePNG() {
    if (templateTarget >= 6) {
      //ダイカットのみ
      canvas2.width = 430;
      canvas2.height = 430;
      canvas2.getContext("2d").clearRect(0, 0, canvas2.width, canvas2.height);
      start();
    } else {
      //ダイカット以外

      //Canvas2に作成
      canvas2.width = TmpImgW;
      canvas2.height = TmpImgH;
      canvas2.getContext("2d").clearRect(0, 0, canvas2.width, canvas2.height);
      //イメージを貼り付け
      canvas2
        .getContext("2d")
        .drawImage(
          srcimages[1],
          PosMainX - TmpImgX,
          PosMainY - TmpImgY,
          PosMainW,
          PosMainH
        );
      //テンプレートファイルの貼り付け
      canvas2
        .getContext("2d")
        .drawImage(tmplimages[templateTarget], 0, 0, TmpImgW, TmpImgH);
      //イメージを画面に出力
      putImage();
    }
  }
  ///////////////////////////////////////////////////////////
  function dataURItoBlob(dataURI) {
    // convert base64/URLEncoded data component to raw binary data held in a string
    var byteString;
    if (dataURI.split(",")[0].indexOf("base64") >= 0)
      byteString = atob(dataURI.split(",")[1]);
    else byteString = unescape(dataURI.split(",")[1]);

    // separate out the mime component
    var mimeString = dataURI.split(",")[0].split(":")[1].split(";")[0];

    // write the bytes of the string to a typed array
    var ia = new Uint8Array(byteString.length);
    for (var i = 0; i < byteString.length; i++) {
      ia[i] = byteString.charCodeAt(i);
    }

    return new Blob([ia], { type: mimeString });
  }
  function cartSubmit() {
    $.post("/Json/GetSimData", "").done(function (data) {
      doneGetSimData(data);
    });
  }
  function doneGetSimData(data) {
    var file = dataURItoBlob(canvas2.toDataURL());
    var fd = new FormData();
    Object.keys(data.sim).forEach(function (k) {
      fd.append(k, data.sim[k]);
    });
    fd.append("Content-Type", file.type);
    fd.append("x-amz-meta-name", "preview");
    fd.append("filename", "preview");
    fd.append("file", file); //fileは最後に
    var xhr = new XMLHttpRequest();
    xhr.onload = function () {
      donePostPreview(data);
    };
    xhr.open("POST", data.s3url, true);
    xhr.send(fd); //POSTw/標準ヘッダ; CORSプレフライトなし
  }
  function donePostPreview(data) {
    var file = dataURItoBlob(srcimages[0].src);
    var filename = "";
    if (typeof srcfilename !== "undefined") {
      filename = srcfilename.match(/[^\\/:]*$/)[0];
    }
    if (filename === "") {
      filename = "untitled";
    }
    data.filename = filename;
    var fd = new FormData();
    Object.keys(data.src).forEach(function (k) {
      fd.append(k, data.src[k]);
    });
    fd.append("Content-Type", file.type);
    fd.append("x-amz-meta-name", filename);
    fd.append("filename", filename);
    fd.append("file", file); ///fileは最後に
    var xhr = new XMLHttpRequest();
    xhr.onload = function () {
      donePostSrc(data);
    };
    xhr.open("POST", data.s3url, true);
    xhr.send(fd); //POSTw/標準ヘッダ; CORSプレフライトなし
  }
  function donePostSrc(data) {
    var form = document.createElement("form");
    form.method = "POST";
    form.action = "/Cart/AddSim";
    var genko = document.createElement("input");
    genko.name = "genko";
    genko.value = data.genko;
    form.appendChild(genko);
    var template = document.createElement("input");
    template.name = "template";
    template.value = templateTarget;
    form.appendChild(template);
    var filename = document.createElement("input");
    filename.name = "filename";
    filename.value = data.filename;
    form.appendChild(filename);
    document.body.appendChild(form);
    form.submit();
  }

  function putImage() {
    var nimage = new Image();
    //nimage.src= cnvs_edit.toDataURL()//イメージに変換
    nimage.src = canvas2.toDataURL(); //イメージに変換
    nimage.onload = function () {
      $("html").css({ overflow: "hidden" });

      if (document.getElementById("MDL_overlay") === null) {
        $("body").append('<div id="MDL_overlay"></div>');
      }
      if (document.getElementById("MDL_window") === null) {
        $("body").append(
          '<div id="MDL_window">' +
            "<h2>仕上がりイメージ</h2>" +
            '<div class="preview_img"><img src="' +
            canvas2.toDataURL() +
            '"></div>' +
            "<p>プレビュー画像はあくまでもイメージです。<br>実際の仕上がりとは異なる場合がありますのでご注意ください。</p>" +
            '<div class="md_btn">' +
            "<ul>" +
            '<li><a href="javascript:void(0);" id="md_submit">商品を注文する</a></li>' +
            '<li class="close_area"><a href="javascript:void(0);" id="md_close" class="close_btn">閉じる</a></li>' +
            "</ul>" +
            "</div>" +
            "</div>"
        );
      }
      $("#MDL_overlay").show();
      $("#MDL_window").fadeIn("slow");
      $("#MDL_overlay,#md_close").click(function () {
        MDL_eliminate();
      });
      $("#md_submit").click(cartSubmit);
      ///////////////////////////////////////////////////////////
      function MDL_eliminate() {
        $("html").css({ overflow: "" });
        $("#MDL_overlay").fadeOut("fast");
        $("#MDL_window").fadeOut("fast");
        setTimeout(function () {
          MDL_remove();
        }, 500);
      }
      function MDL_remove() {
        $("#MDL_overlay").remove();
        $("#MDL_window").remove();
      }
      ///////////////////////////////////////////////////////////
    };
  }

  //カットライン作成
  function start() {
    var Mainimage = new Image();
    var Cutimage = new Image();

    Mainimage.src = srcimages[0].src; //取込画像を読み込み
    Mainimage.onload = function () {
      // 読み込まれた

      context_view.clearRect(0, 0, cnvs_edit.width, cnvs_edit.height); //画面をクリア
      context_view.drawImage(Mainimage, PosMainX, PosMainY, PosMainW, PosMainH); // 画像の描画

      ///////////////////////////////////////////////////////////

      var timage = context_view.getImageData(
        PosGuideX,
        PosGuideY,
        PosGuideW,
        PosGuideH
      ); //ガイド範囲内のイメージを取得
      var Cutcanvas = document.createElement("canvas"); //新しいCanvasを使用
      Cutcanvas.width = PosGuideW; //Canvasサイズはガイドと同じ
      Cutcanvas.height = PosGuideH; //Canvasサイズはガイドと同じ
      Cutcanvas.getContext("2d").putImageData(timage, 0, 0); //取得イメージをセット
      Cutimage.src = Cutcanvas.toDataURL(); //画像にしてカットイメージとする
      ///////////////////////////////////////////////////////////

      Cutimage.onload = function () {
        // 読み込まれた

        /////////////////////////////////////////////////////////////////////////////////////
        ////輪郭の抽出///////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////

        var x1 = PosGuideW; //基本座標をセット
        var y1 = PosGuideH; //基本座標をセット

        var imageData = context_view.getImageData(
          PosGuideX,
          PosGuideY,
          PosGuideW,
          PosGuideH
        );
        var data = imageData.data; //イメージ情報を配列で取得
        var length = data.length; //length取得

        //Canvasをクリア
        context_view.clearRect(0, 0, x1, y1);

        //輪郭作成用のCanvas作成////////////////////////////////////////////////////////
        var canvass = document.createElement("canvas");
        canvass.width = window.innerWidth;
        canvass.height = window.innerHeight;
        var context_sadow = canvass.getContext("2d");

        //debug用////////////////////////////////////////////
        //var canvas_test= document.getElementById('canvas3')
        //var context_test= canvas_test.getContext('2d')
        //context_test.clearRect(0, 0, 400, 400);
        /////////////////////////////////////////////////////

        //再調整用のデータ格納用/////////////////////////////
        var xx = 0;
        var dp = [];
        /////////////////////////////////////////////////////

        //データ解析の開始
        for (var i = 0; i < length; ++i) {
          if (i >= length) break;

          if (i % 4 == 3) {
            //RGBAの順でデータが入ってくるので見るのはAのみ
            xx = xx + 1;
            if (data[i] != 0) {
              //透明以外の部分を塗りつぶす
              var z = parseInt(i / 4);
              //大き目に塗りつぶすため端が切れるので少し移動
              var cut_sup = 15;

              //drawPoint(context_sadow,parseInt(z % x1) + cut_sup , parseInt(z / x1) + cut_sup, 'rgba(200, 200, 200, 0.5)',lineWidth);
              drawPoint(
                context_sadow,
                parseInt(z % x1) + cut_sup,
                parseInt(z / x1) + cut_sup,
                "rgba(255, 255, 255, 0.5)",
                lineWidth
              );

              dp[xx] = 1;
            } else {
              dp[xx] = 0;
            }
          }
        } //データ解析終了

        //補足調整をする

        length = dp.length;

        var base = 400; //Canvas幅をセット（正方形じゃなければ高さも必要）
        var iFLG = 0;
        var iFLG2 = 0;
        var Score = 30; //補正が必要か？
        var hScore = 0; //縦方向の補正スコア
        var wScore = 0; //横方向の補正スコア

        //1行目は補足の必要がないので飛ばす
        for (var i = 401; i < length; ++i) {
          if (i >= length) break;

          if (dp[i] == 0) {
            var iTOP = parseInt(i / base); //何行目？
            var iLEFT = iTOP * base + 1; //開始行の先頭ピクセル
            var iRIGHT = (iTOP + 1) * base; //開始行の終了ピクセル
            var iBOTTOM = base - (iTOP + 1); //残り何行?
            iFLG = 0;
            iFLG2 = 0;

            Score = 0;
            //縦方向を調べる
            for (var iset = 1; iset < iTOP; ++iset) {
              Score = ++Score;
              if (dp[i - iset * base] == 1) {
                iFLG = ++iFLG;
                if (Score < hScore) {
                  iFLG2 = ++iFLG2;
                }
                break;
              }
            }

            Score = 0;
            //左方向を調べる
            for (var iset = i; iLEFT < iset; --iset) {
              Score = ++Score;
              if (dp[iset] == 1) {
                iFLG = ++iFLG;
                if (Score < hScore) {
                  iFLG2 = ++iFLG2;
                }
                break;
              }
            }

            Score = 0;
            //右方向を調べる
            for (var iset = i; iset < iRIGHT; ++iset) {
              Score = ++Score;
              if (dp[iset] == 1) {
                iFLG = ++iFLG;
                if (Score < hScore) {
                  iFLG2 = ++iFLG2;
                }
                break;
              }
            }

            Score = 0;
            //下方向を調べる
            for (var iset2 = iTOP + 1; iset2 - iTOP < iBOTTOM; iset2++) {
              Score = ++Score;
              var tes = i + (iset2 - iTOP) * base;
              if (dp[tes] == 1) {
                iFLG = ++iFLG;
                if (Score < hScore) {
                  iFLG2 = ++iFLG2;
                }
                break;
              }
            }

            //四方が塞がっている場合のみ補正
            if (iFLG >= 4) {
              dp[i] = 1; //2次補正用に修正
              //drawPoint(context_sadow,(i-iLEFT +1)+15 , (base - iBOTTOM )+15, 'rgba(200, 200, 200, 0.5)',lineWidth);
              drawPoint(
                context_sadow,
                i - iLEFT + 1 + 15,
                base - iBOTTOM + 15,
                "rgba(255, 255, 255, 0.5)",
                lineWidth
              );
            }
          }
        }

        //２次補正//////////////////////////////////////////////////////////////////////////////////////////
        var Score = 15; //補正が必要か？
        var hScore = 0; //縦方向の補正スコア
        var wScore = 0; //横方向の補正スコア

        //1行目は補足の必要がないので飛ばす
        for (var i = 401; i < length; ++i) {
          if (i >= length) break;

          if (dp[i] == 0) {
            var iTOP = parseInt(i / base); //何行目？
            var iLEFT = iTOP * base + 1; //開始行の先頭ピクセル
            var iRIGHT = (iTOP + 1) * base; //開始行の終了ピクセル
            var iBOTTOM = base - (iTOP + 1); //残り何行?
            iFLG = 0;
            hScore = 0;
            wScore = 0;

            //縦方向を調べる
            for (var iset = 1; iset < iTOP; ++iset) {
              hScore = ++hScore;
              if (dp[i - iset * base] == 1) {
                if (hScore <= Score) {
                  iFLG = ++iFLG;
                }
                break;
              }
            }

            //左方向を調べる
            for (var iset = i; iLEFT < iset; --iset) {
              wScore = ++wScore;
              if (dp[iset] == 1) {
                if (wScore <= Score) {
                  iFLG = ++iFLG;
                }
                break;
              }
            }

            wScore = 0;
            //右方向を調べる
            for (var iset = i; iset < iRIGHT; ++iset) {
              wScore = ++wScore;
              if (dp[iset] == 1) {
                if (wScore <= Score) {
                  iFLG = ++iFLG;
                }
                break;
              }
            }

            hScore = 0;
            //下方向を調べる
            for (var iset2 = iTOP + 1; iset2 - iTOP < iBOTTOM; iset2++) {
              hScore = ++hScore;
              var tes = i + (iset2 - iTOP) * base;
              if (dp[tes] == 1) {
                if (hScore <= Score) {
                  iFLG = ++iFLG;
                }
                break;
              }
            }

            if (iFLG == 3) {
              //条件満たした３辺があれば補正
              //drawPoint(context_sadow,(i-iLEFT +1)+15 , (base - iBOTTOM )+15, 'rgba(200, 200, 200, 0.5)',lineWidth);
              drawPoint(
                context_sadow,
                i - iLEFT + 1 + 15,
                base - iBOTTOM + 15,
                "rgba(255, 255, 255, 0.5)",
                lineWidth
              );
            }
          }
        }

        ///穴位置を作成///////////////////////////////////////////////////////////////////////
        context_sadow.save();
        context_sadow.beginPath();
        //context_sadow.fillStyle = 'rgb(200, 200, 200)';
        context_sadow.fillStyle = "rgb(255, 255, 255)";
        context_sadow.lineWidth = lineWidth;
        context_sadow.arc(
          PosHoleX - PosGuideX + 20,
          PosHoleY - PosGuideY + 20,
          PosHoleW,
          0,
          Math.PI * 2,
          true
        );
        context_sadow.fill();
        context_sadow.globalCompositeOperation = "xor"; //排他的論理和で合成
        context_sadow.beginPath();
        //context_sadow.fillStyle = 'rgb(200, 200, 200)';
        context_sadow.fillStyle = "rgb(255, 255, 255)";
        context_sadow.arc(
          PosHoleX - PosGuideX + 20,
          PosHoleY - PosGuideY + 20,
          PosHoleW / 2 - 1,
          0,
          Math.PI * 2,
          true
        );
        context_sadow.fill();
        context_sadow.restore();
        /////////////////////////////////////////////////////////////////////////////////////

        /////////////////////////////////////////////////////////////////////////////////////
        //取得したグリッドを描写
        function drawPoint(context_sadow, x, y, color, sline) {
          context_sadow.save();
          context_sadow.translate(x, y);
          context_sadow.strokeStyle = color;
          context_sadow.lineWidth = sline;
          context_sadow.strokeRect(0, 0, 5, 5);
          context_sadow.restore();
        }
        /////////////////////////////////////////////////////////////////////////////////////

        /////////////////////////////////////////////////////////////////////////////////////
        //合成用Canvas
        /////////////////////////////////////////////////////////////////////////////////////
        context_view.clearRect(0, 0, cnvs_edit.width, cnvs_edit.height);

        // Check the opacity of the image
        // var opacityCheck = checkOpacity(cnvs_edit);

        // // Set the stroke color based on opacity check
        // if (opacityCheck < 10) {
        //   context_view.shadowColor = "red";
        //   context_view.shadowBlur = 2;
        //   context_view.shadowOffsetX = 1;
        //   context_view.shadowOffsetY = 1; // Set red border if opacity is less than 90%
        // } else {
        //   context_view.shadowColor = "#333333";
        //   context_view.shadowBlur = 2;
        //   context_view.shadowOffsetX = 1;
        //   context_view.shadowOffsetY = 1;
        // }

        context_view.shadowColor = "#333333";
        context_view.shadowBlur = 2;
        context_view.shadowOffsetX = 1;
        context_view.shadowOffsetY = 1;

        context_view.save();
        context_view.globalCompositeOperation = "xor"; //排他的論理和で合成
        context_view.drawImage(canvass, 0, 0);
        context_view.restore();
        context_view.save();
        context_view.drawImage(Cutimage, lineWidth + 10, lineWidth + 10); // 画像の描画
        context_view.restore();
        context_view.save();

        setTimeout(function () {
          context_view.restore();
          context_view.save();
          var image = context_view.getImageData(0, 0, 650, 650);
          canvas2.getContext("2d").putImageData(image, 0, 0);
          putImage();
          //context_view.clearRect(0, 0, cnvs_edit.width, cnvs_edit.height);
        });
        ///CutImageLoadEnd///////////////////////////////////////////////////////////////////////
      };

      ///MainImageLoadEnd////////////////////////////////////////////////////////////////
    };
    /////////////////////////////////////////////////////////////////////////////////
  }
})();
