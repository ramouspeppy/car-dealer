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
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->



    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ mix('frontend/dealer-theme-v1/css/app.css') }}">
    {{-- <style>
        :root {
            --default-font: Roboto, system-ui, -apple-system, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, Liberation Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            --heading-font: Ubuntu;
            --nav-font: Nunito;
            --background-color: #f8fafd;
            --default-color: #4c5c75;
            --heading-color: #2c3e50;
            --accent-color: #3498db;
            --surface-color: #ffffff;
            --contrast-color: #ffffff;
            --nav-color: #4c5c75;
            --nav-hover-color: #3498db;
            --nav-mobile-background-color: #353535;
            --nav-dropdown-background-color: #ffffff;
            --nav-dropdown-color: #4c5c75;
            --nav-dropdown-hover-color: #3498db;
            scroll-behavior: smooth;
        }
    </style> --}}
    @stack('css')

</head>

<body class="index-page">

    <header id="header" class="header dark-background d-flex flex-column justify-content-center">
        <i class="header-toggle d-xl-none bi bi-list"></i>

        <div class="header-container d-flex flex-column align-items-start">
            <div class="logo-img">
                <img src="{{ asset(config("settings.site_logo")) }}" alt="{{ config('settings.site_name') }}"
                    class="img-fluid rounded-circle">
            </div>
            @include('frontend.'.frontend_theme().'.layouts.nav')

            <div class="social-links text-center">
                <a target="_blank" href="{{ $profile->wa_url }}"><i class="bi bi-whatsapp"></i></a>
                <a target="_blank" href="{{ $profile->ig_url }}"><i class="bi bi-instagram"></i></a>
                <a target="_blank" href="{{ $profile->fb_url }}"><i class="bi bi-facebook"></i></a>
                <a target="_blank" href="{{ $profile->yt_url }}"><i class="bi bi-youtube"></i></a>
                <a target="_blank" href="{{ $profile->x_url }}"><i class="bi bi-twitter-x"></i></a>
                <a target="_blank" href="{{ $profile->phone_url }}"><i class="bi bi-phone"></i></a>
            </div>
        </div>
    </header>

    <main class="main">

        @yield('content')

    </main>

    <footer id="footer" class="footer position-relative">

        @include('frontend.'.frontend_theme().'.layouts.footer')

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Main JS File -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ mix('frontend/dealer-theme-v1/js/app.js') }}"></script>
    @stack('script')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
          const starDivs = document.querySelectorAll(".stars");
      
          starDivs.forEach(starsContainer => {
            const rating = parseFloat(starsContainer.dataset.value) || 0; // ambil value dari DB
            starsContainer.innerHTML = ""; // reset isi div
      
            // loop 1-5 bintang
            for (let i = 1; i <= 5; i++) {
              let star = document.createElement("i");
              star.classList.add("bi");
      
              if (i <= Math.floor(rating)) {
                // bintang penuh
                star.classList.add("bi-star-fill", "active");
              } else if (i - rating <= 0.5 && rating % 1 !== 0) {
                // bintang setengah
                star.classList.add("bi-star-half", "active");
              } else {
                // bintang kosong
                star.classList.add("bi-star");
              }
      
              starsContainer.appendChild(star);
            }
          });
        });
    </script>

</body>

</html>