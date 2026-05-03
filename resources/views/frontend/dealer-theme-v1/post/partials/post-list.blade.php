<section id="post-list-5" class="post-index-list section" data-builder="section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">

        @if ($featuredPost)
            <div class="row gy-5">

                <!-- FEATURED -->
                <div class="col-lg-8">
                    <article class="featured-post">
                        <div class="row g-0">
                            <div class="col-md-6">
                                <div class="featured-img">
                                    <img src="{{ $featuredPost->image_url }}" class="img-fluid">
                                    <span class="post-badge">{{ $featuredPost->post_category ? $featuredPost->post_category->title : 'Umum' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="featured-content">
                                    <div class="tag-row">
                                        <span class="tag">{{ $featuredPost->post_category ? $featuredPost->post_category->title : 'Umum' }}</span>
                                        <span class="read-time">
                                            <i class="bi bi-clock"></i> {{ $featuredPost->published_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <h2 class="title">
                                        <a href="{{ route('post.show', $featuredPost->slug) }}">
                                            {{ $featuredPost->title }}
                                        </a>
                                    </h2>
                                    <p class="excerpt">{{ $featuredPost->excerpt }}</p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- SIDE -->
                @if ($sidePost)
                    <div class="col-lg-4">
                        <article class="side-post">
                            <div class="side-img">
                                <img src="{{ $sidePost->image_url }}" class="img-fluid">
                                <span class="post-badge hot">{{ $sidePost->post_category ? $sidePost->post_category->title : 'Umum' }}</span>
                            </div>
                            <div class="side-content">
                                <span class="tag">{{ $sidePost->post_category ? $sidePost->post_category->title : 'Umum' }}</span>
                                <h3 class="title">
                                    <a href="{{ route('post.show', $sidePost->slug) }}">
                                        {{ $sidePost->title }}
                                    </a>
                                </h3>
                            </div>
                        </article>
                    </div>
                @endif

            </div>
        @endif

        <!-- LIST -->
        <div class="row gy-4 mt-2">

            @foreach ($listPosts as $post)
                <div class="col-lg-3 col-md-6">
                    <article class="compact-post">
                        <div class="compact-img">
                            <img src="{{ $post->image_thumb_url }}" class="img-fluid">
                            <a href="{{ route('post.show', $post->slug) }}" class="overlay-link">
                                <i class="bi bi-arrow-up-right"></i>
                            </a>
                        </div>
                        <div class="compact-content">
                            <span class="tag">{{ $post->post_category ? $post->post_category->title : 'Umum' }}</span>
                            <h3 class="title">
                                <a href="{{ route('post.show', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>
                        </div>
                    </article>
                </div>
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
                            <a href="{{ $posts->url(1) }}" class="page-num">1</a>
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
                                <a href="{{ $posts->url($i) }}" class="page-num">{{ $i }}</a>
                            @endif
                        @endfor

                        {{-- DOTS AKHIR --}}
                        @if ($pagination['current'] < $pagination['last'] - 3)
                            <span class="dots"><i class="bi bi-three-dots"></i></span>
                        @endif

                        {{-- LAST PAGE --}}
                        @if ($pagination['current'] < $pagination['last'] - 2)
                            <a href="{{ $posts->url($pagination['last']) }}" class="page-num">
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
