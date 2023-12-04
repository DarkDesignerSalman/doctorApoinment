<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::all();
        return response()->json([
            'success' => true,
            'message' => 'Tests retrieved successfully',
            'data' => $tests
        ], 200);
    }

    public function create()
    {
        return view('tests.create');
    }

    public function store(Request $request)
    {
        try {
            // Validate
            $validateTest = Validator::make($request->all(), [
                'test_name' => 'required|string|unique:tests',
            ]);

            if ($validateTest->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateTest->errors()
                ], 403);
            }

            $test = new Test;
            $test->test_name = $request->test_name;
            $test->save();

            return response()->json([
                'status' => true,
                'message' => 'Test created successfully'

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
        $test = Test::findOrFail($id);

        if ($test) {
            return response()->json([
                'success' => true,
                'message' => 'Test retrieved successfully',
                'data' => $test
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
        $test = Test::findOrFail($id);
        return view('tests.edit', compact('test'));
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate
            $validateTest = Validator::make($request->all(), [
                'test_name' => 'required|string|unique:tests,test_name,' . $id,
            ]);

            if ($validateTest->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateTest->errors()
                ], 403);
            }

            $test = Test::find($id);

            if ($test) {
                $test->test_name = $request->test_name;
                $test->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Test updated successfully'

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
        $test = Test::findOrFail($id);

        if ($test) {
            $test->delete();
            return response()->json([
                'success' => true,
                'message' => 'Test deleted successfully',
            ], 202);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Data Found',
            ], 404);
        }
    }
}