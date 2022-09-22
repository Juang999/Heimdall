<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\SoRequest;
use App\Models\Dom;
use App\Models\DomMaster;
use App\Models\En;
use App\Models\EnMaster;
use App\Models\PiMaster;
use App\Models\PtMaster;
use App\Models\PtnrMaster;
use App\Models\SoDDetail;
use Illuminate\Http\Request;
use App\Models\SoMaster;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function update(SoRequest $request, $sod_oid)
    {
        try {
            // dd($request->all());
            DB::beginTransaction();
            SoDDetail::where('sod_oid', $sod_oid)->update([
                'sod_upd_by' => Auth::user()->usernama,
                'sod_upd_date' => Carbon::translateTimeString(now()),
                'sod_qty_checked' => $request->sod_qty_checked
            ]);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'success to update SO',
                'data' => SoDDetail::where('sod_oid', $sod_oid)->first()
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to update SO',
                'error' => $th->getMessage()
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
}
