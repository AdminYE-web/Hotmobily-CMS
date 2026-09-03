@extends('admin.layouts.app')


@section('title', 'Dashboard | Hotmobily')


@section('content')

<div class="container-fluid">

    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <h1 class="h3 mb-0 text-gray-800">
            Dashboard
        </h1>

        <a
            href="#"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
        >
            Generate Report
        </a>

    </div>


    {{-- Summary Cards --}}
    <div class="row">

        {{-- Monthly --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-primary shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Order (Monthly)
                            </div>

                            <div class="h5 mb-0 font-weight-bold text-gray-800">

                                {{ number_format(
                                    $totalSalesAmountThisMonth,
                                    2
                                ) }}円

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Latest 6 Months --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-success shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Order (Latest 6 Months)
                            </div>

                            <div class="h5 mb-0 font-weight-bold text-gray-800">

                                {{ number_format(
                                    $totalSalesAmountWholeMonth,
                                    2
                                ) }}円

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Card Monthly --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-primary shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">

                                Paid Order
                                (クレジットカード決済)
                                (Monthly)

                            </div>

                            <div class="h5 mb-0 font-weight-bold text-gray-800">

                                {{ number_format(
                                    $totalSalesCardAmountThisMonth,
                                    2
                                ) }}円

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Card Latest 6 Months --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-success shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">

                                Paid Order
                                (クレジットカード決済)
                                (Latest 6 Months)

                            </div>

                            <div class="h5 mb-0 font-weight-bold text-gray-800">

                                {{ number_format(
                                    $totalSalesCardAmountWholeMonth,
                                    2
                                ) }}円

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Credit Card Total Price --}}
    <div class="row">

        <div class="col-xl-12">

            <div class="card shadow mb-4">

                <div class="card-header py-3">

                    <h6 class="m-0 font-weight-bold text-primary">

                        Order Sale Amount Overview
                        (クレジットカード決済)
                        (Latest 6 Months)

                    </h6>

                </div>

                <div class="card-body">

                    <div id="total-sales-card-chart"></div>

                </div>

            </div>

        </div>

    </div>


    {{-- Credit Card Order Count --}}
    <div class="row">

        <div class="col-xl-12">

            <div class="card shadow mb-4">

                <div class="card-header py-3">

                    <h6 class="m-0 font-weight-bold text-primary">

                        Total order Overview
                        (クレジットカード決済)
                        (Latest 6 Months)

                    </h6>

                </div>

                <div class="card-body">

                    <div id="total-amount-card-chart"></div>

                </div>

            </div>

        </div>

    </div>


    {{-- All Total Price --}}
    <div class="row">

        <div class="col-xl-12">

            <div class="card shadow mb-4">

                <div class="card-header py-3">

                    <h6 class="m-0 font-weight-bold text-primary">

                        Order Amount Overview
                        (Latest 6 Months)

                    </h6>

                </div>

                <div class="card-body">

                    <div id="total-price-chart"></div>

                </div>

            </div>

        </div>

    </div>


    {{-- All Order Count --}}
    <div class="row">

        <div class="col-xl-12">

            <div class="card shadow mb-4">

                <div class="card-header py-3">

                    <h6 class="m-0 font-weight-bold text-primary">

                        Total order Overview
                        (Latest 6 Months)

                    </h6>

                </div>

                <div class="card-body">

                    <div id="order-count-chart"></div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>


<script>

    const categories = @json($categories);
    const totalPriceData = @json($totalPriceData);
    const orderCountData = @json($orderCountData);

    const categoriesCard = @json($categoriesCard);
    const totalPriceCardData = @json($totalPriceCardData);
    const orderCountCardData = @json($orderCountCardData);


    /*
    |--------------------------------------------------------------------------
    | Credit Card Total Price
    |--------------------------------------------------------------------------
    */

    Highcharts.chart('total-sales-card-chart', {

        title: {
            text: 'Total Price'
        },

        xAxis: {
            categories: categoriesCard
        },

        yAxis: {
            title: {
                text: 'Total Price'
            }
        },

        series: [
            {
                name: 'Total Price',
                type: 'line',
                data: totalPriceCardData
            }
        ],

        tooltip: {

            formatter: function () {

                return this.x
                    + ': '
                    + this.y.toLocaleString()
                    + '円';
            }

        },

        exporting: {
            enabled: true
        }

    });


    /*
    |--------------------------------------------------------------------------
    | Credit Card Order Count
    |--------------------------------------------------------------------------
    */

    Highcharts.chart('total-amount-card-chart', {

        title: {
            text: 'Order Count'
        },

        xAxis: {
            categories: categoriesCard
        },

        yAxis: {

            title: {
                text: 'Order Count'
            }

        },

        series: [
            {
                name: 'Order Count',
                type: 'line',
                data: orderCountCardData
            }
        ],

        tooltip: {

            formatter: function () {

                return this.x
                    + ': '
                    + Highcharts.numberFormat(
                        this.y,
                        0
                    );
            }

        },

        exporting: {
            enabled: true
        }

    });


    /*
    |--------------------------------------------------------------------------
    | All Total Price
    |--------------------------------------------------------------------------
    */

    Highcharts.chart('total-price-chart', {

        title: {
            text: 'Total Price'
        },

        xAxis: {
            categories: categories
        },

        yAxis: {

            title: {
                text: 'Total Price'
            }

        },

        series: [
            {
                name: 'Total Price',
                type: 'line',
                data: totalPriceData
            }
        ],

        tooltip: {

            formatter: function () {

                return this.x
                    + ': '
                    + this.y.toLocaleString()
                    + '円';
            }

        },

        exporting: {
            enabled: true
        }

    });


    /*
    |--------------------------------------------------------------------------
    | All Order Count
    |--------------------------------------------------------------------------
    */

    Highcharts.chart('order-count-chart', {

        title: {
            text: 'Order Count'
        },

        xAxis: {
            categories: categories
        },

        yAxis: {

            title: {
                text: 'Order Count'
            }

        },

        series: [
            {
                name: 'Order Count',
                type: 'line',
                data: orderCountData
            }
        ],

        tooltip: {

            formatter: function () {

                return this.x
                    + ': '
                    + Highcharts.numberFormat(
                        this.y,
                        0
                    );
            }

        },

        exporting: {
            enabled: true
        }

    });

</script>

@endpush