<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubscriptionPlan::create([
            'name' => 'Basic',
            'description' => 'This is the basic plan',
            'tier' => 'basic',
            'price_monthly' => 250,
            'price_yearly' => 2500,
            'currency' => 'EGP',
            'features' => [
                'max_users' => 5, // Staff
                'max_cars' => 30,
                'email_support' => true,
            ],
            'limits' => [
                'storage_gb' => 5
            ],
            'is_active' => true,
            'is_default' => true,
        ]);
        SubscriptionPlan::create([
            'name' => 'Medium',
            'description' => 'This is the medium plan',
            'tier' => 'premium',
            'price_monthly' => 300,
            'price_yearly' => 3000,
            'currency' => 'EGP',
            'features' => [
                'max_users' => 10, // Staff
                'max_cars' => 70,
                'email_support' => true,
                'phone_support' => true,
            ],
            'limits' => [
                'storage_gb' => 10
            ],
            'is_active' => true,
            'is_default' => true,
        ]);
        SubscriptionPlan::create([
            'name' => 'Large',
            'description' => 'This is the Large plan',
            'tier' => 'enterprise',
            'price_monthly' => 500,
            'price_yearly' => 5000,
            'currency' => 'EGP',
            'features' => [
                'max_users' => 50, // Staff
                'max_cars' => 600,
                'email_support' => true,
                'phone_support' => true,
                'custom_domain' => true,

            ],
            'limits' => [
                'storage_gb' => 100
            ],
            'is_active' => true,
            'is_default' => true,
        ]);
    }
}
