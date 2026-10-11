<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStoreRequest;
use App\Models\Store;
use App\Http\Requests\UpdateStoreActiveRequest;

class StoreController extends Controller
{
    public function store(StoreStoreRequest $request)
    {
        $validatedData = $request->validated();
    
        $store = Store::create($validatedData);

        return response()->json([
            'message' => 'Store created successfully',
            'data' => $store,
        ], 201);
    }

    public function updateStatus(UpdateStoreActiveRequest $request, Store $store)
    {
        $validatedData = $request->validated();

        $store->update($validatedData);

        if (!$store->wasChanged('is_active')) {
            return response()->json([
                'message' => 'Store status is already set to this value. No changes were made.'
            ], 200);
        }
        return response()->json([
            'message' => 'Store active status updated successfully',
            'data' => $store,
        ]);
    }

    // دالة جلب جميع المتاجر
    public function index()
    {
        $stores = Store::select('id','name','is_active')->withoutGlobalScopes()->get();
        return response()->json([
            'message' => 'Stores retrieved successfully',
            'data' => $stores,
        ]); 
    }
}
