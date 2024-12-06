<?php

use App\Http\Controllers\DashboardController;
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
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\AreaController;
use App\Http\Controllers\Api\AreaLawyerController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForgetPasswordController;
use App\Http\Controllers\Api\ForumCategoryController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\VerificationLawyerController;
use App\Http\Controllers\Api\LawyerController;
use App\Http\Controllers\Api\OverhaulReviewController;
use App\Http\Controllers\Api\LawyerProfileController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MeetingController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function () {
    return view('welcome');
});


// Route::post('/login', [AuthController::class, 'login']);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([

    'middleware' => ['auth:api,lawyer,administrator'],
    'prefix' => 'auth'

], function ($router) {
    // Route::post('/register', [AuthController::class, 'register'])->name('register');
    // Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->name('me');

    Route::post('/meLawyer', [LawyerController::class, 'me'])->name('meLawyer');


});


Route::post('/register', [UserController::class, 'register'])->name('register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/logoutPrueba', [LawyerController::class, 'logout'])->name('logoutPrueba');


Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/registerLawyer', [AuthController::class, 'registerLawyer'])->name('registerPRUEBA')->middleware('guest');
Route::post('/registerLawyerMovil', [LawyerController::class, 'registerLawyer'])->name('registromovil');



Route::get('answers', [AnswerController::class, 'index'])->name('api.v1.answers.index');
Route::post('answers', [AnswerController::class, 'store'])->name('api.v1.answers.store');
Route::get('answers/{answer}', [AnswerController::class, 'show'])->name('api.v1.answers.show');
Route::put('answers/{answer}', [AnswerController::class, 'update'])->name('api.v1.answers.update');
Route::delete('answers/{answer}', [AnswerController::class, 'destroy'])->name('api.v1.answers.delete');


Route::get('li', [QuestionController::class, 'indexr'])->name('api.v1.likes.index');
Route::get('li/{like}', [QuestionController::class, 'shows'])->name('api.v1.likes.show');



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
Route::get('/trends', [ForumCategoryController::class, 'getTrends']);

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
// Route::post('users', [UserController::class, 'store'])->name('api.v1.users.store');
Route::get('users/{user}', [UserController::class, 'show'])->name('api.v1.users.show');
Route::put('users/{user}', [UserController::class, 'update'])->name('api.v1.users.update');
Route::delete('users/{user}', [UserController::class, 'destroy'])->name('api.v1.users.delete');

Route::get('usersProfile', [UserProfileController::class, 'index'])->name('api.v1.usersProfile.index');
Route::post('usersProfile', [UserProfileController::class, 'store'])->name('api.v1.usersProfile.store');
Route::get('usersProfile/{userProfile}', [UserProfileController::class, 'show'])->name('api.v1.usersProfile.show');
Route::put('usersProfile/{userProfile}', [UserProfileController::class, 'update'])->name('api.v1.usersProfile.update');
Route::delete('usersProfile/{userProfile}', [UserProfileController::class, 'destroy'])->name('api.v1.usersProfile.delete');

Route::post('/profile', [UserProfileController::class, 'updateUserProfile'])->middleware('auth');

Route::get('/getprofile', [UserProfileController::class, 'getProfile'])->middleware('auth');


Route::post('/profileLawyer', [LawyerProfileController::class, 'updateOrCreateProfile']);

Route::get('/getProfileLawyer', [LawyerProfileController::class, 'getProfile']);

Route::get('/getAreasLawyer', [AreaLawyerController::class, 'getAreasLawyer']);


Route::post('/verificationLawyerPerfil', [LawyerProfileController::class, 'updateOrCreateVerification']);

Route::get('/getVerificationLawyer', [LawyerProfileController::class, 'getVerification']);

Route::get('/verPerfilAbogado/{lawyerId}', [LawyerProfileController::class, 'getLawyerDetails']);



