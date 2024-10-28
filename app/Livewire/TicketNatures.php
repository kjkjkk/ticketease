<?php

namespace App\Livewire;

use App\Models\TicketNature;
use Livewire\Component;

class TicketNatures extends Component
{
    public $ticket_nature_id;
    public $ticket_nature_name;
    public $created_at;
    public $updated_at;
    public $status;
    public $searchTerm = "";
    public $new_ticket_nature;

    protected $rules = [
        'ticket_nature_name' => 'required|min:2|max:30',
        'new_ticket_nature' => 'required|min:2|max:30',
    ];

    public function render()
    {
        $ticketNatures = TicketNature::where('ticket_nature_name', 'like', '%' . $this->searchTerm . '%')->get();

        return view('livewire.ticket-natures', [
            'ticket_natures' => $ticketNatures,
        ]);
    }

    public function search()
    {
        $this->render();
    }

    public function display($id)
    {
        $ticketNature = TicketNature::findOrFail($id);
        $this->ticket_nature_id = $ticketNature->id;
        $this->ticket_nature_name = $ticketNature->ticket_nature_name;
        $this->created_at = $ticketNature->created_at;
        $this->updated_at = $ticketNature->updated_at;
        $this->status = $ticketNature->status;
    }

    public function create()
    {
        $this->validateOnly('new_ticket_nature');

        try {
            TicketNature::create([
                'ticket_nature_name' => $this->new_ticket_nature,
            ]);
            session()->flash('type', 'success');
            session()->flash('message', 'Ticket nature created successfully!');
        } catch (\Exception $ex) {
            session()->flash('type', 'danger');
            session()->flash('message', 'Something went wrong!');
        }
    }

    public function update()
    {
        if (!$this->ticket_nature_id) {
            session()->flash('type', 'warning');
            session()->flash('message', 'No ticket nature selected.');
            return;
        }

        $this->validateOnly('ticket_nature_name');

        try {
            $ticketNature = TicketNature::findOrFail($this->ticket_nature_id);
            $ticketNature->ticket_nature_name = $this->ticket_nature_name;
            $ticketNature->save();

            session()->flash('type', 'success');
            session()->flash('message', 'Ticket nature updated successfully.');
            $this->clear();
        } catch (\Exception $e) {
            session()->flash('type', 'danger');
            session()->flash('message', "Something went wrong!");
        }
    }

    public function delete()
    {
        if (!$this->ticket_nature_id) {
            session()->flash('type', 'warning');
            session()->flash('message', 'No ticket nature selected to delete.');
            return;
        }

        try {
            TicketNature::findOrFail($this->ticket_nature_id)->delete();
            session()->flash('type', 'success');
            session()->flash('message', "Ticket nature deleted successfully!");
            $this->clear();
        } catch (\Exception $e) {
            session()->flash('type', 'danger');
            session()->flash('message', "Cannot delete this ticket nature");
        }
    }

    public function clear()
    {
        $this->reset(['ticket_nature_id', 'ticket_nature_name', 'created_at', 'updated_at', 'status']);
    }

    public function toggleStatus()
    {
        if (!$this->ticket_nature_id) {
            session()->flash('type', 'warning');
            session()->flash('message', 'Please select a ticket nature first.');
            return;
        }

        try {
            $ticketNature = TicketNature::findOrFail($this->ticket_nature_id);
            $ticketNature->status = !$ticketNature->status;
            $ticketNature->save();

            session()->flash('type', 'success');
            session()->flash('message', 'Ticket nature status updated.');
        } catch (\Exception $e) {
            session()->flash('type', 'danger');
            session()->flash('message', 'Something went wrong!');
        }

        $this->clear();
    }
}
