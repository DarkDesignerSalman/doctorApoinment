<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Contracts\Validation\Rule;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

         $patients=Patient::all();
        return response()->json([
            'success' => true,
            'message' => 'Patient retrieved Successfully',
            'data' => $patients
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       try {
            // Validation
            $validatePatient = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:patients,email',
                'phone' => 'required|string',
                'gender' => 'required|in:Male,Female,Other',
                'birth_date' => 'required|date',

            ]);

            if ($validatePatient->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validatePatient->errors()
                ], 422);
            }

            // Create a new Patient instance
            $patient = new Patient;
            $patient->name = $request->input('name');
            $patient->email = $request->input('email');
            $patient->phone = $request->input('phone');
            $patient->gender = $request->input('gender');
            $patient->birth_date = $request->input('birth_date');

            // Save the patient to the database
            $patient->save();

            return response()->json([
                'status' => true,
                'message' => 'Patient created successfully',
                'data' => $patient
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }





    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
try {
        // Find the patient by ID
        $patient = Patient::find($id);

        // Check if the patient exists
        if ($patient) {
            return response()->json([
                'success' => true,
                'message' => 'Patient retrieved Successfully',
                'data' => $patient
            ], 200);
        } else {
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         return view('patients.edit', compact('patient'));
    }

    /**
 * Update the specified resource in storage.
 */
    public function update(Request $request, $id)
    {
        try {
        // Find the patient by ID
        $patient = Patient::find($id);

        // Check if the patient exists
        if (!$patient) {
            return response()->json([
                'status' => false,
                'message' => 'Patient not found',
            ], 404);
        }

        // Validation
        $validatePatient = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:patients,email,' . $id,
            'phone' => 'required|string',
            'gender' => 'required|in:Male,Female,Other',
            'birth_date' => 'required|date',
        ]);

        if ($validatePatient->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validatePatient->errors()
            ], 422);
        }

        // Update patient data
        $patient->name = $request->input('name');
        $patient->email = $request->input('email');
        $patient->phone = $request->input('phone');
        $patient->gender = $request->input('gender');
        $patient->birth_date = $request->input('birth_date');

        // Save the updated patient to the database
        $patient->save();

        return response()->json([
            'status' => true,
            'message' => 'Patient updated successfully',
            'data' => $patient
        ], 200);

    } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
    }

    }


    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        if($patient){
            $patient->delete();
            return response()->json([
                'success' => true,
                'message' => 'Patient deleted Successfully',
            ], 202);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Data Found',
            ], 404);
        }
    }
}