<?php

namespace App\Http\Controllers;

use App\Models\FacultyMemberClass;
use Exception;
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

    public function classesAttendance(Request $request)
    {
        try {
            $currentDate = now()->format('Y-m-d');
            $records = DB::connection('pgsql')
                ->table('odoocms_class_attendance as ca')
                ->leftJoin('odoocms_class_attendance_line as cal', 'cal.attendance_id', '=', 'ca.id')
                ->where('ca.date_att', $currentDate)
                ->where('ca.att_marked', 'true')
                ->limit(1)
                ->select([
                    'ca.class_id',
                    'ca.term_id',
                    'ca.batch_id',
                    'ca.program_id',
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
            dd($records);
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
}
