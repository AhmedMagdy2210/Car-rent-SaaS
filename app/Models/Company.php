<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];

    protected $casts = [
        'database_settings' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean'
    ];

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
