<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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

            $answerCounts = UserAnswer::select('user_id', DB::raw('COUNT(*) as total_answers'))
                ->whereNull('for_user_id')
                ->groupBy('user_id')
                ->get();
            $stakeholderCounts = UserAnswer::select('user_id', 'for_user_id', DB::raw('COUNT(*) as total_answers'))
                ->whereNotNull('user_id')
                ->whereNotNull('for_user_id')
                ->groupBy('user_id', 'for_user_id')
                ->get();
            $totalUsers = User::count();
            $answeredSelf = $answerCounts->count();
            $answeredStakeholders = $stakeholderCounts->count();
            $pendding = $totalUsers - ($answeredSelf + $answeredStakeholders);
            return view('admin.user', compact('totalUsers', 'answeredSelf', 'answeredStakeholders', 'pendding'));
        } catch (\Exception $e) {
            return apiResponse('Oops! Something went wrong', [],
                false, 500,'');
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
        $user->password = Hash::make('default123'); // Default password

        $user->save();

        // Assign role
        $user->assignRole($request->role);
        if ($request->expectsJson() && $request->is('api/*')) {
                return apiResponse('User created successfully.', ['user' => $user],
                true, 201,'');
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
                return apiResponse('User update successfully', ['user' => $user],
                true, 201,'');
        }
        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id,Request $request)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            if ($request->expectsJson() && $request->is('api/*')) {
                return apiResponse('User deleted successfully', [],
                true, 200,'');
            }
            return response()->json(['status' => 'success', 'message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return apiResponse('Oops! Something went wrong', [],
                false, 500,'');
        }
    }

}
