<?php

return [
    // Optional protection for the backwards-compatible HTTP importer URL.
    'import_token' => env('REVIEWS_IMPORT_TOKEN'),

    'google' => [
        'api_key' => env('REVIEWS_GOOGLE_API_KEY'),
        'spreadsheet_id' => env('REVIEWS_GOOGLE_SPREADSHEET_ID'),
        'sheet_name' => env('REVIEWS_GOOGLE_SHEET_NAME', 'Form Responses 1'),
        'first_data_row' => (int) env('REVIEWS_GOOGLE_FIRST_DATA_ROW', 2),
        'timeout' => (int) env('REVIEWS_GOOGLE_TIMEOUT', 30),
    ],

    // The importer stores files in public/reviews/upload, matching the old
    // URLs used by the product review templates.
    'upload_path' => env('REVIEWS_UPLOAD_PATH', 'reviews/upload'),

    'fallback_sale_name' => env(
        'REVIEWS_FALLBACK_SALE_NAME',
        'その他・覚えていない'
    ),

    'display_limit' => (int) env('REVIEWS_DISPLAY_LIMIT', 20),
];
