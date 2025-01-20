<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $fillable = [
        'product_id',
        'user_id',
        'price_id',
        'qty'
    ];
}
