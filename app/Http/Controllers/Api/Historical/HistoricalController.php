<?php

namespace App\Http\Controllers\Api\Historical;

use App\Http\Controllers\Controller;
use App\Models\INVC;
use App\Models\INVH;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class HistoricalController extends Controller
{
    public function invc(Request $request)
    {

        try {
            $oldData = INVC::where('invc_pt_id', $request->pod_pt_id)->first();
            if (!$oldData) {
                $data = INVC::create([
                    'invc_oid' => Str::uuid(),
                    'invc_dom_id' => 1,
                    'invc_si_id' => 992,
                    'invc_loc_id' => $request->loc_id,
                    'invc_pt_id' => $request->pt_id,
                    'invc_qty_avaliable' => $request->qty_avaliable,
                    'invc_qty' => $request->qty,
                    'invc_qty_old' => 0,
                    'invc_qty_alloc' => 0,
                    'invc_total' => 0,
                    'invc_qty_booking' => 0
                ]);
            } else {
                $newData = $oldData->update([
                    'invc_upd_by' => Auth::user()->usernama,
                    'invc_upd_date' => Carbon::translateTimeString(now()),
                    'invc_qty' => $oldData->invc_qty + $request->qty,
                    'invc_qty_old' => $oldData->invc_qty
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to update or create data',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function invh(Request $request)
    {
        try {
            INVH::create([
                'invh_oid' => Str::uuid(),
                'invh_dom_id' => 1,
                'invh_en_id' => $request->en_id,
                // ''
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
