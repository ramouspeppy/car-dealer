<?php

namespace App\Http\Middleware;

use App\Models\Product;
use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        if ($this->shouldSkip($request)) {
            return $next($request);
        }

        $response = $next($request);

        if (!$request->isMethod('get') || $request->ajax()) {
            return $response;
        }

        $response = $this->captureAttribution($request, $response);

        $visitorKey = $request->cookie('visitor_key');

        if (!$visitorKey) {
            $visitorKey = $this->generateVisitorKey($request);
            $response = $response->withCookie(Cookie::forever('visitor_key', $visitorKey));
        }

        $productId = null;
        $trackedProduct = null;

        if ($request->route()) {
            $productParam = $request->route()->parameter('product');

            if ($productParam) {
                $trackedProduct = is_object($productParam)
                    ? $productParam
                    : Product::where('slug', $productParam)->first();

                $productId = $trackedProduct ? $trackedProduct->id : null;
            }
        }

        $agent = new Agent();

        VisitorLog::create([
            'visitor_key' => $visitorKey,
            'path' => $request->path(),
            'product_id' => $productId,
            'page_title' => $this->resolveTitle($request),
            'referrer' => $request->headers->get('referer'),
            'device' => $agent->isMobile() ? 'mobile' : ($agent->isTablet() ? 'tablet' : 'desktop'),
            'browser' => $agent->browser() ?: 'unknown',
            'os' => $agent->platform() ?: 'unknown',
            'ip_address' => $request->ip(),
            'url' => $request->fullUrl(),
        ]);

        if ($trackedProduct) {
            visits($trackedProduct)->increment();
        }

        return $response;
    }

    protected function captureAttribution(Request $request, $response)
    {
        $cookieMinutes = 60 * 24 * 30;
        $utmKeys = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid', 'fbclid'];

        foreach ($utmKeys as $key) {
            $value = trim((string) $request->query($key, ''));

            if ($value !== '' && !$request->cookie('visitor_' . $key)) {
                $response = $response->withCookie(Cookie::make('visitor_' . $key, substr($value, 0, 255), $cookieMinutes));
            }
        }

        $source = trim((string) $request->query('utm_source', ''));
        if ($source === '' && $request->query('gclid')) {
            $source = 'google';
        }
        if ($source === '' && $request->query('fbclid')) {
            $referrerHost = strtolower((string) parse_url($request->headers->get('referer', ''), PHP_URL_HOST));
            $source = Str::contains($referrerHost, 'instagram') ? 'instagram' : 'facebook';
        }

        if ($source === '' && !$request->cookie('visitor_source')) {
            $referrerHost = strtolower((string) parse_url($request->headers->get('referer', ''), PHP_URL_HOST));

            if (Str::contains($referrerHost, ['google.', 'bing.', 'yahoo.', 'duckduckgo.'])) {
                $source = 'organic';
            } elseif (Str::contains($referrerHost, 'instagram')) {
                $source = 'instagram';
            } elseif (Str::contains($referrerHost, ['facebook.', 'fb.'])) {
                $source = 'facebook';
            } elseif ($referrerHost !== '' && $referrerHost !== strtolower($request->getHost())) {
                $source = $referrerHost;
            } else {
                $source = 'direct';
            }
        }

        if ($source !== '' && !$request->cookie('visitor_source')) {
            $response = $response->withCookie(Cookie::make('visitor_source', substr($source, 0, 255), $cookieMinutes));
        }

        if (!$request->cookie('visitor_landing_url')) {
            $response = $response->withCookie(Cookie::make('visitor_landing_url', substr($request->fullUrl(), 0, 255), $cookieMinutes));
        }

        return $response;
    }

    protected function shouldSkip(Request $request)
    {
        $path = $request->path();

        return $request->is('admin*')
            || $request->is('login')
            || $request->is('logout')
            || $request->is('laravel-filemanager*')
            || $request->is('_debugbar*')
            || Str::startsWith($path, 'api')
            || Str::startsWith($path, 'storage')
            || Str::startsWith($path, '_ignition')
            || Str::contains($request->header('user-agent', ''), ['bot', 'crawl', 'spider']);
    }

    protected function generateVisitorKey(Request $request)
    {
        return hash('sha256', ($request->ip() ?? 'unknown') . '|' . ($request->userAgent() ?? 'unknown') . '|' . ($request->header('accept-language') ?? 'id-ID'));
    }

    protected function resolveTitle(Request $request)
    {
        $route = $request->route();

        if ($route && $route->getName()) {
            return ucfirst(str_replace(['.', '_'], ' ', $route->getName()));
        }

        return $request->path() ?: 'Home';
    }
}
