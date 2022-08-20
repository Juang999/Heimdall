<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Cu;
use App\Models\Dom;
use App\Models\DomMaster;
use App\Models\En;
use App\Models\EnMaster;
use App\Models\PtnrMaster;
use App\Models\Si;
use App\Models\So;
use App\Models\SoMaster;
use Illuminate\Http\Request;
use App\Models\SoShipMaster;
use App\Models\SoShipDDetail;

class SoShipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $products = SoShipMaster::with(['SoShipDDetail'])->paginate(25);

            foreach ($products as $product) {
                $product['dom'] = DomMaster::where('dom_id', $product->soship_dom_id)->get();
                $product['en'] = EnMaster::where('en_id', $product->soship_en_id)->get();
                $product['so'] = SoMaster::where('so_oid', $product->soship_so_oid)->get();
                $product['si'] = Si::where('si_id', $product->soship_si_id)->get();
                $product['cu'] = Cu::where('cu_id', $product->soship_cu_id)->get();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'success to get product data',
                'product_data' => $products
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get product data',
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
    public function show($soship_code)
    {
        try {
            $product = SoShipMaster::where('soship_code',$soship_code)->with('SoShipDDetail')->first();
            $product->partner = PtnrMaster::where('ptnr_oid', $product->so_ptnr_id_sold)->get();
            $product->dom = DomMaster::where('dom_id', $product->soship_dom_id)->get();
            $product->en = EnMaster::where('en_id', $product->soship_en_id)->get();

            return response()->json([
                'status' => 'success',
                'message' => 'success to get detail product',
                'data' => $product
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get detail product',
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
