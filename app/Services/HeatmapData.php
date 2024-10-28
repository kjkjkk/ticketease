<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class HeatmapData
{
    public function getDistrictMonthlyTickets($districts, $months, $year)
    {
        //$year = $year ?? date('Y');
        $districtMonthlyTickets = DB::table('tickets')
            ->leftJoin('districts', 'tickets.district_id', '=', 'districts.id')
            ->select(
                'districts.district_name',
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 1 THEN 1 ELSE 0 END) AS January'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 2 THEN 1 ELSE 0 END) AS February'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 3 THEN 1 ELSE 0 END) AS March'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 4 THEN 1 ELSE 0 END) AS April'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 5 THEN 1 ELSE 0 END) AS May'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 6 THEN 1 ELSE 0 END) AS June'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 7 THEN 1 ELSE 0 END) AS July'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 8 THEN 1 ELSE 0 END) AS August'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 9 THEN 1 ELSE 0 END) AS September'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 10 THEN 1 ELSE 0 END) AS October'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 11 THEN 1 ELSE 0 END) AS November'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 12 THEN 1 ELSE 0 END) AS December')
            )
            ->when($districts, function ($query, $districts) {
                return $query->whereIn('districts.district_name', $districts);
            })
            ->whereYear('tickets.created_at', $year)
            ->groupBy('districts.district_name')
            ->orderBy('districts.id')
            ->get()
            ->map(function ($item) use ($months) {
                // Convert stdClass object to an array
                $item = (array) $item;
                return array_filter($item, function ($key) use ($months) {
                    return $key === 'district_name' || in_array($key, $months);
                }, ARRAY_FILTER_USE_KEY);
            });

        return $districtMonthlyTickets;
    }

    public function getTechnicianMonthlyTickets($technicians, $months, $year)
    {
        $technicianMonthlyTickets = DB::table('ticket_assigns')
            ->join('users', 'users.id', '=', 'ticket_assigns.technician_id')
            ->select(
                'users.lastname',
                DB::raw('SUM(CASE WHEN MONTH(ticket_assigns.created_at) = 1 THEN 1 ELSE 0 END) AS January'),
                DB::raw('SUM(CASE WHEN MONTH(ticket_assigns.created_at) = 2 THEN 1 ELSE 0 END) AS February'),
                DB::raw('SUM(CASE WHEN MONTH(ticket_assigns.created_at) = 3 THEN 1 ELSE 0 END) AS March'),
                DB::raw('SUM(CASE WHEN MONTH(ticket_assigns.created_at) = 4 THEN 1 ELSE 0 END) AS April'),
                DB::raw('SUM(CASE WHEN MONTH(ticket_assigns.created_at) = 5 THEN 1 ELSE 0 END) AS May'),
                DB::raw('SUM(CASE WHEN MONTH(ticket_assigns.created_at) = 6 THEN 1 ELSE 0 END) AS June'),
                DB::raw('SUM(CASE WHEN MONTH(ticket_assigns.created_at) = 7 THEN 1 ELSE 0 END) AS July'),
                DB::raw('SUM(CASE WHEN MONTH(ticket_assigns.created_at) = 8 THEN 1 ELSE 0 END) AS August'),
                DB::raw('SUM(CASE WHEN MONTH(ticket_assigns.created_at) = 9 THEN 1 ELSE 0 END) AS September'),
                DB::raw('SUM(CASE WHEN MONTH(ticket_assigns.created_at) = 10 THEN 1 ELSE 0 END) AS October'),
                DB::raw('SUM(CASE WHEN MONTH(ticket_assigns.created_at) = 11 THEN 1 ELSE 0 END) AS November'),
                DB::raw('SUM(CASE WHEN MONTH(ticket_assigns.created_at) = 12 THEN 1 ELSE 0 END) AS December')
            )
            ->when($technicians, function ($query, $technicians) {
                return $query->whereIn('users.lastname', $technicians);
            })
            ->whereYear('ticket_assigns.created_at', $year)
            ->groupBy('users.lastname')
            ->get()
            ->map(function ($item) use ($months) {
                // Convert stdClass object to an array
                $item = (array) $item;
                // Filter the data to only include the selected months and technician name
                return array_filter($item, function ($key) use ($months) {
                    return $key === 'lastname' || in_array($key, $months);
                }, ARRAY_FILTER_USE_KEY);
            });

        return $technicianMonthlyTickets;
    }

    public function getDeviceMonthlyTickets($devices, $months, $year)
    {
        $deviceMonthlyTickets =  DB::table('tickets')
            ->join('devices', 'devices.id', '=', 'tickets.device_id')
            ->select(
                'devices.device_name',
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 1 THEN 1 ELSE 0 END) AS January'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 2 THEN 1 ELSE 0 END) AS February'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 3 THEN 1 ELSE 0 END) AS March'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 4 THEN 1 ELSE 0 END) AS April'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 5 THEN 1 ELSE 0 END) AS May'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 6 THEN 1 ELSE 0 END) AS June'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 7 THEN 1 ELSE 0 END) AS July'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 8 THEN 1 ELSE 0 END) AS August'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 9 THEN 1 ELSE 0 END) AS September'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 10 THEN 1 ELSE 0 END) AS October'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 11 THEN 1 ELSE 0 END) AS November'),
                DB::raw('SUM(CASE WHEN MONTH(tickets.created_at) = 12 THEN 1 ELSE 0 END) AS December')
            )
            ->when($devices, function ($query, $devices) {
                return $query->whereIn('devices.device_name', $devices);
            })
            ->whereYear('tickets.created_at', $year)
            ->groupBy('devices.device_name')
            ->orderBy('devices.id')
            ->get()
            ->map(function ($item) use ($months) {
                // Convert stdClass object to an array
                $item = (array) $item;
                return array_filter($item, function ($key) use ($months) {
                    return $key === 'device_name' || in_array($key, $months);
                }, ARRAY_FILTER_USE_KEY);
            });

        return $deviceMonthlyTickets;
    }
}
