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
          PosMainH,
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
    // Embed part image if available
    if (typeof parts_obj !== "undefined" && parts_obj.part_pic) {
      var partImg = new Image();
      partImg.crossOrigin = "Anonymous";
      partImg.src = parts_obj.part_pic;
      partImg.onload = function () {
        var ctx = canvas2.getContext("2d");
        // Standardizing hole position for drawing (using global PosHoleX/Y)
        var drawX = PosHoleX;
        var drawY = PosHoleY;

        // Adjust for canvas2 offset if applicable (changePNG uses TmpImgX offset for non-diecut)
        if (templateTarget < 6) {
          drawX = PosHoleX - TmpImgX;
          drawY = PosHoleY - TmpImgY;
        } else {
          // For diecut logic (approximate center relative to hole)
          drawX = PosHoleX - PosGuideX + 20;
          drawY = PosHoleY - PosGuideY + 20;
        }

        // Draw part image centered on hole
        var pW = partImg.naturalWidth * 0.5;
        var pH = partImg.naturalHeight * 0.5;

        ctx.drawImage(partImg, drawX - pW / 2, drawY - 10, pW, pH);

        finalizePutImage();
      };
      partImg.onerror = function () {
        finalizePutImage(); // Proceed even if part load fails
      };
    } else {
      finalizePutImage();
    }

    function finalizePutImage() {
      var nimage = new Image();
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
              "</div>",
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
  }

  /////////////////////////////////////////////////////////////////////////////////
  //
  // This function starts the drawing process. It draws the main image and then
  // creates the cut line image. It then draws the cut line image onto a
  // temporary canvas. It then draws the temporary canvas onto the
  // main canvas, and then extracts the image data from the main canvas. Finally,
  // it saves the image data to a new canvas and calls the `putImage` function.
  /////////////////////////////////////////////////////////////////////////////////
  function start() {
    var Mainimage = new Image();
    var Cutimage = new Image();

    Mainimage.src = srcimages[0].src; // Take in the main image source URL
    Mainimage.onload = function () {
      // Read in the main image
      context_view.clearRect(0, 0, cnvs_edit.width, cnvs_edit.height); // Clear the main canvas
      context_view.drawImage(Mainimage, PosMainX, PosMainY, PosMainW, PosMainH); // Draw the main image

      // Create the cut line image from the guide data
      var timage = context_view.getImageData(
        PosGuideX,
        PosGuideY,
        PosGuideW,
        PosGuideH,
      ); // Get the image data of the guide region
      var Cutcanvas = document.createElement("canvas"); // Create a new canvas
      Cutcanvas.width = PosGuideW; // Set the canvas width to the guide width
      Cutcanvas.height = PosGuideH; // Set the canvas height to the guide height
      var Cutcontext = Cutcanvas.getContext("2d"); // Get the 2d drawing context
      Cutcontext.putImageData(timage, 0, 0); // Draw the guide image data onto the canvas
      Cutimage.src = Cutcanvas.toDataURL(); // Set the source of the Cutimage to the canvas data

      Cutimage.onload = function () {
        // Read in the cut line image
        var x1 = PosGuideW; // Set the basic coordinates
        var y1 = PosGuideH; // Set the basic coordinates

        var imageData = context_view.getImageData(
          PosGuideX,
          PosGuideY,
          PosGuideW,
          PosGuideH,
        );
        var data = imageData.data; // Get the image data
        var length = data.length; // Get the length of the image data

        // Clear the main canvas
        context_view.clearRect(0, 0, cnvs_edit.width, cnvs_edit.height);

        // Create a new canvas to draw the outline onto
        var canvass = document.createElement("canvas");
        canvass.width = window.innerWidth;
        canvass.height = window.innerHeight;
        var context_sadow = canvass.getContext("2d");

        // Make a copy of the image data to use for drawing the outline
        var dp = new Array(length);
        for (var i = 0; i < length; i += 4) {
          dp[i / 4] = data[i + 3] !== 0; // Only look at the alpha channel
        }

        // Draw the outline onto the new canvas
        var iFLG = 0;
        var hScore = 0;
        var wScore = 0;
        for (var i = 401; i < length; ++i) {
          if (i >= length) break;

          if (dp[i] === 0) {
            var iTOP = parseInt(i / base); // Get the row number
            var iLEFT = iTOP * base + 1; // Get the left edge of the row
            var iRIGHT = (iTOP + 1) * base; // Get the right edge of the row
            var iBOTTOM = base - (iTOP + 1); // Get the number of rows below the current row

            iFLG = 0;
            hScore = 0;
            wScore = 0;

            // Check the top edge
            for (var iset = 1; iset < iTOP; ++iset) {
              hScore = ++hScore;
              if (dp[i - iset * base] === 1) {
                if (hScore <= Score) {
                  iFLG = ++iFLG;
                }
                break;
              }
            }

            // Check the left edge
            for (var iset = i; iLEFT < iset; --iset) {
              wScore = ++wScore;
              if (dp[iset] === 1) {
                if (wScore <= Score) {
                  iFLG = ++iFLG;
                }
                break;
              }
            }

            // Check the right edge
            for (var iset = i; iset < iRIGHT; ++iset) {
              wScore = ++wScore;
              if (dp[iset] === 1) {
                if (wScore <= Score) {
                  iFLG = ++iFLG;
                }
                break;
              }
            }

            // Check the bottom edge
            for (var iset2 = iTOP + 1; iset2 - iTOP < iBOTTOM; iset2++) {
              hScore = ++hScore;
              var tes = i + (iset2 - iTOP) * base;
              if (dp[tes] === 1) {
                if (hScore <= Score) {
                  iFLG = ++iFLG;
                }
                break;
              }
            }

            // If the outline is closed, draw a point onto the new canvas
            if (iFLG === 3) {
              drawPoint(
                context_sadow,
                i - iLEFT + 1 + 15,
                base - iBOTTOM + 15,
                "rgba(255, 255, 255, 0.5)",
                lineWidth,
              );
            }
          }
        }

        // Draw a small circle onto the new canvas to mark the center of the
        // outline
        context_sadow.save();
        context_sadow.beginPath();
        context_sadow.fillStyle = "rgba(255, 255, 255)";
        context_sadow.lineWidth = lineWidth;
        context_sadow.arc(
          PosHoleX - PosGuideX + 20,
          PosHoleY - PosGuideY + 20,
          PosHoleW,
          0,
          Math.PI * 2,
          true,
        );
        context_sadow.fill();
        context_sadow.globalCompositeOperation = " xor"; // Exclusive OR
        context_sadow.beginPath();
        context_sadow.fillStyle = "rgba(255, 255, 255)";
        context_sadow.arc(
          PosHoleX - PosGuideX + 20,
          PosHoleY - PosGuideY + 20,
          PosHoleW / 2 - 1,
          0,
          Math.PI * 2,
          true,
        );
        context_sadow.fill();
        context_sadow.restore();

        // Draw the new canvas onto the main canvas
        context_view.save();
        context_view.drawImage(canvass, 0, 0);
        context_view.globalCompositeOperation = " xor"; // Exclusive OR
        context_view.drawImage(Cutimage, lineWidth + 10, lineWidth + 10);
        context_view.restore();

        // Copy the image data onto a new canvas
        var image = context_view.getImageData(0, 0, 650, 650);
        canvas2.getContext("2d").putImageData(image, 0, 0);

        // Call the putImage function
        setTimeout(function () {
          context_view.clearRect(0, 0, cnvs_edit.width, cnvs_edit.height);
          putImage();
        }, 0);
      };

      // Main image load end
    };
    /////////////////////////////////////////////////////////////////////////////////
  }
})();
