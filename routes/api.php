<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AuthorController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\LoanController;
use App\Http\Controllers\API\ReservationController;
use App\Http\Controllers\API\FineController;
use App\Http\Controllers\API\SystemSettingController;

Route::post('auth/login', [AuthController::class,'login'])->name('login');
Route::post('auth/register', [AuthController::class,'register'])->name('register');;

Route::middleware('jwt.auth')->group(function () {
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('authors', AuthorController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('books', BookController::class);
    Route::apiResource('loans', LoanController::class);
    Route::apiResource('reservations', ReservationController::class);
    Route::apiResource('fines', FineController::class);
    Route::apiResource('settings', SystemSettingController::class)->only(['index','update']);
});
