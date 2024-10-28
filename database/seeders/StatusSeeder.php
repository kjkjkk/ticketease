<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'Unassigned',
            'Assigned',
            'In Progress',
            'Repaired',
            'For Waste',
            'To CITC',
            'For Release',
            'Cancelled',
            'Invalid',
            'Closed'
        ];

        foreach ($statuses as $status) {
            Status::create(['status_name' => $status]);
        }
    }
}
