<?php

namespace App\Http\Controllers\Shared;

use App\Enum\AuditActivity;
use App\Events\Logs\TicketStatusUpdateEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketUpdateRequest;
use App\Models\Audit;
use App\Models\Ticket;
use App\Models\District;
use App\Models\Device;
use App\Models\Status;
use App\Models\TicketAssign;
use App\Models\TicketNature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

//----------------changesssss-------------
use App\Events\NotifyRequestorStatusUpdate;
//----------------changesssss-------------

class ShowTicketController extends Controller
{
    public function index(Request $request)
    {
        $ticket = Ticket::find($request->id);
        // Status ID = 9 is Invalid
        if ($ticket->status_id == 9) {
            return redirect()->route('shared.my-tickets');
        }
        $ticketAuditLogs = Audit::where('ticket_id', $ticket->id)->get();
        $districts = District::where('status', 1)->get();
        $devices = Device::where('status', 1)->get();
        $ticketNatures = TicketNature::where('status', 1)->get();
        $previousRoute = $request->route;
        return view('pages.shared.show-ticket', compact('ticket', 'ticketAuditLogs', 'districts', 'devices', 'ticketNatures', 'previousRoute'));
    }

    public function openTicket(Request $request)
    {
        try {
            DB::beginTransaction();
            $ticket = Ticket::find($request->ticketID);
            event(new TicketStatusUpdateEvent($ticket, AuditActivity::IN_PROGRESS->id(), AuditActivity::IN_PROGRESS->activity()));
            $ticket->status_id = AuditActivity::IN_PROGRESS->id();
            $ticket->save();
            DB::commit();
            //----------------changesssss------------- -->
            event(new NotifyRequestorStatusUpdate($ticket));
            //----------------changesssss------------- -->
            Alert::success('Open Ticket', 'You successfully updated the ticket status to IN PROGRESS');
            return redirect()->route('shared.show-ticket', ['id' => $request->ticketID, 'route' => $request->route]);
        } catch (\Exception $e) {
            Alert::error('Error', 'An error occured while openning ticket');
            return redirect()->back();
        }
    }

    public function renderService(Request $request)
    {
        try {
            DB::beginTransaction();
            $ticketAssign = TicketAssign::where('ticket_id', $request->ticketID)->firstOrFail();
            $ticketAssign->issue_found = $request->issueFound ?? "";
            $ticketAssign->service_rendered = $request->serviceRendered ?? "";
            $ticketAssign->save();
            DB::commit();
            Alert::success('Ticket Service', 'You successfully updated ticket service');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Something went wrong, please try again ');
        }
        return redirect()->back();
    }

    public function updateTicketStatus(Request $request)
    {
        try {
            DB::beginTransaction();
            $ticket = Ticket::find($request->ticket_id);
            $new_status = $request->new_status;
            // Get the corresponding AuditActivity enum case based on the status ID
            $activity = AuditActivity::fromId($new_status);
            if ($activity === null) {
                Alert::error('Error', "Something went wrong, please try again");
                return redirect()->back();
            }
            event(new TicketStatusUpdateEvent($ticket, $new_status, $activity->activity()));
            event(new NotifyRequestorStatusUpdate($ticket));
            $ticket->status_id = $new_status;
            $ticket->save();
            DB::commit();
            Alert::success('Status Updated', 'You successfully updated the ticket status');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'An error occured while updating the ticket status');
            return redirect()->back();
        }
    }

    public function updateServiceStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'service_status' => 'required|string|in:' . implode(',', \App\Enum\ServiceStatus::values()),
            ]);

            $ticketAssign = TicketAssign::findOrFail($id);
            $ticketAssign->update(['service_status' => $request->input('service_status')]);

            return response()->json(['message' => 'Service status updated successfully.']);
        } catch (\Exception $e) {
            Alert::error('Error ', 'Something went wrong, please try again');
            return response()->json(['error' => 'An error occurred while updating the service status.'], 500);
        }
    }
}
