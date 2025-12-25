<?php

namespace App\Http\Controllers;
use App\Services\OpticalProductService;
use Illuminate\Http\Request;
use App\Http\Requests\opticalProductRequest;
class OpticalProductController extends Controller
{

    public function __construct( protected OpticalProductService $service ){}

public function store(OpticalProductRequest $request)
{
    return $this->service->createProduct($request->validated());
}

    }
