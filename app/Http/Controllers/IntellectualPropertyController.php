<?php

namespace App\Http\Controllers;

use App\Models\IntellectualProperty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class IntellectualPropertyController extends Controller
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
                          $forms = IntellectualProperty::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('created_by', $all_ids)
                            ->whereIn('status', [3, 2])
                            ->where('form_status', $status)
                            ->get()
                            ->map(function ($form) {
                                if ($form->supporting_docs_as_attachment) {
                                    $form->supporting_docs_as_attachment = Storage::url($form->supporting_docs_as_attachment);
                                }
                                return $form;
                            });
                    }

            }if ($user->hasRole('HOD') || $user->hasRole('Teacher')) {
                $status = $request->input('status');
                if($status=="Teacher"){
                        $forms = IntellectualProperty::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            }
                        ])
                        ->where('created_by', $employee_id)
                        ->get()
                        ->map(function ($form) {
                            if ($form->supporting_docs_as_attachment) {
                                $form->supporting_docs_as_attachment = Storage::url($form->supporting_docs_as_attachment);
                            }
                            return $form;
                        });
                }
                if($status=="HOD"){
                $employeeIds = User::where('manager_id', $employee_id)
                    ->role('Teacher')->pluck('employee_id');
                    $forms = IntellectualProperty::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            }
                        ])
                         ->whereIn('created_by', $employeeIds)
                        ->whereIn('status', [1, 2])
                        ->where('form_status', 'RESEARCHER')
                        ->get()
                        ->map(function ($form) {
                                if ($form->supporting_docs_as_attachment) {
                                    $form->supporting_docs_as_attachment = Storage::url($form->supporting_docs_as_attachment);
                                }
                                return $form;
                            });
                    }        
                
            }if ($user->hasRole('ORIC')) {
                $status = $request->input('status');
                    if($status=="RESEARCHER"){
                          $forms = IntellectualProperty::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('status', [4, 3])
                            ->where('form_status', $status)
                            ->get()
                            ->map(function ($form) {
                                if ($form->supporting_docs_as_attachment) {
                                    $form->supporting_docs_as_attachment = Storage::url($form->supporting_docs_as_attachment);
                                }
                                return $form;
                            });
                    }

            }if ($user->hasRole('Human Resources')) {
                $status = $request->input('status');
                     if($status=="HOD"){
                           $forms = IntellectualProperty::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
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
                        'no_of_ip_disclosed' => 'required|string',
                        'name_of_ip_filed' => 'required|string',
                        'patents_ip_type' => 'required|string',
                        'other_detail' => 'required_if:patents_ip_type,Other|string|nullable',
                        'area_of_application' => 'required|string',
                        'date_of_filing_registration' => 'required|string',
                        'supporting_docs_as_attachment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];
                    $messages = [
                        'supporting_docs_as_attachment.mimes' => 'Upload JPG / PNG / PDF only.',
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
                            'no_of_ip_disclosed',
                            'name_of_ip_filed',
                            'patents_ip_type',
                            'other_detail',
                            'area_of_application',
                            'date_of_filing_registration',
                            'form_status'
                        ]);
                        if ($request->hasFile('supporting_docs_as_attachment')) {

                            $file = $request->file('supporting_docs_as_attachment');
                            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                            $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                            $uniqueNumber = rand(1000, 9999);
                            $extension = $file->getClientOriginalExtension();
                            $fileName = $safeName . '_' . $uniqueNumber . '.' . $extension;
                            $path = $file->storeAs('intellectualProperty', $fileName, 'public');
                            $data['supporting_docs_as_attachment'] = $path;
                        }

            }
            // if($request->form_status=='HOD'){
            //       $rules = [
            //             'kpa_id' => 'required',
            //             'sp_category_id' => 'required',
            //             'indicator_id' => 'required',
            //             'target_of_ip_disclosures' => 'required|integer',
            //             'target_of_ip_filed' => 'required|integer',
            //             'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
            //         ];

            //         $validator = Validator::make($request->all(), $rules);
            //         if ($validator->fails()) {
            //                 return response()->json([
            //                     'status' => 'error',
            //                     'errors' => $validator->errors()
            //                 ], 422);
            //             }
            //         $data = $request->only([
            //                 'kpa_id',
            //                 'sp_category_id',
            //                 'indicator_id',
            //                 'target_of_ip_disclosures',
            //                 'target_of_ip_filed',
            //                 'form_status'
            //             ]);    

            // }
            $employeeId = Auth::user()->employee_id;
            DB::beginTransaction();
            $data['created_by'] = $employeeId;
            $data['updated_by'] = $employeeId;

            $record = IntellectualProperty::create($data);
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
    public function update(Request $request, $id)
    {   try { 
            if ($request->has('status_update_data')) {
                $record = IntellectualProperty::findOrFail($id);
                $rules = [
                    'indicator_id' => 'required',
                    'no_of_ip_disclosed' => 'required|string',
                    'name_of_ip_filed' => 'required|string',
                    'patents_ip_type' => 'required|string',
                    'other_detail' => 'required_if:patents_ip_type,Other|string|nullable',
                    'area_of_application' => 'required|string',
                    'date_of_filing_registration' => 'required|string',
                    'supporting_docs_as_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                    'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                ];
                $data = $request->only([
                    'indicator_id', 'no_of_ip_disclosed', 'name_of_ip_filed', 'patents_ip_type',
                    'other_detail', 'area_of_application', 'date_of_filing_registration', 'form_status'
                ]);
                if ($request->hasFile('supporting_docs_as_attachment')) {
                    $file = $request->file('supporting_docs_as_attachment');
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                    $fileName = $safeName . '_' . rand(1000,9999) . '.' . $file->getClientOriginalExtension();
                    $data['supporting_docs_as_attachment'] = $file->storeAs('intellectualProperty', $fileName, 'public');
                }
                $data['updated_by'] = Auth::user()->employee_id;

                $record->update($data);

                return response()->json(['status' => 'success','message' => 'Record updated successfully', 'data' => $record]);
            }





            if ($request->has('status_update')) {
                $request->validate([
                    'status' => 'required|in:1,2,3,4,5,6'
                ]);

                $target = IntellectualProperty::findOrFail($id);
                $target->status = $request->status;
                $target->updated_by = Auth::id();
                $target->save();

                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {
             DB::rollBack();
             return response()->json(['message' => 'Oops! Something went wrong'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
