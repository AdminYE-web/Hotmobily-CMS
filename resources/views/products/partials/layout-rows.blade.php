@foreach ($rows as $row)
    @php
        $templateButtonCount = 0;
        $otherBlockCount = 0;

        foreach ($row['columns'] ?? [] as $rowColumn) {
            foreach ($rowColumn['blocks'] ?? [] as $rowBlock) {
                if (($rowBlock['type'] ?? null) === 'template_button') {
                    $templateButtonCount++;
                } else {
                    $otherBlockCount++;
                }
            }
        }

        $isSingleTemplateButtonRow =
            $templateButtonCount === 1
            && $otherBlockCount === 0;
    @endphp

    <div class="product-layout-row{{ $isSingleTemplateButtonRow ? ' product-layout-row--single-template-button' : '' }}">

        @foreach ($row['columns'] ?? [] as $column)
            @php
                $columnWidth = (int) ($column['width'] ?? 12);
                $columnWidth = max(1, min(12, $columnWidth));
                $columnPercent = ($columnWidth / 12) * 100;
            @endphp

            <div class="product-layout-column"
                style="--product-column-width: {{ $columnPercent }}%;">
                <div class="product-layout-column-inner">
                    @foreach ($column['blocks'] ?? [] as $block)
                        @include('products.partials.block', [
                            'block' => $block,
                            'contents' => $contents,
                            'product' => $product,
                            'publishedAt' => $publishedAt,
                            'faqData' => $faqData ?? [],
                            'reviewData' => $reviewData ?? [],
                        ])
                    @endforeach
                </div>
            </div>
        @endforeach

    </div>
@endforeach
