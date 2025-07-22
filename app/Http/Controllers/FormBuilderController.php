<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class FormBuilderController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $faculties = Form::with('departments.programs')->select('id', 'name')->get();

            if ($request->ajax()) {
                return response()->json(['faculties' => $faculties]);
            }

            return view('admin.faculty_department_program');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.form.create_form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $form = Form::create(['title' => $request->title]);

        foreach ($request->fields as $field) {
            $form->fields()->create([
                'label' => $field['label'],
                'name' => $field['name'],
                'type' => $field['type'],
                'required' => isset($field['required']),
                'options' => in_array($field['type'], ['select', 'radio', 'checkbox'])
                    ? json_encode($field['options'])
                    : null,
            ]);
        }

        return redirect()->route('forms.create')->with('success', 'Form created!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id, $slug)
    {
        $form = Form::where('title', $slug)->with('fields')->firstOrFail();
        return view('admin.form.form_show', ['form' => $form,'id'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Form $form)
    {
        $form->load('fields'); // Load fields
        return view('admin.form.edit_form', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Form $form)
    {
        $form->update(['title' => $request->title]);

        // Remove old fields and re-create from scratch
        $form->fields()->delete();

        foreach ($request->fields as $field) {
            $form->fields()->create([
                'label' => $field['label'],
                'name' => $field['name'],
                'type' => $field['type'],
                'required' => isset($field['required']),
                'options' => in_array($field['type'], ['select', 'radio', 'checkbox'])
                    ? json_encode($field['options'])
                    : null,
            ]);
        }

        return redirect()->route('forms.edit', $form->id)->with('success', 'Form updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
    }
}
