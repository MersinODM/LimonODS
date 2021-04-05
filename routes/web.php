<?php

use App\Http\Controllers\Web\App\AuthController as AppWebAuthController;
use App\Http\Controllers\Web\App\AppController as AppWebController;
use App\Http\Controllers\Web\Exam\ExamController as ExamWebController;
use App\Http\Controllers\Web\Exam\AuthController as ExamAuthController;
use App\Http\Controllers\Web\MainController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainController::class, "main"]);

Route::post('app/auth/login', [AppWebAuthController::class, "login"])->name('login');
Route::post('exam/auth/login', [ExamAuthController::class, "login"])->name('exam-login');
//Route::post('exam/auth/login', [ExamWebAuthController::class, "login"]);
Route::get('app/{any?}', [AppWebController::class, "app"])
    ->where('any', '^(?!api|password\/reset).*$')
    ->name("app");

Route::get('exam/{any?}', [ExamWebController::class, "exam"])
    ->where('any', '^(?!api|password\/reset).*$')
    ->name("exam");