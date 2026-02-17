<?php

namespace App\Http\Controllers;

use App\Models\FacultyNetPromoterScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FacultyNetPromoterScoreController extends Controller
{
    public function index(Request $request)
    {
         try {
            $user = Auth::user();
            $userId = Auth::id();
            $employee_id = $user->employee_id;

         if ($user->hasRole('HOD')) {
                $status = $request->input('status');
                if($status=="HOD"){
                    $forms = FacultyNetPromoterScore::where('created_by', $employee_id)
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
                    'total_faculty_surveyed'    => 'required|integer|min:0',
                    'number_of_promoters'     => 'required|integer|min:0',
                    'promoters_percentage'   => 'required|integer|min:0',
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
    public function update(Request $request, $id)
    {
       $record = FacultyNetPromoterScore::findOrFail($id);

        $request->validate([
                'record_id' => 'required',
                'year' => 'required|string',
                'total_faculty_surveyed'    => 'required|integer|min:0',
                'number_of_promoters'     => 'required|integer|min:0',
                'promoters_percentage'   => 'required|integer|min:0',
                'remarks'            => 'required|string',
    
        ]);

        $data = $request->only([
                        'year', 'total_faculty_surveyed', 'number_of_promoters', 'promoters_percentage', 'remarks',
                        'graduate_satisfaction'
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
        $record = FacultyNetPromoterScore::findOrFail($id);

        $record->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}
