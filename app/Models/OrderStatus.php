<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'order_priority_id', 'active', 'sms'];

    public function orderPriority()
    {
        return $this->belongsTo(OrderPriority::class);
    }
}
