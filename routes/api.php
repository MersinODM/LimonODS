<?php

use App\Http\Controllers\Api\App\ExamController;
use App\Http\Controllers\Api\App\QuestionController;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//question
Route::get("v1/questions/{id}", [QuestionController::class, "get"]);
Route::post("v1/questions", [QuestionController::class, "save"]);
Route::put("v1/questions/{id}", [QuestionController::class, "update"]);
Route::delete("v1/questions/{id}", [QuestionController::class, "delete"]);
//exam
Route::get("v1/exams/{id}", [ExamController::class, "get"]);
Route::post("v1/exams", [ExamController::class, "save"]);
Route::put("v1/exams/{id}", [ExamController::class, "update"]);
Route::delete("v1/exams/{id}", [ExamController::class, "delete"]);