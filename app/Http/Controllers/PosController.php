<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Cart;
use App\Models\Product;
class PosController extends Controller
{
    //
    function index($id)
    {
        if($id==0)
        {
            $products = DB::table('products as pro')
            ->join('categories as cat','pro.category_id','cat.id')
            ->join('suppliers as sup','pro.supplier_id','sup.id')
            ->select('pro.*','cat.category_name','sup.name as supplier_name')
            ->orderBy('id','DESC')
            ->get();
        }
        else
        {
            $products = DB::table('products as pro')
        ->join('categories as cat','pro.category_id','cat.id')
        ->join('suppliers as sup','pro.supplier_id','sup.id')
        ->select('pro.*','cat.category_name','sup.name as supplier_name')
        ->where('pro.category_id',$id)
        ->orderBy('id','DESC')
        ->get();
        }
        
  
return response()->json($products);
    }

    function Addtocart($id)
    {
        $product = Product::where('id',$id)->get()->first();
        $data['product_id']=$id;
        $data['product_name']=$product->product_name;
        $data['product_qty']=1;
        $data['product_price']=$product->selling_price;
        $data['subtotal']=$product->selling_price;
        if(Cart::insert($data))
        {
            $arr['status'] = 200;
            $arr['message'] = 'Successfully Add to Cart';
        }
        else
        {
            $arr['status'] = 200;
            $arr['message'] = 'Error in Add to Cart';
        }
        return response()->json($arr);
    }
    function getcart()
    {
        $carts = Cart::all();
        return response()->json($carts);
    }
}
