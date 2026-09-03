<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no"
    >
    <meta
    name="csrf-token"
    content="{{ csrf_token() }}"
>

    <title>
        @yield('title', 'Hotmobily Admin')
    </title>


    {{-- Bootstrap --}}
    <link
        href="{{ asset('admin/vendor/bootstrap/css/bootstrap.min.css') }}"
        rel="stylesheet"
    >


    {{-- Sidebar --}}
    <link
        href="{{ asset('admin/css/simple-sidebar.css') }}"
        rel="stylesheet"
    >


    {{-- Custom --}}
    <link
        href="{{ asset('admin/css/showdata_css.css') }}?v=1.01"
        rel="stylesheet"
    >


    {{-- DataTables --}}
    <link
        rel="stylesheet"
        href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css"
    >


    @stack('styles')

</head>


<body>

<div
    class="d-flex"
    id="wrapper"
>

    {{-- Sidebar --}}
    @include('admin.partials.sidebar')


    {{-- Page Content --}}
    <div id="page-content-wrapper">

        {{-- Header --}}
        @include('admin.partials.header')


        {{-- Content --}}
        @yield('content')

    </div>

</div>


{{-- Footer / JS --}}
@include('admin.partials.footer')


@stack('scripts')

</body>

</html>