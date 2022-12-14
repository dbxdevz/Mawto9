<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CallController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CountryCitiesController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CustomerDetailController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DeliveryManController;
use App\Http\Controllers\Api\DeliveryServiceController;
use App\Http\Controllers\Api\GoogleSheetController;
use App\Http\Controllers\Api\HistoryController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\MessageTemplateController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderPriorityController;
use App\Http\Controllers\Api\OrderStatusController;
use App\Http\Controllers\Api\OwnTransactionController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\RoleStatisticController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\StatisticsController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\TransactionPayController;
use App\Http\Controllers\Api\UserController;
use App\Models\City;
use App\Models\Country;
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


Route::middleware('auth:sanctum')
     ->get('/user', function (Request $request) {
         return $request->user();
     })
;

Route::get('city', function () {
    $cities = \Illuminate\Support\Facades\Http::get('https://countriesnow.space/api/v0.1/countries')
                                              ->body()
    ;

    $countries = ["Algeria", "Saudi Arabia", "United Arab Emirates", "Qatar", "Oman", "Bahrain", "Iraq", "lebanon", "Kuwait", "Egypt"];

    $cities = json_decode($cities, true);
    foreach ($countries as $country) {
        foreach ($cities['data'] as $city) {
            if (in_array($city['country'], $countries)) {
                $countr = Country::updateOrCreate(['name' => $country], [
                    'name' => $country,
                ]);
                foreach ($city['cities'] as $cit) {
                    if ($country === $city['country']) {
                        City::create([
                                         'name'       => $cit,
                                         'country_id' => $countr->id,
                                     ]);
                    }
                }
            }
            unset($countries[$country]);
        }
    }
});

Route::post('call', [CallController::class, 'call']);

Route::post('login', [AuthController::class, 'login']);

Route::post('check-auth', [AuthController::class, 'chechAuth']);

Route::middleware(['auth:sanctum'])
     ->group(function () {
         Route::get('histories', [HistoryController::class, 'index']);

         //Profile
         Route::get('profile', [AuthController::class, 'profile']);
         Route::put('profile/update', [AuthController::class, 'update'])
              ->middleware('checkPassword')
         ;
         Route::put('password/update', [AuthController::class, 'updatePassword'])
              ->middleware('checkPassword')
         ;
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
         Route::apiResource('orders', OrderController::class)
              ->except(['destroy'])
         ;

         //Order status
         Route::apiResource('order-status', OrderStatusController::class);

         Route::get('customers-search', [SearchController::class, 'customer']);
         Route::get('order/products-search', [SearchController::class, 'products']);
         Route::get('order/customer-search', [SearchController::class, 'orderCustomer']);
         Route::get('users-search', [SearchController::class, 'users']);
         Route::get('messages-search', [SearchController::class, 'messages']);

         Route::get('country', [CountryCitiesController::class, 'country']);

         // Route::post('messages',                    [MessageController::class, 'create'])->name('messages.create');
         // Route::post('messages/{message}/send-sms', [MessageController::class, 'sendSms'])->name('messages.sendSms');

         // Delivery Services
         Route::get('delivery-services', [DeliveryServiceController::class, 'index'])
              ->name('delivery-services.index')
         ;
         Route::get('delivery-services/{deliveryService}', [DeliveryServiceController::class, 'show'])
              ->name('delivery-services.show')
         ;
         Route::put('delivery-services/{deliveryService}', [DeliveryServiceController::class, 'update'])
              ->name('delivery-services.update')
         ;
         Route::delete('delivery-services/{deliveryService}', [DeliveryServiceController::class, 'destroy'])
              ->name('delivery-services.destroy')
         ;

         // Message Template
         Route::get('message-templates', [MessageTemplateController::class, 'index'])
              ->name('message-templates.index')
         ;
         Route::post('message-templates', [MessageTemplateController::class, 'store'])
              ->name('message-templates.store')
         ;
         Route::put('message-templates/{messageTemplate}', [MessageTemplateController::class, 'update'])
              ->name('message-templates.update')
         ;
         Route::delete('message-templates/{messageTemplate}', [MessageTemplateController::class, 'destroy'])
              ->name('message-templates.destroy')
         ;

         // Messages
         Route::get('messages/{order}', [MessageController::class, 'index'])
              ->name('messages.index')
         ;
         Route::post('messages/send', [MessageController::class, 'send'])
              ->name('messages.send')
         ;

         // Delivery Man
         Route::get('delivery-men', [DeliveryManController::class, 'index'])
              ->name('delivery-men.index')
         ;
         Route::post('delivery-men', [DeliveryManController::class, 'store'])
              ->name('delivery-men.store')
         ;
         Route::get('delivery-men/{deliveryMan}', [DeliveryManController::class, 'show'])
              ->name('delivery-men.show')
         ;
         Route::put('delivery-men/{deliveryMan}', [DeliveryManController::class, 'update'])
              ->name('delivery-men.update')
         ;
         Route::put('delivery-men/{id}/toggleDefault', [DeliveryManController::class, 'toggleDefault'])
              ->name('delivery-men.toggleDefault')
         ;

         // Transactions from provider
         Route::apiResource('own-transactions', OwnTransactionController::class)
              ->except(['destroy'])
         ;
         Route::post('own-transactions/pay/{transactionId}', [TransactionPayController::class, 'store']);
         Route::delete('own-transactions/pay/{TransactionPaymentId}', [TransactionPayController::class, 'destroy']);
         Route::get('own-transactions/pay/index', [TransactionPayController::class, 'index']);

         // Transactions from order
         Route::apiResource('transactions', TransactionController::class)
              ->except(['destroy'])
         ;
         Route::post('transactions/pay/{transactionId}', [TransactionPayController::class, 'storeT']);
         Route::delete('transactions/pay/{TransactionPaymentId}', [TransactionPayController::class, 'destroyT']);
         Route::get('transactions/pay/index', [TransactionPayController::class, 'index']);

         //Store and Update Customer
         Route::post('customer/detail', [CustomerDetailController::class, 'crud']);

         //Categories
         Route::get('categories', [CategoryController::class, 'index']);
         Route::post('categories', [CategoryController::class, 'store']);


         //Role statistics
         Route::get('role/statistics', [RoleStatisticController::class, 'statistic']);

         Route::post('excel', [GoogleSheetController::class, 'store']);

         Route::get('statistics', [StatisticsController::class, 'index']);

         Route::get('dashboard', [DashboardController::class, 'index']);

         Route::get('permissions', [PermissionController::class, 'index']);

         Route::post('logout', [AuthController::class, 'logout']);

         Route::post('auth-permissions', [AuthController::class, 'authPermissions']);
     })
;
