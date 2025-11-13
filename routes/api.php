<?php

use App\Http\Controllers\AdminDashboard\AccountApprovalController;
use App\Http\Controllers\AdminDashboard\UpdateAccountStatusController;
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



//     Route::post('/update-status', [UpdateAccountStatusController::class, 'update']);




Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::get('/doctors/pending', AccountApprovalController::class);
    Route::get('/opticals/pending', AccountApprovalController::class);
    Route::get('/doctors/approved', AccountApprovalController::class);
    Route::get('/opticals/approved', AccountApprovalController::class);
    Route::get('/doctors/rejected', AccountApprovalController::class);
    Route::get('/opticals/rejected', AccountApprovalController::class);
    Route::post('/update-status' , [UpdateAccountStatusController::class, 'update']);
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
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/notifications', [DoctorNotificationController::class, 'getDoctorNotifications']);
    });
});
