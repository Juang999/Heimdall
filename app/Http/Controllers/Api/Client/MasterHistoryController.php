<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\SoMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MasterHistoryController extends Controller
{
    public function getHistorySO()
    {
        try {
            $data = DB::table('public.so_mstr')
            ->select(DB::raw('public.so_mstr.*, public.sod_det.*, public.pt_mstr.*'))
            ->join('public.sod_det', 'public.so_mstr.so_oid', '=', 'public.sod_det.sod_so_oid')
            ->join('public.pt_mstr', 'public.sod_det.sod_pt_id', '=', 'public.pt_mstr.pt_id')
            ->whereIn('public.so_mstr.so_oid', function ($query) {
                $query->select('public.sod_det.sod_so_oid')
                ->from('public.sod_det')
                ->where('public.sod_det.sod_upd_by', Auth::user()->usernama)
                ->get();
            })->get();

            // $data = SoMaster::where('so_oid', function ($query) {
            //     $query->select('public.sod_det.sod_so_oid')
            //     ->from('public.sod_det')
            //     ->where('sod_upd_by', Auth::user()->usernama)
            //     ->distinct('sod_upd_by')->get();
            // })->with('SoDDetail')->get();

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
