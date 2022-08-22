<?php

namespace App\Http\Controllers\Testing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    public function getTime()
    {
        return response()->json([
            'time' => \Carbon\Carbon::translateTimeString(now())
        ]);
    }
}
