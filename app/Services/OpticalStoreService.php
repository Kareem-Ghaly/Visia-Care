<?php

namespace App\Services;
use App\Models\ProductOrder;
use App\Models\Notification;
use App\Models\OpticalStore;
use App\Http\Resources\OpticalStoreResource;
use Illuminate\Support\Facades\Auth;

class OpticalStoreService
{
    public function approveOrder(int $orderId)
{
    $user=Auth::user();
    $order = ProductOrder::findOrFail($orderId);

    if ($order->status !== 'pending') {
        return response()->json(['message' => 'Order cannot be approved'], 400);
    }

    $order->update(['status' => 'approved']);

    Notification::create([
         'sender_id'   => Auth::id(),
    'receiver_id' => $order->patient->user->id,
    'title'       => 'Order Approved',
    'description' => "Your order #{$order->id} has been approved"
]);


    return response()->json(['success' => true, 'data'=>'order approved']);
}
public function rejectOrder(int $orderId)
{
    $user = Auth::user();
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

    Notification::create([
        'sender_id'   => $user->id,
        'receiver_id' => $order->patient->user->id,
        'title'       => 'Order cancelled',
        'description' => "Your order #{$order->id} has been cancelled "
    ]);

    return response()->json(['success' => true,
'data'=>'order cancelled']);
}

}
