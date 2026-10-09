<?php

namespace App\Services;

use App\Models\User;
use App\Models\Term;
use App\Models\IndicatorsPercentage;
use App\Models\FacultyTarget;
use App\Models\CompletionOfCourseFolder;
use App\Models\LineManagerFeedback;
use App\Models\LineManagerEventFeedback;
use App\Models\ResearchTaskAssignedHodDean;
use App\Models\AchievementOfResearchPublicationsTarget;
use App\Models\FacultyMemberClass;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class PmsIndicatorCalculationService
{
    /**
     * Roles which should be processed.
     */
    protected array $roleIds = [
        21,
        26,
        27,
        28,
    ];

    /**
     * Indicators used by these roles.
     */
    protected array $indicatorIds = [
        113,
        117,
        120,
        122,
        127,
        128,
        175,
        182,
        185,
        186,
        188,
        189,
        194,
        203,
    ];

    /**
     * Role => Indicator => Weightage
     */
    protected array $weightages = [];

    /**
     * Last no-data reason.
     */
    protected ?string $lastCalculationReason = null;

    /**
     * Indicator metadata.
     */
    protected array $indicatorMeta = [

        113 => [
            'kpa'      => 1,
            'category' => 3,
            'method'   => 'calculate113',
            'save'     => '90plus',
        ],

        117 => [
            'kpa'      => 1,
            'category' => 3,
            'method'   => 'calculate117',
            'save'     => 'attendance',
        ],

        120 => [
            'kpa'      => 1,
            'category' => 3,
            'method'   => 'calculate120',
            'save'     => '100plus',
        ],

        122 => [
            'kpa'      => 1,
            'category' => 3,
            'method'   => 'calculate122',
            'save'     => 'normal',
        ],

        127 => [
            'kpa'      => 2,
            'category' => 5,
            'method'   => 'calculate127',
            'save'     => 'normal',
        ],

        128 => [
            'kpa'      => 2,
            'category' => 5,
            'method'   => 'calculate128',
            'save'     => 'normal',
        ],

        175 => [
            'kpa'      => 2,
            'category' => 34,
            'method'   => 'calculate175',
            'save'     => 'normal',
        ],

        182 => [
            'kpa'      => 1,
            'category' => 23,
            'method'   => 'calculate182',
            'save'     => '90plus',
        ],

        185 => [
            'kpa'      => 1,
            'category' => 25,
            'method'   => 'calculate185',
            'save'     => '90plus',
        ],

        186 => [
            'kpa'      => 1,
            'category' => 25,
            'method'   => 'calculate186',
            'save'     => 'normal',
        ],

        188 => [
            'kpa'      => 13,
            'category' => 27,
            'method'   => 'calculate188',
            'save'     => 'normal',
        ],

        189 => [
            'kpa'      => 13,
            'category' => 28,
            'method'   => 'calculate189',
            'save'     => 'normal',
        ],

        194 => [
            'kpa'      => 2,
            'category' => 32,
            'method'   => 'calculate194',
            'save'     => 'normal',
        ],

        203 => [
            'kpa'      => 2,
            'category' => 5,
            'method'   => 'calculate203',
            'save'     => 'normal',
        ],
    ];

    /**
     * Current PMS year.
     */
    protected int $yearId = 1;

    /**
     * Active term IDs.
     */
    protected array $activeTermIds = [];

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->loadWeightages();
        $this->loadTerms();
    }

    /**
     * -------------------------------------------------------------
     * NO DATA HELPER
     * -------------------------------------------------------------
     */
    protected function noData(string $reason): ?array
    {
        $this->lastCalculationReason = $reason;

        return null;
    }

    /**
     * -------------------------------------------------------------
     * LOAD ROLE WEIGHTAGES
     * -------------------------------------------------------------
     */
    protected function loadWeightages(): void
    {
        $rows = DB::table('role_kpa_assignments')
            ->whereIn('role_id', $this->roleIds)
            ->whereIn('indicator_id', $this->indicatorIds)
            ->select([
                'role_id',
                'indicator_id',
                'indicator_weightage',
            ])
            ->get();

        foreach ($rows as $row) {

            $roleId = (int) $row->role_id;
            $indicatorId = (int) $row->indicator_id;

            $this->weightages[$roleId][$indicatorId] =
                (float) ($row->indicator_weightage ?? 0);
        }
    }

    /**
     * -------------------------------------------------------------
     * LOAD ACTIVE TERMS
     * -------------------------------------------------------------
     */
    protected function loadTerms(): void
{
    $this->activeTermIds = DB::table('terms')
        ->where('status', '1')
        ->pluck('id')
        ->map(fn ($id) => (int) $id)
        ->values()
        ->toArray();

    Log::info('PMS Active Terms Loaded', [
        'active_term_ids' => $this->activeTermIds,
    ]);
}

    /**
     * -------------------------------------------------------------
     * GET WEIGHT
     * -------------------------------------------------------------
     */
    protected function getWeight(
        int $roleId,
        int $indicatorId
    ): float {
        return (float) (
            $this->weightages[$roleId][$indicatorId] ?? 0
        );
    }

    /**
     * -------------------------------------------------------------
     * WEIGHTED SCORE
     * -------------------------------------------------------------
     */
    protected function weighted(
        float $rawScore,
        float $weight
    ): float {
        return round(
            ($rawScore * $weight) / 100,
            2
        );
    }

    /**
     * -------------------------------------------------------------
     * PROCESS ONE EMPLOYEE
     * -------------------------------------------------------------
     */
    public function calculateForEmployee(User $employee): array
    {
        $result = [
            'employee_id' => $employee->employee_id,
            'user_id'     => $employee->id,
            'faculty_id'  => $employee->faculty_id,
            'name'        => $employee->name,

            'processed'   => 0,
            'saved'       => 0,
            'skipped'     => 0,
            'failed'      => 0,

            'indicators'  => [],
        ];

        if (!$employee->relationLoaded('roles')) {
            $employee->load('roles');
        }

        foreach ($this->roleIds as $roleId) {

            if (!$employee->roles->contains('id', $roleId)) {
                continue;
            }

            foreach ($this->indicatorMeta as $indicatorId => $meta) {

                $indicatorId = (int) $indicatorId;

                $result['processed']++;

                /**
                 * Role / indicator assignment check.
                 */
                if (!isset(
                    $this->weightages[$roleId][$indicatorId]
                )) {

                    $result['skipped']++;

                    $result['indicators'][] = [
                        'role_id'      => $roleId,
                        'indicator_id' => $indicatorId,
                        'status'       => 'NOT ASSIGNED',
                        'message'      =>
                            'Indicator not found in role_kpa_assignments',
                    ];

                    continue;
                }

                try {

                    /**
                     * Reset previous reason.
                     */
                    $this->lastCalculationReason = null;

                    $method = $meta['method'];

                    if (!method_exists($this, $method)) {

                        throw new \RuntimeException(
                            "Calculation method {$method} does not exist"
                        );
                    }

                    /**
                     * Execute calculation.
                     */
                    $calculation = $this->{$method}(
                        $employee,
                        $roleId,
                        $indicatorId
                    );

                    /**
 * No source data.
 *
 * If calculation returns null, save zero instead
 * of skipping the indicator.
 */
if ($calculation === null) {

    $rawScore = 0.0;

    $weightedScore = 0.0;

    /**
     * Save zero result using the same existing
     * saveIndicator() functionality.
     */
    $this->saveIndicator(
        employee: $employee,
        roleId: $roleId,
        indicatorId: $indicatorId,
        kpaId: (int) $meta['kpa'],
        categoryId: (int) $meta['category'],
        weightedScore: $weightedScore,
        rawScore: $rawScore,
        saveType: $meta['save'] ?? 'normal'
    );

    $result['saved']++;

    $result['indicators'][] = [
        'role_id' =>
            $roleId,

        'indicator_id' =>
            $indicatorId,

        'status' =>
            'SAVED',

        'raw_score' =>
            0,

        'weightage' =>
            $this->getWeight(
                $roleId,
                $indicatorId
            ),

        'weighted_score' =>
            0,

        'message' =>
            $this->lastCalculationReason
            ?? 'No source data found. Saved as 0.',
    ];

    continue;
}

                    $rawScore = (float) (
                        $calculation['raw_score'] ?? 0
                    );

                    $weightedScore = (float) (
                        $calculation['weighted_score'] ?? 0
                    );

                    /**
                     * Save result.
                     */
                    $this->saveIndicator(
                        employee: $employee,
                        roleId: $roleId,
                        indicatorId: $indicatorId,
                        kpaId: (int) $meta['kpa'],
                        categoryId: (int) $meta['category'],
                        weightedScore: $weightedScore,
                        rawScore: $rawScore,
                        saveType: $meta['save'] ?? 'normal'
                    );

                    $result['saved']++;

                    $result['indicators'][] = [
                        'role_id' =>
                            $roleId,

                        'indicator_id' =>
                            $indicatorId,

                        'status' =>
                            'SAVED',

                        'raw_score' =>
                            round($rawScore, 2),

                        'weightage' =>
                            $this->getWeight(
                                $roleId,
                                $indicatorId
                            ),

                        'weighted_score' =>
                            round(
                                $weightedScore,
                                2
                            ),
                    ];

                } catch (Throwable $e) {

                    $result['failed']++;

                    $result['indicators'][] = [
                        'role_id' =>
                            $roleId,

                        'indicator_id' =>
                            $indicatorId,

                        'status' =>
                            'FAILED',

                        'message' =>
                            $e->getMessage(),

                        'file' =>
                            basename($e->getFile()),

                        'line' =>
                            $e->getLine(),
                    ];

                    Log::error(
                        'PMS indicator calculation failed',
                        [
                            'employee_id' =>
                                $employee->employee_id,

                            'user_id' =>
                                $employee->id,

                            'faculty_id' =>
                                $employee->faculty_id,

                            'role_id' =>
                                $roleId,

                            'indicator_id' =>
                                $indicatorId,

                            'method' =>
                                $method ?? null,

                            'error' =>
                                $e->getMessage(),

                            'file' =>
                                $e->getFile(),

                            'line' =>
                                $e->getLine(),
                        ]
                    );
                }
            }
        }

        Log::info(
            'PMS indicator calculation completed',
            [
                'employee_id' =>
                    $employee->employee_id,

                'user_id' =>
                    $employee->id,

                'faculty_id' =>
                    $employee->faculty_id,

                'processed' =>
                    $result['processed'],

                'saved' =>
                    $result['saved'],

                'skipped' =>
                    $result['skipped'],

                'failed' =>
                    $result['failed'],
            ]
        );

        return $result;
    }

    /**
     * -------------------------------------------------------------
     * INDICATOR 113
     *
     * Uses faculty_id.
     *
     * Student attendance / presence percentage.
     * -------------------------------------------------------------
     */
    protected function calculate113(
    User $employee,
    int $roleId,
    int $indicatorId
): ?array {

    $facultyId = $employee->faculty_id;

    if (!$facultyId) {
        return $this->noData(
            'faculty_id is missing for employee'
        );
    }

    $termScores = [];

    foreach ($this->activeTermIds as $termId) {

        if (!$termId) {
            continue;
        }

        /*
         * Use the exact same relationship as
         * myClassesAttendanceData()
         */
        $classes = FacultyMemberClass::with('attendances')
            ->where('faculty_id', $facultyId)
            ->where('term_id', $termId)
            ->get();

        if ($classes->isEmpty()) {
            continue;
        }

        /*
         * Same calculation as myClassesAttendanceData():
         *
         * Total Present
         * ---------------- x 100
         * Total Students
         */
        $totalPresent = $classes
            ->flatMap->attendances
            ->sum('present_count');

        $totalStudents = $classes
            ->flatMap->attendances
            ->sum('total_students');

        if ((float) $totalStudents <= 0) {
            continue;
        }

        $score = (
            (float) $totalPresent /
            (float) $totalStudents
        ) * 100;

        $termScores[] = round(
            min(100, $score),
            2
        );
    }

    /*
     * No Spring/Fall attendance data
     */
    if (!$termScores) {
        return $this->noData(
            "No attendance student data found for faculty_id {$facultyId} in active Spring/Fall terms"
        );
    }

    /*
     * If both terms exist:
     *
     * Spring Score + Fall Score
     * --------------------------
     *             2
     *
     * If only one term exists, use that term.
     */
    $rawScore = count($termScores) === 1
        ? $termScores[0]
        : round(
            array_sum($termScores) / count($termScores),
            2
        );

    /*
     * Role-specific indicator weightage
     */
    $weight = $this->getWeight(
        $roleId,
        $indicatorId
    );

    return [
        'raw_score' => $rawScore,

        'weighted_score' => $this->weighted(
            $rawScore,
            $weight
        ),
    ];
}

