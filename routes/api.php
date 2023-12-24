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

    // District Routes
    Route::get("/getDistrictList", [DistrictController::class, "getDistrictList"]);

    // Agency Routes
    Route::post("/createAgency", [AgencyController::class, "createAgency"]);
    Route::get("/getAllAgency", [AgencyController::class, "getAllAgency"]);
    Route::get("/getAgency/{id}", [AgencyController::class, "getAgency"]);
    Route::post("/updateAgency", [AgencyController::class, "updateAgency"]);
    Route::get("/getAgencyList", [AgencyController::class, "getAgencyList"]);

    // Women Police Station Routes
    Route::post("/createWps", [WpsController::class, "createWps"]);
    Route::get("/getAllWps", [WpsController::class, "getAllWps"]);
    Route::get("/getWps/{id}", [WpsController::class, "getWps"]);
    Route::post("/updateWps", [WpsController::class, "updateWps"]);
    Route::get("/getWpsList", [WpsController::class, "getWpsList"]);

    //counselling Centre Route
    Route::post("/createCouncellingCentre", [\App\Http\Controllers\CounsellingCentresController::class, "createCouncellingCentre"]);
    Route::get("/getCouncellingCentre", [\App\Http\Controllers\CounsellingCentresController::class, "getCouncellingCentre"]);
    Route::get("/getCouncellingCentre/{id}", [\App\Http\Controllers\CounsellingCentresController::class, "getCouncellingCentreById"]);
    Route::post("/updateCouncellingCentreById", [\App\Http\Controllers\CounsellingCentresController::class, "updateCouncellingCentreById"]);
    Route::get("/getCounsellingCentreList", [\App\Http\Controllers\CounsellingCentresController::class, "getCounsellingCentreList"]);

    //Users Routes
    Route::get('/getAllUsers', [UsersController::class, 'getAllUsers']);
    Route::get('/getAllowedUserCreationRoles', [UsersController::class, 'getAllowedUserCreationRoles']);
    Route::post('/createUser', [UsersController::class, 'createUser']);
});
