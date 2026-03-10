<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam: {{ $modeConfig['label'] }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance

    <style>
        [v-cloak] { display: none; }
        .exam-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        @media (min-width: 1024px) {
            .exam-grid {
                grid-template-columns: 1fr 300px;
            }
        }
    </style>
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
                    <h1 class="font-bold text-lg leading-tight text-zinc-900 dark:text-zinc-100">{{ $modeConfig['label'] }}</h1>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Attempt #{{ session('exam.attempt_count', 1) }} • {{ $total }} Questions</p>
                </div>
            </div>

            <div class="hidden md:flex flex-col items-end gap-1 min-w-[200px]">
                <div class="flex items-center justify-between w-full text-xs font-medium text-zinc-900 dark:text-zinc-100">
                    <span>Progress</span>
                    <span id="answered-percent">0%</span>
                </div>
                <div class="w-full bg-zinc-200 dark:bg-zinc-800 rounded-full h-2 overflow-hidden">
                    <div id="progress-fill" class="bg-blue-600 h-full transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('exam.history') }}" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                    History
                </a>
                <a href="{{ route('practice.index') }}" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                    Code Practice
                </a>
                <form action="{{ route('exam.reset', ['mode' => $mode]) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                        Reset
                    </button>
                </form>
                <button type="submit" form="exam-form" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Submit Exam
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10">
        @if (session('message'))
            <div class="mb-8 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200">
                {{ session('message') }}
            </div>
        @endif

        <div class="exam-grid items-start">
            <form id="exam-form" action="{{ route('exam.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="mode" value="{{ $mode }}">

                <div class="space-y-8">
                    @foreach ($questions as $question)
                        <flux:card class="p-0 overflow-hidden bg-white/70 dark:bg-zinc-900/70 backdrop-blur-xl border-zinc-200/60 dark:border-zinc-800/60 shadow-sm transition-all focus-within:ring-2 focus-within:ring-blue-500/50" id="q-{{ $question->id }}">
                            <div class="p-6 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between bg-zinc-50/80 dark:bg-zinc-800/50">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center size-8 rounded-full bg-blue-600 text-white font-bold text-sm">
                                        {{ $loop->iteration }}
                                    </span>
                                    <div>
                                        <span class="text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">{{ $question->section }}</span>
                                    </div>
                                </div>
                                <flux:badge color="{{ $question->difficulty === 'hard' ? 'red' : ($question->difficulty === 'medium' ? 'amber' : 'green') }}" variant="subtle" size="sm" class="capitalize">
                                    {{ $question->difficulty }}
                                </flux:badge>
                            </div>

                            <div class="p-6 pb-2">
                                <p class="text-lg font-medium leading-relaxed mb-6">
                                    {{ $question->question_text }}
                                </p>

                                @if ($question->code_snippet)
                                    <div class="mb-6 rounded-lg bg-zinc-900 border border-zinc-800 p-4 font-mono text-sm text-zinc-300 overflow-x-auto">
                                        <pre><code>{{ $question->code_snippet }}</code></pre>
                                    </div>
                                @endif
                            </div>

                            <div class="px-6 pb-6 space-y-3">
                                @foreach ($question->options as $key => $text)
                                    <label class="group flex items-start gap-4 w-full border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 transition-all hover:bg-zinc-50 dark:hover:bg-zinc-800/50 cursor-pointer has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50/50 dark:has-[:checked]:bg-blue-900/20 has-[:checked]:shadow-sm has-[:checked]:ring-1 has-[:checked]:ring-blue-500/50">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}" class="mt-1 size-4 text-blue-600 border-zinc-300 focus:ring-blue-500 dark:border-zinc-700 dark:focus:ring-blue-500 dark:bg-zinc-800 transition-transform group-hover:scale-110">
                                        <div class="flex-1 flex items-start gap-3">
                                            <span class="font-bold text-blue-600 dark:text-blue-400">{{ strtoupper($key) }})</span>
                                            <span class="text-zinc-900 dark:text-zinc-100">{{ $text }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </flux:card>
                    @endforeach
                </div>
            </form>

            <aside class="hidden lg:block sticky top-28 space-y-6">
                <flux:card class="p-6 bg-white/70 dark:bg-zinc-900/70 backdrop-blur-xl border-zinc-200/60 dark:border-zinc-800/60">
                    <h3 class="font-bold tracking-tight mb-4 flex items-center gap-2 text-zinc-900 dark:text-zinc-100">
                        <svg class="size-4 text-zinc-500 dark:text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        Question Map
                    </h3>
                    <div class="grid grid-cols-5 gap-2">
                        @foreach ($questions as $question)
                            <a href="#q-{{ $question->id }}"
                               id="map-{{ $question->id }}"
                               class="size-10 rounded-lg border border-zinc-200 dark:border-zinc-800 flex items-center justify-center text-sm font-medium transition-colors hover:border-blue-600 text-zinc-500 dark:text-zinc-400">
                                {{ $loop->iteration }}
                            </a>
                        @endforeach
                    </div>
                    <div class="my-6 border-t border-zinc-200 dark:border-zinc-800"></div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-zinc-500 dark:text-zinc-400">Answered</span>
                            <span class="text-zinc-900 dark:text-zinc-100"><span id="answered-count" class="font-bold">0</span> / {{ $total }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-zinc-500 dark:text-zinc-400">Time Est.</span>
                            <span class="font-bold text-zinc-900 dark:text-zinc-100">{{ $total * 2 }} min</span>
                        </div>
                    </div>
                </flux:card>

                <div class="p-6 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white shadow-xl shadow-blue-500/30">
                    <h4 class="font-bold mb-2 tracking-tight">Ready to finish?</h4>
                    <p class="text-blue-100 text-sm mb-5 leading-relaxed">Make sure you've reviewed all skipped questions before submitting.</p>
                    <button type="submit" form="exam-form" class="w-full px-4 py-3 text-sm font-bold bg-white text-blue-600 hover:bg-zinc-50 rounded-xl transition-all hover:shadow-lg hover:scale-[1.02]">
                        Submit Attempt
                    </button>
                </div>
            </aside>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const total = {{ $total }};
            const answeredCountEl = document.getElementById('answered-count');
            const answeredPercentEl = document.getElementById('answered-percent');
            const progressFillEl = document.getElementById('progress-fill');

            function updateProgress() {
                const forms = document.getElementById('exam-form');
                const formData = new FormData(forms);
                const answers = {};

                for (let [name, value] of formData.entries()) {
                    if (name.startsWith('answers[')) {
                        answers[name] = value;
                    }
                }

                const answered = Object.keys(answers).length;
                const percent = total ? Math.round((answered / total) * 100) : 0;

                if (answeredCountEl) answeredCountEl.textContent = answered;
                if (answeredPercentEl) answeredPercentEl.textContent = percent + '%';
                if (progressFillEl) progressFillEl.style.width = percent + '%';

                // Update map indicators
                Object.keys(answers).forEach(name => {
                    const id = name.match(/\[(\d+)\]/)[1];
                    const mapEl = document.getElementById('map-' + id);
                    if (mapEl) {
                        mapEl.classList.remove('border-zinc-200', 'dark:border-zinc-800', 'text-zinc-500');
                        mapEl.classList.add('bg-blue-600', 'border-blue-600', 'text-white');
                    }
                });
            }

            // Listen for changes on radio groups
            document.querySelectorAll('input[type="radio"]').forEach((input) => {
                input.addEventListener('change', updateProgress);
            });

            updateProgress();
        });
    </script>
</body>
</html>
