<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\PartyMenuController;
use App\Http\Controllers\PartyMenuProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

    Route::resource('product', ProductController::class);
    Route::resource('party', PartyController::class);
    Route::post('party-menu/add-products', [PartyMenuController::class, 'addProducts']);
    Route::resource('party-menu', PartyMenuController::class);
    Route::resource('party-menu-products', PartyMenuProductController::class);
    Route::resource('sponsor', SponsorController::class);
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);

});
