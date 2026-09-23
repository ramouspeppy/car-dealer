@extends('frontend.layouts.app')
@push('css')
    <style>
        .gallery-4 .masonry-grid {
            columns: 2;
            column-gap: 12px;
        }

        @media (min-width: 768px) {
            .gallery-4 .masonry-grid {
                columns: 3;
            }
        }

        @media (min-width: 992px) {
            .gallery-4 .masonry-grid {
                columns: 4;
            }
        }

        .gallery-4 .masonry-item {
            break-inside: avoid;
            margin-bottom: 12px;
        }

        .gallery-4 .gallery-card {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            margin-bottom: 0;
        }

        .gallery-4 .gallery-card a {
            display: block;
            width: 100%;
            height: 100%;
            position: relative;
        }

        .gallery-4 .gallery-card img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-4 .gallery-card .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: color-mix(in srgb, var(--accent-color), transparent 60%);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-4 .gallery-card .overlay i {
            color: var(--contrast-color);
            font-size: 28px;
            transform: scale(0.6);
            transition: transform 0.3s ease;
        }

        .gallery-4 .gallery-card:hover img {
            transform: scale(1.05);
        }

        .gallery-4 .gallery-card:hover .overlay {
            opacity: 1;
        }

        .gallery-4 .gallery-card:hover .overlay i {
            transform: scale(1);
        }

        /* ===== LOVE BUTTON ===== */
        .btn-love {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid #dee2e6;
            background: transparent;
            border-radius: 50px;
            padding: 6px 16px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: inherit;
        }

        .btn-love:hover {
            border-color: #e74c3c;
            color: #e74c3c;
        }

        .btn-love.loved {
            background: #e74c3c;
            border-color: #e74c3c;
            color: #fff;
        }

        .btn-love i {
            font-size: 16px;
            transition: transform 0.3s ease;
        }

        .btn-love.animate i {
            transform: scale(1.5);
        }
    </style>
@endpush

@section('content')
    <section id="gallery-4" class="gallery-4 section" data-builder="section">

        <div class="container section-title" data-aos="fade-up" data-builder="section-title">
            <h2>{{ $gallery->title }}</h2>
            <div class="row justify-content-center">
                <div class="col-8">
                    <p>{{ $gallery->description }}</p>
                </div>
            </div>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="d-flex align-items-center mb-4 gap-3 small">
                <span><i class="bi bi-calendar3 me-1"></i> {{ $gallery->date }}</span>

                {{-- Tombol Love --}}
                <button class="btn-love" id="btn-love" data-url="{{ route('gallery.love', $gallery->slug) }}">
                    <i class="bi bi-heart-fill"></i>
                    <span id="love-count">{{ number_format($gallery->loves) }}</span> loves
                </button>
            </div>

            <div class="masonry-grid">

                {{-- Cover tampil pertama --}}
                @if ($gallery->hasMedia('cover'))
                    <div class="masonry-item" data-aos="fade-up" data-aos-delay="100">
                        <div class="gallery-card">
                            <a href="{{ $gallery->getFirstMediaUrl('cover') }}" class="glightbox" data-gallery="gallery-set">
                                <img src="{{ $gallery->getFirstMediaUrl('cover') }}" alt="{{ $gallery->title }}" loading="lazy">
                                <div class="overlay">
                                    <i class="bi bi-fullscreen"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Images collection --}}
                @foreach ($gallery->getMedia('images') as $media)
                    <div class="masonry-item" data-aos="fade-up" data-aos-delay="{{ 100 + ($loop->index % 3) * 50 }}">
                        <div class="gallery-card">
                            <a href="{{ $media->getUrl() }}" class="glightbox" data-gallery="gallery-set">
                                <img src="{{ $media->getUrl() }}" alt="{{ $gallery->title }}" loading="lazy">
                                <div class="overlay">
                                    <i class="bi bi-fullscreen"></i>
                                </div>
                            </a>
                        </div>
                    </div><!-- End Gallery Item -->
                @endforeach

            </div>

        </div>

    </section>
@endsection
@push('scripts')
    <script>
        const btnLove = document.getElementById('btn-love');
        const loveCount = document.getElementById('love-count');

        // Cek cookie saat halaman dimuat
        const cookieKey = 'loved_gallery_{{ $gallery->id }}';
        const alreadyLoved = document.cookie.split(';').some(c => c.trim().startsWith(cookieKey + '='));
        if (alreadyLoved) {
            btnLove.classList.add('loved');
            btnLove.disabled = true;
        }

        btnLove.addEventListener('click', function() {
            if (this.disabled) return;

            const url = this.dataset.url;

            this.classList.add('loved', 'animate');
            setTimeout(() => this.classList.remove('animate'), 300);

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                .then(res => res.json())
                .then(data => {
                    loveCount.textContent = data.loves;

                    if (data.already) {
                        // Sudah pernah love sebelumnya
                        btnLove.classList.add('loved');
                    }

                    btnLove.disabled = true;
                });
        });
    </script>
@endpush
