<?php

namespace App\Support;

use Illuminate\Http\Request;

class LeadAttribution
{
    public static function fromRequest(Request $request): array
    {
        $value = function ($key) use ($request) {
            return $request->input($key) ?: $request->cookie('visitor_' . $key);
        };

        $utmSource = $value('utm_source');
        $source = $request->input('source')
            ?: $request->cookie('visitor_source')
            ?: $utmSource
            ?: ($value('gclid') ? 'google' : ($value('fbclid') ? 'facebook' : 'direct'));

        return [
            'visitor_key' => $request->cookie('visitor_key'),
            'source' => substr($source, 0, 255),
            'utm_source' => $utmSource ? substr($utmSource, 0, 255) : null,
            'utm_medium' => $value('utm_medium') ? substr($value('utm_medium'), 0, 255) : null,
            'utm_campaign' => $value('utm_campaign') ? substr($value('utm_campaign'), 0, 255) : null,
            'utm_term' => $value('utm_term') ? substr($value('utm_term'), 0, 255) : null,
            'utm_content' => $value('utm_content') ? substr($value('utm_content'), 0, 255) : null,
            'gclid' => $value('gclid') ? substr($value('gclid'), 0, 255) : null,
            'fbclid' => $value('fbclid') ? substr($value('fbclid'), 0, 255) : null,
            'landing_url' => substr((string) ($request->input('landing_url') ?: $request->cookie('visitor_landing_url') ?: $request->headers->get('referer')), 0, 255) ?: null,
        ];
    }
}
