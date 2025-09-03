<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();
        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Subject::create(['name' => $request->name]);
        return redirect()->back()->with('success', 'Subject added successfully!');
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
    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $subject->update(['name' => $request->name]);
        return redirect()->route('admin.subjects.index')->with('success', 'Subject updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->back()->with('success', 'Subject deleted successfully!');
    }
}
