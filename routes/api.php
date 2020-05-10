<?php

use App\Http\Middleware\CheckSuperAdmin;
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

function apiSoftDelete($path, $controller)
{
    Route::get("/$path/indexOnlyTrashed", "$controller@indexOnlyTrashed");
    Route::post("/$path/restore/{" . $path . "}", "$controller@restore");
    Route::delete("/$path/forceDelete/{" . $path . "}", "$controller@forceDestroy");
}

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

            // Route::group(["middleware" => CheckSuperAdmin::class], function () {
            apiSoftDelete("role", "RoleController");
            // });
            Route::apiResource('/role', 'RoleController');

            // Route::group(["middleware" => CheckSuperAdmin::class], function () {
            apiSoftDelete("permission", "PermissionController");
            // });
            Route::apiResource('/permission', 'PermissionController');

            // Route::group(["middleware" => CheckSuperAdmin::class], function () {
            // apiSoftDelete("permission_group", "PermissionGroupController");
            // });
            Route::apiResource('/permission_group', 'PermissionGroupController');
        });

        Route::group(["namespace" => "Products\\"], function () {
            // Route::group(["middleware" => CheckSuperAdmin::class], function () {
            apiSoftDelete("product_brand", "ProductBrandController");
            // });
            Route::apiResource('/product_brand', 'ProductBrandController');

            // Route::group(["middleware" => CheckSuperAdmin::class], function () {
            apiSoftDelete("product_category", "ProductCategoryController");
            // });
            Route::apiResource('/product_category', 'ProductCategoryController');

            Route::get('/product/{product}/{file_name}', 'ProductController@getFile');
            Route::delete('/product/{product}/deleteFile', 'ProductController@deleteFile');
            Route::post('/product/{product}/addFile', 'ProductController@addFile');
            Route::get('/product/gallery/{product}', 'ProductController@getGallery');
            Route::post('/product/publish/{product}', 'ProductController@publishProduct');
            // Route::group(["middleware" => CheckSuperAdmin::class], function () {
            apiSoftDelete("product", "ProductController");
            // });
            Route::apiResource('/product', 'ProductController');

            Route::get("/product_option/file/{product_option}", 'ProductOptionController@getFile');
            // Route::group(["middleware" => CheckSuperAdmin::class], function () {
            apiSoftDelete("product_option", "ProductOptionController");
            // });
            Route::apiResource('/product_option', 'ProductOptionController');

            // Route::group(["middleware" => CheckSuperAdmin::class], function () {
            // apiSoftDelete("product_rated", "ProductRatedController");
            // });
            Route::apiResource('/product_rated', 'ProductRatedController');

            // Route::group(["middleware" => CheckSuperAdmin::class], function () {
            // apiSoftDelete("product_feedback", "ProductFeedbackController");
            // });
            Route::apiResource('/product_feedback', 'ProductFeedbackController');

            // Route::group(["middleware" => CheckSuperAdmin::class], function () {
            // apiSoftDelete("favorite_product", "FavoriteProductController");
            // });
            Route::apiResource('/favorite_product', 'FavoriteProductController', ["except" => ["update"]]);
        });

        Route::group(["namespace" => "Payments\\"], function () {
            // Route::group(["middleware" => CheckSuperAdmin::class], function () {
            // apiSoftDelete("user_cart", "UserCartController");
            // });
            Route::apiResource('/user_cart', 'UserCartController');

            // Route::group(["middleware" => CheckSuperAdmin::class], function () {
            apiSoftDelete("coupon", "CouponController");
            // });
            Route::apiResource('/coupon', 'CouponController');

            // Route::group(["middleware" => CheckSuperAdmin::class], function () {
            // apiSoftDelete("transaction", "TransactionController");
            // });
            Route::apiResource('/transaction', 'TransactionController', ["except" => ["update"]]);

            // Route::group(["middleware" => CheckSuperAdmin::class], function () {
            // apiSoftDelete("shipping_address", "ShippingAddressController");
            // });
            Route::apiResource('/shipping_address', 'ShippingAddressController');
        });
    });
    // });
});
