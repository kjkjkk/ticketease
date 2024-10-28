<?php

namespace App\View\Components\Heatmap;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Drilldown extends Component
{
    public $title;
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.heatmap.drilldown');
    }
}
