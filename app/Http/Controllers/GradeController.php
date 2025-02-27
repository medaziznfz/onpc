<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    // Display a listing of the grades.
    public function index()
    {
        $grades = Grade::all();
        return view('grades.index', compact('grades'));
    }

    // Show the form for creating a new grade.
    public function create()
    {
        return view('grades.create');
    }

    // Store a newly created grade in storage.
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|string',
        ]);

        Grade::create([
            'name' => $request->name,
            'image' => $request->image,
        ]);

        return redirect()->route('grades.index')->with('success', 'Grade created successfully.');
    }

    // Display the specified grade.
    public function show(Grade $grade)
    {
        return view('grades.show', compact('grade'));
    }

    // Show the form for editing the specified grade.
    public function edit(Grade $grade)
    {
        return view('grades.edit', compact('grade'));
    }

    // Update the specified grade in storage.
    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|string',
        ]);

        $grade->update([
            'name' => $request->name,
            'image' => $request->image,
        ]);

        return redirect()->route('grades.index')->with('success', 'Grade updated successfully.');
    }

    // Remove the specified grade from storage.
    public function destroy(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('grades.index')->with('success', 'Grade deleted successfully.');
    }
}
