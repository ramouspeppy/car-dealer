<!DOCTYPE html>
<html lang="id" data-theme="light" class="landing-v1-page">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seo['title'] }}</title>
    <meta name="description" content="{{ $seo['description'] }}">
    <meta name="keywords" content="{{ $seo['keywords'] }}">
    <meta name="robots" content="{{ $seo['robots'] }}"> {{-- landing page iklan, tidak perlu diindex Google Search --}}
    <link rel="canonical" href="{{ $seo['canonical_url'] }}">

    {{-- Open Graph, penting untuk preview link di iklan Meta/WhatsApp --}}
    <meta property="og:title" content="{{ $seo['title'] }}">
    <meta property="og:description" content="{{ $seo['description'] }}">
    <meta property="og:site_name" content="{{ $seo['site_name'] }}">
    <meta property="og:locale" content="{{ $seo['locale'] }}">
    <meta property="og:image" content="{{ $seo['image'] }}">
    <meta property="og:image:alt" content="{{ $seo['title'] }}">
    <meta property="og:type" content="{{ $seo['type'] }}">
    <meta property="og:url" content="{{ $seo['canonical_url'] }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo['title'] }}">
    <meta name="twitter:description" content="{{ $seo['description'] }}">
    <meta name="twitter:image" content="{{ $seo['image'] }}">

    <link href="{{ $seo['favicon'] }}" rel="icon">
    <link href="{{ $seo['favicon'] }}" rel="shortcut icon">

    {{-- Font sama persis dengan situs utama --}}
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    {{-- CSS yang sama dipakai situs utama, supaya semua komponen (.hero, .services, .promo-list, dst) otomatis konsisten --}}
    <link rel="stylesheet" href="{{ mix('frontend/css/app.css') }}">

    {{-- Tracking script dari admin (Google Tag / Meta Pixel) --}}
    {!! $landingPage->tracking_head_script !!}

    @include('frontend.layouts._tracking')

</head>

