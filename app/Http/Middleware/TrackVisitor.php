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
