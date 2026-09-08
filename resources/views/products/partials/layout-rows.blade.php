@foreach ($rows as $row)
    <div class="product-layout-row">

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
                        ])
                    @endforeach
                </div>
            </div>
        @endforeach

    </div>
@endforeach