Route::get('countries', [DropdownController::class, 'indexCountry'])->name('api.v1.countries.index');
Route::post('countries', [DropdownController::class, 'storeCountry'])->name('api.v1.countries.store');
// Route::get('countries/{country}', [DropdownController::class, 'showCountry'])->name('api.v1.countries.show');
// Route::put('countries/{country}', [DropdownController::class, 'updateCountry'])->name('api.v1.countries.update');
// Route::delete('countries/{country}', [DropdownController::class, 'destroyCountry'])->name('api.v1.countries.delete');

Route::get('states', [DropdownController::class, 'indexState'])->name('api.v1.states.index');
Route::post('states', [DropdownController::class, 'storeState'])->name('api.v1.states.store');
// Route::get('states/{state}', [DropdownController::class, 'showState'])->name('api.v1.states.show');
// Route::put('states/{state}', [DropdownController::class, 'updateState'])->name('api.v1.states.update');
// Route::delete('states/{state}', [DropdownController::class, 'destroyState'])->name('api.v1.states.delete');

Route::get('cities', [DropdownController::class, 'indexCity'])->name('api.v1.cities.index');
Route::post('cities', [DropdownController::class, 'storeCity'])->name('api.v1.cities.store');
// Route::get('cities/{city}', [DropdownController::class, 'showCity'])->name('api.v1.cities.show');
// Route::put('cities/{city}', [DropdownController::class, 'updateCity'])->name('api.v1.cities.update');
// Route::delete('cities/{city}', [DropdownController::class, 'destroyCity'])->name('api.v1.cities.delete');


Route::get('/states/{countryId}', [DropdownController::class, 'indexStateByCountry']);
Route::get('/cities/{stateId}', [DropdownController::class, 'indexCityByState']);


Route::get('/informations', [InformationController::class, 'index'])->name('api.v1.informations.index');
Route::get('informations/view', [InformationController::class, 'view'])->name('api.v1.informations.view');
Route::get('/informations/search', [InformationController::class, 'search']);
// routes/web.php
Route::get('/informations/{id}', [InformationController::class, 'getInformationDetails'])->name('api.v1.informations.getInformationDetails');


Route::post('/informations', [InformationController::class, 'store'])->name('api.v1.informations.store');
Route::get('/informations/{information}', [InformationController::class, 'show'])->name('api.v1.informations.show');
Route::get('/informations/{information}', [InformationController::class, 'search'])->name('api.v1.informations.search');
//Route::put('informations/{information}', [InformationController::class, 'update'])->name('api.v1.informations.update');
//Route::delete('informations/{information}', [InformationController::class, 'destroy'])->name('api.v1.informations.delete');

Route::get('/user-questions-with-answers', [ConsultingController::class, 'getUserQuestionsWithAnswers']);



Route::get('dates', [DateController::class, 'index'])->name('api.v1.dates.index');
Route::post('/guardarDisponibilidad', [DateController::class, 'store'])->name('api.v1.dates.store');
Route::get('/disponibilidadesAbogado', [DateController::class, 'getAvailabilities'])->name('api.v1.disponibilidades');

Route::get('/calendarioAbogado/{lawyerId}', [DateController::class, 'calendarioAbogado'])->name('api.v1.calendarioAbogado');

Route::get('dates/{date}', [DateController::class, 'show'])->name('api.v1.dates.show');
Route::put('dates/{date}', [DateController::class, 'update'])->name('api.v1.dates.update');
Route::delete('dates/{date}', [DateController::class, 'destroy'])->name('api.v1.dates.delete');

Route::get('searches',[SearchController::class,'index'])->name('api.v1.searches.index');
Route::post('searches',[SearchController::class,'store'])->name('api.v1.searches.store');
Route::get('searches/{search}',[SearchController::class,'show'])->name('api.v1.searches.show');
Route::put('searches/{search}',[SearchController::class,'update'])->name('api.v1.searches.update');
Route::delete('searches/{search}',[SearchController::class,'destroy'])->name('api.v1.searches.delete');


