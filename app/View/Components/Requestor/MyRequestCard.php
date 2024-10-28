<?php

namespace App\View\Components\Requestor;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Ticket;

class MyRequestCard extends Component
{
    public $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function render(): View|Closure|string
    {
        $ticket = $this->ticket;
        return view('components.requestor.my-request-card', compact('ticket'));
    }
}
