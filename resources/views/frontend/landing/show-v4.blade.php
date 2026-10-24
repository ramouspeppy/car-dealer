<!DOCTYPE html>
<html lang="id" class="landing-v4-page">

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
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ mix('frontend/css/app.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

    {!! $landingPage->tracking_head_script !!}

    @include('frontend.layouts._tracking')

    <noscript>

    </noscript>
</head>

<body class="landing-v4-page">

    {{-- ============ NAV ============ --}}
    <div class="t-progress" id="t-progress"></div>
    <div class="t-nav">
        <div class="t-nav-inner">
            <a href="#" class="t-brand">
                @if ($seo['logo'] !== '')
                    <img src="{{ $seo['logo'] }}" alt="{{ $profile->name ?? $seo['site_name'] }}">
                @else
                    <span class="t-brand-mark"><i class="bi bi-speedometer2"></i></span>
                @endif
                <span class="t-brand-copy">
                    <span>{{ $navData['name'] }}</span>
                    <span class="t-brand-site-name">{{ $navData['site_name'] }}</span>
                </span>
            </a>
            <div class="t-nav-links">
                @if ($products->count())
                    <a href="#armada" data-target="armada">Armada</a>
                @endif
                @if ($services->count())
                    <a href="#layanan" data-target="layanan">Layanan</a>
                @endif
                @if ($promos->count())
                    <a href="#promo" data-target="promo">Promo</a>
                @endif
                @if (!empty($landingPage->faqs))
                    <a href="#faq" data-target="faq">FAQ</a>
                @endif
            </div>
            <div class="t-nav-actions">
                <div class="t-nav-socials" aria-label="Media sosial">
                    @foreach ($navData['social_links'] as $social)
                        <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social['name'] }}"><i class="bi {{ $social['icon'] }}" aria-hidden="true"></i></a>
                    @endforeach
                </div>
                <a href="{{ $profile->wa_url }}" target="_blank" rel="noopener noreferrer" class="t-btn t-btn-primary t-btn-sm"><i class="bi bi-whatsapp"></i> Chat</a>
            </div>
        </div>
    </div>

    {{-- ============ HERO ============ --}}
    <section class="t-hero">
        <div class="t-hero-grid-bg"></div>
        <div class="t-scan"></div>
        <div class="t-wrap">
            <div class="t-hero-layout">
                <div>
                    <div class="t-chip t-reveal"><span class="t-chip-dot"></span> {{ $landingPage->hero_badge ?: 'Digital Showroom' }}</div>
                    <h1>{!! $headlineHtml !!}</h1>
                    @if ($landingPage->subheadline)
                        <p class="t-hero-desc t-reveal">{{ $landingPage->subheadline }}</p>
                    @endif
                    <div class="t-hero-actions t-reveal">
                        <a href="#konsultasi" class="t-btn t-btn-primary">{{ $landingPage->hero_cta_label ?: 'Mulai Konsultasi' }} <i class="bi bi-arrow-right"></i></a>
                        @if ($products->count())
                            <a href="#armada" class="t-btn t-btn-ghost">Jelajahi Unit</a>
                        @endif
                    </div>

                    <div class="t-readouts t-reveal">
                        <div class="t-readout">
                            <div class="t-readout-num"><span class="t-num" data-count="{{ $stats['products_count'] }}">0</span>+</div>
                            <div class="t-readout-label">Pilihan Unit</div>
                        </div>
                        @if ($stats['deliveries_count'] > 0)
                            <div class="t-readout">
                                <div class="t-readout-num"><span class="t-num" data-count="{{ $stats['deliveries_count'] }}">0</span>+</div>
                                <div class="t-readout-label">Unit Diserahkan</div>
                            </div>
                        @endif
                        @if ($stats['avg_rating'])
                            <div class="t-readout">
                                <div class="t-readout-num">{{ $stats['avg_rating'] }}<span style="font-size:.55em;color:#8b98a9;">/5</span></div>
                                <div class="t-readout-label">Rating</div>
                            </div>
                        @endif
                    </div>
                </div>

                @if ($heroImage)
                    <div class="t-hero-media t-reveal">
                        <img src="{{ $heroImage }}" alt="{{ $landingPage->hero_image_url ? $landingPage->headline : ($products->first()->name ?? $landingPage->headline) }}" fetchpriority="high">
                    </div>
                @else
                    <div class="t-hero-media t-hero-media-empty t-reveal" aria-hidden="true">
                        <i class="bi bi-car-front-fill"></i>
                        <span>Temukan unit pilihan Anda</span>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ============ TICKER ============ --}}
    @if (!empty($landingPage->trust_badges))
        <div class="t-ticker">
            <div class="t-ticker-track">
                @for ($r = 0; $r < 2; $r++)
                    @foreach ($landingPage->trust_badges as $badge)
                        <span class="t-ticker-item">{{ $badge }}</span>
                    @endforeach
                @endfor
            </div>
        </div>
    @endif

    @if ($profile && ($profile->name || $profile->image_url || $profile->bio || $profile->job_title))
        <section class="t-profile-section">
            <div class="t-wrap">
                <div class="t-profile-card {{ $profile->image_url ? '' : 't-profile-card-no-photo' }} t-reveal">
                    @if ($profile->image_url)
                        <div class="t-profile-photo"><img src="{{ $profile->image_url }}" alt="{{ $profile->name ?: 'Profil sales' }}" loading="lazy"></div>
                    @endif
                    <div class="t-profile-copy">
                        <span class="t-profile-kicker">Sales pendamping Anda</span>
                        <h2>{{ $profile->name }}</h2>
                        @if ($profile->job_title)
                            <p class="t-profile-role">{{ $profile->job_title }}</p>
                        @endif
                        @if ($profile->bio)
                            <div class="t-profile-bio">{!! $profile->bio !!}</div>
                        @else
                            <p class="t-profile-bio">Saya siap membantu Anda memilih mobil yang sesuai kebutuhan serta mendampingi proses pembelian dengan nyaman.</p>
                        @endif
                        <a href="{{ $profile->wa_url }}" target="_blank" rel="noopener" class="t-profile-cta"><i class="bi bi-whatsapp"></i> Hubungi Saya</a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ============ ARMADA (konfigurator) ============ --}}
    @if ($products->count())
        <section id="armada" class="t-section t-dark">
            <div class="t-wrap">
                <div class="t-head t-reveal">
                    <span class="t-label">Armada</span>
                    <h2>Pilih unit, lihat detailnya <span class="t-hl">seketika</span></h2>
                    <p class="t-muted">Klik salah satu unit di daftar untuk melihat varian dan harga tanpa pindah halaman.</p>
                </div>

                <div class="t-cfg t-reveal">
                    <div class="t-cfg-list" id="cfg-list">
                        @foreach ($products as $product)
                            <button type="button" class="t-cfg-item {{ $loop->first ? 'is-active' : '' }}" data-index="{{ $loop->index }}">
                                <span>{{ $product->name }}</span>
                                <small>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</small>
                            </button>
                        @endforeach
                    </div>

                    <div class="t-cfg-panel">
                        <div class="t-cfg-img" id="cfg-img-wrap">
                            <img id="cfg-img" src="" alt="">
                            <span class="t-cfg-tag" id="cfg-tag" style="display:none;"></span>
                            <span class="t-cfg-feature-tag" id="cfg-feature-tag" style="display:none;"></span>
                        </div>
                        <div class="t-cfg-info" id="cfg-info">
                            <div class="t-cfg-cat" id="cfg-cat"></div>
                            <h3 id="cfg-name"></h3>
                            <div class="t-cfg-tagline" id="cfg-tagline"></div>
                            <div><span class="t-cfg-price" id="cfg-price"></span><span class="t-cfg-old" id="cfg-old"></span><span class="t-cfg-disc" id="cfg-disc" style="display:none;"></span></div>
                            <ul class="t-cfg-variants" id="cfg-variants"></ul>
                            <div class="t-cfg-actions">
                                <a href="#" class="t-btn t-btn-ghost t-btn-sm" id="cfg-detail">Detail Lengkap</a>
                                <a href="#konsultasi" class="t-btn t-btn-primary t-btn-sm lp-pilih-produk" id="cfg-ask" data-product-id="">Tanya Harga</a>
                            </div>
                        </div>
                        <div class="t-cfg-progress"><i id="cfg-bar"></i></div>
                    </div>
                </div>
                <script type="application/json" id="lineup-data">{!! $lineupJson !!}</script>
            </div>
        </section>
    @endif

    {{-- ============ LAYANAN (bento) ============ --}}
    @if ($services->count())
        <section id="layanan" class="t-section t-dark-2">
            <div class="t-wrap">
                <div class="t-head t-reveal">
                    <span class="t-label">Layanan</span>
                    <h2>Didampingi <span class="t-hl">end-to-end</span>, dari pilih unit sampai serah terima</h2>
                </div>
                <div class="t-bento">
                    @foreach ($services as $service)
                        <div class="t-bento-item t-spot t-reveal">
                            <span class="t-bento-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <div class="t-bento-icon"><i class="bi {{ $service->icon }}"></i></div>
                            <h3>{{ $service->title }}</h3>
                            @if ($service->desc)
                                <p>{{ Str::limit(strip_tags($service->desc), 120) }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============ PROMO ============ --}}
    @if ($promos->count())
        <section id="promo" class="t-section t-dark">
            <div class="t-wrap">
                <div class="t-head t-reveal">
                    <span class="t-label">Promo</span>
                    <h2>Penawaran <span class="t-hl">aktif</span> dengan hitung mundur</h2>
                </div>
                @foreach ($promos as $promo)
                    <div class="t-promo t-spot t-reveal">
                        @if ($promo->promo_image_url)
                            <div class="t-promo-img t-wipe"><img src="{{ $promo->promo_image_url }}" alt="{{ $promo->promo }}" loading="lazy"></div>
                        @endif
                        <div class="t-promo-body">
                            <span class="t-live"><i></i> LIVE DEAL</span>
                            <h3>{{ $promo->promo }}</h3>
                            @if ($promo->desc)
                                <p>{{ Str::limit(strip_tags($promo->desc), 140) }}</p>
                            @endif

                            @if ($promo->effective_date)
                                <div class="t-count" data-countdown="{{ $promo->effective_date->format('Y-m-d') }} 23:59:59">
                                    <div class="t-count-cell">
                                        <div class="t-count-num" data-unit="days">00</div>
                                        <div class="t-count-label">Hari</div>
                                    </div>
                                    <div class="t-count-cell">
                                        <div class="t-count-num" data-unit="hours">00</div>
                                        <div class="t-count-label">Jam</div>
                                    </div>
                                    <div class="t-count-cell">
                                        <div class="t-count-num" data-unit="minutes">00</div>
                                        <div class="t-count-label">Menit</div>
                                    </div>
                                    <div class="t-count-cell">
                                        <div class="t-count-num" data-unit="seconds">00</div>
                                        <div class="t-count-label">Detik</div>
                                    </div>
                                </div>
                            @endif
                            <div><a href="#konsultasi" class="t-btn t-btn-primary">Klaim Promo <i class="bi bi-arrow-right"></i></a></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ============ GALERI ============ --}}
    @if ($galleries->count())
        <section id="galeri" class="t-section t-dark-2">
            <div class="t-wrap">
                <div class="t-head t-reveal">
                    <span class="t-label">Galeri</span>
                    <h2>Di balik layar showroom dan <span class="t-hl">acara kami</span></h2>
                </div>
                <div class="t-gal">
                    @foreach ($galleries as $gallery)
                        <a href="{{ $gallery->cover_url }}" class="t-gal-item glightbox" data-gallery="landing-gallery" data-title="{{ $gallery->title }}">
                            <img src="{{ $gallery->cover_url }}" alt="{{ $gallery->title }}" loading="lazy">
                            <div class="t-gal-cap">
                                <strong>{{ Str::limit($gallery->title, 40) }}</strong>
                                <span><i class="bi bi-heart-fill"></i> {{ $gallery->loves }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============ DELIVERY LOG ============ --}}
    @if ($deliveries->count())
        <section class="t-section t-light">
            <div class="t-wrap">
                <div class="t-head t-reveal">
                    <span class="t-label">Delivery Log</span>
                    <h2>Bukti serah terima, bukan sekadar janji</h2>
                    <p class="t-muted">Foto asli dari unit yang baru saja kami serahkan ke pelanggan, diperbarui otomatis.</p>
                </div>
                <div class="row g-4">
                    @foreach ($deliveries as $delivery)
                        @if ($delivery->landing_image_url)
                            <div class="col-md-6 col-lg-4 t-reveal">
                                <div class="t-del">
                                    <a href="{{ $delivery->landing_image_url }}" class="d-block text-decoration-none glightbox" data-gallery="landing-deliveries" data-title="Serah terima {{ $delivery->product->name ?? '' }}">
                                        <div class="t-del-img"><img src="{{ $delivery->landing_image_url }}" alt="Serah terima {{ $delivery->product->name ?? '' }}" loading="lazy"></div>
                                    </a>
                                    <div class="t-del-body">
                                        <div class="t-del-meta">DELIVERED // {{ $delivery->created_at->translatedFormat('d M Y') }}</div>
                                        @if ($delivery->product)
                                            <h4>{{ $delivery->product->name }}</h4>
                                        @endif
                                        <span class="t-del-ok"><i class="bi bi-check-circle-fill"></i> HANDED OVER</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============ STATS ============ --}}
    <section class="t-section t-dark" style="padding:80px 0;">
        <div class="t-wrap">
            <div class="t-stats t-reveal">
                <div class="t-stat">
                    <div class="t-stat-num"><span class="t-num" data-count="{{ $stats['products_count'] }}">0</span><em>+</em></div>
                    <div class="t-stat-label">Pilihan Unit</div>
                </div>
                @if ($stats['deliveries_count'] > 0)
                    <div class="t-stat">
                        <div class="t-stat-num"><span class="t-num" data-count="{{ $stats['deliveries_count'] }}">0</span><em>+</em></div>
                        <div class="t-stat-label">Unit Diserahkan</div>
                    </div>
                @endif
                @if ($stats['testimonies_count'] > 0)
                    <div class="t-stat">
                        <div class="t-stat-num"><span class="t-num" data-count="{{ $stats['testimonies_count'] }}">0</span><em>+</em></div>
                        <div class="t-stat-label">Cerita Pelanggan</div>
                    </div>
                @endif
                @if ($stats['avg_rating'])
                    <div class="t-stat">
                        <div class="t-stat-num">{{ $stats['avg_rating'] }}<em>/5</em></div>
                        <div class="t-stat-label">Rata-rata Rating</div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ============ TESTIMONI ============ --}}
    @if ($testimonies->count())
        <section class="t-section t-dark-2">
            <div class="t-wrap">
                <div class="t-head t-reveal">
                    <span class="t-label">Testimoni</span>
                    <h2>Kata pelanggan yang <span class="t-hl">sudah membawa pulang</span> unitnya</h2>
                </div>
                <div class="row g-4">
                    @foreach ($testimonies as $testimony)
                        <div class="col-md-6 col-lg-4 t-reveal">
                            <div class="t-testi t-spot">
                                <div class="t-testi-stars">
                                    @for ($i = 0; $i < ($testimony->rating ?: 5); $i++)
                                        <i class="bi bi-star-fill"></i>
                                    @endfor
                                </div>
                                <p>"{{ Str::limit(strip_tags($testimony->message), 170) }}"</p>
                                <div>
                                    <div class="t-testi-name">{{ $testimony->name }}</div>
                                    @if ($testimony->job)
                                        <div class="t-testi-job">{{ $testimony->job }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============ FAQ ============ --}}
    @if (!empty($landingPage->faqs))
        <section id="faq" class="t-section t-light">
            <div class="t-wrap" style="max-width:820px;">
                <div class="t-head t-reveal">
                    <span class="t-label">FAQ</span>
                    <h2>Pertanyaan yang paling sering muncul</h2>
                </div>
                @foreach ($landingPage->faqs as $faq)
                    <div class="t-faq-item t-reveal">
                        <button class="t-faq-btn" type="button" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" data-faq-toggle>
                            <span class="t-faq-q">Q{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <span>{{ $faq['question'] ?? '' }}</span>
                            <span class="t-faq-icon"><i class="bi bi-plus-lg"></i></span>
                        </button>
                        <div class="t-faq-panel" style="{{ $loop->first ? 'max-height:400px;' : '' }}">
                            <div class="t-faq-inner">{{ $faq['answer'] ?? '' }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ============ FORM ============ --}}
    <section id="konsultasi" class="t-section t-dark">
        <div class="t-wrap">
            <div class="t-form-grid">
                <div class="t-form-left t-reveal">
                    <span class="t-label">Konsultasi</span>
                    <h2>{{ $landingPage->form_title ?: 'Mulai dari Satu Pesan' }}</h2>
                    <p>{{ $landingPage->form_subtitle ?: 'Isi data singkat di bawah, tim kami langsung menghubungi Anda lewat WhatsApp.' }}</p>
                    <div class="t-perk"><i class="bi bi-lightning-charge-fill"></i> Respon rata-rata kurang dari 1 jam</div>
                    <div class="t-perk"><i class="bi bi-calculator-fill"></i> Simulasi cicilan disesuaikan budget Anda</div>
                    <div class="t-perk"><i class="bi bi-shield-check"></i> Gratis, transparan, tanpa paksaan</div>
                </div>

                <div class="t-reveal">
                    <div class="t-form-card">
                        <div id="lp-form-alert"></div>
                        <form id="lp-lead-form">
                            <input type="hidden" name="page_version" value="v4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="t-field"><label>Nama lengkap</label><input type="text" name="name" required></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="t-field"><label>No. WhatsApp</label><input type="text" name="phone" placeholder="08xxxxxxxxxx" required></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="t-field"><label>Kota</label><input type="text" name="city"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="t-field">
                                        <label>Unit yang diminati</label>
                                        <select name="product_id" id="lp-product-select">
                                            <option value="">Belum tahu / bebas</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="t-field"><label>Pesan (opsional)</label>
                                        <textarea name="message" placeholder="Contoh: mau tanya simulasi kredit DP 20 juta"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="t-btn t-btn-primary t-submit" id="lp-submit-btn"><i class="bi bi-send-fill"></i> Kirim &amp; Chat WhatsApp</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="t-footer">
        &copy; {{ $seo['year'] }} {{ $profile->name ?? $seo['site_name'] }} // Semua hak dilindungi
        @if ($profile->phone ?? null)
            // {{ $profile->phone }}
        @endif
    </footer>

    <div class="t-sticky">
        <a href="tel:{{ $profile->phone ?? '' }}" class="t-s-call"><i class="bi bi-telephone-fill"></i> Telepon</a>
        <a href="{{ $profile->wa_url }}" target="_blank" class="t-s-wa"><i class="bi bi-whatsapp"></i> WhatsApp</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ mix('frontend/js/app.js') }}"></script>
    <script>
        (function() {
            const prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const hasGsap = window.gsap && window.ScrollTrigger;
            if (hasGsap) gsap.registerPlugin(ScrollTrigger);

            /* ---------- 1. Headline per baris ---------- */
            const lines = document.querySelectorAll('.t-line-inner');
            if (prefersReduced || !hasGsap) {
                lines.forEach(function(el) {
                    el.classList.add('is-done');
                });
            } else {
                gsap.to(lines, {
                    y: 0,
                    duration: .8,
                    stagger: .12,
                    ease: 'power3.out',
                    delay: .15,
                    onComplete: function() {
                        lines.forEach(function(el) {
                            el.classList.add('is-done');
                        });
                    }
                });
            }

            /* ---------- 7. Kata berganti (typewriter) di headline, kalau admin isi kata|kata2|kata3 ---------- */
            document.querySelectorAll('.t-rotate').forEach(function(el) {
                const words = (el.dataset.words || '').split('|').map(function(w) {
                    return w.trim();
                }).filter(Boolean);
                if (words.length < 2 || prefersReduced) return;
                let wi = 0,
                    ci = words[0].length,
                    deleting = false;

                function step() {
                    const word = words[wi];
                    ci += deleting ? -1 : 1;
                    el.textContent = word.slice(0, ci);
                    let delay = deleting ? 45 : 85;
                    if (!deleting && ci === word.length) {
                        delay = 1400;
                        deleting = true;
                    } else if (deleting && ci === 0) {
                        deleting = false;
                        wi = (wi + 1) % words.length;
                        delay = 300;
                    }
                    setTimeout(step, delay);
                }
                setTimeout(step, 1400);
            });

            /* ---------- Reveal umum (fade-up sekali, ringan) ---------- */
            if (hasGsap) {
                document.querySelectorAll('.t-reveal').forEach(function(el) {
                    gsap.to(el, {
                        opacity: 1,
                        y: 0,
                        duration: .8,
                        ease: 'power3.out',
                        scrollTrigger: {
                            trigger: el,
                            start: 'top 90%',
                            once: true
                        }
                    });
                });
                document.querySelectorAll('.t-num[data-count]').forEach(function(el) {
                    const target = parseInt(el.dataset.count, 10) || 0;
                    const obj = {
                        val: 0
                    };
                    ScrollTrigger.create({
                        trigger: el,
                        start: 'top 95%',
                        once: true,
                        onEnter: function() {
                            gsap.to(obj, {
                                val: target,
                                duration: 1.5,
                                ease: 'power2.out',
                                onUpdate: function() {
                                    el.textContent = Math.floor(obj.val);
                                }
                            });
                        }
                    });
                });
                document.querySelectorAll('.t-wipe').forEach(function(el) {
                    const up = el.classList.contains('t-wipe-up');
                    gsap.fromTo(el, {
                        clipPath: up ? 'inset(100% 0% 0% 0%)' : 'inset(0% 100% 0% 0%)'
                    }, {
                        clipPath: 'inset(0% 0% 0% 0%)',
                        duration: 1,
                        ease: 'power3.out',
                        scrollTrigger: {
                            trigger: el,
                            start: 'top 92%',
                            once: true
                        }
                    });
                });
            } else {
                document.querySelectorAll('.t-reveal, .t-wipe').forEach(function(el) {
                    el.style.opacity = 1;
                    el.style.transform = 'none';
                    el.style.clipPath = 'none';
                });
                document.querySelectorAll('.t-num[data-count]').forEach(function(el) {
                    el.textContent = el.dataset.count;
                });
            }

            /* ---------- 5. Progress scroll + nav aktif ---------- */
            const progressBar = document.getElementById('t-progress');
            const navLinks = document.querySelectorAll('.t-nav-links a[data-target]');

            function onScroll() {
                if (progressBar) {
                    const h = document.documentElement;
                    const scrolled = h.scrollTop / (h.scrollHeight - h.clientHeight || 1);
                    progressBar.style.transform = 'scaleX(' + Math.min(1, Math.max(0, scrolled)) + ')';
                }
                let current = null;
                navLinks.forEach(function(a) {
                    const sec = document.getElementById(a.dataset.target);
                    if (sec && sec.getBoundingClientRect().top < window.innerHeight * .4) current = a;
                });
                navLinks.forEach(function(a) {
                    a.classList.toggle('is-active', a === current);
                });
            }
            document.addEventListener('scroll', onScroll, {
                passive: true
            });
            onScroll();

            /* ---------- 2. Spotlight mengikuti kursor ---------- */
            if (!prefersReduced && matchMedia('(hover: hover)').matches) {
                document.querySelectorAll('.t-spot').forEach(function(card) {
                    card.addEventListener('mousemove', function(e) {
                        const r = card.getBoundingClientRect();
                        card.style.setProperty('--mx', (e.clientX - r.left) + 'px');
                        card.style.setProperty('--my', (e.clientY - r.top) + 'px');
                    });
                });

                /* ---------- 6. Kartu ID 3D tilt + shine ---------- */
                const idStage = document.querySelector('.t-id-stage');
                if (idStage) {
                    const idCard = idStage.querySelector('.t-id');
                    const shine = idStage.querySelector('.t-id-shine');
                    idStage.addEventListener('mousemove', function(e) {
                        const r = idStage.getBoundingClientRect();
                        const px = (e.clientX - r.left) / r.width,
                            py = (e.clientY - r.top) / r.height;
                        idCard.style.setProperty('--ry', ((px - .5) * 14) + 'deg');
                        idCard.style.setProperty('--rx', ((.5 - py) * 14) + 'deg');
                        if (shine) {
                            shine.style.setProperty('--sx', (px * 100) + '%');
                            shine.style.setProperty('--sy', (py * 100) + '%');
                        }
                    });
                    idStage.addEventListener('mouseleave', function() {
                        idCard.style.setProperty('--rx', '0deg');
                        idCard.style.setProperty('--ry', '0deg');
                    });
                }
            }

            /* ---------- 3. Konfigurator unit (klik manual + auto-advance) ---------- */
            const dataEl = document.getElementById('lineup-data');
            if (dataEl) {
                const lineup = JSON.parse(dataEl.textContent || '[]');
                const $ = function(id) {
                    return document.getElementById(id);
                };
                const imgWrap = $('cfg-img-wrap'),
                    img = $('cfg-img'),
                    info = $('cfg-info'),
                    bar = $('cfg-bar');
                const items = document.querySelectorAll('.t-cfg-item');
                let activeIndex = 0,
                    autoTimer = null,
                    barTween = null;
                let isHovering = false,
                    isInView = false;
                const AUTO_MS = 5000;

                function shouldRun() {
                    return isInView && !isHovering && lineup.length > 1 && !prefersReduced;
                }

                function render(i, opts) {
                    opts = opts || {};
                    const d = lineup[i];
                    if (!d) return;
                    activeIndex = i;

                    imgWrap.classList.add('is-swap');
                    setTimeout(function() {
                        img.src = d.img || '';
                        img.alt = d.name;
                        imgWrap.classList.remove('is-swap');
                    }, 160);

                    if (hasGsap && !prefersReduced) {
                        gsap.fromTo(info, {
                            opacity: .35,
                            y: 6
                        }, {
                            opacity: 1,
                            y: 0,
                            duration: .35,
                            ease: 'power2.out'
                        });
                    }

                    $('cfg-cat').textContent = d.category || '';
                    $('cfg-name').textContent = d.name;
                    $('cfg-tagline').textContent = d.tagline || '';
                    $('cfg-price').textContent = d.price;
                    $('cfg-old').textContent = d.old || '';
                    const disc = $('cfg-disc');
                    if (d.disc > 0) {
                        disc.style.display = '';
                        disc.textContent = 'HEMAT Rp ' + new Intl.NumberFormat('id-ID').format(d.disc);
                    } else {
                        disc.style.display = 'none';
                    }
                    const tag = $('cfg-tag');
                    tag.style.display = '';
                    tag.textContent = d.category || ('UNIT ' + String(i + 1).padStart(2, '0') + ' / ' + String(lineup.length).padStart(2, '0'));
                    const featureTag = $('cfg-feature-tag');
                    featureTag.style.display = '';
                    featureTag.classList.toggle('is-promo', d.disc > 0);
                    featureTag.textContent = d.disc > 0
                        ? 'HEMAT ' + d.discountLabel
                        : 'UNIT PILIHAN';

                    const ul = $('cfg-variants');
                    ul.innerHTML = '';
                    (d.variants || []).forEach(function(v, vi) {
                        const li = document.createElement('li');
                        li.style.animationDelay = (vi * .06) + 's';
                        const a = document.createElement('span');
                        a.textContent = v.type;
                        const b = document.createElement('span');
                        b.textContent = v.price;
                        li.appendChild(a);
                        li.appendChild(b);
                        ul.appendChild(li);
                    });

                    $('cfg-detail').href = d.url;
                    $('cfg-ask').dataset.productId = d.id;
                    items.forEach(function(it) {
                        it.classList.toggle('is-active', parseInt(it.dataset.index, 10) === i);
                    });

                    if (!opts.silent) restartAuto();
                }

                function playBar() {
                    if (!bar) return;
                    if (hasGsap && !prefersReduced) {
                        if (barTween) barTween.kill();
                        gsap.set(bar, {
                            scaleX: 0
                        });
                        barTween = gsap.to(bar, {
                            scaleX: 1,
                            duration: AUTO_MS / 1000,
                            ease: 'none'
                        });
                    }
                }

                function pauseAuto() {
                    clearTimeout(autoTimer);
                    autoTimer = null;
                    if (barTween) barTween.pause();
                }

                function restartAuto() {
                    clearTimeout(autoTimer);
                    autoTimer = null;
                    if (!shouldRun()) {
                        if (barTween) barTween.pause();
                        return;
                    }
                    playBar();
                    autoTimer = setTimeout(function() {
                        render((activeIndex + 1) % lineup.length);
                    }, AUTO_MS);
                }

                items.forEach(function(it) {
                    it.addEventListener('click', function() {
                        render(parseInt(it.dataset.index, 10));
                    });
                });
                const cfgWrap = document.querySelector('.t-cfg');
                if (cfgWrap) {
                    cfgWrap.addEventListener('mouseenter', function() {
                        isHovering = true;
                        pauseAuto();
                    });
                    cfgWrap.addEventListener('mouseleave', function() {
                        isHovering = false;
                        restartAuto();
                    });

                    // Berhenti total (bukan cuma pause) begitu area konfigurator keluar dari layar,
                    // dan lanjut lagi otomatis begitu pengunjung scroll balik melihatnya.
                    if ('IntersectionObserver' in window) {
                        const cfgObserver = new IntersectionObserver(function(entries) {
                            entries.forEach(function(entry) {
                                isInView = entry.isIntersecting;
                                if (isInView) {
                                    restartAuto();
                                } else {
                                    pauseAuto();
                                }
                            });
                        }, {
                            threshold: .35
                        });
                        cfgObserver.observe(cfgWrap);
                    } else {
                        // Fallback browser lama: anggap selalu terlihat.
                        isInView = true;
                        restartAuto();
                    }
                }

                render(0, {
                    silent: true
                });
                restartAuto();
            }

            /* ---------- 8. Countdown promo dengan digit flip ---------- */
            document.querySelectorAll('[data-countdown]').forEach(function(box) {
                const target = new Date(box.dataset.countdown.replace(' ', 'T')).getTime();

                function setDigit(el, val) {
                    const text = String(val).padStart(2, '0');
                    if (el.textContent === text) return;
                    if (hasGsap && !prefersReduced) {
                        gsap.fromTo(el, {
                            rotationX: -90,
                            opacity: 0
                        }, {
                            rotationX: 0,
                            opacity: 1,
                            duration: .35,
                            ease: 'power2.out',
                            onStart: function() {
                                el.textContent = text;
                            }
                        });
                    } else {
                        el.textContent = text;
                    }
                }

                function tick() {
                    const diff = target - Date.now();
                    if (diff <= 0) {
                        box.innerHTML = '<strong>Promo sudah berakhir</strong>';
                        return;
                    }
                    setDigit(box.querySelector('[data-unit="days"]'), Math.floor(diff / 86400000));
                    setDigit(box.querySelector('[data-unit="hours"]'), Math.floor((diff % 86400000) / 3600000));
                    setDigit(box.querySelector('[data-unit="minutes"]'), Math.floor((diff % 3600000) / 60000));
                    setDigit(box.querySelector('[data-unit="seconds"]'), Math.floor((diff % 60000) / 1000));
                }
                tick();
                setInterval(tick, 1000);
            });

            /* ---------- FAQ ---------- */
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

            /* ---------- Submit lead + 10. sukses dengan centang tergambar ---------- */
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
                            alertBox.innerHTML = '<div class="t-success">' +
                                '<svg viewBox="0 0 52 52"><circle cx="26" cy="26" r="23"/><path d="M15 27l7 7 15-15"/></svg>' +
                                '<div><strong>Terkirim!</strong><span>' + result.data.message + '</span></div>' +
                                '</div>';
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
