<?php

use App\Http\Controllers\ListLocationsController;
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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function($api) {
    $api->group(['namespace' => 'App\Http\Controllers'], function() use($api) {

        $api->get('location', 'ListLocationsController@index');
        $api->get('location/{id}', 'ListLocationsController@show');
        $api->post('location', 'ListLocationsController@store');
        $api->put('location/{id}/update', 'ListLocationsController@update');
        $api->delete('location/{id}/delete', 'ListLocationsController@delete');

    });
});
