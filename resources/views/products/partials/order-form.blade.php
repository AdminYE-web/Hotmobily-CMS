@php
    /*
        |--------------------------------------------------------------------------
        | Rubber strap order form defaults
        |--------------------------------------------------------------------------
        |
        | The dynamic storefront does not receive the legacy controller's
    | attachment array, so keep the same options available as a safe fallback.
    |
    */

$attachments = is_array($attachments ?? null)
    ? $attachments
    : [
        [
            'part_name' => '通常松葉（カニカン）',
            'part_price' => '0',
            'part_pic' => '/products/images/HM_part1-2.webp',
        ],
        [
            'part_name' => 'ゴム松葉（カニカン）',
            'part_price' => '0',
            'part_pic' => '/products/images/HM_part2-2.webp',
        ],
        [
            'part_name' => 'ボールチェーンシルバー',
            'part_price' => '0',
            'part_pic' => '/products/images/HM_part14.webp',
        ],
        [
            'part_name' => '通常松葉（カニカン・スマホプラグ）',
            'part_price' => '10',
            'part_pic' => '/products/images/HM_part3.webp',
        ],
        [
            'part_name' => 'ボールチェーン黄色',
            'part_price' => '10',
            'part_pic' => '/products/images/HM_part9.webp',
        ],
        [
            'part_name' => 'ボールチェーン赤色',
            'part_price' => '10',
            'part_pic' => '/products/images/HM_part10.webp',
        ],
        [
            'part_name' => 'ボールチェーン青色',
            'part_price' => '10',
            'part_pic' => '/products/images/HM_part11.webp',
        ],
        [
            'part_name' => 'ボールチェーンピンク色',
            'part_price' => '10',
            'part_pic' => '/products/images/HM_part12.webp',
        ],
        [
            'part_name' => 'ボールチェーン緑色',
            'part_price' => '10',
            'part_pic' => '/products/images/HM_part13.webp',
            ],
        ];
@endphp

