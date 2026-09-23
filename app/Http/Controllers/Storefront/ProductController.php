<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\OptionDependency;
use App\Models\OptionPriceRule;
use App\Models\OrderSubmission;
use App\Models\Product;
use App\Models\ProductDataPage;
use App\Models\ProductCompleteSummaryCustomRow;
use App\Models\ProductConfirmSummaryCustomRow;
use App\Models\ProductPriceRule;
use App\Models\ProductPdfSummaryCustomRow;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
        | Find Published Product Data Page
        |--------------------------------------------------------------------------
        |
        | Product Data pages use the same public URL namespace as products
        | (/products/{slug}). Resolve them first so a page such as /products/data
        | does not fall through to the Product model lookup.
        |--------------------------------------------------------------------------
        */

        $productDataPage = ProductDataPage::query()
            ->with('layout')
            ->where('slug', $productPath)
            ->where('status', 'active')
            ->first();

        if ($productDataPage) {
            return $this->showProductDataPage($productDataPage);
        }

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
        if (Schema::hasTable('product_confirm_summary_custom_rows')) {
            $product->load('confirmSummaryCustomRows');
        }
        if (Schema::hasTable('product_complete_summary_custom_rows')) {
            $product->load('completeSummaryCustomRows');
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
        $confirmSummaryCustomRows = $product->relationLoaded('confirmSummaryCustomRows')
            ? $product->confirmSummaryCustomRows
                ->map(static fn (ProductConfirmSummaryCustomRow $row): array => [
                    'id' => (int) $row->id,
                    'key' => 'confirm-custom-'.$row->id,
                    'label' => $row->label,
                    'content' => $row->content,
                    'sort_order' => (int) $row->sort_order,
                ])
                ->values()
                ->all()
            : [];
        $completeSummaryCustomRows = $product->relationLoaded('completeSummaryCustomRows')
            ? $product->completeSummaryCustomRows
                ->map(static fn (ProductCompleteSummaryCustomRow $row): array => [
                    'id' => (int) $row->id,
                    'key' => 'complete-custom-'.$row->id,
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

                'confirmSummaryCustomRows' => $confirmSummaryCustomRows,

                'completeSummaryCustomRows' => $completeSummaryCustomRows,

                'orderDependencies' => $this->storefrontOptionDependencies($orderSteps),

            ]
        );
    }

    /**
     * Render a published Product Data page in the same storefront shell and
     * CMS block renderer used by regular products.
     */
    private function showProductDataPage(ProductDataPage $productDataPage)
    {
        if (
            ! $productDataPage->layout
            ||
            empty($productDataPage->layout->published_layout_json)
            ||
            empty($productDataPage->published_content_json)
        ) {
            abort(404);
        }

        $layout = $productDataPage->layout->published_layout_json;
        $content = $productDataPage->published_content_json;

        return view('products.show', [
            'product' => $productDataPage,
            'layout' => $layout,
            'contents' => $content['blocks'] ?? [],
            'publishedAt' => $productDataPage->published_at,
            'faqData' => [],
            'reviewData' => [],
            'orderSteps' => [],
            'orderPricing' => [],
            'orderDependencies' => [],
            'pdfSummaryCustomRows' => [],
            'confirmSummaryCustomRows' => [],
            'completeSummaryCustomRows' => [],
        ]);
    }

    /**
     * Keep the calculated order data in the current session before moving to
     * the separate customer-information page.
     */
    public function storeCustomerOrder(Request $request, string $productPath)
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
            'shipping_amount' => ['nullable', 'integer', 'min:0', 'max:100000000000'],
            'order_values' => ['nullable', 'json', 'max:100000'],
            'summary' => ['nullable', 'array', 'max:100'],
            'summary.*' => ['array'],
            'summary.*.key' => ['nullable', 'string', 'max:100'],
            'summary.*.label' => ['required', 'string', 'max:255'],
            'summary.*.value' => ['nullable', 'string', 'max:2000'],
            'order_summary' => ['nullable', 'array', 'max:100'],
            'order_summary.*' => ['array'],
            'order_summary.*.key' => ['nullable', 'string', 'max:100'],
            'order_summary.*.label' => ['required', 'string', 'max:255'],
            'order_summary.*.value' => ['nullable', 'string', 'max:2000'],
            'confirm_summary' => ['nullable', 'array', 'max:100'],
            'confirm_summary_present' => ['nullable', 'boolean'],
            'confirm_summary.*' => ['array'],
            'confirm_summary.*.key' => ['nullable', 'string', 'max:100'],
            'confirm_summary.*.label' => ['required', 'string', 'max:255'],
            'confirm_summary.*.value' => ['nullable', 'string', 'max:5000'],
            'price_rows' => ['nullable', 'array', 'max:100'],
            'price_rows.*' => ['array'],
            'price_rows.*.key' => ['nullable', 'string', 'max:100'],
            'price_rows.*.label' => ['required', 'string', 'max:255'],
            'price_rows.*.amount' => ['nullable', 'integer', 'min:0', 'max:100000000000'],
            'price_rows.*.kind' => ['nullable', 'string', 'in:product,charge,subtotal,discount,total'],
            'confirm_price_rows' => ['nullable', 'array', 'max:100'],
            'confirm_price_rows_present' => ['nullable', 'boolean'],
            'confirm_price_rows.*' => ['array'],
            'confirm_price_rows.*.key' => ['nullable', 'string', 'max:100'],
            'confirm_price_rows.*.label' => ['required', 'string', 'max:255'],
            'confirm_price_rows.*.amount' => ['nullable', 'integer', 'min:0', 'max:100000000000'],
            'confirm_price_rows.*.kind' => ['nullable', 'string', 'in:product,charge,subtotal,discount,total'],
            'complete_summary' => ['nullable', 'array', 'max:100'],
            'complete_summary_present' => ['nullable', 'boolean'],
            'complete_summary.*' => ['array'],
            'complete_summary.*.key' => ['nullable', 'string', 'max:100'],
            'complete_summary.*.label' => ['required', 'string', 'max:255'],
            'complete_summary.*.value' => ['nullable', 'string', 'max:5000'],
            'complete_price_rows' => ['nullable', 'array', 'max:100'],
            'complete_price_rows_present' => ['nullable', 'boolean'],
            'complete_price_rows.*' => ['array'],
            'complete_price_rows.*.key' => ['nullable', 'string', 'max:100'],
            'complete_price_rows.*.label' => ['required', 'string', 'max:255'],
            'complete_price_rows.*.amount' => ['nullable', 'integer', 'min:0', 'max:100000000000'],
            'complete_price_rows.*.kind' => ['nullable', 'string', 'in:product,charge,subtotal,discount,total'],
        ]);

        $orderValues = collect(json_decode((string) ($validated['order_values'] ?? '[]'), true) ?: [])
            ->filter(static fn ($field): bool => is_array($field))
            ->map(static fn (array $field): array => [
                'name' => trim((string) ($field['name'] ?? '')),
                'value' => (string) ($field['value'] ?? ''),
            ])
            ->filter(static fn (array $field): bool => $field['name'] !== '')
            ->values()
            ->all();

        $request->session()->put('configured_order_'.$product->getKey(), [
            'quantity' => (int) ($validated['quantity'] ?? 1),
            'total_amount' => (int) ($validated['total_amount'] ?? 0),
            'subtotal_amount' => (int) ($validated['subtotal_amount'] ?? 0),
            'discount_amount' => (int) ($validated['discount_amount'] ?? 0),
            'shipping_amount' => (int) ($validated['shipping_amount'] ?? 0),
            'order_values' => $orderValues,
            'summary' => $validated['summary'] ?? [],
            'order_summary' => $validated['order_summary'] ?? [],
            'confirm_summary' => $validated['confirm_summary'] ?? [],
            'confirm_summary_present' => filter_var($validated['confirm_summary_present'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'price_rows' => $validated['price_rows'] ?? [],
            'confirm_price_rows' => $validated['confirm_price_rows'] ?? [],
            'confirm_price_rows_present' => filter_var($validated['confirm_price_rows_present'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'complete_summary' => $validated['complete_summary'] ?? [],
            'complete_summary_present' => filter_var($validated['complete_summary_present'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'complete_price_rows' => $validated['complete_price_rows'] ?? [],
            'complete_price_rows_present' => filter_var($validated['complete_price_rows_present'] ?? false, FILTER_VALIDATE_BOOLEAN),
        ]);

        return redirect()->route('products.customer', [
            'productPath' => $productPath,
        ]);
    }

    /**
     * Save the customer-information form alongside the configured order in
     * the session. The order is intentionally not persisted to the database
     * until the later checkout/confirmation step.
     */
    public function storeCustomerDetails(Request $request, string $productPath)
    {
        $productPath = trim($productPath, '/');

        $product = Product::query()
            ->where('slug', $productPath)
            ->where('status', 'active')
            ->firstOrFail();

        $sessionKey = 'configured_order_'.$product->getKey();
        $orderPayload = $request->session()->get($sessionKey);

        if (! is_array($orderPayload)) {
            return redirect()->route('products.show', [
                'productPath' => $productPath,
            ]);
        }

        $validated = $request->validate([
            'customer' => ['required', 'array'],
            'customer.email' => ['required', 'email', 'max:250'],
            'customer.name' => ['required', 'string', 'max:100'],
            'customer.furigana' => ['required', 'string', 'max:100'],
            'customer.tel' => ['required', 'string', 'max:30'],
            'customer.address_method' => ['required', 'in:add_form,none,message_box'],
            'customer.cstKBN' => ['nullable', 'in:Corp,Personal'],
            'customer.company' => ['nullable', 'string', 'max:100'],
            'customer.company_kana' => ['nullable', 'string', 'max:100'],
            'customer.department' => ['nullable', 'string', 'max:100'],
            'customer.postal_code' => ['nullable', 'string', 'max:8'],
            'customer.prefecture' => ['nullable', 'string', 'max:100'],
            'customer.address' => ['nullable', 'string', 'max:255'],
            'customer.address_street' => ['nullable', 'string', 'max:255'],
            'customer.delivery_type' => ['nullable', 'in:same,different'],
            'customer.delivery_name' => ['nullable', 'string', 'max:100'],
            'customer.delivery_postal_code' => ['nullable', 'string', 'max:8'],
            'customer.delivery_prefecture' => ['nullable', 'string', 'max:100'],
            'customer.delivery_address' => ['nullable', 'string', 'max:255'],
            'customer.delivery_address_street' => ['nullable', 'string', 'max:255'],
            'customer.delivery_tel' => ['nullable', 'string', 'max:30'],
            'customer.contact_detail' => ['nullable', 'string', 'max:10000'],
            'customer.showcase' => ['nullable', 'in:allow,deny'],
            'customer.contact_detail_2' => ['nullable', 'string', 'max:10000'],
            'customer.payment' => ['nullable', 'string', 'max:100'],
            'customer.newsletter' => ['nullable', 'boolean'],
            'customer_files' => ['nullable', 'array', 'max:10'],
            'customer_files.*' => [
                'file',
                'max:10240',
                'extensions:ai,pdf,doc,xls,jpeg,jpg,png,psd,zip,eps',
            ],
        ]);

        $storedFiles = [];
        foreach ((array) $request->file('customer_files', []) as $file) {
            if (! $file instanceof UploadedFile || ! $file->isValid()) {
                continue;
            }

            $storedFiles[] = [
                'name' => $file->getClientOriginalName(),
                'path' => $file->store('customer-files/'.$product->getKey()),
                'size' => (int) $file->getSize(),
            ];
        }

        $existingFiles = is_array($orderPayload['customer_files'] ?? null)
            ? $orderPayload['customer_files']
            : [];

        $orderPayload['customer'] = $validated['customer'];
        $orderPayload['customer_files'] = array_values(array_merge($existingFiles, $storedFiles));
        $orderPayload['customer_saved_at'] = now()->toIso8601String();
        $request->session()->put($sessionKey, $orderPayload);

        return redirect()->route('products.confirm', [
            'productPath' => $productPath,
        ]);
    }

    /**
     * Render the customer-information page after the configured order has
     * been transferred from the product page.
     */
    public function customerDetails(Request $request, string $productPath)
    {
        $productPath = trim($productPath, '/');

        $product = Product::query()
            ->where('slug', $productPath)
            ->where('status', 'active')
            ->firstOrFail();

        $orderPayload = $request->session()->get('configured_order_'.$product->getKey());

        if (! is_array($orderPayload)) {
            return redirect()->route('products.show', [
                'productPath' => $productPath,
            ]);
        }

        return view('products.customer-details', [
            'product' => $product,
            'orderPayload' => $orderPayload,
        ]);
    }

    /**
     * Render the final order confirmation page using the configuration and
     * customer information that have been kept in the session.
     */
    public function confirmOrder(Request $request, string $productPath)
    {
        $productPath = trim($productPath, '/');

        $product = Product::query()
            ->where('slug', $productPath)
            ->where('status', 'active')
            ->firstOrFail();

        $orderPayload = $request->session()->get('configured_order_'.$product->getKey());

        if (! is_array($orderPayload)) {
            return redirect()->route('products.show', [
                'productPath' => $productPath,
            ]);
        }

        $normalizeRows = static function ($rows): array {
            return collect(is_array($rows) ? $rows : [])
                ->filter(static fn ($row): bool => is_array($row))
                ->map(static fn (array $row): array => [
                    'key' => trim((string) ($row['key'] ?? '')),
                    'label' => trim((string) ($row['label'] ?? '')),
                    'value' => (string) ($row['value'] ?? ''),
                    'amount' => (int) ($row['amount'] ?? 0),
                    'kind' => (string) ($row['kind'] ?? ''),
                ])
                ->filter(static fn (array $row): bool => $row['label'] !== '')
                ->values()
                ->all();
        };

        $summaryRows = array_key_exists('confirm_summary_present', $orderPayload)
            ? $normalizeRows($orderPayload['confirm_summary'] ?? [])
            : $normalizeRows($orderPayload['order_summary'] ?? ($orderPayload['summary'] ?? []));
        $priceRows = array_key_exists('confirm_price_rows_present', $orderPayload)
            ? $normalizeRows($orderPayload['confirm_price_rows'] ?? [])
            : $normalizeRows($orderPayload['price_rows'] ?? []);
        $orderValues = collect(is_array($orderPayload['order_values'] ?? null) ? $orderPayload['order_values'] : [])
            ->filter(static fn ($field): bool => is_array($field))
            ->map(static fn (array $field): array => [
                'name' => trim((string) ($field['name'] ?? '')),
                'value' => (string) ($field['value'] ?? ''),
            ])
            ->filter(static fn (array $field): bool => $field['name'] !== '')
            ->values()
            ->all();

        return view('products.order-confirm', [
            'product' => $product,
            'orderPayload' => $orderPayload,
            'summaryRows' => $summaryRows,
            'priceRows' => $priceRows,
            'orderValues' => $orderValues,
        ]);
    }

    /**
     * Complete the configured order using the data kept in the session.
     *
     * The legacy complete.php builds the email body before sending it. Keep
     * the same test hook here: pooh receives the rendered body only,
     * so the email template can be checked without sending an order.
     */
    public function completeOrder(Request $request, string $productPath)
    {
        $productPath = trim($productPath, '/');

        $product = Product::query()
            ->where('slug', $productPath)
            ->where('status', 'active')
            ->firstOrFail();

        $sessionKey = 'configured_order_'.$product->getKey();
        $orderPayload = $request->session()->get($sessionKey);

        if (! is_array($orderPayload)) {
            return redirect()->route('products.show', [
                'productPath' => $productPath,
            ]);
        }

        $normalizeRows = static function ($rows): array {
            return collect(is_array($rows) ? $rows : [])
                ->filter(static fn ($row): bool => is_array($row))
                ->map(static fn (array $row): array => [
                    'key' => trim((string) ($row['key'] ?? '')),
                    'label' => trim((string) ($row['label'] ?? '')),
                    'value' => (string) ($row['value'] ?? ''),
                    'amount' => (int) ($row['amount'] ?? 0),
                    'kind' => (string) ($row['kind'] ?? ''),
                ])
                ->filter(static fn (array $row): bool => $row['label'] !== '')
                ->values()
                ->all();
        };

        $summaryRows = array_key_exists('complete_summary_present', $orderPayload)
            ? $normalizeRows($orderPayload['complete_summary'] ?? [])
            : (array_key_exists('confirm_summary_present', $orderPayload)
                ? $normalizeRows($orderPayload['confirm_summary'] ?? [])
                : $normalizeRows($orderPayload['order_summary'] ?? ($orderPayload['summary'] ?? [])));
        $priceRows = array_key_exists('complete_price_rows_present', $orderPayload)
            ? $normalizeRows($orderPayload['complete_price_rows'] ?? [])
            : (array_key_exists('confirm_price_rows_present', $orderPayload)
                ? $normalizeRows($orderPayload['confirm_price_rows'] ?? [])
                : $normalizeRows($orderPayload['price_rows'] ?? []));
        $orderValues = collect(is_array($orderPayload['order_values'] ?? null) ? $orderPayload['order_values'] : [])
            ->filter(static fn ($field): bool => is_array($field))
            ->map(static fn (array $field): array => [
                'name' => trim((string) ($field['name'] ?? '')),
                'value' => (string) ($field['value'] ?? ''),
            ])
            ->filter(static fn (array $field): bool => $field['name'] !== '')
            ->values()
            ->all();
        $customerFiles = collect(is_array($orderPayload['customer_files'] ?? null) ? $orderPayload['customer_files'] : [])
            ->filter(static fn ($file): bool => is_array($file))
            ->map(static fn (array $file): array => [
                'name' => trim((string) ($file['name'] ?? '')),
                'path' => (string) ($file['path'] ?? ''),
            ])
            ->filter(static fn (array $file): bool => $file['name'] !== '')
            ->values()
            ->all();

        $customer = is_array($orderPayload['customer'] ?? null)
            ? $orderPayload['customer']
            : [];
        $totalAmount = (int) ($orderPayload['total_amount'] ?? 0);
        $subtotalAmount = (int) ($orderPayload['subtotal_amount'] ?? $totalAmount);
        $discountAmount = (int) ($orderPayload['discount_amount'] ?? 0);
        $shippingAmount = (int) ($orderPayload['shipping_amount'] ?? 0);
        $shippingPriceRow = collect($priceRows)->first(static function (array $row): bool {
            return ($row['kind'] ?? '') === 'shipping'
                || in_array(trim((string) ($row['label'] ?? '')), ['送料', '送料計'], true);
        });
        if ($shippingAmount === 0 && is_array($shippingPriceRow)) {
            $shippingAmount = (int) ($shippingPriceRow['amount'] ?? 0);
        }
        $productPriceRow = collect($priceRows)
            ->first(static fn (array $row): bool => ($row['kind'] ?? '') === 'product');
        $productAmount = is_array($productPriceRow)
            ? (int) ($productPriceRow['amount'] ?? 0)
            : 0;
        $orderNumber = trim((string) ($orderPayload['order_number'] ?? ''));
        if ($orderNumber === '') {
            $orderNumber = $this->generateOrderNumber();
        }
        $vsBodytextOder = view('products.order-email', [
            'product' => $product,
            'orderPayload' => $orderPayload,
            'summaryRows' => $summaryRows,
            'priceRows' => $priceRows,
            'orderValues' => $orderValues,
            'customerFiles' => $customerFiles,
            'customer' => $customer,
            'orderNumber' => $orderNumber,
        ])->render();

        // Equivalent to the legacy `echo $vsBodytextOder; die;` hook.
        if ((string) $request->cookie('username') === 'pooh') {
            return response($vsBodytextOder, 200, [
                'Content-Type' => 'text/html; charset=UTF-8',
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            ]);
        }

        $email = trim((string) ($customer['email'] ?? ''));

        if ($email === '') {
            return redirect()
                ->route('products.customer', ['productPath' => $productPath])
                ->with('error', 'メールアドレスを入力してください。');
        }

        $orderSuffix = preg_replace('/^ODR_HM_/', '', $orderNumber) ?: $orderNumber;
        $orderSuffix = preg_replace('/[^A-Za-z0-9]/', '', $orderSuffix) ?: $orderNumber;
        $legacyCustomerId = trim((string) ($orderPayload['legacy_customer_id'] ?? ''));
        $legacyCustomerId = $legacyCustomerId !== '' ? $legacyCustomerId : 'cus_'.$orderSuffix;
        $legacyProductDetailId = trim((string) ($orderPayload['legacy_product_detail_id'] ?? ''));
        $legacyProductDetailId = $legacyProductDetailId !== '' ? $legacyProductDetailId : 'prd_'.$orderSuffix;
        $paymentMethod = trim((string) ($customer['payment'] ?? ''));
        $previousDesignField = collect($orderValues)->first(static fn (array $field): bool => str_contains(
            $field['name'],
            'previous_order_number'
        ));
        $previousDesignNumber = is_array($previousDesignField)
            ? trim((string) ($previousDesignField['value'] ?? ''))
            : '';
        $customerFileSnapshot = collect(is_array($orderPayload['customer_files'] ?? null) ? $orderPayload['customer_files'] : [])
            ->filter(static fn ($file): bool => is_array($file))
            ->map(static fn (array $file): array => [
                'name' => trim((string) ($file['name'] ?? '')),
                'path' => (string) ($file['path'] ?? ''),
                'size' => (int) ($file['size'] ?? 0),
            ])
            ->filter(static fn (array $file): bool => $file['name'] !== '' || $file['path'] !== '')
            ->values()
            ->all();
        $payloadSnapshot = $orderPayload;
        $payloadSnapshot['order_number'] = $orderNumber;
        $payloadSnapshot['product'] = [
            'id' => (int) $product->getKey(),
            'name' => (string) $product->name,
            'slug' => (string) $product->slug,
        ];

        $orderPayload['order_number'] = $orderNumber;
        $orderPayload['legacy_customer_id'] = $legacyCustomerId;
        $orderPayload['legacy_product_detail_id'] = $legacyProductDetailId;
        $request->session()->put($sessionKey, $orderPayload);

        $submissionAttributes = [
            'order_number' => $orderNumber,
            'product_id' => (int) $product->getKey(),
            'product_name' => (string) $product->name,
            'product_slug' => (string) $product->slug,
            'customer_email' => $email,
            'legacy_customer_id' => $legacyCustomerId,
            'legacy_product_detail_id' => $legacyProductDetailId,
            'quantity' => max(1, (int) ($orderPayload['quantity'] ?? 1)),
            'total_amount' => $totalAmount,
            'subtotal_amount' => $subtotalAmount,
            'discount_amount' => $discountAmount,
            'shipping_amount' => $shippingAmount,
            'payment_method' => $paymentMethod !== '' ? $paymentMethod : null,
            'status' => 'pending',
            'order_values' => $orderValues,
            'customer_data' => $customer,
            'customer_files' => $customerFileSnapshot,
            'summary_rows' => $summaryRows,
            'price_rows' => $priceRows,
            'payload' => $payloadSnapshot,
            'email_html' => $vsBodytextOder,
            'email_error' => null,
        ];

        try {
            $submission = DB::transaction(function () use (
                $orderNumber,
                $submissionAttributes,
                $legacyCustomerId,
                $legacyProductDetailId,
                $product,
                $orderPayload,
                $totalAmount,
                $subtotalAmount,
                $discountAmount,
                $shippingAmount,
                $productAmount,
                $paymentMethod,
                $customerFileSnapshot,
                $previousDesignNumber
            ): OrderSubmission {
                $submission = OrderSubmission::query()->firstOrNew([
                    'order_number' => $orderNumber,
                ]);
                $submission->fill($submissionAttributes);
                $submission->save();

                $this->persistLegacyOrder(
                    $orderNumber,
                    $legacyCustomerId,
                    $legacyProductDetailId,
                    $product,
                    max(1, (int) ($orderPayload['quantity'] ?? 1)),
                    $totalAmount,
                    $subtotalAmount,
                    $discountAmount,
                    $shippingAmount,
                    $productAmount,
                    $paymentMethod,
                    collect($customerFileSnapshot)->pluck('path')->filter()->implode(','),
                    $previousDesignNumber
                );

                return $submission;
            });
        } catch (\Throwable $exception) {
            report($exception);

            return redirect()
                ->route('products.confirm', ['productPath' => $productPath])
                ->with('error', '注文情報を保存できませんでした。時間をおいて再度お試しください。');
        }

        try {
            Mail::html($vsBodytextOder, function ($message) use ($email, $product): void {
                $message
                    ->to($email)
                    ->bcc('pooh250841@hotmail.com')
                    ->subject('ご注文ありがとうございます【'.$product->name.'】');
            });
        } catch (\Throwable $exception) {
            report($exception);
            $submission->forceFill([
                'status' => 'email_failed',
                'email_error' => substr($exception->getMessage(), 0, 2000),
            ])->save();

            return redirect()
                ->route('products.confirm', ['productPath' => $productPath])
                ->with('error', 'メールを送信できませんでした。時間をおいて再度お試しください。');
        }

        $submission->forceFill([
            'status' => 'completed',
            'email_sent_at' => now(),
            'completed_at' => now(),
            'email_error' => null,
        ])->save();

        $request->session()->forget($sessionKey);

        return view('products.order-complete', [
            'product' => $product,
            'orderNumber' => $orderNumber,
            'email' => $email,
        ]);
    }

    /**
     * Generate the same visible order-number format as the legacy site.
     * The numeric suffix is the Tokyo timestamp plus PHP's Swatch beat
     * value; a suffix is only added when the same value already exists.
     */
    private function generateOrderNumber(): string
    {
        $base = 'ODR_HM_'.now('Asia/Tokyo')->format('YmdHisB');

        for ($attempt = 0; $attempt < 100; $attempt++) {
            $candidate = $base.($attempt === 0 ? '' : (string) $attempt);

            if (! OrderSubmission::query()->where('order_number', $candidate)->exists()) {
                return $candidate;
            }
        }

        return $base.'_'.strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
    }

    /**
     * Keep the legacy dashboard/order tables populated when they are present.
     * The order_submissions snapshot remains the source of the complete
     * arbitrary option/customer payload.
     */
    private function persistLegacyOrder(
        string $orderNumber,
        string $legacyCustomerId,
        string $legacyProductDetailId,
        Product $product,
        int $quantity,
        int $totalAmount,
        int $subtotalAmount,
        int $discountAmount,
        int $shippingAmount,
        int $productAmount,
        string $paymentMethod,
        string $fileUploadCustomer,
        string $previousDesignNumber
    ): void {
        if (Schema::hasTable('hm_ord_product_detail')) {
            DB::table('hm_ord_product_detail')->updateOrInsert(
                ['id' => $legacyProductDetailId],
                [
                    'qty' => (string) $quantity,
                    'itemtype' => (string) $product->name,
                    'itemsize' => (string) ($product->product_code ?? ''),
                    'spec' => '',
                    'part_qty' => '',
                    'total_price' => (string) $totalAmount,
                    'sub_total_price' => (string) $subtotalAmount,
                    'product_price' => (string) $productAmount,
                    'tax' => (string) (int) round($totalAmount * 10 / 110),
                    'front_side_print_fee' => '',
                    'discount' => (string) $discountAmount,
                    'delivery_price' => (string) $shippingAmount,
                ]
            );
        }

        if (Schema::hasTable('hm_ord_setup')) {
            DB::table('hm_ord_setup')->updateOrInsert(
                [
                    'ord_id' => $orderNumber,
                    'prd_id' => $legacyProductDetailId,
                ],
                [
                    'cus_id' => $legacyCustomerId,
                    'payment' => $paymentMethod !== '' ? $paymentMethod : null,
                    'transaction_id' => null,
                    'date_create' => now('Asia/Tokyo')->toDateString(),
                    'file_upload_tmp' => '',
                    'file_upload_cus' => $fileUploadCustomer,
                    'prv_design' => $previousDesignNumber,
                ]
            );
        }
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
            'shipping_amount' => ['nullable', 'integer', 'min:0', 'max:100000000000'],
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
                                 'show_in_confirm_price_summary' => (bool) $item->show_in_confirm_price_summary,
                                 'confirm_price_summary_label' => $item->confirm_price_summary_label,
                                 'confirm_price_summary_sort_order' => (int) $item->confirm_price_summary_sort_order,
                                 'confirm_price_summary_option_id' => $item->confirm_price_summary_option_id === null ? null : (int) $item->confirm_price_summary_option_id,
                                 'show_in_complete_summary' => (bool) $item->show_in_complete_summary,
                                 'complete_summary_label' => $item->complete_summary_label,
                                 'complete_summary_sort_order' => (int) $item->complete_summary_sort_order,
                                 'show_in_complete_price_summary' => (bool) $item->show_in_complete_price_summary,
                                 'complete_price_summary_label' => $item->complete_price_summary_label,
                                 'complete_price_summary_sort_order' => (int) $item->complete_price_summary_sort_order,
                                 'complete_price_summary_option_id' => $item->complete_price_summary_option_id === null ? null : (int) $item->complete_price_summary_option_id,
                                  'show_in_pdf_summary' => (bool) $item->show_in_pdf_summary,
                                 'pdf_summary_label' => $item->pdf_summary_label,
                                 'pdf_summary_sort_order' => (int) $item->pdf_summary_sort_order,
                                 'show_in_confirm_summary' => (bool) $item->show_in_confirm_summary,
                                 'confirm_summary_label' => $item->confirm_summary_label,
                                 'confirm_summary_sort_order' => (int) $item->confirm_summary_sort_order,
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
                                 'show_in_confirm_price_summary' => false,
                                 'confirm_price_summary_label' => null,
                                 'confirm_price_summary_sort_order' => 0,
                                 'confirm_price_summary_option_id' => null,
                                 'show_in_complete_summary' => false,
                                 'complete_summary_label' => null,
                                 'complete_summary_sort_order' => 0,
                                 'show_in_complete_price_summary' => false,
                                 'complete_price_summary_label' => null,
                                 'complete_price_summary_sort_order' => 0,
                                 'complete_price_summary_option_id' => null,
                                  'show_in_pdf_summary' => false,
                                 'pdf_summary_label' => null,
                                 'pdf_summary_sort_order' => 0,
                                 'show_in_confirm_summary' => false,
                                 'confirm_summary_label' => null,
                                 'confirm_summary_sort_order' => 0,
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
                                 'show_in_confirm_price_summary' => (bool) $row['show_in_confirm_price_summary'],
                                 'confirm_price_summary_label' => $row['confirm_price_summary_label'],
                                 'confirm_price_summary_sort_order' => (int) $row['confirm_price_summary_sort_order'],
                                 'confirm_price_summary_option_id' => $row['confirm_price_summary_option_id'] === null ? null : (int) $row['confirm_price_summary_option_id'],
                                 'show_in_complete_summary' => (bool) $row['show_in_complete_summary'],
                                 'complete_summary_label' => $row['complete_summary_label'],
                                 'complete_summary_sort_order' => (int) $row['complete_summary_sort_order'],
                                 'show_in_complete_price_summary' => (bool) $row['show_in_complete_price_summary'],
                                 'complete_price_summary_label' => $row['complete_price_summary_label'],
                                 'complete_price_summary_sort_order' => (int) $row['complete_price_summary_sort_order'],
                                 'complete_price_summary_option_id' => $row['complete_price_summary_option_id'] === null ? null : (int) $row['complete_price_summary_option_id'],
                                  'show_in_pdf_summary' => (bool) $row['show_in_pdf_summary'],
                                 'pdf_summary_label' => $row['pdf_summary_label'],
                                 'pdf_summary_sort_order' => (int) $row['pdf_summary_sort_order'],
                                 'show_in_confirm_summary' => (bool) $row['show_in_confirm_summary'],
                                 'confirm_summary_label' => $row['confirm_summary_label'],
                                 'confirm_summary_sort_order' => (int) $row['confirm_summary_sort_order'],
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
                         'show_in_confirm_price_summary' => (bool) $assignment->show_in_confirm_price_summary,
                         'confirm_price_summary_label' => $assignment->confirm_price_summary_label ?: $group->group_name,
                         'confirm_price_summary_sort_order' => (int) $assignment->confirm_price_summary_sort_order,
                         'confirm_price_summary_option_id' => $assignment->confirm_price_summary_option_id === null ? null : (int) $assignment->confirm_price_summary_option_id,
                         'show_in_complete_summary' => (bool) $assignment->show_in_complete_summary,
                         'complete_summary_label' => $assignment->complete_summary_label ?: $group->group_name,
                         'complete_summary_sort_order' => (int) $assignment->complete_summary_sort_order,
                         'show_in_complete_price_summary' => (bool) $assignment->show_in_complete_price_summary,
                         'complete_price_summary_label' => $assignment->complete_price_summary_label ?: $group->group_name,
                         'complete_price_summary_sort_order' => (int) $assignment->complete_price_summary_sort_order,
                         'complete_price_summary_option_id' => $assignment->complete_price_summary_option_id === null ? null : (int) $assignment->complete_price_summary_option_id,
                          'show_in_pdf_summary' => (bool) $assignment->show_in_pdf_summary,
                         'pdf_summary_label' => $assignment->pdf_summary_label ?: $group->group_name,
                         'pdf_summary_sort_order' => (int) $assignment->pdf_summary_sort_order,
                         'show_in_confirm_summary' => (bool) $assignment->show_in_confirm_summary,
                         'confirm_summary_label' => $assignment->confirm_summary_label ?: $group->group_name,
                         'confirm_summary_sort_order' => (int) $assignment->confirm_summary_sort_order,
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
