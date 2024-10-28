<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\TicketAssign;
use App\Models\TicketComplete;
use App\Models\User;
use Carbon\Carbon;

class TicketSeeder extends Seeder
{
    public function generateTicketNumber(): string
    {
        $year = now()->format('y'); // Get the last two digits of the current year
        $count = Ticket::whereYear('created_at', now()->year)->count() + 1;
        return $year . str_pad($count, 4, '0', STR_PAD_LEFT); // Format as 240001, 240002, etc.
    }

    

    public function run()
    {
        $monthlyTickets = [
            '2023-01' => 144,
            '2023-02' => 132,
            '2023-03' => 99,
            '2023-04' => 118,
            '2023-05' => 150,
            '2023-06' => 127,
            '2023-07' => 114,
            '2023-08' => 74,
            '2023-09' => 121,
            '2023-10' => 92,
            '2023-11' => 117,
            '2023-12' => 134,
            '2024-01' => 68,
            '2024-02' => 135,
            '2024-03' => 131,
            '2024-04' => 77,
            '2024-05' => 117,
            '2024-06' => 52,
            '2024-07' => 118,
            '2024-08' => 89,
            '2024-09' => 118,
            '2024-10' => 89,
        ];

        $devices = [
            [
                'id' => 2,
                'type' => 'Desktop PC',
                'issues' => [
                    'Bluescreen' => 'Installed latest Windows updates.',
                    'Slow performance' => 'Performed disk cleanup and defragmentation.',
                    'Not booting' => 'Replaced faulty hard drive and restored OS.',
                    'Overheating' => 'Cleaned internal components and replaced thermal paste.',
                    'No display' => 'Replaced defective graphics card.'
                ]
            ],
            [
                'id' => 3,
                'type' => 'Laptop',
                'issues' => [
                    'Battery not charging' => 'Replaced faulty battery.',
                    'Slow boot-up' => 'Optimized startup processes and removed bloatware.',
                    'Wi-Fi not connecting' => 'Reinstalled Wi-Fi drivers and reset network settings.',
                    'Overheating' => 'Cleaned cooling system and applied thermal paste.',
                    'Screen flickering' => 'Replaced damaged screen cable.'
                ]
            ],
            [
                'id' => 4,
                'type' => 'Printer',
                'issues' => [
                    'Paper jams' => 'Cleared paper path and replaced worn rollers.',
                    'Faded printouts' => 'Replaced low toner or ink cartridges.',
                    'Not responding to print jobs' => 'Reinstalled printer drivers.',
                    'Print quality issues' => 'Performed printhead cleaning.',
                    'Connection issues' => 'Reconfigured wireless connection settings.'
                ]
            ],
            [
                'id' => 5,
                'type' => 'Scanner',
                'issues' => [
                    'Scanner not recognized' => 'Updated scanner drivers.',
                    'Lines on scanned images' => 'Cleaned the scanner glass.',
                    'Slow scanning' => 'Optimized scanner resolution settings.',
                    'Scanner button not working' => 'Reinstalled scanner utility software.',
                    'Document feeder malfunction' => 'Repaired or replaced document feeder parts.'
                ]
            ],
            [
                'id' => 6,
                'type' => 'Monitor',
                'issues' => [
                    'No power' => 'Replaced faulty power supply.',
                    'Flickering screen' => 'Updated monitor drivers and checked cables.',
                    'Dead pixels' => 'Replaced the monitor panel.',
                    'Distorted display' => 'Reconfigured display settings and resolutions.',
                    'Screen not detected' => 'Checked and replaced faulty HDMI or VGA cables.'
                ]
            ],
            [
                'id' => 7,
                'type' => 'Keyboard',
                'issues' => [
                    'Keys not responding' => 'Replaced malfunctioning keys or keyboard.',
                    'Sticky keys' => 'Cleaned the keyboard.',
                    'Key input lag' => 'Reinstalled keyboard drivers.',
                    'Keys typing incorrect characters' => 'Adjusted language settings.',
                    'Wireless keyboard not connecting' => 'Replaced the keyboard batteries or USB receiver.'
                ]
            ],
            [
                'id' => 8,
                'type' => 'Mouse',
                'issues' => [
                    'Cursor not moving' => 'Reinstalled mouse drivers or replaced the mouse.',
                    'Double-clicking issue' => 'Adjusted mouse settings or replaced faulty buttons.',
                    'Wireless mouse not connecting' => 'Replaced the mouse batteries or receiver.',
                    'Scroll wheel not working' => 'Repaired or replaced the scroll wheel mechanism.',
                    'Cursor movement erratic' => 'Cleaned the mouse sensor and surface.'
                ]
            ],
            [
                'id' => 9,
                'type' => 'Projector',
                'issues' => [
                    'No display' => 'Replaced damaged projector bulb.',
                    'Blurry image' => 'Adjusted focus and cleaned lens.',
                    'Projector overheating' => 'Cleaned air filters and ensured proper ventilation.',
                    'Remote control not working' => 'Replaced remote batteries or repaired remote sensor.',
                    'Input not recognized' => 'Checked and replaced faulty cables.'
                ]
            ],
            [
                'id' => 10,
                'type' => 'Router',
                'issues' => [
                    'Internet connection dropping' => 'Reconfigured network settings and updated firmware.',
                    'Router not powering on' => 'Replaced power adapter.',
                    'Slow internet speed' => 'Optimized channel settings and reset router.',
                    'Devices not connecting' => 'Reset the router and updated Wi-Fi settings.',
                    'Frequent disconnections' => 'Replaced faulty router hardware.'
                ]
            ],
            [
                'id' => 11,
                'type' => 'Switch',
                'issues' => [
                    'No network connection' => 'Replaced faulty switch port or device.',
                    'Port not responding' => 'Updated switch firmware and tested cables.',
                    'Slow network speed' => 'Optimized network configuration and QoS settings.',
                    'Switch overheating' => 'Cleaned internal components and ensured proper airflow.',
                    'Network loop detected' => 'Reconfigured network topology and prevented loops.'
                ]
            ],
            [
                'id' => 12,
                'type' => 'Modem',
                'issues' => [
                    'No internet' => 'Rebooted modem and reestablished connection with ISP.',
                    'Frequent disconnections' => 'Replaced faulty modem or cables.',
                    'Slow internet speed' => 'Updated modem firmware.',
                    'Modem overheating' => 'Ensured proper ventilation and cleaned air vents.',
                    'Modem not powering on' => 'Replaced power supply or modem unit.'
                ]
            ],
            [
                'id' => 13,
                'type' => 'Headset',
                'issues' => [
                    'No sound' => 'Reinstalled audio drivers or replaced headset.',
                    'Microphone not working' => 'Tested and replaced microphone or audio jack.',
                    'Static noise' => 'Replaced faulty headset cable or audio port.',
                    'Volume too low' => 'Adjusted audio settings and replaced ear cushions.',
                    'Headset not connecting' => 'Checked Bluetooth connection or replaced wired connection.'
                ]
            ],
            [
                'id' => 14,
                'type' => 'Speakers',
                'issues' => [
                    'No sound' => 'Replaced faulty speakers or reinstalled audio drivers.',
                    'Distorted sound' => 'Tested and replaced speaker cable or audio port.',
                    'Speaker not detected' => 'Checked and reconfigured sound settings.',
                    'Crackling sound' => 'Cleaned or replaced faulty audio jack or port.',
                    'Volume imbalance' => 'Recalibrated sound settings or replaced speaker.'
                ]
            ],
            [
                'id' => 15,
                'type' => 'Webcam',
                'issues' => [
                    'No video' => 'Reinstalled webcam drivers or replaced the webcam.',
                    'Poor image quality' => 'Adjusted lighting and cleaned the lens.',
                    'Webcam not detected' => 'Checked USB connection and reinstalled drivers.',
                    'Lagging video' => 'Reduced resolution settings for smoother streaming.',
                    'Microphone not working' => 'Reinstalled webcam software or replaced the microphone.'
                ]
            ],
            [
                'id' => 16,
                'type' => 'Docking Station',
                'issues' => [
                    'Not charging devices' => 'Replaced faulty charging port or adapter.',
                    'USB ports not working' => 'Reinstalled docking station drivers.',
                    'No display output' => 'Checked and replaced HDMI or VGA cables.',
                    'Overheating' => 'Cleaned docking station and improved airflow.',
                    'Device not recognized' => 'Updated firmware and reset connections.'
                ]
            ],
            [
                'id' => 17,
                'type' => 'Tablet',
                'issues' => [
                    'Touchscreen not responding' => 'Replaced or repaired the touchscreen.',
                    'Battery draining quickly' => 'Replaced battery or optimized power settings.',
                    'App crashes' => 'Updated software and cleared cache.',
                    'No sound' => 'Reinstalled audio drivers or replaced speakers.',
                    'Tablet not charging' => 'Replaced charging port or cable.'
                ]
            ],
            [
                'id' => 18,
                'type' => 'Smartphone',
                'issues' => [
                    'Battery not charging' => 'Replaced faulty charging port or battery.',
                    'Screen not responding' => 'Replaced damaged screen.',
                    'Wi-Fi not connecting' => 'Reset network settings or replaced Wi-Fi module.',
                    'Phone overheating' => 'Cleaned internal components and applied thermal solutions.',
                    'Apps crashing' => 'Cleared cache or updated operating system.'
                ]
            ],
            [
                'id' => 19,
                'type' => 'Virtual Reality Headset',
                'issues' => [
                    'No display' => 'Reinstalled VR drivers or checked HDMI/USB connections.',
                    'Tracking issues' => 'Calibrated sensors and updated software.',
                    'Headset not powering on' => 'Replaced power adapter or cable.',
                    'Poor image quality' => 'Adjusted resolution settings or cleaned lenses.',
                    'Controllers not connecting' => 'Replaced batteries or reconnected controllers.'
                ]
            ],
            [
                'id' => 20,
                'type' => 'Fax Machine',
                'issues' => [
                    'Paper jams' => 'Cleared jam and replaced worn-out rollers.',
                    'Fax not sending or receiving' => 'Checked phone line connection and settings.',
                    'Poor print quality' => 'Replaced toner or cleaned print head.',
                    'Frequent errors' => 'Reset machine and updated firmware.',
                    'No power' => 'Replaced faulty power supply or fuse.'
                ]
            ],
            [
                'id' => 21,
                'type' => 'Smart TV',
                'issues' => [
                    'No picture' => 'Replaced faulty backlight or display panel.',
                    'No sound' => 'Reinstalled firmware or checked speaker connections.',
                    'Apps not loading' => 'Updated Smart TV firmware or reinstalled apps.',
                    'Remote not working' => 'Replaced remote batteries or repaired remote sensor.',
                    'TV not connecting to Wi-Fi' => 'Reset network settings and updated firmware.'
                ]
            ],
            [
                'id' => 22,
                'type' => 'External Hard Drive',
                'issues' => [
                    'Not recognized by computer' => 'Reinstalled drivers or replaced USB cable.',
                    'Data corruption' => 'Ran disk repair tools and restored backup data.',
                    'Slow transfer speeds' => 'Replaced USB cable or tested on different ports.',
                    'Overheating' => 'Improved ventilation or replaced external case.',
                    'No power' => 'Replaced faulty power adapter or cable.'
                ]
            ]
        ];


        $departments = [
            'HR',
            'Finance',
            'Marketing',
            'Admin',
            'Sales',
            'Operations',
            'Customer Support',
            'Public Health',
            'Environmental Health',
            'Clinical Services',
            'Epidemiology',
            'Health Education',
            'Community Outreach',
            'Infection Control',
            'Data Management',
            'Emergency Preparedness',
            'Policy and Planning',
            'Laboratory Services',
            'Nutritional Services',
            'Mental Health Services',
        ];

        // Retrieve users based on roles
        $requestors = User::where('role', 'Requestor')->get();
        $technicians = User::whereIn('role', ['Technician', 'Admin'])->get();

        foreach ($monthlyTickets as $month => $count) {
            for ($i = 0; $i < $count; $i++) {
                // Randomize ticket creation date within the month
                $createdDate = Carbon::parse($month)->startOfMonth()->addDays(rand(0, 27));

                // Step 1: Randomly select a device
                $randomDevice = $devices[array_rand($devices)];

                // Step 2: Randomly select one issue from the device's issues
                $issues = $randomDevice['issues'];
                $randomIssueKey = array_rand($issues); // Gets the random issue key (e.g., 'Bluescreen', 'Slow performance')
                $randomIssueDescription = $issues[$randomIssueKey];
                // Create a ticket
                $ticket = Ticket::create([
                    'requestor_id' => $requestors->random()->id,
                    'ticket_nature_id' => rand(1, 5),
                    'district_id' => rand(1, 19),
                    'department' => $departments[array_rand($departments)],
                    'device_id' => $randomDevice['id'], // Use the device ID from your array
                    'brand' => 'N/A',
                    'model' => 'N/A',
                    'property_no' => 'PROP' . rand(100, 999),
                    'serial_no' => 'SN' . rand(100, 999),
                    'details' => 'Need help, ',
                    'status_id' => 10,
                    'created_at' => $createdDate,
                    'updated_at' => $createdDate,
                ]);

                // Add gap between ticket creation and assignment (e.g., 1 to 3 days later)
                $assignDate = (clone $createdDate)->addDays(rand(1, 2));

                // Assign the ticket to a technician
                $ticketAssign = TicketAssign::create([
                    'ticket_id' => $ticket->id,
                    'technician_id' => $technicians->random()->id,
                    'date_assigned' => $assignDate,
                    'if_priority' => 0,
                    'assigned_by' => 1, // Assigner can be another technician
                    'issue_found' => $randomIssueKey, // Assign the selected issue
                    'service_rendered' => $randomIssueDescription, // Assign the selected service
                    'service_status' => 'Completed',
                    'if_scheduled' => rand(0, 1),
                    'created_at' => $assignDate,
                    'updated_at' => $assignDate,
                ]);

                // Add a gap between assignment and completion (e.g., 1 to 7 days later)
                $completeDate = (clone $assignDate)->addDays(rand(1, 7));

                TicketComplete::create([
                    'ticket_assign_id' => $ticketAssign->id,
                    'created_at' => $completeDate,
                    'updated_at' => $completeDate,
                ]);
            }
        }
    }
}
