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

        Route::group(["namespace" => "Products\\"], function () {
            Route::apiResource('/product_brand', 'ProductBrandController');
            Route::get('/product_brand/index/only_trashed', 'ProductBrandController@indexOnlyTrashed');
            Route::post('/product_brand/restore/{product_brand}', 'ProductBrandController@restore');
            Route::delete('/product_brand/forceDelete/{product_brand}', 'ProductBrandController@forceDestroy');

            Route::apiResource('/product_category', 'ProductCategoryController');
            Route::get('/product_category/index/only_trashed', 'ProductCategoryController@indexOnlyTrashed');
            Route::post('/product_category/restore/{product_category}', 'ProductCategoryController@restore');
            Route::delete('/product_category/forceDelete/{product_category}', 'ProductCategoryController@forceDestroy');

            Route::apiResource('/product', 'ProductController');
            Route::get('/product/index/only_trashed', 'ProductController@indexOnlyTrashed');
            Route::post('/product/restore/{product}', 'ProductController@restore');
            Route::delete('/product/forceDelete/{product}', 'ProductController@forceDestroy');

            Route::apiResource('/product_option', 'ProductOptionController');
            Route::get('/product_option/index/only_trashed', 'ProductOptionController@indexOnlyTrashed');
            Route::post('/product_option/restore/{product_option}', 'ProductOptionController@restore');
            Route::delete('/product_option/forceDelete/{product_option}', 'ProductOptionController@forceDestroy');

            Route::group(["namespace" => "UserExperience\\"], function () {
                Route::apiResource('/product_rated', 'ProductRatedController');
                Route::get('/product_rated/index/only_trashed', 'ProductRatedController@indexOnlyTrashed');
                Route::post('/product_rated/restore/{product_rated}', 'ProductRatedController@restore');
                Route::delete('/product_rated/forceDelete/{product_rated}', 'ProductRatedController@forceDestroy');

                Route::apiResource('/product_feedback', 'ProductFeedbackController', ["except" => ["update"]]);
                Route::get('/product_feedback/index/only_trashed', 'ProductFeedbackController@indexOnlyTrashed');
                Route::post('/product_feedback/restore/{product_feedback}', 'ProductFeedbackController@restore');
                Route::delete('/product_feedback/forceDelete/{product_feedback}', 'ProductFeedbackController@forceDestroy');

                Route::apiResource('/user_cart', 'UserCartController');
                Route::get('/user_cart/index/only_trashed', 'UserCartController@indexOnlyTrashed');
                Route::post('/user_cart/restore/{user_cart}', 'UserCartController@restore');
                Route::delete('/user_cart/forceDelete/{user_cart}', 'UserCartController@forceDestroy');
            });
        });
    });
    // });
});
