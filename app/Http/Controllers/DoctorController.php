<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\DoctorService;

class DoctorController extends Controller
{
    public function __construct(protected DoctorService $service) {}
    public function getApprovedDoctors()
    {
        return $this->service->getApprovedDoctors();
    }
}
