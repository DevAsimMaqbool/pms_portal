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

            $status = $request->input('status');

            // Default empty collection
            $forms = collect();

            if ($status == "HOD") {
                $forms = SatisfactionOfInternationalStudent::where('created_by', $employee_id)
                    ->orderBy('id', 'desc')
                    ->get();
            }

            // Always return JSON if AJAX
            if ($request->ajax()) {
                return response()->json([
                    'forms' => $forms
                ]);
            }

            // Optionally, return Blade view for non-AJAX request
            return view('satisfaction_of_international_students.index', compact('forms'));

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
        $product = SatisfactionOfInternationalStudent::findOrFail($id);

        if ($product->created_by !== Auth::id()) {
            abort(403, 'Unauthorized Action');
        }

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

        return redirect()->route('international-st-satisfaction.index')
            ->with('success', 'Updated Successfully');
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
