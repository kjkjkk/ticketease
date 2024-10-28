<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MonthlyReport;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        $authUser = Auth::user();

        // Fetch all technicians and admin
        $technicians = User::query()
            ->whereIn('role', ['Admin', 'Technician'])
            ->where('user_status', 'Active')
            ->get()
            ->map(function ($technician) use ($authUser) {
                // Append (You) to the authenticated admin
                if ($technician->id === $authUser->id) {
                    $technician->lastname .= ' (You)';
                }
                return $technician;
            });

        $currentMonth = date('Y-m');

        $tickets = Ticket::query()->where('status_id', 1)->get();

        $popularDay = $this->getMostPopularDay();
        $popularTicketNature = $this->getMostPopularTicketNature();
        $popularDistrict = $this->getMostPopularDistrict();
        $popularDevice = $this->getMostRepairedDevices();

        return view(
            'pages.admin.dashboard',
            compact(
                'technicians',
                'currentMonth',
                'tickets',
                'popularDay',
                'popularTicketNature',
                'popularDistrict',
                'popularDevice',

            )
        );
    }

    public function exportMonthlyReport(Request $request)
    {
        if ($request->selectedMonth == null) {
            Alert::warning("Failed generating report", "Please select a month first.");
            return redirect()->back();
        }

        $date = $request->selectedMonth;
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $fileName =  "MonthlyReport_(" . date('F Y', mktime(0, 0, 0, $month, 10, $year)) . ").xlsx";
        $password = $request->input('sheetPassword');
        return Excel::download(new MonthlyReport($year, $month, $password), $fileName);
    }

    private function getMostPopularDay()
    {
        $mostCreatedWeekday = Ticket::selectRaw('DAYNAME(created_at) as day')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('day')
            ->orderBy('count', 'DESC')
            ->limit(1)
            ->first();

        return $mostCreatedWeekday;
    }

    private function getMostPopularTicketNature()
    {
        $mostPopularTicketNature = Ticket::join('ticket_natures', 'tickets.ticket_nature_id', '=', 'ticket_natures.id')
            ->selectRaw('ticket_natures.ticket_nature_name')
            ->selectRaw('COUNT(tickets.ticket_nature_id) as count')
            ->groupBy('ticket_natures.ticket_nature_name')
            ->orderBy('count', 'DESC')
            ->limit(1)
            ->first();

        return $mostPopularTicketNature;
    }

    private function getMostPopularDistrict()
    {
        $mostPopularDistrict = Ticket::join('districts', 'tickets.district_id', '=', 'districts.id')
            ->selectRaw('districts.district_name')
            ->selectRaw('COUNT(tickets.district_id) as count')
            ->groupBy('districts.district_name')
            ->orderBy('count', 'DESC')
            ->limit(1)
            ->first();

        return $mostPopularDistrict;
    }

    private function getMostRepairedDevices()
    {
        $mostRepairedDevice = Ticket::join('devices', 'tickets.device_id', '=', 'devices.id')
            ->selectRaw('devices.device_name')
            ->selectRaw('COUNT(tickets.device_id) as count')
            ->groupBy('devices.device_name')
            ->orderBy('count', 'DESC')
            ->limit(1)
            ->first();

        return $mostRepairedDevice;
    }
}
