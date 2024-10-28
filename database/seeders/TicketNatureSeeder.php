<?php

namespace Database\Seeders;

use App\Models\TicketNature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketNatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ticket_natures = [
            'Hardware Repair',
            'Software',
            'Network',
            'Maintenance',
            'Technical Assistance',
        ];

        foreach ($ticket_natures as $nature) {
            TicketNature::create(['ticket_nature_name' => $nature]);
        }
    }
}
