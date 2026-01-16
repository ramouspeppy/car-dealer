<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    // Assesor ======================================================

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
    public function setStatusAttribute($value)
    {
        if ($value == 'active') {
            return $this->attributes['status'] = 1;
        } else {
            return $this->attributes['status'] = 0;
        }
    }
}
