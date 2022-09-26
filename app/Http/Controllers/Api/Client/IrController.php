<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\RiumDDetail;
use App\Models\RiumMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class IrController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // dd($request->all());

                $rawData = RiumMaster::whereBetween('rium_add_date', [
                    Carbon::now()->firstOfMonth()->format('Y-m-d'), Carbon::now()->lastOfMonth()->format('Y-m-d')
                ])->count();

                if (!$rawData) {
                    $rawData = 1;
                } else {
                    $rawData++;
                }
                
                $base = "0000";

                $func = array_slice(str_split($base), 0, -strlen($rawData));
                $data = implode($func).$rawData;

            // dd("IRM0".$request->enId.Carbon::now()->format('ym')."00001".$data);

            $riumMaster = RiumMaster::create([
                    'rium_oid' => Str::uuid(),
                    'rium_dom_id' => 1,
                    'rium_en_id' => $request->enId,
                    'rium_add_by' => Auth::user()->usernama,
                    'rium_add_date' => Carbon::translateTimeString(now()),
                    'rium_type2' => "IRM0".$request->enId.Carbon::now()->format('ym')."00001".$data,
                    'rium_date' => Carbon::now()->format('Y-m-d'),
                    // 'rium_type' => "IRM",
                    'rium_remarks' => $request->remarks,
                    // 'rium_dt' => Carbon::now()->format('Y-m-d')
                ]);

                $values = json_decode($request->products, true);
                // dd(json_encode($values));
                foreach($values as $value) {
                    RiumDDetail::create([
                        'riumd_oid' => Str::uuid(),
                        'riumd_rium_oid' => $riumMaster->rium_oid,
                        'riumd_pt_id' => $value["ptId"],
                        'riumd_qty' => $value["qty"],
                        'riumd_um' => $value["um"],
                        'riumd_um_conv' => 1,
                        'riumd_qty_real' => $value["qty"],
                        'riumd_si_id' => 992,
                        'riumd_loc_id' => $request["locId"],
                        'riumd_cost' => $request["cost"],
                        'riumd_ac_id' => $request["acId"],
                        'riumd_sb_id' => 0,
                        'riumd_cc_id' => 0,
                        'riumd_dt' => Carbon::now()->format('Y-m-d'),
                        'riumd_cost_total' => $value["costTotal"]
                    ]);
                }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'success to post data',
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'status' => 'failed',
                'message' => 'failed to post data',
                'error' => $th->getMessage(),
                'line' => $th->getLine()
            ], 400);
        }
    }

    public function history()
    {
        try {
            $data = RiumMaster::where('rium_add_by', Auth::user()->usernama)->with('RiumDDetail.PtMaster')->get();

            return response()->json([
                'status' => 'success',
                'message' => 'success to get history Inventory Receive',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get history Inventory Receive',
                'error' => $th->getMessage(),
                'errorLine' => $th->getLine()
            ], 400);
        }
    }
}