<?php

namespace App\Http\Controllers;

use App\Models\Punctuality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PunctualityController extends Controller
{
     public function index(Request $request)
    {
         try {
            $user = Auth::user();
            $userId = Auth::id();
            $employee_id = $user->employee_id;

         if(in_array(getRoleName(activeRole()), ['Human Resources'])) {
                $status = $request->input('status');
                if($status=="HOD"){
                    $forms = Punctuality::with(['faculty', 'department', 'program'])
                        ->where('created_by', $employee_id)
                        ->orderBy('id', 'desc')
                        ->get();
                }       
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
                    'year' => 'required|string',
                    'faculty_id' => 'required|integer',
                    'department_id' => 'required|integer',
                    'program_id' => 'required|integer',
                    'program_level' => 'required|string',
                    'start_date'    => 'required',
                    'end_date'     => 'required',
                    'remarks'            => 'required|string',
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

            $record = Punctuality::create($data);
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
    {
       $record = Punctuality::findOrFail($id);

        $request->validate([
                'record_id' => 'required',
                'year' => 'required|string',
                'faculty_id' => 'required|integer',
                'department_id' => 'required|integer',
                'program_id' => 'required|integer',
                'program_level' => 'required|string',
                'start_date'    => 'required',
                'end_date'     => 'required',
                'remarks'            => 'required|string',
    
        ]);

        $data = $request->only([
                        'year','faculty_id','department_id','program_id','program_level', 'start_date', 'end_date', 'remarks'
                    ]);
                    $data['updated_by'] = Auth::user()->employee_id;

                    $record->update($data);

                    return response()->json(['status' => 'success','message' => 'Record updated successfully', 'data' => $record]);
    }

    /**
     * Remove the specified resource from storage.
     */
       public function destroy($id)
    {
        $record = Punctuality::findOrFail($id);

        $record->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}
