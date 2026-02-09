<?php

namespace App\Http\Controllers;

use App\Models\ProgramProfitability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProgramProfitabilityController extends Controller
{
    public function store(Request $request)
    {
        try { 
            
            if($request->form_status=='HOD'){
                 $rules = [
                    'indicator_id' => 'required',
                    'financial_year' => 'nullable|date',
                    'faculty_id'     => 'required|integer',
                    'program_id'     => 'required|integer',
                    'program_level'  => 'required|in:UG,PG',

                    'total_program_income' => 'nullable|numeric',
                    'faculty_cost'         => 'nullable|numeric',
                    'facilities_cost'      => 'nullable|numeric',
                    'materials_cost'       => 'nullable|numeric',
                    'support_services_cost'=> 'nullable|numeric',
                    'other_costs'          => 'nullable|numeric',

                    'evidence_reference' => 'nullable|string|max:255',
                    'remarks'            => 'nullable|string',

                    'total_cost_of_delivery'      => 'nullable|numeric',
                    'net_program_surplus_deficit' => 'nullable|numeric',
                    'program_profitability_status'=> 'nullable|string',
                    'profitability_percentage'    => 'nullable|numeric',

                    'total_programs_assessed'        => 'nullable|integer',
                    'number_of_profitable_programs' => 'nullable|integer',
                    'proportion_of_profitable_programs' => 'nullable|numeric',
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

            $record = ProgramProfitability::create($data);
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
