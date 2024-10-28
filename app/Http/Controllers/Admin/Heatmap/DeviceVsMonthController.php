<?php

namespace App\Http\Controllers\Admin\Heatmap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\HeatmapData;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class DeviceVsMonthController extends Controller
{

    public function index(Request $request)
    {
        $selected_devices = $request->devices;
        $selected_months = $request->months;
        $selectedYear = $request->year;

        if (empty($selected_months)) {
            Alert::warning("Warning", "The months field are empty, please select at least one.");
            return redirect()->back();
        } else if (empty($selected_devices)) {
            Alert::warning("Warning", "The devices field are empty, please select at least one.");
            return redirect()->back();
        }

        $heatmap = new HeatmapData();
        $data = $heatmap->getDeviceMonthlyTickets($selected_devices, $selected_months, $selectedYear);
        // dd($data);
        return view('pages.admin.heatmap.device-vs-month', compact('data', 'selectedYear'));
    }

    public function device_vs_month($device, $month, $year)
    {
        $monthNumber = date('n', strtotime($month));

        $data = Ticket::join('devices', 'tickets.device_id', '=', 'devices.id')
            ->select('ticket_nature_id', DB::raw('COUNT(*) as count'))
            ->where('device_name', '=', $device)
            ->whereRaw('MONTH(tickets.created_at) = ?', [$monthNumber])
            ->whereRaw('YEAR(tickets.created_at) = ?', [$year])
            ->groupBy('ticket_nature_id')
            ->get();

        // Get the total count of tickets for the device, month, and year
        $totalTickets = Ticket::join('devices', 'tickets.device_id', '=', 'devices.id')
            ->where('device_name', '=', $device)
            ->whereRaw('MONTH(tickets.created_at) = ?', [$monthNumber])
            ->whereRaw('YEAR(tickets.created_at) = ?', [$year])
            ->count();

        // Calculate percentage for each nature of ticket
        $dataWithPercentage = $data->map(function ($item) use ($totalTickets) {
            $item->percentage = round(($item->count / $totalTickets) * 100, 2);
            return $item;
        });

        $techData = Ticket::join('ticket_assigns', 'tickets.id', '=', 'ticket_assigns.ticket_id')
            ->join('devices', 'tickets.device_id', '=', 'devices.id')
            ->join('users', 'users.id', '=', 'ticket_assigns.technician_id')
            ->select(
                'lastname',
                'technician_id',
                DB::raw('COUNT(*) as count')
            )
            ->where('device_name', '=', $device)
            ->whereRaw('MONTH(tickets.created_at) = ?', [$monthNumber])
            ->whereRaw('YEAR(tickets.created_at) = ?', [$year])
            ->groupBy('technician_id', 'lastname')
            ->get();

        return view(
            'pages.admin.heatmap.drilldown.device_vs_month',
            [
                'device' => $device,
                'month' => $month,
                'year' => $year,
                'data' => $dataWithPercentage,
                'totalTickets' => $totalTickets,
                'techData' => $techData,
            ]
        );
    }
}
