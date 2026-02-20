<?php

namespace App\Http\Controllers;

use App\Models\ActiveInternationalResearchPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ActiveInternationalResearchPartnerController extends Controller
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

            if ($user->hasRole('Dean') == activeRole()) {
                $status = $request->input('status');
                if($status=="HOD"){
                    $forms = ActiveInternationalResearchPartner::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            }
                        ])->where('created_by', $employee_id)
                        ->orderBy('id', 'desc')
                        ->get();
                }       
            }
            if ($user->hasRole('International Office') == activeRole()) {
                $status = $request->input('status');
                if($status=="HOD"){
                    $forms = ActiveInternationalResearchPartner::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            }
                        ])->orderBy('id', 'desc')
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
               $rules = [
                        'indicator_id' => 'required|integer',
                        'research_partners' => 'required|array|min:1',
                        'research_partners.*.deliverables' => 'required|string',
                        'research_partners.*.target' => 'required|integer',
                        'research_partners.*.achieved_target' => 'required|integer',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];

                    $messages = [
                        'research_partners.*.deliverables.required' => 'Deliverables is required',
                        'research_partners.*.target.required' => 'Target is required',
                        'research_partners.*.achieved_target.required' => 'Achieved Target is required.',
                    ];
                

                    $validator = Validator::make($request->all(), $rules, $messages);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                        }

                        $savedRecords = [];
                    foreach ($request->research_partners as $research_partnerss) {
                        $research_partnerss['indicator_id'] = $request->indicator_id;
                        $research_partnerss['form_status'] = $request->form_status ?? 'HOD';
                        $research_partnerss['created_by'] = $employeeId;
                        $research_partnerss['updated_by'] = $employeeId;

                        $savedRecords[] = ActiveInternationalResearchPartner::create($research_partnerss);
                    } 

            return response()->json([
                'status' => 'success',
                'message' => 'Record saved successfully',
                'data' => $savedRecords
            ]);

        } catch (\Exception $e) {
             DB::rollBack();
             return response()->json(['message' => $e->getMessage()], 500);
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
        try { 
            if ($request->has('status_update_data')) {
                $record = ActiveInternationalResearchPartner::findOrFail($id);

                $request->validate([
                        'record_id' => 'required',
                        'deliverables' => 'required|string',
                        'target' => 'required|integer|min:0',
                        'achieved_target' => 'required|integer|min:0',
                ]);

                $data = $request->only([
                    'deliverables', 'target', 'achieved_target'
                ]);
                $data['updated_by'] = Auth::user()->employee_id;

                $record->update($data);

                 return response()->json(['status' => 'success','message' => 'Record updated successfully', 'data' => $record]);
            }
            if ($request->has('status_update')) {
                $request->validate([
                    'status' => 'required|in:1,2,3,4,5,6'
                ]);

                $target = ActiveInternationalResearchPartner::findOrFail($id);

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

    /**
     * Remove the specified resource from storage.
     */
     public function destroy($id)
    {
        $record = ActiveInternationalResearchPartner::findOrFail($id);
        $record->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}
