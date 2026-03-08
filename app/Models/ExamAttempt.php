<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'mode',
        'total_questions',
        'answered_questions',
        'correct_answers',
        'score',
        'question_ids',
        'user_answers',
    ];

    protected $casts = [
        'question_ids' => 'array',
        'user_answers' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
