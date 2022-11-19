<?php

namespace App\Http\Controllers\API;

use App\Authentication\Authentication;
use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Cookie;

class AuthController extends ApiController
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'socialAuthentication']]);
    }

    public function login(Request $request)
    {
        $this->validators($request, 'login');

        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return $this->respondUnauthorizedError('Unauthorized User');
        }

        $cookie = $this->getCookie($token);
        $user = Auth::user();

        return $this->respond([
            'status' => 'success',
            'user' => $user,
            'authorization' => [
                'token' => $token,
            ],
        ])->withCookie($cookie);
    }

    public function register(Request $request)
    {
        $this->validators($request, 'register');

        $user = User::create([
            'uname' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'last_visit' => Carbon::now(),
        ]);

        $token = Auth::login($user);

        return $this->respondCreated('User created successfully');
    }

    public function logout()
    {
        Auth::logout();
        return $this->respond([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    private function getCookie($token)
    {
        return new Cookie(
            env('AUTH_COOKIE_NAME'),
            $token,
            auth()->factory()->getTTL(),
            null,
            "localhost",
            env('APP_DEBUG') ? false : true,
            true,
            false,
            'Strict'
        );
    }

    //validation rules.
    private function validators($request, $auth)
    {
        $rules = [];

        switch ($auth) {
            case 'login':
                $rules = [
                    'email' => 'required|string|email',
                    'password' => 'required|string|min:6',
                ];
                break;
            case 'register':
                $rules = [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'phone_number' => 'required|numeric|digits:9',
                    'password' => 'required|string|min:6',
                ];
                break;
        }

        //validate the request.
        return $request->validate($rules);
    }

    public function socialAuthentication(Request $request)
    {
        $socAuth = new Authentication();

        // return $socAuth->redirectTo();
    }

}
