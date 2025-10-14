<?php

use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes for Frontend
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your frontend application.
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Address routes
    Route::apiResource('addresses', AddressController::class);
    Route::post('addresses/{address}/set-default', [AddressController::class, 'setDefault'])->name('addresses.set-default');
});
