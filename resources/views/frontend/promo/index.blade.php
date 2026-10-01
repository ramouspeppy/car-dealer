@extends('frontend.layouts.app')

@section('content')
    @push('css')
        <style>
            .promo-page {
                --pp-shell: linear-gradient(180deg, rgba(246, 247, 249, 0.96) 0%, rgba(236, 239, 243, 1) 100%);
                --pp-surface: rgba(255, 255, 255, 0.92);
                --pp-border: rgba(17, 24, 39, 0.08);
                --pp-text: #111827;
                --pp-muted: rgba(17, 24, 39, 0.68);
                --pp-shadow: 0 18px 40px rgba(17, 24, 39, 0.07);
                --pp-accent: var(--accent-color, #3b8ff9);
                --pp-accent-soft: color-mix(in srgb, var(--pp-accent), transparent 88%);
                background: radial-gradient(circle at top left, color-mix(in srgb, var(--pp-accent), transparent 88%), transparent 28%), var(--pp-shell);
                position: relative;
                overflow: hidden;
                padding: 40px 0 20px;
            }

            body[data-theme="dark"] .promo-page {
                --pp-shell: linear-gradient(180deg, #0d1117 0%, #111827 100%);
                --pp-surface: rgba(17, 24, 39, 0.92);
                --pp-border: rgba(148, 163, 184, 0.18);
                --pp-text: #edf2f7;
                --pp-muted: rgba(226, 232, 240, 0.72);
                --pp-shadow: 0 24px 44px rgba(2, 6, 23, 0.4);
            }

            .promo-page-hero {
                position: relative;
                z-index: 1;
                padding: 28px 0 10px;
            }

            .promo-page-hero-card {
                background: var(--pp-surface);
                border: 1px solid var(--pp-border);
                border-radius: 28px;
                padding: 36px 32px;
                box-shadow: var(--pp-shadow);
                height: 100%;
            }

            .promo-page-hero-card .eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                font-size: 12px;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                color: var(--pp-accent);
                margin-bottom: 14px;
            }

            .promo-page-hero-card h1 {
                font-family: var(--heading-font);
                font-size: clamp(1.9rem, 3.4vw, 2.8rem);
                line-height: 1.15;
                color: var(--pp-text);
                margin-bottom: 14px;
            }

            .promo-page-hero-card h1 span {
                color: var(--pp-accent);
            }

            .promo-page-hero-card p {
                color: var(--pp-muted);
                font-size: 1rem;
                line-height: 1.7;
                max-width: 520px;
                margin-bottom: 22px;
            }

            .promo-page-stats {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
            }

            .promo-page-stats .stat {
                background: var(--pp-accent-soft);
                border-radius: 14px;
                padding: 12px 16px;
                min-width: 120px;
            }

            .promo-page-stats .stat strong {
                display: block;
                font-size: 1.35rem;
                color: var(--pp-text);
                font-family: var(--heading-font);
                line-height: 1;
                margin-bottom: 4px;
            }

            .promo-page-stats .stat span {
                font-size: 12px;
                font-weight: 600;
                color: var(--pp-muted);
                letter-spacing: 0.04em;
                text-transform: uppercase;
            }

            .promo-page-visual {
                position: relative;
                border-radius: 28px;
                overflow: hidden;
                min-height: 280px;
                background: color-mix(in srgb, var(--pp-accent), var(--pp-surface) 85%);
                box-shadow: var(--pp-shadow);
                border: 1px solid var(--pp-border);
            }

            .promo-page-visual img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                min-height: 280px;
            }

            .promo-page-visual .badge-float {
                position: absolute;
                top: 18px;
                left: 18px;
                background: rgba(255, 255, 255, 0.92);
                color: #111827;
                font-size: 12px;
                font-weight: 800;
                letter-spacing: 0.06em;
                text-transform: uppercase;
                padding: 8px 14px;
                border-radius: 999px;
                box-shadow: 0 10px 24px rgba(17, 43, 70, 0.1);
            }

            body[data-theme="dark"] .promo-page-visual .badge-float {
                background: rgba(15, 23, 42, 0.9);
                color: #edf2f7;
            }

            .promo-page-grid {
                position: relative;
                z-index: 1;
                padding: 36px 0 50px;
            }

            .promo-page-card {
                background: var(--pp-surface);
                border: 1px solid var(--pp-border);
                border-radius: 22px;
                overflow: hidden;
                height: 100%;
                display: flex;
                flex-direction: column;
                box-shadow: var(--pp-shadow);
                transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
            }

            .promo-page-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 26px 50px rgba(17, 43, 70, 0.12);
            }

            .promo-page-card.is-featured {
                flex-direction: row;
                align-items: stretch;
            }

            .promo-page-card .promo-image {
                position: relative;
                height: 210px;
                overflow: hidden;
                background: color-mix(in srgb, var(--pp-accent), var(--pp-surface) 88%);
            }

            .promo-page-card.is-featured .promo-image {
                flex: 0 0 46%;
                max-width: 46%;
                height: auto;
                min-height: 300px;
            }

            .promo-page-card .promo-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .promo-page-card:hover .promo-image img {
                transform: scale(1.06);
            }

            .promo-page-card .promo-category {
                position: absolute;
                top: 14px;
                left: 14px;
                z-index: 2;
                background: var(--pp-accent);
                color: var(--contrast-color, #12314f);
                font-size: 12px;
                font-weight: 700;
                padding: 7px 12px;
                border-radius: 999px;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                box-shadow: 0 8px 18px color-mix(in srgb, var(--pp-accent), transparent 55%);
            }

            .promo-page-card .promo-category.is-urgent {
                background: #e63946;
                color: #fff;
                animation: promoPulse 1.6s ease-in-out infinite;
            }

            @keyframes promoPulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.72; }
            }

            .promo-page-card .promo-featured-tag {
                position: absolute;
                top: 14px;
                right: 14px;
                z-index: 2;
                background: rgba(255, 255, 255, 0.9);
                color: #111827;
                font-size: 11px;
                font-weight: 700;
                letter-spacing: 0.05em;
                text-transform: uppercase;
                padding: 6px 11px;
                border-radius: 999px;
            }

            body[data-theme="dark"] .promo-page-card .promo-featured-tag {
                background: rgba(15, 23, 42, 0.9);
                color: #edf2f7;
            }

            .promo-page-card .promo-info {
                padding: 22px 22px 20px;
                display: flex;
                flex-direction: column;
                flex: 1;
            }

            .promo-page-card.is-featured .promo-info {
                padding: 32px 28px;
                justify-content: space-between;
            }

            .promo-page-card h3 {
                font-family: var(--heading-font);
                font-size: 1.2rem;
                color: var(--pp-text);
                margin-bottom: 10px;
                line-height: 1.35;
            }

            .promo-page-card.is-featured h3 {
                font-size: 1.55rem;
            }

            .promo-page-card .promo-meta span {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 12.5px;
                font-weight: 600;
                color: var(--pp-accent);
                background: var(--pp-accent-soft);
                padding: 5px 12px;
                border-radius: 999px;
                margin-bottom: 12px;
            }

            .promo-page-card p {
                color: var(--pp-muted);
                font-size: 0.95rem;
                line-height: 1.65;
                margin-bottom: 16px;
            }

            .promo-deadline-bar {
                height: 6px;
                border-radius: 999px;
                background: color-mix(in srgb, var(--pp-accent), transparent 88%);
                overflow: hidden;
                margin-bottom: 6px;
            }

            .promo-deadline-bar span {
                display: block;
                height: 100%;
                border-radius: 999px;
                background: linear-gradient(90deg, var(--pp-accent), color-mix(in srgb, var(--pp-accent), #fff 20%));
            }

            .promo-page-card.is-urgent-card .promo-deadline-bar span {
                background: linear-gradient(90deg, #e63946, #ff7b72);
            }

            .promo-deadline small {
                font-size: 12px;
                font-weight: 600;
                color: var(--pp-muted);
            }

            .promo-page-card .promo-actions {
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
                margin-top: auto;
                padding-top: 8px;
            }

            .promo-page-card .btn-detail {
                border: 1.5px solid color-mix(in srgb, var(--pp-text), transparent 80%);
                color: var(--pp-text);
                background: transparent;
                border-radius: 999px;
                padding: 10px 16px;
                font-size: 13.5px;
                font-weight: 600;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                transition: all 0.25s ease;
            }

            .promo-page-card .btn-detail:hover {
                border-color: var(--pp-accent);
                color: var(--pp-accent);
                background: var(--pp-accent-soft);
            }

            .promo-page-card .btn-wa {
                flex: 1;
                min-width: 130px;
                background: linear-gradient(135deg, var(--pp-accent), color-mix(in srgb, var(--pp-accent), #000 12%));
                color: var(--contrast-color, #12314f);
                border-radius: 999px;
                padding: 10px 16px;
                font-size: 13.5px;
                font-weight: 700;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                transition: transform 0.25s ease, box-shadow 0.25s ease;
            }

            .promo-page-card .btn-wa:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 22px color-mix(in srgb, var(--pp-accent), transparent 55%);
                color: var(--contrast-color, #12314f);
            }

            .promo-page-empty {
                text-align: center;
                padding: 56px 24px;
                background: var(--pp-surface);
                border-radius: 22px;
                border: 1px dashed color-mix(in srgb, var(--pp-accent), transparent 65%);
            }

            .promo-page-empty i {
                font-size: 2rem;
                color: var(--pp-accent);
                margin-bottom: 12px;
                display: block;
            }

            .promo-page-cta {
                position: relative;
                z-index: 1;
                padding: 10px 0 70px;
            }

            .promo-page-cta-inner {
                background: var(--pp-surface);
                border: 1px solid var(--pp-border);
                border-radius: 24px;
                padding: 36px 28px;
                box-shadow: var(--pp-shadow);
            }

            .promo-page-cta-inner h2 {
                font-family: var(--heading-font);
                font-size: clamp(1.4rem, 2.5vw, 1.9rem);
                color: var(--pp-text);
                margin-bottom: 10px;
            }

            .promo-page-cta-inner p {
                color: var(--pp-muted);
                margin-bottom: 0;
            }

            @media (max-width: 991.98px) {
                .promo-page-card.is-featured {
                    flex-direction: column;
                }
                .promo-page-card.is-featured .promo-image {
                    flex: none;
                    max-width: 100%;
                    width: 100%;
                    min-height: 220px;
                    height: 230px;
                }
            }

            @media (max-width: 767.98px) {
                .promo-page-hero-card {
                    padding: 26px 20px;
                }
                .promo-page-card .promo-actions {
                    flex-direction: column;
                }
                .promo-page-card .btn-detail,
                .promo-page-card .btn-wa {
                    width: 100%;
                }
            }
        </style>
    @endpush

    <section class="promo-page section">
        <div class="promo-page-hero">
            <div class="container">
                <div class="row align-items-stretch g-4">
                    <div class="col-lg-7" data-aos="fade-right" data-aos-delay="100">
                        <div class="promo-page-hero-card">
                            <div class="eyebrow"><i class="bi bi-tags-fill"></i> Penawaran terbatas</div>
                            <h1>Promo Spesial <span>{{ config('settings.site_brand') }}</span> untuk Anda.</h1>
                            <p>
                                Cicilan lebih ringan, bonus menarik, dan kesempatan terbatas.
                                Pilih promo yang sesuai, lalu ambil langsung via WhatsApp.
                            </p>
                            <div class="promo-page-stats">
                                <div class="stat">
                                    <strong>{{ $stats['active_count'] }}</strong>
                                    <span>Promo Aktif</span>
                                </div>
                                <div class="stat">
                                    <strong>{{ $stats['urgent_count'] }}</strong>
                                    <span>Segera Berakhir</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5" data-aos="fade-left" data-aos-delay="200">
                        <div class="promo-page-visual">
                            <span class="badge-float">Hot Deals</span>
                            @if ($featuredImage)
                                <img src="{{ $featuredImage }}" alt="Promo {{ config('settings.site_brand') }}">
                            @else
                                <img src="{{ asset('frontend/img/car.png') }}" alt="Promo">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="promo-page-grid" id="promo-grid">
            <div class="container">
                @if ($promoCards->isNotEmpty())
                    <div class="row g-4">
                        @foreach ($promoCards as $card)
                            <div class="{{ $card->col_class }}" data-aos="fade-up" data-aos-delay="{{ $card->aos_delay }}">
                                <article class="{{ $card->card_class }}">
                                    <div class="promo-image">
                                        <a href="{{ $card->detail_url }}">
                                            <img src="{{ $card->image_url }}" alt="{{ $card->title }}" loading="lazy">
                                        </a>
                                        <div class="promo-category {{ $card->badge_class }}">
                                            <i class="bi {{ $card->badge_icon }}"></i>
                                            {{ $card->badge_label }}
                                        </div>
                                        @if ($card->is_featured)
                                            <span class="promo-featured-tag"><i class="bi bi-stars"></i> Utama</span>
                                        @endif
                                    </div>
                                    <div class="promo-info">
                                        <div>
                                            <h3><a href="{{ $card->detail_url }}" class="text-decoration-none" style="color: inherit;">{{ $card->title }}</a></h3>
                                            <div class="promo-meta">
                                                <span><i class="bi bi-calendar3"></i> Sampai {{ $card->effective_label }}</span>
                                            </div>
                                            <p>{{ $card->excerpt }}</p>
                                            @if ($card->show_progress)
                                                <div class="promo-deadline mb-3">
                                                    <div class="promo-deadline-bar"><span style="width: {{ $card->progress }}%"></span></div>
                                                    <small>{{ $card->deadline_text }}</small>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="promo-actions">
                                            <a href="{{ $card->detail_url }}" class="btn-detail">Lihat Detail</a>
                                            <a href="{{ $card->wa_link }}" target="_blank" rel="noopener" class="btn-wa">
                                                <i class="bi bi-whatsapp"></i> Ambil Promo
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="promo-page-empty" data-aos="fade-up">
                        <i class="bi bi-tags"></i>
                        <h3>Belum ada promo aktif</h3>
                        <p class="mb-3">Pantau terus halaman ini — penawaran terbaik segera hadir.</p>
                        <a href="{{ route('product.index') }}" class="btn btn-primary">Lihat Produk</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="promo-page-cta">
            <div class="container">
                <div class="promo-page-cta-inner" data-aos="fade-up">
                    <div class="row align-items-center g-3">
                        <div class="col-lg-8">
                            <h2>Butuh bantuan pilih promo yang tepat?</h2>
                            <p>Kami bantu cocokkan promo dengan budget dan kebutuhan mobil Anda.</p>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#consultationModal" class="btn btn-primary btn-lg">Konsultasi Gratis</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
