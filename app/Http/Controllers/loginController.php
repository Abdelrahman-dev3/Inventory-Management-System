<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    function login() {
        return view("login");
    }

    function regester(Request $request) {
                // validition
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
            $user = User::where('user_name', $request->username)->first();
                if ($user) {
        if (Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('dashboard')->with('success', 'User Login Successfully');
        } else {
            return back()->withErrors(['password' => 'Password is incorrect']);
        }
    } else {
        return back()->withErrors(['username' => 'Username not found']);
    }
    }
}
