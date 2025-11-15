<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\OpticalStoreRegisterRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorLoginRequest;
use App\Services\AuthService;
//use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;


class OpticalStoreController extends Controller
{
    public function __construct(protected AuthService $service) {}

    public function register(OpticalStoreRegisterRequest $request)
    {
        return $this->service->registerOpticalStoreService($request);
    }
    public function login(DoctorLoginRequest $request)
    {
        return $this->service->loginService($request);
    }
    public function logout(Request $request)
    {
        return $this->service->logoutService($request);
    }
}
