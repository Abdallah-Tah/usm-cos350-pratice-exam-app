<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Results: {{ $score }}%</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="min-h-screen bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 font-sans antialiased pb-20">

    <div class="max-w-4xl mx-auto px-6 py-12">
        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                Back to Home
            </a>
            <div class="flex gap-3">
                <a href="{{ route('practice.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 border border-zinc-300 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800 rounded-lg transition-colors">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                    </svg>
                    Code Practice
                </a>
                <a href="{{ route('exam.index', ['mode' => $mode]) }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 border border-zinc-300 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800 rounded-lg transition-colors">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Retake Exam
                </a>
                <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                    </svg>
                    Print Results
                </button>
            </div>
        </div>

        <flux:card class="overflow-hidden border-t-4 border-t-blue-600 dark:border-t-blue-500 mb-10">
            <div class="p-8 text-center border-b border-zinc-100 dark:border-zinc-800">
                <flux:badge color="blue" variant="subtle" class="mb-4">Performance Transcript</flux:badge>
                <h1 class="text-3xl font-bold mb-2">{{ $modeConfig['label'] }} Results</h1>
                <p class="text-zinc-500 dark:text-zinc-400">Completed on {{ now()->format('M d, Y • h:i A') }}</p>

                <div class="mt-10 flex flex-col items-center">
                    <div class="relative size-40 flex items-center justify-center">
                        <svg class="size-full rotate-[-90deg]">
                            <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="12" fill="transparent" class="text-zinc-100 dark:text-zinc-800" />
                            <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="12" fill="transparent"
                                class="{{ $score >= 70 ? 'text-green-500' : ($score >= 50 ? 'text-amber-500' : 'text-red-500') }}"
                                stroke-dasharray="440"
                                stroke-dashoffset="{{ 440 - (440 * $score) / 100 }}"
                                stroke-linecap="round" />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-4xl font-black">{{ $score }}%</span>
                            <span class="text-xs font-bold uppercase tracking-widest opacity-50">{{ $score >= 70 ? 'Passed' : 'Review' }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-3 gap-4 border-t border-zinc-100 dark:border-zinc-800 pt-8">
                    <div>
                        <div class="text-2xl font-bold">{{ $correct }}</div>
                        <div class="text-xs text-zinc-500 uppercase font-bold tracking-tight">Correct</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">{{ $total - $correct }}</div>
                        <div class="text-xs text-zinc-500 uppercase font-bold tracking-tight">Incorrect</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">{{ $answered }}</div>
                        <div class="text-xs text-zinc-500 uppercase font-bold tracking-tight">Answered</div>
                    </div>
                </div>
            </div>

            <div class="p-8 bg-zinc-50/50 dark:bg-zinc-800/30">
                <h3 class="font-bold mb-4 flex items-center gap-2">
                    <flux:icon.chart-bar class="size-4 text-zinc-400" />
                    Lecture Coverage
                </h3>
                <div class="space-y-3">
                    @php
                        $resultsBySection = collect($results)->groupBy(fn($r) => $r['question']->section);
                    @endphp

                    @foreach ($resultsBySection as $section => $items)
                        @php
                            $sectionCorrect = $items->where('is_correct', true)->count();
                            $sectionTotal = $items->count();
                            $sectionPercent = round(($sectionCorrect / $sectionTotal) * 100);
                        @endphp
                        <div class="flex flex-col gap-1">
                            <div class="flex justify-between text-xs font-medium">
                                <span class="truncate pr-4">{{ $section }}</span>
                                <span>{{ $sectionCorrect }}/{{ $sectionTotal }}</span>
                            </div>
                            <div class="w-full h-1.5 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all {{ $sectionPercent >= 70 ? 'bg-green-500' : ($sectionPercent >= 40 ? 'bg-amber-500' : 'bg-red-500') }}" style="width: {{ $sectionPercent }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </flux:card>

        <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
            <flux:icon.clipboard-document-check class="size-5 text-zinc-400" />
            Answer Review
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
                            <flux:badge color="{{ $isCorrect ? 'green' : 'red' }}" variant="subtle" icon="{{ $isCorrect ? 'check' : 'x-mark' }}">
                                {{ $isCorrect ? 'Correct' : 'Incorrect' }}
                            </flux:badge>
                        </div>

                        <p class="font-medium mb-6 leading-relaxed">{{ $question->question_text }}</p>

                        @if ($question->code_snippet)
                            <div class="mb-6 rounded-lg bg-zinc-900 p-4 font-mono text-xs text-zinc-300">
                                <pre><code>{{ $question->code_snippet }}</code></pre>
                            </div>
                        @endif

                        <div class="space-y-3">
                            <div class="flex items-center gap-3 p-3 rounded-lg border {{ $userAnswer === $correctAnswer ? 'bg-green-50 dark:bg-green-900/10 border-green-200 dark:border-green-800' : 'border-zinc-100 dark:border-zinc-800' }}">
                                <div class="font-bold text-sm w-6">
                                    @if ($userAnswer === $correctAnswer)
                                        <flux:icon.check class="size-4 text-green-600" />
                                    @else
                                        <span class="text-zinc-400">@if($userAnswer) {{ strtoupper($userAnswer) }} @else -- @endif</span>
                                    @endif
                                </div>
                                <div class="text-sm">
                                    <span class="text-zinc-500 mr-2">Your Answer:</span>
                                    <span class="{{ $isCorrect ? 'text-green-700 dark:text-green-400' : 'text-red-700 dark:text-red-400' }}">
                                        @if($userAnswer)
                                            {{ $question->options[$userAnswer] }}
                                        @else
                                            (No Answer Provided)
                                        @endif
                                    </span>
                                </div>
                            </div>

                            @if (!$isCorrect)
                                <div class="flex items-center gap-3 p-3 rounded-lg border bg-blue-50 dark:bg-blue-900/10 border-blue-200 dark:border-blue-800">
                                    <div class="font-bold text-sm w-6">
                                        <flux:icon.check class="size-4 text-blue-600" />
                                    </div>
                                    <div class="text-sm">
                                        <span class="text-zinc-500 mr-2">Correct Answer:</span>
                                        <span class="text-blue-700 dark:text-blue-400">{{ $question->options[$correctAnswer] }}</span>
                                    </div>
                                </div>
                            @endif
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
