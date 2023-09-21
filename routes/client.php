<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Client\AuthController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/restaurants', 'RestaurantController@restaurants');
Route::get('/one-restaurant/{id}', 'RestaurantController@oneRestaurant');

Route::get('/one-restaurant-meals/{id}', 'RestaurantController@oneRestaurantMeals');
Route::get('/one-restaurant-reviews/{id}', 'RestaurantController@oneRestaurantReviews');
Route::get('/one-restaurant-info/{id}', 'RestaurantController@oneRestaurantInfo');

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/profile', 'AuthController@profile');

    Route::post('/add-review', 'RestaurantController@addReview');

    Route::post('/create-order', 'RestaurantController@createOrder');

    Route::get('/current-orders', 'OrderController@currentOrders');
    Route::get('/past-orders', 'OrderController@pastOrders');

    Route::get('/client-notification', 'OrderController@clientNotifications');
    Route::post('/read-client-notification', 'OrderController@readClientNotifications');

    Route::post('/deliver', 'OrderController@deliver');
    Route::post('/decline/{id}', 'OrderController@decline');
});

Route::post('/contact-us', 'GeneralController@contactUs');
Route::get('/settings', 'GeneralController@settings')->middleware('auth:sanctum');
Route::get('/offers', 'GeneralController@offers');