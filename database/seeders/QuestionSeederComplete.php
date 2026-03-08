<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeederComplete extends Seeder
{
    public function run(): void
    {
        // Clear existing questions
        Question::truncate();
        
        // Import all 50 questions
        $this->seedAllQuestions();
    }
    
    private function seedAllQuestions(): void
    {
        $questionsData = file_get_contents(__DIR__ . '/questions_data.json');
        $questions = json_decode($questionsData, true);
        
        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}
