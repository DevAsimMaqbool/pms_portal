<?php

namespace App\Http\Controllers;

use App\Models\DropoutRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DropoutRateController extends Controller
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
                $forms = DropoutRate::with(['faculty', 'department', 'program', 'creator'])
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
            return view('dropout_rate.index', compact('forms'));

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
            'faculty_id' => 'required',
            'department_id' => 'required',
            'program_id' => 'required',
            'dropout_rate' => 'required',
        ]);

        DropoutRate::create([
            'indicator_id' => $request->indicator_id,
            'form_status' => $request->form_status,
            'faculty_id' => $request->faculty_id,
            'department_id' => $request->department_id,
            'program_id' => $request->program_id,
            'dropout_rate' => $request->dropout_rate,
            'created_by' => $userId,
            'updated_by' => $userId,
        ]);

        return back()->with('success', 'Added Successfully');
    }

    // 🔹 Edit (Check ownership)
    public function edit($id)
    {
        $product = DropoutRate::findOrFail($id);

        if ($product->created_by !== Auth::id()) {
            abort(403, 'Unauthorized Action');
        }

        return view('dropout_rate.edit', compact('product'));
    }

    // 🔹 Update (Check ownership)
    public function update(Request $request, $id)
    {
        $product = DropoutRate::findOrFail($id);

        if ($product->created_by !== Auth::id()) {
            abort(403, 'Unauthorized Action');
        }

        $request->validate([
            'faculty_id' => 'required',
            'department_id' => 'required',
            'program_id' => 'required',
            'dropout_rate' => 'required',
        ]);

        $data = [
            'faculty_id' => $request->faculty_id,
            'department_id' => $request->department_id,
            'program_id' => $request->program_id,
            'dropout_rate' => $request->dropout_rate,
            'updated_by' => Auth::id(),
        ];

        $product->update($data);

        return redirect()->route('dropout-rate.index')
            ->with('success', 'Updated Successfully');
    }

    // 🔹 Destroy (Check ownership)
    public function destroy($id)
    {
        $product = DropoutRate::findOrFail($id);

        if ($product->created_by !== Auth::id()) {
            abort(403, 'Unauthorized Action');
        }

        $product->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }

}
