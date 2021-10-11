<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UserDetailRequest;
use App\Models\User;
use Auth;
use Hash;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('admin.profile');
    }

    public function saveUserDetail(UserDetailRequest $request)
    {
        $userId = auth()->user()->id;
        $data = [
            'name' => $request->name,
            'phone_number' => $request->phone_number,
        ];

        if ($request->hasFile('profile_pic')) {
            $profilePic = $request->file('profile_pic');
            $fileName = time() . rand(1111, 9999) . '-user-'. $userId."." . $profilePic->getClientOriginalExtension();
            $filePath = $profilePic->storeAs('profile', $fileName);
            $data['profile_pic'] = $filePath;
        } 

        User::where('id', $userId)->update($data);

        return redirect()->route('admin.home');
    }

    public function updatePassword(ProfileRequest $request)
    {
        $oldPassword = $request->old_password;
        $user = Auth::user();

        if (!Hash::check($oldPassword, $user->password)) {
            return back()->with('error', __('user.validations.oldPasswordIncorrect'));
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', __('user.messages.passwordChanged'));
    }
}
