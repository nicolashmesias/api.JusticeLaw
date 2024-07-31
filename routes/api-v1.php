<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppointmentController;

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

Route::get('dates',[AppointmentController::class,'index'])->name('api.v1.appointment.index');
Route::post('dates',[AppointmentController::class,'store'])->name('api.v1.appointment.store');
Route::get('dates/{appointment}',[AppointmentController::class,'show'])->name('api.v1.appointment.show');
Route::put('dates/{appointment}',[AppointmentController::class,'update'])->name('api.v1.appointment.update');