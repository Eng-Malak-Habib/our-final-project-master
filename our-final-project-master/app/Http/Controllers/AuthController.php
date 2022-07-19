<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'changePassword']]);
    }
    // /**
    //  * Handles Registration Request
    //  *
    //  * @param Request $request
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function register(Request $request)
    // {
    //     $this->validate($request, [
    //         'email' =>  'required|unique:users|max:255|email',
    //         'name' =>  'required',
    //         'password' =>  'required|confirmed|min:8',
    //         'Lawyer_National_Number' => 'required|unique:users|digits:14',
    //     ]);

    // User::insert([
    //     'name' => $request->name,
    //     'email' => $request->email,
    //     'password' => Hash::make($request->password),
    //     'Lawyer_National_Number' => $request->Lawyer_National_Number,
    //     'Role' => 'Lawyer',
    //     'status' => 'online',
    // ]);
    //     return $this->login($request);
    // }
    public function register(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'Lawyer_National_Number' => 'required|unique:users|digits:14',
            'password' => 'required|confirmed|min:8',
        ]);
        if (!$validation) {
            return response()->json($validation->errors(), 202);
        }

        User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'Lawyer_National_Number' => $request->Lawyer_National_Number,
            'address' => $request->address,
            'profile_photo_path' => $request->profile_photo_path,
            'phone' => $request->phone,
            'DOB' => $request->DOB,
            'Gender' => $request->Gender,
            'Role' => 'Lawyer',
            'status' => 'offline',
            'created_at' => Carbon::now(),
        ]);

        return $this->login($request);
    }

    public function login(Request $request)
    {
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            $user = Auth::user();
            $token = $user->createToken('api-Application')->accessToken;
            return $this->respondWithToken($token);
        } else {
            return response()->json([
                'status' => 'false',
                'message' => 'Email or password is incorrect',
                'data' => null,
            ], 203);
        }
    }


    // /**
    //  * Handles Login Request
    //  *
    //  * @param Request $request
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function login(Request $request)
    // {

    //     $credentials = [
    //         'email' => $request->email,
    //         'password' => $request->password
    //     ];

    //     if (auth()->attempt($credentials)) {
    //         $token = auth()->user()->createToken('Graduation')->accessToken;
    //         return $this->respondWithToken($token);
    //     } else {
    // return response()->json([
    //     'status' => 'false',
    //     'message' => 'Email or password is incorrect',
    //     'data' => null,
    // ], 401);
    //     }
    // }





    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'logged in successfully',
            'access_token' => $token,
            'data' => Auth::user(),
        ]);
    }
}
