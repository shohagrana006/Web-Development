<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use Auth;
use Hash;
use Image;
use Mail;
use App\Mail\ChangePasswordMail;

class ProfileController extends Controller
{
    function editProfile() {
      return view (' admin.profile.edit_profile');
    }

    function editName(Request $request) {
      $request->validate([
        'profile_name' => 'required',
      ]);
      if (Auth::user()->updated_at->addDays(31) < Carbon::now()) {
        User::find(Auth::id())->update([
          'name'  => $request->profile_name,
        ]);
      }else {
        $diffDays = Carbon::now()->diffInDays(Auth::user()->updated_at->addDays(31));
        return back()->with('nameChange', "You can not change name within ".$diffDays." days.");
      }
      return back()->with('nameChange', "Successfully Your name change");
    }

    function changePassword(Request $request) {
      $request->validate([
        'old_password'          => 'required',
        'password'              => 'required|confirmed|min:8',
      ]);
      if (Hash::check($request->old_password, Auth::user()->password)) {
        if ($request->old_password == $request->password) {
          return back()->with('passChange', "This password is already set");
        } else {
          User::find(Auth::id())->update([
            'password' => Hash::make($request->password),
          ]);

          // send mail of change password start
          Mail::to(Auth::user()->email)->send(new ChangePasswordMail(Auth::user()->name));
          return back()->with('passChange', "your password is change");
          // send mail of change password end
        }
      } else {
        return back()->with('passChange', "your old password is wrong");
      }

    }

    function changeProfileImage(Request $request) {
      $request->validate([
        'profile_photo' => 'image',
      ]);
      if ($request->hasFile('profile_photo')) {
        if (Auth::user()->profile_photo != 'default.png') {
          // old image delete
          $oldImageLocation = 'public/uploads/profile_photos/'.Auth::user()->profile_photo;
          unlink(base_path($oldImageLocation));
        }
        $uploadPhoto      = $request->file('profile_photo');
        $newPhotoName     = Auth::id().'.'.$uploadPhoto->getClientOriginalExtension();
        $newPhotoLocation = 'public/uploads/profile_photos/'.$newPhotoName;
        Image::make($uploadPhoto)->resize(300, 300)->save(base_path($newPhotoLocation), 70);
        User::find(Auth::id())->update([
          'profile_photo' => $newPhotoName,
        ]);
        return back()->with('imageChange', 'Image change successfully done');
      } else {
        echo "please insert your image";
      }
    }





}
