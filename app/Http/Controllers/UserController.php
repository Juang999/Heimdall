<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\User;
use App\Models\TConfGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;


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
            $user = Auth::user();
            $user->group = TConfGroup::where('groupid', $user->groupid)->get();

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
            ], 400);
        }
    }
}