Route::get('consultings', [ConsultingController::class, 'index'])->name('api.v1.consultings.index');
Route::post('/guardarAsesoria', [ConsultingController::class, 'store'])->name('api.v1.consultings.store');
Route::get('consultings/{consulting}', [ConsultingController::class, 'show'])->name('api.v1.consultings.show');
Route::put('consultings/{consulting}', [ConsultingController::class, 'update'])->name('api.v1.consultings.update');
Route::delete('consultings/{consulting}', [ConsultingController::class, 'destroy'])->name('api.v1.consultings.delete');


Route::get('reviews',[ReviewController::class,'index'])->name('api.v1.reviews.index');
Route::post('reviews',[ReviewController::class,'store'])->name('api.v1.reviews.store');
Route::get('reviews/{review}',[ReviewController::class,'show'])->name('api.v1.rivews.show');
Route::put('reviews/{rivew}',[ReviewController::class,'update'])->name('api.v1.rivews.update');
Route::delete('reviews/{review}',[ReviewController::class,'destroy'])->name('api.v1.rivews.delete');

Route::get('verificationLawyers',[VerificationLawyerController::class,'index'])->name('api.v1.verificationLawyers.index');
Route::post('/verificationLawyer',[VerificationLawyerController::class,'store'])->name('api.v1.verificationLawyers.store');
Route::get('verificationLawyers/{verificationLawyer}',[VerificationLawyerController::class,'show'])->name('api.v1.verificationLawyers.show');
Route::put('verificationLawyers/{verificationLawyer}',[VerificationLawyerController::class,'update'])->name('api.v1.verificationLawyers.update');
Route::delete('verificationLawyers/{verificationLawyer}',[VerificationLawyerController::class,'destroy'])->name('api.v1.verificationLawyers  .delete');

Route::get('overhaulreviews',[OverhaulReviewController::class,'index'])->name('api.v1.overhaulreviews.index');
Route::post('overhaulreviews',[OverhaulReviewController::class,'store'])->name('api.v1.overhaulreviews.store');
Route::get('overhaulreviews/{overhaulreview}',[OverhaulReviewController::class,'show'])->name('api.v1.overhaulreviews.show');
Route::put('overhaulreviews/{overhaulreview}',[OverhaulReviewController::class,'update'])->name('api.v1.overhaulreviews.update');
Route::delete('overhaulreviews/{overhaulreview}',[OverhaulReviewController::class,'destroy'])->name('api.v1.overhaulreviews.delete');

Route::get('lawyerProfile', [LawyerProfileController::class, 'index'])->name('lawyerProfile.index');
Route::post('lawyerProfile', [LawyerProfileController::class, 'store'])->name('lawyerProfile.store');
Route::get('lawyerProfile/{lawyerProfile}', [LawyerProfileController::class, 'show'])->name('lawyerProfile.show');
Route::put('lawyerProfile/{lawyerProfile}', [LawyerProfileController::class, 'update'])->name('lawyerProfile.update');
Route::delete('lawyerProfile/{lawyerProfile}', [LawyerProfileController::class, 'destroy'])->name('lawyerProfile.delete');

Route::get('searchs', [SearchController::class, 'index'])->name('api.v1.searchs.index');
Route::post('searchs', [SearchController::class, 'store'])->name('api.v1.searchs.store');
Route::get('searchs/{search}', [SearchController::class, 'show'])->name('api.v1.searchs.show');
Route::put('searchs/{search}', [SearchController::class, 'update'])->name('api.v1.searchs.update');
Route::get('/searches/history', [SearchController::class, 'getHistory']);
Route::post('/registrar-vista', [SearchController::class, 'registrarVista']);
Route::delete('searchs/{search}', [SearchController::class, 'destroy'])->name('api.v1.searchs.delete');

Route::get('/areas', [AreaController::class, 'index'])->name('api.v1.areas.index');
Route::post('areas', [AreaController::class, 'store'])->name('api.v1.areas.store');
Route::get('areas/{area}', [AreaController::class, 'show'])->name('api.v1.areas.show');
Route::put('areas/{area}', [AreaController::class, 'update'])->name('api.v1.areas.update');
Route::delete('areas/{area}', [AreaController::class, 'destroy'])->name('api.v1.areas.delete');

