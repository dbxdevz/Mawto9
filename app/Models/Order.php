<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function prority()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id')
                    ->with('orderPriority')
        ;
    }

    public function orderPackage()
    {
        return $this->belongsTo(PackageStatus::class, 'package_status_id');
    }

    public function deliveryService()
    {
        return $this->belongsTo(DeliveryService::class, 'delivery_service_id');
    }

    public function deliveryMen()
    {
        return $this->belongsTo(DeliveryMan::class, 'delivery_men_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->hasMany(OrderDetail::class, 'order_id')
                    ->with('product:id,name')
        ;
    }
}
