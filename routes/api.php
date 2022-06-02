<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CustomerDetailController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function(){

    //Roles
    Route::apiResource('roles', RoleController::class);

    //Customers
    Route::apiResource('customers', CustomerController::class);

    //Users
    Route::apiResource('users', UserController::class);

    //Products
    Route::apiResource('products', ProductController::class);

    //Orders
    Route::apiResource('orders', OrderController::class);

    //Store and Update Customer
    Route::post('customer/detail', [CustomerDetailController::class, 'crud']);

    //Categories
    Route::get('categories', [CategoryController::class, 'index']);
    Route::post('categories', [CategoryController::class, 'store']);

    Route::get('permissions', [PermissionController::class, 'index']);

    Route::post('logout', [AuthController::class, 'logout']);
});
