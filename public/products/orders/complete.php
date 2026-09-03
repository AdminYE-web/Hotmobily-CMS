<?php
ini_set("session.bug_compat_warn", 0);
include_once('common/Const.php');
//Read Modules
require_once('control/Control_Quotation.php');
?>
<?php
//Start Session
session_start();

/*******************
  Unit Test
  Type: phpmailer class
 ********************/
//ライブラリ読み込み
require '../../lib/phpmailer7/src/Exception.php';
require '../../lib/phpmailer7/src/PHPMailer.php';

use PaygentModule\System\PaygentB2BModule;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require('control/Control_Contact.php');
//require('../order/color_const.php');
//error_reporting(E_ALL);

$today = date("YmdHisB");

//Read Modules
// POSTリクエストを取得
$mrFormData = $_SESSION;
foreach ($mrFormData as $k => $v) {
	$_POST["$k"] = $_SESSION["$v"];
	$$k = $v;
}

switch ($cstKBN) {
	case "Corp":
		$cstKBNs = "法人のお客様";
		break;
	case "Personal":
		$cstKBNs = "個人のお客様";
		break;
}

$path_load_file = array();
if (!empty($_SESSION['filename'])) {
	$lastpointer = end(array_keys($_SESSION['filename']));
	for ($i = 0; $i <= $lastpointer; $i++) {
		if ($_SESSION["filename"][$i]) {
			array_push($path_load_file, $_SESSION["filename"][$i]);
		}
	}
}
$path_load_file1 = array();
if (!empty($_SESSION['tmpfile'])) {
	$lastpointer1 = end(array_keys($_SESSION['tmpfile']));
	for ($y = 0; $y <= $lastpointer1; $y++) {
		if ($_SESSION["tmpfile"][$y]) {
			array_push($path_load_file1, $_SESSION["tmpfile"][$y]);
		}
	}
}
switch ($ItemType) {
	case 'target':
		$ItemType = 'ゴルフターゲットカップ';
		switch ($carabiner) {
			case "0":
				$carabiner_text = 'なし';
				break;
			case "1":
				$carabiner_text = $carabiner_type;
				break;
		}
		switch ($carabiner_print) {
			case "0":
				$carabiner_print = '刻印なし';
				break;
			case "1":
				$carabiner_print = '刻印あり（表）';
				break;
			case "2":
				$carabiner_print = '刻印あり（表+裏）';
				break;
		}
		break;
	case 'phone_stand':
		$ItemType = 'ラバースマートフォンスタンド';
		break;
	case 'rubber_strap':
		$ItemType = 'ラバーストラップ';
		break;
	case 'rubber_keyholder':
		$ItemType = 'ラバーキーホルダー';
		break;
}
switch ($ItemQA) {
	case "standard":
		$ItemQA = 'スタンダード';
		break;
	case "premium":
		$ItemQA = 'プレミアム';
		break;
	default:
		$ItemQA = '';
		break;
}
switch ($example) {
	case "1":
		$example = '不要';
		break;
	case "2":
		$example = '必要';
		break;
	default:
		$example = '';
		break;
}
switch ($DeFormat) {
	case "ai_file":
		$DeFormat = 'イラストレータファイル';
		break;
	case "other_file":
		$DeFormat = 'その他';
		break;
	default:
		$DeFormat = '';
		break;
}
switch ($Screen) {
	case "no_screen":
		$Screen = 'シルク印刷なし';
		break;
	case "screen":
		$Screen = 'シルク印刷あり';
		break;
	default:
		$Screen = '';
		break;
}
//メール本文の組み立て
$vsBodytextOder = "";
$vsBodytextOder = <<<HTML

<div style="width:550px; font-size:12px; line-height:150%; color: #CC0000; font-weight:bold; font-family:"MS PGothic","Verdana","OSAKA" ;">
	$Name_S $Name_F この度はホットモバイリーのショッピングサイトのご利用誠にありがとうございます。 $Itemtypeの製作開始までにお願いしたい事項がございます。大変お手数ですが、下記内容をご一読頂きますようお願い致します。
