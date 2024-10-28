<?php

namespace App\Http\Controllers\Admin\Heatmap;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\HeatmapData;
use RealRashid\SweetAlert\Facades\Alert;

class DistrictVsMonthController extends Controller
{
    public function index(Request $request)
    {
        $selected_districts = $request->districts;
        $selected_months = $request->months;
        $selectedYear = $request->year;

        if (empty($selected_months)) {
            Alert::warning("Warning", "The months field are empty, please select at least one.");
            return redirect()->back();
        } else if (empty($selected_districts)) {
            Alert::warning("Warning", "The districts field are empty, please select at least one.");
            return redirect()->back();
        }

        $heatmap = new HeatmapData();
        $data = $heatmap->getDistrictMonthlyTickets($selected_districts, $selected_months, $selectedYear);

        return view('pages.admin.heatmap.district-vs-month', compact('data', 'selectedYear'));
    }

    public function district_vs_month($district, $month, $year)
    {
        // Convert the month name to a number (1-12)
        $monthNumber = date('n', strtotime($month));

        // Get all tickets grouped by their nature
        $data = Ticket::join('districts', 'tickets.district_id', '=', 'districts.id')
            ->select('ticket_nature_id', DB::raw('COUNT(*) as count'))
            ->where('district_name', '=', $district)
            ->whereRaw('MONTH(tickets.created_at) = ?', [$monthNumber])
            ->whereRaw('YEAR(tickets.created_at) = ?', [$year])
            ->groupBy('ticket_nature_id')
            ->get();

        // Get the total count of tickets for the district, month, and year
        $totalTickets = Ticket::join('districts', 'tickets.district_id', '=', 'districts.id')
            ->where('district_name', '=', $district)
            ->whereRaw('MONTH(tickets.created_at) = ?', [$monthNumber])
            ->whereRaw('YEAR(tickets.created_at) = ?', [$year])
            ->count();

        // Calculate percentage for each nature of ticket
        $dataWithPercentage = $data->map(function ($item) use ($totalTickets) {
            $item->percentage = round(($item->count / $totalTickets) * 100, 2);
            return $item;
        });

        $techData = Ticket::join('ticket_assigns', 'tickets.id', '=', 'ticket_assigns.ticket_id')
            ->join('districts', 'tickets.district_id', '=', 'districts.id')
            ->join('users', 'users.id', '=', 'ticket_assigns.technician_id')
            ->select(
                'lastname',
                'technician_id',
                DB::raw('COUNT(*) as count')
            )
            ->where('district_name', '=', $district)
            ->whereRaw('MONTH(tickets.created_at) = ?', [$monthNumber])
            ->whereRaw('YEAR(tickets.created_at) = ?', [$year])
            ->groupBy('technician_id', 'lastname')
            ->get();


        // Return the data to the view
        return view('pages.admin.heatmap.drilldown.district_vs_month', [
            'district' => $district,
            'month' => $month,
            'year' => $year,
            'data' => $dataWithPercentage,
            'totalTickets' => $totalTickets,
            'techData' => $techData,
        ]);
    }
}
