@extends('frontend.'.frontend_theme().'.layouts.app')

@section('content')
@push('css')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

@endpush
<div class="page-title dark-background" data-builder="page-title">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0" >Portfolio Details</h1>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="index.html">Home</a></li>
                <li class="current">Portfolio Details</li>
            </ol>
        </nav>
    </div>
</div>

<section class="product-detail-carousel">
    <div class="product-detail-list init-swiper">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach ($product->product_colors as $media)
                <div class="swiper-slide">
                    <div class="product-detail-item">
                        <figure>
                            <img src="{{ $media->original_url }}">
                        </figure>
                        <div class="product-hero-name">
                            <h2>{{ $product->hero_name }}</h2>
                        </div>
                        <div class="product-detail-content">
                            <div class="product-detail-description">
                                {!! $product->tagline !!}
                            </div>
                            <div class="product-detail-more">
                                <button>TestDrive ?</button>
                                <button>
                                    <i class="fa-solid fa-play"></i> Tanya Angsuran ?
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- custom nav & pagination -->
            <!-- custom navigation -->
            <div class="product-swiper-button product-swiper-button-prev">
                <i class="bi bi-arrow-left"></i>
            </div>
            <div class="product-swiper-button product-swiper-button-next">
                <i class="bi bi-arrow-right"></i>
            </div>

            <!-- custom pagination -->
            <div class="swiper-pagination product-swiper-pagination"></div>
        </div>
        <script type="application/json" class="swiper-config">
            {
                "loop": true,
                "speed": 600,
                "grabCursor": true,
                "centeredSlides": true,
                "slidesPerView": 1,
                "autoplay": {
                  "delay": 5000,
                  "disableOnInteraction": false
                },
                "navigation": {
                  "nextEl": ".product-swiper-button-next",
                  "prevEl": ".product-swiper-button-prev"
                },
                "pagination": {
                  "el": ".product-swiper-pagination",
                  "clickable": true
                }
              }
              
        </script>
    </div>