</div>
<div style="width:550px; font-size:12px; line-height:150%; color: #666666; font-family:"MS PGothic","Verdana" ;">

        <br/>
	<b>1．ご注文内容のご確認</b><br/>
	本メールには、お客様にご入力頂いたご注文内容が記載されております。大変お手数ですが、いま一度ご注文内容に誤りがないかどうかご確認下さい。 万が一、ご注文内容に誤りがある場合、出来るだけ早く本電子メール（contact@hotmobily.jp）に返信する形で正しいご注文内容をお知らせ下さい。
        <br/><br/>

	<b>2．ソフトラバー製品のデザインのご入稿</b><br/>
	ソフトラバー製品のデザインをご入稿下さい。デザインの送付先は、contact@hotmobily.jpになります。
        <br/><br/>

	<b>3．製作料金のお振込み</b><br/>
        本メールの振込み先銀行口座に、注文合計金額にあります金額をお振込み下さい。
        <br/><br/>

        <b>4．製品の製作開始</b><br/>
        製品の製作開始は次の条件が完了した時点からとなります。<br/>
        &nbsp;&nbsp;&nbsp;&nbsp;a)上記２．の製品のデザインに問題がないことを、お客様、弊社の両方が確認が完了していること。<br/>
        &nbsp;&nbsp;&nbsp;&nbsp;b)上記３．の製品の製作料金のお振込みが弊社にて確認できていること。<br/>
        製品の製作開始の際には、電子メール にてご登録の電子メールアドレス宛てに、その旨をご連絡させて頂きます。
        <br/><br/>

	<table border="0" style=" background-color: #CC0000; text-align:left; width:550px; border:1px; color: #ffffff; font-size:14px;  font-weight:bold; height:25px; line-height:150%; font-family:"MS PGothic","Verdana","OSAKA" ;" >
	  <tr>
	    <td style="padding-left:10px; "><b>ご注文内容詳細</b></td>
	  </tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" style="background-color:#F3F3F3; text-align:left; width:550px; border:1px; font-family:"MS PGothic","Verdana","OSAKA" ;" >
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">No.</td>
	    <td colspan=2 style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"> ODR_HM_&nbsp;$today</td>
	  </tr>
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">ご注文商品</td>
	    <td colspan=2 style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"> $ItemType </td>
	  </tr>
HTML;

