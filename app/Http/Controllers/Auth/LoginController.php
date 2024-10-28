<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Events\WelcomeUser;
use App\Events\Reminder;
use App\Events\TechnicianReminder;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    public function username()
    {
        return 'username';
    }
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();


            if ($user->role === 'Admin' && $user->user_status === 'Active') {
                event(new Reminder($user));
                //----------------changesssss------------- -->
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'Technician' && $user->user_status === 'Active') {
                //----------------changesssss------------- -->
                event(new TechnicianReminder($user));
                //----------------changesssss------------- -->
                return redirect()->route('technician.dashboard');
            } elseif ($user->role === 'Requestor' && $user->user_status === 'Active') {
                //----------------changesssss------------- -->
                event(new WelcomeUser($user));
                //----------------changesssss------------- -->
                return redirect()->route('requestor.home');
            } else {
                Auth::logout();
                Alert::error('Error', 'Your Account is deactivated');
                return redirect('/login');
            }
        }
    }
}
