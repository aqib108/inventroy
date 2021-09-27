<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Cart;
use App\Models\Product;
class PosController extends Controller
{
    //
    public function dashboard()
    {
       $data['today_orders'] = DB::table('orders')->where('order_date',date('y-m-d'))->get()->count(); 
       $data['today_sales'] = DB::table('orders')->where('order_date',date('y-m-d'))->sum('pay'); 
       $data['today_dues'] = DB::table('orders')->where('order_date',date('y-m-d'))->sum('due'); 
       $data['today_products'] = DB::table('products')->get()->count(); 
       return response()->json($data);        
    }
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
    function checkinCart($id)
    {
      $count = 0;
      $count = Cart::where('product_id',$id)->get()->count();
      
      if($count>0)
      {
          return true;
      }
        return false;
    }
    function Addtocart($id)
    {
        $product = Product::where('id',$id)->get()->first();
        $data['product_id']=$id;
        $data['product_name']=$product->product_name;
        $data['product_qty']=1;
        $data['product_price']=$product->selling_price;
        $data['subtotal']=$product->selling_price;
       if($this->checkinCart($id))
       {
         $result = Cart::where('product_id',$id)->increment('product_qty');
         if($result)
         {
            $arr['status'] = 200;
            $arr['message'] = 'Successfully Add to Cart';
         }
         else
         {
            $arr['status'] = 200;
            $arr['message'] = 'Error in Add to Cart';
         }
       }
       else
       {
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
       }
        
        return response()->json($arr);
    }
    function getcart()
    {
        $carts = Cart::all();
        return response()->json($carts);
    }
    function removetocart($id)
    {
        $c = Cart::find($id);
        if($c->delete())
        {
            $arr['status'] = 200;
            $arr['message'] = 'Successfully Removed from Cart.';
        }
        else
        {
            $arr['status'] = 401;
            $arr['message'] = 'Error from Removed Cart';
        }
        return response()->json($arr);
    }
    function incrementcart($id)
    {

        if(Cart::where('id',$id)->increment('product_qty'))
        {
            $udata = array();
            $subtotal = 0;
            $cart = array();
            $cart = Cart::find($id);
            if(!empty($cart))
            {
                $subtotal = (int)$cart->product_qty*(int)$cart->product_price;
                $cart->subtotal = $subtotal;
                if($cart->save())
                {
                  $arr['message'] = 'Successfully Added Cart';
                }
                else
                {
                    $arr['message'] = 'Unable to Add in Cart';
                }

            }
            else
            {
                $arr['message'] = 'Cart Fetch issue';
            }


        }
        else
        {
            $arr['message'] = 'Cart Increment issue';
        }
        return response()->json($arr);
    }
    function decrementcart($id)
    {
        $result=0;
        if(Cart::where('id',$id)->decrement('product_qty'))
        {
            $cart = Cart::find($id);
            if(!empty($cart))
            {
              
              
                
                $subtotal = (int)$cart->product_qty*(int)$cart->product_price;
                $cart->subtotal = $subtotal;
                if($cart->save())
                {
                  $arr['message'] = 'Successfully Remove from Cart';
                }
                else
                {
                    $arr['message'] = 'Unable to Removed From Cart';
                }

            }
            else
            {
                $arr['message'] = 'Cart Fetch issue';
            }


        }
        else
        {
            $arr['message'] = 'Cart decrement issue';
        }
        return response()->json($arr);
    }
    //placeorder
    function placeorder(Request $request)
    {
        extract($request->all());
      
        $qty = Cart::get()->sum('product_qty');
        $subtotal = Cart::get()->sum('subtotal');
        $order = array(
     'customer_id'=>$customer_id,
     'qty'=>$qty,
     'subtotal'=>$subtotal,
     'tex'=>5,
     'total'=>$subtotal*(1+5/100),
     'pay'=>$pay,
     'due'=>$due,
     'pay_method'=>$pay_method,
     'order_id'=>uniqid(),
     'order_date'=>date('y-m-d'),
     'month'=>date('m'),
     'year'=>date('y')
        );
        $result=0;
        $result = DB::table('orders')->insertGetId($order);
        if($result!=0)
        {
            $cart = Cart::get();
            foreach($cart as $ct)
            {
               $order_details= array(
                   'order_id'=>$result,
                    'product_id'=>$ct->product_id,
                    'product_qty'=>$ct->product_qty,
                    'product_price'=>$ct->product_price,
                    'subtotal'=>$ct->subtotal
               );
               $ch=DB::table('orders_details')->insert($order_details);
               if($ch)
               {
                   DB::table('products')->where('id',$ct->product_id)->update(['qty'=>DB::raw('qty -'.$ct->product_qty)]);
                   
               }
              
            }
            if(Cart::truncate())
            {
                 $arr['message'] = 'Successfully Place Order';
            }
            else
            {
             $arr['message'] = 'Issue in truncart Cart Table';
            }

        }
        else
        {
            $arr['message'] = 'issue in create order';
        }
        return response()->json($arr);

    }
  function orders()
  {
     //
     $order = DB::table('orders as or')
     ->join('customers as cust','cust.id','or.customer_id')
     ->select('or.*','cust.name as customer_name')
     ->orderBy('id','DESC')
     ->get();

return response()->json($order);   
  }
 function outofstock()
 {
    $products = DB::table('products as pro')
    ->join('categories as cat','pro.category_id','cat.id')
    ->join('suppliers as sup','pro.supplier_id','sup.id')
    ->where('pro.qty','=',0)
    ->select('pro.*','cat.category_name','sup.name as supplier_name')
    ->orderBy('id','DESC')
    ->get();
    return response()->json($products); 

 }


}
