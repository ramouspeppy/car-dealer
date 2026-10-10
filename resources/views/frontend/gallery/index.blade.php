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
    <section id="post-pagination" class="post-pagination section">

        <div class="container">
            <div class="pagination-wrapper">

                <!-- INFO -->
                <div class="page-info">
                    Displaying page <strong>{{ $pagination['current'] }}</strong>
                    of <strong>{{ $pagination['last'] }}</strong>
                </div>

                <nav>
                    <div class="pagination-track">

                        <!-- PREV -->

                        @if ($pagination['hasPrev'])
                            <a href="{{ $pagination['prevUrl'] }}" class="nav-arrow prev">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        @endif

                        <!-- NUMBERS -->
                        <div class="page-numbers">

                            {{-- FIRST PAGE --}}
                            @if ($pagination['current'] > 3)
                                <a href="{{ $galleries->url(1) }}" class="page-num">1</a>
                            @endif

                            {{-- DOTS AWAL --}}
                            @if ($pagination['current'] > 4)
                                <span class="dots"><i class="bi bi-three-dots"></i></span>
                            @endif

                            {{-- RANGE TENGAH --}}
                            @for ($i = max(1, $pagination['current'] - 2); $i <= min($pagination['last'], $pagination['current'] + 2); $i++)
                                @if ($i == $pagination['current'])
                                    <span class="page-num active">{{ $i }}</span>
                                @else
                                    <a href="{{ $galleries->url($i) }}" class="page-num">{{ $i }}</a>
                                @endif
                            @endfor

                            {{-- DOTS AKHIR --}}
                            @if ($pagination['current'] < $pagination['last'] - 3)
                                <span class="dots"><i class="bi bi-three-dots"></i></span>
                            @endif

                            {{-- LAST PAGE --}}
                            @if ($pagination['current'] < $pagination['last'] - 2)
                                <a href="{{ $galleries->url($pagination['last']) }}" class="page-num">
                                    {{ $pagination['last'] }}
                                </a>
                            @endif

                        </div>

                        <!-- NEXT -->
                        @if ($pagination['hasNext'])
                            <a href="{{ $pagination['nextUrl'] }}" class="nav-arrow next">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        @endif

                    </div>
                </nav>

                <!-- JUMP -->
                <div class="jump-to">
                    <span>Go to page</span>
                    <input type="number" min="1" max="{{ $pagination['last'] }}" value="{{ $pagination['current'] }}" id="jumpPage">
                    <a href="#" class="jump-btn" onclick="goToPage()">
                        <i class="bi bi-arrow-return-left"></i>
                    </a>
                </div>

            </div>
        </div>

    </section>
@endsection
@push('scripts')
@endpush
