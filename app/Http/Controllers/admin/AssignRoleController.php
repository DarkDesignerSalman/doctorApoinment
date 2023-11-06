<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AssignRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user=User::where('id', $request->userid)->first();
        $role =Role::where('name' ,$request->role)->first();
        if($role){
            if($user){
              
            if(!$user->hasRole($role)){
                $user->assignRole($role);
                return response()->json([
                 'success' => true,
                 'message' => 'Role Assaign Created Successfully',
             ], 201);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Role is already assigned',
                ], 400);
            }
            }
           
           
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
