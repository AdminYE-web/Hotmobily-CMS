<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Rubber strap attachments configuration.
     */
    protected array $rubberAttachments = [
        ['part_name' => '通常松葉（カニカン）', 'part_price' => '0', 'part_pic' => '/products/images/HM_part1-2.webp'],
        ['part_name' => 'ゴム松葉（カニカン）', 'part_price' => '0', 'part_pic' => '/products/images/HM_part2-2.webp'],
        ['part_name' => 'ボールチェーンシルバー', 'part_price' => '0', 'part_pic' => '/products/images/HM_part14.webp'],
        ['part_name' => '通常松葉（カニカン・スマホプラグ）', 'part_price' => '10', 'part_pic' => '/products/images/HM_part3.webp'],
        ['part_name' => 'ボールチェーン黄色', 'part_price' => '10', 'part_pic' => '/products/images/HM_part9.webp'],
        ['part_name' => 'ボールチェーン赤色', 'part_price' => '10', 'part_pic' => '/products/images/HM_part10.webp'],
        ['part_name' => 'ボールチェーン青色', 'part_price' => '10', 'part_pic' => '/products/images/HM_part11.webp'],
        ['part_name' => 'ボールチェーンピンク色', 'part_price' => '10', 'part_pic' => '/products/images/HM_part12.webp'],
        ['part_name' => 'ボールチェーン緑色', 'part_price' => '10', 'part_pic' => '/products/images/HM_part13.webp'],
    ];

    /**
     * Display the Rubber Strap product page.
     */
    public function rubberstrap(Request $request): View
    {
        $productName = '【ホットモバイリー】オリジナルラバーストラップ';
        $productDescription = 'オリジナル形状のラバーストラップをオーダーメイドで製作。最短7営業日で出荷可能なプランや、少数（10個）向けプランあり。';
        $productImageUrl = 'https://hotmobily.jp/gallery/img-rub/2023-rubberstrap-gallery/4.webp';
        $productSku = 'HM-RS-2024';
        $productPrice = 126;
        $productCurrency = 'JPY';
        $productAvailability = 'InStock';
        $productUrl = 'https://hotmobily.jp/products/rubberstrap/';

        $totalReviews = 185;
        $avgService = 4.8;
        $avgProduct = 4.9;

        $schemaArray = [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $productName,
            'description' => $productDescription,
            'sku' => $productSku,
            'url' => $productUrl,
            'image' => $productImageUrl,
            'brand' => [
                '@type' => 'Brand',
                'name' => 'HotMobily',
            ],
            'offers' => [
                '@type' => 'Offer',
                'url' => $productUrl,
                'availability' => 'https://schema.org/' . $productAvailability,
                'priceCurrency' => $productCurrency,
                'price' => $productPrice,
                'priceValidUntil' => '2026-12-31',
            ],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => number_format($avgProduct, 1),
                'reviewCount' => $totalReviews,
            ],
            'review' => [
                '@type' => 'Review',
                'name' => '当店ラバーストラップのレビュー',
                'author' => [
                    '@type' => 'Person',
                    'name' => 'Anonymous',
                ],
                'positiveNotes' => [
                    '@type' => 'ItemList',
                    'itemListElement' => [
                        [
                            '@type' => 'ListItem',
                            'position' => 1,
                            'name' => '対応が丁寧で不安なく作れて感謝しています。 年末のせいか制作にやや時間がかかったのが少し気になりましたが、それ以外は完璧でした。 またよろしくお願いします。',
                        ],
                        [
                            '@type' => 'ListItem',
                            'position' => 2,
                            'name' => '発色が一番好みだったのと、裏面保護があるのがいいと思いました。 もう少し小さくしても印刷が衰えないならアクキーもそのうち作りたいです。',
                        ],
                        [
                            '@type' => 'ListItem',
                            'position' => 3,
                            'name' => 'いつもお世話になっております。 制作前のやり取り、納期、仕上り、梱包状態、そして細部にわたる製品のクオリティ全てに満足しております。',
                        ],
                    ],
                ],
            ],
        ];

        $breadcrumbSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'ホーム',
                    'item' => 'https://hotmobily.jp/',
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Products',
                    'item' => 'https://hotmobily.jp/products',
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => 'ラバーストラップ',
                    'item' => 'https://hotmobily.jp/products/rubberstrap/',
                ],
            ],
        ];

        $jsonLdOutput = json_encode([$schemaArray, $breadcrumbSchema], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        // Mock reviews for the reviews block
        $reviews = [
            [
                'id' => 1,
                'comment' => '発色が良く、細かいラインも綺麗に出ていて大満足の仕上がりでした！サンプル確認もスムーズで助かりました。',
                'service' => 5,
                'product' => 5,
                'sale_name' => '山田',
                'product_type' => 'ラバーストラップ',
                'images' => '',
            ],
            [
                'id' => 2,
                'comment' => '同人イベント用に100個製作をお願いしました。納期通りに届き、汚れ防止加工のおかげで手触りもとても良いです。',
                'service' => 5,
                'product' => 5,
                'sale_name' => '佐藤',
                'product_type' => 'ラバーストラップ',
                'images' => '',
            ],
            [
                'id' => 3,
                'comment' => '小ロットでの注文でしたが、丁寧にご対応いただきました。次回もまたお願いしたいです。',
                'service' => 4,
                'product' => 5,
                'sale_name' => '鈴木',
                'product_type' => 'ラバーストラップ',
                'images' => '',
            ],
        ];

        // Mock FAQ items
        $faqs = [
            [
                'question' => '最小ロットは何個から注文できますか？',
                'answer' => 'オリジナルラバーストラップは、1個からご注文いただけます。ロット数に応じたボリュームディスカウントもご用意しております。',
            ],
            [
                'question' => '試作品の確認は可能ですか？',
                'answer' => 'プレミアムプランでは試作品の製作と実物確認が基本料金に含まれております。スタンダードプランでもオプションで追加可能です。',
            ],
            [
                'question' => 'イラストレーターのデータがなくても注文できますか？',
                'answer' => 'はい、画像や手描きイラストからの「データトレースサービス」を承っております。お気軽にご相談ください。',
            ],
        ];

        // Mock Blog articles
        $blogs = [
            [
                'title' => 'ラバーストラップを安く作るコツと価格を抑えるポイント',
                'url' => 'howtomake-cheaper',
                'img_cover' => 'products/images/rubberstrap/v2/rubber_strap_product01.webp',
            ],
            [
                'title' => 'データトレースサービスとは？画像1枚からグッズを作る方法',
                'url' => 'about-trace',
                'img_cover' => 'products/images/rubberstrap/v2/rubber_strap_product02.webp',
            ],
        ];

        $units = [100, 200, 300, 500, 1000, 3000, 5000];
        $attachments = $this->rubberAttachments;

        return view('products.rubberstrap.index', compact(
            'productName',
            'productDescription',
            'productImageUrl',
            'productPrice',
            'jsonLdOutput',
            'totalReviews',
            'avgProduct',
            'avgService',
            'reviews',
            'faqs',
            'blogs',
            'units',
            'attachments'
        ));
    }

    /**
     * Delivery schedule calculation for Rubber Strap.
     */
    public function deliveryScheduleRubber(): View
    {
        $units = [100, 200, 300, 500, 1000, 3000, 5000];
        $deliDateS = [10, 10, 10, 14, 14, 22, 22];
        $deliDateSp = [16, 16, 16, 21, 21, 29, 29];
        $deliDateP = [16, 16, 16, 21, 21, 29, 29];
        $deliDatePp = [23, 23, 23, 28, 28, 36, 36];

        $rows = [];
        foreach ($units as $key => $unit) {
            $rows[] = [
                'quantity' => $unit,
                'deli_date_s' => $deliDateS[$key],
                'production_date_s' => $this->calculateProductionDate($deliDateS[$key]),
                'deli_date_sp' => $deliDateSp[$key],
                'production_date_sp' => $this->calculateProductionDate($deliDateSp[$key]),
                'deli_date_p' => $deliDateP[$key],
                'production_date_p' => $this->calculateProductionDate($deliDateP[$key]),
                'deli_date_pp' => $deliDatePp[$key],
                'production_date_pp' => $this->calculateProductionDate($deliDatePp[$key]),
            ];
        }

        return view('products.partials.delivery-table-rubber', compact('rows'));
    }

    /**
     * Check production / holiday dates.
     */
    public function checkHoliday(Request $request): JsonResponse
    {
        $tz = new \DateTimeZone('Asia/Tokyo');
        $now = CarbonImmutable::now($tz);
        $startDate = ($now->hour >= 12) ? $now->addDay() : $now;
        $dayCount = 10; // default production days

        $endDate = $this->addBusinessDays($startDate, $dayCount);

        return response()->json([
            $startDate->format('Y-m-d'),
            $endDate->format('Y-m-d'),
        ]);
    }

    /**
     * Get sample date calculation.
     */
    public function getSampleDate(Request $request): JsonResponse
    {
        $days = (int) $request->input('days', 6);
        $days = ($days > 0) ? min($days, 60) : 6;
        $daysExpress = $days + 6;

        $calcHour = (int) $request->input('format_cal', 12);
        $tz = new \DateTimeZone('Asia/Tokyo');
        $now = CarbonImmutable::now($tz);

        $startDate = ($now->hour >= $calcHour) ? $now->addDay() : $now;
        $endDate1 = $this->addBusinessDays($startDate, $days);
        $endDate2 = $this->addBusinessDays($startDate, $daysExpress);

        return response()->json([
            $startDate->format('Y-m-d'),
            $endDate1->format('Y-m-d'),
            $endDate2->format('Y-m-d'),
        ]);
    }

    /**
     * Backing paper preview patterns.
     */
    public function paperPreview(): View
    {
        return view('products.partials.paper-preview');
    }

    /**
     * Rubber strap attachments JSON API.
     */
    public function rubberstrapPart(Request $request): JsonResponse
    {
        return response()->json($this->rubberAttachments);
    }

    /**
     * Helper to compute Japanese business dates (excluding Sundays and adjusting for Saturdays).
     */
    protected function calculateProductionDate(int $days): string
    {
        $tz = new \DateTimeZone('Asia/Tokyo');
        $now = CarbonImmutable::now($tz);
        $startDate = ($now->hour >= 12) ? $now->addDay() : $now;

        $targetDate = $this->addBusinessDays($startDate, $days);
        $dayOfWeekLabels = ['日', '月', '火', '水', '木', '金', '土'];

        return $targetDate->format('m/d') . '(' . $dayOfWeekLabels[$targetDate->dayOfWeek] . ')';
    }

    /**
     * Helper to add business days (Mon-Sat production days, Sunday is factory holiday).
     */
    protected function addBusinessDays(CarbonImmutable $start, int $days): CarbonImmutable
    {
        $current = $start;
        $workDays = 0;

        while ($workDays < $days) {
            // Sunday (0) is a holiday
            if ($current->dayOfWeek !== Carbon::SUNDAY) {
                $workDays++;
            }
            if ($workDays < $days) {
                $current = $current->addDay();
            }
        }

        // If target lands on Sunday, push to Monday
        while ($current->dayOfWeek === Carbon::SUNDAY) {
            $current = $current->addDay();
        }

        return $current;
    }
}
