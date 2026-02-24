<?php

namespace App\Http\Controllers;

use App\Imports\ProgramProfitabilityImport;
use App\Models\ProgramProfitability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ProgramProfitabilityController extends Controller
{
     public function index(Request $request)
    {
         try {
            $user = Auth::user();
            $userId = Auth::id();
            $employee_id = $user->employee_id;

                $status = $request->input('status');
                if($status=="HOD"){
                        $forms = ProgramProfitability::with(['faculty', 'department', 'program'])
                        ->where('created_by', $employee_id)
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
            
            if($request->form_status=='HOD'){
                 $rules = [
                    'indicator_id' => 'required',
                    'faculty_id'     => 'required|integer',
                    'department_id'     => 'required|integer',
                    'program_id'     => 'required|integer',
                    'program_level'  => 'required|in:UG,PG',
                    'profitability' => 'nullable|numeric',
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
    public function update(Request $request, $id)
    {   try { 
            $data = [];
            if ($request->has('status_update_data')) {
                $record = ProgramProfitability::findOrFail($id);
                
                $rules = [
                    'department_id'     => 'required|integer',
                    'program_id'     => 'required|integer',
                    'program_level'  => 'required|in:UG,PG',
                    'profitability' => 'nullable|numeric',
                ];


                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                        }
                    
                    $data = $validator->validated(); 
                    

                
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
        $record = ProgramProfitability::findOrFail($id);
        $record->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'indicator_id' => 'required',
            'form_status' => 'required',
        ]);

        Excel::import(
            new ProgramProfitabilityImport(
                $request->indicator_id,
                $request->form_status
            ),
            $request->file
        );

        return response()->json([
            'message' => 'Program Profitability data imported successfully'
        ]);
    }
}
