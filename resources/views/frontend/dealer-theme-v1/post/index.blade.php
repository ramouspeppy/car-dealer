@extends('frontend.dealer-theme-v1.layouts.app')

@section('content')

    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container">

            <h1>Berita</h1>

            <nav class="breadcrumbs">
                <ol>

                    @foreach ($breadcrumbs as $crumb)
                        <li class="{{ $loop->last ? 'current' : '' }}">

                            @if ($crumb['url'])
                                <a href="{{ $crumb['url'] }}">
                                    {{ $crumb['label'] }}
                                </a>
                            @else
                                {{ $crumb['label'] }}
                            @endif

                        </li>
                    @endforeach

                </ol>
            </nav>

        </div>
    </div>

    <section id="search-post-index" class="search-post-index section">
        <div class="container">

            <div class="search-post-index">
                <div class="row align-items-center">

                    <!-- RESULT INFO -->

                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="results-count">
                            @if ($hasFilter)
                                <h2>Hasil Pencarian</h2>
                                <p>
                                    Ditemukan <span class="results-number">{{ $posts->total() }}</span> artikel
                                    @if ($search)
                                        untuk <span class="search-term">"{{ $search }}"</span>
                                    @endif
                                </p>
                            @endif

                        </div>
                    </div>

                    <!-- SEARCH FORM -->
                    <div class="col-lg-6">
                        <form class="search-form" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari artikel..." value="{{ $search }}">
                                <button class="btn search-btn">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

                <!-- ACTIVE FILTER -->
                <div class="search-filters mt-4">
                    <div class="tags-wrapper">

                        @if ($category)
                            <span class="filter-tag">
                                Kategori: {{ $category }}
                                <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            </span>
                        @endif

                        @if ($tag)
                            <span class="filter-tag">
                                Tag: {{ $tag }}
                                <a href="{{ request()->fullUrlWithQuery(['tag' => null]) }}">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            </span>
                        @endif

                        @if ($date)
                            <span class="filter-tag">
                                Tanggal: {{ $date }}
                                <a href="{{ request()->fullUrlWithQuery(['date' => null]) }}">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            </span>
                        @endif

                    </div>
                </div>

                <!-- ADVANCED FILTER -->
                <div class="advanced-filters mt-4">
                    <button class="btn btn-sm toggle-filters" type="button" data-bs-toggle="collapse" data-bs-target="#advancedFiltersCollapse" aria-expanded="true" aria-controls="advancedFiltersCollapse">
                        <i class="bi bi-sliders me-1"></i> Advanced Filters
                    </button>
                    <div class="mt-3 collapse @if ($hasFilter) show @endif" aria-labelledby="advancedFiltersCollapse" data-bs-parent="#search-post-index" class="hide" id="advancedFiltersCollapse" style="">
                        <form method="GET">

                            <input type="hidden" name="search" value="{{ $search }}">
                            <div class="card card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Kategori</label>
                                        <select name="category" class="form-select">
                                            <option value="">Semua</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->slug }}" {{ $category == $cat->slug ? 'selected' : '' }}>
                                                    {{ $cat->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- DATE -->
                                    <div class="col-md-4">
                                        <label class="form-label">Tanggal</label>
                                        <select name="date" class="form-select">
                                            <option value="">Semua</option>
                                            <option value="today" {{ $date == 'today' ? 'selected' : '' }}>Hari ini</option>
                                            <option value="week" {{ $date == 'week' ? 'selected' : '' }}>Minggu ini</option>
                                            <option value="month" {{ $date == 'month' ? 'selected' : '' }}>Bulan ini</option>
                                            <option value="year" {{ $date == 'year' ? 'selected' : '' }}>Tahun ini</option>
                                        </select>
                                    </div>

                                    <!-- TAG (ganti rating) -->
                                    <div class="col-md-4">
                                        <label class="form-label">Tag</label>
                                        <select name="tag" class="form-select">
                                            <option value="">Semua</option>
                                            @foreach ($tags as $t)
                                                <option value="{{ $t->slug }}" {{ $tag == $t->slug ? 'selected' : '' }}>
                                                    {{ $t->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <a href="{{ route('post.index') }}" class="btn btn-sm reset-btn">Reset</a>
                                    <button class="btn btn-sm apply-btn">Apply</button>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>
    <div id="post-container">

        @include('frontend.dealer-theme-v1.post.partials.post-list')
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const container = document.getElementById('post-container');

            function loadPage(url, push = true) {

                // fade out
                container.style.opacity = '0.3';

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.text())
                    .then(html => {

                        // fade cepat hilang dulu
                        container.style.opacity = '0';

                        setTimeout(() => {
                            container.innerHTML = html;

                            if (push) {
                                window.history.pushState({
                                    url: url
                                }, '', url);
                            }

                            // fade masuk
                            container.style.opacity = '1';

                            container.scrollIntoView({
                                behavior: 'smooth'
                            });

                        }, 150);

                    })
                    .catch(err => {
                        console.error('AJAX error:', err);
                    });
            }

            // pagination click
            document.addEventListener('click', function(e) {
                const target = e.target.closest('a[href*="page="]');
                if (target) {
                    e.preventDefault();
                    loadPage(target.href);
                }
            });

            // go to page
            document.addEventListener('click', function(e) {
                if (e.target.closest('.jump-btn')) {
                    e.preventDefault();
                    goToPageAjax();
                }
            });

            // enter key
            document.addEventListener('keypress', function(e) {
                if (e.target.id === 'jumpPage' && e.key === 'Enter') {
                    goToPageAjax();
                }
            });

            // back / forward
            window.addEventListener('popstate', function(e) {
                if (e.state && e.state.url) {
                    loadPage(e.state.url, false);
                }
            });

            // go to page function
            window.goToPageAjax = function() {

                const input = document.getElementById('jumpPage');
                let page = parseInt(input.value);

                const max = {{ $pagination['last'] }};

                if (!page || page < 1) page = 1;
                if (page > max) page = max;

                const baseUrl = "{{ $posts->url(1) }}";
                const url = baseUrl.replace('page=1', 'page=' + page);

                loadPage(url);
            }

        });
    </script>
@endpush
