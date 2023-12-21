<?php

namespace App\Http\Controllers\API;
use App\Helpers\ResponseHelper;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

use Carbon\Carbon;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'phoneNumber' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('phoneNumber', 'password');
        $token = Auth::attempt($credentials, ['exp' => Carbon::now()->addDays(7)->timestamp]);
       // $token = Auth::attempt($credentials);

        if (!$token) {
            return ResponseHelper::error('Faild login');
        }
        $user = Auth::user();
        $user->image;
        $response = [
            'data' => ['user'=>$user,'token'=>$token]
        ];
        return ResponseHelper::success($response);    }

    public function register(Request $request)
    {

        ///edit her by ghfran (add validate)
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'birthDate'=>'required',
            'phoneNumber'=>'required|min:10|max:10||unique:users',
            'role'=>'required'

        ]);




        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'birthDate'=>$request->birthDate,
            'phoneNumber'=>$request->phoneNumber,
            'role'=>$request->role,

        ]);


        return ResponseHelper::success([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return ResponseHelper::success([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
