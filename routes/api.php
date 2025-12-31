<?php

use App\Http\Controllers\AdminDashboard\AccountApprovalController;
use App\Http\Controllers\AdminDashboard\UpdateAccountStatusController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\DoctorAuthController;
use App\Http\Controllers\Auth\PatientAuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorAvailabilityController;
use App\Http\Controllers\DoctorDashbaord\DoctorAppointmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OpticalStoreController;
use App\Http\Controllers\DoctorDashbaord\DoctorNotificationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\OpticalProductController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ProductOrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::get('/doctors/pending', AccountApprovalController::class);
    Route::get('/opticals/pending', AccountApprovalController::class);
    Route::get('/doctors/approved', AccountApprovalController::class);
    Route::get('/opticals/approved', AccountApprovalController::class);
    Route::get('/doctors/rejected', AccountApprovalController::class);
    Route::get('/opticals/rejected', AccountApprovalController::class);
    Route::post('/update-status', [UpdateAccountStatusController::class, 'update']);
});

Route::prefix('auth')->group(function () {

    // Route::post('/login/admin', [AdminAuthController::class, 'login']);
    Route::post('/login', [DoctorAuthController::class, 'login']);

    Route::post('/register/doctor', [DoctorAuthController::class, 'register']);
    Route::post('/register/opticalstore', [OpticalStoreController::class, 'register']);
    Route::post('/register/patient', [PatientAuthController::class, 'register']);

    Route::middleware('auth:sanctum')->post('/logout', [DoctorAuthController::class, 'logout']);
});

Route::prefix('doctor')->group(function () {
    Route::get('/{doctor_id}/availabilities', [DoctorAvailabilityController::class, 'show']);
    Route::get('/approved', [DoctorController::class, 'getApprovedDoctors']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/notifications', [DoctorNotificationController::class, 'getDoctorNotifications']);
        Route::post('/availability', [DoctorAvailabilityController::class, 'store']);
        Route::put('/availability', [DoctorAvailabilityController::class, 'update']);
        Route::delete('/availability', [DoctorAvailabilityController::class, 'destroy']);
    });
});

Route::middleware('auth:sanctum')->prefix('/appointments')->group(function () {
    Route::post('/book', [AppointmentController::class, 'store']);
    Route::get('/pending', [DoctorAppointmentController::class, 'getPending']);
    Route::get('/approved', [DoctorAppointmentController::class, 'getApproved']);
    Route::put('/{id}/approve', [DoctorAppointmentController::class, 'approve']);
    Route::put('/{id}/reject', [DoctorAppointmentController::class, 'reject']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/notifications/{role}', NotificationController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/medical-records', [MedicalRecordController::class, 'store']);
    Route::get('/medical-records/{id}', [MedicalRecordController::class, 'show']);
    Route::post('/prescriptions', [PrescriptionController::class, 'store']);
    Route::get('/my-prescriptions', [PrescriptionController::class, 'myPrescriptions']);


});
Route::get('/optical-stores/approved', [OpticalProductController::class, 'showallopticalstores']);
Route::middleware('auth:sanctum')->prefix('optical')->group(function () {
    Route::post('/products', [OpticalProductController::class, 'store']);
    Route::post('/products-update/{id}', [OpticalProductController::class, 'update']);
    Route::get('/{id}/products', [OpticalProductController::class, 'show']);
    Route::delete('/products/{id}', [OpticalProductController::class, 'destroy']);


});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/patient/appointments', [AppointmentController::class, 'myAppointments']);
});
Route::middleware('auth:sanctum')->prefix('product')->group(function () {

    Route::post('/orders', [ProductOrderController::class, 'createorder']);
    Route::get('orders/patient/{patientId}', [ProductOrderController::class, 'ordersByPatient']);
    });
    Route::middleware('auth:sanctum')->prefix('optical')->group(function () {
    Route::patch('/orders/{id}/approve',[OpticalStoreController::class,'approvedorder']);
    Route::patch('/orders/{id}/cancelled',[OpticalStoreController::class,'rejectOrder']);
    Route::patch('/orders/{id}/ready',[OpticalStoreController::class,'markOrderAsReady']);
    Route::get('orders/approved',[ProductOrderController::class,'approvedOrders']);
});


