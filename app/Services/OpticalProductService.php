<?php

namespace App\Services;

use App\Models\OpticalProduct;
use App\Models\OpticalStore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\OpticalProductResource;
class OpticalProductService
{
    public function createproduct(array $data)
    {
        try {
            $user = Auth::user();
            if (!$user->hasRole('OpticalStore')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Optical store profile not found'
                ], 403);
            }
            $opticalStore=$user->opticalStore;
             if (!$opticalStore) {
                return  response()->json([
                    'success' => false,
                    'message' => 'Optical store profile not found'
                ],403);
        }
        $data['optical_store_id'] = $opticalStore->id;
         if (isset($data['image'])) {
                    $path = $data['image']->store('optical_products', 'public');
                    $data['image'] = $path;
                }
        $product=OpticalProduct::create($data);
        return response()->json([
             'success' => true,
                'message' => 'Product created successfully',
                'data' => new OpticalProductResource($product)
        ],201);
    }
    catch (\Exception $e) {
            return  response()->json([
                'success' => false,
                'message' => 'Failed to create product: ' . $e->getMessage()
            ],500);
        }
}
}
