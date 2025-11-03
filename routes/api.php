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

Route::middleware(['auth:sanctum', 'role:Admin'])->group(function () {

 //   Route::apiResource('brands', \App\Http\Controllers\BrandController::class);
   // Route::apiResource('categories', \App\Http\Controllers\CategoryController::class);
    Route::apiResource('families', \App\Http\Controllers\FamilyController::class);
    Route::apiResource('products', \App\Http\Controllers\ProductController::class);
    Route::apiResource('subcategories', \App\Http\Controllers\SubcategoryController::class);
    Route::apiResource('subfamilies', \App\Http\Controllers\SubfamilyController::class);
    Route::apiResource('users', \App\Http\Controllers\UserController::class);
    Route::apiResource('roles', \App\Http\Controllers\RoleController::class);
});

//Route Employee Access Example

Route::middleware(['auth:sanctum', 'role:Employee'])->group(function () {
    // Define routes accessible to Employees here
    Route::apiResource('products', \App\Http\Controllers\ProductController::class)->only(['index', 'show' ,'store']);
 //   Route::apiResource('categories', \App\Http\Controllers\CategoryController::class)->only(['index', 'show', 'store']);
    Route::apiResource('subcategories', \App\Http\Controllers\SubcategoryController::class)->only(['index', 'show' ,'store']);
    Route::apiResource('families', \App\Http\Controllers\FamilyController::class)->only(['index', 'show' ,'store']);
    Route::apiResource('subfamilies', \App\Http\Controllers\SubfamilyController::class)->only(['index', 'show' ,'store']);
});

//All non protected routes can be defined here
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('products', \App\Http\Controllers\ProductController::class)->only(['index', 'show']);
  //  Route::apiResource('categories', \App\Http\Controllers\CategoryController::class)->only(['index', 'show']);
    Route::apiResource('subcategories', \App\Http\Controllers\SubcategoryController::class)->only(['index', 'show']);
 //   Route::apiResource('brands', \App\Http\Controllers\BrandController::class)->only(['index', 'show']);
    Route::apiResource('families', \App\Http\Controllers\FamilyController::class)->only(['index', 'show']);
    Route::apiResource('subfamilies', \App\Http\Controllers\SubfamilyController::class)->only(['index', 'show']);
});


    Route::apiResource('brands', \App\Http\Controllers\BrandController::class);
    Route::apiResource('categories', \App\Http\Controllers\CategoryController::class);
