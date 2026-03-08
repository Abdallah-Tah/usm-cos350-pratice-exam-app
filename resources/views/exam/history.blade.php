<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam History</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="min-h-screen bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 font-sans antialiased pb-20">

    <div class="sticky top-0 z-50 w-full bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md border-b border-zinc-200 dark:border-zinc-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="font-bold text-lg leading-tight text-zinc-900 dark:text-zinc-100">Exam History</h1>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Track your progress and performance</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('exam.index', ['mode' => 'comprehensive']) }}" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                    New Review
                </a>
                <a href="{{ route('practice.index') }}" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                    Code Practice
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10">
        <!-- Overall Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <flux:card class="p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/40">
                        <svg class="size-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $totalAttempts }}</div>
                        <div class="text-xs text-zinc-500 dark:text-zinc-400 uppercase font-bold tracking-tight">Total Attempts</div>
                    </div>
                </div>
            </flux:card>

            <flux:card class="p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900/40">
                        <svg class="size-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $bestScore ? round($bestScore) : 0 }}%</div>
                        <div class="text-xs text-zinc-500 dark:text-zinc-400 uppercase font-bold tracking-tight">Best Score</div>
                    </div>
                </div>
            </flux:card>

            <flux:card class="p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-lg bg-purple-100 dark:bg-purple-900/40">
                        <svg class="size-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $averageScore ? round($averageScore) : 0 }}%</div>
                        <div class="text-xs text-zinc-500 dark:text-zinc-400 uppercase font-bold tracking-tight">Average Score</div>
                    </div>
                </div>
            </flux:card>
        </div>

        <!-- Statistics by Mode -->
        @if($statsByMode->isNotEmpty())
            <div class="mb-10">
                <h2 class="text-xl font-bold mb-6 text-zinc-900 dark:text-zinc-100">Performance by Mode</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($statsByMode as $modeKey => $stats)
                        @php
                            $modeConfig = $modes[$modeKey] ?? ['label' => ucfirst($modeKey)];
                        @endphp
                        <flux:card class="p-6">
                            <h3 class="font-bold text-zinc-900 dark:text-zinc-100 mb-4">{{ $modeConfig['label'] }}</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-zinc-500 dark:text-zinc-400">Attempts</span>
                                    <span class="font-bold text-zinc-900 dark:text-zinc-100">{{ $stats->count }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-zinc-500 dark:text-zinc-400">Avg Score</span>
                                    <span class="font-bold text-zinc-900 dark:text-zinc-100">{{ round($stats->avg_score) }}%</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-zinc-500 dark:text-zinc-400">Best</span>
                                    <span class="font-bold text-zinc-900 dark:text-zinc-100">{{ round($stats->best_score) }}%</span>
                                </div>
                            </div>
                        </flux:card>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Attempt History -->
        <div>
            <div class="flex flex-col gap-4 mb-6 lg:flex-row lg:items-end lg:justify-between">
                <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                    <svg class="size-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Recent Attempts
                </h2>

                <form method="GET" action="{{ route('exam.history') }}" class="grid grid-cols-1 gap-3 md:grid-cols-4">
                    <div>
                        <label for="mode" class="mb-1 block text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">Mode</label>
                        <select id="mode" name="mode" class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100">
                            <option value="">All Modes</option>
                            @foreach ($modes as $key => $config)
                                <option value="{{ $key }}" @selected($modeFilter === $key)>{{ $config['label'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="outcome" class="mb-1 block text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">Outcome</label>
                        <select id="outcome" name="outcome" class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100">
                            <option value="">All Results</option>
                            <option value="passed" @selected($outcomeFilter === 'passed')>Passed</option>
                            <option value="review" @selected($outcomeFilter === 'review')>Needs Review</option>
                        </select>
                    </div>

                    <div>
                        <label for="sort" class="mb-1 block text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">Sort</label>
                        <select id="sort" name="sort" class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100">
                            <option value="latest" @selected($sortFilter === 'latest')>Latest First</option>
                            <option value="oldest" @selected($sortFilter === 'oldest')>Oldest First</option>
                            <option value="score_high" @selected($sortFilter === 'score_high')>Highest Score</option>
                            <option value="score_low" @selected($sortFilter === 'score_low')>Lowest Score</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                            Apply
                        </button>
                        <a href="{{ route('exam.history') }}" class="inline-flex items-center justify-center rounded-lg border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800 transition-colors">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            @if($attempts->isEmpty())
                <flux:card class="p-12 text-center">
                    <div class="flex flex-col items-center gap-4">
                        <div class="p-4 rounded-full bg-zinc-100 dark:bg-zinc-800">
                            <svg class="size-8 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100 mb-2">No Exam History Yet</h3>
                            <p class="text-zinc-500 dark:text-zinc-400 mb-6">Start taking practice exams to track your progress here.</p>
                            <a href="{{ route('exam.index', ['mode' => 'comprehensive']) }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                                Start Practicing
                            </a>
                        </div>
                    </div>
                </flux:card>
            @else
                <div class="space-y-4">
                    @foreach($attempts as $attempt)
                        @php
                            $modeConfig = $modes[$attempt->mode] ?? ['label' => ucfirst($attempt->mode)];
                        @endphp
                        <flux:card class="p-0 overflow-hidden border-l-4 {{ $attempt->score >= 70 ? 'border-l-green-500' : ($attempt->score >= 50 ? 'border-l-amber-500' : 'border-l-red-500') }}">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="font-bold text-zinc-900 dark:text-zinc-100">{{ $modeConfig['label'] }}</h3>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ $attempt->created_at->format('M d, Y • h:i A') }}
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="text-right">
                                            <div class="text-3xl font-bold {{ $attempt->score >= 70 ? 'text-green-600 dark:text-green-400' : ($attempt->score >= 50 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400') }}">
                                                {{ $attempt->score }}%
                                            </div>
                                            <div class="text-xs text-zinc-500 dark:text-zinc-400 uppercase font-bold">
                                                {{ $attempt->score >= 70 ? 'Passed' : 'Review' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-4 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                                    <div class="text-center">
                                        <div class="text-lg font-bold text-zinc-900 dark:text-zinc-100">{{ $attempt->correct_answers }}</div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400">Correct</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-lg font-bold text-zinc-900 dark:text-zinc-100">{{ $attempt->total_questions - $attempt->correct_answers }}</div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400">Incorrect</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-lg font-bold text-zinc-900 dark:text-zinc-100">{{ $attempt->answered_questions }}/{{ $attempt->total_questions }}</div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400">Answered</div>
                                    </div>
                                </div>

                                <div class="mt-5 pt-5 border-t border-zinc-100 dark:border-zinc-800 flex justify-end">
                                    <a href="{{ route('exam.history.show', $attempt) }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-blue-700 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                                        Review Attempt
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </flux:card>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($attempts->hasPages())
                    <div class="mt-8">
                        {{ $attempts->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>

    @fluxScripts
</body>
</html>
