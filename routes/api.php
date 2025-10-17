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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('brands', \App\Http\Controllers\BrandController::class);
Route::apiResource('categories', \App\Http\Controllers\CategoryController::class);
Route::apiResource('families', \App\Http\Controllers\FamilyController::class);
Route::apiResource('products', \App\Http\Controllers\ProductController::class);
Route::apiResource('roles', \App\Http\Controllers\RoleController::class);
Route::apiResource('subcategories', \App\Http\Controllers\SubcategoryController::class);
Route::apiResource('subfamilies', \App\Http\Controllers\SubfamilyController::class);
