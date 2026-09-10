<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        // Temporary data until the legacy news table is migrated.
        $news = collect([
            [
                'id' => 1,
                'published_at' => Carbon::parse('2026-09-01'),
                'title' => '【モック】ホームページのリニューアル準備を進めています。',
            ],
            [
                'id' => 2,
                'published_at' => Carbon::parse('2026-08-25'),
                'title' => '【モック】商品情報は順次、新しいサイトへ移行予定です。',
            ],
            [
                'id' => 3,
                'published_at' => Carbon::parse('2026-08-18'),
                'title' => '【モック】オリジナルグッズ製作のご相談を受付中です。',
            ],
        ]);

        // Temporary review data until the legacy reviews table is migrated.
        $reviews = [
            [
                'id' => 1,
                'comment' => '',
                'service' => 4,
                'product' => 4,
                'sale_name' => '竹村',
                'product_type' => '刺繍キーホルダー',
                'date' => '2026年08月31日 06:47:00',
            ],
            [
                'id' => 2,
                'comment' => '',
                'service' => 5,
                'product' => 5,
                'sale_name' => 'ビビアン',
                'product_type' => 'アクリルキーホルダー',
                'date' => '2026年08月28日 11:11:00',
            ],
            [
                'id' => 3,
                'comment' => '',
                'service' => 4,
                'product' => 4,
                'sale_name' => '原',
                'product_type' => 'アクリルキーホルダー',
                'date' => '2026年08月25日 09:30:00',
            ],
        ];

        return view('home', compact('news', 'reviews'));
    }
}
