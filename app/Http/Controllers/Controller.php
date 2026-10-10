<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function frontendSeo(array $page = []): array
    {
        $siteName = trim((string) config('settings.site_name'));
        if ($siteName === '' || $siteName === 'data or value has not been set') {
            $siteName = config('app.name');
        }

        $siteBrand = trim((string) config('settings.site_brand'));
        if ($siteBrand === 'data or value has not been set') {
            $siteBrand = '';
        }

        $defaultTitle = trim((string) config('settings.site_title'));
        if ($defaultTitle === '' || $defaultTitle === 'data or value has not been set') {
            $defaultTitle = $siteName;
        }

        $title = trim((string) ($page['title'] ?? '')) ?: $defaultTitle;
        if ($siteName !== '' && !Str::contains($title, $siteName)) {
            $title .= ' | ' . $siteName;
        }

        $description = trim(strip_tags((string) ($page['description'] ?? '')));
        if ($description === '') {
            $description = trim((string) config('settings.site_desc'));
        }
        if ($description === '' || $description === 'data or value has not been set') {
            $description = $siteName;
        }
        $description = Str::limit($description, 160);

        $keywords = $page['keywords'] ?? [];
        if (!is_array($keywords)) {
            $keywords = [$keywords];
        }
        $keywords = array_values(array_filter(array_map('trim', $keywords), function ($keyword) {
            return $keyword !== '' && $keyword !== 'data or value has not been set';
        }));
        if ($keywords === []) {
            $keywords = array_values(array_filter([
                $siteName,
                $siteBrand,
            ]));
        }

        $image = trim((string) ($page['image'] ?? ''));
        if ($image === '') {
            $image = trim((string) config('settings.og_image'));
            if ($image === 'data or value has not been set') {
                $image = '';
            }
        }
        if ($image !== '' && !Str::startsWith($image, ['http://', 'https://'])) {
            $image = asset($image);
        }

        $favicon = trim((string) config('settings.favicon'));
        if ($favicon === '' || $favicon === 'data or value has not been set') {
            $favicon = asset('favicon.ico');
        } elseif (!Str::startsWith($favicon, ['http://', 'https://'])) {
            $favicon = asset($favicon);
        }

        $logo = trim((string) config('settings.site_logo'));
        $logo = $logo === '' || $logo === 'data or value has not been set'
            ? ''
            : (Str::startsWith($logo, ['http://', 'https://']) ? $logo : asset($logo));

        return [
            'locale' => str_replace('_', '-', app()->getLocale()),
            'site_name' => $siteName,
            'title' => $title,
            'description' => $description,
            'keywords' => implode(', ', $keywords),
            'robots' => $page['robots'] ?? 'index, follow',
            'canonical_url' => $page['canonical_url'] ?? request()->url(),
            'type' => $page['type'] ?? 'website',
            'image' => $image,
            'twitter_card' => $image !== '' ? 'summary_large_image' : 'summary',
            'favicon' => $favicon,
            'apple_touch_icon' => asset('frontend/dealer-theme-v1/img/apple-touch-icon.png'),
            'google_verification' => trim((string) config('settings.g_verif')) !== 'data or value has not been set'
                ? trim((string) config('settings.g_verif'))
                : '',
            'site_logo' => $logo,
            'site_brand' => $siteBrand,
            'year' => date('Y'),
        ];
    }
}
