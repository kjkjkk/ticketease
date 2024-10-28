<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class RequestorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        switch ($user->role) {
            case 'Admin':
                return redirect('admin/dashboard');
            case 'Technician':
                return redirect('technician/dashboard');
            case 'Requestor':
                return $next($request);
            default:
                Alert::warning('Unauthorized Access', 'You are not logged in!');
                return redirect('login');
        }
    }
}
