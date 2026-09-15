<style>
    /* Keep the legacy order-form structure; only option values come from Admin. */
    #order-form.admin-configured-order-form { margin-top: 24px; }
    #order-form.admin-configured-order-form .configured-summary-table { width: 100%; border-collapse: collapse; }
    #order-form.admin-configured-order-form .configured-summary-table td { padding: 5px 12px; border: 1px solid #ddd; }
    #order-form.admin-configured-order-form .configured-summary-table td:first-child { width: 112px; background: #f3f3f3; text-align: center; }
    #order-form.admin-configured-order-form .configured-step-summary { margin: 0 0 20px; padding: 10px; border: 1px solid #d9d9d9; background: #fff; }
    #order-form.admin-configured-order-form .configured-step-summary .configured-summary-table { margin: 0; }
    #order-form.admin-configured-order-form .configured-top-summary:empty { display: none; }
    #order-form.admin-configured-order-form .configured-detailed-summary { margin: 24px 0 16px; }
    #order-form.admin-configured-order-form .configured-detailed-summary-columns { display: flex; align-items: flex-start; gap: 10px; }
    #order-form.admin-configured-order-form .configured-detailed-summary-column { flex: 1 1 0; min-width: 0; }
    #order-form.admin-configured-order-form .configured-detailed-summary-column > h3 { margin: 0 0 8px; text-align: center; }
    #order-form.admin-configured-order-form .configured-detail-table { width: 100%; border-collapse: collapse; table-layout: fixed; }
    #order-form.admin-configured-order-form .configured-detail-table td { padding: 4px 7px; border: 1px solid #4b7299; line-height: 1.25; }
    #order-form.admin-configured-order-form .configured-detail-table td:first-child { width: 34%; background: #f3f3f3; text-align: center; word-break: break-word; }
    #order-form.admin-configured-order-form .configured-price-table td:first-child { background: #429cf1; color: #fff; font-weight: 500; }
    #order-form.admin-configured-order-form .configured-price-table td:last-child { text-align: right; white-space: nowrap; }
    #order-form.admin-configured-order-form .configured-summary-image { width: 135px; height: 135px; object-fit: contain; }
    /* Match the original rubberstrap progress indicator. */
    #order-form.admin-configured-order-form .configured-step-list ul { display: flex; align-items: flex-start; justify-content: space-around; margin: auto !important; padding: 0; list-style: none; }
    #order-form.admin-configured-order-form .configured-step-list li { position: relative; display: inline-grid; width: 30%; color: #222; text-align: center; cursor: pointer; }
    #order-form.admin-configured-order-form .configured-step-list li::after { position: absolute; top: 12px; left: -62%; z-index: -1; width: 110%; height: 4px; background-color: #ddd; content: ''; }
    #order-form.admin-configured-order-form .configured-step-list li:first-child::after { content: none; }
    #order-form.admin-configured-order-form .configured-step-list li.completed { color: #1e90ff; }
    #order-form.admin-configured-order-form .configured-step-list li.completed::after { background-color: #1e90ff; }
    #order-form.admin-configured-order-form .configured-step-list li.completed .configured-step-number { background: #1e90ff; color: #fff; }
    #order-form.admin-configured-order-form .configured-step-list li.active { color: #1e90ff; }
    #order-form.admin-configured-order-form .configured-step-list li.active::after { background-color: #1e90ff; }
    #order-form.admin-configured-order-form .configured-step-number { width: 25px; height: 25px; margin: auto; border: 2px solid #add8e6; border-radius: 15px; background: #fff; color: #222; line-height: 1.8; text-align: center; }
    #order-form.admin-configured-order-form .configured-step-list li.active .configured-step-number { background: #1e90ff; color: #fff; }
    #order-form.admin-configured-order-form .configured-step-label { display: block; margin-top: 10px; font-size: 12px; line-height: normal; vertical-align: top; }
    #order-form.admin-configured-order-form .configured-estimate-content { display: none; }
    #order-form.admin-configured-order-form .configured-estimate-content.active { display: block; }
    #order-form.admin-configured-order-form .configured-step-actions { display: flex; justify-content: space-around; margin: 10px auto 0; text-align: center; }
    #order-form.admin-configured-order-form .configured-step-actions[hidden],
    #order-form.admin-configured-order-form .configured-step-actions .btn[hidden] { display: none !important; }
    #order-form.admin-configured-order-form .configured-step-actions .btn { width: 35%; border: 0; cursor: pointer; font: inherit; }
    #order-form.admin-configured-order-form .configured-step-actions .btn-back { border: 1px solid #aaa; }
    #order-form.admin-configured-order-form .configured-step-actions.is-final { align-items: stretch; justify-content: space-between; gap: 7px; }
    #order-form.admin-configured-order-form .configured-step-actions.is-final .configured-final-action { box-sizing: border-box; width: auto; min-width: 0; min-height: 50px; padding: 10px 6px; border: 1px solid transparent; border-radius: 3px; font-size: 14px; font-weight: 700; line-height: 1.4; white-space: nowrap; }
    #order-form.admin-configured-order-form .configured-step-actions.is-final .configured-final-action--small { flex: 15 1 0; }
    #order-form.admin-configured-order-form .configured-step-actions.is-final .configured-final-action--estimate { flex: 20 1 0; background: #6f7d89; color: #fff; }
    #order-form.admin-configured-order-form .configured-step-actions.is-final .configured-final-action--order { flex: 30 1 0; background: #cc3f44; color: #fff; }
    #order-form.admin-configured-order-form .configured-step-actions.is-final .configured-final-action--clear { border-color: #111; background: #fff; color: #111; }
    #order-form.admin-configured-order-form .configured-step-actions.is-final .configured-final-action--edit { border-color: #111; background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); color: #111; }
    #order-form.admin-configured-order-form .configured-step-actions.is-final .configured-final-action:hover { opacity: .78; }
    #order-form.admin-configured-order-form .configured-customer-details { margin: 18px auto 0; text-align: center; }
    #order-form.admin-configured-order-form .configured-customer-details[hidden] { display: none !important; }
    #order-form.admin-configured-order-form .configured-customer-table { width: 100%; border-collapse: collapse; background: #f3f3f3; }
    #order-form.admin-configured-order-form .configured-customer-table td { padding: 2px 4px; border: 1px solid #ddd; line-height: 1.25; }
    #order-form.admin-configured-order-form .configured-customer-table .configured-customer-label { width: 30%; text-align: center; white-space: nowrap; }
    #order-form.admin-configured-order-form .configured-customer-table .configured-customer-field { background: #fff; text-align: left; }
    #order-form.admin-configured-order-form .configured-customer-table input { box-sizing: border-box; width: 100%; height: 22px; padding: 1px 5px; border: 1px solid #777; border-radius: 1px; background: #fff; font: inherit; }
    #order-form.admin-configured-order-form .configured-customer-postal { display: grid; gap: 2px; }
    #order-form.admin-configured-order-form .configured-customer-postal button {  height: 24px; padding: 1px 5px; border: 1px solid #777; border-radius: 1px; background: #eee; color: #111; cursor: pointer; font: inherit; }
    #order-form.admin-configured-order-form .configured-customer-postal button:hover { background: #e2e2e2; }
    #order-form.admin-configured-order-form .configured-customer-error { display: block; min-height: 0; color: #f00; line-height: 1.35; }
    #order-form.admin-configured-order-form .configured-customer-error:empty { display: none; }
    #order-form.admin-configured-order-form .configured-customer-submit { width: 254px; max-width: 100%; height: 34px; margin: 10px auto 0; border: 1px solid #777; border-radius: 2px; background: #eee; color: #f00; cursor: pointer; font: inherit; }
    #order-form.admin-configured-order-form .configured-customer-submit:hover { background: #e2e2e2; }
    #order-form.admin-configured-order-form .configured-customer-note { margin: 3px 0 0; color: #111; line-height: 1.35; }
    #order-form.admin-configured-order-form .configured-option-group { margin-bottom: 20px; }
    #order-form.admin-configured-order-form .is-configured-hidden { display: none !important; }
    #order-form.admin-configured-order-form .is-configured-locked { opacity: .52; }
    #order-form.admin-configured-order-form .configured-quantity-input .part-content { margin: 0; }
    #order-form.admin-configured-order-form .configured-quantity-input .part-name { padding-left: 12px; }
    #order-form.admin-configured-order-form .configured-quantity-input input[type="number"] { width: 210px; margin-left: 12px; text-align: right; }
    #order-form.admin-configured-order-form .configured-option-heading h3 { margin: 0 0 5px; }
    #order-form.admin-configured-order-form .configured-help-button { display: block; min-width: 58px; padding: 3px 10px; border: 1px solid #c8c8c8; border-radius: 3px; background: #fff; color: #333; font-size: 13px; line-height: 1.35; cursor: pointer; }
    #order-form.admin-configured-order-form .configured-help-button:hover { border-color: #999; background: #f5f5f5; }
    #order-form.admin-configured-order-form .configured-option-help { margin: 0; color: #111; font-size: 14px; line-height: 1.8; white-space: normal; }
    #order-form.admin-configured-order-form .configured-option-help::after { display: block; clear: both; content: ''; }
    #order-form.admin-configured-order-form .configured-option-help > :first-child { margin-top: 0; }
    #order-form.admin-configured-order-form .configured-option-help h1,
    #order-form.admin-configured-order-form .configured-option-help h2,
    #order-form.admin-configured-order-form .configured-option-help h3,
    #order-form.admin-configured-order-form .configured-option-help h4,
    #order-form.admin-configured-order-form .configured-option-help h5,
    #order-form.admin-configured-order-form .configured-option-help h6 { margin: 0 0 10px; line-height: 1.35; }
    #order-form.admin-configured-order-form .configured-option-help p { margin: 0 0 8px; }
    #order-form.admin-configured-order-form .configured-option-help figure.image { float: left; width: 125px; max-width: 100%; margin: 0 25px 8px 0; }
    #order-form.admin-configured-order-form .configured-option-help figure.image img { display: block; max-width: 100%; height: auto; }
    #order-form.admin-configured-order-form .configured-option-help figure.image.image-style-align-left,
    #order-form.admin-configured-order-form .configured-option-help figure.image.image-style-wrap-text { float: left; width: 125px; margin: 0 25px 8px 0; }
    #order-form.admin-configured-order-form .configured-option-help figure.image.image-style-align-right,
    #order-form.admin-configured-order-form .configured-option-help figure.image.image-style-break-text { float: right; width: 125px; margin: 0 0 8px 25px; }
    #order-form.admin-configured-order-form .configured-option-help figure.image:not(.image-style-align-right):not(.image-style-break-text) ~ *:not(figure):not(.horizontal-line):not(hr) { margin-left: 150px !important; }
    #order-form.admin-configured-order-form .configured-option-help figure.image.image-style-align-left ~ *:not(figure):not(.horizontal-line):not(hr),
    #order-form.admin-configured-order-form .configured-option-help figure.image.image-style-wrap-text ~ *:not(figure):not(.horizontal-line):not(hr) { margin-left: 150px !important; }
    #order-form.admin-configured-order-form .configured-option-help figure.image.image-style-align-right ~ *:not(figure):not(.horizontal-line):not(hr),
    #order-form.admin-configured-order-form .configured-option-help figure.image.image-style-break-text ~ *:not(figure):not(.horizontal-line):not(hr) { margin-right: 150px !important; }
    #order-form.admin-configured-order-form .configured-option-help figure.horizontal-line { clear: both; margin: 20px 0; }
    #order-form.admin-configured-order-form .configured-option-help figure.horizontal-line hr,
    #order-form.admin-configured-order-form .configured-option-help hr { clear: both; margin: 0; border: 0; border-top: 1px solid #d0d0d0; }
    #order-form.admin-configured-order-form .configured-required { margin-left: 7px; color: #e60000; font-size: 12px; }
    #order-form.admin-configured-order-form .configured-option-remark { margin: 8px 0 0; color: #e60000; font-size: 13px; line-height: 1.45; white-space: pre-line; }
    #order-form.admin-configured-order-form .configured-option-shell { min-width: 0; }
    #order-form.admin-configured-order-form .configured-option-disable-text { display: flex; align-items: flex-start; gap: 10px; margin: 8px 0 0; padding: 0 4px; color: #e60000; font-size: 13px; line-height: 1.35; }
    #order-form.admin-configured-order-form .configured-option-disable-text[hidden] { display: none !important; }
    #order-form.admin-configured-order-form .configured-option-disable-indicator { flex: 0 0 20px; width: 20px; height: 20px; margin-top: 1px; border-radius: 50%; background: #d71920; box-shadow: 0 0 0 0 rgba(215, 25, 32, .4); content: ''; animation: configured-disable-pulse 1.2s ease-in-out infinite; }
    #order-form.admin-configured-order-form .configured-option-disable-content { flex: 1 1 auto; min-width: 0; line-height: 1.35; white-space: pre-line; }
    #order-form.admin-configured-order-form .configured-option-disable-content p { margin: 0 0 4px; }
    #order-form.admin-configured-order-form .configured-option-disable-content p:last-child { margin-bottom: 0; }
    #order-form.admin-configured-order-form .configured-option-disable-content ul,
    #order-form.admin-configured-order-form .configured-option-disable-content ol { margin: 0 0 4px 18px; padding: 0; }
    @keyframes configured-disable-pulse {
        0%, 100% { opacity: 1; transform: scale(1); box-shadow: 0 0 0 0 rgba(215, 25, 32, .4); }
        50% { opacity: .62; transform: scale(.86); box-shadow: 0 0 0 5px rgba(215, 25, 32, 0); }
    }
    @media (prefers-reduced-motion: reduce) {
        #order-form.admin-configured-order-form .configured-option-disable-indicator { animation: none; }
    }
    #order-form.admin-configured-order-form .configured-image-grid--priced .configured-option-shell { box-sizing: border-box; flex: 0 0 20%; max-width: 20%; padding: 0; text-align: center; }
    #order-form.admin-configured-order-form .configured-image-grid--priced .configured-option-shell .configured-image-choice { padding: 0; }
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
    /* The Image Grid is the same five-across attachment picker used by rubberstrap. */
    #order-form.admin-configured-order-form .configured-image-grid--priced { display: flex; flex-wrap: wrap; align-items: flex-start; gap: 0; }
    #order-form.admin-configured-order-form .configured-image-grid--priced .configured-image-choice { box-sizing: border-box; flex: 0 0 20%; max-width: 20%; padding: 0; }
    #order-form.admin-configured-order-form .configured-image-grid--priced .configured-image-choice img { box-sizing: border-box; width: 95px; height: 95px; margin: 0 auto 8px; outline: .5px solid #f8f8f8; outline-offset: -1px; box-shadow: 0 1px 5px rgba(0, 0, 0, .14); }
    #order-form.admin-configured-order-form .configured-image-grid--priced .configured-image-choice input:checked + img { outline: 2px solid #1e90ff; outline-offset: -2px; box-shadow: none; }
    #order-form.admin-configured-order-form .configured-image-grid--priced .configured-option-price { display: block; color: #111; font-size: 14px; line-height: 1.2; text-align: center; }
    /* Match the original scrollable paper-pattern picker. */
    #order-form.admin-configured-order-form .configured-paper-preview { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 5px; max-height: 380px; overflow-y: auto; scroll-behavior: smooth; }
    #order-form.admin-configured-order-form .configured-paper-preview .configured-image-choice { padding: 0; }
    #order-form.admin-configured-order-form .configured-paper-preview .configured-image-choice img { width: 100%; height: auto; min-height: 0; object-fit: initial; }
    #order-form.admin-configured-order-form .configured-paper-preview .configured-image-choice input:checked + img { outline: 2px solid #1e90ff; outline-offset: -2px; }
    #order-form.admin-configured-order-form .configured-option-name { display: block; margin-top: 6px; }
    #order-form.admin-configured-order-form .configured-option-detail { display: block; margin-top: 3px; color: #666; font-size: 11px; white-space: pre-line; }
    #order-form.admin-configured-order-form .configured-color { display: inline-block; width: 11px; height: 11px; margin-right: 4px; border: 1px solid rgba(0, 0, 0, .3); border-radius: 50%; vertical-align: -1px; }
    #order-form.admin-configured-order-form .configured-switch-row { padding: 0 !important; }
    #order-form.admin-configured-order-form .configured-help-modal { position: fixed; z-index: 10000; display: none; align-items: center; justify-content: center; inset: 0; padding: 20px; background: rgba(0, 0, 0, .9); }
    #order-form.admin-configured-order-form .configured-help-modal.is-open { display: flex; }
    #order-form.admin-configured-order-form .configured-help-dialog { position: relative; width: min(900px, 100%); max-height: calc(100vh - 62px); overflow-y: auto; padding: 22px 40px 28px; border-radius: 5px; background: #fff; box-shadow: 0 4px 20px rgba(0, 0, 0, .35); }
    #order-form.admin-configured-order-form .configured-help-close { position: absolute; top: 7px; right: 12px; width: 30px; height: 30px; padding: 0; border: 0; background: transparent; color: #f00; font-size: 30px; line-height: 30px; cursor: pointer; }
    #order-form.admin-configured-order-form .configured-help-dialog .configured-option-help figure.image.image-style-align-left,
    #order-form.admin-configured-order-form .configured-help-dialog .configured-option-help figure.image.image-style-wrap-text { width: 125px; }
    #order-form.admin-configured-order-form .configured-help-dialog .configured-option-help figure.image.image-style-align-right,
    #order-form.admin-configured-order-form .configured-help-dialog .configured-option-help figure.image.image-style-break-text { width: 125px; }
    body.configured-help-modal-open { overflow: hidden; }
    @media (max-width: 600px) {
        #order-form.admin-configured-order-form .configured-step-list li::after { display: none; }
        #order-form.admin-configured-order-form .configured-step-label { min-height: 32px; font-size: 10px; }
        #order-form.admin-configured-order-form .configured-image-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        #order-form.admin-configured-order-form .configured-image-grid--priced .configured-image-choice { flex-basis: 33.333%; max-width: 33.333%; }
        #order-form.admin-configured-order-form .configured-paper-preview { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        #order-form.admin-configured-order-form .configured-detailed-summary-columns { flex-direction: column; }
        #order-form.admin-configured-order-form .configured-detailed-summary-column { width: 100%; }
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

        @php
            $orderSummaryGroups = collect($orderSteps)
                ->flatMap(fn (array $step) => $step['groups'])
                ->values();
            $buildSummaryFields = static function ($groups, string $showKey, string $sortKey, string $labelKey, ?string $sourceKey = null): \Illuminate\Support\Collection {
                return $groups
                    ->flatMap(static function (array $group) use ($showKey, $sortKey, $labelKey, $sourceKey): array {
                        $optionFields = $group['display_type'] === 'switch'
                            ? collect($group['options'] ?? [])
                                ->filter(static fn (array $option): bool => !empty($option[$showKey]))
                                ->sortBy($sortKey)
                                ->map(static fn (array $option): array => [
                                    'key' => 'option-'.$option['id'],
                                    'group_id' => $group['id'],
                                    'option_id' => $option['id'],
                                    'sort_order' => (int) ($option[$sortKey] ?? 0),
                                    'label' => ($option[$labelKey] ?? '') !== '' ? $option[$labelKey] : $option['name'],
                                    'price_option_id' => $sourceKey !== null ? (int) $option['id'] : null,
                                ])
                                ->values()
                            : collect();

                        if ($optionFields->isNotEmpty()) {
                            return $optionFields->all();
                        }

                        if (!empty($group[$showKey])) {
                            return [[
                                'key' => 'group-'.$group['id'],
                                'group_id' => $group['id'],
                                'option_id' => null,
                                'sort_order' => (int) ($group[$sortKey] ?? 0),
                                'label' => ($group[$labelKey] ?? '') !== '' ? $group[$labelKey] : $group['name'],
                                'price_option_id' => null,
                            ]];
                        }

                        return [];
                    })
                    ->sortBy('sort_order')
                    ->values();
            };
            $previewSummaryFields = $buildSummaryFields($orderSummaryGroups, 'show_in_preview_summary', 'preview_summary_sort_order', 'preview_summary_label');
            $summaryFields = $buildSummaryFields($orderSummaryGroups, 'show_in_order_summary', 'summary_sort_order', 'summary_label');
            $priceSummaryFields = $buildSummaryFields($orderSummaryGroups, 'show_in_price_summary', 'price_summary_sort_order', 'price_summary_label', 'price_summary_option_id');
            $pdfSummaryFields = $buildSummaryFields($orderSummaryGroups, 'show_in_pdf_summary', 'pdf_summary_sort_order', 'pdf_summary_label');
            $pdfSummaryCustomRows = collect($pdfSummaryCustomRows ?? []);
            $pdfSummaryFieldRows = $pdfSummaryFields
                ->map(static fn (array $field): array => [
                    ...$field,
                    'is_custom' => false,
                    'content' => null,
                ])
                ->concat($pdfSummaryCustomRows->map(static fn (array $row): array => [
                    'key' => $row['key'],
                    'group_id' => null,
                    'option_id' => null,
                    'sort_order' => (int) ($row['sort_order'] ?? 0),
                    'label' => $row['label'],
                    'price_option_id' => null,
                    'is_custom' => true,
                    'content' => $row['content'] ?? '',
                ]))
                ->sortBy('sort_order')
                ->values();
            $summaryStepIndex = collect($orderSteps)
                ->search(fn (array $step): bool => !empty($step['is_summary_step']));
            $summaryStepIndex = $summaryStepIndex === false ? 0 : $summaryStepIndex;
        @endphp

        @if ($pdfSummaryFieldRows->isNotEmpty())
            <div hidden data-configured-pdf-summary-container>
                <table><tbody>
                    @foreach ($pdfSummaryFieldRows as $field)
                        <tr>
                            <td>{{ $field['label'] }}</td>
                            @if ($field['is_custom'])
                                <td data-configured-pdf-summary="{{ $field['key'] }}">{{ $field['content'] }}</td>
                            @else
                                <td data-configured-pdf-summary="{{ $field['key'] }}" data-configured-summary-group="{{ $field['group_id'] }}" data-configured-summary-option="{{ $field['option_id'] ?? '' }}">-</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody></table>
            </div>
        @endif

        <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
            @if ($previewSummaryFields->isNotEmpty())
                <div class="step-box configured-top-summary">
                    <table class="configured-summary-table"><tbody>
                        @foreach ($previewSummaryFields as $field)
                            <tr><td>{{ $field['label'] }}</td><td data-configured-preview-summary="{{ $field['key'] }}" data-configured-summary-group="{{ $field['group_id'] }}" data-configured-summary-option="{{ $field['option_id'] ?? '' }}">-</td></tr>
                        @endforeach
                    </tbody></table>
                </div>
            @endif
            <div class="step-box line2" style="text-align: center;">
                <img src="/products/acrylic/img/coming-soon.webp" width="135" height="135" class="configured-summary-image" data-configured-preview-image alt="">
                <br><span data-configured-preview-name>-</span>
            </div>
            <div class="step-box line2" style="text-align: center;">
                <img src="/products/acrylic/img/coming-soon.webp" width="135" height="135" class="configured-summary-image" data-configured-paper-preview-image alt="">
                <br>台紙:<span data-configured-paper-preview-name>なし</span>
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
                        <section class="configured-option-group" data-configured-group="{{ $group['id'] }}" data-configured-display-type="{{ $displayType }}">
                            @if ($displayType !== 'paper_preview')
                                <div class="configured-option-heading">
                                    <h3>{{ $group['name'] }}@if ($group['is_required'])<span class="configured-required">必須</span>@endif</h3>
                                    @if ($group['help_text'] !== null && $group['help_text'] !== '')
                                        <button type="button" class="configured-help-button" data-configured-help-open="configured-help-modal-{{ $group['id'] }}">詳細</button>
                                    @endif
                                </div>
                            @endif

                            @if ($displayType === 'quantity_input')
                                <div class="part-container configured-quantity-input">
                                    <div class="part-content">
                                        <label class="part-name" for="configured-quantity-{{ $group['id'] }}">
                                            ご注文・御見積数量
                                            <input id="configured-quantity-{{ $group['id'] }}" type="number" name="quantity" value="100" min="1" step="1" inputmode="numeric" @if ($group['is_required']) required @endif>
                                        </label>
                                    </div>
                                </div>
                            @elseif ($displayType === 'switch')
                                <div class="part-container">
                                    @foreach ($group['options'] as $option)
                                        @php $inputId = 'configured-option-'.$group['id'].'-'.$option['id']; @endphp
                                        <div class="configured-option-shell" data-configured-option="{{ $option['id'] }}">
                                            <div class="part-content">
                                                <label class="part-name configured-switch-row" for="{{ $inputId }}">
                                                    <div class="switch_off_button b2 switch_off">
                                                        <input type="hidden" name="{{ $inputName }}" value="なし">
                                                        <input id="{{ $inputId }}" type="checkbox" class="checkbox" name="{{ $inputName }}" value="あり" @checked($option['is_default']) data-option-id="{{ $option['id'] }}" data-option-name="{{ $option['name'] }}" data-option-image="{{ $option['images'][0] ?? '' }}" data-option-disabled="{{ !empty($option['is_disabled']) ? '1' : '0' }}">
                                                        <div class="knobs" aria-hidden="true"><span></span></div><div class="layer" aria-hidden="true"></div>
                                                    </div>
                                                    {{ $option['name'] }}
                                                </label>
                                                @if ($option['detail'] !== null && $option['detail'] !== '')<span class="configured-option-detail">{{ $option['detail'] }}</span>@endif
                                            </div>
                                            @if (!empty($option['is_disabled']) && trim((string) ($option['disable_text'] ?? '')) !== '')<div class="configured-option-disable-text" data-configured-disable-text hidden><span class="configured-option-disable-indicator" aria-hidden="true"></span><div class="configured-option-disable-content">{!! app(\App\Support\RichTextSanitizer::class)->sanitize($option['disable_text']) !!}</div></div>@endif
                                        </div>
                                    @endforeach
                                </div>
                            @elseif ($isImageType)
                                <div class="configured-image-grid {{ $displayType === 'image_grid' ? 'configured-image-grid--priced' : '' }} {{ $displayType === 'paper_preview' ? 'configured-paper-preview' : '' }}">
                                    @foreach ($group['options'] as $optionIndex => $option)
                                        @php
                                            $inputId = 'configured-option-'.$group['id'].'-'.$option['id'];
                                            $image = $option['images'][0] ?? null;
                                            $isChecked = $defaultOptionId !== null && $defaultOptionId === $option['id'];
                                        @endphp
                                        <div class="configured-option-shell" data-configured-option="{{ $option['id'] }}">
                                            <label class="configured-image-choice" for="{{ $inputId }}">
                                                <input id="{{ $inputId }}" type="radio" name="{{ $inputName }}" value="{{ $option['id'] }}" @checked($isChecked) @if ($group['is_required'] && $optionIndex === 0) required @endif data-option-id="{{ $option['id'] }}" data-option-name="{{ $option['name'] }}" data-option-image="{{ $image ?? '' }}" data-option-disabled="{{ !empty($option['is_disabled']) ? '1' : '0' }}">
                                                @if ($image !== null)<img src="{{ asset('product-options/'.rawurlencode($image)) }}" alt="{{ $option['name'] }}" loading="lazy">@endif
                                                @if ($displayType === 'image_grid' && $image !== null)
                                                    <span class="configured-option-price" data-configured-option-price="{{ $option['id'] }}">+0円</span>
                                                @elseif ($displayType !== 'paper_preview' || $image === null)
                                                    <span class="configured-option-name">{{ $option['name'] }}</span>
                                                @endif
                                                @if ($displayType !== 'paper_preview' && $option['detail'] !== null && $option['detail'] !== '')<span class="configured-option-detail">{{ $option['detail'] }}</span>@endif
                                            </label>
                                            @if (!empty($option['is_disabled']) && trim((string) ($option['disable_text'] ?? '')) !== '')<div class="configured-option-disable-text" data-configured-disable-text hidden><span class="configured-option-disable-indicator" aria-hidden="true"></span><div class="configured-option-disable-content">{!! app(\App\Support\RichTextSanitizer::class)->sanitize($option['disable_text']) !!}</div></div>@endif
                                        </div>
                                    @endforeach
                                </div>
                            @elseif ($displayType === 'button_group')
                                <div class="configured-button-group">
                                    @foreach ($group['options'] as $optionIndex => $option)
                                        @php
                                            $inputId = 'configured-option-'.$group['id'].'-'.$option['id'];
                                            $isChecked = $defaultOptionId !== null && $defaultOptionId === $option['id'];
                                        @endphp
                                        <div class="configured-option-shell" data-configured-option="{{ $option['id'] }}">
                                            <label class="configured-button-choice" for="{{ $inputId }}">
                                                <input id="{{ $inputId }}" type="radio" name="{{ $inputName }}" value="{{ $option['id'] }}" @checked($isChecked) @if ($group['is_required'] && $optionIndex === 0) required @endif data-option-id="{{ $option['id'] }}" data-option-name="{{ $option['name'] }}" data-option-image="{{ $option['images'][0] ?? '' }}" data-option-disabled="{{ !empty($option['is_disabled']) ? '1' : '0' }}">
                                                <span>@if ($option['color_code'])<i class="configured-color" style="background-color: {{ $option['color_code'] }}"></i>@endif{{ $option['name'] }}</span>
                                            </label>
                                            @if (!empty($option['is_disabled']) && trim((string) ($option['disable_text'] ?? '')) !== '')<div class="configured-option-disable-text" data-configured-disable-text hidden><span class="configured-option-disable-indicator" aria-hidden="true"></span><div class="configured-option-disable-content">{!! app(\App\Support\RichTextSanitizer::class)->sanitize($option['disable_text']) !!}</div></div>@endif
                                        </div>
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
                                        <div class="configured-option-shell" data-configured-option="{{ $option['id'] }}">
                                            <div class="part-content">
                                                <label class="part-name" for="{{ $inputId }}">
                                                    <input id="{{ $inputId }}" type="radio" name="{{ $inputName }}" value="{{ $option['id'] }}" @checked($isChecked) @if ($group['is_required'] && $optionIndex === 0) required @endif data-option-id="{{ $option['id'] }}" data-option-name="{{ $option['name'] }}" data-option-image="{{ $option['images'][0] ?? '' }}" data-option-disabled="{{ !empty($option['is_disabled']) ? '1' : '0' }}" data-previous-order-yes="{{ $isPreviousOrderYes ? '1' : '0' }}">
                                                    {{ $option['name'] }} <span class="checkmark"></span>
                                                </label>
                                                @if ($option['detail'] !== null && $option['detail'] !== '')<span class="configured-option-detail">{{ $option['detail'] }}</span>@endif
                                            </div>
                                            @if (!empty($option['is_disabled']) && trim((string) ($option['disable_text'] ?? '')) !== '')<div class="configured-option-disable-text" data-configured-disable-text hidden><span class="configured-option-disable-indicator" aria-hidden="true"></span><div class="configured-option-disable-content">{!! app(\App\Support\RichTextSanitizer::class)->sanitize($option['disable_text']) !!}</div></div>@endif
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

                            @if (isset($group['remark_text']) && trim((string) $group['remark_text']) !== '')
                                <div class="configured-option-remark">{!! nl2br(e($group['remark_text'])) !!}</div>
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
                    @if ($summaryStepIndex === $stepIndex && ($summaryFields->isNotEmpty() || $priceSummaryFields->isNotEmpty()))
                        <section class="configured-detailed-summary" data-configured-detailed-summary>
                            <div class="configured-detailed-summary-columns">
                                @if ($summaryFields->isNotEmpty())
                                    <div class="configured-detailed-summary-column">
                                        <h3>製品仕様</h3>
                                        <table class="configured-detail-table configured-spec-table"><tbody>
                                            @foreach ($summaryFields as $field)
                                                <tr>
                                                    <td>{{ $field['label'] }}</td>
                                                    <td data-configured-detail-summary="{{ $field['key'] }}" data-configured-summary-group="{{ $field['group_id'] }}" data-configured-summary-option="{{ $field['option_id'] ?? '' }}">-</td>
                                                </tr>
                                            @endforeach
                                        </tbody></table>
                                    </div>
                                @endif
                                @if ($priceSummaryFields->isNotEmpty())
                                    <div class="configured-detailed-summary-column">
                                        <h3>製作料金</h3>
                                        <table class="configured-detail-table configured-price-table"><tbody>
                                            <tr><td>商品代金</td><td data-configured-price-row="product">0円</td></tr>
                                            @foreach ($priceSummaryFields as $field)
                                                <tr><td>{{ $field['label'] }}</td><td @if ($field['price_option_id'] !== null) data-configured-price-option="{{ $field['price_option_id'] }}" @else data-configured-price-group="{{ $field['group_id'] }}" @endif>0円</td></tr>
                                            @endforeach
                                            <tr><td>小計(税込)</td><td data-configured-price-row="subtotal">0円</td></tr>
                                            <tr><td>お値引き</td><td data-configured-price-row="discount">0円</td></tr>
                                            <tr><td>合計(税込)</td><td data-configured-price-row="total">0円</td></tr>
                                        </tbody></table>
                                    </div>
                                @endif
                            </div>
                        </section>
                    @endif
                </div>
            @endforeach
            <div id="acrylic-btn" class="btn-container configured-step-actions">
                <button type="button" class="btn btn-back" data-configured-step-back hidden>戻る</button>
                <button type="button" class="btn btn-next" data-configured-step-next>次へ</button>
                <button type="button" class="btn configured-final-action configured-final-action--small configured-final-action--clear" data-configured-final-action data-configured-clear hidden>CLEAR</button>
                <button type="button" class="btn configured-final-action configured-final-action--small configured-final-action--edit" data-configured-final-action data-configured-jump-step="0" hidden>製作条件修正</button>
                <button type="button" class="btn configured-final-action configured-final-action--small configured-final-action--edit" data-configured-final-action data-configured-jump-step="1" hidden>ｱﾀｯﾁﾒﾝﾄ修正</button>
                <button type="button" class="btn configured-final-action configured-final-action--estimate" data-configured-final-action data-configured-show-estimate hidden>見積書</button>
                <button type="button" class="btn configured-final-action configured-final-action--order" data-configured-final-action data-configured-order-info hidden>ご注文情報入力へ</button>
            </div>
        </form>
        <section class="configured-customer-details" data-configured-customer-details hidden>
            <table class="configured-customer-table"><tbody>
                <tr>
                    <td class="configured-customer-label">お名前（姓）</td>
                    <td class="configured-customer-field"><input type="text" name="estimate_customer[last_name]" maxlength="100" data-estimate-customer="last_name" autocomplete="family-name"></td>
                </tr>
                <tr>
                    <td class="configured-customer-label">お名前（名）</td>
                    <td class="configured-customer-field"><input type="text" name="estimate_customer[first_name]" maxlength="100" data-estimate-customer="first_name" autocomplete="given-name"></td>
                </tr>
                <tr>
                    <td class="configured-customer-label">法人名</td>
                    <td class="configured-customer-field"><input type="text" name="estimate_customer[company]" maxlength="100" data-estimate-customer="company" autocomplete="organization"></td>
                </tr>
                <tr>
                    <td class="configured-customer-label">郵便番号</td>
                    <td class="configured-customer-field">
                        <div class="configured-customer-postal">
                            <input type="text" name="estimate_customer[postal_code]" maxlength="8" inputmode="numeric" data-estimate-customer="postal_code" autocomplete="postal-code">
                            <button type="button" data-estimate-address-lookup>住所に変換</button>
                        </div>
                        <span class="configured-customer-error" data-estimate-address-error></span>
                    </td>
                </tr>
                <tr>
                    <td class="configured-customer-label">都道府県</td>
                    <td class="configured-customer-field"><input type="text" name="estimate_customer[prefecture]" data-estimate-customer="prefecture" autocomplete="address-level1"></td>
                </tr>
                <tr>
                    <td class="configured-customer-label">以降の住所</td>
                    <td class="configured-customer-field"><input type="text" name="estimate_customer[address]" data-estimate-customer="address" autocomplete="address-line1"></td>
                </tr>
                <tr>
                    <td class="configured-customer-label">番地、建物名、部屋番号</td>
                    <td class="configured-customer-field"><input type="text" name="estimate_customer[address_street]" data-estimate-customer="address_street" autocomplete="address-line2"></td>
                </tr>
                <tr>
                    <td class="configured-customer-label">TELハイフンなし</td>
                    <td class="configured-customer-field"><input type="text" name="estimate_customer[tel]" maxlength="30" inputmode="tel" data-estimate-customer="tel" autocomplete="tel"></td>
                </tr>
                <tr>
                    <td class="configured-customer-label">お客様メモ欄</td>
                    <td class="configured-customer-field"><input type="text" name="estimate_customer[comment]" maxlength="1000" data-estimate-customer="comment"></td>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 10px 4px; border: 0; background: #fff;">
                        <button type="button" class="configured-customer-submit" data-estimate-customer-submit>御社情報確定（PDF出力）</button>
                        <p class="configured-customer-note">※社名や会社名の入力は任意です</p>
                    </td>
                </tr>
            </tbody></table>
        </section>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const orderForm = document.querySelector('#order-form.admin-configured-order-form');
            if (!orderForm) return;
            const stepLinks = Array.from(orderForm.querySelectorAll('[data-configured-step-link]'));
            const backButton = orderForm.querySelector('[data-configured-step-back]');
            const nextButton = orderForm.querySelector('[data-configured-step-next]');
            const finalActionButtons = Array.from(orderForm.querySelectorAll('[data-configured-final-action]'));
            const dependencies = @json($orderDependencies ?? []);
            const pricing = @json($orderPricing ?? ['product_rules' => [], 'option_rules' => []]);
            const estimatePdfUrl = @json(route('products.estimate.pdf', ['productPath' => $product->slug]));
            const estimateCsrfToken = @json(csrf_token());
            const customerDetails = orderForm.querySelector('[data-configured-customer-details]');
            const hideCustomerDetails = function () {
                if (customerDetails) customerDetails.hidden = true;
            };
            let currentStep = 0;

            const currentStepHasDisabledOption = function () {
                const step = orderForm.querySelector('[data-configured-step="' + currentStep + '"]');
                return Boolean(step?.querySelector('input:checked:not(:disabled)[data-option-disabled="1"]'));
            };
            const updateDisabledOptionMessages = function () {
                orderForm.querySelectorAll('[data-configured-option]').forEach(function (option) {
                    const input = option.querySelector('input[data-option-id]');
                    const message = option.querySelector('[data-configured-disable-text]');
                    const isSelected = Boolean(input && !input.disabled && input.checked);
                    const isDisabled = input?.dataset.optionDisabled === '1';

                    option.classList.toggle('is-configured-disabled-selection', isSelected && isDisabled);
                    if (message) message.hidden = !(isSelected && isDisabled);
                });
            };
            const updateStepActions = function () {
                const hasNextStep = currentStep < stepLinks.length - 1;
                const isFinalStep = !hasNextStep;

                orderForm.querySelector('.configured-step-actions')?.classList.toggle('is-final', isFinalStep);
                if (backButton) backButton.hidden = currentStep === 0 || isFinalStep;
                if (nextButton) {
                    nextButton.hidden = isFinalStep;
                    nextButton.disabled = hasNextStep && currentStepHasDisabledOption();
                    if (hasNextStep) {
                        const label = stepLinks[currentStep + 1].querySelector('.configured-step-label')?.textContent.trim() || '次へ';
                        nextButton.textContent = label + 'へ';
                    }
                }

                finalActionButtons.forEach(function (button) { button.hidden = !isFinalStep; });
            };
            const showStep = function (index, shouldScroll) {
                currentStep = Math.max(0, Math.min(index, stepLinks.length - 1));
                orderForm.querySelectorAll('[data-configured-step]').forEach(function (step) {
                    step.classList.toggle('active', Number(step.dataset.configuredStep) === currentStep);
                });
                orderForm.querySelectorAll('[data-configured-step-link]').forEach(function (link) {
                    const stepIndex = Number(link.dataset.configuredStepLink);
                    link.classList.toggle('active', stepIndex === currentStep);
                    link.classList.toggle('completed', stepIndex < currentStep);
                });
                updateStepActions();
                if (shouldScroll) orderForm.querySelector('.configured-step-list')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            };
            const updateSummary = function () {
                const summaryValueForGroup = function (group) {
                    if (group.dataset.configuredDisplayType === 'quantity_input') {
                        return group.querySelector('input[type="number"]:not(:disabled)')?.value || '-';
                    }
                    if (group.dataset.configuredDisplayType === 'switch') {
                        return Array.from(group.querySelectorAll('input[type="checkbox"]'))
                            .filter(function (input) { return !input.disabled && input.checked; })
                            .map(function (input) { return input.dataset.optionName || ''; })
                            .filter(Boolean)
                            .join('\u3001') || '\u306A\u3057';
                    }

                    return Array.from(group.querySelectorAll('input:checked:not(:disabled)'))
                        .map(function (input) { return input.dataset.optionName || ''; })
                        .filter(Boolean)
                        .join('\u3001') || '-';
                };
                orderForm.querySelectorAll('[data-configured-preview-summary], [data-configured-detail-summary], [data-configured-pdf-summary]').forEach(function (cell) {
                    const group = orderForm.querySelector('[data-configured-group="' + cell.dataset.configuredSummaryGroup + '"]');
                    if (!group) return;

                    const optionId = Number(cell.dataset.configuredSummaryOption || 0);
                    if (optionId > 0) {
                        const input = group.querySelector('input[data-option-id="' + optionId + '"]');
                        const isSelected = Boolean(input && !input.disabled && input.checked);
                        cell.textContent = group.dataset.configuredDisplayType === 'switch'
                            ? (isSelected ? '\u3042\u308A' : '\u306A\u3057')
                            : (isSelected ? (input.dataset.optionName || '-') : '-');
                        return;
                    }

                    cell.textContent = summaryValueForGroup(group);
                });
                orderForm.querySelectorAll('[data-configured-group]').forEach(function (group) {
                    const summaryCells = orderForm.querySelectorAll(
                        '[data-configured-preview-summary="' + group.dataset.configuredGroup + '"], [data-configured-detail-summary="' + group.dataset.configuredGroup + '"], [data-configured-pdf-summary="group-' + group.dataset.configuredGroup + '"]'
                    );
                    const setSummaryValue = function (value) {
                        summaryCells.forEach(function (cell) {
                            cell.textContent = value;
                        });
                    };
                    const summary = {
                        set textContent (value) {
                            setSummaryValue(value);
                        },
                    };
                    if (group.dataset.configuredDisplayType === 'quantity_input') {
                        setSummaryValue(group.querySelector('input[type="number"]')?.value || '-');
                        return;
                    }
                    if (group.dataset.configuredDisplayType === 'switch') {
                        if (summary) summary.textContent = group.querySelector('input[type="checkbox"]')?.checked ? 'あり' : 'なし';
                        return;
                    }

                    const selected = Array.from(group.querySelectorAll('input:checked:not(:disabled)'));
                    const names = selected.map(function (input) { return input.dataset.optionName || ''; }).filter(Boolean);
                    if (summary) summary.textContent = names.join('、') || '-';
                });
                orderForm.querySelectorAll('[data-configured-previous-order]').forEach(function (detail) {
                    const group = detail.closest('[data-configured-group]');
                    const isYes = group?.querySelector('input:checked[data-previous-order-yes="1"]') !== null;
                    detail.hidden = !isYes;
                    const field = detail.querySelector('input[type="text"]');
                    if (field) field.disabled = !isYes;
                });
                const selectedOptionForDisplayType = function (displayType) {
                    const group = Array.from(orderForm.querySelectorAll('[data-configured-group]')).find(function (candidate) {
                        return candidate.dataset.configuredDisplayType === displayType;
                    });
                    return Array.from(group?.querySelectorAll('input:checked[data-option-name]') || []).find(function (input) {
                        return input.dataset.optionImage && !input.disabled;
                    });
                };
                const previewOption = selectedOptionForDisplayType('image_grid') || Array.from(orderForm.querySelectorAll('input:checked[data-option-name]')).find(function (input) {
                    return input.dataset.optionImage && !input.disabled && input.closest('[data-configured-group]')?.dataset.configuredDisplayType !== 'paper_preview';
                });
                const paperPreviewOption = selectedOptionForDisplayType('paper_preview');
                const previewName = orderForm.querySelector('[data-configured-preview-name]');
                const previewImage = orderForm.querySelector('[data-configured-preview-image]');
                const paperPreviewName = orderForm.querySelector('[data-configured-paper-preview-name]');
                const paperPreviewImage = orderForm.querySelector('[data-configured-paper-preview-image]');
                if (previewName) previewName.textContent = previewOption?.dataset.optionName || '-';
                if (previewImage) previewImage.src = previewOption?.dataset.optionImage
                    ? '/product-options/' + encodeURIComponent(previewOption.dataset.optionImage)
                    : '/products/acrylic/img/coming-soon.webp';
                if (paperPreviewName) paperPreviewName.textContent = paperPreviewOption?.dataset.optionName || 'なし';
                if (paperPreviewImage) paperPreviewImage.src = paperPreviewOption?.dataset.optionImage
                    ? '/product-options/' + encodeURIComponent(paperPreviewOption.dataset.optionImage)
                    : '/products/acrylic/img/coming-soon.webp';
            };
            const formatPrice = function (amount) {
                return Math.round(Number(amount) || 0).toLocaleString('ja-JP') + '円';
            };
            const getOrderQuantity = function () {
                const input = orderForm.querySelector('input[type="number"]:not(:disabled)');
                const quantity = Number(input?.value || 1);
                return Number.isFinite(quantity) && quantity > 0 ? Math.floor(quantity) : 1;
            };
            const selectedOptionIds = function () {
                return new Set(Array.from(orderForm.querySelectorAll('input:checked:not(:disabled)[data-option-id]'))
                    .map(function (input) { return Number(input.dataset.optionId); })
                    .filter(function (id) { return Number.isFinite(id) && id > 0; }));
            };
            const matchingTier = function (tiers, quantity) {
                const usableTiers = (Array.isArray(tiers) ? tiers : [])
                    .filter(function (tier) { return Number(tier.quantity) > 0; });
                if (!usableTiers.length) return null;

                const eligibleTiers = usableTiers.filter(function (tier) {
                    return Number(tier.quantity) <= quantity;
                });
                if (eligibleTiers.length) {
                    return eligibleTiers.reduce(function (selected, tier) {
                        return Number(tier.quantity) > Number(selected.quantity) ? tier : selected;
                    });
                }

                return usableTiers.find(function (tier) { return tier.is_display; }) || usableTiers[0];
            };
            const ruleMatches = function (rule, selectedIds) {
                return (Array.isArray(rule.conditions) ? rule.conditions : []).every(function (optionId) {
                    return selectedIds.has(Number(optionId));
                });
            };
            const updatePricing = function () {
                const quantity = getOrderQuantity();
                const selectedIds = selectedOptionIds();
                const productRules = Array.isArray(pricing.product_rules) ? pricing.product_rules : [];
                const optionRules = Array.isArray(pricing.option_rules) ? pricing.option_rules : [];
                const matchingProductRule = productRules
                    .filter(function (rule) { return ruleMatches(rule, selectedIds) && matchingTier(rule.tiers, quantity); })
                    .sort(function (left, right) {
                        return (right.conditions?.length || 0) - (left.conditions?.length || 0);
                    })[0];
                const productTier = matchingProductRule ? matchingTier(matchingProductRule.tiers, quantity) : null;
                const productTotal = productTier ? (Number(productTier.unit_price_with_tax) || 0) * quantity : 0;
                const chargesByGroup = new Map();
                const chargesByOption = new Map();

                optionRules.forEach(function (rule) {
                    const targetOptionId = Number(rule.target_option_id);
                    if (!targetOptionId || !selectedIds.has(targetOptionId) || !ruleMatches(rule, selectedIds)) return;

                    const tier = matchingTier(rule.tiers, quantity);
                    if (!tier) return;

                    const tierPrice = Number(tier.additional_price_with_tax) || 0;
                    const charge = rule.price_type === 'per_piece' ? tierPrice * quantity : tierPrice;
                    chargesByOption.set(targetOptionId, (chargesByOption.get(targetOptionId) || 0) + charge);

                    const groupId = Number(rule.target_group_id);
                    if (groupId > 0) chargesByGroup.set(groupId, (chargesByGroup.get(groupId) || 0) + charge);
                });

                const optionChargeTotal = Array.from(chargesByOption.values()).reduce(function (total, amount) {
                    return total + amount;
                }, 0);
                const subtotal = productTotal + optionChargeTotal;
                const discount = 0;
                const total = subtotal - discount;

                orderForm.querySelectorAll('[data-configured-price-row="product"]').forEach(function (cell) {
                    cell.textContent = formatPrice(productTotal);
                });
                orderForm.querySelectorAll('[data-configured-price-group]').forEach(function (cell) {
                    cell.textContent = formatPrice(chargesByGroup.get(Number(cell.dataset.configuredPriceGroup)) || 0);
                });
                orderForm.querySelectorAll('[data-configured-price-option]').forEach(function (cell) {
                    cell.textContent = formatPrice(chargesByOption.get(Number(cell.dataset.configuredPriceOption)) || 0);
                });
                orderForm.querySelectorAll('[data-configured-price-row="subtotal"]').forEach(function (cell) {
                    cell.textContent = formatPrice(subtotal);
                });
                orderForm.querySelectorAll('[data-configured-price-row="discount"]').forEach(function (cell) {
                    cell.textContent = formatPrice(discount);
                });
                orderForm.querySelectorAll('[data-configured-price-row="total"]').forEach(function (cell) {
                    cell.textContent = formatPrice(total);
                });
                orderForm.querySelectorAll('.prd_total').forEach(function (element) {
                    element.textContent = Math.round(total).toLocaleString('ja-JP');
                });
                orderForm.querySelectorAll('[data-configured-option-price]').forEach(function (element) {
                    element.textContent = '+' + formatPrice(chargesByOption.get(Number(element.dataset.configuredOptionPrice)) || 0);
                });
            };
            const applyDependencies = function () {
                const targetStates = new Map();

                dependencies.forEach(function (dependency) {
                    const targetKey = dependency.target_type + ':' + dependency.target_id;
                    const state = targetStates.get(targetKey) || {
                        type: dependency.target_type,
                        id: dependency.target_id,
                        showMatches: [],
                        hide: false,
                        lock: false,
                        disable: false,
                    };
                    const isTriggered = Array.from(orderForm.querySelectorAll('input:checked')).some(function (input) {
                        return Number(input.dataset.optionId || input.value) === Number(dependency.trigger_option_id);
                    });

                    if (dependency.action_type === 'show') state.showMatches.push(isTriggered);
                    if (dependency.action_type === 'hide' && isTriggered) state.hide = true;
                    if (dependency.action_type === 'lock' && isTriggered) state.lock = true;
                    if (dependency.action_type === 'disable' && isTriggered) state.disable = true;
                    targetStates.set(targetKey, state);
                });

                targetStates.forEach(function (state) {
                    const target = state.type === 'group'
                        ? orderForm.querySelector('[data-configured-group="' + state.id + '"]')
                        : orderForm.querySelector('[data-configured-option="' + state.id + '"]');
                    if (!target) return;

                    const isVisible = !state.hide && (state.showMatches.length === 0 || state.showMatches.some(Boolean));
                    const isDisabled = !isVisible || state.lock || state.disable;
                    target.classList.toggle('is-configured-hidden', !isVisible);
                    target.classList.toggle('is-configured-locked', state.lock);
                    target.setAttribute('aria-hidden', isVisible ? 'false' : 'true');

                    target.querySelectorAll('input, select, textarea, button').forEach(function (control) {
                        if (control.dataset.configuredOriginalDisabled === undefined) {
                            control.dataset.configuredOriginalDisabled = control.disabled ? '1' : '0';
                        }
                        control.disabled = isDisabled || control.dataset.configuredOriginalDisabled === '1';
                    });
                });
            };
            const currentStepIsValid = function () {
                const step = orderForm.querySelector('[data-configured-step="' + currentStep + '"]');
                if (!step) return true;

                const disabledInput = step.querySelector('input:checked:not(:disabled)[data-option-disabled="1"]');
                if (disabledInput) {
                    updateDisabledOptionMessages();
                    disabledInput.focus();
                    return false;
                }

                const requiredInputs = Array.from(step.querySelectorAll('input[required]:not(:disabled), select[required]:not(:disabled), textarea[required]:not(:disabled)'));
                for (const input of requiredInputs) {
                    if (input.type === 'radio') {
                        const selected = Array.from(step.querySelectorAll('input[type="radio"]:checked')).some(function (candidate) {
                            return candidate.name === input.name;
                        });
                        if (selected) continue;
                    } else if (input.checkValidity()) {
                        continue;
                    }

                    input.reportValidity();
                    input.focus();
                    return false;
                }

                return true;
            };
            stepLinks.forEach(function (link) {
                link.addEventListener('click', function () {
                    const targetStep = Number(link.dataset.configuredStepLink);
                    if (targetStep > currentStep && !currentStepIsValid()) return;
                    showStep(targetStep, false);
                });
            });
            nextButton?.addEventListener('click', function () {
                if (currentStepIsValid()) showStep(currentStep + 1, true);
            });
            backButton?.addEventListener('click', function () { showStep(currentStep - 1, true); });
            orderForm.querySelectorAll('[data-configured-jump-step]').forEach(function (button) {
                button.addEventListener('click', function () {
                    hideCustomerDetails();
                    showStep(Number(button.dataset.configuredJumpStep), true);
                });
            });
            orderForm.querySelector('[data-configured-clear]')?.addEventListener('click', function () {
                orderForm.querySelector('#configured-order-form')?.reset();
                customerDetails?.querySelectorAll('input').forEach(function (input) { input.value = ''; });
                hideCustomerDetails();
                applyDependencies();
                updateDisabledOptionMessages();
                updateSummary();
                updatePricing();
                showStep(0, true);
            });
            orderForm.querySelector('[data-configured-show-estimate]')?.addEventListener('click', function () {
                if (!currentStepIsValid()) return;

                updateSummary();
                updatePricing();

                if (!customerDetails) return;
                const shouldShow = customerDetails.hidden;
                customerDetails.hidden = !shouldShow;
                if (shouldShow) {
                    customerDetails.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    customerDetails.querySelector('input')?.focus({ preventScroll: true });
                }
            });
            orderForm.querySelector('[data-estimate-address-lookup]')?.addEventListener('click', async function () {
                const postalInput = orderForm.querySelector('[data-estimate-customer="postal_code"]');
                const prefectureInput = orderForm.querySelector('[data-estimate-customer="prefecture"]');
                const addressInput = orderForm.querySelector('[data-estimate-customer="address"]');
                const error = orderForm.querySelector('[data-estimate-address-error]');
                const button = this;
                const postalCode = String(postalInput?.value || '').replace(/[^0-9]/g, '');

                if (postalCode.length !== 7) {
                    if (error) error.textContent = '郵便番号を7桁で入力してください。';
                    return;
                }

                if (error) error.textContent = '';
                button.disabled = true;
                try {
                    const response = await fetch('https://zipcloud.ibsnet.co.jp/api/search?zipcode=' + postalCode);
                    const data = await response.json();
                    const result = data.results?.[0];
                    if (!result) throw new Error('not-found');
                    if (prefectureInput) prefectureInput.value = result.address1 || '';
                    if (addressInput) addressInput.value = (result.address2 || '') + (result.address3 || '');
                } catch (errorResponse) {
                    if (error) error.textContent = '自動変換できませんでした。都道府県、以降の住所をご入力下さい';
                    if (prefectureInput) prefectureInput.value = '';
                    if (addressInput) addressInput.value = '';
                } finally {
                    button.disabled = false;
                }
            });
            orderForm.querySelector('[data-estimate-customer-submit]')?.addEventListener('click', function () {
                if (!currentStepIsValid()) return;

                const downloadFrameName = 'configured_estimate_download_' + Date.now();
                const downloadFrame = document.createElement('iframe');
                downloadFrame.name = downloadFrameName;
                downloadFrame.title = 'PDF download';
                downloadFrame.hidden = true;
                downloadFrame.setAttribute('aria-hidden', 'true');
                document.body.appendChild(downloadFrame);

                const exportForm = document.createElement('form');
                exportForm.method = 'POST';
                exportForm.action = estimatePdfUrl;
                exportForm.target = downloadFrameName;
                exportForm.style.display = 'none';

                const addField = function (name, value) {
                    const field = document.createElement('input');
                    field.type = 'hidden';
                    field.name = name;
                    field.value = value == null ? '' : String(value);
                    exportForm.appendChild(field);
                };
                const amountFromText = function (value) {
                    const amount = Number(String(value || '').replace(/[^0-9.-]/g, ''));
                    return Number.isFinite(amount) ? Math.round(amount) : 0;
                };

                addField('_token', estimateCsrfToken || document.querySelector('meta[name="csrf-token"]')?.content || '');
                addField('quantity', getOrderQuantity());
                const totalText = orderForm.querySelector('[data-configured-price-row="total"]')?.textContent
                    || orderForm.querySelector('.prd_total')?.textContent;
                const subtotalText = orderForm.querySelector('[data-configured-price-row="subtotal"]')?.textContent || totalText;
                const discountText = orderForm.querySelector('[data-configured-price-row="discount"]')?.textContent;
                addField('total_amount', amountFromText(totalText));
                addField('subtotal_amount', amountFromText(subtotalText));
                addField('discount_amount', amountFromText(discountText));

                orderForm.querySelectorAll('[data-estimate-customer]').forEach(function (input) {
                    addField(input.name, input.value.trim());
                });

                const pdfSummaryCells = Array.from(orderForm.querySelectorAll('[data-configured-pdf-summary]'));
                pdfSummaryCells.forEach(function (cell, index) {
                    const label = cell.closest('tr')?.querySelector('td:first-child')?.textContent.trim() || '';
                    addField('summary[' + index + '][label]', label);
                    addField('summary[' + index + '][value]', cell.textContent.trim());
                });

                Array.from(orderForm.querySelectorAll('.configured-price-table tbody tr')).forEach(function (row, index) {
                    const cells = Array.from(row.children);
                    const valueCell = cells[1];
                    const marker = valueCell?.matches('[data-configured-price-row]')
                        ? valueCell
                        : valueCell?.querySelector('[data-configured-price-row]');
                    const label = cells[0]?.textContent.trim() || '';
                    const kind = marker?.dataset.configuredPriceRow || (label === '商品代金' ? 'product' : 'charge');
                    addField('price_rows[' + index + '][label]', label);
                    addField('price_rows[' + index + '][amount]', amountFromText(valueCell?.textContent));
                    addField('price_rows[' + index + '][kind]', kind);
                });

                document.body.appendChild(exportForm);
                exportForm.submit();
                exportForm.remove();
                window.setTimeout(function () {
                    downloadFrame.remove();
                }, 30000);
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
            orderForm.querySelectorAll('input').forEach(function (input) {
                input.addEventListener('change', function () {
                    applyDependencies();
                    updateDisabledOptionMessages();
                    updateSummary();
                    updatePricing();
                    updateStepActions();
                });
                if (input.type === 'number') input.addEventListener('input', function () {
                    updateSummary();
                    updatePricing();
                });
            });
            applyDependencies();
            updateDisabledOptionMessages();
            updateSummary();
            updatePricing();
            showStep(0, false);
        });
    </script>
@endpush
