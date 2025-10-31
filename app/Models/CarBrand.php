<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    protected $guarded = [];
    protected $casts = [
        'is_active' => 'boolean'
    ];
    public function models(){
        return $this->hasMany(CarModel::class);
    }
    
}
