<?php

namespace App\Http\Controllers\Api\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TConfGroup;
use App\User;
use Illuminate\Support\Facades\Auth;

class Profile extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
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
