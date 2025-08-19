<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\User;
use Illuminate\Http\Request;

class AssignFormToUserController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::limit(10)->get();
        $forms = Form::all();
        return view('admin.form.assign_form', compact('users', 'forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::limit(10)->get();
        $forms = Form::all();
        return view('admin.form.assign_form', compact('users', 'forms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        foreach ($request->users as $userId) {
            $user = User::find($userId);
            $user->forms()->syncWithoutDetaching($request->forms); // attaches only new ones
        }
        return response()->json(['message' => 'Forms assigned successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id, $slug)
    {
        $form = Form::where('title', $slug)->with('fields')->firstOrFail();
        return view('admin.form.form_show', ['form' => $form, 'id' => $id]);
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

    public function view($userId, $title)
    {
        $form = Form::with('fields')->where('title', $title)->firstOrFail();
        return view('admin.form.partials._form_fields', compact('form', 'userId'));
    }

    public function showAssignedFormDropdown()
    {
        $user = User::with('forms')->findOrFail(1318);
        $forms = $user->forms;
        return view('admin.form.show_assigned_form', compact('forms'));
    }
}

