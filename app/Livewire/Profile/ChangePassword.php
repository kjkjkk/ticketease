<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Livewire\Component;

class ChangePassword extends Component
{
    public $current_password;
    public $new_password;
    public $new_password_confirmation;
    public $new_username;

    protected $rules = [
        'current_password' => 'required|min:8|max:30',
        'new_password' => 'required|min:8|max:30|confirmed',
        'new_username' => 'required|min:8|max:30',
    ];

    public function render()
    {
        return view('livewire.profile.change-password');
    }

    public function clearPasswordFields()
    {
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
    }

    public function changePassword()
    {
        // Validate inputs
        $this->validate([
            'current_password' => 'required|min:8|max:30',
            'new_password' => 'required|min:8|max:30|confirmed',
        ]);

        $auth = Auth::user();

        // Check if the current password matches
        if (!password_verify($this->current_password, $auth->password)) {
            session()->flash('type', 'danger');
            session()->flash(
                'message',
                'Your current password does not match your real password.'
            );
            session()->flash('password_fail');
            $this->clearPasswordFields();
            return; // Stop further execution
        }

        // Check if the new password is the same as the current one
        if ($this->current_password === $this->new_password) {
            session()->flash('type', 'warning');
            session()->flash('message', 'New password cannot be the same as the current password.');
            session()->flash('password_fail');
            $this->clearPasswordFields();
            return; // Stop further execution
        }

        // Update the password in the database
        $user = User::find($auth->id);
        $user->password = Hash::make($this->new_password);
        $user->save();

        session()->flash('type', 'success');
        session()->flash('message', 'You have successfully changed your password.');
        session()->flash('password_success');

        $this->clearPasswordFields();
    }

    public function changeUsername()
    {
        $this->validateOnly('new_username');

        $auth = Auth::user();

        if ($auth->username == $this->new_username) {
            session()->flash('type', 'warning');
            session()->flash('message', 'New username cannot be the same as the current username.');
            session()->flash('username_fail');
            $this->reset(['new_username']);
            return;
        }

        if (User::where('username', $this->new_username)->exists()) {
            session()->flash('type', 'warning');
            session()->flash('message', 'Username is already taken.');
            session()->flash('username_fail');
            $this->reset(['new_username']);
            return;
        }

        $user = User::find($auth->id);
        $user->username = $this->new_username;
        $user->save();

        
        session()->flash('type', 'success');
        session()->flash('message', 'You have successfully changed your username.');
        session()->flash('username_success');
    }
}
