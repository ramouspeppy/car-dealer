<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Header;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\Testimony;
use App\Support\LeadAttribution;
use App\Models\PhotoDelivery;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Promo;
use App\Models\Service;
use App\Models\Testdrive;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FrontendController extends Controller
{
    public function index()
    {
        $this->ensureFrontendPageIsActive('home');

        $header      = Header::first();
        $seo = $this->frontendSeo();
        $posts       = Post::with('media')->published()->latest()->limit(3)->get();
        $testimonies = Testimony::with('media')->randomLimit()->get();
        $promos      = Promo::with('media')->active()->priority()->get();
        $profile     = Profile::first();
        $products    = Product::with(['media', 'product_type', 'product_category', 'photo_delivery'])->active()->latest()->get();
        $services    = Service::latest()->get();

        $deliveries = PhotoDelivery::with(['media', 'product'])
            ->whereHas('media', function ($query) {
                $query->where('collection_name', 'images');
            })
            ->latest()
            ->get()
            ->flatMap(function ($delivery) {
                if (!$delivery->product) {
                    return [];
                }

                return $delivery->getMedia('images')->map(function ($image) use ($delivery) {
                    return (object) [
                        'product' => $delivery->product,
                        'image_url' => $image->getUrl(),
                        'image_thumb_url' => $image->hasGeneratedConversion('thumb')
                            ? $image->getUrl('thumb')
                            : $image->getUrl(),
                    ];
                });
            })
            ->values();

        $deliveriesByProduct = $deliveries
            ->groupBy(function ($delivery) {
                return $delivery->product->id;
            })
            ->map(function ($productDeliveries) {
                $product = $productDeliveries->first()->product;

                return (object) [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'photo_count' => $productDeliveries->count(),
                ];
            })
            ->values();
        $galleries = Media::where('model_type', Gallery::class)
            ->inRandomOrder()
            ->limit(7)
            ->get();

        // Siapkan data tampilan promo di controller (tanpa @php di Blade)
        $promoCount = $promos->count();
        $waNumber = optional($profile)->wa_formatted;
        $promoCards = $promos->values()->map(function ($promo, $index) use ($promoCount, $waNumber) {
            $daysLeft = $promo->days_left;
            $isFeatured = $index === 0 && $promoCount > 1;
            $isUrgent = $daysLeft !== null && $daysLeft <= 2;

            $progress = null;
            $showProgress = false;
            $deadlineText = null;
            if ($daysLeft !== null) {
                $showProgress = true;
                $progress = max(8, min(100, (int) round(($daysLeft / 30) * 100)));
                $deadlineText = $daysLeft <= 0
                    ? 'Segera berakhir'
                    : 'Masih ' . $daysLeft . ' hari tersisa';
            }

            if ($daysLeft === null) {
                $badgeLabel = $promo->effective_status;
            } elseif ($daysLeft <= 0) {
                $badgeLabel = 'Hari Terakhir!';
            } else {
                $badgeLabel = $daysLeft . ' Hari Lagi';
            }

            $waText = 'Halo, saya tertarik dengan promo "' . $promo->promo . '". Boleh minta info lebih lanjut?';
            $waLink = $waNumber
                ? 'https://wa.me/' . $waNumber . '?text=' . urlencode($waText)
                : '#';

            return (object) [
                'title'           => $promo->promo,
                'image_url'       => $promo->promo_image_url,
                'excerpt'         => $promo->desc_limit,
                'description'     => $promo->desc,
                'effective_label' => $promo->effective_format ?: '—',
                'wa_link'         => $waLink,
                'is_featured'     => $isFeatured,
                'is_urgent'       => $isUrgent,
                'badge_label'     => $badgeLabel,
                'badge_class'     => $isUrgent ? 'is-urgent' : '',
                'badge_icon'      => $isUrgent ? 'bi-clock-fill' : 'bi-clock',
                'show_progress'   => $showProgress,
                'progress'        => $progress,
                'deadline_text'   => $deadlineText,
                'col_class'       => $isFeatured ? 'col-12' : 'col-lg-4 col-md-6',
                'card_class'      => trim('promo-list-card'
                    . ($isFeatured ? ' is-featured' : '')
                    . ($isUrgent ? ' is-urgent-card' : '')),
                'aos_delay'       => 100 + ($index * 50),
            ];
        });

        return view('frontend.welcome', compact(
            'header',
            'profile',
            'products',
            'deliveries',
            'deliveriesByProduct',
            'promos',
            'promoCards',
            'testimonies',
            'posts',
            'services',
            'galleries',
            'seo',
        ));
    }

    public function testdriveShow()
    {
        $products = Product::latest()->active()->get();
        $services  = Service::latest()->get();
        $profile      = Profile::first();
        $seo = $this->frontendSeo([
            'title' => 'Jadwalkan Test Drive',
            'description' => 'Jadwalkan test drive kendaraan dan rasakan langsung kenyamanan serta performanya. Pilih kendaraan dan waktu yang sesuai untuk Anda.',
            'keywords' => ['test drive', 'jadwal test drive', config('settings.site_name'), config('settings.site_brand')],
        ]);
        return view('frontend.testdrive', compact('products', 'profile', 'services', 'seo'));
    }

    public function gallery()
    {
        $galleries = Gallery::with('media')->latest()->paginate(6);
        $seo = $this->frontendSeo([
            'title' => 'Galeri Foto',
            'description' => 'Lihat koleksi foto aktivitas, serah terima kendaraan, dan momen pelanggan bersama ' . config('settings.site_name') . '.',
            'keywords' => ['galeri foto', 'serah terima kendaraan', config('settings.site_name'), config('settings.site_brand')],
        ]);

        return view('frontend.gallery.index', compact('galleries', 'seo'));
    }

    public function galleryShow(Gallery $gallery)
    {
        $seo = $this->frontendSeo([
            'title' => $gallery->title,
            'description' => $gallery->description,
            'keywords' => [$gallery->title, 'galeri foto', config('settings.site_name')],
            'image' => $gallery->cover_url,
            'type' => 'article',
        ]);

        return view('frontend.gallery.show', compact('gallery', 'seo'));
    }

    public function contact()
    {
        $this->ensureFrontendPageIsActive('contact');

        $seo = $this->frontendSeo([
            'title' => 'Kontak Kami',
            'description' => 'Hubungi ' . config('settings.site_name') . ' untuk mendapatkan informasi produk, promo, dan layanan.',
            'keywords' => ['kontak', 'hubungi kami', config('settings.site_name')],
        ]);

        return view('frontend.contact.index', compact('seo'));
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
            $testdrive->fill(LeadAttribution::fromRequest($request));

            $testdrive->save();

            if ($testdrive) {
                return response()->json(['status' => 1, 'url' => $this->whatsapp($message)]);
            }
        }
    }

    public function contactStore(Request $request)
    {
        abort_unless(
            $this->frontendSettingIsActive('page', 'contact')
                || ($this->frontendSettingIsActive('page', 'home')
                    && $this->frontendSettingIsActive('section', 'contact')),
            404
        );

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
            $contact->fill(LeadAttribution::fromRequest($request));

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
