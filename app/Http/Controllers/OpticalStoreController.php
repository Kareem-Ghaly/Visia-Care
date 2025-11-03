<?php

namespace App\Http\Controllers;


use App\Http\Requests\OpticalStoreRegisterRequest;
use App\Services\OpticalStoreAuthService;


class OpticalStoreController extends Controller
{
public function __construct(private OpticalStoreAuthService $authService) {}

    public function register(OpticalStoreRegisterRequest $request)
    {
        return $this->authService->register($request->validated());
    }
}
