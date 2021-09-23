<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

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
}
