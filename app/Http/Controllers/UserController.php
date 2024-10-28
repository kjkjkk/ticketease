<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        // the UserStoreRequest object automatically validates the incoming request based on the rules and stores it in $data
        $data = $request->validated();

        $data['username'] = $data['lastname'] . rand(100, 999);

        // calls the uploadSignature method to handle the file upload and stores the returned file path in the $data['signature]
        if ($request->hasFile('signature')) {
            $data['signature'] = $this->uploadSignature($request->file('signature'), $data['firstname'], $data['lastname']);
        }

        try {
            User::create($data);
            Alert::success('Create User', 'User created successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Something went wrong, please try again');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}


    public function changeSignature(Request $request)
    {
        $validated = $request->validate([
            'signature' => 'required|image|mimes:png|max:2048',
        ]);
        //dd($validated);
        try {
            $user = User::find($request->user_id);

            if ($request->hasFile('signature')) {
                if ($user->signature) {
                    Storage::disk('public')->delete($user->signature);
                }
                $newSignature = $this->uploadSignature($request->file('signature'), $user->firstname, $user->lastname);
                $user->update(['signature' => $newSignature]);
            }


            Alert::success('Changed Signature', 'You successfully changed your signature');
        } catch (\Exception $e) {
            Alert::error('Error', 'Something went wrong, please try again');
        }
        return redirect()->back();
    }

    public function removeSignature(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        try {
            $user = User::findOrFail($request->input('user_id'));

            if ($user->signature) {
                Storage::disk('public')->delete($user->signature);
                $user->update(['signature' => null]);
            }

            Alert::success('Signature Removed', 'The signature has been successfully removed.');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Something went wrong, please try again');
            return redirect()->back();
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $user = User::find($id);
            $validate = $request->validate([
                'firstname' => 'required|string|min:2|max:255',
                'lastname' => 'required|string|min:2|max:255',
                'contact_number' => 'required|string|regex:/^(\d+[-]?)*\d+$/',
            ]);
            $user->firstname = $validate['firstname'];
            $user->lastname = $validate['lastname'];
            $user->contact_number = $validate['contact_number'];
            $user->save();
            Alert::success('Update Successful', 'You successfully updated your personal information');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Something went wrong, please try again');
            return redirect()->back();
        }
    }

    // changing of email --- h
    public function changeEmail(Request $request, string $id)
    {
        $request->validate([
            'new_email' => 'required|email|unique:users,email',
        ]);

        try {
            $user = User::find($id);
            $user->email = $request->new_email;
            $user->email_verified_at = null;
            $user->save();

            if (!$user->hasVerifiedEmail()) {
                $user->sendEmailVerificationNotification();
            }
            return redirect()->route('verify');
        } catch (\Exception $e) {
            Alert::error('Error', 'Something went wrong, please try again');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function uploadSignature($file, $firstname, $lastname)
    {
        $fileExtension = $file->getClientOriginalExtension();
        $fileName = strtolower($firstname . '_' . $lastname) . '.' . $fileExtension;
        return $file->storeAs('images/signatures', $fileName, 'public');
    }


    public function assignTemporaryAdmin(Request $request)
    {
        try {
            $validated = $request->validate([
                'technician_id' => 'required|exists:users,id',
            ]);
            $technician = User::findOrFail($validated['technician_id']);

            $technician->role = "Admin";
            $technician->is_temporary_admin = 1;
            $technician->save();

            Alert::success('Success', 'You successfully assign a temporary admin.');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Something went wrong, please try again');
            return redirect()->back();
        }
    }

    public function cancelTemporaryAdmin(Request $request)
    {
        try {
            $validated = $request->validate([
                'technician_id' => 'required|exists:users,id',
            ]);
            $technician = User::findOrFail($validated['technician_id']);

            $technician->role = "Technician";
            $technician->is_temporary_admin = 0;
            $technician->save();

            Alert::success('Success', 'You successfully changed back the role to technician.');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Something went wrong, please try again');
            return redirect()->back();
        }
    }
}
