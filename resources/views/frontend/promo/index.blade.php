@extends('frontend.layouts.app')

@section('content')


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
                        @if (filter_var(config('settings.frontend_page_products', '1'), FILTER_VALIDATE_BOOLEAN))
                            <a href="{{ route('product.index') }}" class="btn btn-primary">Lihat Produk</a>
                        @endif
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
