<?php

namespace App\Http\Controllers;

use App\Models\SpinOff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SpinOffController extends Controller
{
    public function store(Request $request)
    {
        try { 
            if($request->form_status=='RESEARCHER'){
                 $rules = [
                        'kpa_id' => 'required',
                        'sp_category_id' => 'required',
                        'indicator_id' => 'required',
                        'name_of_faculty_member' => 'required|string',
                        'spin_off_form_submission' => 'required|string',
                        'work_plan_for_the_spin_off' => 'required|string',
                        'name_of_pre_spin_off' => 'required|string',
                        'annual_revenue_generated' => 'required|string',
                        'rev_current_financial_year' => 'required|string',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];

                    
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                        }

                        $data = $request->only([
                            'kpa_id',
                            'sp_category_id',
                            'indicator_id',
                            'name_of_faculty_member',
                            'spin_off_form_submission',
                            'status_of_spin_off_feasibility',
                            'work_plan_for_the_spin_off',
                            'name_of_pre_spin_off',
                            'total_revenue_generated',
                            'annual_revenue_generated',
                            'rev_current_financial_year',
                            'form_status'
                        ]);

            }
            if($request->form_status=='Dean'){
                  $rules = [
                        'kpa_id' => 'required',
                        'sp_category_id' => 'required',
                        'indicator_id' => 'required',
                        'target_of_new_spin_offs',
                        'target_of_pre_spin_offs',
                        'name_of_lead_faculty_member',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];


                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                        }
                    $data = $request->only([
                            'kpa_id',
                            'sp_category_id',
                            'indicator_id',
                            'target_of_new_spin_offs',
                            'target_of_pre_spin_offs',
                            'name_of_lead_faculty_member',
                            'form_status'
                        ]);    

            }
            $employeeId = Auth::user()->employee_id;
            $data['created_by'] = $employeeId;
            $data['updated_by'] = $employeeId;

            $record = SpinOff::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Record saved successfully',
                'data' => $record
            ]);

        } catch (\Exception $e) {
                return response()->json([
                        'status'  => 'error',
                        'message' => 'Something went wrong: ' . $e->getMessage(),], 500);
        }
    }
}