if ($ItemType == "ゴルフターゲットカップ") {
	$vsBodytextOder .= <<<HTML
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">カラビナ</td>
	    <td colspan=2 style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"> $carabiner_text </td>
	  </tr>
	  <tr>
	    <td style=" padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">カラビナレーザー刻印</td>
	    <td colspan=2 style=" padding-left:10px;width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"> $carabiner_print</td>
	  </tr>
HTML;
} else if ($ItemType == "ラバースマートフォンスタンド") {
	$vsBodytextOder .= <<<HTML
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">スタンドのサイズ</td>
	    <td colspan=2 style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"> $ItemSize </td>
	  </tr>
HTML;
}
if ($ItemType != "ラバーストラップ" && $ItemType != "ラバーキーホルダー") {
	$vsBodytextOder .= <<<HTML
	  <tr>
	    <td style=" padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">ご注文タイプ</td>
	    <td colspan=2 style=" padding-left:10px;width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"> $ItemQA</td>
	  </tr>
	  <tr>
	    <td style=" padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">実物校正サンプル</td>
	    <td colspan=2 style=" padding-left:10px;width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"> $example</td>
	  </tr>
	  <tr>
	    <td style=" padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">ご入稿ファイル形式</td>
	    <td colspan=2 style=" padding-left:10px;width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"> $DeFormat</td>
	  </tr>
	  <tr>
	    <td style=" padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">裏面シルク印刷</td>
	    <td colspan=2 style=" padding-left:10px;width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"> $Screen</td>
	  </tr>

	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">ご注文本数</td>
	    <td colspan=2 style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$numberOf 本</td>
	  </tr>

	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">ターゲットカップ代金</td>
	    <td style="padding-left:10px; width:80px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; text-align:right;">$pricefield7 円</td>
        <td style="padding-left:10px; width:320px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"></td>
	  </tr>
HTML;
} else {
	$vsBodytextOder .= <<<HTML

	  <tr>
	  	<td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">ご注文本数</td>
	    <td style="padding-left:10px; width:80px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; text-align:right;">$qty 本</td>
        <td style="padding-left:10px; width:320px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"></td>
	  </tr>

	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">$ItemType代金</td>
	    <td style="padding-left:10px; width:80px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; text-align:right;">$totalprice 円</td>
        <td style="padding-left:10px; width:320px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"></td>
	  </tr>
	</table>
HTML;
}
if ($ItemType == "ゴルフターゲットカップ") {
	$vsBodytextOder .= <<<HTML
	 <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">カラビナ</td>
	    <td style="padding-left:10px; width:80px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; text-align:right;">$pricefield7_n1 円</td>
        <td style="padding-left:10px; width:320px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"></td>
	  </tr>
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">カラビナ刻印代金</td>
	    <td style="padding-left:10px; width:80px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; text-align:right;">$pricefield7_n2 円</td>
        <td style="padding-left:10px; width:320px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"></td>
	  </tr>
HTML;
}
if ($ItemType != "ラバーストラップ" && $ItemType != "ラバーキーホルダー") {
	$vsBodytextOder .= <<<HTML
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">実物校正サンプル</td>
	    <td style="padding-left:10px; width:80px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; text-align:right;">$pricefield8 円</td>
        <td style="padding-left:10px; width:320px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"></td>
	  </tr>
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">トレース代金</td>
	    <td style="padding-left:10px; width:80px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; text-align:right;">$pricefield9 円</td>
        <td style="padding-left:10px; width:320px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"></td>
	  </tr>
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">裏面シルク印刷代金</td>
	    <td style="padding-left:10px; width:80px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; text-align:right;">$pricefield10 円</td>
        <td style="padding-left:10px; width:320px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"></td>
	  </tr>
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">小計(税込)</td>
	    <td style="padding-left:10px; width:80px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; text-align:right;">$pricefield11 円</td>
        <td style="padding-left:10px; width:320px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"></td>
	  </tr>
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">お値引き</td>
	    <td style="padding-left:10px; width:80px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; text-align:right;">$pricefield12 円</td>
        <td style="padding-left:10px; width:320px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"></td>
	  </tr>
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">合計(税込)</td>
	    <td style="padding-left:10px; width:80px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; text-align:right;">$pricefield13 円</td>
        <td style="padding-left:10px; width:320px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;"></td>
	  </tr>

	</table>
HTML;
}
$vsBodytextOder .= <<<HTML
	<!-- image -->
		<table border="0" style=" background-color: #CC0000; text-align:left; width:550px; border:1px; color: #ffffff; font-size:14px;  font-weight:bold; height:25px; line-height:150%; font-family:"MS PGothic","Verdana","OSAKA" ;" >
	  <tr>
	    <td style="padding-left:10px; "><b>ご入稿デザイン</b></td>
	  </tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" style="background-color:#F3F3F3; text-align:left; width:550px; border:1px; font-family:"MS PGothic","Verdana","OSAKA" ;" >
HTML;

$arrlength = count($path_load_file);
if ($arrlength > 0) {
	for ($x = 0; $x < $arrlength; $x++) {
		$vsBodytextOder .= <<<HTML
			<tr>
			    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">お客様ご入稿データ</td>
			    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$path_load_file1[$x]</td>
			</tr>
	 		<tr>
			    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">ご入稿デザイン番号</td>
			    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$path_load_file[$x]</td>
			</tr>
HTML;
	}
} else {
	$vsBodytextOder .= <<<HTML
			<tr>
					<td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">お客様ご入稿データ</td>
					<td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">-</td>
			</tr>
	 		<tr>
			    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">ご入稿デザイン番号</td>
			    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">-</td>
			</tr>
HTML;
}


