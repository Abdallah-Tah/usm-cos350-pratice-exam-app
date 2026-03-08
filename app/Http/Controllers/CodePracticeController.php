<?php

namespace App\Http\Controllers;

use App\Models\CodeExercise;
use Illuminate\Http\Request;

class CodePracticeController extends Controller
{
    public function index()
    {
        $exercises = CodeExercise::orderBy('exercise_number')->get();
        $categories = $exercises->groupBy('category');

        return view('practice.index', compact('exercises', 'categories'));
    }

    public function show($id)
    {
        $exercise = CodeExercise::findOrFail($id);
        $allExercises = CodeExercise::orderBy('exercise_number')->get();

        return view('practice.show', compact('exercise', 'allExercises'));
    }

    public function run(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string',
        ]);

        $code = $validated['code'];

        // Create a temporary file
        $filename = 'code_' . time() . '_' . rand(1000, 9999);
        $filepath = storage_path("app/tmp/{$filename}.c");
        $execpath = storage_path("app/tmp/{$filename}");

        // Ensure tmp directory exists
        if (!is_dir(storage_path('app/tmp'))) {
            mkdir(storage_path('app/tmp'), 0755, true);
        }

        // Write code to file
        file_put_contents($filepath, $code);

        // Compile the code
        $compileCmd = "gcc {$filepath} -o {$execpath} 2>&1";
        exec($compileCmd, $compileOutput, $compileReturnCode);

        if ($compileReturnCode !== 0) {
            // Compilation failed
            @unlink($filepath);
            return response()->json([
                'success' => false,
                'error' => 'Compilation Error',
                'output' => implode("\n", $compileOutput),
            ]);
        }

        // Execute the compiled program with timeout
        $runCmd = "timeout 5s {$execpath} 2>&1";
        exec($runCmd, $runOutput, $runReturnCode);

        // Clean up
        @unlink($filepath);
        @unlink($execpath);

        if ($runReturnCode === 124) {
            return response()->json([
                'success' => false,
                'error' => 'Execution Timeout',
                'output' => 'Program exceeded 5 second timeout',
            ]);
        }

        return response()->json([
            'success' => true,
            'output' => implode("\n", $runOutput),
        ]);
    }
}
