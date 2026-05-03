<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;

class ConsultationController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:100',
            'phone'        => ['required', 'regex:/^(08|628)[0-9]{8,11}$/'],
            'city'         => 'required|string|max:100',
            'budget'       => 'required|string',
            'product_id'   => 'required|exists:products,id',
            'payment_type' => 'required|in:cash,credit',
            'tenor'        => 'required|required_if:payment_type,credit|integer',
            'message'      => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $consultation = Consultation::create([
            'name'         => $request->name,
            'phone'        => $request->phone,
            'city'         => $request->city,
            'budget'       => $request->budget,
            'product_id'   => $request->product_id,
            'payment_type' => $request->payment_type,
            'tenor'        => $request->payment_type === 'credit' ? $request->tenor : null,
            'message'      => $request->message,
            'source'       => 'website',
            'ip_address'   => $request->ip(),
        ]);


        $profile = Profile::first();
        $wa = $profile->wa_formatted;

        $wa_message  = "KONSULTASI KENDARAAN BARU\n";
        $wa_message .= "==============================\n\n";

        $wa_message .= "{$consultation->timeGreeting()} {$profile->name}, saya *{$consultation->name}* ingin konsultasi pembelian mobil *{$consultation->product->name}*.\n\n";

        if ($consultation->city) {
            $wa_message .= "Kota    : {$consultation->city}\n";
        }

        if ($consultation->budget) {
            $wa_message .= "Budget  : {$consultation->budget}\n";
        }

        if ($consultation->payment_type) {
            $wa_message .= "Metode  : " . ucfirst($consultation->payment_type) . "\n";
        }

        if ($consultation->payment_type === 'credit' && $consultation->tenor) {
            $wa_message .= "Tenor   : {$consultation->tenor} bulan\n";
        }

        $wa_message .= "\nPesan:\n{$consultation->message}\n\n";

        $wa_message .= "==============================\n";
        $wa_message .= "Mohon informasi detail dan penawaran terbaik.\n";
        $wa_message .= "Terima kasih.";

        return response()->json([
            'status'  => 'success',
            'message' => 'Konsultasi berhasil dikirim',
            'data'    => $consultation,
            'wa_text' => $this->whatsapp($wa, $wa_message)
        ]);
    }

    public function whatsapp($wa, $message)
    {
        $walink = 'https://wa.me/send';

        $agent = new Agent();
        if ($agent->isMobile()) {
            $walink = 'whatsapp://send';
        }

        $wa = $wa;
        $messageEncode = urlencode($message);
        $url = $walink . '?phone=' . $wa . '&text=' . $messageEncode;

        return $url;
    }
}
