<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\DoctorFile;
use App\Models\File;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        // Validate the request parameters
        $request->validate([
            'qualification_id' => 'nullable|exists:qualifications,id',
        ]);

        // Build the query
        $query = Doctor::with('qualification', 'department', 'user')->with('profilePicture.file');

        // Apply the qualification filter if provided
        if ($request->has('qualification_id')) {
            $qualificationId = $request->input('qualification_id');
            $query->where('qualification_id', $qualificationId);
        }

        // Execute the query
        $doctors = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Doctors retrieved successfully',
            'data' => $doctors,
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
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                // 'file' => 'required',
                'file_id' =>'required|exists:files,id',

            ]);

            if($validateDoctor->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateDoctor->errors()
                ], 403);
            }



            $doctor = Doctor::create([
                    'first_name'  =>  $request->first_name,
                    'last_name'  => $request->last_name,
                    'birth_date' =>$request->birth_date,
                    'email'=>$request->email,
                    'qualification_id'=>$request->qualification_id,
                    'department_id'=>$request->department_id,
                    'user_id'=>$request->user_id,
                    'join_date'=>$request->join_date,
                    'gender'=>$request->gender,
                 ]);

                 if($doctor){

                    $doctor_file=DoctorFile::create([
                    'doctor_id' => $doctor->id,
                    'file_id' => $request->file_id
                ]);
                    //  $file = $request->file('file');

        //         if($file){

        //         $filename = time() . '.' . $file->getClientOriginalExtension();
        //         $folder = 'uploads';
        //         $path = $folder . '/' . $filename;
        //         $file->move(public_path($folder), $filename);

        //         $created_file=File::create([
        //             'filename' => $filename,
        //             'path' => $path
        //         ]);

        //         if($created_file){
        //             $doctor_file=DoctorFile::create([
        //             'doctor_id' =>$doctor->id,
        //             'file_id' => $created_file->id
        //         ]);
                 return response()->json([
                'success' => true,
                'message' => 'Doctor created Successfully',
                ], 200);
        //         }
        // }
                 }


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $doctor = Doctor::with('qualification','department','user')->with('profilePicture.file')->findOrFail($id);
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
                'email' =>'required|email',
                'user_id' =>'required|exists:users,id',
                'qualification_id' =>'required|exists:qualifications,id',
                'department_id' =>'required|exists:departments,id',
                'join_date' =>'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',


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

                if ($request->hasFile('file')) {
                $file = $request->file('file');

                // Your file handling logic here (similar to the upload function in the FileController)
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $folder = 'uploads';
                $path = $folder . '/' . $filename;
                $file->move(public_path($folder), $filename);

                // Update the associated file in the DoctorFile model
                $doctor->doctorFile->file->update([
                    'filename' => $filename,
                    'path' => $path,
                ]);
            }

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