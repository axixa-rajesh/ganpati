<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable=['name','flavour','description','main_image'];
    public function price(){
        return $this->hasMany(Price::class);
    }
    public function media()
    {
       return  $this->hasMany(Media::class);
    }
}
