<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question_number',
        'section',
        'difficulty',
        'question_text',
        'code_snippet',
        'options',
        'correct_answer',
        'explanation',
        'key_concept',
    ];

    protected $casts = [
        'options' => 'array',
    ];
}
