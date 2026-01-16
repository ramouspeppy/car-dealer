<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;

class Profile extends Model implements HasMedia, Viewable
{
    use HasFactory, InteractsWithMedia, InteractsWithViews;
    protected $guarded = ['id'];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('image')
            ->singleFile();
    }

    public function getExperienceNumberAttribute()
    {
        // Ambil hanya angka dari string, misalnya "10" dari "10+ tahun pengalaman"
        preg_match('/\d+/', $this->experience, $matches);

        return $matches[0] ?? null;
    }
    public function getProjectNumberAttribute()
    {
        // Ambil hanya angka dari string, misalnya "10" dari "10+ tahun pengalaman"
        preg_match('/\d+/', $this->project, $matches);

        return $matches[0] ?? null;
    }
    public function getClientNumberAttribute()
    {
        // Ambil hanya angka dari string, misalnya "10" dari "10+ tahun pengalaman"
        preg_match('/\d+/', $this->client, $matches);

        return $matches[0] ?? null;
    }

    public function getImageUrlAttribute($value)
    {
        return $this->getFirstMediaUrl('image');
    }

    public function getWaFormattedAttribute($value)
    {
        $p =  preg_replace("~\D~", "", $this->wa);
        return preg_replace("/^0/", '62', $p, 1);
    }

    public function getPhoneFormattedAttribute($value)
    {
        $p =  preg_replace("~\D~", "", $this->phone);
        return preg_replace("/^62/", '0', $p, 1);
    }

    public function getFirstNameAttribute()
    {
        $parts = Str::of($this->name)->explode(' ');
        return $parts->first();
    }

    // Accessor untuk sisa kata
    public function getLastNameAttribute()
    {
        $parts = Str::of($this->name)->explode(' ');
        return $parts->skip(1)->implode(' ');
    }

    public function getPhoneUrlAttribute()
    {

        return "tel:" . $this->PhoneFormatted;
    }

    public function getWaUrlAttribute()
    {
        $name = $this->name;

        // Ambil greetings (bisa string dari db atau array dari config)
        $greetings = $this->wa_message ?: config('whatsapp.greetings');

        // Kalau hasilnya string → jadikan array supaya konsisten
        if (is_string($greetings)) {
            $greetings = [$greetings];
        }

        // Ambil random salah satu greeting
        $greeting = $greetings[array_rand($greetings)];

        // // Replace {name}
        // $greeting = str_replace('{name}', $nama, $greeting);

        // // Salam berdasarkan jam
        // $timeGreeting = $this->timeGreeting();

        // // Ganti {name} dengan nama company/admin
        // $name = $this->name ?? 'Admin';
        // $greeting = str_replace('{name}', $name, $greeting);

        // return $timeGreeting . ', ' . $greeting;

        // 3) Pilih satu lalu replace placeholder + salam waktu
        $chosen  = $greetings[array_rand($greetings)];
        $message = $this->timeGreeting() . ' ' . str_replace('{name}', $name, $chosen);

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
}