Route::get('areasLawyer', [AreaLawyerController::class, 'index'])->name('api.v1.areasLawyer.index');
Route::post('/saveAreas', [AreaLawyerController::class, 'saveSelectedAreas'])->name('api.v1.areasLawyer.store');
Route::get('areasLawyer/{areaLawyer}', [AreaLawyerController::class, 'show'])->name('api.v1.areasLawyer.show');
Route::put('areasLawyer/{areaLawyer}', [AreaLawyerController::class, 'update'])->name('api.v1.areasLawyer.update');
Route::delete('areasLawyer/{areaLawyer}', [AreaLawyerController::class, 'destroy'])->name('api.v1.areasLawyer.delete');

// Route::get('reviews', [ReviewController::class, 'index'])->name('api.v1.reviews.index');
Route::post('/enviarReviews', [ReviewController::class, 'store'])->name('api.v1.reviews.store');
Route::get('/reseñaAbogado/{lawyer_id}', [ReviewController::class, 'index']);
// Route::get('reviews/{review}', [ReviewController::class, 'show'])->name('api.v1.riv ews.show');
// Route::put('reviews/{rivew}', [ReviewController::class, 'update'])->name('api.v1.rivews.update');
// Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('api.v1.rivews.delete');

Route::get('lawyers', [LawyerController::class, 'index'])->name('api.v1.lawyers.index');
Route::post('/registrarLawyer', [LawyerController::class, 'registerLawyer'])->name('api.v1.lawyers.store');
Route::get('lawyers/{lawyer}', [LawyerController::class, 'show'])->name('api.v1.lawyers.show');
Route::put('lawyers/{lawyer}', [LawyerController::class, 'update'])->name('api.v1.lawyers.update');
Route::delete('lawyers/{lawyer}', [LawyerController::class, 'destroy'])->name('api.v1.lawyers.delete');

// Route::post('v1/validate-code', [ForgetPasswordController::class, 'validateCode'])->name('api.v1.validate-code');
// Route::post('/password', [ForgetPasswordController::class, 'store'])->name('api.v1.password.store');

Route::post('/password/email', [PasswordResetController::class, 'sendResetCode']);
Route::post('/password/reset', [PasswordResetController::class, 'resetPassword']);

//Endpoints para notificaciones

Route::post('/notifications/send', [NotificationController::class, 'sendNotification']);
Route::get('/notifications', [NotificationController::class, 'index']);
Route::patch('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead']);
Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);
Route::post('/notifications/{id}/archive', [NotificationController::class, 'archive']);
Route::delete('/notifications/delete-all', [NotificationController::class, 'destroyAll']);
Route::post('notifications/mark-all', [NotificationController::class, 'markAllAsRead']);
Route::post('/notifications/archive-all', [NotificationController::class, 'archiveAll']);
Route::get('/notifications/{id}', [NotificationController::class, 'show']);
Route::post('/notifications/{id}/like', [NotificationController::class, 'likeNotification']);

Route::get('/chart-data/clients', [DashboardController::class, 'clients']);
Route::get('/chart-data/reviews', [DashboardController::class, 'reviews']);
Route::get('/chart-data/information', [DashboardController::class, 'information']);
Route::get('/chart-data/sessions', [DashboardController::class, 'sessions']);
Route::get('/chart-data/visitors', [DashboardController::class, 'visitors']);
Route::get('/chart-data/users-by-role', [DashboardController::class, 'usersByRole']);

Route::post('/create-meeting', [MeetingController::class, 'createMeeting']);


    Route::post('/react/{id}/react', [QuestionController::class, 'toggleLike']);
    Route::get('/reactions/{id}/reactions', [QuestionController::class, 'getLikes'])->name('api.v1.slikes.show');


    Route::get('/likes/{question_id}', [LikeController::class, 'getLikes']);
    Route::post('/lk', [LikeController::class, 'store']);
    Route::post('/question/{id}/react', [QuestionController::class, 'toggleLike']);
    Route::get('/question/{id}/reactions', [QuestionController::class, 'getLikes'])->name('api.v1.slikes.show');