protected function calculate117(
    User $employee,
    int $roleId,
    int $indicatorId
): ?array {

    if (!$employee->faculty_id) {
        return $this->noData(
            'faculty_id is missing for employee'
        );
    }

    // Get active Spring and Fall terms.
    $activeTerms = Term::query()
        ->where('status', '1')
        ->whereIn('term', ['Spring', 'Fall'])
        ->get()
        ->keyBy('term');

    $springTerm = $activeTerms->get('Spring');
    $fallTerm = $activeTerms->get('Fall');

    /*
    |--------------------------------------------------------------------------
    | Calculate the average held percentage for one term.
    |--------------------------------------------------------------------------
    */
    $calculateTermScore = function ($termId) use ($employee) {

        if (!$termId) {
            return 0.0;
        }

        $classes = FacultyMemberClass::query()
            ->where('faculty_id', $employee->faculty_id)
            ->where('term_id', $termId)
            ->with('attendances')
            ->withCount([
                'attendances as total_rows',

                'attendances as class_held_count' => function ($query) {
                    $query->where('att_marked', 1);
                },

                'attendances as class_not_held_count' => function ($query) {
                    $query->where('att_marked', 0);
                },
            ])
            ->get()
            ->map(function ($class) {

                $class->total_classes = $class->attendances->count();

                $class->held_percentage =
                    $class->class_held_count >= 16
                        ? 100
                        : (
                            $class->total_rows
                                ? round(
                                    ($class->class_held_count / 16) * 100,
                                    2
                                )
                                : 0
                        );

                return $class;
            })
            // Match myClassesAttendanceRecord(): exclude classes
            // that have no attendance records.
            ->filter(function ($class) {
                return $class->total_classes > 0;
            })
            ->values();

        if ($classes->isEmpty()) {
            return 0.0;
        }

        return round(
            (float) $classes->avg('held_percentage'),
            2
        );
    };

    // Calculate each term independently, just like Blade.
    $springScore = $calculateTermScore(
        $springTerm?->id
    );

    $fallScore = $calculateTermScore(
        $fallTerm?->id
    );

    /*
    |--------------------------------------------------------------------------
    | Apply the exact overall-score conditions from Blade.
    |--------------------------------------------------------------------------
    */
    if ($springScore > 0 && $fallScore > 0) {

        $rawScore = round(
            ($springScore + $fallScore) / 2,
            2
        );

    } elseif ($springScore > 0) {

        $rawScore = $springScore;

    } elseif ($fallScore > 0) {

        $rawScore = $fallScore;

    } else {

        $rawScore = 0.0;
    }

    // Apply the existing role-specific indicator weightage.
    $weight = $this->getWeight($roleId, $indicatorId);

    return [
        'raw_score' => $rawScore,
        'weighted_score' => $this->weighted(
            $rawScore,
            $weight
        ),
    ];
}
    
    /**
     * -------------------------------------------------------------
     * INDICATOR 120
     *
     * Uses employee_id.
     *
     * Completion of course folder.
     * -------------------------------------------------------------
     */
    protected function calculate120(
        User $employee,
        int $roleId,
        int $indicatorId
    ): ?array {

        $employeeId = $employee->employee_id;

        if (!$employeeId) {
            return $this->noData(
                'employee_id is missing'
            );
        }

        $termScores = [];

        foreach ($this->activeTermIds as $termId) {

            if (!$termId) {
                continue;
            }

            $score = CompletionOfCourseFolder::query()
                ->where(
                    'faculty_member_id',
                    $employeeId
                )
                ->where(
                    'form_status',
                    'HOD'
                )
                ->where(
                    'status',
                    2
                )
                ->where(
                    'term_id',
                    $termId
                )
                ->where(
                    'completion_of_Course_folder_indicator_id',
                    $indicatorId
                )
                ->avg(
                    'completion_of_Course_folder'
                );

            if ($score === null) {
                continue;
            }

            $termScores[] =
                round(
                    min(
                        100,
                        (float) $score
                    ),
                    2
                );
        }

        if (!$termScores) {
            return $this->noData(
                'No completion of course folder data found'
            );
        }

        $rawScore =
            count($termScores) === 1
                ? $termScores[0]
                : round(
                    array_sum($termScores) /
                    count($termScores),
                    2
                );

        $weight =
            $this->getWeight(
                $roleId,
                $indicatorId
            );

        return [
            'raw_score' =>
                $rawScore,

            'weighted_score' =>
                $this->weighted(
                    $rawScore,
                    $weight
                ),
        ];
    }

    /**
     * -------------------------------------------------------------
     * COURSE STATISTICS
     *
     * Uses faculty_id.
     * -------------------------------------------------------------
     */
    protected function getCourseStatistics(
        int $facultyId,
        int $termId
    ): ?object {

        return DB::table(
            'faculty_member_classes as fmc'
        )
            ->where(
                'fmc.faculty_id',
                $facultyId
            )
            ->where(
                'fmc.term_id',
                $termId
            )
            ->selectRaw(
                '
                COUNT(*) as total_courses,

                AVG(
                    COALESCE(
                        fmc.passing_percentage,
                        0
                    )
                ) as avg_pass,

                AVG(
                    COALESCE(
                        fmc.average_marks,
                        0
                    )
                ) as avg_marks
                '
            )
            ->first();
    }

    /**
     * -------------------------------------------------------------
     * COURSE RAW SCORES
     *
     * Uses faculty_id.
     * -------------------------------------------------------------
     */
    protected function getCourseRawScores(
        User $employee
    ): ?array {

        $facultyId =
            $employee->faculty_id;

        if (!$facultyId) {
            return null;
        }

        $scores = [];

        foreach ($this->activeTermIds as $termId) {

            if (!$termId) {
                continue;
            }

            $row =
                $this->getCourseStatistics(
                    $facultyId,
                    $termId
                );

            if (
                !$row ||
                (int) $row->total_courses <= 0
            ) {
                continue;
            }

            $totalCourses =
                (int) $row->total_courses;

            /*
             * Original formula:
             *
             * > 3  = 100
             * == 3 = 80
             * else = 60
             */
            $courseLoadScore =
                $totalCourses > 3
                    ? 100
                    : (
                        $totalCourses === 3
                            ? 80
                            : 60
                    );

            $scores[] = [
                'course_load' =>
                    $courseLoadScore,

                'pass' =>
                    (float) $row->avg_pass,

                'marks' =>
                    (float) $row->avg_marks,
            ];
        }

        return $scores ?: null;
    }
