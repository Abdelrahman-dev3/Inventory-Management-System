<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class signupController extends Controller
{
        function signup() {
        return view("signup");
    }

    function store(Request $request) {
        // validition
        $request->validate([
            'username' => 'required|unique:users,user_name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);
        // insert
        User::create([
        'user_name' => $request->username,
        'email' => $request->email,
        'password' => $request->password,
    ]);

    return redirect()->route('login');

    }
}
