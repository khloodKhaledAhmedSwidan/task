<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    //
    protected $table = 'cart_products';
    public $timestamps = true;
    protected $fillable = array(
        'cart_id',
        'product_id',
        'quantity',
  
    );

    public function cart(){
        return $this->belongsTo('App\Models\Cart','cart_id');
    }
    public function product(){
        return $this->belongsTo('App\Models\Product','product_id');
    }
   
}
