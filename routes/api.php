<?php

use App\Http\Controllers\ListLocationsController;
use App\Http\Controllers\CategoryLocationsController;
use App\Http\Controllers\GaleryController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'jwt.verify'], function(){
    Route::post('logout', [UsersController::class, 'logout']);
    Route::get('me', [UsersController::class, 'getAuthenticatedUser']);
    Route::post('test', [UsersController::class, 'test']);
    Route::post('/editProfile', [UsersController::class, 'update']);
});

Route::post('register', [UsersController::class, 'register']);
Route::post('login', [UsersController::class, 'login']);

Route::get('/dashboard', [ListLocationsController::class, 'dashboard']);
Route::get('/acomodation', [ListLocationsController::class, 'getAcomodation']);
Route::get('/galery', [GaleryController::class, 'index']);

Route::get('/locations', [ListLocationsController::class, 'index'])->name('user');
Route::get('/locations/search', [ListLocationsController::class, 'search']);
Route::get('/locations/{id}', [ListLocationsController::class, 'show']);

Route::group(['prefix' => 'galery',  'middleware' => ['jwt.verify','role.check']], function() {
    Route::get('/read', [GaleryController::class, 'index']);
    Route::post('/create', [GaleryController::class, 'store']);
    Route::post('/update/{id}', [GaleryController::class, 'update']);
    Route::delete('/delete/{id}', [GaleryController::class, 'destroy']);
});

Route::group(['prefix' => 'location'/*,  'middleware' => ['jwt.verify','role.check']*/ ], function() {
    Route::get('/read', [ListLocationsController::class, 'read']);
    Route::post('/create', [ListLocationsController::class, 'store']);
    Route::post('/update/{id}', [ListLocationsController::class, 'update']);
    Route::delete('/delete/{id}', [ListLocationsController::class, 'destroy']);
});

Route::group(['prefix' => 'category' /*,  'middleware' => ['jwt.verify','role.check']*/], function() {
    Route::get('/{id}', [CategoryLocationsController::class, 'show']);
    Route::get('/', [CategoryLocationsController::class, 'read']);
    Route::post('/create', [CategoryLocationsController::class, 'store']);
    Route::put('/update/{id}', [CategoryLocationsController::class, 'update']);
    Route::delete('/delete/{id}', [CategoryLocationsController::class, 'destroy']);
});
