<?php

namespace App\Http\Controllers\Shared;

use App\Enum\Notification;
use App\Events\Logs\TicketActivityEvent;
use App\Events\Technician\NotifyTechnicianReassignEvent;
use App\Http\Controllers\Controller;
use App\Models\ReassignTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TicketAssign;
use App\Models\Status;
use App\Models\TicketNature;
use App\Models\User;
use App\Models\Ticket;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class MyTicketController extends Controller
{
    public function index(Request $request)
    {
        $technician = Auth::id();

        // Fetching data needed for filters and counts
        $statuses = Status::whereIn('id', [2, 3, 4, 6, 7])->get();
        $ticketNatures = TicketNature::where('status', 1)->get();

        // Build the query for tickets based on the request filters
        $tickets = $this->getFilteredTickets($request, $technician);

        // Counting status and nature data
        $statusCounts = $this->getStatusCounts($technician);
        $statusLabels = $this->getStatusLabels($technician);
        $natureCounts = $this->getNatureCounts($technician);
        $natureLabels = $this->getNatureLabels($technician);

        $reassigns = ReassignTicket::join('tickets', 'tickets.id', '=', 'reassign_tickets.ticket_id')
            ->where('reassign_tickets.to_technician', $technician)
            ->whereNull('reassign_tickets.if_accepted')
            ->whereNotIn('tickets.status_id', [8, 9, 10])
            ->select(
                'reassign_tickets.id',
                'reassign_tickets.ticket_id',
                'reassign_tickets.from_technician',
                'reassign_tickets.to_technician',
                'reassign_tickets.if_accepted',
                'reassign_tickets.created_at',
                'reassign_tickets.updated_at',
            )
            ->get();



        $technicians = User::whereIn('role', ['Admin', 'Technician'])->where('user_status', '=', 'Active')->get();
        return view('pages.shared.my-tickets', compact(
            'tickets',
            'statuses',
            'ticketNatures',
            'statusCounts',
            'statusLabels',
            'natureCounts',
            'natureLabels',
            'technicians',
            'reassigns'
        ));
    }

    // Filtering the tickets using search, status, and ticket nature
    private function getFilteredTickets(Request $request, $technician)
    {
        $ticketQuery = TicketAssign::where('technician_id', $technician)
            ->with(['ticket.status', 'ticket.requestor', 'ticket.ticketNature'])
            ->whereHas('ticket.status', function ($query) {
                $query->whereIn('id', [2, 3, 4, 6, 7]);
            });

        if ($request->filled('status_name')) {
            $ticketQuery->whereHas('ticket.status', function ($query) use ($request) {
                $query->where('status_name', $request->input('status_name'));
            });
        }

        if ($request->filled('ticket_nature_name')) {
            $ticketQuery->whereHas('ticket.ticketNature', function ($query) use ($request) {
                $query->where('ticket_nature_name', $request->input('ticket_nature_name'));
            });
        }

        if ($request->filled('searchRequestor')) {
            $ticketQuery->whereHas('ticket.requestor', function ($query) use ($request) {
                $searchTerm = $request->input('searchRequestor');
                $query->where('firstname', 'like', "%{$searchTerm}%")
                    ->orWhere('lastname', 'like', "%{$searchTerm}%");
            });
        }

        return $ticketQuery->orderByDesc('if_priority')
            ->orderBy('id')
            ->paginate(5);
    }

    private function getStatusCounts($technician)
    {
        return $this->getTicketData($technician)
            ->groupBy('ticket.status_id')
            ->map(fn($statusGroup) => $statusGroup->count());
    }

    private function getStatusLabels($technician)
    {
        return $this->getTicketData($technician)
            ->groupBy('ticket.status_id')
            ->map(fn($statusGroup) => $statusGroup->first()->ticket->status->status_name);
    }

    private function getNatureCounts($technician)
    {
        return $this->getTicketData($technician)
            ->groupBy('ticket.ticket_nature_id')
            ->map(fn($natureGroup) => $natureGroup->count());
    }

    private function getNatureLabels($technician)
    {
        return $this->getTicketData($technician)
            ->groupBy('ticket.ticket_nature_id')
            ->map(fn($natureGroup) => $natureGroup->first()->ticket->ticketNature->ticket_nature_name);
    }

    private function getTicketData($technician)
    {
        return TicketAssign::where('technician_id', $technician)
            ->with(['ticket.status', 'ticket.ticketNature'])
            ->whereHas('ticket.status', fn($query) => $query->whereIn('id', [2, 3, 4, 6, 7]))
            ->get();
    }

    public function reassignTicket(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validate([
                "ticket_id" => "required|integer",
                "from_technician" => "required|integer|exists:users,id",
                "to_technician" => "required|integer|exists:users,id",
            ]);
            $reassignRequest = ReassignTicket::create($data);
            $message =  Notification::TECHNICIAN_REASSIGN->message($reassignRequest->fromTechnician->lastname);
            event(new TicketActivityEvent($reassignRequest->ticket, "Tech. " . $reassignRequest->fromTechnician->lastname . " made reassign request to Tech. " . $reassignRequest->toTechnician->lastname));
            NotifyTechnicianReassignEvent::dispatch($reassignRequest, $message, "REQUEST");
            DB::commit();
            Alert::success("Reassigned Ticket", "You successfully reassigned the ticket.");
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error("Error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function cancelReassignTicket(Request $request)
    {
        try {
            $reassignRequest = ReassignTicket::findOrFail($request->reassign_ticket_id);
            $reassignRequest->delete();
            event(new TicketActivityEvent($reassignRequest->ticket, "Tech. " . $reassignRequest->fromTechnician->lastname . " has cancelled reassign request to Tech. " . $reassignRequest->toTechnician->lastname));
            Alert::success("Canceled Request", "You successfully canceled to reassign ticket.");
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error("Error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function acceptOrRejectReassign(Request $request)
    {
        try {
            DB::beginTransaction();
            $reassignRequest = ReassignTicket::findOrFail($request->reassign_ticket_id);
            $ifAccepted = $request->if_accepted;
            $reassignRequest->if_accepted = $ifAccepted;
            $reassignRequest->save();
            if ($ifAccepted) {
                $message = Notification::REASSIGN_ACCEPT->message($reassignRequest->toTechnician->lastname);
                $ticketAssign = TicketAssign::where('ticket_id', '=', $reassignRequest->ticket_id)->first();
                $ticketAssign->technician_id = $reassignRequest->to_technician;
                $ticketAssign->save();
                NotifyTechnicianReassignEvent::dispatch($reassignRequest, $message, "ACCEPT");
                event(new TicketActivityEvent($reassignRequest->ticket, "Tech. " . $reassignRequest->toTechnician->lastname . " accepted Tech. " . $reassignRequest->fromTechnician->lastname . " reassign request."));
            } else {
                $message = Notification::REASSIGN_REJECT->message($reassignRequest->toTechnician->lastname);
                NotifyTechnicianReassignEvent::dispatch($reassignRequest, $message, "REJECT");
                event(new TicketActivityEvent($reassignRequest->ticket, "Tech. " . $reassignRequest->toTechnician->lastname . " rejected Tech. " . $reassignRequest->fromTechnician->lastname . " reassign request."));
            }
            $title = $ifAccepted == 1 ? "You accepted reassign" : "You rejected reassign";
            DB::commit();
            Alert::success($title);
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error("Error", $e->getMessage());
            return redirect()->back();
        }
    }
}
