<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProfessionalMembershipController extends Controller
{
    public function index(Request $request)
    {
         try {
            $user = Auth::user();
            $userId = Auth::id();
            $employee_id = $user->employee_id;


            if ($user->hasRole(['Dean','HOD']) == activeRole()) {
                $status = $request->input('status');
                if($status=="HOD"){
                        $forms = ProfessionalMembership::with([
                            'creator:employee_id,name',
                        ])->where('created_by', $employee_id)
                        ->orderBy('id', 'desc')
                        ->get()
                        ->map(function ($form) {
                                if ($form->document_link) {
                                    $form->document_link = Storage::url($form->document_link);
                                }
                                return $form;
                            });;
                }
            }
            if ($user->hasRole('QEC') == activeRole()) {
                $status = $request->input('status');
                if($status=="HOD"){
                    $forms = ProfessionalMembership::with([
                            'creator:employee_id,name',
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
                'type_of_membership' => 'required|string',
                'name_of_professional_body' => 'required|string|max:255',
                'category_of_body' => 'required|string',
                'discipline' => 'required|string',
                'level' => 'required|string',
                'country' => 'nullable|string|max:100',
                'membership_status' => 'required|string',
                'membership_start_date' => 'required|date',
                'membership_valid_until' => 'required|date|after_or_equal:membership_start_date',
                'evidence_type' => 'nullable|array',
                'document_link' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip',
                'declaration' => 'accepted',
                'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                 ];
                 
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
                $data = $request->only([
                    'indicator_id',
                    'type_of_membership',
                    'name_of_professional_body',
                    'category_of_body',
                    'discipline',
                    'level',
                    'country',
                    'membership_status',
                    'membership_start_date',
                    'membership_valid_until',
                    'declaration',
                    'form_status'
                ]); 
                 if ($request->hasFile('document_link')) {

                        $file = $request->file('document_link');
                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                        $uniqueNumber = rand(1000, 9999);
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $safeName . '_' . $uniqueNumber . '.' . $extension;
                        $path = $file->storeAs('professional_memberships', $fileName, 'public');
                        $data['document_link'] = $path;
                    }            

            }
            $employeeId = Auth::user()->employee_id;
            DB::beginTransaction();
            $data['evidence_type'] = json_encode($request->evidence_type);
            $data['created_by'] = $employeeId;
            $data['updated_by'] = $employeeId;

            $record = ProfessionalMembership::create($data);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Record saved successfully',
                'data' => $record
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'oops some thing wrong'], 500);
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
        $data = ProfessionalMembership::findOrFail($id);
        return response()->json($data);
    }
   public function update(Request $request, $id)
    {  
        try {  
            if ($request->has('status_update_data')) {
                $record = ProfessionalMembership::findOrFail($id);

                $request->validate([
                        'record_id' => 'required',
                        'type_of_membership' => 'required|string',
                        'name_of_professional_body' => 'required|string|max:255',
                        'category_of_body' => 'required|string',
                        'discipline' => 'required|string',
                        'level' => 'required|string',
                        'country' => 'nullable|string|max:100',
                        'membership_status' => 'required|string',
                        'membership_start_date' => 'required|date',
                        'membership_valid_until' => 'required|date|after_or_equal:membership_start_date',
                        'evidence_type' => 'nullable|array',
                        'document_link' => '',
                        'declaration' => 'accepted',    
                ]);

                $data = $request->only([
                                'type_of_membership', 'name_of_professional_body', 'category_of_body', 'discipline','level','country','membership_status','membership_start_date','membership_valid_until','evidence_type'
                                ,'document_link','declaration'
                            ]);
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
                                    $path = $file->storeAs('professional_memberships', $fileName, 'public');
                                    $data['document_link'] = $path;
                                }
                            $data['updated_by'] = Auth::user()->employee_id;

                            $record->update($data);

                    return response()->json(['status' => 'success','message' => 'Record updated successfully', 'data' => $record]);
                 }
                 if ($request->has('status_update')) {
                        $request->validate([
                            'status' => 'required|in:1,2,3,4,5,6'
                        ]);

                        $target = ProfessionalMembership::findOrFail($id);

                        // Get current update history
                        $history = $target->update_history ? json_decode($target->update_history, true) : [];

                        // Get current user info
                        $currentUserId = Auth::id();
                        $currentUserName = Auth::user()->name;
                        $userRoll = activeRole() ?? 'N/A';

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
        $record = ProfessionalMembership::findOrFail($id);
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
        $area = ProfessionalMembership::with('indicatorCategories.indicators')->findOrFail($id);
        return view('admin.performance', compact('area'));
    }
}

