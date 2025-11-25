<?php

use App\Http\Controllers\AchievementOfResearchPublicationsTargetController;
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
use App\Http\Controllers\AwardController;
use App\Http\Controllers\CommercialGainsCounsultancyResearchIncomeController;
use App\Http\Controllers\EmployabilityController;
use App\Http\Controllers\IntellectualPropertyController;
use App\Http\Controllers\InternationalCoauthoredPaperController;
use App\Http\Controllers\NoAchievementOfMultidisciplinaryProjectsTargetController;
use App\Http\Controllers\PipController;
use App\Http\Controllers\PublicationOfHecRecognizedJournalController;
use App\Http\Controllers\RatingOnImpactOfResearchConferencesOrganizedController;
use App\Http\Controllers\SpinOffController;
use App\Http\Controllers\TrainingsSeminarsWorkshopConductedWithImpactController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SelfAssessmentWorkingController;
use App\Http\Controllers\ComparitiveAnalysisController;
use App\Models\RatingOnImpactOfResearchConferencesOrganized;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\DownloadsController;
use App\Http\Controllers\FacultyTargetController;
use App\Http\Controllers\IndustrialProjectsController;
use App\Http\Controllers\NoOfGrantsSubmitAndWonController;
use App\Http\Controllers\ProductsDeliveredToIndustryController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/tictactoe', function () {
    return view('admin.game.tictactoe');
});
Route::get('/v1', function () {
    return view('admin.v1');
});

