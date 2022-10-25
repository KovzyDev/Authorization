<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\HomeController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('throttle:api')->group(function() {
    Route::group(['middleware' => ['auth', 'verified']], function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
    });

});


Route::prefix('auth')->group(function() {
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout');
        // facebook
        Route::get('/facebook', 'FacebookAuthentication')->name('facebook');
        Route::get('/facebook/callback/{return}', 'FacebookAuthentication');
        // google
        Route::get('/google', 'GoogleAuthentication')->name('google');
        Route::get('/google/callback/{return}', 'GoogleAuthentication');

        // BOG
    });
});

