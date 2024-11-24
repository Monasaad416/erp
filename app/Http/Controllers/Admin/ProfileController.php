<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Alert;

class ProfileController extends Controller
{
        public function editProfile()
    {
        $user = Auth::user();
        return view('admin.pages.profile.edit',compact('user'));
    }

    public function updateProfile(UpdateUserRequest $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        Alert::success('تم تعديل الملف الشخصي بنجاح');

        return redirect()->route('user.edit_profile');
    }


    public function editPassword()
    {
        $user = Auth::user();
        return view('admin.pages.profile.edit_password',compact('user'));
    }

    public function updatePassword(UpdateUserRequest $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        Alert::success(trans('تم تعديل كلمة السر بنجاح'));

        return redirect()->route('index');
    }
}
