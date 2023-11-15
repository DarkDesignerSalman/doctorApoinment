<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ap\LoginController;
use App\Http\Controllers\ap\RegisterController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\AssignRoleController;
use App\Http\Controllers\admin\DoctorController;
use App\Http\Controllers\admin\DepartmentController;
use App\Http\Controllers\admin\QualificationController;
use App\Http\Controllers\admin\ScheduleController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('customer',[CustomerController::class,'login']);
Route::get('customers',[CustomerController::class,'allcustomer'])->middleware('auth:sanctum','abilities:customer');


Route::post('member_login',[MemberController::class,'login']);
Route::get('member',[MemberController::class,'authUser'])->middleware('auth:sanctum','abilities:member');


Route::post('login',[LoginController::class,'login']);
Route::post('register',[RegisterController::class,'register']);

Route::group(["prefix"=>"admin"], function(){
Route::resource('/roles', RoleController::class);
Route::resource('/permissions', PermissionController::class);
Route::resource('/users', UserController::class);
Route::resource('/assignrole', AssignRoleController::class);
Route::resource('/doctors', DoctorController::class);
Route::resource('/departments', DepartmentController::class);
Route::resource('/qualifications', QualificationController::class);
Route::resource('/schedules', ScheduleController::class);
});



Route::group(["prefix"=>"doctor"], function(){


});
Route::group(["prefix"=>"user"], function(){

});