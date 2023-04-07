<?php

namespace App\Http\Controllers;

use datatables;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        return view('backend.employee.index',compact('companies'));
    }

    public function ssd(){

        $data = Employee::query();

        if(request()->name){
            $data = $data->where('fname','LIKE','%'.request()->name.'%');
         }
 
         if(request()->date){
             $date = explode("-",request()->date);
             $from = $date[0];
             $to = $date[1];
             $data = $data->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
         }

         if(request()->company){
            $value = request()->company;
            $data = $data->whereHas('company',function($query) use($value){
                $query->where('id',$value);   
            });
        }
        
        return datatables($data)
        ->editColumn('company_id',function($each){
            return $each->company ? $each->company->name : "-";
        })
        ->editColumn('created_at',function($each){
            return $each->created_at->format('Y-m-d');
        })
        ->addColumn('action',function($each){
            $edit_btn = '<button class="btn btn-warning edit px-3 mx-2 my-2" value="'.$each->id.'">Edit</button>';
            $delete_btn = '<button class="btn btn-danger delete" value="'.$each->id.'">Delete</button>';
            return $edit_btn . $delete_btn; 
        })
        ->rawColumns(['action'])
        ->toJson();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();
        return response()->json($companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employee = new Employee();
        $employee->fname = $request->fname;
        $employee->lname = $request->lname;
        $employee->company_id = $request->company;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->save();
        return response()->json('Successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $companies = Company::all();
        return response()->json([
            'employee'=>$employee,
            'companies'=>$companies
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $employee->fname = $request->fname;
        $employee->lname = $request->lname;
        $employee->company_id = $request->company;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->save();
        return response()->json('Successfully created.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json('Successfully Deleted');
    }
}
