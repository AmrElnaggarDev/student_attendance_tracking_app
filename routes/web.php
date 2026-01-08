<?php

use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Teacher\Attendance\AttendancePage;
use App\Livewire\Teacher\Grades\AddGrade;
use App\Livewire\Teacher\Grades\EditGrade;
use App\Livewire\Teacher\Grades\GradeList;
use App\Livewire\Teacher\Reports\MonthlyAttendanceReport;
use App\Livewire\Teacher\Students\StudentProfile;
use App\Livewire\Teachers\Students\AddStudent;
use App\Livewire\Teachers\Students\EditStudent;
use App\Livewire\Teachers\Students\StudentList;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'teacher'])
    ->name('teacher.dashboard');

Route::middleware(['auth', 'teacher'])->group(function () {


    // Attendances
    Route::get('/attendance', AttendancePage::class)->name('attendance.page');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');

    //students
    Route::get('/student-list', StudentList::class)->name('student.index');
    Route::get('/create/student' , AddStudent::class)->name('student.create');
    Route::get('/edit/student/{id}' , EditStudent::class)->name('student.edit');

    // Student Profile
    Route::get('student/profile/{student}', StudentProfile::class)->name('student.profile');

    //Monthly Attendance Report
    Route::get('/teacher/reports/monthly-attendance', MonthlyAttendanceReport::class)
        ->name('teacher.reports.monthly-attendance');

    //Grades
    Route::get('/grade/list', GradeList::class)->name('grade.index');
    Route::get('/grade/create', AddGrade::class)->name('grade.create');
    Route::get('/grade/edit/{id}', EditGrade::class)->name('grade.edit');
});