$vsBodytextOder .= <<<HTML
	</table>
	<!-- end image-->
	<table border="0" style=" background-color: #CC0000; text-align:left; width:550px; border:1px; color: #ffffff; font-size:14px;  font-weight:bold; height:25px; line-height:150%; font-family:"MS PGothic","Verdana","OSAKA" ;" >
	  <tr>
	    <td style="padding-left:10px; "><b>お客様情報</b></td>
	  </tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" style="background-color:#F3F3F3; text-align:left; width:550px; border:1px; font-family:"MS PGothic","Verdana","OSAKA" ;" >
	 <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">お客様区分</td>
	    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$cstKBNs</td>
	  </tr>
	  <tr>
	    <td style=" padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">お客様氏名　</td>
	    <td style=" padding-left:10px;width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$Name_S $Name_F</td>
	  </tr>
	  <tr>
	    <td style=" padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">お客様氏名<br />（フリガナ）</td>
	    <td style=" padding-left:10px;width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$Name_S_K $Name_F_K</td>
	  </tr>
	  <tr>
	    <td style=" padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">お客様法人名</td>
	    <td style=" padding-left:10px;width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$Corp_Name</td>
	  </tr>
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">お客様法人名<br />（フリガナ）</td>
	    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$Corp_Name_K</td>
	  </tr>
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">お客様メールアドレス</td>
	    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$email</td>
	  </tr>
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">お客様部署名　</td>
	    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$dev</td>
	  </tr>
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">電話番号</td>
	    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$tel</td>
	  </tr>
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">ファックス番号</td>
	    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$fax</td>
	  </tr>
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">郵便番号</td>
	    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$zip</td>
	  </tr>
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">都道府県　</td>
	    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$prefc</td>
	  </tr>
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">以降の住所</td>
	    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$address </td>
	  </tr>
		<tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">番地、建物名、部屋番号</td>
	    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$address_street </td>
	  </tr>
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">商品送付先</td>
	    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$sndKBN </td>
	  </tr>
