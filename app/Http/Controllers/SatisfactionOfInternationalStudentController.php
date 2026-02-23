<?php

namespace App\Http\Controllers;

use App\Models\SatisfactionOfInternationalStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SatisfactionOfInternationalStudentController extends Controller
{

    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $employee_id = $user->employee_id;
            if(in_array(getRoleName(activeRole()), ['International Office'])){
                $status = $request->input('status');
                if($status=="HOD"){
                    $forms = SatisfactionOfInternationalStudent::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            }
                        ])->where('created_by', $employee_id)
                        ->orderBy('id', 'desc')
                        ->get();
                }       
            }
            if(in_array(getRoleName(activeRole()), ['QEC'])) {
                $status = $request->input('status');
                if($status=="HOD"){
                    $forms = SatisfactionOfInternationalStudent::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            }
                        ])->orderBy('id', 'desc')
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

            if ($request->form_status == 'HOD') {
                $rules = [
                    'indicator_id' => 'required',
                    'student_name' => 'required|string|max:255',
                    'student_roll_no' => 'required|string|max:255',
                    'student_program' => 'required|string|max:255',
                    'student_country' => 'required|string|max:255',
                    'student_semester' => 'required|string|max:255',
                    'score' => 'required|numeric|min:0|max:5',
                    'student_comments' => '',
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
            $data['student_rating'] = $request->score * 20;
            $data['created_by'] = $employeeId;
            $data['updated_by'] = $employeeId;

            $record = SatisfactionOfInternationalStudent::create($data);
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
        try {
            if ($request->has('status_update_data')) {
                $product = SatisfactionOfInternationalStudent::findOrFail($id);

                $request->validate([
                    'student_name' => 'required|string|max:255',
                    'student_roll_no' => 'required|string|max:255',
                    'student_program' => 'required|string|max:255',
                    'student_country' => 'required|string|max:255',
                    'student_semester' => 'required|string|max:255',
                    'score' => 'required|numeric|min:0|max:5',
                    'student_comments' => '',
                ]);

                $data = [
                    'student_name' => $request->student_name,
                    'student_roll_no' => $request->student_roll_no,
                    'student_program' => $request->student_program,
                    'student_country' => $request->student_country,
                    'student_semester' => $request->student_semester,
                    'student_rating' => $request->score * 20,
                    'student_comments' => $request->student_comments,
                    'updated_by' => Auth::id(),
                ];

                $product->update($data);

                
                return response()->json(['status' => 'success','message' => 'Record updated successfully', 'data' => $product]);
            }
            if ($request->has('status_update')) {
                $request->validate([
                    'status' => 'required|in:1,2,3,4,5,6'
                ]);

                $target = SatisfactionOfInternationalStudent::findOrFail($id);

                // Get current update history
                $history = $target->update_history ? json_decode($target->update_history, true) : [];

                // Get current user info
                $currentUserId = Auth::id();
                $currentUserName = Auth::user()->name;
                $userRoll = getRoleName(activeRole()) ?? 'N/A';

                // Avoid duplicate consecutive updates by the same user with the same status
                $lastUpdate = end($history);
                if (!$lastUpdate || $lastUpdate['user_id'] != $currentUserId || $lastUpdate['status'] != $request->status) {
                    $history[] = [
                        'user_id'    => $currentUserId,
                        'user_name'  => $currentUserName,
                        'status'     => $request->status,
                        'role'     => $userRoll,
                        'updated_at' => now()->toDateTimeString(),
                    ];
                }





                $target->status = $request->status;
                $target->update_history = json_encode($history);
                $target->updated_by = $currentUserId;
                $target->save();

                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // 🔹 Destroy (Check ownership)
    public function destroy($id)
    {
        $product = SatisfactionOfInternationalStudent::findOrFail($id);

        if ($product->created_by !== Auth::id()) {
            abort(403, 'Unauthorized Action');
        }

        $product->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}
