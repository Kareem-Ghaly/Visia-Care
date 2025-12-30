<?php

namespace App\Services;

use App\Models\OpticalStore;
use App\Http\Resources\OpticalStoreResource;

class OpticalStoreService
{
    public function getApprovedStores()
    {
        $stores = OpticalStore::whereHas('user', function ($query) {
                $query->where('status', 'approved');
            })
            ->with('user')
            ->orderBy('storeName')
            ->get();

        return response()->json([
            'success' => true,
            'data' => OpticalStoreResource::collection($stores)
        ]);
    }
}
