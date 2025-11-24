<?php

namespace App\Http\Controllers;

use App\Models\ProductsDeliveredToIndustry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductsDeliveredToIndustryController extends Controller
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
                        'project_name' => 'required|string',
                        'other_disciplines' => 'required|string',
                        'partner_industry' => 'required|string',
                        'identified_public_sector_entity' => 'required|string',
                        'completion_time_of_project' => 'required|string',
                        'product_developed' => 'required|in:YES,NO,NA',
                        'third_party_validation' => 'required|in:YES,NO,NA',
                        'ip_claim' => 'required|in:YES,NO',
                        'provide_details' => 'required_if:ip_claim,YES|string|nullable',
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
                            'indicator_id',
                            'project_name',
                            'other_disciplines',
                            'partner_industry',
                            'identified_public_sector_entity',
                            'completion_time_of_project',
                            'product_developed',
                            'third_party_validation',
                            'ip_claim',
                            'provide_details',
                            'form_status'
                        ]);
            }
            if($request->form_status=='HOD'){
                  $rules = [
                        'kpa_id' => 'required',
                        'sp_category_id' => 'required',
                        'indicator_id' => 'required',
                        'target_of_projects' => 'required|string',
                        'target_of_faculties' => 'required|string',
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
                            'target_of_projects',
                            'target_of_faculties',
                            'form_status'
                        ]);    

            }
            $employeeId = Auth::user()->employee_id;
            DB::beginTransaction();
            $data['created_by'] = $employeeId;
            $data['updated_by'] = $employeeId;

            $record = ProductsDeliveredToIndustry::create($data);
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
    public function show(ProductsDeliveredToIndustry $productsDeliveredToIndustry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductsDeliveredToIndustry $productsDeliveredToIndustry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductsDeliveredToIndustry $productsDeliveredToIndustry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductsDeliveredToIndustry $productsDeliveredToIndustry)
    {
        //
    }
}
