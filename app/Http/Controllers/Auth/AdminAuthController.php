<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\DoctorLoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    // public function __construct(private AuthService $adminService) {}

    // public function login(AdminLoginRequest $request)
    // {
    //     $credentials = $request->only('email', 'password');
    //     return $this->adminService->loginAdminService($credentials);
    // }

    public function __construct(protected AuthService $service) {}

    public function login(DoctorLoginRequest $request)
    {
        return $this->service->loginService($request);
    }
}


