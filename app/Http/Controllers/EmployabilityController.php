<?php

namespace App\Http\Controllers;

use App\Models\Employability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Imports\EmployabilityImport;
use App\Imports\GraduateSatisfactionImport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class EmployabilityController extends Controller
{
    // public function index(Request $request)
    // {
    //     try {
    //         $data = Employability::all();
    //         if ($request->ajax()) {
    //             return response()->json($data);
    //         }
    //         return view('indicator_forms.employability');
    //     } catch (\Exception $e) {
    //         return apiResponse(
    //             'Oops! Something went wrong',
    //             [],
    //             false,
    //             500,
    //             ''
    //         );
    //     }
    // }

    public function index123(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = Auth::id();
            $employee_id = $user->employee_id;

            if (in_array(getRoleName(activeRole()), ['Employability Center'])) {
                $status = $request->input('status');
                if ($status == "HOD") {
                    $forms = Employability::with(['faculty', 'department', 'program'])->where('created_by', $employee_id)
                        ->orderBy('id', 'desc')
                        ->get();
                }
            }

            if ($request->ajax()) {
                return response()->json([
                    'forms' => $forms
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Oops! Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function index(Request $request)
    {
        try {

            $user = Auth::user();
            $employee_id = $user->employee_id;

            if (!in_array(getRoleName(activeRole()), ['Employability Center'])) {
                abort(403);
            }

            $query = Employability::with([
                'faculty',
                'department',
                'program',
            ])
            ->where('created_by', $employee_id)
            ->orderByDesc('id');

            return DataTables::eloquent($query)
                ->addIndexColumn()

                ->addColumn('faculty_name', function ($form) {
                    return $form->faculty?->name ?? 'N/A';
                })

                ->addColumn('department_name', function ($form) {
                    return $form->department?->name ?? 'N/A';
                })

                ->addColumn('program_name', function ($form) {
                    return $form->program?->program_name ?? 'N/A';
                })

                ->addColumn('actions', function ($form) {

                    $buttons = '';

                    if ((int) $form->status === 1) {
                        $formData = rawurlencode(json_encode($form));

                        $buttons .= '
                            <button
                                type="button"
                                class="btn rounded-pill btn-outline-warning waves-effect edit-form-btn"
                                data-form="' . $formData . '">
                                <span class="icon-xs icon-base ti tabler-edit me-2"></span>
                                Edit
                            </button>

                            <button
                                type="button"
                                class="btn rounded-pill btn-outline-danger delete-btn"
                                data-id="' . $form->id . '">
                                Delete
                            </button>
                        ';
                    }

                    return $buttons;
                })

                ->rawColumns(['actions'])

                ->toJson();

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Oops! Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
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
        try {

            if ($request->form_status == 'HOD') {
                $rules = [
                    'indicator_id' => 'required',
                    'period' => 'required|string',
                    'student_name' => 'required|string',
                    'student_id' => 'required|string',
                    'cnic' => '',
                    'domicile' => '',
                    'gender' => 'required',
                    'faculty_id' => 'required|integer',
                    'department_id' => 'required|integer',
                    'program_id' => 'required|integer',
                    'program_level' => 'required|string',
                    'batch' => 'required',
                    'date_of_appointment' => '',
                    'proof_salary_and_appointment' => '',
                    'passing_year' => 'required',
                    'employer_name' => '',
                    'sector' => 'required|string',
                    'salary' => 'required|integer|min:1',
                    'market_competitive_salary' => 'required|in:Above,At Par,Low',
                    'job_relevancy' => 'required|in:yes,no',
                    'employer_satisfaction' => 'nullable|numeric|min:0|max:5',
                    'graduate_satisfaction' => 'nullable|numeric|min:0|max:5',
                    'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'error',
                        'errors' => $validator->errors()
                    ], 422);
                }
                $data = $validator->validated();

            }
            $employeeId = Auth::user()->employee_id;
            DB::beginTransaction();
            $data['created_by'] = $employeeId;
            $data['updated_by'] = $employeeId;

            $record = Employability::create($data);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Record saved successfully',
                'data' => $record
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Oops! Something went wrong'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Employability::findOrFail($id);
        return response()->json($data);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $record = Employability::findOrFail($id);

        $request->validate([
            'record_id' => 'required',
            'period' => 'required|string',
            'student_name' => 'required|string',
            'student_id' => 'required|string',
            'cnic' => '',
            'domicile' => '',
            'gender' => 'required',
            'faculty_id' => 'required|integer',
            'department_id' => 'required|integer',
            'program_id' => 'required|integer',
            'program_level' => 'required|string',
            'batch' => 'required',
            'date_of_appointment' => '',
            'proof_salary_and_appointment' => '',
            'passing_year' => 'required',
            'employer_name' => '',
            'sector' => 'required|string',
            'salary' => 'required|integer|min:1',
            'market_competitive_salary' => 'required|in:Above,At Par,Low',
            'job_relevancy' => 'required|in:yes,no',
            'employer_satisfaction' => 'nullable|numeric|min:0|max:5',
            'graduate_satisfaction' => 'nullable|numeric|min:0|max:5',

        ]);

        $data = $request->only([
            'period',
            'student_name',
            'student_id',
            'cnic',
            'domicile',
            'gender',
            'faculty_id',
            'program_id',
            'program_level',
            'batch',
            'passing_year',
            'employer_name',
            'sector',
            'salary',
            'market_competitive_salary',
            'job_relevancy',
            'employer_satisfaction',
            'graduate_satisfaction'
        ]);
        $data['updated_by'] = Auth::user()->employee_id;

        $record->update($data);

        return response()->json(['status' => 'success', 'message' => 'Record updated successfully', 'data' => $record]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $record = Employability::findOrFail($id);

        $record->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
    public function report($id)
    {
        $area = Employability::with('indicatorCategories.indicators')->findOrFail($id);
        return view('admin.performance', compact('area'));
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
            'indicator_id' => 'required',
            'form_status' => 'required',
        ]);

        try {

            DB::beginTransaction();

            Excel::import(
                new EmployabilityImport(
                    $request->indicator_id,
                    $request->form_status
                ),
                $request->file('file')
            );

            DB::commit();

            return response()->json([
                'message' => 'Employability data imported successfully'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Import failed. No data was saved.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Import failed. No data was saved.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function importGraduateSatisfaction(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls,csv',
        'indicator_id' => 'required',
        'form_status' => 'required',
    ]);

    try {

        DB::beginTransaction();

        Excel::import(
            new GraduateSatisfactionImport(
                $request->indicator_id,
                $request->form_status
            ),
            $request->file('file')
        );

        DB::commit();

        return response()->json([
            'message' => 'Graduate satisfaction updated successfully'
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {

        DB::rollBack();

        return response()->json([
            'message' => 'Import failed. No data was updated.',
            'errors' => $e->errors(),
        ], 422);

    } catch (\Throwable $e) {

        DB::rollBack();

        return response()->json([
            'message' => 'Import failed. No data was updated.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function departmentCount(Request $request)
{
    try {

        $user = Auth::user();
        $employee_id = $user->employee_id;

        if (getRoleName(activeRole()) !== 'Employability Center') {
            abort(403);
        }

        $query = Employability::query()
            ->select([
                'employabilities.program_id',
                'employabilities.faculty_id',
                'employabilities.department_id',

                DB::raw('COUNT(*) as total_students'),

                DB::raw('SUM(employabilities.salary) as total_salary'),

                DB::raw('SUM(employabilities.employer_satisfaction) as total_employer_satisfaction'),

                DB::raw('SUM(employabilities.graduate_satisfaction) as total_graduate_satisfaction'),
                DB::raw("ROUND((COUNT(CASE WHEN employer_name IS NOT NULL THEN 1 END) / COUNT(*)) * 100, 2) AS employability"),
                DB::raw(" ROUND( ( SUM(CASE
                        WHEN employer_name IS NOT NULL
                        AND employer_satisfaction IS NOT NULL
                        THEN employer_satisfaction
                        ELSE 0 END) * 20) / NULLIF(SUM(
                    CASE
                        WHEN employer_name IS NOT NULL
                        THEN 1
                        ELSE 0
                    END ),0),2) AS employer_satisfaction_score"),
                    DB::raw("
                        ROUND(
                            (
                                SUM(
                                    CASE
                                        WHEN employer_name IS NOT NULL
                                        AND graduate_satisfaction IS NOT NULL
                                        THEN graduate_satisfaction
                                        ELSE 0
                                    END
                                ) * 20
                            )
                            / NULLIF(
                                SUM(
                                    CASE
                                        WHEN employer_name IS NOT NULL
                                        THEN 1
                                        ELSE 0
                                    END
                                ),
                                0
                            ),
                            2
                        ) AS graduate_sat
                    ")
                ])

            ->with([
                'faculty',
                'department',
                'program',
            ])

            ->where('employabilities.created_by', $employee_id)

            ->groupBy(
                'employabilities.program_id',
                'employabilities.faculty_id',
                'employabilities.department_id'
            )

            ->orderByDesc('employabilities.department_id');

        return DataTables::eloquent($query)

            ->addIndexColumn()

            ->addColumn('faculty_name', function ($form) {
                return $form->faculty?->name ?? 'N/A';
            })

            ->addColumn('department_name', function ($form) {
                return $form->department?->name ?? 'N/A';
            })

            ->addColumn('program_name', function ($form) {
                return $form->program?->program_name ?? 'N/A';
            })

            ->filter(function ($query) use ($request) {

                $search = $request->input('search.value');

                if (!empty($search)) {

                    $query->where(function ($q) use ($search) {

                        $q->whereHas('faculty', function ($faculty) use ($search) {
                            $faculty->where('name', 'like', "%{$search}%");
                        })

                        ->orWhereHas('department', function ($department) use ($search) {
                            $department->where('name', 'like', "%{$search}%");
                        })

                        ->orWhereHas('program', function ($program) use ($search) {
                            $program->where('program_name', 'like', "%{$search}%");
                        })

                        ->orWhere(
                            'employabilities.program_level',
                            'like',
                            "%{$search}%"
                        );
                    });
                }
            })

            ->toJson();

    } catch (\Exception $e) {

        return response()->json([
            'message' => 'Oops! Something went wrong',
            'error' => $e->getMessage()
        ], 500);
    }
}
    public function showDepartmentCount()
    {
        return view('admin.indicator_crud.employability_count');
    }
}

