<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @yield('head')
</head>

<body id="top">
    <!-- :: header start :: -->
    @include('partials.header')
    <!-- :: header end :: -->

    <!-- globalNavi -->
    @include('partials.legacy-navigation')
    <!-- globalNavi End -->

    <!-- :: wrapper start :: -->
    <div id="wrapper">
        <!-- sidemenu-->
        @include('partials.legacy-sidebar')
        <!-- sidemenu End -->

        <!-- :: content_wrapper start :: -->
        <div id="content_wrapper" class="scrollingPanel">
            @yield('content')
        </div>
        <!-- :: content_wrapper end :: -->
    </div>
    <!-- :: wrapper end :: -->

    <!--フッター ここから-->
    @include('partials.footer')
    <!--フッター ここまで-->

    @stack('scripts')
</body>

</html>
