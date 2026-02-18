<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\LineManagerReviewRating;
use App\Models\LineManagerReviewRatingTask;

class LineManagerReviewRatingController extends Controller
{
    public function index(Request $request)
    {
         try {
            $user = Auth::user();
            $userId = Auth::id();
            $employee_id = $user->employee_id;

                $status = $request->input('status');
                if($status=="HOD"){
                        $forms = LineManagerReviewRating::with('tasks')->where('created_by', $employee_id)
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
                        'year' => 'required|string',
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
                    $lineManagerReview = LineManagerReviewRating::create([
                        'indicator_id' => $request->indicator_id,
                        'employee_id' => $request->employee_id,
                        'year' => $request->year,
                        'remarks' => $request->remarks,
                        'form_status' => $request->form_status,
                        'created_by' => $employeeId,
                        'updated_by' => $employeeId,
                    ]);    
                    // Insert tasks and ratings into mid table
                    foreach ($request->linemanager as $item) {
                        LineManagerReviewRatingTask::create([
                            'line_manager_review_rating_id' => $lineManagerReview->id,
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
            'year' => 'required|string',
            'linemanager' => 'required|array|min:1',
            'linemanager.*.task' => 'required|string',
            'linemanager.*.linemanager_rating' => 'required',
            'remarks' => 'nullable|string'
        ];

        Validator::validate($request->all(), $rules);

        $review = LineManagerReviewRating::findOrFail($id);

        // ✅ Update parent
        $review->update([
            'employee_id' => $request->employee_id,
            'year' => $request->year,
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
    $record = LineManagerReviewRating::findOrFail($id);

    // Delete related tasks (assuming tasks are in separate table)
    $record->tasks()->delete();

    $record->delete();

    return response()->json([
        'message' => 'Record deleted successfully from both tables!'
    ]);
}


}
