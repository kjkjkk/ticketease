<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\District;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            'CHO main',
            'District A',
            'District B',
            'District C',
            'District D',
            'Toril A',
            'Toril B',
            'Talomo South',
            'Talomo North',
            'Talomo Central',
            'Calinan Health Center (HC)',
            'Baguio HC',
            'Sta. Ana HC',
            'Buhangin HC',
            'Paquibato HC',
            'Bunawan HC',
            'Tibungco HC',
            'Agdao HC',
            'Reproductive Health and Wellness Center (RHWC)',
        ];

        foreach ($districts as $district) {
            District::create(['district_name' => $district, 'status' => true]);
        }
    }
}
