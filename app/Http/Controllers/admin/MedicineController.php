<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::all();

        return response()->json([
            'success' => true,
            'message' => 'Medicines retrieved successfully',
            'data' => $medicines
        ], 200);
    }

    public function create()
    {
        return view('medicines.create');
    }

    public function store(Request $request)
    {
        try {
            // Validate
            $validateMedicine = Validator::make($request->all(), [
                'name' => 'required|string|unique:medicines',
            ]);

            if ($validateMedicine->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateMedicine->errors()
                ], 403);
            }

            $medicine = new Medicine;
            $medicine->name = $request->name;
            $medicine->save();

            return response()->json([
                'status' => true,
                'message' => 'Medicine created successfully'
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
        $medicine = Medicine::findOrFail($id);

        if ($medicine) {
            return response()->json([
                'success' => true,
                'message' => 'Medicine retrieved successfully',
                'data' => $medicine
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Data Found',
            ], 404);
        }
    }

    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('medicines.edit', compact('medicine'));
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate
            $validateMedicine = Validator::make($request->all(), [
                'name' => 'required|string|unique:medicines,name,' . $id,
            ]);

            if ($validateMedicine->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateMedicine->errors()
                ], 403);
            }

            $medicine = Medicine::find($id);

            if ($medicine) {
                $medicine->name = $request->name;
                $medicine->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Medicine updated successfully'
                ], 202);
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

    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);

        if ($medicine) {
            $medicine->delete();
            return response()->json([
                'success' => true,
                'message' => 'Medicine deleted successfully',
            ], 202);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Data Found',
            ], 404);
        }
    }
}