<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->firstDate . " 00:00:00";
        $end   = $request->secondDate . " 23:59:59";

        $topProducts = Product::withCount('order_product')
                              ->whereHas('order_product', function ($query) use ($start, $end) {
                                  return $query->whereBetween('order_product.created_at', [$start, $end]);
                              })
                              ->orderBy('order_product_count', 'desc')
                              ->take(10)
                              ->get()
        ;

        $bestOperators  = User::where('role_id', 3)
                              ->orderBy('call_order_count', 'desc')
                              ->withCount('call_order')
                              ->whereHas('call_order', function ($query) use ($start, $end) {
                                  return $query->whereBetween('call_order.created_at', [$start, $end]);
                              })
                              ->take(10)
                              ->get()
        ;
        $bestDeliveries = DeliveryMan::withCount('orders')
                                     ->whereHas('orders', function ($query) use ($start, $end) {
                                         return $query->whereBetween('orders.created_at', [$start, $end]);
                                     })
                                     ->orderBy('orders_count', 'desc')
                                     ->with('user')
                                     ->take(10)
                                     ->get()
        ;

        return response(
            [
                'top_products'    => $topProducts,
                'best_operators'  => $bestOperators,
                'best_deliveries' => $bestDeliveries,
            ]
        );
    }
}