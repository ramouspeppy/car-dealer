<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Header;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\Testimony;
use App\Models\PhotoDelivery;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Promo;
use App\Models\Service;
use App\Models\Testdrive;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Validator;

class TestdriveController extends Controller
{

    public function testdriveShow()
    {
        SEOTools::setTitle(config('settings.site_title'));
        SEOTools::setDescription(config('settings.site_desc'));
        SEOTools::addImages(asset('images/' . config('settings.og_image')));

        $products = Product::latest()->active()->get();
        $services  = Service::latest()->get();
        return view('frontend.testdrive', compact('products', 'services'));
    }


    public function testdriveStore(Request $request)
    {
        $messages = [
            'name.required'             => 'Ups! nama masih kosong. Yuk, diisi dulu',
            'wa.required'               => 'Ups! whatsapp masih kosong. Yuk, diisi dulu.',
            'wa.digits_between'         => 'Ups! whatsapp harus berbentuk angka dengan panjang antara 9 - 15 digit.',
            'wa.regex'                  => 'Ups! format whatsapp salah, tolong di cek lagi yaa',
            'email.email'               => 'Format email salah, tolong di cek lagi yaa.',
            'product.required'          => 'Ups! Mobil Tesdrive masih kosong. Yuk, diisi dulu',
            'product.exists'             => 'Ups! Mobil Tesdrive salah, tolong di pilih dengan benar yaa',
            'schedule_date.required'    => 'Ups! jadwal masih kosong. Yuk, diisi dulu',
            'schedule_date.date_format' => 'Ups! format tanggal salah, tolong di cek lagi yaa',
        ];

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
            ],
            'wa' => [
                'required',
                'digits_between:9,15',
                'regex:/^(?:\+62|62|0)8[1-9][0-9]{6,11}$/',
            ],
            'email' => [
                'nullable',
                'email',
            ],
            'product' => [
                'required',
                'exists:products,slug',
            ],
            'schedule_date' => [
                'required',
                'date_format:d M Y'
            ],
        ], $messages);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'errors' => $validator->errors()]);
        } else {

            $name          = trim($request->name);
            $wa            = trim($request->wa);
            $email         = trim($request->email);
            $product       = trim($request->product);
            $schedule_date = trim($request->schedule_date);
            $note          = trim($request->note);

            $message          = "*Halo!* Terima kasih telah mengisi formulir Testdrive kami.\n\n";
            $message        .= "Berikut detail informasi Anda: \n";
            $message        .= "• Nama: *{$name}*\n";
            $message        .= "• WhatsApp: *{$wa}*\n";
            if (!empty($email)) {
                $message .= "• Email: _{$email}_\n";
            }
            $message        .= "• Produk: *{$product}*\n";
            $message        .= "• Jadwal Test Drive: *{$schedule_date}*\n";
            if (!empty($note)) {
                $message .= "• Catatan: _{$note}_\n";
            }
            $message .= "\n Tim kami akan segera menghubungi Anda untuk konfirmasi lebih lanjut.\n";
            $message .= "Terima kasih";

            $testdrive = new Testdrive();

            $testdrive->name    = $request->name;
            $testdrive->wa      = $request->wa;
            $testdrive->email   = $request->email;
            $testdrive->product = $request->product;
            $testdrive->schedule_date    = $request->schedule_date;
            $testdrive->note    = $request->note;

            $testdrive->save();

            if ($testdrive) {
                return response()->json(['status' => 1, 'url' => $this->whatsapp($message)]);
            }
        }
    }

    public function contactStore(Request $request)
    {
        $messages = [
            'name.required'    => 'Nama wajib diisi.',
            'wa.required'      => 'Nomor WhatsApp wajib diisi.',
            'email.required'   => 'Email wajib diisi.',
            'email.email'      => 'Format email tidak valid.',
            'subject.required' => 'Subjek wajib diisi.',
            'message.required' => 'Pesan wajib diisi.',
        ];

        $validator = Validator::make($request->all(), [
            'name'    => 'required',
            'wa'      => 'required',
            'email'   => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'errors' => $validator->errors()]);
        } else {

            $name    = trim($request->name);
            $email   = trim($request->email);
            $subject = trim($request->subject);
            $msg     = trim($request->message);

            $message       = "Hallo,\n";
            $message       .= "Name : *{$name}*\n";
            $message       .= "Email : *{$email}*\n";
            $message       .= "Subject : *{$subject}*\n\n";
            $message       .= "Message : {$msg}\n";

            $contact = new Contact();

            $contact->name    = $request->name;
            $contact->email   = $request->email;
            $contact->wa      = $request->wa;
            $contact->subject = $request->subject;
            $contact->message = $request->message;

            $contact->save();

            if ($contact) {
                return response()->json(['status' => 1, 'url' => $this->whatsapp($message)]);
            }
        }
    }

    public function whatsapp($message)
    {
        $walink = 'https://wa.me/send';

        $agent = new Agent();
        if ($agent->isMobile()) {
            $walink = 'whatsapp://send';
        }

        $profile = Profile::first();
        $wa = $profile->wa_formatted;
        $messageEncode = urlencode($message);
        $url = $walink . '?phone=' . $wa . '&text=' . $messageEncode;

        return $url;
    }
}
