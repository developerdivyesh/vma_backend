<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\ApiAuthController;
use App\Http\Controllers\Api\AttendanceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [ApiAuthController::class, 'login']);
Route::post('logout', [ApiAuthController::class, 'logout'])->middleware('auth:sanctum')->name('api.logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/scan-qr', [AttendanceController::class, 'scanQR']);
    Route::get('/scanned-list', [AttendanceController::class, 'scannedList'])->middleware('auth:sanctum');
});