HTML;
if ($sndKBN == "下記住所へ送付する") {
	$vsBodytextOder .= <<<HTML
<!--
--><tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">郵便番号</td>
	    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$zip2</td>
	  </tr>
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">都道府県</td>
	    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$prefc2</td>
	  </tr>
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">以降の住所 </td>
	    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$address2</td>
	  </tr>
		<tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">番地、建物名、部屋番号 </td>
	    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$address_street2</td>
	  </tr><!--
-->
HTML;
}
$vsBodytextOder .= <<<HTML
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">その他備考（問い合わせ）</td>
	    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$contactDetail</td>
	  </tr>
	  <tr>
	    <td style="padding-left:10px; width:130px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; ">お支払い情報</td>
	    <td style="padding-left:10px; width:400px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF;">$payment</td>
	  </tr>
	</table>
	<br />
		 <table border="0" style=" background-color: #CC0000; text-align:left; width:550px; border:1px; color: #ffffff; font-size:14px;  font-weight:bold; height:25px; line-height:150%; padding-left:10px; font-family:"MS PGothic","Verdana","OSAKA" ;" >
  	<tr>
    	<td style="padding-left:10px;"><b>振込先銀行口座</b></td>
 		</tr>
 </table>
 	<!-- Bank -->
	<table border="0" cellpadding="0" cellspacing="0" style="background-color:#F3F3F3; text-align:left; width:550px; border:1px; font-size:12px; font-family:"MS PGothic","Verdana" ;" >
	    <tr>
	      <td colspan="2" style="width:470px; background-color: #F3F3F3; padding-left:10px;font-size:12px;">■■■■■■■■■■■■■■■■■■■■■■■■■■■</td>
	    </tr>
	    <tr>
	      <td style="width:170px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; padding-left:10px; font-size:12px;" >銀行名</td>
	      <td style="width:270px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; padding-left:10px;font-size:12px;">三菱UFJ銀行</td>
	    </tr>
	    <tr>
	      <td style="width:170px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; padding-left:10px;font-size:12px;" >口座名義</td>
	      <td style="width:270px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; padding-left:10px;font-size:12px;">ユーアンドアースカブシキガイシャ</td>
	    </tr>
	    <tr>
	      <td style="width:170px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; padding-left:10px;font-size:12px;">店番</td>
	      <td style="width:270px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; padding-left:10px;font-size:12px;">119</td>
	    </tr>
	    <tr>
	      <td style="width:170px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; padding-left:10px;font-size:12px;">支店</td>
	      <td style="width:270px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; padding-left:10px;font-size:12px;">長原支店</td>
	    </tr>
		 <tr>
	      <td style="width:170px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; padding-left:10px;font-size:12px;">口座番号</td>
	      <td style="width:270px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; padding-left:10px;font-size:12px;">1103739 (普通)</td>
	    </tr>
	    <!--/////////////////////////////////// new-->
	    <tr>
	      <td colspan="2" style="width:470px; background-color: #F3F3F3; padding-left:10px;font-size:12px;">■■■■■■■■■■■■■■■■■■■■■■■■■■■</td>
	    </tr>
	    <tr>
	      <td style="width:170px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; padding-left:10px; font-size:12px;" >銀行名</td>
	      <td style="width:270px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; padding-left:10px; font-size:12px;">PayPay銀行</td>
	    </tr>
	    <tr>
	      <td style="width:170px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; padding-left:10px;font-size:12px;" >口座名義</td>
	      <td style="width:270px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; padding-left:10px; font-size:12px;">ユーアンドアース（カ）ホットストラップ</td>
	    </tr>
	    <tr>
	      <td style="width:170px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; padding-left:10px;font-size:12px;">店番</td>
	      <td style="width:270px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; padding-left:10px; font-size:12px;">002</td>
	    </tr>
	    <tr>
	      <td style="width:170px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; padding-left:10px;font-size:12px;">支店</td>
	      <td style="width:270px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; padding-left:10px; font-size:12px;">すずめ支店</td>
	    </tr>
		 <tr>
	      <td style="width:170px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; padding-left:10px;font-size:12px;">口座番号</td>
	      <td style="width:270px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; padding-left:10px; font-size:12px;">6070134 (普通)</td>
	    </tr>
	    <tr>
	      <td colspan="2" style="width:470px; background-color: #F3F3F3; padding-left:10px;font-size:12px;">■■■■■■■■■■■■■■■■■■■■■■■■■■■</td>
	    </tr>
	    <tr>
	      <td style="width:170px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; padding-left:10px; font-size:12px;" >銀行名</td>
	      <td style="width:270px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; padding-left:10px; font-size:12px;">ゆうちょ銀行</td>
	    </tr>
	    <tr>
	      <td style="width:170px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; padding-left:10px; font-size:12px;" >店名</td>
	      <td style="width:270px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; padding-left:10px; font-size:12px;">〇一八（読み ゼロイチハチ）</td>
	    </tr>
	    <tr>
	      <td style="width:170px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; padding-left:10px;font-size:12px;" >口座名義</td>
	      <td style="width:270px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; padding-left:10px; font-size:12px;">ユーアンドアース（カ）</td>
	    </tr>
	    <tr>
	      <td style="width:170px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; padding-left:10px;font-size:12px;" >記号</td>
	      <td style="width:270px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; padding-left:10px; font-size:12px;">10170</td>
	    </tr>
	    <tr>
	      <td style="width:170px;font-weight:bold; background-color: #E5E5E5;  border-bottom:1px solid #FFFFFF; padding-left:10px;font-size:12px;" >番号</td>
	      <td style="width:270px; background-color: #F3F3F3; border-bottom:1px solid #FFFFFF; padding-left:10px; font-size:12px;">87556861 (普通)</td>
	    </tr>
	    <!--/////////////////////////////////// new-->
	    <tr>
	      <td colspan="2" style="width:270px; background-color: #F3F3F3; padding-left:10px; font-size:12px;">■■■■■■■■■■■■■■■■■■■■■■■■■■■</td>
	    </tr>
	</table><!-- /Bank -->
        <br/>
