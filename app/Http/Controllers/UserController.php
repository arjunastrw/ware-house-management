<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\User; // Make sure this import is correct
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the users.
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {

        // Check if the user has the 'Admin' role
        if (auth()->check() && auth()->user()->roles === 'Admin') {
            $users = $model->paginate(5);
            return view('users.index', compact('users'));
        } else {
            // Redirect or show an error view
            return redirect('/dashboard')->with('error', 'You do not have permission to access this page.');
        }

    }

    public function userOnlineStatus()
    {
        $users = User::all();
        foreach ($users as $user) {
            if (Cache::has('user-online' . $user->id)) {
                echo $user->name . " is online. <br>";
            } else {
                echo $user->name . " is offline <br>";
            }
        }
    }

    public function store(Request $request)
    {
        try{
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:8|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|string|in:Admin,inspector', // Add other roles as needed
        ]);

        // Create a new user with the provided data and set the role
        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'nik' => $request->nik,
            'password' => Hash::make($request->password),
            'roles' => $request->roles,
        ]);

        // Redirect the user to a desired location after saving to the database
        return redirect()->back()->with('success', 'User successfully added!');
    } catch (\Exception $e) {
        // Handle the error and provide feedback to the user
            $errorData = ['message' => 'Failed to add User. Please try again.'];

        return redirect()->back()->with('error', $errorData);
    }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:255|unique:users,nik,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);

        $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->nik = $request->input('nik');

        // Check if the password should be updated
        if ($request->has('password') && !empty($request->input('password'))) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->back()->with('success', 'User successfully updated!');
    }

    public function destroy($id)
    {
        //fungsi eloquent untuk menghapus data
        User::find($id)->delete();
        return redirect()->back()->with('success', 'Admin Successfully Deleted Dihapus!');
    }
}
