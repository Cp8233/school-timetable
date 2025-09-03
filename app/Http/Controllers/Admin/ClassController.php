<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = SchoolClass::all();
        return view('admin.classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.classes.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        SchoolClass::create(['name' => $request->name]);

        return redirect()->route('admin.classes.index')->with('success', 'Class added successfully');
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
    public function edit(SchoolClass $class)
    {
        return view('admin.classes.edit', compact('class'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolClass $class)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $class->update(['name' => $request->name]);

        return redirect()->route('admin.classes.index')->with('success', 'Class updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Class deleted successfully');
    }
}
