<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\PoDDetail;
use App\Models\PoMaster;
use App\Models\PtMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\Historical\HistoricalController;
use App\Models\RiumMaster;

class InventoryReceipt extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {

            $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');

            $lastDate = Carbon::now()->lastOfMonth()->format('Y-m-d');

            $data = RiumMaster::whereBetween('rium_add_date', [$startDate, $lastDate])->count();

            $increment = "0000";

            if (!$data) {
                $increment += 1;
            }

            dd($increment);

            DB::beginTransaction();
                $riumMaster = RiumMaster::create([
                    'rium_oid' => Str::uuid(),
                    'rium_dom_id' => 1,
                    'rium_en_id' => 1,
                    'rium_add_date' => Carbon::translateTimeString(now()),
                    'rium_add_by' => Auth::user()->usernama,
                    'rium_date' => Carbon::translateTimeString(now()),
                    // 'rium_type2' =>
                    'rium_rmks' => $request->remarks,
                    'rium_sb_id' => 0,
                    'rium_cc_id' => 0,
                    'rium_si_id' => 992,
                    'rium_pjc_id' => 991,
                    'rium_total' => $request->total,
                    'rium_tran_id' => 19,
                    'rium_trans_id' => 'I',
                    'rium_credit_term' => $request->creditTerm,
                ]);

                foreach ($request->details as $detail) {
                    $partnumber = PtMaster::where('pt_code', $request->ptCode)->first();

                    $riumMaster->detail = PoDDetail::create([
                        'pod_oid' => Str::uuid(),
                        'pod_dom_id' => 1,
                        'pod_add_by' => Auth::user()->usernama,
                        'pod_add_date' => Carbon::translateTimeString(now()),
                        'pod_po_oid' => $riumMaster->po_oid,
                        'po_si_id' => 992,
                        'pod_pt_id' => $partnumber->pt_id,
                        'pod_qty_receive' => $request->qtyReceive,
                        'pod_loc_id' => $request->locId
                    ]);
                }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'success to create Inventory Receive data',
                'data' => $riumMaster
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to create Inventory Receive data',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
