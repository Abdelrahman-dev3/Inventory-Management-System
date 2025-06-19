<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class profileController extends Controller
{
        function profile() {
            $user = User::find(Auth::user()->id);
        return view("profile" , ['user' => $user]);
    }
        function profile_edit() {
            $user = User::find(Auth::user()->id);

        return view("profile_edit" , ['user' => $user]);
    }

            function update(Request $request) {
        // validition
        $request->validate([
            'user_name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
        ]);
        
        $user = User::find(Auth::user()->id);
        $filename = $user->user_image;

        if ($request->hasFile('user_image')) {
            $file = $request->file('user_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/users'), $filename);
        }
        // update
        $user->update([
        'user_name' => $request->user_name,
        'email' => $request->email,
        'user_image' => $filename,
    ]);

    return redirect()->route('profile')->with('success', 'Profile Updated Successfully');

    }

    function changepass(Request $request) {
    $request->validate([
        'OldPassword' => 'required',
        'NewPassword' => 'required|min:8',
    ]);
    if (!Hash::check($request->OldPassword, Auth::user()->password)) {
    return back()->withErrors(['OldPassword' => 'The old password is incorrect.']);
    }
    $user = Auth::user();
    $user->password = Hash::make($request->NewPassword);
    $user->save();

return back()->with('success', 'Password updated successfully.');
    }
}

