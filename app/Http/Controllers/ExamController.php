<?php

namespace App\Http\Controllers;

use App\Models\ExamAttempt;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ExamController extends Controller
{
    private const MODES = [
        'comprehensive' => [
            'label' => 'Comprehensive Review',
            'size' => 50,
        ],
        'realistic' => [
            'label' => 'Realistic Exam',
            'size' => 20,
            'mix' => [
                'Section 1: UNIX Basics & Commands (Lecture 1)' => 2,
                'Section 2: Arrays & Pointers (Lecture 3)' => 2,
                'Section 3: File I/O & System Calls (Lectures 4, 6)' => 2,
                'Section 4: Strings (Lecture 5)' => 2,
                'Section 5: File Permissions (Lecture 11)' => 2,
                'Section 6: Buffering (Lecture 7)' => 1,
                'Section 7: Function Pointers & qsort (Lecture 8)' => 2,
                'Section 8: Dynamic Memory (Lecture 9)' => 2,
                'Section 9: Directories (Lectures 10, 12)' => 2,
                'Section 10: Devices & Terminal Control (Lecture 13)' => 1,
                'Section 11: Signals (Lecture 14)' => 2,
            ],
        ],
        'professor' => [
            'label' => 'Professor Practice Test',
            'size' => 12,
            'professor_mode' => true,
        ],
    ];

    public function index()
    {
        $mode = request()->string('mode')->toString();
        $mode = array_key_exists($mode, self::MODES) ? $mode : 'comprehensive';
        $modeConfig = self::MODES[$mode];
        $poolSize = Question::count();
        $total = min($modeConfig['size'], $poolSize);
        $questionIds = match($mode) {
            'realistic' => $this->buildRealisticAttempt($total),
            'professor' => $this->buildProfessorAttempt($total),
            default => Question::query()
                ->inRandomOrder()
                ->limit($total)
                ->pluck('id')
                ->all(),
        };

        $questions = $this->questionsInAttemptOrder($questionIds);

        $requestSectionCounts = $questions
            ->groupBy('section')
            ->map(fn (Collection $items) => $items->count());

        session([
            'exam.question_ids' => $questionIds,
            'exam.total' => $total,
            'exam.mode' => $mode,
        ]);

        $modes = collect(self::MODES)->map(fn (array $config, string $key) => [
            'key' => $key,
            'label' => $config['label'],
            'size' => $config['size'],
        ]);

        return view('exam.index', compact('questions', 'total', 'poolSize', 'requestSectionCounts', 'mode', 'modeConfig', 'modes'));
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'mode' => ['nullable', 'in:comprehensive,realistic,professor'],
            'answers' => ['nullable', 'array'],
            'answers.*' => ['nullable', 'in:a,b,c,d'],
        ]);

        $answers = $validated['answers'] ?? [];
        $mode = $validated['mode'] ?? session('exam.mode', 'comprehensive');
        $mode = array_key_exists($mode, self::MODES) ? $mode : 'comprehensive';
        $modeConfig = self::MODES[$mode];
        $questionIds = session('exam.question_ids', []);
        $questions = $this->questionsInAttemptOrder($questionIds);

        $results = [];
        $correct = 0;
        $total = $questions->count();

        foreach ($questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $isCorrect = $userAnswer === $question->correct_answer;

            if ($isCorrect) {
                $correct++;
            }

            $results[$question->id] = [
                'question' => $question,
                'user_answer' => $userAnswer,
                'is_correct' => $isCorrect,
            ];
        }

        $score = $total > 0 ? round(($correct / $total) * 100) : 0;
        $answered = count(array_filter($answers, fn ($answer) => in_array($answer, ['a', 'b', 'c', 'd'], true)));
        $poolSize = Question::count();

        // Save exam attempt to history
        ExamAttempt::create([
            'user_id' => auth()->id(),
            'mode' => $mode,
            'total_questions' => $total,
            'answered_questions' => $answered,
            'correct_answers' => $correct,
            'score' => $score,
            'question_ids' => $questionIds,
            'user_answers' => $answers,
        ]);

        return view('exam.results', compact('results', 'correct', 'total', 'score', 'answered', 'poolSize', 'mode', 'modeConfig'));
    }

    public function reset()
    {
        $mode = request()->string('mode')->toString();
        $mode = array_key_exists($mode, self::MODES) ? $mode : 'comprehensive';

        session()->forget('exam');

        return redirect()->route('exam.index', ['mode' => $mode])->with('message', 'Exam reset successfully!');
    }

    private function questionsInAttemptOrder(array $questionIds): Collection
    {
        if ($questionIds === []) {
            return Question::query()->orderBy('question_number')->get();
        }

        $questions = Question::query()
            ->whereIn('id', $questionIds)
            ->get()
            ->keyBy('id');

        return collect($questionIds)
            ->map(fn (int $id) => $questions->get($id))
            ->filter()
            ->values();
    }

    private function buildRealisticAttempt(int $total): array
    {
        $selectedIds = collect();
        $usedIds = [];

        foreach (self::MODES['realistic']['mix'] as $section => $count) {
            $sectionIds = Question::query()
                ->where('section', $section)
                ->whereNotIn('id', $usedIds)
                ->inRandomOrder()
                ->limit($count)
                ->pluck('id');

            $selectedIds = $selectedIds->merge($sectionIds);
            $usedIds = $selectedIds->all();
        }

        if ($selectedIds->count() < $total) {
            $remainingIds = Question::query()
                ->whereNotIn('id', $usedIds)
                ->inRandomOrder()
                ->limit($total - $selectedIds->count())
                ->pluck('id');

            $selectedIds = $selectedIds->merge($remainingIds);
        }

        return $selectedIds
            ->shuffle()
            ->take($total)
            ->values()
            ->all();
    }

    private function buildProfessorAttempt(int $total): array
    {
        // Get all professor test questions first
        $professorIds = Question::query()
            ->where('key_concept', 'Professor Test Question')
            ->inRandomOrder()
            ->pluck('id');

        // If we don't have enough professor questions, supplement with random questions
        if ($professorIds->count() < $total) {
            $supplementIds = Question::query()
                ->whereNotIn('id', $professorIds)
                ->inRandomOrder()
                ->limit($total - $professorIds->count())
                ->pluck('id');

            $professorIds = $professorIds->merge($supplementIds);
        }

        return $professorIds
            ->shuffle()
            ->take($total)
            ->values()
            ->all();
    }
}
