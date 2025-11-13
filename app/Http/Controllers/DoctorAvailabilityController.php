<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DoctorAvailabilityRequest;
use App\Services\DoctorAvailabilityService;

class DoctorAvailabilityController extends Controller
{
    public function __construct(protected DoctorAvailabilityService $service) {}
    public function store(DoctorAvailabilityRequest $request)
    {
        return $this->service->createDoctorAvailability($request->validated());
    }
    public function show($doctorid)
{
    return $this->service->getAvailabilitiesByDocto($doctorid);
}

}
