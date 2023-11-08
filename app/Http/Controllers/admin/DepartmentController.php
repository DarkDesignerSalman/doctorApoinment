<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DepartmentController extends Controller
{
    public function index()
    {
        $departments=Department::all();
        return response()->json([
            'success' => true,
            'message' => 'Department retrieved Successfully',
            'data' => $departments
        ], 200);
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        try {
            //Validated
            $validateDepartment = Validator::make($request->all(),
            [
                'name' =>'required|string|unique:departments',
                

            ]);

            if($validateDepartment->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateDepartment->errors()
                ], 403);
            }

            $department=new Department;
            $department->name=$request->name;
            
            $department->save();

            return response()->json([
                'status' => true,
                'message' => 'Department Updated Successfully'

            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $department = Department::findOrFail($id);
        if($department){
            return response()->json([
                'success' => true,
                'message' => 'Department retrieved Successfully',
                'data' => $department
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Data Found',
            ], 404);
        }
        
       
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        try {
            //Validated
            $validateDepartment = Validator::make($request->all(),
            [
                'name' =>'required|string|unique:departments',
                

            ]);

            if($validateDepartment->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateDepartment->errors()
                ], 403);
            }

            $department=Department::find($id);
            if($department){
                $department->name=$request->name;
            
                $department->save();
    
                return response()->json([
                    'status' => true,
                    'message' => 'Department Updated Successfully'
    
                ], 202);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'No Data Found',
                ], 404);
            }
            

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        if($department){
            $department->delete();
            return response()->json([
                'success' => true,
                'message' => 'Department deleted Successfully',
            ], 202);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Data Found',
            ], 404);
        }
    }
}