/**
 * -------------------------------------------------------------
 * VALID COURSE RAW SCORES FOR INDICATORS 185 AND 186
 *
 * Excludes courses where total attendance students = 0.
 * Processes active Spring and Fall terms only.
 *
 * IMPORTANT:
 * This is a separate helper so Indicator 122 remains unchanged.
 * -------------------------------------------------------------
 */
protected function getValidCourseRawScoresFor185And186(
    User $employee
): ?array {

    $facultyId = $employee->faculty_id;

    if (!$facultyId) {
        return null;
    }

    /*
     * Match the existing Blade logic:
     * Only active Spring and Fall terms.
     */
    $terms = Term::query()
        ->where('status', '1')
        ->whereIn('term', ['Spring', 'Fall'])
        ->get(['id', 'term']);

    $scores = [];

    foreach ($terms as $term) {

        $classes = FacultyMemberClass::query()
            ->where('faculty_id', $facultyId)
            ->where('term_id', $term->id)
            ->with('attendances')
            ->get();

        /*
         * Exclude courses whose total student count is zero.
         * This matches the existing Blade filtering.
         */
        $validClasses = $classes->filter(
            function ($class) {
                return $class->attendances
                    ->sum('total_students') > 0;
            }
        );

        /*
         * No valid courses in this term.
         */
        if ($validClasses->isEmpty()) {
            continue;
        }

        $scores[$term->term] = [
            'pass' => (float) $validClasses->avg(
                function ($class) {
                    return (float) (
                        $class->passing_percentage ?? 0
                    );
                }
            ),

            'marks' => (float) $validClasses->avg(
                function ($class) {
                    return (float) (
                        $class->average_marks ?? 0
                    );
                }
            ),
        ];
    }

    return $scores ?: null;
}

    /**
     * -------------------------------------------------------------
     * INDICATOR 122
     *
     * Uses faculty_id.
     * -------------------------------------------------------------
     */
    protected function calculate122(
        User $employee,
        int $roleId,
        int $indicatorId
    ): ?array {

        if (!$employee->faculty_id) {
            return $this->noData(
                'faculty_id is missing for employee'
            );
        }

        $scores =
            $this->getCourseRawScores(
                $employee
            );

        if (!$scores) {
            return $this->noData(
                'No faculty classes found for active Spring/Fall terms'
            );
        }

        $rawScores =
            array_column(
                $scores,
                'course_load'
            );

        $rawScore =
            count($rawScores) === 1
                ? $rawScores[0]
                : round(
                    array_sum($rawScores) /
                    count($rawScores),
                    2
                );

        $weight =
            $this->getWeight(
                $roleId,
                $indicatorId
            );

        return [
            'raw_score' =>
                $rawScore,

            'weighted_score' =>
                $this->weighted(
                    $rawScore,
                    $weight
                ),
        ];
    }

    /**
 * -------------------------------------------------------------
 * INDICATOR 185
 *
 * Average Pass Percentage.
 *
 * Excludes courses with zero total students.
 * Averages Spring and Fall scores using existing Blade logic.
 * -------------------------------------------------------------
 */
