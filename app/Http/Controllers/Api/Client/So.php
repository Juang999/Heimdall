<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\So as ModelSo;

class So extends Controller
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
            $so_data = ModelSo::paginate(100);

            return response()->json([
                'status' => 'success',
                'message' => 'success to get so_data',
                'so' => $so_data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get so_data',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
