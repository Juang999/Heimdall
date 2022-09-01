<?php

namespace App\Http\Controllers;

use App\Models\TConfGroup;
use JWTAuth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;


class UserController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where([
            'usernama' => $request->usernama,
            'password' => $request->password
        ])->first();

        if (!$user) {
            return response()->json([
                'status' => 'rejected!',
                'message' => 'user not found!'
            ], 300);
        }

        try {
            if (! $token = JWTAuth::fromUser($user)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:6|confirmed',
    //     ]);

    //     if($validator->fails()){
    //         return response()->json($validator->errors()->toJson(), 400);
    //     }

    //     $user = User::create([
    //         'name' => $request->get('name'),
    //         'email' => $request->get('email'),
    //         'password' => Hash::make($request->get('password')),
    //     ]);

    //     $token = JWTAuth::fromUser($user);

    //     return response()->json(compact('user','token'),201);
    // }

    // public function getAuthenticatedUser()
    // {
    //     try {

    //         if (! $user = JWTAuth::parseToken()->authenticate()) {
    //             return response()->json(['user_not_found'], 404);
    //         }

    //     } catch (PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException $e) {

    //         return response()->json(['token_expired'], $e->getStatusCode());

    //     } catch (PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException $e) {

    //         return response()->json(['token_invalid'], $e->getStatusCode());

    //     } catch (PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException $e) {

    //         return response()->json(['token_absent'], $e->getStatusCode());

    //     }

    //     return response()->json(compact('user'));
    // }

    // public function getUser()
    // {
    //     try {
    //         $user = User::get();

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'success to get data',
    //             'data' => $user
    //         ], 200);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => 'failed to get data',
    //             'error' => $th->getMessage()
    //         ], 200);
    //     }
    // }

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
