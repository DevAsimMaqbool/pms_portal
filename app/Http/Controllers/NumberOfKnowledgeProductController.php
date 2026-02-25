<?php

namespace App\Http\Controllers;

use App\Models\NumberOfKnowledgeProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NumberOfKnowledgeProductController extends Controller
{
    // 🔹 Index (Only show logged-in user records)
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $employee_id = $user->employee_id;
            if(in_array(getRoleName(activeRole()), ['ORIC'])) {
                   $status = $request->input('status');
                    if($status=="RESEARCHER"){
                          $forms = NumberOfKnowledgeProduct::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            }
                        ])->orderBy('id', 'desc')
                    ->get()->map(function ($form) {
                                if ($form->attach_evidence) {
                                    $form->attach_evidence = Storage::url($form->attach_evidence);
                                }
                                return $form;
                            });
                    }

            }

             if(in_array(getRoleName(activeRole()), ['Teacher','Professor','Associate Professor','Assistant Professor','Program Leader UG','Program Leader PG'])) {
                $status = $request->input('status');
                if($status=="Teacher"){
                    $forms = NumberOfKnowledgeProduct::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            }
                        ])
                        ->where('created_by', $employee_id)
                        ->orderBy('id', 'desc')
                        ->get()->map(function ($form) {
                                if ($form->attach_evidence) {
                                    $form->attach_evidence = Storage::url($form->attach_evidence);
                                }
                                return $form;
                            });
                }       
                
            }
            if(in_array(getRoleName(activeRole()), ['HOD'])) {
                $status = $request->input('status');
                if($status=="HOD"){
                    $employeeIds = User::where('manager_id', $employee_id)
                        ->role('Teacher')->pluck('employee_id');
                        $forms = NumberOfKnowledgeProduct::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('created_by', $employeeIds)
                            ->whereIn('status', [1, 2])
                            ->where('form_status', 'RESEARCHER')
                            ->orderBy('id', 'desc')
                            ->get()->map(function ($form) {
                                if ($form->attach_evidence) {
                                    $form->attach_evidence = Storage::url($form->attach_evidence);
                                }
                                return $form;
                            });
                }        
                
            }
            if(in_array(getRoleName(activeRole()), ['Dean'])) {
                $status = $request->input('status');
                $hod_ids = User::where('manager_id', $employee_id)
                    ->role('HOD')->pluck('employee_id');
                if ($status == "HOD") {
                    $forms = NumberOfKnowledgeProduct::with([
                        'creator' => function ($q) {
                            $q->select('employee_id', 'name');
                        }
                    ])
                        ->whereIn('created_by', $hod_ids)
                        ->whereIn('status', [1, 2])
                        ->where('form_status', $status)
                        ->get()
                        ->map(function ($form) {
                                if ($form->attach_evidence) {
                                    $form->attach_evidence = Storage::url($form->attach_evidence);
                                }
                                return $form;
                            });
                }

            }

            // Always return JSON if AJAX
            if ($request->ajax()) {
                return response()->json([
                    'forms' => $forms
                ]);
            }

            // Optionally, return Blade view for non-AJAX request
            return view('number_of_knowledge_products.index', compact('forms'));

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Oops! Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // 🔹 Store
    public function store(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'indicator_id' => 'required|exists:indicators,id',
            'form_status' => 'required|string',
            'product_type' => 'required|string',
            'url' => 'required|url',
            'attach_evidence' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $filePath = $request->file('attach_evidence')
            ->store('knowledge_products', 'public');

        NumberOfKnowledgeProduct::create([
            'indicator_id' => $request->indicator_id,
            'form_status' => $request->form_status,
            'product_type' => $request->product_type,
            'url' => $request->url,
            'attach_evidence' => $filePath,
            'created_by' => $userId,
            'updated_by' => $userId,
        ]);

        return back()->with('success', 'Number of Knowledge Product Added Successfully');
    }

    // 🔹 Edit (Check ownership)
    public function edit($id)
    {
        $product = NumberOfKnowledgeProduct::findOrFail($id);

        if ($product->created_by !== Auth::id()) {
            abort(403, 'Unauthorized Action');
        }

        return view('number_of_knowledge_products.edit', compact('product'));
    }

    // 🔹 Update (Check ownership)
    public function update(Request $request, $id)
    {
        try {
            if ($request->has('status_update_data')) {
                $product = NumberOfKnowledgeProduct::findOrFail($id);

                if ($product->created_by !== Auth::id()) {
                    abort(403, 'Unauthorized Action');
                }

                $request->validate([
                    'product_type' => 'required|string',
                    'url' => 'required|url',
                    'attach_evidence' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                ]);

                $data = [
                    'product_type' => $request->product_type,
                    'url' => $request->url,
                    'updated_by' => Auth::id(),
                ];

                if ($request->hasFile('attach_evidence')) {

                    if (
                        $product->attach_evidence &&
                        Storage::disk('public')->exists($product->attach_evidence)
                    ) {
                        Storage::disk('public')->delete($product->attach_evidence);
                    }

                    $data['attach_evidence'] = $request->file('attach_evidence')
                        ->store('knowledge_products', 'public');
                }

                $product->update($data);

                return response()->json([
                    'message' => 'Updated successfully'
                ]);
            } 
            if ($request->has('status_update')) {
                $request->validate([
                    'status' => 'required|in:1,2,3,4,5,6'
                ]);

                $target = NumberOfKnowledgeProduct::findOrFail($id);

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

    // 🔹 Destroy (Check ownership)
    public function destroy($id)
    {
        $product = NumberOfKnowledgeProduct::findOrFail($id);

        if ($product->created_by !== Auth::id()) {
            abort(403, 'Unauthorized Action');
        }

        if (
            $product->attach_evidence &&
            Storage::disk('public')->exists($product->attach_evidence)
        ) {
            Storage::disk('public')->delete($product->attach_evidence);
        }

        $product->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }

}
