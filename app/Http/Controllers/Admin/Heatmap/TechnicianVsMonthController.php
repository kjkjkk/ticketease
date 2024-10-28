<?php

namespace App\Http\Controllers\Admin\Heatmap;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketAssign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\HeatmapData;
use RealRashid\SweetAlert\Facades\Alert;

class TechnicianVsMonthController extends Controller
{
    public function index(Request $request)
    {
        $selected_technicians = $request->technicians;
        $selected_months = $request->months;
        $selectedYear = $request->year;

        if (empty($selected_months)) {
            Alert::warning("Warning", "The months field are empty, please select at least one.");
            return redirect()->back();
        } else if (empty($selected_technicians)) {
            Alert::warning("Warning", "The technicians field are empty, please select at least one.");
            return redirect()->back();
        }
        $heatmap = new HeatmapData();
        $data = $heatmap->getTechnicianMonthlyTickets($selected_technicians, $selected_months, $selectedYear);

        return view('pages.admin.heatmap.technician-vs-month', compact('data', 'selectedYear'));
    }

    public function technician_vs_month($technician, $month, $year)
    {
        // Convert the month name to a number (1-12)
        $monthNumber = date('n', strtotime($month));
        // Get all tickets grouped by their technician
        $data = TicketAssign::join('users', 'ticket_assigns.technician_id', '=', 'users.id')
            ->join('tickets', 'ticket_assigns.ticket_id', '=', 'tickets.id')
            ->join('ticket_natures', 'ticket_natures.id', '=', 'tickets.ticket_nature_id')
            ->select('ticket_nature_id', 'ticket_nature_name',  DB::raw('COUNT(*) as count'))
            ->where('lastname', '=', $technician)
            ->whereRaw('MONTH(tickets.created_at) = ?', [$monthNumber])
            ->whereRaw('YEAR(tickets.created_at) = ?', [$year])
            ->groupBy('ticket_nature_id')
            ->get();

        // Get the total count of tickets for the technician, month, and year
        $totalTickets = TicketAssign::join('users', 'ticket_assigns.technician_id', '=', 'users.id')
            ->where('lastname', '=', $technician)
            ->whereRaw('MONTH(ticket_assigns.created_at) = ?', [$monthNumber])
            ->whereRaw('YEAR(ticket_assigns.created_at) = ?', [$year])
            ->count();

        // Calculate percentage for each nature of ticket
        $dataWithPercentage = $data->map(function ($item) use ($totalTickets) {
            $item->percentage = round(($item->count / $totalTickets) * 100, 2);
            return $item;
        });

        $districtData = Ticket::join('ticket_assigns', 'tickets.id', '=', 'ticket_assigns.ticket_id')
            ->join('districts', 'tickets.district_id', '=', 'districts.id')
            ->join('users', 'users.id', '=', 'ticket_assigns.technician_id')
            ->select('district_name', 'district_id', DB::raw('COUNT(*) as count'))
            ->where('lastname', '=', $technician)
            ->whereRaw('MONTH(tickets.created_at) = ?', [$monthNumber])
            ->whereRaw('YEAR(tickets.created_at) = ?', [$year])
            ->groupBy('district_name', 'district_id')
            ->get();

        return view(
            'pages.admin.heatmap.drilldown.technician_vs_month',
            [
                'technician' => $technician,
                'month' => $month,
                'year' => $year,
                'data' => $dataWithPercentage,
                'totalTickets' => $totalTickets,
                'districtData' => $districtData,
            ]
        );
    }
}
