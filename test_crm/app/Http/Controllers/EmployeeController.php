<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Companies;
use App\Models\Employee;
use Redirect;
use Session;
use Response;
use Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Companies::all();
        $employees = Employee::paginate(10);
        return view('admin.employee', compact('companies', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'LastName' => ['required', 'string', 'max:255'],
            'FirstName' => ['required', 'string', 'max:255'],
            'Email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'Company'=>'required',

        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $emp = new Employee();
            $emp->first_name = $request->FirstName;
            $emp->last_name = $request->LastName;
            $emp->email = $request->Email;
            $emp->phone = $request->Phone;
            $emp->company_id  = $request->Company;


            $emp->save();
            return response()->json(['status' => 1, 'msg' => 'Employee Added successfully..!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::where('id', $id)->first();
        $companies = Companies::all();
        return view('admin.view_employee', compact('employee', 'companies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::where('id', $id)->first();
        return response()->json(['success' => true, 'data' => $employee]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'LastName' => ['required', 'string', 'max:255'],
            'FirstName' => ['required', 'string', 'max:255'],
            'Email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $id = $request->id;
            Employee::where('id', $id)->update([
                'first_name' => $request->FirstName,
                'last_name' => $request->LastName,
                'email' => $request->Email,
                'phone' => $request->Phone,
                'company_id' => $request->Company,
            ]);


            return response()->json(['status' => 1, 'msg' => 'Employee Updated successfully..!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employee::where('id', $id)->delete();
        return response()->json(['status' => 1, 'msg' => ' Employee deleted successfull..!']);
    }
}
