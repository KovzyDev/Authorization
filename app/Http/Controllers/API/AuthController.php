<?php

namespace App\Http\Controllers\API;

use App\Authentication\Authentication;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
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
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'skadosh',
            ],
        ]);
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
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'skadosh',
            ],
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
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
        $request->validate($rules);
    }

    public function socialAuthentication(Request $request)
    {
        $socAuth = new Authentication();

        // return $socAuth->redirectTo();
    }

}
