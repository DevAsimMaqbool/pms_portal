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

}
