<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'message',
    ];

    protected $with = [
        'orderStatuses',
        'deliveryServices',
    ];

    public function orderStatuses()
    {
        return $this->belongsToMany(OrderStatus::class);
    }

    public function deliveryServices()
    {
        return $this->belongsToMany(DeliveryService::class);
    }
}
