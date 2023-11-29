<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
// use App\Models\DoctorFile;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{

   public function index()
{
    // Retrieve all files from the database
    $files = File::all();

    return response()->json([
        'success' => true,
        'message' => 'Files retrieved successfully',
        'data' => $files,
    ], 200);
}

public function show($id)
{
    // Retrieve a specific file based on the provided ID
    $file = File::find($id);

    if (!$file) {
        return response()->json([
            'status' => false,
            'message' => 'File not found',
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => 'File retrieved successfully',
        'data' => $file,
    ], 200);
}

//upload function

    public function upload(Request $request)
    {

        $validateFile = Validator::make($request->all(),
            [

               'file' => 'required',
                // 'doctor_id'=> 'required'

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
                //     $doctor_file=DoctorFile::create([
                //     'doctor_id' => $request->doctor_id,
                //     'file_id' => $created_file->id
                // ]);
                 return response()->json([
                'success' => true,
                'message' => 'File uploaded Successfully',
                'data' => $created_file,

                ], 200);
                }
        }
    }


//update function

 public function update(Request $request)
    {
        try {
            // Updated Validation Rule
            $validateFile = Validator::make($request->all(), [
                'id' => 'required',
                'file' => 'required',
            ]);

            if ($validateFile->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateFile->errors(),
                ], 403);
            }


            $file = File::where('id',$request->id)->first();
            // $file = File::find($request->id);


            if (!$file) {
                return response()->json([
                    'status' => false,
                    'message' => 'File not found',
                ], 404);
            }

            if ($request->hasFile('file')) {

                // Your file handling logic here
                $newFile = $request->file('file');
                $filename = time() . '.' . $newFile->getClientOriginalExtension();
                $folder = 'uploads';
                $path = $folder . '/' . $filename;
                $newFile->move(public_path($folder), $filename);


                // Delete the old file from storage
                $oldFilePath = public_path($file->path);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
                // Update file information in the database
                $file->update([
                    'filename' => $filename,
                    'path' => $path,
                ]);


            }

            return response()->json([
                'success' => true,
                'message' => 'File updated successfully',
                'data' => $file,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }

    }

    // public function update(Request $request)
    // {

    //     try {
    //         $request->validate([
    //             'file' => 'required',
    //             'id'=>'required',
    //         ]);

    //         // $file = File::findOrFail($id);
    //          $file = File::where('id',$request->id)->first();

    //         $newFile = $request->file('file');
    //         $filename = time() . '.' . $newFile->getClientOriginalExtension();
    //         $folder = 'uploads';
    //         $path = $folder . '/' . $filename;
    //         $newFile->move(public_path($folder), $filename);

    //         $file->update([
    //             'filename' => $filename,
    //             'path' => $path,
    //         ]);


    //         return response()->json([
    //             'success' => true,
    //             'message' => 'File updated successfully',
    //             'data' => $file,
    //         ], 200);

    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => $th->getMessage(),
    //         ], 500);
    //     }
    // }




//delete function

     public function delete($id)
    {
        $file = File::find($id);

        if (!$file) {
            return response()->json([
                'status' => false,
                'message' => 'File not found',
            ], 404);
        }

        // Delete the file from storage
        $filePath = public_path($file->path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete the file record from the database
        $file->delete();

        return response()->json([
            'success' => true,
            'message' => 'File deleted successfully',
        ], 200);
    }



}