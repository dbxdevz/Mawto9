<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DeliveryMan;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionProducts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpseclib3\Math\PrimeField\Integer;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->firstDate;
        $end = $request->secondDate;

        $totalOrdersCount = $this->getCount(Order::class, $start, $end, null, null);
        $totalOrders = $this->getSum(Order::class, $start, $end, null, null, 'total');
        $status = OrderStatus::where('status', 'Confirmed')->first();
        $confirmedOrders = $this->getSum(Order::class, $start, $end, 'order_status_id', $status->id, 'total');
        $confirmedOrdersCount = $this->getCount(Order::class, $start, $end, 'order_status_id' ,$status->id);

        $TranPaidsCount = $this->getCount(TransactionProducts::class, $start, $end, null, null);
        $TranPaids = $this->getSum(TransactionProducts::class, $start, $end, null, null, 'subtotal');

        $topProduct = Product::find($this->getTopId(Product::class, $start, $end, 'order_product'));
        $totalProductsPrice = 0;
        $totalProductsCount = 0;

        if($topProduct){
            $OrderProductId = OrderDetail::where('product_id', $topProduct->id)->first();
            $totalProductsPrice = $this->getSum(Order::class, $start, $end, $OrderProductId->order_id, 'id', 'total');
            $totalProductsCount = $this->getCount(OrderDetail::class, $start, $end, $topProduct->id, 'product_id');
        }

        $topCustomer = Customer::find($this->getTopId(Customer::class, $start, $end, 'orders'));
        $CustomerOrderCount = 0;

        if($topProduct){
            $CustomerOrderCount = $this->getCount(Order::class, $start, $end, 'customer_id' ,$topCustomer->id);
        }

        $topDelivery = DeliveryMan::find($this->getTopId(DeliveryMan::class, $start, $end, 'orders'))->load('user');
        $deliveryOrderCount = 0;

        if($topDelivery){
            $deliveryOrderCount = $this->getCount(Order::class, $start, $end, 'delivery_id' ,$topDelivery->user->id);
        }

        return response([
            'total_orders_count' => $totalOrdersCount,
            'confirmed_orders_count' => $confirmedOrdersCount,
            'total_orders_price' => $totalOrders,
            'confirmed_orders_price' => $confirmedOrders,
            'paid_transactions_price' => $TranPaids,
            'paid_transactions_count' => $TranPaidsCount,
            'top_product' => $topProduct,
            'total_products_count' => $totalProductsCount,
            'total_products_price' => $totalProductsPrice,
            'top_customer' => $topCustomer,
            'customer_orders_count' => $CustomerOrderCount,
            'top_delivery' => $topDelivery,
            'delivery_orders_count' => $deliveryOrderCount,
        ], 200);
    }

    private function getTopId($modal, $start, $end, $relation)
    {
        $topModals = $modal::withCount($relation)->whereHas($relation, function ($query) use ($start, $end, $relation) {
            return $query->whereBetween($relation . '.created_at', [$start . " 00:00:00", $end . " 23:59:59"]);
        })->get();

        $topModalId = 0;
        $topModalCount = 0;

        foreach ($topModals as $topModal){
            if($topModalCount < $topModal->$relation . '_count'){
                $topModalCount = $topModal->$relation . '_count';
                $topModalId = $topModal->id;
            }
        }

        return $topModalId;
    }

    private function getCount($modal, $start, $end, $modal_id, $modal_name){
        $count = 0;
        $modal_id == null and $modal_name == null
            ?
                $count = $modal::whereBetween('created_at', [$start . " 00:00:00", $end . " 23:59:59"])->count()
            :
                $count = $modal::where($modal_name, $modal_id)
                      ->whereBetween('created_at', [$start . " 00:00:00", $end . " 23:59:59"])
                      ->count();
        return $count;
    }

    private function getSum($modal, $start, $end, $modal_id, $modal_name, $total = '')
    {
        $sum = 0;
        $modal_id == null and $modal_name == null
            ?
                $sum = $modal::whereBetween('created_at', [$start . " 00:00:00", $end . " 23:59:59"])
                        ->get()
                        ->sum($total)
            :
                $sum = $modal::where($modal_name, $modal_id)
                    ->whereBetween('created_at', [$start . " 00:00:00", $end . " 23:59:59"])
                    ->get()
                    ->sum($total);
        return $sum;
    }
}
