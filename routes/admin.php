<?php

use App\Http\Controllers\Admin\MainController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/main',[MainController::class, 'index']);
Route::get('/generals/{name}',[MainController::class, 'viewGeneralModule']);


//Route::get('/generals/{module}', function ($module){
//    Route::get('/{module}',[MainController::class, 'generals']);
//});
//
//Route::get('/generals/{module}', function ($module){
//    switch ($module){
//        case 'cities':
//            return view('Admin.generals.cities');
//        default:
//            return Route::redirect(url('main'));
//    }
//});
