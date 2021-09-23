<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
class ExpenseController extends Controller
{
    protected $model ; 
    public function __construct(Expense $model)
    {
      $this->model = $model;
    }
    public function index()
    {
        
        $Expense = $this->model->all();
        return response()->json($Expense);
    }

    public function store(Request $request)
    {
        
        $validation = $request->validate([
            'details'=>'required',
            'amount'=>'required',
            'expense_date'=>'required',
         ]);
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
        $validation = $request->validate([
            'details'=>'required',
            'amount'=>'required',
            'expense_date'=>'required',
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

   
    public function destroy($id)
    {
        $Expense=$this->model->find($id);
     
        if($Expense->delete())
        {
          
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
