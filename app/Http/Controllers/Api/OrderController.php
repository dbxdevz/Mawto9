<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreRequest;
use App\Http\Requests\Order\UpdateRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\TimeChanceCall;
use Illuminate\Support\Facades\DB;

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
        // $sort = request('sort') ? 'asc' : 'desc';

        $orders = Order::with([
                                  'products:id,order_id,product_id,unit_cost,quantity,color',
                                  'orderStatus:id,status',
                                  'orderPackage:id,status',
                                  'customer:id,first_name,last_name,phone',
                                  'deliveryService:id,name,shipping_cost',
                                  'deliveryMen:id,code,shipping_cost,user_id',
                                  'deliveryMen.user:id,name,email',
                              ])
                       ->paginate($limit)
        ;

        return response($orders, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('customer-store');

        $order = Order::create([
                                   'order_status_id'     => $request->get('order_status_id'),
                                   'package_status_id'   => $request->get('package_status_id'),
                                   'delivery_service_id' => $request->get('service') == true ? $request->get(
                                       'delivery_service_id'
                                   ) : null,
                                   'delivery_men_id'     => $request->get('service') == false ? $request->get(
                                       'delivery_men_id'
                                   ) : null,
                                   'customer_id'         => $request->get('customer_id'),
                                   'note'                => $request->get('note'),
                                   'delivery_note'       => $request->get('delivery_note'),
                                   'subtotal'            => $request->get('subtotal'),
                                   'total'               => $request->get('total'),
                               ]);

        foreach ($request->get('products') as $product) {
            $productQuantity = Product::where('id', $product['product_id'])
                                      ->first()
            ;

            $productQuantity->code = (int)$productQuantity->code - (int)$product['quantity'];
            $productQuantity->save();

            OrderDetail::create([
                                    'order_id'   => $order->id,
                                    'product_id' => $product['product_id'],
                                    'unit_cost'  => $product['unit_cost'],
                                    'quantity'   => $product['quantity'],
                                    'color'      => isset($product['color']) == true ? $product['color'] : null,
                                ]);
        }

        $timeChance = TimeChanceCall::find(1);

        DB::table('call_order')
          ->insert([
                       'order_id'   => $order->id,
                       'chance'     => $timeChance->chance,
                       'created_at' => now(),
                   ])
        ;

        return response(['message' => 'Created Successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order = Order::where('id', $order->id)
                      ->with([
                                 'products:id,order_id,product_id,unit_cost,quantity,color',
                                 'orderStatus:id,status',
                                 'orderPackage:id,status',
                                 'customer:id,first_name,last_name,phone',
                                 'deliveryService:id,name,shipping_cost',
                                 'deliveryMen:id,code,shipping_cost,user_id',
                                 'deliveryMen.user:id,name,email',
                             ])
                      ->first()
        ;

        return response($order, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order        $order
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Order $order)
    {

        $this->authorize('customer-update');

        $order->update([
                           'order_status_id'     => $request->get('order_status_id'),
                           'package_status_id'   => $request->get('package_status_id'),
                           'delivery_service_id' => $request->get('service') == true ? $request->get(
                               'delivery_service_id'
                           ) : null,
                           'delivery_men_id'     => $request->get('service') == false ? $request->get(
                               'delivery_men_id'
                           ) : null,
                           'note'                => $request->get('note'),
                           'delivery_note'       => $request->get('delivery_note'),
                       ]);

        return response(['message' => 'Order updated successfully'], 200);
    }
}
