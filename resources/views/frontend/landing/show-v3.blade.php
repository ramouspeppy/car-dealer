<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landingPage->meta_title ?: strip_tags(str_replace('*', '', $landingPage->headline)) }}</title>
    <meta name="description" content="{{ $landingPage->meta_description ?: $landingPage->subheadline }}">
    <meta name="robots" content="noindex, follow">

    <meta property="og:title" content="{{ $landingPage->meta_title ?: str_replace('*', '', $landingPage->headline) }}">
    <meta property="og:description" content="{{ $landingPage->meta_description ?: $landingPage->subheadline }}">
    <meta property="og:image" content="{{ $landingPage->og_image_url }}">
    <meta property="og:type" content="website">

    <link href="{{ asset('frontend/img/favicon.png') }}" rel="icon">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Chewy&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ mix('frontend/css/app.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

    {!! $landingPage->tracking_head_script !!}

    <style>
        :root {
            --p-cream: #fff6d6;
            --p-yellow: #ffd23f;
            --p-red: #ee4266;
            --p-blue: #2a9df4;
            --p-mint: #3ddc97;
            --p-ink: #1f1b3a;
            --p-white: #ffffff;
            --p-font-display: 'Chewy', cursive;
            --p-font-body: 'Baloo 2', sans-serif;
            --p-outline: 3px solid var(--p-ink);
            --p-shadow: 5px 5px 0 var(--p-ink);
        }

        * { box-sizing: border-box; }

        html, body { background: var(--p-cream) !important; }

        body {
            font-family: var(--p-font-body);
            color: var(--p-ink);
            margin: 0;
            overflow-x: hidden;
            padding-bottom: 78px;
            font-size: 17px;
        }

        img { max-width: 100%; display: block; }

        h1, h2, h3, h4 {
            font-family: var(--p-font-display);
            font-weight: 400;
            color: var(--p-ink);
            margin: 0;
            letter-spacing: .5px;
        }

        .p-wrap { max-width: 1180px; margin: 0 auto; padding: 0 22px; position: relative; }
        .p-section { padding: 100px 0; position: relative; overflow: hidden; }
        .p-bg-cream { background: var(--p-cream); }
        .p-bg-yellow { background: var(--p-yellow); }
        .p-bg-blue { background: var(--p-blue); }
        .p-bg-white { background: var(--p-white); }

        .p-section-title { text-align: center; margin-bottom: 52px; position: relative; z-index: 2; }
        .p-section-title h2 { font-size: clamp(34px, 5vw, 56px); line-height: 1.05; }
        .p-section-title p { font-size: 18px; margin: 12px auto 0; max-width: 520px; font-weight: 500; }

        .p-hl {
            position: relative; display: inline-block; color: var(--p-red); white-space: nowrap;
        }
        .p-hl::after {
            content: ''; position: absolute; left: -2%; bottom: -8px; width: 104%; height: 12px;
            background: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 12' preserveAspectRatio='none'><path d='M2 8 Q 12 0 22 7 T 42 7 T 62 7 T 82 7 T 102 7 T 118 6' fill='none' stroke='%23ffd23f' stroke-width='5' stroke-linecap='round'/></svg>") center/100% 100% no-repeat;
        }

        .p-reveal { opacity: 0; transform: translateY(30px) scale(.96); }

        /* ===== Buttons (sticker style) ===== */
        .p-btn {
            display: inline-flex; align-items: center; gap: 10px;
            font-family: var(--p-font-display); font-size: 21px; letter-spacing: .5px;
            padding: 12px 28px; border-radius: 999px; border: var(--p-outline);
            box-shadow: var(--p-shadow); text-decoration: none; cursor: pointer;
            color: var(--p-ink) !important; transition: transform .18s ease, box-shadow .18s ease;
            background: var(--p-yellow);
        }
        .p-btn:hover { transform: translate(-2px, -2px) rotate(-1.5deg); box-shadow: 8px 8px 0 var(--p-ink); }
        .p-btn:active { transform: translate(3px, 3px); box-shadow: 1px 1px 0 var(--p-ink); }
        .p-btn-red { background: var(--p-red); color: #fff !important; }
        .p-btn-white { background: #fff; }
        .p-btn-blue { background: var(--p-blue); color: #fff !important; }

        /* ===== Doodles ===== */
        .p-doodle { position: absolute; pointer-events: none; z-index: 1; }
        .p-float { animation: pFloat 5s ease-in-out infinite; }
        .p-float-2 { animation: pFloat 6.5s ease-in-out infinite reverse; }
        .p-spin { animation: pSpin 14s linear infinite; }
        @keyframes pFloat { 0%, 100% { transform: translateY(0) rotate(-3deg); } 50% { transform: translateY(-16px) rotate(3deg); } }
        @keyframes pSpin { to { transform: rotate(360deg); } }

        /* ===== Topbar ===== */
        .p-topbar {
            position: sticky; top: 0; z-index: 1000; background: var(--p-white);
            border-bottom: var(--p-outline);
        }
        .p-topbar-inner { display: flex; align-items: center; justify-content: space-between; padding: 12px 22px; max-width: 1180px; margin: 0 auto; }
        .p-brand { font-family: var(--p-font-display); font-size: 26px; color: var(--p-ink); text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .p-brand svg { width: 34px; height: 34px; }
        .p-topbar .p-btn { font-size: 17px; padding: 8px 20px; box-shadow: 3px 3px 0 var(--p-ink); }

        /* ===== Hero ===== */
        .p-hero { padding: 70px 0 110px; background: var(--p-cream); position: relative; overflow: hidden; }
        .p-hero-grid { display: grid; grid-template-columns: 1fr; gap: 50px; align-items: center; position: relative; z-index: 2; }
        @media (min-width: 992px) { .p-hero-grid { grid-template-columns: 1.15fr .85fr; gap: 60px; } }

        .p-badge {
            display: inline-block; background: var(--p-red); color: #fff; font-family: var(--p-font-display);
            font-size: 19px; padding: 6px 20px; border: var(--p-outline); border-radius: 12px;
            box-shadow: 4px 4px 0 var(--p-ink); transform: rotate(-3deg); margin-bottom: 22px;
        }

        .p-hero h1 { font-size: clamp(42px, 7vw, 84px); line-height: 1; margin-bottom: 20px; }
        .p-hero-desc { font-size: 20px; font-weight: 500; max-width: 500px; margin-bottom: 34px; }
        .p-hero-actions { display: flex; flex-wrap: wrap; gap: 18px; }

        .p-profile { position: relative; max-width: 380px; margin: 0 auto; }
        .p-profile-frame {
            border: var(--p-outline); box-shadow: 8px 8px 0 var(--p-ink); background: var(--p-blue);
            border-radius: 46% 54% 42% 58% / 50% 44% 56% 50%; overflow: hidden; aspect-ratio: 1/1.05;
            animation: pMorph 8s ease-in-out infinite;
        }
        .p-profile-frame img { width: 100%; height: 100%; object-fit: cover; }
        @keyframes pMorph {
            0%, 100% { border-radius: 46% 54% 42% 58% / 50% 44% 56% 50%; }
            50% { border-radius: 56% 44% 55% 45% / 44% 54% 46% 56%; }
        }

        .p-bubble {
            position: relative; margin-top: 26px; background: #fff; border: var(--p-outline);
            border-radius: 20px; padding: 16px 20px; box-shadow: 5px 5px 0 var(--p-ink);
            transform: rotate(1.5deg);
        }
        .p-bubble::before {
            content: ''; position: absolute; top: -16px; left: 42px; width: 22px; height: 22px;
            background: #fff; border-left: var(--p-outline); border-top: var(--p-outline); transform: rotate(45deg);
        }
        .p-bubble p { margin: 0 0 8px; font-size: 15.5px; font-weight: 500; line-height: 1.5; }
        .p-bubble strong { font-family: var(--p-font-display); font-size: 19px; display: block; }
        .p-bubble span { font-size: 13.5px; opacity: .7; }

        /* ===== Marquee strip ===== */
        .p-strip { background: var(--p-yellow); border-top: var(--p-outline); border-bottom: var(--p-outline); padding: 14px 0; overflow: hidden; transform: rotate(-1.2deg); margin: -34px -20px 0; position: relative; z-index: 3; }
        .p-strip-track { display: flex; width: max-content; animation: pMarquee 22s linear infinite; }
        .p-strip:hover .p-strip-track { animation-play-state: paused; }
        .p-strip-item { font-family: var(--p-font-display); font-size: 23px; padding: 0 30px; display: flex; align-items: center; gap: 12px; white-space: nowrap; }
        .p-strip-item svg { width: 22px; height: 22px; }
        @keyframes pMarquee { to { transform: translateX(-50%); } }

        /* ===== Product carousel ===== */
        .p-carousel { display: flex; gap: 28px; overflow-x: auto; padding: 14px 6px 34px; scroll-snap-type: x mandatory; scrollbar-width: none; }
        .p-carousel::-webkit-scrollbar { display: none; }
        .p-card-product {
            flex: 0 0 auto; width: min(80vw, 300px); scroll-snap-align: center;
            background: #fff; border: var(--p-outline); border-radius: 22px; box-shadow: var(--p-shadow);
            overflow: hidden; transition: transform .25s ease;
        }
        .p-card-product:nth-child(odd) { transform: rotate(-1.5deg); }
        .p-card-product:nth-child(even) { transform: rotate(1.5deg); }
        .p-card-product:hover { transform: rotate(0) translateY(-8px); }
        .p-card-product-img { aspect-ratio: 4/3; border-bottom: var(--p-outline); background: var(--p-cream); overflow: hidden; }
        .p-card-product-img img { width: 100%; height: 100%; object-fit: cover; }
        .p-card-product-body { padding: 18px 20px 22px; }
        .p-card-product-body h3 { font-size: 26px; margin-bottom: 4px; }
        .p-price { font-weight: 700; font-size: 18px; color: var(--p-red); margin-bottom: 14px; }
        .p-price s { color: rgba(31, 27, 58, .45); font-weight: 500; font-size: 14px; margin-right: 6px; }
        .p-card-product .p-btn { font-size: 18px; padding: 8px 20px; box-shadow: 3px 3px 0 var(--p-ink); }

        .p-carousel-hint { text-align: center; font-weight: 600; font-size: 15px; margin-top: -6px; opacity: .65; }

        /* ===== Services tiles ===== */
        .p-tile {
            border: var(--p-outline); border-radius: 22px; box-shadow: var(--p-shadow);
            padding: 28px 24px; height: 100%; transition: transform .25s ease;
        }
        .p-tile:hover { transform: translateY(-8px) rotate(-1deg); }
        .p-tile-c0 { background: var(--p-yellow); }
        .p-tile-c1 { background: var(--p-mint); }
        .p-tile-c2 { background: #fff; }
        .p-tile-c3 { background: #ffb3c1; }
        .p-tile-icon {
            width: 58px; height: 58px; border-radius: 50%; background: var(--p-ink); color: #fff;
            display: flex; align-items: center; justify-content: center; font-size: 26px; margin-bottom: 16px;
        }
        .p-tile h3 { font-size: 26px; margin-bottom: 8px; }
        .p-tile p { margin: 0; font-size: 16px; font-weight: 500; line-height: 1.5; }

        /* ===== Promo ===== */
        .p-promo-card {
            background: #fff; border: var(--p-outline); border-radius: 26px; box-shadow: 8px 8px 0 var(--p-ink);
            overflow: hidden; display: grid; grid-template-columns: 1fr; margin-bottom: 34px; position: relative;
        }
        @media (min-width: 768px) { .p-promo-card { grid-template-columns: .9fr 1.1fr; } }
        .p-promo-img { aspect-ratio: 16/10; background: var(--p-cream); border-bottom: var(--p-outline); overflow: hidden; }
        @media (min-width: 768px) { .p-promo-img { border-bottom: none; border-right: var(--p-outline); aspect-ratio: auto; } }
        .p-promo-img img { width: 100%; height: 100%; object-fit: cover; }
        .p-promo-body { padding: 32px; display: flex; flex-direction: column; justify-content: center; }
        .p-promo-body h3 { font-size: 34px; margin-bottom: 8px; }
        .p-promo-body p { font-weight: 500; margin-bottom: 18px; }
        .p-promo-tag {
            position: absolute; top: 14px; left: 14px; z-index: 2; background: var(--p-red); color: #fff;
            font-family: var(--p-font-display); font-size: 18px; padding: 4px 14px; border: var(--p-outline); border-radius: 10px;
            transform: rotate(-6deg); box-shadow: 3px 3px 0 var(--p-ink);
        }

        .p-countdown { display: flex; gap: 10px; margin-bottom: 22px; flex-wrap: wrap; }
        .p-count-box { background: var(--p-yellow); border: var(--p-outline); border-radius: 14px; text-align: center; padding: 8px 12px; min-width: 66px; box-shadow: 3px 3px 0 var(--p-ink); }
        .p-count-num { font-family: var(--p-font-display); font-size: 30px; line-height: 1; }
        .p-count-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; }

        /* ===== Polaroid (gallery & delivery) ===== */
        .p-polaroid {
            background: #fff; border: var(--p-outline); box-shadow: var(--p-shadow); padding: 12px 12px 18px;
            border-radius: 6px; transition: transform .25s ease; position: relative; display: block; text-decoration: none; color: var(--p-ink);
        }
        .p-polaroid:hover { transform: rotate(0) scale(1.03) !important; }
        .p-polaroid-tape {
            position: absolute; top: -14px; left: 50%; transform: translateX(-50%) rotate(-4deg); width: 84px; height: 26px;
            background: rgba(255, 210, 63, .85); border: 2px solid var(--p-ink);
        }
        .p-polaroid-img { aspect-ratio: 1/1; overflow: hidden; background: var(--p-cream); border: 2px solid var(--p-ink); }
        .p-polaroid-img img { width: 100%; height: 100%; object-fit: cover; }
        .p-polaroid-cap { font-family: var(--p-font-display); font-size: 21px; margin-top: 12px; line-height: 1.1; }
        .p-polaroid-sub { font-size: 13.5px; font-weight: 600; opacity: .7; display: flex; align-items: center; gap: 5px; margin-top: 3px; }

        .p-stamp {
            display: inline-flex; align-items: center; gap: 6px; font-family: var(--p-font-display); font-size: 15px;
            color: var(--p-red); border: 2px dashed var(--p-red); padding: 2px 10px; border-radius: 8px; transform: rotate(-3deg); margin-top: 8px;
        }

        /* ===== Testimonial bubbles ===== */
        .p-testi-card {
            background: #fff; border: var(--p-outline); border-radius: 26px; box-shadow: var(--p-shadow);
            padding: 26px 28px; position: relative; margin-bottom: 34px; height: calc(100% - 34px);
        }
        .p-testi-card::after {
            content: ''; position: absolute; bottom: -20px; left: 46px; width: 26px; height: 26px; background: #fff;
            border-right: var(--p-outline); border-bottom: var(--p-outline); transform: rotate(45deg);
        }
        .p-testi-card p { font-weight: 500; font-size: 17px; line-height: 1.6; margin-bottom: 16px; }
        .p-testi-name { font-family: var(--p-font-display); font-size: 22px; }
        .p-testi-job { font-size: 14px; font-weight: 600; opacity: .65; }
        .p-testi-stars { color: var(--p-red); font-size: 15px; margin-top: 4px; }

        /* ===== FAQ ===== */
        .p-faq-item { background: #fff; border: var(--p-outline); border-radius: 18px; box-shadow: 4px 4px 0 var(--p-ink); margin-bottom: 18px; overflow: hidden; }
        .p-faq-btn {
            width: 100%; text-align: left; background: none; border: none; padding: 18px 22px; display: flex;
            align-items: center; gap: 14px; font-family: var(--p-font-display); font-size: 23px; color: var(--p-ink); cursor: pointer;
        }
        .p-faq-num { width: 36px; height: 36px; border-radius: 50%; background: var(--p-yellow); border: var(--p-outline); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
        .p-faq-icon { margin-left: auto; font-size: 22px; transition: transform .3s ease; }
        .p-faq-btn[aria-expanded="true"] .p-faq-icon { transform: rotate(135deg); }
        .p-faq-panel { max-height: 0; overflow: hidden; transition: max-height .35s ease; }
        .p-faq-panel-inner { padding: 0 22px 22px 72px; font-weight: 500; line-height: 1.6; }

        /* ===== Form ===== */
        .p-form-card { background: #fff; border: var(--p-outline); border-radius: 28px; box-shadow: 10px 10px 0 var(--p-ink); padding: 36px 32px; }
        .p-form-left h2 { font-size: clamp(36px, 5vw, 54px); color: #fff; line-height: 1.05; margin-bottom: 14px; text-shadow: 3px 3px 0 var(--p-ink); }
        .p-form-left p { color: #fff; font-size: 19px; font-weight: 600; margin-bottom: 26px; }
        .p-perk { display: flex; align-items: center; gap: 12px; background: #fff; border: var(--p-outline); border-radius: 14px; padding: 12px 16px; margin-bottom: 14px; box-shadow: 4px 4px 0 var(--p-ink); font-weight: 600; }
        .p-perk i { font-size: 20px; color: var(--p-red); }

        .p-field { margin-bottom: 20px; }
        .p-field label { display: block; font-family: var(--p-font-display); font-size: 18px; margin-bottom: 6px; }
        .p-field input, .p-field select, .p-field textarea {
            width: 100%; border: var(--p-outline); border-radius: 14px; padding: 12px 16px;
            font-family: var(--p-font-body); font-size: 17px; font-weight: 500; background: var(--p-cream); color: var(--p-ink);
            transition: box-shadow .2s ease, background .2s ease;
        }
        .p-field input:focus, .p-field select:focus, .p-field textarea:focus { outline: none; background: #fff; box-shadow: 4px 4px 0 var(--p-blue); }
        .p-field textarea { resize: vertical; min-height: 84px; }
        .p-submit { width: 100%; justify-content: center; background: var(--p-red); color: #fff !important; font-size: 25px; padding: 14px; }

        /* ===== Footer ===== */
        .p-footer { background: var(--p-ink); color: #fff; text-align: center; padding: 34px 20px; font-weight: 500; font-size: 15px; }
        .p-footer strong { font-family: var(--p-font-display); font-size: 20px; font-weight: 400; }

        /* ===== Sticky mobile bar ===== */
        .p-sticky { position: fixed; bottom: 0; left: 0; right: 0; z-index: 1040; background: #fff; border-top: var(--p-outline); padding: 10px 14px; display: flex; gap: 10px; }
        .p-sticky a { flex: 1; text-align: center; padding: 10px; border: var(--p-outline); border-radius: 999px; font-family: var(--p-font-display); font-size: 19px; text-decoration: none; color: var(--p-ink); }
        .p-sticky .p-s-call { background: var(--p-yellow); }
        .p-sticky .p-s-wa { background: var(--p-mint); }
        @media (min-width: 992px) { .p-sticky { display: none; } body { padding-bottom: 0; } }
        @media (max-width: 767px) { .p-section { padding: 70px 0; } .p-hero { padding: 40px 0 90px; } }
    </style>
</head>

<body>

    {{-- ============ TOPBAR ============ --}}
    <div class="p-topbar">
        <div class="p-topbar-inner">
            <a href="#" class="p-brand">
                <svg viewBox="0 0 48 48" fill="none" stroke="#1f1b3a" stroke-width="3" stroke-linejoin="round" stroke-linecap="round"><path d="M6 30l4-11c.6-1.7 2.2-2.8 4-2.8h20c1.8 0 3.4 1.1 4 2.8l4 11" fill="#ffd23f"/><rect x="4" y="29" width="40" height="9" rx="4" fill="#ee4266"/><circle cx="14" cy="39" r="4.5" fill="#fff"/><circle cx="34" cy="39" r="4.5" fill="#fff"/></svg>
                {{ $profile->name ?? config('settings.site_name') }}
            </a>
            <a href="{{ $profile->wa_url }}" target="_blank" class="p-btn p-btn-white"><i class="bi bi-whatsapp"></i> Chat</a>
        </div>
    </div>

    {{-- ============ HERO ============ --}}
    <section class="p-hero">
        {{-- doodles --}}
        <svg class="p-doodle p-float" style="top:40px;left:4%;width:90px;" viewBox="0 0 100 60"><path d="M20 50c-10 0-16-6-16-14s7-14 15-13c2-10 12-16 22-14 8 2 12 8 13 13 9-3 20 3 20 13 0 8-6 15-15 15z" fill="#fff" stroke="#1f1b3a" stroke-width="3" stroke-linejoin="round"/></svg>
        <svg class="p-doodle p-float-2" style="top:120px;right:6%;width:70px;" viewBox="0 0 100 60"><path d="M20 50c-10 0-16-6-16-14s7-14 15-13c2-10 12-16 22-14 8 2 12 8 13 13 9-3 20 3 20 13 0 8-6 15-15 15z" fill="#fff" stroke="#1f1b3a" stroke-width="3" stroke-linejoin="round"/></svg>
        <svg class="p-doodle p-spin" style="bottom:130px;left:6%;width:46px;" viewBox="0 0 50 50"><path d="M25 3l6.5 15.5L48 20l-12.5 11 4 16.5L25 39l-14.5 8.5 4-16.5L2 20l16.5-1.5z" fill="#ffd23f" stroke="#1f1b3a" stroke-width="3" stroke-linejoin="round"/></svg>
        <svg class="p-doodle p-float" style="bottom:90px;right:12%;width:36px;" viewBox="0 0 50 50"><path d="M25 3l6.5 15.5L48 20l-12.5 11 4 16.5L25 39l-14.5 8.5 4-16.5L2 20l16.5-1.5z" fill="#ee4266" stroke="#1f1b3a" stroke-width="3" stroke-linejoin="round"/></svg>

        <div class="p-wrap">
            <div class="p-hero-grid">
                <div>
                    <div class="p-badge p-reveal">{{ $landingPage->hero_badge ?: 'Yuk Kenalan!' }}</div>
                    <h1 class="p-reveal">{!! nl2br(preg_replace('/\*(.+?)\*/', '<span class="p-hl">$1</span>', e($landingPage->headline))) !!}</h1>
                    @if($landingPage->subheadline)
                    <p class="p-hero-desc p-reveal">{{ $landingPage->subheadline }}</p>
                    @endif
                    <div class="p-hero-actions p-reveal">
                        <a href="#ngobrol" class="p-btn p-btn-red">{{ $landingPage->hero_cta_label ?: 'Ngobrol Yuk!' }} <i class="bi bi-chat-heart-fill"></i></a>
                        @if($products->count())
                        <a href="#armada" class="p-btn">Lihat Mobilnya <i class="bi bi-arrow-down-circle-fill"></i></a>
                        @endif
                    </div>
                </div>

                @if($profile->image_url ?? null)
                <div class="p-profile p-reveal">
                    <div class="p-profile-frame"><img src="{{ $profile->image_url }}" alt="{{ $profile->name }}"></div>
                    @if($profile->bio)
                    <div class="p-bubble">
                        <p>{{ Str::limit(strip_tags($profile->bio), 140) }}</p>
                        <strong>{{ $profile->name }}</strong>
                        @if($profile->job_title)<span>{{ $profile->job_title }}</span>@endif
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ============ STRIP MARQUEE ============ --}}
    @if(!empty($landingPage->trust_badges))
    <div class="p-strip">
        <div class="p-strip-track">
            @for($r = 0; $r < 2; $r++)
                @foreach($landingPage->trust_badges as $badge)
                <span class="p-strip-item">
                    <svg viewBox="0 0 50 50"><path d="M25 3l6.5 15.5L48 20l-12.5 11 4 16.5L25 39l-14.5 8.5 4-16.5L2 20l16.5-1.5z" fill="#ee4266" stroke="#1f1b3a" stroke-width="4" stroke-linejoin="round"/></svg>
                    {{ $badge }}
                </span>
                @endforeach
            @endfor
        </div>
    </div>
    @endif

    {{-- ============ ARMADA (carousel produk) ============ --}}
    @if($products->count())
    <section id="armada" class="p-section p-bg-cream" style="padding-top:130px;">
        <svg class="p-doodle p-float" style="top:70px;right:5%;width:80px;" viewBox="0 0 100 60"><path d="M20 50c-10 0-16-6-16-14s7-14 15-13c2-10 12-16 22-14 8 2 12 8 13 13 9-3 20 3 20 13 0 8-6 15-15 15z" fill="#fff" stroke="#1f1b3a" stroke-width="3" stroke-linejoin="round"/></svg>
        <div class="p-wrap">
            <div class="p-section-title p-reveal">
                <h2>Kenalan sama <span class="p-hl">Mobil-mobilnya!</span></h2>
                <p>Geser ke samping, siapa tahu ada yang bikin kamu bilang "ini dia!"</p>
            </div>

            <div class="p-carousel">
                @foreach($products as $product)
                <div class="p-card-product">
                    <div class="p-card-product-img"><img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy"></div>
                    <div class="p-card-product-body">
                        <h3>{{ $product->name }}</h3>
                        <div class="p-price">
                            @if($product->disc > 0)<s>{{ $product->min_price }}</s>{{ $product->special_min_price }}
                            @else Mulai {{ $product->min_price }}@endif
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('product.detail', $product->slug) }}" class="p-btn p-btn-white">Detail</a>
                            <a href="#ngobrol" class="p-btn p-btn-red lp-pilih-produk" data-product-id="{{ $product->id }}">Mau!</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="p-carousel-hint"><i class="bi bi-arrow-left-right"></i> geser buat lihat semua</div>
        </div>
    </section>
    @endif

    {{-- ============ SERVICES ============ --}}
    @if($services->count())
    <section class="p-section p-bg-yellow" style="border-top:3px solid #1f1b3a;border-bottom:3px solid #1f1b3a;">
        <svg class="p-doodle p-spin" style="top:50px;left:4%;width:54px;" viewBox="0 0 50 50"><path d="M25 3l6.5 15.5L48 20l-12.5 11 4 16.5L25 39l-14.5 8.5 4-16.5L2 20l16.5-1.5z" fill="#fff" stroke="#1f1b3a" stroke-width="3" stroke-linejoin="round"/></svg>
        <div class="p-wrap">
            <div class="p-section-title p-reveal">
                <h2>Kami <span class="p-hl" style="color:#ee4266;">bantuin</span> dari awal sampai tuntas</h2>
                <p>Bukan cuma jual mobil, semua layanan ini gratis jadi satu paket.</p>
            </div>
            <div class="row g-4">
                @foreach($services as $service)
                <div class="col-md-6 col-lg-4 p-reveal">
                    <div class="p-tile p-tile-c{{ $loop->index % 4 }}">
                        <div class="p-tile-icon"><i class="bi {{ $service->icon }}"></i></div>
                        <h3>{{ $service->title }}</h3>
                        @if($service->desc)<p>{{ Str::limit(strip_tags($service->desc), 100) }}</p>@endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============ PROMO ============ --}}
    @if($promos->count())
    <section class="p-section p-bg-cream">
        <div class="p-wrap">
            <div class="p-section-title p-reveal">
                <h2>Promo <span class="p-hl">Seru</span> Lagi Jalan!</h2>
                <p>Buruan, keburu habis waktunya!</p>
            </div>
            @foreach($promos as $promo)
            <div class="p-promo-card p-reveal">
                <span class="p-promo-tag">PROMO!</span>
                @if($promo->promo_image_url)
                <div class="p-promo-img"><img src="{{ $promo->promo_image_url }}" alt="{{ $promo->promo }}" loading="lazy"></div>
                @endif
                <div class="p-promo-body">
                    <h3>{{ $promo->promo }}</h3>
                    @if($promo->desc)<p>{{ Str::limit(strip_tags($promo->desc), 130) }}</p>@endif

                    @if($promo->effective_date)
                    <div class="p-countdown" data-countdown="{{ $promo->effective_date->format('Y-m-d') }} 23:59:59">
                        <div class="p-count-box"><div class="p-count-num" data-unit="days">00</div><div class="p-count-label">Hari</div></div>
                        <div class="p-count-box"><div class="p-count-num" data-unit="hours">00</div><div class="p-count-label">Jam</div></div>
                        <div class="p-count-box"><div class="p-count-num" data-unit="minutes">00</div><div class="p-count-label">Menit</div></div>
                        <div class="p-count-box"><div class="p-count-num" data-unit="seconds">00</div><div class="p-count-label">Detik</div></div>
                    </div>
                    @endif

                    <div><a href="#ngobrol" class="p-btn p-btn-red">Klaim Sekarang!</a></div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ============ GALERI ============ --}}
    @if($galleries->count())
    <section class="p-section p-bg-blue" style="border-top:3px solid #1f1b3a;border-bottom:3px solid #1f1b3a;">
        <svg class="p-doodle p-float" style="top:40px;right:6%;width:90px;" viewBox="0 0 100 60"><path d="M20 50c-10 0-16-6-16-14s7-14 15-13c2-10 12-16 22-14 8 2 12 8 13 13 9-3 20 3 20 13 0 8-6 15-15 15z" fill="#fff" stroke="#1f1b3a" stroke-width="3" stroke-linejoin="round"/></svg>
        <div class="p-wrap">
            <div class="p-section-title p-reveal">
                <h2 style="color:#fff;text-shadow:3px 3px 0 #1f1b3a;">Jepretan Seru Kami</h2>
                <p style="color:#fff;font-weight:600;">Momen-momen di showroom dan acara kami</p>
            </div>
            <div class="row g-4">
                @foreach($galleries as $gallery)
                <div class="col-6 col-lg-4 p-reveal">
                    <a href="{{ route('gallery.show', $gallery->slug) }}" class="p-polaroid" style="transform: rotate({{ $loop->odd ? '-2.5' : '2.5' }}deg);">
                        <span class="p-polaroid-tape"></span>
                        <div class="p-polaroid-img"><img src="{{ $gallery->cover_url }}" alt="{{ $gallery->title }}" loading="lazy"></div>
                        <div class="p-polaroid-cap">{{ Str::limit($gallery->title, 34) }}</div>
                        <div class="p-polaroid-sub"><i class="bi bi-heart-fill" style="color:#ee4266;"></i> {{ $gallery->loves }}</div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============ SERAH TERIMA ============ --}}
    @if($deliveries->count())
    <section class="p-section p-bg-cream">
        <div class="p-wrap">
            <div class="p-section-title p-reveal">
                <h2>Pemilik Baru yang <span class="p-hl">Bahagia</span></h2>
                <p>Ini unit-unit yang baru saja kami serahkan, foto asli, bukan katalog!</p>
            </div>
            <div class="row g-4">
                @foreach($deliveries as $delivery)
                @php $deliveryImg = $delivery->getFirstMediaUrl('images'); @endphp
                @if($deliveryImg)
                <div class="col-6 col-lg-4 p-reveal">
                    <div class="p-polaroid" style="transform: rotate({{ $loop->odd ? '2' : '-2' }}deg);">
                        <span class="p-polaroid-tape" style="background:rgba(61,220,151,.85);"></span>
                        <div class="p-polaroid-img"><img src="{{ $deliveryImg }}" alt="Serah terima {{ $delivery->product->name ?? '' }}" loading="lazy"></div>
                        @if($delivery->product)<div class="p-polaroid-cap">{{ $delivery->product->name }}</div>@endif
                        <div class="p-polaroid-sub">{{ $delivery->created_at->translatedFormat('d F Y') }}</div>
                        <span class="p-stamp"><i class="bi bi-patch-check-fill"></i> SUDAH DISERAHKAN</span>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============ TESTIMONI ============ --}}
    @if($testimonies->count())
    <section class="p-section p-bg-yellow" style="border-top:3px solid #1f1b3a;">
        <div class="p-wrap">
            <div class="p-section-title p-reveal">
                <h2>Kata <span class="p-hl" style="color:#ee4266;">Mereka</span></h2>
                <p>Cerita langsung dari pelanggan yang sudah bawa pulang mobilnya.</p>
            </div>
            <div class="row g-4">
                @foreach($testimonies as $testimony)
                <div class="col-md-6 col-lg-4 p-reveal">
                    <div class="p-testi-card">
                        <p>"{{ Str::limit(strip_tags($testimony->message), 150) }}"</p>
                        <div class="p-testi-name">{{ $testimony->name }}</div>
                        @if($testimony->job)<div class="p-testi-job">{{ $testimony->job }}</div>@endif
                        <div class="p-testi-stars">
                            @for($i = 0; $i < ($testimony->rating ?: 5); $i++)<i class="bi bi-star-fill"></i>@endfor
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============ FAQ ============ --}}
    @if(!empty($landingPage->faqs))
    <section class="p-section p-bg-cream">
        <div class="p-wrap" style="max-width:820px;">
            <div class="p-section-title p-reveal">
                <h2>Masih <span class="p-hl">Penasaran?</span></h2>
                <p>Jawaban dari pertanyaan yang paling sering kami dengar.</p>
            </div>
            @foreach($landingPage->faqs as $faq)
            <div class="p-faq-item p-reveal">
                <button class="p-faq-btn" type="button" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" data-faq-toggle>
                    <span class="p-faq-num">{{ $loop->iteration }}</span>
                    <span>{{ $faq['question'] ?? '' }}</span>
                    <span class="p-faq-icon"><i class="bi bi-plus-lg"></i></span>
                </button>
                <div class="p-faq-panel" style="{{ $loop->first ? 'max-height:400px;' : '' }}">
                    <div class="p-faq-panel-inner">{{ $faq['answer'] ?? '' }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ============ FORM ============ --}}
    @php $allProducts = $products; @endphp
    <section id="ngobrol" class="p-section p-bg-blue" style="border-top:3px solid #1f1b3a;padding-bottom:110px;">
        <svg class="p-doodle p-spin" style="top:60px;right:8%;width:60px;" viewBox="0 0 50 50"><path d="M25 3l6.5 15.5L48 20l-12.5 11 4 16.5L25 39l-14.5 8.5 4-16.5L2 20l16.5-1.5z" fill="#ffd23f" stroke="#1f1b3a" stroke-width="3" stroke-linejoin="round"/></svg>
        <svg class="p-doodle p-float" style="bottom:60px;left:5%;width:80px;" viewBox="0 0 100 60"><path d="M20 50c-10 0-16-6-16-14s7-14 15-13c2-10 12-16 22-14 8 2 12 8 13 13 9-3 20 3 20 13 0 8-6 15-15 15z" fill="#fff" stroke="#1f1b3a" stroke-width="3" stroke-linejoin="round"/></svg>

        <div class="p-wrap">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 p-reveal p-form-left">
                    <h2>{{ $landingPage->form_title ?: 'Yuk, Cerita Mobil Impianmu' }}</h2>
                    <p>{{ $landingPage->form_subtitle ?: 'Isi form di bawah, tim kami bakal kabarin kamu secepatnya lewat WhatsApp.' }}</p>
                    <div class="p-perk"><i class="bi bi-lightning-charge-fill"></i> Dibalas kurang dari 1 jam</div>
                    <div class="p-perk"><i class="bi bi-calculator-fill"></i> Dibantu hitung cicilan sesuai budget</div>
                    <div class="p-perk"><i class="bi bi-emoji-smile-fill"></i> Gratis & tanpa paksaan</div>
                </div>

                <div class="col-lg-7 p-reveal">
                    <div class="p-form-card">
                        <div id="lp-form-alert"></div>
                        <form id="lp-lead-form">
                            <input type="hidden" name="page_version" value="v3">
                            <div class="row">
                                <div class="col-md-6"><div class="p-field"><label>Nama kamu</label><input type="text" name="name" required></div></div>
                                <div class="col-md-6"><div class="p-field"><label>No. WhatsApp</label><input type="text" name="phone" placeholder="08xxxxxxxxxx" required></div></div>
                                <div class="col-md-6"><div class="p-field"><label>Kota</label><input type="text" name="city"></div></div>
                                <div class="col-md-6">
                                    <div class="p-field">
                                        <label>Mobil yang kamu taksir</label>
                                        <select name="product_id" id="lp-product-select">
                                            <option value="">Belum tahu, bebas</option>
                                            @foreach($allProducts as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12"><div class="p-field"><label>Pesan (boleh kosong)</label><textarea name="message" placeholder="Contoh: mau tanya simulasi kredit DP 20 juta"></textarea></div></div>
                                <div class="col-12">
                                    <button type="submit" class="p-btn p-submit" id="lp-submit-btn"><i class="bi bi-send-fill"></i> Kirim &amp; Chat WhatsApp</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="p-footer">
        <strong>{{ $profile->name ?? config('settings.site_name') }}</strong><br>
        &copy; {{ date('Y') }} Semua hak dilindungi.
        @if($profile->phone ?? null) &bull; {{ $profile->phone }} @endif
    </footer>

    <div class="p-sticky">
        <a href="tel:{{ $profile->phone ?? '' }}" class="p-s-call"><i class="bi bi-telephone-fill"></i> Telepon</a>
        <a href="{{ $profile->wa_url }}" target="_blank" class="p-s-wa"><i class="bi bi-whatsapp"></i> WhatsApp</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ mix('frontend/js/app.js') }}"></script>
    <script>
        (function () {
            /* ---------- GSAP pop-in (sekali per elemen, ringan) ---------- */
            if (window.gsap && window.ScrollTrigger) {
                gsap.registerPlugin(ScrollTrigger);
                gsap.timeline().to('.p-hero .p-reveal', { opacity: 1, y: 0, scale: 1, duration: .8, stagger: .12, ease: 'back.out(1.5)', delay: .15 });
                document.querySelectorAll('.p-reveal:not(.p-hero .p-reveal)').forEach(function (el) {
                    gsap.to(el, { opacity: 1, y: 0, scale: 1, duration: .7, ease: 'back.out(1.4)', scrollTrigger: { trigger: el, start: 'top 90%', once: true } });
                });
            } else {
                document.querySelectorAll('.p-reveal').forEach(function (el) { el.style.opacity = 1; el.style.transform = 'none'; });
            }

            /* ---------- Countdown promo ---------- */
            document.querySelectorAll('[data-countdown]').forEach(function (box) {
                const target = new Date(box.dataset.countdown.replace(' ', 'T')).getTime();
                function tick() {
                    const diff = target - Date.now();
                    if (diff <= 0) { box.innerHTML = '<strong>Promo sudah berakhir</strong>'; return; }
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

            /* ---------- Submit lead (sistem Consultation yang sama) ---------- */
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