<body class="index-page landing-v1-page">

    @if (filled($profile->wa))
        {{-- Floating WhatsApp Button (persis sama dengan situs utama) --}}
        <a href="{{ $profile->wa_url }}" target="_blank" class="floating-wa" aria-label="Chat WhatsApp">
            <div class="floating-wa-icon">
                <i class="bi bi-whatsapp"></i>
            </div>
            <div class="floating-wa-text">Chat Kami</div>
        </a>
    @endif

    {{-- HERO --}}
    <section id="hero" class="hero section lp-hero" style="min-height: auto; padding: 100px 0 70px;">
        <div class="background-elements">
            <div class="bg-circle circle-1"></div>
            <div class="bg-circle circle-2"></div>
        </div>
        <div class="hero-content">
            <div class="container">
                <div class="lp-page-header">
                    <a href="{{ url('/') }}" class="lp-page-brand">
                        @if ($seo['logo'] !== '')
                            <img src="{{ $seo['logo'] }}" alt="{{ $profile->name ?? $seo['site_name'] }}">
                        @else
                            <span>{{ $seo['site_name'] }}</span>
                        @endif
                        <span class="lp-page-brand-copy">
                            <span>{{ $navData['name'] }}</span>
                            <span class="lp-page-brand-site">{{ $navData['site_name'] }}</span>
                        </span>
                    </a>
                    <div class="lp-page-socials" aria-label="Media sosial">
                        @foreach ($navData['social_links'] as $social)
                            <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social['name'] }}">
                                <i class="bi {{ $social['icon'] }}" aria-hidden="true"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                        <div class="hero-text">
                            @if ($landingPage->hero_badge)
                                <span class="lp-hero-badge"><i class="bi bi-stars"></i> {{ $landingPage->hero_badge }}</span>
                            @endif
                            <h1 style="font-size: 46px;">{{ $landingPage->headline }}</h1>
                            @if ($landingPage->subheadline)
                                <p class="description">{{ $landingPage->subheadline }}</p>
                            @endif
                            <div class="hero-actions">
                                <a href="#lead-form" class="btn btn-primary">
                                    <i class="bi bi-chat-dots me-1"></i> {{ $landingPage->hero_cta_label ?: 'Konsultasi Sekarang' }}
                                </a>
                                <a href="{{ $profile->wa_url }}" target="_blank" rel="noopener" class="btn btn-outline">
                                    <i class="bi bi-whatsapp me-1"></i> Chat WhatsApp
                                </a>
                                @if ($products->first())
                                    <a href="#promo-list" class="btn btn-outline">
                                        <i class="bi bi-car-front me-1"></i> Lihat Pilihan Mobil
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                        <div class="hero-visual">
                            <div class="profile-container">
                                <div class="profile-background"></div>
                                @if ($landingPage->hero_image_url)
                                    <img src="{{ $landingPage->hero_image_url }}" alt="{{ $landingPage->headline }}" class="profile-image">
                                @elseif($products->first())
                                    <img src="{{ $products->first()->image_url }}" alt="{{ $landingPage->headline }}" class="profile-image product-photo-fallback">
                                @else
                                    <div class="lp-hero-placeholder">
                                        <i class="bi bi-car-front-fill"></i>
                                        <span>Temukan mobil yang tepat untuk Anda</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($profile && ($profile->name || $profile->image_url || $profile->bio || $profile->job_title))
        <section class="lp-profile-section">
            <div class="container">
                <div class="lp-profile-card {{ $profile->image_url ? '' : 'lp-profile-card-no-photo' }}" data-aos="fade-up">
                    @if ($profile->image_url)
                        <div class="lp-profile-photo">
                            <img src="{{ $profile->image_url }}" alt="{{ $profile->name ?: 'Profil sales' }}" loading="lazy">
                        </div>
                    @endif
                    <div class="lp-profile-copy">
                        <span class="lp-profile-kicker">Pendamping Anda</span>
                        <h2>{{ $profile->name }}</h2>
                        @if ($profile->job_title)
                            <p class="lp-profile-role">{{ $profile->job_title }}</p>
                        @endif
                        @if ($profile->bio)
                            <div class="lp-profile-bio">{!! $profile->bio !!}</div>
                        @else
                            <p class="lp-profile-bio">Siap membantu Anda memilih mobil yang sesuai kebutuhan dan menjawab pertanyaan seputar pembelian.</p>
                        @endif
                        <a href="{{ $profile->wa_url }}" target="_blank" rel="noopener" class="lp-profile-cta">
                            <i class="bi bi-whatsapp"></i> Kenali & Hubungi Saya
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- TRUST BADGES --}}
    @if (!empty($landingPage->trust_badges))
        <div class="lp-trust-bar">
            <div class="container d-flex flex-wrap justify-content-center gap-4">
                @foreach ($landingPage->trust_badges as $badge)
                    <span class="lp-trust-item"><i class="bi bi-patch-check-fill"></i> {{ $badge }}</span>
                @endforeach
            </div>
        </div>
    @endif

    {{-- USP --}}
    @if (!empty($landingPage->usp_items))
        <section id="services" class="services section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Kenapa Beli Mobil di Sini?</h2>
                <p>Alasan pelanggan percaya untuk membeli mobil bersama kami</p>
            </div>
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row justify-content-center g-4">
                    @foreach ($landingPage->usp_items as $item)
                        <div class="col-lg-4 col-md-6">
                            <div class="service-card position-relative z-1">
                                <div class="service-icon">
                                    <i class="{{ $item['icon'] ?? 'bi bi-check-circle' }}"></i>
                                </div>
                                <span class="card-action d-flex align-items-center justify-content-center rounded-circle">
                                    <i class="bi bi-check-lg"></i>
                                </span>
                                <h3><span>{{ $item['title'] ?? '' }}</span></h3>
                                <p>{{ $item['desc'] ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- PRODUK UNGGULAN --}}
    @if ($products->count())
        <section id="promo-list" class="promo-list section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Pilihan Mobil Terbaik untuk Anda</h2>
                <p>Stok terbatas, harga bisa berubah sewaktu-waktu mengikuti promo yang sedang berjalan</p>
            </div>
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">
                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="promo-list-card product-photo-card">
                                <div class="product-photo-badges">
                                    <div class="promo-category"><i class="bi bi-car-front-fill"></i> {{ $product->product_category->category ?? 'Mobil' }}</div>
                                    <div class="promo-image-badge {{ $product->disc > 0 ? 'is-promo' : '' }}">
                                        <i class="bi {{ $product->disc > 0 ? 'bi-tag-fill' : 'bi-stars' }}"></i>
                                        {{ $product->disc > 0 ? 'Hemat ' . $product->discount_short : 'Unit Pilihan' }}
                                    </div>
                                </div>
                                <div class="promo-image">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid">

                                </div>
                                <div class="promo-info">
                                    <h3>{{ $product->name }}</h3>
                                    <div class="promo-meta">
                                        <span><i class="bi bi-tag"></i> Mulai
                                            @if ($product->disc > 0)
                                                <s>{{ $product->min_price }}</s> {{ $product->special_min_price }}
                                            @else
                                                {{ $product->min_price }}
                                            @endif
                                        </span>
                                    </div>
                                    @if ($product->tagline)
                                        {!! $product->tagline !!}
                                    @endif
                                    <div class="promo-actions">
                                        <a href="{{ route('product.detail', $product->slug) }}" class="btn-details">Lihat Detail</a>
                                        <a href="#lead-form" class="btn-purchase lp-pilih-produk" data-product-id="{{ $product->id }}">Tanya Harga</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- PROMO BANNER --}}
    @if ($promo)
        <section id="call-to-action" class="call-to-action section light-background">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row justify-content-center position-relative">
                    <div class="col-lg-10 text-center">
                        <div class="scribble scribble-1"></div>
                        <div class="scribble scribble-2"></div>
                        <div class="scribble scribble-3"></div>

                        <h2 class="display-6 mb-3">{{ $promo->promo }}</h2>
                        @if ($promo->desc ?? null)
                            <p class="lead mb-4">{{ Str::limit(strip_tags($promo->desc), 150) }}</p>
                        @endif

                        <div class="cta-buttons">
                            <a href="#lead-form" class="btn btn-primary btn-lg">Klaim Promo Ini</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- TESTIMONI --}}
    @if ($testimonies->count())
        <section id="testimonials-2" class="testimonials-2 section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Kata Mereka yang Sudah Beli</h2>
                <p>Cerita nyata dari pelanggan yang sudah membawa pulang mobil impiannya</p>
            </div>
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper init-swiper">
                    <script type="application/json" class="swiper-config">
                    {
                        "loop": true,
                        "speed": 600,
                        "autoplay": { "delay": 5000, "disableOnInteraction": false },
                        "slidesPerView": 1,
                        "pagination": { "el": ".swiper-pagination", "type": "bullets", "clickable": true }
                    }
                </script>
                    <div class="swiper-wrapper">
                        @foreach ($testimonies as $testimony)
                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <div class="row gy-4 justify-content-center">
                                        <div class="col-lg-6">
                                            <div class="testimonial-content">
                                                <p>
                                                    <i class="bi bi-quote quote-icon-left"></i>
                                                    <span>{{ $testimony->message ?? ($testimony->testimony ?? '') }}</span>
                                                    <i class="bi bi-quote quote-icon-right"></i>
                                                </p>
                                                <h3>{{ $testimony->name }}</h3>
                                                @if ($testimony->job ?? null)
                                                    <h4>{{ $testimony->job }}</h4>
                                                @endif
                                                <div class="stars" data-value="{{ $testimony->rating ?? 5 }}"></div>
                                            </div>
                                        </div>
                                        @if ($testimony->image_url ?? null)
                                            <div class="col-lg-2 text-center">
                                                <img src="{{ $testimony->image_url }}" class="img-fluid w-50 w-md-50 w-lg-100 testimonial-img" alt="{{ $testimony->name }}">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
    @endif

    {{-- FAQ --}}
    @if (!empty($landingPage->faqs))
        <section class="section light-background">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="section-title" data-aos="fade-up">
                            <h2>Pertanyaan yang Sering Ditanyakan</h2>
                        </div>
                        <div class="accordion lp-faq" id="lpFaqAccordion" data-aos="fade-up" data-aos-delay="100">
                            @foreach ($landingPage->faqs as $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $loop->index }}">
                                            {{ $faq['question'] ?? '' }}
                                        </button>
                                    </h2>
                                    <div id="faq{{ $loop->index }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#lpFaqAccordion">
                                        <div class="accordion-body">
                                            {{ $faq['answer'] ?? '' }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- FORM LEAD --}}
    <section id="lead-form" class="contact section">
        <div class="container section-title" data-aos="fade-up">
            <h2>{{ $landingPage->form_title ?: 'Konsultasi Gratis Sekarang' }}</h2>
            <p>{{ $landingPage->form_subtitle ?: 'Isi data di bawah, tim kami akan segera menghubungi Anda via WhatsApp' }}</p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row g-4 g-lg-5">
                <div class="col-lg-5">
                    <div class="info-box">
                        <h3>Kenapa Konsultasi di Sini?</h3>
                        <p>Tanpa paksaan, tim kami bantu carikan mobil dan simulasi cicilan yang paling pas untuk Anda.</p>

                        <div class="info-item">
                            <div class="icon-box"><i class="bi bi-lightning-charge"></i></div>
                            <div class="content">
                                <h4>Respon Cepat</h4>
                                <p>Dibalas kurang dari 1 jam</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="icon-box"><i class="bi bi-calculator"></i></div>
                            <div class="content">
                                <h4>Simulasi Cicilan</h4>
                                <p>Dibantu hitungkan sesuai budget Anda</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="icon-box"><i class="bi bi-shield-check"></i></div>
                            <div class="content">
                                <h4>100% Gratis</h4>
                                <p>Konsultasi tanpa biaya apapun</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="contact-form">
                        <h3>Isi Data Diri Anda</h3>
                        <p>Tim kami akan menghubungi Anda melalui WhatsApp secepatnya.</p>
                        <div id="lp-form-alert"></div>
                        <form id="lp-lead-form">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="phone" class="form-control" placeholder="No. WhatsApp (08xxxxxxxxxx)" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="city" class="form-control" placeholder="Kota">
                                </div>
                                <div class="col-md-6">
                                    <select name="product_id" id="lp-product-select" class="form-select">
                                        <option value="">Mobil yang diminati (bebas)</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <textarea name="message" class="form-control" rows="4" placeholder="Pesan (opsional), contoh: mau tanya simulasi kredit DP 20 juta"></textarea>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn" id="lp-submit-btn">
                                        <i class="bi bi-send-fill"></i> Kirim &amp; Chat WhatsApp
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="lp-footer">
        <div class="container">
            &copy; {{ $seo['year'] }} <strong>{{ $profile->name ?? $seo['site_name'] }}</strong>. Semua hak dilindungi.
            @if ($profile->phone ?? null)
                &bull; {{ $profile->phone }}
            @endif
        </div>
    </footer>

    {{-- Sticky CTA bar (mobile) --}}
    <div class="lp-sticky-bar">
        <a href="tel:{{ $profile->phone ?? '' }}" class="lp-btn-call"><i class="bi bi-telephone-fill me-1"></i> Telepon</a>
        <a href="{{ $profile->wa_url }}" target="_blank" class="lp-btn-wa"><i class="bi bi-whatsapp me-1"></i> WhatsApp</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ mix('frontend/js/app.js') }}"></script>
    <script>
        (function() {
            // Ambil parameter UTM & click id dari URL iklan (Google Ads / Meta Ads)
            const params = new URLSearchParams(window.location.search);
            const utmFields = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid', 'fbclid'];
            const utmData = {};
            utmFields.forEach(function(key) {
                utmData[key] = params.get(key) || sessionStorage.getItem('lp_' + key) || '';
                if (params.get(key)) sessionStorage.setItem('lp_' + key, params.get(key));
            });

            // Klik "Tanya Harga" di kartu produk -> pilih produknya di form
            document.querySelectorAll('.lp-pilih-produk').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const select = document.getElementById('lp-product-select');
                    if (select) select.value = this.dataset.productId;
                });
            });

            const form = document.getElementById('lp-lead-form');
            const alertBox = document.getElementById('lp-form-alert');
            const submitBtn = document.getElementById('lp-submit-btn');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Mengirim...';
                alertBox.innerHTML = '';

                const formData = new FormData(form);
                Object.keys(utmData).forEach(function(key) {
                    formData.append(key, utmData[key]);
                });
                formData.append('landing_url', window.location.href);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('{{ route('landing.lead.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                    .then(function(res) {
                        return res.json().then(function(data) {
                            return {
                                status: res.status,
                                data: data
                            };
                        });
                    })
                    .then(function(result) {
                        if (result.status === 200 && result.data.status === 'success') {
                            alertBox.innerHTML = '<div class="alert alert-success">' + result.data.message + '</div>';
                            form.reset();

                            // Jalankan event konversi iklan (Google Ads / Meta Ads) kalau diisi admin
                            try {
                                {!! $landingPage->tracking_conversion_script !!}
                            } catch (err) {}

                            window.open(result.data.wa_text, '_blank');
                        } else {
                            const errors = result.data.errors || {};
                            const firstError = Object.values(errors)[0];
                            alertBox.innerHTML = '<div class="alert alert-danger">' + (firstError ? firstError[0] : 'Terjadi kesalahan, silakan coba lagi.') + '</div>';
                        }
                    })
                    .catch(function() {
                        alertBox.innerHTML = '<div class="alert alert-danger">Gagal mengirim, periksa koneksi internet Anda.</div>';
                    })
                    .finally(function() {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="bi bi-send-fill"></i> Kirim & Chat WhatsApp';
                    });
            });
        })();
    </script>
</body>

</html>
