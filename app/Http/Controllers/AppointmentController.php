<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AppointmentRequest;
use App\Services\AppointmentService;
class AppointmentController extends Controller
{
    public function __construct(protected  AppointmentService $service){}

public function store(AppointmentRequest $request){
     return $this->service->createAppointment($request->validated());
}
}
