<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\PtMaster;
use Illuminate\Http\Request;
use App\Models\SoDDetail;
use App\Models\SoMaster;
use Illuminate\Support\Facades\Auth;

class History extends Controller
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
            if (request()->start_date && request()->end_date) {
                $histories = SoMaster::whereIn('so_oid', function ($query) {
                    $query->select('sod_so_oid')
                        ->from('public.sod_det')
                        ->where('sod_upd_by', Auth::user()->usernama)
                        ->whereBetween('sod_upd_date', [request()->start_date, request()->end_date])
                        ->distinct('sod_so_oid')->get();
                })->with('SoDDetail')->limit(5);

                return response()->json([
                    'status' => 'success',
                    'message' => 'success to get data',
                    'histories' => $histories
                ], 200);
            }

            $histories = SoMaster::whereIn('so_oid', function ($query) {
                $query->select('sod_so_oid')
                    ->from('public.sod_det')
                    ->where('sod_upd_by', Auth::user()->usernama)
                    ->distinct('sod_so_oid')->get();
            })->with('SoDDetail')->limit(5);

            return response()->json([
                'status' => 'success',
                'message' => 'success to get history',
                'history' => $histories
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get histories',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
