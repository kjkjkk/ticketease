<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::factory()->create([
            'firstname' => 'Pierce Steven',
            'lastname' => 'Pantanosas',
            'contact_number' => '0932-512-7126',
            'username' => 'Pantat555',
            'email' => 'p.pantanosas.526254@umindanao.edu.ph',
            'role' => 'Admin',
        ]);

        User::factory()->create([
            'firstname' => 'Kent Justin',
            'lastname' => 'Lacson',
            'contact_number' => '0932-512-7126',
            'username' => 'Kent12345',
            'email' => 'l.kentjustin.528847@umindanao.edu.ph',
            'role' => 'Technician',
        ]);

        User::factory()->create([
            'firstname' => 'James',
            'lastname' => 'Loayon',
            'contact_number' => '0932-512-7126',
            'username' => 'James999',
            'email' => 'j.loayon.524590@umindanao.edu.ph',
            'role' => 'Technician',
        ]);

        User::factory()->create([
            'firstname' => 'Gregory',
            'lastname' => 'House',
            'contact_number' => '0932-512-7126',
            'username' => 'Gregory123',
            'email' => 'gregoryhouse12@gmail.com',
            'role' => 'Technician',
        ]);
    }
}
