<!DOCTYPE html>
<html lang="id" class="landing-v2-page">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seo['title'] }}</title>
    <meta name="description" content="{{ $seo['description'] }}">
    <meta name="keywords" content="{{ $seo['keywords'] }}">
    <meta name="robots" content="{{ $seo['robots'] }}">
    <link rel="canonical" href="{{ $seo['canonical_url'] }}">

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

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ mix('frontend/css/app.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

    {!! $landingPage->tracking_head_script !!}

    @include('frontend.layouts._tracking')

</head>

<body class="landing-v2-page">

    <div class="e-topbar">
        <a href="#" class="e-topbar-brand">
            @if ($seo['logo'] !== '')
                <img src="{{ $seo['logo'] }}" alt="{{ $profile->name ?? $seo['site_name'] }}">
            @endif
            <span class="e-topbar-brand-copy">
                <span>{{ $navData['name'] }}</span>
                <span class="e-topbar-site-name">{{ $navData['site_name'] }}</span>
            </span>
        </a>
        <div class="e-topbar-actions">
            <div class="e-topbar-socials" aria-label="Media sosial">
                @foreach ($navData['social_links'] as $social)
                    <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social['name'] }}"><i class="bi {{ $social['icon'] }}" aria-hidden="true"></i></a>
                @endforeach
            </div>
            <a href="{{ $profile->wa_url }}" target="_blank" rel="noopener noreferrer" class="e-topbar-cta"><i class="bi bi-whatsapp"></i> {{ $profile->phone ?? 'Chat Kami' }}</a>
        </div>
    </div>

    {{-- ============ HERO ============ --}}
    <section class="e-hero">
        <div class="e-hero-wash"></div>
        <div class="e-wrap e-hero-content">
            <div class="e-hero-grid">
                <div>
                    <div class="e-hero-eyebrow e-reveal"><span class="e-dot"></span> {{ $landingPage->hero_badge ?: 'Digital Showroom' }}</div>
                    <h1 class="e-reveal">{!! nl2br(e($landingPage->headline)) !!}</h1>
                    @if ($landingPage->subheadline)
                        <p class="e-hero-desc e-reveal">{{ $landingPage->subheadline }}</p>
                    @endif
                    <div class="e-hero-actions e-reveal">
                        <a href="#konsultasi" class="e-btn e-btn-gold">{{ $landingPage->hero_cta_label ?: 'Konsultasi Sekarang' }}</a>
                        @if ($featuredVehicle)
                            <a href="#spotlight" class="e-btn e-btn-line">Lihat Unit Pilihan</a>
                        @endif
                    </div>
                </div>

                @if ($heroImage)
                    <div class="e-hero-visual e-reveal">
                        <img src="{{ $heroImage }}" alt="{{ $landingPage->hero_image_url ? $landingPage->headline : $featuredVehicle->name ?? $landingPage->headline }}">
                    </div>
                @else
                    <div class="e-hero-visual e-hero-visual-empty e-reveal" aria-hidden="true">
                        <i class="bi bi-car-front-fill"></i>
                        <span>Temukan mobil yang tepat untuk Anda</span>
                    </div>
                @endif
            </div>
        </div>
        <div class="e-scroll-cue">Scroll</div>
    </section>

    {{-- ============ TRUST MARQUEE ============ --}}
    @if (!empty($landingPage->trust_badges))
        <div class="e-dark e-marquee-wrap">
            <div class="e-marquee">
                @for ($r = 0; $r < 2; $r++)
                    @foreach ($landingPage->trust_badges as $badge)
                        <span class="e-marquee-item"><i class="bi bi-gem"></i> {{ $badge }}</span>
                    @endforeach
                @endfor
            </div>
        </div>
    @endif

    @if ($profile && ($profile->name || $profile->image_url || $profile->bio || $profile->job_title))
        <section class="e-profile-section">
            <div class="e-wrap">
                <div class="e-profile-card {{ $profile->image_url ? '' : 'e-profile-card-no-photo' }} e-reveal">
                    @if ($profile->image_url)
                        <div class="e-profile-photo"><img src="{{ $profile->image_url }}" alt="{{ $profile->name ?: 'Profil sales' }}" loading="lazy"></div>
                    @endif
                    <div class="e-profile-copy">
                        <span class="e-profile-kicker">Sales pendamping Anda</span>
                        <h2>{{ $profile->name }}</h2>
                        @if ($profile->job_title)
                            <p class="e-profile-role">{{ $profile->job_title }}</p>
                        @endif
                        @if ($profile->bio)
                            <div class="e-profile-bio">{!! $profile->bio !!}</div>
                        @else
                            <p class="e-profile-bio">Saya siap membantu Anda menemukan mobil yang tepat dan mendampingi proses pembelian dari awal hingga selesai.</p>
                        @endif
                        <a href="{{ $profile->wa_url }}" target="_blank" rel="noopener" class="e-profile-cta"><i class="bi bi-whatsapp"></i> Hubungi Saya</a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ============ SERVICES (data nyata) ============ --}}
    @if ($services->count())
        <section class="e-light e-section">
            <div class="e-wrap">
                <div class="e-section-head e-reveal">
                    <span class="e-eyebrow">Layanan Kami</span>
                    <h2>Bukan cuma jual mobil, kami dampingi sampai tuntas</h2>
                </div>
                <div class="row g-4 g-lg-5">
                    @foreach ($services as $service)
                        <div class="col-md-6 col-lg-4 e-reveal">
                            <div class="e-feature">
                                <div class="e-feature-icon"><i class="bi {{ $service->icon }}"></i></div>
                                <div>
                                    <h4>{{ $service->title }}</h4>
                                    @if ($service->desc)
                                        <p class="e-muted">{{ Str::limit(strip_tags($service->desc), 110) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============ SPOTLIGHT ============ --}}
    @if ($featuredVehicle)
        <section id="spotlight" class="e-dark e-section">
            <div class="e-wrap">
                <div class="e-spotlight-grid">
                    <div class="e-spotlight-img e-reveal">
                        <img src="{{ $featuredVehicle->image_url }}" alt="{{ $featuredVehicle->name }}">
                    </div>
                    <div class="e-spotlight-text e-reveal">
                        <span class="e-spotlight-kicker">Unit Pilihan</span>
                        <h3>{{ $featuredVehicle->name }}</h3>
                        @if ($featuredVehicle->tagline)
                            <div class="e-desc e-muted">{!! $featuredVehicle->tagline !!}</div>
                        @endif

                        <div class="e-price-row">
                            @if ($featuredVehicle->disc > 0)
                                <span class="e-price-now">{{ $featuredVehicle->special_min_price }}</span>
                                <span class="e-price-old">{{ $featuredVehicle->min_price }}</span>
                                <span class="e-price-badge">Promo</span>
                            @else
                                <span class="e-price-now">{{ $featuredVehicle->min_price }}</span>
                            @endif
                        </div>

                        <ul class="e-spec-list">
                            <li><span class="e-muted">Kategori</span><span>{{ $featuredVehicle->product_category->category ?? '-' }}</span></li>
                            @if ($featuredVehicle->product_type->count())
                                <li><span class="e-muted">Varian</span><span>{{ $featuredVehicle->product_type->pluck('type')->implode(' / ') }}</span></li>
                            @endif
                        </ul>

                        <div class="d-flex flex-wrap gap-3">
                            <a href="{{ route('product.detail', $featuredVehicle->slug) }}" class="e-btn e-btn-line">Detail Lengkap</a>
                            <a href="#konsultasi" class="e-btn e-btn-gold lp-pilih-produk" data-product-id="{{ $featuredVehicle->id }}">Tanya Harga</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ============ EXPLORE LINEUP ============ --}}
    @if ($exploreProducts->count())
        <section class="e-light e-section">
            <div class="e-wrap">
                <div class="e-section-head e-reveal">
                    <span class="e-eyebrow">Jajaran Lainnya</span>
                    <h2>Pilihan lain yang mungkin lebih cocok untuk Anda</h2>
                </div>
                <div class="row g-4">
                    @foreach ($exploreProducts as $product)
                        <div class="col-md-6 col-lg-4 e-reveal">
                            <div class="e-product-item">
                                <div class="e-product-img">
                                    <span class="e-product-badge e-product-badge-left"><i class="bi bi-car-front-fill"></i> {{ $product->product_category->category ?? 'Mobil' }}</span>
                                    <span class="e-product-badge e-product-badge-right {{ $product->disc > 0 ? 'is-promo' : '' }}"><i class="bi {{ $product->disc > 0 ? 'bi-tag-fill' : 'bi-stars' }}"></i> {{ $product->disc > 0 ? 'Hemat ' . $product->discount_short : 'Unit Pilihan' }}</span>
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                                </div>
                                <div class="e-product-content">
                                    <div class="e-product-meta">
                                        <h4>{{ $product->name }}</h4>
                                        <span>
                                            @if ($product->disc > 0)
                                                <span class="e-product-price-old">{{ $product->min_price }}</span>
                                                {{ $product->special_min_price }}
                                            @else
                                                {{ $product->min_price }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="e-product-actions">
                                        <a href="{{ route('product.detail', $product->slug) }}"><i class="bi bi-arrow-up-right"></i> Detail</a>
                                        <a href="#konsultasi" class="lp-pilih-produk" data-product-id="{{ $product->id }}"><i class="bi bi-chat-dots"></i> Tanya harga</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============ PROMO (countdown) ============ --}}
    @if ($promos->count())
        <section class="e-dark-2 e-section">
            <div class="e-wrap">
                <div class="e-section-head e-reveal">
                    <span class="e-eyebrow">Promo Berjalan</span>
                    <h2>Penawaran terbatas, jangan sampai terlewat</h2>
                </div>
                @foreach ($promos as $promo)
                    <div class="e-promo-card e-reveal">
                        @if ($promo->promo_image_url)
                            <div class="e-promo-img"><img src="{{ $promo->promo_image_url }}" alt="{{ $promo->promo }}" loading="lazy"></div>
                        @endif
                        <div class="e-promo-body">
                            <h3>{{ $promo->promo }}</h3>
                            @if ($promo->desc)
                                <p class="e-muted">{{ Str::limit(strip_tags($promo->desc), 140) }}</p>
                            @endif

                            @if ($promo->effective_date)
                                <div class="e-countdown" data-countdown="{{ $promo->effective_date->format('Y-m-d') }} 23:59:59">
                                    <div class="e-countdown-unit">
                                        <div class="e-countdown-num" data-unit="days">00</div>
                                        <div class="e-countdown-label">Hari</div>
                                    </div>
                                    <div class="e-countdown-unit">
                                        <div class="e-countdown-num" data-unit="hours">00</div>
                                        <div class="e-countdown-label">Jam</div>
                                    </div>
                                    <div class="e-countdown-unit">
                                        <div class="e-countdown-num" data-unit="minutes">00</div>
                                        <div class="e-countdown-label">Menit</div>
                                    </div>
                                    <div class="e-countdown-unit">
                                        <div class="e-countdown-num" data-unit="seconds">00</div>
                                        <div class="e-countdown-label">Detik</div>
                                    </div>
                                </div>
                            @endif

                            <a href="#konsultasi" class="e-btn e-btn-gold">Klaim Promo Ini</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ============ GALLERY ============ --}}
    @if ($galleries->count())
        <section class="e-light e-section">
            <div class="e-wrap">
                <div class="e-section-head e-reveal">
                    <span class="e-eyebrow">Galeri</span>
                    <h2>Momen di showroom &amp; acara kami</h2>
                </div>
                <div class="row g-3">
                    @foreach ($galleries as $gallery)
                        <div class="col-6 col-lg-4 e-reveal">
                            <a href="{{ $gallery->cover_url }}" class="e-gallery-item text-decoration-none glightbox" data-gallery="landing-gallery" data-title="{{ $gallery->title }}">
                                <img src="{{ $gallery->cover_url }}" alt="{{ $gallery->title }}" loading="lazy">
                                <div class="e-gallery-overlay">
                                    <h4>{{ $gallery->title }}</h4>
                                    <span><i class="bi bi-heart-fill"></i> {{ $gallery->loves }}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============ SERAH TERIMA TERBARU ============ --}}
    @if ($deliveries->count())
        <section class="e-dark e-section">
            <div class="e-wrap">
                <div class="e-section-head e-reveal">
                    <span class="e-eyebrow">Bukti Nyata</span>
                    <h2>Serah Terima Unit Terbaru</h2>
                    <p class="e-muted">Bukan janji, ini unit yang benar-benar sudah kami serahkan ke pelanggan.</p>
                </div>
                <div class="row g-4">
                    @foreach ($deliveries as $delivery)
                        @if ($delivery->landing_image_url)
                            <div class="col-6 col-lg-4 e-reveal">
                                <div class="e-delivery-item">
                                    <a href="{{ $delivery->landing_image_url }}" class="d-block text-decoration-none glightbox" data-gallery="landing-deliveries" data-title="Serah terima {{ $delivery->product->name ?? '' }}">
                                        <div class="e-delivery-img"><img src="{{ $delivery->landing_image_url }}" alt="Serah terima {{ $delivery->product->name ?? '' }}" loading="lazy"></div>
                                    </a>
                                    <div class="e-delivery-badge"><i class="bi bi-patch-check-fill"></i> Sudah Diserahkan</div>
                                    @if ($delivery->product)
                                        <h4>{{ $delivery->product->name }}</h4>
                                    @endif
                                    <span class="e-muted">{{ $delivery->created_at->translatedFormat('d F Y') }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============ STATS ============ --}}
    <section class="e-light e-section" style="padding-top:70px; padding-bottom:70px;">
        <div class="e-wrap">
            <div class="e-stats-row">
                <div class="e-reveal">
                    <div class="e-stat-num"><span class="e-count" data-count="{{ $stats['products_count'] }}">0</span>+</div>
                    <div class="e-stat-label e-muted">Pilihan Mobil</div>
                </div>
                @if ($stats['deliveries_count'] > 0)
                    <div class="e-reveal">
                        <div class="e-stat-num"><span class="e-count" data-count="{{ $stats['deliveries_count'] }}">0</span>+</div>
                        <div class="e-stat-label e-muted">Unit Diserahkan</div>
                    </div>
                @endif
                @if ($stats['testimonies_count'] > 0)
                    <div class="e-reveal">
                        <div class="e-stat-num"><span class="e-count" data-count="{{ $stats['testimonies_count'] }}">0</span>+</div>
                        <div class="e-stat-label e-muted">Cerita Pelanggan</div>
                    </div>
                @endif
                @if ($stats['avg_rating'])
                    <div class="e-reveal">
                        <div class="e-stat-num">{{ $stats['avg_rating'] }}<span style="font-size:.5em;">/5</span></div>
                        <div class="e-stat-label e-muted">Rata-rata Rating</div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ============ TESTIMONIAL ============ --}}
    @if ($testimonies->count())
        <section class="e-dark e-section">
            <div class="e-wrap">
                <span class="e-eyebrow e-reveal">Testimoni</span>
                <div class="swiper init-swiper">
                    <script type="application/json" class="swiper-config">
                    { "loop": true, "speed": 700, "autoplay": { "delay": 5000, "disableOnInteraction": false }, "slidesPerView": 1 }
                </script>
                    <div class="swiper-wrapper">
                        @foreach ($testimonies as $testimony)
                            <div class="swiper-slide">
                                <div class="e-testi-mark">&rdquo;</div>
                                <p class="e-testi-text">{{ Str::limit(strip_tags($testimony->message), 180) }}</p>
                                <div class="e-testi-name">{{ $testimony->name }}</div>
                                @if ($testimony->job)
                                    <div class="e-testi-job e-muted">{{ $testimony->job }}</div>
                                @endif
                                <div class="e-testi-stars">
                                    @for ($i = 0; $i < ($testimony->rating ?: 5); $i++)
                                        <i class="bi bi-star-fill"></i>
                                    @endfor
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ============ FAQ ============ --}}
    @if (!empty($landingPage->faqs))
        <section class="e-light e-section">
            <div class="e-wrap" style="max-width:760px;">
                <div class="e-section-head e-reveal">
                    <span class="e-eyebrow">FAQ</span>
                    <h2>Pertanyaan Umum</h2>
                </div>
                <div>
                    @foreach ($landingPage->faqs as $faq)
                        <div class="e-faq-item e-reveal">
                            <button class="e-faq-btn" type="button" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" data-faq-toggle>
                                {{ $faq['question'] ?? '' }}
                                <span class="e-faq-icon"><i class="bi bi-plus"></i></span>
                            </button>
                            <div class="e-faq-panel" style="{{ $loop->first ? 'max-height:400px;' : '' }}">
                                <div class="e-faq-panel-inner">{{ $faq['answer'] ?? '' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============ CTA / FORM ============ --}}
    <section id="konsultasi" class="e-dark e-section" style="padding-bottom:90px;">
        <div class="e-wrap">
            <div class="e-cta-grid">
                <div class="e-cta-left e-reveal">
                    <span class="e-eyebrow">Mulai Sekarang</span>
                    <h2>{{ $landingPage->form_title ?: 'Konsultasi Gratis Sekarang' }}</h2>
                    <p class="e-muted">{{ $landingPage->form_subtitle ?: 'Isi data di bawah, tim kami akan segera menghubungi Anda via WhatsApp.' }}</p>

                    <div class="e-benefit-row"><i class="bi bi-lightning-charge"></i><span>Respon cepat, dibalas kurang dari 1 jam</span></div>
                    <div class="e-benefit-row"><i class="bi bi-calculator"></i><span>Simulasi cicilan sesuai budget Anda</span></div>
                    <div class="e-benefit-row"><i class="bi bi-shield-check"></i><span>Konsultasi 100% gratis, tanpa paksaan</span></div>
                </div>

                <div class="e-reveal">
                    <div id="lp-form-alert"></div>
                    <form id="lp-lead-form">
                        <input type="hidden" name="page_version" value="v2">
                        <div class="e-field"><label>Nama Lengkap</label><input type="text" name="name" required></div>
                        <div class="e-field"><label>No. WhatsApp</label><input type="text" name="phone" placeholder="08xxxxxxxxxx" required></div>
                        <div class="e-field"><label>Kota</label><input type="text" name="city"></div>
                        <div class="e-field">
                            <label>Mobil yang Diminati</label>
                            <select name="product_id" id="lp-product-select">
                                <option value="">Belum tahu / bebas</option>
                                @foreach ($allProducts as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="e-field"><label>Pesan (opsional)</label>
                            <textarea name="message" placeholder="Contoh: mau tanya simulasi kredit DP 20 juta"></textarea>
                        </div>
                        <button type="submit" class="e-btn e-btn-gold e-submit" id="lp-submit-btn">
                            <i class="bi bi-send-fill"></i> Kirim &amp; Chat WhatsApp
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="e-footer">
        &copy; {{ $seo['year'] }} {{ $profile->name ?? $seo['site_name'] }}. Semua hak dilindungi.
        @if ($profile->phone ?? null)
            &bull; {{ $profile->phone }}
        @endif
    </footer>

    <div class="e-sticky-bar">
        <a href="tel:{{ $profile->phone ?? '' }}" class="e-sticky-call"><i class="bi bi-telephone-fill me-1"></i> Telepon</a>
        <a href="{{ $profile->wa_url }}" target="_blank" class="e-sticky-wa"><i class="bi bi-whatsapp me-1"></i> WhatsApp</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ mix('frontend/js/app.js') }}"></script>
    <script>
        (function() {
            /* ---------- GSAP reveal ringan (sekali, bukan scroll-linked) ---------- */
            if (window.gsap && window.ScrollTrigger) {
                gsap.registerPlugin(ScrollTrigger);
                gsap.timeline().to('.e-hero .e-reveal', {
                    opacity: 1,
                    y: 0,
                    duration: 1,
                    stagger: .12,
                    ease: 'power3.out',
                    delay: .2
                });
                document.querySelectorAll('.e-reveal:not(.e-hero .e-reveal)').forEach(function(el) {
                    gsap.to(el, {
                        opacity: 1,
                        y: 0,
                        duration: .9,
                        ease: 'power3.out',
                        scrollTrigger: {
                            trigger: el,
                            start: 'top 88%',
                            once: true
                        }
                    });
                });
                document.querySelectorAll('.e-count').forEach(function(el) {
                    const target = parseInt(el.dataset.count, 10) || 0;
                    const obj = {
                        val: 0
                    };
                    ScrollTrigger.create({
                        trigger: el,
                        start: 'top 90%',
                        once: true,
                        onEnter: function() {
                            gsap.to(obj, {
                                val: target,
                                duration: 1.6,
                                ease: 'power2.out',
                                onUpdate: function() {
                                    el.textContent = Math.floor(obj.val);
                                }
                            });
                        }
                    });
                });
            } else {
                document.querySelectorAll('.e-reveal').forEach(function(el) {
                    el.style.opacity = 1;
                    el.style.transform = 'none';
                });
                document.querySelectorAll('.e-count').forEach(function(el) {
                    el.textContent = el.dataset.count;
                });
            }

            /* ---------- Countdown promo ---------- */
            document.querySelectorAll('[data-countdown]').forEach(function(box) {
                const target = new Date(box.dataset.countdown.replace(' ', 'T')).getTime();

                function tick() {
                    const diff = target - Date.now();
                    if (diff <= 0) {
                        box.innerHTML = '<span class="e-countdown-label">Promo sudah berakhir</span>';
                        return;
                    }
                    const d = Math.floor(diff / 86400000);
                    const h = Math.floor((diff % 86400000) / 3600000);
                    const m = Math.floor((diff % 3600000) / 60000);
                    const s = Math.floor((diff % 60000) / 1000);
                    box.querySelector('[data-unit="days"]').textContent = String(d).padStart(2, '0');
                    box.querySelector('[data-unit="hours"]').textContent = String(h).padStart(2, '0');
                    box.querySelector('[data-unit="minutes"]').textContent = String(m).padStart(2, '0');
                    box.querySelector('[data-unit="seconds"]').textContent = String(s).padStart(2, '0');
                }
                tick();
                setInterval(tick, 1000);
            });

            /* ---------- FAQ toggle ---------- */
            document.querySelectorAll('[data-faq-toggle]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const expanded = btn.getAttribute('aria-expanded') === 'true';
                    const panel = btn.nextElementSibling;
                    btn.setAttribute('aria-expanded', expanded ? 'false' : 'true');
                    panel.style.maxHeight = expanded ? '0px' : panel.scrollHeight + 'px';
                });
            });

            /* ---------- UTM capture ---------- */
            const params = new URLSearchParams(window.location.search);
            const utmFields = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid', 'fbclid'];
            const utmData = {};
            utmFields.forEach(function(key) {
                utmData[key] = params.get(key) || sessionStorage.getItem('lp_' + key) || '';
                if (params.get(key)) sessionStorage.setItem('lp_' + key, params.get(key));
            });

            document.querySelectorAll('.lp-pilih-produk').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const select = document.getElementById('lp-product-select');
                    if (select) select.value = this.dataset.productId;
                });
            });

            /* ---------- Submit lead ---------- */
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
