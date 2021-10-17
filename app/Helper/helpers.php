<?php

function checkproductInCart($user_id, $product_id){
$checkValue = 3;
$user = App\Models\User::where('id',$user_id)->first();
$cart =App\Models\Cart::where('user_id',$user_id)->where('is_send','0')->latest()->first();
if(!$cart){
return 3; // no cart
}
$checkProduct = $cart->cartProducts()->where('product_id',$product_id)->first();
if($checkProduct != null){
return 1;
}else{
return 0;
}
}


function total($cart_id){
$cart =App\Models\Cart::where('id',$cart_id)->first();
$cartProducts = $cart->cartProducts()->get();
$total = 0;
foreach($cartProducts as $item){
$product = App\Models\Product::where('id',$item->product_id)->first();
$total = ($product->price * $item->quantity);

$product->quantity =  $product->quantity - $item->quantity;
$product->save();
}
return $total;
}
