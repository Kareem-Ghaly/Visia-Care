<?php

namespace App\Http\Controllers;
use App\Services\OpticalProductService;
use Illuminate\Http\Request;
use App\Http\Requests\opticalProductRequest;
use App\Http\Requests\UpdateopticalProductRequest;
use App\Models\OpticalProduct;
use App\Http\Resources\OpticalProductResource;
class OpticalProductController extends Controller
{

    public function __construct(protected OpticalProductService $service)
    {
    }

    public function store(OpticalProductRequest $request)
    {
        return $this->service->createProduct($request->validated());
    }
    public function update(UpdateopticalProductRequest $request, int $id)
    {
        return $this->service->updateProduct($id,$request->validated());

    }
    public function show(int $id)
{
    $products = OpticalProduct::where('optical_store_id', $id)->paginate(10);

    return response()->json([
        'success' => true,
        'data' => OpticalProductResource::collection($products)
    ]);
}



}
