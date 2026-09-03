<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Date Range
        |--------------------------------------------------------------------------
        |
        | วันนี้ -> ย้อนหลัง 5 เดือน = รวมประมาณ 6 เดือน
        |
        */

        $dateStart = Carbon::now()
            ->subMonths(5)
            ->startOfMonth()
            ->format('Y-m-d');

        $dateEnd = Carbon::today()
            ->format('Y-m-d');


        /*
        |--------------------------------------------------------------------------
        | Get Orders
        |--------------------------------------------------------------------------
        */

        $orders = DB::table('HM_ord_setup as ord')
            ->join(
                'HM_ord_product_detail as prd',
                'ord.prd_id',
                '=',
                'prd.id'
            )
            ->select(
                'total_price',
                'date_create',
                'payment',
                'transaction_id'
            )
            ->whereDate('date_create', '>=', $dateStart)
            ->whereDate('date_create', '<=', $dateEnd)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Prepare Data
        |--------------------------------------------------------------------------
        */

        $groupedOrdData = [];
        $groupedOrdDataType = [];

        foreach ($orders as $item) {

            $price = (float) str_replace(
                ',',
                '',
                $item->total_price
            );

            $month = Carbon::parse(
                $item->date_create
            )->format('m');


            /*
             * All Orders
             */
            if (!isset($groupedOrdData[$month])) {

                $groupedOrdData[$month] = [
                    'total_price' => $price,
                    'order_count' => 1,
                ];

            } else {

                $groupedOrdData[$month]['total_price'] += $price;
                $groupedOrdData[$month]['order_count']++;
            }


            /*
             * Credit Card Orders
             */
            if (
                $item->payment === 'クレジットカード決済'
                && is_numeric($item->transaction_id)
            ) {

                if (!isset($groupedOrdDataType[$month])) {

                    $groupedOrdDataType[$month] = [
                        'total_price' => $price,
                        'order_count' => 1,
                    ];

                } else {

                    $groupedOrdDataType[$month]['total_price'] += $price;
                    $groupedOrdDataType[$month]['order_count']++;
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        $thisMonth = Carbon::now()->format('m');

        $totalSalesAmountThisMonth = 0;
        $totalSalesAmountWholeMonth = 0;

        $totalSalesCardAmountThisMonth = 0;
        $totalSalesCardAmountWholeMonth = 0;


        foreach ($groupedOrdData as $month => $item) {

            if ($month === $thisMonth) {
                $totalSalesAmountThisMonth = $item['total_price'];
            }

            $totalSalesAmountWholeMonth += $item['total_price'];
        }


        foreach ($groupedOrdDataType as $month => $item) {

            if ($month === $thisMonth) {
                $totalSalesCardAmountThisMonth = $item['total_price'];
            }

            $totalSalesCardAmountWholeMonth += $item['total_price'];
        }


        /*
        |--------------------------------------------------------------------------
        | Chart Data
        |--------------------------------------------------------------------------
        */

        $categories = [];
        $totalPriceData = [];
        $orderCountData = [];

        foreach ($groupedOrdData as $month => $item) {

            $categories[] = Carbon::create(
                2000,
                (int) $month,
                1
            )->format('F');

            $totalPriceData[] = $item['total_price'];
            $orderCountData[] = $item['order_count'];
        }


        $categoriesCard = [];
        $totalPriceCardData = [];
        $orderCountCardData = [];

        foreach ($groupedOrdDataType as $month => $item) {

            $categoriesCard[] = Carbon::create(
                2000,
                (int) $month,
                1
            )->format('F');

            $totalPriceCardData[] = $item['total_price'];
            $orderCountCardData[] = $item['order_count'];
        }


        return view('admin.dashboard', compact(
            'totalSalesAmountThisMonth',
            'totalSalesAmountWholeMonth',
            'totalSalesCardAmountThisMonth',
            'totalSalesCardAmountWholeMonth',

            'categories',
            'totalPriceData',
            'orderCountData',

            'categoriesCard',
            'totalPriceCardData',
            'orderCountCardData',
        ));
    }
}