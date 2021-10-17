<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\ProductRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    //
    //============================== show all category ===============================
    public function categories(Request $request)
    {
        
        try {
            $categories = Category::orderBy('id', 'desc')->paginate(5);
            $data =  CategoryResource::collection($categories);
            return response()->json(['status' => 'success', 'data' => $data->response()->getData(), 'message' => ""], 200);
        } catch (\Exception $e) {

            return response()->json(['status' => 'failed', 'data' => null, 'message' => "لا يوجد اقسام "], 400);
        }
    }

    //=============================== products ======================================
    public function products(ProductRequest $request)
    {
     
        try {
            $products = Product::where('category_id', $request->category_id)->orderBy('id', 'desc')->paginate(10);
            $data =  ProductResource::collection($products);
            return response()->json(['status' => 'success', 'data' => $data->response()->getData(), 'message' => ""], 200);
        } catch (\Exception $e) {

            return response()->json(['status' => 'failed', 'data' => null, 'message' => "لا يوجد منتجات بهذا القسم  "], 400);
        }
    }
}
