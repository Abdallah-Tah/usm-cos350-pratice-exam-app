<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attempt Review: {{ $score }}%</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="min-h-screen bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 font-sans antialiased pb-20">

    <div class="max-w-4xl mx-auto px-6 py-12">
        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('exam.history') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Back to History
            </a>
            <div class="flex gap-3">
                <a href="{{ route('exam.index', ['mode' => $mode]) }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 border border-zinc-300 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800 rounded-lg transition-colors">
                    Retake Mode
                </a>
                <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                    Print Review
                </button>
            </div>
        </div>

        <flux:card class="overflow-hidden border-t-4 border-t-blue-600 dark:border-t-blue-500 mb-10">
            <div class="p-8 text-center border-b border-zinc-100 dark:border-zinc-800">
                <flux:badge color="blue" variant="subtle" class="mb-4">Saved Attempt</flux:badge>
                <h1 class="text-3xl font-bold mb-2">{{ $modeConfig['label'] }} Review</h1>
                <p class="text-zinc-500 dark:text-zinc-400">Completed on {{ $attempt->created_at->format('M d, Y • h:i A') }}</p>

                <div class="mt-8 grid grid-cols-4 gap-4 border-t border-zinc-100 dark:border-zinc-800 pt-8">
                    <div>
                        <div class="text-2xl font-bold">{{ $score }}%</div>
                        <div class="text-xs text-zinc-500 uppercase font-bold tracking-tight">Score</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">{{ $correct }}</div>
                        <div class="text-xs text-zinc-500 uppercase font-bold tracking-tight">Correct</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">{{ $total - $correct }}</div>
                        <div class="text-xs text-zinc-500 uppercase font-bold tracking-tight">Incorrect</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">{{ $answered }}/{{ $total }}</div>
                        <div class="text-xs text-zinc-500 uppercase font-bold tracking-tight">Answered</div>
                    </div>
                </div>
            </div>
        </flux:card>

        <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
            <flux:icon.clipboard-document-check class="size-5 text-zinc-400" />
            Question Review
        </h2>

        <div class="space-y-6">
            @foreach ($results as $result)
                @php
                    $question = $result['question'];
                    $userAnswer = $result['user_answer'];
                    $isCorrect = $result['is_correct'];
                    $correctAnswer = $question->correct_answer;
                @endphp

                <flux:card class="p-0 overflow-hidden border-l-4 {{ $isCorrect ? 'border-l-green-500' : 'border-l-red-500' }}">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold text-zinc-500 uppercase tracking-widest">{{ $question->section }}</span>
                            <flux:badge color="{{ $isCorrect ? 'green' : 'red' }}" variant="subtle">
                                {{ $isCorrect ? 'Correct' : 'Incorrect' }}
                            </flux:badge>
                        </div>

                        <p class="font-medium mb-6 leading-relaxed">{{ $loop->iteration }}. {{ $question->question_text }}</p>

                        @if ($question->code_snippet)
                            <div class="mb-6 rounded-lg bg-zinc-900 p-4 font-mono text-xs text-zinc-300 overflow-x-auto">
                                <pre><code>{{ $question->code_snippet }}</code></pre>
                            </div>
                        @endif

                        <div class="space-y-3">
                            <div class="flex items-center gap-3 p-3 rounded-lg border {{ $isCorrect ? 'bg-green-50 dark:bg-green-900/10 border-green-200 dark:border-green-800' : 'border-zinc-100 dark:border-zinc-800' }}">
                                <div class="font-bold text-sm w-6">
                                    @if ($isCorrect)
                                        <flux:icon.check class="size-4 text-green-600" />
                                    @else
                                        <span class="text-zinc-400">@if($userAnswer) {{ strtoupper($userAnswer) }} @else -- @endif</span>
                                    @endif
                                </div>
                                <div class="text-sm">
                                    <span class="text-zinc-500 mr-2">Your Answer:</span>
                                    <span class="{{ $isCorrect ? 'text-green-700 dark:text-green-400' : 'text-red-700 dark:text-red-400' }}">
                                        @if($userAnswer)
                                            {{ strtoupper($userAnswer) }}) {{ $question->options[$userAnswer] }}
                                        @else
                                            (No Answer Provided)
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 p-3 rounded-lg border bg-blue-50 dark:bg-blue-900/10 border-blue-200 dark:border-blue-800">
                                <div class="font-bold text-sm w-6">
                                    <flux:icon.check class="size-4 text-blue-600" />
                                </div>
                                <div class="text-sm">
                                    <span class="text-zinc-500 mr-2">Correct Answer:</span>
                                    <span class="text-blue-700 dark:text-blue-400">{{ strtoupper($correctAnswer) }}) {{ $question->options[$correctAnswer] }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-zinc-100 dark:border-zinc-800">
                            <div class="flex items-start gap-3">
                                <flux:icon.information-circle class="size-5 text-zinc-400 shrink-0" />
                                <div class="text-sm text-zinc-600 dark:text-zinc-400">
                                    <strong class="text-zinc-900 dark:text-zinc-200">Explanation:</strong>
                                    {{ $question->explanation }}
                                </div>
                            </div>
                        </div>
                    </div>
                </flux:card>
            @endforeach
        </div>
    </div>

    @fluxScripts
</body>
</html>
