@extends('frontend.layouts.app')

@section('content')
    <div class="product-index-page">
        <section class="section">
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
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#consultationModal" class="btn btn-outline-primary btn-lg">Konsultasi Gratis</a>
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
                                    {!! $product->tagline !!}
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
                                @if (filter_var(config('settings.frontend_page_testdrive', '1'), FILTER_VALIDATE_BOOLEAN))
                                    <a href="{{ route('testdrive.show') }}" class="btn btn-outline-primary btn-lg">Booking Test Drive</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
