<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tva()
    {
        return $this->belongsTo(Tva::class);
    }

    public function transactionPayment()
    {
        return $this->hasMany(TransactionPayment::class);
    }

    public function transactionProducts()
    {
        return $this->hasMany(TransactionProducts::class);
    }
}
