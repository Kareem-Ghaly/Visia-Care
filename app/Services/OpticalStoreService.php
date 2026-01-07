<?php

namespace App\Services;

use App\Models\ProductOrder;
use App\Notifications\OrderStatusChangedNotification;
use Illuminate\Support\Facades\Auth;

class OpticalStoreService
{

    public function approveOrder(int $orderId)
    {
        $user  = Auth::user();
        $store = $user->opticalStore;

        if (!$store) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $order = ProductOrder::findOrFail($orderId);

        if ($order->status !== 'pending') {
            return response()->json(['message' => 'Order cannot be approved'], 400);
        }

        $order->update(['status' => 'approved']);


        $patientUser = $order->patient->user;
        $patientUser->notify(
            new OrderStatusChangedNotification(
                $order,
                'approved',
                "Your order #{$order->id} has been approved"
            )
        );

        return response()->json([
            'success' => true,
            'message' => 'Order approved'
        ]);
    }


    public function rejectOrder(int $orderId)
    {
        $user  = Auth::user();
        $store = $user->opticalStore;

        if (!$store) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $order = ProductOrder::findOrFail($orderId);

        if ($order->status !== 'pending') {
            return response()->json(['message' => 'Order cannot be cancelled'], 400);
        }

        $belongsToStore = $order->items()
            ->whereHas('product', function ($q) use ($store) {
                $q->where('optical_store_id', $store->id);
            })
            ->exists();

        if (!$belongsToStore) {
            return response()->json(['message' => 'This order does not belong to your store'], 403);
        }

        $order->update(['status' => 'cancelled']);


        $patientUser = $order->patient->user;
        $patientUser->notify(
            new OrderStatusChangedNotification(
                $order,
                'cancelled',
                "Your order #{$order->id} has been cancelled"
            )
        );

        return response()->json([
            'success' => true,
            'message' => 'Order cancelled'
        ]);
    }


    public function markOrderAsReady(int $orderId)
    {
        $user  = Auth::user();
        $store = $user->opticalStore;

        if (!$store) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $order = ProductOrder::findOrFail($orderId);

        $belongsToStore = $order->items()
            ->whereHas('product', function ($q) use ($store) {
                $q->where('optical_store_id', $store->id);
            })
            ->exists();

        if (!$belongsToStore) {
            return response()->json(['message' => 'This order does not belong to your store'], 403);
        }

        $order->update([
            'status'        => 'ready',
            'delivery_time' => now(),
        ]);


        $patientUser = $order->patient->user;
        $patientUser->notify(
            new OrderStatusChangedNotification(
                $order,
                'ready',
                "Your order #{$order->id} is ready for pickup"
            )
        );

        return response()->json([
            'success' => true,
            'message' => 'Order marked as ready',
            'delivery_time'=>now()
        ]);
    }
}
