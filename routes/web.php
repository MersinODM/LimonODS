<?php

use App\Http\Controllers\Web\App\AuthController as AppWebAuthController;
use App\Http\Controllers\Web\App\AppController as AppWebController;
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

Route::post('app/auth/login', [AppWebAuthController::class, "login"]);
//Route::post('exam/auth/login', [ExamWebAuthController::class, "login"]);
Route::get('app/{any?}', [AppWebController::class, "app"])
    ->where('any', '^(?!api|password\/reset).*$')
    ->name("management");