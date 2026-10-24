<?php

namespace App\Http\Controllers\Backend;

use App\Models\WebSetting;
use App\Models\LandingPage;
use App\Models\LandingPageV2;
use App\Models\LandingPageV3;
use App\Models\LandingPageV4;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class WebSettingController extends Controller
{

    protected $uploadPath;
    public function __construct()
    {
        $this->uploadPath = public_path();
    }
    public function getSettings()
    {
        return  new WebSetting();
    }
    public function website()
    {
        $website    = $this->getSettings();
        $frontendPages = [
            'home' => 'Beranda',
            'products' => 'Produk',
            'promos' => 'Promo',
            'testdrive' => 'Test Drive',
            'gallery' => 'Galeri',
            'posts' => 'Berita',
            'contact' => 'Kontak',
            'landing_v1' => 'Landing Page V1',
            'landing_v2' => 'Landing Page V2',
            'landing_v3' => 'Landing Page V3',
            'landing_v4' => 'Landing Page V4',
        ];
        $frontendSections = [
            'hero' => 'Hero',
            'about' => 'Tentang Kami',
            'promo_list' => 'Daftar Promo',
            'product_cards' => 'Daftar Produk',
            'call_to_action' => 'Ajakan Test Drive',
            'services' => 'Layanan',
            'testimonials' => 'Testimoni',
            'portfolio' => 'Serah Terima Kendaraan',
            'gallery' => 'Galeri',
            'contact' => 'Kontak',
            'footer' => 'Footer',
        ];

        return view("backend.websetting.website", compact('website', 'frontendPages', 'frontendSections'));
    }

    public function update(Request $request)
    {
        // return $request->all();
        $webSetting = $this->getSettings();
        $visibilityRules = [];

        foreach (['page' => $this->frontendPageKeys(), 'section' => $this->frontendSectionKeys()] as $type => $keys) {
            foreach ($keys as $key) {
                $visibilityRules["frontend_{$type}_{$key}"] = 'sometimes|boolean';
            }
        }

        $request->validate($visibilityRules);

        if ($request->input('website') == true) {
            $this->websiteValidation($request);
        }
        if ($request->input('header') == true) {
            $this->headerValidation($request);
        }
        if ($request->input('testimony') == true) {
            $this->testimonyValidation($request);
        }
        // if ($request->hasFile('favicon')) {
        //     $favicon = $this->getSettings()->findValue('favicon');
        //     // remove favicon
        //     $this->removeImage($favicon);

        //     // get extention
        //     $ext = Str::after($favicon, ".");

        //     // loop any size
        //     foreach ($this->widthSize as $value) {
        //         // remove the other favicon
        //         $this->removeImage("favicon-{$value}x{$value}.{$ext}");
        //     }
        // }

        $data = $this->handleRequest($request);
        $settingKeys = $this->settingKeys();

        foreach ($data as $name => $value) {
            if (in_array($name, $settingKeys, true)) {
                $webSetting->updateValue($name, $value);
                $this->syncLandingPageStatus($name, $value);
            }
        }

        Cache::forget('settings');

        $request->session()->flash('flash_notification', [
            "level" => "info",
            "message" => "Your settings has been saved !!"
        ]);

        return redirect()->back();
    }

    public function toggleVisibility(Request $request)
    {
        $validated = $request->validate([
            'key' => ['required', 'string', Rule::in($this->visibilitySettingKeys())],
            'active' => 'required|boolean',
        ]);

        $active = filter_var($validated['active'], FILTER_VALIDATE_BOOLEAN);
        $this->getSettings()->updateValue($validated['key'], $active ? '1' : '0');
        $this->syncLandingPageStatus($validated['key'], $active);
        Cache::forget('settings');

        return response()->json([
            'success' => true,
            'active' => $active,
            'message' => $active ? 'Tayangan berhasil diaktifkan.' : 'Tayangan berhasil dinonaktifkan.',
        ]);
    }

    private function frontendPageKeys(): array
    {
        return [
            'home',
            'products',
            'promos',
            'testdrive',
            'gallery',
            'posts',
            'contact',
            'landing_v1',
            'landing_v2',
            'landing_v3',
            'landing_v4',
        ];
    }

    private function frontendSectionKeys(): array
    {
        return [
            'hero',
            'about',
            'promo_list',
            'product_cards',
            'call_to_action',
            'services',
            'testimonials',
            'portfolio',
            'gallery',
            'contact',
            'footer',
        ];
    }

    private function settingKeys(): array
    {
        return array_merge(
            [
                'site_name',
                'site_brand',
                'site_title',
                'site_desc',
                'g_verif',
                'g_tag',
                'script',
                'site_logo',
                'favicon',
                'og_image',
                'bg_footer',
                'bg_header_other',
                'bg_testimony',
            ],
            array_map(function ($key) {
                return "frontend_page_{$key}";
            }, $this->frontendPageKeys()),
            array_map(function ($key) {
                return "frontend_section_{$key}";
            }, $this->frontendSectionKeys())
        );
    }

    private function visibilitySettingKeys(): array
    {
        return array_merge(
            array_map(function ($key) {
                return "frontend_page_{$key}";
            }, $this->frontendPageKeys()),
            array_map(function ($key) {
                return "frontend_section_{$key}";
            }, $this->frontendSectionKeys())
        );
    }

    private function syncLandingPageStatus(string $setting, $value): void
    {
        $pages = [
            'frontend_page_landing_v1' => LandingPage::class,
            'frontend_page_landing_v2' => LandingPageV2::class,
            'frontend_page_landing_v3' => LandingPageV3::class,
            'frontend_page_landing_v4' => LandingPageV4::class,
        ];

        if (!isset($pages[$setting])) {
            return;
        }

        $landingPage = $pages[$setting]::first();
        if ($landingPage) {
            $landingPage->is_active = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            $landingPage->save();
        }
    }

    private function websiteValidation($request)
    {
        $request->validate([
            'site_name'       => 'required|max:100',
            'site_title'      => 'required',
            'site_desc'       => 'required',
            'site_logo'       => 'mimes:jpg,jpeg,png,gif|max:500',
            'favicon'         => 'mimes:jpg,jpeg,ico,png|max:250',
            'og_image'        => 'mimes:jpg,jpeg,ico,png|max:500',
            'g_verif'         => 'nullable|min:5',
            'g_tag'           => 'nullable|min:5',
            'script'          => 'nullable|min:5',
            'bg_footer'       => 'mimes:jpg,jpeg,ico,png|max:500',
        ]);
    }
    private function headerValidation($request)
    {
        $request->validate([
            'bg_header_other'        => 'mimes:jpg,jpeg,png|max:2024',
        ]);
    }
    private function testimonyValidation($request)
    {
        $request->validate([
            'bg_testimony'        => 'mimes:jpg,jpeg,png|max:2024',
        ]);
    }
    private function handleRequest($request)
    {
        $data = $request->all();
        if ($request->hasFile('site_logo')) {
            $site_logo   = $request->file('site_logo');
            $extension   = $site_logo->getClientOriginalExtension();
            $filename    = 'logo.' . $extension;
            $destination = $this->uploadPath;

            $successUploaded = $site_logo->move($destination, $filename);
            $data['site_logo']     = $filename;
        }

        if ($request->hasFile('favicon')) {
            $favicon     = $request->file('favicon');
            $extension   = $favicon->getClientOriginalExtension();
            $filename    = 'favicon.' . $extension;
            $destination = public_path();

            $successUploaded = $favicon->move($destination, $filename);
            // $size            = $this->widthSize;
            // if ($successUploaded) {
            //     foreach ($size as $value) {
            //         $name  = str_replace(".{$extension}", "-{$value}x{$value}.{$extension}", $filename);
            //         $width = $value;
            //         // fungsi widen lebih efektif dipakai dari resize
            //         // karena lebar gambar akan menyesuaikan tinggi otomatis
            //         Image::make($destination . "/" . $filename)
            //             ->widen($width)
            //             ->save($destination . "/" . $name);

            //         $data['faviconx' . $value] = $name;
            //     }
            // }
            $data['favicon'] = $filename;
        }

        if ($request->hasFile('og_image')) {
            $og_image     = $request->file('og_image');
            $extension   = $og_image->getClientOriginalExtension();
            $filename    = 'site_image.' . $extension;
            $destination = $this->uploadPath;

            $successUploaded = $og_image->move($destination, $filename);
            $data['og_image'] = $filename;
        }

        if ($request->hasFile('bg_footer')) {
            $bg_footer     = $request->file('bg_footer');
            $extension   = $bg_footer->getClientOriginalExtension();
            $filename    = 'bg_footer.' . $extension;
            $destination = $this->uploadPath;

            $successUploaded = $bg_footer->move($destination, $filename);
            $data['bg_footer'] = $filename;
        }

        if ($request->hasFile('bg_header_other')) {
            $bg_header_other     = $request->file('bg_header_other');
            $extension   = $bg_header_other->getClientOriginalExtension();
            $filename    = 'image_header_other.' . $extension;
            $destination = $this->uploadPath;

            $successUploaded = $bg_header_other->move($destination, $filename);
            $data['bg_header_other'] = $filename;
        }

        if ($request->hasFile('bg_testimony')) {
            $bg_testimony     = $request->file('bg_testimony');
            $extension   = $bg_testimony->getClientOriginalExtension();
            $filename    = 'bg_testimony.' . $extension;
            $destination = $this->uploadPath;

            $successUploaded = $bg_testimony->move($destination, $filename);
            $data['bg_testimony'] = $filename;
        }
        return $data;
    }

    public function removeImage($image)
    {
        if (!empty($image)) {
            $imagePath     = $this->uploadPath . '/' . $image;
            $ext           = substr(strrchr($image, '.'), 1);

            if (file_exists($imagePath)) unlink($imagePath);
        }
    }
}
