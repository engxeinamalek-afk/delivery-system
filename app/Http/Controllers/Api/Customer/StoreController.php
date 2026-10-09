<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(){
        $stores= Store::select('id','name')->get();
        return response()->json([
            'message' => 'Stores retrieved successfully',
            'data' => $stores,
        ]);
    }
}
