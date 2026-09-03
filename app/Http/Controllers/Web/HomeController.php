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

        return view('home', compact('news'));
    }
}
