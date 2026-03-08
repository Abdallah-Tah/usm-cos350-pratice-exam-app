<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\User;
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
        $response->assertSee('Comprehensive Review');
        $response->assertSee('Submit Exam');

        $questionIds = session('exam.question_ids');

        $this->assertCount(50, $questionIds);
        $this->assertCount(50, array_unique($questionIds));
    }

    public function test_realistic_mode_builds_a_twenty_question_attempt(): void
    {
        $this->seedQuestionsForRealisticMode();

        $response = $this->get(route('exam.index', ['mode' => 'realistic']));

        $response->assertOk();
        $response->assertSee('Realistic Exam');
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

    public function test_submitting_an_exam_creates_a_history_record(): void
    {
        $this->seedQuestions(60);

        $this->get(route('exam.index'));

        $questionIds = session('exam.question_ids');
        $firstQuestion = Question::findOrFail($questionIds[0]);

        $this->post(route('exam.submit'), [
            'mode' => 'comprehensive',
            'answers' => [
                $firstQuestion->id => $firstQuestion->correct_answer,
            ],
        ])->assertOk();

        $this->assertDatabaseCount('exam_attempts', 1);
        $this->assertDatabaseHas('exam_attempts', [
            'mode' => 'comprehensive',
            'total_questions' => 50,
            'answered_questions' => 1,
            'correct_answers' => 1,
            'score' => 2,
        ]);
    }

    public function test_history_page_displays_saved_attempts(): void
    {
        $this->seedQuestions(60);

        $this->get(route('exam.index'));

        $questionIds = session('exam.question_ids');
        $firstQuestion = Question::findOrFail($questionIds[0]);

        $this->post(route('exam.submit'), [
            'mode' => 'comprehensive',
            'answers' => [
                $firstQuestion->id => $firstQuestion->correct_answer,
            ],
        ])->assertOk();

        $response = $this->get(route('exam.history'));

        $response->assertOk();
        $response->assertSee('Exam History');
        $response->assertSee('Comprehensive Review');
        $response->assertSee('Recent Attempts');
    }

    public function test_history_attempt_page_shows_correct_and_incorrect_answers(): void
    {
        $this->seedQuestions(60);

        $this->get(route('exam.index'));

        $questionIds = session('exam.question_ids');
        $firstQuestion = Question::findOrFail($questionIds[0]);
        $secondQuestion = Question::findOrFail($questionIds[1]);

        $this->post(route('exam.submit'), [
            'mode' => 'comprehensive',
            'answers' => [
                $firstQuestion->id => $firstQuestion->correct_answer,
                $secondQuestion->id => 'b',
            ],
        ])->assertOk();

        $attemptId = \App\Models\ExamAttempt::query()->latest('id')->value('id');

        $response = $this->get(route('exam.history.show', $attemptId));

        $response->assertOk();
        $response->assertSee('Saved Attempt');
        $response->assertSee('Question Review');
        $response->assertSee('Correct');
        $response->assertSee('Incorrect');
        $response->assertSee('Correct Answer:');
    }

    public function test_history_can_be_filtered_by_mode_and_outcome(): void
    {
        $comprehensiveAttempt = \App\Models\ExamAttempt::create([
            'user_id' => null,
            'mode' => 'comprehensive',
            'total_questions' => 50,
            'answered_questions' => 50,
            'correct_answers' => 45,
            'score' => 90,
            'question_ids' => [1, 2],
            'user_answers' => [],
        ]);

        $realisticAttempt = \App\Models\ExamAttempt::create([
            'user_id' => null,
            'mode' => 'realistic',
            'total_questions' => 20,
            'answered_questions' => 20,
            'correct_answers' => 8,
            'score' => 40,
            'question_ids' => [3, 4],
            'user_answers' => [],
        ]);

        $response = $this->get(route('exam.history', [
            'mode' => 'realistic',
            'outcome' => 'review',
        ]));

        $response->assertOk();
        $response->assertSee('Realistic Exam');
        $response->assertSee('40%');
        $response->assertSee(route('exam.history.show', $realisticAttempt), false);
        $response->assertDontSee(route('exam.history.show', $comprehensiveAttempt), false);
    }

    public function test_history_can_be_sorted_by_score(): void
    {
        \App\Models\ExamAttempt::create([
            'user_id' => null,
            'mode' => 'comprehensive',
            'total_questions' => 50,
            'answered_questions' => 50,
            'correct_answers' => 15,
            'score' => 30,
            'question_ids' => [1, 2],
            'user_answers' => [],
        ]);

        \App\Models\ExamAttempt::create([
            'user_id' => null,
            'mode' => 'comprehensive',
            'total_questions' => 50,
            'answered_questions' => 50,
            'correct_answers' => 45,
            'score' => 90,
            'question_ids' => [3, 4],
            'user_answers' => [],
        ]);

        $response = $this->get(route('exam.history', ['sort' => 'score_high']));

        $response->assertOk();
        $response->assertSeeInOrder(['90%', '30%']);
    }

    public function test_dashboard_includes_history_navigation(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Attempt History');
        $response->assertSee('View History');
        $response->assertSee(route('exam.history'), false);
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
        $response->assertSee('Realistic Exam Results');
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
