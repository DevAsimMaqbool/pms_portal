<?php

namespace App\Http\Controllers;

use App\Models\CommercialGainsCounsultancyResearchIncome;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            if($request->form_status=='RESEARCHER'){
                 $rules = [
                        'indicator_id' => 'required',
                        'title_of_consultancy' => 'required|string',
                        'duration_of_consultancy' => 'required|string',
                        'name_of_client_organization' => 'required|string',
                        'consultancy_fee' => 'required|numeric|min:0',
                        'consultancy_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];
                    $messages = [
                        'consultancy_file.mimes' => 'Upload JPG / PNG / PDF only.',
                    ];

                    $validator = Validator::make($request->all(), $rules, $messages);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                        }
                        $data = $request->only([
                            'indicator_id',
                            'title_of_consultancy',
                            'duration_of_consultancy',
                            'name_of_client_organization',
                            'consultancy_fee',
                            'form_status'
                        ]); 
                    if ($request->hasFile('consultancy_file')) {

                        $file = $request->file('consultancy_file');
                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                        $uniqueNumber = rand(1000, 9999);
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $safeName . '_' . $uniqueNumber . '.' . $extension;
                        $path = $file->storeAs('consultancy_file', $fileName, 'public');
                        $data['consultancy_file'] = $path;
                    }
                       $employeeId = Auth::user()->employee_id;
                        DB::beginTransaction();
                        $data['created_by'] = $employeeId;
                        $data['updated_by'] = $employeeId;
                        $research = CommercialGainsCounsultancyResearchIncome::create($data);
                       
                        DB::commit();
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Form saved successfully!',
                            'data' => $research
                        ]);
                       
            }
           

        } catch (\Exception $e) {
            DB::rollBack();
            // return response()->json([
            //     'message' => 'Oops! Something went wrong',
            //     'error' => $e->getMessage()
            // ], 500);
            return response()->json([
            'message' => 'Oops! Something went wrong'], 500);
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
