<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'ホットモバイリー｜オリジナルグッズ製作')</title>
    <meta name="description" content="@yield('description', '小ロット・短納期に対応したオリジナルグッズ、ノベルティの製作サービスです。')">
    <meta name="robots" content="index,follow">

    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    @stack('styles')
</head>
<body>
    <a class="skip-link" href="#main-content">本文へ移動</a>

    @include('partials.header')

    <main id="main-content">
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="{{ asset('js/site.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
