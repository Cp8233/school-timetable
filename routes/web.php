<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TimetableController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('timetables', [TimetableController::class, 'index'])->name('timetables.index');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('classes', ClassController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('timetables', TimetableController::class);

    Route::get('/teachers/by-subject/{subject}', [TeacherController::class, 'getBySubject'])->name('teachers.by-subject');

    Route::get('timetables/class/{class}', [TimetableController::class, 'byClass'])->name('admin.timetables.by-class');
    Route::get('timetables/teacher/{teacher}', [TimetableController::class, 'byTeacher'])->name('admin.timetables.by-teacher');

});

require __DIR__ . '/auth.php';
