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
                $histories = SoDDetail::wherre('sod_upd_by', Auth::user()->usernama)
                ->whereBetween('sod_upd_date', [request()->start_date, request()->end_date])
                ->orderBy('sod_upd_date', 'DESC')->paginate(10);

                foreach ($histories as $history) {
                    $history->product = PtMaster::where('pt_id', $history->sod_pt_id)->get();
                    $history->so_master = SoMaster::where('so_oid', $history->sod_so_oid)->get();
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'success to get data',
                    'histories' => $histories
                ], 200);
            }

            $histories = SoDDetail::where('sod_upd_by', Auth::user()->usernama)
            ->orderBy('sod_upd_date', 'DESC')->paginate(10);

            foreach ($histories as $history) {
                $history->product = PtMaster::where('pt_id', $history->sod_pt_id)->get();
                $history->so_master = SoMaster::where('so_oid', $history->sod_so_oid)->get();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'success to get histories',
                'histories' => $histories
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
