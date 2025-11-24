<?php

namespace App\Http\Controllers;

use App\Models\IndustrialProjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IndustrialProjectsController extends Controller
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
            if($request->form_status=='RESEARCHER'){
                 $rules = [
                        'indicator_id' => 'required',
                        'project_name' => 'required|string|max:255',
                        'contracting_industry' => 'required|string|max:255',
                        'project_duration' => 'required|integer',
                        'estimated_project_cost' => 'required|integer',
                        'estimated_complection' => 'required|date',
                        'attachment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];
                    $messages = [
                        'attachment.mimes' => 'Upload JPG / PNG / PDF only.',
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
                            'project_name',
                            'contracting_industry',
                            'project_duration',
                            'estimated_project_cost',
                            'estimated_complection',
                            'form_status'
                        ]); 
                    if ($request->hasFile('attachment')) {

                        $file = $request->file('attachment');
                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                        $uniqueNumber = rand(1000, 9999);
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $safeName . '_' . $uniqueNumber . '.' . $extension;
                        $path = $file->storeAs('industrialProject', $fileName, 'public');
                        $data['attachment'] = $path;
                    }
                       $employeeId = Auth::user()->employee_id;
                        DB::beginTransaction();
                        $data['created_by'] = $employeeId;
                        $data['updated_by'] = $employeeId;
                        $research = IndustrialProjects::create($data);
                       
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
    public function show(IndustrialProjects $industrialProjects)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IndustrialProjects $industrialProjects)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IndustrialProjects $industrialProjects)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IndustrialProjects $industrialProjects)
    {
        //
    }
}
