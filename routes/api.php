<?php

use App\Http\Controllers\ListLocationsController;
use App\Http\Controllers\CategoryLocationsController;
use App\Http\Controllers\GaleryController;
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

Route::group(['middleware' => 'jwt.verify'], function(){
    Route::post('logout', [UsersController::class, 'logout']);
    Route::post('me', [UsersController::class, 'me']);
    Route::post('test', [UsersController::class, 'test']);
    Route::post('/editProfile', [UsersController::class, 'update']);
});

Route::post('register', [UsersController::class, 'register']);
Route::post('login', [UsersController::class, 'login']);

Route::get('/locations', [ListLocationsController::class, 'index'])->name('user');
Route::get('/locations/search', [ListLocationsController::class, 'search']);
Route::get('/locations/{id}', [ListLocationsController::class, 'show']);
Route::get('/category/{id}', [CategoryLocationsController::class, 'show']);
Route::get('/akomodasi', [ListLocationsController::class, 'getAcomodation']);

Route::group(['prefix' => 'galery',  'middleware' => ['jwt.verify','role.check']], function() {
    Route::get('/', [GaleryController::class, 'index']);
    Route::get('/{id}', [GaleryController::class, 'show']);
    Route::post('/', [GaleryController::class, 'store']);
    Route::post('/update/{id}', [GaleryController::class, 'update']);
    Route::delete('/delete/{id}', [GaleryController::class, 'destroy']);
});

Route::group(['prefix' => 'locations',  'middleware' => ['jwt.verify','role.check']], function() {
    Route::post('/', [ListLocationsController::class, 'store']);
    Route::post('/update/{id}', [ListLocationsController::class, 'update']);
    Route::delete('/delete/{id}', [ListLocationsController::class, 'destroy']);
});

Route::group(['prefix' => 'category',  'middleware' => ['jwt.verify','role.check']], function() {
    Route::get('/', [CategoryLocationsController::class, 'index']);
    Route::post('/', [CategoryLocationsController::class, 'store']);
    Route::put('/update/{id}', [CategoryLocationsController::class, 'update']);
    Route::delete('/delete/{id}', [CategoryLocationsController::class, 'destroy']);
});