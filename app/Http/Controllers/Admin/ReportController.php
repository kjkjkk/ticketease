<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketNature;
use App\Models\Device;
use App\Models\District;
use App\Exports\CustomReport;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class ReportController extends Controller
{
    public function index()
    {
        $districts = District::all();
        $devices = Device::all();
        $ticketNatures = TicketNature::all();
        $statuses = Status::whereIn('id', [5, 10])->get();

        $columns = [
            ['column' => 'TICKET ID', 'db_column' => 'tickets.id'],
            ['column' => 'REQUESTOR NAME', 'db_column' => 'CONCAT(requestor.firstname, " ", requestor.lastname)'],
            ['column' => 'DISTRICT', 'db_column' => 'districts.district_name'],
            ['column' => 'DEPARTMENT', 'db_column' => 'tickets.department'],
            ['column' => 'TICKET NATURE', 'db_column' => 'ticket_natures.ticket_nature_name'],
            ['column' => 'DEVICE', 'db_column' => 'devices.device_name'],
            ['column' => 'BRAND', 'db_column' => 'tickets.brand'],
            ['column' => 'MODEL', 'db_column' => 'tickets.model'],
            ['column' => 'SERVICE BY', 'db_column' => 'CONCAT(technician.firstname, " ", technician.lastname)'],
            ['column' => 'SERVICE RENDERED', 'db_column' => 'ticket_assigns.service_rendered'],
            ['column' => 'ISSUE FOUND', 'db_column' => 'ticket_assigns.issue_found'],
            ['column' => 'DATE SUBMITTED', 'db_column' => 'tickets.created_at as date_submitted'],
            ['column' => 'DATE CLOSED', 'db_column' => 'ticket_completes.created_at as date_closed'],
            ['column' => 'STATUS', 'db_column' => 'statuses.status_name'],
        ];
        return view('pages.admin.reports', compact('ticketNatures', 'districts', 'devices', 'columns', 'statuses'));
    }

    public function export(Request $request)
    {
        // Get selected columns
        $columns = $request->input('columns', []);

        // Get selected filters
        $ticketNatures = $request->input('ticket_nature', []);
        $districts = $request->input('district', []);
        $statuses = $request->input('status', []);

        // Get the date range
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $password = $request->input('sheetPassword');
        if (empty($columns)) {
            Alert::warning("Warning", "Please select at least one column for the report.");
            return redirect()->back();
        }

        if (empty($ticketNatures) || empty($districts) || empty($statuses)) {
            Alert::warning('Warning', 'Filters should have at least one selected filter.');
            return redirect()->back();
        }
        if ($dateFrom > $dateTo) {
            Alert::warning('Warning', 'Date To must not be less than Date From.');
            return redirect()->back();
        }



        $reportName = "(" . Carbon::parse($dateFrom)->format('F j, Y') . " - " . Carbon::parse($dateTo)->format('F j, Y') . ")";

        return Excel::download(new CustomReport($columns, $ticketNatures, $districts, $dateFrom, $dateTo, $password), $reportName . '.xlsx');
        //return Excel::download(new CustomReport($columns, $ticketNatures, $districts, $dateFrom, $dateTo), $reportName . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);;
        // return Excel::download(new CustomReport($columns, $ticketNatures, $districts, $dateFrom, $dateTo), $reportName . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
