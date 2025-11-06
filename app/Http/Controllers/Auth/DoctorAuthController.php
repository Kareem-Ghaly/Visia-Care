<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorLoginRequest;
use App\Http\Requests\DoctorRegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class DoctorAuthController extends Controller
{
    public function __construct(protected AuthService $service) {}

   public function register(DoctorRegisterRequest $request)
    {
        return $this->service->registerDoctorService($request);
    }
    public function login(DoctorLoginRequest $request)
    {
        return $this->service->loginService($request);
    }
}
