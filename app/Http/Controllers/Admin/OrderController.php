<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderSubmission;
use App\Models\Product;
use App\Models\ProductOptionGroup;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller
{
    public function index(Request $request): View|StreamedResponse
    {
        $filters = $this->filters($request);

        if ($request->boolean('export')) {
            return $this->streamExport($filters);
        }

        $orders = $this->orderQuery($filters)
            ->paginate(75)
            ->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'payments' => $this->paymentOptions(),
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        return $this->streamExport($this->filters($request));
    }

    public function show(string $order): View
    {
        $orderSubmission = Schema::hasTable('order_submissions')
            ? OrderSubmission::query()->where('order_number', $order)->first()
            : null;

        $legacyLines = collect();

        if (Schema::hasTable('hm_ord_setup') && Schema::hasTable('hm_ord_product_detail')) {
            $legacyLines = DB::table('hm_ord_setup as setup')
                ->leftJoin('hm_ord_product_detail as detail', 'setup.prd_id', '=', 'detail.id')
                ->where('setup.ord_id', $order)
                ->orderBy('detail.id')
                ->select([
                    'detail.*',
                    'setup.ord_id',
                    'setup.cus_id',
                    'setup.payment as order_payment',
                    'setup.transaction_id as order_transaction_id',
                    'setup.date_create as order_date',
                    'setup.file_upload_tmp',
                    'setup.file_upload_cus',
                    'setup.prv_design',
                ])
                ->get();
        }

        if ($orderSubmission === null && $legacyLines->isEmpty()) {
            abort(404);
        }

        $summary = $this->summaryForOrder($order, $orderSubmission, $legacyLines);
        $adminOrderDetailRows = $this->adminOrderDetailRows($orderSubmission);

        return view('admin.orders.show', [
            'orderSubmission' => $orderSubmission,
            'legacyLines' => $legacyLines,
            'summary' => $summary,
            'adminDetailSummaryRows' => $adminOrderDetailRows['summary'],
            'adminDetailPriceRows' => $adminOrderDetailRows['price'],
            ...$this->managementForOrder($order),
        ]);
    }

    /**
     * @return array{q: string|null, date_from: string|null, date_to: string|null, payment: string|null}
     */
    private function filters(Request $request): array
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            'payment' => ['nullable', 'string', 'max:255'],
        ]);

        return [
            'q' => filled($validated['q'] ?? null) ? trim((string) $validated['q']) : null,
            'date_from' => $validated['date_from'] ?? null,
            'date_to' => $validated['date_to'] ?? null,
            'payment' => filled($validated['payment'] ?? null) ? trim((string) $validated['payment']) : null,
        ];
    }

    /** @param array{q: string|null, date_from: string|null, date_to: string|null, payment: string|null} $filters */
    private function orderQuery(array $filters): Builder
    {
        $hasLegacy = Schema::hasTable('hm_ord_setup') && Schema::hasTable('hm_ord_product_detail');
        $hasSubmissions = Schema::hasTable('order_submissions');
        $queries = [];

        if ($hasLegacy) {
            $queries[] = $this->legacyOrderQuery($filters, $hasSubmissions);
        }

        if ($hasSubmissions) {
            $queries[] = $this->submissionOrderQuery($filters, $hasLegacy);
        }

        if ($queries === []) {
            $empty = DB::query()
                ->selectRaw("NULL as order_id, NULL as order_date, 0 as price, NULL as payment, NULL as transaction_id, NULL as email, NULL as product, 0 as quantity, NULL as file_upload_cus, NULL as status, NULL as customer_id")
                ->whereRaw('1 = 0');

            return DB::query()
                ->fromSub($empty, 'orders')
                ->select('orders.*');
        }

        $base = array_shift($queries);

        foreach ($queries as $query) {
            $base->unionAll($query);
        }

        return DB::query()
            ->fromSub($base, 'orders')
            ->select('orders.*')
            ->orderByDesc('orders.order_date')
            ->orderByDesc('orders.order_id');
    }

    /** @param array{q: string|null, date_from: string|null, date_to: string|null, payment: string|null} $filters */
    private function legacyOrderQuery(array $filters, bool $hasSubmissions): Builder
    {
        $query = DB::table('hm_ord_setup as setup')
            ->leftJoin('hm_ord_product_detail as detail', 'setup.prd_id', '=', 'detail.id');

        if ($hasSubmissions) {
            $query->leftJoin(
                'order_submissions as submission',
                'submission.order_number',
                '=',
                'setup.ord_id'
            );
        }

        $emailExpression = $hasSubmissions
            ? 'MAX(submission.customer_email)'
            : 'NULL';
        $statusExpression = $hasSubmissions
            ? 'MAX(submission.status)'
            : 'NULL';

        $query->selectRaw("
            setup.ord_id as order_id,
            MAX(setup.date_create) as order_date,
            SUM(
                CAST(REPLACE(COALESCE(detail.total_price, '0'), ',', '') AS DECIMAL(20, 2))
                + CAST(REPLACE(COALESCE(detail.delivery_price, '0'), ',', '') AS DECIMAL(20, 2))
            ) as price,
            MAX(setup.payment) as payment,
            MAX(setup.transaction_id) as transaction_id,
            {$emailExpression} as email,
            MAX(detail.itemtype) as product,
            MAX(detail.qty) as quantity,
            MAX(setup.file_upload_cus) as file_upload_cus,
            {$statusExpression} as status,
            MAX(setup.cus_id) as customer_id,
            COUNT(*) as line_count
        ")
            ->when(
                filled($filters['q']),
                function (Builder $query) use ($filters, $hasSubmissions): void {
                    $search = '%'.$filters['q'].'%';

                    $query->where(function (Builder $query) use ($search, $hasSubmissions): void {
                        $query
                            ->where('setup.ord_id', 'like', $search)
                            ->orWhere('setup.cus_id', 'like', $search)
                            ->orWhere('detail.itemtype', 'like', $search);

                        if ($hasSubmissions) {
                            $query->orWhere('submission.customer_email', 'like', $search)
                                ->orWhere('submission.product_name', 'like', $search);
                        }
                    });
                }
            )
            ->when(
                filled($filters['date_from']),
                fn (Builder $query) => $query->whereDate('setup.date_create', '>=', $filters['date_from'])
            )
            ->when(
                filled($filters['date_to']),
                fn (Builder $query) => $query->whereDate('setup.date_create', '<=', $filters['date_to'])
            )
            ->when(
                filled($filters['payment']),
                fn (Builder $query) => $query->where('setup.payment', $filters['payment'])
            )
            ->groupBy('setup.ord_id');

        return $query;
    }

    /** @param array{q: string|null, date_from: string|null, date_to: string|null, payment: string|null} $filters */
    private function submissionOrderQuery(array $filters, bool $excludeLegacy): Builder
    {
        $query = DB::table('order_submissions as submission')
            ->when(
                $excludeLegacy,
                fn (Builder $query) => $query->whereNotExists(function (Builder $query): void {
                    $query->selectRaw('1')
                        ->from('hm_ord_setup as legacy_setup')
                        ->whereColumn('legacy_setup.ord_id', 'submission.order_number');
                })
            )
            ->selectRaw("
                submission.order_number as order_id,
                COALESCE(submission.completed_at, submission.created_at) as order_date,
                submission.total_amount as price,
                submission.payment_method as payment,
                NULL as transaction_id,
                submission.customer_email as email,
                submission.product_name as product,
                submission.quantity as quantity,
                '' as file_upload_cus,
                submission.status as status,
                submission.legacy_customer_id as customer_id,
                1 as line_count
            ")
            ->when(
                filled($filters['q']),
                function (Builder $query) use ($filters): void {
                    $search = '%'.$filters['q'].'%';

                    $query->where(function (Builder $query) use ($search): void {
                        $query->where('submission.order_number', 'like', $search)
                            ->orWhere('submission.customer_email', 'like', $search)
                            ->orWhere('submission.product_name', 'like', $search)
                            ->orWhere('submission.legacy_customer_id', 'like', $search);
                    });
                }
            )
            ->when(
                filled($filters['date_from']),
                fn (Builder $query) => $query->whereDate(
                    DB::raw('COALESCE(submission.completed_at, submission.created_at)'),
                    '>=',
                    $filters['date_from']
                )
            )
            ->when(
                filled($filters['date_to']),
                fn (Builder $query) => $query->whereDate(
                    DB::raw('COALESCE(submission.completed_at, submission.created_at)'),
                    '<=',
                    $filters['date_to']
                )
            )
            ->when(
                filled($filters['payment']),
                fn (Builder $query) => $query->where('submission.payment_method', $filters['payment'])
            );

        return $query;
    }

    private function paymentOptions()
    {
        $payments = collect();

        if (Schema::hasTable('hm_ord_setup')) {
            $payments = $payments->merge(DB::table('hm_ord_setup')->pluck('payment'));
        }

        if (Schema::hasTable('order_submissions')) {
            $payments = $payments->merge(DB::table('order_submissions')->pluck('payment_method'));
        }

        return $payments
            ->filter(fn ($payment): bool => filled($payment))
            ->map(fn ($payment): string => trim((string) $payment))
            ->unique()
            ->sort()
            ->values();
    }

    /** @param array{q: string|null, date_from: string|null, date_to: string|null, payment: string|null} $filters */
    private function streamExport(array $filters): StreamedResponse
    {
        $filename = 'HM_order_details_export_'.now()->format('YmdHis').'.xlsx';

        return response()->streamDownload(function () use ($filters): void {
            $path = $this->createExcelExport($filters);

            try {
                readfile($path);
            } finally {
                @unlink($path);
            }
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /** @param array{q: string|null, date_from: string|null, date_to: string|null, payment: string|null} $filters */
    private function createExcelExport(array $filters): string
    {
        $path = tempnam(sys_get_temp_dir(), 'hm-orders-');

        if ($path === false) {
            throw new \RuntimeException('Unable to create the order export file.');
        }

        $zip = new \ZipArchive;

        if ($zip->open($path, \ZipArchive::OVERWRITE) !== true) {
            @unlink($path);
            throw new \RuntimeException('Unable to create the order export archive.');
        }

        $headers = [
            'Date',
            'No',
            'Product',
            'Quantity',
            'Price',
            'Payment',
            'Email',
            'Simulator',
            'Status',
        ];
        $rows = [$this->excelRow(1, $headers, 1)];
        $rowNumber = 2;

        foreach ($this->orderQuery($filters)->cursor() as $order) {
            $rows[] = $this->excelRow($rowNumber, [
                (string) ($order->order_date ?? ''),
                (string) ($order->order_id ?? ''),
                (string) ($order->product ?? ''),
                (string) ($order->quantity ?? ''),
                (string) ((int) round((float) ($order->price ?? 0))),
                $this->paymentDisplay($order),
                (string) ($order->email ?? ''),
                $this->isSimulator($order) ? 'シミュレーター使用' : '不使用',
                (string) ($order->status ?? 'legacy'),
            ], 0);
            $rowNumber++;
        }

        $zip->addFromString('[Content_Types].xml', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/><Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/><Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/></Types>
XML);

        $zip->addFromString('_rels/.rels', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>
XML);

        $zip->addFromString('xl/workbook.xml', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets><sheet name="Whole Order Details" sheetId="1" r:id="rId1"/></sheets></workbook>
XML);

        $zip->addFromString('xl/_rels/workbook.xml.rels', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/></Relationships>
XML);

        $zip->addFromString('xl/styles.xml', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><fonts count="2"><font><sz val="11"/><name val="Calibri"/></font><font><b/><color rgb="FFFFFFFF"/><sz val="11"/><name val="Calibri"/></font></fonts><fills count="3"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill><fill><patternFill patternType="solid"><fgColor rgb="FF5B9BD5"/><bgColor indexed="64"/></patternFill></fill></fills><borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders><cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs><cellXfs count="2"><xf numFmtId="0" fontId="0" fillId="0" xfId="0"/><xf numFmtId="0" fontId="1" fillId="2" borderId="0" xfId="0" applyFont="1" applyFill="1"><alignment horizontal="center"/></xf></cellXfs></styleSheet>
XML);

        $sheet = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            .'<cols><col min="1" max="1" width="18" customWidth="1"/><col min="2" max="2" width="30" customWidth="1"/><col min="3" max="3" width="36" customWidth="1"/><col min="4" max="5" width="14" customWidth="1"/><col min="6" max="9" width="24" customWidth="1"/></cols>'
            .'<sheetData>'.implode('', $rows).'</sheetData></worksheet>';
        $zip->addFromString('xl/worksheets/sheet1.xml', $sheet);
        $zip->close();

        return $path;
    }

    /** @param list<string> $values */
    private function excelRow(int $rowNumber, array $values, int $style): string
    {
        $cells = '';

        foreach ($values as $index => $value) {
            $column = '';
            $number = $index + 1;

            while ($number > 0) {
                $remainder = ($number - 1) % 26;
                $column = chr(65 + $remainder).$column;
                $number = intdiv($number - 1, 26);
            }

            $escaped = htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
            $space = $value !== trim($value) ? ' xml:space="preserve"' : '';
            $cells .= sprintf(
                '<c r="%s%d" s="%d" t="inlineStr"><is><t%s>%s</t></is></c>',
                $column,
                $rowNumber,
                $style,
                $space,
                $escaped
            );
        }

        return sprintf('<row r="%d">%s</row>', $rowNumber, $cells);
    }

    private function isSimulator(object $order): bool
    {
        return str_contains((string) ($order->file_upload_cus ?? ''), 'sim_');
    }

    private function paymentDisplay(object $order): string
    {
        $payment = trim((string) ($order->payment ?? ''));
        $transaction = trim((string) ($order->transaction_id ?? ''));

        if ($transaction !== '' && str_contains($payment, 'クレジット')) {
            return $transaction;
        }

        return $payment;
    }

    private function summaryForOrder(string $orderNumber, ?OrderSubmission $submission, $legacyLines): object
    {
        $firstLegacyLine = $legacyLines->first();
        $legacyPrice = $legacyLines->sum(function ($line): float {
            return $this->numericPrice($line->total_price ?? 0)
                + $this->numericPrice($line->delivery_price ?? 0);
        });

        return (object) [
            'order_id' => $orderNumber,
            'order_date' => $submission?->completed_at?->format('Y-m-d')
                ?? $submission?->created_at?->format('Y-m-d')
                ?? ($firstLegacyLine->order_date ?? null),
            'product' => $submission?->product_name ?? ($firstLegacyLine->itemtype ?? null),
            'quantity' => $submission?->quantity ?? ($firstLegacyLine->qty ?? null),
            'price' => $submission?->total_amount ?? $legacyPrice,
            'payment' => $submission?->payment_method ?? ($firstLegacyLine->order_payment ?? null),
            'transaction_id' => $firstLegacyLine->order_transaction_id ?? null,
            'email' => $submission?->customer_email,
            'status' => $submission?->status ?? 'legacy',
            'customer_id' => $submission?->legacy_customer_id ?? ($firstLegacyLine->cus_id ?? null),
        ];
    }

    /**
     * Apply the product-specific Admin order detail settings to the order
     * snapshot. Orders created before row keys were stored continue to work
     * through their saved display labels.
     *
     * @return array{summary: list<array<string, mixed>>, price: list<array<string, mixed>>}
     */
    private function adminOrderDetailRows(?OrderSubmission $submission): array
    {
        $summaryRows = is_array($submission?->summary_rows) ? array_values($submission->summary_rows) : [];
        $priceRows = is_array($submission?->price_rows) ? array_values($submission->price_rows) : [];

        if ($submission === null || ! Schema::hasTable('product_option_groups')) {
            return ['summary' => $summaryRows, 'price' => $priceRows];
        }

        $product = null;

        if ($submission->product_id) {
            $product = Product::query()->find($submission->product_id);
        }

        if ($product === null && filled($submission->product_slug)) {
            $product = Product::query()->where('slug', $submission->product_slug)->first();
        }

        if ($product === null
            || ! Schema::hasColumn('product_option_groups', 'show_in_admin_order_detail_summary')) {
            return ['summary' => $summaryRows, 'price' => $priceRows];
        }

        $assignments = ProductOptionGroup::query()
            ->where('product_id', $product->id)
            ->with(['optionGroup', 'items.productOption'])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        if ($assignments->isEmpty()) {
            return ['summary' => $summaryRows, 'price' => $priceRows];
        }

        $buildFields = static function (string $showKey, string $sortKey, string $labelKey, ?string $sourceKey = null) use ($assignments): array {
            return $assignments
                ->flatMap(static function (ProductOptionGroup $assignment) use ($showKey, $sortKey, $labelKey, $sourceKey): array {
                    if ($assignment->optionGroup?->display_type !== 'switch') {
                        return (bool) $assignment->{$showKey}
                            ? [[
                                'key' => 'group-'.$assignment->option_group_id,
                                'label' => trim((string) ($assignment->{$labelKey} ?: $assignment->optionGroup?->group_name)),
                                'sort_order' => (int) $assignment->{$sortKey},
                                'source_key' => $sourceKey !== null && $assignment->{$sourceKey} !== null
                                    ? 'option-'.(int) $assignment->{$sourceKey}
                                    : null,
                            ]]
                            : [];
                    }

                    return $assignment->items
                        ->filter(static fn ($item): bool => (bool) $item->{$showKey} && $item->productOption !== null)
                        ->map(static fn ($item): array => [
                            'key' => 'option-'.$item->product_option_id,
                            'label' => trim((string) ($item->{$labelKey} ?: $item->productOption?->option_name)),
                            'sort_order' => (int) $item->{$sortKey},
                            'source_key' => $sourceKey !== null && $item->{$sourceKey} !== null
                                ? 'option-'.(int) $item->{$sourceKey}
                                : null,
                        ])
                        ->all();
                })
                ->filter(static fn (array $field): bool => $field['label'] !== '')
                ->sortBy('sort_order')
                ->values()
                ->all();
        };

        $summaryFields = $buildFields(
            'show_in_admin_order_detail_summary',
            'admin_order_detail_summary_sort_order',
            'admin_order_detail_summary_label'
        );
        $priceFields = $buildFields(
            'show_in_admin_order_detail_price_summary',
            'admin_order_detail_price_summary_sort_order',
            'admin_order_detail_price_summary_label',
            'admin_order_detail_price_summary_option_id'
        );

        return [
            'summary' => $this->filterConfiguredSnapshotRows($summaryRows, $summaryFields, false),
            'price' => $this->filterConfiguredSnapshotRows($priceRows, $priceFields, true),
        ];
    }

    /**
     * @param list<array<string, mixed>> $rows
     * @param list<array{key: string, label: string, sort_order: int}> $fields
     * @return list<array<string, mixed>>
     */
    private function filterConfiguredSnapshotRows(array $rows, array $fields, bool $keepUnkeyedRows): array
    {
        $isUnkeyedSystemRow = static function (array $row): bool {
            $kind = trim((string) ($row['kind'] ?? ''));
            $label = trim((string) ($row['label'] ?? ''));

            return in_array($kind, ['product', 'subtotal', 'discount', 'total'], true)
                || ($kind === 'charge' && preg_match('/shipping|delivery|送料|運賃|配送料/iu', $label) === 1);
        };

        if ($fields === []) {
            return $keepUnkeyedRows
                ? array_values(array_filter($rows, fn ($row): bool => is_array($row) && empty($row['key']) && $isUnkeyedSystemRow($row)))
                : [];
        }

        $fieldKeys = array_column($fields, 'key');
        $sourceKeys = array_values(array_filter(array_column($fields, 'source_key')));
        $allowedKeys = array_values(array_unique(array_merge($fieldKeys, $sourceKeys)));
        $labels = collect($fields)
            ->flatMap(static fn (array $field): array => [
                mb_strtolower(trim((string) $field['label'])),
            ])
            ->filter()
            ->values()
            ->all();
        $hasSnapshotKeys = collect($rows)->contains(static fn ($row): bool => is_array($row) && filled($row['key'] ?? null));

        $filtered = collect($rows)
            ->filter(static function ($row) use ($allowedKeys, $labels, $hasSnapshotKeys, $keepUnkeyedRows, $isUnkeyedSystemRow): bool {
                if (! is_array($row)) {
                    return false;
                }

                $rowKey = trim((string) ($row['key'] ?? ''));
                if ($rowKey !== '') {
                    return in_array($rowKey, $allowedKeys, true);
                }

                if ($keepUnkeyedRows && $isUnkeyedSystemRow($row)) {
                    return true;
                }

                if ($hasSnapshotKeys) {
                    return false;
                }

                return in_array(mb_strtolower(trim((string) ($row['label'] ?? ''))), $labels, true);
            })
            ->values();

        $rank = [];
        foreach ($fields as $fieldIndex => $field) {
            $rank[(string) $field['key']] = $fieldIndex;
            if (! empty($field['source_key'])) {
                $rank[(string) $field['source_key']] = $fieldIndex;
            }
        }

        return $filtered
            ->map(fn (array $row, int $index): array => [
                'row' => $row,
                'rank' => array_key_exists((string) ($row['key'] ?? ''), $rank)
                    ? $rank[(string) $row['key']]
                    : count($rank) + $index,
            ])
            ->sortBy('rank')
            ->pluck('row')
            ->values()
            ->all();
    }

    private function managementForOrder(string $orderNumber): array
    {
        $designRequest = Schema::hasTable('design_request_hm')
            ? DB::table('design_request_hm')->where('ref_id', $orderNumber)->first()
            : null;

        $designMaking = null;

        if ($designRequest !== null && Schema::hasTable('design_making_hm')) {
            $designMaking = DB::table('design_making_hm')
                ->where('request_id', $designRequest->id ?? null)
                ->orderByDesc('id')
                ->first();
        }

        $productionRequest = Schema::hasTable('production_request_hm')
            ? DB::table('production_request_hm')->where('ref_id', $orderNumber)->first()
            : null;

        $eventData = Schema::hasTable('hm_ord_events')
            ? DB::table('hm_ord_events')->where('ord_id', $orderNumber)->first()
            : null;

        return compact(
            'designRequest',
            'designMaking',
            'productionRequest',
            'eventData'
        );
    }

    private function numericPrice($value): float
    {
        return (float) preg_replace('/[^0-9.\-]/', '', (string) $value);
    }
}
