<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FacebookController extends Controller
{
    public function redirectTo()
    {
       return Socialite::driver('facebook')->redirect();
    }


    public function handleCallback()
    {
        try {

            $user = Socialite::driver('facebook')->user();

            $finduser = User::where('fbid', $user->id)->first();

            if($finduser){

                Auth::login($finduser);

                return redirect()->intended('home');

            }else{
                $newUser = User::updateOrCreate([
                        'email' => $user->email,
                        'uname' => $user->name,
                        'fbid'=> $user->id,
                        'password' => Hash::make(mt_rand(0, 9),mt_rand(0, 9),mt_rand(0, 9),mt_rand(0, 9)),
                    ]);

                Auth::login($newUser);

                return redirect()->intended('home');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
