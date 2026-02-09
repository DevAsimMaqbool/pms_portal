<?php

namespace App\Http\Controllers;

use App\Models\StudentEngagementRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudentEngagementRateController extends Controller
{
    public function store(Request $request)
    {
        try { 
             $data = [];
            if($request->form_status=='HOD'){
                 $rules = [
                    'indicator_id' => 'required',
                    'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',

                    'stakeholder_category' => 'nullable|array',
                    'nature_of_activity' => 'nullable|string',
                    'activity_location' => 'nullable|array',

                    'title_of_activity' => 'nullable|string',
                    'brief_description_of_activity' => 'nullable|string',
                    'date_of_activity' => 'nullable|date',
                    'partner_organization' => 'nullable|string',

                    'total_number_of_faculty_in_department' => 'nullable|integer',
                    'number_of_faculty_participated' => 'nullable|integer',
                    'total_number_of_staff_in_office' => 'nullable|integer',
                    'number_of_staff_participated' => 'nullable|integer',
                    'total_number_of_students_in_program' => 'nullable|integer',
                    'number_of_students_participated' => 'nullable|integer',

                    'typ_of_impact_achieved' => 'nullable|array',
                    'evidence_of_impact_available' => 'nullable|array',

                    'declaration' => 'nullable|boolean',
                    'employer_satisfaction' => 'nullable|integer|min:1|max:5',
                ];


                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                        }
                    
                    $data = $validator->validated(); 
                    $data['stakeholder_category'] = json_encode($data['stakeholder_category']);
                    $data['nature_of_activity'] = json_encode($data['nature_of_activity']);
                    $data['activity_location'] = json_encode($data['activity_location']);
                    $data['typ_of_impact_achieved'] = json_encode($data['typ_of_impact_achieved']);
                    $data['evidence_of_impact_available'] = json_encode($data['evidence_of_impact_available']); 

                        

            }
            $employeeId = Auth::user()->employee_id;
            DB::beginTransaction();
            $data['created_by'] = $employeeId;
            $data['updated_by'] = $employeeId;

            $record = StudentEngagementRate::create($data);
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
}
