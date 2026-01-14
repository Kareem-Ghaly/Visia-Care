<?php

namespace App\Http\Controllers;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function __construct(private ProfileService $profileService) {}

    public function doctor()
    {
        return $this->profileService->doctorProfile();
    }
public function opticalStore()
    {
        return $this->profileService->opticalStoreProfile();
    }
     public function patient()
    {
        return $this->profileService->patientProfile();
    }
}
