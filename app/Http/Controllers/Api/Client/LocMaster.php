<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LocMaster as Location;

class LocMaster extends Controller
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
            $location = Location::get();

            return response()->json([
                'status' => 'success',
                'message' => 'success to get data location',
                'location' => $location
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get data location',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
