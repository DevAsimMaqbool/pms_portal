<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $students = Student::select(['id', 'roll_number', 'full_name', 'email']);

            return DataTables::of($students)
                ->addColumn('actions', function ($row) {
                    $url = route('forms.show', ['id' => $row->id, 'slug' => 'Employability']);
                    return '<a href="' . $url . '" class="btn btn-primary waves-effect waves-light">
                                    <span class="icon-xs icon-base ti tabler-layout-navbar me-2"></span>Employability
                                </a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.student');
    }
    public function test_forms($areaId, $categoryId, $indicatorId)
    {
         try {
             $user = Auth::user();
             $employee_id = $user->employee_id;
             $facultyMembers = User::where('manager_id', $employee_id)->get(['id','name','department','job_title']);
            // return view('admin.form.no_of_grants_submitted',compact('facultyMembers', 'areaId', 'categoryId', 'indicatorId'));
            //return view('admin.form.no_of_grants_submitted',compact('facultyMembers', 'areaId', 'categoryId', 'indicatorId'));
            //return view('admin.form.achievement_of_multidisciplinary',compact('facultyMembers', 'areaId', 'categoryId', 'indicatorId'));
            return view('admin.form.commercial_gains_counsultancy_research',compact('facultyMembers', 'areaId', 'categoryId', 'indicatorId'));
        } catch (\Exception $e) {
            return apiResponse('Oops! Something went wrong', [], false, 500, '');
        }
    }

}