Route::get('/v3', function () {
    return view('admin.v3');
});
//Route::middleware('pms.auth')->group(function () {
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [PermissionController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard-v1', [PermissionController::class, 'dashboardV1'])->name('dashboard_v1');
    Route::get('/v2/{id?}', [PermissionController::class, 'V2'])->name('v2');
    Route::get('/my_performance/{id?}', [PermissionController::class, 'myPerformance'])->name('my_performance');
    // Route::get('/teacher_dashboard/{id?}', [RectorDashboardController::class, 'teacherDashboard'])->name('teacher_dashboard');
    Route::get('student/dashboard', [PermissionController::class, 'dashboard'])->name('student.dashboard');
    Route::get('teacher/dashboard', [PermissionController::class, 'dashboard'])->name('teacher.dashboard');
    Route::get('survey/dashboard', [PermissionController::class, 'dashboard'])->name('survey.dashboard');
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
    Route::get('/kpa/{id}', [KeyPerformanceAreaController::class, 'kpa'])->name('kpa.report');

    Route::get('/teaching_learning', [AssignUserKpaController::class, 'index']);
    Route::post('/get-indicator-categories', [AssignUserKpaController::class, 'getIndicatorCategories'])->name('indicatorCategory.getIndicatorCategories');
    Route::post('/get-users', [AssignUserKpaController::class, 'getUsers'])->name('indicatorCategory.getUsers');
    Route::post('/get-indicators', [AssignUserKpaController::class, 'getIndicators'])->name('indicator.getIndicators');
    Route::post('/get-indicator', [KeyPerformanceAreaController::class, 'getIndicators'])->name('indicator.getIndicator');

    Route::get('/assignments', [RoleKpaAssignmentController::class, 'create'])->name('assignments.create');
    Route::post('/assignments', [RoleKpaAssignmentController::class, 'store'])->name('assignments.store');

    // For dependent dropdowns
    Route::get('/categories/{kpaId}', [RoleKpaAssignmentController::class, 'getCategories']);
    Route::get('/indicators/{categoryId}', [RoleKpaAssignmentController::class, 'getIndicators']);

    // To show data for logged-in user
    Route::get('/my-kpa-data', [UserKPAController::class, 'index'])->name('user.kpa');

    Route::resource('/departments', DepartmentController::class);
    Route::resource('/rector-dashboard', RectorDashboardController::class);
    Route::get('/teacher_dashboard/{id?}', [RectorDashboardController::class, 'teacherDashboard'])->name('teacher_dashboard');
    Route::get('/departments/{department}/report', [RectorDashboardController::class, 'departmentDashboard'])
        ->name('departments.report');

    Route::post('/get-role-users', [UserController::class, 'index'])->name('userRole.index');
    Route::get('/user_report/{id}', [UserController::class, 'userReport']);
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



    Route::middleware('role:Teacher|HOD|ORIC|Dean|Human Resources|Assistant Professor|Professor')->group(function () {
        Route::get('/view-forms', [IndicatorController::class, 'indicator_form_show'])->name('indicatorForm.show');
        Route::post('/achievement-of-research-publications-target/{id}/update-status', [IndicatorController::class, 'updateStatus']);
        Route::post('/achievement-of-research-publications-target/bulk-update-status', [IndicatorController::class, 'bulkUpdateStatus'])->name('indicatorForm.bulkUpdateStatus');

        Route::get('/kpa/{area}/category/{category}/indicator/{indicator}', [IndicatorController::class, 'indicator_form'])->name('indicator.form');
        Route::resource('indicator-form', AchievementOfResearchPublicationsTargetController::class);
        Route::get('indicator-forms/target', [AchievementOfResearchPublicationsTargetController::class, 'getPublicationTarget'])->name('indicator-form.target');

        Route::get('/load-forms/{form}', [IndicatorController::class, 'loadForm']);
        Route::resource('publication-of-hecRecognized', PublicationOfHecRecognizedJournalController::class);
        Route::resource('rating-onimpact-of-research', RatingOnImpactOfResearchConferencesOrganizedController::class);
        Route::resource('trainings-seminars-workshops', TrainingsSeminarsWorkshopConductedWithImpactController::class);
        Route::resource('spin-offs', SpinOffController::class);
        Route::resource('intellectual-properties', IntellectualPropertyController::class);
        Route::resource('counsultancy', CommercialGainsCounsultancyResearchIncomeController::class);
        Route::resource('international-Coauthored-Paper', InternationalCoauthoredPaperController::class);
        Route::resource('no-Of-GrantSubmit-And-Won', NoOfGrantsSubmitAndWonController::class);
        Route::resource('achievement-ofmultidisciplinary', NoAchievementOfMultidisciplinaryProjectsTargetController::class);
        Route::resource('products-delivered-to-industry', ProductsDeliveredToIndustryController::class);
        Route::resource('industrial-projects', IndustrialProjectsController::class);
        Route::resource('faculty-target', FacultyTargetController::class);
        // routes/web.php
        

    });
    Route::get('/faculty-target-gets', [FacultyTargetController::class, 'getTarget'])
    ->name('faculty-target.getTarget');

    Route::resource('/survey', SurveyController::class);
    Route::get('/survey-report', [SurveyController::class, 'report'])->name('survey.report');
    // routes/web.php
    Route::get('/survey/report/pdf', [SurveyController::class, 'exportPdf'])->name('survey.report.pdf');
    Route::get('/report/preview/{faculty_code}', [SurveyController::class, 'preview'])->name('report.preview');
    Route::get('/survey/{faculty_code}/download-pdf', [SurveyController::class, 'downloadPdf'])
        ->name('survey.downloadPdf');
    Route::get('/survey-report-dashboard', [SurveyController::class, 'surveyReportDashboard'])->name('survey_dashboard.report');

    Route::get('area-of-improvements', [TeacherController::class, 'areaOfImprovements'])->name('teacher.area_of_improvements');
    Route::get('noteable-performance', [TeacherController::class, 'noteablePerformance'])->name('teacher.noteable_performance');
    Route::resource('pip', PipController::class);
    Route::post('pip/{id}/update-status', [PipController::class, 'updateStatus'])->name('pip.updateStatus');
    Route::resource('/self-assessment', SelfAssessmentWorkingController::class);
    // web.php
    Route::post('self-assessment/term-data', [SelfAssessmentWorkingController::class, 'termData'])->name('self-assessment.termData');

    Route::get('comparitive-analysis', [ComparitiveAnalysisController::class, 'index'])->name('comparitive.analysis');
    Route::post('/get-indicator-categories-comp', [ComparitiveAnalysisController::class, 'getIndicatorCategories'])->name('Category.IndicatorCategories');
    Route::post('/get-indicators-comp', [ComparitiveAnalysisController::class, 'getIndicators'])->name('indicator.getIndicatorsForComp');
    Route::get('/reports/feedback', [SurveyController::class, 'loadFeedbackPage'])->name('reports.feedback');
    Route::post('/get-faculties', [SurveyController::class, 'getFaculties'])->name('reports.getFaculties');
    Route::post('/get-departments', [SurveyController::class, 'getDepartments'])->name('reports.getDepartments');
    Route::get('/reports/faculty-feedback', [SurveyController::class, 'feedbackReport'])->name('feedback.report');
    Route::get('downloads', [DownloadsController::class, 'index'])->name('pms.downloads');
    Route::get('awards', [AwardController::class, 'index'])->name('pms.awards');

    Route::middleware('role:HOD')->group(function () {
      Route::get('/hod-taget', [FormBuilderController::class, 'HodTargetForms'])->name('hod.target');
    });
    Route::middleware('role:Dean')->group(function () {
      Route::get('/dean-taget', [FormBuilderController::class, 'DeanTargetForms'])->name('dean.target');
    });
    Route::middleware('role:ORIC')->group(function () {
      Route::get('/oric-taget', [FormBuilderController::class, 'OricTargetForms'])->name('oric.target');
    });
    Route::middleware('role:Human Resources')->group(function () {
      Route::get('/hr-taget', [FormBuilderController::class, 'HrTargetForms'])->name('hr.target');
    });

    Route::get('/odoo-test', [AdminUserController::class, 'testOfOdoo'])->name('odoo.test');
});

require __DIR__ . '/auth.php';
