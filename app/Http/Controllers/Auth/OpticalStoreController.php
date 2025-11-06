<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\OpticalStoreRegisterRequest;
use App\Http\Controllers\Controller;
use App\Services\AuthService;

class OpticalStoreController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function register(OpticalStoreRegisterRequest $request)
    {
        return $this->authService->registerOpticalStoreService($request);
    }
}
