<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\PtMaster;
use Illuminate\Http\Request;

class CheckProduct extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($pt_code)
    {
        try {
            $product = PtMaster::where('pt_code', $pt_code)->first();

            return response()->json([
                'status' => 'success',
                'message' => 'success to get detail product',
                'data' => $product
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get detail product',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
