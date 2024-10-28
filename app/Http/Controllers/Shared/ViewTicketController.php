<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\Audit;
use Illuminate\Support\Facades\DB;

class ViewTicketController extends Controller
{
    public function index(Request $request)
    {
        $ticket = Ticket::findOrFail($request->id);
        $ticketAuditLogs = Audit::where('ticket_id', $ticket->id)->get();
        $previousRoute = $request->route;
        return view('pages.shared.view-ticket', compact('ticket', 'previousRoute', 'ticketAuditLogs'));
    }
}
