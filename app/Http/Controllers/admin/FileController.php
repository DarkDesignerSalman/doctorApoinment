<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\DoctorFile;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function showForm()
    {
        return view('file.upload');
    }

    public function upload(Request $request)
    {

        $validateFile = Validator::make($request->all(),
            [

               'file' => 'required',
                'doctor_id'=> 'required'

            ]);
              if($validateFile->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateFile->errors()
                ], 403);
            }




        $file = $request->file('file');

        if($file){

                $filename = time() . '.' . $file->getClientOriginalExtension();
                $folder = 'uploads';
                $path = $folder . '/' . $filename;
                $file->move(public_path($folder), $filename);

                $created_file=File::create([
                    'filename' => $filename,
                    'path' => $path
                ]);

                if($created_file){
                    $doctor_file=DoctorFile::create([
                    'doctor_id' => $request->doctor_id,
                    'file_id' => $created_file->id
                ]);
                 return response()->json([
                'success' => true,
                'message' => 'File uploaded Successfully',
                ], 200);
                }
        }
    }
}
