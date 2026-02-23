<?php

namespace App\Http\Controllers;

use App\Models\CompletionOfCourseFolder;
use App\Models\FacultyMemberClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompletionOfCourseFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employeeId = Auth::id();
        $data = CompletionOfCourseFolder::with('facultyClass') // eager load classes
            ->where('faculty_member_id', $employeeId)
            ->where('completion_of_Course_folder_indicator_id', 120)
            ->get(); // make sure you call get() here, not just a query builder
        // dd($data);


        if(in_array(getRoleName(activeRole()), ['HOD', 'Teacher'])) {
                $status = $request->input('status');
                if($status=="Teacher"){
                    $forms = CompletionOfCourseFolder::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            },'facultyClass'
                        ])
                        ->where('faculty_member_id', $employeeId)
                        ->where('completion_of_Course_folder_indicator_id', 120)
                        ->get();
                }
                if($status=="HOD"){
                    $employeeIds = User::where('manager_id', $employeeId)
                        ->role('Teacher')->pluck('employee_id');
                        $forms = CompletionOfCourseFolder::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                },'facultyClass'
                            ])
                            ->whereIn('created_by', $employeeIds)
                            ->where('completion_of_Course_folder_indicator_id', 120)
                            ->orderBy('id', 'desc')
                            ->get();
                }        
                
            }
             if(in_array(getRoleName(activeRole()), ['QEC'])) {
                $status = $request->input('status');
                if($status=="RESEARCHER"){
                    $forms = CompletionOfCourseFolder::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            },'facultyClass'
                        ])->orderBy('id', 'desc')
                        ->get();
                }       
            }

            if ($request->ajax()) {
                return response()->json([
                    'forms' => $forms
                ]);
            }
        return view('admin.indicator_crud.completion_of_course_folder', compact('data'));

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
            $employeeId = Auth::id();
            if ($request->form_status == 'HOD') {
                // Validation rules
                $rules = [
                    'faculty_member_id' => 'required|integer',
                    'class_name' => 'required|array',
                    'class_name.*' => 'string',
                    'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                ];

                // Add rules only if field exists in request
                if ($request->has('completion_of_Course_folder')) {
                    $rules['completion_of_Course_folder'] = 'nullable|integer';
                    $rules['completion_of_Course_folder_indicator_id'] = 'nullable|integer';
                }

                if ($request->has('compliance_and_usage_of_lms')) {
                    $rules['compliance_and_usage_of_lms'] = 'nullable|integer';
                    $rules['compliance_and_usage_of_lms_indicator_id'] = 'nullable|integer';
                }
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'error',
                        'errors' => $validator->errors()
                    ], 422);
                }

                DB::beginTransaction();
                foreach ($request->class_name as $classCode) {

                    $exists = CompletionOfCourseFolder::where('faculty_member_id', $request->faculty_member_id)
                        ->where('class_cod', $classCode)
                        ->where(function ($query) use ($request) {
                            $query->where('completion_of_Course_folder_indicator_id', $request->completion_of_Course_folder_indicator_id)
                                ->where('compliance_and_usage_of_lms_indicator_id', $request->compliance_and_usage_of_lms_indicator_id);
                        })
                        ->exists();


                    if ($exists) {
                        DB::rollBack();
                        return response()->json([
                            'status' => 'error',
                            'message' => "This class ($classCode) is already submitted for this faculty member."
                        ], 409);
                    }

                    // Base data (always inserted)
                    $data = [
                        'faculty_member_id' => $request->faculty_member_id,
                        'class_cod' => $classCode,
                        'form_status' => $request->form_status,
                        'created_by' => $employeeId,
                        'updated_by' => $employeeId,
                    ];

                    // Add only if exists in request
                    if ($request->has('completion_of_Course_folder')) {
                        $data['completion_of_Course_folder'] = $request->completion_of_Course_folder;
                        $data['completion_of_Course_folder_indicator_id'] = $request->completion_of_Course_folder_indicator_id;
                    }

                    if ($request->has('compliance_and_usage_of_lms')) {
                        $data['compliance_and_usage_of_lms'] = $request->compliance_and_usage_of_lms;
                        $data['compliance_and_usage_of_lms_indicator_id'] = $request->compliance_and_usage_of_lms_indicator_id;
                    }

                    CompletionOfCourseFolder::create($data);
                }


                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Form saved successfully!',
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid form_status'
            ], 400);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Oops! Something went wrong',
                'error' => $e->getMessage()
            ], 500);
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
    public function edit($id)
    {
        $data = CompletionOfCourseFolder::findOrFail($id);

        return view('admin.indicator_crud.completion-of-course-folder-edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $employeeId = Auth::id();

            $record = CompletionOfCourseFolder::findOrFail($id);
            // Validation
            $rules = [
                'faculty_member_id' => 'required|integer',
                'class_name' => 'required|array',
                'class_name.*' => 'string',
                'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
            ];

            if ($request->has('completion_of_Course_folder')) {
                $rules['completion_of_Course_folder'] = 'nullable|integer';
                $rules['completion_of_Course_folder_indicator_id'] = 'nullable|integer';
            }

            if ($request->has('compliance_and_usage_of_lms')) {
                $rules['compliance_and_usage_of_lms'] = 'nullable|integer';
                $rules['compliance_and_usage_of_lms_indicator_id'] = 'nullable|integer';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $classCode = $request->class_name[0]; // edit case → single class

            // ✅ Unique check (exclude current record)
            $exists = CompletionOfCourseFolder::where('faculty_member_id', $request->faculty_member_id)
                ->where('class_cod', $classCode)
                ->where('id', '!=', $id)
                ->where(function ($query) use ($request) {
                    $query->where('completion_of_Course_folder_indicator_id', $request->completion_of_Course_folder_indicator_id)
                        ->orWhere('compliance_and_usage_of_lms_indicator_id', $request->compliance_and_usage_of_lms_indicator_id);
                })
                ->exists();

            if ($exists) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => "This class already exists for this faculty member."
                ], 409);
            }

            // Base update data
            $updateData = [
                'class_cod' => $classCode,
                'form_status' => $request->form_status,
                'updated_by' => $employeeId,
            ];

            if ($request->has('completion_of_Course_folder')) {
                $updateData['completion_of_Course_folder'] = $request->completion_of_Course_folder;
                $updateData['completion_of_Course_folder_indicator_id'] = $request->completion_of_Course_folder_indicator_id;
            }

            if ($request->has('compliance_and_usage_of_lms')) {
                $updateData['compliance_and_usage_of_lms'] = $request->compliance_and_usage_of_lms;
                $updateData['compliance_and_usage_of_lms_indicator_id'] = $request->compliance_and_usage_of_lms_indicator_id;
            }

            $record->update($updateData);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Record updated successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Oops! Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getFacultyClasses($faculty_id)
    {
        $classes = FacultyMemberClass::where('faculty_id', $faculty_id)->get();

        return response()->json($classes);
    }
    public function updatestatusverification(Request $request, $id)
    {   
        try { 
            if ($request->has('status_update')) {
                $request->validate([
                    'status' => 'required|in:1,2,3,4,5,6'
                ]);

                $target = CompletionOfCourseFolder::findOrFail($id);

                // Get current update history
                $history = $target->update_history ? json_decode($target->update_history, true) : [];

                // Get current user info
                $currentUserId = Auth::id();
                $currentUserName = Auth::user()->name;
                $userRoll = getRoleName(activeRole()) ?? 'N/A';

                // Avoid duplicate consecutive updates by the same user with the same status
                $lastUpdate = end($history);
                if (!$lastUpdate || $lastUpdate['user_id'] != $currentUserId || $lastUpdate['status'] != $request->status) {
                    $history[] = [
                        'user_id'    => $currentUserId,
                        'user_name'  => $currentUserName,
                        'status'     => $request->status,
                        'role'     => $userRoll,
                        'updated_at' => now()->toDateTimeString(),
                    ];
                }





                $target->status = $request->status;
                $target->update_history = json_encode($history);
                $target->updated_by = $currentUserId;
                $target->save();

                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {
             DB::rollBack();
             return response()->json(['message' => 'Oops! Something went wrong'], 500);
        }
    }
}
