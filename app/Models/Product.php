<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    //
    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = array(
        'name',
        'desc',
        'price',
        'quantity',
        'image',
        'category_id',
    );

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id');
    }
}
