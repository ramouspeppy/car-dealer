<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // scope
    public function scopeActive($query)
    {
        return $query->where("status", "1")->orderBy('price', 'asc');
    }

    // Assesor ======================================================
    public function getPriceFormattedAttribute($value)
    {
        return "Rp. " . number_format($this->price);
    }
    public function getStatusLabelAttribute()
    {
        if ($this->status == "active") {
            return '<span class="badge badge-pill badge-success">active</span>';
        } else {
            return '<span class="badge badge-pill badge-danger">non active</span>';
        }
    }
    public function getStatusAttribute($value)
    {
        if ($value == '1') {
            return 'active';
        } elseif ($value == '0') {
            return 'non active';
        } else {
            return null;
        }
    }
    // Mutator ======================================================
    public function setPriceAttribute($value)
    {
        return $this->attributes['price'] = str_replace('.', '', $value);
    }
    public function setStatusAttribute($value)
    {
        if ($value == 'active') {
            return $this->attributes['status'] = 1;
        } else {
            return $this->attributes['status'] = 0;
        }
    }
}
