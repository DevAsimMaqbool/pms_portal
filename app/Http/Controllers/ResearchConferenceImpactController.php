<?php

namespace App\Http\Controllers;

use App\Models\ResearchConferenceImpact;
use App\Models\ResearchConferenceParticipant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ResearchConferenceImpactController extends Controller
{
        public function index(Request $request)
    {
         try {
            $user = Auth::user();
            $userId = Auth::id();
            $employee_id = $user->employee_id;

            if(in_array(getRoleName(activeRole()), ['Dean'])) {    
                   $status = $request->input('status');
                   $hod_ids = User::where('manager_id', $employee_id)
                   ->role('HOD')->pluck('employee_id');
                    if($status=="RESEARCHER"){
                        $teacher_id = User::whereIn('manager_id', $hod_ids)
                        ->role(['Professor','Assistant Professor','Associate Professor'])->pluck('employee_id');
                          $all_ids = $teacher_id->merge($hod_ids);
                          $forms = ResearchConferenceImpact::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                },'participants'
                            ])
                            ->whereIn('created_by', $all_ids)
                            ->where('form_status', $status)
                            ->orderBy('id', 'desc')
                            ->get();
                    }

            }
            if(in_array(getRoleName(activeRole()), ['HOD','Professor','Assistant Professor','Associate Professor'])) {
                $status = $request->input('status');
                if($status=="Teacher"){
                    $forms = ResearchConferenceImpact::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            },'participants'
                        ])
                        ->where('created_by', $employee_id)
                        ->orderBy('id', 'desc')
                        ->get();
                }
                if($status=="HOD"){
                    $employeeIds = User::where('manager_id', $employee_id)
                        ->role(['Professor','Assistant Professor','Associate Professor'])->pluck('employee_id');
                        $all_ids = $employeeIds->merge($employee_id);
                        $forms = ResearchConferenceImpact::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                },'participants'
                            ])
                            ->whereIn('created_by', $all_ids)
                            ->whereIn('status', [1, 2])
                            ->where('form_status', 'RESEARCHER')
                            ->orderBy('id', 'desc')
                            ->get();
                }        
                
            }
            if(in_array(getRoleName(activeRole()), ['ORIC'])) {
                $status = $request->input('status');
                    if($status=="RESEARCHER"){
                          $forms = ResearchConferenceImpact::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                },'participants'
                            ])
                            ->whereIn('status', [2, 3])
                            ->where('form_status', $status)
                            ->orderBy('id', 'desc')
                            ->get();
                    }

            }
            if(in_array(getRoleName(activeRole()), ['Human Resources'])) {
                $status = $request->input('status');
                     if($status=="HOD"){
                           $forms = ResearchConferenceImpact::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                },'participants'
                            ])
                            ->whereIn('status', [3, 4])
                            ->where('form_status', $status)
                            ->orderBy('id', 'desc')
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
    public function store(Request $request)
    {
        try { 
            
               $employeeId = Auth::user()->employee_id;
               $rules = [
                        'indicator_id' => 'required|integer',
                        'conference_name' => 'required|string',
                        'conference_theme' => 'required|string',
                        'conference_date' => 'required',
                        'conference_venue' => 'required|string',
                        'conference_scope' => 'required',
                        'scopus_indexing' => 'required',
                        'national_participants' => 'required',
                        'international_participants' => 'required',
                        'industry_participants' => 'required',
                        'industry_engagement' => 'required|string',
                        'international_participation' => 'required|string',
                        'indexing_recognition' => 'required|string',
                        'overall_remarks' => 'required|string',
                        'nature_of_partner' => 'required',
                        'partner_institute' => 'required',
                        'partner_country' => 'required',

                        'intrtnationpart' => 'required|array|min:1',
                        'intrtnationpart.*.name' => 'required|string',
                        'intrtnationpart.*.designation' => 'required',
                        'intrtnationpart.*.participant_university' => 'required',
                        'intrtnationpart.*.participant_country' => 'required',
                        'intrtnationpart.*.participated_as' => '',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];

                    $messages = [
                        'intrtnationpart.*.name.required' => 'Name is required',
                        'intrtnationpart.*.designation.required' => 'Designation is required',
                        'intrtnationpart.*.participant_university.required' => 'Univeristy is required',
                        'intrtnationpart.*.participant_country.required' => 'Country is required',
                    ];
                

                    $validator = Validator::make($request->all(), $rules, $messages);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                        }
                    // Create main record
                    $lineManagerReview = ResearchConferenceImpact::create([
                        'indicator_id' => $request->indicator_id,
                        
                        'conference_name' => $request->conference_name,
                        'conference_theme' => $request->conference_theme,
                        'conference_date' => $request->conference_date,
                        'conference_venue' => $request->conference_venue,
                        'conference_scope' => $request->conference_scope,
                        'scopus_indexing' => $request->scopus_indexing,
                        'national_participants' => $request->national_participants,
                        'international_participants' => $request->international_participants,
                        'industry_participants' => $request->industry_participants,
                        'scholarly_impact' => $request->scholarly_impact,
                        'industry_engagement' => $request->industry_engagement,
                        'international_participation' => $request->international_participation,
                        'indexing_recognition' => $request->indexing_recognition,
                        'overall_remarks' => $request->overall_remarks,
                        'nature_of_partner' => $request->nature_of_partner,
                        'partner_institute' => $request->partner_institute,
                        'partner_country' => $request->partner_country,
                        'form_status' => $request->form_status,
                        'created_by' => $employeeId,
                        'updated_by' => $employeeId,
                    ]);    
                    // Insert tasks and ratings into mid table
                    foreach ($request->intrtnationpart as $participant) {
                        ResearchConferenceParticipant::create([
                            'research_conference_impact_id' => $lineManagerReview->id,
                            'name' => $participant['name'],
                            'designation' => $participant['designation'],
                            'participant_university' => $participant['participant_university'],
                            'participant_country' => $participant['participant_country'],
                            'participated_as' => json_encode($participant['participated_as']),
                        ]);
                    }

                       

            return response()->json([
                'status' => 'success',
                'message' => 'Record saved successfully',
                'data' => $lineManagerReview
            ]);

        } catch (\Exception $e) {
             DB::rollBack();
             return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function updateResearchConferenceImpact(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $rules = [
                'conference_name' => 'required|string',
                'conference_theme' => 'required|string',
                'conference_date' => 'required',
                'conference_venue' => 'required|string',
                'conference_scope' => 'required',
                'scopus_indexing' => 'required',
                'national_participants' => 'required',
                'international_participants' => 'required',
                'industry_participants' => 'required',
                'industry_engagement' => 'required|string',
                'international_participation' => 'required|string',
                'indexing_recognition' => 'required|string',
                'overall_remarks' => 'required|string',
                'nature_of_partner' => 'required',
                'partner_institute' => 'required',
                'partner_country' => 'required',

                'intrtnationpart' => 'required|array|min:1',
                'intrtnationpart.*.name' => 'required|string',
                'intrtnationpart.*.designation' => 'required',
                'intrtnationpart.*.participant_university' => 'required',
                'intrtnationpart.*.participant_country' => 'required',
                'intrtnationpart.*.participated_as' => '',
            ];

            Validator::validate($request->all(), $rules);

            $review = ResearchConferenceImpact::findOrFail($id);

            // ✅ Update parent
            $review->update([
                'conference_name' => $request->conference_name,
                'conference_theme' => $request->conference_theme,
                'conference_date' => $request->conference_date,
                'conference_venue' => $request->conference_venue,
                'conference_scope' => $request->conference_scope,
                'scopus_indexing' => $request->scopus_indexing,
                'national_participants' => $request->national_participants,
                'international_participants' => $request->international_participants,
                'industry_participants' => $request->industry_participants,
                'scholarly_impact' => $request->scholarly_impact,
                'industry_engagement' => $request->industry_engagement,
                'international_participation' => $request->international_participation,
                'indexing_recognition' => $request->indexing_recognition,
                'overall_remarks' => $request->overall_remarks,
                'nature_of_partner' => $request->nature_of_partner,
                'partner_institute' => $request->partner_institute,
                'partner_country' => $request->partner_country,
                'updated_by' => Auth::user()->employee_id
            ]);

            // ✅ Sync child tasks
            $review->participants()->delete();

            foreach ($request->intrtnationpart as $participant) {

                $review->participants()->create([
                    'name' => $participant['name'],
                    'designation' => $participant['designation'],
                    'participant_university' => $participant['participant_university'],
                    'participant_country' => $participant['participant_country'],
                    'participated_as' => json_encode($participant['participated_as']),
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Updated Successfully'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Update Failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {   
        $request->validate([
            'status' => 'required|in:1,2,3,4,5,6'
        ]);

        $target = ResearchConferenceImpact::findOrFail($id);

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
public function destroy($id)
{
    // Delete main line-manager-review record
    $record = ResearchConferenceImpact::findOrFail($id);

    // Delete related participants (assuming participants are in separate table)
    $record->participants()->delete();

    $record->delete();

    return response()->json([
        'message' => 'Record deleted successfully from both tables!'
    ]);
}
}
