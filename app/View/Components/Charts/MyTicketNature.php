<?php

namespace App\View\Components\Charts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MyTicketNature extends Component
{
    public $technician_id;
    public function __construct($technician_id)
    {
        $this->technician_id = $technician_id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.charts.my-ticket-nature');
    }
}
