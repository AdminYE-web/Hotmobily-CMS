<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\OptionDependency;
use App\Models\OptionPriceRule;
use App\Models\Product;
use App\Models\ProductPriceRule;
use App\Models\ProductPdfSummaryCustomRow;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Product Page
    |--------------------------------------------------------------------------
    |
    | Examples:
    |
    | /products/rubberstrap
    |
    | /products/acrylic/figure
    |
    | /products/acrylic/keyholder
    |
    */

    public function show(
        string $productPath
    ) {

        /*
        |--------------------------------------------------------------------------
        | Normalize Product Path
        |--------------------------------------------------------------------------
        */

        $productPath =
            trim(
                $productPath,
                '/'
            );

        /*
        |--------------------------------------------------------------------------
        | Find Product
        |--------------------------------------------------------------------------
        */

        $product = Product::query()
            ->where(
                'slug',
                $productPath
            )
            ->where(
                'status',
                'active'
            )
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Load Relations
        |--------------------------------------------------------------------------
        */

        $product->load([
            'layout',
            'page',
            'optionSteps',
            'optionGroupAssignments.optionGroup.productOptions',
            'optionGroupAssignments.items.productOption',
        ]);
        if (Schema::hasTable('product_pdf_summary_custom_rows')) {
            $product->load('pdfSummaryCustomRows');
        }

        /*
        |--------------------------------------------------------------------------
        | Published Layout
        |--------------------------------------------------------------------------
        */

        if (
            ! $product->layout
            ||
            empty(
                $product
                    ->layout
                    ->published_layout_json
            )
        ) {

            abort(404);

        }

        /*
        |--------------------------------------------------------------------------
        | Published Content
        |--------------------------------------------------------------------------
        */

        if (
            ! $product->page
            ||
            empty(
                $product
                    ->page
                    ->published_content_json
            )
        ) {

            abort(404);

        }

        /*
        |--------------------------------------------------------------------------
        | Data
        |--------------------------------------------------------------------------
        */

        $layout =
            $product
                ->layout
                ->published_layout_json;

        $content =
            $product
                ->page
                ->published_content_json;

        $blocks =
            $content['blocks']
            ??
            [];

        $selectedFaqProductIds = collect($blocks)
            ->filter(
                fn (mixed $blockContent): bool => is_array($blockContent)
            )
            ->map(
                fn (array $blockContent): int => (int) (
                    $blockContent['faq_product_id']
                    ?? 0
                )
            )
            ->filter()
            ->unique()
            ->values();

        $faqData = [];

        if ($selectedFaqProductIds->isNotEmpty()) {
            $faqProducts = Faq::query()
                ->whereIn('id', $selectedFaqProductIds->all())
                ->where('category', 'product')
                ->where('entry_type', 'product')
                ->where('is_active', true)
                ->get([
                    'id',
                    'material',
                    'question_name',
                ])
                ->keyBy('id');

            $productFaqItems = Faq::query()
                ->whereIn('product_id', $faqProducts->keys()->all())
                ->where('category', 'product')
                ->where('entry_type', 'faq')
                ->where('is_active', true)
                ->whereNotNull('question')
                ->where('question', '<>', '')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get([
                    'id',
                    'product_id',
                    'question',
                    'answer',
                ])
                ->groupBy('product_id');

            foreach ($blocks as $blockId => $blockContent) {
                if (! is_array($blockContent)) {
                    continue;
                }

                $faqProductId = (int) (
                    $blockContent['faq_product_id']
                    ?? 0
                );

                if (! $faqProductId || ! $faqProducts->has($faqProductId)) {
                    continue;
                }

                $faqData[(string) $blockId] = [
                    'product' => $faqProducts->get($faqProductId),
                    'faqs' => $productFaqItems
                        ->get($faqProductId, collect())
                        ->take(3)
                        ->values(),
                ];
            }
        }

        $selectedReviewProductTypes = collect($blocks)
            ->filter(
                fn (mixed $blockContent): bool => is_array($blockContent)
            )
            ->map(
                fn (array $blockContent): string => trim((string) (
                    $blockContent['review_product_type']
                    ?? ''
                ))
            )
            ->filter()
            ->unique()
            ->values();

        $reviewData = [];

        if (
            $selectedReviewProductTypes->isNotEmpty()
            &&
            Review::tableExists()
        ) {
            $reviewsByProductType = Review::query()
                ->whereIn('product_type', $selectedReviewProductTypes->all())
                ->orderByDesc('date_reviews')
                ->orderByDesc('id')
                ->get([
                    'id',
                    'comment',
                    'service',
                    'product',
                    'product_type',
                    'images',
                    'sale_name',
                    'date_reviews',
                ])
                ->groupBy(
                    static fn (Review $review): string => trim((string) $review->product_type)
                );

            foreach ($blocks as $blockId => $blockContent) {
                if (! is_array($blockContent)) {
                    continue;
                }

                $reviewProductType = trim((string) (
                    $blockContent['review_product_type']
                    ?? ''
                ));

                if (
                    $reviewProductType === ''
                    ||
                    ! $reviewsByProductType->has($reviewProductType)
                ) {
                    continue;
                }

                $reviewData[(string) $blockId] = [
                    'product_type' => $reviewProductType,
                    'reviews' => $reviewsByProductType
                        ->get($reviewProductType, collect())
                        ->take(3)
                        ->values(),
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Render
        |--------------------------------------------------------------------------
        */

        $orderSteps = $this->storefrontOrderSteps($product);
        $orderPricing = $this->storefrontOrderPricing($product);
        $pdfSummaryCustomRows = $product->relationLoaded('pdfSummaryCustomRows')
            ? $product->pdfSummaryCustomRows
                ->map(static fn (ProductPdfSummaryCustomRow $row): array => [
                    'id' => (int) $row->id,
                    'key' => 'custom-'.$row->id,
                    'label' => $row->label,
                    'content' => $row->content,
                    'sort_order' => (int) $row->sort_order,
                ])
                ->values()
                ->all()
            : [];

        return view(
            'products.show',
            [

                'product' => $product,

                'layout' => $layout,

                'contents' => $blocks,

                'publishedAt' => $product
                    ->page
                    ->published_at,

                'faqData' => $faqData,

                'reviewData' => $reviewData,

                'orderSteps' => $orderSteps,

                'orderPricing' => $orderPricing,

                'pdfSummaryCustomRows' => $pdfSummaryCustomRows,

                'orderDependencies' => $this->storefrontOptionDependencies($orderSteps),

            ]
        );
    }

    /**
     * Render the quotation using the same document structure as the legacy
     * rubberstrap estimate template. The values are collected from the
     * already-calculated order summary in the browser.
     */
    public function estimatePdf(Request $request, string $productPath)
    {
        $productPath = trim($productPath, '/');

        $product = Product::query()
            ->where('slug', $productPath)
            ->where('status', 'active')
            ->firstOrFail();

        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:1000000000'],
            'total_amount' => ['nullable', 'integer', 'min:0', 'max:100000000000'],
            'subtotal_amount' => ['nullable', 'integer', 'min:0', 'max:100000000000'],
            'discount_amount' => ['nullable', 'integer', 'max:100000000000'],
            'estimate_customer' => ['nullable', 'array'],
            'estimate_customer.last_name' => ['nullable', 'string', 'max:100'],
            'estimate_customer.first_name' => ['nullable', 'string', 'max:100'],
            'estimate_customer.company' => ['nullable', 'string', 'max:100'],
            'estimate_customer.postal_code' => ['nullable', 'string', 'max:8'],
            'estimate_customer.prefecture' => ['nullable', 'string', 'max:100'],
            'estimate_customer.address' => ['nullable', 'string', 'max:255'],
            'estimate_customer.address_street' => ['nullable', 'string', 'max:255'],
            'estimate_customer.tel' => ['nullable', 'string', 'max:30'],
            'estimate_customer.comment' => ['nullable', 'string', 'max:1000'],
            'summary' => ['nullable', 'array', 'max:100'],
            'summary.*' => ['array'],
            'summary.*.label' => ['required', 'string', 'max:255'],
            'summary.*.value' => ['nullable', 'string', 'max:2000'],
            'price_rows' => ['nullable', 'array', 'max:100'],
            'price_rows.*' => ['array'],
            'price_rows.*.label' => ['required', 'string', 'max:255'],
            'price_rows.*.amount' => ['nullable', 'integer', 'min:0', 'max:100000000000'],
            'price_rows.*.kind' => ['nullable', 'string', 'in:product,charge,subtotal,discount,total'],
        ]);

        $summaryRows = collect($validated['summary'] ?? [])
            ->map(static fn (array $row): array => [
                'label' => trim((string) ($row['label'] ?? '')),
                'value' => trim((string) ($row['value'] ?? '')),
            ])
            ->filter(static fn (array $row): bool => $row['label'] !== '')
            ->values()
            ->all();

        $priceRows = collect($validated['price_rows'] ?? [])
            ->map(static fn (array $row): array => [
                'label' => trim((string) ($row['label'] ?? '')),
                'amount' => max(0, (int) ($row['amount'] ?? 0)),
                'kind' => $row['kind'] ?? 'charge',
            ])
            ->filter(static fn (array $row): bool => $row['label'] !== '')
            ->values()
            ->all();

        if (! collect($priceRows)->contains(static fn (array $row): bool => $row['kind'] === 'product')) {
            $productRowIndex = collect($priceRows)->search(
                static fn (array $row): bool => in_array($row['label'], ['商品代金', '商品価格'], true)
            );

            if ($productRowIndex !== false) {
                $priceRows[$productRowIndex]['kind'] = 'product';
            }
        }

        $totalAmount = (int) ($validated['total_amount'] ?? 0);
        $subtotalAmount = (int) ($validated['subtotal_amount'] ?? $totalAmount);
        $discountAmount = (int) ($validated['discount_amount'] ?? 0);
        $taxAmount = (int) round($totalAmount * 10 / 110);
        $quantity = (int) ($validated['quantity'] ?? 1);
        $customerInput = $validated['estimate_customer'] ?? [];
        $customer = [
            'last_name' => trim((string) ($customerInput['last_name'] ?? '')),
            'first_name' => trim((string) ($customerInput['first_name'] ?? '')),
            'company' => trim((string) ($customerInput['company'] ?? '')),
            'postal_code' => trim((string) ($customerInput['postal_code'] ?? '')),
            'prefecture' => trim((string) ($customerInput['prefecture'] ?? '')),
            'address' => trim((string) ($customerInput['address'] ?? '')),
            'address_street' => trim((string) ($customerInput['address_street'] ?? '')),
            'tel' => trim((string) ($customerInput['tel'] ?? '')),
            'comment' => trim((string) ($customerInput['comment'] ?? '')),
        ];

        $estimateFilename = 'HM_QT_'.now('Asia/Tokyo')->format('Ymd_His');
        $estimateViewData = [
            'product' => $product,
            'customer' => $customer,
            'summaryRows' => $summaryRows,
            'priceRows' => $priceRows,
            'quantity' => $quantity,
            'totalAmount' => $totalAmount,
            'subtotalAmount' => $subtotalAmount,
            'discountAmount' => $discountAmount,
            'taxAmount' => $taxAmount,
            'estimateNumber' => $estimateFilename,
            'issuedDate' => now('Asia/Tokyo')->format('Y年n月j日'),
            'forPdf' => true,
        ];

        $html = view('products.pdf.estimate', $estimateViewData)->render();
        $html = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $html) ?? $html;
        $html = str_replace(
            [
                asset('img/img_hb.png'),
                asset('img/stamp_pdf_hm.png'),
            ],
            [
                public_path('img/img_hb.png'),
                public_path('img/stamp_pdf_hm.png'),
            ],
            $html
        );

        $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('HotMobily');
        $pdf->SetTitle($estimateFilename);
        $pdf->SetSubject($estimateFilename);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetDefaultMonospacedFont(defined('PDF_FONT_MONOSPACED') ? PDF_FONT_MONOSPACED : 'courier');
        $pdf->SetMargins(5, 3, 5);
        $pdf->SetAutoPageBreak(true, defined('PDF_MARGIN_BOTTOM') ? PDF_MARGIN_BOTTOM : 25);
        $pdf->setImageScale(defined('PDF_IMAGE_SCALE_RATIO') ? PDF_IMAGE_SCALE_RATIO : 1.25);
        $pdf->SetFont('cid0jp', '', 12);
        $pdf->AddPage();
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        $pdfContent = $pdf->Output($estimateFilename.'.pdf', 'S');

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$estimateFilename.'.pdf"',
            'Content-Length' => (string) strlen($pdfContent),
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        ]);
    }

    /**
     * Build the storefront-safe order configuration from the product options
     * selected in the Admin "Manage Options" screen.
     *
     * @return list<array{id: int|null, name: string, groups: list<array<string, mixed>>}>
     */
    private function storefrontOrderSteps(Product $product): array
    {
        $assignmentsByStep = $product->optionGroupAssignments
            ->groupBy('product_option_step_id');

        $groupsForAssignments = static function ($assignments): array {
            return $assignments
                ->map(static function ($assignment): ?array {
                    $group = $assignment->optionGroup;

                    if ($group === null || ! $group->is_active) {
                        return null;
                    }

                    $optionRows = $assignment->has_option_configuration
                        ? $assignment->items
                            ->filter(static fn ($item): bool => $item->is_active && $item->productOption !== null && $item->productOption->is_active)
                            ->sortBy('sort_order')
                            ->map(static fn ($item): array => [
                                'option' => $item->productOption,
                                'is_default' => $item->is_default,
                                'quantity_rule' => $item->quantity_rule,
                                'min_qty' => $item->min_qty,
                                'max_qty' => $item->max_qty,
                                'exact_qty' => $item->exact_qty,
                                'show_in_order_summary' => (bool) $item->show_in_order_summary,
                                'summary_label' => $item->summary_label,
                                'summary_sort_order' => (int) $item->summary_sort_order,
                                 'show_in_preview_summary' => (bool) $item->show_in_preview_summary,
                                 'preview_summary_label' => $item->preview_summary_label,
                                 'preview_summary_sort_order' => (int) $item->preview_summary_sort_order,
                                'show_in_price_summary' => (bool) $item->show_in_price_summary,
                                'price_summary_label' => $item->price_summary_label,
                                'price_summary_sort_order' => (int) $item->price_summary_sort_order,
                                'price_summary_option_id' => $item->price_summary_option_id === null ? null : (int) $item->price_summary_option_id,
                                'show_in_pdf_summary' => (bool) $item->show_in_pdf_summary,
                                'pdf_summary_label' => $item->pdf_summary_label,
                                'pdf_summary_sort_order' => (int) $item->pdf_summary_sort_order,
                             ])
                        : $group->productOptions
                            ->filter(static fn ($option): bool => $option->is_active)
                            ->map(static fn ($option): array => [
                                'option' => $option,
                                'is_default' => false,
                                'quantity_rule' => 'no_limit',
                                'min_qty' => null,
                                'max_qty' => null,
                                'exact_qty' => null,
                                'show_in_order_summary' => false,
                                'summary_label' => null,
                                'summary_sort_order' => 0,
                                 'show_in_preview_summary' => false,
                                 'preview_summary_label' => null,
                                 'preview_summary_sort_order' => 0,
                                 'show_in_price_summary' => false,
                                 'price_summary_label' => null,
                                 'price_summary_sort_order' => 0,
                                 'price_summary_option_id' => null,
                                 'show_in_pdf_summary' => false,
                                 'pdf_summary_label' => null,
                                 'pdf_summary_sort_order' => 0,
                             ]);

                    $options = $optionRows
                        ->map(static function (array $row): array {
                            $option = $row['option'];

                            return [
                                'id' => $option->id,
                                 'code' => $option->option_code,
                                 'name' => $option->option_name,
                                 'color_code' => $option->color_code,
                                 'detail' => $option->option_detail,
                                 'is_disabled' => (bool) $option->is_disabled,
                                 'disable_text' => $option->disable_text,
                                 'images' => collect($option->option_images ?? [])
                                    ->map(static fn ($image): string => basename((string) $image))
                                    ->filter()
                                    ->values()
                                    ->all(),
                                'is_default' => (bool) $row['is_default'],
                                'quantity_rule' => $row['quantity_rule'],
                                'min_qty' => $row['min_qty'],
                                'max_qty' => $row['max_qty'],
                                'exact_qty' => $row['exact_qty'],
                                'show_in_order_summary' => (bool) $row['show_in_order_summary'],
                                'summary_label' => $row['summary_label'],
                                'summary_sort_order' => (int) $row['summary_sort_order'],
                                 'show_in_preview_summary' => (bool) $row['show_in_preview_summary'],
                                 'preview_summary_label' => $row['preview_summary_label'],
                                 'preview_summary_sort_order' => (int) $row['preview_summary_sort_order'],
                                'show_in_price_summary' => (bool) $row['show_in_price_summary'],
                                'price_summary_label' => $row['price_summary_label'],
                                'price_summary_sort_order' => (int) $row['price_summary_sort_order'],
                                'price_summary_option_id' => $row['price_summary_option_id'] === null ? null : (int) $row['price_summary_option_id'],
                                'show_in_pdf_summary' => (bool) $row['show_in_pdf_summary'],
                                'pdf_summary_label' => $row['pdf_summary_label'],
                                'pdf_summary_sort_order' => (int) $row['pdf_summary_sort_order'],
                             ];
                        })
                        ->values()
                        ->all();

                    if ($options === [] && $group->display_type !== 'quantity_input') {
                        return null;
                    }

                    return [
                        'id' => $group->id,
                        'code' => $group->group_code,
                        'name' => $group->group_name,
                        'display_type' => $group->display_type ?: 'button',
                        'help_text' => $group->help_text,
                        'remark_text' => $group->remark_text,
                        'is_required' => (bool) $group->is_required,
                        'has_option_configuration' => (bool) $assignment->has_option_configuration,
                        'show_in_order_summary' => (bool) $assignment->show_in_order_summary,
                        'summary_label' => $assignment->summary_label ?: $group->group_name,
                        'summary_sort_order' => (int) $assignment->summary_sort_order,
                         'show_in_preview_summary' => (bool) $assignment->show_in_preview_summary,
                         'preview_summary_label' => $assignment->preview_summary_label ?: $group->group_name,
                         'preview_summary_sort_order' => (int) $assignment->preview_summary_sort_order,
                         'show_in_price_summary' => (bool) $assignment->show_in_price_summary,
                         'price_summary_label' => $assignment->price_summary_label ?: $group->group_name,
                         'price_summary_sort_order' => (int) $assignment->price_summary_sort_order,
                         'price_summary_option_id' => $assignment->price_summary_option_id === null ? null : (int) $assignment->price_summary_option_id,
                         'show_in_pdf_summary' => (bool) $assignment->show_in_pdf_summary,
                         'pdf_summary_label' => $assignment->pdf_summary_label ?: $group->group_name,
                         'pdf_summary_sort_order' => (int) $assignment->pdf_summary_sort_order,
                         'options' => $options,
                    ];
                })
                ->filter()
                ->values()
                ->all();
        };

        $steps = $product->optionSteps
            ->map(static function ($step) use ($assignmentsByStep, $groupsForAssignments): array {
                return [
                    'id' => $step->id,
                    'name' => $step->step_name,
                    'is_summary_step' => (bool) $step->is_summary_step,
                    'groups' => $groupsForAssignments($assignmentsByStep->get($step->id, collect())),
                ];
            })
            ->filter(static fn (array $step): bool => $step['groups'] !== [] || $step['is_summary_step'])
            ->values();

        $unassignedGroups = $groupsForAssignments(
            $product->optionGroupAssignments
                ->filter(static fn ($assignment): bool => $assignment->product_option_step_id === null)
        );

        if ($unassignedGroups !== []) {
            $steps->push([
                'id' => null,
                'name' => $steps->isEmpty() ? 'Options' : 'Other options',
                'is_summary_step' => false,
                'groups' => $unassignedGroups,
            ]);
        }

        return $steps->all();
    }

    /**
     * Expose only the price fields required by the storefront calculator.
     * Product and option prices are still controlled by the existing Admin
     * price-rule screens; this keeps the order form independent from Eloquent
     * model internals and avoids exposing rule names or timestamps.
     *
     * @return array{product_rules: list<array<string, mixed>>, option_rules: list<array<string, mixed>>}
     */
    private function storefrontOrderPricing(Product $product): array
    {
        $pricing = [
            'product_rules' => [],
            'option_rules' => [],
        ];

        if (
            Schema::hasTable('product_price_rules')
            && Schema::hasTable('product_price_rule_conditions')
            && Schema::hasTable('product_price_rule_tiers')
        ) {
            $pricing['product_rules'] = ProductPriceRule::query()
                ->where('product_id', $product->id)
                ->with([
                    'conditions:id,product_price_rule_id,product_option_id',
                    'tiers:id,product_price_rule_id,quantity,unit_price_with_tax,is_display',
                ])
                ->orderBy('id')
                ->get()
                ->map(static fn (ProductPriceRule $rule): array => [
                    'conditions' => $rule->conditions
                        ->pluck('product_option_id')
                        ->map(static fn ($id): int => (int) $id)
                        ->values()
                        ->all(),
                    'tiers' => $rule->tiers
                        ->map(static fn ($tier): array => [
                            'quantity' => (int) $tier->quantity,
                            'unit_price_with_tax' => (float) $tier->unit_price_with_tax,
                            'is_display' => (bool) $tier->is_display,
                        ])
                        ->values()
                        ->all(),
                ])
                ->values()
                ->all();
        }

        if (
            Schema::hasTable('option_price_rules')
            && Schema::hasTable('option_price_rule_conditions')
            && Schema::hasTable('option_price_rule_tiers')
        ) {
            $pricing['option_rules'] = OptionPriceRule::query()
                ->where('product_id', $product->id)
                ->with([
                    'targetOption:id,option_group_id',
                    'conditions:id,option_price_rule_id,product_option_id',
                    'tiers:id,option_price_rule_id,quantity,additional_price_with_tax',
                ])
                ->orderBy('id')
                ->get()
                ->map(static fn (OptionPriceRule $rule): array => [
                    'target_option_id' => (int) $rule->target_product_option_id,
                    'target_group_id' => (int) ($rule->targetOption?->option_group_id ?? 0),
                    'price_type' => $rule->price_type,
                    'conditions' => $rule->conditions
                        ->pluck('product_option_id')
                        ->map(static fn ($id): int => (int) $id)
                        ->values()
                        ->all(),
                    'tiers' => $rule->tiers
                        ->map(static fn ($tier): array => [
                            'quantity' => (int) $tier->quantity,
                            'additional_price_with_tax' => (float) $tier->additional_price_with_tax,
                        ])
                        ->values()
                        ->all(),
                ])
                ->values()
                ->all();
        }

        return $pricing;
    }

    /**
     * Return active dependencies that can be applied to this product's
     * configured option groups. Dependencies are global in the CMS, so both
     * the trigger and target must be present on this product before exposing
     * a rule to the storefront.
     *
     * @param  list<array{id: int|null, name: string, groups: list<array<string, mixed>>}>  $orderSteps
     * @return list<array{trigger_option_id: int, target_type: string, target_id: int, action_type: string}>
     */
    private function storefrontOptionDependencies(array $orderSteps): array
    {
        $groups = collect($orderSteps)
            ->pluck('groups')
            ->flatten(1);

        $groupIds = $groups
            ->pluck('id')
            ->filter()
            ->map(static fn ($id): int => (int) $id)
            ->values();

        $optionIds = $groups
            ->pluck('options')
            ->flatten(1)
            ->pluck('id')
            ->filter()
            ->map(static fn ($id): int => (int) $id)
            ->values();

        if ($groupIds->isEmpty() || $optionIds->isEmpty()) {
            return [];
        }

        return OptionDependency::query()
            ->where('is_active', true)
            ->whereIn('trigger_product_option_id', $optionIds)
            ->where(function ($query) use ($groupIds, $optionIds): void {
                $query
                    ->where(function ($groupQuery) use ($groupIds): void {
                        $groupQuery
                            ->where('target_type', 'group')
                            ->whereIn('target_option_group_id', $groupIds);
                    })
                    ->orWhere(function ($optionQuery) use ($optionIds): void {
                        $optionQuery
                            ->where('target_type', 'option')
                            ->whereIn('target_product_option_id', $optionIds);
                    });
            })
            ->get([
                'trigger_product_option_id',
                'target_type',
                'target_product_option_id',
                'target_option_group_id',
                'action_type',
            ])
            ->map(static function (OptionDependency $dependency): array {
                return [
                    'trigger_option_id' => (int) $dependency->trigger_product_option_id,
                    'target_type' => $dependency->target_type,
                    'target_id' => (int) ($dependency->target_type === 'group'
                        ? $dependency->target_option_group_id
                        : $dependency->target_product_option_id),
                    'action_type' => $dependency->action_type,
                ];
            })
            ->values()
            ->all();
    }
}
