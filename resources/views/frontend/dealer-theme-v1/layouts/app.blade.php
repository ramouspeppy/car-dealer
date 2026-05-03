<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Index - SnapFolio Bootstrap Template</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="frontend/dealer-theme-v1/img/favicon.png" rel="icon">
    <link href="frontend/dealer-theme-v1/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ mix('frontend/dealer-theme-v1/css/app.css') }}">

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
                <img src="{{ asset(config('settings.site_logo')) }}" alt="{{ config('settings.site_name') }}" class="img-fluid rounded-circle">
            </div>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ url('/') }}" class="active"><i class="bi bi-house navicon"></i>Home</a></li>
                    <li><a href="{{ route('product.index') }}"><i class="bi bi-person navicon"></i> Produk</a></li>
                    <li><a href="{{ route('testdrive.show') }}"><i class="bi bi-person navicon"></i> TestDrive</a></li>
                    <li><a href="{{ route('gallery.index') }}"><i class="bi bi-person navicon"></i> Gallery</a></li>
                    <li><a href="{{ route('post.index') }}"><i class="bi bi-person navicon"></i> Berita</a></li>
                    {{-- <li><a href="#resume"><i class="bi bi-file-earmark-text navicon"></i> Resume</a></li>
                    <li><a href="#portfolio"><i class="bi bi-images navicon"></i> Portfolio</a></li> --}}
                    {{-- <li><a href="#services"><i class="bi bi-hdd-stack navicon"></i> Services</a></li>
                    <li class="dropdown"><a href="#"><i class="bi bi-menu-button navicon"></i> <span>Dropdown</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="#">Dropdown 1</a></li>
                            <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i
                                        class="bi bi-chevron-down toggle-dropdown"></i></a>
                                <ul>
                                    <li><a href="#">Deep Dropdown 1</a></li>
                                    <li><a href="#">Deep Dropdown 2</a></li>
                                    <li><a href="#">Deep Dropdown 3</a></li>
                                    <li><a href="#">Deep Dropdown 4</a></li>
                                    <li><a href="#">Deep Dropdown 5</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Dropdown 2</a></li>
                            <li><a href="#">Dropdown 3</a></li>
                            <li><a href="#">Dropdown 4</a></li>
                        </ul>
                    </li>
                    <li><a href="#contact"><i class="bi bi-envelope navicon"></i> Contact</a></li> --}}
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

        @include('frontend.' . frontend_theme() . '.layouts.footer')

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
    <script src="{{ mix('frontend/dealer-theme-v1/js/app.js') }}"></script>
    @stack('scripts')

</body>

</html>
