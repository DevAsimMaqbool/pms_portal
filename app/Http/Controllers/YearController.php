<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Years;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class YearController extends Controller
{
    public function index()
    {
        $years = Years::orderByDesc('year')->get();

        return view('admin.years.index', compact('years'));
    }


    public function create()
    {
        return view('admin.years.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => [
                'required',
                'integer',
                'min:1900',
                'max:9999',
                'unique:years,year',
            ],
        ]);

        Years::create([
            'year'       => $validated['year'],
            'active'     => 0,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Year created successfully.',
        ]);
    }


    public function show(Years $year)
    {
        return response()->json([
            'status' => true,
            'data' => $year,
        ]);
    }


    public function edit($id)
    {
        $year = Years::findOrFail($id);
        return response()->json([
            'status' => true,
            'data' => $year,
        ]);
    }


    public function update(Request $request,$id)
    {
        $year = Years::findOrFail($id);
        $validated = $request->validate([
            'year' => [
                'required',
                'integer',
                'min:1900',
                'max:9999',
                Rule::unique('years', 'year')->ignore($year->id),
            ]
        ]);

        $year->update([
            'year'       => $validated['year'],
            'updated_by' => Auth::id(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Year updated successfully.',
        ]);
    }


    public function destroy(Years $year)
    {
        $year->delete();

        return response()->json([
            'status' => true,
            'message' => 'Year deleted successfully.',
        ]);
    }
    public function updateStatus(Request $request, $id)
    {
        $year = Years::findOrFail($id);

        $active = (int) $request->active;

        if ($active == 1) {

            // Make all other years inactive
            Years::where('id', '!=', $id)
                ->update([
                    'active'     => 0,
                    'updated_by' => Auth::id(),
                ]);

            // Make selected year active
            $year->update([
                'active'     => 1,
                'updated_by' => Auth::id(),
            ]);

        } else {

            // Make selected year inactive
            $year->update([
                'active'     => 0,
                'updated_by' => Auth::id(),
            ]);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Year status updated successfully.',
            'active'  => (bool) $year->active,
        ]);
    }
}
