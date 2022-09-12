<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CallController extends Controller
{
    public function call()
    {
        // $this->authorize('order-index');

        $orders = DB::table('orders')
                    ->join('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id')
                    ->join('package_statuses', 'orders.package_status_id', '=', 'package_statuses.id')
                    ->join('order_priorities', function ($join) {
                        $join->on('order_priorities.id', '=', 'order_statuses.order_priority_id')
                             ->where('order_statuses.order_priority_id', '!=', 4)
                        ;
                    })
                    ->join('call_order', function ($join) {
                        $join->on('call_order.order_id', '=', 'orders.id')
                             ->where('call_order.chance', '>', 0)
                        ;
                    })
                    ->join('customers', 'orders.customer_id', '=', 'customers.id')
                    ->select(
                        'orders.id', 'orders.created_at', 'orders.subtotal',
                        'order_statuses.status',
                        'customers.phone', 'customers.first_name', 'customers.last_name',
                        'package_statuses.status as package_status',
                        'call_order.chance',
                        'order_priorities.id as priority.id'
                    )
                    ->orderBy('order_priorities.id')
                    ->orderBy('call_order.chance', 'desc')
                    ->orderBy('orders.created_at')
                    ->take(1)
                    ->get()
        ;

        return response($orders, 200);
    }

    public function endCall(Request $request)
    {
        $callOrder = DB::table('call_order')
                       ->where('order_id', $request->order_id)
                       ->first()
        ;

        $callOrder->chance  = $callOrder->chance - 1;
        $callOrder->user_id = auth('sanctum')->id();

        $callOrder->save();
    }
}
