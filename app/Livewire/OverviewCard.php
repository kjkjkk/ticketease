<?php

namespace App\Livewire;

use App\Models\Status;
use Livewire\Component;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OverviewCard extends Component
{
    public $color;
    public $status_id;
    public $role;

    public function mount($color, $status_id, $role)
    {
        $this->color = $color;
        $this->status_id = $status_id;
        $this->role = $role;
    }

    public function render()
    {
        $title = Status::where('id', $this->status_id)->value('status_name');
        if ($this->role == "Admin") {
            $result = Ticket::where('status_id', $this->status_id)->count();
            $formattedResult = str_pad($result, 2, '0', STR_PAD_LEFT);
        } else if ($this->role == "Technician") {
            $result = Ticket::whereHas('ticket_assigns', function ($query) {
                $query->where('technician_id', Auth::id());
            })->where('status_id', $this->status_id)->count();

            $formattedResult = str_pad($result, 2, '0', STR_PAD_LEFT);
        }

        return view('livewire.overview-card', compact('formattedResult', 'title'));
    }
}
