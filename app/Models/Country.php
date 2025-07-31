<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_code',
        'country_name',
        'is_default',
    ];

    protected $casts = ['is_default' => 'boolean'];

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'country_brand')
            ->withPivot('position')
            ->orderBy('position')
            ->withTimestamps();
    }
}
