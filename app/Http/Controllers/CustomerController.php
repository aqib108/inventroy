<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Image;

class CustomerController extends Controller
{
    protected $model ; 
    public function __construct(Customer $model)
    {
      $this->model = $model;
    }
    
    public function index()
    {
        //
        $suppliers = $this->model->all();
        return response()->json($suppliers);
    }

   
    public function store(Request $request)
    {
      
        $validation = $request->validate([
            'name'=>'required',
            'email'=>'unique:customers',
            'address'=>'required',
            'phone'=>'required',
            
         ]);
         if($request->photo)
         {
            $position = strpos($request->photo,';');
         
            $sub = substr($request->photo,0,$position);
            $ext = explode('/',$sub)[1];
            $name = time().'.'.$ext;
            $img = Image::make($request->photo)->resize(200,240);
            $path = 'uploads/customer_images/';
            $image_url = $path.$name;
            $img->save($image_url);
            $request['photo'] = $image_url;
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
        //
    }

   
    public function show($id)
    {
        //
        $data = $this->model->where('id',$id)->get()[0];
      return response()->json($data);
    }

    
    public function update(Request $request,$id)
    {
        extract($request->all());
      $old_image = $this->model->where('id',$id)->get(['photo'])[0];
      
      
        $flag=false;
        if($request->newimage)
       {
         $position = strpos($request->newimage,';');
         
         $sub = substr($request->newimage,0,$position);
         $ext = explode('/',$sub)[1];
         $name = time().'.'.$ext;
         $img = Image::make($request->newimage)->resize(200,240);
         $path = 'uploads/customer_images/';
         $image_url = $path.$name;
         $img->save($image_url);
         $request['photo'] = $image_url;
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
        $suppliers=$this->model->find($id);
     
        if($suppliers->delete())
        {
          unlink($suppliers->photo);
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
}
