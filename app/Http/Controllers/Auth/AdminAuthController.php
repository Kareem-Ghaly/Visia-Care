<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Services\AuthService;

class AdminAuthController extends Controller
{
    public function __construct(private AuthService $adminService) {}

    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        return $this->adminService->loginAdminService($credentials);
    }
}


