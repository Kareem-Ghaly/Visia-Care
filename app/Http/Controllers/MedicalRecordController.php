<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicalRecordRequest;
use App\Services\MedicalRecordService;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    protected $service;

    public function __construct(MedicalRecordService $service)
    {
        $this->service = $service;
    }

    public function store(MedicalRecordRequest $request)
    {
        return $this->service->createRecord($request->validated());
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function getByPatientId($patientProfileId)
    {
        return $this->service->getByPatientId($patientProfileId);
    }
}