protected function calculate185(
    User $employee,
    int $roleId,
    int $indicatorId
): ?array {

    if (!$employee->faculty_id) {
        return $this->noData(
            'faculty_id is missing for employee'
        );
    }

    $scores = $this->getValidCourseRawScoresFor185And186(
        $employee
    );

    if (!$scores) {
        return $this->noData(
            'No valid faculty classes with students found in active Spring/Fall terms'
        );
    }

    /*
     * Match Blade logic:
     * Only positive term averages are used.
     */
    $springAvg = (float) (
        $scores['Spring']['pass'] ?? 0
    );

    $fallAvg = (float) (
        $scores['Fall']['pass'] ?? 0
    );

    if ($springAvg > 0 && $fallAvg > 0) {

        $rawScore = ($springAvg + $fallAvg) / 2;

    } elseif ($springAvg > 0) {

        $rawScore = $springAvg;

    } elseif ($fallAvg > 0) {

        $rawScore = $fallAvg;

    } else {

        $rawScore = 0;
    }

    $rawScore = round(
        min(100, $rawScore),
        2
    );

    $weight = $this->getWeight(
        $roleId,
        $indicatorId
    );

    return [
        'raw_score' => $rawScore,

        'weighted_score' => $this->weighted(
            $rawScore,
            $weight
        ),
    ];
}

    /**
 * -------------------------------------------------------------
 * INDICATOR 186
 *
 * Average Student Marks.
 *
 * Excludes courses with zero total students.
 * Averages available Spring and Fall term scores.
 * -------------------------------------------------------------
 */
