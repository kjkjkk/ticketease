<?php

namespace App\Http\Controllers\Requestor;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class MyRequestController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $user_id = Auth::id();

        $tickets = Ticket::where('requestor_id', $user_id)
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                if ($fromDate <= $toDate) {
                    return $query->whereBetween('created_at', [$fromDate, $toDate]);
                }
            })
            ->with(['ticketNature', 'district', 'device', 'status'])
            ->orderBy('created_at', 'desc')
            ->paginate(4);

        if ($fromDate > $toDate) {
            Alert::warning("Wrong selected dates", "Choose the selected dates correctly");
            return redirect()->route('requestor.my-requests')->withInput(['fromDate' => null, 'toDate' => null]);
        }

        return view('pages.requestor.my-requests', compact('tickets'));
    }

    public function viewTicket($ticket_id)
    {
        $ticket = Ticket::findOrFail($ticket_id);
        return view('pages.requestor.view-ticket', compact('ticket'));
    }
}
