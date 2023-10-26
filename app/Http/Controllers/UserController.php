<?php

namespace App\Http\Controllers;

use App\Models\TConfGroup;
use JWTAuth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $user = User::where([
                'usernama' => $request->usernama,
                'password' => $request->password
            ])->first();

            if (!$user) {
                return response()->json([
                    'status' => 'rejected!',
                    'message' => 'username or password incorrect'
                ], 300);
            }

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'token' => $token
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'pesan' => 'gagal untuk masuk',
                'galat' => $th->getMessage()
            ], 400);
        }
    }

    public function profile()
    {
        try {
            $user = User::where('userid', Auth::user()->userid)->with('TConfGroup')->first();

            return response()->json([
                'status' => 'success',
                'message' => 'success to get profile',
                'profile' => $user
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get profile',
                'error' => $th->getMessage()
            ], 200);
        }
    }
}
