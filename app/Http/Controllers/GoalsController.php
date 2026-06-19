<?php

namespace App\Http\Controllers;

use App\Models\Dimension;
use App\Models\Goal;
use App\Models\Objective;
use App\Models\S2RDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

class GoalsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $goals = Goal::with('driver')->select('goals.*');

            return DataTables::of($goals)

                ->addIndexColumn()

                ->addColumn('driver_name', function ($row) {
                    return $row->driver?->driver_name ?? '-';
                })

                ->addColumn('action', function ($row) {

                    return '
                        <a href="'.route('goals.edit',$row->id).'"
                        class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <button
                            class="btn btn-sm btn-danger deleteGoal"
                            data-id="'.$row->id.'">
                            Delete
                        </button>
                    ';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.goals.index');
    }

    public function create()
    {
        $drivers = S2RDriver::all();

        return view('admin.goals.create', compact('drivers'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'goal_name' => 'required|string|max:255|unique:goals,goal_name',
            'goal_cod' => 'required|string|max:255|unique:goals,goal_cod',
            's2r_driver_id' => 'required|exists:s2_r_drivers,id',
            'goal_statement' => 'required|string',

            'objectives' => 'required|array|min:1',

            'objectives.*.title' => 'required|string|max:255',
            'objectives.*.objective_cod' => 'required|string|max:255',

            'objectives.*.dimensions.*.name' => 'required|string|max:255',
            'objectives.*.dimensions.*.dimension_cod' => 'required|string|max:255',
        ], [
            'goal_name.required' => 'Goal Name is required.',
            'goal_cod.required' => 'Goal Code is required.',
            'goal_cod.unique' => 'Goal Code already exists.',

            's2r_driver_id.required' => 'S2R Driver is required.',
            's2r_driver_id.exists' => 'Selected Driver is invalid.',

            'goal_statement.required' => 'Goal Statement is required.',

            'objectives.required' => 'At least one Objective is required.',
            'objectives.min' => 'At least one Objective is required.',

            'objectives.*.title.required' => 'Objective Title is required.',
            'objectives.*.objective_cod.required' => 'Objective Code is required.',

            'objectives.*.dimensions.*.name.required' => 'Dimension Name is required.',
            'objectives.*.dimensions.*.dimension_cod.required' => 'Dimension Code is required.',
        ]);
        DB::beginTransaction();

        try {

            $goal = Goal::create([
                'goal_name' => $request->goal_name,
                'goal_cod' => $request->goal_cod,
                's2r_driver_id' => $request->s2r_driver_id,
                'goal_statement' => $request->goal_statement,
            ]);

            foreach ($request->objectives ?? [] as $objectiveData) {

                $objective = Objective::create([
                    'goal_id' => $goal->id,
                    'title' => $objectiveData['title'],
                    'objective_cod' => $objectiveData['objective_cod']
                ]);

                foreach ($objectiveData['dimensions'] ?? [] as $dimensionData) {

                    Dimension::create([
                        'objective_id' => $objective->id,
                        'name' => $dimensionData['name'],
                        'dimension_cod' => $dimensionData['dimension_cod'],
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function edit($id)
    {
        $goal = Goal::with('objectives.dimensions')->findOrFail($id);
        $drivers = S2RDriver::all();

        return view('admin.goals.edit', compact('goal', 'drivers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'goal_name' => [
                'required',
                'max:255',
                Rule::unique('goals', 'goal_name')->ignore($id)
            ],

            'goal_cod' => [
                'required',
                'max:255',
                Rule::unique('goals', 'goal_cod')->ignore($id)
            ],

            's2r_driver_id' => 'required|exists:s2_r_drivers,id',
            'goal_statement' => 'required|string',

            'objectives' => 'required|array|min:1',

            'objectives.*.title' => 'required|string|max:255|distinct',
            'objectives.*.objective_cod' => 'required|string|max:255|distinct',

            'objectives.*.dimensions.*.name' => 'required|string|max:255',
            'objectives.*.dimensions.*.dimension_cod' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {

            $goal = Goal::findOrFail($id);

            $goal->update([
                'goal_name' => $request->goal_name,
                'goal_cod' => $request->goal_cod,
                's2r_driver_id' => $request->s2r_driver_id,
                'goal_statement' => $request->goal_statement,
            ]);

            // DELETE OLD CHILD DATA
            $goal->objectives()->delete();

            foreach ($request->objectives as $objectiveData) {

                $objective = Objective::create([
                    'goal_id' => $goal->id,
                    'title' => $objectiveData['title'],
                    'objective_cod' => $objectiveData['objective_cod']
                ]);

                foreach ($objectiveData['dimensions'] ?? [] as $dimensionData) {

                    Dimension::create([
                        'objective_id' => $objective->id,
                        'name' => $dimensionData['name'],
                        'dimension_cod' => $dimensionData['dimension_cod']
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Goal updated successfully'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

   public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $goal = Goal::with('objectives.dimensions')->findOrFail($id);

            // Delete dimensions first
            foreach ($goal->objectives as $objective) {
                $objective->dimensions()->delete();
            }

            // Delete objectives
            $goal->objectives()->delete();

            // Delete goal
            $goal->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Goal and all related data deleted successfully'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