protected function calculate186(
    User $employee,
    int $roleId,
    int $indicatorId
): ?array {

    if (!$employee->faculty_id) {
        return $this->noData(
            'faculty_id is missing for employee'
        );
    }

    $scores = $this->getValidCourseRawScoresFor185And186(
        $employee
    );

    if (!$scores) {
        return $this->noData(
            'No valid faculty classes with students found in active Spring/Fall terms'
        );
    }

    /*
     * Match Blade logic:
     * Average both terms when both have valid courses.
     * Otherwise use the available term.
     */
    $hasSpring = isset($scores['Spring']);
    $hasFall = isset($scores['Fall']);

    $springAvg = (float) (
        $scores['Spring']['marks'] ?? 0
    );

    $fallAvg = (float) (
        $scores['Fall']['marks'] ?? 0
    );

    if ($hasSpring && $hasFall) {

        $rawScore = ($springAvg + $fallAvg) / 2;

    } elseif ($hasSpring) {

        $rawScore = $springAvg;

    } elseif ($hasFall) {

        $rawScore = $fallAvg;

    } else {

        return $this->noData(
            'No valid Spring/Fall course marks found'
        );
    }

    $rawScore = round(
        min(100, $rawScore),
        2
    );

    $weight = $this->getWeight(
        $roleId,
        $indicatorId
    );

    return [
        'raw_score' => $rawScore,

        'weighted_score' => $this->weighted(
            $rawScore,
            $weight
        ),
    ];
}

    /**
     * -------------------------------------------------------------
     * PUBLICATION DATA
     *
     * Uses employee_id.
     * -------------------------------------------------------------
     */
    protected function getPublicationData(
    int $employeeId,
    int $indicatorId
): ?array {

    $target = FacultyTarget::query()
        ->where('user_id', $employeeId)
        ->where('form_status', 'HOD')
        ->where('year_id', $this->yearId)
        ->where('indicator_id', $indicatorId)
        ->sum('target');

    if ((float) $target <= 0) {
        return null;
    }

    $publications = AchievementOfResearchPublicationsTarget::query()
        ->where('created_by', $employeeId)
        ->whereIn('form_status', ['RESEARCHER', 'DEAN'])
        ->where('status', 3)
        ->where('year_id', $this->yearId)
        ->where('indicator_id', $indicatorId)
        ->whereNotNull('journal_clasification');

    return [
        'target' => (float) $target,
        'submitted' => (int) (clone $publications)->count(),
        'query' => $publications,
    ];
}
/**

* ---
* INDICATOR 127 — INTERNATIONAL SCOPUS PUBLICATIONS
*
* Source data: Indicator 128 (Scopus Publications)
* Saved result: Indicator 127
*
* Formula:
* International Publications / Total Target * 100
*
* Maximum raw score = 100
* ---

*/
protected function calculate127(
User $employee,
int $roleId,
int $indicatorId
): ?array {

$employeeId = $employee->employee_id;

if (!$employeeId) {
    return $this->noData(
        'employee_id is missing'
    );
}

// Indicator 127 derives its publication data from indicator 128.
$sourceIndicatorId = 128;

$facultyTargets = FacultyTarget::query()
    ->where('user_id', $employeeId)
    ->where('form_status', 'HOD')
    ->where('year_id', $this->yearId)
    ->where('indicator_id', $sourceIndicatorId)
    ->with([
        'researchPublicationTargets' => function ($query) use (
            $sourceIndicatorId
        ) {
            $query
                ->whereIn('form_status', ['RESEARCHER', 'DEAN'])
                ->where('indicator_id', $sourceIndicatorId)
                ->where('year_id', $this->yearId)
                ->where('status', 3)
                ->whereNotNull('journal_clasification');
        },
    ])
    ->get();

$totalTarget = (float) $facultyTargets->sum(
    fn ($target) => (float) ($target->target ?? 0)
);

$totalSubmitted = 0;
$internationalPapers = 0;

foreach ($facultyTargets as $facultyTarget) {
    $publications = $facultyTarget->researchPublicationTargets;

    $totalSubmitted += $publications->count();

    $internationalPapers += $publications
        ->filter(function ($publication) {
            return strtolower(
                trim((string) ($publication->nationality ?? ''))
            ) === 'international';
        })
        ->count();
}

$rawScore = $totalTarget > 0
    ? round(($internationalPapers / $totalTarget) * 100, 2)
    : 0.0;

$rawScore = min(100, $rawScore);

$weight = $this->getWeight($roleId, $indicatorId);

return [
    'raw_score' => $rawScore,
    'weighted_score' => $this->weighted($rawScore, $weight),
];
}

    /**
 * -------------------------------------------------------------
 * INDICATOR 128
 *
 * Scopus Publications.
 *
 * Formula:
 *
 * Total Approved Scopus Publications
 * ---------------------------------- x 100
 *          Total Target
 *
 * Maximum raw score = 100
 *
 * Target:
 * - FacultyTarget.user_id = employee_id
 * - FacultyTarget.form_status = HOD
 * - FacultyTarget.year_id = PMS year
 * - FacultyTarget.indicator_id = 128
 *
 * Publications:
 * - created_by = employee_id
 * - form_status IN (RESEARCHER, DEAN)
 * - status = 3
 * - year_id = PMS year
 * - indicator_id = 128
 * - journal_clasification IS NOT NULL
 * -------------------------------------------------------------
 */
