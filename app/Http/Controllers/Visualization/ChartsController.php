<?php

namespace App\Http\Controllers\Visualization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketAssign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;


class ChartsController extends Controller
{
    public function getPendingTicketsData()
    {
        $tickets = Ticket::selectRaw('COUNT(tickets.status_id) as count, tickets.status_id, statuses.status_name')
            ->join('statuses', 'tickets.status_id', '=', 'statuses.id')
            ->whereIn('tickets.status_id', [1, 2, 3, 4, 6, 7]) // Filter tickets with status_id less than 5
            ->groupBy('tickets.status_id', 'statuses.status_name')
            ->get();

        return response()->json($tickets);
    }

    public function getDistrictTicketsData(Request $request)
    {
        $month = $request->input('month');

        if ($month) {
            $year = substr($month, 0, 4);
            $monthOnly = substr($month, 5, 2);
        } else {
            $year = now()->year;
            $monthOnly = now()->month;
        }

        $districts = DB::table('districts')
            ->select('districts.district_name', DB::raw('COUNT(tickets.district_id) as tickets'))
            ->leftJoin('tickets', function ($join) use ($year, $monthOnly) {
                $join->on('districts.id', '=', 'tickets.district_id')
                    ->whereYear('tickets.created_at', $year)
                    ->whereMonth('tickets.created_at', $monthOnly);
            })
            ->groupBy('districts.district_name')
            ->get();

        return response()->json($districts);
    }

    public function getTicketNatureTicketsData(Request $request)
    {
        $technician = $request->input('technician_id');
        $month = $request->input('month');

        if ($month) {
            $year = substr($month, 0, 4);
            $monthOnly = substr($month, 5, 2);
        } else {
            $year = now()->year;
            $monthOnly = now()->format('m'); // Ensures two-digit month
        }

        // Modify the query to return all ticket natures, even those with zero tickets
        $ticketNaturesQuery = DB::table('ticket_natures')
            ->select('ticket_natures.ticket_nature_name', DB::raw('COUNT(tickets.ticket_nature_id) as tickets'))
            ->leftJoin('tickets', function ($join) use ($year, $monthOnly) {
                $join->on('ticket_natures.id', '=', 'tickets.ticket_nature_id')
                    ->whereYear('tickets.created_at', $year)
                    ->whereMonth('tickets.created_at', $monthOnly);
            })
            ->leftJoin('ticket_assigns', 'tickets.id', '=', 'ticket_assigns.ticket_id')
            ->leftJoin('users', 'ticket_assigns.technician_id', '=', 'users.id')
            ->where(function ($query) {
                $query->where('tickets.status_id', '!=', 1)
                    ->orWhereNull('tickets.status_id'); // Include ticket natures with no tickets
            });

        // Apply technician filter if technician_id is selected
        if ($technician) {
            $ticketNaturesQuery->where('ticket_assigns.technician_id', $technician);
        }

        // Group by ticket nature to ensure that we get a count, even if it's 0
        $ticketNatures = $ticketNaturesQuery
            ->groupBy('ticket_natures.ticket_nature_name')
            ->get();

        return response()->json($ticketNatures);
    }



    // Technician Cherts
    public function getTechnicianMonthlyTickets(Request $request)
    {
        $technician_id = Auth::id();

        $year = $request->input('year', date('Y'));

        $months = collect(range(1, 12)); // Generate months from 1 to 12

        $monthlyTickets = $months->map(function ($month) use ($technician_id, $year) {
            return DB::table('ticket_assigns')
                ->selectRaw('COUNT(*) as tickets')
                ->where('technician_id', $technician_id)
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->first()->tickets ?? 0;
        })->map(function ($tickets, $month) {
            return [
                'month' => DateTime::createFromFormat('!m', $month + 1)->format('F'), // Convert month number to month name
                'tickets' => $tickets
            ];
        });


        return response()->json($monthlyTickets);
    }

    public function getTechniciansTicketPerMonth(Request $request)
    {
        $technician = Auth::id();
        $month = $request->input('month');

        if ($month) {
            $year = substr($month, 0, 4);
            $monthOnly = substr($month, 5, 2);
        } else {
            $year = now()->year;
            $monthOnly = now()->format('m'); // Ensures two-digit month
        }

        // Query to get the total number of tickets
        $totalTickets = DB::table('tickets')
            ->leftJoin('ticket_assigns', 'tickets.id', '=', 'ticket_assigns.ticket_id')
            ->where('tickets.status_id', '!=', 1)
            ->whereYear('tickets.created_at', $year)
            ->whereMonth('tickets.created_at', $monthOnly)
            ->where('ticket_assigns.technician_id', '=', $technician)
            ->count();

        // Query to get ticket nature breakdown with percentages
        $ticketNatures = DB::table('ticket_natures')
            ->select(
                'ticket_natures.ticket_nature_name',
                DB::raw('COUNT(tickets.ticket_nature_id) as tickets'),
                DB::raw("ROUND((COUNT(tickets.ticket_nature_id) / {$totalTickets}) * 100) as percentage"),
                DB::raw("COUNT(tickets.ticket_nature_id) as count")
            )
            ->leftJoin('tickets', function ($join) use ($year, $monthOnly) {
                $join->on('ticket_natures.id', '=', 'tickets.ticket_nature_id')
                    ->whereYear('tickets.created_at', $year)
                    ->whereMonth('tickets.created_at', $monthOnly);
            })
            ->leftJoin('ticket_assigns', 'tickets.id', '=', 'ticket_assigns.ticket_id')
            ->leftJoin('users', 'ticket_assigns.technician_id', '=', 'users.id')
            ->where('tickets.status_id', '!=', 1)
            ->where('technician_id', '=', $technician)
            ->groupBy('ticket_natures.ticket_nature_name')
            ->get();

        return response()->json([
            'totalTickets' => $totalTickets,
            'ticketNatures' => $ticketNatures,
        ]);
    }
    //Get technicians pending tickets 
    public function getTechnicianPendingTicketsData()
    {
        $technician = Auth::id();
        $tickets = Ticket::selectRaw('COUNT(tickets.status_id) as count, tickets.status_id, statuses.status_name')
            ->join('statuses', 'tickets.status_id', '=', 'statuses.id')
            ->join('ticket_assigns', 'tickets.id', '=', 'ticket_assigns.ticket_id')
            ->where('technician_id', $technician)
            ->where('tickets.status_id', '<', 5)
            ->groupBy('tickets.status_id', 'statuses.status_name')
            ->get();

        return response()->json($tickets);
    }
}
