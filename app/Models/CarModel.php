<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $guarded = [];
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function brand()
    {
        return $this->belongsTo(CarBrand::class);
    }
}
