<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreProductOrderRequest;
use App\Services\ProductOredrService;
use Illuminate\Http\Request;

class ProductOrderController extends Controller
{
    public function __construct( protected ProductOredrService $service)
    {

    }
    public function createorder(StoreProductOrderRequest $request)
    {
        return $this->service->create($request->validated());
    }
    public function ordersByPatient($patientId)
    {
        return $this->service->getOrdersByPatientId($patientId);
    }
    public function approvedOrders()
    {
            return $this->service->getApprovedOrders();
    }
    public function pendingOrders()
    {
            return $this->service->getPendingOrders();
    }
}
