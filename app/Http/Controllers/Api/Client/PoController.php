<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryReceiveRequest;
use App\Http\Requests\PORequest;
use App\Models\PoDDetail;
use App\Models\PoMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Api\Historical\HistoricalController;

class PoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InventoryReceiveRequest $request)
    {
        try {
            DB::beginTransaction();

            $inventoryReceive = PoMaster::create([
                'po_oid' => Str::uuid(),
                'po_dom_id' => 1,
                'po_en_id' => 1,
                'po_add_date' => Carbon::translateTimeString(now()),
                'po_add_by' => Auth::user()->usernama,
                'po_rmks' => $request->inventory_code
            ]);

            $number = 0;

            foreach ($request->details as $detail) {
                PoDDetail::create([
                    'pod_oid' => Str::uuid(),
                    'pod_dom_id' => 1,
                    'pod_add_by' => Auth::user()->usernama,
                    'pod_add_date' => Carbon::translateTimeString(now()),
                    'pod_po_oid' => $inventoryReceive->po_oid,
                    'pod_seq' => $number,
                    'pod_si_id' => 992,
                    'pod_pt_id' => $detail->pt_id,
                    'pod_qty' => $detail->qty,
                    'pod_qty_receive' => $detail->qty_receive,
                    'pod_cost' => $detail->cost,
                    'pod_disc' => 0,
                    'pod_sb_id' => 0,
                    'pod_cc_id' => 0,
                    'pod_pjr_id' => 0,

                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'success to create Inventory Receive data',
                'data' => $inventoryReceive
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to create data',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($po_code)
    {
        try {
            $po = PoMaster::where('po_code', $po_code)->with('PoDDetail.PtMaster')->first();

            return response()->json([
                'status' => 'success',
                'message' => 'success to get data Pre-Order',
                'po_detail' => $po
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get data Pre-Order',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PORequest $request, $pod_oid)
    {
        try {
            PoDDetail::where('pod_oid', $pod_oid)->update([
                'pod_upd_by' => Auth::user()->uaernama,
                'pod_upd_date' => Carbon::translateTimeString(now()),

            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'success to check transaction'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get check transaction',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
