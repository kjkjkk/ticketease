<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Ticket;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class OverviewCard extends Component
{
    public $color;
    public $title;
    public $result;
    public $role;
    public $status;
    public function __construct($color, $status, $role)
    {
        $this->color = $color;
        $this->role = $role;
        $this->status = $status;
        // Fetch status name from Status model
        $this->title = Status::find($status)->status_name ?? 'Unknown';

        if ($role == "Admin") {
            $result = Ticket::where('status_id', $this->status)->count();
            $this->result = str_pad($result, 2, '0', STR_PAD_LEFT);
        } else if ($role == "Technician") {
            $result = Ticket::whereHas('ticketAssign', function ($query) {
                $query->where('technician_id', Auth::id());
            })->where('status_id', $this->status)->count();

            $this->result = str_pad($result, 2, '0', STR_PAD_LEFT);
        }
    }
    public function render()
    {
        return view('components.overview-card');
    }
}
