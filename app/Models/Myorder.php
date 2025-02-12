<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Myorder extends Model
{
    //
    protected $fillable=['finalprice', 'mrp','price','discount', 'madewith', 'weight_type', 'weight', 'qty', 'flavour', 'product_name', 'address', 'mobile', 'name', 'user_id', 'product_id','billno_id'];
    public function product()
    {
        return  $this->belongsTo(Product::class);
    }
}
