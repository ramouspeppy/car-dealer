<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Models\Product;
use App\Models\Promo;
use App\Models\Testimony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LandingPageController extends Controller
{
    public function index()
    {
        $landingPage = LandingPage::first();

        if (!$landingPage) {
            $landingPage = LandingPage::create([
                'headline'       => 'Wujudkan Mobil Impian Anda Sekarang Juga',
                'hero_badge'     => 'Promo Spesial Bulan Ini',
                'hero_cta_label' => 'Chat Sekarang via WhatsApp',
                'form_title'     => 'Konsultasi Gratis, Dapatkan Penawaran Terbaik',
                'form_subtitle'  => 'Isi form di bawah, tim kami akan segera menghubungi Anda.',
                'is_active'      => true,
            ]);
        }

        $products    = Product::active()->orderBy('name')->get(['id', 'name']);
        $testimonies = Testimony::orderBy('name')->get(['id', 'name']);
        $promos      = Promo::orderBy('promo')->get(['id', 'promo']);

        return view('backend.landing-page.index', compact('landingPage', 'products', 'testimonies', 'promos'));
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

        $landingPage = LandingPage::first() ?? new LandingPage();

        $landingPage->fill([
            'is_active'                  => $request->boolean('is_active'),
            'hero_badge'                 => $request->hero_badge,
            'headline'                   => $request->headline,
            'subheadline'                => $request->subheadline,
            'hero_cta_label'             => $request->hero_cta_label,
            'trust_badges'               => $this->linesToArray($request->trust_badges_raw),
            'usp_items'                  => $this->buildUspItems($request),
            'featured_product_ids'       => array_values(array_filter($request->featured_product_ids ?? [])),
            'promo_id'                   => $request->promo_id ?: null,
            'testimony_ids'              => array_values(array_filter($request->testimony_ids ?? [])),
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
            'message' => 'Landing page berhasil diperbarui',
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

    private function buildUspItems(Request $request)
    {
        $icons  = $request->usp_icon ?? [];
        $titles = $request->usp_title ?? [];
        $descs  = $request->usp_desc ?? [];

        $items = [];
        foreach ($titles as $i => $title) {
            if (!trim($title ?? '')) {
                continue;
            }
            $items[] = [
                'icon'  => $icons[$i] ?? 'bi bi-check-circle',
                'title' => $title,
                'desc'  => $descs[$i] ?? '',
            ];
        }

        return $items;
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
