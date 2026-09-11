<style>
    /* Keep the legacy order-form structure; only option values come from Admin. */
    #order-form.admin-configured-order-form { margin-top: 24px; }
    #order-form.admin-configured-order-form .configured-summary-table { width: 100%; border-collapse: collapse; }
    #order-form.admin-configured-order-form .configured-summary-table td { padding: 5px 12px; border: 1px solid #ddd; }
    #order-form.admin-configured-order-form .configured-summary-table td:first-child { width: 112px; background: #f3f3f3; text-align: center; }
    #order-form.admin-configured-order-form .configured-summary-image { width: 135px; height: 135px; object-fit: contain; }
    #order-form.admin-configured-order-form .configured-step-list ul { display: flex; margin: 0; padding: 0; list-style: none; }
    #order-form.admin-configured-order-form .configured-step-list li { position: relative; flex: 1; min-width: 0; color: #222; text-align: center; cursor: pointer; }
    #order-form.admin-configured-order-form .configured-step-list li::before { position: absolute; top: 14px; right: 50%; left: -50%; z-index: 0; height: 4px; background: #ddd; content: ''; }
    #order-form.admin-configured-order-form .configured-step-list li:first-child::before { left: 50%; }
    #order-form.admin-configured-order-form .configured-step-list li:last-child::before { right: 50%; }
    #order-form.admin-configured-order-form .configured-step-list li.active::before { background: #8bd0ec; }
    #order-form.admin-configured-order-form .configured-step-number { position: relative; z-index: 1; display: inline-flex; align-items: center; justify-content: center; width: 26px; height: 26px; border: 2px solid #9fd8ed; border-radius: 50%; background: #fff; color: #222; }
    #order-form.admin-configured-order-form .configured-step-list li.active .configured-step-number { border-color: #8bd0ec; background: #429cf1; color: #fff; }
    #order-form.admin-configured-order-form .configured-step-label { display: block; margin-top: 7px; font-size: 12px; line-height: 1.3; }
    #order-form.admin-configured-order-form .configured-estimate-content { display: none; }
    #order-form.admin-configured-order-form .configured-estimate-content.active { display: block; }
    #order-form.admin-configured-order-form .configured-option-group { margin-bottom: 20px; }
    #order-form.admin-configured-order-form .configured-option-heading h3 { margin: 0 0 5px; }
    #order-form.admin-configured-order-form .configured-help-button { display: block; min-width: 58px; padding: 3px 10px; border: 1px solid #c8c8c8; border-radius: 3px; background: #fff; color: #333; font-size: 13px; line-height: 1.35; cursor: pointer; }
    #order-form.admin-configured-order-form .configured-help-button:hover { border-color: #999; background: #f5f5f5; }
    #order-form.admin-configured-order-form .configured-option-help { margin: 0; color: #111; font-size: 14px; line-height: 1.8; white-space: normal; }
    #order-form.admin-configured-order-form .configured-option-help::after { display: block; clear: both; content: ''; }
    #order-form.admin-configured-order-form .configured-option-help p { margin: 0 0 8px; }
    #order-form.admin-configured-order-form .configured-option-help figure.image { max-width: 100%; }
    #order-form.admin-configured-order-form .configured-option-help figure.image img { max-width: 100%; height: auto; }
    #order-form.admin-configured-order-form .configured-option-help figure.image.image-style-align-left { float: left; width: 125px; margin: 0 25px 8px 0; }
    #order-form.admin-configured-order-form .configured-option-help figure.image.image-style-align-right { float: right; width: 125px; margin: 0 0 8px 25px; }
    #order-form.admin-configured-order-form .configured-option-help figure.horizontal-line { clear: both; margin: 20px 0; }
    #order-form.admin-configured-order-form .configured-option-help figure.horizontal-line hr,
    #order-form.admin-configured-order-form .configured-option-help hr { clear: both; margin: 0; border: 0; border-top: 1px solid #d0d0d0; }
    #order-form.admin-configured-order-form .configured-required { margin-left: 7px; color: #e60000; font-size: 12px; }
    #order-form.admin-configured-order-form .configured-radio-list .part-container { display: block; }
    #order-form.admin-configured-order-form .configured-radio-list .part-content { margin-bottom: 7px; }
    #order-form.admin-configured-order-form .configured-previous-order { margin-top: 14px; }
    #order-form.admin-configured-order-form .configured-previous-order-label { margin: 0 0 10px; font-size: 14px; font-weight: 400; line-height: 1.45; }
    #order-form.admin-configured-order-form .configured-previous-order-field { padding: 10px 14px; border: 1px solid #ececec; border-radius: 4px; }
    #order-form.admin-configured-order-form .configured-previous-order input { box-sizing: border-box; width: 100%; max-width: none; height: 30px; padding: 4px 7px; border: 1px solid #777; border-radius: 2px; }
    #order-form.admin-configured-order-form .configured-button-group { display: grid; grid-template-columns: repeat(auto-fit, minmax(145px, 1fr)); gap: 8px; }
    #order-form.admin-configured-order-form .configured-button-choice { position: relative; margin: 0; cursor: pointer; }
    #order-form.admin-configured-order-form .configured-button-choice input { position: absolute; opacity: 0; pointer-events: none; }
    #order-form.admin-configured-order-form .configured-button-choice span { display: block; padding: 10px 7px; border: 1px solid #9e9e9e; background: #fff; color: #111; text-align: center; }
    #order-form.admin-configured-order-form .configured-button-choice input:checked + span,
    #order-form.admin-configured-order-form .configured-button-choice:hover span { border-color: #f7b516; background: #f7b516; color: #fff; }
    #order-form.admin-configured-order-form .configured-image-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(110px, 1fr)); gap: 10px; }
    #order-form.admin-configured-order-form .configured-image-choice { position: relative; display: block; padding: 6px; border: 1px solid transparent; text-align: center; cursor: pointer; }
    #order-form.admin-configured-order-form .configured-image-choice input { position: absolute; opacity: 0; pointer-events: none; }
    #order-form.admin-configured-order-form .configured-image-choice img { display: block; width: 100%; height: 100px; object-fit: contain; }
    #order-form.admin-configured-order-form .configured-image-choice input:checked + img { outline: 3px solid #f7b516; outline-offset: 4px; }
    #order-form.admin-configured-order-form .configured-option-name { display: block; margin-top: 6px; }
    #order-form.admin-configured-order-form .configured-option-detail { display: block; margin-top: 3px; color: #666; font-size: 11px; white-space: pre-line; }
    #order-form.admin-configured-order-form .configured-color { display: inline-block; width: 11px; height: 11px; margin-right: 4px; border: 1px solid rgba(0, 0, 0, .3); border-radius: 50%; vertical-align: -1px; }
    #order-form.admin-configured-order-form .configured-switch-row { display: flex; align-items: center; gap: 9px; margin-bottom: 8px; cursor: pointer; }
    #order-form.admin-configured-order-form .configured-switch-row input { position: absolute; opacity: 0; pointer-events: none; }
    #order-form.admin-configured-order-form .configured-switch-track { position: relative; width: 42px; height: 23px; border-radius: 20px; background: #aaa; }
    #order-form.admin-configured-order-form .configured-switch-track::after { position: absolute; top: 3px; left: 3px; width: 17px; height: 17px; border-radius: 50%; background: #fff; content: ''; transition: transform .18s; }
    #order-form.admin-configured-order-form .configured-switch-row input:checked + .configured-switch-track { background: #f7b516; }
    #order-form.admin-configured-order-form .configured-switch-row input:checked + .configured-switch-track::after { transform: translateX(19px); }
    #order-form.admin-configured-order-form .configured-help-modal { position: fixed; z-index: 10000; display: none; align-items: center; justify-content: center; inset: 0; padding: 20px; background: rgba(0, 0, 0, .9); }
    #order-form.admin-configured-order-form .configured-help-modal.is-open { display: flex; }
    #order-form.admin-configured-order-form .configured-help-dialog { position: relative; width: min(900px, 100%); max-height: calc(100vh - 62px); overflow-y: auto; padding: 22px 40px 28px; border-radius: 5px; background: #fff; box-shadow: 0 4px 20px rgba(0, 0, 0, .35); }
    #order-form.admin-configured-order-form .configured-help-close { position: absolute; top: 7px; right: 12px; width: 30px; height: 30px; padding: 0; border: 0; background: transparent; color: #f00; font-size: 30px; line-height: 30px; cursor: pointer; }
    #order-form.admin-configured-order-form .configured-help-dialog .configured-option-help figure.image.image-style-align-left { width: 125px; }
    #order-form.admin-configured-order-form .configured-help-dialog .configured-option-help figure.image.image-style-align-right { width: 125px; }
    body.configured-help-modal-open { overflow: hidden; }
    @media (max-width: 600px) {
        #order-form.admin-configured-order-form .configured-step-list li::before { display: none; }
        #order-form.admin-configured-order-form .configured-step-label { min-height: 32px; font-size: 10px; }
        #order-form.admin-configured-order-form .configured-image-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
</style>

<br>
<div id="order-form" class="admin-configured-order-form">
    <h2 id="est-order">ご注文・見積書作成</h2>
    <div style="overflow: unset!important;">
        <div class="fixed-contrainer">
            <h3 class="red">【{{ $product->name }}】</h3>
            <span class="total-price"><span class="prd_total">0</span>円（税込）</span>
        </div>
        <div style="clear: both;"></div>

        <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
            <div class="step-box">
                <table class="configured-summary-table"><tbody>
                    @foreach ($orderSteps as $step)
                        @foreach ($step['groups'] as $group)
                            @if ($group['show_in_order_summary'])
                                <tr><td>{{ $group['name'] }}</td><td data-configured-summary="{{ $group['id'] }}">-</td></tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody></table>
            </div>
            <div class="step-box line2" style="text-align: center;">
                <img src="/products/acrylic/img/coming-soon.webp" width="135" height="135" class="configured-summary-image" data-configured-preview-image alt="">
                <br><span data-configured-preview-name>-</span>
            </div>
        </div>

        <div class="step-container">
            <div class="step-box step-list configured-step-list"><ul>
                @foreach ($orderSteps as $stepIndex => $step)
                    <li class="{{ $stepIndex === 0 ? 'active' : '' }}" data-configured-step-link="{{ $stepIndex }}">
                        <div class="configured-step-number">{{ $stepIndex + 1 }}</div><span class="configured-step-label">{{ $step['name'] }}</span>
                    </li>
                @endforeach
            </ul></div>
        </div>

        <form action="" method="post" name="configured-order-form" id="configured-order-form">
            @foreach ($orderSteps as $stepIndex => $step)
                <div class="estimate-content configured-estimate-content {{ $stepIndex === 0 ? 'active' : '' }}" data-configured-step="{{ $stepIndex }}">
                    @foreach ($step['groups'] as $group)
                        @php
                            $displayType = $group['display_type'];
                            $isImageType = in_array($displayType, ['image_card', 'image_grid', 'paper_preview'], true);
                            $isRadioList = in_array($displayType, ['radio_list', 'previous_order'], true);
                            $defaultOption = collect($group['options'])->firstWhere('is_default', true);
                            $defaultOptionId = $defaultOption['id'] ?? null;
                            $inputName = 'product_options['.$group['id'].']';
                        @endphp
                        <section class="configured-option-group" data-configured-group="{{ $group['id'] }}">
                            <div class="configured-option-heading">
                                <h3>{{ $group['name'] }}@if ($group['is_required'])<span class="configured-required">必須</span>@endif</h3>
                                @if ($group['help_text'] !== null && $group['help_text'] !== '')
                                    <button type="button" class="configured-help-button" data-configured-help-open="configured-help-modal-{{ $group['id'] }}">詳細</button>
                                @endif
                            </div>

                            @if ($displayType === 'switch')
                                <div class="part-container">
                                    @foreach ($group['options'] as $option)
                                        @php $inputId = 'configured-option-'.$group['id'].'-'.$option['id']; @endphp
                                        <label class="configured-switch-row" for="{{ $inputId }}">
                                            <input id="{{ $inputId }}" type="checkbox" name="{{ $inputName }}[]" value="{{ $option['id'] }}" @checked($option['is_default']) data-option-name="{{ $option['name'] }}" data-option-image="{{ $option['images'][0] ?? '' }}">
                                            <span class="configured-switch-track" aria-hidden="true"></span><span>{{ $option['name'] }}</span>
                                        </label>
                                        @if ($option['detail'] !== null && $option['detail'] !== '')<span class="configured-option-detail">{{ $option['detail'] }}</span>@endif
                                    @endforeach
                                </div>
                            @elseif ($isImageType)
                                <div class="configured-image-grid">
                                    @foreach ($group['options'] as $optionIndex => $option)
                                        @php
                                            $inputId = 'configured-option-'.$group['id'].'-'.$option['id'];
                                            $image = $option['images'][0] ?? null;
                                            $isChecked = $defaultOptionId !== null && $defaultOptionId === $option['id'];
                                        @endphp
                                        <label class="configured-image-choice" for="{{ $inputId }}">
                                            <input id="{{ $inputId }}" type="radio" name="{{ $inputName }}" value="{{ $option['id'] }}" @checked($isChecked) @if ($group['is_required'] && $optionIndex === 0) required @endif data-option-name="{{ $option['name'] }}" data-option-image="{{ $image ?? '' }}">
                                            @if ($image !== null)<img src="{{ asset('product-options/'.rawurlencode($image)) }}" alt="{{ $option['name'] }}" loading="lazy">@endif
                                            <span class="configured-option-name">{{ $option['name'] }}</span>
                                            @if ($option['detail'] !== null && $option['detail'] !== '')<span class="configured-option-detail">{{ $option['detail'] }}</span>@endif
                                        </label>
                                    @endforeach
                                </div>
                            @elseif ($displayType === 'button_group')
                                <div class="configured-button-group">
                                    @foreach ($group['options'] as $optionIndex => $option)
                                        @php
                                            $inputId = 'configured-option-'.$group['id'].'-'.$option['id'];
                                            $isChecked = $defaultOptionId !== null && $defaultOptionId === $option['id'];
                                        @endphp
                                        <label class="configured-button-choice" for="{{ $inputId }}">
                                            <input id="{{ $inputId }}" type="radio" name="{{ $inputName }}" value="{{ $option['id'] }}" @checked($isChecked) @if ($group['is_required'] && $optionIndex === 0) required @endif data-option-name="{{ $option['name'] }}" data-option-image="{{ $option['images'][0] ?? '' }}">
                                            <span>@if ($option['color_code'])<i class="configured-color" style="background-color: {{ $option['color_code'] }}"></i>@endif{{ $option['name'] }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <div class="part-container {{ $isRadioList ? 'configured-radio-list' : '' }}">
                                    @foreach ($group['options'] as $optionIndex => $option)
                                        @php
                                            $inputId = 'configured-option-'.$group['id'].'-'.$option['id'];
                                            $isChecked = $defaultOptionId !== null && $defaultOptionId === $option['id'];
                                            $isPreviousOrderYes = $displayType === 'previous_order'
                                                && ($option['name'] === 'はい' || strtolower($option['name']) === 'yes');
                                        @endphp
                                        <div class="part-content">
                                            <label class="part-name" for="{{ $inputId }}">
                                                <input id="{{ $inputId }}" type="radio" name="{{ $inputName }}" value="{{ $option['id'] }}" @checked($isChecked) @if ($group['is_required'] && $optionIndex === 0) required @endif data-option-name="{{ $option['name'] }}" data-option-image="{{ $option['images'][0] ?? '' }}" data-previous-order-yes="{{ $isPreviousOrderYes ? '1' : '0' }}">
                                                {{ $option['name'] }} <span class="checkmark"></span>
                                            </label>
                                            @if ($option['detail'] !== null && $option['detail'] !== '')<span class="configured-option-detail">{{ $option['detail'] }}</span>@endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @if ($displayType === 'previous_order')
                                <div class="configured-previous-order" data-configured-previous-order hidden>
                                    <p class="configured-previous-order-label">前回ご注文の管理番号等がもしおわかりでしたら、ご入力ください。</p>
                                    <div class="configured-previous-order-field">
                                        <input type="text" name="product_options[{{ $group['id'] }}][previous_order_number]" maxlength="255" autocomplete="off">
                                    </div>
                                </div>
                            @endif

                            @if ($group['help_text'] !== null && $group['help_text'] !== '')
                                <div id="configured-help-modal-{{ $group['id'] }}" class="configured-help-modal" data-configured-help-modal role="dialog" aria-modal="true" aria-labelledby="configured-help-title-{{ $group['id'] }}">
                                    <div class="configured-help-dialog">
                                        <button type="button" class="configured-help-close" data-configured-help-close aria-label="閉じる">&times;</button>
                                        <div id="configured-help-title-{{ $group['id'] }}" class="sr-only">{{ $group['name'] }}</div>
                                        <div class="configured-option-help">{!! $group['help_text'] !!}</div>
                                    </div>
                                </div>
                            @endif
                        </section>
                    @endforeach
                </div>
            @endforeach
        </form>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const orderForm = document.querySelector('#order-form.admin-configured-order-form');
            if (!orderForm) return;
            const showStep = function (index) {
                orderForm.querySelectorAll('[data-configured-step]').forEach(function (step) {
                    step.classList.toggle('active', Number(step.dataset.configuredStep) === index);
                });
                orderForm.querySelectorAll('[data-configured-step-link]').forEach(function (link) {
                    link.classList.toggle('active', Number(link.dataset.configuredStepLink) === index);
                });
            };
            const updateSummary = function () {
                orderForm.querySelectorAll('[data-configured-group]').forEach(function (group) {
                    const selected = Array.from(group.querySelectorAll('input:checked'));
                    const names = selected.map(function (input) { return input.dataset.optionName || ''; }).filter(Boolean);
                    const summary = orderForm.querySelector('[data-configured-summary="' + group.dataset.configuredGroup + '"]');
                    if (summary) summary.textContent = names.join('、') || '-';
                });
                orderForm.querySelectorAll('[data-configured-previous-order]').forEach(function (detail) {
                    const group = detail.closest('[data-configured-group]');
                    const isYes = group?.querySelector('input:checked[data-previous-order-yes="1"]') !== null;
                    detail.hidden = !isYes;
                    const field = detail.querySelector('input[type="text"]');
                    if (field) field.disabled = !isYes;
                });
                const firstSelected = orderForm.querySelector('input:checked[data-option-name]');
                const previewName = orderForm.querySelector('[data-configured-preview-name]');
                const previewImage = orderForm.querySelector('[data-configured-preview-image]');
                if (!firstSelected) return;
                if (previewName) previewName.textContent = firstSelected.dataset.optionName || '-';
                if (previewImage && firstSelected.dataset.optionImage) previewImage.src = '/product-options/' + encodeURIComponent(firstSelected.dataset.optionImage);
            };
            orderForm.querySelectorAll('[data-configured-step-link]').forEach(function (link) {
                link.addEventListener('click', function () { showStep(Number(link.dataset.configuredStepLink)); });
            });
            const closeHelpModal = function (modal) {
                modal?.classList.remove('is-open');
                document.body.classList.remove('configured-help-modal-open');
            };
            orderForm.querySelectorAll('[data-configured-help-open]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const modal = document.getElementById(button.dataset.configuredHelpOpen);
                    if (!modal) return;
                    modal.classList.add('is-open');
                    document.body.classList.add('configured-help-modal-open');
                    modal.querySelector('[data-configured-help-close]')?.focus();
                });
            });
            orderForm.querySelectorAll('[data-configured-help-modal]').forEach(function (modal) {
                modal.addEventListener('click', function (event) {
                    if (event.target === modal || event.target.closest('[data-configured-help-close]')) closeHelpModal(modal);
                });
            });
            document.addEventListener('keydown', function (event) {
                if (event.key !== 'Escape') return;
                orderForm.querySelectorAll('[data-configured-help-modal].is-open').forEach(closeHelpModal);
            });
            orderForm.querySelectorAll('input').forEach(function (input) { input.addEventListener('change', updateSummary); });
            updateSummary();
        });
    </script>
@endpush
