<?php

use App\Http\Controllers\Api\AkunBankController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VerificationController;
use App\Http\Controllers\Api\PemodalController;
use App\Http\Controllers\Api\BerkasController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
	Route::post('register', [AuthController::class, 'register']);
	Route::post('login', [AuthController::class, 'store']);

	Route::middleware(['verified', 'auth:api'])->group(function() {
	  	Route::get('me', [AuthController::class, 'myInfo']);
	  	Route::post('logout', [AuthController::class, 'destroy']);

        // Pemodal
	  	Route::get('/pemodal', [PemodalController::class, 'index']);
        Route::get('/pemodal/{id}', [PemodalController::class, 'show']);
        Route::post('/pemodal', [PemodalController::class, 'store']);
        Route::put('/pemodal/{id}', [PemodalController::class, 'update']);
        Route::delete('/pemodal/{id}', [PemodalController::class, 'destroy']);

        // Pemodal Akun Bank
	  	// Route::get('/pemodal-akunbank', [AkunBankController::class, 'index']);
        Route::get('/pemodal-akunbank/{id}', [AkunBankController::class, 'show']);
        Route::post('/pemodal-akunbank', [AkunBankController::class, 'store']);
        Route::put('/pemodal-akunbank/{id}', [AkunBankController::class, 'update']);
        Route::delete('/pemodal-akunbank/{id}', [AkunBankController::class, 'destroy']);

        // Pemodal Berkas
	  	Route::get('/pemodal-berkas', [BerkasController::class, 'index']);
        Route::get('/pemodal-berkas/{id}', [BerkasController::class, 'show']);
        Route::post('/pemodal-berkas', [BerkasController::class, 'store']);
        Route::put('/pemodal-berkas/{id}', [BerkasController::class, 'update']);
        Route::put('/pemodal-berkas/{id}/update-status', [BerkasController::class, 'updateStatus']);
        Route::delete('/pemodal-berkas/{id}', [BerkasController::class, 'destroy']);

	 });
});

// Define Custom Verification Routes
Route::group(['namespace' => 'Api'], function() {
    Route::get('/email/verify', [VerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function() {
    Route::post('data_diri', [PemodalController::class, 'datadiri']);
    Route::post('akun_bank', [PemodalController::class, 'akunbank']);
    Route::post('swa_photo', [PemodalController::class, 'swaFoto']);
});

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function() {
    Route::post('swa_photo', [BerkasController::class, 'swaFoto']);
});
Route::apiResource('/berkas', App\Http\Controllers\Api\BerkasController::class);
