<?php

namespace App\Http\Controllers;

use App\Models\StudentEngagementRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudentEngagementRateController extends Controller
{
    public function index(Request $request)
    {
         try {
            $user = Auth::user();
            $userId = Auth::id();
            $employee_id = $user->employee_id;

                $status = $request->input('status');
                if($status=="HOD"){
                        $forms = StudentEngagementRate::where('created_by', $employee_id)
                        ->orderBy('id', 'desc')
                        ->get();
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
    public function store(Request $request)
    {
        try { 
             $data = [];
            if($request->form_status=='HOD'){
                 $rules = [
                    'indicator_id' => 'required',
                    'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',

                    // Engagement
                    'nature_of_event' => 'required|string',
                    'other_event_detail' => 'nullable|string',
                    'event_location' => 'nullable|array',
                    'scope_of_the_event' => 'nullable|string',

                    // Event Details
                    'title_of_the_event' => 'nullable|string',
                    'brief_description_of_activity' => 'nullable|string',
                    'event_start_date' => 'required|date',
                    'event_end_date'   => 'required|date|after_or_equal:event_start_date',

                    // Program Info
                    'faculty_id' => 'required|integer',
                    'department_id' => 'required|integer',
                    'program_id' => 'required|integer',

                    // Participation
                    'participation_target' => 'nullable|integer',
                    'number_of_students_participated' => 'nullable|integer',
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
                     // ✅ Convert checkbox array to JSON
                    $data['event_location'] = isset($data['event_location'])
                        ? json_encode($data['event_location'])
                        : null; 

                        

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
             return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {   try { 
            $data = [];
            if ($request->has('status_update_data')) {
                $record = StudentEngagementRate::findOrFail($id);
                
                $rules = [
                    // Engagement
                    'nature_of_event' => 'required|string',
                    'other_event_detail' => 'nullable|string',
                    'event_location' => 'nullable|array',
                    'scope_of_the_event' => 'nullable|string',

                    // Event Details
                    'title_of_the_event' => 'nullable|string',
                    'brief_description_of_activity' => 'nullable|string',
                    'event_start_date' => 'required|date',
                    'event_end_date'   => 'required|date|after_or_equal:event_start_date',

                    // Program Info
                    'faculty_id' => 'required|integer',
                    'department_id' => 'required|integer',
                    'program_id' => 'required|integer',

                    // Participation
                    'participation_target' => 'nullable|integer',
                    'number_of_students_participated' => 'nullable|integer',
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
                     // ✅ Convert checkbox array to JSON
                    $data['event_location'] = isset($data['event_location'])
                        ? json_encode($data['event_location'])
                        : null;

                    // ✅ If "Other" selected — override value
                    if ($request->nature_of_event != 'Other') {
                        $data['other_event_detail'] = null;
                    } 
                
                $data['updated_by'] = Auth::user()->employee_id;

                $record->update($data);

                return response()->json(['status' => 'success','message' => 'Record updated successfully', 'data' => $record]);
            }





            if ($request->has('status_update')) {
               
            }
        } catch (\Exception $e) {
             DB::rollBack();
             return response()->json(['message' => 'Oops! Something went wrong'], 500);
        }
    }
    // Destroy single or bulk records
    public function destroy($id)
    {
        $record = StudentEngagementRate::findOrFail($id);
        $record->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}
