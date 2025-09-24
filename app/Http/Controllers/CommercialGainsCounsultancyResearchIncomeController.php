<?php

namespace App\Http\Controllers;

use App\Models\CommercialGainsCounsultancyResearchIncome;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommercialGainsCounsultancyResearchIncomeController extends Controller
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
                    if($status=="HOD"){
                           $forms = CommercialGainsCounsultancyResearchIncome::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('created_by', $hod_ids)
                            ->whereIn('status', [1, 2])
                            ->where('form_status', $status)
                            ->get();
                    }
                    if($status=="RESEARCHER"){
                        $teacher_id = User::whereIn('manager_id', $hod_ids)
                        ->role('Teacher')->pluck('employee_id');
                          $all_ids = $teacher_id->merge($hod_ids);
                          $forms = CommercialGainsCounsultancyResearchIncome::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                },'Projects'
                            ])
                            ->whereIn('created_by', $all_ids)
                            ->whereIn('status', [3, 2])
                            ->where('form_status', $status)
                            ->get();
                    }

            }if ($user->hasRole('HOD')) {
                $employeeIds = User::where('manager_id', $employee_id)
                    ->role('Teacher')->pluck('employee_id');
                    $forms = CommercialGainsCounsultancyResearchIncome::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            },'Projects'
                        ])
                         ->whereIn('created_by', $employeeIds)
                        ->whereIn('status', [1, 2])
                        ->where('form_status', 'RESEARCHER')
                        ->get();
                
            }if ($user->hasRole('ORIC')) {
                $status = $request->input('status');
                    if($status=="HOD"){
                           $forms = CommercialGainsCounsultancyResearchIncome::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                },'Projects'
                            ])
                            ->whereIn('status', [2, 3])
                            ->where('form_status', $status)
                            ->get();
                    }
                    if($status=="RESEARCHER"){
                          $forms = CommercialGainsCounsultancyResearchIncome::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                },'Projects'
                            ])
                            ->whereIn('status', [4, 3])
                            ->where('form_status', $status)
                            ->get();
                    }

            }if ($user->hasRole('Human Resources')) {
                $status = $request->input('status');
                     if($status=="HOD"){
                           $forms = CommercialGainsCounsultancyResearchIncome::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                },'Projects'
                            ])
                            ->whereIn('status', [3, 4])
                            ->where('form_status', $status)
                            ->get();
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
    public function store(Request $request)
    {
        try { 
            $employeeId = Auth::user()->employee_id;
            if($request->form_status=='RESEARCHER'){
                 $rules = [
                        'kpa_id' => 'required',
                        'sp_category_id' => 'required',
                        'indicator_id' => 'required',
                        'no_of_consultancies_done' => 'required|integer',
                        'title_of_consultancy' => 'required|string',
                        'duration_of_consultancy' => 'required|string',
                        'name_of_client_organization' => 'required|string',
                        'industrial_projects' => 'required|array',
                        'industrial_projects.*.no_of_projects' => 'required|integer',
                        'industrial_projects.*.name_of_project' => 'required|string',
                        'industrial_projects.*.name_of_contracting_industry' => 'required|string',
                        'industrial_projects.*.total_duration_of_project' => 'required|string',
                        'industrial_projects.*.estimate_cost_project' => 'required|string',
                        'industrial_projects.*.completion_year' => 'required|string',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];
                    $messages = [
                        'industrial_projects.*.name_of_project.required' => 'Name of industrial projects is required.',
                        'industrial_projects.*.no_of_projects.required' => 'No of industrial projects is required.',
                        'industrial_projects.*.name_of_contracting_industry.required' => 'Name of contracting industry is required.',
                        'industrial_projects.*.total_duration_of_project.required' => 'Total duration of the project is required.',
                        'industrial_projects.*.estimate_cost_project.required' => 'Estimated project cost is required.',
                        'industrial_projects.*.completion_year.required' => 'Estimated completion month/year is required.',
                        // You can add more custom messages if you want
                    ];


                    $validator = Validator::make($request->all(), $rules, $messages);
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
                            'no_of_consultancies_done',
                            'title_of_consultancy',
                            'duration_of_consultancy',
                            'name_of_client_organization',
                            'form_status'
                        ]); 
                        $data['created_by'] = $employeeId;
                        $data['updated_by'] = $employeeId;
                        $research = CommercialGainsCounsultancyResearchIncome::create($data);

                        // Save multiple industrial projects
                        if ($request->has('industrial_projects')) {
                            foreach ($request->industrial_projects as $project) {
                                $research->projects()->create([
                                    'no_of_projects' => $project['no_of_projects'],
                                    'name_of_project' => $project['name_of_project'],
                                    'name_of_contracting_industry' => $project['name_of_contracting_industry'],
                                    'total_duration_of_project' => $project['total_duration_of_project'],
                                    'estimate_cost_project' => $project['estimate_cost_project'],
                                    'completion_year' => $project['completion_year'],
                                    'created_by' => $employeeId,
                                    'updated_by' => $employeeId,
                                ]);
                            }
                        }

                        return response()->json([
                            'status' => 'success',
                            'message' => 'Form saved successfully!',
                            'data' => $research
                        ]);

                       
            }
            if($request->form_status=='HOD'){
                  $rules = [
                        'kpa_id' => 'required',
                        'sp_category_id' => 'required',
                        'indicator_id' => 'required',
                        'target_of_consultancy_projects' => 'required',
                        'target_of_industrial_projects' => 'required',
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
                            'target_of_consultancy_projects',
                            'target_of_industrial_projects',
                            'form_status'
                        ]); 
                         $data['created_by'] = $employeeId;
                         $data['updated_by'] = $employeeId;
                        $record = CommercialGainsCounsultancyResearchIncome::create($data);
                        if ($record) {
                            return response()->json([
                                'status' => 'success',
                                'message' => 'Record saved successfully',
                                'data' => $record
                            ], 201);
                        } 
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Failed to save record'
                        ], 500);

            }

            

           

        } catch (\Exception $e) {

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

        $target = CommercialGainsCounsultancyResearchIncome::findOrFail($id);
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
