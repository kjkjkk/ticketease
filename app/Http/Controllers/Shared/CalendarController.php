<?php

namespace App\Http\Controllers\Shared;

use App\Models\TicketAssign;
use App\Models\Schedule;
use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleStoreRequest;
use App\Http\Requests\ScheduleUpdateRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        $technician = Auth::id();
        $tickets = TicketAssign::where('technician_id', $technician) // The authenticated technician data only
            ->where('if_scheduled', 0) // Only fetch tickets where if_scheduled is false
            ->with(['ticket.requestor', 'ticket.ticketNature', 'ticket.district', 'ticket.device', 'ticket.status'])
            ->whereHas('ticket.status', function ($query) {
                $query->whereIn('id', [2, 3, 4, 5]); // Filter by specific statuses
            })
            ->orderByDesc('if_priority') // Order by if_priority (true first)
            ->orderBy('id') // Then order by ID for non-priority tickets
            ->paginate(5);

        $schedules = Schedule::whereHas('ticketAssign', function ($query) use ($technician) {
            $query->where('technician_id', $technician);
        })
            ->with(['ticketAssign.ticket'])
            ->get()
            ->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'ticket_assign_id' => $schedule->ticket_assign_id,
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'comments' => $schedule->comments ?? null,
                    'ticket_id' => $schedule->ticketAssign->ticket->id ?? null,
                    'date_assigned' => $schedule->ticketAssign->date_assigned ?
                        Carbon::parse($schedule->ticketAssign->date_assigned)->format('F j, Y g:i A') : null,
                    'ticket_nature_name' => $schedule->ticketAssign->ticket->ticketNature->ticket_nature_name ?? null,
                    'district' => $schedule->ticketAssign->ticket->district->district_name ?? null,
                    'department' => $schedule->ticketAssign->ticket->department ?? null,
                    'created_at' => $schedule->ticketAssign->ticket->created_at ?
                        Carbon::parse($schedule->ticketAssign->ticket->created_at)->format('F j, Y g:i A') : null,

                ];
            });

        return view('pages.shared.calendar', compact('tickets', 'schedules'));
    }

    public function store(ScheduleStoreRequest $request)
    {
        try {
            $data = $request->validated();
            if ($this->updateTicketAssignSchedule($data['ticket_assign_id'])) {
                Schedule::create([
                    'ticket_assign_id' => $data['ticket_assign_id'],
                    'comments' => $data['comments'] ?? null,
                    'start_time' => Carbon::createFromFormat('Y-m-d\TH:i', $data['start_time'])->format('Y-m-d H:i:s'),
                    'end_time' => Carbon::createFromFormat('Y-m-d\TH:i', $data['end_time'])->format('Y-m-d H:i:s'),
                ]);
                Alert::success('Create Schedule', 'Schedule created successfully!');
            } else {
                Alert::warning('Create Schedule', 'Unable to create ticket, please try again!');
            }
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Something went wrong, please try again');
            return redirect()->back();
        }
    }

    public function edit(ScheduleUpdateRequest $request)
    {
        try {
            $data = $request->validated();

            $schedule = Schedule::findOrFail($data['schedule_id']);
            $schedule->update([
                'comments' => $data['comments'] ?? null,
                'start_time' => Carbon::createFromFormat('Y-m-d\TH:i', $data['start_time'])->format('Y-m-d H:i:s'),
                'end_time' => Carbon::createFromFormat('Y-m-d\TH:i', $data['end_time'])->format('Y-m-d H:i:s'),
            ]);

            Alert::success('Update Schedule', 'Schedule rescheduled successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Something went wrong, please try again');
            return redirect()->back();
        }
    }

    private function updateTicketAssignSchedule($ticket_assign_id)
    {
        try {
            $ticketAssign = TicketAssign::find($ticket_assign_id);
            if (!$ticketAssign) {
                return false;
            }
            $ticketAssign->if_scheduled = 1;
            return $ticketAssign->save();
        } catch (\Exception $e) {
            Alert::error('Error', 'Something went wrong, please try again');
            return false;
        }
    }
}
