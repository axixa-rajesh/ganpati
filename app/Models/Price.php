<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    //
    protected $fillable = ['product_id', 'madewith', 'weight', 'weight_type','price','finalprice'];
}
