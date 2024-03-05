<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Gate;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('profile.edit');
    }


    
    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PasswordRequest $request)
    {
        $userId = auth()->id();
        $newPassword = Hash::make($request->get('password'));

        User::where('id', $userId)->update(['password' => $newPassword]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }
}
