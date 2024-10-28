<?php

namespace App\View\Components\Requestor;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Ticket;
use App\Models\Audit;
use Illuminate\Support\Facades\DB;

class StatusProgress extends Component
{
    public $ticket;
    public $steps;
    public $currentStep;
    public $statusDates;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;

        // Define the steps with their labels and respective status IDs
        $this->steps = [
            ['id' => 1, 'label' => 'Submitted', 'step' => 1],
            ['id' => 2, 'label' => 'Assigned', 'step' => 2],
            ['id' => [3, 6], 'label' => 'In Progress / To CITC', 'step' => 3],
            ['id' => 4, 'label' => 'Repaired', 'step' => 4],
            ['id' => 7, 'label' => 'For Release', 'step' => 5],
            ['id' => [5, 9, 10], 'label' => 'Closed / For Waste / Invalid', 'step' => 6],
        ];

        // Set the current step based on the ticket status
        $this->currentStep = $this->determineCurrentStep();

        // Fetch status change dates
        $this->statusDates = $this->getStatusChangeDates();
    }

    // Determine the current step based on the ticket's status
    protected function determineCurrentStep()
    {
        foreach ($this->steps as $step) {
            if (is_array($step['id']) ? in_array($this->ticket->status_id, $step['id']) : $this->ticket->status_id == $step['id']) {
                return $step['step'];
            }
        }

        return 0; // Default to 0 if no match is found
    }

    // Fetch the status change dates from the audits table
    protected function getStatusChangeDates()
    {
        $audits = Audit::where('ticket_id', $this->ticket->id)
            ->select('new_status_id', DB::raw('MAX(created_at) as created_at'))
            ->groupBy('new_status_id')
            ->get();

        $statusDates = [];
        foreach ($audits as $audit) {
            $statusDates[$audit->new_status_id] = $audit->created_at;
        }

        return $statusDates;
    }

    // Format date or return 'N/A'
    protected function formatDate($statusId)
    {
        if ($statusId === 1) {
            return $this->ticket->created_at->format('F j, Y g:i a');
        }

        return isset($this->statusDates[$statusId])
            ? $this->statusDates[$statusId]->format('F j, Y g:i a')
            : 'N/A';
    }

    public function render(): View|Closure|string
    {
        return view('components.requestor.status-progress', [
            'ticket' => $this->ticket,
            'steps' => $this->steps,
            'currentStep' => $this->currentStep,
            'formatDate' => function ($statusId) {
                return $this->formatDate($statusId);
            }
        ]);
    }
}
