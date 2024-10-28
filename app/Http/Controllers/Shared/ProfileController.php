<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    public function index()
    {
        return view('pages.shared.profile');
    }

    public function updatePersonalInformation(Request $request)
    {
        $request->validate();
    }

    public function changePasswordSave(Request $request)
    {

        $this->validate($request, [
            'current_password' => 'required|string',
            'new_password' => 'required|confirmed|min:8|string',
            'new_password_confirmation' => 'required|confirmed|min:8|string'
        ]);
        $auth = Auth::user();
        // The passwords matches
        if (!Hash::check($request->get('current_password'), $auth->password)) {
            Alert::error("Error", "CurrentPassword is Invalid");
            return redirect()->back();
        }
        // Current password and new password same
        if (strcmp($request->get('current_password'), $request->new_password) == 0) {
            Alert::warning("Warning", "New Password cannot be same as your current password.");
            return redirect()->back();
        }

        if ($request->new_password != $request->new_password_confirmation) {
            Alert::warning("Warning", "New Password and new password confirmation does not match.");
            return redirect()->back();
        }

        $user =  User::find($auth->id);
        $user->password =  Hash::make($request->new_password);
        $user->save();
        Alert::success("Success", "Password Changed Successfully");
        return redirect()->back();
    }

    // Added these two functions for setting up of profile --- 10/10/2024 : hannah
    public function setup()
    {
        return view('pages.shared.profile-setup');
    }

    // storing of email, and contact number. sending also a verification email --- h
    public function store(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:users,id',
                'email' => 'required|email|unique:users,email,' . Auth::id(),
                'contact_number' => 'required',
            ]);

            $user = User::findOrFail($request->input('id'));
            $user->email = $request->email;
            $user->contact_number = $request->contact_number;
            $user->save();

            if (!$user->hasVerifiedEmail()) {
                $user->sendEmailVerificationNotification();
            }
            Alert::success('Success', 'Email verification is succesfull.');
            return redirect()->route('verify');
        } catch (\Exception $e) {
            Alert::error("Error", "Somthing went wrong, please try again");
            return redirect()->back();
        }
    }

    public function show()
    {
        return view('pages.shared.verify');
    }
}
