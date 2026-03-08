<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodeExercise extends Model
{
    protected $fillable = [
        'exercise_number',
        'title',
        'category',
        'difficulty',
        'description',
        'instructions',
        'starter_code',
        'solution_code',
        'test_cases',
        'hints',
    ];

    protected $casts = [
        'test_cases' => 'array',
    ];
}
