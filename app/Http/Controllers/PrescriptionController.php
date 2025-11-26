<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PrescriptionService;

class PrescriptionController extends Controller
{
    protected $service;
    public function __construct(PrescriptionService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        return response()->json($this->service->addPrescription($request->all()));
    }

    public function myPrescriptions()
    {
        $patientProfileId = auth()->user()->patientProfile->id;
        return response()->json(
            $this->service->getPrescriptionsForPatient($patientProfileId)
        );
    }
}
