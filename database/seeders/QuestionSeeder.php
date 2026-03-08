<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questionsData = file_get_contents(__DIR__.'/questions_data.json');
        $questions = json_decode($questionsData, true, 512, JSON_THROW_ON_ERROR);

        Question::truncate();

        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}
