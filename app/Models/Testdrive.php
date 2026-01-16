<?php

namespace App\Models;

use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testdrive extends Model
{
    use HasFactory;
    protected $dates = ['schedule_date'];
    protected $guarded = ['id'];


    public function getScheduleDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function setScheduleDateAttribute($value)
    {
        $this->attributes['schedule_date'] = Carbon::createFromFormat('d M Y', $value)->format('Y-m-d');
    }

    public function getWaFormattedAttribute($value)
    {
        $p =  preg_replace("~\D~", "", $this->wa);
        return preg_replace("/^0/", '62', $p, 1);
    }
    public function getWaUrlAttribute()
    {
        $name = $this->name;

        $text = "";
        $message = $this->timeGreeting() . ' ' . str_replace('{name}', $name, $text);

        // 4) Bangun URL WhatsApp
        $phone = $this->wa_formatted ?? $this->phone;
        $phone = preg_replace('/\D+/', '', (string) $phone); // opsional: sanitize


        $walink = 'https://wa.me/send';

        $agent = new Agent();
        if ($agent->isMobile()) {
            $walink = 'whatsapp://send';
        }

        return $walink . '?phone=' . $phone . '&text=' . urlencode($message);
    }


    private function timeGreeting(): string
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
        return '<a href="' . $this->wa_url . '" type="button" target="_blank" class="btn btn-success btn-icon icon-left">
        <i class="fab fa-whatsapp"></i> ' . $this->wa . ' <span class="badge badge-transparent"></span>
    </a>';
    }

    public function getStatusLabelAttribute()
    {
        if ($this->status == '1') {
            return "<span class='badge badge-pill badge-success'>read</span>";
        }
        return "<span class='badge badge-pill badge-info text-white'>unread</span>";
    }
}
