<?php

use App\Http\Controllers\api\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Use App\Models\Plants;
use App\Http\Controllers\api\PlantsController;
use App\Http\Controllers\api\SizeController;
use App\Http\Controllers\api\ColorController;
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

Route::post('plants', 'PlantsController@store');
Route::get('plants', 'PlantsController@index');
Route::get('plants/{plants}', 'PlantsController@show');
Route::put('plants/{plants}', 'PlantsController@update');
Route::delete('plants/{plants}', 'PlantsController@delete');

Route::post('sizes', 'SizeController@store');
Route::get('sizes', 'SizeController@index');

Route::post('colors', 'ColorController@store');
Route::get('colors', 'ColorController@index');

Route::post('category', 'CategoryController@store');
Route::get('category', 'CategoryController@index');

Route::middleware('auth:api')
    ->get('/user', function (Request $request) {
        return $request->user();
    });


Route::group(['middleware' => 'auth:api'], function() {
    
});