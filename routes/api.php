<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["prefix" => "/v1"], function () {
    Route::group(["namespace" => "Api\\v1\\"], function () {
        Route::group(["namespace" => "Users\\"], function () {
            Route::post("/login", "UserController@login");
            Route::post("/register", "UserController@register");
            Route::post("/logout/{user}", "UserController@logout");

            Route::apiResource('/role', 'RoleController');
            Route::get('/role/index/only_trashed', 'RoleController@indexOnlyTrashed');
            Route::post('/role/restore/{role}', 'RoleController@restore');
            Route::delete('/role/forceDelete/{role}', 'RoleController@forceDestroy');
        });
    });
});
