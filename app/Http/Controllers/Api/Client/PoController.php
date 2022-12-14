<?php

namespace App\Http\Controllers\Api\Client;

use Carbon\Carbon;
use App\Models\PoMaster;
use App\Models\PoDDetail;
use App\Http\Requests\PoRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PoController extends Controller
{
    public function show($po_code)
    {
        try {
            $po = PoMaster::where('po_code', $po_code)->with('PoDDetail.PtMaster')->first([
                'po_oid',
                'po_add_by',
                'po_add_date',
                'po_code'
            ]);

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

    public function update(PoRequest $request)
    {
        try {
            DB::beginTransaction();
            $products = json_decode($request->products, true);

            foreach ($products as $product) {
                PoDDetail::where('pod_oid', $product["pod_oid"])->update([
                    'pod_upd_by' => Auth::user()->usernama,
                    'pod_upd_date' => Carbon::translateTimeString(now()),
                    'pod_qty_receive' => $product["qtyReceive"],
                    'pod_loc_id' => $product["locId"]
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'success to check transaction',
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get check transaction',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function history()
    {
        try {
            $data = PoMaster::whereIn('po_oid', function ($query) {
                $query->select('pod_po_oid')
                ->from('public.pod_det')
                ->where('pod_upd_by', Auth::user()->usernama)
                ->distinct('pod_po_oid')
                ->get();
            })->limit(5)->get(['po_oid', 'po_add_by', 'po_add_date', 'po_code']);

            return response()->json([
                'status' => 'success',
                'message' => 'success to get data history from pre-order',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get history from pre-order',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function toDay()
    {
        try {
            $data = DB::table('public.po_mstr')
                            ->selectRaw('po_code AS code, po_date AS date, po_add_date')
                            ->where('po_date', Carbon::now()->format('Y-m-d'))
                            ->whereIn('po_oid', function ($query) {
                                $query->select('pod_po_oid')
                                    ->from('public.pod_det')
                                    ->where([
                                        ['pod_upd_by', '=', NULL],
                                        ['pod_upd_date', '=', NULL],
                                        ['pod_qty_receive', '=', NULL]
                                    ])
                                    ->distinct('pod_po_oid')
                                    ->get();
                            })
                            ->orderBy('po_add_date', 'DESC')
                            ->paginate(100);

            return response()->json([
                'status' => 'success',
                'message' => 'success to get data today',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get data today',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
