<?php

namespace App\Http\Controllers;

use App\Models\AchievementOfResearchPublicationsTarget;
use App\Models\Department;
use App\Models\Indicator;
use App\Models\IndicatorCategory;
use App\Models\KeyPerformanceArea;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class IndicatorController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // $indicators = Indicator::with('category.keyPerformanceArea')->get();
            $indicators = IndicatorCategory::with('indicators')->get();
            $KeyPerformanceArea = KeyPerformanceArea::select('id', 'performance_area')->get();
            if ($request->ajax()) {
                return response()->json([
                    'indicators' => $indicators,
                    'KeyPerformanceArea' => $KeyPerformanceArea,
                ]);
            }
            return view('admin.indicator');
        } catch (\Exception $e) {
            return apiResponse(
                'Oops! Something went wrong',
                [],
                false,
                500,
                ''
            );
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
        $request->validate([
            'key_performance_area' => 'required',
            'indicator_category' => 'required',
            'indicator' => 'required',
        ]);
        $userId = session('user_id');
        $categories = array_map('trim', explode(',', $request->indicator));
        // Create new complaint
        foreach ($categories as $category) {
            $IndicatorCategory = new Indicator();
            $IndicatorCategory->indicator_category_id = $request->indicator_category;
            $IndicatorCategory->indicator = $category;
            $IndicatorCategory->created_by = $userId;
            $IndicatorCategory->updated_by = $userId;
            $IndicatorCategory->save();
        }
        return response()->json(['message' => 'Indicator Category created successfully']);




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
        $category = IndicatorCategory::with('keyPerformanceArea')->findOrFail($id);
        $indicators = $category->indicators()->pluck('indicator');

        return response()->json([
            'id' => $category->id,
            'indicator_category' => $category->indicator_category,
            'key_performance_area_id' => $category->key_performance_area_id,
            'indicator' => $indicators->implode(','),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'key_performance_area' => 'required',
            'indicator_category' => 'required',
            'indicator' => 'required',
        ]);
        $userId = session('user_id');
        // Parse incoming indicators (comma-separated string to array)
        $newIndicators = array_filter(array_map('trim', explode(',', $request->indicator)));
        $existingIndicators = Indicator::where('indicator_category_id', $request->indicator_category)
            ->pluck('indicator')
            ->toArray();
        // Normalize arrays to lowercase for case-insensitive comparison
        $existingIndicatorsLower = array_map('strtolower', $existingIndicators);
        $newIndicatorsLower = array_map('strtolower', $newIndicators);
        // Add new indicators that don't already exist
        foreach ($newIndicators as $index => $indicator) {
            if (!in_array(strtolower($indicator), $existingIndicatorsLower)) {
                Indicator::create([
                    'indicator_category_id' => $request->indicator_category,
                    'indicator' => $indicator,
                    'created_by' => $userId,
                    'updated_by' => $userId,
                ]);
            }
        }

        // Delete indicators that were removed by the user
        foreach ($existingIndicators as $existingIndicator) {
            if (!in_array(strtolower($existingIndicator), $newIndicatorsLower)) {
                Indicator::where('indicator_category_id', $request->indicator_category)
                    ->where('indicator', $existingIndicator)
                    ->delete();
            }
        }

        return response()->json(['message' => 'Indicator updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        try {
            $IndicatorCategory = Indicator::findOrFail($id);
            $IndicatorCategory->delete();
            return response()->json(['status' => 'success', 'message' => 'Indicator deleted successfully']);
        } catch (\Exception $e) {
            return apiResponse(
                'Oops! Something went wrong',
                [],
                false,
                500,
                ''
            );
        }
    }
    public function getCategoriesByKPA($kpaId)
    {
        $categories = IndicatorCategory::where('key_performance_area_id', $kpaId)->get();
        return response()->json($categories);
    }
     public function indicator_form($areaId, $categoryId, $indicatorId)
    {
         try {
            return view('admin.form.form_display', compact('areaId', 'categoryId', 'indicatorId'));
        } catch (\Exception $e) {
            return apiResponse('Oops! Something went wrong', [], false, 500, '');
        }
    }
    public function indicator_form_store(Request $request)
    {
       
        $rules = [
            'kpa_id' => 'required',
            'sp_category_id' => 'required',
            'indicator_id' => 'required',
            'target_category' => 'required|string',
            'target_of_publications' => 'required|string',
            'progress_on_publication' => 'required|string',
            'draft_stage' => 'required_if:progress_on_publication,At draft stage|string|nullable',
            'email_screenshot' => 'required_if:progress_on_publication,In Review|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'scopus_link' => 'required_if:progress_on_publication,Published|nullable|url',
        ];

        $messages = [
            'scopus_link.url' => 'Please provide a valid URL for the Scopus link.',
            'email_screenshot.mimes' => 'Upload JPG / PNG / PDF only.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

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
            'target_category',
            'target_of_publications',
            'draft_stage',
            'scopus_link'
        ]);

        if ($request->hasFile('email_screenshot')) {
            $data['email_screenshot'] = $request->file('email_screenshot')->store('screenshots', 'public');
        }

        $employeeId = Auth::user()->employee_id;
        $data['created_by'] = $employeeId;
        $data['updated_by'] = $employeeId;

        $record = AchievementOfResearchPublicationsTarget::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Record saved successfully',
            'data' => $record
        ]);
    }
    // public function indicator_form_show(Request $request)
    // {
    //     try {
    //         $employee_id = Auth::user()->employee_id;

    //         // Step 1: Get employee IDs of users managed by this manager
    //         $employeeIds = User::where('manager_id', $employee_id)
    //             ->pluck('employee_id');

    //         // Step 2: Get forms + eager load creator's name
    //         $forms = AchievementOfResearchPublicationsTarget::with(['creator' => function ($q) {
    //                 $q->select('employee_id', 'name');
    //             }])
    //             ->whereIn('created_by', $employeeIds)
    //             ->get()
    //             ->map(function ($form) {
    //                 if ($form->email_screenshot) {
    //                     $form->email_screenshot_url = Storage::url($form->email_screenshot);
    //                 }
    //                 return $form;
    //             });
    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'forms' => $forms
    //             ]);
    //         }

    //         return view('admin.form.form_indicator_show');

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Oops! Something went wrong',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    public function indicator_form_show(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = Auth::id(); 
            $employee_id = $user->employee_id;

            if ($user->hasRole('Teacher')) {
                // Teacher: only own forms
                $forms = AchievementOfResearchPublicationsTarget::with(['creator' => function ($q) {
                        $q->select('employee_id', 'name');
                    }])
                    ->where('created_by', $userId)
                    ->get()
                    ->map(function ($form) {
                        if ($form->email_screenshot) {
                            $form->email_screenshot_url = Storage::url($form->email_screenshot);
                        }
                        return $form;
                    });

            } elseif ($user->hasRole('HOD')) {
                // HOD: forms of managed employees
                $employeeIds = User::where('manager_id', $employee_id)
                    ->pluck('employee_id');

                $forms = AchievementOfResearchPublicationsTarget::with(['creator' => function ($q) {
                        $q->select('employee_id', 'name');
                    }])
                    ->whereIn('created_by', $employeeIds)
                    ->whereIn('status', [1, 2])
                    ->get()
                    ->map(function ($form) {
                        if ($form->email_screenshot) {
                            $form->email_screenshot_url = Storage::url($form->email_screenshot);
                        }
                        return $form;
                    });

            } elseif ($user->hasRole('ORIC')) {
                // ORIC: only approved forms (status = 2)
                $forms = AchievementOfResearchPublicationsTarget::with(['creator' => function ($q) {
                        $q->select('employee_id', 'name');
                    }])
                    ->where('status', 2)
                    ->get()
                    ->map(function ($form) {
                        if ($form->email_screenshot) {
                            $form->email_screenshot_url = Storage::url($form->email_screenshot);
                        }
                        return $form;
                    });

            } else {
                $forms = collect();
            }

            if ($request->ajax()) {
                return response()->json([
                    'forms' => $forms
                ]);
            }

            return view('admin.form.form_indicator_show');

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Oops! Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:1,2,3'
        ]);

        $target = AchievementOfResearchPublicationsTarget::findOrFail($id);
        $target->status = $request->status;
        $target->updated_by = Auth::id();
        $target->save();

        return response()->json(['success' => true]);
    }
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:achievement_of_research_publications_target,id',
            'status' => 'required|in:1,2'
        ]);

        AchievementOfResearchPublicationsTarget::whereIn('id', $request->ids)
            ->update(['status' => $request->status, 'updated_by' => Auth::id()]);

        return response()->json(['success' => true]);
    }


}
