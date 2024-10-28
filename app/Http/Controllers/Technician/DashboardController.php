<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $technician = Auth::id();
        $user = Auth::user();

        if (is_null($user->email) || is_null($user->contact_number)) {
            return redirect()->route('profile-setup'); 
        } else {
            $years =  Ticket::selectRaw('YEAR(created_at) as year')
                ->groupBy('year')
                ->pluck('year');

            $currentMonth = date('Y-m');

            $tickets = Ticket::join('ticket_assigns', 'tickets.id', '=', 'ticket_assigns.ticket_id')
                ->whereIn('status_id', [2, 3, 4, 6, 7])
                ->where('ticket_assigns.technician_id', '=', $technician)
                ->orderBy('tickets.id')
                ->get();

            // $unresolvedTickets = Ticket::join('ticket_assigns', 'tickets.id', '=', 'ticket_assigns.ticket_id')
            //     ->whereIn('status_id', [ 2, 3, 4, 6, 7])
            //     ->where('ticket_assigns.technician_id', '=', $technician)
            //     ->orderBy('tickets.id')
            //     ->get();

            return view('pages.technician.dashboard', compact('years', 'currentMonth', 'tickets'));
        }         
    }
}
