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
    protected ?int $springTermId = null;

    protected ?int $fallTermId = null;

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
    $terms = DB::table('terms')
        ->whereIn('term', ['Spring', 'Fall'])
        ->get()
        ->keyBy(function ($term) {
            return strtolower(trim($term->term));
        });

    $this->springTermId = isset($terms['spring'])
        ? (int) $terms['spring']->id
        : null;

    $this->fallTermId = isset($terms['fall'])
        ? (int) $terms['fall']->id
        : null;
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

        Log::info(
            'PMS indicator calculation started',
            [
                'employee_id' => $employee->employee_id,
                'user_id'     => $employee->id,
                'faculty_id'  => $employee->faculty_id,
                'roles'       => $employee->roles
                    ->pluck('id')
                    ->values()
                    ->toArray(),
                'spring_term_id' => $this->springTermId,
                'fall_term_id'   => $this->fallTermId,
                'year_id'        => $this->yearId,
            ]
        );

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

    foreach ([
        $this->springTermId,
        $this->fallTermId,
    ] as $termId) {

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

    /**
     * -------------------------------------------------------------
     * INDICATOR 117
     *
     * Uses faculty_id.
     *
     * Classes held percentage.
     * -------------------------------------------------------------
     */
    protected function calculate117(
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

    foreach ([
        $this->springTermId,
        $this->fallTermId,
    ] as $termId) {

        if (!$termId) {
            continue;
        }

        /*
         * IMPORTANT:
         * Use the existing FacultyMemberClass -> attendances
         * relationship because this is already working in Blade.
         */
        $classes = \App\Models\FacultyMemberClass::with([
            'attendances' => function ($query) {
                $query->orderBy('class_date', 'desc');
            }
        ])
            ->where('faculty_id', $facultyId)
            ->where('term_id', $termId)
            ->get();

        if ($classes->isEmpty()) {
            continue;
        }

        $classPercentages = [];

        foreach ($classes as $class) {

            $attendances = $class->attendances;

            $totalAttendance = $attendances->count();

            if ($totalAttendance <= 0) {
                continue;
            }

            $heldCount = $attendances->where(
                'att_marked',
                1
            )->count();

            $percentage = (
                $heldCount / $totalAttendance
            ) * 100;

            $classPercentages[] = round(
                min($percentage, 100),
                2
            );
        }

        if (!$classPercentages) {
            continue;
        }

        /*
         * Same logic as existing Blade calculation:
         * average percentage of all classes for this term.
         */
        $termScores[] = round(
            array_sum($classPercentages) /
            count($classPercentages),
            2
        );
    }

    if (!$termScores) {
        return $this->noData(
            'No class attendance marking data found for active Spring/Fall terms'
        );
    }

    /*
     * If both Spring and Fall exist:
     * average both term scores.
     */
    $rawScore = count($termScores) === 1
        ? $termScores[0]
        : round(
            array_sum($termScores) /
            count($termScores),
            2
        );

    $rawScore = min($rawScore, 100);

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

        foreach ([
            $this->springTermId,
            $this->fallTermId,
        ] as $termId) {

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

        foreach ([
            $this->springTermId,
            $this->fallTermId,
        ] as $termId) {

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
     * Uses faculty_id.
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
                'pass'
            );

        $rawScore =
            count($rawScores) === 1
                ? $rawScores[0]
                : round(
                    array_sum($rawScores) /
                    count($rawScores),
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
     * INDICATOR 186
     *
     * Uses faculty_id.
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
                'marks'
            );

        $rawScore =
            count($rawScores) === 1
                ? $rawScores[0]
                : round(
                    array_sum($rawScores) /
                    count($rawScores),
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
     * PUBLICATION DATA
     *
     * Uses employee_id.
     * -------------------------------------------------------------
     */
    protected function getPublicationData(
        int $employeeId,
        int $indicatorId
    ): ?array {

        $target =
            FacultyTarget::query()
                ->where(
                    'user_id',
                    $employeeId
                )
                ->where(
                    'year_id',
                    $this->yearId
                )
                ->where(
                    'indicator_id',
                    $indicatorId
                )
                ->sum('target');

        if ((float) $target <= 0) {
            return null;
        }

        $publications =
            AchievementOfResearchPublicationsTarget::query()
                ->where(
                    'created_by',
                    $employeeId
                )
                ->where(
                    'form_status',
                    'RESEARCHER'
                )
                ->where(
                    'status',
                    3
                )
                ->where(
                    'year_id',
                    $this->yearId
                )
                ->where(
                    'indicator_id',
                    $indicatorId
                )
                ->whereNotNull(
                    'journal_clasification'
                );

        $submitted =
            $publications->count();

        return [
            'target' =>
                (float) $target,

            'submitted' =>
                (int) $submitted,

            'query' =>
                $publications,
        ];
    }

    /**
     * -------------------------------------------------------------
     * INDICATOR 127
     *
     * Uses employee_id.
     *
     * International publications.
     * -------------------------------------------------------------
     */
    protected function calculate127(
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

        $data =
            $this->getPublicationData(
                $employeeId,
                $indicatorId
            );

        if (!$data) {
            return $this->noData(
                'No FacultyTarget found for indicator 127'
            );
        }

        $international =
            (clone $data['query'])
                ->whereRaw(
                    'LOWER(TRIM(nationality)) = ?',
                    ['international']
                )
                ->count();

        if ($international <= 0) {

            $rawScore = 0;

        } else {

            $rawScore =
                (
                    $international /
                    $data['target']
                ) * 100;

            $rawScore =
                min(
                    100,
                    round(
                        $rawScore,
                        2
                    )
                );
        }

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
     * INDICATOR 128
     *
     * Uses employee_id.
     *
     * Scopus publications.
     * -------------------------------------------------------------
     */
    protected function calculate128(
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

        $data =
            $this->getPublicationData(
                $employeeId,
                $indicatorId
            );

        if (!$data) {
            return $this->noData(
                'No FacultyTarget found for indicator 128'
            );
        }

        $rawScore =
            (
                $data['submitted'] /
                $data['target']
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

        $termIds =
            array_filter([
                $this->springTermId,
                $this->fallTermId,
            ]);

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
     * -------------------------------------------------------------
     */
    protected function calculate189(
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

        $row =
            LineManagerEventFeedback::query()
                ->where(
                    'employee_id',
                    $employeeId
                )
                ->where(
                    'year_id',
                    $this->yearId
                )
                ->selectRaw(
                    '
                    SUM(rating) as total_rating,

                    COUNT(rating) as rating_count
                    '
                )
                ->first();

        if (
            !$row ||
            (int) $row->rating_count <= 0
        ) {
            return $this->noData(
                'No line manager event feedback ratings found'
            );
        }

        $rawScore =
            (
                (float) $row->total_rating /
                (int) $row->rating_count
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
     * -------------------------------------------------------------
     * INDICATOR 203
     *
     * Uses employee_id.
     *
     * Journal quartile.
     * -------------------------------------------------------------
     */
    protected function calculate203(
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
            AchievementOfResearchPublicationsTarget::query()
                ->where(
                    'indicator_id',
                    $indicatorId
                )
                ->where(
                    'created_by',
                    $employeeId
                )
                ->where(
                    'target_category',
                    'Scopus-Indexed'
                )
                ->where(
                    'form_status',
                    'RESEARCHER'
                )
                ->where(
                    'year_id',
                    $this->yearId
                )
                ->where(
                    'status',
                    3
                )
                ->whereNotNull(
                    'journal_clasification'
                )
                ->get([
                    'journal_clasification',
                ]);

        if ($records->isEmpty()) {
            return $this->noData(
                'No Scopus journal publication records found'
            );
        }

        $quartilePoints = [
            'Q1' => 20,
            'Q2' => 15,
            'Q3' => 10,
            'Q4' => 5,
        ];

        $obtainedScore = 0;

        foreach ($records as $record) {

            $quartile =
                strtoupper(
                    trim(
                        (string)
                        $record->journal_clasification
                    )
                );

            if (
                isset(
                    $quartilePoints[$quartile]
                )
            ) {

                $obtainedScore +=
                    $quartilePoints[$quartile];
            }
        }

        $rawScore =
            min(
                100,
                $obtainedScore
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