<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with('user', 'subject')->get();
        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'teacher')->get();
        $subjects = Subject::all();
        return view('admin.teachers.create', compact('users', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => [
                'required',
                Rule::unique('teachers')->where(fn($query) => $query->where('subject_id', $request->subject_id))
            ],
            'subject_id' => 'required|exists:subjects,id',
        ]);

        Teacher::create($request->only('user_id', 'subject_id'));

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher added successfully!');
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
    public function edit(Teacher $teacher)
    {
        $users = User::where('role', 'teacher')->get();
        $subjects = Subject::all();
        return view('admin.teachers.edit', compact('teacher', 'users', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'user_id' => [
                'required',
                Rule::unique('teachers')->where(fn($query) => $query->where('subject_id', $request->subject_id))->ignore($teacher->id)
            ],
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $teacher->update($request->only('user_id', 'subject_id'));

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->back()->with('success', 'Teacher deleted successfully!');
    }

    public function getBySubject($subjectId)
    {
        // dd($subjectId);
        $teachers = Teacher::with('user')
            ->where('subject_id', $subjectId)
            ->get();
        // dd($teachers);
        return response()->json($teachers);
    }

}
