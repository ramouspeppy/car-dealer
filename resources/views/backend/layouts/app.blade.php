<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title',config('settings.site_name'))</title>
    <!-- Popperjs -->

    <link rel="stylesheet" href="{{ mix('backend/css/app.css') }}">
    @yield('css')


    <link rel="icon" href="{{ config('settings.favicon_url') }}">

</head>

<body>
    <div id="app">
        @auth
        <div class="main-wrapper">
            <div class="navbar-bg" style="position: relative; z-index:1000">
                @include('backend.layouts._nav')
                @yield('breadcrumb')

            </div>
            <div class="main-sidebar">
                @include('backend.layouts._sidebar')
            </div>
            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2021 <div class="bullet"></div> Design By Azza
                </div>
                <div class="footer-right">
                    2.3.0
                </div>
            </footer>
        </div>
        @endauth

        @guest
        <div id="app">
            @yield('content')
        </div>
        @endguest

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Flip.min.js"></script>
    <script src="{{ mix('backend/js/app.js') }}"></script>

    @yield('script')
    @stack('scripts')


    <!-- Page Specific JS File -->
</body>

</html>