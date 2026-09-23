<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Profile;
use App\Models\Tag;
use App\Models\User;

class PostController extends Controller
{
    protected $limit = 6;

    public function index()
    {
        $limit = 10;

        $search   = request('search');
        $category = request('category');
        $tag      = request('tag');
        $date     = request('date');
        $sort     = request('sort');
        $profile     = Profile::first();

        $query = Post::with(['author', 'post_category', 'tags', 'media'])
            ->published();
        $categories = PostCategory::all();
        $tags       = Tag::all();
        // 🔎 SEARCH
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('excerpt', 'like', "%$search%")
                    ->orWhere('body', 'like', "%$search%");
            });
        }

        // 📂 CATEGORY
        if ($category) {
            $query->whereHas('category', fn($q) => $q->where('slug', $category));
        }

        // 🏷 TAG
        if ($tag) {
            $query->whereHas('tags', fn($q) => $q->where('slug', $tag));
        }

        // 📅 DATE RANGE
        if ($date) {
            if ($date == 'today') {
                $query->whereDate('published_at', now());
            } elseif ($date == 'week') {
                $query->whereBetween('published_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($date == 'month') {
                $query->whereMonth('published_at', now()->month);
            } elseif ($date == 'year') {
                $query->whereYear('published_at', now()->year);
            }
        }

        // 🔄 SORT
        if ($sort == 'oldest') {
            $query->oldest();
        } else {
            $query->latest(); // default
        }

        $posts = $query->paginate($limit)->withQueryString();


        // SPLIT DATA
        $featuredPost = $posts->first();
        $sidePost     = $posts->skip(1)->first();
        $listPosts    = $posts->skip(2)->values();

        // PAGINATION META
        $pagination = [
            'current' => $posts->currentPage(),
            'last'    => $posts->lastPage(),
            'hasPrev' => !$posts->onFirstPage(),
            'hasNext' => $posts->hasMorePages(),
            'prevUrl' => $posts->previousPageUrl(),
            'nextUrl' => $posts->nextPageUrl(),
        ];

        $hasFilter = $search || $category || $tag || $date;
        $breadcrumbs = [
            [
                'label' => 'Home',
                'url'   => route('/')
            ],
            [
                'label' => 'Berita',
                'url'   => route('post.index') // reset semua filter
            ],
        ];

        // helper hapus query
        function removeQuery($key)
        {
            return request()->fullUrlWithQuery([$key => null]);
        }

        // 🔎 CATEGORY
        if ($category) {
            $breadcrumbs[] = [
                'label' => 'Kategori: ' . $category,
                'url'   => removeQuery('category')
            ];
        }

        // 🏷 TAG
        if ($tag) {
            $breadcrumbs[] = [
                'label' => 'Tag: ' . $tag,
                'url'   => removeQuery('tag')
            ];
        }

        // 🔍 SEARCH
        if ($search) {
            $breadcrumbs[] = [
                'label' => 'Pencarian: "' . $search . '"',
                'url'   => removeQuery('search')
            ];
        }

        // 📅 DATE
        if ($date) {
            $breadcrumbs[] = [
                'label' => 'Filter: ' . $date,
                'url'   => removeQuery('date')
            ];
        }
        if (request()->ajax()) {
            return view('frontend.post.partials.post-list', compact(
                'featuredPost',
                'sidePost',
                'listPosts',
                'posts',
                'pagination'
            ))->render();
        }

        return view('frontend.post.index', compact(
            'featuredPost',
            'sidePost',
            'listPosts',
            'posts',
            'pagination',
            'search',
            'category',
            'tag',
            'date',
            'sort',
            'categories',
            'tags',
            'hasFilter',
            'breadcrumbs',
            'profile'
        ));
    }
    // public function index()
    // {
    //     $limit  = 10;
    //     $search = request('search');

    //     $posts = Post::with(['author', 'category', 'tags', 'media'])
    //         ->published()
    //         ->when($search, function ($query, $search) {
    //             $query->where(function ($q) use ($search) {
    //                 $q->where('title', 'like', "%{$search}%")
    //                     ->orWhere('excerpt', 'like', "%{$search}%")
    //                     ->orWhere('body', 'like', "%{$search}%");
    //             });
    //         })
    //         ->filter(request(['s', 'm', 'y'])) // tetap dipakai
    //         ->latest()
    //         ->paginate($limit)
    //         ->withQueryString();

    //     // =========================
    //     // SAFE SPLIT DATA (ANTI ERROR 🔥)
    //     // =========================
    //     $collection = $posts->getCollection();

    //     $featuredPost = $collection->first();
    //     $sidePost     = $collection->skip(1)->first();
    //     $listPosts    = $collection->skip(2)->values();

    //     // =========================
    //     // PAGINATION
    //     // =========================
    //     $pagination = [
    //         'current' => $posts->currentPage(),
    //         'last'    => $posts->lastPage(),
    //         'hasPrev' => !$posts->onFirstPage(),
    //         'hasNext' => $posts->hasMorePages(),
    //         'prevUrl' => $posts->previousPageUrl(),
    //         'nextUrl' => $posts->nextPageUrl(),
    //     ];

    //     // =========================
    //     // AJAX RESPONSE
    //     // =========================
    //     if (request()->ajax()) {
    //         return view('frontend.perindo.post.partials.post-list', compact(
    //             'featuredPost',
    //             'sidePost',
    //             'listPosts',
    //             'posts',
    //             'pagination'
    //         ))->render();
    //     }

    //     return view('frontend.perindo.post.index', compact(
    //         'featuredPost',
    //         'sidePost',
    //         'listPosts',
    //         'posts',
    //         'pagination',
    //         'search'
    //     ));
    // }

    public function show(Post $post)
    {
        // record views
        views($post)->record();

        // load relasi (hindari N+1 query)
        $post->load(['post_category', 'tags', 'author']);

        // related posts (kategori sama)
        $relatedPosts = Post::with(['media', 'post_category', 'author'])
            ->published()
            ->where('post_category_id', $post->post_category_id)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(4)
            ->get();

        // fallback kalau kosong
        if ($relatedPosts->count() == 0) {
            $relatedPosts = Post::with(['media', 'post_category'])
                ->published()
                ->where('id', '!=', $post->id)
                ->latest()
                ->take(4)
                ->get();
        }

        $searchAll = true;
        return view('frontend.post.detail', compact(
            'post',
            'relatedPosts',
            'searchAll',
        ));
    }

    public function category(PostCategory $category)
    {
        $categoryName = $category->title;

        $posts = $category->posts()
            ->published()
            ->filter(request(['s', 'm', 'y']))
            ->latest()
            ->with(['author', 'category', 'tags', 'media'])
            ->paginate($this->limit);
        return view('frontend.index', compact('posts', 'categoryName'));
    }

    public function author(User $author)
    {
        $authorName = $author->name;

        $posts = $author->posts()
            ->published()
            ->filter(request(['s', 'm', 'y']))
            ->latest()
            ->with(['author', 'category', 'tags', 'media'])
            ->paginate($this->limit);
        return view('frontend.index', compact('posts', 'authorName'));
    }

    public function tag(Tag $tag)
    {
        $tagName = $tag->name;

        $posts = $tag->posts()
            ->published()
            ->filter(request(['s', 'm', 'y']))
            ->latest()
            ->with(['author', 'category', 'tags', 'media'])
            ->paginate($this->limit);
        return view('frontend.index', compact('posts', 'tagName'));
    }
}
