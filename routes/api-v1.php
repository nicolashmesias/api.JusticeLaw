<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AnswerController;

use App\Http\Controllers\Api\AdministratorController;
use App\Http\Controllers\Api\TypeDocumentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DateController;
use App\Http\Controllers\Api\ConsultingController;
use App\Http\Controllers\Api\InformationController;
use App\Http\Controllers\Api\AreaController;
use App\Http\Controllers\Api\AreaLAwyerController;
use App\Http\Controllers\Api\ReviewController;
use App\Models\Area;
use App\Models\AreaLawyer;
use App\Models\Consulting;
use App\Models\Review;
use Symfony\Component\VarDumper\Caster\DateCaster;

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

Route::get('answers',[AnswerController::class,'index'])->name('api.v1.answers.index');
Route::post('answers',[AnswerController::class,'store'])->name('api.v1.answers.store');
Route::get('answers/{answer}',[AnswerController::class,'show'])->name('api.v1.answers.show');
Route::put('answers/{answer}', [AnswerController::class,'update'])->name('api.v1.answers.update');
Route::delete('answers/{answer}', [AnswerController::class,'destroy'])->name('api.v1.answers.delete');

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

 Route::get('users', [UserController::class,'index'])->name('api.v1.users.index');
 Route::post('users', [UserController::class,'store'])->name('api.v1.users.store');
 Route::get('users/{user}', [UserController::class,'show'])->name('api.v1.users.show');
 Route::put('users/{user}', [UserController::class,'update'])->name('api.v1.users.update');
 Route::delete('users/{user}', [UserController::class,'destroy'])->name('api.v1.users.delete');


 Route::get('informations', [InformationController::class,'index'])->name('api.v1.informations.index');
 Route::post('informations', [InformationController::class,'store'])->name('api.v1.informations.store');
 Route::get('informations/{information}', [InformationController::class,'show'])->name('api.v1.informations.show');
 Route::put('informations/{information}', [InformationController::class,'update'])->name('api.v1.informations.update');
 Route::delete('informations/{information}', [InformationController::class,'destroy'])->name('api.v1.informations.delete');

Route::get('dates',[DateController::class,'index'])->name('api.v1.dates.index');
Route::post('dates',[DateController::class,'store'])->name('api.v1.dates.show');
Route::get('dates/{date}',[DateController::class,'show'])->name('api.v1.dates.show');
Route::put('dates/{date}',[DateController::class,'update'])->name('api.v1.dates.update');
Route::delete('dates/{date}',[DateController::class,'delete'])->name('api.v1.dates.delete');


Route::get('consultings',[ConsultingController::class,'index'])->name('api.v1.consultings.index');
Route::post('consultings',[ConsultingController::class,'store'])->name('api.v1.consultings.store');
Route::get('consultings/{consulting}',[ConsultingController::class,'show'])->name('api.v1.consultings.show');
Route::put('consultings/{consulting}',[ConsultingController::class,'update'])->name('api.v1.consultings.update');
Route::delete('consultings/{consulting}',[ConsultingController::class,'delete'])->name('api.v1.consultings.delete');

Route::get('areas',[AreaController::class,'index'])->name('api.v1.areas.index');
Route::post('areas',[AreaController::class,'store'])->name('api.v1.areas.show');
Route::get('areas/{area}',[AreaController::class,'show'])->name('api.v1.areas.show');
Route::put('areas/{area}',[AreaController::class,'update'])->name('api.v1.areas.update');
Route::delete('areas/{area}',[AreaController::class,'delete'])->name('api.v1.areas.delete');

Route::get('areasLawyer',[AreaLawyerController::class,'index'])->name('api.v1.areasLawyer.index');
Route::post('areasLawyer',[AreaLawyerController::class,'store'])->name('api.v1.areasLawyer.show');
Route::get('areasLawyer/{areaLawyer}',[AreaLawyerController::class,'show'])->name('api.v1.areasLawyer.show');
Route::put('areasLawyer/{areaLawyer}',[AreaLawyerController::class,'update'])->name('api.v1.areasLawyer.update');
Route::delete('areasLawyer/{areaLawyer}',[AreaLawyerController::class,'delete'])->name('api.v1.areasLawyer.delete');

Route::get('reviews',[ReviewController::class,'index'])->name('api.v1.reviews.index');
Route::post('reviews',[ReviewController::class,'store'])->name('api.v1.reviews.show');
Route::get('reviews/{review}',[ReviewController::class,'show'])->name('api.v1.rivews.show');
Route::put('reviews/{rivew}',[ReviewController::class,'update'])->name('api.v1.rivews.update');
Route::delete('reviews/{review}',[ReviewController::class,'delete'])->name('api.v1.rivews.delete');