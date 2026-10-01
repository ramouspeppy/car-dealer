@extends('frontend.layouts.app')

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="hero section">

        <div class="background-elements">
            <div class="bg-circle circle-1"></div>
            <div class="bg-circle circle-2"></div>
        </div>
        <div class="hero-content">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                        <div class="hero-text">
                            <h1 class="header-title">{{ $header->title }}<span class="accent-text"></span></h1>
                            <p class="lead">
                                <span class="typed" data-typed-items="{{ $header->sub_title }}"></span>
                            </p>

                            <p class="description">{!! $header->caption !!}</p>

                            <div class="hero-actions">
                                <a href="{{ route('testdrive.show') }}" class="btn btn-primary">TestDrive ?</a>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#consultationModal" class="btn btn-outline">Konsultasi ?</a>
                            </div>

                            <div class="social-links">
                                <a target="_blank" href="{{ $profile->wa_url }}"><i class="bi bi-whatsapp"></i></a>
                                <a target="_blank" href="{{ $profile->ig_url }}"><i class="bi bi-instagram"></i></a>
                                <a target="_blank" href="{{ $profile->fb_url }}"><i class="bi bi-facebook"></i></a>
                                <a target="_blank" href="{{ $profile->yt_url }}"><i class="bi bi-youtube"></i></a>
                                <a target="_blank" href="{{ $profile->x_url }}"><i class="bi bi-twitter-x"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                        <div class="hero-visual">
                            <div class="profile-container">
                                <div class="profile-background"></div>
                                <img src="{{ $header->image_url }}" alt="Alexander Chen" class="profile-image">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section><!-- /Hero Section -->
    @push('css')
    @endpush


    <section id="about" class="about section">

        <div class="container aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">

            <div class="row">
                <div class="col-lg-5 aos-init aos-animate" data-aos="zoom-in" data-aos-delay="200">
                    <div class="profile-card">
                        <div class="profile-header">
                            <div class="profile-image">
                                <img src="{{ $profile->image_url }}" alt="{{ $profile->name }}" class="img-fluid">
                            </div>
                            <div class="profile-badge">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                        </div>

                        <div class="profile-content">
                            <h3>{{ $profile->name }}</h3>
                            <p class="profession">{{ $profile->job_title }}</p>

                            <div class="contact-links">
                                <a href="{{ $profile->phone_url }}" class="contact-item">
                                    <i class="bi bi-telephone"></i>
                                    {{ $profile->phone }}
                                </a>
                                <a href="{{ $profile->wa_url }}" class="contact-item">
                                    <i class="bi bi-whatsapp"></i>
                                    {{ $profile->wa }}
                                </a>
                                <a href="mailto:{{ $profile->email }}" class="contact-item">
                                    <i class="bi bi-envelope"></i>
                                    {{ $profile->email }}
                                </a>
                                <a href="{{ $profile->address_url }}" class="contact-item">
                                    <i class="bi bi-geo-alt"></i>
                                    {{ $profile->address }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 aos-init aos-animate" data-aos="fade-left" data-aos-delay="300">
                    <div class="about-content">
                        <div class="section-header">
                            <span class="badge-text">Get to Know Me</span>
                            <h2>{{ $profile->title }}</h2>
                        </div>

                        <div class="description">
                            {!! $profile->bio !!}
                        </div>

                        <div class="stats-grid">

                            <div class="stat-item">
                                <span class="stat-number">
                                    <span class="purecounter" data-purecounter-start="0" data-purecounter-end="{{ $profile->project_number }}" data-purecounter-duration="1">
                                    </span>+</span>
                                <div class="stat-label">Delivery Order</div>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">
                                    <span class="purecounter" data-purecounter-start="0" data-purecounter-end="{{ $profile->client_number }}" data-purecounter-duration="1"></span>%</span>
                                <div class="stat-label">Kepuasan Pelanggan</div>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">
                                    <span class="purecounter" data-purecounter-start="0" data-purecounter-end="{{ $profile->experience_number }}" data-purecounter-duration="1"></span>+</span>
                                <div class="stat-label">Tahun Pengalaman</div>
                            </div>

                        </div>



                        <div class="cta-section">
                            <a href="{{ route('testdrive.show') }}" class="btn btn-primary">
                                <i class="bi bi-car-front"></i>
                                TestDrive ?
                            </a>
                            <a href="{{ $profile->wa_url }}" target="_blank" class="btn btn-outline">
                                <i class="bi bi-whatsapp"></i>
                                Yuk Ngobrol ?
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
    <section id="promo-list" class="promo-list section">
        <div class="container section-title" data-aos="fade-up" data-builder="section-title">
            <h2>Promo Spesial {{ config('settings.site_brand') }} Bulan Ini</h2>
            <p>Dapatkan penawaran terbaik, cicilan ringan, dan bonus menarik khusus untuk Anda</p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            @if ($promos->isEmpty())
                <div class="promo-empty" data-aos="fade-up">
                    <div class="promo-empty-icon"><i class="bi bi-tags"></i></div>
                    <h3>Belum ada promo aktif</h3>
                    <p>Pantau terus halaman ini — penawaran terbaik {{ config('settings.site_brand') }} akan segera hadir.</p>
                    <a href="{{ route('testdrive.show') }}" class="btn btn-primary">Jadwalkan Test Drive</a>
                </div>
            @else
                <div class="row g-4">
                    @foreach ($promos as $index => $promo)
                        @php
                            $promoWaText = 'Halo, saya tertarik dengan promo "' . $promo->promo . '". Boleh minta info lebih lanjut?';
                            $promoWaLink = 'https://wa.me/' . $profile->wa_formatted . '?text=' . urlencode($promoWaText);
                            $isFeatured = $index === 0 && $promos->count() > 1;
                            $daysLeft = $promo->days_left;
                            $isUrgent = $daysLeft !== null && $daysLeft <= 2;
                            // Progress bar: anggap 30 hari sebagai penuh, clamp 0–100
                            $progress = null;
                            if ($daysLeft !== null) {
                                $progress = max(8, min(100, (int) round(($daysLeft / 30) * 100)));
                            }
                        @endphp

                        <div class="{{ $isFeatured ? 'col-12' : 'col-lg-4 col-md-6' }}" data-aos="fade-up" data-aos-delay="{{ 100 + $index * 50 }}">
                            <article class="promo-list-card {{ $isFeatured ? 'is-featured' : '' }} {{ $isUrgent ? 'is-urgent-card' : '' }}">
                                <div class="promo-image">
                                    <img src="{{ $promo->promo_image_url }}" alt="{{ $promo->promo }}" class="img-fluid" loading="lazy">
                                    <div class="promo-image-overlay"></div>

                                    <div class="promo-category {{ $isUrgent ? 'is-urgent' : '' }}">
                                        <i class="bi bi-clock{{ $isUrgent ? '-fill' : '' }}"></i>
                                        @if ($daysLeft === null)
                                            {{ $promo->effective_status }}
                                        @elseif ($daysLeft <= 0)
                                            Hari Terakhir!
                                        @else
                                            {{ $daysLeft }} Hari Lagi
                                        @endif
                                    </div>

                                    @if ($isFeatured)
                                        <span class="promo-featured-tag"><i class="bi bi-stars"></i> Promo Utama</span>
                                    @endif
                                </div>

                                <div class="promo-info">
                                    <div class="promo-info-top">
                                        <h3>{{ $promo->promo }}</h3>
                                        <div class="promo-meta">
                                            <span><i class="bi bi-calendar3"></i> Berlaku sampai {{ $promo->effective_format ?? '—' }}</span>
                                        </div>
                                        <p>{{ $promo->desc_limit }}</p>

                                        @if ($progress !== null)
                                            <div class="promo-deadline" aria-hidden="true">
                                                <div class="promo-deadline-bar">
                                                    <span style="width: {{ $progress }}%"></span>
                                                </div>
                                                <small>
                                                    @if ($daysLeft <= 0)
                                                        Segera berakhir
                                                    @else
                                                        Masih {{ $daysLeft }} hari tersisa
                                                    @endif
                                                </small>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="promo-actions">
                                        <button type="button" class="btn-details" data-bs-toggle="modal" data-bs-target="#promoModal" data-title="{{ $promo->promo }}" data-image="{{ $promo->promo_image_url }}" data-date="{{ $promo->effective_format }}" data-desc="{{ $promo->desc }}" data-wa="{{ $promoWaLink }}">
                                            Detail Promo
                                        </button>
                                        <a href="{{ $promoWaLink }}" target="_blank" rel="noopener" class="btn-purchase">
                                            <i class="bi bi-whatsapp"></i> Ambil Promo
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Modal Detail Promo (satu modal untuk semua kartu, diisi lewat JS) --}}
    <div class="modal fade" id="promoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content promo-modal-content">
                <button type="button" class="btn-close promo-modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="row g-0">
                    <div class="col-md-5">
                        <div class="promo-modal-image">
                            <img id="promoModalImage" src="" alt="">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="promo-modal-body">
                            <span class="promo-modal-eyebrow"><i class="bi bi-calendar3"></i> Berlaku sampai <span id="promoModalDate"></span></span>
                            <h5 class="modal-title" id="promoModalTitle">Detail Promo</h5>
                            <div id="promoModalDesc" class="promo-modal-desc"></div>
                            <a href="#" id="promoModalWa" target="_blank" rel="noopener" class="btn btn-primary promo-modal-cta">
                                <i class="bi bi-whatsapp"></i> Ambil Promo Ini
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function() {
            var promoModal = document.getElementById('promoModal');
            if (!promoModal) return;
            promoModal.addEventListener('show.bs.modal', function(event) {
                var btn = event.relatedTarget;
                if (!btn) return;
                document.getElementById('promoModalTitle').textContent = btn.getAttribute('data-title') || '';
                document.getElementById('promoModalImage').src = btn.getAttribute('data-image') || '';
                document.getElementById('promoModalImage').alt = btn.getAttribute('data-title') || '';
                document.getElementById('promoModalDate').textContent = btn.getAttribute('data-date') || '-';
                document.getElementById('promoModalDesc').innerHTML = btn.getAttribute('data-desc') || '';
                document.getElementById('promoModalWa').href = btn.getAttribute('data-wa') || '#';
            });
        })();
    </script>

    <section id="product-cards" class="product-list-cards section">
        <div class="container section-title" data-aos="fade-up" data-builder="section-title">
            <h2>Drive Your Future with {{ config('settings.site_brand') }}</h2>
            <p>Rasakan kenyamanan, performa, dan kebanggaan memiliki mobil {{ config('settings.site_brand') }} terbaru</p>
        </div>
        <slot type="section-title"></slot>

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row g-4">
                @foreach ($products as $product)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="product-list-card bg-white rounded shadow-sm h-100">
                            <div class="product-list-content">
                                <a href="{{ route('product.detail', $product->slug) }}" class="text-decoration-none">
                                    <h2 class="product-list-title">{{ $product->name }}</h2>
                                    @if ($product->tagline)
                                        <p class="product-list-subtitle">{{ Str::limit($product->tagline, 60) }}</p>
                                    @endif
                                    <h1 class="product-list-hero text-uppercase">{{ $product->hero_name }}</h1>
                                    <div class="product-list-image">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid" loading="lazy">
                                    </div>
                                    <div class="product-list-footer d-flex justify-content-between align-items-end">
                                        <div class="shop-now">Mulai dari <i class="bi bi-arrow-right"></i></div>
                                        <div class="text-end">
                                            @if ($product->disc > 0)
                                                <div class="badge-discount">Hemat Rp {{ number_format($product->disc) }}</div>
                                            @endif
                                            <span class="price fw-bold">{{ $product->min_price }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section id="call-to-action" class="call-to-action section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row justify-content-center position-relative">
                <div class="col-lg-10 text-center">
                    <!-- Scribble decorations -->
                    <div class="scribble scribble-1" data-aos="fade-down" data-aos-delay="200"></div>
                    <div class="scribble scribble-2" data-aos="fade-up" data-aos-delay="300"></div>
                    <div class="scribble scribble-3" data-aos="fade-right" data-aos-delay="400"></div>

                    <h2 class="display-4 mb-4 builder-editable-editing">Siap Bantu Anda Wujudkan Mobil Impian</h2>
                    <p class="lead mb-5">Hubungi saya untuk konsultasi gratis seputar mobil {{ config('settings.site_brand') }} terbaru. Dapatkan
                        informasi promo, cicilan ringan, dan proses cepat tanpa ribet..</p>

                    <div class="cta-buttons" data-aos="zoom-in" data-aos-delay="500">
                        <a href="#" class="btn btn-primary btn-lg me-3">Hubungi Sakarang !!</a>
                        <a href="#" class="btn btn-outline-primary btn-lg">Cek Promo Lainnya</a>
                    </div>
                </div>
            </div>

        </div>

    </section>

    <!-- Services Section -->
    <section id="services" class="services section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Kenapa Harus Memilih Saya Sebagai Sales {{ config('settings.site_brand') }} Anda?</h2>
            <p>Saya percaya membeli mobil bukan hanya soal transaksi, tapi tentang kepercayaan, kenyamanan, dan pengalaman
                terbaik untuk Anda.</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="service-header">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <div class="service-intro">
                            <h2 class="service-heading">
                                <div>Solusi Lengkap untuk Beli Mobil {{ config('settings.site_brand') }}</div>
                            </h2>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="service-summary">
                            <p>
                                Saya selalu berkomitmen memberikan layanan menyeluruh untuk memastikan Anda mendapatkan
                                mobil {{ config('settings.site_brand') }} impian dengan pengalaman pembelian yang mudah, cepat, dan menyenangkan.
                            </p>
                            <a href="" class="service-btn">
                                View All Products
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                @foreach ($services as $service)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-card position-relative z-1">
                            <div class="service-icon">
                                <i class="bi {{ $service->icon }}"></i>
                            </div>
                            <span class="card-action d-flex align-items-center justify-content-center rounded-circle">
                                <i class="bi bi-check-lg"></i>
                            </span>
                            <h3>
                                <span>
                                    {{ $service->title }}
                                </span>
                            </h3>
                            <p>{{ $service->desc }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section><!-- /Services Section -->

    <section id="testimonials-2" class="testimonials-2 section">

        <div class="container section-title" data-aos="fade-up" data-builder="section-title">
            <h2>Cerita dari Hati Pelanggan</h2>
            <p>“Setiap mobil baru bukan hanya kendaraan, tapi awal perjalanan
                penuh cerita bersama keluarga tercinta.”</p>
        </div>
        <slot type="section-title"></slot>

        <div class="container" data-aos="fade-up" data-aos-delay="100" data-no-editable="true">
            <div class="swiper init-swiper">
                <div class="swiper-wrapper">
                    @foreach ($testimonies as $testimony)
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="row gy-4 justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="testimonial-content">
                                            <p>
                                                <i class="bi bi-quote quote-icon-left"></i>
                                                <span>{{ $testimony->message }}</span>
                                                <i class="bi bi-quote quote-icon-right"></i>
                                            </p>
                                            <h3>{{ $testimony->name }}</h3>
                                            <h4>{{ $testimony->job }}</h4>
                                            <div class="stars" data-value="{{ $testimony->rating }}"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 text-center">
                                        <img src="{{ $testimony->image_url }}" class="img-fluid w-50 w-md-50 w-lg-100 testimonial-img" alt="{{ $testimony->name }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>

                <!-- Config -->
                <script type="application/json" class="swiper-config">
                {
                "loop": true,
                "speed": 600,
                "autoplay": {
                  "delay": 5000,
                  "disableOnInteraction": false
                },
                "slidesPerView": 1,
                "pagination": {
                  "el": ".swiper-pagination",
                  "type": "bullets",
                  "clickable": true
                }
                
              }
            </script>
            </div>

        </div>

    </section>

    <section id="portfolio" class="portfolio section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Awal Perjalanan Baru</h2>
            <p>“Mobil baru bukan sekadar kendaraan, tapi langkah pertama menuju cerita hidup yang lebih seru.”</p>
        </div><!-- End Section Title -->
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
                <div class="row">
                    <div class="col-lg-3 filter-sidebar">
                        <div class="filters-wrapper" data-aos="fade-right" data-aos-delay="150">
                            <ul class="portfolio-filters isotope-filters">
                                <li data-filter="*" class="filter-active">All Photo Delivery</li>
                                @foreach ($deliveriesByProduct as $product)
                                    <li data-filter=".delivery-{{ $product->slug }}"> {{ $product->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row gy-4 portfolio-container isotope-container">
                            @foreach ($deliveries as $delivery)
                                <div class="col-6 col-lg-4 col-md-4 portfolio-item isotope-item delivery-{{ $delivery->product->slug }}">
                                    <div class="portfolio-wrap">
                                        <img src="{{ $delivery->image_thumb_url }}" class="img-fluid" alt="">
                                        <div class="portfolio-info">
                                            <div class="content">
                                                <span class="category">{{ $delivery->product->name }}</span>
                                                {{-- <h4>Capturing Moments</h4> --}}
                                                <div class="portfolio-links">
                                                    <a href="{{ $delivery->image_url }}" class="glightbox"><i class="bi bi-arrows-fullscreen"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End Portfolio Item -->
                            @endforeach
                        </div><!-- End Portfolio Container -->
                    </div>
                </div>

            </div>

        </div>

    </section><!-- /Portfolio Section -->
    <section id="gallery" class="gallery section">

        <div class="container section-title">
            <h2>Kisah di Balik Roda</h2>
            <p>Potret pengalaman nyata bersama mobil impian pelanggan</p>
        </div>
        <slot type="section-title"></slot>

        <div class="container">

            <div class="gallery-carousel swiper init-swiper swiper-initialized swiper-horizontal swiper-backface-hidden">
                <script type="application/json" class="swiper-config">
                {
            "loop": true,
            "speed": 600,
            "autoplay": {
              "delay": 3000
            },
            "slidesPerView": 1,
            "spaceBetween": 20,
            "centeredSlides": true,
            "breakpoints": {
              "576": {
                "slidesPerView": 2,
                "centeredSlides": false
              },
              "768": {
                "slidesPerView": 3,
                "centeredSlides": false
              },
              "992": {
                "slidesPerView": 4,
                "centeredSlides": false
              },
              "1200": {
                "slidesPerView": 5,
                "centeredSlides": false
              }
            }
          }
            </script>
                <div class="swiper-wrapper">
                    @foreach ($galleries as $gallery)
                        <div class="swiper-slide">
                            <div class="gallery-item">
                                <img src="{{ $gallery->getUrl() }}" alt="Grand Ballroom Setup" class="img-fluid" loading="lazy">
                                <a href="{{ $gallery->getUrl() }}" class="gallery-overlay glightbox">
                                    <i class="bi bi-arrows-fullscreen"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>

            <div class="text-center mt-5">
                <a href="gallery.html" class="btn btn-gallery">
                    <i class="bi bi-collection me-2"></i>Discover Our Full Gallery
                </a>
            </div>

        </div>

    </section>
    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Saatnya Punya Mobil Baru!</h2>
            <p>"Jangan tunggu besok. Hubungi saya hari ini dan dapatkan penawaran terbaik {{ config('settings.site_brand') }} khusus untuk Anda."</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row g-4 g-lg-5">
                <div class="col-lg-5">
                    <div class="info-box">
                        <h3>Contact Info</h3>
                        <p>“Yuk, hubungi saya untuk info promo, konsultasi, atau test drive. Siap bantu cari mobil {{ config('settings.site_brand') }}
                            yang cocok buat Anda!”</p>

                        <div class="info-item">
                            <div class="icon-box">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="content">
                                <h4>Alamat Dealer Kami</h4>
                                <p>{{ $profile->address }}</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="icon-box">
                                <i class="bi bi-whatsapp"></i>
                            </div>
                            <div class="content">
                                <h4>Whatsapp</h4>
                                <p>{{ $profile->wa }}</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="icon-box">
                                <i class="bi bi-phone"></i>
                            </div>
                            <div class="content">
                                <h4></h4>
                                <p>{{ $profile->phone }}</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="icon-box">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div class="content">
                                <h4>Email Address</h4>
                                <p>{{ $profile->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="contact-form">
                        <h3>Hubungi Sekarang !!</h3>
                        <p>Siap bantu Anda menemukan mobil {{ config('settings.site_brand') }} impian. Konsultasi gratis, cepat, dan tanpa ribet.</p>
                        <div id="card-contact">
                            <form action="{{ route('contact.store') }}" id="form-contact" method="post">
                                @csrf
                                <div class="row gy-4">

                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama">
                                        <div class="invalid-feedback" id="error-name"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="wa" name="wa" placeholder="Nomor Whatsapp">
                                        <div class="invalid-feedback" id="error-wa"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                                        <div class="invalid-feedback" id="error-email"></div>
                                    </div>

                                    <div class="col-12">
                                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject">
                                        <div class="invalid-feedback" id="error-subject"></div>
                                    </div>

                                    <div class="col-12">
                                        <textarea class="form-control" id="message" name="message" rows="6" placeholder="Message"></textarea>
                                        <div class="invalid-feedback" id="error-message"></div>
                                    </div>

                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @push('script')
                            <script>
                                $(function() {
                                    $("#form-contact").on('submit', function(e) {
                                        e.preventDefault();

                                        let form = $(this);
                                        let formData = new FormData(this);

                                        // clear error dulu
                                        form.find('.form-control').removeClass('is-invalid');
                                        form.find('.invalid-feedback').text('');
                                        cardProgress('#card-contact');

                                        $.ajax({
                                            url: form.attr('action'),
                                            method: form.attr('method'),
                                            data: formData,
                                            processData: false,
                                            contentType: false,
                                            dataType: 'json',
                                            success: function(data) {
                                                if (data.status == 0) {
                                                    $.each(data.errors, function(key, val) {
                                                        $("#" + key).addClass('is-invalid'); // tambahkan bootstrap class
                                                        $("#error-" + key).text(val[0]); // tampilkan pesan error
                                                    });
                                                    cardProgressDismiss('#card-contact');
                                                } else {
                                                    form[0].reset();
                                                    cardProgressDismiss('#card-contact');
                                                    swalGlass({
                                                        title: 'Berhasil!',
                                                        html: 'Terimakasih telah mengisi form kontak kami, <i class="d-block mt-2 white">Ingin melanjutkan konfirmasi melalui WhatsApp agar proses lebih cepat?</i>',
                                                        icon: 'success',
                                                        cancelButtonText: 'Nanti saja',
                                                        confirmButtonText: 'Ya, Kirim ke WhatsApp',
                                                        showCancelButton: true
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            window.open(data.url, '_blank');
                                                        }
                                                    });
                                                }
                                            }
                                        });
                                    });
                                });
                            </script>
                        @endpush

                    </div>
                </div>

            </div>

        </div>

    </section><!-- /Contact Section -->
@endsection
