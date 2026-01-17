<?php

use App\Http\Controllers\Admin\AdminController;
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
/*

 */
/* Route::middleware(['auth:sanctum'])->group(function () {

    // Admin only API
    Route::middleware('can:access-admin')->prefix('admin')->group(function () {

        Route::delete('/users/{user}', [AdminController::class, 'destroy']);
        Route::post('/users', [AdminController::class, 'store']);
        Route::put('/users/{user}', [AdminController::class, 'update']);

    });

    // Public (but authenticated)  API
    Route::apiResource('brands', \App\Http\Controllers\BrandController::class);
    Route::apiResource('products', controller: \App\Http\Controllers\ProductController::class);
    Route::get('brand-names', [\App\Http\Controllers\BrandController::class, 'getBrandNames']);
    Route::get('countries', [\App\Http\Controllers\BrandController::class, 'getCountry']);
    Route::get('subfamily-names', [\App\Http\Controllers\SubfamilyController::class, 'getSubfamilyNames']);

}); */

Route::apiResource('brands', \App\Http\Controllers\BrandController::class);
Route::apiResource('banners', \App\Http\Controllers\BannerController::class);
Route::apiResource('categories', \App\Http\Controllers\CategoryController::class);
Route::apiResource('families', \App\Http\Controllers\FamilyController::class);
Route::apiResource('products', controller: \App\Http\Controllers\ProductController::class);
Route::apiResource('subcategories', \App\Http\Controllers\SubcategoryController::class);
Route::apiResource('subfamilies', \App\Http\Controllers\SubfamilyController::class);
Route::apiResource('users', \App\Http\Controllers\UserController::class);
Route::apiResource('roles', \App\Http\Controllers\RoleController::class);
Route::get('brand-names', [\App\Http\Controllers\BrandController::class, 'getBrandNames']);
Route::get('countries', [\App\Http\Controllers\BrandController::class, 'getCountry']);
Route::get('subfamily-names', [\App\Http\Controllers\SubfamilyController::class, 'getSubfamilyNames']);

