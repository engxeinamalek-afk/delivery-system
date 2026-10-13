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

        User::factory()->count(50)->create([
            'role' => 'customer'
        ]);

        User::factory()->count(20)->create([
            'role' => 'driver'
        ]);

        $this->call([
            StoreSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
