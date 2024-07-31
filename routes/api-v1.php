<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppointmentController;

use App\Http\Controllers\Api\AdministratorController;
use App\Http\Controllers\Api\TypeDocumentController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('administrators', [AdministratorController::class,'index'])->name('api.v1.administrators.index');
 Route::post('administrators', [AdministratorController::class,'store'])->name('api.v1.administrators.store');
 Route::get('administrators/{administrator}', [AdministratorController::class,'show'])->name('api.v1.administrators.show');
 Route::put('administrators/{administrator}', [AdministratorController::class,'update'])->name('api.v1.administrators.update');
 Route::delete('administrators/{administrator}', [AdministratorController::class,'destroy'])->name('api.v1.administrators.delete');

 Route::get('typeDocuments', [TypeDocumentController::class,'index'])->name('api.v1.typeDocuments.index');
 Route::post('typeDocuments', [TypeDocumentController::class,'store'])->name('api.v1.typeDocuments.store');
 Route::get('typeDocuments/{typeDocument}', [TypeDocumentController::class,'show'])->name('api.v1.typeDocuments.show');
 Route::put('typeDocuments/{typeDocument}', [TypeDocumentController::class,'update'])->name('api.v1.typeDocuments.update');
 Route::delete('typeDocuments/{typeDocument}', [TypeDocumentController::class,'destroy'])->name('api.v1.typeDocuments.delete');


