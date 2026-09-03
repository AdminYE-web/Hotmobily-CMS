var canvas = document.getElementById("canvas");
var canvas2 = document.getElementById("canvas2");
var cnvs_edit = document.getElementById("cnvs_edit");
var context_view = cnvs_edit.getContext("2d");
var template = new Image();
var templateTarget = 0;
var srcimages = [];
var srcfilename = "";
var PosMainX = 0;
var PosMainY = 0;
var PosMainH = 0;
var PosMainW = 0;
var context = canvas.getContext("2d");

var PosGuideX = 200; //ガイドの標準X座標
var PosGuideY = 150; //ガイドの標準X座標
var PosGuideH = 400; //ガイドのサイズ（ダイカットのみ）
var PosGuideW = 400; //ガイドのサイズ（ダイカットのみ）

var PosHoleX = 400; //穴位置のX座標
var PosHoleY = 167; //穴位置のY座標
var PosHoleW = 16; //穴位置の直径
var PosHoleH = 16;

var MainMaxW = 0; //画像の最大サイズ
var MainMaxH = 0; //画像の最大サイズ

var TmpImgX = 250; //テンプレート画像表示位置
var TmpImgY = 150; //テンプレート画像表示位置
var TmpImgW = 300; //テンプレート画像サイズ
var TmpImgH = 300; //テンプレート画像サイズ

var ImgMag = 0.7; //読み込み画像倍率（Canvasサイズに対して）

var cnvW = 800;
var cnvH = 700;
var tmplimages = [];

