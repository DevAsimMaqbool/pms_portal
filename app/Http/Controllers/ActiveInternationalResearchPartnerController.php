<?php

namespace App\Http\Controllers;

use App\Models\ActiveInternationalResearchPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ActiveInternationalResearchPartnerController extends Controller
{
    public function store(Request $request)
    {
        try { 
            
            if($request->form_status=='HOD'){
                 $rules = [
                    'indicator_id' => 'required',
                    'university_name' => 'required|string',
                    'country' => 'required|string',
                    'city' => 'required|city',
                    'signing_authorities' => 'required',
                    'duration_of_agreement' => 'required',
                    'outcome_timeline' => 'required',
                    'collaboration_scope' => 'required',
                    'contact_details' => 'required',
                    'projects_activities_planned' => '',
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

            $record = ActiveInternationalResearchPartner::create($data);
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
