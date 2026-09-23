@extends('frontend.layouts.app')

@section('content')
    <section id="gallery-index-list" class="gallery-index-list section">

        <div class="container section-title" data-aos="fade-up">
            <h2>Gallery</h2>
            <p>Koleksi galeri foto terbaik kami untuk Anda</p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">

                @foreach ($galleries as $index => $gallery)
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ 200 + ($loop->index % 3) * 100 }}">
                        <div class="card">
                            <div class="card-top d-flex align-items-center">
                                <span class="date">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $gallery->date }}
                                </span>
                                <span class="ms-auto likes">
                                    <i class="bi bi-heart"></i> {{ number_format($gallery->loves) }}
                                </span>
                            </div>
                            <div class="card-img-wrapper">
                                <img src="{{ $gallery->getFirstMediaUrl('cover') }}" alt="{{ $gallery->title }}">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('gallery.show', $gallery->slug) }}">{{ $gallery->title }}</a>
                                </h5>
                                <p class="card-text">
                                    {{ $gallery->descLimit(18) }}
                                </p>
                            </div>
                        </div>
                    </div><!-- End Gallery Item Card -->
                @endforeach

            </div>
        </div>

    </section>
@endsection
@push('scripts')
@endpush
