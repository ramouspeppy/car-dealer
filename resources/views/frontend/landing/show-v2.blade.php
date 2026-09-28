<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landingPage->meta_title ?: $landingPage->headline }}</title>
    <meta name="description" content="{{ $landingPage->meta_description ?: $landingPage->subheadline }}">
    <meta name="robots" content="noindex, follow">

    <meta property="og:title" content="{{ $landingPage->meta_title ?: $landingPage->headline }}">
    <meta property="og:description" content="{{ $landingPage->meta_description ?: $landingPage->subheadline }}">
    <meta property="og:image" content="{{ $landingPage->og_image_url }}">
    <meta property="og:type" content="website">

    <link href="{{ asset('frontend/img/favicon.png') }}" rel="icon">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ mix('frontend/css/app.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

    {!! $landingPage->tracking_head_script !!}

    <style>
        :root {
            --e-ink: #1b1815;
            --e-ink-2: #24201b;
            --e-cream: #f7f3ec;
            --e-cream-2: #efe8db;
            --e-gold: #b6904f;
            --e-gold-light: #d8bd8a;
            --e-line-d: rgba(247, 243, 236, .14);
            --e-line-l: rgba(27, 24, 21, .12);
            --e-font-display: 'Fraunces', serif;
            --e-font-body: 'Inter', sans-serif;
        }

        * { box-sizing: border-box; }

        html, body { background: var(--e-ink) !important; }

        body {
            font-family: var(--e-font-body);
            color: var(--e-cream);
            margin: 0;
            overflow-x: hidden;
            padding-bottom: 78px;
        }

        img { max-width: 100%; display: block; }

        h1, h2, h3, h4, .e-display {
            font-family: var(--e-font-display);
            font-weight: 600;
            letter-spacing: -.01em;
            margin: 0;
            color: var(--e-cream);
        }

        .e-light h1, .e-light h2, .e-light h3, .e-light h4 { color: var(--e-ink); }

        .e-wrap { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        .e-dark { background: var(--e-ink); color: var(--e-cream); }
        .e-dark-2 { background: var(--e-ink-2); color: var(--e-cream); }
        .e-light { background: var(--e-cream); color: var(--e-ink); }
        .e-section { padding: 110px 0; position: relative; }

        .e-muted { color: rgba(247, 243, 236, .58); }
        .e-light .e-muted { color: rgba(27, 24, 21, .58); }

        .e-eyebrow {
            font-family: var(--e-font-body);
            font-weight: 600;
            font-size: 12px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--e-gold);
            display: inline-block;
            margin-bottom: 18px;
        }

        .e-section-head { max-width: 620px; margin-bottom: 54px; }
        .e-section-head h2 { font-size: clamp(28px, 3.6vw, 44px); line-height: 1.15; }
        .e-section-head p { font-size: 16px; margin-top: 14px; }

        .e-reveal { opacity: 0; transform: translateY(36px); }

        /* ===== Buttons ===== */
        .e-btn {
            display: inline-flex; align-items: center; gap: 10px;
            font-family: var(--e-font-body); font-weight: 600; font-size: 14px;
            padding: 15px 30px; border-radius: 3px; text-decoration: none;
            border: 1px solid currentColor; transition: all .35s cubic-bezier(.16, 1, .3, 1);
            cursor: pointer; background: transparent;
        }
        .e-btn-gold { background: var(--e-gold); border-color: var(--e-gold); color: var(--e-ink) !important; }
        .e-btn-gold:hover { background: transparent; color: var(--e-gold) !important; }
        .e-btn-line { color: var(--e-cream); }
        .e-btn-line:hover { background: var(--e-cream); color: var(--e-ink) !important; }
        .e-light .e-btn-line { color: var(--e-ink); }
        .e-light .e-btn-line:hover { background: var(--e-ink); color: var(--e-cream) !important; }

        /* ===== Topbar ===== */
        .e-topbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            display: flex; align-items: center; justify-content: space-between;
            padding: 24px 28px; mix-blend-mode: difference;
        }
        .e-topbar-brand { font-family: var(--e-font-display); font-weight: 600; font-size: 16px; color: #fff; text-decoration: none; }
        .e-topbar-cta { font-family: var(--e-font-body); font-weight: 600; font-size: 13px; color: #fff; text-decoration: none; display: flex; align-items: center; gap: 7px; }

        /* ===== Hero ===== */
        .e-hero { position: relative; min-height: 100svh; display: flex; align-items: center; overflow: hidden; }
        .e-hero-wash { position: absolute; inset: 0; background: linear-gradient(120deg, var(--e-ink) 35%, var(--e-ink-2) 100%); }
        .e-hero-content { position: relative; z-index: 2; width: 100%; padding-top: 60px; }

        .e-hero-eyebrow { display: inline-flex; align-items: center; gap: 10px; font-size: 12.5px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--e-gold-light); margin-bottom: 26px; }
        .e-hero-eyebrow .e-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--e-gold); }

        .e-hero h1 { font-size: clamp(38px, 6vw, 72px); line-height: 1.05; max-width: 780px; font-weight: 500; }
        .e-hero h1 em { font-style: italic; color: var(--e-gold-light); font-weight: 500; }

        .e-hero p.e-hero-desc { font-weight: 300; font-size: 18px; line-height: 1.75; color: rgba(247, 243, 236, .68); max-width: 480px; margin: 26px 0 40px; }

        .e-hero-actions { display: flex; flex-wrap: wrap; gap: 16px; margin-bottom: 50px; }

        .e-hero-grid { display: grid; grid-template-columns: 1fr; gap: 50px; align-items: center; }
        @media (min-width: 992px) { .e-hero-grid { grid-template-columns: 1.15fr .85fr; gap: 70px; } }

        .e-hero-profile { position: relative; max-width: 380px; margin: 0 auto; }
        .e-hero-profile-img { border-radius: 6px; overflow: hidden; aspect-ratio: 3/4; }
        .e-hero-profile-img img { width: 100%; height: 100%; object-fit: cover; }
        .e-hero-profile-img::after { content: ''; position: absolute; inset: 0; border: 1px solid var(--e-gold); border-radius: 6px; transform: translate(14px, 14px); z-index: -1; }

        .e-hero-greet {
            position: relative;
            margin-top: -50px;
            margin-left: 24px;
            margin-right: -10px;
            background: var(--e-cream);
            color: var(--e-ink);
            border-radius: 4px;
            padding: 22px 24px;
            box-shadow: 0 24px 50px rgba(0, 0, 0, .35);
        }
        .e-hero-greet .e-testi-mark { font-size: 44px; margin-bottom: 2px; color: var(--e-gold); opacity: .5; }
        .e-hero-greet p { font-size: 13.5px; line-height: 1.7; color: rgba(27,24,21,.72); margin-bottom: 12px; font-style: italic; }
        .e-hero-greet strong { display: block; font-family: var(--e-font-display); font-size: 15px; }
        .e-hero-greet span { font-size: 12px; color: rgba(27,24,21,.55); }

        @media (max-width: 767px) {
            .e-hero-profile { max-width: 260px; }
            .e-hero-greet { margin-left: 10px; margin-right: 0; }
        }

        .e-scroll-cue { position: absolute; bottom: 34px; left: 24px; display: flex; align-items: center; gap: 12px; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: rgba(247,243,236,.4); z-index: 2; }
        .e-scroll-cue::before { content: ''; width: 1px; height: 44px; background: linear-gradient(var(--e-gold-light), transparent); }

        /* ===== Trust marquee ===== */
        .e-marquee-wrap { padding: 24px 0; overflow: hidden; border-top: 1px solid var(--e-line-d); border-bottom: 1px solid var(--e-line-d); }
        .e-marquee { display: flex; width: max-content; animation: eMarquee 24s linear infinite; }
        .e-marquee:hover { animation-play-state: paused; }
        .e-marquee-item { display: flex; align-items: center; gap: 10px; font-weight: 500; font-size: 13.5px; letter-spacing: .3px; padding: 0 30px; white-space: nowrap; color: rgba(247,243,236,.75); }
        .e-marquee-item i { color: var(--e-gold); }
        @keyframes eMarquee { from { transform: translateX(0); } to { transform: translateX(-50%); } }

        /* ===== Feature rows (Services, minimal no card) ===== */
        .e-feature { display: flex; gap: 18px; align-items: flex-start; }
        .e-feature-icon {
            width: 46px; height: 46px; border-radius: 50%; flex-shrink: 0;
            background: rgba(182, 144, 79, .12); color: var(--e-gold);
            display: flex; align-items: center; justify-content: center; font-size: 19px;
        }
        .e-feature h4 { font-size: 16.5px; margin-bottom: 6px; }
        .e-feature p { font-size: 14px; margin: 0; line-height: 1.7; }

        /* ===== Spotlight ===== */
        .e-spotlight-grid { display: grid; grid-template-columns: 1fr; gap: 40px; align-items: center; }
        @media (min-width: 992px) { .e-spotlight-grid { grid-template-columns: 1fr 1fr; gap: 70px; } }
        .e-spotlight-img { border-radius: 4px; overflow: hidden; aspect-ratio: 4/3; }
        .e-spotlight-img img { width: 100%; height: 100%; object-fit: cover; }
        .e-spotlight-kicker { font-size: 12px; letter-spacing: 3px; text-transform: uppercase; color: var(--e-gold); font-weight: 600; margin-bottom: 16px; }
        .e-spotlight-text h3 { font-size: clamp(26px, 3.2vw, 38px); margin-bottom: 16px; }
        .e-spotlight-text p.e-desc { font-size: 15.5px; line-height: 1.8; max-width: 440px; margin-bottom: 26px; }

        .e-spec-list { list-style: none; padding: 0; margin: 0 0 28px; display: flex; flex-direction: column; gap: 12px; }
        .e-spec-list li { display: flex; justify-content: space-between; gap: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--e-line-d); font-size: 13.5px; }

        .e-price-row { display: flex; align-items: baseline; gap: 12px; margin-bottom: 24px; }
        .e-price-now { font-family: var(--e-font-display); font-size: 25px; font-weight: 600; }
        .e-price-old { font-size: 14px; color: rgba(247,243,236,.4); text-decoration: line-through; }
        .e-price-badge { font-size: 11px; font-weight: 700; color: var(--e-ink); background: var(--e-gold); padding: 3px 10px; border-radius: 3px; }

        /* ===== Explore lineup ===== */
        .e-product-item { position: relative; }
        .e-product-img { position: relative; overflow: hidden; aspect-ratio: 4/3; border-radius: 3px; }
        .e-product-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .8s cubic-bezier(.16,1,.3,1); }
        .e-product-item:hover .e-product-img img { transform: scale(1.06); }
        .e-product-meta { display: flex; justify-content: space-between; align-items: baseline; padding-top: 16px; }
        .e-product-meta h4 { font-size: 16.5px; }
        .e-product-meta span { font-size: 13.5px; }

        /* ===== Promo (countdown) ===== */
        .e-promo-card { display: grid; grid-template-columns: 1fr; gap: 0; overflow: hidden; border-radius: 4px; margin-bottom: 28px; background: var(--e-ink-2); }
        @media (min-width: 768px) { .e-promo-card { grid-template-columns: .9fr 1.1fr; } }
        .e-promo-img { aspect-ratio: 16/10; overflow: hidden; }
        .e-promo-img img { width: 100%; height: 100%; object-fit: cover; }
        .e-promo-body { padding: 36px; display: flex; flex-direction: column; justify-content: center; }
        .e-promo-body h3 { font-size: 24px; margin-bottom: 10px; }
        .e-promo-body p { font-size: 14.5px; margin-bottom: 22px; }

        .e-countdown { display: flex; gap: 14px; margin-bottom: 26px; }
        .e-countdown-unit { text-align: center; }
        .e-countdown-num { font-family: var(--e-font-display); font-size: 26px; font-weight: 600; color: var(--e-gold-light); line-height: 1; }
        .e-countdown-label { font-size: 10px; letter-spacing: 1px; text-transform: uppercase; color: rgba(247,243,236,.45); margin-top: 4px; }

        /* ===== Gallery ===== */
        .e-gallery-item { position: relative; overflow: hidden; border-radius: 3px; aspect-ratio: 1/1; }
        .e-gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform .7s ease, filter .4s ease; filter: brightness(.9); }
        .e-gallery-item:hover img { transform: scale(1.08); filter: brightness(1); }
        .e-gallery-overlay {
            position: absolute; inset: 0; display: flex; flex-direction: column; justify-content: flex-end; padding: 18px;
            background: linear-gradient(0deg, rgba(27,24,21,.85), transparent 55%);
        }
        .e-gallery-overlay h4 { color: #fff; font-size: 14.5px; }
        .e-gallery-overlay span { color: rgba(255,255,255,.65); font-size: 12px; display: flex; align-items: center; gap: 5px; margin-top: 4px; }

        /* ===== Delivery (serah terima) ===== */
        .e-delivery-item { }
        .e-delivery-img { border-radius: 3px; overflow: hidden; aspect-ratio: 5/4; margin-bottom: 14px; }
        .e-delivery-img img { width: 100%; height: 100%; object-fit: cover; }
        .e-delivery-item h4 { font-size: 15px; margin-bottom: 4px; }
        .e-delivery-item span { font-size: 12.5px; }
        .e-delivery-badge { display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 600; color: var(--e-gold); margin-bottom: 8px; text-transform: uppercase; letter-spacing: .5px; }

        /* ===== Stats ===== */
        .e-stats-row { display: flex; flex-wrap: wrap; gap: 54px; }
        .e-stat-num { font-family: var(--e-font-display); font-size: clamp(34px, 4.4vw, 52px); font-weight: 600; }
        .e-stat-label { font-size: 12.5px; letter-spacing: .5px; margin-top: 8px; }

        /* ===== Testimonial ===== */
        .e-testi-mark { font-family: var(--e-font-display); font-size: 80px; color: var(--e-gold); opacity: .35; line-height: .4; margin-bottom: 18px; }
        .e-testi-text { font-size: clamp(19px, 2.4vw, 27px); font-family: var(--e-font-display); font-weight: 400; font-style: italic; line-height: 1.55; max-width: 760px; margin-bottom: 30px; }
        .e-testi-name { font-weight: 600; font-size: 14.5px; }
        .e-testi-job { font-size: 13px; }
        .e-testi-stars { color: var(--e-gold); font-size: 13px; margin-top: 6px; }

        /* ===== FAQ ===== */
        .e-faq-item { border-bottom: 1px solid var(--e-line-l); }
        .e-faq-btn { width: 100%; text-align: left; background: none; border: none; padding: 26px 0; display: flex; justify-content: space-between; align-items: center; font-family: var(--e-font-display); font-weight: 500; font-size: 18px; color: var(--e-ink); cursor: pointer; }
        .e-faq-icon { font-size: 18px; color: var(--e-gold); transition: transform .35s ease; flex-shrink: 0; margin-left: 20px; }
        .e-faq-btn[aria-expanded="true"] .e-faq-icon { transform: rotate(135deg); }
        .e-faq-panel { max-height: 0; overflow: hidden; transition: max-height .4s ease; }
        .e-faq-panel-inner { padding-bottom: 26px; font-size: 14.5px; line-height: 1.8; max-width: 640px; color: rgba(27,24,21,.65); }

        /* ===== CTA / Form ===== */
        .e-cta-grid { display: grid; grid-template-columns: 1fr; gap: 60px; }
        @media (min-width: 992px) { .e-cta-grid { grid-template-columns: .85fr 1.15fr; } }
        .e-cta-left h2 { font-size: clamp(30px, 4vw, 46px); margin-bottom: 20px; }
        .e-cta-left p { font-size: 16px; line-height: 1.8; max-width: 420px; margin-bottom: 36px; }
        .e-benefit-row { display: flex; align-items: center; gap: 14px; padding: 16px 0; border-top: 1px solid var(--e-line-d); }
        .e-benefit-row:last-child { border-bottom: 1px solid var(--e-line-d); }
        .e-benefit-row i { color: var(--e-gold); font-size: 18px; }
        .e-benefit-row span { font-size: 14px; }

        .e-field { position: relative; margin-bottom: 28px; }
        .e-field label { display: block; font-size: 11.5px; letter-spacing: 1px; text-transform: uppercase; color: rgba(247,243,236,.5); margin-bottom: 10px; }
        .e-field input, .e-field select, .e-field textarea {
            width: 100%; background: transparent; border: none; border-bottom: 1.5px solid var(--e-line-d);
            color: var(--e-cream); font-family: var(--e-font-body); font-size: 16px; padding: 8px 2px 12px; border-radius: 0;
            transition: border-color .3s ease;
        }
        .e-field select option { color: #000; }
        .e-field input:focus, .e-field select:focus, .e-field textarea:focus { outline: none; border-color: var(--e-gold); }
        .e-field textarea { resize: vertical; min-height: 70px; }
        .e-submit { width: 100%; justify-content: center; margin-top: 8px; }

        /* ===== Footer ===== */
        .e-footer { padding: 40px 0; text-align: center; font-size: 13px; color: rgba(247,243,236,.4); border-top: 1px solid var(--e-line-d); }

        /* ===== Sticky mobile bar ===== */
        .e-sticky-bar { position: fixed; bottom: 0; left: 0; right: 0; z-index: 1040; background: var(--e-ink); border-top: 1px solid var(--e-line-d); padding: 12px 20px; display: flex; gap: 10px; }
        .e-sticky-bar a { flex: 1; text-align: center; padding: 13px; border-radius: 3px; font-weight: 600; font-size: 13.5px; text-decoration: none; }
        .e-sticky-call { border: 1.5px solid var(--e-cream); color: var(--e-cream); }
        .e-sticky-wa { background: #25d366; color: #fff; }

        @media (min-width: 992px) { .e-sticky-bar { display: none; } body { padding-bottom: 0; } }
        @media (max-width: 767px) { .e-section { padding: 70px 0; } .e-hero { min-height: auto; padding: 130px 0 50px; } }
    </style>
</head>

<body>

    <div class="e-topbar">
        <a href="#" class="e-topbar-brand">{{ $profile->name ?? config('settings.site_name') }}</a>
        <a href="{{ $profile->wa_url }}" target="_blank" class="e-topbar-cta"><i class="bi bi-whatsapp"></i> {{ $profile->phone ?? 'Chat Kami' }}</a>
    </div>

    {{-- ============ HERO ============ --}}
    <section class="e-hero">
        <div class="e-hero-wash"></div>
        <div class="e-wrap e-hero-content">
            <div class="e-hero-grid">
                <div>
                    <div class="e-hero-eyebrow e-reveal"><span class="e-dot"></span> {{ $landingPage->hero_badge ?: 'Digital Showroom' }}</div>
                    <h1 class="e-reveal">{!! nl2br(e($landingPage->headline)) !!}</h1>
                    @if($landingPage->subheadline)
                    <p class="e-hero-desc e-reveal">{{ $landingPage->subheadline }}</p>
                    @endif
                    <div class="e-hero-actions e-reveal">
                        <a href="#konsultasi" class="e-btn e-btn-gold">{{ $landingPage->hero_cta_label ?: 'Konsultasi Sekarang' }}</a>
                        @if($featuredVehicle)
                        <a href="#spotlight" class="e-btn e-btn-line">Lihat Unit Pilihan</a>
                        @endif
                    </div>
                </div>

                @if($profile->image_url ?? null)
                <div class="e-hero-profile e-reveal">
                    <div class="e-hero-profile-img">
                        <img src="{{ $profile->image_url }}" alt="{{ $profile->name }}">
                    </div>
                    @if($profile->bio)
                    <div class="e-hero-greet">
                        <div class="e-testi-mark">&rdquo;</div>
                        <p>{{ Str::limit(strip_tags($profile->bio), 150) }}</p>
                        <strong>{{ $profile->name }}</strong>
                        @if($profile->job_title)<span>{{ $profile->job_title }}</span>@endif
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
        <div class="e-scroll-cue">Scroll</div>
    </section>

    {{-- ============ TRUST MARQUEE ============ --}}
    @if(!empty($landingPage->trust_badges))
    <div class="e-dark e-marquee-wrap">
        <div class="e-marquee">
            @for($r = 0; $r < 2; $r++)
                @foreach($landingPage->trust_badges as $badge)
                <span class="e-marquee-item"><i class="bi bi-gem"></i> {{ $badge }}</span>
                @endforeach
            @endfor
        </div>
    </div>
    @endif

    {{-- ============ SERVICES (data nyata) ============ --}}
    @if($services->count())
    <section class="e-light e-section">
        <div class="e-wrap">
            <div class="e-section-head e-reveal">
                <span class="e-eyebrow">Layanan Kami</span>
                <h2>Bukan cuma jual mobil, kami dampingi sampai tuntas</h2>
            </div>
            <div class="row g-4 g-lg-5">
                @foreach($services as $service)
                <div class="col-md-6 col-lg-4 e-reveal">
                    <div class="e-feature">
                        <div class="e-feature-icon"><i class="bi {{ $service->icon }}"></i></div>
                        <div>
                            <h4>{{ $service->title }}</h4>
                            @if($service->desc)<p class="e-muted">{{ Str::limit(strip_tags($service->desc), 110) }}</p>@endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============ SPOTLIGHT ============ --}}
    @if($featuredVehicle)
    <section id="spotlight" class="e-dark e-section">
        <div class="e-wrap">
            <div class="e-spotlight-grid">
                <div class="e-spotlight-img e-reveal">
                    <img src="{{ $featuredVehicle->image_url }}" alt="{{ $featuredVehicle->name }}">
                </div>
                <div class="e-spotlight-text e-reveal">
                    <span class="e-spotlight-kicker">Unit Pilihan</span>
                    <h3>{{ $featuredVehicle->name }}</h3>
                    @if($featuredVehicle->tagline)<p class="e-desc e-muted">{{ $featuredVehicle->tagline }}</p>@endif

                    <div class="e-price-row">
                        @if($featuredVehicle->disc > 0)
                        <span class="e-price-now">{{ $featuredVehicle->special_min_price }}</span>
                        <span class="e-price-old">{{ $featuredVehicle->min_price }}</span>
                        <span class="e-price-badge">Promo</span>
                        @else
                        <span class="e-price-now">{{ $featuredVehicle->min_price }}</span>
                        @endif
                    </div>

                    <ul class="e-spec-list">
                        <li><span class="e-muted">Kategori</span><span>{{ $featuredVehicle->product_category->category ?? '-' }}</span></li>
                        @if($featuredVehicle->product_type->count())
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
    @if($exploreProducts->count())
    <section class="e-light e-section">
        <div class="e-wrap">
            <div class="e-section-head e-reveal">
                <span class="e-eyebrow">Jajaran Lainnya</span>
                <h2>Pilihan lain yang mungkin lebih cocok untuk Anda</h2>
            </div>
            <div class="row g-4">
                @foreach($exploreProducts as $product)
                <div class="col-md-6 col-lg-4 e-reveal">
                    <div class="e-product-item">
                        <div class="e-product-img">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                        </div>
                        <div class="e-product-meta">
                            <h4>{{ $product->name }}</h4>
                            <span class="e-muted">{{ $product->min_price }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============ PROMO (countdown) ============ --}}
    @if($promos->count())
    <section class="e-dark-2 e-section">
        <div class="e-wrap">
            <div class="e-section-head e-reveal">
                <span class="e-eyebrow">Promo Berjalan</span>
                <h2>Penawaran terbatas, jangan sampai terlewat</h2>
            </div>
            @foreach($promos as $promo)
            <div class="e-promo-card e-reveal">
                @if($promo->promo_image_url)
                <div class="e-promo-img"><img src="{{ $promo->promo_image_url }}" alt="{{ $promo->promo }}" loading="lazy"></div>
                @endif
                <div class="e-promo-body">
                    <h3>{{ $promo->promo }}</h3>
                    @if($promo->desc)<p class="e-muted">{{ Str::limit(strip_tags($promo->desc), 140) }}</p>@endif

                    @if($promo->effective_date)
                    <div class="e-countdown" data-countdown="{{ $promo->effective_date->format('Y-m-d') }} 23:59:59">
                        <div class="e-countdown-unit"><div class="e-countdown-num" data-unit="days">00</div><div class="e-countdown-label">Hari</div></div>
                        <div class="e-countdown-unit"><div class="e-countdown-num" data-unit="hours">00</div><div class="e-countdown-label">Jam</div></div>
                        <div class="e-countdown-unit"><div class="e-countdown-num" data-unit="minutes">00</div><div class="e-countdown-label">Menit</div></div>
                        <div class="e-countdown-unit"><div class="e-countdown-num" data-unit="seconds">00</div><div class="e-countdown-label">Detik</div></div>
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
    @if($galleries->count())
    <section class="e-light e-section">
        <div class="e-wrap">
            <div class="e-section-head e-reveal">
                <span class="e-eyebrow">Galeri</span>
                <h2>Momen di showroom &amp; acara kami</h2>
            </div>
            <div class="row g-3">
                @foreach($galleries as $gallery)
                <div class="col-6 col-lg-4 e-reveal">
                    <a href="{{ route('gallery.show', $gallery->slug) }}" class="e-gallery-item text-decoration-none">
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
    @if($deliveries->count())
    <section class="e-dark e-section">
        <div class="e-wrap">
            <div class="e-section-head e-reveal">
                <span class="e-eyebrow">Bukti Nyata</span>
                <h2>Serah Terima Unit Terbaru</h2>
                <p class="e-muted">Bukan janji, ini unit yang benar-benar sudah kami serahkan ke pelanggan.</p>
            </div>
            <div class="row g-4">
                @foreach($deliveries as $delivery)
                @php $deliveryImg = $delivery->getFirstMediaUrl('images'); @endphp
                @if($deliveryImg)
                <div class="col-6 col-lg-4 e-reveal">
                    <div class="e-delivery-item">
                        <div class="e-delivery-img"><img src="{{ $deliveryImg }}" alt="Serah terima {{ $delivery->product->name ?? '' }}" loading="lazy"></div>
                        <div class="e-delivery-badge"><i class="bi bi-patch-check-fill"></i> Sudah Diserahkan</div>
                        @if($delivery->product)<h4>{{ $delivery->product->name }}</h4>@endif
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
                @if($stats['deliveries_count'] > 0)
                <div class="e-reveal">
                    <div class="e-stat-num"><span class="e-count" data-count="{{ $stats['deliveries_count'] }}">0</span>+</div>
                    <div class="e-stat-label e-muted">Unit Diserahkan</div>
                </div>
                @endif
                @if($stats['testimonies_count'] > 0)
                <div class="e-reveal">
                    <div class="e-stat-num"><span class="e-count" data-count="{{ $stats['testimonies_count'] }}">0</span>+</div>
                    <div class="e-stat-label e-muted">Cerita Pelanggan</div>
                </div>
                @endif
                @if($stats['avg_rating'])
                <div class="e-reveal">
                    <div class="e-stat-num">{{ $stats['avg_rating'] }}<span style="font-size:.5em;">/5</span></div>
                    <div class="e-stat-label e-muted">Rata-rata Rating</div>
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ============ TESTIMONIAL ============ --}}
    @if($testimonies->count())
    <section class="e-dark e-section">
        <div class="e-wrap">
            <span class="e-eyebrow e-reveal">Testimoni</span>
            <div class="swiper init-swiper">
                <script type="application/json" class="swiper-config">
                    { "loop": true, "speed": 700, "autoplay": { "delay": 5000, "disableOnInteraction": false }, "slidesPerView": 1 }
                </script>
                <div class="swiper-wrapper">
                    @foreach($testimonies as $testimony)
                    <div class="swiper-slide">
                        <div class="e-testi-mark">&rdquo;</div>
                        <p class="e-testi-text">{{ Str::limit(strip_tags($testimony->message), 180) }}</p>
                        <div class="e-testi-name">{{ $testimony->name }}</div>
                        @if($testimony->job)<div class="e-testi-job e-muted">{{ $testimony->job }}</div>@endif
                        <div class="e-testi-stars">
                            @for($i = 0; $i < ($testimony->rating ?: 5); $i++)<i class="bi bi-star-fill"></i>@endfor
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ============ FAQ ============ --}}
    @if(!empty($landingPage->faqs))
    <section class="e-light e-section">
        <div class="e-wrap" style="max-width:760px;">
            <div class="e-section-head e-reveal">
                <span class="e-eyebrow">FAQ</span>
                <h2>Pertanyaan Umum</h2>
            </div>
            <div>
                @foreach($landingPage->faqs as $faq)
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
    @php $allProducts = $featuredVehicle ? $exploreProducts->prepend($featuredVehicle) : $exploreProducts; @endphp
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
                                @foreach($allProducts as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="e-field"><label>Pesan (opsional)</label><textarea name="message" placeholder="Contoh: mau tanya simulasi kredit DP 20 juta"></textarea></div>
                        <button type="submit" class="e-btn e-btn-gold e-submit" id="lp-submit-btn">
                            <i class="bi bi-send-fill"></i> Kirim &amp; Chat WhatsApp
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="e-footer">
        &copy; {{ date('Y') }} {{ $profile->name ?? config('settings.site_name') }}. Semua hak dilindungi.
        @if($profile->phone ?? null) &bull; {{ $profile->phone }} @endif
    </footer>

    <div class="e-sticky-bar">
        <a href="tel:{{ $profile->phone ?? '' }}" class="e-sticky-call"><i class="bi bi-telephone-fill me-1"></i> Telepon</a>
        <a href="{{ $profile->wa_url }}" target="_blank" class="e-sticky-wa"><i class="bi bi-whatsapp me-1"></i> WhatsApp</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ mix('frontend/js/app.js') }}"></script>
    <script>
        (function () {
            /* ---------- GSAP reveal ringan (sekali, bukan scroll-linked) ---------- */
            if (window.gsap && window.ScrollTrigger) {
                gsap.registerPlugin(ScrollTrigger);
                gsap.timeline().to('.e-hero .e-reveal', { opacity: 1, y: 0, duration: 1, stagger: .12, ease: 'power3.out', delay: .2 });
                document.querySelectorAll('.e-reveal:not(.e-hero .e-reveal)').forEach(function (el) {
                    gsap.to(el, { opacity: 1, y: 0, duration: .9, ease: 'power3.out', scrollTrigger: { trigger: el, start: 'top 88%', once: true } });
                });
                document.querySelectorAll('.e-count').forEach(function (el) {
                    const target = parseInt(el.dataset.count, 10) || 0;
                    const obj = { val: 0 };
                    ScrollTrigger.create({
                        trigger: el, start: 'top 90%', once: true,
                        onEnter: function () {
                            gsap.to(obj, { val: target, duration: 1.6, ease: 'power2.out', onUpdate: function () { el.textContent = Math.floor(obj.val); } });
                        }
                    });
                });
            } else {
                document.querySelectorAll('.e-reveal').forEach(function (el) { el.style.opacity = 1; el.style.transform = 'none'; });
                document.querySelectorAll('.e-count').forEach(function (el) { el.textContent = el.dataset.count; });
            }

            /* ---------- Countdown promo ---------- */
            document.querySelectorAll('[data-countdown]').forEach(function (box) {
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
            document.querySelectorAll('[data-faq-toggle]').forEach(function (btn) {
                btn.addEventListener('click', function () {
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
            utmFields.forEach(function (key) {
                utmData[key] = params.get(key) || sessionStorage.getItem('lp_' + key) || '';
                if (params.get(key)) sessionStorage.setItem('lp_' + key, params.get(key));
            });

            document.querySelectorAll('.lp-pilih-produk').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const select = document.getElementById('lp-product-select');
                    if (select) select.value = this.dataset.productId;
                });
            });

            /* ---------- Submit lead ---------- */
            const form = document.getElementById('lp-lead-form');
            const alertBox = document.getElementById('lp-form-alert');
            const submitBtn = document.getElementById('lp-submit-btn');

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Mengirim...';
                alertBox.innerHTML = '';

                const formData = new FormData(form);
                Object.keys(utmData).forEach(function (key) { formData.append(key, utmData[key]); });
                formData.append('landing_url', window.location.href);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('{{ route('landing.lead.store') }}', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                })
                    .then(function (res) { return res.json().then(function (data) { return { status: res.status, data: data }; }); })
                    .then(function (result) {
                        if (result.status === 200 && result.data.status === 'success') {
                            alertBox.innerHTML = '<div class="alert alert-success">' + result.data.message + '</div>';
                            form.reset();
                            try { {!! $landingPage->tracking_conversion_script !!} } catch (err) {}
                            window.open(result.data.wa_text, '_blank');
                        } else {
                            const errors = result.data.errors || {};
                            const firstError = Object.values(errors)[0];
                            alertBox.innerHTML = '<div class="alert alert-danger">' + (firstError ? firstError[0] : 'Terjadi kesalahan, silakan coba lagi.') + '</div>';
                        }
                    })
                    .catch(function () {
                        alertBox.innerHTML = '<div class="alert alert-danger">Gagal mengirim, periksa koneksi internet Anda.</div>';
                    })
                    .finally(function () {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="bi bi-send-fill"></i> Kirim & Chat WhatsApp';
                    });
            });
        })();
    </script>
</body>

</html>
