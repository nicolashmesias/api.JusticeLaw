<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AdministratorController;
use App\Http\Controllers\Api\TypeDocumentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DateController;

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

 Route::get('users', [TypeDocumentController::class,'index'])->name('api.v1.users.index');
 Route::post('users', [TypeDocumentController::class,'store'])->name('api.v1.users.store');
 Route::get('users/{user}', [UserController::class,'show'])->name('api.v1.users.show');
 Route::put('users/{user}', [UserController::class,'update'])->name('api.v1.users.update');
 Route::delete('users/{user}', [UserController::class,'destroy'])->name('api.v1.users.delete');

Route::get('dates',[DateController::class,'index'])->name('api.v1.dates.index');
Route::post('dates',[DateController::class,'store'])->name('api.v1.dates.store');
Route::get('dates',[DateController::class,'show'])->name('api.v1.dates.show');
Route::put('dates',[DateController::class,'update'])->name('api.v1.dates.update');
Route::delete('dates',[DateController::class,'delete'])->name('api.v1.dates.delete');