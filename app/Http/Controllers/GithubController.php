<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Hash;
use Auth;
use App\User;
use Carbon\Carbon;

class GithubController extends Controller
{
   public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();
        if (!User::where('email', $user->getEmail())->exists()) {
            User::insert([
                'name'       => $user->getNickname(),
                'email'      => $user->getEmail(),
                'role'       => 2,
                'password'   => Hash::make('abc@123'),
                'created_at' => Carbon::now(),
            ]);
        }
        
        if (Auth::attempt(['email' => $user->getEmail(), 'password' => 'abc@123'])) {
            return redirect('customer/home');
        }
    }
}