HTML;

if ($ItemType != "ラバーストラップ" && $ItemType != "ラバーキーホルダー") {
	$vsBodytextOder .= <<<HTML
		<div style="width:550px; font-size:10px; line-height:120%; color: #888888; font-family:"MS PGothic","Verdana" ;">
        <b>ご注文のキャンセルに関しまして</b><br/>
        <div style="margin-left:15px;">
            ・ご注文確定前<br/>
                <div style="margin-left:15px;">
                キャンセルが可能です。ご入金が完了している場合、製作基本料金及び諸費用（デザインのトレースを行った場合はその費用）を差し引いた金額をご指定の銀行口座にご返金致します。 ご返金にかかります振込手数料はご負担下さい。又、銀行振込以外のご返金方法は行っておりません。<br/>
                </div>
            </div>
        <br/>
            <div style="margin-left:15px;">
            ・ご注文確定後 （キャンセルをご希望される場合、製品の製作作業の進捗状況によりましてご返金金額が異なります。）<br/>
                <div style="margin-left:15px;">
                ・量産開始前<br/>
                    <div style="margin-left:15px;">
                    量産開始前の場合、お振込み金額より製作基本料金、版型代金、試作品送付代金（お申し込みの場合）、デザイントレース料金（お申し込みの場合）を差し引いた。 金額をご指定の銀行口座にご返金致します。ご返金に必要な振込み手数料はご負担下さい。<br/>
                    </div>
                </div>
                <div style="margin-left:15px;">
                ・量産開始後<br/>
                    <div style="margin-left:15px;">
                    申し訳ございませんが、キャンセルをお受けできません。ご返金のご依頼に対しましても、お受けできません。<br/>
                    </div>
                </div>
            </div>
        </div>
HTML;
} else {
	$vsBodytextOder .= <<<HTML
		<div style="width:550px; font-size:10px; line-height:120%; color: #888888; font-family:"MS PGothic","Verdana" ;">
        	<b>ご注文のキャンセルに関しまして</b><br/>
			<div style="margin-left:15px;">
           	 ・本キャンペーンでのご注文のキャンセルはできません。ご注文確定後、製作を希望しない場合でもご返金はできません。<br/>
            </div>
        </div>
HTML;
}

$mail = new PHPMailer(true);
$mail->CharSet = "UTF-8";
$mail->addAddress($email);
$mail->addBCC("contact@hotmobily.jp", "HOTMOBILY ウェブサイト");
$mail->addBCC("kadota@gmail.com", "HOTMOBILY ウェブサイト");
$mail->addBCC("takemura.d@gmail.com", "HOTMOBILY ウェブサイト");
$mail->addBCC("kikuchiye@gmail.com", "HOTMOBILY ウェブサイト");
$mail->addBCC("sakata91hot@gmail.com", "HOTMOBILY ウェブサイト");
$mail->addBCC("fym.nakano@gmail.com", "HOTMOBILY ウェブサイト");

$from = "contact@hotmobily.jp";
$fromname = "HOTMOBILY ウェブサイト";
if ($ItemType != "ラバーストラップ" && $ItemType != "ラバーキーホルダー") {
	$subject = "ご注文誠にありがとうございました【" . $ItemType . "】";
} else {
	$subject = "春の創作活動応援キャンペーン【" . $ItemType . "】";
}

