<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'vendor_id' => '1',
        ]);

        Vendor::insert([
            'name' => 'Test Vendor',
        ]);

        DB::table('user_vendor')->insert([
            'user_id' => 1,
            'vendor_id' => 1,
        ]);
    }
}
