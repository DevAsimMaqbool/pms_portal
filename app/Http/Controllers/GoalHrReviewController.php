<?php

namespace App\Http\Controllers;

use App\Models\GoalSelfReport;
use App\Models\GoalOverallReview;
use App\Exports\GoalHrOverallPerformanceExport;
use App\Models\GoalHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;

class GoalHrReviewController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HR Goal List
    |--------------------------------------------------------------------------
    */

   public function index(Request $request)
{
    // Get available departments
    $departments = User::whereNotNull('hr_department_name')
        ->where('hr_department_name', '!=', '')
        ->distinct()
        ->orderBy('hr_department_name')
        ->pluck('hr_department_name');

    // Get selected departments
    $selectedDepartments = $request->input('department', []);

    if (!is_array($selectedDepartments)) {
        $selectedDepartments = [$selectedDepartments];
    }

    $selectedDepartments = array_values(
        array_filter($selectedDepartments)
    );

    $employees = User::whereHas('goalSelfReports', function ($query) {
            $query->where('status', 'manager_approved');
        })
        ->when(!empty($selectedDepartments), function ($query) use ($selectedDepartments) {

            $query->whereIn(
                'hr_department_name',
                $selectedDepartments
            );

        })
        ->with([
            'goalSelfReports' => function ($query) {
                $query->where('status', 'manager_approved')
                    ->with([
                        'goal.s2rDriver',
                        'reviews' => function ($query) {
                            $query->where(
                                'reviewer_type',
                                'manager'
                            )->latest('id');
                        },
                        'reviews.reviewer',
                    ]);
            },

            'goalOverallReviews' => function ($query) {
                $query->latest('id');
            },
        ])
        ->paginate(15)
        ->withQueryString();

    return view(
        'admin.goal-hr.index',
        compact(
            'employees',
            'departments'
        )
    );
}

    /*
    |--------------------------------------------------------------------------
    | HR Overall Review
    |--------------------------------------------------------------------------
    */

    public function show(User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | Get All Manager-Reviewed Goals
        |--------------------------------------------------------------------------
        */

        $reports = GoalSelfReport::where(
            'user_id',
            $user->id
        )
            ->where('status', 'manager_approved')
            ->with([
                'goal.s2rDriver',
                'reviews' => function ($query) {
                    $query->where(
                        'reviewer_type',
                        'manager'
                    )->latest('id');
                },
                'reviews.reviewer',
            ])
            ->latest('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Existing Overall HR Review
        |--------------------------------------------------------------------------
        */

        $overallReview = GoalOverallReview::where(
            'user_id',
            $user->id
        )
            ->latest('id')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Manager Overall Rating
        |--------------------------------------------------------------------------
        |
        | For now we calculate the manager's overall rating
        | from the ratings assigned against individual goals.
        |
        */

        $managerRatings = $reports
            ->pluck('manager_rating')
            ->filter(function ($rating) {
                return $rating !== null;
            });

        $managerOverallRating = $managerRatings->count()
            ? round($managerRatings->avg(), 2)
            : null;

        return view(
            'admin.goal-hr.review',
            compact(
                'user',
                'reports',
                'overallReview',
                'managerOverallRating'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Save HR Overall Moderation
    |--------------------------------------------------------------------------
    */

    public function review(Request $request, User $user)
    {
        $validated = $request->validate([
            'hr_overall_rating' => [
                'required',
                'integer',
                'min:0',
                'max:5',
            ],

            'decision' => [
                'required',
                'in:approved,rejected',
            ],

            'comments' => [
                'nullable',
                'string',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Get Manager Overall Rating
        |--------------------------------------------------------------------------
        */

        $managerRatings = GoalSelfReport::where(
            'user_id',
            $user->id
        )
            ->where('status', 'manager_approved')
            ->whereNotNull('manager_rating')
            ->pluck('manager_rating');

        $managerOverallRating = $managerRatings->count()
            ? round($managerRatings->avg(), 2)
            : null;
        /*
        |--------------------------------------------------------------------------
        | Save Overall HR Review
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use ($validated, $user, $managerOverallRating) {

            GoalOverallReview::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'reviewer_id' => Auth::id(),
                ],
                [
                    'manager_overall_rating' => $managerOverallRating,

                    'hr_overall_rating' =>
                        $validated['hr_overall_rating'],

                    'decision' =>
                        $validated['decision'],

                    'comments' =>
                        $validated['comments'] ?? null,

                    'reviewed_at' => now(),
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | History
            |--------------------------------------------------------------------------
            */

            GoalHistory::create([
                'new_goal_id' => null,
                'user_id' => Auth::id(),
                'action' =>
                    $validated['decision'] === 'approved'
                    ? 'HR Overall Performance Approved'
                    : 'HR Overall Performance Rejected',

                'from_status' => 'manager_approved',

                'to_status' =>
                    $validated['decision'] === 'approved'
                    ? 'hr_approved'
                    : 'hr_rejected',

                'comments' =>
                    $validated['comments'] ?? null,

                'metadata' => [
                    'employee_id' => $user->id,
                    'manager_overall_rating' =>
                        $managerOverallRating,
                    'hr_overall_rating' =>
                        $validated['hr_overall_rating'],
                ],
            ]);
        });

        return redirect()
            ->route(
                'goal-hr.show',
                $user
            )
            ->with(
                'success',
                'Overall performance moderation has been saved successfully.'
            );
    }

    public function export(Request $request)
{
    $departments = $request->input('department', []);

    if (!is_array($departments)) {
        $departments = [$departments];
    }

    $departments = array_values(
        array_filter($departments)
    );

    /*
    |--------------------------------------------------------------------------
    | Department Name for File
    |--------------------------------------------------------------------------
    */

    if (count($departments) === 0) {

        $departmentName = 'All_Departments';

    } elseif (count($departments) === 1) {

        $departmentName = $departments[0];

        if (str_contains($departmentName, '/')) {
            $departmentName = trim(
                last(explode('/', $departmentName))
            );
        }

    } else {

        $departmentName = 'Multiple_Departments';
    }

    /*
    |--------------------------------------------------------------------------
    | Safe File Name
    |--------------------------------------------------------------------------
    */

    $departmentName = preg_replace(
        '/[^A-Za-z0-9_-]+/',
        '_',
        $departmentName
    );

    $filename =
        'Overall_Performance_Report_' .
        $departmentName .
        '_' .
        now()->format('Y-m-d') .
        '.xlsx';

    /*
    |--------------------------------------------------------------------------
    | Download Excel
    |--------------------------------------------------------------------------
    */

    return Excel::download(
        new GoalHrOverallPerformanceExport($departments),
        $filename
    );
}

    public function exportPdf(Request $request)
{
    $departments = $request->input('department', []);

    if (!is_array($departments)) {
        $departments = [$departments];
    }

    $departments = collect($departments)
        ->filter()
        ->unique()
        ->values();

    /*
    |--------------------------------------------------------------------------
    | No department OR one department
    |--------------------------------------------------------------------------
    | Return a normal PDF.
    */
    if ($departments->count() <= 1) {

        $department = $departments->first();

        $rows = (new GoalHrOverallPerformanceExport(
            $department
        ))->collection();

        $departmentName = $department
            ? preg_replace(
                '/[^A-Za-z0-9_-]+/',
                '_',
                $department
            )
            : 'All_Departments';

        $filename =
            'Overall_Performance_Report_' .
            $departmentName .
            '_' .
            now()->format('Y-m-d') .
            '.pdf';

        $pdf = Pdf::loadView(
            'admin.goal-hr.overall_performance_pdf',
            [
                'rows' => $rows,
                'department' => $department,
            ]
        )->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }

    /*
    |--------------------------------------------------------------------------
    | Multiple departments
    |--------------------------------------------------------------------------
    | Generate a separate PDF for every selected department
    | and place all PDFs inside one ZIP file.
    */
    $zipName =
        'Overall_Performance_Reports_' .
        now()->format('Y-m-d') .
        '.zip';

    $zipPath = storage_path(
        'app/' . $zipName
    );

    $zip = new ZipArchive();

    if (
        $zip->open(
            $zipPath,
            ZipArchive::CREATE |
            ZipArchive::OVERWRITE
        ) !== true
    ) {
        abort(
            500,
            'Unable to create ZIP file.'
        );
    }

    foreach ($departments as $index => $department) {

        $rows = (new GoalHrOverallPerformanceExport(
            $department
        ))->collection();

        $pdf = Pdf::loadView(
            'admin.goal-hr.overall_performance_pdf',
            [
                'rows' => $rows,
                'department' => $department,
            ]
        )->setPaper('a4', 'landscape');

        $departmentName = preg_replace(
            '/[^A-Za-z0-9_-]+/',
            '_',
            $department
        );

        $departmentName = trim(
            $departmentName,
            '_'
        );

        if (!$departmentName) {
            $departmentName =
                'Department_' . ($index + 1);
        }

        $pdfFileName =
            'Overall_Performance_Report_' .
            $departmentName .
            '_' .
            now()->format('Y-m-d') .
            '.pdf';

        $zip->addFromString(
            $pdfFileName,
            $pdf->output()
        );
    }

    $zip->close();

    return response()
        ->download(
            $zipPath,
            $zipName
        )
        ->deleteFileAfterSend(true);
}
}