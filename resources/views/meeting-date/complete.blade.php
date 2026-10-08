@extends('layouts.product')

@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="問い合わせ先,無料サンプル,ラバーストラップ,ラバーキーホルダー,ラバーコースター">
    <meta name="description" content="ノベルティーグッズ、同人グッズ製作(作成)に関する質問を受付中。納期、価格、作り方、製作可否等ご相談ください。お急ぎの場合お電話ください。">
    <meta name="robots" content="index,follow">
    <title>ノベルティー営業担当呼び出しフォーム</title>
    @include('partials.legacy-head-products')
    <link rel="stylesheet" href="{{ asset('css/meeting_date_2nd.css') }}" type="text/css">
    <style>
        #content_wrapper .meeting-date-complete {
            width: 100%;
        }

        .meeting-date-complete .meeting-date-complete-copy {
            width: 100%;
        }

        .meeting-date-complete .meeting-date-complete-copy p {
            margin: 0;
        }

        .meeting-date-complete .meeting-date-complete-alert {
            width: 100%;
            max-width: 771px;
            margin: 10px auto;
            color: #a40000;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="meeting-date-complete">
        <div class="titleMeeting">&nbsp;</div>
        <div style="clear: both;">&nbsp;</div>
        <div class="meeting-date-complete-copy">
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
            <div class="textMeetingDate03">&nbsp;</div>
            <br clear="all">
            <br clear="all">
            <p class="textContactCenter">
                ご依頼を受付ました。ありがとうございます。ご入力頂きましたメールアドレスに確認のメールをお送りしております。
                追って営業担当よりご連絡させて頂きます。
            </p>

            @if (filled($mailError ?? null))
                <p class="meeting-date-complete-alert">{{ $mailError }}</p>
            @endif
        </div>
    </div>
@endsection
