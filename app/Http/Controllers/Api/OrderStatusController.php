<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function index()
    {
        $orderStatus = OrderStatus::all();

        return response(['orderStatus' => $orderStatus], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => ['required'],
            'order_priority_id' => ['required'],
            'sms' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
        ]);

        OrderStatus::create($request->all());

        return response(['message' => 'Order status created successfully'], 200);
    }

    public function update(Request $request, OrderStatus $orderStatus)
    {
        $request->validate([
            'status' => ['required'],
            'order_priority_id' => ['required'],
            'sms' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
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
