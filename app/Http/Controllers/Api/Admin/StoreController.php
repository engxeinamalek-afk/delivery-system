<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStoreRequest;
use App\Models\Store;
use App\Http\Requests\UpdateStoreActiveRequest;
use App\Traits\ApiResponse;

class StoreController extends Controller
{
    use ApiResponse;
    public function store(StoreStoreRequest $request)
    {
        $validatedData = $request->validated();
    
        $store = Store::create($validatedData);

        return $this->successResponse(data:$store,
                                        message:'Store created successfully',
                                        statusCode:201);
    }

    public function updateStatus(UpdateStoreActiveRequest $request, Store $store)
    {
        $validatedData = $request->validated();

        $store->update($validatedData);

        if (!$store->wasChanged('is_active')) {
            return $this->successResponse(message: 'Store status is already set to this value. No changes were made.');
        }
        return $this->successResponse(data: $store,
                                        message: 'Store active status updated successfully.');
    }

    // دالة جلب جميع المتاجر
    public function index()
    {
        $stores = Store::select('id','name','is_active')->withoutGlobalScopes()->get();
        return $this->successResponse(data: $stores,
                                        message: 'Stores retrieved successfully.');
    }
}
