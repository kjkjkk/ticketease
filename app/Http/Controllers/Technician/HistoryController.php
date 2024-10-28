<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketNature;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $ticketQuery = Ticket::query()
            ->whereIn('status_id', [5, 9, 10])
            ->whereHas('ticketAssign', function ($query) {
                $query->where('technician_id', Auth::id());  // Filter by the authenticated technician's ID
            })
            ->orderBy('id', 'DESC');

        $ticketNatures = TicketNature::where('status', 1)->get();

        $this->applyFilters($request, $ticketQuery);
        $tickets = $ticketQuery->paginate(10)->appends($request->all());

        return view('pages.technician.history', compact('tickets', 'ticketNatures'));
    }

    private function applyFilters(Request $request, $query)
    {
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
}
