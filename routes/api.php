<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\AuthController;
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

Route::post("/login", [AuthController::class, "login"]);

Route::group(["middleware" => ["auth"]], function () {
    Route::get("/logout", [AuthController::class, "logout"]);
    Route::get("/getMenus", [UsersController::class, "getMenus"]);
    Route::get("/getUserDetails", [AuthController::class, "getUserDetails"]);

    Route::group(["prefix" => "user"], function () {
        Route::post('/create', [UsersController::class, 'createUser']);
        Route::get("/roles", [UsersController::class, 'getRoles']);
        Route::get("/getAll", [UsersController::class, 'getUserList']);
        Route::put("/changeStatus", [UsersController::class, 'changeStatus']);
        Route::delete("/{user}", [UsersController::class, 'deleteUser']);
    });
});
