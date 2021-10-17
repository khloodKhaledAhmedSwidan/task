<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    /*
    *is_send 0 in cart
    *is_send 1 send
    */
    protected $table = 'carts';
    public $timestamps = true;
    protected $fillable = array(
        'user_id',
        'is_send',

    );

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function cartProducts()
    {
        return $this->hasMany('App\Models\CartProduct', 'cart_id');
    }
}
