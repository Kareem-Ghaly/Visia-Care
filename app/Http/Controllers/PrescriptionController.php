<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PrescriptionService;
use App\Http\Requests\PrescriptionRequest;

class PrescriptionController extends Controller
{
    protected $service;
    public function __construct(PrescriptionService $service)
    {
        $this->service = $service;
    }

    public function store(PrescriptionRequest $request)
    {
        return response()->json($this->service->addPrescription($request->validated()));
    }

    public function myPrescriptions($patientProfileId)
    {

             return $this->service->getPrescriptionsForPatient($patientProfileId);

    }
    public function getPrescriptionsbyid($PrescriptionsId){
        return $this->service->getPrescriptionById($PrescriptionsId);
    }

}
