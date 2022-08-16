<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cu as ModelCu;

class Cu extends Controller
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
            $cu_data = ModelCu::get();

            return response()->json([
                'status' => 'success',
                'message' => 'success to get cu_data',
                'cu' => $cu_data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get cu_data',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
