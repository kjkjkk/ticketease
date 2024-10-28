<?php

namespace App\Http\Controllers\Requestor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RequestorProfileSettingController extends Controller
{
    public function index()
    {
        // $user_id = Auth::id();
        return view('pages.requestor.profile-settings');
    }
}
