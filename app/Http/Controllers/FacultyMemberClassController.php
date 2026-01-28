<?php

namespace App\Http\Controllers;

use App\Models\FacultyMemberClass;
use App\Models\FacultyClassAttendance;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FacultyMemberClassController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FacultyMemberClass $facultyMemberClass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FacultyMemberClass $facultyMemberClass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FacultyMemberClass $facultyMemberClass)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FacultyMemberClass $facultyMemberClass)
    {
        //
    }

    public function getOdooClasses(Request $request)
    {
        try {
            $faculty_id = Auth::user()->faculty_id;
            // $users = DB::connection('pgsql')
            //     ->table('res_users')
            //     ->select('id', 'login AS username', 'company_id', 'partner_id')
            //     ->where('user_type', 'faculty')
            //     ->where('active', 'true')
            //     ->limit(10)
            //     ->get();
            $records = DB::connection('pgsql')
                ->table('odoocms_class_faculty as cf')
                ->leftJoin('odoocms_faculty_staff as fs', 'fs.id', '=', 'cf.faculty_staff_id')
                ->leftJoin('odoocms_class as c', 'c.id', '=', 'cf.class_id')
                ->leftJoin('odoocms_academic_term as oat', 'oat.id', '=', 'cf.term_id')
                ->leftJoin('odoocms_career as cr', 'cr.id', '=', 'c.career_id')
                ->where('cf.faculty_staff_id', $faculty_id)
                ->where('oat.active_for_roll', 'true')
                ->limit(100)
                ->select([
                    'c.id as class_id',
                    'c.name as class_name',
                    'c.code',
                    'oat.id as term_id',
                    'oat.name as term',
                    'cr.id as career_id',
                    'cr.name as career',
                    'cr.code as career_code',
                ])
                ->get();

            foreach ($records as $record) {

                FacultyMemberClass::updateOrCreate(
                    [
                        'faculty_id' => $faculty_id,
                        'class_id' => $record->class_id,
                        'term_id' => $record->term_id,
                    ],
                    [
                        'class_name' => $record->class_name,
                        'code' => $record->code,
                        'term' => $record->term,
                        'career_id' => $record->career_id,
                        'career' => $record->career,
                        'career_code' => $record->career_code,
                    ]
                );
            }

        } catch (Exception $e) {
            return apiResponse(
                $e->getMessage(),
                [],
                false,
                500,
                ''
            );
        }
    }

    public function odooClasses(Request $request)
    {
        try {
            set_time_limit(300);

            DB::transaction(function () {
                DB::connection('pgsql')
                    ->table('odoocms_class_faculty as cf')
                    ->join('odoocms_faculty_staff as fs', 'fs.id', '=', 'cf.faculty_staff_id')
                    ->join('odoocms_class as c', 'c.id', '=', 'cf.class_id')
                    ->join('odoocms_academic_term as oat', 'oat.id', '=', 'cf.term_id')
                    ->leftJoin('odoocms_career as cr', 'cr.id', '=', 'c.career_id')
                    ->where('oat.id', 51)
                    ->where('oat.active_for_roll', true)
                    ->select([
                        'cf.faculty_staff_id as faculty_id',
                        'c.id as class_id',
                        'c.name as class_name',
                        'c.code',
                        'oat.id as term_id',
                        'oat.name as term',
                        'cr.id as career_id',
                        'cr.name as career',
                        'cr.code as career_code',
                    ])
                    // Pass the alias 'cf_id' as the 3rd parameter
                    ->chunkById(1000, function ($records) {
                        foreach ($records as $record) {
                            FacultyMemberClass::updateOrCreate(
                                [
                                    'faculty_id' => $record->faculty_id,
                                    'class_id' => $record->class_id,
                                    'term_id' => $record->term_id,
                                ],
                                [
                                    'class_name' => $record->class_name,
                                    'code' => $record->code,
                                    'term' => $record->term,
                                    'career_id' => $record->career_id,
                                    'career' => $record->career,
                                    'career_code' => $record->career_code,
                                ]
                            );
                        }
                    }, 'class_id'); // Match the alias used in select
            });

            return apiResponse("Classes imported successfully", [], true);

        } catch (\Exception $e) {
            return apiResponse($e->getMessage(), [], false, 500, '');
        }
    }

    public function classesAttendancebk(Request $request)
    {
        try {
            $currentDate = now()->format('Y-m-d');
            $records = DB::connection('pgsql')
                ->table('odoocms_class_attendance as ca')
                ->leftJoin('odoocms_class_attendance_line as cal', 'cal.attendance_id', '=', 'ca.id')
                ->leftJoin('odoocms_program as p', 'p.id', '=', 'ca.program_id')
                ->where('ca.date_att', '2022-10-24')
                //->where('ca.class_id', '49057')
                ->where('ca.att_marked', 'true')
                // ->limit(1)
                ->select([
                    'ca.class_id',
                    'ca.term_id',
                    'ca.batch_id',
                    'p.program_name',
                    'ca.faculty_id',
                    'ca.date_class',
                    'ca.date_att',
                    'ca.makeup_class',
                    'ca.state',
                    'cal.student_id',
                    'cal.student_name',
                    'cal.present',
                ])
                ->get();

            $totalStudents = $records->count();
            $presentCount = $records->where('present', true)->count();
            $absentCount = $totalStudents - $presentCount;
            $presentPercentage = $totalStudents > 0 ? round(($presentCount / $totalStudents) * 100, 2) : 0;
            dd($records);

        } catch (Exception $e) {
            return apiResponse(
                $e->getMessage(),
                [],
                false,
                500,
                ''
            );
        }
    }

    public function classesAttendanceBKK()
    {
        // Fetch attendance records
        $records = DB::connection('pgsql')
            ->table('odoocms_class_attendance as ca')
            ->leftJoin('odoocms_class_attendance_line as cal', 'cal.attendance_id', '=', 'ca.id')
            ->leftJoin('odoocms_program as p', 'p.id', '=', 'ca.program_id')
            ->where('ca.date_att', '2022-10-24')
            ->where('ca.class_id', '49057')
            ->where('ca.att_marked', 'true')
            ->select([
                'ca.class_id',
                'p.name as program_name',
                'ca.date_att',
                'cal.student_id',
                'cal.present',
            ])
            ->get();
        dd($records);
        // Group records by class_id
        $groupedByClass = $records->groupBy('class_id');

        foreach ($groupedByClass as $classId => $students) {
            $totalStudents = $students->count();
            $presentCount = $students->where('present', true)->count();
            $absentCount = $totalStudents - $presentCount;

            $presentPercentage = $totalStudents > 0 ? round(($presentCount / $totalStudents) * 100) : 0;
            $absentPercentage = $totalStudents > 0 ? round(($absentCount / $totalStudents) * 100) : 0;

            // Determine color and rating
            if ($presentPercentage >= 90 && $presentPercentage <= 100) {
                $color = '#6EA8FE';
                $rating = 'OS';
            } elseif ($presentPercentage >= 80 && $presentPercentage < 90) {
                $color = '#96e2b4';
                $rating = 'EE';
            } elseif ($presentPercentage >= 70 && $presentPercentage < 80) {
                $color = '#ffcb9a';
                $rating = 'ME';
            } elseif ($presentPercentage >= 60 && $presentPercentage < 70) {
                $color = '#fd7e13';
                $rating = 'NI';
            } elseif ($presentPercentage >= 50 && $presentPercentage < 60) {
                $color = '#ff4c51';
                $rating = 'BE';
            } else {
                $color = '#d3d3d3'; // default color for <50%
                $rating = 'NA';
            }

            // Save or update in FacultyClassAttendance
            FacultyClassAttendance::updateOrCreate(
                [
                    'class_id' => $classId,
                    'class_date' => $students->first()->date_att, // take date_att from first student
                ],
                [
                    'program_name' => $students->first()->program_name ?? null,
                    'total_students' => $totalStudents,
                    'present_count' => $presentCount,
                    'absent_count' => $absentCount,
                    'present_percentage' => $presentPercentage,
                    'absent_percentage' => $absentPercentage,
                    'color' => $color,
                    'rating' => $rating,
                ]
            );
        }

        return response()->json(['message' => 'Attendance summary saved successfully.']);
    }

    public function classesAttendance()
    {
        try {
            $from_date = '2025-12-21';
            $to_date = '2025-12-27';
            $sql = "
        SELECT 
            max(ca.class_id) as class_id,
            MAX(cal.faculty_updated_id) as faculty_id,
            MAX(p.name) as program_name,
            max(cal.state) as state,
            max(cal.term_id) as term_id,
            max(oat.name) as term,
            BOOL_OR(ca.att_marked) AS att_marked,
            COUNT(cal.student_id) AS total_no_of_students,
            COUNT(cal.student_id) FILTER (WHERE cal.present = 'true') AS present_students_count,
            COUNT(cal.student_id) FILTER (WHERE cal.present = 'false') AS absent_students_count
        FROM public.odoocms_class_attendance ca 
        left join public.odoocms_class_attendance_line cal on ca.id = cal.attendance_id
        left join public.odoocms_program p on p.id = ca.program_id
        left join public.odoocms_academic_term oat on oat.id = ca.term_id
        where cal.term_id = 51
        and ca.date_class BETWEEN '{$from_date}' AND '{$to_date}'
        group by ca.id
        ";

            DB::connection('pgsql')
                ->table(DB::raw("({$sql}) as attendance_summary"))
                ->orderByRaw('class_id')   // ✅ REQUIRED by chunk()
                ->chunk(1200, function ($attendanceSummary) {

                    foreach ($attendanceSummary as $item) {

                        // if (!$item->class_id || !$item->faculty_id) {
                        //     continue;
                        // }
    
                        FacultyClassAttendance::create([
                            'class_date' => '2025-08-18',
                            'class_id' => $item->class_id,
                            'faculty_id' => $item->faculty_id,
                            'program_name' => $item->program_name,
                            'state' => $item->state,
                            'term_id' => $item->term_id,
                            'term' => $item->term,
                            'att_marked' => $item->att_marked,
                            'total_students' => $item->total_no_of_students,
                            'present_count' => $item->present_students_count,
                            'absent_count' => $item->absent_students_count,
                        ]);
                    }
                });

            return response()->json([
                'status' => true,
                'message' => 'Attendance summary saved successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


}
