<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TechnicianDropdown extends Component
{
    public $technicians;

    public function __construct()
    {
        // Fetch authenticated user
        $authUser = Auth::user();

        // Fetch all technicians and admin
        $this->technicians = User::query()
            ->whereIn('role', ['Admin', 'Technician'])
            ->where('user_status', 'Active')
            ->get()
            ->map(function ($technician) use ($authUser) {
                // Append (You) to the authenticated admin
                if ($technician->id === $authUser->id) {
                    $technician->lastname .= ' (You)';
                }
                return $technician;
            });
    }

    public function render(): View|Closure|string
    {
        return view('components.technician-dropdown', [
            'technicians' => $this->technicians,
        ]);
    }
}
