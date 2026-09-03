/* <SCRIPT language="JavaScript" src="common.js"></SCRIPT>								Version 1.1
 ===================================================================================================
 * 
 * 画面共通のJavaScriptファイルです。
 * 
 * -Function List-
 * comOpen					新規ウィンドウを開く
 * comSubmit				サブミットを行う
 * comPdfOpen				ＰＤＦファイルを開く
 * comLogout				ログアウト処理
 * comFocusCtl				コントロールにフォーカスをあてる
 * delConfirm				削除確認用ダイアログを表示
 * getNowDate				現在時刻を取得する
 *
 ===================================================================================================
 */
var COM_SUBMIT_FLG = false;
var COMPATMODE_CSS1 = 'CSS1Compat'  // 標準モード
var COMPATMODE_BACK = 'BackCompat'  // 互換モード

/***************************************************************************************************
 * [機能]	comSubmit関数によるサブミットが行われているかどうかを判定しているフラグをOFFにする
 * [備考]	Excelテンプレートのダウンロードのように、サブミットするが画面を再描写しないような場合に、
 * 			検索子画面の表示などの別ウィンドを開く処理がロックされてしまうので、
 * 			この関数を使用して、適切なタイミングでロックをはずしてください。
 ***************************************************************************************************/
function comJsSubmitFlgOff() {
	COM_INPUT_TYPE = false;
}

/***************************************************************************************************
 * [機能]	新規ウィンドウを開く
 * [引数]	sUrl	行き先のURL
 * [引数]	sName	新規に開くウィンドウの名前
 ***************************************************************************************************/
function comOpen( sUrl, sName) {
var loWin;
    if ( !COM_SUBMIT_FLG ) {
	    loWin = window.open(sUrl, sName, 'width=1014,height=683,top=0,left=0,resizable=yes,scrollbars=yes,status=yes');
	    loWin.focus();
    }
}

/***************************************************************************************************
 * [機能]	サブミットを行う
 * 			※第三引数のフォームオブジェクトがなければ自動的にdocument.formを送る。
 * [引数]	sCommand	コマンド
 * [引数]	sTarget		ターゲット
 * [引数]	objForm		フォーム
 * [戻値]	なし
 ***************************************************************************************************/
function comSubmit( sCommand, sTarget, objForm ){
var objLcForm;
    if ( !COM_SUBMIT_FLG ) {
	    COM_SUBMIT_FLG = true;
	    if ( objForm ) {
		    objLcForm = objForm;
	    } else {
		    objLcForm = document.form;
	    }
		
	    objLcForm.action = sCommand;
	    objLcForm.target = sTarget;
	    objLcForm.submit();
    }
}

/***************************************************************************************************
 * [機能]	ＰＤＦファイルを開く
 *       	※第三引数のウィンドウの名前がなければ自動的に'print'を送る。
 * [引数]	sUrl	PDFファイルのURL
 * [引数]	sName	新規に開くウィンドウの名前
 ***************************************************************************************************/
function comPdfOpen( sUrl, sName) {
var sWindowName;
	if ( sName ) {
		sWindowName = sName;
	} else {
		sWindowName = '';
	}

	window.open(sUrl, sWindowName, 'width=1014,height=683,top=0,left=0,resizable=yes,scrollbars=no,status=yes');
}

/***************************************************************************************************
 * [機能]	ログアウト処理
 ***************************************************************************************************/
function comLogout() {
	if (!confirm('ログアウトします。よろしいですか？')) return false;
	comSubmit('C010_ログイン.html', '_top');
}

/***************************************************************************************************
 * [機能]	コントロールにフォーカスをあてる
 ***************************************************************************************************/
function comFocusCtl(id) {
	var ctl = document.getElementById(id);
	if (!ctl) { return; }
		
	// 画面スクロール
	var winmidpt = document.body.offsetHeight ;
	var ctlpt = getTop(ctl)
	if (ctlpt > winmidpt) { scrollTo(0,ctlpt- ( winmidpt / 2 )) ; }
	
	// フォーカス設定
	if ( ctl.type == 'text' ) {
		if ( !ctl.readOnly ) { ctl.focus(); return; }
	} else {
		if ( !ctl.disabled ) { ctl.focus(); return; }
	}
	
	return;
	
	//////////////////////////////////////////////////////////////////////////////
	// コントロールのスクロール値を取得する（プライベート関数）
 	//////////////////////////////////////////////////////////////////////////////
    function getTop(ctl) {
	    if (ctl.nodeName == 'BODY') { return 0 ; }
	    return ctl.offsetTop + getTop(ctl.offsetParent) ;
    }
}

/***************************************************************************************************
 * [機能]	削除確認
 ***************************************************************************************************/
function delConfirm(submitStr, nameStr) {
	
	if (!confirm(nameStr + 'を削除します。よろしいですか？')) return false;
	comSubmit(submitStr, '_top');
	
}	

/***************************************************************************************************
 * [機能]	現在時刻を取得する
 ***************************************************************************************************/
function getNowDate(vsCtlId) {
	
	getDate    = new Date();
	nowYear    = getDate.getFullYear();
	nowMonth   = getDate.getMonth() + 1;
	nowDate    = getDate.getDate();
	nowHours   = getDate.getHours();
	nowMinutes = getDate.getMinutes();
	nowSeconds = getDate.getUTCSeconds();

	// 日付のフォーマットを行う
	if (nowMonth < 10) { nowMonth = "0" + nowMonth; }
	if (nowDate < 10) { nowDate = "0" + nowDate; }
	if (nowHours < 10) { nowHours = "0" + nowHours; }
	if (nowMinutes < 10) { nowMinutes = "0" + nowMinutes; }
	if (nowSeconds < 10) { nowSeconds = "0" + nowSeconds; }

	nowgetdate = nowYear +  "/" + nowMonth + "/" + nowDate + " " + nowHours + ":" + nowMinutes + ":" + nowSeconds;
	document.getElementById(vsCtlId).value = nowgetdate;
}

