<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_name',
        'brand_image',
        'rating',
    ];

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'country_brand')
            ->withPivot('position')
            ->withTimestamps();
    }
}
