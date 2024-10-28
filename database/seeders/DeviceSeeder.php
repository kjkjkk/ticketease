<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Device;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $devices = [
            'N/A',
            'Desktop PC',
            'Laptop',
            'Printer',
            'Scanner',
            'Monitor',
            'Keyboard',
            'Mouse',
            'Projector',
            'Router',
            'Switch',
            'Modem',
            'Headset',
            'Speakers',
            'Webcam',
            'Docking Station',
            'Tablet',
            'Smartphone',
            'Virtual Reality Headset',
            'Fax Machine',
            'Smart TV',
            'External Hard Drive',
            'Network Attached Storage (NAS)',
            'UPS (Uninterruptible Power Supply)',
            'Whiteboard',
            'Digital Signage Display',
        ];


        foreach ($devices as $device) {
            Device::create(['device_name' => $device, 'status' => true]);
        }
    }
}
