<?php

use App\Http\Controllers\ListLocationsController;
use App\Http\Controllers\CategoryLocationsController;
use App\Http\Controllers\UsersController;
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

Route::post('register', [UsersController::class, 'register']);
Route::post('login', [UsersController::class, 'login']);
Route::get('user', [UsersController::class, 'getAuthenticatedUser'])->middleware('jwt.verify');

Route::group(['middleware' =>['auth', 'jwt.verify']], function () {
    Route::get('/locations', [ListLocationsController::class, 'index']);
    Route::get('/locations/{id}', [ListLocationsController::class, 'show']);
    Route::get('/category', [CategoryLocationsController::class, 'index']);
    Route::get('/category/{id}', [CategoryLocationsController::class, 'show']);
});


Route::prefix('locations')->group(function () {
    // Route::get('/', [ListLocationsController::class, 'index']);
    // Route::get('/{id}', [ListLocationsController::class, 'show']);
    Route::post('/', [ListLocationsController::class, 'store']);
    Route::put('/update/{id}', [ListLocationsController::class, 'update']);
    Route::delete('/delete/{id}', [ListLocationsController::class, 'destroy']);
});

Route::prefix('category')->group(function () {
    
    Route::post('/', [CategoryLocationsController::class, 'store']);
    Route::put('/update/{id}', [CategoryLocationsController::class, 'update']);
    Route::delete('/delete/{id}', [CategoryLocationsController::class, 'destroy']);
});