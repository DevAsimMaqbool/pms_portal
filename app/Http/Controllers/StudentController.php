<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    public function index(Request $request)
    {
       if ($request->ajax()) {
            $students = Student::select(['id', 'full_name', 'email', 'created_at', 'updated_at']);

            return DataTables::of($students)
                ->addColumn('actions', function ($row) {
                    return '<button type="button" class="btn btn-primary waves-effect waves-light"><span class="icon-xs icon-base ti tabler-layout-navbar me-2"></span>Form</button>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.student');
    }

}
