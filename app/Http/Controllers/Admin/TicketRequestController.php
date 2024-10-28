<?php

namespace App\Http\Controllers\Admin;

use App\Enum\AuditActivity;
use App\Events\Logs\InvalidTicketEvent;
use App\Events\Logs\TicketStatusUpdateEvent;
use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\TicketNature;
use Illuminate\Http\Request;
use App\Http\Requests\AssignStoreRequest;
use App\Models\TicketAssign;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

use App\Events\NotifyRequestorStatusUpdate;
use App\Events\Technician\NotifyTechnicianAssignEvent;

class TicketRequestController extends Controller
{
    public function index(Request $request)
    {
        $statuses = Status::whereIn('id', [2, 3, 4, 7])->get();
        $ticketNatures = TicketNature::where('status', 1)->get();

        $ticketQueue = $this->getTicketQueue($request);
        $ticketPending = $this->getTicketPending($request);

        return view('pages.admin.ticket-request', compact('ticketQueue', 'ticketPending', 'statuses', 'ticketNatures'));
    }

    // Get Tickets with UNASSIGNED status
    private function getTicketQueue(Request $request)
    {
        return Ticket::query()
            ->where('status_id', 1)
            ->with(['requestor', 'ticketNature', 'status'])
            ->get();
    }

    // Get Tickets with statuses ASSIGNED, IN PROGRESS, REPAIRED, and TO RELEASE
    private function getTicketPending(Request $request)
    {
        $pendingTickets = Ticket::query()
            ->whereIn('status_id', [2, 3, 4, 7]);

        $this->applyFilters($request, $pendingTickets);

        return $pendingTickets->with(['requestor', 'ticketNature', 'status'])->paginate(5);
    }

    // Filter data by search requestor, status and ticket nature
    private function applyFilters(Request $request, $query)
    {
        if ($request->filled('status_name')) {
            $this->filterByStatus($request->input('status_name'), $query);
        }

        if ($request->filled('ticket_nature_name')) {
            $this->filterByTicketNature($request->input('ticket_nature_name'), $query);
        }

        if ($request->filled('searchRequestor')) {
            $this->searchByRequestor($request->input('searchRequestor'), $query);
        }
    }

    // Filter by status
    private function filterByStatus(string $statusName, $query)
    {
        $query->whereHas('status', function ($query) use ($statusName) {
            $query->where('status_name', $statusName);
        });
    }

    // Filter by ticket nature
    private function filterByTicketNature(string $ticketNatureName, $query)
    {
        $query->whereHas('ticketNature', function ($query) use ($ticketNatureName) {
            $query->where('ticket_nature_name', $ticketNatureName);
        });
    }

    // Filter by searching
    private function searchByRequestor(string $searchTerm, $query)
    {
        $query->whereHas('requestor', function ($query) use ($searchTerm) {
            $query->where('firstname', 'like', "%{$searchTerm}%")
                ->orWhere('lastname', 'like', "%{$searchTerm}%");
        });
    }

    public function assign(AssignStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $ticket = Ticket::find($data['ticket_id']);
            event(new TicketStatusUpdateEvent($ticket, AuditActivity::ASSIGNED->id(), AuditActivity::ASSIGNED->activity()));
            $ticket->status_id = AuditActivity::ASSIGNED->id();
            $ticket->save();
            $ticketAssign = TicketAssign::create($data);
            event(new NotifyTechnicianAssignEvent($ticketAssign));
            event(new NotifyRequestorStatusUpdate($ticket));
            DB::commit();
            Alert::success('Assign Ticket', 'Ticket assigned successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Something went wrong, please try again');
            return redirect()->back();
        }
    }


}
