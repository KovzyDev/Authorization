<?php
namespace App\Authentication;


use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GoogleAuth
{

    public function redirectTo()
    {
       return Socialite::driver('google')->stateless()->redirect();
    }


    public function handleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();

            $finduser = User::where('gmid', $user->getId())->first();

            if($finduser){

                Auth::login($finduser);

                return redirect()->intended('home');

            }else{
                $newUser = User::updateOrCreate([
                        'email' => $user->getEmail(),
                        'uname' => $user->getName(),
                        'gmid'=> $user->getId(),
                        'password' => Hash::make(mt_rand(0, 9),mt_rand(0, 9),mt_rand(0, 9),mt_rand(0, 9),mt_rand(0, 9),mt_rand(0, 9)),
                        'avatar' => $user->getAvatar(),
                    ]);

                Auth::login($newUser);

                return redirect()->intended('home');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
