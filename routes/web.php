<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\VmaMemberController;
use App\Http\Controllers\OtpController;


require __DIR__.'/auth.php';

Route::get('/', function () {
    return redirect('/event-registration');
});

Route::get('/event-registration', [RegistrationController::class, 'showForm'])->name('event_registration.form');
Route::post('/event-registration', [RegistrationController::class, 'register'])->name('event_registration.submit');
Route::get('/event-registration/success/{id}', [RegistrationController::class, 'success'])->name('event_registration.success');
Route::get('/show-qr/{id}', [RegistrationController::class, 'showQr'])->name('show_qr');
Route::post('/otp/send', [OtpController::class, 'sendOtp'])->name('otp.send');
Route::post('/otp/verify', [OtpController::class, 'verifyOtp'])->name('otp.verify');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/registrations', [RegistrationController::class, 'index'])->name('admin.registrations.index');
    Route::resource('/admin/vma-members', VmaMemberController::class, [
        'as' => 'admin',
        'parameters' => ['vma-members' => 'user']
    ])->except(['show']);
});

