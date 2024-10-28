<?php

namespace App\Livewire;

use App\Enum\ServiceStatus as EnumServiceStatus;
use App\Models\TicketAssign;
use Livewire\Component;

class ServiceStatus extends Component
{
    public $ticketAssignId;
    public $serviceStatus;
    public $selectedStatus;

    public function mount($ticketAssignId)
    {
        $this->ticketAssignId = $ticketAssignId;
        $ticketAssign = TicketAssign::find($this->ticketAssignId);
        $this->serviceStatus = $ticketAssign ? $ticketAssign->service_status : null;
        $this->selectedStatus = $this->serviceStatus; // Set the selected status
    }


    public function render()
    {
        $service_statuses = EnumServiceStatus::values();
        return view('livewire.service-status', compact('service_statuses'));
    }

    public function updateServiceStatus()
    {
        $this->validate([
            'selectedStatus' => ['required', 'in:' . implode(',', EnumServiceStatus::values())],
        ]);

        $ticketAssign = TicketAssign::find($this->ticketAssignId);
        $ticketAssign->service_status = $this->selectedStatus;
        $ticketAssign->save();

        session()->flash('message', 'Service status updated successfully!');
        
    }
}
