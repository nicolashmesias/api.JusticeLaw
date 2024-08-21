<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Api\AdministratorController;
use App\Http\Controllers\Api\TypeDocumentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\DropdownController;
use App\Http\Controllers\Api\DateController;
use App\Http\Controllers\Api\ConsultingController;
use App\Http\Controllers\Api\InformationController;
<<<<<<< HEAD

use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\SearchController;
use App\Models\Consulting;
use App\Models\Notification;
use App\Models\Search;

=======
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\SearchController;
>>>>>>> 9dce23307d5438e4637fbc467083614d379ce2ec
use App\Http\Controllers\Api\AreaController;
use App\Http\Controllers\Api\AreaLawyerController;
use App\Http\Controllers\Api\ForumCategoryController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\ReviewController;

<<<<<<< HEAD
use App\Http\Controllers\Api\OverhaulReviewController;
use App\Http\Controllers\LawyerProfileController;
=======
>>>>>>> 9dce23307d5438e4637fbc467083614d379ce2ec
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

Route::get('answers', [AnswerController::class, 'index'])->name('api.v1.answers.index');
Route::post('answers', [AnswerController::class, 'store'])->name('api.v1.answers.store');
Route::get('answers/{answer}', [AnswerController::class, 'show'])->name('api.v1.answers.show');
Route::put('answers/{answer}', [AnswerController::class, 'update'])->name('api.v1.answers.update');
Route::delete('answers/{answer}', [AnswerController::class, 'destroy'])->name('api.v1.answers.delete');

Route::get('questions', [QuestionController::class, 'index'])->name('api.v1.questions.index');
Route::post('questions', [QuestionController::class, 'store'])->name('api.v1.questions.store');
Route::get('questions/{question}', [QuestionController::class, 'show'])->name('api.v1.questions.show');
Route::put('questions/{question}', [QuestionController::class, 'update'])->name('api.v1.questions.update');
Route::delete('questions/{question}', [QuestionController::class, 'destroy'])->name('api.v1.questions.delete');

Route::get('forumCategories', [ForumCategoryController::class, 'index'])->name('api.v1.forumCategories.index');
Route::post('forumCategories', [ForumCategoryController::class, 'store'])->name('api.v1.forumCategories.store');
Route::get('forumCategories/{forumCategory}', [ForumCategoryController::class, 'show'])->name('api.v1.forumCategories.show');
Route::put('forumCategories/{forumCategory}', [ForumCategoryController::class, 'update'])->name('api.v1.forumCategories.update');
Route::delete('forumCategories/{forumCategory}', [ForumCategoryController::class, 'destroy'])->name('api.v1.forumCategories.delete');

Route::get('administrators', [AdministratorController::class, 'index'])->name('api.v1.administrators.index');
Route::post('administrators', [AdministratorController::class, 'store'])->name('api.v1.administrators.store');
Route::get('administrators/{administrator}', [AdministratorController::class, 'show'])->name('api.v1.administrators.show');
Route::put('administrators/{administrator}', [AdministratorController::class, 'update'])->name('api.v1.administrators.update');
Route::delete('administrators/{administrator}', [AdministratorController::class, 'destroy'])->name('api.v1.administrators.delete');

Route::get('typeDocuments', [TypeDocumentController::class, 'index'])->name('api.v1.typeDocuments.index');
Route::post('typeDocuments', [TypeDocumentController::class, 'store'])->name('api.v1.typeDocuments.store');
Route::get('typeDocuments/{typeDocument}', [TypeDocumentController::class, 'show'])->name('api.v1.typeDocuments.show');
Route::put('typeDocuments/{typeDocument}', [TypeDocumentController::class, 'update'])->name('api.v1.typeDocuments.update');
Route::delete('typeDocuments/{typeDocument}', [TypeDocumentController::class, 'destroy'])->name('api.v1.typeDocuments.delete');

Route::get('users', [UserController::class, 'index'])->name('api.v1.users.index');
Route::post('users', [UserController::class, 'store'])->name('api.v1.users.store');
Route::get('users/{user}', [UserController::class, 'show'])->name('api.v1.users.show');
Route::put('users/{user}', [UserController::class, 'update'])->name('api.v1.users.update');
Route::delete('users/{user}', [UserController::class, 'destroy'])->name('api.v1.users.delete');

