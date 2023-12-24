<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::get('all', 'UserController@all');
        Route::get('{user}', 'UserController@show');
        Route::post('/', 'UserController@store');
        Route::put('/{user}', 'UserController@update');
        Route::delete('/{user}', 'UserController@delete');
    });
});

Route::group(['prefix' => 'auth/form', 'namespace' => 'auth'], function () {
    Route::post('register', 'FormController@register');
    Route::post('login', 'FormController@login');
});
