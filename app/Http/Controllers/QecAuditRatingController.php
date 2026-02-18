<?php

namespace App\Http\Controllers;

use App\Models\QecAuditRating;
use App\Models\QecAuditRatingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class QecAuditRatingController extends Controller
{
    public function index()
    {
        $audits = QecAuditRating::with([
            'details.faculty',
            'details.department',
            'details.program'
        ])->latest()->get();

        return view(
            'admin.indicator_crud.qec_audit_rating',
            compact('audits')
        );
    }




    public function store(Request $request)
    {
        $request->validate([
            'indicator_id' => 'required',
            'remarks' => 'required',
            'audits.*.audit_term' => 'required',
            'audits.*.faculty_id' => 'required',
            'audits.*.department_id' => 'required',
            'audits.*.program_id' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $rating = QecAuditRating::create([
                'indicator_id' => $request->indicator_id,
                'user_id' => auth()->id(),
                'form_status' => $request->form_status,
                'remarks' => $request->remarks,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            foreach ($request->audits as $audit) {
                $rating->details()->create($audit);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'QEC Audit Rating submitted successfully'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $audit = QecAuditRating::with([
            'details.faculty',
            'details.department',
            'details.program'
        ])->findOrFail($id);

        return view('admin.indicator_crud.qec_audit_rating_edit', compact('audit'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'indicator_id' => 'required',
            'remarks' => 'required',
            'audits.*.audit_term' => 'required',
            'audits.*.faculty_id' => 'required',
            'audits.*.department_id' => 'required',
            'audits.*.program_id' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $rating = QecAuditRating::findOrFail($id);

            $rating->update([
                'indicator_id' => $request->indicator_id,
                'remarks' => $request->remarks,
                'updated_by' => auth()->id(),
            ]);

            // Delete old child records
            $rating->details()->delete();

            // Insert new child records
            foreach ($request->audits as $audit) {
                $rating->details()->create($audit);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'QEC Audit Rating updated successfully'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $rating = QecAuditRating::findOrFail($id);

            // delete child records first
            $rating->details()->delete();

            // delete parent
            $rating->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'QEC Audit Rating deleted successfully'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


}
