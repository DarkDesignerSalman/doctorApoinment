<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\Medicine;
use App\Models\PrescriptionMedicine;
use Illuminate\Support\Facades\Validator;

class PrescriptionMedicineController extends Controller
{
    public function index()
    {
        try {
            $prescriptionMedicines = PrescriptionMedicine::all();
            return response()->json([
                'success' => true,
                'message' => 'Prescription Medicines retrieved successfully',
                'data' => $prescriptionMedicines
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
            'medicine_id' => 'required|array',
            'medicine_id.*' => 'exists:medicines,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create PrescriptionMedicine instances for each medicine_id
        foreach ($request->input('medicine_id') as $medicineId) {
            PrescriptionMedicine::create([
                'prescription_id' => $request->input('prescription_id'),
                'medicine_id' => $medicineId,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Prescription Medicines created successfully',
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
            // Find the prescription medicine by ID
            $prescriptionMedicine = PrescriptionMedicine::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Prescription Medicine retrieved successfully',
                'data' => $prescriptionMedicine
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
        // Find the prescription medicine by ID
        $prescriptionMedicine = PrescriptionMedicine::findOrFail($id);

        // Validation
        $validator = Validator::make($request->all(), [
            'prescription_id' => 'required|exists:prescriptions,id',
            'medicine_id' => 'required|exists:medicines,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update prescription medicine data
        $prescriptionMedicine->update([
            'prescription_id' => $request->input('prescription_id'),
            'medicine_id' => $request->input('medicine_id'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Prescription Medicine updated successfully',
            'data' => $prescriptionMedicine
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
        $prescriptionMedicine = PrescriptionMedicine::findOrFail($id);
        $prescriptionMedicine->delete();

        return response()->json([
            'success' => true,
            'message' => 'Prescription Medicine deleted successfully',
        ], 202);
    } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
    }
}

}
