<?php

namespace App\Http\Controllers\Requestor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (is_null($user->email) || is_null($user->contact_number)) {
            return redirect()->route('profile-setup'); 
        } else {
            return view('pages.requestor.home');
        }

    }

}
