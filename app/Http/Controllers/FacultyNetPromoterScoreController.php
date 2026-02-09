<?php

namespace App\Http\Controllers;

use App\Models\FacultyNetPromoterScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FacultyNetPromoterScoreController extends Controller
{
    public function store(Request $request)
    {
        try { 
            
            if($request->form_status=='HOD'){
                 $rules = [
                    'indicator_id' => 'required',
                    'total_faculty_surveyed' => 'nullable|integer|min:0',
                    'number_of_promoters'    => 'nullable|integer|min:0',
                    'number_of_passives'     => 'nullable|integer|min:0',
                    'number_of_detractors'   => 'nullable|integer|min:0',

                    'evidence_reference' => 'nullable|string|max:255',
                    'remarks'            => 'nullable|string',

                    'promoters_percentage'  => 'nullable|numeric',
                    'detractors_percentage' => 'nullable|numeric',
                    'net_promoter_score'    => 'nullable|numeric',
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

            $record = FacultyNetPromoterScore::create($data);
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
