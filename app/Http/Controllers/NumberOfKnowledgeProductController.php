<?php

namespace App\Http\Controllers;

use App\Models\NumberOfKnowledgeProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class NumberOfKnowledgeProductController extends Controller
{
    // 🔹 Index (Only show logged-in user records)
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $employee_id = $user->employee_id;

            $status = $request->input('status');

            // Default empty collection
            $forms = collect();

            if ($status == "HOD") {
                $forms = NumberOfKnowledgeProduct::where('created_by', $employee_id)
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
            return view('number_of_knowledge_products.index', compact('forms'));

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
            'product_type' => 'required|string',
            'url' => 'required|url',
            'attach_evidence' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $filePath = $request->file('attach_evidence')
            ->store('knowledge_products', 'public');

        NumberOfKnowledgeProduct::create([
            'indicator_id' => $request->indicator_id,
            'form_status' => $request->form_status,
            'product_type' => $request->product_type,
            'url' => $request->url,
            'attach_evidence' => $filePath,
            'created_by' => $userId,
            'updated_by' => $userId,
        ]);

        return back()->with('success', 'Number of Knowledge Product Added Successfully');
    }

    // 🔹 Edit (Check ownership)
    public function edit($id)
    {
        $product = NumberOfKnowledgeProduct::findOrFail($id);

        if ($product->created_by !== Auth::id()) {
            abort(403, 'Unauthorized Action');
        }

        return view('number_of_knowledge_products.edit', compact('product'));
    }

    // 🔹 Update (Check ownership)
    public function update(Request $request, $id)
    {
        $product = NumberOfKnowledgeProduct::findOrFail($id);

        if ($product->created_by !== Auth::id()) {
            abort(403, 'Unauthorized Action');
        }

        $request->validate([
            'product_type' => 'required|string',
            'url' => 'required|url',
            'attach_evidence' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'product_type' => $request->product_type,
            'url' => $request->url,
            'updated_by' => Auth::id(),
        ];

        if ($request->hasFile('attach_evidence')) {

            if (
                $product->attach_evidence &&
                Storage::disk('public')->exists($product->attach_evidence)
            ) {
                Storage::disk('public')->delete($product->attach_evidence);
            }

            $data['attach_evidence'] = $request->file('attach_evidence')
                ->store('knowledge_products', 'public');
        }

        $product->update($data);

        return redirect()->route('number-of-knowledge-products.index')
            ->with('success', 'Updated Successfully');
    }

    // 🔹 Destroy (Check ownership)
    public function destroy($id)
    {
        $product = NumberOfKnowledgeProduct::findOrFail($id);

        if ($product->created_by !== Auth::id()) {
            abort(403, 'Unauthorized Action');
        }

        if (
            $product->attach_evidence &&
            Storage::disk('public')->exists($product->attach_evidence)
        ) {
            Storage::disk('public')->delete($product->attach_evidence);
        }

        $product->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }

}
