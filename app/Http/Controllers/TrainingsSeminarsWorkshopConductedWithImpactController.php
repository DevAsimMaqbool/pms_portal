<?php

namespace App\Http\Controllers;

use App\Models\TrainingsSeminarsWorkshopConductedWithImpact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TrainingsSeminarsWorkshopConductedWithImpactController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         try {
            $user = Auth::user();
            $userId = Auth::id();
            $employee_id = $user->employee_id;

            if ($user->hasRole('Dean')) {
                   $status = $request->input('status');
                   $hod_ids = User::where('manager_id', $employee_id)
                   ->role('HOD')->pluck('employee_id');
                    if($status=="RESEARCHER"){
                        $teacher_id = User::whereIn('manager_id', $hod_ids)
                        ->role('Teacher')->pluck('employee_id');
                          $all_ids = $teacher_id->merge($hod_ids);
                          $forms = TrainingsSeminarsWorkshopConductedWithImpact::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])->whereIn('created_by', $all_ids)->whereIn('status', [3,2])
                            ->where('form_status', $status)->get();
                    }

            }if ($user->hasRole('HOD')) {
                $status = $request->input('status');
                   $hod_ids = User::where('manager_id', $employee_id)
                   ->role(['Teacher'])->pluck('employee_id');
                    if($status=="RESEARCHER"){
                          $forms = TrainingsSeminarsWorkshopConductedWithImpact::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])->whereIn('created_by', $hod_ids)->whereIn('status', [1, 2])
                            ->where('form_status', 'RESEARCHER')->get();
                    }
                
            }if ($user->hasRole('ORIC')) {
                 $status = $request->input('status');
                    if($status=="RESEARCHER"){
                          $forms = TrainingsSeminarsWorkshopConductedWithImpact::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])->whereIn('status', [4,3])
                            ->where('form_status', $status)->get();
                    }

            }

            if ($request->ajax()) {
                return response()->json([
                    'forms' => $forms
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Oops! Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try { 
            if($request->form_status=='RESEARCHER'){
                 $rules = [
                        'kpa_id' => 'required',
                        'sp_category_id' => 'required',
                        'indicator_id' => 'required',
                        'ket_target' => 'required|string',
                        'target_of_ken_knowledge_products' => 'required|string',
                        'event_proposal_forms_submission' => 'required|string',
                        'no_of_knowledge_products_produced' => 'required|string',
                        'no_of_participants' => 'required|string',
                        'no_of_participants_from_the_industry' => 'required|string',
                        'no_of_participants_from_the_public_sector' => 'required|string',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                        }

                        $data = $request->only([
                            'kpa_id',
                            'sp_category_id',
                            'indicator_id',
                            'ket_target',
                            'target_of_ken_knowledge_products',
                            'event_proposal_forms_submission',
                            'no_of_knowledge_products_produced',
                            'no_of_participants',
                            'no_of_participants_from_the_industry',
                            'no_of_participants_from_the_public_sector',
                            'form_status'
                        ]);

                        
            }
            $employeeId = Auth::user()->employee_id ?? null;
            $data['created_by'] = $employeeId;
            $data['updated_by'] = $employeeId;

            $record = TrainingsSeminarsWorkshopConductedWithImpact::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Record saved successfully',
                'data' => $record
            ]);

        } catch (\Exception $e) {
            return response()->json([
                    'status'  => 'error',
                    'message' => 'Something went wrong: ' . $e->getMessage()
                ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:1,2,3,4,5,6'
        ]);

        $target = TrainingsSeminarsWorkshopConductedWithImpact::findOrFail($id);
        $target->status = $request->status;
        $target->updated_by = Auth::id();
        $target->save();

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
