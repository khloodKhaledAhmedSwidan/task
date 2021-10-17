<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array(
        'user_id',
        'cart_id',
        'address',
        'status',
        'total'
  
    );

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function cart(){
        return $this->belongsTo('App\Models\Cart','cart_id');
    }
}
