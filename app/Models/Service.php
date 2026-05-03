<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function promoNameLimit($limit = 5)
    {
        return Str::words($this->promo, $limit);
    }

    public function scopePriority($query)
    {
        return $query->orderByRaw('ISNULL(priority), priority ASC');
    }
}
