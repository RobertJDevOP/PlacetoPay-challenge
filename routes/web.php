<?php


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect(RouteServiceProvider::HOME);
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::group(['middleware' => ['role:admin','auth']], function () {
    Route::name('users.index')->get('/users', [UserController::class, 'index']);
    Route::name('users.edit')->get('/users/{email}/edit', [UserController::class, 'edit']);
    Route::name('users.update')->put('/users/{email}/', [UserController::class, 'update']);
    Route::name('users.status')->put('/users/{email}/status', [UserController::class, 'statusUser']);

    Route::name('products.index')->get('/products', [UserController::class, 'index']);
});
