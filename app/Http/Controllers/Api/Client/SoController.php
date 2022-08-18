<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Dom;
use App\Models\DomMaster;
use App\Models\En;
use App\Models\EnMaster;
use App\Models\PiMaster;
use Illuminate\Http\Request;
use App\Models\SoMaster;

class SoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $so_masters = SoMaster::with('SoDDetail')->paginate(25);

            foreach ($so_masters as $so_master) {
                $so_master->dom_master = DomMaster::where('dom_id', $so_master->so_dom_id)->get();
                $so_master->en_master = EnMaster::where('en_id', $so_master->so_en_id)->get();
                $so_master->pi_master = PiMaster::where('pi_id', $so_master->so_pi_id)->get();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'success to get so_master data',
                'so_master' => $so_masters
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to et so_master data',
                'error' => $th->getMessage()
            ], 400);
        }
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
    public function show($so_code)
    {
        try {
            $so_detail = SoMaster::where('so_code', $so_code)->with('SoDDetail')->first();
            $so_detail->dom_master = DomMaster::where('dom_id', $so_detail->so_dom_id)->get();
            $so_detail->en_master = EnMaster::where('en_id', $so_detail->so_en_id)->get();
            $so_detail->pi_master = PiMaster::where('pi_id', $so_detail->so_pi_id)->get();

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
