<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorLoginRequest;
use App\Http\Requests\PatientRegisterRequest;
use App\Services\AuthService;
//use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;


class PatientAuthController extends Controller
{
    public function __construct(protected AuthService $service) {}

   public function register(PatientRegisterRequest $request)
    {
        return $this->service->registerPatientService($request);
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
