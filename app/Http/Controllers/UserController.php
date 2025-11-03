<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexbk()
    {
        try {
            $users = User::limit(5)->get();
            return view('admin.form.teaching_learning', compact('users'));
        } catch (\Exception $e) {
            return apiResponse($e->getMessage(), [], false, 500, '');
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $authUser = auth()->user();
            $authRole = $authUser->getRoleNames()->first(); // get once

            // Build query once
            $query = User::query()
                ->with('roles:id,name') // only load needed role fields
                ->when(
                    $authRole !== 'user',
                    fn($q) =>
                    $q->where('manager_id', $authUser->id)
                );

            // Apply department filter
            if ($request->filled('department')) {
                $query->where('department', $request->department);
            }

            return DataTables::of($query)
                ->addColumn(
                    'checkbox',
                    fn($user) =>
                    '<input type="checkbox" class="dt-checkboxes form-check-input" data-user-id="' . $user->id . '">'
                )
                ->addColumn('full_name', function ($user) {
                    return '
            <div class="d-flex align-items-center user-name">
                <div class="avatar-wrapper">
                    <div class="avatar avatar-sm me-4">
                        <span class="avatar-initial rounded-circle bg-label-primary">'
                        . strtoupper($user->name[0]) .
                        '</span>
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <a href="app-user-view-account.html" class="text-heading text-truncate">
                        <span class="fw-medium">' . $user->name . '</span>
                    </a>
                    <small>' . $user->email . '</small>
                </div>
            </div>';
                })
                ->addColumn('role', function ($user) {
                    // use loaded relation instead of new query
                    $role = $user->roles->pluck('name')->first() ?? 'user';
                    $icon = match ($role) {
                        'admin' => '<i class="icon-base ti tabler-device-desktop icon-md text-danger me-2"></i>',
                        'user' => '<i class="icon-base ti tabler-user icon-md text-success me-2"></i>',
                        'Teacher' => '<i class="icon-base ti tabler-chalkboard icon-md text-info me-2"></i>',
                        default => '<i class="icon-base ti tabler-circle icon-md text-primary me-2"></i>',
                    };
                    return '<span class="d-flex align-items-center text-heading">' . $icon . ' ' . $role . '</span>';
                })
                ->addColumn('status', function ($user) {
                    $statusMap = [
                        'pending' => ['title' => 'pending', 'class' => 'bg-label-warning'],
                        'active' => ['title' => 'active', 'class' => 'bg-label-success'],
                        'inactive' => ['title' => 'inactive', 'class' => 'bg-label-secondary'],
                    ];
                    $s = $statusMap[$user->status] ?? $statusMap['inactive'];
                    return '<span class="badge ' . $s['class'] . '">' . $s['title'] . '</span>';
                })
                ->addColumn('actions', function ($user) use ($authRole) {
                    $actions = '
            <div class="d-flex align-items-center">
                <a href="javascript:;" class="btn btn-text-secondary rounded-pill waves-effect btn-icon" onclick="editUser(' . $user->id . ')">
                    <i class="icon-base ti tabler-edit icon-22px"></i>
                </a>
                <a class="btn btn-icon btn-text-secondary rounded-pill waves-effect" onclick="deleteUser(' . $user->id . ')">
                    <i class="icon-base ti tabler-trash icon-md"></i>
                </a>
                <a class="btn btn-icon btn-text-secondary rounded-pill waves-effect" href="/user_report/' . $user->id . '" target="_blank">
                    <i class="icon-base ti tabler-eye icon-md"></i>
                </a>';

                    if ($authRole === "Dean") {
                        $actions .= '
                <a class="btn btn-icon btn-text-secondary rounded-pill waves-effect" href="/departments/' . strtolower(str_replace(' ', '_', $user->department)) . '/report" target="_blank">
                    <i class="icon-base ti tabler-file icon-md"></i>
                </a>';
                    }

                    if ($authRole === "HOD") {
                        $actions .= '
                <a class="btn btn-icon btn-text-secondary rounded-pill waves-effect" href="/teacher_dashboard/' . $user->id . '" target="_blank">
                    <i class="icon-base ti tabler-file icon-md"></i>
                </a>';
                    }

                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['checkbox', 'full_name', 'role', 'status', 'actions'])
                ->make(true);
        }

        // For blade dropdown
        $departments = Department::select('name')
            ->distinct()
            ->orderBy('name')
            ->get();

        $authUser = auth()->user();
        $authRole = $authUser->getRoleNames()->first();
        $totalUsers = $authRole === 'user'
            ? User::count()
            : User::where('manager_id', $authUser->id)->count();

        $roles = Role::all();

        return view('admin.user', compact('totalUsers', 'departments', 'roles'));
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
            'role' => 'required|string',
            //'level' => 'required|string|max:50',
            //'manager_id' => 'required|exists:users,id',
            'status' => 'required|in:active,inactive',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->barcode = $request->employee_code;
        $user->department = $request->department;
        //$user->level = $request->level;
        // $user->manager_id = $request->manager_id;
        $user->status = $request->status;

        $user->save();

        // Sync role
        $user->syncRoles([$request->role]);

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function userReport($id)
    {
        $user = User::findOrFail($id);
        return view('admin.report', compact('user'));
    }
}
