@extends('frontend.layouts.app')

@section('content')
    @push('css')
        <style>
            .product-index-page {
                --product-shell-bg: linear-gradient(180deg, rgba(246, 247, 249, 0.96) 0%, rgba(236, 239, 243, 1) 100%);
                --product-surface: rgba(255, 255, 255, 0.82);
                --product-surface-strong: rgba(255, 255, 255, 0.96);
                --product-surface-soft: rgba(245, 247, 249, 0.9);
                --product-border: rgba(17, 24, 39, 0.08);
                --product-text: #111827;
                --product-text-soft: rgba(17, 24, 39, 0.72);
                --product-chip-bg: rgba(255, 255, 255, 0.7);
                --product-orb: rgba(17, 24, 39, 0.05);
                --product-card-shadow: 0 18px 35px rgba(17, 24, 39, 0.06);
                --product-accent: #1f2937;
                --product-accent-soft: rgba(31, 41, 55, 0.08);
                background: radial-gradient(circle at top left, rgba(17, 24, 39, 0.08), transparent 24%), var(--product-shell-bg);
                position: relative;
                overflow: hidden;
            }

            body[data-theme="dark"] .product-index-page {
                --product-shell-bg: linear-gradient(180deg, #0d1117 0%, #111827 100%);
                --product-surface: rgba(17, 24, 39, 0.82);
                --product-surface-strong: rgba(17, 24, 39, 0.96);
                --product-surface-soft: rgba(15, 23, 42, 0.94);
                --product-border: rgba(148, 163, 184, 0.18);
                --product-text: #edf2f7;
                --product-text-soft: rgba(226, 232, 240, 0.74);
                --product-chip-bg: rgba(17, 24, 39, 0.76);
                --product-orb: rgba(148, 163, 184, 0.08);
                --product-card-shadow: 0 24px 44px rgba(2, 6, 23, 0.38);
                --product-accent: #e5e7eb;
                --product-accent-soft: rgba(229, 231, 235, 0.12);
            }

            .product-index-page::before,
            .product-index-page::after {
                content: "";
                position: absolute;
                width: 420px;
                height: 420px;
                border-radius: 50%;
                background: var(--product-orb);
                filter: blur(8px);
                animation: floatOrb 14s ease-in-out infinite alternate;
            }

            .product-index-page::before {
                top: -110px;
                right: -40px;
            }

            .product-index-page::after {
                bottom: -120px;
                left: -40px;
                animation-delay: 1.5s;
            }

            @keyframes floatOrb {
                0% {
                    transform: translateY(0px) scale(1);
                }

                100% {
                    transform: translateY(24px) scale(1.08);
                }
            }

            .product-hero-wrap {
                position: relative;
                z-index: 1;
                padding-top: 80px;
                padding-bottom: 40px;
            }

            .product-hero-card {
                background: var(--product-surface);
                border: 1px solid var(--product-border);
                border-radius: 28px;
                box-shadow: var(--product-card-shadow);
                backdrop-filter: blur(10px);
                padding: 42px 36px;
                position: relative;
                overflow: hidden;
            }

            .product-hero-card::before {
                content: "";
                position: absolute;
                inset: 0;
                background: linear-gradient(135deg, var(--product-accent-soft), rgba(255, 255, 255, 0));
                pointer-events: none;
            }

            .eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 8px 16px;
                border-radius: 999px;
                background: var(--product-accent-soft);
                border: 1px solid rgba(17, 24, 39, 0.08);
                color: var(--product-accent);
                font-size: 0.78rem;
                font-weight: 700;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                margin-bottom: 18px;
            }

            body[data-theme="dark"] .eyebrow {
                border-color: rgba(229, 231, 235, 0.12);
            }

            .product-hero-card h1 {
                color: var(--product-text);
                font-size: clamp(2.2rem, 4vw, 4rem);
                line-height: 1.1;
                margin: 0 0 18px;
                font-weight: 800;
            }

            .product-hero-card h1 .highlight {
                color: var(--product-accent);
            }

            .product-hero-card p {
                color: var(--product-text-soft);
                font-size: 1.05rem;
                line-height: 1.8;
                max-width: 620px;
            }

            .product-hero-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 14px;
                margin-top: 28px;
            }

            .product-hero-badges {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                margin-top: 30px;
            }

            .product-hero-badges span {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                border-radius: 999px;
                padding: 9px 14px;
                background: var(--product-chip-bg);
                color: var(--product-text);
                font-size: 0.85rem;
                font-weight: 600;
                border: 1px solid var(--product-border);
            }

            .product-hero-visual {
                position: relative;
                min-height: 420px;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 24px 0;
            }

            .product-hero-visual .visual-frame {
                position: relative;
                width: 100%;
                max-width: 470px;
                aspect-ratio: 1.15;
                border-radius: 32px;
                background: linear-gradient(145deg, rgba(59, 143, 249, 0.08), var(--product-surface-soft));
                border: 1px solid var(--product-border);
                box-shadow: var(--product-card-shadow);
                overflow: hidden;
                transform: perspective(1000px) rotateY(-10deg);
                animation: vehicleFloat 6s ease-in-out infinite alternate;
            }

            @keyframes vehicleFloat {
                0% {
                    transform: perspective(1000px) rotateY(-10deg) translateY(0);
                }

                100% {
                    transform: perspective(1000px) rotateY(-4deg) translateY(-12px);
                }
            }

            .visual-badge {
                position: absolute;
                top: 28px;
                left: 28px;
                z-index: 2;
                background: rgba(255, 255, 255, 0.92);
                color: var(--heading-color);
                padding: 10px 16px;
                border-radius: 14px;
                font-size: 0.8rem;
                font-weight: 800;
                box-shadow: 0 10px 24px rgba(17, 43, 70, 0.08);
            }

            body[data-theme="dark"] .visual-badge {
                background: rgba(15, 23, 42, 0.9);
                color: #edf6ff;
                border: 1px solid rgba(148, 163, 184, 0.2);
            }

            .visual-badge span {
                color: var(--product-accent);
            }

            .visual-image {
                position: absolute;
                inset: 0;
                display: flex;
                align-items: end;
                justify-content: center;
                padding: 40px 20px 0;
            }

            .visual-image img {
                width: 100%;
                max-width: 420px;
                object-fit: contain;
                filter: drop-shadow(0 26px 28px rgba(17, 43, 70, 0.12));
                animation: carGlow 3.5s ease-in-out infinite alternate;
            }

            @keyframes carGlow {
                0% {
                    filter: drop-shadow(0 26px 28px rgba(17, 43, 70, 0.12));
                }

                100% {
                    filter: drop-shadow(0 32px 42px rgba(59, 143, 249, 0.18));
                }
            }

            .promo-dock {
                position: absolute;
                right: 18px;
                bottom: 18px;
                z-index: 3;
                background: rgba(15, 23, 42, 0.9);
                border: 1px solid rgba(148, 163, 184, 0.18);
                border-radius: 20px;
                padding: 18px 20px;
                min-width: 185px;
                box-shadow: var(--product-card-shadow);
            }

            .promo-dock strong {
                display: block;
                color: #fff;
                font-size: 1.55rem;
                margin-bottom: 4px;
            }

            .promo-dock small {
                color: rgba(255, 255, 255, 0.75);
                font-size: 0.78rem;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .promo-strip {
                position: relative;
                z-index: 1;
                padding-bottom: 10px;
            }

            .promo-strip-inner {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 16px;
            }

            .promo-chip {
                background: var(--product-surface);
                border: 1px solid var(--product-border);
                border-radius: 18px;
                padding: 18px 20px;
                display: flex;
                align-items: center;
                gap: 12px;
                color: var(--product-text);
                box-shadow: var(--product-card-shadow);
            }

            .promo-chip i {
                width: 42px;
                height: 42px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                background: linear-gradient(135deg, var(--product-accent-soft), rgba(255, 255, 255, 0.06));
                color: var(--product-accent);
                font-size: 1.2rem;
            }

            .promo-chip strong {
                display: block;
                color: var(--product-text);
                font-size: 1rem;
                margin-bottom: 2px;
            }

            .promo-chip span {
                display: block;
                color: var(--product-text-soft);
                font-size: 0.72rem;
                letter-spacing: 0.04em;
            }

            .product-benefits-section {
                position: relative;
                z-index: 1;
                padding: 36px 0 20px;
            }

            .benefit-card {
                background: var(--product-surface);
                border: 1px solid var(--product-border);
                border-radius: 22px;
                padding: 28px 22px;
                height: 100%;
                box-shadow: var(--product-card-shadow);
                transition: transform 0.35s ease, border-color 0.35s ease;
            }

            .benefit-card:hover {
                transform: translateY(-8px);
                border-color: rgba(17, 24, 39, 0.18);
            }

            .benefit-icon {
                width: 60px;
                height: 60px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 18px;
                background: linear-gradient(135deg, var(--product-accent-soft), rgba(255, 255, 255, 0.06));
                color: var(--product-accent);
                font-size: 1.7rem;
                margin-bottom: 16px;
            }

            .benefit-card h4 {
                color: var(--product-text);
                margin-bottom: 10px;
            }

            .benefit-card p {
                color: var(--product-text-soft);
                margin: 0;
                line-height: 1.7;
            }

            .product-grid-section {
                position: relative;
                z-index: 1;
                padding-top: 70px;
                padding-bottom: 30px;
            }

            .section-title {
                margin-bottom: 28px;
            }

            .section-title h2 {
                color: var(--product-text);
                font-size: clamp(2rem, 3vw, 3rem);
                margin-bottom: 10px;
            }

            .section-title p {
                color: var(--product-text-soft);
                max-width: 620px;
                margin: 0 auto;
            }

            .product-card {
                background: linear-gradient(180deg, var(--product-surface-strong), var(--product-surface-soft));
                border-radius: 26px;
                overflow: hidden;
                border: 1px solid var(--product-border);
                box-shadow: var(--product-card-shadow);
                position: relative;
                height: 100%;
                transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
                animation: fadeUp 0.7s ease both;
            }

            .product-card:hover {
                transform: translateY(-10px) scale(1.01);
                border-color: rgba(17, 24, 39, 0.18);
                box-shadow: 0 24px 50px rgba(17, 24, 39, 0.08);
            }

            @keyframes fadeUp {
                from {
                    opacity: 0;
                    transform: translateY(25px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .product-card-head {
                display: flex;
                align-items: center;
                justify-content: space-between;
                position: absolute;
                inset: 18px 18px auto 18px;
                z-index: 2;
            }

            .product-card-tag,
            .product-card-badge {
                border-radius: 999px;
                padding: 7px 12px;
                font-size: 0.72rem;
                font-weight: 700;
                letter-spacing: 0.06em;
                text-transform: uppercase;
            }

            .product-card-tag {
                background: rgba(17, 43, 70, 0.05);
                color: var(--product-text);
                border: 1px solid rgba(17, 43, 70, 0.08);
            }

            body[data-theme="dark"] .product-card-tag {
                background: rgba(148, 163, 184, 0.08);
                color: #edf6ff;
                border-color: rgba(148, 163, 184, 0.18);
            }

            .product-card-badge {
                background: rgba(255, 188, 92, 0.15);
                color: #7c5605;
                border: 1px solid rgba(255, 188, 92, 0.35);
            }

            .product-card-image {
                position: relative;
                height: 250px;
                background: linear-gradient(145deg, var(--product-accent-soft), rgba(17, 43, 70, 0.04));
                padding-top: 30px;
                overflow: hidden;
            }

            body[data-theme="dark"] .product-card-image {
                background: linear-gradient(145deg, rgba(30, 41, 59, 0.96), rgba(15, 23, 42, 0.92));
            }

            .product-card-image::after {
                content: "";
                position: absolute;
                inset: auto 0 0 0;
                height: 50%;
                background: linear-gradient(180deg, rgba(255, 255, 255, 0), rgba(17, 43, 70, 0.04));
            }

            .product-card-image img {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.5s ease;
            }

            .product-card:hover .product-card-image img {
                transform: scale(1.07);
            }

            .product-card-body {
                padding: 26px 22px 22px;
            }

            .product-mini-label {
                display: inline-block;
                margin-bottom: 10px;
                color: var(--product-accent);
                font-size: 0.72rem;
                font-weight: 700;
                letter-spacing: 0.12em;
                text-transform: uppercase;
            }

            .product-card-body h3 {
                color: var(--product-text);
                font-size: clamp(1.35rem, 2vw, 1.7rem);
                margin-bottom: 12px;
                min-height: 52px;
            }

            .product-card-body p {
                color: var(--product-text-soft);
                line-height: 1.7;
                margin-bottom: 18px;
                min-height: 78px;
            }

            .product-meta {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                color: var(--product-text-soft);
                margin-bottom: 20px;
                font-size: 0.82rem;
                padding-top: 10px;
                border-top: 1px solid var(--product-border);
            }

            .product-meta span {
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }

            .product-price {
                display: flex;
                align-items: end;
                justify-content: space-between;
                gap: 12px;
                margin-top: 14px;
            }

            .product-price small {
                color: rgba(17, 43, 70, 0.64);
                display: block;
                margin-bottom: 6px;
            }

            body[data-theme="dark"] .product-price small {
                color: rgba(226, 232, 240, 0.7);
            }

            .product-price strong {
                color: var(--product-text);
                font-size: 1.25rem;
            }

            .product-price .btn {
                border-radius: 12px;
                padding: 0.8rem 1.1rem;
                font-weight: 700;
            }

            .product-cta-panel {
                position: relative;
                z-index: 1;
                padding: 40px 0 80px;
            }

            .cta-panel-inner {
                background: linear-gradient(135deg, var(--product-accent-soft), var(--product-surface-strong));
                border: 1px solid var(--product-border);
                border-radius: 28px;
                padding: 34px 30px;
                overflow: hidden;
                position: relative;
            }

            .cta-panel-inner::before {
                content: "";
                position: absolute;
                right: -30px;
                top: -30px;
                width: 180px;
                height: 180px;
                border-radius: 50%;
                background: rgba(17, 24, 39, 0.04);
            }

            .cta-panel-inner h2 {
                color: var(--product-text);
                font-size: clamp(1.8rem, 3vw, 2.8rem);
                margin-bottom: 12px;
            }

            .cta-panel-inner p {
                color: var(--product-text-soft);
                margin: 0;
                line-height: 1.8;
            }

            .cta-actions {
                display: flex;
                flex-wrap: wrap;
                justify-content: flex-end;
                gap: 12px;
                position: relative;
                z-index: 1;
            }

            @media (max-width: 991.98px) {
                .promo-strip-inner {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .cta-actions {
                    justify-content: flex-start;
                    margin-top: 22px;
                }
            }

            @media (max-width: 575.98px) {

                .product-hero-card,
                .cta-panel-inner {
                    padding-left: 20px;
                    padding-right: 20px;
                }

                .promo-strip-inner {
                    grid-template-columns: 1fr;
                }

                .product-hero-visual {
                    min-height: 330px;
                }

                .product-card-image {
                    height: 210px;
                }
            }

            body[data-theme="dark"] .product-index-page {
                background:
                    radial-gradient(circle at top left, rgba(255, 255, 255, 0.04), transparent 24%),
                    linear-gradient(180deg, #1c1c1c 0%, #131313 100%);
            }

            body[data-theme="dark"] .product-index-page::before,
            body[data-theme="dark"] .product-index-page::after {
                background: rgba(255, 255, 255, 0.04);
            }

            body[data-theme="dark"] .product-hero-card,
            body[data-theme="dark"] .promo-chip,
            body[data-theme="dark"] .benefit-card,
            body[data-theme="dark"] .product-card,
            body[data-theme="dark"] .cta-panel-inner {
                background: rgba(34, 34, 34, 0.9);
                border-color: rgba(255, 255, 255, 0.08);
                box-shadow: 0 18px 40px rgba(0, 0, 0, 0.2);
            }

            body[data-theme="dark"] .product-hero-card::before {
                background: linear-gradient(135deg, rgba(236, 236, 236, 0.05), rgba(255, 255, 255, 0));
            }

            body[data-theme="dark"] .eyebrow {
                background: rgba(236, 236, 236, 0.08);
                border-color: rgba(236, 236, 236, 0.12);
                color: #f3f3f3;
            }

            body[data-theme="dark"] .product-hero-card h1,
            body[data-theme="dark"] .product-hero-card p,
            body[data-theme="dark"] .promo-chip strong,
            body[data-theme="dark"] .promo-chip span,
            body[data-theme="dark"] .benefit-card h4,
            body[data-theme="dark"] .benefit-card p,
            body[data-theme="dark"] .section-title h2,
            body[data-theme="dark"] .section-title p,
            body[data-theme="dark"] .product-card-body h3,
            body[data-theme="dark"] .product-card-body p,
            body[data-theme="dark"] .product-meta,
            body[data-theme="dark"] .product-price small,
            body[data-theme="dark"] .product-price strong,
            body[data-theme="dark"] .cta-panel-inner h2,
            body[data-theme="dark"] .cta-panel-inner p {
                color: #f2f2f2;
            }

            body[data-theme="dark"] .product-hero-card h1 .highlight,
            body[data-theme="dark"] .promo-chip i,
            body[data-theme="dark"] .benefit-icon,
            body[data-theme="dark"] .product-mini-label {
                color: #ececec;
            }

            body[data-theme="dark"] .product-hero-badges span {
                background: rgba(255, 255, 255, 0.04);
                border-color: rgba(255, 255, 255, 0.08);
                color: #f3f3f3;
            }

            body[data-theme="dark"] .visual-frame {
                background: linear-gradient(145deg, rgba(255, 255, 255, 0.04), rgba(31, 31, 31, 0.82));
                border-color: rgba(255, 255, 255, 0.08);
                box-shadow: 0 18px 48px rgba(0, 0, 0, 0.18);
            }

            body[data-theme="dark"] .visual-badge {
                background: rgba(22, 22, 22, 0.92);
                color: #f5f5f5;
                box-shadow: 0 10px 24px rgba(0, 0, 0, 0.18);
            }

            body[data-theme="dark"] .promo-chip i,
            body[data-theme="dark"] .benefit-icon {
                background: rgba(255, 255, 255, 0.06);
            }

            body[data-theme="dark"] .product-card-tag {
                background: rgba(255, 255, 255, 0.04);
                color: #f3f3f3;
                border-color: rgba(255, 255, 255, 0.08);
            }

            body[data-theme="dark"] .product-card-badge {
                background: rgba(255, 213, 128, 0.12);
                color: #f4dba2;
                border-color: rgba(255, 213, 128, 0.24);
            }

            body[data-theme="dark"] .product-card-image {
                background: linear-gradient(145deg, rgba(255, 255, 255, 0.04), rgba(20, 20, 20, 0.7));
            }

            body[data-theme="dark"] .product-card-image::after {
                background: linear-gradient(180deg, rgba(255, 255, 255, 0), rgba(17, 17, 17, 0.18));
            }

            body[data-theme="dark"] .product-meta,
            body[data-theme="dark"] .product-card-body p,
            body[data-theme="dark"] .product-price small,
            body[data-theme="dark"] .section-title p,
            body[data-theme="dark"] .cta-panel-inner p {
                color: rgba(255, 255, 255, 0.72);
            }

            body[data-theme="dark"] .product-card {
                background: linear-gradient(180deg, rgba(32, 32, 32, 0.96), rgba(20, 20, 20, 0.96));
                border-color: rgba(255, 255, 255, 0.08);
            }

            body[data-theme="dark"] .cta-panel-inner::before {
                background: rgba(255, 255, 255, 0.04);
            }
        </style>
    @endpush

    <section class="product-index-page section">
        <div class="product-hero-wrap">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7" data-aos="fade-right" data-aos-delay="100">
                        <div class="product-hero-card">
                            <div class="eyebrow"><i class="bi bi-stars"></i> Koleksi mobil pilihan</div>
                            <h1>Drive Your <span class="highlight">Future</span> with Confidence.</h1>
                            <p>
                                Temukan kendaraan yang tepat untuk kebutuhan harian, keluarga, hingga perjalanan bisnis Anda.
                                Setiap model kami hadir dengan performa handal, desain modern, dan harga yang kompetitif.
                            </p>
                            <div class="product-hero-actions">
                                <a href="#product-grid" class="btn btn-primary btn-lg">Lihat Semua Produk</a>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#consultationModal" class="btn btn-outline btn-lg">Konsultasi Gratis</a>
                            </div>
                            <div class="product-hero-badges">
                                <span><i class="bi bi-shield-check"></i> Garansi Terpercaya</span>
                                <span><i class="bi bi-cash-stack"></i> DP Ringan</span>
                                <span><i class="bi bi-headset"></i> Support 24/7</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5" data-aos="fade-left" data-aos-delay="200">
                        <div class="product-hero-visual">
                            <div class="visual-frame">
                                <div class="visual-badge"><span>Promo</span> Bulan Ini</div>
                                <div class="visual-image">
                                    @if ($products->isNotEmpty() && $products->first()->image_url)
                                        <img src="{{ $products->first()->image_url }}" alt="{{ $products->first()->name }}">
                                    @else
                                        <img src="{{ asset('frontend/img/car.png') }}" alt="Product Car">
                                    @endif
                                </div>
                                <div class="promo-dock">
                                    <strong>0%</strong>
                                    <small>Angsuran Awal</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="promo-strip">
            <div class="container">
                <div class="promo-strip-inner">
                    <div class="promo-chip" data-aos="fade-up" data-aos-delay="100">
                        <i class="bi bi-percent"></i>
                        <div>
                            <strong>Diskon Spesial</strong>
                            <span>Harga lebih hemat</span>
                        </div>
                    </div>
                    <div class="promo-chip" data-aos="fade-up" data-aos-delay="150">
                        <i class="bi bi-wallet2"></i>
                        <div>
                            <strong>Cicilan Ringan</strong>
                            <span>Mulai dari 1 jutaan</span>
                        </div>
                    </div>
                    <div class="promo-chip" data-aos="fade-up" data-aos-delay="200">
                        <i class="bi bi-award"></i>
                        <div>
                            <strong>Kualitas Teruji</strong>
                            <span>Standar showroom</span>
                        </div>
                    </div>
                    <div class="promo-chip" data-aos="fade-up" data-aos-delay="250">
                        <i class="bi bi-people"></i>
                        <div>
                            <strong>Tim Profesional</strong>
                            <span>Siap bantu pilih mobil</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-benefits-section">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="benefit-card">
                            <div class="benefit-icon"><i class="bi bi-speedometer2"></i></div>
                            <h4>Performa Handal</h4>
                            <p>Mesin responsif, efisiensi bahan bakar, dan pengalaman berkendara nyaman di setiap jalan.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="150">
                        <div class="benefit-card">
                            <div class="benefit-icon"><i class="bi bi-shield-fill-check"></i></div>
                            <h4>Keamanan Maksimal</h4>
                            <p>Fitur keselamatan modern hadir untuk menjaga perjalanan Anda tetap aman dan tenang.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="benefit-card">
                            <div class="benefit-icon"><i class="bi bi-person-hearts"></i></div>
                            <h4>Pelayanan Personal</h4>
                            <p>Konsultasi yang ramah dan rekomendasi sesuai kebutuhan, gaya hidup, serta budget Anda.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="250">
                        <div class="benefit-card">
                            <div class="benefit-icon"><i class="bi bi-tools"></i></div>
                            <h4>After Sales Terpercaya</h4>
                            <p>Didukung layanan purna jual yang siap membantu sejak pembelian hingga perawatan rutin.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="product-grid" class="product-grid-section section">
        <div class="container section-title" data-aos="fade-up" data-builder="section-title">
            <h2>Semua Produk Kami</h2>
            <p>Pilih mobil yang paling cocok dengan kebutuhan Anda, dari model keluarga hingga kendaraan premium dan urban.</p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row g-4">
                @foreach ($products as $product)
                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="{{ 100 + $loop->index * 80 }}">
                        <article class="product-card">
                            <div class="product-card-head">
                                <span class="product-card-tag">{{ $product->product_category->category ?? 'Mobil' }}</span>
                                <span class="product-card-badge">Promo</span>
                            </div>
                            <div class="product-card-image">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                            </div>
                            <div class="product-card-body">
                                <span class="product-mini-label">{{ $product->hero_name ?? 'New Arrival' }}</span>
                                <h3>{{ $product->name }}</h3>
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($product->desc ?? ''), 110) }}</p>
                                <div class="product-meta">
                                    <span><i class="bi bi-speedometer2"></i> {{ $product->product_type->count() ?? 0 }} Varian</span>
                                    <span><i class="bi bi-coin"></i> Cashback</span>
                                </div>
                                <div class="product-price">
                                    <div>
                                        <small>Mulai dari</small>
                                        <strong>{{ $product->min_price }}</strong>
                                    </div>
                                    <a href="{{ route('product.detail', $product->slug) }}" class="btn btn-primary">Detail</a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="product-cta-panel">
        <div class="container">
            <div class="cta-panel-inner" data-aos="fade-up">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <div class="eyebrow"><i class="bi bi-chat-square-dots"></i> Butuh rekomendasi?</div>
                        <h2>Pilih mobil terbaik sesuai kebutuhan dan budget Anda.</h2>
                        <p>
                            Tim kami siap membantu Anda membandingkan model, menyesuaikan angsuran, dan memastikan pilihan yang paling tepat.
                        </p>
                    </div>
                    <div class="col-lg-5">
                        <div class="cta-actions">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#consultationModal" class="btn btn-primary btn-lg">Konsultasi Gratis</a>
                            <a href="{{ route('testdrive.show') }}" class="btn btn-outline btn-lg">Booking Test Drive</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
