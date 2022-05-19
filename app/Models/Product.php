<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'label',
        'code',
        'cost_price',
        'selling_price',
        'color',
        'description',
        'category_id',
        'deleted',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
