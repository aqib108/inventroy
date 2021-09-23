<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Intervention\Image\ImageManagerStatic as Image;
class EmployeeController extends Controller
{
    //
    protected $model; 
    public function __construct(Employee $model)
    {
       $this->model = $model;
    }
    public function index()
    {
        
        $data = $this->model->all();
    
        return response()->json($data);
    }
    public function create(Request $request)
    {
       //  dd($request->all());
       $validation = $request->validate([
          'name'=>'required',
          'email'=>'required|unique:employees',
          'salary'=>'required',
          'date'=>'required',
          'address'=>'required',
          'phone'=>'required',
          'nid'=>'required',
       ]);
       if($request->photo)
       {
         $position = strpos($request->photo,';');
         
         $sub = substr($request->photo,0,$position);
         $ext = explode('/',$sub)[1];
         $name = time().'.'.$ext;
         $img = Image::make($request->photo)->resize(200,240);
         $path = 'uploads/employee_images/';
         $image_url = $path.$name;
         $img->save($image_url);
         $request['photo'] = $image_url;
       }
       if($this->model->insert($request->all()))
       {
           $data['status'] = 200;
           $data['message'] = 'Employee Successfully Add';
       }
       else
       {
        $data['status'] = 401;
        $data['message'] = 'Something Went to Wrong';
       }
       return response()->json($data);
    }
    public function delete($id)
    {
      $employe=$this->model->find($id);
     
      if($employe->delete())
      {
        unlink($employe->photo);
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
    function edit($id)
    {
      $data = $this->model->where('id',$id)->get()[0];
      return response()->json($data);
    }
    function update(Request $request)
    {
      extract($request->all());
      $old_image = $this->model->where('id',$id)->get(['photo'])[0];
      
        $id = $request['id'];
        unset($request['id']);
        unset($request['created_at']);
        unset($request['updated_at']);
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
}
