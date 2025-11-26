<?php

namespace App\Http\Controllers;

use App\Services\MedicalRecordService;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    protected $service;
    public function __construct(MedicalRecordService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        return response()->json($this->service->createRecord($request->all()));
    }
}
