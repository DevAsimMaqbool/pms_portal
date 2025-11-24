<?php

namespace App\Http\Controllers;

use App\Models\NoOfGrantsSubmitAndWon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NoOfGrantsSubmitAndWonController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try { 
            $employeeId = Auth::user()->employee_id;
            if($request->form_status=='RESEARCHER'){
               
                  $rules = [
                        'indicator_id' => 'required|integer',
                        'grants' => 'required|array|min:1',
                        'grants.*.name' => 'required|string',
                        'grants.*.funding_agency' => 'required|string',
                        'grants.*.volume' => 'required|string',
                        'grants.*.role' => 'required|string',
                        'grants.*.grant_status' => 'required|string',
                        'grants.*.proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];

                    $messages = [
                        'grants.*.name.required' => 'Name Of Grant is required.',
                        'grants.*.funding_agency.required' => 'Funding Agency is required.',
                        'grants.*.volume.required' => 'Grant Volume is required.',
                        'grants.*.proof.mimes' => 'Upload JPG / PNG / PDF only.',
                    ];


                    $validator = Validator::make($request->all(), $rules, $messages);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                    }
                    $savedRecords = [];
                    foreach ($request->grants as $index => $grant) {

                        $filename = null;

                        if (isset($grant['proof']) && $grant['proof']) {

                            $file = $grant['proof'];

                            // ORIGINAL NAME WITHOUT EXTENSION
                            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

                            // REMOVE INVALID CHARACTERS
                            $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);

                            // RANDOM 4-DIGIT NUMBER
                            $uniqueNumber = rand(1000, 9999);

                            // EXTENSION
                            $extension = $file->getClientOriginalExtension();

                            // FINAL NAME: example → "misdoc_2345.pdf"
                            $filename = $safeName . '_' . $uniqueNumber . '.' . $extension;

                            // STORE FILE
                            $path = $file->storeAs('grants', $filename, 'public');

                            // SAVE FILE PATH
                            $filename = $path;
                        }

                        $savedRecords[] = NoOfGrantsSubmitAndWon::create([
                            'indicator_id'   => $request->indicator_id,
                            'name'           => $grant['name'],
                            'funding_agency' => $grant['funding_agency'],
                            'volume'         => $grant['volume'],
                            'role'           => $grant['role'],
                            'grant_status'   => $grant['grant_status'],
                            'proof'          => $filename, // PATH STORED
                            'form_status'    => $request->form_status ?? 'RESEARCHER',
                            'status'         => 1,
                            'created_by'     => $employeeId,
                            'updated_by'     => $employeeId,
                        ]);
                    }

                    return response()->json([ 'status' => 'success','message' => 'Co-authored papers saved successfully', 'data' => $savedRecords], 201);   
            }

        } catch (\Exception $e) {
               return response()->json(['status' => 'error', 'message' => 'Failed to save records','error' => $e->getMessage()], 500);
        }
    }
}
