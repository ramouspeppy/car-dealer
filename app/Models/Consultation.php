<?php

namespace App\Models;

use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consultation extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function wa_url($phoneNumber = null)
    {
        // $this->update(['status', 'contacted']);
        $name = $this->name;

        $text = "";
        $message = $this->timeGreeting() . ' ' . str_replace('{name}', $name, $text);

        // 4) Bangun URL WhatsApp
        $phone = $phoneNumber ?? $this->phone;

        $phone = preg_replace('/\D+/', '', (string) $phone); // opsional: sanitize


        $walink = 'https://wa.me/send';

        $agent = new Agent();
        if ($agent->isMobile()) {
            $walink = 'whatsapp://send';
        }

        return $walink . '?phone=' . $phone . '&text=' . urlencode($message);
    }

    public function timeGreeting(): string
    {
        $hour = now()->format('H');

        if ($hour >= 5 && $hour < 11) {
            return "Selamat pagi";
        } elseif ($hour >= 11 && $hour < 15) {
            return "Selamat siang";
        } elseif ($hour >= 15 && $hour < 18) {
            return "Selamat sore";
        } else {
            return "Selamat malam";
        }
    }

    function getWaButtonAttribute()
    {
        return '<a href="' . route('backend.consultation.contact', $this->id) . '" type="button" target="_blank" class="btn btn-success btn-icon icon-left">
        <i class="fab fa-whatsapp"></i> ' . $this->phone . ' <span class="badge badge-transparent"></span>
    </a>';
    }

    public function getStatusLabelAttribute()
    {
        if ($this->status == 'contacted') {
            return "<span class='badge badge-pill badge-primary'>contacted</span>";
        }
        if ($this->status == 'closed') {
            return "<span class='badge badge-pill badge-dark'>closed</span>";
        }
        return "<span class='badge badge-pill badge-success text-white'>new</span>";
    }

    public function getPhoneFormattedAttribute()
    {
        $phone = preg_replace('/[^0-9]/', '', $this->phone);

        if (substr($phone, 0, 1) == '0') {
            $phone = '62' . substr($phone, 1);
        }

        return $phone;
    }
}
