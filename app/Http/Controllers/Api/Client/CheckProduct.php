<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\InvctTable;
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
    public function __invoke($pt_syslog_code)
    {
        try {
            $product = PtMaster::where('pt_syslog_code', $pt_syslog_code)->first();

            if (!$product) {
                return response()->json([
                    'status' => 'not found',
                    'message' => 'product not found'
                ], 404);
            }

            $cost = InvctTable::where([
                ['invct_pt_id', '=', $product->pt_id],
                ['invct_si_id', '=', 992]
            ])->first('invct_cost');

            return response()->json([
                'status' => 'success',
                'message' => 'success to get detail product',
                'data' => compact('product', 'cost')
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
