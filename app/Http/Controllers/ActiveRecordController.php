<?php

namespace App\Http\Controllers;

use App\Models\ActiveRecord;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActiveRecordController extends Controller
{
   public function index()
    {
        $activerecord = ActiveRecord::with('year')->orderByDesc('id')->get();
        $activeTerms = Term::where('status', '1')->get();

        return view('admin.activerecord.index', compact(['activerecord','activeTerms']));
    }


    public function create()
    {
        return view('admin.activerecord.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'year_id' => [
                'required',
            ],'description'=>'required',
            'term_spring_id'=>'required',
            'term_fall_id'=>'required'
        ]);

        ActiveRecord::create([
            'year_id'       => $validated['year_id'],
            'description'       => $validated['description'],
            'term_spring_id'       => $validated['term_spring_id'],
            'term_fall_id'       => $validated['term_fall_id'],
            'status'     => 0,
            'status_year'     => 0,
            'status_spring'     => 0,
            'status_fall'     => 0,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Year created successfully.',
        ]);
    }


    public function show(ActiveRecord $year)
    {
        return response()->json([
            'status' => true,
            'data' => $year,
        ]);
    }


    public function edit($id)
    {
        $year = ActiveRecord::findOrFail($id);
        return response()->json([
            'status' => true,
            'data' => $year,
        ]);
    }


    public function update(Request $request,$id)
    {
        $year = ActiveRecord::findOrFail($id);
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


    public function destroy(ActiveRecord $year)
    {
        $year->delete();

        return response()->json([
            'status' => true,
            'message' => 'Year deleted successfully.',
        ]);
    }
    public function updateStatus(Request $request, $id)
    {
        $year = ActiveRecord::findOrFail($id);

        $active = (int) $request->active;

        if ($active == 1) {

            // Make all other years inactive
            ActiveRecord::where('id', '!=', $id)
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
