<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'phone',
        'email',
        'city_id',
        'country_id',
        'whatsapp'
    ];

    public function Country()
    {
        return $this->belongsTo(Country::class);
    }

    public function City()
    {
        return $this->belongsTo(City::class);
    }
}
