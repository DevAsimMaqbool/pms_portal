<?php

namespace App\Http\Controllers;

use App\Models\RatingRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingRuleController extends Controller
{
    public function index()
    {
        return view('admin.table.rating-rules');
    }
    public function fetch()
    {
        return response()->json(RatingRule::orderBy('min_percentage','desc')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'min_percentage' => 'required|integer|lte:max_percentage',
            'max_percentage' => 'required|integer|gte:min_percentage',
            'rating'         => 'required|string',
            'description'    => 'nullable|string',
            'color'          => 'required|string',
        ]);

        $employeeId = Auth::user()->employee_id; // login user employee_id

        RatingRule::create([
            'min_percentage' => $request->min_percentage,
            'max_percentage' => $request->max_percentage,
            'rating'         => $request->rating,
            'description'    => $request->description,
            'color'          => $request->color,
            'created_by'     => $employeeId,   
            'updated_by'     => $employeeId,      // <-- set the logged-in employee
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Rating Rule added successfully'
        ]);
    }


    public function edit($id)
    {
        return response()->json(RatingRule::find($id));
    }

   public function update(Request $request, $id)
    {
        $request->validate([
            'min_percentage' => 'required|integer|lte:max_percentage',
            'max_percentage' => 'required|integer|gte:min_percentage',
            'rating'         => 'required|string',
            'description'    => 'nullable|string',
            'color'          => 'required|string',
        ]);

        $employeeId = Auth::user()->employee_id; // logged-in user employee_id

        $rule = RatingRule::findOrFail($id);

        $rule->update([
            'min_percentage' => $request->min_percentage,
            'max_percentage' => $request->max_percentage,
            'rating'         => $request->rating,
            'description'    => $request->description,
            'color'          => $request->color,
            'updated_by'     => $employeeId,        // <-- set the logged-in employee
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Rating Rule updated successfully'
        ]);
    }


    public function delete($id)
    {
        RatingRule::destroy($id);
        return response()->json(['status' => 'success', 'message' => 'Rating Rule deleted']);
    }

    // GET RATING BY PERCENTAGE
    public function getRating($percentage)
    {
        $rule = RatingRule::where('min_percentage', '<=', $percentage)
            ->where('max_percentage', '>=', $percentage)
            ->first();

        if (!$rule) {
            return response()->json(['rating' => 'NA', 'color' => '#000000']);
        }

        return response()->json($rule);
    }
}
