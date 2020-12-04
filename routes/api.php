<?php

use App\Http\Controllers\api\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Use App\Models\Plants;
use App\Http\Controllers\api\PlantsController;
use App\Http\Controllers\api\PlantInfoController;
use App\Http\Controllers\api\SizeController;
use App\Http\Controllers\api\ColorController;
use App\Http\Controllers\api\StatusController;
use App\Http\Controllers\api\DescController;
use App\Http\Controllers\api\OrdersController;
use App\Http\Controllers\api\OrdersPlantsController;
use App\Http\Controllers\api\DataDeliveryController;
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
Route::group([

    ['middleware' => 'throttle:20,5'],
    'prefix' => '/auth'

], function ($router) {
    Route::post('/register', 'Auth\RegisterController@register');
    Route::post('/login', 'Auth\LoginController@login');
});

Route::group([
    'middleware' => ['jwt.auth']
], function(){
    Route::get('/me', 'MeController@index')->name('/me');
    Route::get('/auth/logout', 'MeController@logout');
});

// Route::post('/register', 'Auth\RegisterController@register');
// Route::post('/login', 'Auth\LoginController@login')->name('login');

//Plants
Route::post('plants', 'PlantsController@store');
Route::get('plants', 'PlantsController@index');
Route::get('plants/{plants}', 'PlantsController@show');
//Route::put('plants/{plants}', 'PlantsController@update');
Route::delete('plants/{plants}', 'PlantsController@delete');

Route::get('plants/{plants}', 'PlantsController@searchTitle');
Route::put('plants/{plants}', 'PlantsController@updatePlants');

//PlantsInfo
Route::post('plants-info', 'PlantInfoController@store');
Route::get('plants-info', 'PlantInfoController@index');
Route::get('plants-info/{plants-info}', 'PlantInfoController@show');
Route::put('plants-info/{id}', 'PlantInfoController@update');
Route::put('plants-info-category/{id}', 'PlantInfoController@updateCategory');

//Orders
Route::post('orders', 'OrdersController@store');
Route::get('orders', 'OrdersController@index');
Route::get('orders/{orders}', 'OrdersController@show');
Route::delete('orders/{orders}', 'OrdersController@delete');
Route::put('orders/{orders}', 'OrdersController@updateOrders');

//OrdersPlants
Route::post('orders-plants', 'OrdersPlantsController@store');
Route::get('orders-plants', 'OrdersPlantsController@index');
Route::get('orders-plants/{orders-plants}', 'OrdersPlantsController@show');
Route::delete('orders-plants/{orders-plants}', 'OrdersPlantsController@delete');
Route::put('orders-plants/{orders-plants}', 'OrdersPlantsController@updateOrders');

//Data-delifery
Route::post('data-delivery', 'DataDeliveryController@store');
Route::get('data-delivery', 'DataDeliveryController@index');
Route::get('data-delivery/{data-delivery}', 'DataDeliveryController@show');
//Route::delete('data-delivery/{data-delivery}', 'OrdersPlantsController@delete');
Route::put('data-delivery/{orders-plants}', 'DataDeliveryController@updateOrders');



Route::post('sizes', 'SizeController@store');
Route::get('sizes', 'SizeController@index');

Route::post('colors', 'ColorController@store');
Route::get('colors', 'ColorController@index');

Route::post('category', 'CategoryController@store');
Route::get('category', 'CategoryController@index');

Route::post('status', 'StatusController@store');
Route::get('status', 'StatusController@index');

Route::post('decsription', 'DescController@store');
Route::get('decsription', 'DescController@index');

Route::middleware('auth:api')
    ->get('/user', function (Request $request) {
        return $request->user();
    });


Route::group(['middleware' => 'auth:api'], function() {
    
});