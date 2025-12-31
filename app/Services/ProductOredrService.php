<?php

namespace App\Services;

use App\Models\ProductOrder;
use App\Models\ProductOrderItem;
use App\Models\OpticalProduct;
use App\Http\Resources\ProductOrderResource;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductOredrService
{
    public function create(array $data)
    {
        try {
            $user = Auth::user();

            if (!$user->patientProfile) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is not a patient'
                ], 403);
            }

            DB::beginTransaction();
            $storeIds = collect($data['items'])->map(function ($item) {
                return OpticalProduct::find($item['optical_product_id'])->optical_store_id;
            })->unique();

            if ($storeIds->count() > 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'All products must belong to the same optical store'
                ], 400);
            }
            $order = ProductOrder::create([
                'patient_id' => $user->patientProfile->id,
                'prescription_id' => $data['prescription_id'],
                'status' => 'pending',
                'total_price' => 0
            ]);
            $totalPrice = 0;
            foreach ($data['items'] as $item) {
                $product = OpticalProduct::findOrFail($item['optical_product_id']);

                $itemTotal = $product->price * $item['quantity'];
                $totalPrice += $itemTotal;

                ProductOrderItem::create([
                    'product_order_id' => $order->id,
                    'optical_product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'total_price' => $itemTotal
                ]);
            }
            $order->update(['total_price' => $totalPrice]);
            $storeUser = OpticalProduct::find($data['items'][0]['optical_product_id'])
                ->opticalStore
                ->user;

            Notification::create([
                'sender_id' => $user->id,
                'receiver_id' => $storeUser->id,
                'title' => 'New Order Received',
                'description' => "New order #{$order->id} received",
                'reminder' => null
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => new ProductOrderResource(
                    $order->load('items.product')
                )
            ], 201);
            ;
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function getOrdersByPatientId(int $patientId)
    {
        $orders = ProductOrder::where('patient_id', $patientId)
            ->with([
                    'items.product.opticalStore',
                    'patient.user',
                    'prescription'
                ])
            ->orderByDesc('created_at')->paginate(5);
        return response()->json([
            'success' => true,
            'data' => ProductOrderResource::collection($orders)
        ]);
    }
    public function getApprovedOrders()
{
    $user = Auth::user();
    $store = $user->opticalStore;

    if (!$store) {
        return response()->json([
            'message' => 'Unauthorized'
        ], 403);
    }

    $orders = ProductOrder::where('status', 'approved')
        ->whereHas('items.product', function ($q) use ($store) {
            $q->where('optical_store_id', $store->id);
        })
        ->with([
            'items.product',
            'patient.user',
             'prescription'

        ])
        ->orderByDesc('created_at')
        ->paginate(5);

    return response()->json([
        'success' => true,
        'data' => ProductOrderResource::collection($orders)
    ]);

}

}

