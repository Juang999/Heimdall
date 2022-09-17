<?php

namespace App\Http\Controllers\Api\Historical;

use App\Http\Controllers\Controller;
use App\Models\GltDetail;
use App\Models\InvcMaster;
use App\Models\InvhMaster;
use App\Models\PtMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HistoricalController extends Controller
{
    public $qtyOld = 0;

    public function invc($ptId, $locId, $qty)
    {
        try {
            $data = InvcMaster::where('invc_pt_id', $ptId)->first();

            if (!$data) {
                $data = InvcMaster::create([
                    'invc_oid' => Str::uuid(),
                    'invc_dom_id' => 1,
                    'invc_si_id' => 992,
                    'invc_loc_id' => $locId,
                    'invc_pt_id' => $ptId,
                    'invc_qty_avaliable' => 0,
                    'invc_qty' => $qty,
                    'invc_qty_old' => 0
                ]);

                $this->qtyOld = $data->invc_qty_old;
            } else {
                $data->update([
                    'invc_qty' => $data->invc_qty + $qty,
                    'invc_qty_old' => $data->invc_qty_old + $data->invc_qty
                ]);

                $newData = InvcMaster::where('incv_pt_id', $ptId)->first();

                $this->qtyOld = $newData->invc_qty_old;
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to add or update data',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function invh($ptId, $locId)
    {
        try {
            InvhMaster::create([
                'invh_oid' => Str::uuid(),
                'invh_dom_id' => 1,
                'invh_date' => Carbon::translateTimeString(now()),
                'invh_desc' => 'Inventory Receipt',
                'invh_si_id' => 992,
                'invh_loc_id' => $locId,
                'invh_pt_id' => $ptId,
                'dt_timestamp' => Carbon::translateTimeString(now()),
                // 'invh_avg_cost' => NULL,
                'invh_qty_old' => $this->qtyOld
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'messaget' => 'failed to create history',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function glt($ptId, $credit)
    {
        $pt = PtMaster::where('pt_id', $ptId)->first();

        try {
            GltDetail::create([
                'glt_oid' => Str::uuid(),
                'glt_dom_id' => 1,
                'glt_add_by' => Auth::user()->usernama,
                'glt_add_date' => Carbon::translateTimeString(now()),
                'glt_date' => Carbon::translateTimeString(now()),
                'glt_type' => 'IR',
                'glt_cc_id' => 0,
                'glt_desc' => 'Inventory Receipt '.$pt->pt_code.' '.$pt->desc1,
                'glt_credit' => $credit,
                'glt_dt' => Carbon::translateTimeString(now()),
                'glt_is_reverse' => 'N'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
