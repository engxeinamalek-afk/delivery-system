<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    use ApiResponse;
    public function index(){
        $stores= Store::select('id','name')->get();
        return $this->successResponse(data:$stores,
                                        message:'Stores retrieved successfully');
    }
}
