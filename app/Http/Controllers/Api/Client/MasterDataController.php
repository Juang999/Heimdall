<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\AcMaster;
use App\Models\EnMaster;
use Illuminate\Http\Request;
use App\Models\LocMaster;
use App\Models\PtnrMaster;

class MasterDataController extends Controller
{
    public function getLocation()
    {
        try {
            $data = LocMaster::get();

            return response()->json([
                'status' => 'success',
                'message' => 'success to get data location',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get data location',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function getPartner()
    {
        try {
            $data = PtnrMaster::get();

            return response()->json([
                'status' => 'success',
                'message' => 'success to get data partner',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get data partner',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function getEntity()
    {
        try {
            $data = EnMaster::get();

            return response()->json([
                'status' => 'success',
                'message' => 'success to get data entity',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get data entity',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function getAccount()
    {
        try {
            $data = AcMaster::get();

            return response()->json([
                'status' => 'success',
                'message' => 'success to get data account',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get data account',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
