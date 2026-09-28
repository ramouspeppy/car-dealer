<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\LandingPageV4;
use App\Models\Product;
use App\Models\Promo;
use App\Models\Testimony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LandingPageV4Controller extends Controller
{
    public function index()
    {
        $landingPage = LandingPageV4::first();

        if (!$landingPage) {
            $landingPage = LandingPageV4::create([
                'headline'       => 'Beli Mobil Jadi *Lebih Cerdas*, Cepat, dan Transparan',
                'hero_badge'     => 'Digital Showroom v4.0',
                'hero_cta_label' => 'Mulai Konsultasi',
                'form_title'     => 'Mulai dari Satu Pesan',
                'form_subtitle'  => 'Isi data singkat di bawah, tim kami langsung menghubungi Anda lewat WhatsApp.',
                'is_active'      => true,
            ]);
        }

        $products    = Product::active()->orderBy('name')->get(['id', 'name']);
        $testimonies = Testimony::orderBy('name')->get(['id', 'name']);
        $promos      = Promo::orderBy('promo')->get(['id', 'promo']);
        $galleries   = Gallery::orderBy('title')->get(['id', 'title']);

        return view('backend.landing-page-v4.index', compact('landingPage', 'products', 'testimonies', 'promos', 'galleries'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'headline'    => 'required|string|max:150',
            'hero_badge'  => 'nullable|string|max:100',
            'subheadline' => 'nullable|string',
            'meta_title'  => 'nullable|string|max:150',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $landingPage = LandingPageV4::first() ?? new LandingPageV4();

        $landingPage->fill([
            'is_active'                  => $request->boolean('is_active'),
            'hero_badge'                 => $request->hero_badge,
            'headline'                   => $request->headline,
            'subheadline'                => $request->subheadline,
            'hero_cta_label'             => $request->hero_cta_label,
            'trust_badges'               => $this->linesToArray($request->trust_badges_raw),
            'featured_product_ids'       => array_values(array_filter($request->featured_product_ids ?? [])),
            'testimony_ids'              => array_values(array_filter($request->testimony_ids ?? [])),
            'promo_ids'                  => array_values(array_filter($request->promo_ids ?? [])),
            'gallery_ids'                => array_values(array_filter($request->gallery_ids ?? [])),
            'faqs'                       => $this->buildFaqs($request),
            'form_title'                 => $request->form_title,
            'form_subtitle'              => $request->form_subtitle,
            'meta_title'                 => $request->meta_title,
            'meta_description'           => $request->meta_description,
            'tracking_head_script'       => $request->tracking_head_script,
            'tracking_conversion_script' => $request->tracking_conversion_script,
        ]);
        $landingPage->save();

        if ($request->hasFile('hero_image')) {
            $landingPage->addMedia($request->hero_image)->preservingOriginal()->toMediaCollection('hero_image');
        }
        if ($request->hasFile('og_image')) {
            $landingPage->addMedia($request->og_image)->preservingOriginal()->toMediaCollection('og_image');
        }

        $request->session()->flash('flash_notification', [
            'level'   => 'info',
            'message' => 'Landing Page V2 berhasil diperbarui',
        ]);

        return redirect()->back();
    }

    private function linesToArray($raw)
    {
        if (!$raw) {
            return [];
        }

        return collect(explode("\n", $raw))
            ->map(fn($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }

    private function buildFaqs(Request $request)
    {
        $questions = $request->faq_question ?? [];
        $answers   = $request->faq_answer ?? [];

        $faqs = [];
        foreach ($questions as $i => $question) {
            if (!trim($question ?? '')) {
                continue;
            }
            $faqs[] = [
                'question' => $question,
                'answer'   => $answers[$i] ?? '',
            ];
        }

        return $faqs;
    }
}
