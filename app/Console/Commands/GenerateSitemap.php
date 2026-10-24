<?php

namespace App\Console\Commands;

use App\Models\Gallery;
use App\Models\Post;
use App\Models\Product;
use App\Models\Promo;
use App\Models\WebSetting;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the public website sitemap.';

    public function handle()
    {
        $settings = WebSetting::pluck('value', 'name')->all();
        $sitemap = Sitemap::create();
        $urlCount = 0;

        $addUrl = function (string $url, $lastModified = null, float $priority = 0.7) use ($sitemap, &$urlCount) {
            $tag = Url::create($url)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority($priority);

            if ($lastModified instanceof \DateTimeInterface) {
                $tag->setLastModificationDate($lastModified);
            }

            $sitemap->add($tag);
            $urlCount++;
        };

        if ($this->pageIsEnabled($settings, 'home')) {
            $addUrl(url('/'), null, 1.0);
        }

        if ($this->pageIsEnabled($settings, 'products')) {
            $addUrl(route('product.index'), null, 0.9);

            foreach (Product::query()->where('status', '1')->get(['slug', 'updated_at']) as $product) {
                $addUrl(route('product.detail', $product->slug), $product->updated_at, 0.8);
            }
        }

        if ($this->pageIsEnabled($settings, 'promos')) {
            $addUrl(route('promo.index'), null, 0.8);

            foreach (Promo::active()->get(['slug', 'updated_at']) as $promo) {
                $addUrl(route('promo.detail', $promo->slug), $promo->updated_at, 0.7);
            }
        }

        if ($this->pageIsEnabled($settings, 'testdrive')) {
            $addUrl(route('testdrive.show'), null, 0.6);
        }

        if ($this->pageIsEnabled($settings, 'posts')) {
            $addUrl(route('post.index'), null, 0.8);

            foreach (Post::published()->get(['slug', 'updated_at']) as $post) {
                $addUrl(route('post.show', $post->slug), $post->updated_at, 0.7);
            }
        }

        if ($this->pageIsEnabled($settings, 'gallery')) {
            $addUrl(route('gallery.index'), null, 0.7);

            foreach (Gallery::whereNotNull('published_at')->get(['slug', 'updated_at']) as $gallery) {
                $addUrl(route('gallery.show', $gallery->slug), $gallery->updated_at, 0.6);
            }
        }

        if ($this->pageIsEnabled($settings, 'contact')) {
            $addUrl(route('contact'), null, 0.5);
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info("Sitemap generated with {$urlCount} URLs.");

        return self::SUCCESS;
    }

    private function pageIsEnabled(array $settings, string $page): bool
    {
        $value = $settings["frontend_page_{$page}"] ?? '1';

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? true;
    }
}
