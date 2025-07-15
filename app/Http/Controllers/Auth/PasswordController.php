<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */

     public function edit()
     {
         return view('profile.edit', [
             'activeSection' => 'password',
             'user' => auth()->user()
         ]);
     }
     

     public function update(Request $request)
     {
         $request->validate([
             'current_password' => ['required'],
             'password' => ['required', 'confirmed', Password::defaults()],
         ]);
 
         $user = Auth::user();
 
         if (!Hash::check($request->current_password, $user->password)) {
             return back()->withErrors(['current_password' => 'The provided current password is incorrect.']);
         }
 
         $user->update([
             'password' => Hash::make($request->password)
         ]);
 
         return redirect()->route('profile.show')->with('password_success', 'Password updated successfully.');
     }

}
