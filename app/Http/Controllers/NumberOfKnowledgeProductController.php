<?php

namespace App\Http\Controllers;

use App\Models\NumberOfKnowledgeProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NumberOfKnowledgeProductController extends Controller
{
    public function store(Request $request)
    {
        try { 
            
            if($request->form_status=='RESEARCHER'){
                 $rules = [
                    'indicator_id' => 'required',
                    'product_type' => 'required',
                    'total_products' => 'required|integer|min:0',
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

            $record = NumberOfKnowledgeProduct::create($data);
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
