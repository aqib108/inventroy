<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary;
use DB;
class SalaryController extends Controller
{
    protected $model ; 
    public function __construct(Salary $model)
    {
      $this->model = $model;
    }
    public function index()
    {
        
        $Salaries = DB::table('salaries')->select('salary_month')->groupBy('salary_month')->get();
        return response()->json($Salaries);
    }

    public function store(Request $request)
    {
        
        $validation = $request->validate([
            'amount'=>'required',
            'salary_month'=>'required',
            'salary_date'=>'required',
            'employee_id'=>'required',
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
        'amount'=>'required',
        'salary_month'=>'required',
        'salary_date'=>'required',
        'employee_id'=>'required',
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
    function getsalariesbymonth($month)
    {
      $salaries = DB::table('salaries as sal')
      ->join('employees as emp','sal.employee_id','emp.id')
      ->where('sal.salary_month',$month)
      ->get(['sal.*','emp.name as employee_name','emp.email as employee_email']);
      return response()->json($salaries);
    }
    
}
