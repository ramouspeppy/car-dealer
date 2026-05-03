@extends('frontend.dealer-theme-v1.layouts.app')

@section('content')
    <!-- Toast Container for Deadline Validation -->
    <div id="validationToastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11;"></div>

    <div class="page-title light-background">
        <div class="container">
            <h1>Berita</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('/') }}">Home</a></li>
                    <li class="current">Berita</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->
    <section id="post-details" class="post-details section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <article class="post-article">

                {{-- HEADER --}}
                <div class="row g-5 align-items-center mb-5">

                    {{-- THUMBNAIL --}}
                    <div class="col-lg-6" data-aos="fade-right">
                        <div class="featured-media">
                            @if ($post->image_url)
                                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="img-fluid" loading="lazy">
                            @endif
                        </div>
                    </div>

                    {{-- META --}}
                    <div class="col-lg-6" data-aos="fade-left">
                        <div class="post-header">

                            {{-- CATEGORY + READING TIME --}}
                            <div class="post-badges">
                                <a href="{{ route('post.category', $post->post_category->slug) }}" class="badge-category">
                                    {{ $post->post_category->name }}
                                </a>

                                <span class="badge-time">
                                    <i class="bi bi-clock"></i>
                                    {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read
                                </span>
                            </div>

                            {{-- TITLE --}}
                            <h1 class="post-title">{{ $post->title }}</h1>

                            {{-- AUTHOR --}}
                            <div class="writer-bar">
                                <img src="{{ $post->author->image_url ?? asset('default-avatar.png') }}" class="writer-avatar">
                                <div class="writer-meta">
                                    <h5>{{ $post->author->name ?? 'Admin' }}</h5>
                                    <span>Author</span>
                                </div>
                            </div>

                            {{-- DATE + VIEWS --}}
                            <div class="date-bar">
                                <span class="pub-date">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $post->created_at->format('d M Y') }}
                                </span>

                                <span class="dot-separator">•</span>

                                <span>
                                    <i class="bi bi-eye"></i>
                                    {{ views($post)->count() }} views
                                </span>
                            </div>

                        </div>
                    </div>

                </div>

                {{-- CONTENT --}}
                <div class="row g-5">

                    {{-- MAIN CONTENT --}}
                    <div class="col-lg-8" data-aos="fade-up">
                        <div class="post-body">

                            {{-- CONTENT DARI DATABASE --}}
                            {!! $post->body !!}

                        </div>
                    </div>

                    {{-- SIDEBAR --}}
                    <div class="col-lg-4" data-aos="fade-left">
                        <aside class="post-sidebar">

                            {{-- AUTHOR CARD --}}
                            <div class="sidebar-author-card">
                                <img src="{{ $post->author->image_url ?? asset('default-avatar.png') }}" class="sidebar-author-img">

                                <h4>{{ $post->author->name ?? 'Admin' }}</h4>
                                <span class="sidebar-author-role">Author</span>

                                <p>
                                    Penulis artikel di website ini.
                                </p>
                            </div>
                            <div class="sidebar-section">
                                <div class="position-relative widget-item">
                                    <div class="search-widget" data-aos="fade-up" data-aos-delay="200">

                                        <h3 class="widget-title">Search</h3>
                                        <slot type="widget-title"></slot>

                                        <form action="{{ route('post.index') }}" method="GET">
                                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel...">
                                            <button type="submit" title="Search">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </form>

                                    </div>
                                </div>

                            </div>
                            {{-- TAGS --}}
                            <div class="sidebar-section">
                                <h4>Tags</h4>
                                <div class="topic-tags">
                                    @foreach ($post->tags as $tag)
                                        <a href="{{ route('post.index', ['tag' => $tag->slug]) }}" class="topic-tag">
                                            {{ $tag->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="sidebar-section">
                                <div id="widget-7i0sSwExsT" class="builder-widget-wrap position-relative widget-item">
                                    <div class="recent-posts-widget" data-builder="widget">

                                        <h3 class="widget-title">Related Posts</h3>
                                        <slot type="widget-title"></slot>

                                        @foreach ($relatedPosts as $related)
                                            <div class="post-item">

                                                <!-- IMAGE -->
                                                <div class="post-img-wrapper">
                                                    <img src="{{ $related->image_thumb_url }}" alt="">
                                                </div>

                                                <!-- CONTENT -->
                                                <div class="post-content ps-3">

                                                    <h4>
                                                        <a href="{{ route('post.show', $related->slug) }}">
                                                            {{ $related->titleLimit(10) }}
                                                        </a>
                                                    </h4>

                                                    <!-- META BARU -->
                                                    <div class="post-meta">
                                                        <span class="post-date">
                                                            {{ $related->published_at->format('d M Y') }}
                                                        </span>

                                                        <span class="post-author">
                                                            <a href="#">
                                                                {{ $related->author->name }}
                                                            </a>
                                                        </span>
                                                    </div>

                                                </div>

                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            {{-- SHARE --}}
                            <div class="sidebar-section">
                                <h4>Share This Post</h4>
                                <div class="share-buttons">

                                    <a href="https://wa.me/?text={{ urlencode(url()->current()) }}" class="share-btn">
                                        <i class="bi bi-whatsapp"></i> WhatsApp
                                    </a>

                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" class="share-btn">
                                        <i class="bi bi-facebook"></i> Facebook
                                    </a>

                                    <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}" class="share-btn">
                                        <i class="bi bi-twitter-x"></i> Twitter
                                    </a>

                                    <a href="#" onclick="navigator.clipboard.writeText('{{ url()->current() }}')" class="share-btn">
                                        <i class="bi bi-clipboard"></i> Copy Link
                                    </a>

                                </div>
                            </div>

                        </aside>
                    </div>

                </div>

            </article>

        </div>

    </section>
@endsection

@push('scripts')
@endpush
