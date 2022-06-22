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

    public function orderPackage()
    {
        return $this->belongsTo(PackageStatus::class, 'package_status_id');
    }

    public function deliverySerice()
    {
        return $this->belongsTo(DeliveryService::class, 'delivery_service_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->hasMany(OrderDetail::class, 'order_id')->with('product:id,name');
    }
}
