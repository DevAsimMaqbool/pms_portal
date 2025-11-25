<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FacultyMemberClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $users = User::with('roles')->get()->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'status' => $user->status,
                        'created_at' => $user->created_at,
                        'department' => $user->department,
                        'level' => $user->level,
                        'roles' => $user->getRoleNames(), // Spatie method to get role names
                    ];
                });
                $managerialUsers = User::where('level', 'Managerial')->get();
                return response()->json([
                    'users' => $users,
                    'managerial_users' => $managerialUsers,
                ]);
            }

            $totalUsers = User::count();
            return view('admin.user', compact('totalUsers'));
        } catch (Exception $e) {
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'employee_code' => 'required|string|max:50',
            'department' => 'required|string|max:100',
            'role' => 'required|string',
            'level' => 'required',
            'manager_id' => 'required',
            'status' => 'required|in:active,inactive',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->employee_code = $request->employee_code;
        $user->department = $request->department;
        $user->level = $request->level;
        $user->manager_id = $request->manager_id;
        $user->status = $request->status;
        $user->password = Hash::make('Admin@123'); // Default password

        $user->save();

        // Assign role
        $user->assignRole($request->role);
        if ($request->expectsJson() && $request->is('api/*')) {
            return apiResponse(
                'User created successfully.',
                ['user' => $user],
                true,
                201,
                ''
            );
        }
        return response()->json(['message' => 'User created successfully', 'user' => $user]);
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
        $user = User::findOrFail($id);
        $roles = $user->getRoleNames();
        return response()->json([
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'employee_code' => 'required|string|max:50',
            'department' => 'required|string|max:100',
            'role' => 'string',
            'level' => 'required|string|max:50',
            'manager_id' => 'required|exists:users,id',
            'status' => 'required|in:active,inactive',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->employee_code = $request->employee_code;
        $user->department = $request->department;
        $user->level = $request->level;
        $user->manager_id = $request->manager_id;
        $user->status = $request->status;

        $user->save();

        // Sync role
        $user->syncRoles([$request->role]);
        if ($request->expectsJson() && $request->is('api/*')) {
            return apiResponse(
                'User update successfully',
                ['user' => $user],
                true,
                201,
                ''
            );
        }
        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            if ($request->expectsJson() && $request->is('api/*')) {
                return apiResponse(
                    'User deleted successfully',
                    [],
                    true,
                    200,
                    ''
                );
            }
            return response()->json(['status' => 'success', 'message' => 'User deleted successfully']);
        } catch (Exception $e) {
            return apiResponse(
                'Oops! Something went wrong',
                [],
                false,
                500,
                ''
            );
        }
    }

    public function testOfOdoo(Request $request)
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

}
