<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors=Doctor::with('qualification','department','user')-> get();
        return response()->json([
            'success' => true,
            'message' => 'Doctor retrieved Successfully',
            'data' => $doctors
        ], 200);
    }

    public function create()
    {
        return view('doctors.create');
    }

    public function store(Request $request)
    {
        try {
            //Validated
            $validateDoctor = Validator::make($request->all(),
            [
                'first_name' =>'required|string',
                'email' =>'required|email|unique:doctors',
                'user_id' =>'required|exists:users,id',
                'qualification_id' =>'required|exists:qualifications,id',
                'department_id' =>'required|exists:departments,id',
                'join_date' =>'required|string',
                

            ]);

            if($validateDoctor->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateDoctor->errors()
                ], 403);
            }

            $doctor=new Doctor;
            $doctor->first_name=$request->first_name;
            $doctor->last_name=$request->last_name;
            $doctor->birth_date=$request->birth_date;
            $doctor->email=$request->email;
            $doctor->qualification_id=$request->qualification_id;
            $doctor->department_id=$request->department_id;
            $doctor->user_id=$request->user_id;
            $doctor->join_date=$request->join_date;
            $doctor->gender=$request->gender;
            
            $doctor->save();

            return response()->json([
                'status' => true,
                'message' => 'Doctor Created Successfully'

            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $doctor = Doctor::with('qualification','department','user')->findOrFail($id);
        if($doctor){
            return response()->json([
                'success' => true,
                'message' => 'Doctor retrieved Successfully',
                'data' => $doctor
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
        $doctor = Doctor::findOrFail($id);
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        try {
            //Validated
            $validateDoctor = Validator::make($request->all(),
            [
                'first_name' =>'required|string',
                'email' =>'required|email|unique:doctors',
                'user_id' =>'required|exists:users,id',
                'qualification_id' =>'required|exists:qualifications,id',
                'department_id' =>'required|exists:departments,id',
                'join_date' =>'required|string',
                

            ]);

            if($validateDoctor->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateDoctor->errors()
                ], 403);
            }

            $doctor=Doctor::find($id);
            if($doctor){
                $doctor->first_name=$request->first_name;
                $doctor->last_name=$request->last_name;
                $doctor->birth_date=$request->birth_date;
                $doctor->email=$request->email;
                $doctor->qualification_id=$request->qualification_id;
                $doctor->department_id=$request->department_id;
                $doctor->user_id=$request->user_id;
                $doctor->join_date=$request->join_date;
                $doctor->gender=$request->gender;
                
                $doctor->save();
    
                return response()->json([
                    'status' => true,
                    'message' => 'Doctor Updated Successfully'
    
                ], 200);
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
        $doctor = Doctor::findOrFail($id);
        if($doctor){
            $doctor->delete();
            return response()->json([
                'success' => true,
                'message' => 'Doctor deleted Successfully',
            ], 202);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Data Found',
            ], 404);
        }
    }
}
