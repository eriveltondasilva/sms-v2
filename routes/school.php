<?php

declare(strict_types=1);
use App\Http\Controllers\School\DashboardController;
// #
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'school', 'school.year'])
    ->prefix('{school}')
    ->name('schools.')
    ->group(function (): void {

        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        // // --- Admin e Secretary ---
        // Route::resource('teachers', TeacherController::class);
        // Route::resource('students', StudentController::class);
        // Route::resource('guardians', GuardianController::class);
        // Route::resource('classrooms', ClassroomController::class);
        // Route::resource('subjects', SubjectController::class);
        // Route::resource('teaching-assignments', TeachingAssignmentController::class);
        // Route::resource('class-schedules', ClassScheduleController::class);
        // Route::resource('enrollments', EnrollmentController::class);
        // Route::resource('school-years', SchoolYearController::class);
        // Route::resource('academic-periods', AcademicPeriodController::class);

        // Route::post(
        //     'academic-periods/{academic_period}/close',
        //     [AcademicPeriodController::class, 'close']
        // )->name('academic-periods.close');

        // Route::post(
        //     'academic-periods/{academic_period}/reopen',
        //     [AcademicPeriodController::class, 'reopen']
        // )->name('academic-periods.reopen');

        // Route::resource('school-events', SchoolEventController::class);
        // Route::resource('reports', ReportController::class)->only(['index', 'show']);
        // Route::get('settings', SchoolSettingsController::class)->name('settings');

        // // --- Admin, Secretary e Teacher ---
        // Route::resource('lessons', LessonController::class);

        // Route::post(
        //     'lessons/{lesson}/generate',
        //     [LessonController::class, 'generate']
        // )->name('lessons.generate');

        // Route::post(
        //     'lessons/{lesson}/attendance',
        //     AttendanceController::class
        // )->name('lessons.attendance');

        // Route::resource('lesson-records', LessonRecordController::class);
        // Route::resource('lesson-plans', LessonPlanController::class);
        // Route::resource('assessment-templates', AssessmentTemplateController::class);
        // Route::resource('assessments', AssessmentController::class);

        // Route::post(
        //     'assessments/{assessment}/scores',
        //     ScoreController::class
        // )->name('assessments.scores');

        // Route::get(
        //     'period-results/{academic_period}',
        //     [PeriodResultController::class, 'show']
        // )->name('period-results.show');
    });
