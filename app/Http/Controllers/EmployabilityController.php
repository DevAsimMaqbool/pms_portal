<?php

namespace App\Http\Controllers;

use App\Models\Employability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Imports\EmployabilityImport;
use Maatwebsite\Excel\Facades\Excel;

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

    public function index(Request $request)
    {
         try {
            $user = Auth::user();
            $userId = Auth::id();
            $employee_id = $user->employee_id;

        if(in_array(getRoleName(activeRole()), ['Employability Center'])) {
                $status = $request->input('status');
                if($status=="HOD"){
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
            
            if($request->form_status=='HOD'){
                 $rules = [
                    'indicator_id' => 'required',
                    'period' => 'required|string',
                    'student_name' => 'required|string',
                    'faculty_id' => 'required|integer',
                    'department_id' => 'required|integer',
                    'program_id' => 'required|integer',
                    'batch' => 'required',
                    'date_of_appointment' => 'required',
                    'proof_salary_and_appointment' => 'required',
                    'passing_year' => 'required',
                    'employer_name' => 'required|string',
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
                'faculty_id' => 'required|integer',
                'department_id' => 'required|integer',
                'program_id' => 'required|integer',
                'batch' => 'required',
                'date_of_appointment' => 'required',
                'proof_salary_and_appointment' => 'required',
                'passing_year' => 'required',
                'employer_name' => 'required|string',
                'sector' => 'required|string',
                'salary' => 'required|integer|min:1',
                'market_competitive_salary' => 'required|in:Above,At Par,Low',
                'job_relevancy' => 'required|in:yes,no',
                'employer_satisfaction' => 'nullable|numeric|min:0|max:5',
                'graduate_satisfaction' => 'nullable|numeric|min:0|max:5',
    
        ]);

        $data = $request->only([
                        'period', 'student_name', 'faculty_id', 'program_id', 'batch','passing_year',
                        'employer_name','sector','salary','market_competitive_salary','job_relevancy','employer_satisfaction',
                        'graduate_satisfaction'
                    ]);
                    $data['updated_by'] = Auth::user()->employee_id;

                    $record->update($data);

                    return response()->json(['status' => 'success','message' => 'Record updated successfully', 'data' => $record]);
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
            'file' => 'required|mimes:xlsx,xls,csv',
            'indicator_id' => 'required',
            'form_status' => 'required',
        ]);

        Excel::import(
            new EmployabilityImport(
                $request->indicator_id,
                $request->form_status
            ),
            $request->file
        );

        return response()->json([
            'message' => 'Employability data imported successfully'
        ]);
    }
}

