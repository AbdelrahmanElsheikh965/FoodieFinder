<?php

use App\Http\Controllers\Api\Restaurant\OrderController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::apiResource('meals', 'MealController');
    Route::apiResource('offers', 'OfferController');
    Route::get('new-orders', 'OrderController@newOrders');
    Route::get('current-orders', 'OrderController@currentOrders');
    Route::get('past-orders', 'OrderController@pastOrders');

    Route::post('/profile', 'AuthController@profile');

    Route::post('/accept/{id}', 'OrderController@accept');
    Route::post('/reject/{id}', 'OrderController@reject');
});

Route::get('/commission', 'OrderController@commission');
Route::post('/reset-password', 'AuthController@resetPassword');
Route::post('/create-new-password', 'AuthController@createNewPassword');

