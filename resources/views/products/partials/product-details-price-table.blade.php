<div class="product-details-price-summary">
    @if(trim((string) ($content['price_table_title'] ?? '製作単価目安（税込）')) !== '')
        <p class="product-details-price-title">{{ $content['price_table_title'] ?? '製作単価目安（税込）' }}</p>
    @endif
    <div class="product-details-price-scroll" tabindex="0" role="region" aria-label="{{ $content['price_table_title'] ?? '製作単価目安（税込）' }}">
        <table class="product-details-price-table" style="min-width: {{ max(1, count($content['price_table_columns'] ?? [])) * 100 }}px">
            <thead><tr>
                @foreach($content['price_table_columns'] ?? [] as $priceColumn)
                    <th scope="col">{{ $priceColumn['quantity'] ?? '' }}</th>
                @endforeach
            </tr></thead>
            <tbody><tr>
                @foreach($content['price_table_columns'] ?? [] as $priceColumn)
                    <td><strong>{{ $priceColumn['price'] ?? '' }}</strong><span>{{ $priceColumn['suffix'] ?? '' }}</span></td>
                @endforeach
            </tr></tbody>
        </table>
    </div>
</div>
