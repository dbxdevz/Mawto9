<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function index()
    {
        $orderStatus = OrderStatus::with('orderPriority')
                                  ->get()
        ;

        return response(['orderStatus' => $orderStatus], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
                               'status'            => ['required'],
                               'order_priority_id' => ['required'],
                               'color'             => ['required', 'regex:/^(#(?:[0-9a-f]{2}){2,4}|#[0-9a-f]{3}|(?:rgba?|hsla?)\((?:\d+%?(?:deg|rad|grad|turn)?(?:,|\s)+){2,3}[\s\/]*[\d\.]+%?\))$/i',],
                           ]);

        OrderStatus::create([
                                'status'            => $request->status,
                                'order_priority_id' => $request->order_priority_id,
                                'color'             => $request->color,
                            ]);

        return response(['message' => 'Order status created successfully'], 200);
    }

    public function show(OrderStatus $orderStatus)
    {
        $orderStatus = $orderStatus->with('orderPriority')
                                   ->first()
        ;

        return response(['orderStatus' => $orderStatus], 200);
    }

    public function update(Request $request, OrderStatus $orderStatus)
    {
        $request->validate([
                               'status'            => ['required'],
                               'order_priority_id' => ['required'],
                               'color'             => ['required', 'regex:/^(#(?:[0-9a-f]{2}){2,4}|#[0-9a-f]{3}|(?:rgba?|hsla?)\((?:\d+%?(?:deg|rad|grad|turn)?(?:,|\s)+){2,3}[\s\/]*[\d\.]+%?\))$/i',],
                           ]);

        $orderStatus->update($request->all());

        return response(['message' => 'Order status updated successfully']);
    }

    public function destroy(OrderStatus $orderStatus)
    {
        $orderStatus->delete();

        return response(['message' => 'Order status deleted successfully'], 200);
    }


}
