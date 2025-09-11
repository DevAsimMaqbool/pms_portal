<?php

namespace App\Http\Controllers;

use App\Models\IndicatorForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndicatorFormController extends Controller
{
    public function index()
    {
        $forms = IndicatorForm::latest()->get();
        return response()->json($forms);
    }

    public function store(Request $request)
    {
        $request->validate([
            'indicator_id' => 'required|exists:indicators,id',
            'indicator_name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:indicator_forms,slug',
            'roles' => 'required|array'
        ]);

        $form = IndicatorForm::create([
            'indicator_id'   => $request->indicator_id,
            'indicator_name' => $request->indicator_name,
            'slug'           => $request->slug,
            'status'         => $request->status ?? '1',
            'created_by'     => Auth::id(),
            'updated_by'     => Auth::id(),
            'roles'          => $request->roles,
        ]);

        return response()->json(['success' => true, 'data' => $form]);
    }

    public function show($id)
    {
        $form = IndicatorForm::findOrFail($id);
        return response()->json($form);
    }

    public function update(Request $request, $id)
    {
        $form = IndicatorForm::findOrFail($id);

        $request->validate([
            'indicator_name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:indicator_forms,slug,' . $form->id,
            'roles' => 'required|array'
        ]);

        $form->update([
            'indicator_name' => $request->indicator_name,
            'slug'           => $request->slug,
            'status'         => $request->status ?? $form->status,
            'updated_by'     => Auth::id(),
            'roles'          => $request->roles,
        ]);

        return response()->json(['success' => true, 'data' => $form]);
    }

    public function destroy($id)
    {
        $form = IndicatorForm::findOrFail($id);
        $form->delete();

        return response()->json(['success' => true]);
    }
}
