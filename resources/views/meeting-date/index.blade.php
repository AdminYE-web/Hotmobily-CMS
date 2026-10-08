@extends('layouts.product')

@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="大阪,東京,営業,訪問,打ち合わせ">
    <meta name="description" content="オリジナルグッズ製作に関して、お打ち合わせをご希望のお客様はこちらからご依頼ください。東京23区、横浜市、川崎市、大阪市近郊の法人様が対象です。">
    <meta name="robots" content="index,follow">
    <title>お打合せのご依頼、営業担当呼び出しフォーム。都内及び大阪市近郊</title>

    @include('partials.legacy-head-products')
    <link rel="stylesheet" href="{{ asset('css/meeting_date_2nd.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('meeting_date/css/pikaday.css') }}" type="text/css">
    <style>
        #content_wrapper .meeting-date-page {
            width: 100%;
            color: #281600;
            font-size: 13.6px;
            line-height: normal;
            letter-spacing: normal;
        }

        .meeting-date-page .meeting-date-copy {
            margin: 0 auto;
            max-width: 771px;
        }

        .meeting-date-page .meeting-date-copy p {
            margin: 0;
        }

        /* The original page uses the larger .new-text block for the introduction. */
        .meeting-date-page .meeting-date-copy {
            font-size: 16px !important;
            letter-spacing: 0.05em !important;
            line-height: 150% !important;
        }

        .meeting-date-page .red {
            color: #f00;
        }

        .meeting-date-page .symbolRed {
            color: #f00;
        }

        .meeting-date-page .meeting-date-form-wrap {
            width: 100%;
            max-width: 771px;
            margin: 0 auto;
        }

        .meeting-date-page .form-table {
            width: 100%;
            box-sizing: border-box;
            grid-template-columns: 180px minmax(0, 1fr);
            margin-top: 10px;
            padding: 5px;
        }

        .meeting-date-page .form-left,
        .meeting-date-page .form-right {
            box-sizing: border-box;
            min-width: 0;
        }

        .meeting-date-page .form-left {
            overflow-wrap: anywhere;
        }

        .meeting-date-page .form-right {
            gap: 0;
        }

        .meeting-date-page input[type="text"],
        .meeting-date-page input[type="email"],
        .meeting-date-page input[type="tel"],
        .meeting-date-page input[type="date"],
        .meeting-date-page input[type="number"],
        .meeting-date-page select,
        .meeting-date-page textarea {
            box-sizing: content-box;
            max-width: none;
            min-height: 0;
            padding: 0;
            border: 2px inset rgb(118, 118, 118);
            border-radius: 0;
            background: #fff;
            color: #000;
            font: 13.3333px Arial, sans-serif;
            line-height: normal;
        }

        .meeting-date-page .form-right > input[type="text"],
        .meeting-date-page .form-right > input[type="email"],
        .meeting-date-page .form-right > input[type="tel"],
        .meeting-date-page .form-right > input[type="date"],
        .meeting-date-page .form-right > textarea {
            flex: 0 1 auto;
            width: 171px;
        }

        .meeting-date-page .form-right#fullw > input,
        .meeting-date-page .form-right#fullw > textarea {
            flex: 1 1 auto;
            width: -webkit-fill-available;
        }

        .meeting-date-page textarea {
            border: 1px solid #767676;
            font: 13.3333px monospace;
            resize: both;
        }

        .meeting-date-page select {
            border: 1px solid #767676;
        }

        .meeting-date-page .meeting-radio-row {
            display: block;
        }

        .meeting-date-page .meeting-radio {
            display: inline;
            margin-right: 5px;
            cursor: pointer;
            white-space: nowrap;
        }

        .meeting-date-page .meeting-radio input {
            width: auto;
            min-height: 0;
            height: auto;
            margin: 3px;
        }

        .meeting-date-page .meeting-date-note {
            color: #666;
            font-size: 12px;
        }

        .meeting-date-page .meeting-date-error {
            display: block;
            flex-basis: 100%;
            color: #d40000;
            font-size: 12px;
        }

        .meeting-date-page .meeting-date-alert {
            max-width: 771px;
            margin: 0 auto 12px;
            padding: 8px 12px;
            border: 1px solid #e7a3a3;
            background: #fff1f1;
            color: #a40000;
        }

        .meeting-date-page .meeting-date-actions {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 20px auto 10px;
            text-align: center;
        }

        .meeting-date-page .meeting-date-button {
            min-width: 0;
            min-height: 0;
            height: 35px;
            box-sizing: border-box;
            padding: 5px;
            border: 2px outset #000;
            border-radius: 0;
            background: #f0f0f0;
            color: #000;
            cursor: pointer;
            font: 13.3333px Arial, sans-serif;
            font-weight: normal;
            text-decoration: none;
            display: inline-block;
        }

        .meeting-date-page .meeting-date-button--next {
            border: 2px solid #76a0b0;
            background: #76a0b0;
            color: #fff;
        }

        .meeting-date-page .meeting-date-button:hover {
            opacity: .86;
        }

        .meeting-date-page .zip-row {
            display: block;
            flex: 0 1 auto;
        }

        .meeting-date-page .zip-row input {
            flex: 0 1 auto;
            width: 136px;
        }

        .meeting-date-page .zip-row button {
            min-height: 0;
            height: 25px;
            padding: 0;
            border: 2px outset #000;
            background: #f0f0f0;
            color: #000;
            cursor: pointer;
            font: 13.3333px Arial, sans-serif;
        }

        .meeting-date-page .zip-error {
            flex-basis: 100%;
            color: #d40000;
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .meeting-date-page .meeting-date-copy,
            .meeting-date-page .meeting-date-form-wrap,
            .meeting-date-page .meeting-date-alert {
                max-width: 100%;
            }

            .meeting-date-page .form-table {
                grid-template-columns: 30% 70%;
                padding: 3px;
            }

            .meeting-date-page .form-left {
                padding: 5px;
                line-height: 1.5;
            }

            .meeting-date-page .form-right {
                padding: 5px 4px 5px 8px;
                font-size: 12px;
            }

            .meeting-date-page .meeting-date-actions {
                gap: 12px;
            }

            .meeting-date-page .meeting-date-button {
                min-width: 0;
                flex: 1 1 0;
            }
        }

        @media (max-width: 425px) {
            #content_wrapper .meeting-date-page {
                font-size: 12px;
            }

            .meeting-date-page .titleMeeting {
                height: 72px;
            }

            .meeting-date-page .SubtitleMeeting {
                height: 33px;
            }

            .meeting-date-page .textMeetingDate01 {
                height: 45px;
            }

            .meeting-date-page .form-table {
                grid-template-columns: 32% 68%;
            }

            .meeting-date-page .meeting-radio-row {
                gap: 6px 10px;
            }

            .meeting-date-page .zip-row {
                display: block;
            }

            .meeting-date-page .zip-row button {
                margin-top: 6px;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $form = is_array($form ?? null) ? $form : [];
        $inputValue = static fn (string $key, mixed $default = ''): mixed => old($key, $form[$key] ?? $default);
        $dateValue = static function (string $key) use ($inputValue): string {
            $value = (string) $inputValue($key);
            return preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) === 1
                ? str_replace('-', '/', $value)
                : $value;
        };
    @endphp

    <div class="meeting-date-page">
        <div class="titleMeeting" role="img" aria-label="営業担当呼び出しフォーム">営業担当呼び出しフォーム</div>
        <div style="clear: both;">&nbsp;</div>

        @if ($errors->any())
            <div class="meeting-date-alert" role="alert">
                <strong>入力内容をご確認ください。</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="meeting-date-copy">
            <p>
                <span class="red">東京23区、川崎市、横浜市、大阪市近郊の法人のお客様（学校PTAや個人事業主様でもOKです）をご訪問させて頂きます。</span>
                <br><br>
                当社では担当の営業マンが直接製品やサービスのご提案・ご説明をさせて頂けます。WEBサイトだけではなかなかイメージが掴めない。
                価格も含めて相談したい。このような ご要望がございましたら是非お声掛け下さい。
                営業担当が実際にサンプル品をもって御社にお伺いし詳しく説明させて頂きます。
                ご希望のお客様はお手数ですが、バナーをクリックして頂き必要事項をご入力ください。
                お伺いできるエリアは東京23区、川崎市、横浜市、大阪市近郊(京都市、神戸市、奈良市、和歌山市、堺市、吹田市、豊中市)の法人のお客様（学校PTAや個人事業主様でもOKです）が対象となります。 <span class="red">対象エリア外のお客様はまずご相談下さい。</span>
                事情によりお伺いできない場合もございますので、ご了承ください。
                <br><br>
                フォームの必要事項の入力をお願いします。 <span class="red">特に製品のご利用予定日が2週間未満の場合、フォームではなく直接お電話頂いた方が良いです。</span>
                ご検討中の製品、数量、ご希望のご納期など、お分かりになる範囲で結構ですのでできるだけ詳細に記載して頂くとより良いご案内が可能です。
                2営業日経っても営業担当よりご連絡が無い場合、何らかの不具合が発生している可能性がございますので、恐れ入りますがお電話でのご連絡をお願い致します。
            </p>
        </div>

        <div style="clear: both;">&nbsp;</div>
        <div class="SubtitleMeeting">営業担当呼び出しフォーム</div>

        <div class="meeting-date-form-wrap">
            <form action="{{ route('meeting-date.confirm') }}" method="post" id="meeting-date-form">
                @csrf
                <div class="textMeetingDate01">&nbsp;</div>
                <div class="subMenu1"></div>

                <div class="form-table">
                    <div class="form-left">お打ち合わせ方法 <span class="symbolRed">※</span></div>
                    <div class="form-right">
                        <div class="meeting-radio-row">
                            <label class="meeting-radio">
                                <input name="cont_type" type="radio" value="ご訪問" @checked($inputValue('cont_type') === 'ご訪問')>
                                <span>ご訪問</span>
                            </label>
                            <label class="meeting-radio">
                                <input name="cont_type" type="radio" value="ZOOM等リモートミーティング" @checked($inputValue('cont_type') === 'ZOOM等リモートミーティング')>
                                <span>ZOOM等リモートミーティング</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-left">お客様法人名 <span class="symbolRed">※</span></div>
                    <div class="form-right" id="fullw">
                        <input name="Company_Name" type="text" size="80" maxlength="30" value="{{ $inputValue('Company_Name') }}" autocomplete="organization">
                    </div>

                    <div class="form-left">ご担当者氏名 <span class="symbolRed">※</span></div>
                    <div class="form-right" id="fullw">
                        <input name="person_name" type="text" size="55" maxlength="100" value="{{ $inputValue('person_name') }}" autocomplete="name">
                    </div>

                    <div class="form-left">ご担当者部署名</div>
                    <div class="form-right">
                        <input id="department" name="department" type="text" maxlength="100" value="{{ $inputValue('department') }}">
                    </div>

                    <div class="form-left">訪問先郵便番号</div>
                    <div class="form-right">
                        <div class="zip-row">
                            <input id="meeting-zip" name="zip" type="text" size="15" maxlength="8" class="contact_text1" inputmode="numeric" value="{{ $inputValue('zip') }}">
                            <button type="button" id="meeting-zip-button">住所に変換</button>
                            <br><span id="meeting-zip-error" class="zip-error"></span>
                        </div>
                    </div>

                    <div class="form-left">都道府県</div>
                    <div class="form-right">
                        <input id="meeting-prefecture" name="prefc" type="text" value="{{ $inputValue('prefc') }}">
                    </div>

                    <div class="form-left">以降の住所</div>
                    <div class="form-right">
                        <input id="meeting-address" name="address" type="text" value="{{ $inputValue('address') }}">
                    </div>

                    <div class="form-left">番地、建物名、部屋番号</div>
                    <div class="form-right">
                        <input name="address_street" type="text" value="{{ $inputValue('address_street') }}">
                    </div>

                    <div class="form-left">ご連絡先電話番号 <span class="symbolRed">※</span></div>
                    <div class="form-right">
                        <input name="phone_number" type="text" maxlength="11" inputmode="numeric" value="{{ $inputValue('phone_number') }}" autocomplete="tel">&nbsp;&nbsp;(ハイフンは不要です。例 0355002083)
                    </div>

                    <div class="form-left">E-mail <span class="symbolRed">※</span></div>
                    <div class="form-right" id="fullw">
                        <input name="email" type="email" maxlength="60" value="{{ $inputValue('email') }}" autocomplete="email">
                    </div>

                    <div class="form-left">E-mail（確認） <span class="symbolRed">※</span></div>
                    <div class="form-right" id="fullw">
                        <input name="email_confirm" type="email" maxlength="60" value="{{ $inputValue('email_confirm') }}" autocomplete="email">
                    </div>

                    <div class="form-left">ご希望製品</div>
                    <div class="form-right" id="fullw">
                        <input name="expected_product" type="text" maxlength="60" value="{{ $inputValue('expected_product') }}">
                    </div>

                    <div class="form-left">予定数量</div>
                    <div class="form-right">
                        <input name="qty" type="text" maxlength="20" inputmode="numeric" value="{{ $inputValue('qty') }}">
                        <span>個</span>
                    </div>

                    <div class="form-left">ご希望単価</div>
                    <div class="form-right">
                        <input name="expected_price" type="text" maxlength="20" inputmode="decimal" value="{{ $inputValue('expected_price') }}">
                        <span>円</span>
                    </div>

                    <div class="form-left">製品ご利用予定日(納期)</div>
                    <div class="form-right">
                        <input id="Delivery_Date" name="expected_delivery_date" type="text" maxlength="10" inputmode="numeric" value="{{ $dateValue('expected_delivery_date') }}">
                        <span class="meeting-date-note">&nbsp;&nbsp;(YYYY/MM/DD の形式で入力してください。)</span>
                    </div>

                    <div class="form-left">ご希望日時<br>（第一希望）</div>
                    <div class="form-right">
                        <input id="visit_date_1" name="visit_date_1" type="text" maxlength="10" inputmode="numeric" value="{{ $dateValue('visit_date_1') }}">
                        <select name="visit_time_1" aria-label="第一希望の時間">
                            <option value="">-- 時 --</option>
                            @foreach (range(10, 17) as $hour)
                                <option value="{{ $hour }}" @selected((string) $inputValue('visit_time_1') === (string) $hour)>{{ $hour }}</option>
                            @endforeach
                        </select>
                        <span class="meeting-date-note">&nbsp;&nbsp;(YYYY/MM/DD の形式で入力してください。)</span>
                    </div>

                    <div class="form-left">ご希望日時<br>（第二希望)</div>
                    <div class="form-right">
                        <input id="visit_date_2" name="visit_date_2" type="text" maxlength="10" inputmode="numeric" value="{{ $dateValue('visit_date_2') }}">
                        <select name="visit_time_2" aria-label="第二希望の時間">
                            <option value="">-- 時 --</option>
                            @foreach (range(10, 17) as $hour)
                                <option value="{{ $hour }}" @selected((string) $inputValue('visit_time_2') === (string) $hour)>{{ $hour }}</option>
                            @endforeach
                        </select>
                        <span class="meeting-date-note">&nbsp;&nbsp;(YYYY/MM/DD の形式で入力してください。)</span>
                    </div>
                </div>

                <div class="subMenu2"></div>
                <div class="form-table">
                    <div class="form-left">お問い合わせ・ご連絡<br>その他特記事項があれば<br>ご記入ください。</div>
                    <div class="form-right" id="fullw">
                        <textarea name="contactDetail" rows="10">{{ $inputValue('contactDetail') }}</textarea>
                    </div>
                </div>

                <div class="meeting-date-actions">
                    <a class="meeting-date-button" href="{{ route('meeting-date.index', ['mode' => 'MODE_RESET']) }}">リセット</a>
                    <button class="meeting-date-button meeting-date-button--next" type="submit">入力内容の確認</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('meeting_date/js/moment.min.js') }}"></script>
    <script src="{{ asset('meeting_date/js/pikaday.js') }}"></script>
    <script>
        (() => {
            if (typeof Pikaday !== 'function') {
                return;
            }

            const pickerOptions = {
                firstDay: 1,
                minDate: new Date(),
                format: 'YYYY/MM/DD',
                yearRange: [2000, new Date().getFullYear() + 5],
            };

            ['Delivery_Date', 'visit_date_1', 'visit_date_2'].forEach((id) => {
                const field = document.getElementById(id);

                if (field) {
                    new Pikaday({ ...pickerOptions, field });
                }
            });
        })();
    </script>
    <script>
        (() => {
            const zipButton = document.getElementById('meeting-zip-button');
            const zipInput = document.getElementById('meeting-zip');
            const zipError = document.getElementById('meeting-zip-error');
            const prefectureInput = document.getElementById('meeting-prefecture');
            const addressInput = document.getElementById('meeting-address');

            if (!zipButton || !zipInput || !zipError || !prefectureInput || !addressInput) {
                return;
            }

            zipButton.addEventListener('click', async () => {
                const zipcode = zipInput.value.replace(/[^0-9]/g, '');
                zipError.textContent = '';

                if (zipcode.length !== 7) {
                    zipError.textContent = '郵便番号は7桁で入力してください。';
                    return;
                }

                zipButton.disabled = true;

                try {
                    const response = await fetch('https://zipcloud.ibsnet.co.jp/api/search?zipcode=' + encodeURIComponent(zipcode));
                    const result = await response.json();
                    const address = result?.results?.[0];

                    if (!address) {
                        throw new Error('address-not-found');
                    }

                    prefectureInput.value = address.address1 || '';
                    addressInput.value = (address.address2 || '') + (address.address3 || '');
                } catch (error) {
                    zipError.textContent = '住所を取得できませんでした。都道府県と住所を直接入力してください。';
                } finally {
                    zipButton.disabled = false;
                }
            });
        })();
    </script>
@endpush