Route::get('usersProfile', [UserProfileController::class, 'index'])->name('api.v1.usersProfile.index');
Route::post('usersProfile', [UserProfileController::class, 'store'])->name('api.v1.usersProfile.store');
Route::get('usersProfile/{userProfile}', [UserProfileController::class, 'show'])->name('api.v1.usersProfile.show');
Route::put('usersProfile/{userProfile}', [UserProfileController::class, 'update'])->name('api.v1.usersProfile.update');
Route::delete('usersProfile/{userProfile}', [UserProfileController::class, 'destroy'])->name('api.v1.usersProfile.delete');


Route::get('countries', [DropdownController::class, 'indexCountry'])->name('api.v1.countries.index');
Route::post('countries', [DropdownController::class, 'storeCountry'])->name('api.v1.countries.store');
Route::get('countries/{country}', [DropdownController::class, 'showCountry'])->name('api.v1.countries.show');
Route::put('countries/{country}', [DropdownController::class, 'updateCountry'])->name('api.v1.countries.update');
Route::delete('countries/{country}', [DropdownController::class, 'destroyCountry'])->name('api.v1.countries.delete');



<<<<<<< HEAD

=======
Route::get('informations', [InformationController::class, 'index'])->name('api.v1.informations.index');
Route::post('informations', [InformationController::class, 'store'])->name('api.v1.informations.store');
Route::get('informations/{information}', [InformationController::class, 'show'])->name('api.v1.informations.show');
Route::put('informations/{information}', [InformationController::class, 'update'])->name('api.v1.informations.update');
Route::delete('informations/{information}', [InformationController::class, 'destroy'])->name('api.v1.informations.delete');
>>>>>>> 9dce23307d5438e4637fbc467083614d379ce2ec

Route::get('dates', [DateController::class, 'index'])->name('api.v1.dates.index');
Route::post('dates', [DateController::class, 'store'])->name('api.v1.dates.store');
Route::get('dates/{date}', [DateController::class, 'show'])->name('api.v1.dates.show');
Route::put('dates/{date}', [DateController::class, 'update'])->name('api.v1.dates.update');
Route::delete('dates/{date}', [DateController::class, 'delete'])->name('api.v1.dates.delete');


<<<<<<< HEAD
Route::get('searchs',[SearchController::class,'index'])->name('api.v1.searchs.index');
Route::post('searchs',[SearchController::class,'store'])->name('api.v1.searchs.store');
Route::get('searchs/{search}',[SearchController::class,'show'])->name('api.v1.searchs.show');
Route::put('searchs/{search}',[SearchController::class,'update'])->name('api.v1.searchs.update');
Route::delete('searchs/{search}',[SearchController::class,'delete'])->name('api.v1.searchs.delete');

Route::get('areas',[AreaController::class,'index'])->name('api.v1.areas.index');
Route::post('areas',[AreaController::class,'store'])->name('api.v1.areas.store');
Route::get('areas/{area}',[AreaController::class,'show'])->name('api.v1.areas.show');
Route::put('areas/{area}',[AreaController::class,'update'])->name('api.v1.areas.update');
Route::delete('areas/{area}',[AreaController::class,'delete'])->name('api.v1.areas.delete');
=======
Route::get('consultings', [ConsultingController::class, 'index'])->name('api.v1.consultings.index');
Route::post('consultings', [ConsultingController::class, 'store'])->name('api.v1.consultings.store');
Route::get('consultings/{consulting}', [ConsultingController::class, 'show'])->name('api.v1.consultings.show');
Route::put('consultings/{consulting}', [ConsultingController::class, 'update'])->name('api.v1.consultings.update');
Route::delete('consultings/{consulting}', [ConsultingController::class, 'delete'])->name('api.v1.consultings.delete');
>>>>>>> 9dce23307d5438e4637fbc467083614d379ce2ec


<<<<<<< HEAD
Route::get('reviews',[ReviewController::class,'index'])->name('api.v1.reviews.index');
Route::post('reviews',[ReviewController::class,'store'])->name('api.v1.reviews.store');
Route::get('reviews/{review}',[ReviewController::class,'show'])->name('api.v1.rivews.show');
Route::put('reviews/{rivew}',[ReviewController::class,'update'])->name('api.v1.rivews.update');
Route::delete('reviews/{review}',[ReviewController::class,'delete'])->name('api.v1.rivews.delete');

