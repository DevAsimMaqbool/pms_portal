<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AssignUserKpaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\IndicatorCategoryController;
use App\Http\Controllers\IndicatorController;
use App\Http\Controllers\KeyPerformanceAreaController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleKpaAssignmentController;
use App\Http\Controllers\UserKPAController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RectorDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('pms.auth')->group(function () {
    Route::get('/dashboard', [PermissionController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
    Route::resource('/key-performance-area', KeyPerformanceAreaController::class);
    Route::resource('/indicator-category', IndicatorCategoryController::class);
    Route::resource('/indicator', IndicatorController::class);
    Route::get('/indicator-categories/{kpaId}', [IndicatorController::class, 'getCategoriesByKPA'])->name('indicators.categories');
    Route::get('/performance/{id}', [KeyPerformanceAreaController::class, 'report'])->name('performance.report');


    Route::get('/teaching_learning', [AssignUserKpaController::class, 'index']);
    Route::post('/get-indicator-categories', [AssignUserKpaController::class, 'getIndicatorCategories'])->name('indicatorCategory.getIndicatorCategories');
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
});

require __DIR__ . '/auth.php';
