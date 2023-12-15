<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\PrescriptionMedicine;
use App\Models\Medicine;
use App\Models\Test;
use Illuminate\Support\Facades\Validator;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::with(
            'doctor',
            'patient',
            'selectedMedicines'
        )->get();

        return response()->json([
            'success' => true,
            'message' => 'Prescriptions retrieved successfully',
            'data' => $prescriptions
        ], 200);
    }

    public function create()
    {
        $doctors = Doctor::all();
        $patients = Patient::all();
        $medicines = Medicine::all();
        $tests = Test::all();

        return view('prescriptions.create', compact('doctors', 'patients', 'medicines', 'tests'));
    }

    public function store(Request $request)
    {
        try {
            // Validation
            $validator = Validator::make($request->all(), [
                'doctor_id' => 'required|exists:doctors,id',
                'patient_id' => 'required|exists:patients,id',
                'date' => 'required|date',
                'medicine_ids' => 'required|array',
                'medicine_ids.*' => 'exists:medicines,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Create a new Prescription instance
            $prescription = Prescription::create($request->all());

            // Attach selected medicines to the prescription
            $prescription->selectedMedicines()->attach($request->input('medicine_ids'));

            // Load only the selected medicines to include in the response
            $prescription->load('selectedMedicines');

            return response()->json([
                'status' => true,
                'message' => 'Prescription created successfully',
                'data' => $prescription,
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
            $prescription = Prescription::with(['doctor', 'patient', 'selectedMedicines'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Prescription retrieved successfully',
                'data' => $prescription
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $prescription = Prescription::findOrFail($id);
            $doctors = Doctor::all();
            $patients = Patient::all();

            return view('prescriptions.edit', compact('prescription', 'doctors', 'patients'));
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
            $prescription = Prescription::findOrFail($id);

            // Validation
            $validator = Validator::make($request->all(), [
                'doctor_id' => 'required|exists:doctors,id',
                'patient_id' => 'required|exists:patients,id',
                'date' => 'required|date',
                'medicine_ids' => 'required|array',
                'medicine_ids.*' => 'exists:medicines,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $prescription->update($request->all());
            $prescription->selectedMedicines()->sync($request->input('medicine_ids'));
            $prescription->load('selectedMedicines');

            return response()->json([
                'status' => true,
                'message' => 'Prescription updated successfully',
                'data' => $prescription,
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
            $prescription = Prescription::findOrFail($id);
            $prescription->selectedMedicines()->detach();
            $prescription->delete();

            return response()->json([
                'success' => true,
                'message' => 'Prescription deleted successfully',
            ], 202);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getMedicines($prescriptionId)
    {
        try {
            $prescription = Prescription::with('selectedMedicines.medicine')->findOrFail($prescriptionId);
            $medicines = $prescription->selectedMedicines->pluck('medicine');

            return response()->json([
                'success' => true,
                'message' => 'Medicines retrieved successfully',
                'data' => $medicines
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
