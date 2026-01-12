<?php

namespace App\Http\Controllers;

use App\Models\InternationalizationSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InternationalizationSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        try { 
             $data = [];
            if($request->form_status=='HOD'){
                 $rules = [
                    'indicator_id' => 'required',
                    'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',

                    'stakeholder_category' => 'required|array|min:1',
                    'nature_of_activity' => 'required|array|min:1',
                    'activity_location' => 'required|array|min:1',

                    'title_of_activity' => 'required|string|max:255',
                    'brief_description_of_activity' => 'required|string',
                    'date_of_activity' => 'required|date',
                    'partner_organization' => 'nullable|string|max:255',

                    'total_number_of_faculty_in_department' => 'nullable|integer|min:0',
                    'number_of_faculty_participated' => 'nullable|integer|min:0',

                    'total_number_of_staff_in_office' => 'nullable|integer|min:0',
                    'number_of_staff_participated' => 'nullable|integer|min:0',

                    'total_number_of_students_in_program' => 'nullable|integer|min:0',
                    'number_of_students_participated' => 'nullable|integer|min:0',

                    'typ_of_impact_achieved' => 'required|array|min:1',
                    'evidence_of_impact_available' => 'required|array|min:1',

                    'declaration' => 'required|boolean',
                ];


                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                        }
                    
                    $data = $validator->validated(); 
                    $data['stakeholder_category'] = json_encode($data['stakeholder_category']);
                    $data['nature_of_activity'] = json_encode($data['nature_of_activity']);
                    $data['activity_location'] = json_encode($data['activity_location']);
                    $data['typ_of_impact_achieved'] = json_encode($data['typ_of_impact_achieved']);
                    $data['evidence_of_impact_available'] = json_encode($data['evidence_of_impact_available']); 

                        

            }
            $employeeId = Auth::user()->employee_id;
            DB::beginTransaction();
            $data['created_by'] = $employeeId;
            $data['updated_by'] = $employeeId;

            $record = InternationalizationSection::create($data);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Record saved successfully',
                'data' => $record
            ]);

        } catch (\Exception $e) {
             DB::rollBack();
             return response()->json(['message' => 'Oops! Something went wrong'], 500);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
