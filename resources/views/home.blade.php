@extends('layouts.product')

@section('head')

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="keywords" content="ノベルティ,同人グッズ,印刷,記念品,製作,販促,名入れ,激安">
    <meta name="description" content="小ロットもOKで短納期。アクリルグッズ、ラバーグッズ、アクキー、反射キーホルダー、3D立体キーホルダー、お守り、PVCケース、フライトタグ、キッチンスポンジの製作を中心に、社名やロゴが印刷できる、オリジナルグッズ、販促品を製造しております。同人や学校の記念品はもちろん大ロットの企業・官公庁や個人のお客様もご注文頂けます。">
    <meta name="robots" content="index,follow">
    <title>オリジナルグッズ・ノベルティを小ロット短納期で製作。ホットモバイリーオリジナルグッズ</title>
    <link rel="canonical" href="{{ url('/') }}">
    @include('partials.legacy-head-products')
    <link rel="stylesheet" href="{{ asset('css/tinyscrollbar_2nd.css') }}?v=1.015" type="text/css" media="screen" />
    <link href="{{ asset('reviews/css/reviews.css') }}?v=1.07" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/jquery.bxslider.css') }}">
    <style type="text/css">
        body {
          font-family:
            IwaUDGoDspPro-Th,
            'Hiragino Sans',
            'ヒラギノ角ゴシック',
            'メイリオ',
            Meiryo,
            'Hiragino Kaku Gothic ProN',
            'Yu Gothic',
            sans-serif !important;
          -webkit-font-smoothing: antialiased !important;
          font-size: 13.6px;
          font-feature-settings: palt;
          -webkit-text-size-adjust: 100%;
          letter-spacing: -.06em;
          color: #281600;
        }

        a,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
          font-family:
            IwaUDGoDspPro-Th,
            'Hiragino Sans',
            'ヒラギノ角ゴシック',
            'メイリオ',
            Meiryo,
            'Hiragino Kaku Gothic ProN',
            'Yu Gothic',
            sans-serif !important;
        }

        .info {
          margin: 0 0 15px;
          padding: 5px !important;
          background-color: #fff;
          border: #d90000 2px solid;
          font-size: 15px
        }

        .red {
          color: red
        }

        .txt {
          font-size: 15px !important;
          padding: 0 10px !important;
          background: none !important
        }

        #customer_review_area {
          display: block;
          width: 100%;
          height: 210px;
          box-sizing: border-box;
          border: 1px solid #dcdcdc;
          margin: auto;
          overflow: hidden;
          background: #fff;
        }

        #customer_review_area .slider_review {
          margin: 0;
          padding: 0;
        }

        #customer_review_area .bx-wrapper {
          margin-bottom: 0;
          border: 5px solid #fff;
          background: #fff;
          box-shadow: 0 0 5px #ccc;
        }

        #customer_review_area .reviews_box {
          box-sizing: border-box;
          width: calc(100% - 10px) !important;
          max-width: none;
          margin: 0 5px 10px;
          padding: 12px 15px 7px;
          background: #f4f4f4;
          border-radius: 3px;
          box-shadow: 2px 2px 3px rgba(0, 0, 0, .25);
          color: #111;
        }

        #customer_review_area .reviews_box p {
          margin: 0;
          padding: 0;
        }

        #customer_review_area .reviews_box .star {
          font-size: 16px;
          line-height: 22px;
          white-space: nowrap;
        }

        #customer_review_area .reviews_box .score {
          display: inline-block;
          margin: 0 4px 0 6px;
          color: #f5a623;
          letter-spacing: 0;
          white-space: nowrap;
        }

        #customer_review_area .reviews_box .date {
          margin-top: 3px;
          color: #888;
          font-size: 11px;
          line-height: 14px;
        }

        #customer_review_area .reviews_box hr {
          margin: 7px 0;
          border: 0;
          border-top: 1px solid #ddd;
        }

        #customer_review_area .reviews_box .comment {
          margin-bottom: 5px;
          line-height: 1.5;
        }

        #google-qr {
          display: none;
        }

        table.tbl_index:hover {
          box-shadow: 1px 1px 3px 1px grey;
          transition-duration: .1s
        }

        .social-box {
          width: 48%;
          height: 500px;
          border: 1px solid #CCC;
          margin: 5px 0 10px;
          max-height: 500px;
          overflow: auto
        }

        .social-group {
          display: flex;
          justify-content: space-between
        }

        .pc_only {
          display: block !important
        }

        #twitter-widget-1 {
          max-width: 99.8% !important
        }

        /* body .tbl_index .topic {
          font-family: IwaUDGoDspPro-Bd, sans-serif !important
        } */

        .tbl_index div p {
          padding-left: 10px
        }

        .new-text {
          font-size: 16px !important;
          letter-spacing: 0.05em !important;
          line-height: 150% !important;
        }



        @media screen and (min-width: 768px) {
          .tbl_index .text-box span {
            font-size: 14px;
            padding: 2.4px 7px
          }

          body .tbl_index .topic {
            font-size: 26px
          }

          .text-box {
            width: 20% !important;
            padding-left: 5px !important
          }

        }

        @media screen and (max-width: 768px) {
          .social-box {
            width: -webkit-fill-available
          }

          .social-group {
            display: block
          }

          .pc_only {
            display: none !important
          }

          #google-qr {
            display: block;
          }
        }

        @media screen and (max-width: 576px) {
          body .tbl_index .topic {
            font-size: 3.3vw
          }

          #google-qr {
            display: block;
          }
        }

        .fullw-img {
          text-align: center;
          margin-top: 15px;
        }

        .tbl_index div p {
          padding-left: 0;
        }

        @media(max-width: 768px) {
          #customer_review_area {
            width: 100%;
          }

          .fullw-img {
            margin-top: 0
          }
        }

        .tbl_index .detail {
          font-size: calc(16px + 6 * ((15vw - 320px) / 680));
          line-height: 26px;
        }

        @media(max-width: 576px) {
          .tbl_index .detail {
            font-size: 2.2vw;
            line-height: 3vw;
            font-weight: 100;
          }

          #customer_review_area {
            height: 350px;
          }

          #customer_review_area .reviews_box .star {
            font-size: 12px;
            line-height: 18px;
            white-space: normal;
          }

          p.comment,
          p.star {
            font-size: 12px;
          }

          #customer_review_area .bx-viewport {
            height: 350px !important;
          }

          .slideshow-container {
            display: block;
          }

          .dot-pic {
            display: none;
          }

          .social-group {
            display: none;
          }

          .prev,
          .next {
            display: none;
          }

          /* #info_div {
            display: none;
          } */

          .info_box a {
            font-size: 0.65rem;
          }
        }

        .twitter-tweet {
          max-width: 100% !important;
        }

        .mobile-viewer {
          display: none;
        }

        section[aria-label="Timeline"] div div:nth-child(n+4) {
          display: none;
        }

        @media screen and (max-width: 768px) {
          .mobile-viewer {
            display: block;
          }

        }
    </style>
    <script type="text/javascript" src="{{ asset('js/coin-slider.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/coin-slider-styles.css') }}" type="text/css" />
    <link rel="preload" href="{{ asset('css/my-slider.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <script src="{{ asset('js/ism-2.2.min.js') }}"></script>
    <noscript>
      <link rel="stylesheet" href="{{ asset('css/my-slider.css') }}" />
    </noscript>
    <!-- end -->
    <script type="text/javascript" src="{{ asset('js/jquery.tinyscrollbar.js') }}"></script>
    <script type="text/javascript">
      $(document).ready(function() {
          $('#scrollbar1').tinyscrollbar();
          $('#flash_slide').coinslider();
          $('#coin-slider').coinslider({
            width: 900,
            navigation: false,
            delay: 5000
          });
      });
    </script>
    <script type="application/ld+json">
      {
        "@@context": "https://schema.org",
        "@type": "OnlineStore",
        "@id": "https://hotmobily.jp/#organization",
        "name": "ホットモバイリー",
        "url": "https://hotmobily.jp/",
        "description": "個人の小ロットから企業・官公庁の量産まで、アクリルグッズ、ラバーグッズ、アクキー、反射キーホルダー、3D立体キーホルダー、お守り、PVCケース、フライトタグ、キッチンスポンジ等の多彩なオリジナルグッズを、良品廉価・顧客第一主義で製作するサービス。"
      }
    </script>
    <!-- end -->

