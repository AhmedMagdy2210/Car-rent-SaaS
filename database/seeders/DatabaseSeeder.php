<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CarBrandWithModelsSeeder::class,
            SystemRoleSeeder::class,
            SubscriptionPlanSeeder::class
        ]);
        User::create([
            'name' => 'Super Admin',
            'email' => 'super@test.com',
            'password' => 'password',

        ])->assignRole('super_admin');
    }
}