</section>
<section id="service-details-2" class="service-details-2 section">
    <slot type="section-title"></slot>
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row">
            <div class="col-xl-8 col-lg-8">
                <div class="service-content">
                    <div class="content-header mb-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-meta d-flex align-items-center gap-3 mb-3">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">{{
                                $product->product_category->category }}</span>
                        </div>
                        <h1 class="service-title mb-3" >{{ $product->name }}</h1>
                        {!! $product->desc !!}
                    </div>
                    <div class="service-card mb-4 d-block d-lg-none"" id=" PriceLIST">
                        <div class="card-header">
                            <h4 class="card-title" >Price List {{ $product->name }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="overview-list">
                                @foreach ($product->product_type as $type )
                                <div class="overview-item">
                                    <div class="item-label">
                                        <i class="bi bi-check2-square"></i>
                                        <span>{{ $type->type }}</span>
                                    </div>
                                    <span class="item-value">{{ $type->price_formatted }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="content-header mb-4" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="section-heading mb-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                            Detail {{ $product->name }}</h3>
                        {!! $product->detail !!}
                    </div>
                    <div class="features-showcase mb-5">
                        <h3 class="section-heading mb-4" data-aos="fade-up" data-aos-delay="100">Pelayanan</h3>
                        <div class="features-tabs" data-aos="fade-up" data-aos-delay="200">
                            <div class="row g-4">
                                @foreach ($services as $service)                                    
                                <div class="col-md-6">
                                    <div class="feature-card">
                                        <div class="feature-icon">
                                            <i class="bi {{ $service->icon }}"></i>
                                        </div>
                                        <h5>{{ $service->title }}</h5>
                                        <p>{{ $service->desc }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="client-success mb-5" data-aos="fade-up" data-aos-delay="100">
                        <div class="success-card">
                            <div class="init-swiper swiper">
                                <div class="swiper-wrapper">
                                    @foreach ($testimonies as $testimony)
                                    <div class="swiper-slide p-3">
                                        <div class="success-header d-flex align-items-center mb-4">
                                            <img src="{{ $testimony->image_thumb_url }}"
                                                alt="Client" class="client-avatar">
                                            <div class="client-info ms-3">
                                                <h5 class="client-name mb-1">{{ $testimony->name }}</h5>
                                                <span class="client-role">{{ $testimony->job }}</span>
                                            </div>
                                            <div class="ms-auto">
                                                <div class="stars" data-value="{{ $testimony->rating }}"></div>
                                            </div>
                                        </div>
                                        <blockquote class="success-quote mb-4"> 
                                            {{ $testimony->message }}
                                        </blockquote>
                                    </div>
                                    @endforeach
                                </div>
                                <script type="application/json" class="swiper-config">
                                    {
                                        "slidesPerView": 1,
                                        "spaceBetween": 24,
                                        "loop": true,
                                        "grabCursor": true,
                                        "speed": 650,
                                        "autoplay": {
                                          "delay": 3200,
                                          "disableOnInteraction": false
                                        }
                                      }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                <div class="sidebar" data-aos="fade-left" data-aos-delay="200">
                    <div class="service-card mb-4 d-none d-lg-block" id="PriceLIST">
                        <div class="card-header">
                            <h4 class="card-title" >Price List {{ $product->name }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="overview-list">
                                @foreach ($product->product_type as $type )
                                <div class="overview-item">
                                    <div class="item-label">
                                        <i class="bi bi-check2-square"></i>
                                        <span>{{ $type->type }}</span>
                                    </div>
                                    <span class="item-value">{{ $type->price_formatted }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="contact-card">
                        <div class="card-header">
                            <h4 class="card-title" >Penasaran dengan Mobil Ini?</h4>
                            <p class="card-subtitle" >isi form di bawah untuk informasi harga, promo, atau simulasi kredit.</p>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('contact.store') }}" id="form-contact" method="post"
                                class="php-email-form contact-form">
                                @csrf
                                <div class="form-group mb-3">
                                    <div class="input-wrapper">
                                        <i class="bi bi-people input-icon"></i>
                                        <input type="text" id="name" name="name" placeholder="Your Name">
                                        <div class="invalid-feedback" id="error-name"></div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-wrapper">
                                        <i class="bi bi-envelope input-icon"></i>
                                        <input type="text" id="email" name="email" placeholder="Your Email">
                                        <div class="invalid-feedback" id="error-email"></div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-wrapper">
                                        <i class="bi bi-telephone input-icon"></i>
                                        <input type="text" id="wa" name="wa" placeholder="Your Whatsapp Number">
                                        <div class="invalid-feedback" id="error-wa"></div>
                                    </div>
                                </div>
                                <input type="hidden" name="subject" value="{{ $product->name}}">
                                <div class="form-group mb-4">
                                    <textarea id="message" name="message" rows="6" placeholder="Message"></textarea>
                                    <div class="invalid-feedback" id="error-message"></div>
                                </div>
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>
                                <button type="submit" class="submit-btn w-100">
                                    <span>Submit Request</span>
                                    <i class="bi bi-arrow-right"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="action-section text-center mt-5 pt-4" data-aos="fade-up" data-aos-delay="100">
            <div class="action-buttons d-flex flex-wrap gap-3 justify-content-center">
                <a href="#" class="action-btn secondary">
                    <i class="bi bi-calendar3"></i>
                    <span>Schedule Meeting</span>
                </a>
                <a href="#" class="action-btn primary">
                    <i class="bi bi-folder2-open"></i>
                    <span>View Portfolio</span>
                </a>
                @if ($product->brochure_url)
                <a href="{{ $product->brochure_url }}" class="action-btn secondary">
                    <i class="bi bi-download"></i>
                    <span>Download Brochure</span>
                </a>
                @endif

            </div>
        </div>

    </div>

</section>
<section id="gallery-product-detail" class="gallery-product-detail section" data-builder="section">

    <div class="container section-title" data-aos="fade-up" data-builder="section-title">
        <h2>Full Showcase</h2>
        <p>Dari tampilan luar, interior, hingga aksesoris — semua bisa Anda
            lihat langsung di sini.</p>
    </div>
    <slot type="section-title"></slot>

    <div class="container" data-aos="fade-up" data-aos-delay="100" data-no-editable="true">
        <div class="row">
            <div class="col-12">
                <div class="gallery-product-detail-container init-swiper">
                    <div class=" custom-swiper swiper">
                        <div class="swiper-wrapper">
                            @foreach ($product->product_gallery as $gallery)
                            <div class="swiper-slide">
                                <div class="gallery-product-detail-item">
                                    <div class="gallery-product-detail-img">
                                        <a class="glightbox" data-gallery="images-gallery"
                                            href="{{ $gallery->original_url }}">
                                            <img src="{{ $gallery->original_url }}" class="img-fluid"
                                                alt="{{ $gallery->original_name }}">
                                            <div class="gallery-product-detail-overlay">
                                                <i class="bi bi-plus-circle"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <!-- Pagination & Navigation -->
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                    <script type="application/json" class="swiper-config">
                        {
                            "centeredSlides": true,
                            "slidesPerView": 1.2,
                            "spaceBetween": 24,
                            "loop": true,
                            "grabCursor": true,
                            "effect": "coverflow",
                            "coverflowEffect": {
                              "rotate": 24,
                              "depth": 180,
                              "modifier": 1.2,
                              "slideShadows": true
                            },
                            "speed": 650,
                            "autoplay": {
                              "delay": 3200,
                              "disableOnInteraction": false
                            },
                            "pagination": {
                              "el": ".custom-swiper .swiper-pagination",
                              "clickable": true
                            },
                            "navigation": {
                              "nextEl": ".custom-swiper .swiper-button-next",
                              "prevEl": ".custom-swiper .swiper-button-prev"
                            },
                            "breakpoints": {
                              "640": { "slidesPerView": 1.6, "spaceBetween": 28 },
                              "768": { "slidesPerView": 2, "spaceBetween": 28 },
                              "1024": { "slidesPerView": 2.6, "spaceBetween": 32 }
                            }
                          }
                    </script>
                </div>
            </div>
        </div>
    </div>

</section>

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function() {
            // Card Progress Controller
            $.cardProgress = function (card) {
                var me = $(card);
                me.addClass('card-progress');
            }

            $.cardProgressDismiss = function (card, dismissed) {
                var me = $(card);
                me.removeClass('card-progress');
                me.find('.card-progress-dismiss').remove();
                if (dismissed)
                    dismissed.call(this, me);
            }

            $("#form-contact").on('submit', function(e) {
                e.preventDefault();
                
                let form = $(this);
                let formData = new FormData(this);

                // clear error dulu
                form.find('.form-control').removeClass('is-invalid');
                form.find('.invalid-feedback').text('');
                $.cardProgress('#card-contact');

                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 0) {
                            $.each(data.errors, function(key, val) {
                                $("#" + key).addClass('is-invalid'); // tambahkan bootstrap class
                                $("#error-" + key).text(val[0]); // tampilkan pesan error
                            });
                            $.cardProgressDismiss('#card-contact');
                        } else {
                            form[0].reset();
                            $.cardProgressDismiss('#card-contact');
                            swal.fire({
                                    icon: 'success',
                                    title: 'Thank You',
                                    html: '<small> your message has been sent successfully, <strong class="d-block">would you like to contact us via whatsapp for a quick response</strong></small>',
                                    showCloseButton: true,
                                    showCancelButton: true,
                                    reverseButtons: true,
                                    confirmButtonColor: '#4caf50',
                                    confirmButtonText: '<i class="fab fa-whatsapp text-white"></i> Yes, Please !',
                                    confirmButtonAriaLabel: 'Yes, Please!',
                                    cancelButtonText: 'No, Thanks',
                                    cancelButtonAriaLabel: 'No, Thanks',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.open(data.url, '_blank');
                                    }
                                })
                        }
                    }
                });
            });
        });
</script>
@endpush
@endsection