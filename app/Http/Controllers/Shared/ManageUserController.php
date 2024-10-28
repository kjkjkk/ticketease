<?php

namespace App\Http\Controllers\Shared;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use RealRashid\SweetAlert\Facades\Alert;

class ManageUserController extends Controller
{
    protected $roles = ['Admin', 'Technician', 'Requestor'];

    public function index(Request $request)
    {
        $roles = ['Admin', 'Technician', 'Requestor'];

        $usersQuery = User::query();
        $technicians = User::where('role', '=', 'Technician')->where('user_status', '=', 'Active')->where('is_temporary_admin', '=', 0)->get();
        //if the request contains the 'role' parameter, it adds a condition to the query to filter users by the specified r ole
        if ($request->filled('role')) {
            $usersQuery->where('role', $request->input('role'));
        }

        //if the request contains the 'searchUser' parameter, it adds a condition to the query to filter users by their firstname or lastname
        if ($request->filled('searchUser')) {
            $searchTerm = $request->input('searchUser');
            $usersQuery->where(function ($query) use ($searchTerm) {
                $query->where('firstname', 'like', "%{$searchTerm}%")
                    ->orWhere('lastname', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('userID')) {
            $searchID = $request->input('userID');
            $usersQuery->where(function ($query) use ($searchID) {
                $query->where('id', $searchID);
            });
        }
        // executes the query and limits the number of users per page
        $users = $usersQuery->paginate(6)->appends($request->all());
        $searchTerm = $request->input('searchUser', '');

        // passes the retrieved users, roles, and search term back to the view for rendering
        return view('pages.shared.manage-users', compact('users', 'roles', 'searchTerm', 'technicians'));
    }
    // resets the user password to the default value
    public function resetPassword(Request $request)
    {
        //first validates the id
        $request->validate([
            'id' => 'required|exists:users,id',
        ]);

        try {
            //retrieves the 'id'. attempts to find the user with the given id
            $user = User::findOrFail($request->input('id'));
            //getDefaultPassword method retrieves the default password value, hashed
            $user->password = Hash::make(User::getDefaultPassword());
            $user->save();
            Alert::success('Reset Password', 'Password reset successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('An error occured',  'Please try again');
            return redirect()->back()->back();
        }
    }

    public function updateUserStatus(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:users,id',
        ]);

        try {
            //retrieves the 'id'. attempts to find the user with the given id
            $user = User::findOrFail($request->input('id'));
            //if user is active, set status into inactive, else if user is inactive set it into active
            $user->user_status = $user->user_status === 'Active' ? 'Inactive' : 'Active';
            $userStatus = $user->user_status === "Active" ? 'User Reactivated' : 'User Deactivated';
            $user->save();
            Alert::success($userStatus, 'User status updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('An error occured', 'Please try again');
            return redirect()->back();
        }
    }

    public function destroy(Request $request)
    {
        try {
            //finds the user by the given ID
            $user = User::findOrFail($request->input('id'));
            $user->delete();
            Alert::success('Delete User', 'User deleted successfully!');
            return redirect()->route('shared.manage-users');
        } catch (\Illuminate\Database\QueryException $e) {
            //catches the exception if a database related error occurs
            Alert::warning('Warning',  'You can not delete this user!');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::warning('Error',  'An Error occured');
            return redirect()->back();
        }
    }
}
