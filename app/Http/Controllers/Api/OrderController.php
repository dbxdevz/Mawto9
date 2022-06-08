<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit = request('limit') ? request('limit') : 10;

        $orders = Order::with([
                            'products:id,order_id,product_id,unit_cost,quantity',
                            'orderStatus:id,status',
                            'orderPackage:id,status',
                            'customer:id,first_name,last_name,phone',
                            'deliverySerice:id,code,name,shipping_cost',
                        ])->paginate($limit);

        return response($orders, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('customer-store');

        $order = Order::create([
            'order_status_id' => $request->get('order_status_id'),
            'package_status_id' => $request->get('package_status_id'),
            'delivery_service_id' => $request->get('delivery_service_id'),
            'customer_id' => $request->get('customer_id'),
            'note' => $request->get('note'),
            'delivery_note' => $request->get('delivery_note'),
            'subtotal' => $request->get('subtotal'),
            'total' => $request->get('total'),
        ]);

        foreach($request->get('products') as $product){
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $product['product_id'],
                'unit_cost' => $product['unit_cost'],
                'quantity' => $product['quantity'],
            ]);
        }

        return response(['message' => 'Created Successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order = $order->with([
                            'products:id,order_id,product_id,unit_cost,quantity',
                            'orderStatus:id,status',
                            'orderPackage:id,status',
                            'customer:id,first_name,last_name,phone',
                            'deliverySerice:id,code,name,shipping_cost',
                        ])
                        ->paginate(10);

        return response($order, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, Order $order)
    {

        $this->authorize('customer-update');

        $order->update([
            'order_status_id' => $request->get('order_status_id'),
            'package_status_id' => $request->get('package_status_id'),
            'delivery_service_id' => $request->get('delivery_service_id'),
            'customer_id' => $request->get('customer_id'),
            'note' => $request->get('note'),
            'delivery_note' => $request->get('delivery_note'),
        ]);

        return response(['message' => 'Order updated successfully'], 200);
    }
}
