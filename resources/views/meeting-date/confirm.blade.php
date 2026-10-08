@extends('layouts.product')

@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="大阪,東京,営業,訪問,打ち合わせ">
    <meta name="description" content="営業担当呼び出しフォームの入力内容確認">
    <meta name="robots" content="noindex,nofollow">
    <title>入力内容確認｜営業担当呼び出しフォーム</title>
    @include('partials.legacy-head-products')
    <link rel="stylesheet" href="{{ asset('css/meeting_date_2nd.css') }}" type="text/css">
    <style>
        #content_wrapper .meeting-date-confirm {
            width: 100%;
        }

        .meeting-date-confirm .meeting-date-confirm-copy {
            width: 100%;
        }

        .meeting-date-confirm .meeting-date-confirm-copy p {
            margin: 0;
        }

        .meeting-date-confirm .tableAllContact,
        .meeting-date-confirm .TableAllL {
            max-width: 100%;
            box-sizing: border-box;
        }

        @media screen and (max-width: 768px) {
            .meeting-date-confirm .textMeetingDate02 {
                background-size: 100% 100%;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $form = is_array($form ?? null) ? $form : [];
        $displayDate = static function (mixed $value): string {
            $value = (string) $value;

            return preg_replace('/^(\d{4})-(\d{2})-(\d{2})$/', '$1/$2/$3', $value) ?: $value;
        };
    @endphp

    <div class="meeting-date-confirm">
        <div class="titleMeeting">&nbsp;</div>
        <div style="clear: both;">&nbsp;</div>
        <div class="meeting-date-confirm-copy">
            <p>
                <span class="red">東京23区、川崎市、横浜市の法人のお客様（学校PTAや個人事業主様でもOKです）をご訪問させて頂きます。</span>
                <br><br>
                当社では担当の営業マンが直接製品やサービスのご提案・ご説明をさせて頂けます。WEBサイトだけではなかなかイメージが掴めない。
                価格も含めて相談したい。このような ご要望がございましたら是非お声掛け下さい。
                営業担当が実際にサンプル品をもって御社にお伺いし詳しく説明させて頂きます。
                ご希望のお客様はお手数ですが、バナーをクリックして頂き必要事項をご入力ください。
                お伺いできるエリアは東京23区、川崎市、横浜市の法人のお客様（学校PTAや個人事業主様でもOKです）が対象となります。 <span class="red">対象エリア外のお客様はまずご相談下さい。</span>
                事情によりお伺いできない場合もございますので、ご了承ください。
                <br><br>
                フォームの必要事項の入力をお願いします。 <span class="red">特に製品のご利用予定日が2週間未満の場合、フォームではなく直接お電話頂いた方が良いです。</span>
                ご検討中の製品、数量、ご希望のご納期など、お分かりになる範囲で結構ですのでできるだけ詳細に記載して頂くとより良いご案内が可能です。
                2営業日経っても営業担当よりご連絡が無い場合、何らかの不具合が発生している可能性がございますので、恐れ入りますがお電話でのご連絡をお願い致します。
            </p>
        </div>
        <div style="clear: both;">&nbsp;</div>
        <div class="SubtitleMeeting">&nbsp;</div>

        <div class="tableAllContact">
            <form action="{{ route('meeting-date.complete') }}" method="post" name="form" id="meeting-date-confirm-form">
                @csrf
                <div class="textMeetingDate02">&nbsp;</div>
                <div class="subMenu1"></div>

                <table class="TableAllL">
                    <tbody>
                        @if (filled($form['cont_type'] ?? null))
                            <tr>
                                <td class="TableLeft">お打ち合わせ方法</td>
                                <td class="TableRightGray">{{ $form['cont_type'] }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="TableLeft">会社名</td>
                            <td class="TableRightGray">{{ $form['Company_Name'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="TableLeft">ご担当者様</td>
                            <td class="TableRightGray">{{ $form['person_name'] ?? '' }}</td>
                        </tr>
                        @if (array_key_exists('department', $form))
                            <tr>
                                <td class="TableLeft">ご担当者部署名</td>
                                <td class="TableRightGray">{{ $form['department'] ?? '' }}</td>
                            </tr>
                        @endif
                        @if (($form['cont_type'] ?? '') === 'ご訪問')
                            <tr>
                                <td class="TableLeft">郵便番号</td>
                                <td class="TableRightGray">{{ $form['zip'] ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="TableLeft">都道府県</td>
                                <td class="TableRightGray">{{ $form['prefc'] ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="TableLeft">以降の住所</td>
                                <td class="TableRightGray">{{ $form['address'] ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="TableLeft">番地、建物名、部屋番号</td>
                                <td class="TableRightGray">{{ $form['address_street'] ?? '' }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="TableLeft">ご連絡先電話番号</td>
                            <td class="TableRightGray">{{ $form['phone_number'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="TableLeft">E-mail</td>
                            <td class="TableRightGray">{{ $form['email'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="TableLeft">E-mail（確認）</td>
                            <td class="TableRightGray">{{ $form['email_confirm'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="TableLeft">ご希望製品</td>
                            <td class="TableRightGray">{{ $form['expected_product'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="TableLeft">予定数量</td>
                            <td class="TableRightGray">{{ $form['qty'] ?? '' }} 個</td>
                        </tr>
                        <tr>
                            <td class="TableLeft">ご希望単価</td>
                            <td class="TableRightGray">{{ $form['expected_price'] ?? '' }}&nbsp;円</td>
                        </tr>
                        <tr aria-hidden="true"></tr>
                        <tr>
                            <td class="TableLeft">製品ご利用予定日(納期)</td>
                            <td class="TableRightGray">{{ $displayDate($form['expected_delivery_date'] ?? '') }}</td>
                        </tr>
                        <tr>
                            <td class="TableLeft">ご希望日時<br>（第一希望）</td>
                            <td valign="top" class="TableRightGray">{{ $displayDate($form['visit_date_1'] ?? '') }}&nbsp;&nbsp;{{ $form['visit_time_1'] ?? '' }} 時</td>
                        </tr>
                        <tr>
                            <td valign="top" class="TableLeft">ご希望日時<br>（第二希望)</td>
                            <td valign="top" class="TableRightGray">{{ $displayDate($form['visit_date_2'] ?? '') }}&nbsp;&nbsp;{{ $form['visit_time_2'] ?? '' }} 時</td>
                        </tr>
                    </tbody>
                </table>

                <div class="subMenu2"></div>
                <table class="TableAllL">
                    <tbody>
                        <tr>
                            <td class="TableLeft">お問い合わせ・ご連絡<br>その他特記事項があれば<br>ご記入ください。</td>
                            <td class="TableRightGray">{{ $form['contactDetail'] ?? '' }}&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <div class="textContactCenter">
                    <input type="button" name="cmdMod" value="戻る" class="text_12" onclick="window.location.href='{{ route('meeting-date.index', ['mode' => 'MODE_MOD']) }}'" style="padding: 5px">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" name="cmdComp" value="送信" class="text_12" style="padding: 5px">
                </div>
                <br>
            </form>
        </div>
    </div>
@endsection
