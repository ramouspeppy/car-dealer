<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\VisitorLog;
use Faker\Factory;
use Illuminate\Database\Seeder;

class VisitorLogSeeder extends Seeder
{
    private const VISITOR_KEY_PREFIX = 'seeded-visitor-';

    public function run(): void
    {
        VisitorLog::query()
            ->where('visitor_key', 'like', self::VISITOR_KEY_PREFIX . '%')
            ->delete();

        $faker = Factory::create('id_ID');
        $products = Product::query()
            ->where('status', 1)
            ->get(['id', 'name', 'slug']);
        $now = now();
        $startDate = $now->copy()->subDays(59)->startOfDay();
        $endDate = $now->copy();
        $baseUrl = rtrim((string) config('app.url'), '/');
        $rows = [];
        $totalLogs = 10000;
        $generatedLogs = 0;

        for ($visitorNumber = 1; $generatedLogs < $totalLogs; $visitorNumber++) {
            $visitorKey = self::VISITOR_KEY_PREFIX . str_pad((string) $visitorNumber, 6, '0', STR_PAD_LEFT);
            $pageViews = min(random_int(1, 8), $totalLogs - $generatedLogs);

            for ($pageView = 0; $pageView < $pageViews; $pageView++) {
                $product = $products->isNotEmpty() && random_int(1, 100) <= 35
                    ? $products->random()
                    : null;

                $page = $product
                    ? [
                        'path' => 'product/' . $product->slug,
                        'title' => $product->name,
                        'product_id' => $product->id,
                    ]
                    : $this->randomPage();

                $viewedAt = $faker->dateTimeBetween($startDate, $endDate);
                $rows[] = [
                    'visitor_key' => $visitorKey,
                    'path' => $page['path'],
                    'url' => substr($baseUrl . '/' . ltrim($page['path'], '/'), 0, 255),
                    'page_title' => $page['title'],
                    'referrer' => $this->randomReferrer($faker),
                    'device' => $faker->randomElement(['desktop', 'mobile', 'mobile', 'tablet']),
                    'browser' => $faker->randomElement(['Chrome', 'Chrome', 'Safari', 'Firefox', 'Edge']),
                    'os' => $faker->randomElement(['Windows', 'Android', 'iOS', 'macOS', 'Linux']),
                    'product_id' => $page['product_id'] ?? null,
                    'ip_address' => $faker->randomElement(['192.0.2', '198.51.100', '203.0.113']) . '.' . random_int(1, 254),
                    'created_at' => $viewedAt,
                    'updated_at' => $viewedAt,
                ];
                $generatedLogs++;

                if (count($rows) >= 250) {
                    VisitorLog::query()->insert($rows);
                    $rows = [];
                }
            }
        }

        if ($rows !== []) {
            VisitorLog::query()->insert($rows);
        }
    }

    private function randomPage(): array
    {
        return [
            [
                'path' => '',
                'title' => 'Home',
            ],
            [
                'path' => 'product',
                'title' => 'Produk',
            ],
            [
                'path' => 'promo',
                'title' => 'Promo',
            ],
            [
                'path' => 'testdrive',
                'title' => 'Test Drive',
            ],
            [
                'path' => 'gallery',
                'title' => 'Galeri',
            ],
            [
                'path' => 'berita',
                'title' => 'Berita',
            ],
            [
                'path' => 'promo-mobil',
                'title' => 'Landing Page V1',
            ],
            [
                'path' => 'promo-mobil-v2',
                'title' => 'Landing Page V2',
            ],
            [
                'path' => 'promo-mobil-v3',
                'title' => 'Landing Page V3',
            ],
            [
                'path' => 'promo-mobil-v4',
                'title' => 'Landing Page V4',
            ],
        ][random_int(0, 9)];
    }

    private function randomReferrer($faker): ?string
    {
        if (random_int(1, 100) <= 45) {
            return null;
        }

        return $faker->randomElement([
            'https://www.google.com/',
            'https://www.facebook.com/',
            'https://www.instagram.com/',
            'https://www.tiktok.com/',
        ]);
    }
}