$mail->setFrom($from, $fromname);
$mail->Subject = $subject;
$mail->MsgHTML($vsBodytextOder);
//$mail->setAltBody($altbody);
if (isset($email) && !($email == "") && !($email == null)) {
	if (!$mail->send()) {
		gbSetLog('LV_DEBUG', "$title：送信完了");
		echo ("メールが送信できませんでした。エラー:" . $mail->getErrorMessage());
	}
}
session_unset();
session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="keywords" content="HOTMOBILY,ホットモバイリー,オリジナル,携帯ストラップ,コースター,携帯クリーナー,見積">
	<meta name="description" content="オリジナル携帯ストラップの製作販売のホットモバイリー。最低５０個から注文が可能、ノベルティグッズとしても最適です。自動見積で直ぐに値段チェックが可能！">
	<title>ご注文完了::ご注文フォーム::オリジナル携帯ストラップ製作ホットモバイリー</title>

	<?
	include_once('../../head_products.html');
	?>

	<link href="css/order_2nd.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="Shortcut icon" href="//hotmobily.jp/favicon.ico" />
	<!-- Event snippet for HM_注文 conversion page -->
	<script>
		gtag('event', 'conversion', {
			'send_to': 'AW-1036353231/zjQwCImDuAEQz_2V7gM',
			'transaction_id': ''
		});
	</script>
</head>

<body id="top">
	<!-- Google Code for HM_&#27880;&#25991; Conversion Page -->
	<script type="text/javascript">
		/* <![CDATA[ */
		var google_conversion_id = 1036353231;
		var google_conversion_language = "ja";
		var google_conversion_format = "3";
		var google_conversion_color = "ffffff";
		var google_conversion_label = "zjQwCImDuAEQz_2V7gM";
		var google_remarketing_only = false;
		/* ]]> */
	</script>
	<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
	</script>
	<noscript>
		<div style="display:inline;">
			<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1036353231/?label=zjQwCImDuAEQz_2V7gM&amp;guid=ON&amp;script=0" />
		</div>
	</noscript>

	<!-- Yahoo Code for your Conversion Page -->
	<script type="text/javascript">
		/* <![CDATA[ */
		var yahoo_conversion_id = 1000179237;
		var yahoo_conversion_label = "jm7wCPfWnVkQr-mfxwM";
		var yahoo_conversion_value = 0;
		/* ]]> */
	</script>
	<script type="text/javascript" src="http://i.yimg.jp/images/listing/tool/cv/conversion.js">
	</script>
	<noscript>
		<div style="display:inline;">
			<img height="1" width="1" style="border-style:none;" alt="" src="http://b91.yahoo.co.jp/pagead/conversion/1000179237/?value=0&amp;label=jm7wCPfWnVkQr-mfxwM&amp;guid=ON&amp;script=0&amp;disvt=true" />
		</div>
	</noscript>

	<!-- :: header start :: -->
	<?
	include_once('../../header.html');
	?>
	<!-- :: header end :: -->

	<!-- globalNavi -->
	<?
	include_once('../../gnavi.html');
	?>
	<!-- globalNavi End -->

	<!-- :: wrapper start :: -->
	<div id="wrapper">

		<!-- sidemenu-->
		<?
		include_once('../../sidenavi.html');
		?>
		<!-- sidemenu End -->

		<!-- :: content_wrapper start :: -->
		<div id="content_wrapper">

			<h2 class="titleOrder">ご注文完了：：ご注文フォーム</h2>
			<div class="tableAllOrder">
				<p class="textOrderCenter">ご注文を受付ました。ありがとうございました。</p>
			</div>
		</div>
	</div>
	<!-- :: WRAPPER end :: -->

	<!--フッター ここから-->
	<?
	include_once('../../footer.html');
	?>
	<!--フッター ここまで-->

	<!-- google script -->
	<!-- リマーケティング タグの Google コード -->
	<!--------------------------------------------------
リマーケティング タグは、個人を特定できる情報と関連付けることも、デリケートなカテゴリに属するページに設置することも許可されません。タグの設定方法については、こちらのページをご覧ください。
http://google.com/ads/remarketingsetup
--------------------------------------------------->
	<script type="text/javascript">
		/* <![CDATA[ */
		var google_conversion_id = 1036353231;
		var google_custom_params = window.google_tag_params;
		var google_remarketing_only = true;
		/* ]]> */
	</script>
	<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
	</script>
	<noscript>
		<div style="display:inline;">
			<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1036353231/?value=0&amp;guid=ON&amp;script=0" />
		</div>
	</noscript>
	<!-- /.google script -->

</body>

</html>