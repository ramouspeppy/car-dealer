<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\LandingPage;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;

class LandingController extends Controller
{
    public function show(Request $request)
    {
        $landingPage = LandingPage::with('media')->first();

        if (!$landingPage || !$landingPage->is_active) {
            return redirect()->route('/');
        }

        $products    = $landingPage->featuredProducts();
        $testimonies = $landingPage->selectedTestimonies();
        $promo       = $landingPage->promo;

        return view('frontend.landing.show', compact('landingPage', 'products', 'testimonies', 'promo'));
    }

    /**
     * Lead dari landing page disimpan ke tabel `consultations` yang sama
     * dipakai form konsultasi lainnya, dengan source = 'landing_page' dan
     * data UTM/gclid/fbclid supaya bisa dilacak dari kampanye iklan mana.
     * Otomatis muncul juga di Dashboard & menu Konsultasi admin.
     */
    public function storeLead(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:100',
            'phone'      => ['required', 'regex:/^(08|628)[0-9]{8,11}$/'],
            'city'       => 'nullable|string|max:100',
            'product_id' => 'nullable|exists:products,id',
            'message'    => 'nullable|string|max:1000',
        ], [
            'phone.regex' => 'Format nomor WhatsApp tidak valid. Gunakan format 08xxx atau 628xxx.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $landingPage = LandingPage::first();

        $consultation = Consultation::create([
            'name'         => $request->name,
            'phone'        => $request->phone,
            'city'         => $request->city,
            'product_id'   => $request->product_id,
            'message'      => $request->message ?: 'Tertarik dengan penawaran di halaman "' . ($landingPage->headline ?? 'promo') . '"',
            'source'       => 'landing_page',
            'ip_address'   => $request->ip(),
            'utm_source'   => $request->utm_source,
            'utm_medium'   => $request->utm_medium,
            'utm_campaign' => $request->utm_campaign,
            'utm_term'     => $request->utm_term,
            'utm_content'  => $request->utm_content,
            'gclid'        => $request->gclid,
            'fbclid'       => $request->fbclid,
            'landing_url'  => $request->landing_url,
        ]);

        $profile = Profile::first();
        $wa      = $profile->wa_formatted;

        $wa_message  = "LEAD DARI LANDING PAGE\n";
        $wa_message .= "==============================\n\n";
        $wa_message .= "{$consultation->timeGreeting()} {$profile->name}, saya *{$consultation->name}* tertarik dengan promo mobil.\n\n";

        if ($consultation->product) {
            $wa_message .= "Mobil   : {$consultation->product->name}\n";
        }
        if ($consultation->city) {
            $wa_message .= "Kota    : {$consultation->city}\n";
        }

        $wa_message .= "\nPesan:\n{$consultation->message}\n\n";
        $wa_message .= "==============================\n";
        $wa_message .= "Mohon informasi detail dan penawaran terbaik.\nTerima kasih.";

        $walink = 'https://wa.me/send';
        $agent  = new Agent();
        if ($agent->isMobile()) {
            $walink = 'whatsapp://send';
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Terima kasih, tim kami akan segera menghubungi Anda',
            'wa_text' => $walink . '?phone=' . $wa . '&text=' . urlencode($wa_message),
        ]);
    }
}
