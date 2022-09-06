<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\PORequest;
use App\Models\PoDDetail;
use App\Models\PoMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
    public function store(Request $request)
    {
        //
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
                'PO' => $po
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
