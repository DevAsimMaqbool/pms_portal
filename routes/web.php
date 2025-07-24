<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AssignUserKpaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\IndicatorCategoryController;
use App\Http\Controllers\IndicatorController;
use App\Http\Controllers\KeyPerformanceAreaController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleKpaAssignmentController;
use App\Http\Controllers\UserKPAController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RectorDashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\DepartmentAssignmentController;
use App\Http\Controllers\FormBuilderController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AssignFormToUserController;
use App\Http\Controllers\EmployabilityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


//Route::middleware('pms.auth')->group(function () {
Route::get('/dashboard', [PermissionController::class, 'dashboard'])->name('dashboard');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');
Route::resource('/key-performance-area', KeyPerformanceAreaController::class);
Route::resource('/user-role', RoleController::class);
Route::get('roles/permissions/list', [RoleController::class, 'permissionsList'])->name('roles.permissions.list');
Route::resource('/role-permission', RolePermissionController::class);
Route::resource('/indicator-category', IndicatorCategoryController::class);
Route::resource('/indicator', IndicatorController::class);
Route::get('/indicator-categories/{kpaId}', [IndicatorController::class, 'getCategoriesByKPA'])->name('indicators.categories');
Route::get('/performance/{id}', [KeyPerformanceAreaController::class, 'report'])->name('performance.report');

Route::get('/teaching_learning', [AssignUserKpaController::class, 'index']);
Route::post('/get-indicator-categories', [AssignUserKpaController::class, 'getIndicatorCategories'])->name('indicatorCategory.getIndicatorCategories');
Route::post('/get-users', [AssignUserKpaController::class, 'getUsers'])->name('indicatorCategory.getUsers');
Route::post('/get-indicators', [AssignUserKpaController::class, 'getIndicators'])->name('indicator.getIndicators');

Route::get('/assignments', [RoleKpaAssignmentController::class, 'create'])->name('assignments.create');
Route::post('/assignments', [RoleKpaAssignmentController::class, 'store'])->name('assignments.store');

// For dependent dropdowns
Route::get('/categories/{kpaId}', [RoleKpaAssignmentController::class, 'getCategories']);
Route::get('/indicators/{categoryId}', [RoleKpaAssignmentController::class, 'getIndicators']);

// To show data for logged-in user
Route::get('/my-kpa-data', [UserKPAController::class, 'index'])->name('user.kpa');

Route::resource('/departments', DepartmentController::class);
Route::resource('/rector-dashboard', RectorDashboardController::class);

Route::post('/get-role-users', [UserController::class, 'index'])->name('userRole.index');
Route::resource('users', UserController::class);
Route::resource('/faculty', FacultyController::class);
Route::resource('/assigndepartment', DepartmentAssignmentController::class);

Route::get('/assign-department', [DepartmentAssignmentController::class, 'index'])->name('assign.form');
Route::post('/assign-department', [DepartmentAssignmentController::class, 'store'])->name('assign.store');
Route::get('/faculty/{faculty}/departments', [DepartmentAssignmentController::class, 'getDepartments']);

Route::get('/students', [StudentController::class, 'index'])->name('students.index');

Route::get('/forms/create', [FormBuilderController::class, 'create'])->name('forms.create');
Route::post('/forms/store', [FormBuilderController::class, 'store'])->name('forms.store');
Route::get('/{id}/forms/{slug}', [FormBuilderController::class, 'show'])->name('forms.show');
Route::post('/forms/{form}', [FormBuilderController::class, 'submit'])->name('forms.submit');

Route::get('/forms/{form}/edit', [FormBuilderController::class, 'edit'])->name('forms.edit');
Route::put('/forms/{form}', [FormBuilderController::class, 'update'])->name('forms.update');

Route::resource('/assign-form', AssignFormToUserController::class);
Route::post('/assign-forms', [AssignFormToUserController::class, 'store'])->name('forms.assign');

Route::get('/assigned-forms', [AssignFormToUserController::class, 'showAssignedFormDropdown'])->name('forms.assigned');
Route::get('/assigned-forms/view/{userId}/{title}', [AssignFormToUserController::class, 'view'])
    ->name('forms.assigned.view');
Route::post('/employabilities', [EmployabilityController::class, 'store'])->name('employability.store');


//});

require __DIR__ . '/auth.php';
