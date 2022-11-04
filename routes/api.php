<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\HomeController;

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

Auth::routes();

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::middleware('throttle:api')->group(function() {
    Route::controller(DashboardController::class)->group(function() {
        Route::get('getCardsList', 'getCardsList');
        Route::get('getAddressesList', 'getAddressesList');
        Route::post('addAddresses', 'addAddresses');
    });

    // Authorization
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout');
        // facebook
        Route::get('auth/facebook', 'FacebookAuthentication')->name('facebook');
        Route::get('auth/facebook/callback/{return}', 'FacebookAuthentication');
        // google
        Route::get('auth/google', 'GoogleAuthentication')->name('google');
        Route::get('auth/google/callback/{return}', 'GoogleAuthentication');
    
        // BOG
    });
});