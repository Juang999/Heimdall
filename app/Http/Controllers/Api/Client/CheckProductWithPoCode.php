<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\PoMaster;
use Illuminate\Http\Request;

class CheckProductWithPoCode extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($po_code)
    {
        try {
            $data = PoMaster::where('po_code', $po_code)->first();

            return response()->json([
                'status' => 'success',
                'message' => 'success to get data',
                'data' => $po_code
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get data',
                'error' => $th->getMessage(),
                'line' => $th->getLine()
            ], 400);
        }
    }
}
