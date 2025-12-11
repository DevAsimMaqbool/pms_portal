<?php

namespace App\Http\Controllers;

use App\Models\CompletionOfCourseFolder;
use App\Models\FacultyMemberClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompletionOfCourseFolderController extends Controller
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
    try { 
        $employeeId = Auth::user()->employee_id;
        // dd($request);

        if ($request->form_status == 'HOD') {

            // Validation rules
            $rules = [
                'faculty_member_id' => 'required|integer',
                'faculty_member_id' => 'integer|exists:users,id',
                'class_name' => 'required|array',
                'class_name.*' => 'string',
                'completion_of_Course_folder' => 'required|integer',
                'compliance_and_usage_of_lms' => 'required|integer',
                'completion_of_Course_folder_indicator_id' => 'nullable|integer',
                'compliance_and_usage_of_lms_indicator_id' => 'nullable|integer',
                'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

         

                foreach ($request->class_name as $classCode) {

                     // 🔍 Check if this faculty + this class already exists
                        $exists = CompletionOfCourseFolder::where('faculty_member_id', $request->faculty_member_id)
                                    ->where('class_cod', $classCode)
                                    ->exists();

                        if ($exists) {
                            DB::rollBack(); // rollback transactions before exit
                            return response()->json([
                                'status' => 'error',
                                'message' => "This class ($classCode) is already submitted for this faculty member."
                            ], 409);
                        }

                    // Insert record
                    CompletionOfCourseFolder::create([
                        'faculty_member_id' => $request->faculty_member_id,
                        'class_cod' => $classCode,

                        'completion_of_Course_folder' => $request->completion_of_Course_folder,
                        'completion_of_Course_folder_indicator_id' => $request->completion_of_Course_folder_indicator_id,

                        'compliance_and_usage_of_lms' => $request->compliance_and_usage_of_lms,
                        'compliance_and_usage_of_lms_indicator_id' => $request->compliance_and_usage_of_lms_indicator_id,

                        'form_status' => $request->form_status,
                        'created_by' => $employeeId,
                        'updated_by' => $employeeId,
                    ]);
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
     public function getFacultyClasses($faculty_id)
    {
        $classes = FacultyMemberClass::where('faculty_id', $faculty_id)->get();

        return response()->json($classes);
    }
}