protected function calculate128(
    User $employee,
    int $roleId,
    int $indicatorId
): ?array {

    $employeeId = $employee->employee_id;

    if (!$employeeId) {
        return $this->noData(
            'employee_id is missing'
        );
    }

    /*
     * ---------------------------------------------------------
     * Get target + approved publications
     * ---------------------------------------------------------
     */
    $data = $this->getPublicationData(
        $employeeId,
        $indicatorId
    );

    if (!$data) {
        return $this->noData(
            'No HOD FacultyTarget found for indicator 128'
        );
    }

    /*
     * ---------------------------------------------------------
     * Total approved Scopus publications
     * ---------------------------------------------------------
     */
    $totalSubmitted = (int) $data['submitted'];

    /*
     * ---------------------------------------------------------
     * Calculate percentage
     * ---------------------------------------------------------
     *
     * Example:
     *
     * Target = 5
     * Submitted = 4
     *
     * 4 / 5 × 100 = 80
     */
    $rawScore = (
        $totalSubmitted /
        $data['target']
    ) * 100;

    /*
     * Maximum raw score = 100
     */
    $rawScore = min(
        100,
        round(
            $rawScore,
            2
        )
    );

    /*
     * ---------------------------------------------------------
     * Role-specific indicator weight
     * ---------------------------------------------------------
     */
    $weight = $this->getWeight(
        $roleId,
        $indicatorId
    );

    /*
     * ---------------------------------------------------------
     * Weighted score
     * ---------------------------------------------------------
     */
    $weightedScore = $this->weighted(
        $rawScore,
        $weight
    );

    return [
        'raw_score' => $rawScore,

        'weighted_score' => $weightedScore,
    ];
}

    /**
     * -------------------------------------------------------------
     * INDICATOR 175
     *
     * Uses employee_id.
     * -------------------------------------------------------------
     */
    protected function calculate175(
        User $employee,
        int $roleId,
        int $indicatorId
    ): ?array {

        $employeeId =
            $employee->employee_id;

        if (!$employeeId) {
            return $this->noData(
                'employee_id is missing'
            );
        }

        $records =
            ResearchTaskAssignedHodDean::query()
                ->where(
                    'employee_id',
                    $employeeId
                )
                ->where(
                    'year_id',
                    $this->yearId
                )
                ->where(
                    'form_status',
                    'OTHER'
                )
                ->with('tasks')
                ->get();

        if ($records->isEmpty()) {
            return $this->noData(
                'No research task assignment records found'
            );
        }

        $taskScores = [];

        foreach ($records as $record) {

            foreach (
                $record->tasks ?? []
                as $task
            ) {

                if (
                    $task->linemanager_rating === null
                ) {
                    continue;
                }

                $score =
                    (float) $task->linemanager_rating
                    * 20;

                $taskScores[] =
                    min(
                        100,
                        $score
                    );
            }
        }

        if (!$taskScores) {
            return $this->noData(
                'Research tasks found but no line manager ratings found'
            );
        }

        $rawScore =
            round(
                array_sum($taskScores) /
                count($taskScores),
                2
            );

        $weight =
            $this->getWeight(
                $roleId,
                $indicatorId
            );

        return [
            'raw_score' =>
                $rawScore,

            'weighted_score' =>
                $this->weighted(
                    $rawScore,
                    $weight
                ),
        ];
    }

    /**
     * -------------------------------------------------------------
     * INDICATOR 182
     *
     * Uses faculty_id.
     *
     * Student feedback.
     * -------------------------------------------------------------
     */
    protected function calculate182(
        User $employee,
        int $roleId,
        int $indicatorId
    ): ?array {

        $facultyId =
            $employee->faculty_id;

        if (!$facultyId) {
            return $this->noData(
                'faculty_id is missing for employee'
            );
        }

        $termIds = $this->activeTermIds;

        if (!$termIds) {
            return $this->noData(
                'No active Spring/Fall term found'
            );
        }

        $row =
            DB::table(
                'student_feedback_class_wises as sf'
            )
                ->join(
                    'faculty_member_classes as fmc',
                    'fmc.code',
                    '=',
                    'sf.component_class'
                )
                ->where(
                    'fmc.faculty_id',
                    $facultyId
                )
                ->whereIn(
                    'fmc.term_id',
                    $termIds
                )
                ->selectRaw(
                    '
                    COALESCE(
                        SUM(
                            CAST(
                                REPLACE(
                                    COALESCE(
                                        sf.feedback,
                                        "0"
                                    ),
                                    "%",
                                    ""
                                ) AS DECIMAL(12,4)
                            )
                            *
                            COALESCE(
                                sf.attempts,
                                0
                            )
                        ),
                        0
                    ) as total_multiplication,

                    COALESCE(
                        SUM(
                            COALESCE(
                                sf.attempts,
                                0
                            )
                        ),
                        0
                    ) as total_attempts
                    '
                )
                ->first();

        if (
            !$row ||
            (float) $row->total_attempts <= 0
        ) {
            return $this->noData(
                'No student feedback attempts found'
            );
        }

        $rawScore =
            (
                (float) $row->total_multiplication /
                (float) $row->total_attempts
            );

        $rawScore =
            min(
                100,
                round(
                    $rawScore,
                    2
                )
            );

        $weight =
            $this->getWeight(
                $roleId,
                $indicatorId
            );

        return [
            'raw_score' =>
                $rawScore,

            'weighted_score' =>
                $this->weighted(
                    $rawScore,
                    $weight
                ),
        ];
    }

    /**
     * -------------------------------------------------------------
     * INDICATOR 188
     *
     * Uses employee_id.
     * -------------------------------------------------------------
     */
    protected function calculate188(
        User $employee,
        int $roleId,
        int $indicatorId
    ): ?array {

        $employeeId =
            $employee->employee_id;

        if (!$employeeId) {
            return $this->noData(
                'employee_id is missing'
            );
        }

        $records =
            LineManagerFeedback::query()
                ->where(
                    'employee_id',
                    $employeeId
                )
                ->where(
                    'year_id',
                    $this->yearId
                )
                ->get();

        if ($records->isEmpty()) {
            return $this->noData(
                'No line manager task feedback records found'
            );
        }

        $recordScores = [];

        foreach ($records as $record) {

            $responsibility =
                (
                    (float)
                    $record->responsibility_accountability_1
                    +
                    (float)
                    $record->responsibility_accountability_2
                ) / 2;

            $empathy =
                (
                    (float)
                    $record->empathy_compassion_1
                    +
                    (float)
                    $record->empathy_compassion_2
                ) / 2;

            $humility =
                (
                    (float)
                    $record->humility_service_1
                    +
                    (float)
                    $record->humility_service_2
                ) / 2;

            $honesty =
                (
                    (float)
                    $record->honesty_integrity_1
                    +
                    (float)
                    $record->honesty_integrity_2
                ) / 2;

            $inspirational =
                (
                    (float)
                    $record->inspirational_leadership_1
                    +
                    (float)
                    $record->inspirational_leadership_2
                ) / 2;

            $overall =
                (
                    $responsibility +
                    $empathy +
                    $humility +
                    $honesty +
                    $inspirational
                ) / 5;

            $recordScores[] =
                $overall;
        }

        if (!$recordScores) {
            return $this->noData(
                'No valid line manager ratings found'
            );
        }

        $rawScore =
            round(
                array_sum($recordScores) /
                count($recordScores),
                2
            );

        $rawScore =
            min(
                100,
                $rawScore
            );

        $weight =
            $this->getWeight(
                $roleId,
                $indicatorId
            );

        return [
            'raw_score' =>
                $rawScore,

            'weighted_score' =>
                $this->weighted(
                    $rawScore,
                    $weight
                ),
        ];
    }

    /**
 * -------------------------------------------------------------
 * INDICATOR 189
 *
 * Uses employee_id.
 *
 * Line Manager Event Feedback
 *
 * Final Score:
 * 70% = Average Event Feedback Rating
 * 30% = Event Participation Score
 *
 * Participation Score:
 * Employee event count
 * ---------------------------- x 100
 * Highest event count in same department
 * -------------------------------------------------------------
 */
    protected function calculate189(
    User $employee,
    int $roleId,
    int $indicatorId
    ): ?array {

    $employeeId = $employee->employee_id;

    if (!$employeeId) {
        return $this->noData(
            'employee_id is missing'
        );
    }

    /*
        * ---------------------------------------------------------
        * Get employee department
        * ---------------------------------------------------------
        */
    $departmentId = $employee->department_id;

    if (!$departmentId) {
        return $this->noData(
            'department_id is missing for employee'
        );
    }

    /*
        * ---------------------------------------------------------
        * Employee event feedback
        * ---------------------------------------------------------
        */
    $feedbacks = LineManagerEventFeedback::query()
        ->where(
            'employee_id',
            $employeeId
        )
        ->where(
            'year_id',
            $this->yearId
        )
        ->get();

    if ($feedbacks->isEmpty()) {
        return $this->noData(
            'No line manager event feedback ratings found'
        );
    }

    /*
        * ---------------------------------------------------------
        * 1. Average Feedback Rating
        * ---------------------------------------------------------
        */
    $ratings = $feedbacks
        ->pluck('rating')
        ->filter(function ($rating) {
            return $rating !== null
                && is_numeric($rating);
        })
        ->map(function ($rating) {
            return (float) $rating;
        });

    if ($ratings->isEmpty()) {
        return $this->noData(
            'No valid line manager event feedback ratings found'
        );
    }

    $averageRating = round(
        $ratings->avg(),
        2
    );

    $averageRating = min(
        $averageRating,
        100
    );

    /*
        * ---------------------------------------------------------
        * 2. Employee Event Participation Count
        * ---------------------------------------------------------
        */
    $employeeEventCount = $feedbacks->count();

    /*
        * ---------------------------------------------------------
        * 3. Highest Event Count in Same Department
        * ---------------------------------------------------------
        *
        * Get all users from same department.
        */
    $departmentEmployeeIds = User::query()
        ->where(
            'department_id',
            $departmentId
        )
        ->pluck('employee_id')
        ->filter()
        ->values();

    /*
        * Find highest number of events participated by
        * any employee in the same department for this year.
        */
    $highestDepartmentCount = 1;

    if ($departmentEmployeeIds->isNotEmpty()) {

        $highestDepartmentCount =
            LineManagerEventFeedback::query()
                ->whereIn(
                    'employee_id',
                    $departmentEmployeeIds
                )
                ->where(
                    'year_id',
                    $this->yearId
                )
                ->selectRaw(
                    'employee_id, COUNT(*) as total'
                )
                ->groupBy(
                    'employee_id'
                )
                ->orderByDesc(
                    'total'
                )
                ->value(
                    'total'
                ) ?? 1;
    }

    $highestDepartmentCount = max(
        1,
        (int) $highestDepartmentCount
    );

    /*
        * ---------------------------------------------------------
        * 4. Participation Score
        * ---------------------------------------------------------
        *
        * Example:
        *
        * Employee events = 4
        * Department highest = 5
        *
        * 4 / 5 * 100 = 80
        */
    $participationScore = (
        $employeeEventCount /
        $highestDepartmentCount
    ) * 100;

    $participationScore = min(
        100,
        round(
            $participationScore,
            2
        )
    );

    /*
        * ---------------------------------------------------------
        * 5. Final 189 Raw Score
        * ---------------------------------------------------------
        *
        * 70% Average Rating
        * 30% Participation Score
        */
    $weightedRating = (
        $averageRating * 70
    ) / 100;

    $weightedParticipation = (
        $participationScore * 30
    ) / 100;

    $rawScore = (
        $weightedRating +
        $weightedParticipation
    );

    $rawScore = min(
        100,
        round(
            $rawScore,
            2
        )
    );

    /*
        * ---------------------------------------------------------
        * 6. Role-specific Indicator Weightage
        * ---------------------------------------------------------
        */
    $weight = $this->getWeight(
        $roleId,
        $indicatorId
    );

    /*
        * ---------------------------------------------------------
        * 7. Final Weighted Score
        * ---------------------------------------------------------
        */
    $weightedScore = $this->weighted(
        $rawScore,
        $weight
    );

    return [
        'raw_score' => $rawScore,

        'weighted_score' => $weightedScore,
    ];
    }
    
    /**
     * -------------------------------------------------------------
     * INDICATOR 194
     *
     * Uses employee_id.
     *
     * Number of knowledge products.
     * -------------------------------------------------------------
     */
    protected function calculate194(
        User $employee,
        int $roleId,
        int $indicatorId
    ): ?array {

        $employeeId =
            $employee->employee_id;

        if (!$employeeId) {
            return $this->noData(
                'employee_id is missing'
            );
        }

        /**
         * IMPORTANT:
         *
         * Knowledge products are matched using employee_id.
         */
        $achieved =
            DB::table(
                'number_of_knowledge_products'
            )
                ->where(
                    'created_by',
                    $employeeId
                )
                ->where(
                    'status',
                    2
                )
                ->where(
                    'year_id',
                    $this->yearId
                )
                ->count();

        /**
         * Target also uses employee_id.
         */
        $target =
            FacultyTarget::query()
                ->where(
                    'user_id',
                    $employeeId
                )
                ->where(
                    'indicator_id',
                    $indicatorId
                )
                ->where(
                    'year_id',
                    $this->yearId
                )
                ->value('target');

        if (
            $target === null ||
            (float) $target <= 0
        ) {
            return $this->noData(
                'No knowledge product target found for employee_id'
            );
        }

        $rawScore =
            (
                $achieved /
                (float) $target
            ) * 100;

        $rawScore =
            min(
                100,
                round(
                    $rawScore,
                    2
                )
            );

        $weight =
            $this->getWeight(
                $roleId,
                $indicatorId
            );

        return [
            'raw_score' =>
                $rawScore,

            'weighted_score' =>
                $this->weighted(
                    $rawScore,
                    $weight
                ),
        ];
    }

