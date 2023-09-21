<?php

use App\Http\Controllers\api\GeneralController;
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

Route::get('/cities', [GeneralController::class, 'cities']);
Route::get('/regions', [GeneralController::class, 'regions']);
Route::get('/categories', [GeneralController::class, 'categories']);
Route::get('/reviews', [GeneralController::class, 'reviews']);
Route::get('/restaurants', [GeneralController::class, 'restaurants']);
Route::get('/meals', [GeneralController::class, 'meals']);
