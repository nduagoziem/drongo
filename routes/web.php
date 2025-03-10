<?php

use App\Models\User;
// use Illuminate\Foundation\Application;
use Inertia\Inertia;
// use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Attendance;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\NewEmployeeController;
use App\Http\Controllers\SignInHistoryController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AttendancePageController;
use App\Http\Controllers\SignOutHistoryController;
use App\Http\Controllers\AttendanceRankingController;

Route::get('/', function () {
    return Inertia::render('Home');
})->middleware("guest");

Route::get('/attendance/{user_uid}', [AttendancePageController::class, 'create'])->name("attendance.create");
Route::post('/attendance/open{user_uid}', [AttendancePageController::class, 'open'])->name("attendance.open");
Route::post('/attendance/close{user_uid}', [AttendancePageController::class, 'close'])->name("attendance.close");
Route::post('/attendance/timer/{user_uid}', [AttendancePageController::class, 'lateMarKingTime'])->name("attendance.timer");
Route::post('/attendance/signIn/{user_uid}', [AttendancePageController::class, 'signInAttendance'])->name("attendance.signIn");
Route::post('/attendance/signOut/{user_uid}', [AttendancePageController::class, 'signOutAttendance'])->name("attendance.signOut");

Route::middleware("auth")->group(function () {
    Route::get('admin/dashboard', [AdminDashboardController::class, 'create'])->name('dashboard');

    Route::get('admin/attendance-ranking', [AttendanceRankingController::class, 'create'])->name('attendance-ranking');

    Route::get('admin/employees', [EmployeesController::class, 'create'])->name('employees.create');
    Route::post('admin/employees/store', [EmployeesController::class, 'store'])->name('employees.store');
    Route::delete('admin/employees/{employee_uid}', [EmployeesController::class, 'destroy'])->name('employees.destroy');
    Route::get('admin/employees/edit/{employee_uid}', [EmployeesController::class, 'showEdit'])->name('employees.showEdit');
    Route::put('admin/employees/{employee_uid}', [EmployeesController::class, 'update'])->name('employees.update');
    // Allows images in storage/app/private/employees_img to be accessible
    Route::get('admin/employee-image/{filename}', function ($filename) {
        $path = storage_path("app/private/employees_img/{$filename}");

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    })->name('employees.image');

    Route::get('admin/new-employee', [NewEmployeeController::class, 'create'])->name('new-employee');

    Route::get('admin/profile', [ProfileController::class, 'create'])->name('profile.create');
    Route::patch('admin/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('admin/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('admin/settings', [SettingsController::class, 'create'])->name('settings');

    Route::get('admin/signin-history', [SignInHistoryController::class, 'create'])->name('signin-history');

    Route::get('admin/signout-history', [SignOutHistoryController::class, 'create'])->name('signout-history');
});

require __DIR__ . '/auth.php';