(function () {
  var isDragging = false;
  var dragTarget = null; // ドラッグ対象の画像の添え字
  var dragType = null; // ドラッグ対象の画像の添え字
  var cnvsH = cnvH;
  var cnvsW = cnvW;
  var natuWidth = 0;
  var natuHeight = 0;

  var psx = 0;
  var psy = 0;

  context.save();

  $("input[name='myskintype']").val(["0"]);

  $("#menu li").on("click", function () {
    var sub = $(this).children("ul");
    if ($(sub).is(":hidden")) $(sub).slideDown();
    else $(sub).slideUp();
  });

  var bgimage = new Image();
  bgimage.src = "/products/acrylic/img/bg.png" + "?" + new Date().getTime();
  //bgimage.src = 'js/simulator/bg.png' + '?' + new Date().getTime();
  bgimage.onload = function () {
    drawbg();
    //context.fill();
  };

  /* 画像URLを指定して、画像のロードを開始する */
  template.src = "/products/acrylic/img/small_dogtag.png";
  template.drawOffsetX = TmpImgX;
  template.drawOffsetY = TmpImgY;

  var srcs = [
    "/products/acrylic/img/small_dogtag.png",
    "/products/acrylic/img/small_ema_120627.png",
    "/products/acrylic/img/small_jougi_120703.png",
    "/products/acrylic/img/small_kan75_120620.png",
    "/products/acrylic/img/small_maru_120620.png",
    "/products/acrylic/img/small_woodstrap.png",
  ];

  for (var i in srcs) {
    tmplimages[i] = new Image();
    tmplimages[i].src = srcs[i];
  }

  var loadedCount = 0;

  tmplimages[templateTarget].addEventListener(
    "load",
    function () {
      var x = TmpImgX; //テンプレート画像表示位置
      var y = TmpImgY; //テンプレート画像表示位置
      var w = TmpImgW; //テンプレート画像サイズ
      var h = TmpImgH; //テンプレート画像サイズ

      tmplimages[templateTarget].drawOffsetX = x;
      tmplimages[templateTarget].drawOffsetY = y;
      tmplimages[templateTarget].drawWidth = w;
      tmplimages[templateTarget].drawHeight = h;
      context.drawImage(tmplimages[templateTarget], x, y, w, h);
    },
    false
  );
  /////////////////////////////////////////////////////////////////////////

  // id="ufile"の変化でコールバック
  $("#ufile").change(function () {
    // 選択ファイルの有無をチェック
    if (!this.files.length) {
      alert("ファイルが選択されていません");
      return;
    }

    var fileName = this.files[0].name;
    var type = fileName.split(".");
    if (type[type.length - 1].toLowerCase() != "png") {
      alert(
        "サポートしていないデータ形式です。PNGの画像データをアップロードしてください。"
      );
      $(".dropify-clear").click();
      return;
    }

    document.getElementById("def").className = "selectskin"; //classを削除

    // Formからファイルを取得
    var file = this.files[0];
    srcfilename = file.name;

    // 描画イメージインスタンス化
    srcimages[0] = new Image();
    srcimages[1] = new Image();

    // File API FileReader Objectでローカルファイルにアクセス
    var fr = new FileReader();

    //画面クリア
    context_view.clearRect(0, 0, cnvs_edit.width, cnvs_edit.height);

    // ファイル読み込み読み込み完了後に実行 [非同期処理]
    fr.onload = function (evt) {
      // 画像がロードされた後にcanvasに描画を行う [非同期処理]
      srcimages[0].onload = function () {
        canvas.width = cnvW;
        canvas.height = cnvH;
        //画面クリア
        context.clearRect(0, 0, canvas.width, canvas.height);

        //読み込み画像サイズを取得
        var srcH = srcimages[0].naturalHeight;
        var srcW = srcimages[0].naturalWidth;

        //Canvasより大きい場合は縮小
        if (srcH > cnvsH * ImgMag) {
          srcH = cnvsH * ImgMag;
          srcW =
            (srcimages[0].naturalWidth * srcH) / srcimages[0].naturalHeight;
        }

        if (srcW > cnvsW * ImgMag) {
          srcW = cnvsW * ImgMag;
          srcH =
            (srcimages[0].naturalHeight * srcW) / srcimages[0].naturalWidth;
        }

        //これ以上拡大させない
        MainMaxW = srcW;
        MainMaxH = srcH;

        //中心に配置
        psx = (cnvsW - srcW) / 2;
        psy = (cnvsH - srcH) / 2;

        //画像の表示
        context.drawImage(srcimages[0], psx, psy, srcW, srcH);
        context.drawImage(srcimages[1], psx, psy, srcW, srcH);
        console.log(cnvsW, cnvsH);
        console.log(srcW, srcH);
        console.log(psx, psy);
        //初期サイズと座標を記憶
        srcimages[1].drawOffsetX = psx;
        srcimages[1].drawOffsetY = psy;
        srcimages[1].drawWidth = srcW;
        srcimages[1].drawHeight = srcH;

        //オリジナルサイズを記憶させておく
        natuWidth = srcW;
        natuHeight = srcH;

        //現行のサイズ・座標を登録
        PosMainX = psx;
        PosMainY = psy;
        PosMainW = srcW;
        PosMainH = srcH;

        //サイズを変更
        srcimages[0].drawWidth = srcW;
        srcimages[0].drawHeight = srcH;

        //ガイドを作成
        //drawGuide(templateTarget);
        //context.fillRect(PosHoleX, PosHoleY, PosHoleW, PosHoleH);

        context.clearRect(0, 0, canvas.width, canvas.height);
        context.restore();
        context.save();

        templateTarget = 6;

        drawbg(); //背景をセット

        //context.drawImage(tmplimages[skintype], 150, 150, 300, 300);
        if (PosMainW != 0 && PosMainY != 0) {
          context.drawImage(
            srcimages[0],
            PosMainX,
            PosMainY,
            PosMainW,
            PosMainH
          );
        }

        drawGuide(templateTarget); //ガイドを作成
      };
      srcimages[0].src = evt.target.result;
      srcimages[1].src = evt.target.result;
    };

    // fileを読み込む データはBase64エンコードされる
    fr.readAsDataURL(file);
  });

  // ドラッグ開始/////////////////////////////////////////////////////////////////////////
  var mouseDown = function (e) {
    // ドラッグ開始位置
    //var posX = parseInt(e.clientX - canvas.offsetLeft);
    //var posY = parseInt(e.clientY - canvas.offsetTop);

    //var posX = parseInt(e.layerX - canvas.offsetLeft);
    //var posY = parseInt(e.layerY - canvas.offsetTop);
    var rect = e.target.getBoundingClientRect();
    var posX = Math.round(
      (canvas.width * (e.clientX - rect.left)) / canvas.clientWidth
    );
    var posY = Math.round(
      (canvas.height * (e.clientY - rect.top)) / canvas.clientHeight
    );

    var i = 1;
    var movX = 0;
    var movY = 0;

    var WmovX = 0;
    var WmovY = 0;

    console.log("posX:" + posX + "posY:" + posY);

    if (srcimages[i].drawOffsetX < 0) {
      movX = srcimages[i].drawWidth + srcimages[i].drawOffsetX;

      WmovX = srcimages[i].drawWidth + srcimages[i].drawOffsetX - 20;
    } else {
      movX = srcimages[i].drawOffsetX + srcimages[i].drawWidth;
      WmovX = srcimages[i].drawWidth + srcimages[i].drawOffsetX - 20;
    }

    if (srcimages[i].drawOffsetY < 0) {
      movY = srcimages[i].drawHeight + srcimages[i].drawOffsetY;
      WmovY = srcimages[i].drawHeight + srcimages[i].drawOffsetY - 20;
    } else {
      movY = srcimages[i].drawOffsetY + srcimages[i].drawHeight;
      WmovY = srcimages[i].drawHeight + srcimages[i].drawOffsetY - 20;
    }

    console.log("MovX:" + movX + "MovYY:" + movY);
    //console.log("WMovX:" + WmovX + "WMovY:" + WmovY);
    //console.log(srcimages[i].drawHeight);
    // 当たり判定（ドラッグした位置が画像の範囲内に収まっているか）

    //穴位置の判定
    if (
      posX >= PosHoleX - PosHoleW / 2 &&
      posX <= PosHoleX + PosHoleW / 2 &&
      posY >= PosHoleY - PosHoleH / 2 &&
      posY <= PosHoleY + PosHoleH / 2
    ) {
      dragTarget = i;
      dragType = 2;
      isDragging = true;
    }
    //拡大縮小の判定
    else if (
      posX >= WmovX &&
      posX <= movX + 20 &&
      posY >= WmovY &&
      posY <= movY + 20
    ) {
      dragTarget = i;
      dragType = 1;
      isDragging = true;
      WidthX = posX;
      WidthY = posY;
      //break;
    }
    //画像の判定
    else if (
      posX >= srcimages[i].drawOffsetX &&
      posX <= movX &&
      posY >= srcimages[i].drawOffsetY &&
      posY <= movY
    ) {
      dragTarget = i;
      dragType = 0;
      isDragging = true;
      //break;
    }

    console.log("dragType:" + dragType);
  };

  // ドラッグ終了
  var mouseUp = function (e) {
    isDragging = false;
    if (srcimages[1] != undefined) {
      natuWidth = srcimages[1].drawWidth;
      natuHeight = srcimages[1].drawHeight;
    }
  };

  // canvasの枠から外れた
  var mouseOut = function (e) {
    // canvas外にマウスカーソルが移動した場合に、ドラッグ終了としたい場合はコメントインする
    mouseUp(e);
  };

  // ドラッグ中
  var mouseMove = function (e) {
    // ドラッグ終了（現在）位置
    //var posX = parseInt(e.clientX - canvas.offsetLeft);
    //var posY = parseInt(e.clientY - canvas.offsetTop);

    //var posX = parseInt(e.layerX - canvas.offsetLeft);
    //var posY = parseInt(e.layerY - canvas.offsetTop);

    var rect = e.target.getBoundingClientRect();
    var posX = Math.round(
      (canvas.width * (e.clientX - rect.left)) / canvas.clientWidth
    );
    var posY = Math.round(
      (canvas.height * (e.clientY - rect.top)) / canvas.clientHeight
    );

    if (isDragging) {
      // canvas内を一旦クリア
      context.clearRect(0, 0, canvas.width, canvas.height);

      var x = 0;
      var y = 0;
      var w = srcimages[1].drawWidth;
      var h = srcimages[1].drawHeight;

      ///////////////////////////////////////////////////////
      if (dragType == 0) {
        x = posX - srcimages[1].drawWidth / 2;
        y = posY - srcimages[1].drawHeight / 2;
        //x = posX;
        //y = posY;

        //console.log("DMovX:" + x + "DMovY:" + y);
        // ドラッグが終了した時の情報を記憶
        srcimages[1].drawOffsetX = x;
        srcimages[1].drawOffsetY = y;
        w = srcimages[1].drawWidth;
        h = srcimages[1].drawHeight;
      } /////////////////////////////////////////////////////////////
      //拡大・縮小
      else if (dragType == 1) {
        x = srcimages[1].drawOffsetX;
        y = srcimages[1].drawOffsetY;

        //最大値以上は拡大しない
        if (
          MainMaxW > natuWidth * (posX / WidthX) ||
          MainMaxH > natuHeight * (posX / WidthX)
        ) {
          w = natuWidth * (posX / WidthX);
          h = natuHeight * (posX / WidthX);
        }

        srcimages[1].drawWidth = w;
        srcimages[1].drawHeight = h;
      }

      if (dragType == 2) {
        //一定の範囲以上は動かせないように
        if (posX <= PosGuideX + PosHoleW) {
          PosHoleX = PosGuideX + PosHoleW;
        } else if (posX >= PosGuideX + PosGuideW - PosHoleW) {
          PosHoleX = PosGuideX + PosGuideW - PosHoleW;
        } else {
          PosHoleX = posX;
        }

        if (posY >= PosGuideY) {
          PosHoleY = 100;
        } else {
          PosHoleY = posY;
        }
        PosHoleY = PosGuideY + PosHoleW;

        drawbg(); //背景をセット
        context.drawImage(srcimages[1], PosMainX, PosMainY, PosMainW, PosMainH); //読み込み画像をセット
        drawGuide(templateTarget); //ガイド・テンプレートをセット

        //穴位置ガイドを作成///////////////////////////////////////////////////////
        context.beginPath();
        context.fillStyle = "rgba(0, 176, 80,0.2)";
        context.fillRect(PosGuideX, PosGuideY, PosGuideW, PosHoleH * 2);
        context.stroke();
        context.restore();
        context.save();
        /////////////////////////////////////////////////////////////////////////////
      } else {
        PosMainX = x;
        PosMainY = y;
        PosMainW = w;
        PosMainH = h;

        drawbg(); //背景をセット
        context.drawImage(srcimages[1], x, y, w, h); // 画像を描画
        drawGuide(templateTarget); //ガイド・テンプレートをセット
      }
    }
  };

  function drawbg() {
    context.beginPath();
    /* パターンを生成 */
    var ptn = context.createPattern(bgimage, "");
    /* fillStyleにパターンをセット */
    context.fillStyle = ptn;
    context.fillRect(0, 0, cnvW, cnvH);
    context.restore();
    context.save();
  }

  function widthchange(e) {
    var target = e.target;
    var is = target.value / 100;
    drawScreen();

    function drawScreen() {
      //console.log(is)
      var ix = srcimages[0].drawWidth * is;
      var iy = srcimages[0].drawHeight * is;
      console.log(srcimages[1].drawOffsetX);
      console.log(srcimages[1].drawOffsetY);
      x = srcimages[1].drawOffsetX;
      y = srcimages[1].drawOffsetY;

      context.clearRect(0, 0, canvas.width, canvas.height);
      context.drawImage(srcimages[1], x, y, ix, iy);

      drawGuide(templateTarget);

      srcimages[1].drawWidth = ix;
      srcimages[1].drawHeight = iy;

      PosMainX = x;
      PosMainY = y;
      PosMainW = ix;
      PosMainH = iy;
    }
  }

  // canvasにイベント登録
  canvas.addEventListener(
    "mousedown",
    function (e) {
      mouseDown(e);
    },
    false
  );
  canvas.addEventListener(
    "mousemove",
    function (e) {
      mouseMove(e);
    },
    false
  );
  canvas.addEventListener(
    "mouseup",
    function (e) {
      mouseUp(e);
    },
    false
  );
  canvas.addEventListener(
    "mouseout",
    function (e) {
      mouseOut(e);
    },
    false
  );
  var formelement = document.getElementById("canvsWidth");
  //formelement.addEventListener('input',  widthchange,  false);//拡大縮小のボリュームを使用する場合は有効

  //グッズ変更処理/////////////////////////////////////////////////////////////////////////////
  $('input[name="myskintype"]:radio').change(function () {
    $("ul.child").slideUp("fast");
    var skintype = $(this).val();

    context.clearRect(0, 0, canvas.width, canvas.height);
    context.restore();
    context.save();

    templateTarget = skintype;

    drawbg(); //背景をセット

    //context.drawImage(tmplimages[skintype], 150, 150, 300, 300);
    if (PosMainW != 0 && PosMainY != 0) {
      context.drawImage(srcimages[0], PosMainX, PosMainY, PosMainW, PosMainH);
    }

    drawGuide(templateTarget); //ガイドを作成
  });

  //ガイド作成モジュール/////////////////////////////////////////////////////////////////////
  function drawGuide(templateTarget) {
    context.restore();

    context.beginPath();
    context.strokeStyle = "rgb(60, 60, 255)";
    context.rect(PosMainX, PosMainY, PosMainW, PosMainH);
    context.stroke();
    context.restore();
    context.save();

    if (PosMainW != 0 && PosMainY != 0) {
      context.beginPath();
      context.fillStyle = "rgb(0, 0, 0)";
      context.arc(
        PosMainX + PosMainW,
        PosMainY + PosMainH,
        15,
        0,
        Math.PI * 2,
        true
      );
      context.fill();
      context.restore();
      context.save();
    }

    if (templateTarget != 6) {
      context.drawImage(
        tmplimages[templateTarget],
        TmpImgX,
        TmpImgY,
        TmpImgW,
        TmpImgH
      );
    } else {
      context.beginPath();
      context.strokeStyle = "rgb(192, 80, 77)"; // 赤
      context.rect(PosGuideX, PosGuideY, PosGuideW, PosGuideH);
      context.stroke();
      context.restore();
      context.save();

      //context.save();
      context.beginPath();
      context.fillStyle = "rgb(200, 200, 200)";
      //context.arc(300,125,35,0,Math.PI*2,true);
      context.arc(PosHoleX, PosHoleY, PosHoleW, 0, Math.PI * 2, true);
      context.stroke();
      context.restore();
      context.save();

      //context.save();
      //context.globalCompositeOperation = 'xor';
      context.beginPath();
      context.fillStyle = "rgb(200, 200, 200)";
      //context.arc(300,125,15,0,Math.PI*2,true);
      context.arc(PosHoleX, PosHoleY, PosHoleW / 2, 0, Math.PI * 2, true);
      context.stroke();
      context.restore();
      context.save();
    }
  }
})();
