<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Image;
use DB;
class ProductController extends Controller
{
   
    protected $model ; 
    public function __construct(Product $model)
    {
      $this->model = $model;
    }
    public function index()
    {
        //
        $products = DB::table('products as pro')
                     ->join('categories as cat','pro.category_id','cat.id')
                     ->join('suppliers as sup','pro.supplier_id','sup.id')
                     ->select('pro.*','cat.category_name','sup.name as supplier_name')
                     ->orderBy('id','DESC')
                     ->get();
               
        return response()->json($products);
    }
    public function store(Request $request)
    {
        
        $validation = $request->validate([
            'product_name'=>'required',
            'product_code'=>'required|unique:products',
            'category_id'=>'required',
            'selling_price'=>'required',
            'qty'=>'required',
         ]);
         if($request->image)
         {
            $position = strpos($request->image,';');
         
            $sub = substr($request->image,0,$position);
            $ext = explode('/',$sub)[1];
            $name = time().'.'.$ext;
            $img = Image::make($request->image)->resize(200,240);
            $path = 'uploads/product_images/';
            $image_url = $path.$name;
            $img->save($image_url);
            $request['image'] = $image_url;
         }
        
         if($this->model->insert($request->all()))
       {
           $data['status'] = 200;
           $data['message'] = 'Successfully Saved';
       }
       else
       {
        $data['status'] = 401;
        $data['message'] = 'Something Went to Wrong';
       }
       return response()->json($data);
      
    }

    public function show($id)
    {
        $data = $this->model->where('id',$id)->get()[0];
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        extract($request->all());
      $old_image = $this->model->where('id',$id)->get(['image'])[0];
      
        $id = $request['id'];
        unset($request['id']);
     
        $flag=false;
        if($request->newimage)
       {
         $position = strpos($request->newimage,';');
         
         $sub = substr($request->newimage,0,$position);
         $ext = explode('/',$sub)[1];
         $name = time().'.'.$ext;
         $img = Image::make($request->newimage)->resize(200,240);
         $path = 'uploads/employee_images/';
         $image_url = $path.$name;
         $img->save($image_url);
         $request['image'] = $image_url;
         $flag=true;
         unset($request['newimage']);
        }
        else
        {
          unset($request['newimage']);
        }
       
        ///unset($request['photo']);
        if($this->model->where('id',$id)->update($request->all()))
        {
          if($old_image->photo && $flag==true )
         {
          unlink($old_image->photo);
         }
          
         $data['status'] =  200;
         $data['message'] = 'successfully update';
        }
        else
        {
            $data['status'] =  401;
            $data['message'] = 'Error in updation';
        }
        return response()->json($data);

    }

    public function destroy($id)
    {
        $product=$this->model->find($id);
     
        if($product->delete())
        {
          unlink($product->image);
          $data['status'] = 200;
          $data['message'] = 'successfully Delete';
        }
        else
        {
          $data['status'] = 401;
          $data['message'] = 'Error in Deletion';
        }
        return response()->json($data);
    }
    function stockupdate(Request $request, $id)
    {
      $validation = $request->validate([
        'qty'=>'required',
     ]);
  
    
     if($this->model->where('id',$id)->update($request->all()))
   {
       $data['status'] = 200;
       $data['message'] = 'Successfully Saved';
   }
   else
   {
    $data['status'] = 401;
    $data['message'] = 'Something Went to Wrong';
   }
   return response()->json($data);
    }
}
