<?php

use App\Http\Controllers\Api\App\AuthController as AppApiAuthController;
use App\Http\Controllers\Api\App\ExamController;
use App\Http\Controllers\Api\App\InstitutionController;
use App\Http\Controllers\Api\App\LessonController;
use App\Http\Controllers\Api\App\QuestionController;
use App\Http\Controllers\Api\App\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//Route::group(['prefix' => 'app'], static function () {
//});

Route::post('app/auth/login', [AppApiAuthController::class, 'login']);



/*
 * Uygulama v1 REST API HTTP rota tanımlamaları
 */
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'app/v1'], static function () {

    // Kullanıcı adı, rolleri ve izinleri geri döncecek
    Route::get("me", [UserController::class, "me"]);

    // Sorular ile ilgili rota tanımlamaları
    Route::get("questions/{id}", [QuestionController::class, "get"]);
    Route::post("questions", [QuestionController::class, "save"]);
    Route::put("questions/{id}", [QuestionController::class, "update"]);
    Route::delete("questions/{id}", [QuestionController::class, "delete"]);

    // Sınavlar ile ilgili rota tanımlamaları
    Route::get("exams/{id}", [ExamController::class, "get"]);
    Route::post("exams", [ExamController::class, "save"]);
    Route::put("exams/{id}", [ExamController::class, "update"]);
    Route::delete("exams/{id}", [ExamController::class, "delete"]);

    // Sorular ile ilgili rota tanımlamaları
    Route::get("institutions/{id}", [InstitutionController::class, "get"]);
    Route::post("institutions", [InstitutionController::class, "save"]);
    Route::put("institutions/{id}", [InstitutionController::class, "update"]);
    Route::delete("institutions/{id}", [InstitutionController::class, "delete"]);

    //Dersler ilgili rota tanımlamaları
    Route::get("lessons", [LessonController::class, "getAllLessons"]);
});

/*
 * E Sınav v1 REST Api rota tanımlamaları
 */
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'exam/v1'], static function () {

});



//exam
