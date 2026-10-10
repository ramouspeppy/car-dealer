<!DOCTYPE html>
<html lang="{{ $seo['locale'] }}">


<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $seo['title'] }}</title>
    <meta name="description" content="{{ $seo['description'] }}">
    @if ($seo['keywords'] !== '')
        <meta name="keywords" content="{{ $seo['keywords'] }}">
    @endif
    <meta name="robots" content="{{ $seo['robots'] }}">
    <link rel="canonical" href="{{ $seo['canonical_url'] }}">

    <meta property="og:locale" content="{{ $seo['locale'] }}">
    <meta property="og:type" content="{{ $seo['type'] }}">
    <meta property="og:site_name" content="{{ $seo['site_name'] }}">
    <meta property="og:title" content="{{ $seo['title'] }}">
    <meta property="og:description" content="{{ $seo['description'] }}">
    <meta property="og:url" content="{{ $seo['canonical_url'] }}">
    @if ($seo['image'] !== '')
        <meta property="og:image" content="{{ $seo['image'] }}">
        <meta property="og:image:alt" content="{{ $seo['title'] }}">
        <meta name="twitter:image" content="{{ $seo['image'] }}">
    @endif
    <meta name="twitter:card" content="{{ $seo['twitter_card'] }}">
    <meta name="twitter:title" content="{{ $seo['title'] }}">
    <meta name="twitter:description" content="{{ $seo['description'] }}">
    @if ($seo['google_verification'] !== '')
        <meta name="google-site-verification" content="{{ $seo['google_verification'] }}">
    @endif
    <meta name="theme-color" content="#12314f">

    <!-- Favicons -->
    <link href="{{ $seo['favicon'] }}" rel="icon">
    <link href="{{ $seo['apple_touch_icon'] }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ mix('frontend/css/app.css') }}">

    <style>
        .product-list-cards .product-list-image {
            align-self: stretch;
            min-height: 220px;
            padding: 18px;
            border-radius: 14px;
        }

        .product-list-cards .product-list-image img {
            max-width: 100%;
            max-height: 200px;
            object-fit: contain;
        }

        .promo-list .product-photo-card .promo-image img {
            box-sizing: border-box;
            padding: clamp(14px, 3vw, 28px);
            object-fit: contain;
        }

        .promo-list .product-photo-card:hover .promo-image img {
            transform: none;
        }

        .product-detail-carousel .product-detail-item figure {
            box-sizing: border-box;
            max-width: 850px;
            padding: clamp(14px, 3vw, 32px);
            border-radius: 14px;
        }

        .product-detail-carousel .product-detail-item figure img {
            display: block;
            width: 100%;
            max-height: 68vh;
            object-fit: contain;
            transform: none !important;
        }
    </style>

    @stack('css')

</head>

<body class="index-page">
    {{-- Floating WhatsApp Button --}}
    <a href="{{ $profile->wa_url }}" target="_blank" class="floating-wa" aria-label="Chat WhatsApp">
        <div class="floating-wa-icon">
            <i class="bi bi-whatsapp"></i>
        </div>
        <div class="floating-wa-text">Chat Kami</div>
    </a>
    <header id="header" class="header dark-background d-flex flex-column justify-content-center">
        <i class="header-toggle d-xl-none bi bi-list"></i>

        <div class="header-container d-flex flex-column align-items-start">
            <div class="logo-img">
                @if ($seo['site_logo'] !== '')
                    <img src="{{ $seo['site_logo'] }}" alt="{{ $seo['site_name'] }}" class="img-fluid rounded-circle">
                @else
                    <span>{{ $seo['site_name'] }}</span>
                @endif
            </div>
            <button class="theme-toggle" type="button" aria-label="Ganti tema" aria-pressed="true">
                <i class="theme-toggle-icon bi bi-moon-stars-fill"></i>
                <span class="theme-toggle-label">Dark</span>
            </button>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ url('/') }}" class="active"><i class="bi bi-house-door-fill navicon"></i>Home</a></li>
                    <li><a href="{{ route('product.index') }}"><i class="bi bi-car-front-fill navicon"></i> Produk</a></li>
                    <li><a href="{{ route('promo.index') }}"><i class="bi bi-tags-fill navicon"></i> Promo</a></li>
                    <li><a href="{{ route('testdrive.show') }}"><i class="bi bi-calendar-check-fill navicon"></i> TestDrive</a></li>
                    <li><a href="{{ route('gallery.index') }}"><i class="bi bi-images navicon"></i> Gallery</a></li>
                    <li><a href="{{ route('post.index') }}"><i class="bi bi-newspaper navicon"></i> Berita</a></li>
                    <li class="dropdown"><a href="#"><i class="bi bi-window-stack navicon"></i> <span>Landing Page</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="{{ route('landing.show') }}">Landing Page V1</a></li>
                            <li><a href="{{ route('landing.showV2') }}">Landing Page V2</a></li>
                            <li><a href="{{ route('landing.showV3') }}">Landing Page V3</a></li>
                            <li><a href="{{ route('landing.showV4') }}">Landing Page V4</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <div class="social-links text-center mx-auto">
                <a target="_blank" href="{{ $profile->wa_url }}"><i class="bi bi-whatsapp"></i></a>
                <a target="_blank" href="{{ $profile->ig_url }}"><i class="bi bi-instagram"></i></a>
                <a target="_blank" href="{{ $profile->fb_url }}"><i class="bi bi-facebook"></i></a>
                <a target="_blank" href="{{ $profile->phone_url }}"><i class="bi bi-phone"></i></a>
            </div>
            {{-- Tombol Konsultasi --}}
            <div class="mt-3 w-100 px-2">
                <button data-bs-toggle="modal" data-bs-target="#consultationModal" class="btn-konsultasi w-100">
                    <i class="bi bi-chat-dots-fill"></i>
                    <span>Konsultasi Sekarang</span>
                </button>
            </div>
        </div>
    </header>

    <main class="main">

        @yield('content')

    </main>

    <footer id="footer" class="footer position-relative">

        @include('frontend.layouts.footer')

    </footer>
    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    {{-- --}}
    @include('components.consultation-modal')

    <!-- Main JS File -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script> --}}
    <script src="{{ mix('frontend/js/app.js') }}"></script>
    @stack('scripts')

</body>

</html>
