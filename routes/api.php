<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\WpsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

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

Route::post("/login", [\App\Http\Controllers\AuthController::class, "login"]);

Route::group(["middleware" => ["auth"]], function () {
    Route::get("/logout", [\App\Http\Controllers\AuthController::class, "logout"]);
    Route::get("/getMenus", [\App\Http\Controllers\UsersController::class, "getMenus"]);
    Route::get("/getUserDetails", [\App\Http\Controllers\AuthController::class, "getUserDetails"]);

    Route::group(["prefix" => "user"], function () {
        Route::post('/create', [UsersController::class, 'createUser']);
        Route::get("/roles", [UsersController::class, 'getRoles']);
    });
});
