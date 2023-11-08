<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Qualification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QualificationController extends Controller
{
    public function index()
    {
        $qualifications=Qualification::all();
        return response()->json([
            'success' => true,
            'message' => 'Qualification retrieved Successfully',
            'data' => $qualifications
        ], 200);
    }

    public function create()
    {
        return view('qualifications.create');
    }

    public function store(Request $request)
    {
        try {
            //Validated
            $validateQualification = Validator::make($request->all(),
            [
                'name' =>'required|string|unique:qualifications',
                

            ]);

            if($validateQualification->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateQualification->errors()
                ], 403);
            }

            $qualification=new Qualification;
            $qualification->name=$request->name;
            
            $qualification->save();

            return response()->json([
                'status' => true,
                'message' => 'Qualification Updated Successfully'

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
        $qualification = Qualification::findOrFail($id);
        if($qualification){
            return response()->json([
                'success' => true,
                'message' => 'qualification retrieved Successfully',
                'data' => $qualification
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
        $qualification = Qualification::findOrFail($id);
        return view('qualifications.edit', compact('qualification'));
    }

    public function update(Request $request, $id)
    {
        try {
            //Validated
            $validateQualification = Validator::make($request->all(),
            [
                'name' =>'required|string|unique:qualifications',
                

            ]);

            if($validateQualification->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateQualification->errors()
                ], 403);
            }

            $qualification=Qualification::find($id);
            if($qualification){
                $qualification->name=$request->name;
            
                $qualification->save();
    
                return response()->json([
                    'status' => true,
                    'message' => 'qualification Updated Successfully'
    
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
        $qualification = Qualification::findOrFail($id);
        if($qualification){
            $qualification->delete();
            return response()->json([
                'success' => true,
                'message' => 'Qualification deleted Successfully',
            ], 202);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Data Found',
            ], 404);
        }
    }
}
