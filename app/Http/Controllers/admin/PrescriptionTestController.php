<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\Test;
use App\Models\PrescriptionTest;
use Illuminate\Support\Facades\Validator;

class PrescriptionTestController extends Controller
{
    public function index()
    {
        try {
            $prescriptionTests = PrescriptionTest::all();
            return response()->json([
                'success' => true,
                'message' => 'Prescription Tests retrieved successfully',
                'data' => $prescriptionTests
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

   public function store(Request $request)
{
    try {
        // Validation
        $validator = Validator::make($request->all(), [
            'prescription_id' => 'required|exists:prescriptions,id',
            'test_id' => 'required|array',
            'test_id.*' => 'exists:tests,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create PrescriptionTest instances for each test_id
        foreach ($request->input('test_id') as $testId) {
            PrescriptionTest::create([
                'prescription_id' => $request->input('prescription_id'),
                'test_id' => $testId,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Prescription Tests created successfully',
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
        try {
            // Find the prescription test by ID
            $prescriptionTest = PrescriptionTest::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Prescription Test retrieved successfully',
                'data' => $prescriptionTest
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

  public function update(Request $request, $id)
{
    try {
        // Find the prescription test by ID
        $prescriptionTest = PrescriptionTest::findOrFail($id);

        // Validation
        $validator = Validator::make($request->all(), [
            'prescription_id' => 'required|exists:prescriptions,id',
            'test_id' => 'required|exists:tests,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update prescription test data
        $prescriptionTest->update([
            'prescription_id' => $request->input('prescription_id'),
            'test_id' => $request->input('test_id'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Prescription Test updated successfully',
            'data' => $prescriptionTest
        ], 200);
    } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
    }
}


   public function destroy($id)
{
    try {
        $prescriptionTest = PrescriptionTest::findOrFail($id);
        $prescriptionTest->delete();

        return response()->json([
            'success' => true,
            'message' => 'Prescription Test deleted successfully',
        ], 202);
    } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
    }
}

}