<style>
    #order-form .color-variation-heading {
        margin: 0 0 10px;
    }

    #order-form .color-variation-heading h3 {
        margin: 0 0 4px;
    }

    #order-form .color-variation-heading .btn-details {
        display: inline-block;
    }

    #order-form .color-variation-options {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 8px;
        margin: 10px 0;
    }

    #order-form .color-variation-option {
        position: relative;
        margin: 0;
        cursor: pointer;
    }

    #order-form .color-variation-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    #order-form .color-variation-option span {
        display: block;
        padding: 10px 5px;
        border: 1px solid #9e9e9e;
        border-radius: 2px;
        background: #fff;
        color: #111;
        text-align: center;
        transition: background-color .2s, border-color .2s, color .2s;
    }

    #order-form .color-variation-option:hover span,
    #order-form .color-variation-option input:checked+span {
        border-color: #f7b516;
        background: #f7b516;
        color: #fff;
    }

    #order-form .color-variation-option input:focus-visible+span {
        outline: 2px solid #1e6077;
        outline-offset: 2px;
    }

    @media (max-width: 575.98px) {
        #order-form .color-variation-options {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
</style>


<!-- Order Form -->
<br>
<div id="order-form">


    <h2 id="est-order">ご注文・見積書作成</h2>
    <div style="overflow: unset!important;">
        <div class="fixed-contrainer">
            <h3 class="red">【ラバーストラップ】</h3>
            <span class="total-price"><span class="prd_total">0</span>円（税込）</span>
        </div>
        <div style="clear: both;"></div>
        <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
            <div class="step-box">
                <table class="table_rubber" style="padding: 0">
                    <tr>
                        <td>ご注文タイプ</td>
                        <td><span id="sample-prd-pcs">-</span></td>
                    </tr>
                    <tr>
                        <td>サイズ</td>
                        <td><span id="sample-prd-size">-</span></td>
                    </tr>
                    <tr>
                        <td>裏面印刷</td>
                        <td><span id="sample-prd-screen">-</span></td>
                    </tr>
                    <tr>
                        <td>汚れ防止加工</td>
                        <td><span id="sample-prd-coating">-</span></td>
                    </tr>
                    <tr>
                        <td>数量</td>
                        <td><span id="sample-prd-qty">-</span></td>
                    </tr>
                    <tr>
                        <td>試作品</td>
                        <td><span id="sample-prd-samp">-</span></td>
                    </tr>
                    <tr>
                        <td>データトレース</td>
                        <td><span id="sample-prd-trace">-</span></td>
                    </tr>
                </table>
            </div>
            <div class="step-box line2" style="text-align: center;">
                <img data-src="/products/images/HM_part1-2.webp" width="135" height="135" id="sample-part-pic"
                    class="picpro lazy" loading="lazy"><br />
                <span id="sample-part-name">通常松葉（カニカン）</span>
            </div>
            <div class="step-box line2" style="text-align: center;">
                <img data-src="/products/acrylic/img/coming-soon.webp" width="135" height="135"
                    id="sample-paper-pic" class="picpro lazy" loading="lazy"><br />台紙:<span
                    id="sample-paper-name">なし</span>
            </div>
        </div>
        <div class="step-container">
            <div class="step-box step-list">
                <ul>
                    <li id="dot-step1" class="active">
                        <div class="step-number">1</div><span class="step-details">ご注文タイプ・裏面印刷</span>
                    </li>
                    <li id="dot-step2">
                        <div class="step-number">2</div><span class="step-details">アタッチメント・台紙等</span>
                    </li>
                    <li id="dot-step3">
                        <div class="step-number">3</div><span class="step-details">製品仕様・製作料金</span>
                    </li>
                </ul>
            </div>
        </div>
        <form action="" method="post" name="form" id="form" enctype="multipart/form-data">
            <div style="display: table-column;"><input type="text" name="ItemType" id="strap" value="ラバーストラップ" />
            </div>

            <div class="estimate-content" id="step1">
                <h3>以前のご注文と同じデザインでの製作ですか？</h3>
                <div class="part-container">
                    <div class="part-content">
                        <label class="part-name"><input type="radio" name="ItemDesignRepeat" value="いいえ"
                                onclick="$('.repeat').hide();" {{ $RepeatSelected_1 ?? 'checked' }}>いいえ <span
                                class="checkmark"></span></label>
                    </div>
                    <div class="part-content">
                        <label class="part-name"><input type="radio" name="ItemDesignRepeat" value="はい"
                                onclick="$('.repeat').show();" {{ $RepeatSelected_2 ?? '' }}>はい<span
                                class="checkmark"></span></label>
                    </div>
                </div>

                <div class="repeat"
                    style="{{ $RepeatStyle_2 ?? (($RepeatSelected_2 ?? '') === 'checked' ? '' : 'display:none;') }}">
                    <h3>前回ご注文の管理番号等がもしおわかりでしたら、ご入力ください。</h3>
                    <div class="part-container">
                        <div class="part-content">
                            <label class="part-name">
                                <input type="text" name="design_no" value="{{ $design_no ?? '' }}">
                            </label>
                        </div>
                    </div>
                </div>

                <h3>ご注文タイプ</h3><a class="btn-details inline" href="javascript:void(0)" for="modal-3"
                    style="cursor: pointer;" onclick="$('#modal-3').prop('checked',true)">詳細</a>
                <input class="modal-state" id="modal-3" type="checkbox">
                <div class="modal">
                    <label class="modal__bg" for="modal-3"></label>
                    <div class="modal__inner modal1">
                        <label class="modal__close" for="modal-3"></label>
                        <div class="flex-container b-bottom p-bottom">
                            <div class="icon-img"><img class="lazy"
                                    data-src="/products/images/icon-standard-pc.webp" width="122" height="122"
                                    loading="lazy"></div>
                            <div class="icon-text">
                                <h4>配布用ノベルティ製品として十分な品質とコストパフォーマンスを両立</h4>
                                <p>
                                    通常のラバーストラップのご注文はスタンダートプランをご利用下さい。来店されたお客様への景品や粗品、イベントでの販売などに最適です。玩具や、趣味としての販売にお使い頂くのに十分な品質を確保しております。また、業界最速での納期をご提供しながら、コストパフォーマンスの高さを実現。特に法人のお客様の大ロット・短納期へのご要望、台紙や同梱する書類などへの対応も含めて専任の担当者がご希望にお応えできる体制を構築しております。<br /><a
                                        href="https://hotmobily.jp/products/quality.html#quality-check1">スタンダートの品質基準</a>
                                </p>
                                <div>&nbsp;</div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="flex-container b-bottom p-bottom">
                            <div class="icon-img"><img class="lazy" data-src="/products/images/icon-rush-pc.jpg"
                                    width="122" height="122" loading="lazy"></div>
                            <div class="icon-text">
                                <h4>7営業日出荷。業界最速のスピードで製作</h4>
                                <p>
                                    原稿確定日より、7営業日後に出荷いたします。例）月曜日に原稿確定の場合、翌週火曜日に出荷<br />スタンダードと同じ品質とコストパフォーマンスで、納期を縮めることができます。「とにかく早く作りたい！」とお考えのお客様に最適。このプランは、200個までのご注文で選択いただけます。<br /><a
                                        href="https://hotmobily.jp/products/quality.html#quality-check1">スタンダード（スピード発送）の品質基準はスタンダートの品質基準をご覧ください</a>
                                </p>
                                <div>&nbsp;</div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="flex-container b-bottom p-bottom">
                            <div class="icon-img"><img class="lazy"
                                    data-src="/products/images/icon-premium-pc.webp" width="122" height="122"
                                    loading="lazy"></div>
                            <div class="icon-text">
                                <h4>品質重視。販売用製品として十分な品質を保証</h4>
                                <p>
                                    物販サイトや店頭での販売や限られた大切なお客様への配布などに最適です。スタンダートプランとの一番の違いは品質の高さです。通常の玩具やノベルティ製品に要求される品質をはるかに超えた卓越した逸品としての品質を確保しております。海外での検査に加え、日本国内の専門検査会社での検査を行い品質を保証致します。<br />また、ハイスペックな製品をお求めのお客様に対応する為、製作可能な色数や裏面印刷へのこだわりなど、専任の担当者が細部までヒアリングを行い、対応させて頂きます。<br /><a
                                        href="https://hotmobily.jp/products/quality.html#quality-check2">プレミアムの品質基準</a>
                                </p>
                                <div>&nbsp;</div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="flex-container p-bottom">
                            <div class="icon-img"><img class="lazy"
                                    data-src="/products/images/icon-hotmobilyfan-pc.webp" width="122"
                                    height="122" loading="lazy"></div>
                            <div class="icon-text">
                                <h4>ラバスト製作の入門プラン。業界最安値であなたの創作意欲に応えます</h4>
                                <p>
                                    10個9,900円（税込)。ラバスト製作の初心者向け入門プランです。ラバストと他の製品の大きな違いは、事前に金型を作る必要があるので、ラバスト独特のデザインに変更しないといけない点です。こういった所を、できる限り小予算で体験して頂いたり、これから本格的にラバストを含めたグッズ製作をやってみようという方を念頭に置いたプランです。<br /><span
                                        class="font_s">・このサービスは、個人のお客様専用のサービスです。<br />・このサービスをご注文頂くお客様は、ホットモバイリーのツイッター(@GoodsYe)のフォローをお願いしております。<br />・データトレースも製作料金に含まれますので、どの様なデータでも大丈夫です。<br />・ご納期の指定はできません。<br />・見積書、請求書、領収書の発行はできません。WEBサイトからのご注文のみとなります。<br />ホットモバイリーファンの品質基準は<a
                                            href="https://hotmobily.jp/products/quality.html#quality-check1">スタンダートの品質基準をご覧ください</a></span>
                                </p>
                                <div>&nbsp;</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <p class="new-text" style="color:red">中国工場の春節休みに伴い、現在通常納期以外の納期に対応しておりません。ご理解のほどお願い申し上げます。詳細は<a href="/campaign/202602" target="_blank">こちら</a></p> -->




                <div class="part-container">
                    <div class="part-content"><label class="part-name"><input type="radio" name="ItemPCS"
                                id="pcs1" value="スタンダード" onclick="click_typeorder_enabled();clearValue();"
                                {{ $lsSelected_1pcs ?? '' }}>スタンダード <span class="checkmark"></span></label></div>
                    <div class="part-content" {{ $delivery_disabled ?? '' }}><label class="part-name"><input
                                type="radio" name="ItemPCS" id="pcs4" value="スタンダード（スピード7営業日発送）"
                                onclick="click_typeorder_enabled();clearValue();" {{ $lsSelected_4pcs ?? '' }}
                                {{ $planDisabled ?? '' }}>スタンダード（スピード7営業日発送） <span class="checkmark"></span></label>
                    </div>
                    <div class="part-content"><label class="part-name"><input type="radio" name="ItemPCS"
                                id="pcs2" value="プレミアム" onclick="click_typeorder_disabled();clearValue();"
                                {{ $lsSelected_2pcs ?? '' }} {{ $planDisabled ?? '' }}>プレミアム <span
                                class="checkmark"></span></label></div>
                    <div class="part-content"><label class="part-name"><input type="radio" name="ItemPCS"
                                id="pcs3" value="ホットモバイリーファン"
                                onclick="type_special_disabled('t1');clearValue();" {{ $lsSelected_3pcs ?? '' }}
                                {{ $planDisabled ?? '' }}>ホットモバイリーファン (10個 9,900円税込)<span
                                class="checkmark"></span></label>
                    </div>
                    <span style="color: red" id="error_pcs"></span>
                    <div class="pcs_option">
                        <p class="pcs_group"><span class="pcs_01" id="pcs_status"></span>
                            <span id="pcs_txt"></span>
                        </p>
                        <p class="pcs_info">
                            ・このサービスは、個人のお客様専用のサービスです。<br />・このサービスをご注文頂くお客様は、ホットモバイリーのツイッター(@GoodsYe)のフォローをお願いしております。<br />・ホットモバイリーファンは、スタンダートの品質基準と同じ製品です。<br />・製作料金は、送料込みの金額です。<br />・製品の色数は12色以内でお願い致します。<br />・データトレースも製作料金に含まれますので、どの様なデータでも大丈夫です。<br />・製品の裏面へのシルク印刷につきましては、申し訳ございませんが対応しておりません。<br />・ご注文製品は、本WEBサイトの生産実績に掲載させて頂く場合がございます。<br />・製品は製作開始から約3週間～1ヵ月程度でのご納品となります。<br />・申し訳ございませんが、ご納期の指定はできません。<br />・見積書、請求書、領収書の発行はできません。<br />
                        </p>
                    </div>
                </div>
                <h3>ベース厚さ</h3><a class="btn-details inline" href="javascript:void(0)" for="modal-4"
                    style="cursor: pointer;" onclick="$('#modal-4').prop('checked',true)">詳細</a>
                <input class="modal-state" id="modal-4" type="checkbox">
                <div class="modal">
                    <label class="modal__bg" for="modal-4"></label>
                    <div class="modal__inner modal1" style="height: fit-content;"><label class="modal__close"
                            for="modal-4"></label>最下層の厚みは、通常3mmでございます。ハイインパクトの最下層は5mmとなりまして、製品単価はスタンダード+20％増、プレミアム+10％増、となります。
                    </div>
                </div>
                <div class="part-container">
                    <div class="part-content"><label class="part-name"><input type="radio" id="normal_size"
                                name="ItemSize" value="通常（80*80/3mm厚）" {{ $tickness0_checked ?? '' }}
                                onclick="clearValue();" />通常（3mm厚） <span class="checkmark"></span></label></div>
                    <div class="part-content"><label class="part-name"><input type="radio" id="big_size"
                                name="ItemSize" value="ハイインパクト（80*80/5mm厚）" {{ $tickness1_checked ?? '' }}
                                onclick="clearValue();" />ハイインパクト（5mm厚） <span class="checkmark"></span></label></div>
                </div>

                <h3>特殊素材（蓄光／蛍光／ラメ／金色銀色）</h3>
                <div class="part-container">
                    <div class="part-content"><label class="part-name"><input type="radio" name="ItemMaterial"
                                value="特殊素材なし" {{ $material0_checked ?? '' }} onclick="clearValue();" />特殊素材なし <span
                                class="checkmark"></span></label></div>
                    <div class="part-content"><label class="part-name"><input type="radio" name="ItemMaterial"
                                value="特殊素材あり" {{ $material1_checked ?? '' }} onclick="clearValue();" />特殊素材あり <span
                                class="checkmark"></span></label></div>
                </div>

                <h3>裏面印刷</h3>
                <div class="part-container">
                    <div class="part-content"><label class="part-name"><input type="radio" name="silk_print"
                                id="nashiprint" value="印刷なし" {{ $printing1_checked ?? '' }}
                                onclick="clearValue();" />印刷なし <span class="checkmark"></span></label></div>
                    <div class="part-content"><label class="part-name"><input type="radio" name="silk_print"
                                id="ariprint" value="単色（シルク）印刷" {{ $printing2_checked ?? '' }}
                                onclick="clearValue();" />単色（シルク）印刷 <span class="checkmark"></span></label></div>
                    <div class="part-content"><label class="part-name"><input type="radio" name="silk_print"
                                id="fcprint" value="フルカラー印刷" {{ $printing3_checked ?? '' }}
                                onclick="clearValue();" />フルカラー印刷
                            <span class="checkmark"></span></label></div>
                    <span style="color: red" id="error_print"></span>
                    <font color="red">※プレミアムは裏面印刷が無料</font>
                </div>
                <h3>汚れ防止加工</h3><a class="btn-details inline" href="javascript:void(0)" for="modal-2"
                    style="cursor: pointer;" onclick="$('#modal-2').prop('checked',true)">詳細</a>
                <input class="modal-state" id="modal-2" type="checkbox">
                <div class="modal">
                    <label class="modal__bg" for="modal-2"></label>
                    <div class="modal__inner modal1" style="height: fit-content;">
                        <label class="modal__close" for="modal-2"></label>
                        <img src="/products/images/banner-coating.webp" width="660" height="327"
                            loading="lazy"><br>
                        <p>ラバー製品に汚れ防止加工が出来ます。汚れが付着した場合、水洗いして頂くで簡単に汚れが落ちます。</p>
                        <p class="red">スタンダード（スピード7営業日発送）では、汚れ防止加工はお選びいただけません。</p>
                    </div>
                </div>
                <div class="part-container">
                    <div class="part-content"><label class="part-name"><input type="radio" name="coating"
                                id="coating0" value="汚れ防止加工なし" {{ $coating0_checked ?? '' }}
                                onclick="clearValue();" />汚れ防止加工なし
                            <span class="checkmark"></span></label></div>
                    <div class="part-content"><label class="part-name"><input type="radio" name="coating"
                                id="coating1" value="汚れ防止加工あり" {{ $coating1_checked ?? '' }}
                                onclick="clearValue();" />汚れ防止加工あり (納期+3～5営業日） <span class="checkmark"></span></label>
                    </div>
                    <span style="color: red" id="error_coating"></span>
                </div>

                <div class="color-variation-heading">
                    <h3>カラーバリエーション</h3>
                    <a class="btn-details" href="javascript:void(0)" for="modal-5" style="cursor: pointer;"
                        onclick="$('#modal-5').prop('checked',true)">詳細</a>
                </div>
                <input class="modal-state" id="modal-5" type="checkbox">
                <div class="modal">
                    <label class="modal__bg" for="modal-5"></label>
                    <div class="modal__inner modal1" style="height: fit-content;">
                        <label class="modal__close" for="modal-5"></label>
                        <p>
                            （詳細）<br />
                            2種以上のカラーバリエーションを組み合わせて1つの注文にする事ができます。<br />
                            <span class="red">複数種のデザインを1度にご注文できるわけではございません。</span>
                        <div class="d-flex">
                            <div class="flex-item">
                                <img src="/products/images/HM_design1.webp" width="300" height="300"
                                    loading="lazy">
                            </div>
                            <div class="flex-item">
                                <img src="/products/images/HM_design2.webp" width="300" height="300"
                                    loading="lazy">
                            </div>
                        </div>
                        カラーバリエーション2種類目から＜3,300円(税込)/デザイン＞<br />
                        ※カラーバリエーション毎の個数は、入稿データ内またはご連絡事項に記載してください。<br />
                        ※4種類まで可能。各バリエーションの最小ロットは50個です。<br />
                        </p>
                    </div>
                </div>
                <div class="color-variation-options">
                    <label class="color-variation-option">
                        <input type="radio" name="ItemDesignVariation" value="1種類"
                            {{ $lsSelected_1design ?? '' }} onclick="clearValue();">
                        <span>1種類</span>
                    </label>
                    <label class="color-variation-option">
                        <input type="radio" name="ItemDesignVariation" value="2種類"
                            {{ $lsSelected_2design ?? '' }} onclick="clearValue();">
                        <span>2種類</span>
                    </label>
                    <label class="color-variation-option">
                        <input type="radio" name="ItemDesignVariation" value="3種類"
                            {{ $lsSelected_3design ?? '' }} onclick="clearValue();">
                        <span>3種類</span>
                    </label>
                    <label class="color-variation-option">
                        <input type="radio" name="ItemDesignVariation" value="4種類"
                            {{ $lsSelected_4design ?? '' }} onclick="clearValue();">
                        <span>4種類</span>
                    </label>
                </div>
                <p>1種類カラーバリエーションが増えると、＋3300円（税込）</p>
                <div>&nbsp;</div>
                <h3>ご注文本数</h3>
                <div class="part-container">
                    <div class="part-content">
                        <label class="part-name" id="label-qty">ご注文・御見積数量&nbsp;&nbsp;<input type="number"
                                name="numberOf" id="no_of_order" class="right qty-inp"
                                onchange="this.value=format_number(this.value);" value="{{ $numberOf ?? '' }}"
                                style="text-align: right;"><br /></label>
                        <div id="err_numberOf_mess">
                        </div>
                    </div>
                </div>
                <span style="color: red" id="error_message"></span>
            </div>
            <div class="estimate-content" id="step2">
                <h3>アタッチメント</h3>
                <div class="flex-container">
                    <div class="preview-container">
                        <div class="preview-sub flex-container">
                            @foreach ($attachments as $idx => $att)
                                <div class="flex-item">
                                    <label class="part-name">
                                        <input type="radio" name="part" value="{{ $att['part_name'] }}"
                                            onclick="getPartData('{{ $att['part_name'] }}')"
                                            {{ $idx === 0 ? 'checked' : '' }}>
                                        <img data-src="{{ $att['part_pic'] }}" width="95" height="95"
                                            class="picpro lazy" loading="lazy">
                                        <br><span class="part_price_std">+{{ $att['part_price'] * 1.1 }}円</span><span
                                            class="part_price_prm">+0円</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <h3>台紙</h3>
                <div class="part-container">
                    <div class="part-content">
                        <label class="part-name">
                            <div class="switch_off_button b2 switch_off">
                                <input type='hidden' value='なし' name='paper_select'>
                                <input type="checkbox" class="checkbox" name="paper_select" value="あり"
                                    onclick="check_val('next')" {{ ($paper_select ?? '') === 'あり' ? 'checked' : '' }}>
                                <div class="knobs"><span></span></div>
                                <div class="layer"></div>
                            </div>
                            台紙印刷
                        </label>
                        <div class="error" id="paper-error"></div>
                    </div>
                </div>
                <div class="flex-container paper-container">
                    <div class="preview-container">
                        <div class="preview-sub flex-container" id="paper-preview">
                            @include('products.partials.paper-preview')
                        </div>
                    </div>
                </div>
                <h3>試作品・データトレース</h3>
                <div class="part-container">
                    <div class="part-content">
                        <label class="part-name">
                            <div class="switch_off_button b2 switch_off">
                                <input type='hidden' value='なし' name='SendPrototype'>
                                <input type="checkbox" class="checkbox" name="SendPrototype" value="あり"
                                    onclick="setToInput();" {{ $sendActual_checked ?? '' }}>
                                <div class="knobs"><span></span></div>
                                <div class="layer"></div>
                            </div>
                            試作品
                        </label>
                    </div>
                    <font color="red">※プレミアムは試作品代金が無料</font>
                    <font color="red">※ご注文納期とは別に、6営業日+配送2日がかかります。</font>
                </div>
                <div class="part-container">
                    <div class="part-content">
                        <label class="part-name">
                            <div class="switch_off_button b2 switch_off">
                                <input type='hidden' value='なし' name='DeFormat'>
                                <input type="checkbox" class="checkbox" name="DeFormat" value="あり"
                                    onclick="setToInput();" {{ $others_checked ?? '' }}>
                                <div class="knobs"><span></span></div>
                                <div class="layer"></div>
                            </div>
                            データトレース
                        </label>
                    </div>
                    <font color="red">※プレミアムはトレース代金が無料</font>
                </div>
            </div>
            <div class="estimate-content flex-item" id="step3">
                <div class="flex-container">
                    <div class="flex-item">
                        <h3>製品仕様</h3>
                        <table class="table_rubber">
                            <tbody>
                                <tr>
                                    <td class="TableLeft">ご注文タイプ</td>
                                    <td class="" id="prd_ItemPCS" style="text-align: left;"></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">サイズ</td>
                                    <td class="" id="prd_ItemSize" style="text-align: left;"></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">裏面印刷</td>
                                    <td class="" id="prd_silk_print" style="text-align: left;"></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">汚れ防止加工</td>
                                    <td class="" id="prd_coating" style="text-align: left;"></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">ご注文本数</td>
                                    <td class="" id="prd_qty" style="text-align: left;"></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">アタッチメント</td>
                                    <td class="" id="prd_part" style="text-align: left;"></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">台紙</td>
                                    <td class="" id="prd_paper" style="text-align: left;"></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">試作品</td>
                                    <td class="" id="prd_SendPrototype" style="text-align: left;">なし</td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">データトレース</td>
                                    <td class="" id="prd_DeFormat" style="text-align: left;">なし</td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">カラーバリエーション</td>
                                    <td class="" id="prd_ItemDesign" style="text-align: left;"></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">特殊素材</td>
                                    <td class="" id="prd_ItemMaterial" style="text-align: left;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="flex-item">
                        <h3>製作料金</h3>
                        <table class="table_rubber total_price_tbl">
                            <tbody>
                                <tr>
                                    <td class="TableLeft">商品代金</td>
                                    <td class=""><input style="text-align: right;" type="text"
                                            size="16" name="StrapPrice" readonly="readonly" id="textfield7"
                                            class="right" value="{{ $StrapPrice ?? '' }}">円</td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">裏面印刷代金</td>
                                    <td class=""><input style="text-align: right;" type="text"
                                            size="16" name="SilkPrint" readonly="readonly" id="textfield13"
                                            class="right" value="{{ $SilkPrint ?? '' }}" />円</td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">汚れ防止加工</td>
                                    <td class=""><input style="text-align: right;" type="text"
                                            size="16" name="coatingPrice" readonly="readonly"
                                            id="textfield13_2" class="right" value="{{ $coatingPrice ?? '' }}">円
                                    </td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">アタッチメント</td>
                                    <td class=""><input style="text-align: right;" type="text"
                                            size="16" name="PartPrice" readonly="readonly" id="textfield7_1"
                                            class="right" value="{{ $PartPrice ?? '' }}">円</td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">台紙</td>
                                    <td class=""><input style="text-align: right;" type="text"
                                            size="16" name="PaperPrice" readonly="readonly" id="textfield7_2"
                                            class="right" value="{{ $PaperPrice ?? '' }}">円</td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">試作品</td>
                                    <td class=""><input style="text-align: right;" type="text"
                                            size="16" name="ProShipping" readonly="readonly" id="textfield3"
                                            class="right" value="{{ $ProShipping ?? '' }}">円</td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">データトレース</td>
                                    <td class=""><input style="text-align: right;" type="text"
                                            size="16" name="TraceCharge" readonly="readonly" id="textfield4"
                                            class="right" value="{{ $TraceCharge ?? '' }}">円</td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">カラーバリエーション</td>
                                    <td class=""><input style="text-align: right;" type="text"
                                            size="16" name="DesignsCharge" readonly="readonly"
                                            id="DesignsCharge" class="right" value="{{ $DesignsCharge ?? '' }}">円
                                    </td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">特殊素材</td>
                                    <td class=""><input style="text-align: right;" type="text"
                                            size="16" name="MaterialCharge" readonly="readonly"
                                            id="MaterialCharge" class="right" value="{{ $MaterialCharge ?? '' }}">円
                                    </td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">小計(税込)</td>
                                    <td class=""><input style="text-align: right;" type="text"
                                            size="16" name="BeforeTax" readonly="readonly" id="textfield9"
                                            class="right" value="{{ $BeforeTax ?? '' }}">円</td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">お値引き</td>
                                    <td class=""><input style="text-align: right;" type="text"
                                            size="16" name="discount" readonly="readonly" id="textfield_dis"
                                            class="right" value="{{ $discount ?? '' }}">円</td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">合計(税込)</td>
                                    <td class=""><input style="text-align: right;" type="text"
                                            size="16" name="grandTotal" readonly="readonly" id="textfield11"
                                            class="right" value="{{ $grandTotal ?? '' }}">円</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <table class="table_rubber total_price_tbl">
                    <tbody>
                        <tr id="">
                            <td colspan="2" style="background: unset;border: unset;">
                                <div class="flex-container btn-container">
                                    <input type="button" class="btn clr-btn flex-item" value="CLEAR"
                                        id=""
                                        onclick="clearValue();$('#cus_detail').hide();valid_chk_btn('step1');" />
                                    <a href="javascript:void(0)" class="btn btn-back"
                                        onclick="valid_chk_btn('step1');$('#cus_detail').hide();">製作条件修正</a>
                                    <a href="javascript:void(0)" class="btn btn-back"
                                        onclick="valid_chk_btn('step2');$('#cus_detail').hide();">ｱﾀｯﾁﾒﾝﾄ修正</a>
                                    <input type="button" class="btn est-btn flex-item" value="見積書"
                                        id="button_pdf2" onclick="$('#cus_detail').toggle()" />
                                    <input type="button" class="btn ord-btn flex-item" value="ご注文情報入力へ"
                                        for="modal-ord" onclick="$('#modal-ord').prop('checked',true)" />
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input class="modal-state" id="modal-ord" type="checkbox">
                <div class="modal">
                    <label class="modal__bg" for="modal-ord"></label>
                    <div class="modal__inner modal1" style="height: fit-content;">
                        <label class="modal__close" for="modal-ord"></label>
                        <p>【ご確認ください】</p>
                        <p class="red">毎営業日正午(昼の12時)までに仕上がりイメージ図のご承認及び製作料金のお支払いの両方が完了した場合、当日が1営業日目となります。</p>
                        <p>それ以降は翌営業日扱いとなります。ご注文日及びデータのご入稿日ではございません。</p>
                        <diV style="display: grid;justify-items: center;">
                            <picture>
                                <source media="(max-width:650px)" srcset="/img/delivery_10days_notice_mb.jpg"
                                    style="width: 100%;">
                                <img src="/img/delivery_10days_notice.jpg" alt="Flowers" style="width:100%;"
                                    loading="lazy">
                            </picture>
                            <input type="button" class="btn btn-back flex-item" value="OK" for="modal-ord"
                                onclick="comSubmit('', '_top', form); " />
                        </diV>

                    </div>
                </div>
            </div>
            <div id="acrylic-btn" class="btn-container">
                <a href="javascript:void(0)" id="back" class="btn btn-back"
                    onclick="valid_chk_btn('back')">戻る</a>
                <a href="javascript:void(0)" id="next" class="btn btn-next"
                    onclick="valid_chk_btn('next')">アタッチメント・オプション入力へ</a>
            </div>
        </form>
        <div id="cus_detail" style="display: none;" align="center">
            <table class="table_rubber" style="display: table;">
                <tbody>
                    <tr>
                        <td class="TableLeft">お名前（姓）</td>
                        <td class=""><input name="Name_S" id="sname" type="text" maxlength="100"
                                value="">
                        </td>
                    </tr>
                    <tr>
                        <td class="TableLeft">お名前（名）</td>
                        <td class=""><input name="Name_F" id="fname" type="text" maxlength="100"
                                value="">
                        </td>
                    </tr>
                    <tr>
                        <td class="TableLeft">法人名</td>
                        <td class=""><input name="Corp_Name" id="Corp_Name" type="text" value=""
                                size="45" maxlength="100"></td>
                    </tr>
                    <tr>
                        <td class="TableLeft">郵便番号</td>
                        <td class=""><input type="text" id="zip" name="zip" maxlength="8"
                                size="15" value="">&nbsp;<input type="button" id="src_btn"
                                onclick="address_fn();" value="住所に変換"><br><span id="error"
                                style="color:red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="TableLeft">都道府県</td>
                        <td class=""><input type="text" id="address1" name="prefc" value=""></td>
                    </tr>
                    <tr>
                        <td class="TableLeft">以降の住所</td>
                        <td class=""><input id="address2" name="address" type="text"
                                class="contact_text1" value=""></td>
                    </tr>
                    <tr>
                        <td class="TableLeft">番地、建物名、部屋番号</td>
                        <td class=""><input id="address_street" name="address_street" type="text"
                                class="contact_text1" value=""></td>
                    </tr>
                    <tr>
                        <td class="TableLeft">TELハイフンなし</td>
                        <td class=""><input name="tel" id="tel" type="text" maxlength="11"
                                value=""></td>
                    </tr>
                    <tr>
                        <td class="TableLeft">お客様メモ欄</td>
                        <td class=""><input name="comment" id="comment" type="text" size="45"
                                value=""></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center" style="padding: 10px;background: unset;border: unset;">
                            <input id="button_pdf" type="button"
                                style="cursor:pointer;height: 30px;width: 250px;color: red"
                                onclick="Javascript:validate('gcd');$('.loading').show();" value="御社情報確定（PDF出力）" />
                            <div class="remark">&nbsp;※社名や会社名の入力は任意です</div><span id="validate_error"
                                style="color:red"></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- End Order Form -->
