<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Timetable;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\User;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role === 'teacher') {
            $timetables = Timetable::with(['schoolClass', 'subject', 'teacher.user'])
                ->where('teacher_id', auth()->user()->id)
                ->get();

            if ($request->ajax()) {
                return response()->json($timetables);
            }

            return view('admin.timetables.index', compact('timetables'))
                ->with([
                    'classes' => [],
                    'teachers' => [],
                ]);
        }

        $query = Timetable::with(['schoolClass', 'subject', 'teacher.user']);

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        $timetables = $query->get();
        $classes = SchoolClass::all();
        $teachers = User::where('role', 'teacher')->get();

        // अगर AJAX call है तो JSON return
        if ($request->ajax()) {
            return response()->json($timetables);
        }

        return view('admin.timetables.index', compact('timetables', 'classes', 'teachers'));
    }



    public function create()
    {
        $classes = SchoolClass::all();
        $teachers = Teacher::with('user')->get();
        $subjects = Subject::all();

        return view('admin.timetables.create', compact('classes', 'teachers', 'subjects'));
    }

    // Store new timetable entry
    public function store(Request $request)
    {
        $request->validate([
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'period' => 'required|integer|min:1',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        // Conflict check: same class, same day & period
        if (
            Timetable::where('class_id', $request->class_id)
                ->where('day', $request->day)
                ->where('period', $request->period)
                ->exists()
        ) {
            return back()->withErrors(['Class already has a subject in this period.']);
        }

        // Conflict check: same teacher, same day & period
        if (
            Timetable::where('teacher_id', $request->teacher_id)
                ->where('day', $request->day)
                ->where('period', $request->period)
                ->exists()
        ) {
            return back()->withErrors(['Teacher is already assigned to another class in this period.']);
        }

        Timetable::create($request->only('day', 'period', 'class_id', 'subject_id', 'teacher_id'));

        return redirect()->route('admin.timetables.index')->with('success', 'Timetable entry added successfully!');
    }

    // Edit timetable entry
    public function edit(Timetable $timetable)
    {
        $classes = SchoolClass::all();
        $teachers = Teacher::with('user')->get();
        $subjects = Subject::all();
        return view('admin.timetables.edit', compact('timetable', 'classes', 'teachers', 'subjects'));
    }

    // Update timetable entry
    public function update(Request $request, Timetable $timetable)
    {
        $request->validate([
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'period' => 'required|integer|min:1',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        // Conflict check: same class, same day & period excluding current
        if (
            Timetable::where('class_id', $request->class_id)
                ->where('day', $request->day)
                ->where('period', $request->period)
                ->where('id', '!=', $timetable->id)
                ->exists()
        ) {
            return back()->withErrors(['Class already has a subject in this period.']);
        }

        // Conflict check: same teacher, same day & period excluding current
        if (
            Timetable::where('teacher_id', $request->teacher_id)
                ->where('day', $request->day)
                ->where('period', $request->period)
                ->where('id', '!=', $timetable->id)
                ->exists()
        ) {
            return back()->withErrors(['Teacher is already assigned to another class in this period.']);
        }

        $timetable->update($request->only('day', 'period', 'class_id', 'subject_id', 'teacher_id'));

        return redirect()->route('admin.timetables.index')->with('success', 'Timetable entry updated successfully!');
    }

    // Delete timetable entry
    public function destroy(Timetable $timetable)
    {
        $timetable->delete();
        return redirect()->route('admin.timetables.index')->with('success', 'Timetable entry deleted successfully!');
    }

    // Optional: AJAX fetch timetable by class
    public function getByClass($class_id)
    {
        $timetable = Timetable::with('teacher.user', 'subject')
            ->where('class_id', $class_id)
            ->get();
        return response()->json($timetable);
    }

    // Optional: AJAX fetch timetable by teacher
    public function getByTeacher($teacher_id)
    {
        $timetable = Timetable::with('schoolClass', 'subject')
            ->where('teacher_id', $teacher_id)
            ->get();
        return response()->json($timetable);
    }
}
