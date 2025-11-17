<?php

namespace App\Http\Controllers\DoctorDashbaord;
use App\Services\DoctorAppointmentService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorAppointmentController extends Controller
{
    public function __construct(protected DoctorAppointmentService $service){}
    public function getPending(){
        return $this->service->getPendingAppointments();
    }

}
