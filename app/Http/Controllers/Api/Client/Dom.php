<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Dom as ModelsDom;
use Illuminate\Http\Request;

class Dom extends Controller
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
            $dom_data = ModelsDom::get();

            return response()->json([
                'status' => 'success',
                'message' => 'success to get dom_data',
                'dom' => $dom_data
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get dom_data',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