Route::get('overhaulreviews',[OverhaulReviewController::class,'index'])->name('api.v1.overhaulreviews.index');
Route::post('overhaulreviews',[ReviewController::class,'store'])->name('api.v1.overhaulreviews.store');
Route::get('overhaulreviews/{overhaulreview}',[ReviewController::class,'show'])->name('api.v1.overhaulreviews.show');
Route::put('overhaulreviews/{overhaulreview}',[ReviewController::class,'update'])->name('api.v1.overhaulreviews.update');
Route::delete('overhaulreviews/{overhaulreview}',[ReviewController::class,'delete'])->name('api.v1.overhaulreviews.delete');

Route::get('lawyerprofiles',[LawyerProfileController::class,'index'])->name('api.v1.lawyerprofiles.index');
Route::post('lawyerprofiles',[LawyerProfileController::class,'store'])->name('api.v1.lawyerprofiles.store');
Route::get('lawyerprofiles/{lawyerprofile}',[LawyerProfileController::class,'show'])->name('api.v1.lawyerprofiles.show');
Route::put('lawyerprofiles/{lawyerprofile}',[LawyerProfileController::class,'update'])->name('api.v1.lawyerprofiles.update');
Route::delete('lawyerprofiles/{lawyerprofile}',[LawyerProfileController::class,'delete'])->name('api.v1.lawyerprofiles.delete');
=======

Route::get('notifications', [NotificationController::class, 'index'])->name('api.v1.notifications.index');
Route::post('notifications', [NotificationController::class, 'store'])->name('api.v1.notifications.store');
Route::get('notifications/{notification}', [NotificationController::class, 'show'])->name('api.v1.notifications.show');
Route::put('notifications/{notification}', [NotificationController::class, 'update'])->name('api.v1.notifications.update');
Route::delete('notifications/{notification}', [NotificationController::class, 'delete'])->name('api.v1.notifications.delete');


Route::get('searchs', [SearchController::class, 'index'])->name('api.v1.searchs.index');
Route::post('searchs', [SearchController::class, 'store'])->name('api.v1.searchs.store');
Route::get('searchs/{search}', [SearchController::class, 'show'])->name('api.v1.searchs.show');
Route::put('searchs/{search}', [SearchController::class, 'update'])->name('api.v1.searchs.update');
Route::delete('searchs/{search}', [SearchController::class, 'delete'])->name('api.v1.searchs.delete');

Route::get('areas', [AreaController::class, 'index'])->name('api.v1.areas.index');
Route::post('areas', [AreaController::class, 'store'])->name('api.v1.areas.store');
Route::get('areas/{area}', [AreaController::class, 'show'])->name('api.v1.areas.show');
Route::put('areas/{area}', [AreaController::class, 'update'])->name('api.v1.areas.update');
Route::delete('areas/{area}', [AreaController::class, 'delete'])->name('api.v1.areas.delete');

Route::get('areasLawyer', [AreaLawyerController::class, 'index'])->name('api.v1.areasLawyer.index');
Route::post('areasLawyer', [AreaLawyerController::class, 'store'])->name('api.v1.areasLawyer.store');
Route::get('areasLawyer/{areaLawyer}', [AreaLawyerController::class, 'show'])->name('api.v1.areasLawyer.show');
Route::put('areasLawyer/{areaLawyer}', [AreaLawyerController::class, 'update'])->name('api.v1.areasLawyer.update');
Route::delete('areasLawyer/{areaLawyer}', [AreaLawyerController::class, 'delete'])->name('api.v1.areasLawyer.delete');

Route::get('reviews', [ReviewController::class, 'index'])->name('api.v1.reviews.index');
Route::post('reviews', [ReviewController::class, 'store'])->name('api.v1.reviews.store');
Route::get('reviews/{review}', [ReviewController::class, 'show'])->name('api.v1.rivews.show');
Route::put('reviews/{rivew}', [ReviewController::class, 'update'])->name('api.v1.rivews.update');
Route::delete('reviews/{review}', [ReviewController::class, 'delete'])->name('api.v1.rivews.delete');
>>>>>>> 9dce23307d5438e4637fbc467083614d379ce2ec
