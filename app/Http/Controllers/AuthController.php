<?php

namespace App\Http\Controllers;

use App\Models\Penyewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    // public function register(Request $req)
    // {
    //     //valdiate
    //     $rules = [
    //         'email' => 'required|string|unique:users',
    //         'password' => 'required|string',
    //         'confirm_password' => 'required|string',
    //     ];
    //     $validator = Validator::make($req->all(), $rules);
    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 400);
    //     }
    //     //create new user penyewa in users table model
    //     $penyewa = Penyewa::create([
    //         'email' => $req->email,
    //         'password' => Hash::make($req->password),
    //         'confirm_password' => Hash::make($req->password)
    //     ]);
    //     $token = $penyewa->createToken('Personal Access Token')->plainTextToken;
    //     $response = ['penyewa' => $penyewa, 'token' => $token];
    //     return response()->json($response, 200);
    // }

    public function register(Request $req)
    {
        //valdiate
        $rules = [
            'email' => 'required|string|unique:users',
            'password' => 'required|string',

        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        //create new user in users table
        $user = User::create([
            'email' => $req->email,
            'password' => Hash::make($req->password)
        ]);
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        $response = ['user' => $user, 'token' => $token];
        return response()->json($response, 200);
    }

    public function login(Request $req)
    {
        // validate inputs
        $rules = [
            'email' => 'required',
            'password' => 'required|string'
        ];
        $req->validate($rules);
        // find user email in users table
        $user = User::where('email', $req->email)->first();
        // if user email found and password is correct
        if ($user && Hash::check($req->password, $user->password)) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = ['user' => $user, 'token' => $token];
            return response()->json($response, 200);
        }
        $response = ['message' => 'Incorrect email or password'];
        return response()->json($response, 400);
    }
    // public function login(Request $req)
    // {
    //     // validate inputs
    //     $rules = [
    //         'email' => 'required',
    //         'password' => 'required|string',
    //         'confirm_password' => 'required|string'
    //     ];
    //     $req->validate($rules);
    //     // find user email in users table
    //     $penyewa = Penyewa::where('email', $req->email)->first();
    //     // if user email found and password is correct
    //     if ($penyewa && Hash::check($req->password, $user->password)) {
    //         $token = $penyewa->createToken('Personal Access Token')->plainTextToken;
    //         $response = ['penyewa' => $penyewa, 'token' => $token];
    //         return response()->json($response, 200);
    //     }
    //     $response = ['message' => 'Incorrect email or password'];
    //     return response()->json($response, 400);
    // }
}
