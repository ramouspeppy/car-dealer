<!DOCTYPE html>
<html lang="id" class="landing-v3-page">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seo['title'] }}</title>
    <meta name="description" content="{{ $seo['description'] }}">
    <meta name="keywords" content="{{ $seo['keywords'] }}">
    <meta name="robots" content="{{ $seo['robots'] }}">
    <link rel="canonical" href="{{ $seo['canonical_url'] }}">

    <meta property="og:title" content="{{ $seo['title'] }}">
    <meta property="og:description" content="{{ $seo['description'] }}">
    <meta property="og:site_name" content="{{ $seo['site_name'] }}">
    <meta property="og:locale" content="{{ $seo['locale'] }}">
    <meta property="og:image" content="{{ $seo['image'] }}">
    <meta property="og:image:alt" content="{{ $seo['title'] }}">
    <meta property="og:type" content="{{ $seo['type'] }}">
    <meta property="og:url" content="{{ $seo['canonical_url'] }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo['title'] }}">
    <meta name="twitter:description" content="{{ $seo['description'] }}">
    <meta name="twitter:image" content="{{ $seo['image'] }}">

    <link href="{{ $seo['favicon'] }}" rel="icon">
    <link href="{{ $seo['favicon'] }}" rel="shortcut icon">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Chewy&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ mix('frontend/css/app.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

    {!! $landingPage->tracking_head_script !!}

    @include('frontend.layouts._tracking')

</head>

<body class="landing-v3-page">

    {{-- ============ TOPBAR ============ --}}
    <div class="p-topbar">
        <div class="p-topbar-inner">
            <a href="#" class="p-brand">
                @if ($seo['logo'] !== '')
                    <img src="{{ $seo['logo'] }}" alt="{{ $profile->name ?? $seo['site_name'] }}">
                @else
                    <svg viewBox="0 0 48 48" fill="none" stroke="#1f1b3a" stroke-width="3" stroke-linejoin="round" stroke-linecap="round"><path d="M6 30l4-11c.6-1.7 2.2-2.8 4-2.8h20c1.8 0 3.4 1.1 4 2.8l4 11" fill="#ffd23f"/><rect x="4" y="29" width="40" height="9" rx="4" fill="#ee4266"/><circle cx="14" cy="39" r="4.5" fill="#fff"/><circle cx="34" cy="39" r="4.5" fill="#fff"/></svg>
                @endif
                <span class="p-brand-copy">
                    <span>{{ $navData['name'] }}</span>
                    <span class="p-brand-site-name">{{ $navData['site_name'] }}</span>
                </span>
            </a>
            <div class="p-topbar-actions">
                <div class="p-topbar-socials" aria-label="Media sosial">
                    @foreach ($navData['social_links'] as $social)
                        <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social['name'] }}"><i class="bi {{ $social['icon'] }}" aria-hidden="true"></i></a>
                    @endforeach
                </div>
                <a href="{{ $profile->wa_url }}" target="_blank" rel="noopener noreferrer" class="p-btn p-btn-white"><i class="bi bi-whatsapp"></i> Chat</a>
            </div>
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

                @if($heroImage)
                <div class="p-hero-visual p-reveal">
                    <img src="{{ $heroImage }}" alt="{{ $landingPage->hero_image_url ? $landingPage->headline : ($products->first()->name ?? $landingPage->headline) }}" loading="eager">
                </div>
                @else
                <div class="p-hero-visual p-hero-visual-empty p-reveal" aria-hidden="true">
                    <i class="bi bi-car-front-fill"></i>
                    <span>Mobil impianmu menanti!</span>
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

    @if($profile && ($profile->name || $profile->image_url || $profile->bio || $profile->job_title))
    <section class="p-profile-section">
        <div class="p-wrap">
            <div class="p-profile-card {{ $profile->image_url ? '' : 'p-profile-card-no-photo' }} p-reveal">
                @if($profile->image_url)
                    <div class="p-profile-photo"><img src="{{ $profile->image_url }}" alt="{{ $profile->name ?: 'Profil sales' }}" loading="lazy"></div>
                @endif
                <div class="p-profile-copy">
                    <span class="p-profile-kicker">Teman perjalanan Anda</span>
                    <h2>{{ $profile->name }}</h2>
                    @if($profile->job_title)<p class="p-profile-role">{{ $profile->job_title }}</p>@endif
                    @if($profile->bio)
                        <div class="p-profile-bio">{!! $profile->bio !!}</div>
                    @else
                        <p class="p-profile-bio">Saya siap menemani Anda menemukan mobil yang pas, dengan proses yang jelas dan nyaman.</p>
                    @endif
                    <a href="{{ $profile->wa_url }}" target="_blank" rel="noopener" class="p-profile-cta"><i class="bi bi-whatsapp"></i> Chat Saya</a>
                </div>
            </div>
        </div>
    </section>
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
                    <div class="p-card-product-img">
                        <span class="p-card-product-badge p-card-product-badge-left"><i class="bi bi-car-front-fill"></i> {{ $product->product_category->category ?? 'Mobil' }}</span>
                        <span class="p-card-product-badge p-card-product-badge-right {{ $product->disc > 0 ? 'is-promo' : '' }}"><i class="bi {{ $product->disc > 0 ? 'bi-tag-fill' : 'bi-stars' }}"></i> {{ $product->disc > 0 ? 'Hemat ' . $product->discount_short : 'Unit Pilihan' }}</span>
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                    </div>
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
            <div class="p-carousel-hint"><i class="bi bi-arrow-left-right"></i> Mouse: klik dan tahan lalu tarik &bull; trackpad atau layar sentuh: geser</div>
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
                    <a href="{{ $gallery->cover_url }}" class="p-polaroid glightbox" data-gallery="landing-gallery" data-title="{{ $gallery->title }}" style="transform: rotate({{ $loop->odd ? '-2.5' : '2.5' }}deg);">
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
                @if($delivery->landing_image_url)
                <div class="col-6 col-lg-4 p-reveal">
                    <div class="p-polaroid" style="transform: rotate({{ $loop->odd ? '2' : '-2' }}deg);">
                        <span class="p-polaroid-tape" style="background:rgba(61,220,151,.85);"></span>
                        <a href="{{ $delivery->landing_image_url }}" class="d-block glightbox" data-gallery="landing-deliveries" data-title="Serah terima {{ $delivery->product->name ?? '' }}">
                            <div class="p-polaroid-img"><img src="{{ $delivery->landing_image_url }}" alt="Serah terima {{ $delivery->product->name ?? '' }}" loading="lazy"></div>
                        </a>
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
        <strong>{{ $profile->name ?? $seo['site_name'] }}</strong><br>
        &copy; {{ $seo['year'] }} Semua hak dilindungi.
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
            /* ---------- Mouse drag for the product carousel ---------- */
            const productCarousel = document.querySelector('.p-carousel');
            if (productCarousel) {
                let isDragging = false;
                let wasDragged = false;
                let startX = 0;
                let startScrollLeft = 0;

                function moveCarousel(event) {
                    if (!isDragging) return;

                    const distance = event.clientX - startX;
                    if (Math.abs(distance) > 5) {
                        wasDragged = true;
                        productCarousel.classList.add('is-dragging');
                        event.preventDefault();
                    }
                    if (wasDragged) productCarousel.scrollLeft = startScrollLeft - distance;
                }

                function stopDragging() {
                    if (!isDragging) return;
                    isDragging = false;
                    productCarousel.classList.remove('is-dragging');
                    window.removeEventListener('mousemove', moveCarousel);
                    window.removeEventListener('mouseup', stopDragging);
                    if (wasDragged) {
                        window.setTimeout(function () { wasDragged = false; }, 0);
                    }
                }

                productCarousel.addEventListener('mousedown', function (event) {
                    if (event.button !== 0) return;
                    isDragging = true;
                    wasDragged = false;
                    startX = event.clientX;
                    startScrollLeft = productCarousel.scrollLeft;
                    window.addEventListener('mousemove', moveCarousel);
                    window.addEventListener('mouseup', stopDragging);
                });

                productCarousel.addEventListener('click', function (event) {
                    if (!wasDragged) return;
                    event.preventDefault();
                    event.stopPropagation();
                    wasDragged = false;
                }, true);
            }

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
