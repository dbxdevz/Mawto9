<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CustomerDetailController;
use App\Http\Controllers\Api\DeliveryServiceController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderPriorityController;
use App\Http\Controllers\Api\OrderStatusController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\RoleStatisticController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\OrderController as ControllersOrderController;
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

Route::post('check-auth', [AuthController::class, 'chechAuth']);

Route::middleware(['auth:sanctum'])->group(function(){
    //Profile
    Route::get('profile', [AuthController::class, 'profile']);
    Route::put('profile/update', [AuthController::class, 'update'])->middleware('checkPassword');
    Route::put('password/update', [AuthController::class, 'updatePassword'])->middleware('checkPassword');
    Route::post('password/check', [AuthController::class, 'checkPassword']);

    Route::get('order/priorities', [OrderPriorityController::class, 'index']);
    Route::get('package/priorities', [OrderPriorityController::class, 'index2']);
    //Roles
    Route::apiResource('roles', RoleController::class);

    //Customers
    Route::apiResource('customers', CustomerController::class);

    //Users
    Route::apiResource('users', UserController::class);

    //Products
    Route::apiResource('products', ProductController::class);

    //Orders
    Route::apiResource('orders', OrderController::class)->except(['destroy']);

    //Order status
    Route::apiResource('order-status', OrderStatusController::class);

    Route::get('customers-search', [SearchController::class, 'customer']);
    Route::get('order/products-search', [SearchController::class, 'products']);
    Route::get('order/customer-search', [SearchController::class, 'orderCustomer']);

    // Route::post('messages',                    [MessageController::class, 'create'])->name('messages.create');
    // Route::post('messages/{message}/send-sms', [MessageController::class, 'sendSms'])->name('messages.sendSms');

    // Delivery Services
    Route::get('delivery-services', [DeliveryServiceController::class, 'index'])->name('delivery-services.index');
    Route::get('delivery-services/{deliveryService}', [DeliveryServiceController::class, 'show'])->name('delivery-services.show');
    Route::put('delivery-services/{deliveryService}', [DeliveryServiceController::class, 'update'])->name('delivery-services.update');
    Route::delete('delivery-services/{deliveryService}', [DeliveryServiceController::class, 'destroy'])->name('delivery-services.destroy');

    //Store and Update Customer
    Route::post('customer/detail', [CustomerDetailController::class, 'crud']);

    //Categories
    Route::get('categories', [CategoryController::class, 'index']);
    Route::post('categories', [CategoryController::class, 'store']);

    //Role statistics
    Route::get('role/statistics', [RoleStatisticController::class, 'statistic']);


    Route::get('permissions', [PermissionController::class, 'index']);

    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('auth-permissions', [AuthController::class, 'authPermissions']);
});
