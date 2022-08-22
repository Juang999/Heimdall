<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Si as ModelSi;

class Si extends Controller
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
            $si_data = ModelSi::get();

            return response()->json([
                'status' => 'success',
                'message' => 'success to get si_data',
                'si' => $si_data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get si_data',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
