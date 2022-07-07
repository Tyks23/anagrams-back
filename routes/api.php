<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\AnagramController;
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
Route::post('login', [LoginController::class, 'login']);
Route::get('users', [UserController::class, 'index']);
Route::post('register', [RegisterController::class, 'register']);

Route::post('uploadWordbase', [WordController::class, 'uploadWordbase'])->middleware('auth:api');
Route::post('findAnagrams', [AnagramController::class, 'findAnagrams'])->middleware('auth:api');
Route::middleware('auth:api')->get('/profile', function(Request $request) {
    return $request->user();
});
// for "auth"enticated users
/*Route::group(['middleware' => ['auth:api']], function () {
    Route::get('word', [WordController::class, 'index']);
});*/
