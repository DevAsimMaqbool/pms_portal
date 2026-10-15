<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;


class AllDepartmentEmployeeController extends Controller
{
   public function index()
    {
        $user = Auth::user();

        $departmentIds = $user->alldepartments_id ?? [];

        $departments = Department::whereIn('id', $departmentIds)
            ->with(['user' => function ($query) {
                $query->select(
                    'id',
                    'name',
                    'email',
                    'department_id',
                    'employee_id',
                    'as_admin_score',
                    'as_hod_score'
                )->whereHas('roles', function ($roleQuery) {
                    $roleQuery->where('name', 'HOD');
                });
            }])
            ->get();

        return view(
            'admin.departments.department-employees',
            compact('departments')
        );
    }
}
