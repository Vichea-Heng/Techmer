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
    Route::group(["namespace" => "Api\\v1\\Users\\"], function () {
        Route::post("/login", "UserController@login");
        Route::post("/register", "UserController@register");
        Route::post("/logout/{user}", "UserController@logout");
    });
    // Route::group(["middleware" => "auth:api"], function () {
    Route::group(["namespace" => "Api\\v1\\"], function () {
        Route::group(["namespace" => "Users\\"], function () {
            Route::post("/addIdentity", "UserController@addIdentity");

            Route::apiResource('/role', 'RoleController');
            Route::get('/role/index/only_trashed', 'RoleController@indexOnlyTrashed');
            Route::post('/role/restore/{role}', 'RoleController@restore');
            Route::delete('/role/forceDelete/{role}', 'RoleController@forceDestroy');

            Route::apiResource('/permission', 'PermissionController');
            Route::get('/permission/index/only_trashed', 'PermissionController@indexOnlyTrashed');
            Route::post('/permission/restore/{permission}', 'PermissionController@restore');
            Route::delete('/permission/forceDelete/{permission}', 'PermissionController@forceDestroy');

            Route::apiResource('/permission_group', 'PermissionGroupController');
            Route::get('/permission_group/index/only_trashed', 'PermissionGroupController@indexOnlyTrashed');
            Route::post('/permission_group/restore/{permission_group}', 'PermissionGroupController@restore');
            Route::delete('/permission_group/forceDelete/{permission_group}', 'PermissionGroupController@forceDestroy');
        });
    });
    // });
});
