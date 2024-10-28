<?php

namespace App\Http\Controllers\Admin;

use App\Enum\Months;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\District;
use App\Models\Ticket;
use App\Models\User;
use App\Services\HeatmapData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HeatmapController extends Controller
{
    public function index()
    {
        $districts = District::all();

        $technicians = User::whereIn('role', ['Admin', 'Technician'])->get();

        $devices = Device::where('id', '!=', 1)->get();

        $months = Months::all();
        $years = Ticket::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->pluck('year');
        return view('pages.admin.heatmap', compact('districts', 'technicians', 'devices', 'months', 'years'));
    }
}
