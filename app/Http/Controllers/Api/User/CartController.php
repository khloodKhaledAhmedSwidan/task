<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\{DeleteItemRequest, CartRequest, OrderRequest};
use App\Http\Resources\{OrderResource, CartResource};
use App\Models\{Cart, Order, Product};
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function __construct()
    {

       if(auth('api')->check() == false){
        return response()->json(['status' => 'success', 'data' => null, 'message' => "token is required"], 401);

       } 
    }

    public function addToCart(CartRequest $request)
    {
        try {
            $product = Product::where('id', $request->product_id)->where('quantity', '>', $request->quantity)->first();
            $user = auth('api')->user();
            // check product in cart ot not

            $inCart = checkproductInCart($user->id, $product->id);
            // not cart inisialization
            if ($inCart == 3) {

                $iniCart = Cart::create([
                    'user_id'  => $user->id,
                    'is_send' => '0',


                ]);
                $cartProduct = $iniCart->cartProducts()->create([
                    'quantity' => $request->quantity,
                    'product_id' => $request->product_id,
                ]);

                $data = new CartResource($iniCart);
                return response()->json(['status' => 'success', 'data' => $data, 'message' => "تم الاضافه بنجاح"], 200);
            } elseif ($inCart == 1) {
                //update product in cart but cart is existed 
                $cart = Cart::where('user_id', $user->id)->where('is_send', '0')->first();
                $cartProduct = $cart->cartProducts()->where('product_id', $request->product_id)->first();
                $cartProduct->quantity = $request->quantity;
                $cartProduct->save();

                $data = new CartResource($cart);
                return response()->json(['status' => 'success', 'data' => $data, 'message' => "تم التعديل بنجاح"], 200);
            } elseif ($inCart == 0) {
                //add new  product in cart  
                $cart = Cart::where('user_id', $user->id)->where('is_send', '0')->latest()->first();
                $cartProduct =   $cart->cartProducts()->create([
                    'quantity' => $request->quantity,
                    'product_id' => $request->product_id,
                ]);


                $data = new CartResource($cart);
                return response()->json(['status' => 'success', 'data' => $data, 'message' => "تم الاضافه بنجاح"], 200);
            } else {
                return response()->json(['status' => 'failed', 'data' => null, 'message' => "حدث خطأ"], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "الكمية لا تكفي "], 400);
        }
    }


    // ====================== delete All Item In Cart ================================
    public function deleteAllItemInCart(Request $request)
    {
        $user = auth('api')->user();
        $cart = Cart::where('user_id', $user->id)->where('is_send', '0')->latest()->first();
        if (!$cart) {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "السلة فارغة"], 400);
        }
        $cart->delete();
        return response()->json(['status' => 'success', 'data' => null, 'message' => "تم الحذف بنجاح"], 200);
    }

    //================================ delete one item from cart ========================
    public function deleteItemFromCart(DeleteItemRequest $request)
    {
        $user = auth('api')->user();
        $cart = $user->carts()->where('id', $request->cart_id)->where('is_send', '0')->latest()->first();
        $product = $cart->cartProducts()->where('product_id', $request->product_id)->first();
        if (!$product) {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "هذا المنتج غير موجود بالسلة "], 400);
        }
        $product->delete();
        return response()->json(['status' => 'success', 'data' => null, 'message' => "تم حذف المنتج  بنجاح"], 200);
    }

    //============================= show cart ======================================
    public function showCart(Request $request)
    {
        $user = auth('api')->user();
        $cart = $user->carts()->where('is_send', '0')->latest()->first();
        if (!$cart) {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "السلة فارغة"], 400);
        }
        return response()->json(['status' => 'success', 'data' => new CartResource($cart), 'message' => ""], 200);
    }

    //============================= send order =====================================
    public function sendOrder(OrderRequest $request)
    {
        $user = auth('api')->user();
        $cart = Cart::where('id', $request->cart_id)->where('is_send', '0')->first();
        if (!$cart) {
            return response()->json(['status' => 'faild', 'data' => null, 'message' => "تم ارسال هذا الاوردر من قبل"], 200);
        }
        $totalPrice  =  total($cart->id);
        $order = Order::create([
            'user_id' => $user->id,
            'cart_id'  => $request->cart_id,
            'address' => $request->address,
            'status' => 'pending',
            'total'  => $totalPrice,

        ]);
        $cart->is_send = '1';
        $cart->save();
        return response()->json(['status' => 'success', 'data' => new OrderResource($order), 'message' => ""], 200);
    }
}
