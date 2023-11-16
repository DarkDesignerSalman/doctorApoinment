<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoctorDetail;
use Illuminate\Support\Facades\Validator;

class DoctorDetailController extends Controller
{
    public function index()
    {
        $doctorDetails = DoctorDetail::with('doctor')->get();

        return response()->json([
            'success' => true,
            'message' => 'Doctor details retrieved successfully',
            'data' => $doctorDetails,
        ], 200);
    }

    public function create()
    {
        // Your create method logic here
    }

    public function store(Request $request)
    {
        try {
            $validateDoctorDetail = Validator::make($request->all(), [
                'doctor_id' => 'required|exists:doctors,id',
                'doctor_name' => 'required|string',
                'qualification' => 'required|string',
                'department' => 'required|string',
                'days_of_week' => 'required|string',
                'branch' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validateDoctorDetail->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateDoctorDetail->errors(),
                ], 403);
            }

            $doctorDetail = new DoctorDetail($request->all());

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/doctor_details'), $imageName);
                $doctorDetail->image = $imageName;
            }

            $doctorDetail->save();

            return response()->json([
                'status' => true,
                'message' => 'Doctor Detail Created Successfully',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $doctorDetail = DoctorDetail::with('doctor')->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Doctor detail retrieved successfully',
            'data' => $doctorDetail,
        ], 200);
    }

    public function edit($id)
    {
        // Your edit method logic here
    }

    public function update(Request $request, $id)
    {
        try {
            $validateDoctorDetail = Validator::make($request->all(), [
                'doctor_id' => 'required|exists:doctors,id',
                'doctor_name' => 'required|string',
                'qualification' => 'required|string',
                'department' => 'required|string',
                'days_of_week' => 'required|string',
                'branch' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validateDoctorDetail->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateDoctorDetail->errors(),
                ], 403);
            }

            $doctorDetail = DoctorDetail::find($id);

            if ($doctorDetail) {
                $doctorDetail->fill($request->all());

                // Handle image upload for update
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images/doctor_details'), $imageName);
                    $doctorDetail->image = $imageName;
                }

                $doctorDetail->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Doctor Detail Updated Successfully',
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
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $doctorDetail = DoctorDetail::findOrFail($id);

        if ($doctorDetail) {
            $doctorDetail->delete();

            return response()->json([
                'success' => true,
                'message' => 'Doctor Detail deleted Successfully',
            ], 202);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Data Found',
            ], 404);
        }
    }
}