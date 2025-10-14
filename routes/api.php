<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Payment routes
Route::prefix('payments')->middleware('auth:sanctum')->group(function () {
    // Get all active payment methods
    Route::get('/methods', [PaymentController::class, 'getPaymentMethods']);
    
    // Process a new payment
    Route::post('/process', [PaymentController::class, 'store']);
    
    // Get payment transaction details
    Route::get('/transaction/{id}', [PaymentController::class, 'show']);
});
