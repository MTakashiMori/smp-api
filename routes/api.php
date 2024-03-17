<?php

<<<<<<< HEAD
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SponsorController;
=======
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
>>>>>>> 7697ef8bfebcd35431649573b32fa369a71e60e9
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

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
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
    });

<<<<<<< HEAD
    Route::resource('product', ProductController::class);
    Route::resource('party', PartyController::class);
    Route::resource('sponsor', SponsorController::class);
=======
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);
>>>>>>> 7697ef8bfebcd35431649573b32fa369a71e60e9

});
