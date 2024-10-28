<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketNature;
use Illuminate\Http\Request;
use App\Models\Audit;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $ticketQuery = Ticket::query()
            ->whereIn('status_id', [5, 9, 10])
            ->orderBy('id', 'DESC');

        $ticketNatures = TicketNature::where('status', 1)->get();
        $technicians = User::whereIn('role', ['Admin', 'Technician'])->get();
        $this->applyFilters($request, $ticketQuery);
        $tickets = $ticketQuery->paginate(10)->appends($request->all());

        return view('pages.admin.history', compact('tickets', 'ticketNatures', 'technicians'));
    }

    private function applyFilters(Request $request, $query)
    {
        if ($request->filled('technician_id')) {
            $this->filterByTechnician($request->input('technician_id'), $query);
        }

        if ($request->filled('ticket_nature_name')) {
            $this->filterByTicketNature($request->input('ticket_nature_name'), $query);
        }

        if ($request->filled('searchUser')) {
            $this->searchByRequestor($request->input('searchUser'), $query);
        }

        if ($request->filled('searchID')) {
            $this->searchByTicketID($request->input('searchID'), $query);
        }
    }

    private function searchByTicketID(string $ticket_id, $query)
    {
        $query->where('id', '=', $ticket_id);
    }

    // Filter by reqyestir search
    private function searchByRequestor(string $searchTerm, $query)
    {
        $query->whereHas('requestor', function ($query) use ($searchTerm) {
            $query->where('firstname', 'like', "%{$searchTerm}%")
                ->orWhere('lastname', 'like', "%{$searchTerm}%");
        });
    }

    // Filter by ticket nature
    private function filterByTicketNature(string $ticketNatureName, $query)
    {
        $query->whereHas('ticketNature', function ($query) use ($ticketNatureName) {
            $query->where('ticket_nature_name', $ticketNatureName);
        });
    }

    // Filter by technician
    private function filterByTechnician(string $technician_id, $query)
    {
        $query->whereHas('ticketAssign', function ($query) use ($technician_id) {
            $query->where('technician_id', 'like', "%{$technician_id}%");
        });
    }
}
