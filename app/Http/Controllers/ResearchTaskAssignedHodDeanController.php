<?php

namespace App\Http\Controllers;

use App\Models\ResearchTaskAssignedHodDean;
use App\Models\ResearchTaskAssignedHodDeanTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ResearchTaskAssignedHodDeanController extends Controller
{
    public function index(Request $request)
    {
         try {
            $user = Auth::user();
            $userId = Auth::id();
            $employee_id = $user->employee_id;

                $status = $request->input('status');
                if($status=="OTHER"){
                        $forms = ResearchTaskAssignedHodDean::with(['tasks','year'])->where('created_by', $employee_id)
                        ->where('form_status', $status)
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
            
               $employeeId = Auth::user()->employee_id;
               $rules = [
                        'indicator_id' => 'required|integer',
                        'employee_id' => 'required|integer',
                        'year_id' => 'required',
                        'kpa_category' => '',
                        'linemanager' => 'required|array|min:1',
                        'linemanager.*.task' => 'required|string',
                        'linemanager.*.linemanager_rating' => 'required',
                        'remarks' => 'required',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];

                    $messages = [
                        'linemanager.*.task.required' => 'Task is required',
                        'linemanager.*.linemanager_rating.required' => 'Rating is required',
                    ];
                

                    $validator = Validator::make($request->all(), $rules, $messages);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                        }
                    // Create main record
                    $lineManagerReview = ResearchTaskAssignedHodDean::create([
                        'indicator_id' => $request->indicator_id,
                        'employee_id' => $request->employee_id,
                        'year_id' => $request->year_id,
                        'kpa_category' => $request->kpa_category,
                        'remarks' => $request->remarks,
                        'form_status' => $request->form_status,
                        'created_by' => $employeeId,
                        'updated_by' => $employeeId,
                    ]);    
                    // Insert tasks and ratings into mid table
                    foreach ($request->linemanager as $item) {
                        ResearchTaskAssignedHodDeanTask::create([
                            'research_task_assigned_hod_dean_id' => $lineManagerReview->id,
                            'task' => $item['task'],
                            'linemanager_rating' => $item['linemanager_rating'],
                        ]);
                    }

                       

            return response()->json([
                'status' => 'success',
                'message' => 'Record saved successfully',
                'data' => $lineManagerReview
            ]);

        } catch (\Exception $e) {
             DB::rollBack();
             return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function update(Request $request, $id)
{
    DB::beginTransaction();

    try {

        $rules = [
            'employee_id' => 'required|integer',
            'year_id' => 'required',
            'kpa_category' => '',
            'linemanager' => 'required|array|min:1',
            'linemanager.*.task' => 'required|string',
            'linemanager.*.linemanager_rating' => 'required',
            'remarks' => 'nullable|string'
        ];

        Validator::validate($request->all(), $rules);

        $review = ResearchTaskAssignedHodDean::findOrFail($id);

        // ✅ Update parent
        $review->update([
            'employee_id' => $request->employee_id,
            'year_id' => $request->year_id,
            'kpa_category' => $request->kpa_category,
            'remarks' => $request->remarks,
            'updated_by' => Auth::user()->employee_id
        ]);

        // ✅ Sync child tasks
        $review->tasks()->delete();

        foreach ($request->linemanager as $row) {

            $review->tasks()->create([
                'task' => $row['task'],
                'linemanager_rating' => $row['linemanager_rating']
            ]);
        }

        DB::commit();

        return response()->json([
            'message' => 'Updated Successfully'
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'message' => 'Update Failed',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function destroy($id)
{
    // Delete main line-manager-review record
    $record = ResearchTaskAssignedHodDean::findOrFail($id);

    // Delete related tasks (assuming tasks are in separate table)
    $record->tasks()->delete();

    $record->delete();

    return response()->json([
        'message' => 'Record deleted successfully from both tables!'
    ]);
}
//  public function import(Request $request)
//     {
//         $request->validate([
//             'file' => 'required|mimes:xlsx,xls,csv',
//             'indicator_id' => 'required',
//             'form_status' => 'required',
//         ]);

//         Excel::import(
//             new LineManagerReviewRatingImport(
//                 $request->indicator_id,
//                 $request->form_status
//             ),
//             $request->file
//         );

//         return response()->json([
//             'message' => 'Imported successfully'
//         ]);
//     }
}
