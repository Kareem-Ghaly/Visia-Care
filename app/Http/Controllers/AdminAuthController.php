<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Services\AdminAuthService;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function __construct(private AdminAuthService $adminService) {}

    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        return $this->adminService->login($credentials);
    }
}


