<?php

namespace App\Http\Controllers\Requestor;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketStoreRequest;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\District;
use App\Models\Ticket;
use App\Models\TicketNature;
use Illuminate\Http\RedirectResponse;
use RealRashid\SweetAlert\Facades\Alert;


class CreateTicketController extends Controller
{
    public function index()
    {
        $districts = District::where('status', 1)->get();
        $devices = Device::where('status', 1)->get();
        $ticketNatures = TicketNature::where('status', 1)->get();
        return view('pages.requestor.create-ticket',  compact('districts', 'devices', 'ticketNatures'));
    }

    public function resetTicket(Request $request)
    {
        // Clear the old input data from the session
        $request->session()->forget('_old_input');

        // Redirect back to the form page
        return redirect()->route('requestor.create-ticket.form'); // Adjust this route to the form page
    }
}
