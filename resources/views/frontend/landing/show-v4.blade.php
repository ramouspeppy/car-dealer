<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landingPage->meta_title ?: str_replace('*', '', $landingPage->headline) }}</title>
    <meta name="description" content="{{ $landingPage->meta_description ?: $landingPage->subheadline }}">
    <meta name="robots" content="noindex, follow">

    <meta property="og:title" content="{{ $landingPage->meta_title ?: str_replace('*', '', $landingPage->headline) }}">
    <meta property="og:description" content="{{ $landingPage->meta_description ?: $landingPage->subheadline }}">
    <meta property="og:image" content="{{ $landingPage->og_image_url }}">
    <meta property="og:type" content="website">

    <link href="{{ asset('frontend/img/favicon.png') }}" rel="icon">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ mix('frontend/css/app.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

    {!! $landingPage->tracking_head_script !!}

    <style>
        :root {
            --t-bg: #0b0f14;
            --t-bg-2: #0f151c;
            --t-surface: #131a23;
            --t-surface-2: #182130;
            --t-line: #232e3d;
            --t-text: #e6edf3;
            --t-muted: #8b98a9;
            --t-accent: #c8ff3d;
            --t-accent-dim: rgba(200, 255, 61, .12);
            --t-cyan: #38d5ff;
            --t-light-bg: #eef2f6;
            --t-light-surface: #ffffff;
            --t-light-text: #0b0f14;
            --t-light-muted: #566273;
            --t-f-display: 'Space Grotesk', sans-serif;
            --t-f-body: 'Inter', sans-serif;
            --t-f-mono: 'JetBrains Mono', monospace;
        }

        * { box-sizing: border-box; }

        html, body { background: var(--t-bg) !important; }

        body {
            font-family: var(--t-f-body);
            color: var(--t-text);
            margin: 0;
            overflow-x: hidden;
            padding-bottom: 76px;
            font-size: 16px;
            line-height: 1.6;
        }

        img { max-width: 100%; display: block; }

        h1, h2, h3, h4 {
            font-family: var(--t-f-display);
            font-weight: 600;
            letter-spacing: -.025em;
            margin: 0;
            color: #f5f8fb;
        }

        .t-wrap { max-width: 1200px; margin: 0 auto; padding: 0 24px; position: relative; }
        .t-section { padding: 110px 0; position: relative; }
        .t-dark { background: var(--t-bg); color: var(--t-text); }
        .t-dark-2 { background: var(--t-bg-2); color: var(--t-text); border-top: 1px solid var(--t-line); border-bottom: 1px solid var(--t-line); }
        .t-light { background: var(--t-light-bg); color: var(--t-light-text); }
        .t-light h1, .t-light h2, .t-light h3, .t-light h4 { color: var(--t-light-text); }

        .t-muted { color: var(--t-muted); }
        .t-light .t-muted { color: var(--t-light-muted); }

        .t-label {
            font-family: var(--t-f-mono);
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--t-accent);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }
        .t-label::before { content: '//'; opacity: .6; }
        .t-light .t-label { color: #3f6b00; }

        .t-head { max-width: 640px; margin-bottom: 52px; }
        .t-head h2 { font-size: clamp(30px, 4vw, 48px); line-height: 1.08; }
        .t-head p { margin: 14px 0 0; font-size: 17px; }

        .t-hl { color: var(--t-accent); }

        .t-reveal { opacity: 0; transform: translateY(26px); }

        /* ===== Buttons ===== */
        .t-btn {
            display: inline-flex; align-items: center; gap: 10px;
            font-family: var(--t-f-display); font-weight: 600; font-size: 15px;
            padding: 14px 26px; border-radius: 10px; text-decoration: none; cursor: pointer;
            border: 1px solid transparent; transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
        }
        .t-btn-primary { background: var(--t-accent); color: #0b0f14 !important; }
        .t-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(200, 255, 61, .28); }
        .t-btn-ghost { background: transparent; color: var(--t-text) !important; border-color: var(--t-line); }
        .t-btn-ghost:hover { border-color: var(--t-accent); color: var(--t-accent) !important; }
        .t-btn-sm { padding: 10px 18px; font-size: 14px; }

        /* ===== Nav ===== */
        .t-nav { position: sticky; top: 0; z-index: 1000; background: rgba(11, 15, 20, .94); border-bottom: 1px solid var(--t-line); }
        .t-nav-inner { display: flex; align-items: center; justify-content: space-between; height: 66px; max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        .t-brand { display: flex; align-items: center; gap: 10px; font-family: var(--t-f-display); font-weight: 700; font-size: 18px; color: #fff; text-decoration: none; }
        .t-brand-mark { width: 28px; height: 28px; border-radius: 8px; background: var(--t-accent); display: flex; align-items: center; justify-content: center; color: #0b0f14; font-size: 15px; }
        .t-nav-links { display: none; gap: 28px; }
        .t-nav-links a { font-size: 14px; font-weight: 500; color: var(--t-muted); text-decoration: none; }
        .t-nav-links a:hover { color: #fff; }
        @media (min-width: 992px) { .t-nav-links { display: flex; } }

        /* ===== Hero ===== */
        .t-hero { position: relative; padding: 90px 0 100px; overflow: hidden; background: var(--t-bg); }
        .t-hero-grid-bg {
            position: absolute; inset: 0;
            background-image: radial-gradient(var(--t-line) 1px, transparent 1px);
            background-size: 30px 30px;
            -webkit-mask-image: radial-gradient(ellipse 80% 70% at 50% 40%, #000 30%, transparent 100%);
            mask-image: radial-gradient(ellipse 80% 70% at 50% 40%, #000 30%, transparent 100%);
        }
        .t-scan { position: absolute; left: 0; right: 0; top: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--t-accent), transparent); opacity: .35; animation: tScan 7s linear infinite; }
        @keyframes tScan { from { transform: translateY(0); } to { transform: translateY(640px); } }

        .t-hero-layout { display: grid; grid-template-columns: 1fr; gap: 56px; align-items: center; position: relative; z-index: 2; }
        @media (min-width: 992px) { .t-hero-layout { grid-template-columns: 1.2fr .8fr; gap: 70px; } }

        .t-chip {
            display: inline-flex; align-items: center; gap: 10px; font-family: var(--t-f-mono); font-size: 12.5px; font-weight: 500;
            color: var(--t-accent); background: var(--t-accent-dim); border: 1px solid rgba(200, 255, 61, .25);
            padding: 7px 14px; border-radius: 999px; margin-bottom: 26px;
        }
        .t-chip-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--t-accent); animation: tPulse 1.8s ease-in-out infinite; }
        @keyframes tPulse { 0%, 100% { opacity: 1; } 50% { opacity: .3; } }

        .t-hero h1 { font-size: clamp(40px, 6.2vw, 82px); line-height: 1.02; margin-bottom: 24px; }
        .t-hero-desc { font-size: 18px; color: var(--t-muted); max-width: 520px; margin-bottom: 34px; }
        .t-hero-actions { display: flex; flex-wrap: wrap; gap: 14px; margin-bottom: 46px; }

        .t-readouts { display: flex; flex-wrap: wrap; gap: 0; border: 1px solid var(--t-line); border-radius: 12px; background: var(--t-surface); max-width: 520px; }
        .t-readout { flex: 1; min-width: 120px; padding: 16px 20px; border-right: 1px solid var(--t-line); }
        .t-readout:last-child { border-right: none; }
        .t-readout-num { font-family: var(--t-f-display); font-size: 28px; font-weight: 700; color: #fff; line-height: 1; }
        .t-readout-label { font-family: var(--t-f-mono); font-size: 11px; letter-spacing: 1px; text-transform: uppercase; color: var(--t-muted); margin-top: 6px; }

        /* ID card */
        .t-id { position: relative; max-width: 400px; margin: 0 auto; background: var(--t-surface); border: 1px solid var(--t-line); border-radius: 18px; padding: 16px; }
        .t-id::before, .t-id::after { content: ''; position: absolute; width: 26px; height: 26px; border: 2px solid var(--t-accent); }
        .t-id::before { top: -8px; left: -8px; border-right: none; border-bottom: none; border-radius: 6px 0 0 0; }
        .t-id::after { bottom: -8px; right: -8px; border-left: none; border-top: none; border-radius: 0 0 6px 0; }
        .t-id-photo { border-radius: 12px; overflow: hidden; aspect-ratio: 1/1; background: var(--t-surface-2); }
        .t-id-photo img { width: 100%; height: 100%; object-fit: cover; }
        .t-id-meta { display: flex; justify-content: space-between; align-items: flex-start; gap: 10px; padding: 16px 4px 4px; }
        .t-id-name { font-family: var(--t-f-display); font-size: 20px; font-weight: 600; color: #fff; line-height: 1.2; }
        .t-id-job { font-family: var(--t-f-mono); font-size: 12px; color: var(--t-muted); margin-top: 3px; }
        .t-status { font-family: var(--t-f-mono); font-size: 11px; color: var(--t-accent); display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; padding-top: 4px; }
        .t-status i { width: 7px; height: 7px; border-radius: 50%; background: var(--t-accent); display: inline-block; animation: tPulse 1.8s ease-in-out infinite; }
        .t-id-bio { font-size: 14px; color: var(--t-muted); padding: 10px 4px 4px; border-top: 1px dashed var(--t-line); margin-top: 12px; }

        /* ===== Ticker ===== */
        .t-ticker { background: var(--t-bg-2); border-top: 1px solid var(--t-line); border-bottom: 1px solid var(--t-line); overflow: hidden; padding: 16px 0; }
        .t-ticker-track { display: flex; width: max-content; animation: tTicker 30s linear infinite; }
        .t-ticker:hover .t-ticker-track { animation-play-state: paused; }
        .t-ticker-item { font-family: var(--t-f-mono); font-size: 13px; text-transform: uppercase; letter-spacing: 1px; color: var(--t-muted); padding: 0 32px; display: flex; align-items: center; gap: 14px; white-space: nowrap; }
        .t-ticker-item::before { content: ''; width: 6px; height: 6px; background: var(--t-accent); transform: rotate(45deg); }
        @keyframes tTicker { to { transform: translateX(-50%); } }

        /* ===== Bento (layanan) ===== */
        .t-bento { display: grid; grid-template-columns: 1fr; gap: 16px; grid-auto-flow: dense; }
        @media (min-width: 768px) { .t-bento { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 992px) { .t-bento { grid-template-columns: repeat(4, 1fr); } .t-bento-item:nth-child(1) { grid-column: span 2; grid-row: span 2; } }
        .t-bento-item {
            background: var(--t-surface); border: 1px solid var(--t-line); border-radius: 16px; padding: 26px;
            transition: border-color .25s ease, transform .25s ease; position: relative; overflow: hidden;
        }
        .t-bento-item:hover { border-color: rgba(200, 255, 61, .55); transform: translateY(-4px); }
        .t-bento-icon { width: 46px; height: 46px; border-radius: 12px; background: var(--t-accent-dim); color: var(--t-accent); border: 1px solid rgba(200, 255, 61, .25); display: flex; align-items: center; justify-content: center; font-size: 21px; margin-bottom: 20px; }
        .t-bento-item h3 { font-size: 20px; margin-bottom: 8px; }
        .t-bento-item p { margin: 0; font-size: 14.5px; color: var(--t-muted); }
        .t-bento-num { position: absolute; top: 18px; right: 22px; font-family: var(--t-f-mono); font-size: 12px; color: var(--t-line); }
        .t-bento-item:nth-child(1) { display: flex; flex-direction: column; justify-content: flex-end; min-height: 260px; background: linear-gradient(180deg, var(--t-surface), var(--t-surface-2)); }
        .t-bento-item:nth-child(1) h3 { font-size: 30px; }
        .t-bento-item:nth-child(1) p { font-size: 16px; }
        .t-bento-item:nth-child(1) .t-bento-icon { width: 58px; height: 58px; font-size: 26px; }

        /* ===== Configurator (armada) ===== */
        .t-cfg { display: grid; grid-template-columns: 1fr; gap: 24px; }
        @media (min-width: 992px) { .t-cfg { grid-template-columns: 300px 1fr; gap: 32px; } }
        .t-cfg-list { display: flex; gap: 10px; overflow-x: auto; padding-bottom: 6px; scrollbar-width: none; }
        .t-cfg-list::-webkit-scrollbar { display: none; }
        @media (min-width: 992px) { .t-cfg-list { flex-direction: column; overflow: visible; } }
        .t-cfg-item {
            flex: 0 0 auto; text-align: left; background: var(--t-surface); border: 1px solid var(--t-line); color: var(--t-text);
            border-radius: 12px; padding: 14px 18px; cursor: pointer; font-family: var(--t-f-display); font-size: 16px; font-weight: 500;
            display: flex; align-items: center; justify-content: space-between; gap: 14px; transition: all .2s ease; min-width: 190px;
        }
        .t-cfg-item small { font-family: var(--t-f-mono); font-size: 11px; color: var(--t-muted); }
        .t-cfg-item:hover { border-color: #3a4a5f; }
        .t-cfg-item.is-active { border-color: var(--t-accent); background: var(--t-accent-dim); color: #fff; }
        .t-cfg-item.is-active small { color: var(--t-accent); }

        .t-cfg-panel { background: var(--t-surface); border: 1px solid var(--t-line); border-radius: 18px; overflow: hidden; display: grid; grid-template-columns: 1fr; }
        @media (min-width: 768px) { .t-cfg-panel { grid-template-columns: 1.1fr .9fr; } }
        .t-cfg-img { background: var(--t-surface-2); aspect-ratio: 4/3; overflow: hidden; position: relative; }
        .t-cfg-img img { width: 100%; height: 100%; object-fit: cover; transition: opacity .3s ease, transform .6s ease; }
        .t-cfg-img.is-swap img { opacity: 0; transform: scale(1.03); }
        .t-cfg-tag { position: absolute; top: 14px; left: 14px; font-family: var(--t-f-mono); font-size: 11px; background: rgba(11, 15, 20, .85); color: var(--t-accent); border: 1px solid rgba(200, 255, 61, .3); padding: 5px 10px; border-radius: 6px; }
        .t-cfg-info { padding: 28px; display: flex; flex-direction: column; }
        .t-cfg-cat { font-family: var(--t-f-mono); font-size: 12px; color: var(--t-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
        .t-cfg-info h3 { font-size: 30px; margin-bottom: 8px; }
        .t-cfg-tagline { font-size: 14.5px; color: var(--t-muted); margin-bottom: 18px; }
        .t-cfg-price { font-family: var(--t-f-display); font-size: 28px; font-weight: 700; color: var(--t-accent); }
        .t-cfg-old { font-size: 14px; color: var(--t-muted); text-decoration: line-through; margin-left: 10px; font-weight: 400; }
        .t-cfg-disc { display: inline-block; font-family: var(--t-f-mono); font-size: 11px; background: var(--t-accent); color: #0b0f14; padding: 2px 8px; border-radius: 5px; margin-left: 8px; font-weight: 600; vertical-align: middle; }
        .t-cfg-variants { list-style: none; margin: 18px 0 22px; padding: 0; border-top: 1px solid var(--t-line); }
        .t-cfg-variants li { display: flex; justify-content: space-between; gap: 14px; padding: 10px 0; border-bottom: 1px solid var(--t-line); font-size: 14px; }
        .t-cfg-variants li span:first-child { color: var(--t-muted); }
        .t-cfg-variants li span:last-child { font-family: var(--t-f-mono); font-size: 13px; color: var(--t-text); }
        .t-cfg-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: auto; }

        /* ===== Promo ===== */
        .t-promo { background: var(--t-surface); border: 1px solid var(--t-line); border-radius: 18px; overflow: hidden; display: grid; grid-template-columns: 1fr; margin-bottom: 20px; }
        @media (min-width: 768px) { .t-promo { grid-template-columns: .9fr 1.1fr; } }
        .t-promo-img { aspect-ratio: 16/10; background: var(--t-surface-2); overflow: hidden; }
        .t-promo-img img { width: 100%; height: 100%; object-fit: cover; }
        .t-promo-body { padding: 32px; display: flex; flex-direction: column; justify-content: center; }
        .t-live { font-family: var(--t-f-mono); font-size: 12px; color: #ff6b6b; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 12px; letter-spacing: 1px; }
        .t-live i { width: 8px; height: 8px; border-radius: 50%; background: #ff6b6b; animation: tPulse 1.2s ease-in-out infinite; }
        .t-promo-body h3 { font-size: 30px; margin-bottom: 10px; }
        .t-promo-body p { color: var(--t-muted); margin-bottom: 22px; }
        .t-count { display: flex; gap: 10px; margin-bottom: 26px; flex-wrap: wrap; }
        .t-count-cell { background: var(--t-bg); border: 1px solid var(--t-line); border-radius: 10px; padding: 10px 14px; min-width: 70px; text-align: center; }
        .t-count-num { font-family: var(--t-f-mono); font-size: 28px; font-weight: 600; color: var(--t-accent); line-height: 1; }
        .t-count-label { font-family: var(--t-f-mono); font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: var(--t-muted); margin-top: 6px; }

        /* ===== Gallery ===== */
        .t-gal { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; }
        @media (min-width: 992px) { .t-gal { grid-template-columns: repeat(3, 1fr); } .t-gal-item:nth-child(4n+1) { grid-row: span 2; } }
        .t-gal-item { position: relative; border-radius: 14px; overflow: hidden; background: var(--t-surface-2); aspect-ratio: 4/3; display: block; text-decoration: none; border: 1px solid var(--t-line); }
        @media (min-width: 992px) { .t-gal-item:nth-child(4n+1) { aspect-ratio: auto; } }
        .t-gal-item img { width: 100%; height: 100%; object-fit: cover; transition: transform .7s ease; }
        .t-gal-item:hover img { transform: scale(1.06); }
        .t-gal-cap { position: absolute; left: 0; right: 0; bottom: 0; padding: 40px 16px 14px; background: linear-gradient(0deg, rgba(11, 15, 20, .92), transparent); }
        .t-gal-cap strong { display: block; font-family: var(--t-f-display); font-size: 15px; color: #fff; font-weight: 600; }
        .t-gal-cap span { font-family: var(--t-f-mono); font-size: 11.5px; color: var(--t-accent); }

        /* ===== Delivery log ===== */
        .t-del { background: var(--t-light-surface); border: 1px solid #d9e0e8; border-radius: 16px; overflow: hidden; height: 100%; }
        .t-del-img { aspect-ratio: 4/3; overflow: hidden; background: #dfe6ee; }
        .t-del-img img { width: 100%; height: 100%; object-fit: cover; }
        .t-del-body { padding: 18px 20px 20px; }
        .t-del-meta { font-family: var(--t-f-mono); font-size: 11.5px; color: var(--t-light-muted); letter-spacing: .5px; text-transform: uppercase; }
        .t-del-body h4 { font-size: 18px; margin: 6px 0 12px; color: var(--t-light-text); }
        .t-del-ok { display: inline-flex; align-items: center; gap: 7px; font-family: var(--t-f-mono); font-size: 11.5px; font-weight: 600; color: #2b6b00; background: #e6f8c8; padding: 5px 10px; border-radius: 6px; }

        /* ===== Stats ===== */
        .t-stats { display: grid; grid-template-columns: repeat(2, 1fr); border: 1px solid var(--t-line); border-radius: 16px; background: var(--t-surface); overflow: hidden; }
        @media (min-width: 768px) { .t-stats { grid-template-columns: repeat(4, 1fr); } }
        .t-stat { padding: 34px 26px; border-right: 1px solid var(--t-line); border-bottom: 1px solid var(--t-line); }
        .t-stat-num { font-family: var(--t-f-display); font-size: clamp(36px, 4.4vw, 54px); font-weight: 700; color: #fff; line-height: 1; }
        .t-stat-num em { font-style: normal; color: var(--t-accent); }
        .t-stat-label { font-family: var(--t-f-mono); font-size: 12px; letter-spacing: 1px; text-transform: uppercase; color: var(--t-muted); margin-top: 10px; }

        /* ===== Testimonial ===== */
        .t-testi { background: var(--t-surface); border: 1px solid var(--t-line); border-radius: 16px; padding: 28px; height: 100%; display: flex; flex-direction: column; }
        .t-testi-stars { color: var(--t-accent); font-size: 13px; letter-spacing: 2px; margin-bottom: 14px; }
        .t-testi p { font-size: 16px; color: var(--t-text); margin-bottom: 22px; flex: 1; }
        .t-testi-name { font-family: var(--t-f-display); font-weight: 600; color: #fff; }
        .t-testi-job { font-family: var(--t-f-mono); font-size: 12px; color: var(--t-muted); }

        /* ===== FAQ ===== */
        .t-faq-item { border: 1px solid #d4dce6; border-radius: 12px; background: var(--t-light-surface); margin-bottom: 12px; overflow: hidden; }
        .t-faq-btn { width: 100%; text-align: left; background: none; border: none; padding: 20px 22px; display: flex; align-items: center; gap: 16px; font-family: var(--t-f-display); font-weight: 600; font-size: 17px; color: var(--t-light-text); cursor: pointer; }
        .t-faq-q { font-family: var(--t-f-mono); font-size: 12px; color: #3f6b00; background: #e6f8c8; padding: 3px 8px; border-radius: 5px; flex-shrink: 0; }
        .t-faq-icon { margin-left: auto; font-size: 18px; color: #3f6b00; transition: transform .3s ease; }
        .t-faq-btn[aria-expanded="true"] .t-faq-icon { transform: rotate(45deg); }
        .t-faq-panel { max-height: 0; overflow: hidden; transition: max-height .35s ease; }
        .t-faq-inner { padding: 0 22px 22px 70px; color: var(--t-light-muted); font-size: 15px; }

        /* ===== Form ===== */
        .t-form-grid { display: grid; grid-template-columns: 1fr; gap: 50px; align-items: center; }
        @media (min-width: 992px) { .t-form-grid { grid-template-columns: .9fr 1.1fr; gap: 70px; } }
        .t-form-left h2 { font-size: clamp(32px, 4.2vw, 52px); line-height: 1.05; margin-bottom: 16px; }
        .t-form-left p { color: var(--t-muted); font-size: 17px; margin-bottom: 30px; max-width: 440px; }
        .t-perk { display: flex; align-items: center; gap: 14px; padding: 14px 0; border-top: 1px solid var(--t-line); font-size: 15px; }
        .t-perk:last-child { border-bottom: 1px solid var(--t-line); }
        .t-perk i { color: var(--t-accent); font-size: 18px; }
        .t-form-card { background: var(--t-surface); border: 1px solid var(--t-line); border-radius: 18px; padding: 34px; position: relative; }
        .t-form-card::before { content: ''; position: absolute; top: 0; left: 34px; right: 34px; height: 2px; background: var(--t-accent); border-radius: 0 0 4px 4px; }
        .t-field { margin-bottom: 20px; }
        .t-field label { display: block; font-family: var(--t-f-mono); font-size: 11.5px; letter-spacing: 1px; text-transform: uppercase; color: var(--t-muted); margin-bottom: 8px; }
        .t-field input, .t-field select, .t-field textarea {
            width: 100%; background: var(--t-bg); border: 1px solid var(--t-line); border-radius: 10px; color: var(--t-text);
            padding: 13px 15px; font-family: var(--t-f-body); font-size: 15.5px; transition: border-color .2s ease, box-shadow .2s ease;
        }
        .t-field select option { background: var(--t-bg); color: var(--t-text); }
        .t-field input:focus, .t-field select:focus, .t-field textarea:focus { outline: none; border-color: var(--t-accent); box-shadow: 0 0 0 3px rgba(200, 255, 61, .14); }
        .t-field textarea { resize: vertical; min-height: 88px; }
        .t-submit { width: 100%; justify-content: center; padding: 16px; font-size: 16px; }

        /* ===== Footer / sticky ===== */
        .t-footer { background: var(--t-bg); border-top: 1px solid var(--t-line); padding: 36px 20px; text-align: center; font-family: var(--t-f-mono); font-size: 12.5px; color: var(--t-muted); }
        .t-sticky { position: fixed; bottom: 0; left: 0; right: 0; z-index: 1040; background: rgba(11, 15, 20, .97); border-top: 1px solid var(--t-line); padding: 10px 14px; display: flex; gap: 10px; }
        .t-sticky a { flex: 1; text-align: center; padding: 12px; border-radius: 10px; font-family: var(--t-f-display); font-weight: 600; font-size: 14px; text-decoration: none; }
        .t-s-call { border: 1px solid var(--t-line); color: var(--t-text); }
        .t-s-wa { background: var(--t-accent); color: #0b0f14; }
        @media (min-width: 992px) { .t-sticky { display: none; } body { padding-bottom: 0; } }
        @media (max-width: 767px) { .t-section { padding: 72px 0; } .t-hero { padding: 56px 0 70px; } .t-cfg-info { padding: 22px; } }
    </style>
</head>

<body>

    {{-- ============ NAV ============ --}}
    <div class="t-nav">
        <div class="t-nav-inner">
            <a href="#" class="t-brand"><span class="t-brand-mark"><i class="bi bi-speedometer2"></i></span> {{ $profile->name ?? config('settings.site_name') }}</a>
            <div class="t-nav-links">
                @if($products->count())<a href="#armada">Armada</a>@endif
                @if($services->count())<a href="#layanan">Layanan</a>@endif
                @if($promos->count())<a href="#promo">Promo</a>@endif
                @if(!empty($landingPage->faqs))<a href="#faq">FAQ</a>@endif
            </div>
            <a href="{{ $profile->wa_url }}" target="_blank" class="t-btn t-btn-primary t-btn-sm"><i class="bi bi-whatsapp"></i> Chat</a>
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
                    <h1 class="t-reveal">{!! nl2br(preg_replace('/\*(.+?)\*/', '<span class="t-hl">$1</span>', e($landingPage->headline))) !!}</h1>
                    @if($landingPage->subheadline)
                    <p class="t-hero-desc t-reveal">{{ $landingPage->subheadline }}</p>
                    @endif
                    <div class="t-hero-actions t-reveal">
                        <a href="#konsultasi" class="t-btn t-btn-primary">{{ $landingPage->hero_cta_label ?: 'Mulai Konsultasi' }} <i class="bi bi-arrow-right"></i></a>
                        @if($products->count())
                        <a href="#armada" class="t-btn t-btn-ghost">Jelajahi Unit</a>
                        @endif
                    </div>

                    <div class="t-readouts t-reveal">
                        <div class="t-readout"><div class="t-readout-num"><span class="t-num" data-count="{{ $stats['products_count'] }}">0</span>+</div><div class="t-readout-label">Pilihan Unit</div></div>
                        @if($stats['deliveries_count'] > 0)
                        <div class="t-readout"><div class="t-readout-num"><span class="t-num" data-count="{{ $stats['deliveries_count'] }}">0</span>+</div><div class="t-readout-label">Unit Diserahkan</div></div>
                        @endif
                        @if($stats['avg_rating'])
                        <div class="t-readout"><div class="t-readout-num">{{ $stats['avg_rating'] }}<span style="font-size:.55em;color:#8b98a9;">/5</span></div><div class="t-readout-label">Rating</div></div>
                        @endif
                    </div>
                </div>

                @if(($profile->image_url ?? null) || ($profile->bio ?? null))
                <div class="t-id t-reveal">
                    @if($profile->image_url)
                    <div class="t-id-photo"><img src="{{ $profile->image_url }}" alt="{{ $profile->name }}"></div>
                    @endif
                    <div class="t-id-meta">
                        <div>
                            <div class="t-id-name">{{ $profile->name }}</div>
                            @if($profile->job_title)<div class="t-id-job">{{ $profile->job_title }}</div>@endif
                        </div>
                        <span class="t-status"><i></i> ONLINE</span>
                    </div>
                    @if($profile->bio)
                    <div class="t-id-bio">{{ Str::limit(strip_tags($profile->bio), 150) }}</div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ============ TICKER ============ --}}
    @if(!empty($landingPage->trust_badges))
    <div class="t-ticker">
        <div class="t-ticker-track">
            @for($r = 0; $r < 2; $r++)
                @foreach($landingPage->trust_badges as $badge)
                <span class="t-ticker-item">{{ $badge }}</span>
                @endforeach
            @endfor
        </div>
    </div>
    @endif

    {{-- ============ ARMADA (konfigurator) ============ --}}
    @if($products->count())
    @php
        $lineup = $products->map(function ($p) {
            return [
                'id'       => $p->id,
                'name'     => $p->name,
                'category' => optional($p->product_category)->category,
                'img'      => $p->image_url,
                'tagline'  => $p->tagline,
                'price'    => $p->disc > 0 ? $p->special_min_price : $p->min_price,
                'old'      => $p->disc > 0 ? $p->min_price : null,
                'disc'     => (int) $p->disc,
                'url'      => route('product.detail', $p->slug),
                'variants' => $p->product_type->map(function ($t) {
                    return ['type' => $t->type, 'price' => 'Rp. ' . number_format($t->price)];
                })->values()->all(),
            ];
        })->values();
    @endphp
    <section id="armada" class="t-section t-dark">
        <div class="t-wrap">
            <div class="t-head t-reveal">
                <span class="t-label">Armada</span>
                <h2>Pilih unit, lihat detailnya <span class="t-hl">seketika</span></h2>
                <p class="t-muted">Klik salah satu unit di daftar untuk melihat varian dan harga tanpa pindah halaman.</p>
            </div>

            <div class="t-cfg t-reveal">
                <div class="t-cfg-list" id="cfg-list">
                    @foreach($products as $product)
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
                    </div>
                    <div class="t-cfg-info">
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
                </div>
            </div>
            <script type="application/json" id="lineup-data">@json($lineup)</script>
        </div>
    </section>
    @endif

    {{-- ============ LAYANAN (bento) ============ --}}
    @if($services->count())
    <section id="layanan" class="t-section t-dark-2">
        <div class="t-wrap">
            <div class="t-head t-reveal">
                <span class="t-label">Layanan</span>
                <h2>Didampingi <span class="t-hl">end-to-end</span>, dari pilih unit sampai serah terima</h2>
            </div>
            <div class="t-bento">
                @foreach($services as $service)
                <div class="t-bento-item t-reveal">
                    <span class="t-bento-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <div class="t-bento-icon"><i class="bi {{ $service->icon }}"></i></div>
                    <h3>{{ $service->title }}</h3>
                    @if($service->desc)<p>{{ Str::limit(strip_tags($service->desc), 120) }}</p>@endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============ PROMO ============ --}}
    @if($promos->count())
    <section id="promo" class="t-section t-dark">
        <div class="t-wrap">
            <div class="t-head t-reveal">
                <span class="t-label">Promo</span>
                <h2>Penawaran <span class="t-hl">aktif</span> dengan hitung mundur</h2>
            </div>
            @foreach($promos as $promo)
            <div class="t-promo t-reveal">
                @if($promo->promo_image_url)
                <div class="t-promo-img"><img src="{{ $promo->promo_image_url }}" alt="{{ $promo->promo }}" loading="lazy"></div>
                @endif
                <div class="t-promo-body">
                    <span class="t-live"><i></i> LIVE DEAL</span>
                    <h3>{{ $promo->promo }}</h3>
                    @if($promo->desc)<p>{{ Str::limit(strip_tags($promo->desc), 140) }}</p>@endif

                    @if($promo->effective_date)
                    <div class="t-count" data-countdown="{{ $promo->effective_date->format('Y-m-d') }} 23:59:59">
                        <div class="t-count-cell"><div class="t-count-num" data-unit="days">00</div><div class="t-count-label">Hari</div></div>
                        <div class="t-count-cell"><div class="t-count-num" data-unit="hours">00</div><div class="t-count-label">Jam</div></div>
                        <div class="t-count-cell"><div class="t-count-num" data-unit="minutes">00</div><div class="t-count-label">Menit</div></div>
                        <div class="t-count-cell"><div class="t-count-num" data-unit="seconds">00</div><div class="t-count-label">Detik</div></div>
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
    @if($galleries->count())
    <section id="galeri" class="t-section t-dark-2">
        <div class="t-wrap">
            <div class="t-head t-reveal">
                <span class="t-label">Galeri</span>
                <h2>Di balik layar showroom dan <span class="t-hl">acara kami</span></h2>
            </div>
            <div class="t-gal">
                @foreach($galleries as $gallery)
                <a href="{{ route('gallery.show', $gallery->slug) }}" class="t-gal-item t-reveal">
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
    @if($deliveries->count())
    <section class="t-section t-light">
        <div class="t-wrap">
            <div class="t-head t-reveal">
                <span class="t-label">Delivery Log</span>
                <h2>Bukti serah terima, bukan sekadar janji</h2>
                <p class="t-muted">Foto asli dari unit yang baru saja kami serahkan ke pelanggan, diperbarui otomatis.</p>
            </div>
            <div class="row g-4">
                @foreach($deliveries as $delivery)
                @php $deliveryImg = $delivery->getFirstMediaUrl('images'); @endphp
                @if($deliveryImg)
                <div class="col-md-6 col-lg-4 t-reveal">
                    <div class="t-del">
                        <div class="t-del-img"><img src="{{ $deliveryImg }}" alt="Serah terima {{ $delivery->product->name ?? '' }}" loading="lazy"></div>
                        <div class="t-del-body">
                            <div class="t-del-meta">DELIVERED // {{ $delivery->created_at->translatedFormat('d M Y') }}</div>
                            @if($delivery->product)<h4>{{ $delivery->product->name }}</h4>@endif
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
                <div class="t-stat"><div class="t-stat-num"><span class="t-num" data-count="{{ $stats['products_count'] }}">0</span><em>+</em></div><div class="t-stat-label">Pilihan Unit</div></div>
                @if($stats['deliveries_count'] > 0)
                <div class="t-stat"><div class="t-stat-num"><span class="t-num" data-count="{{ $stats['deliveries_count'] }}">0</span><em>+</em></div><div class="t-stat-label">Unit Diserahkan</div></div>
                @endif
                @if($stats['testimonies_count'] > 0)
                <div class="t-stat"><div class="t-stat-num"><span class="t-num" data-count="{{ $stats['testimonies_count'] }}">0</span><em>+</em></div><div class="t-stat-label">Cerita Pelanggan</div></div>
                @endif
                @if($stats['avg_rating'])
                <div class="t-stat"><div class="t-stat-num">{{ $stats['avg_rating'] }}<em>/5</em></div><div class="t-stat-label">Rata-rata Rating</div></div>
                @endif
            </div>
        </div>
    </section>

    {{-- ============ TESTIMONI ============ --}}
    @if($testimonies->count())
    <section class="t-section t-dark-2">
        <div class="t-wrap">
            <div class="t-head t-reveal">
                <span class="t-label">Testimoni</span>
                <h2>Kata pelanggan yang <span class="t-hl">sudah membawa pulang</span> unitnya</h2>
            </div>
            <div class="row g-4">
                @foreach($testimonies as $testimony)
                <div class="col-md-6 col-lg-4 t-reveal">
                    <div class="t-testi">
                        <div class="t-testi-stars">@for($i = 0; $i < ($testimony->rating ?: 5); $i++)<i class="bi bi-star-fill"></i>@endfor</div>
                        <p>"{{ Str::limit(strip_tags($testimony->message), 170) }}"</p>
                        <div>
                            <div class="t-testi-name">{{ $testimony->name }}</div>
                            @if($testimony->job)<div class="t-testi-job">{{ $testimony->job }}</div>@endif
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
    <section id="faq" class="t-section t-light">
        <div class="t-wrap" style="max-width:820px;">
            <div class="t-head t-reveal">
                <span class="t-label">FAQ</span>
                <h2>Pertanyaan yang paling sering muncul</h2>
            </div>
            @foreach($landingPage->faqs as $faq)
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
                                <div class="col-md-6"><div class="t-field"><label>Nama lengkap</label><input type="text" name="name" required></div></div>
                                <div class="col-md-6"><div class="t-field"><label>No. WhatsApp</label><input type="text" name="phone" placeholder="08xxxxxxxxxx" required></div></div>
                                <div class="col-md-6"><div class="t-field"><label>Kota</label><input type="text" name="city"></div></div>
                                <div class="col-md-6">
                                    <div class="t-field">
                                        <label>Unit yang diminati</label>
                                        <select name="product_id" id="lp-product-select">
                                            <option value="">Belum tahu / bebas</option>
                                            @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12"><div class="t-field"><label>Pesan (opsional)</label><textarea name="message" placeholder="Contoh: mau tanya simulasi kredit DP 20 juta"></textarea></div></div>
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
        &copy; {{ date('Y') }} {{ $profile->name ?? config('settings.site_name') }} // Semua hak dilindungi
        @if($profile->phone ?? null) // {{ $profile->phone }} @endif
    </footer>

    <div class="t-sticky">
        <a href="tel:{{ $profile->phone ?? '' }}" class="t-s-call"><i class="bi bi-telephone-fill"></i> Telepon</a>
        <a href="{{ $profile->wa_url }}" target="_blank" class="t-s-wa"><i class="bi bi-whatsapp"></i> WhatsApp</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ mix('frontend/js/app.js') }}"></script>
    <script>
        (function () {
            /* ---------- Reveal ringan (sekali per elemen) + counter ---------- */
            if (window.gsap && window.ScrollTrigger) {
                gsap.registerPlugin(ScrollTrigger);
                function settle(el) { el.classList.remove('t-reveal'); gsap.set(el, { clearProps: 'all' }); }
                gsap.timeline().to('.t-hero .t-reveal', { opacity: 1, y: 0, duration: .8, stagger: .1, ease: 'power3.out', delay: .1, onComplete: function () { document.querySelectorAll('.t-hero .t-reveal').forEach(settle); } });
                document.querySelectorAll('.t-reveal:not(.t-hero .t-reveal)').forEach(function (el) {
                    gsap.to(el, { opacity: 1, y: 0, duration: .8, ease: 'power3.out', scrollTrigger: { trigger: el, start: 'top 90%', once: true }, onComplete: function () { settle(el); } });
                });
                document.querySelectorAll('.t-num[data-count]').forEach(function (el) {
                    const target = parseInt(el.dataset.count, 10) || 0;
                    const obj = { val: 0 };
                    ScrollTrigger.create({
                        trigger: el, start: 'top 95%', once: true,
                        onEnter: function () {
                            gsap.to(obj, { val: target, duration: 1.5, ease: 'power2.out', onUpdate: function () { el.textContent = Math.floor(obj.val); } });
                        }
                    });
                });
            } else {
                document.querySelectorAll('.t-reveal').forEach(function (el) { el.style.opacity = 1; el.style.transform = 'none'; });
                document.querySelectorAll('.t-num[data-count]').forEach(function (el) { el.textContent = el.dataset.count; });
            }

            /* ---------- Konfigurator unit ---------- */
            const dataEl = document.getElementById('lineup-data');
            if (dataEl) {
                const lineup = JSON.parse(dataEl.textContent || '[]');
                const $ = function (id) { return document.getElementById(id); };
                const imgWrap = $('cfg-img-wrap'), img = $('cfg-img');
                const items = document.querySelectorAll('.t-cfg-item');

                function render(i) {
                    const d = lineup[i];
                    if (!d) return;
                    imgWrap.classList.add('is-swap');
                    setTimeout(function () {
                        img.src = d.img || '';
                        img.alt = d.name;
                        imgWrap.classList.remove('is-swap');
                    }, 160);

                    $('cfg-cat').textContent = d.category || '';
                    $('cfg-name').textContent = d.name;
                    $('cfg-tagline').textContent = d.tagline || '';
                    $('cfg-price').textContent = d.price;
                    $('cfg-old').textContent = d.old || '';
                    const disc = $('cfg-disc');
                    if (d.disc > 0) { disc.style.display = ''; disc.textContent = '-' + d.disc + '%'; } else { disc.style.display = 'none'; }
                    const tag = $('cfg-tag');
                    tag.style.display = '';
                    tag.textContent = 'UNIT ' + String(i + 1).padStart(2, '0') + ' / ' + String(lineup.length).padStart(2, '0');

                    const ul = $('cfg-variants');
                    ul.innerHTML = '';
                    (d.variants || []).forEach(function (v) {
                        const li = document.createElement('li');
                        const a = document.createElement('span'); a.textContent = v.type;
                        const b = document.createElement('span'); b.textContent = v.price;
                        li.appendChild(a); li.appendChild(b); ul.appendChild(li);
                    });

                    $('cfg-detail').href = d.url;
                    $('cfg-ask').dataset.productId = d.id;

                    items.forEach(function (it) { it.classList.toggle('is-active', parseInt(it.dataset.index, 10) === i); });
                }

                items.forEach(function (it) {
                    it.addEventListener('click', function () { render(parseInt(it.dataset.index, 10)); });
                });
                render(0);
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

            /* ---------- FAQ ---------- */
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
