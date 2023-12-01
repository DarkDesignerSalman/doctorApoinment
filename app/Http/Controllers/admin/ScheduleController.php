<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Doctor; // Assuming Doctor model is already imported
use App\Models\Qualification;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\View;


class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('doctor.qualification')->get();
        return response()->json([
            'success' => true,
            'message' => 'Schedules retrieved Successfully',
            'data' => $schedules
        ], 200);
    }

    public function create()
    {
        // You can create a view for creating schedules if needed
        return view('schedules.create');
    }

    public function store(Request $request)
    {
        try {
            // Validation
            $validateSchedule = Validator::make($request->all(), [
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i',
                'doctor_id' => 'required|exists:doctors,id',
                'qualification_id' => 'required|exists:qualifications,id',
                'date' => 'required|date',
            ]);

            if ($validateSchedule->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateSchedule->errors()
                ], 403);
            }

            $schedule = new Schedule;
            $schedule->doctor_id = $request->doctor_id;
            $schedule->qualification_id = $request->qualification_id;
            $schedule->start_time = $request->start_time;
            $schedule->end_time = $request->end_time;
            $schedule->date = $request->date;

            $schedule->save();

            return response()->json([
                'status' => true,
                'message' => 'Schedule Created Successfully'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $schedule = Schedule::with('doctor.qualification')->findOrFail($id);
        if ($schedule) {
            return response()->json([
                'success' => true,
                'message' => 'Schedule retrieved Successfully',
                'data' => $schedule
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
        $schedule = Schedule::findOrFail($id);
        return view('schedules.edit', compact('schedule'));
    }

    public function update(Request $request, $id)
    {
        try {
            // Validation
            $validateSchedule = Validator::make($request->all(), [
               'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i',
                'doctor_id' => 'required|exists:doctors,id',
                'qualification_id' => 'required|exists:qualificationa,id',
                'date' => 'required|date',
            ]);

            if ($validateSchedule->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateSchedule->errors()
                ], 403);
            }

            $schedule = Schedule::find($id);
            if ($schedule) {
                $schedule->doctor_id = $request->doctor_id;
                $schedule->qualification_id = $request->qualification_id;
                $schedule->start_time = $request->start_time;
                $schedule->end_time = $request->end_time;
                 $schedule->date = $request->date;

                $schedule->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Schedule Updated Successfully'

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

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        if ($schedule) {
            $schedule->delete();
            return response()->json([
                'success' => true,
                'message' => 'Schedule deleted Successfully',
            ], 202);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Data Found',
            ], 404);
        }
    }
public function createPDF()
    {
        try {
            // Retrieve all schedule records from the database
            $schedules = Schedule::with('doctor.qualification')->get();

            // Share data to the view
            $data = ['schedules' => $schedules];

            // Load the view for PDF
            $pdf = PDF::loadView('schedules.pdf_view', $data);

            // Download PDF file with the download method
            return $pdf->download('schedules_pdf_file.pdf');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
