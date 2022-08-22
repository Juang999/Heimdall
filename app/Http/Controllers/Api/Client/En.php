<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\En as ModelEn;

class En extends Controller
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
            $en_data = ModelEn::get();

            return response()->json([
                'status' => 'success',
                'message' => 'success to get entity',
                'entity' => $en_data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get entity',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
