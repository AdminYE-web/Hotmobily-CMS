@php
    $validColor = fn ($value, $fallback) => preg_match('/^#[0-9a-f]{6}$/i', (string) $value) ? $value : $fallback;
    $startBackground = $validColor($content['start_background'] ?? '', '#bee0fa');
    $summaryThemes = ['blue' => '#bee0fa', 'pink' => '#f8cecc', 'cyan' => '#c5f1f1', 'orange' => '#ffe0b8', 'gray' => '#e5e5e5'];
@endphp
@if(count($schedules))
    <div class="shipping-summary-scroll">
        <table class="shipping-summary-table">
            @if(trim((string) ($content['intro_text'] ?? '')) !== '')
                <thead><tr><th colspan="2" class="shipping-summary-message">{{ $content['intro_text'] }}</th></tr></thead>
            @endif
            <tbody>
                @foreach($schedules as $index => $schedule)
                    @php
                        $background = $validColor($schedule['background_color'] ?? '', $summaryThemes[$schedule['theme'] ?? 'blue'] ?? '#bee0fa');
                        $summaryLabel = trim((string) ($schedule['label'] ?? ''));
                        if ($summaryLabel === '') $summaryLabel = (int) ($schedule['days'] ?? 0).'営業日出荷予定';
                    @endphp
                    <tr>
                        @if($loop->first)
                            <th scope="col" style="background-color: {{ $startBackground }}">{{ $startLabel }}</th>
                        @endif
                        <th scope="row" style="background-color: {{ $background }}">{{ $summaryLabel }}</th>
                    </tr>
                    <tr>
                        @if($loop->first)
                            <td rowspan="{{ count($schedules) * 2 - 1 }}" class="shipping-summary-start" style="background-color: {{ $startBackground }}">
                                <strong data-shipping-start-time>-</strong>
                            </td>
                        @endif
                        <td class="shipping-summary-date" style="background-color: {{ $background }}">
                            <strong data-shipping-date-days="{{ (int) ($schedule['days'] ?? 0) }}">-</strong>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
