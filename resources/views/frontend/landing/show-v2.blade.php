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
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    {{-- CSS situs utama tetap dipakai supaya bootstrap-icons & swiper (dipakai testimoni) konsisten --}}
    <link rel="stylesheet" href="{{ mix('frontend/css/app.css') }}">

    {{-- GSAP + ScrollTrigger via CDN, khusus dipakai di halaman ini untuk scroll reveal --}}
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

    {!! $landingPage->tracking_head_script !!}

    <style>
        :root {
            --v-ink: #0a0a0c;
            --v-ink-2: #131317;
            --v-paper: #fafafa;
            --v-muted: #8a8a94;
            --v-line: rgba(255, 255, 255, .12);
            --v-line-dark: rgba(10, 10, 12, .1);
            --v-accent: #e63946;
            --v-font-display: 'Sora', sans-serif;
            --v-font-body: 'Roboto', sans-serif;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: auto; }

        html, body {
            background: var(--v-ink) !important;
        }

        body {
            font-family: var(--v-font-body);
            color: #e8e8ea;
            margin: 0;
            overflow-x: hidden;
            padding-bottom: 76px;
        }

        img { max-width: 100%; display: block; }

        h1, h2, h3, h4, .v-display {
            font-family: var(--v-font-display);
            font-weight: 700;
            letter-spacing: -.01em;
            margin: 0;
        }

        .v-wrap { max-width: 1240px; margin: 0 auto; padding: 0 24px; }
        .v-section { padding: 120px 0; position: relative; }
        .v-light { background: var(--v-paper); color: var(--v-ink); }
        .v-light h1, .v-light h2, .v-light h3, .v-light h4 { color: var(--v-ink); }
        .v-light .v-muted { color: #6b6b74; }
        .v-muted { color: var(--v-muted); }

        .v-eyebrow {
            font-family: var(--v-font-body);
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--v-accent);
            margin-bottom: 18px;
            display: block;
        }

        .v-line { color: transparent; -webkit-text-stroke: 1px currentColor; }

        /* ===== reveal (GSAP target) ===== */
        .v-reveal { opacity: 0; transform: translateY(40px); }

        /* ===== Buttons - minimal, no heavy card look ===== */
        .v-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-family: var(--v-font-body);
            font-weight: 700;
            font-size: 14px;
            letter-spacing: .3px;
            padding: 16px 32px;
            border-radius: 999px;
            text-decoration: none;
            border: 1.5px solid currentColor;
            transition: all .35s cubic-bezier(.16, 1, .3, 1);
            cursor: pointer;
            background: transparent;
        }

        .v-btn-solid { background: var(--v-accent); border-color: var(--v-accent); color: #fff !important; }
        .v-btn-solid:hover { background: transparent; color: var(--v-accent) !important; }

        .v-btn-line { color: #fff; }
        .v-btn-line:hover { background: #fff; color: var(--v-ink) !important; }

        .v-light .v-btn-line { color: var(--v-ink); }
        .v-light .v-btn-line:hover { background: var(--v-ink); color: #fff !important; }

        /* ===== Sticky top bar (minimal, no glass card box) ===== */
        .v-topbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            display: flex; align-items: center; justify-content: space-between;
            padding: 22px 28px;
            mix-blend-mode: difference;
        }
        .v-topbar-brand { font-family: var(--v-font-display); font-weight: 700; font-size: 15px; color: #fff; text-decoration: none; }
        .v-topbar-cta { font-family: var(--v-font-body); font-weight: 700; font-size: 13px; color: #fff; text-decoration: none; display: flex; align-items: center; gap: 6px; }

        /* ===== HERO ===== */
        .v-hero {
            position: relative;
            min-height: 100svh;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .v-hero-glow {
            position: absolute;
            inset: 0;
            background: linear-gradient(100deg, transparent 40%, rgba(230, 57, 70, .16) 70%, rgba(230, 57, 70, .05) 100%);
            pointer-events: none;
        }

        .v-hero-content { position: relative; z-index: 2; width: 100%; padding-top: 60px; }

        .v-hero-eyebrow {
            display: inline-flex; align-items: center; gap: 10px;
            font-size: 12.5px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;
            color: #cfcfd4; margin-bottom: 26px;
        }
        .v-hero-eyebrow .v-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--v-accent); box-shadow: 0 0 12px var(--v-accent); }

        .v-hero h1 {
            font-size: clamp(40px, 7vw, 92px);
            line-height: .98;
            color: #fff;
            max-width: 900px;
        }

        .v-hero p.v-hero-desc {
            font-family: var(--v-font-body);
            font-weight: 300;
            font-size: 19px;
            line-height: 1.7;
            color: #a9a9b2;
            max-width: 480px;
            margin: 28px 0 40px;
        }

        .v-hero-actions { display: flex; flex-wrap: wrap; gap: 16px; }

        .v-hero-vehicle {
            position: absolute;
            right: -4%;
            bottom: 0;
            width: 62%;
            max-width: 900px;
            z-index: 1;
        }

        .v-hero-vehicle img {
            width: 100%;
            filter: drop-shadow(0 40px 60px rgba(0, 0, 0, .6));
        }

        .v-scroll-cue {
            position: absolute; bottom: 36px; left: 24px;
            display: flex; align-items: center; gap: 12px;
            font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: #7a7a82;
            z-index: 2;
        }
        .v-scroll-cue::before {
            content: ''; width: 1px; height: 46px; background: linear-gradient(#fff, transparent);
            animation: vScrollLine 2s ease-in-out infinite;
        }
        @keyframes vScrollLine { 0% { opacity: 0; } 50% { opacity: 1; } 100% { opacity: 0; } }

        /* ===== Statement (giant scroll text) ===== */
        .v-statement { padding: 160px 0; text-align: center; }
        .v-statement h2 {
            font-size: clamp(28px, 5vw, 58px);
            line-height: 1.25;
            max-width: 900px;
            margin: 0 auto;
            color: #d8d8dc;
        }
        .v-statement h2 em { font-style: normal; color: #fff; }

        /* ===== Feature / Service rows (minimal, no card box) ===== */
        .v-feature-item { display: flex; gap: 18px; align-items: flex-start; }
        .v-feature-icon {
            width: 48px; height: 48px; border-radius: 50%; flex-shrink: 0;
            background: rgba(230, 57, 70, .12);
            color: var(--v-accent);
            display: flex; align-items: center; justify-content: center; font-size: 20px;
        }
        .v-light .v-feature-icon { background: rgba(230, 57, 70, .08); }
        .v-feature-item h4 { font-size: 16px; margin-bottom: 6px; }
        .v-feature-item p { font-size: 14px; color: #a9a9b2; margin: 0; line-height: 1.7; }
        .v-light .v-feature-item p { color: #6b6b74; }

        /* ===== Spotlight (sticky editorial) ===== */
        .v-spotlight { padding: 0; }
        .v-spotlight-grid { display: grid; grid-template-columns: 1fr; gap: 0; }

        @media (min-width: 992px) {
            .v-spotlight-grid { grid-template-columns: 1.1fr .9fr; }
        }

        .v-spotlight-media { position: relative; }
        .v-spotlight-media-inner {
            position: sticky;
            top: 0;
            height: 100svh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: linear-gradient(180deg, #14141a, #0a0a0c);
        }
        .v-spotlight-media-inner img { width: 100%; height: 100%; object-fit: cover; opacity: .92; }

        .v-spotlight-text { padding: 100px 0; }
        .v-spotlight-block { padding: 60px 48px; min-height: 60vh; display: flex; flex-direction: column; justify-content: center; }

        .v-spotlight-kicker { font-size: 12px; letter-spacing: 3px; text-transform: uppercase; color: var(--v-accent); font-weight: 700; margin-bottom: 16px; }
        .v-spotlight-block h3 { font-size: clamp(26px, 3.2vw, 40px); margin-bottom: 18px; color: #fff; }
        .v-spotlight-block p { color: #a9a9b2; font-size: 15.5px; line-height: 1.8; max-width: 420px; margin-bottom: 24px; }

        .v-spec-list { list-style: none; padding: 0; margin: 0 0 28px; display: flex; flex-direction: column; gap: 12px; }
        .v-spec-list li {
            display: flex; justify-content: space-between; gap: 20px;
            padding-bottom: 12px; border-bottom: 1px solid var(--v-line);
            font-size: 13.5px; color: #cfcfd4;
        }
        .v-spec-list li span:first-child { color: #7a7a82; }

        .v-price-row { display: flex; align-items: baseline; gap: 12px; margin-bottom: 26px; }
        .v-price-now { font-family: var(--v-font-display); font-size: 26px; font-weight: 700; color: #fff; }
        .v-price-old { font-size: 14px; color: #7a7a82; text-decoration: line-through; }
        .v-price-badge { font-size: 11px; font-weight: 700; color: var(--v-accent); border: 1px solid var(--v-accent); padding: 3px 10px; border-radius: 999px; }

        .v-view-count { display: inline-flex; align-items: center; gap: 8px; font-size: 12.5px; color: #7a7a82; margin-bottom: 26px; }
        .v-view-count i { color: var(--v-accent); }

        /* ===== Explore lineup (editorial grid, no card box) ===== */
        .v-explore-item { position: relative; overflow: hidden; margin-bottom: 6px; }
        .v-explore-img { position: relative; overflow: hidden; aspect-ratio: 4/3; background: #111; }
        .v-explore-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 1s cubic-bezier(.16, 1, .3, 1), filter .5s ease; filter: brightness(.82); }
        .v-explore-item:hover .v-explore-img img { transform: scale(1.06); filter: brightness(1); }

        .v-explore-meta { display: flex; justify-content: space-between; align-items: baseline; padding-top: 16px; }
        .v-explore-meta h4 { font-size: 17px; color: #fff; }
        .v-explore-meta span { font-size: 13.5px; color: #7a7a82; font-family: var(--v-font-body); }

        .v-explore-link {
            position: absolute; top: 16px; right: 16px;
            width: 40px; height: 40px; border-radius: 50%;
            background: rgba(255, 255, 255, .12);
            backdrop-filter: blur(6px);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 16px;
            opacity: 0; transform: translateY(-8px);
            transition: all .35s ease;
        }
        .v-explore-item:hover .v-explore-link { opacity: 1; transform: translateY(0); }
        .v-light .v-explore-link { background: rgba(10, 10, 12, .08); color: var(--v-ink); }

        /* ===== Category storytelling ===== */
        .v-story-section { padding: 100px 0; position: relative; }
        .v-story-heading { font-size: clamp(34px, 5vw, 64px); margin-bottom: 44px; }
        .v-story-row { display: flex; gap: 24px; overflow-x: auto; padding-bottom: 8px; scrollbar-width: none; }
        .v-story-row::-webkit-scrollbar { display: none; }
        .v-story-card { flex: 0 0 auto; width: min(78vw, 320px); }
        .v-story-card .v-explore-img { aspect-ratio: 3/4; }
        .v-story-card h4 { font-size: 15.5px; margin-top: 14px; }
        .v-story-card span { font-size: 13px; color: #9a9aa4; }
        .v-light .v-story-card span { color: #6b6b74; }

        /* ===== Promo (full bleed, no card) ===== */
        .v-promo { padding: 140px 0; text-align: center; position: relative; overflow: hidden; background: linear-gradient(135deg, #1a1015 0%, var(--v-ink) 55%); }
        .v-promo h2 { font-size: clamp(30px, 5vw, 56px); color: #fff; margin-bottom: 20px; position: relative; }
        .v-promo p { color: #a9a9b2; max-width: 480px; margin: 0 auto 34px; position: relative; }

        /* ===== Stats (inline numbers, no cards) ===== */
        .v-stats-row { display: flex; flex-wrap: wrap; gap: 60px; justify-content: center; text-align: center; }
        .v-stat-num { font-family: var(--v-font-display); font-size: clamp(38px, 5vw, 60px); font-weight: 700; color: #fff; line-height: 1; }
        .v-stat-label { font-size: 12.5px; letter-spacing: 1px; text-transform: uppercase; color: #7a7a82; margin-top: 10px; }

        /* ===== Testimonial (minimal quote) ===== */
        .v-testi-quote-mark { font-family: var(--v-font-display); font-size: 90px; color: var(--v-accent); opacity: .3; line-height: .5; margin-bottom: 10px; }
        .v-testi-text { font-size: clamp(20px, 2.6vw, 30px); font-family: var(--v-font-display); font-weight: 500; line-height: 1.5; color: #fff; max-width: 780px; margin: 0 auto 32px; }
        .v-testi-name { font-weight: 700; font-size: 14.5px; color: #fff; }
        .v-testi-job { font-size: 13px; color: #7a7a82; }
        .v-testi-stars { color: var(--v-accent); font-size: 13px; margin-top: 6px; }

        /* ===== FAQ (line list, no cards) ===== */
        .v-faq-item { border-bottom: 1px solid var(--v-line-dark); }
        .v-faq-btn {
            width: 100%; text-align: left; background: none; border: none;
            padding: 26px 0; display: flex; justify-content: space-between; align-items: center;
            font-family: var(--v-font-display); font-weight: 600; font-size: 17px; color: var(--v-ink);
            cursor: pointer;
        }
        .v-faq-icon { font-size: 20px; color: var(--v-accent); transition: transform .35s ease; flex-shrink: 0; margin-left: 20px; }
        .v-faq-btn[aria-expanded="true"] .v-faq-icon { transform: rotate(135deg); }
        .v-faq-panel { max-height: 0; overflow: hidden; transition: max-height .4s ease; }
        .v-faq-panel-inner { padding-bottom: 26px; color: #5a5a64; font-size: 14.5px; line-height: 1.8; max-width: 640px; }

        /* ===== Final CTA / Form ===== */
        .v-cta-section { padding: 130px 0 100px; }
        .v-cta-grid { display: grid; grid-template-columns: 1fr; gap: 60px; }
        @media (min-width: 992px) { .v-cta-grid { grid-template-columns: .9fr 1.1fr; } }

        .v-cta-left h2 { font-size: clamp(30px, 4vw, 48px); color: #fff; margin-bottom: 20px; }
        .v-cta-left p { color: #a9a9b2; font-size: 16px; line-height: 1.8; max-width: 420px; margin-bottom: 36px; }

        .v-benefit-row { display: flex; align-items: center; gap: 14px; padding: 16px 0; border-top: 1px solid var(--v-line); }
        .v-benefit-row:last-child { border-bottom: 1px solid var(--v-line); }
        .v-benefit-row i { color: var(--v-accent); font-size: 18px; }
        .v-benefit-row span { font-size: 14px; color: #cfcfd4; }

        .v-field { position: relative; margin-bottom: 30px; }
        .v-field label { display: block; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; color: #7a7a82; margin-bottom: 10px; }
        .v-field input, .v-field select, .v-field textarea {
            width: 100%; background: transparent; border: none; border-bottom: 1.5px solid var(--v-line);
            color: #fff; font-family: var(--v-font-body); font-size: 16px; padding: 8px 2px 12px;
            border-radius: 0; transition: border-color .3s ease;
        }
        .v-field select option { color: #000; }
        .v-field input:focus, .v-field select:focus, .v-field textarea:focus {
            outline: none; border-color: var(--v-accent);
        }
        .v-field textarea { resize: vertical; min-height: 70px; }

        .v-submit { width: 100%; justify-content: center; margin-top: 10px; }

        /* ===== Footer ===== */
        .v-footer { padding: 40px 0; text-align: center; font-size: 13px; color: #5a5a64; border-top: 1px solid var(--v-line); }

        /* ===== Sticky mobile bar ===== */
        .v-sticky-bar {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 1040;
            background: #0a0a0c; border-top: 1px solid var(--v-line);
            padding: 12px 20px; display: flex; gap: 10px;
        }
        .v-sticky-bar a { flex: 1; text-align: center; padding: 13px; border-radius: 999px; font-weight: 700; font-size: 13.5px; text-decoration: none; }
        .v-sticky-call { border: 1.5px solid #fff; color: #fff; }
        .v-sticky-wa { background: #25d366; color: #fff; }

        @media (min-width: 992px) {
            .v-sticky-bar { display: none; }
            body { padding-bottom: 0; }
        }

        @media (max-width: 767px) {
            .v-section { padding: 80px 0; }
            .v-hero-vehicle { position: relative; width: 100%; right: 0; margin-top: 40px; }
            .v-hero { min-height: auto; padding: 130px 0 60px; flex-direction: column; }
            .v-hero-content { padding-top: 0; }
            .v-spotlight-block { padding: 40px 24px; min-height: auto; }
            .v-spotlight-media-inner { height: 46vh; position: relative; top: auto; }
        }
    </style>
</head>

<body>

    <div class="v-topbar">
        <a href="#" class="v-topbar-brand">{{ $profile->name ?? config('settings.site_name') }}</a>
        <a href="{{ $profile->wa_url }}" target="_blank" class="v-topbar-cta"><i class="bi bi-whatsapp"></i> {{ $profile->phone ?? 'Chat Kami' }}</a>
    </div>

    {{-- ============ HERO ============ --}}
    <section class="v-hero">
        <div class="v-hero-glow" data-parallax="glow"></div>
        <div class="v-hero-grid"></div>

        <div class="v-wrap v-hero-content">
            <div class="v-hero-eyebrow v-reveal"><span class="v-dot"></span> {{ $landingPage->hero_badge ?: 'Digital Showroom' }}</div>
            <h1 class="v-reveal">{{ $landingPage->headline }}</h1>
            @if($landingPage->subheadline)
            <p class="v-hero-desc v-reveal">{{ $landingPage->subheadline }}</p>
            @endif
            <div class="v-hero-actions v-reveal">
                <a href="#konsultasi" class="v-btn v-btn-solid">{{ $landingPage->hero_cta_label ?: 'Konsultasi Sekarang' }}</a>
                @if($featuredVehicle)
                <a href="#spotlight" class="v-btn v-btn-line"><i class="bi bi-arrow-down"></i> Lihat Mobilnya</a>
                @endif
            </div>
        </div>

        @php $heroImg = $featuredVehicle ? ($featuredVehicle->header_image_url ?: $featuredVehicle->image_url) : ($landingPage->hero_image_url ?: null); @endphp
        @if($heroImg)
        <div class="v-hero-vehicle" data-parallax="car">
            <img src="{{ $heroImg }}" alt="{{ $featuredVehicle->name ?? $landingPage->headline }}">
        </div>
        @endif

        <div class="v-scroll-cue">Scroll untuk eksplorasi</div>
    </section>

    {{-- ============ STATEMENT ============ --}}
    <section class="v-statement v-wrap">
        <h2 class="v-reveal">Dibuat untuk mereka yang <em>tidak mau menunggu lama</em> demi mobil yang tepat, <em>bukan sekadar mobil yang ada.</em></h2>
    </section>

    {{-- ============ USP (dari admin, tab "Kenapa Pilih Kami") ============ --}}
    @if(!empty($landingPage->usp_items))
    <section class="v-section">
        <div class="v-wrap">
            <span class="v-eyebrow v-reveal">Kenapa Pilih Kami</span>
            <div class="row g-4 g-lg-5">
                @foreach($landingPage->usp_items as $item)
                <div class="col-md-6 col-lg-3 v-reveal">
                    <div class="v-feature-item">
                        <div class="v-feature-icon"><i class="{{ $item['icon'] ?? 'bi bi-check-circle' }}"></i></div>
                        <div>
                            <h4>{{ $item['title'] ?? '' }}</h4>
                            <p>{{ $item['desc'] ?? '' }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============ SPOTLIGHT (featured vehicle) ============ --}}
    @if($featuredVehicle)
    <section id="spotlight" class="v-spotlight">
        <div class="v-spotlight-grid">
            <div class="v-spotlight-media">
                <div class="v-spotlight-media-inner">
                    <img src="{{ $featuredVehicle->header_image_url ?: $featuredVehicle->image_url }}" alt="{{ $featuredVehicle->name }}">
                </div>
            </div>

            <div class="v-spotlight-text">
                <div class="v-spotlight-block v-reveal">
                    <span class="v-spotlight-kicker">Unit Pilihan</span>
                    <h3>{{ $featuredVehicle->hero_name ?: $featuredVehicle->name }}</h3>
                    @if($featuredVehicle->tagline)
                    <p>{{ $featuredVehicle->tagline }}</p>
                    @endif

                    <div class="v-price-row">
                        @if($featuredVehicle->disc > 0)
                        <span class="v-price-now">{{ $featuredVehicle->special_min_price }}</span>
                        <span class="v-price-old">{{ $featuredVehicle->min_price }}</span>
                        <span class="v-price-badge">Promo</span>
                        @else
                        <span class="v-price-now">{{ $featuredVehicle->min_price }}</span>
                        @endif
                    </div>

                    @php $featuredVehicleViews = $featuredVehicle->visitStats()->count(); @endphp
                    @if($featuredVehicleViews > 0)
                    <div class="v-view-count"><i class="bi bi-eye-fill"></i> Dilihat {{ number_format($featuredVehicleViews) }} kali oleh calon pembeli lain</div>
                    @endif

                    <ul class="v-spec-list">
                        <li><span>Kategori</span><span>{{ $featuredVehicle->product_category->category ?? '-' }}</span></li>
                        @if($featuredVehicle->product_type->count())
                        <li><span>Varian Tersedia</span><span>{{ $featuredVehicle->product_type->pluck('type')->implode(' / ') }}</span></li>
                        @endif
                    </ul>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('product.detail', $featuredVehicle->slug) }}" class="v-btn v-btn-line">Detail Lengkap</a>
                        <a href="#konsultasi" class="v-btn v-btn-solid lp-pilih-produk" data-product-id="{{ $featuredVehicle->id }}">Tanya Harga</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ============ EXPLORE LINEUP ============ --}}
    @if($exploreProducts->count())
    <section class="v-section">
        <div class="v-wrap">
            <span class="v-eyebrow v-reveal">Jajaran Lainnya</span>
            <h2 class="v-story-heading v-reveal">Mobil mana yang <span style="color:var(--v-accent);">terasa seperti Anda?</span></h2>

            <div class="row g-4">
                @foreach($exploreProducts as $product)
                <div class="col-md-6 col-lg-4 v-reveal">
                    <div class="v-explore-item">
                        <div class="v-explore-img">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                            <a href="{{ route('product.detail', $product->slug) }}" class="v-explore-link"><i class="bi bi-arrow-up-right"></i></a>
                        </div>
                        <div class="v-explore-meta">
                            <h4>{{ $product->name }}</h4>
                            <span>{{ $product->min_price }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============ LAYANAN (data nyata dari menu Service admin) ============ --}}
    @if($services->count())
    <section class="v-section v-light">
        <div class="v-wrap">
            <span class="v-eyebrow v-reveal">Layanan Kami</span>
            <h2 class="v-story-heading v-reveal">Bukan cuma jual mobil, <span style="color:var(--v-accent);">kami dampingi sampai tuntas.</span></h2>

            <div class="row g-4 g-lg-5">
                @foreach($services as $service)
                <div class="col-md-6 col-lg-4 v-reveal">
                    <div class="v-feature-item">
                        <div class="v-feature-icon"><i class="bi {{ $service->icon }}"></i></div>
                        <div>
                            <h4>{{ $service->title }}</h4>
                            @if($service->desc)
                            <p>{{ Str::limit(strip_tags($service->desc), 110) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============ CATEGORY STORYTELLING ============ --}}
    @foreach($categoryShowcase as $category)
    <section class="v-story-section {{ $loop->even ? 'v-light' : '' }}">
        <div class="v-wrap">
            <span class="v-eyebrow v-reveal">Dibuat untuk</span>
            <h2 class="v-story-heading v-reveal">{{ $category->category }}</h2>

            <div class="v-story-row">
                @foreach($category->products as $product)
                <div class="v-story-card v-reveal">
                    <div class="v-explore-img">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                        <a href="{{ route('product.detail', $product->slug) }}" class="v-explore-link"><i class="bi bi-arrow-up-right"></i></a>
                    </div>
                    <h4 style="{{ $loop->parent->even ? 'color:var(--v-ink)' : 'color:#fff' }}">{{ $product->name }}</h4>
                    <span>{{ $product->min_price }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endforeach

    {{-- ============ PROMO ============ --}}
    @if($promo)
    <section class="v-promo">
        <div class="v-wrap">
            <span class="v-eyebrow v-reveal">Promo Berjalan</span>
            <h2 class="v-reveal">{{ $promo->promo }}</h2>
            @if($promo->desc ?? null)
            <p class="v-reveal">{{ Str::limit(strip_tags($promo->desc), 150) }}</p>
            @endif
            <a href="#konsultasi" class="v-btn v-btn-solid v-reveal">Klaim Promo Ini</a>
        </div>
    </section>
    @endif

    {{-- ============ STATS (data asli) ============ --}}
    <section class="v-section" style="padding-top:60px; padding-bottom:60px;">
        <div class="v-wrap">
            <div class="v-stats-row">
                <div class="v-reveal">
                    <div class="v-stat-num"><span class="v-count" data-count="{{ $stats['products_count'] }}">0</span>+</div>
                    <div class="v-stat-label">Pilihan Mobil Tersedia</div>
                </div>
                @if($stats['testimonies_count'] > 0)
                <div class="v-reveal">
                    <div class="v-stat-num"><span class="v-count" data-count="{{ $stats['testimonies_count'] }}">0</span>+</div>
                    <div class="v-stat-label">Cerita Pelanggan</div>
                </div>
                @endif
                @if($stats['avg_rating'])
                <div class="v-reveal">
                    <div class="v-stat-num">{{ $stats['avg_rating'] }}<span style="font-size:.5em;">/5</span></div>
                    <div class="v-stat-label">Rata-rata Rating</div>
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ============ TESTIMONIAL ============ --}}
    @if($testimonies->count())
    <section class="v-section" style="padding-top:60px;">
        <div class="v-wrap text-center">
            <span class="v-eyebrow v-reveal">Testimoni</span>

            <div class="swiper init-swiper">
                <script type="application/json" class="swiper-config">
                    { "loop": true, "speed": 700, "autoplay": { "delay": 5000, "disableOnInteraction": false }, "slidesPerView": 1 }
                </script>
                <div class="swiper-wrapper">
                    @foreach($testimonies as $testimony)
                    <div class="swiper-slide">
                        <div class="v-testi-quote-mark">&rdquo;</div>
                        <p class="v-testi-text">{{ Str::limit(strip_tags($testimony->message), 180) }}</p>
                        <div class="v-testi-name">{{ $testimony->name }}</div>
                        @if($testimony->job)<div class="v-testi-job">{{ $testimony->job }}</div>@endif
                        <div class="v-testi-stars">
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
    <section class="v-section v-light">
        <div class="v-wrap" style="max-width:760px;">
            <span class="v-eyebrow v-reveal">FAQ</span>
            <h2 class="v-story-heading v-reveal" style="font-size:clamp(28px,3.6vw,42px);">Pertanyaan Umum</h2>

            <div>
                @foreach($landingPage->faqs as $faq)
                <div class="v-faq-item v-reveal">
                    <button class="v-faq-btn" type="button" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" data-faq-toggle>
                        {{ $faq['question'] ?? '' }}
                        <span class="v-faq-icon"><i class="bi bi-plus"></i></span>
                    </button>
                    <div class="v-faq-panel" style="{{ $loop->first ? 'max-height:400px;' : '' }}">
                        <div class="v-faq-panel-inner">{{ $faq['answer'] ?? '' }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============ CTA / FORM ============ --}}
    @php $allProducts = $featuredVehicle ? $exploreProducts->prepend($featuredVehicle) : $exploreProducts; @endphp
    <section id="konsultasi" class="v-cta-section">
        <div class="v-wrap">
            <div class="v-cta-grid">
                <div class="v-cta-left v-reveal">
                    <span class="v-eyebrow">Mulai Sekarang</span>
                    <h2>{{ $landingPage->form_title ?: 'Konsultasi Gratis Sekarang' }}</h2>
                    <p>{{ $landingPage->form_subtitle ?: 'Isi data di bawah, tim kami akan segera menghubungi Anda via WhatsApp.' }}</p>

                    <div class="v-benefit-row"><i class="bi bi-lightning-charge"></i><span>Respon cepat, dibalas kurang dari 1 jam</span></div>
                    <div class="v-benefit-row"><i class="bi bi-calculator"></i><span>Simulasi cicilan sesuai budget Anda</span></div>
                    <div class="v-benefit-row"><i class="bi bi-shield-check"></i><span>Konsultasi 100% gratis, tanpa paksaan</span></div>
                </div>

                <div class="v-reveal">
                    <div id="lp-form-alert"></div>
                    <form id="lp-lead-form">
                        <div class="v-field">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" required>
                        </div>
                        <div class="v-field">
                            <label>No. WhatsApp</label>
                            <input type="text" name="phone" placeholder="08xxxxxxxxxx" required>
                        </div>
                        <div class="v-field">
                            <label>Kota</label>
                            <input type="text" name="city">
                        </div>
                        <div class="v-field">
                            <label>Mobil yang Diminati</label>
                            <select name="product_id" id="lp-product-select">
                                <option value="">Belum tahu / bebas</option>
                                @foreach($allProducts as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="v-field">
                            <label>Pesan (opsional)</label>
                            <textarea name="message" placeholder="Contoh: mau tanya simulasi kredit DP 20 juta"></textarea>
                        </div>
                        <button type="submit" class="v-btn v-btn-solid v-submit" id="lp-submit-btn">
                            <i class="bi bi-send-fill"></i> Kirim &amp; Chat WhatsApp
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="v-footer">
        &copy; {{ date('Y') }} {{ $profile->name ?? config('settings.site_name') }}. Semua hak dilindungi.
        @if($profile->phone ?? null) &bull; {{ $profile->phone }} @endif
    </footer>

    <div class="v-sticky-bar">
        <a href="tel:{{ $profile->phone ?? '' }}" class="v-sticky-call"><i class="bi bi-telephone-fill me-1"></i> Telepon</a>
        <a href="{{ $profile->wa_url }}" target="_blank" class="v-sticky-wa"><i class="bi bi-whatsapp me-1"></i> WhatsApp</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ mix('frontend/js/app.js') }}"></script>
    <script>
        (function () {
            /* ---------- GSAP reveals (ringan: fade-in sekali saat masuk viewport, bukan scroll-linked) ---------- */
            if (window.gsap && window.ScrollTrigger) {
                gsap.registerPlugin(ScrollTrigger);

                gsap.timeline()
                    .to('.v-hero .v-reveal', { opacity: 1, y: 0, duration: 1, stagger: .12, ease: 'power3.out', delay: .2 });

                document.querySelectorAll('.v-reveal:not(.v-hero .v-reveal)').forEach(function (el) {
                    gsap.to(el, {
                        opacity: 1, y: 0, duration: .9, ease: 'power3.out',
                        scrollTrigger: { trigger: el, start: 'top 88%', once: true }
                    });
                });

                /* Animated counter untuk stats asli */
                document.querySelectorAll('.v-count').forEach(function (el) {
                    const target = parseInt(el.dataset.count, 10) || 0;
                    const obj = { val: 0 };
                    ScrollTrigger.create({
                        trigger: el,
                        start: 'top 90%',
                        once: true,
                        onEnter: function () {
                            gsap.to(obj, {
                                val: target, duration: 1.6, ease: 'power2.out',
                                onUpdate: function () { el.textContent = Math.floor(obj.val); }
                            });
                        }
                    });
                });
            } else {
                // fallback kalau CDN gagal load: tampilkan langsung tanpa animasi
                document.querySelectorAll('.v-reveal').forEach(function (el) { el.style.opacity = 1; el.style.transform = 'none'; });
                document.querySelectorAll('.v-count').forEach(function (el) { el.textContent = el.dataset.count; });
            }

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

            /* ---------- Submit lead (logika sama dengan sistem Consultation existing) ---------- */
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
