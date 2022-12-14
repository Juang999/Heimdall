<?php

namespace App\Http\Controllers\Api\Client;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\SoRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\{SoMaster, SoDDetail};

class SoController extends Controller
{
    public function show($so_code)
    {
        try {
        $so_detail = SoMaster::where('so_code', $so_code)->with('SoDDetail.PtMaster')->first([
            'so_oid',
            'so_add_by',
            'so_add_date',
            'so_code'
        ]);

            return response()->json([
                'status' => 'success',
                'message' => 'success to get so detail',
                'so_detail' => $so_detail
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get so detail',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function update(SoRequest $request)
    {
        try {
            DB::beginTransaction();
            $products = json_decode($request->products, true);

            foreach ($products as $product) {
                SoDDetail::where('sod_oid', $product['sod_oid'])->update([
                    'sod_upd_by' => Auth::user()->usernama,
                    'sod_upd_date' => Carbon::translateTimeString(now()),
                    'sod_qty_checked' => $product["qtyChecked"]
                ]);
            }
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'success to update SO',
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to update SO',
                'error' => $th->getMessage(),
                'line' => $th->getLine()
            ], 400);
        }
    }

    public function history()
    {
        try {
            $data = SoMaster::whereIn('so_oid', function ($query) {
                $query->select('sod_so_oid')
                    ->from('public.sod_det')
                    ->where('sod_upd_by', Auth::user()->usernama)
                    ->distinct('sod_so_oid')
                    ->get();
            })->limit(5)->get(['so_oid', 'so_add_by', 'so_add_date', 'so_code']);

            return response()->json([
                'status' => 'success',
                'message' => 'success to get history',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get history',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function toDay()
    {
        try {
            $data = DB::table('public.so_mstr')
                            ->selectRaw('so_code AS code, so_date AS date, so_add_date')
                            ->where('so_date', Carbon::now()->format('Y-m-d'))
                            ->whereIn('so_oid', function ($query) {
                                $query->select('sod_so_oid')
                                    ->from('public.sod_det')
                                    ->where([
                                        ['sod_upd_by', '=', NULL],
                                        ['sod_upd_date', '=', NULL],
                                        ['sod_qty_checked', '=', NULL]
                                    ])
                                    ->distinct('sod_so_oid')
                                    ->get();
                            })
                            ->orderBy('so_add_date', 'DESC')
                            ->paginate(100);

            return response()->json([
                'status' => 'success',
                'message' => 'success to get data',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get data',
                'error' => $th->getMessage(),
            ], 400);
        }
    }
}
