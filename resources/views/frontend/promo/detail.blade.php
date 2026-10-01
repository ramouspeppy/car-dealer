@extends('frontend.layouts.app')

@section('content')
    @push('css')
        <style>
            .promo-detail-page {
                --pd-surface: rgba(255, 255, 255, 0.94);
                --pd-border: rgba(17, 24, 39, 0.08);
                --pd-text: #111827;
                --pd-muted: rgba(17, 24, 39, 0.68);
                --pd-shadow: 0 18px 40px rgba(17, 24, 39, 0.07);
                --pd-accent: var(--accent-color, #3b8ff9);
                --pd-accent-soft: color-mix(in srgb, var(--pd-accent), transparent 88%);
                background: linear-gradient(180deg, rgba(246, 247, 249, 0.96) 0%, #eef1f5 100%);
                padding: 30px 0 70px;
            }

            body[data-theme="dark"] .promo-detail-page {
                --pd-surface: rgba(17, 24, 39, 0.94);
                --pd-border: rgba(148, 163, 184, 0.18);
                --pd-text: #edf2f7;
                --pd-muted: rgba(226, 232, 240, 0.72);
                --pd-shadow: 0 24px 44px rgba(2, 6, 23, 0.4);
                background: linear-gradient(180deg, #0d1117 0%, #111827 100%);
            }

            .promo-detail-breadcrumb {
                font-size: 13px;
                color: var(--pd-muted);
                margin-bottom: 18px;
            }

            .promo-detail-breadcrumb a {
                color: var(--pd-accent);
                text-decoration: none;
                font-weight: 600;
            }

            .promo-detail-main {
                background: var(--pd-surface);
                border: 1px solid var(--pd-border);
                border-radius: 24px;
                overflow: hidden;
                box-shadow: var(--pd-shadow);
            }

            .promo-detail-cover {
                position: relative;
                min-height: 320px;
                background: color-mix(in srgb, var(--pd-accent), var(--pd-surface) 85%);
            }

            .promo-detail-cover img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                min-height: 320px;
                max-height: 460px;
            }

            .promo-detail-cover .badge-top {
                position: absolute;
                top: 18px;
                left: 18px;
                background: var(--pd-accent);
                color: var(--contrast-color, #12314f);
                font-size: 12px;
                font-weight: 700;
                padding: 8px 14px;
                border-radius: 999px;
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }

            .promo-detail-cover .badge-top.is-urgent {
                background: #e63946;
                color: #fff;
            }

            .promo-detail-body {
                padding: 28px 28px 10px;
            }

            .promo-detail-body h1 {
                font-family: var(--heading-font);
                font-size: clamp(1.6rem, 3vw, 2.2rem);
                color: var(--pd-text);
                line-height: 1.25;
                margin-bottom: 12px;
            }

            .promo-detail-meta {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-bottom: 22px;
            }

            .promo-detail-meta span {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 13px;
                font-weight: 600;
                color: var(--pd-accent);
                background: var(--pd-accent-soft);
                padding: 6px 12px;
                border-radius: 999px;
            }

            .promo-detail-desc {
                color: var(--pd-muted);
                font-size: 1rem;
                line-height: 1.8;
                margin-bottom: 8px;
            }

            .promo-detail-desc p {
                margin-bottom: 1rem;
            }

            .promo-detail-sidebar {
                position: sticky;
                top: 100px;
            }

            .promo-side-card {
                background: var(--pd-surface);
                border: 1px solid var(--pd-border);
                border-radius: 22px;
                padding: 24px;
                box-shadow: var(--pd-shadow);
                margin-bottom: 16px;
            }

            .promo-side-card h3 {
                font-family: var(--heading-font);
                font-size: 1.15rem;
                color: var(--pd-text);
                margin-bottom: 8px;
            }

            .promo-side-card p {
                color: var(--pd-muted);
                font-size: 0.92rem;
                line-height: 1.6;
                margin-bottom: 16px;
            }

            .promo-side-deadline {
                background: var(--pd-accent-soft);
                border-radius: 14px;
                padding: 14px 16px;
                margin-bottom: 16px;
            }

            .promo-side-deadline strong {
                display: block;
                color: var(--pd-text);
                font-size: 1.05rem;
                margin-bottom: 4px;
            }

            .promo-side-deadline span {
                font-size: 13px;
                color: var(--pd-muted);
                font-weight: 600;
            }

            .promo-side-card .btn-wa {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                width: 100%;
                background: linear-gradient(135deg, #25d366, #1da851);
                color: #fff !important;
                border-radius: 999px;
                padding: 13px 18px;
                font-weight: 700;
                text-decoration: none;
                margin-bottom: 10px;
            }

            .promo-side-card .btn-outline-soft {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                width: 100%;
                border: 1.5px solid color-mix(in srgb, var(--pd-text), transparent 80%);
                color: var(--pd-text);
                border-radius: 999px;
                padding: 12px 18px;
                font-weight: 600;
                text-decoration: none;
            }

            .promo-side-card .btn-outline-soft:hover {
                border-color: var(--pd-accent);
                color: var(--pd-accent);
            }

            .promo-related {
                margin-top: 40px;
            }

            .promo-related h2 {
                font-family: var(--heading-font);
                font-size: 1.5rem;
                color: var(--pd-text);
                margin-bottom: 18px;
            }

            .promo-related-card {
                background: var(--pd-surface);
                border: 1px solid var(--pd-border);
                border-radius: 18px;
                overflow: hidden;
                height: 100%;
                box-shadow: var(--pd-shadow);
                transition: transform 0.3s ease;
            }

            .promo-related-card:hover {
                transform: translateY(-6px);
            }

            .promo-related-card img {
                width: 100%;
                height: 160px;
                object-fit: cover;
            }

            .promo-related-card .body {
                padding: 16px;
            }

            .promo-related-card h4 {
                font-size: 1rem;
                color: var(--pd-text);
                margin-bottom: 8px;
                font-family: var(--heading-font);
            }

            .promo-related-card a.stretched {
                text-decoration: none;
                color: inherit;
            }

            @media (max-width: 991.98px) {
                .promo-detail-sidebar {
                    position: static;
                    margin-top: 20px;
                }
            }
        </style>
    @endpush

    <section class="promo-detail-page section">
        <div class="container">
            <div class="promo-detail-breadcrumb" data-aos="fade-up">
                <a href="{{ url('/') }}">Home</a>
                <span class="mx-1">/</span>
                <a href="{{ route('promo.index') }}">Promo</a>
                <span class="mx-1">/</span>
                <span>{{ $card->title }}</span>
            </div>

            <div class="row g-4">
                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                    <article class="promo-detail-main">
                        <div class="promo-detail-cover">
                            @if ($card->image_url)
                                <img src="{{ $card->image_url }}" alt="{{ $card->title }}">
                            @endif
                            <span class="badge-top {{ $card->badge_class }}">
                                <i class="bi {{ $card->badge_icon }}"></i>
                                {{ $card->badge_label }}
                            </span>
                        </div>
                        <div class="promo-detail-body">
                            <h1>{{ $card->title }}</h1>
                            <div class="promo-detail-meta">
                                <span><i class="bi bi-calendar3"></i> Berlaku sampai {{ $card->effective_label }}</span>
                                @if ($card->deadline_text)
                                    <span><i class="bi bi-hourglass-split"></i> {{ $card->deadline_text }}</span>
                                @endif
                            </div>
                            <div class="promo-detail-desc">
                                {!! $card->description !!}
                            </div>
                        </div>
                    </article>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="150">
                    <aside class="promo-detail-sidebar">
                        <div class="promo-side-card">
                            <h3>Ambil promo ini</h3>
                            <p>Hubungi sales {{ config('settings.site_brand') }} via WhatsApp untuk claim penawaran dan cek ketersediaan.</p>

                            @if ($card->show_progress)
                                <div class="promo-side-deadline">
                                    <strong>{{ $card->badge_label }}</strong>
                                    <span>{{ $card->deadline_text }} · sampai {{ $card->effective_label }}</span>
                                    <div class="promo-deadline-bar mt-2">
                                        <span style="width: {{ $card->progress }}%; display:block; height:6px; border-radius:999px; background: var(--pd-accent);"></span>
                                    </div>
                                </div>
                            @endif

                            <a href="{{ $card->wa_link }}" target="_blank" rel="noopener" class="btn-wa">
                                <i class="bi bi-whatsapp"></i> Chat WhatsApp
                            </a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#consultationModal" class="btn-outline-soft">
                                <i class="bi bi-chat-dots"></i> Konsultasi Dulu
                            </a>
                        </div>

                        <div class="promo-side-card">
                            <h3>Butuh test drive?</h3>
                            <p class="mb-3">Jadwalkan test drive unit {{ config('settings.site_brand') }} favorit Anda.</p>
                            <a href="{{ route('testdrive.show') }}" class="btn-outline-soft">
                                <i class="bi bi-steering-wheel"></i> Booking Test Drive
                            </a>
                        </div>
                    </aside>
                </div>
            </div>

            @if ($relatedCards->isNotEmpty())
                <div class="promo-related" data-aos="fade-up">
                    <h2>Promo lainnya</h2>
                    <div class="row g-4">
                        @foreach ($relatedCards as $rel)
                            <div class="col-md-4">
                                <div class="promo-related-card">
                                    <a href="{{ $rel->detail_url }}" class="stretched">
                                        @if ($rel->image_url)
                                            <img src="{{ $rel->image_url }}" alt="{{ $rel->title }}" loading="lazy">
                                        @endif
                                        <div class="body">
                                            <h4>{{ $rel->title }}</h4>
                                            <small class="text-muted">{{ $rel->badge_label }} · sampai {{ $rel->effective_label }}</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
