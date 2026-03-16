<?php

namespace App\Http\Controllers;

use App\Imports\AlumniSatisfactionRateImport;
use App\Models\AlumniSatisfactionRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AlumniSatisfactionRateController extends Controller
{
    // 🔹 Index (Only show logged-in user records)
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $status = $request->input('status');

            // Default empty collection
            $forms = collect();

            // If user role is HOD, get their created DropoutRate forms
            if ($status === 'HOD') {
                $forms = AlumniSatisfactionRate::with(['faculty', 'department', 'program', 'creator'])
                    ->where('created_by', $user->id)
                    ->orderBy('id', 'desc')
                    ->get();
            }

            // Return JSON for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'forms' => $forms
                ]);
            }

            // Return Blade view for normal requests
            return view('alumni_satisfaction_rate.index', compact('forms'));

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Oops! Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // 🔹 Store
    public function store(Request $request)
    {
        $userId = Auth::id();
        $request->validate([
            'indicator_id' => 'required|exists:indicators,id',
            'form_status' => 'required|string',
            'name' => 'required',
            'gender' => 'required',
            'faculty_id' => 'required',
            'department_id' => 'required',
            'program_id' => 'required',
            'program_level'=>'required',
            'roll_no' => 'required|unique:alumni_satisfaction_rates,roll_no',
            'graduation_year' => 'required',
            'current_organization' => 'required',
            'current_designation' => 'required',
            'current_salary' => 'required',
            'email' => 'required',
            'satisfaction_rate' => 'required',
        ]);

        AlumniSatisfactionRate::create([
            'indicator_id' => $request->indicator_id,
            'form_status' => $request->form_status,
            'name' => $request->name,
            'gender' => $request->gender,
            'faculty_id' => $request->faculty_id,
            'department_id' => $request->department_id,
            'program_id' => $request->program_id,
            'program_level' => $request->program_level,
            'roll_no' => $request->roll_no,
            'graduation_year' => $request->graduation_year,
            'current_organization' => $request->current_organization,
            'current_designation' => $request->current_designation,
            'current_salary' => $request->current_salary,
            'email' => $request->email,
            'satisfaction_rate' => $request->satisfaction_rate,
            'created_by' => $userId,
            'updated_by' => $userId,
        ]);

        return back()->with('success', 'Added Successfully');
    }

    // 🔹 Edit (Check ownership)
    public function edit($id)
    {
        $product = AlumniSatisfactionRate::findOrFail($id);

        if ($product->created_by !== Auth::id()) {
            abort(403, 'Unauthorized Action');
        }

        return view('alumni_satisfaction_rate.edit', compact('product'));
    }

    // 🔹 Update (Check ownership)
    public function update(Request $request, $id)
    {
        $product = AlumniSatisfactionRate::findOrFail($id);

        if ($product->created_by !== Auth::id()) {
            abort(403, 'Unauthorized Action');
        }

        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'faculty_id' => 'required',
            'department_id' => 'required',
            'program_id' => 'required',
            'program_level'=>'required',
            'roll_no' => 'required|unique:alumni_satisfaction_rates,roll_no,' . $id,
            'graduation_year' => 'required',
            'current_organization' => 'required',
            'current_designation' => 'required',
            'current_salary' => 'required',
            'email' => 'required',
            'satisfaction_rate' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'gender' => $request->gender,
            'faculty_id' => $request->faculty_id,
            'department_id' => $request->department_id,
            'program_id' => $request->program_id,
            'program_level' => $request->program_level,
            'roll_no' => $request->roll_no,
            'graduation_year' => $request->graduation_year,
            'current_organization' => $request->current_organization,
            'current_designation' => $request->current_designation,
            'current_salary' => $request->current_salary,
            'email' => $request->email,
            'satisfaction_rate' => $request->satisfaction_rate,
            'updated_by' => Auth::id(),
        ];

        $product->update($data);

        return redirect()->route('alumni-satisfaction-rate.index')
            ->with('success', 'Updated Successfully');
    }

    // 🔹 Destroy (Check ownership)
    public function destroy($id)
    {
        $product = AlumniSatisfactionRate::findOrFail($id);

        if ($product->created_by !== Auth::id()) {
            abort(403, 'Unauthorized Action');
        }

        $product->delete();

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
            new AlumniSatisfactionRateImport(
                $request->indicator_id,
                $request->form_status
            ),
            $request->file
        );

        return response()->json([
            'message' => 'Admission Target data imported successfully'
        ]);
    }

}
