<?php

namespace Tests\Feature;

use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExamTest extends TestCase
{
    use RefreshDatabase;

    public function test_exam_page_builds_a_randomized_attempt_from_the_pool(): void
    {
        $this->seedQuestions(60);

        $response = $this->get(route('exam.index'));

        $response->assertOk();
        $response->assertSee('Randomized Attempt');

        $questionIds = session('exam.question_ids');

        $this->assertCount(50, $questionIds);
        $this->assertCount(50, array_unique($questionIds));
    }

    public function test_realistic_mode_builds_a_twenty_question_attempt(): void
    {
        $this->seedQuestionsForRealisticMode();

        $response = $this->get(route('exam.index', ['mode' => 'realistic']));

        $response->assertOk();
        $response->assertSee('Realistic Mock Exam');
        $response->assertSee('20 Questions');

        $questionIds = session('exam.question_ids');

        $this->assertSame('realistic', session('exam.mode'));
        $this->assertCount(20, $questionIds);
        $this->assertCount(20, array_unique($questionIds));
    }

    public function test_submit_grades_only_the_questions_in_the_current_attempt(): void
    {
        $this->seedQuestions(60);

        $this->get(route('exam.index'));

        $questionIds = session('exam.question_ids');
        $firstQuestion = Question::findOrFail($questionIds[0]);

        $response = $this->post(route('exam.submit'), [
            'answers' => [
                $firstQuestion->id => $firstQuestion->correct_answer,
            ],
        ]);

        $response->assertOk();
        $response->assertSee('1');
        $response->assertSee('Correct');
    }

    public function test_realistic_mode_result_keeps_mode_context(): void
    {
        $this->seedQuestionsForRealisticMode();

        $this->get(route('exam.index', ['mode' => 'realistic']));

        $questionIds = session('exam.question_ids');
        $firstQuestion = Question::findOrFail($questionIds[0]);

        $response = $this->post(route('exam.submit'), [
            'mode' => 'realistic',
            'answers' => [
                $firstQuestion->id => $firstQuestion->correct_answer,
            ],
        ]);

        $response->assertOk();
        $response->assertSee('Realistic Mock Exam Results');
        $response->assertSee('1');
        $response->assertSee('Correct');
    }

    private function seedQuestions(int $count): void
    {
        for ($i = 1; $i <= $count; $i++) {
            Question::create([
                'question_number' => $i,
                'section' => 'Section '.(($i % 5) + 1),
                'difficulty' => ['easy', 'medium', 'hard'][$i % 3],
                'question_text' => "Question {$i}?",
                'code_snippet' => null,
                'options' => [
                    'a' => 'Option A',
                    'b' => 'Option B',
                    'c' => 'Option C',
                    'd' => 'Option D',
                ],
                'correct_answer' => 'a',
                'explanation' => "Explanation {$i}",
                'key_concept' => null,
            ]);
        }
    }

    private function seedQuestionsForRealisticMode(): void
    {
        $sections = [
            'Section 1: UNIX Basics & Commands (Lecture 1)',
            'Section 2: Arrays & Pointers (Lecture 3)',
            'Section 3: File I/O & System Calls (Lectures 4, 6)',
            'Section 4: Strings (Lecture 5)',
            'Section 5: File Permissions (Lecture 11)',
            'Section 6: Buffering (Lecture 7)',
            'Section 7: Function Pointers & qsort (Lecture 8)',
            'Section 8: Dynamic Memory (Lecture 9)',
            'Section 9: Directories (Lectures 10, 12)',
            'Section 10: Devices & Terminal Control (Lecture 13)',
            'Section 11: Signals (Lecture 14)',
        ];

        $questionNumber = 1;

        foreach ($sections as $section) {
            for ($i = 0; $i < 4; $i++) {
                Question::create([
                    'question_number' => $questionNumber++,
                    'section' => $section,
                    'difficulty' => ['easy', 'medium', 'hard'][$i % 3],
                    'question_text' => "{$section} question {$i}?",
                    'code_snippet' => null,
                    'options' => [
                        'a' => 'Option A',
                        'b' => 'Option B',
                        'c' => 'Option C',
                        'd' => 'Option D',
                    ],
                    'correct_answer' => 'a',
                    'explanation' => "Explanation {$section} {$i}",
                    'key_concept' => null,
                ]);
            }
        }
    }
}
