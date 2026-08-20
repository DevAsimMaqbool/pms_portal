<?php

namespace App\Http\Controllers;

use App\Models\CompletionOfCourseFolder;
use App\Models\FacultyMemberClass;
use App\Models\Term;
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
        $activeTermIds = Term::where('status', '1')->pluck('id');
        $data = CompletionOfCourseFolder::with('facultyClass') // eager load classes
            ->where('faculty_member_id', $employeeId)
            ->whereIn('term_id', $activeTermIds)
            ->where('completion_of_Course_folder_indicator_id', 120)
            ->get(); // make sure you call get() here, not just a query builder
        // dd($data);

        if (in_array(getRoleName(activeRole()), ['HOD', 'Teacher', 'Assistant Professor', 'Professor', 'Associate Professor', 'Demonstrator'])) {
            $status = $request->input('status');
            if ($status == "Teacher") {
                $forms = CompletionOfCourseFolder::with([
                    'creator' => function ($q) {
                        $q->select('employee_id', 'name');
                    },
                    'facultyClass'
                ])
                    ->where('faculty_member_id', $employeeId)
                    ->whereIn('term_id', $activeTermIds)
                    ->where('completion_of_Course_folder_indicator_id', 120)
                    ->orderBy('id', 'desc')
                    ->get();
            }
            if ($status == "HOD") {
                $employeeIds = User::where('manager_id', $employeeId)
                    ->role(['Teacher', 'Assistant Professor', 'Professor', 'Associate Professor', 'Demonstrator'])->pluck('employee_id');
                $forms = CompletionOfCourseFolder::with([
                    'creator' => function ($q) {
                        $q->select('employee_id', 'name');
                    },
                    'facultyClass'
                ])
                    ->whereIn('created_by', $employeeIds)
                    ->whereIn('term_id', $activeTermIds)
                    ->where('completion_of_Course_folder_indicator_id', 120)
                    ->orderBy('id', 'desc')
                    ->get();
            }

        }
        if (in_array(getRoleName(activeRole()), ['QEC'])) {
            $status = $request->input('status');
            if ($status == "RESEARCHER") {
                $forms = CompletionOfCourseFolder::with([
                    'creator' => function ($q) {
                        $q->select('employee_id', 'name');
                    },
                    'facultyClass'
                ])->whereIn('term_id', $activeTermIds)->orderBy('id', 'desc')
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
                    'term_id' => 'required|integer',
                    'class_name' => 'required|array',
                    'class_name.*' => 'string',
                    'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                ];

                // Add rules only if field exists in request
                if ($request->has('completion_of_Course_folder')) {
                    $rules['completion_of_Course_folder'] = 'nullable|integer';
                    $rules['completion_of_Course_folder_indicator_id'] = 'nullable|integer';
                    $rules['document_url'] = 'nullable|url';
                    $rules['completion_status'] = 'nullable|array';
                }

                if ($request->has('compliance_and_usage_of_lms')) {
                    $rules['compliance_and_usage_of_lms'] = 'nullable|integer';
                    $rules['compliance_and_usage_of_lms_indicator_id'] = 'nullable|integer';
                    $rules['document_url'] = 'nullable|url';
                    $rules['completion_status'] = 'nullable|array';
                }
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'error',
                        'errors' => $validator->errors()
                    ], 422);
                }
                $completionStatus = $request->completion_status ?? [];

                $checkedCount = 0;
                // Individual checkboxes
                $individualItems = ['Module', 'lecture log sheet', 'CQI Docuement',];
                foreach ($individualItems as $item) {
                    if (in_array($item, $completionStatus)) {
                        $checkedCount++;
                    }
                }
                // Assessment: Good / Bad / Any = count as ONE
                $assessmentOptions = ['Good', 'Bad', 'Any'];
                if (count(array_intersect($assessmentOptions, $completionStatus)) > 0) {
                    $checkedCount++;
                }
                // Result: Marks Sheet / Grading Sheet / CLO PLO Mapping Sheet = count as ONE
                $resultOptions = ['Marks Sheet', 'Grading Sheet', 'CLO PLO Maping Sheet'];
                if (count(array_intersect($resultOptions, $completionStatus)) > 0) {
                    $checkedCount++;
                }
                // Total logical items = 5
                $totalCheckboxes = 5;
                if ($checkedCount == 0) {
                    $completionScore = 25;
                } elseif ($checkedCount == $totalCheckboxes) {
                    $completionScore = 100;
                } else {
                    $completionScore = 70;
                }

                DB::beginTransaction();
                foreach ($request->class_name as $classCode) {

                    $exists = CompletionOfCourseFolder::where('faculty_member_id', $request->faculty_member_id)
                        ->where('class_cod', $classCode)
                        ->where('term_id', $request->term_id)
                        ->when($request->has('completion_of_Course_folder'), function ($query) use ($request) {
                            $query->where(
                                'completion_of_Course_folder_indicator_id',
                                $request->completion_of_Course_folder_indicator_id
                            );
                        })
                        ->when($request->has('compliance_and_usage_of_lms'), function ($query) use ($request) {
                            $query->where(
                                'compliance_and_usage_of_lms_indicator_id',
                                $request->compliance_and_usage_of_lms_indicator_id
                            );
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
                        'term_id' => $request->term_id,
                        'class_cod' => $classCode,
                        'form_status' => $request->form_status,
                        'created_by' => $employeeId,
                        'updated_by' => $employeeId,
                    ];

                    // Add only if exists in request
                    if ($request->has('completion_of_Course_folder')) {
                        $data['document_url'] = $request->document_url;
                        $data['completion_status'] = $completionStatus;
                        $data['completion_of_Course_folder'] = $completionScore;
                        $data['completion_of_Course_folder_indicator_id'] = $request->completion_of_Course_folder_indicator_id;
                    }

                    if ($request->has('compliance_and_usage_of_lms')) {
                        $data['document_url'] = $request->document_url;
                        $data['completion_status'] = $completionStatus;
                        $data['compliance_and_usage_of_lms'] = $completionScore;
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
                'term_id' => 'required|integer',
                'class_name' => 'required|array',
                'class_name.*' => 'string',
                'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
            ];

            if ($request->has('completion_of_Course_folder')) {
                $rules['completion_of_Course_folder'] = 'nullable|integer';
                $rules['completion_of_Course_folder_indicator_id'] = 'nullable|integer';
                $rules['document_url'] = 'nullable|url';
                $rules['completion_status'] = 'nullable|array';
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

            $completionStatus = $request->completion_status ?? [];

            $checkedCount = 0;
            // Individual checkboxes
            $individualItems = ['Module', 'lecture log sheet', 'CQI Docuement',];
            foreach ($individualItems as $item) {
                if (in_array($item, $completionStatus)) {
                    $checkedCount++;
                }
            }
            // Assessment: Good / Bad / Any = count as ONE
            $assessmentOptions = ['Good', 'Bad', 'Any'];
            if (count(array_intersect($assessmentOptions, $completionStatus)) > 0) {
                $checkedCount++;
            }
            // Result: Marks Sheet / Grading Sheet / CLO PLO Mapping Sheet = count as ONE
            $resultOptions = ['Marks Sheet', 'Grading Sheet', 'CLO PLO Maping Sheet'];
            if (count(array_intersect($resultOptions, $completionStatus)) > 0) {
                $checkedCount++;
            }
            // Total logical items = 5
            $totalCheckboxes = 5;
            if ($checkedCount == 0) {
                $completionScore = 25;
            } elseif ($checkedCount == $totalCheckboxes) {
                $completionScore = 100;
            } else {
                $completionScore = 70;
            }

            DB::beginTransaction();

            $classCode = $request->class_name[0]; // edit case → single class

            // ✅ Unique check (exclude current record)

            $exists = CompletionOfCourseFolder::where('faculty_member_id', $request->faculty_member_id)
                ->where('class_cod', $classCode)
                ->where('term_id', $request->term_id)
                ->where('id', '!=', $id)
                ->when($request->has('completion_of_Course_folder'), function ($query) use ($request) {
                    $query->where(
                        'completion_of_Course_folder_indicator_id',
                        $request->completion_of_Course_folder_indicator_id
                    );
                })
                ->when($request->has('compliance_and_usage_of_lms'), function ($query) use ($request) {
                    $query->where(
                        'compliance_and_usage_of_lms_indicator_id',
                        $request->compliance_and_usage_of_lms_indicator_id
                    );
                })
                ->exists();

            if ($exists) {
                DB::rollBack();

                return response()->json([
                    'status' => 'error',
                    'message' => 'This class already exists for this faculty member.'
                ], 409);
            }

            // Base update data
            $updateData = [
                'class_cod' => $classCode,
                'term_id' => $request->term_id,
                'form_status' => $request->form_status,
                'updated_by' => $employeeId,
            ];

            if ($request->has('completion_of_Course_folder')) {
                $updateData['completion_of_Course_folder_indicator_id'] = $request->completion_of_Course_folder_indicator_id;

                $updateData['document_url'] = $request->document_url;
                $updateData['completion_status'] = $completionStatus;
                $updateData['completion_of_Course_folder'] = $completionScore;
            }

            if ($request->has('compliance_and_usage_of_lms')) {
                $updateData['compliance_and_usage_of_lms'] = $request->compliance_and_usage_of_lms;
                $updateData['compliance_and_usage_of_lms_indicator_id'] = $request->compliance_and_usage_of_lms_indicator_id;
            }
            $updateData['status'] = 1;
            $updateData['reject_status'] = '0';
            $updateData['reject_status_remarks'] = null;

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
    public function getFacultyClasses($faculty_id, $term_id)
    {
        $classes = FacultyMemberClass::where('faculty_id', $faculty_id)
        ->where('term_id', $term_id)->get();

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
                        'user_id' => $currentUserId,
                        'user_name' => $currentUserName,
                        'status' => $request->status,
                        'role' => $userRoll,
                        'updated_at' => now()->toDateTimeString(),
                    ];
                }

                $target->status = $request->status;
                $target->reject_status = '0';
                $target->reject_status_remarks = null;
                $target->update_history = json_encode($history);
                $target->updated_by = $currentUserId;
                $target->save();

                return response()->json(['success' => true]);
            }
            if ($request->has('status_reject_update')) {
                $request->validate([
                    'status' => 'required|in:0,1,2,3,4,5,6'
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
                        'user_id' => $currentUserId,
                        'user_name' => $currentUserName,
                        'status' => 0,
                        'role' => $userRoll,
                        'remarks' => $request->reject_status_remarks,
                        'updated_at' => now()->toDateTimeString(),
                    ];
                }

                $target->status = 1;
                $target->reject_status = $request->status;
                $target->reject_status_remarks = $request->reject_status_remarks;
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