/**

* ---
* INDICATOR 203 — SCOPUS JOURNAL QUARTILE SCORE
*
* Source data: Indicator 128 (Scopus Publications)
* Saved result: Indicator 203
*
* Q1 = 20 points
* Q2 = 15 points
* Q3 = 10 points
* Q4 = 5 points
*
* Maximum raw score = 100
* ---

*/
protected function calculate203(
User $employee,
int $roleId,
int $indicatorId
): ?array {

$employeeId = $employee->employee_id;

if (!$employeeId) {
    return $this->noData(
        'employee_id is missing'
    );
}

// Indicator 203 derives its publication data from indicator 128.
$sourceIndicatorId = 128;

$quartilePoints = [
    'Q1' => 20,
    'Q2' => 15,
    'Q3' => 10,
    'Q4' => 5,
];

$records = AchievementOfResearchPublicationsTarget::query()
    ->where('indicator_id', $sourceIndicatorId)
    ->where('created_by', $employeeId)
    ->where('target_category', 'Scopus-Indexed')
    ->whereIn('form_status', ['RESEARCHER', 'DEAN'])
    ->where('year_id', $this->yearId)
    ->where('status', 3)
    ->whereNotNull('journal_clasification')
    ->get([
        'journal_clasification',
    ]);

$obtainedScore = 0;
$quartileCounts = [
    'Q1' => 0,
    'Q2' => 0,
    'Q3' => 0,
    'Q4' => 0,
];

foreach ($records as $record) {
    $quartile = strtoupper(
        trim((string) $record->journal_clasification)
    );

    if (!isset($quartilePoints[$quartile])) {
        continue;
    }

    $obtainedScore += $quartilePoints[$quartile];
    $quartileCounts[$quartile]++;
}

$rawScore = min(100, $obtainedScore);

$weight = $this->getWeight($roleId, $indicatorId);

return [
    'raw_score' => $rawScore,
    'weighted_score' => $this->weighted($rawScore, $weight),
];

}

    /**
     * -------------------------------------------------------------
     * SAVE INDICATOR
     * -------------------------------------------------------------
     */
    protected function saveIndicator(
        User $employee,
        int $roleId,
        int $indicatorId,
        int $kpaId,
        int $categoryId,
        float $weightedScore,
        float $rawScore,
        string $saveType
    ): void {

        /**
         * IndicatorsPercentage always stores actual employee_id.
         */
        $employeeId =
            $employee->employee_id;

        /**
         * ---------------------------------------------------------
         * INDICATOR 117
         *
         * Preserve original saveOverallAttendancePercentage()
         * behavior.
         * ---------------------------------------------------------
         */
        if ($saveType === 'attendance') {

            if ($rawScore == 100) {

                $color = 'warning';
                $rating = 'ME';

            } elseif (
                $rawScore >= 90 &&
                $rawScore <= 100
            ) {

                $color = 'orange';
                $rating = 'NI';

            } else {

                $color = 'danger';
                $rating = 'BE';
            }

            IndicatorsPercentage::updateOrCreate(
                [
                    'employee_id' =>
                        $employeeId,

                    'role_id' =>
                        $roleId,

                    'key_performance_area_id' =>
                        $kpaId,

                    'indicator_category_id' =>
                        $categoryId,

                    'indicator_id' =>
                        $indicatorId,

                    'year_id' =>
                        $this->yearId,
                ],
                [
                    'score' =>
                        $weightedScore,

                    'rating' =>
                        $rating,

                    'color' =>
                        $color,
                ]
            );

            return;
        }

        /**
         * Other indicators.
         */
        $ratingData =
            $this->getRating(
                $rawScore,
                $saveType
            );

        IndicatorsPercentage::updateOrCreate(
            [
                'employee_id' =>
                    $employeeId,

                'role_id' =>
                    $roleId,

                'key_performance_area_id' =>
                    $kpaId,

                'indicator_category_id' =>
                    $categoryId,

                'indicator_id' =>
                    $indicatorId,

                'year_id' =>
                    $this->yearId,
            ],
            [
                'score' =>
                    number_format(
                        $weightedScore,
                        2,
                        '.',
                        ''
                    ),

                'with_out_weight_score' =>
                    number_format(
                        $rawScore,
                        2,
                        '.',
                        ''
                    ),

                'color' =>
                    $ratingData['color'],

                'rating' =>
                    $ratingData['rating'],
            ]
        );
    }

    /**
     * -------------------------------------------------------------
     * RATING
     * -------------------------------------------------------------
     */
    protected function getRating(
        float $score,
        string $type
    ): array {

        /**
         * 90 PLUS
         *
         * 95+ = OS
         * 90+ = EE
         * 80+ = ME
         * 70+ = NI
         * else = BE
         */
        if ($type === '90plus') {

            if ($score >= 95) {

                return [
                    'color'  => 'primary',
                    'rating' => 'OS',
                ];
            }

            if ($score >= 90) {

                return [
                    'color'  => 'success',
                    'rating' => 'EE',
                ];
            }

            if ($score >= 80) {

                return [
                    'color'  => 'warning',
                    'rating' => 'ME',
                ];
            }

            if ($score >= 70) {

                return [
                    'color'  => 'orange',
                    'rating' => 'NI',
                ];
            }

            return [
                'color'  => 'danger',
                'rating' => 'BE',
            ];
        }

        /**
         * 100 PLUS
         *
         * 100 = OS
         * 90-99 = EE
         * 80-89 = ME
         * 70-79 = NI
         * else = BE
         */
        if ($type === '100plus') {

            if ($score == 100) {

                return [
                    'color'  => 'primary',
                    'rating' => 'OS',
                ];
            }

            if ($score >= 90) {

                return [
                    'color'  => 'success',
                    'rating' => 'EE',
                ];
            }

            if ($score >= 80) {

                return [
                    'color'  => 'warning',
                    'rating' => 'ME',
                ];
            }

            if ($score >= 70) {

                return [
                    'color'  => 'orange',
                    'rating' => 'NI',
                ];
            }

            return [
                'color'  => 'danger',
                'rating' => 'BE',
            ];
        }

        /**
         * NORMAL
         *
         * 90+ = OS
         * 80+ = EE
         * 70+ = ME
         * 60+ = NI
         * else = BE
         */
        if ($score >= 90) {

            return [
                'color'  => 'primary',
                'rating' => 'OS',
            ];
        }

        if ($score >= 80) {

            return [
                'color'  => 'success',
                'rating' => 'EE',
            ];
        }

        if ($score >= 70) {

            return [
                'color'  => 'warning',
                'rating' => 'ME',
            ];
        }

        if ($score >= 60) {

            return [
                'color'  => 'orange',
                'rating' => 'NI',
            ];
        }

        return [
            'color'  => 'danger',
            'rating' => 'BE',
        ];
    }

    /**
     * -------------------------------------------------------------
     * GET EMPLOYEES
     * -------------------------------------------------------------
     */
    public function employees()
    {
        return User::query()
            ->whereHas(
                'roles',
                function ($query) {
                    $query->whereIn(
                        'roles.id',
                        $this->roleIds
                    );
                }
            )
            ->with('roles')
            ->orderBy('id')
            ->get();
    }

    /**
     * -------------------------------------------------------------
     * PROCESS ALL EMPLOYEES
     * -------------------------------------------------------------
     */
    public function calculateAll(
        ?int $employeeId = null
    ): array {

        $summary = [
            'employees' => 0,
            'processed' => 0,
            'saved'     => 0,
            'skipped'   => 0,
            'failed'    => 0,
            'details'   => [],
        ];

        $query =
            User::query()
                ->whereHas(
                    'roles',
                    function ($query) {
                        $query->whereIn(
                            'roles.id',
                            $this->roleIds
                        );
                    }
                )
                ->with('roles')
                ->orderBy('id');

        /**
         * Specific employee.
         */
        if ($employeeId !== null) {

            $query->where(
                'employee_id',
                $employeeId
            );
        }

        $query->chunkById(
            200,
            function ($employees) use (&$summary) {

                foreach ($employees as $employee) {

                    $summary['employees']++;

                    $result =
                        $this->calculateForEmployee(
                            $employee
                        );

                    $summary['processed'] +=
                        $result['processed'];

                    $summary['saved'] +=
                        $result['saved'];

                    $summary['skipped'] +=
                        $result['skipped'];

                    $summary['failed'] +=
                        $result['failed'];

                    $summary['details'][] =
                        $result;
                }
            }
        );

        return $summary;
    }
}