@endsection


@section('content')

    <div class="home-page">

        <noscript>
            <div style="display:inline;">
              <p>&nbsp;</p>
              <p><img height="0" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1036353231/?label=IGnMCK-CuAEQz_2V7gM&amp;guid=ON&amp;script=0" />
              </p>
            </div>
          </noscript>
      <div id="info_div"></div>
      {{-- Legacy campaign_2021.php is currently empty. --}}

      @include('partials.legacy-slider')

      @if (now()->format('Y-m-d') < '2025-02-06')
        <div class="mobile-viewer">
          <a href="https://hotmobily.jp/campaign/chinese_new_year2025_campaign.php"><img src="/products/images/cn-new-year-2.webp" width="770" height="194"></a>
        </div>
      @endif

      <h1 style="font-size: 14px;" class="new-text">オリジナルグッズ・ノベルティを小ロット短納期で製作。</h1>
      <!-- :: index start :: -->
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/rubberstrap/">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/157x120/rubber-strap.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナルラバーストラップ</span><span class="detail">凹凸表面が特徴のソフトゴム製。自由なカタチで<br />製作。同人グッズ、記念品、販促品。100本～。</span></p>
                <p class="text-box"><span>@<text class="yellow">126円～</text></span><span>最短<text class="yellow">2週間納品</text></span><span><text class="yellow">15</text>色定額料金※1</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/rubberkeyholder/">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/rubber-keyholder.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナルラバーキーホルダー</span><span class="detail">ソフトゴム製半立体。色・カタチ自由自在。<br />同人グッズ、記念品、販促品。100個から製作。</span></p>
                <p class="text-box"><span>@<text class="yellow">126円～</text></span><span>最短<text class="yellow">2週間納品</text></span><span><text class="yellow">15</text>色定額料金※1</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/printedrubberstrap_keyholder/">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/printed_rubber_entry.webp" width="157" height="120"></div>
                <p><span class="topic">印刷ラバーストラップ</span><span class="detail">1個から製作できるラバーストラップ！<br />推し活グッズや同人グッズに最適！</span></p>
                <p class="text-box"><span>@<text class="yellow">174円～</text></span><span>最短製作6営業日</span><span><text class="yellow">フルカラー印刷</text></span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>


      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/rubbercoaster/">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/157x120/rubber-coaster.webp" width="157" height="120">
                </div>
                <p><span class="topic">オリジナルラバーコースター</span><span class="detail">ゴム製立体構造。四角・円形以外でも製作。<br />飲食、販促、記念。個人様可。1枚より製作。</span></p>
                <p class="text-box"><span>色・カタチ自由</span><span>最短<text class="yellow">2週間納品</text></span><span><text class="yellow">15</text>色定額料金※1</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/printedrubbercoaster/">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/printed_coaster_entry.webp" width="157" height="120"></div>
                <p><span class="topic">印刷ラバーコースター</span><span class="detail">1個から製作できるラバーコースター！<br />飲食店にも自宅用にも製作可能！</span></p>
                <p class="text-box"><span><text class="yellow">@216円～</text></span><span><text class="yellow">1個から製作可能！</text></span><span><text class="">大ロットほどお得◎</text></span><span><text class="">フルカラー可能</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/157x120/acrylic-keyholder.webp" width="157" height="120">
                </div>
                <p><span class="topic">オリジナルアクリルキーホルダー</span><span class="detail">フルカラー印刷、コーティングフィルムあり。<br />同人グッズ、販促品。最小ロットは1個から製作可能。</span></p>
                <p class="text-box"><span>＠<text class="yellow">168円～</text></span><span>最短製作<text class="yellow">6営業日</text></span><span><text class="yellow">フルカラー印刷</text></span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/connectable-acrylic-keyholder">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/connectable-acrylic-top.webp" width="157" height="120">
                </div>
                <p><span class="topic">2連アクリルキーホルダー</span><span class="detail">表現の幅が広がる連結アクリルキーホルダー！<br />推し活・同人グッズに最適！カスタマイズも楽しい！</span></p>
                <p class="text-box"><span>＠<text class="yellow">300円～</text></span><span>最短製作6営業日</span><span><text class="yellow">フルカラー印刷</text></span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/blister-pack-style">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/blister-acrylic-top.webp" width="157" height="120">
                </div>
                <p><span class="topic">ブリスターパック風アクリルキーホルダー</span><span class="detail">キャラやアイドルをパッキング！発想が光るアクキー！<br />推し活グッズ、ファングッズ、企業ノベルティに！</span></p>
                <p class="text-box"><span>＠<text class="yellow">416円～</text></span><span><text class="yellow">最短製作12営業日</text></span><span>大ロットほどお得◎</span><span>フルカラー可能</span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/syaka-syaka-acrylic-keyholder">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/157x120/syakasyaka_entry.webp" width="157" height="120">
                </div>
                <p><span class="topic">シャカシャカアクリルキーホルダー</span><span class="detail">パーツの入れ替え自由！カスタマイズが楽しいアクリルグッズ<br />推し活グッズにも同人グッズにも最適！</span></p>
                <p class="text-box"><span>@656円～<text class="yellow" </text></span><span>最短製作10営業日<text class="yellow"></text></span><span><text class="yellow">フルカラー印刷</text></span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/tsumehodai">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/157x120/tsume_entry.webp" width="157" height="120">
                </div>
                <p><span class="topic">アクリル詰め放題</span><span class="detail">A5サイズにデザイン詰め放題！アクキーにもアクスタにも<br />ファングッズ製作にも小ロット製作にもぴったりマッチ！</span></p>
                <p class="text-box"><span><text class="yellow">@3850円～</text></span><span><text class="yellow">1個から製作可能！</text></span><span>最短10営業日後出荷<text class="yellow"></text></span><span>フルカラー可能<text class="yellow"></text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>



      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/aurora.php">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/aurora_top_v2.webp" width="157" height="120">
                </div>
                <p><span class="topic">オーロラアクリルキーホルダー</span><span class="detail">光の角度で色が変わる！特別感を演出するアクキー！<br />同人グッズや自社ブランディングに！1個から製作可能！</span></p>
                <p class="text-box"><span>＠<text class="yellow">188円～</text></span><span>最短製作<text class="yellow">6営業日</text></span><span><text class="yellow">フルカラー印刷</text></span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/rainbow.php">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/rainbow_top_v2.webp" width="157" height="120">
                </div>
                <p><span class="topic">レインボーアクリルキーホルダー</span><span class="detail">光を反射して虹色に！ひとあじ違う輝きが魅力的！<br />同人グッズや自社ブランディングに！1個から製作可能！</span></p>
                <p class="text-box"><span>＠<text class="yellow">188円～</text></span><span>最短製作<text class="yellow">6営業日</text></span><span><text class="yellow">フルカラー印刷</text></span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/recycle.php">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/recycle_157×120_v2.webp" width="157" height="120">
                </div>
                <p><span class="topic">再生材料アクリルキーホルダー</span><span class="detail">再生材100％、エコでサステナブル、SDGsに貢献できる！<br />自社ブランディングや同人グッズに！1個から製作可能！</span></p>
                <p class="text-box"><span>＠<text class="yellow">168円～</text></span><span>最短製作<text class="yellow">6営業日</text></span><span><text class="yellow">フルカラー印刷</text></span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>


      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/omamori-keyholder.php">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/Omamori_acrylic_top.webp" width="157" height="120">
                </div>
                <p><span class="topic">お守りアクリルキーホルダー</span><span class="detail">新しい形のお守りグッズ！<br />神社・寺院で販売するお守りや推し活グッズに！</span></p>
                <p class="text-box"><span>＠<text class="yellow">245円～</text></span><span>最短製作<text class="yellow">6営業日</text></span><span><text class="yellow">フルカラー印刷</text></span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>


      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/figure">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/157x120/acrylic-figure.webp" width="157" height="120">
                </div>
                <p><span class="topic">アクリルスタンド</span><span class="detail">フルカラー印刷、コーティングフィルムあり。<br />両面印刷可。最小ロットは1個から製作可能。</span></p>
                <p class="text-box"><span>＠<text class="yellow">233円～</text></span><span>最短製作<text class="yellow">6営業日</text></span><span><text class="yellow">フルカラー印刷</text></span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/dioramastand">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/diorama-acrylicstand-top.webp" width="157" height="120">
                </div>
                <p><span class="topic">ジオラマアクリルスタンド</span><span class="detail">世界観を立体的に演出！表現力◎<br />推し活グッズ・同人グッズ・ファングッズに！</span></p>
                <p class="text-box"><span>＠398円～</span><span>最短製作10営業日</span><span><text class="yellow">フルカラー印刷</text></span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/monitor">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/monitor-acrylic-top.webp" width="157" height="120">
                </div>
                <p><span class="topic">モニターアクリルスタンド</span><span class="detail">モニター上に設置できる新しいアクスタ！<br />デスクまわりの推し活・同人グッズ・ファングッズに！</span></p>
                <p class="text-box"><span>＠398円～</span><span>最短製作6営業日</span><span><text class="yellow">フルカラー印刷</text></span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>



      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/figure/rainbow">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/top_rainbowstand.webp" width="157" height="120">
                </div>
                <p><span class="topic">レインボーアクリルスタンド</span><span class="detail">虹色エフェクトで特別なアクスタに！<br />記念品や限定品の製作にぴったり◎</span></p>
                <p class="text-box"><span>＠330円～</span><span>最短製作6営業日</span><span>フルカラー印刷</span><span>一部送料無料</span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/figure/aurora">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/top_arurorastand.webp" width="157" height="120">
                </div>
                <p><span class="topic">オーロラアクリルスタンド</span><span class="detail">色と光の演出で特別なアクスタに！<br />記念品や限定品としておすすめ◎</span></p>
                <p class="text-box"><span>＠330円～</span><span>1個から製作可能！</span><span>大ロットほどお得◎</span><span>フルカラー可能</span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>


      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/board">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/acrylicboard-top.webp" width="157" height="120">
                </div>
                <p><span class="topic">アクリルパネル（アクリルボード）</span><span class="detail">インテリアとしても映えるアクリルグッズ！<br />推し活グッズや同人グッズに！1個から製作可能！</span></p>
                <p class="text-box"><span>＠<text class="yellow">740円～</text></span><span>最短製作<text class="yellow">6営業日</text></span><span><text class="yellow">フルカラー印刷</text></span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/stand">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/157x120/acrylic-phonestand.webp" width="157" height="120">
                </div>
                <p><span class="topic">アクリルスマホスタンド</span><span class="detail">フルカラー印刷、コーティングフィルムあり。<br />卓上グッズ、最小ロットは1個から製作可能。</span></p>
                <p class="text-box"><span>＠<text class="yellow">876円～</text></span><span>最短製作<text class="yellow">8営業日</text></span><span><text class="yellow">フルカラー印刷</text></span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/umbrella">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/157x120/acrylic-umbrella.webp" width="157" height="120">
                </div>
                <p><span class="topic">めじるしキーホルダー（アクリルアンブレラマーカー）</span><span class="detail">フルカラー印刷、コーティングフィルムあり。傘の目印に最適<br /></span></p>
                <p class="text-box"><span>＠<text class="yellow">168円～</text></span><span>最短製作<text class="yellow">6営業日</text></span><span><text class="yellow">フルカラー印刷</text></span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/badge">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/157x120/acrylic-badge.webp" width="157" height="120">
                </div>
                <p><span class="topic">アクリルクリップ（アクリルバッジ）</span><span class="detail">フルカラー印刷、コーティングフィルムあり。<br />アクリル製バッジ。安心安全のエッヂ処理。</span></p>
                <p class="text-box"><span>＠<text class="yellow">168円～</text></span><span>最短製作<text class="yellow">6営業日</text></span><span><text class="yellow">フルカラー印刷</text></span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/coaster">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/157x120/acrylic-coaster.webp" width="157" height="120">
                </div>
                <p><span class="topic">アクリルコースター</span><span class="detail">フルカラー印刷、コーティングフィルムあり。<br />アクリル製コースター。繰り返し使用可能。</span></p>
                <p class="text-box"><span>＠<text class="yellow">267円～</text></span><span>最短製作<text class="yellow">6営業日</text></span><span><text class="yellow">フルカラー印刷</text></span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/hairbunch">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/157x120/acrylic-hairbunch.webp" width="157" height="120">
                </div>
                <p><span class="topic">アクリルヘアバンド</span><span class="detail">フルカラー印刷、コーティングフィルムあり。<br />アクリル製ヘアバンド。ノベルティ記念品。</span></p>
                <p class="text-box"><span>＠<text class="yellow">168円～</text></span><span>最短製作<text class="yellow">6営業日</text></span><span><text class="yellow">フルカラー印刷</text></span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/acrylic/griptok">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/157x120/acrylic-griptok.webp" width="157" height="120">
                </div>
                <p><span class="topic">アクリルスマホグリップトック（アクリルグリップホルダー）</span><span class="detail">フルカラー印刷、コーティングフィルムあり。<br>卓上グッズ、多機能製品、最小ロットは1個。</span></p>
                <p class="text-box"><span>＠<text class="yellow">267円～</text></span><span>最短製作<text class="yellow">6営業日</text></span><span><text class="yellow">フルカラー印刷</text></span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/plushie-pouch/">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/157x120/plushie-pouch-top.webp" width="157" height="120">
                </div>
                <p><span class="topic">ぬいぐるみポーチ</span><span class="detail">実用性も抜群のぬいぐるみ型ポーチをご製作！<br>推し活グッズやオリジナル雑貨として最適！</span></p>
                <p class="text-box">
                  <span>＠<text class="yellow">1,338円～</text></span>
                  <span>アタッチメント取付可</span>
                  <span><text class="yellow">フルカラー印刷</text></span>
                  <span><text class="yellow">送料無料</text></span>
                </p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/candysticker">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/candysticker-toppage.webp" width="157" height="120"></div>
                <p><span class="topic">キャンディシール</span><span class="detail">ぷっくりした厚みとツヤが可愛い立体シール！<br />デコアイテム・推し活グッズ・コレクションアイテム・ノベルティに！</span></p>
                <p class="text-box"><span>@279円～</span><span>試作品込み！</span><span><text class="yellow">フルカラー印刷</text></span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/cleaner.html">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/157x120/rubber-cleaner.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナルスマホクリーナートップ</span><span class="detail">凹凸構造のゴム製、カラービニール、貼付の<br />3タイプ。マイクロファイバー対応の本格派。</span></p>
                <p class="text-box"><span>@<text class="yellow">126円～</text></span><span><text class="yellow">色・カタチ自由</text></span><span>300本～製作</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/phonestand/">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/157x120/rubber-phonestand.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナルスマホスタンド</span><span class="detail">凹凸表面が特徴のソフトゴム製。自由なカタチで<br />製作。小ロット企業ノベルティに最適。100個～。</span></p>
                <p class="text-box"><span>色・カタチ自由</span><span>最短<text class="yellow">2週間納品</text></span><span><text class="yellow">15</text>色定額料金※1</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/cableholder/">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/157x120/rubber-cableholder.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナルイヤホンコードホルダ</span><span class="detail">凹凸表面が特徴のソフトゴム製。自由なカタチで<br />製作。音楽関連ノベルティに最適。100個～。</span></p>
                <p class="text-box"><span>色・カタチ自由</span><span>最短<text class="yellow">2週間納品</text></span><span><text class="yellow">15</text>色定額料金※1</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/rubbertag">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/157x120/rubbertag.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナルラバータグ</span><span class="detail">帽子や洋服、バックなどに簡単に縫製。<br />水洗い可能。オリジナルデザイン。100個～</span></p>
                <p class="text-box"><span><text class="yellow">＠299円～</text></span><span>最短<text class="yellow">2週間納品</text></span><span><text class="yellow">15</text>色定額料金※1</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/rubber_frame">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/157x120/rubberframe.webp" width="157" height="120"></div>
                <p><span class="topic">ラバーフォトフレーム</span><span class="detail">写真をオリジナルデザインのフレームに装着できます。<br />最小ロット30個～。</span></p>
                <p class="text-box"><span><text class="yellow">色・カタチ自由</text></span><span><text class="yellow">30個</text>～製作</span><span><text class="yellow">15色</text>定額料金</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/keycover/">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/157x120/rubber-keycover.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナルキーカバー</span><span class="detail">凹凸表面が特徴のソフトゴム製。自由なカタチで<br />製作。裏面もデザインＯＫ。100個～。</span></p>
                <p class="text-box"><span>色・カタチ自由</span><span>最短<text class="yellow">2週間納品</text></span><span><text class="yellow">15</text>色定額料金※1</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/rubberjibbitzs/">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/Top_Jibbitz0502.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナルジビッツチャーム</span><span class="detail">クロックスのカスタマイズに！ソフトゴム製ジビッツチャーム<br />100個から制作。汚れ防止加工オプションあり。</span></p>
                <p class="text-box"><span>@126円～</span><span>最短<text class="yellow">2週間納品</text></span><span><text class="yellow">15</text>色定額料金※1</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/rubbercableband/">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/Top_rubbercable.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナルラバーケーブルバンド</span><span class="detail">配線すっきり、実用性とデザイン性を両立！オフィスのお供に。<br />最小ロット100個。ノベルティにも販売品にも。</span></p>
                <p class="text-box"><span>@126円～</span><span>最短<text class="yellow">2週間納品</text></span><span><text class="yellow">15</text>色定額料金※1</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/pvc-clear-multi-case">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/pvc-case-top.webp" width="157" height="120"></div>
                <p><span class="topic">PVCクリアマルチケース</span><span class="detail">実用性◎サイズ感が可愛いクリアケース！<br />推し活グッズ、ファングッズ、企業ノベルティに！</span></p>
                <p class="text-box"><span>@420円～</span><span><text class="yellow">最短製作12営業日</text></span><span>大ロットほどお得◎</span><span>フルカラー可能</span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/pvczipcase/">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/index-pvczipcase.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナルテンチャックケース</span><span class="detail">2種類のサイズから選びオリジナルフルカラー印刷可能。最小ロット1個から。</span></p>
                <p class="text-box"><span><text class="yellow">＠440円～</text></span><span><text class="yellow">最短7営業日</text>出荷</span><span><text class="yellow">フルカラー</text>印刷</span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/aircusshion-pouch">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/Aircusshion_pouch_top.webp" width="157" height="120">
                </div>
                <p><span class="topic">オリジナルクッションポーチ</span><span class="detail">オリジナルデザインを印刷したクッションポーチを製作！<br />自社のオリジナルグッズやブランディングツールとして！</span></p>
                <p class="text-box"><span><text class="yellow">＠362円～</text></span><span><text class="yellow">30枚から製作可能！</text></span><span><text class="">大ロットほどお得◎</text></span><span><text class="">フルカラー印刷</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/omamori/">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/omamori_top.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナルお守り</span><span class="detail">ジャガード織とフルカラーの2タイプをご用意！<br>大ロットが超お得。小ロットもご対応</span></p>
                <p class="text-box"><span><text class="yellow">＠220円～</text></span><span><text class="yellow">大ロットが超お得！</text></span><span><text class="yellow">紐色は14色！</text></span><span><text class="yellow">送料無料！</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>


      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/tapestry">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/tapestry_top.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナルタペストリー</span><span class="detail">オリジナルデザインでタペストリーをご制作！<br>同人グッズや自社サービスの宣伝に！</span></p>
                <p class="text-box"><span><text class="yellow">＠754円～</text></span><span><text class="yellow">1個から製作可能！</text></span><span><text class="yellow">大ロットほどお得◎</text></span><span><text class="yellow">フルカラー印刷</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>


      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/deskmat">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/deskmat_157×120.webp" width="157" height="120">
                </div>
                <p><span class="topic">オリジナルデスクマット</span><span class="detail">オリジナルデザインでデスクマットを製作！<br />同人グッズやアニメファン・ゲーマー向けのグッズとして！</span></p>
                <p class="text-box"><span>＠<text class="yellow">754円～</text></span><span><text class="yellow">30枚から製作可能！</text></span><span><text class="yellow">大ロットほどお得◎</text></span><span><text class="yellow">フルカラー印刷</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/tumbler">
              <div class="banner_box_flex">
                <div class="img_box"><img src="/img/2022_prod/tumbler-top.webp" width="157" height="120">
                </div>
                <p><span class="topic">オリジナルタンブラー</span><span class="detail">オリジナルタンブラーをご製作！<br />シンプルな名入れも写真の印刷も可能です！</span></p>
                <p class="text-box"><span>＠<text class="yellow">1,620円～</text></span><span><text class="yellow">100個から製作可能！</text></span><span><text class="">大ロットほどお得◎</text></span><span><text class="">フルカラー可能</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>


      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/pbholder.html">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/157x120/pbholder.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナルペットボトルホルダ</span><span class="detail">ソフトゴム製。表裏両面にデザイン可能。<br />ノベルティ、記念品として。100個～。</span></p>
                <p class="text-box"><span>アウトドア対応</span><span>両面デザイン</span><span><text class="yellow">ユニーク製品</text></span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/targetcup">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/157x120/targetcup.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナルターゲットカップ</span><span class="detail">パター練習に最適なゴルフターゲットカップ。<br />持ち運び簡単。贈呈品、記念品に最適。100個～。</span></p>
                <p class="text-box"><span>色・カタチ自由</span><span>100個～製作</span><span><text class="yellow">15色</text>定額料金※1</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/reflecter">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/reflecter.webp" width="157" height="120"></div>
                <p><span class="topic">リフレクター（反射）チャーム</span><span class="detail">交通安全ノベルティ、ご採用実績ナンバーワン！<br />カラー印刷チャーム、リストバンド、ステッカー。</span></p>
                <p class="text-box"><span>人気急上昇中</span><span><text class="yellow">3M反射材使用※1</text></span><span><text class="yellow">300本～</text>製作※1</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/3dcharm.html">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/3d-charm.webp" width="157" height="120">
                </div>
                <p><span class="topic">三次元立体チャームトップ</span><span class="detail">自治体ゆるキャラノベルティご採用実績豊富。<br />企業展示会、イベントでの配布。500個～。</span></p>
                <p class="text-box"><span>色・カタチ自由</span><span><text class="yellow">本格派立体横造</text></span><span><text class="yellow">短納期</text>ご相談可</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/pvc_hariawase">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/157x120/3D-rubber-top.webp" width="157" height="120"></div>
                <p><span class="topic">3D立体チャーム</span><span class="detail">立体のキーホルダーやフィギュアを明瞭価格でご製作！
                    <br />キャラクターやマスコットなどのオリジナルグッズに！</span></p>
                <p class="text-box">
                  <span><text class="yellow">@556円～</text></span>
                  <span>大ロットほどお得◎</span>
                  <span>デザイン印刷可能</span>
                  <span><text class="yellow">送料無料</text></span>
                </p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/polyresign.html">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/polyresign.webp" width="157" height="120"></div>
                <p><span class="topic">3D立体チャームポリレジン</span><span class="detail">当店一番人気の立体チャーム。ゆるキャラ、
                    <br />企業展示会、イベントでの配布。500個～。</span></p>
                <p class="text-box"><span>人気急上昇中</span><span>スマホプラグ可</span><span><text class="yellow">短納期</text>ご相談可</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/injection.html">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/injection.webp" width="157" height="120"></div>
                <p><span class="topic">三次元立体インジェクションチャーム</span><span class="detail">射出成型で製作する、本格的立体チャーム。<br />実物の再現力ナンバーワン！1,000個～。</span></p>
                <p class="text-box"><span>大ロット対応可</span><span><text class="yellow">スマホプラグ可</text></span><span><text class="yellow">本格派立体横造</text></span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/sponge/">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/sponge.webp" width="157" height="120">
                </div>
                <p><span class="topic">オリジナルキッチンスポンジ</span><span class="detail">フルカラー印刷、水洗いで繰り返し使用できるスポンジ。<br />オリジナル形状で製作可、最小50個から製作可能。</span></p>
                <p class="text-box"><span>＠<text class="yellow">146円～</text></span><span>最短製作<text class="yellow">10営業日</text></span><span><text class="yellow">フルカラー</text>印刷</span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/floatkeyholder.php">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/floatkey.webp" width="157" height="120">
                </div>
                <p><span class="topic">オリジナルフローティングキーホルダ</span><span class="detail">水に浮くキーホルダー、オリジナル形状、印刷可。
                    <br />アウトドア。お子様向け。100個～</span></p>
                <p class="text-box"><span>色・カタチ自由</span><span><text class="yellow">両面</text>デザイン</span><span><text class="yellow">100個～</text>製作</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/flight_tag">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/products/images/F_-31 - white.webp?v=1.02" width="140" height="120"></div>
                <p><span class="topic">フライトタグ</span><span class="detail">刺繍またはジャガード織で、オリジナルデザインを再現。<br />ノベルティや記念品として。50枚～。裏面デザインも可。</span></p>
                <p class="text-box"><span>＠<text class="yellow">132円～</text></span><span>最短製作<text class="yellow">15営業日</text></span><span>50枚～製作</span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/wappen">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/products/images/W_-07 - white.webp" width="140" height="auto"></div>
                <p><span class="topic">オリジナルワッペン</span><span class="detail"><span class="detail">オリジナルワッペンを50枚から激安で製作。マジックテープ・アイロンテープなど裏面加工豊富。</span></span></p>
                <p class="text-box"><span>＠<text class="yellow">94円～</text></span><span>最短製作<text class="yellow">15営業日</text></span><span>50枚～製作</span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/flight_tag_keyholder">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/products/images/K_-01 - white.webp" width="140" height="auto"></div>
                <p><span class="topic">刺繍キーホルダー</span><span class="detail">オリジナル刺繍キーホルダーを小ロット50個から製作。両面デザイン可。アニメグッズに最適。</span></p>
                <p class="text-box"><span>＠<text class="yellow">94円～</text></span><span>最短製作<text class="yellow">15営業日</text></span><span>50枚～製作</span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/flight_tag_badge">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/products/images/ft_badge_02_S - white.webp" width="140" height="auto"></div>
                <p><span class="topic">刺繍バッジ</span><span class="detail">イベントや展示会に最適なロゴ・社名入りオリジナル刺繍バッジ。安全ピンやバタフライクラッチ付き。</span></p>
                <p class="text-box"><span>＠<text class="yellow">94円～</text></span><span>最短製作<text class="yellow">15営業日</text></span><span>50枚～製作</span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/flight_tag_coaster">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/products/images/ft_coaster_01_S - white.webp?v=1.01" width="140" height="auto"></div>
                <p><span class="topic">刺繍コースター</span><span class="detail">オリジナル刺繍コースター。カフェや飲食店に最適。両面デザイン可。小ロット50枚より製作。</span></p>
                <p class="text-box"><span>＠<text class="yellow">281円～</text></span><span>最短製作<text class="yellow">15営業日</text></span><span>50枚～製作</span><span><text class="yellow">一部送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/microfibers.html">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/index-microfibers.webp" width="157" height="120"></div>
                <p><span class="topic">マイクロファイバー製品トップ</span><span class="detail">メガネクロス、ポーチ、マウスパット他。<br />フルカラー印刷で製作できます。</span></p>
                <p class="text-box"><span>＠<text class="yellow">44円～</text></span><span>RoHS対応</span><span><text class="yellow">100枚～</text>製作</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/pvcpouch.html">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/pvcpouch.webp" width="157" height="120">
                </div>
                <p><span class="topic">オリジナルクリアビニールポーチ </span><span class="detail">選べる3つのサイズ。社名やロゴマーク等名入れ
                    <br />可。特注サイズでの製作もできます。200個～。</span></p>
                <p class="text-box"><span><text class="yellow">社名等</text>名入れ可</span><span><text class="yellow">指定形状</text>製作可</span><span><text class="yellow">パイピング加工</text></span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/ecokairo.html">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/ecokairo.webp" width="157" height="120">
                </div>
                <p><span class="topic">オリジナルエコカイロ </span><span class="detail">繰返し使え、環境に優しい人気の冬ノベルティ。<br />オリジナルのカタチで、社名や製品名を名入れ。</span></p>
                <p class="text-box"><span><text class="yellow">社名等</text>名入れ可</span><span><text class="yellow">指定形状</text>製作可</span><span><text class="yellow">500個～</text>製作</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/gloves.html">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/gloves.webp" width="157" height="120">
                </div>
                <p><span class="topic">オリジナルスマートフォン手袋 </span><span class="detail">手袋をしたまま、スマホを簡単操作。<br />オリジナルデザインで製作できます。</span></p>
                <p class="text-box"><span><text class="yellow">社名等</text>名入れ可</span><span>ユニーク製品</span><span><text class="yellow">500個～</text>製作</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/led.php">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/led-products.webp" width="157" height="120">
                </div>
                <p><span class="topic">オリジナルLED製品トップ </span><span class="detail">印刷可能なLEDライトチャームとペンライト。<br />手軽な既製品とオーダーメイド品。500個～。</span></p>
                <p class="text-box"><span>色・カタチ自由</span><span><text class="yellow">スマホプラグ可</text></span><span><text class="yellow">短納期</text>ご相談可</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/led_original.html">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/led-original.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナルLEDライトチャーム </span><span class="detail">お好きなカタチで、両面にカラー印刷できます。<br />ストラップやキーホルダー型。500個～。</span></p>
                <p class="text-box"><span>色・カタチ自由</span><span><text class="yellow">スマホプラグ可</text></span><span><text class="yellow">短納期</text>ご相談可</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/led_penlight.html">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/led-penlight.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナルLEDペンライト </span><span class="detail">イベントでの豊富なご採用実績。社名・ロゴ名<br />で、手軽に製作できる、LED製品。500個～。</span></p>
                <p class="text-box"><span><text class="yellow">オリジナル</text>形状</span><span>複数<text class="yellow">発光パターン</text></span><span><text class="yellow">レーザー刻印</text></span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <!-- <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/jogbottle.html">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/jogbottle.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナルコンパクトジョグボトル </span><span class="detail">折り畳み可能な、カラビナ付き水筒。全面に印刷<br />製品単価：180円～</span></p>
                <p class="text-box"><span><text class="yellow">社名等</text>名入れ可</span><span>ユニーク製品</span><span><text class="yellow">大ロット</text>対応可</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table> -->
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/coolpac.html">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/coolpack-220617.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナル保冷剤 </span><span class="detail">繰返し使え、環境に優しい人気の夏ノベルティ。<br />オリジナルのカタチで、社名や製品名を名入れ。</span></p>
                <p class="text-box"><span><text class="yellow">社名等</text>名入れ可</span><span><text class="yellow">指定形状</text>製作可</span><span><text class="yellow">100個～</text>製作</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/stubbyholder.html">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/stubbyholder.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナルスタビーホルダー </span><span class="detail">缶・瓶製品の保冷カバーの製作。カラー印刷で、<br />社名や店舗名を名入れ。軽量薄型ノベルティ。</span></p>
                <p class="text-box"><span>社名等<text class="yellow">名入れ可</text></span><span>ユニーク製品</span><span><text class="yellow">100個～</text>製作</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/beach.php">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/beach.webp" width="157" height="120">
                </div>
                <p><span class="topic">オリジナルビーチサンダル </span><span class="detail">表面に、社名やイベントロゴをカラー印刷。足跡、<br />社名や店舗名を名入れ。軽量薄型ノベルティ。</span></p>
                <p class="text-box"><span>社名等<text class="yellow">名入れ可</text></span><span>子供用<text class="yellow">対応</text></span><span><text class="yellow">指定形状</text>製作可</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/baghanger.html">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/baghanger.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナルバックハンガー </span><span class="detail">社名やイベントロゴをカラー印刷。軽量・小型<br />ノベルティ。会社・イベントの記念品として。</span></p>
                <p class="text-box"><span>社名等<text class="yellow">名入れ可</text></span><span><text class="yellow">指定形状</text>製作可</span><span><text class="yellow">500個～</text>製作</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/haizara.html">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/haizara.webp" width="157" height="120">
                </div>
                <p><span class="topic">オリジナル携帯灰皿 </span><span class="detail">小型ソフトケース。社名やイベントロゴを印刷。<br />屋外イベントでのご採用実績多数。</span></p>
                <p class="text-box"><span>社名等<text class="yellow">名入れ可</text></span><span><text class="yellow">指定形状</text>製作可</span><span><text class="yellow">1,000個～</text>製作</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/bosui.php">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/index-bosui-2020.webp" width="157" height="120"></div>
                <p><span class="topic">オリジナル防水ケース </span><span class="detail">二重チャックのソフトケース。ストラップ付。<br />社名・イベントロゴ名入れ。フルカラー印刷可。</span></p>
                <p class="text-box"><span>社名等<text class="yellow">名入れ可</text></span><span><text class="yellow">指定形状</text>製作可</span><span><text class="yellow">100個～</text>製作</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>
      <!-- <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/gallery/other0.html#ring">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/ring.webp" width="157" height="120">
                </div>
                <p><span class="topic">オリジナルキーリング </span><span class="detail">指定の英数字を刻印。リング直径、形状、切れ込<br />み形状、メッキ処理等オプション指定可。</span></p>
                <p class="text-box"><span>社名等<text class="yellow">名入れ可</text></span><span><text class="yellow">指定形状</text>製作可</span><span><text class="yellow">5,000個～</text>製作</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table> -->
      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/carabiner/">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/carabiner.webp" width="157" height="120"></div>
                <p><span class="topic">カラビナリング</span><span class="detail">安心、安全の高品質アルミ材使用<br />2種の製法で名入れ印刷可能</span></p>
                <p class="text-box"><span>社名等<text class="yellow">名入れ可</text></span><span>最短<text class="yellow">2週間納品</text></span><span><text class="yellow">安心</text>品質</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/bottle-opner/">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/opener_top.webp" width="157" height="120"></div>
                <p><span class="topic">ボトルオープナー</span><span class="detail">名入れボトルオープナーをご制作！社名やイベント名等<br>小ロット50個から対応</span></p>
                <p class="text-box"><span><text class="yellow">＠89円～</text></span><span><text class="yellow">大ロットが超お得！</text></span><span><text class="yellow">50個から制作可</text></span><span><text class="yellow">送料無料！</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table>

      <!-- <table width="100%" cellspacing="0" class="tbl_index">
        <tr>
          <td>
            <a href="/products/strap.html">
              <div class="banner_box_flex">
                <div class="img_box"><img class="lazy" data-src="/img/2022_prod/mix.webp" width="157" height="120">
                </div>
                <p><span class="topic">オリジナルストラップ</span><span class="detail">オリジナルストラップ製作、小ロット対応、<br />ノベルティ。短納期。オリジナルデザイン。</span></p>
                <p class="text-box"><span>＠<text class="yellow">126円～</text></span><span>最短<text class="yellow">2週間納品</text></span><span><text class="yellow">100個～</text>製作</span><span><text class="yellow">送料無料</text></span></p>
              </div>
            </a>
          </td>
        </tr>
      </table> -->

      

      @if ($news->isNotEmpty())
        <style>
          .news-list {
            max-width: 800px;
            margin: auto;
          }

          .news-item {
            display: flex;
            border-bottom: 1px dotted #ccc;
            padding: 20px 0;
            gap: 20px;
            transition: all 0.7s ease;
          }

          .news-item:hover {
            border-bottom: 1px solid #F25140;
            color: #F25140;
            cursor: pointer;
          }

          .news-date {
            font-weight: bold;
            white-space: nowrap;
          }

          .foo-news {
            margin-top: 10px;
            text-align: right;
          }

          .font-news {
            font-family: IwaUDGoDspPro-Th, sans-serif !important;
            color: #EB8018;
            font-size: 19px;
            margin-top: 10px;
          }

          .ddv:hover {
            text-decoration: none;
          }

          .news-bor {
            border: 1px solid #cccccc;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
          }
        </style>
        <div class="news-bor">
          <div>
            <h2 class="font-news">News!</h2>
          </div>
          @foreach ($news as $item)
            <a href="news-detail.php?id={{ $item['id'] }}" style="color:black;" class="ddv">
              <div class="news-item">
                <div class="news-date">{{ $item['published_at']->format('Y.m.d') }}</div>
                <div class="news-title" style="letter-spacing: 0.05em;">{{ $item['title'] }}</div>
              </div>
            </a>
          @endforeach
          <div class="foo-news">
            <a href="news.php">News一覧へ</a>
          </div>
        </div>
      @endif

      <!-- :: index end :: -->

      <!-- <div class="clear">
        <hr />
      </div> -->
      <!--   <table border="0" align="left" cellpadding="1" cellspacing="7">
      <tr>
        <td><span class="gp_copyright">※1,※2 © Gamepot Inc., All Rights Reserved.</span></td>
      </tr>
  </table> -->
      <!-- <div>
        <div id="social-box" style="height: 400px;overflow: auto;">
        <a class="twitter-timeline" data-height="400" href="https://twitter.com/GoodsYe?ref_src=twsrc%5Etfw" data-tweet-limit="20" data-dnt="true">Tweets by GoodsYe</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
      </div> -->

      <!-- <div>&nbsp;</div> -->
      <div class="fullw-img">
        <a href="/reviews/"><img class="lazy" data-src="/reviews/img/reviews_bannerB.webp" width="771" height="238"></a>
      </div>
      <div id="customer_review_area">
        <div class="slider_review">
          @include('partials.review-slider', ['reviews' => $reviews])
        </div>
      </div>

      <br>
      <div id="google-qr">
        <h2 class="font-news" style="text-align: center;">Googleレビューはこちら!</h2>
        <div style="text-align: center; margin-top: 20px;;">
          <a href="https://www.google.com/search?q=%E3%83%9B%E3%83%83%E3%83%88%E3%83%A2%E3%83%90%E3%82%A4%E3%83%AA%E3%83%BC&oq=%E3%83%9B%E3%83%83%E3%83%88%E3%83%A2%E3%83%90%E3%82%A4%E3%83%AA%E3%83%BC&gs_lcrp=EgZjaHJvbWUyBggAEEUYOTIGCAEQRRg9MgYIAhBFGD0yBggDEEUYPTIGCAQQRRhB0gEIMjg5OWowajGoAgCwAgA&sourceid=chrome&ie=UTF-8"><img src="/img/hm_qr.webp" alt="" width="auto"></a><br />
        </div>
      </div>
    </div>

@endsection

@push('scripts')

  <script>
    function popitup(url) {
      newwindow = window.open(url, 'popup', 'height=518,width=518');
      if (window.focus) {
        newwindow.focus()
      }
      return false;
    }
  </script>
  <script type="text/javascript" src="{{ asset('js/jquery.bxslider.js') }}?v=1.01"></script>
  <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
  <script type="text/javascript">
    $(function() {
      $('#info_div').load(@json(route('legacy-mock.info')));

      var $reviewSlider = $('.slider_review');
      if ($reviewSlider.length && $.fn.bxSlider) {
        $reviewSlider.bxSlider({
          mode: 'vertical',
          auto: true,
          pause: 4000,
          speed: 1000,
          maxSlides: 3,
          minSlides: 3,
          moveSlides: 1,
          pager: false,
          controls: false,
          autoControls: false,
          preventDefaultSwipeY: false,
          touchEnabled: false,
          autoHover: true
        });
      }
    });
  </script>
@endpush
