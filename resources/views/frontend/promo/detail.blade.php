@extends('frontend.layouts.app')

@section('content')


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
                                        <span style="width: {{ $card->progress }}%; display:block; height:6px; border-radius:999px; background: var(--accent-color);"></span>
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
                            @if (filter_var(config('settings.frontend_page_testdrive', '1'), FILTER_VALIDATE_BOOLEAN))
                                <a href="{{ route('testdrive.show') }}" class="btn-outline-soft">
                                    <i class="bi bi-steering-wheel"></i> Booking Test Drive
                                </a>
                            @endif
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
