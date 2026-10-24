@extends('frontend.layouts.app')



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
