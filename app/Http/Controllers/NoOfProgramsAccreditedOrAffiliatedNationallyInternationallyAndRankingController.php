<?php

namespace App\Http\Controllers;

use App\Models\ProgramAccreditation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class NoOfProgramsAccreditedOrAffiliatedNationallyInternationallyAndRankingController extends Controller
{
    public function index(Request $request)
    {
         try {
            $user = Auth::user();
            $userId = Auth::id();
            $employee_id = $user->employee_id;
            if(in_array(getRoleName(activeRole()), ['Dean'])) {
                $status = $request->input('status');
                if($status=="HOD"){
                        $forms = ProgramAccreditation::with([
                            'creator:employee_id,name',
                            'faculty:id,name',
                            'department:id,name',
                            'program:id,program_name',
                        ])->where('created_by', $employee_id)
                        ->orderBy('id', 'desc')
                        ->get()
                        ->map(function ($form) {
                                if ($form->document_link) {
                                    $form->document_link = Storage::url($form->document_link);
                                }
                                return $form;
                            });
                }
            }
           
            if(in_array(getRoleName(activeRole()), ['QEC'])) {
                $status = $request->input('status');
                if($status=="HOD"){
                    $forms = ProgramAccreditation::with([
                            'creator:employee_id,name',
                            'faculty:id,name',
                            'department:id,name',
                            'program:id,program_name',
                        ])->orderBy('id', 'desc')
                        ->get()->map(function ($form) {
                                if ($form->document_link) {
                                    $form->document_link = Storage::url($form->document_link);
                                }
                                return $form;
                            });
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
            if($request->form_status=='HOD'){
                 $rules = [
                'indicator_id' => 'required',
                'faculty_id' => 'required|integer',
                'department_id' => 'required|integer',
                'program_id' => 'required|integer',
                'program_level' => 'required|string',
                'recognition_type' => 'required|in:accreditation,affiliation,ranking',
                
                'scope' => 'required|string',
                'validity_from' => 'required|date',
                'validity_to' => 'required|date|after_or_equal:validity_from',
                'evidence_available' => 'required|string',
                'document_link' => 'nullable|file|mimes:pdf,doc,docx,zip,jpg,png',
                'remarks' => 'nullable|string',
                'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                 ];
                 // ✅ Conditional Rules
                if ($request->recognition_type == 'ranking') {
                    $rules['university_ranking'] = 'required|string';
                    $rules['ranking_position'] = 'required|integer|min:1';
                }

                if ($request->recognition_type == 'accreditation') {
                    $rules['accrediting'] = 'required|string';

                    if ($request->accrediting == 'Other') {
                        $rules['accrediting_other_detail'] = 'required|string|max:255';
                    }
                }

                if ($request->recognition_type == 'affiliation') {
                    $rules['affiliated_body_name'] = 'required|string|max:255';
                    $rules['affiliated_for'] = 'required|string|max:255';
                }
                 
                $messages = [
                    'document_link.mimes' => 'Upload JPG / PNG / PDF only.',
                ];
                 $validator = Validator::make($request->all(), $rules, $messages);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'error',
                        'errors' => $validator->errors()
                    ], 422);
                }
                 $data = $validator->validated();
                 if ($request->hasFile('document_link')) {

                        $file = $request->file('document_link');
                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                        $uniqueNumber = rand(1000, 9999);
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $safeName . '_' . $uniqueNumber . '.' . $extension;
                        $path = $file->storeAs('program_accreditation_doc', $fileName, 'public');
                        $data['document_link'] = $path;
                    }   

                        

            }
            $employeeId = Auth::user()->employee_id;
            DB::beginTransaction();
            $data['created_by'] = $employeeId;
            $data['updated_by'] = $employeeId;

            $record = ProgramAccreditation::create($data);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Record saved successfully',
                'data' => $record
            ]);
        } catch (\Exception $e) {
           // DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = ProgramAccreditation::findOrFail($id);
        return response()->json($data);
    }
    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $id)
    // {
    //      $request->validate([
    //          'key_performance_area' => 'required',
    //      ]);
    //      $userId = session('user_id');
    //      $data = ProgramAccreditation::findOrFail($id);
    //      $data->performance_area = $request->key_performance_area;
    //      $data->updated_by = $userId;
    //      $data->save();
    //      return response()->json(['message' => 'data update successfully']);
    // }
     public function update(Request $request, $id)
    {   
        try { 
            if ($request->has('status_update_data')) {
                $record = ProgramAccreditation::findOrFail($id);

                $rules =[
                        'faculty_id' => 'required|integer',
                        'department_id' => 'required|integer',
                        'program_id' => 'required|integer',
                        'program_level' => 'required|string',

                        'recognition_type' => 'required|in:accreditation,affiliation,ranking',

                        'scope' => 'required|string',
                        'validity_from' => 'required|date',
                        'validity_to' => 'required|date|after_or_equal:validity_from',

                        'evidence_available' => 'required|string',

                        'document_link' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                        'remarks' => 'nullable|string',    
                ];
                // ✅ Conditional Rules
                if ($request->recognition_type == 'ranking') {
                    $rules['university_ranking'] = 'required|string';
                    $rules['ranking_position'] = 'required|integer|min:1';
                }

                if ($request->recognition_type == 'accreditation') {
                    $rules['accrediting'] = 'required|string';

                    if ($request->accrediting == 'Other') {
                        $rules['accrediting_other_detail'] = 'required|string|max:255';
                    }
                }

                if ($request->recognition_type == 'affiliation') {
                    $rules['affiliated_body_name'] = 'required|string|max:255';
                    $rules['affiliated_for'] = 'required|string|max:255';
                }
                // ✅ Validate
                $validated = $request->validate($rules);
                

            
                if ($request->hasFile('document_link')) {
                        
                        if ($record->document_link && Storage::disk('public')->exists($record->document_link)) {
                            Storage::disk('public')->delete($record->document_link);
                        }

                        $file = $request->file('document_link');
                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                        $uniqueNumber = rand(1000, 9999);
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $safeName . '_' . $uniqueNumber . '.' . $extension;
                        $path = $file->storeAs('program_accreditation_doc', $fileName, 'public');
                        $data['document_link'] = $path;
                    }
                $data['updated_by'] = Auth::user()->employee_id;

                $record->update($validated);

                return response()->json(['status' => 'success','message' => 'Record updated successfully', 'data' => $record]);
            }
            if ($request->has('status_update')) {
                $request->validate([
                    'status' => 'required|in:1,2,3,4,5,6'
                ]);

                $target = ProgramAccreditation::findOrFail($id);

                // Get current update history
                $history = $target->update_history ? json_decode($target->update_history, true) : [];

                // Get current user info
                $currentUserId = Auth::id();
                $currentUserName = Auth::user()->name;
                $userRoll = getRoleName(activeRole()) ?? 'N/A';

                // Avoid duplicate consecutive updates by the same user with the same status
                $lastUpdate = end($history);
                if (!$lastUpdate || $lastUpdate['user_id'] != $currentUserId || $lastUpdate['status'] != $request->status) {
                    $history[] = [
                        'user_id'    => $currentUserId,
                        'user_name'  => $currentUserName,
                        'status'     => $request->status,
                        'role'     => $userRoll,
                        'updated_at' => now()->toDateTimeString(),
                    ];
                }





                $target->status = $request->status;
                $target->update_history = json_encode($history);
                $target->updated_by = $currentUserId;
                $target->save();

                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {
             DB::rollBack();
             return response()->json(['message' => 'Oops! Something went wrong'], 500);
        }
    }

    
      public function destroy($id)
    {
        $record = ProgramAccreditation::findOrFail($id);
        // ✅ Delete file from storage if exists
        if ($record->document_link &&
            Storage::disk('public')->exists($record->document_link)) {

            Storage::disk('public')->delete($record->document_link);
        }

        $record->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
    public function report($id)
    {
        $area = ProgramAccreditation::with('indicatorCategories.indicators')->findOrFail($id);
        return view('admin.performance', compact('area'));
    }
}

