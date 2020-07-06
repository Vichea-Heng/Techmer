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

if (!function_exists("apiSoftDelete")) {
    function apiSoftDelete($path, $controller)
    {
        Route::get("/$path/indexOnlyTrashed", "$controller@indexOnlyTrashed");
        Route::post("/$path/restore/{" . str_replace("-", "_", $path) . "}", "$controller@restore");
        Route::delete("/$path/forceDelete/{" . str_replace("-", "_", $path) . "}", "$controller@forceDestroy");
    }
}

if (!function_exists("eachUser")) {
    function eachUser($path, $controller)
    {
        Route::get("/$path/eachUser/{id}", "$controller@eachUser");
    }
}

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["prefix" => "/v1"], function () {
    Route::group(["namespace" => "Api\\v1\\Users\\"], function () {
        Route::post("/login", "UserController@login");
        Route::post("/register", "UserController@register");
        Route::post("/logout/{user}", "UserController@logout");
        Route::post("/send-reset-email", "UserController@sendResetEmail");
        Route::post("/reset-password", "UserController@resetPassword");
    });

    Route::group(["middleware" => "auth:api"], function () {
        Route::group(["namespace" => "Api\\v1\\"], function () {
            Route::group(["namespace" => "Users\\"], function () {
                Route::post("/addIdentity", "UserController@addIdentity");
                Route::post("/block-user/{id}", "UserController@addIdentity");

                // Route::group(["middleware" => CheckSuperAdmin::class], function () {
                // apiSoftDelete("role", "RoleController");
                // });
                Route::apiResource('/role', 'RoleController');

                // Route::group(["middleware" => CheckSuperAdmin::class], function () {
                // apiSoftDelete("permission", "PermissionController");
                // });
                Route::apiResource('/permission', 'PermissionController');

                // Route::group(["middleware" => CheckSuperAdmin::class], function () {
                // apiSoftDelete("permission-group", "PermissionGroupController");
                // });
                Route::apiResource('/permission-group', 'PermissionGroupController');
            });

            Route::group(["namespace" => "Products\\"], function () {
                // Route::group(["middleware" => CheckSuperAdmin::class], function () {
                apiSoftDelete("product-brand", "ProductBrandController");
                // });
                Route::apiResource('/product-brand', 'ProductBrandController');

                // Route::group(["middleware" => CheckSuperAdmin::class], function () {
                apiSoftDelete("product-category", "ProductCategoryController");
                // });
                Route::apiResource('/product-category', 'ProductCategoryController', ["except", "index"]);

                Route::delete('/product/{product}/deleteFile', 'ProductController@deleteFile');
                Route::post('/product/{product}/addFile', 'ProductController@addFile');
                // Route::get('/product/gallery/{product}', 'ProductController@getGallery');
                Route::post('/product/publish/{product}', 'ProductController@publishProduct');
                // Route::group(["middleware" => CheckSuperAdmin::class], function () {
                apiSoftDelete("product", "ProductController");
                // });
                Route::apiResource('/product', 'ProductController', ["except", ["index", "show"]]);

                Route::get("/product-option/file/{product-option}", 'ProductOptionController@getFile');
                // Route::group(["middleware" => CheckSuperAdmin::class], function () {
                apiSoftDelete("product-option", "ProductOptionController");
                // });
                Route::apiResource('/product-option', 'ProductOptionController');

                // Route::group(["middleware" => CheckSuperAdmin::class], function () {
                // apiSoftDelete("product-rated", "ProductRatedController");
                // });
                // Route::apiResource('/product-rated', 'ProductRatedController');

                // Route::group(["middleware" => CheckSuperAdmin::class], function () {
                // apiSoftDelete("product-feedback", "ProductFeedbackController");
                // });
                Route::apiResource('/product-feedback', 'ProductFeedbackController');

                // Route::group(["middleware" => CheckSuperAdmin::class], function () {
                // apiSoftDelete("favorite-product", "FavoriteProductController");
                // });
                Route::apiResource('/favorite-product', 'FavoriteProductController', ["except" => ["update"]]);
            });

            Route::group(["namespace" => "Payments\\"], function () {
                // Route::group(["middleware" => CheckSuperAdmin::class], function () {
                // apiSoftDelete("user-cart", "UserCartController");
                // });
                eachUser("/user-cart", "UserCartController");
                Route::apiResource('/user-cart', 'UserCartController');

                // Route::group(["middleware" => CheckSuperAdmin::class], function () {
                apiSoftDelete("coupon", "CouponController");
                // });
                Route::apiResource('/coupon', 'CouponController');

                // Route::group(["middleware" => CheckSuperAdmin::class], function () {
                // apiSoftDelete("transaction", "TransactionController");
                // });
                Route::apiResource('/transaction', 'TransactionController', ["except" => ["update"]]);

                // Route::group(["middleware" => CheckSuperAdmin::class], function () {
                // apiSoftDelete("shipping-address", "ShippingAddressController");
                // });
                Route::apiResource('/shipping-address', 'ShippingAddressController');
            });

            // Route::group(["namespace" => "Addresses\\"], function () {
            //     // Route::group(["middleware" => CheckSuperAdmin::class], function () {
            //     // apiSoftDelete("user-cart", "UserCartController");
            //     // });
            //     Route::apiResource('/country', 'CountryController', ["only" => ["index"]]);
            // });
        });
    });
    Route::apiResource('/product-category', 'Api\\v1\\Products\\ProductCategoryController', ["only", "index"]);
    Route::group(["namespace" => "Api\\v1\\Products"], function () {
        Route::apiResource('/product', 'ProductController', ["only", ["show"]]);
        Route::get('/product/byCategory/{id}', 'ProductController@productByCategory');
        Route::get("/product/page/{page}", 'ProductController@index');
        Route::get('/product/byBrand/{id}', 'ProductController@productByBrand');
        Route::post('/product/search', 'ProductController@searchProduct');

        Route::get('/home-page-product/productHotDeal', 'HomePageProductController@productHotDeal');
        Route::get('/home-page-product/productPopular', 'HomePageProductController@productPopular');
        Route::get('/home-page-product/productBestRating', 'HomePageProductController@productBestRating');
    });


    Route::group(["namespace" => "Api\\v1\\Addresses\\"], function () {
        // Route::group(["middleware" => CheckSuperAdmin::class], function () {
        // apiSoftDelete("user-cart", "UserCartController");
        // });
        Route::apiResource('/country', 'CountryController', ["only" => ["index"]]);
    });
    Route::get('/product/{product}/{file_name}', 'Api\\v1\\Products\\ProductController@getFile');
});
