<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchProductRequest;
use App\Models\PtMaster;
use Illuminate\Http\Request;

class SearchProduct extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(SearchProductRequest $request)
    {
        try {
            // $data = PtMaster::where('pt_')
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
