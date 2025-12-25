<?php

namespace App\Services;

use App\Models\OpticalProduct;
use App\Models\OpticalStore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\OpticalProductResource;
use Illuminate\Support\Facades\Storage;


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
public function updateProduct(int $productId, array $data)
{
    try {
        return DB::transaction(function () use ($productId, $data) {

            $user = Auth::user();

 if (!$user->hasRole('OpticalStore')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only optical stores can update products'
                ], 403);
            }
            $opticalStore = $user->opticalStore;
            if (!$opticalStore) {
                return response()->json([
                    'success' => false,
                    'message' => 'Optical store profile not found'
                ], 403);
            }
            $product = OpticalProduct::where('optical_store_id', $opticalStore->id)
                ->findOrFail($productId);
                 if (isset($data['image'])) {

    if ($product->image && Storage::disk('public')->exists($product->image)) {
        Storage::disk('public')->delete($product->image);
    }

    $path = $data['image']->store('optical_products', 'public');
    $data['image'] = $path;
}

$product->update($data);


 $product->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => new OpticalProductResource($product)
            ], 200);
        });

}catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to update product: ' . $e->getMessage()
        ], 500);

    }
}
}
