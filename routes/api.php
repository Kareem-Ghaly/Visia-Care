<?php


use App\Http\Controllers\AdminDashboard\ApprovalRequestsController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\DoctorAuthController;
use App\Http\Controllers\Auth\PatientAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OpticalStoreController;
use App\Http\Controllers\DoctorDashbaord\DoctorNotificationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::post('/approve/{id}', [ApprovalRequestsController::class, 'ApprovalRequest']);
    Route::middleware('auth:sanctum')->get('/notifications', function () {
        return \App\Models\Notification::where('receiver_id', auth()->id())->latest()->get();
    });
});

Route::prefix('auth')->group(function () {

    // Route::post('/login/admin', [AdminAuthController::class, 'login']);
    Route::post('/login', [DoctorAuthController::class, 'login']);

    Route::post('/register/doctor', [DoctorAuthController::class, 'register']);
    Route::post('/register/opticalstore', [OpticalStoreController::class, 'register']);
    Route::post('/register/patient', [PatientAuthController::class, 'register']);
});

Route::prefix('doctor')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/notifications', [DoctorNotificationController::class, 'getDoctorNotifications']);
    });
});

