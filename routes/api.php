<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\Api\ManagerEmployeeTaskController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware('api.key')->group(function () {
        Route::get('/get-employees-task', [ManagerEmployeeTaskController::class, 'index']);
        Route::get('/dashboard/{id}', [ManagerEmployeeTaskController::class, 'show']);
        Route::get('/faculty-retention-rate', [ManagerEmployeeTaskController::class, 'facultyRetentionRate']);
        Route::get('/goal-achievement-rate', [ManagerEmployeeTaskController::class, 'goalAchievementRate']);
        Route::get('/department-wise-performance', [ManagerEmployeeTaskController::class, 'departmentWisePerformance']);
        Route::get('/performance-review', [ManagerEmployeeTaskController::class, 'performanceReviewDashboard']);
        Route::get('/performance-distribution', [ManagerEmployeeTaskController::class, 'performanceDistribution']);
        Route::get('/productivity-index-summary', [ManagerEmployeeTaskController::class, 'productivityIndexSummary']);
        Route::get('/productivity-trend', [ManagerEmployeeTaskController::class, 'productivityTrend']);
        Route::get('/employee-net-promoter-score', [ManagerEmployeeTaskController::class, 'employeeNetPromoterScore']);
        Route::get('leadership-satisfaction-score', [ManagerEmployeeTaskController::class, 'leadershipSatisfactionScore']);
    });

});