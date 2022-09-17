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
            DB::beginTransaction();
                $poMaster = PoMaster::create([
                    'po_oid' => Str::uuid(),
                    'po_dom_id' => 1,
                    'po_en_id' => 1,
                    'po_add_date' => Carbon::translateTimeString(now()),
                    'po_add_by' => Auth::user()->usernama,
                    'po_date' => Carbon::translateTimeString(now()),
                    'po_rmks' => $request->remarks,
                    'po_sb_id' => 0,
                    'po_cc_id' => 0,
                    'po_si_id' => 992,
                    'po_pjc_id' => 991,
                    'po_total' => $request->total,
                    'po_tran_id' => 19,
                    'po_trans_id' => 'I',
                    'po_credit_term' => $request->creditTerm,
                ]);

                foreach ($request->details as $detail) {
                    $partnumber = PtMaster::where('pt_code', $request->ptCode)->first();

                    $poMaster->detail = PoDDetail::create([
                        'pod_oid' => Str::uuid(),
                        'pod_dom_id' => 1,
                        'pod_add_by' => Auth::user()->usernama,
                        'pod_add_date' => Carbon::translateTimeString(now()),
                        'pod_po_oid' => $poMaster->po_oid,
                        'po_si_id' => 992,
                        'pod_pt_id' => $partnumber->pt_id,
                        'pod_qty_receive' => $request->qtyReceive,
                        'pod_loc_id' => $request->locId
                    ]);

                    $historical = new HistoricalController();

                    $historical->invc($partnumber->pt_id, $request->locId, $request->qtyReceive);
                    $historical->invh($partnumber->pt_id, $request->locId);
                    $historical->glt($partnumber->pt_id, $request->credit);
                }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'success to create Inventory Receive data',
                'data' => $poMaster
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
