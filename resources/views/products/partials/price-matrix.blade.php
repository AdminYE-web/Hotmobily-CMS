@php
    $matrix = \App\Support\PriceMatrixContent::withGroups($content);
    $matrixKey = 'pm-'.preg_replace('/[^A-Za-z0-9_-]/', '-', $blockId).'-'.\Illuminate\Support\Str::random(8);
    $selectedOptions = array_column($matrix['option_groups'], 'default_option', 'id');
    $variant = collect($matrix['variants'])->first(function ($v) use ($selectedOptions) {
        foreach ($selectedOptions as $id => $selected) {
            if (($v['selections'][$id] ?? null) !== $selected) return false;
        }
        return true;
    });
@endphp
<section class="price-matrix" data-price-matrix>
    @if($matrix['title'] !== '')<h3>{{ $matrix['title'] }}</h3>@endif
    @if($matrix['description'] !== '')
        @if($matrix['description_format'] === 'html')
            <div class="price-matrix-description">{!! (new \App\Support\RichTextSanitizer)->sanitize($matrix['description']) !!}</div>
        @else
            <p>{{ $matrix['description'] }}</p>
        @endif
    @endif
    @foreach($matrix['option_groups'] as $group)
        <fieldset>
            <legend>{{ $group['label'] }}</legend>
            <div class="price-matrix-options">
                @foreach($group['options'] as $option)
                    <label>
                        <input type="radio" name="{{ $matrixKey }}-{{ $group['id'] }}" value="{{ $option['id'] }}"
                            data-pm-choice="{{ $group['id'] }}" @checked($option['id'] === $group['default_option'])>
                        <span>{{ $option['label'] }}</span>
                    </label>
                @endforeach
            </div>
        </fieldset>
    @endforeach
    <h4>{{ $matrix['table_title'] }}</h4>
    <div data-pm-result aria-live="polite" aria-atomic="true">
        <p data-pm-empty @if(!empty($variant['rows'])) hidden @endif>{{ $matrix['empty_message'] }}</p>
        <div class="price-matrix-scroll" tabindex="0" aria-label="{{ $matrix['table_title'] }}" data-pm-table @if(empty($variant['rows'])) hidden @endif>
            <table>
                <thead><tr><th scope="col">{{ $matrix['quantity_label'] }}</th>@foreach($matrix['sizes'] as $size)<th scope="col">{{ $size['label'] }}</th>@endforeach</tr></thead>
                <tbody>
                    @foreach($variant['rows'] ?? [] as $row)
                        <tr><th scope="row">{{ $row['quantity'] }}</th>@foreach($matrix['sizes'] as $size)<td>{{ $row['prices'][$size['id']] ?? '—' }}</td>@endforeach</tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if($matrix['note'] !== '')<p class="price-matrix-note">{{ $matrix['note'] }}</p>@endif
    <script type="application/json" data-pm-data>{!! json_encode($matrix, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) !!}</script>
</section>
