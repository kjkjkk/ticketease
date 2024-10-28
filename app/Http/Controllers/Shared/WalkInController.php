<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;

use App\Http\Requests\TicketStoreRequest;
use App\Models\Device;
use App\Models\District;
use App\Models\Ticket;
use App\Models\TicketNature;
use Illuminate\Http\RedirectResponse;
use RealRashid\SweetAlert\Facades\Alert;

class WalkInController extends Controller
{
    public function index()
    {
        $districts = District::where('status', 1)->get();
        $devices = Device::where('status', 1)->get();
        $ticketNatures = TicketNature::where('status', 1)->get();
        return view('pages.shared.walk-in',  compact('districts', 'devices', 'ticketNatures'));
    }
}
