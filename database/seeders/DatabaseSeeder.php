<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        User::factory(28)->create();
        $this->call([
            StatusSeeder::class,
            DistrictSeeder::class,
            TicketNatureSeeder::class,
            DeviceSeeder::class,
            TicketSeeder::class,
        ]);
    }
}
