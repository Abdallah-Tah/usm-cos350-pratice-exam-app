<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exercise->title }} - C Practice</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|jetbrains-mono:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance

    <style>
        .code-editor {
            font-family: 'JetBrains Mono', 'Courier New', monospace;
            tab-size: 4;
        }
        .output-terminal {
            font-family: 'JetBrains Mono', 'Courier New', monospace;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
</head>
<body class="min-h-screen bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 font-sans antialiased pb-20">

    <div class="sticky top-0 z-50 w-full bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md border-b border-zinc-200 dark:border-zinc-800 shadow-sm">
        <div class="max-w-[1800px] mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('practice.index') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="font-bold text-lg leading-tight text-zinc-900 dark:text-zinc-100">{{ $exercise->title }}</h1>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Exercise #{{ $exercise->exercise_number }} • {{ ucfirst($exercise->difficulty) }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button onclick="resetCode()" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                    Reset
                </button>
                <button id="show-solution-btn" onclick="showSolution()" class="px-4 py-2 text-sm font-medium text-amber-700 dark:text-amber-300 hover:text-amber-900 dark:hover:text-amber-100 transition-colors">
                    Show Solution
                </button>
                <button onclick="runCode()" id="run-btn" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                    </svg>
                    Run Code
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-[1800px] mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Panel: Instructions -->
            <div class="space-y-6">
                <flux:card class="p-6 bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md border border-zinc-200/60 dark:border-zinc-800/60">
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">Instructions</h2>
                    <div class="prose prose-zinc dark:prose-invert max-w-none">
                        <p class="text-zinc-700 dark:text-zinc-300">{{ $exercise->instructions }}</p>
                    </div>
                </flux:card>

                @if($exercise->hints)
                <flux:card class="p-6 border-l-4 border-l-blue-500 bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md border-y border-r border-zinc-200/60 dark:border-zinc-800/60">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100 mb-2 flex items-center gap-2">
                        <svg class="size-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                        </svg>
                        Hint
                    </h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $exercise->hints }}</p>
                </flux:card>
                @endif

                <flux:card class="p-6 bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md border border-zinc-200/60 dark:border-zinc-800/60">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100 mb-4">Expected Output</h3>
                    <div class="space-y-2">
                        @foreach($exercise->test_cases as $index => $testCase)
                            <div class="p-3 rounded-lg bg-zinc-100 dark:bg-zinc-800 font-mono text-sm">
                                <div class="text-zinc-500 dark:text-zinc-400 text-xs mb-1">Test Case {{ $index + 1 }}:</div>
                                <div class="text-zinc-900 dark:text-zinc-100">{{ $testCase['expected'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </flux:card>

                <!-- Exercise Navigator -->
                <flux:card class="p-4 bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md border border-zinc-200/60 dark:border-zinc-800/60">
                    <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-3">Other Exercises</h3>
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($allExercises as $ex)
                            <a href="{{ route('practice.show', $ex->id) }}"
                               class="size-10 rounded-lg border flex items-center justify-center text-sm font-medium transition-colors {{ $ex->id === $exercise->id ? 'bg-blue-600 text-white border-blue-600' : 'border-zinc-200 dark:border-zinc-800 text-zinc-500 dark:text-zinc-400 hover:border-blue-600' }}">
                                {{ $ex->exercise_number }}
                            </a>
                        @endforeach
                    </div>
                </flux:card>
            </div>

            <!-- Right Panel: Code Editor & Output -->
            <div class="space-y-6">
                <flux:card class="p-0 overflow-hidden">
                    <div class="bg-zinc-800 dark:bg-zinc-900 px-4 py-2 flex items-center justify-between border-b border-zinc-700">
                        <span class="text-xs font-medium text-zinc-300">main.c</span>
                        <span class="text-xs text-zinc-400">C Programming</span>
                    </div>
                    <textarea
                        id="code-editor"
                        class="code-editor w-full h-[500px] p-4 bg-zinc-900 text-zinc-100 text-sm resize-none focus:outline-none border-none"
                        spellcheck="false"
                    >{{ $exercise->starter_code }}</textarea>
                </flux:card>

                <flux:card class="p-0 overflow-hidden">
                    <div class="bg-zinc-800 dark:bg-zinc-900 px-4 py-2 flex items-center justify-between border-b border-zinc-700">
                        <span class="text-xs font-medium text-zinc-300">Output</span>
                        <span id="output-status" class="text-xs text-zinc-400"></span>
                    </div>
                    <div id="output-terminal" class="output-terminal p-4 bg-zinc-900 text-zinc-100 text-sm min-h-[200px] max-h-[400px] overflow-y-auto">
                        <div class="text-zinc-500">Press "Run Code" to see output...</div>
                    </div>
                </flux:card>
            </div>
        </div>
    </div>

    <script>
        const starterCode = @json($exercise->starter_code);
        const solutionCode = @json($exercise->solution_code);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        function resetCode() {
            document.getElementById('code-editor').value = starterCode;
            document.getElementById('output-terminal').innerHTML = '<div class="text-zinc-500">Press "Run Code" to see output...</div>';
            document.getElementById('output-status').textContent = '';
        }

        function showSolution() {
            if (confirm('Are you sure you want to see the solution? Try solving it yourself first!')) {
                document.getElementById('code-editor').value = solutionCode;
            }
        }

        async function runCode() {
            const code = document.getElementById('code-editor').value;
            const runBtn = document.getElementById('run-btn');
            const outputTerminal = document.getElementById('output-terminal');
            const outputStatus = document.getElementById('output-status');

            // Disable button and show loading
            runBtn.disabled = true;
            runBtn.innerHTML = '<svg class="size-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Running...';
            outputStatus.textContent = 'Compiling...';
            outputTerminal.innerHTML = '<div class="text-zinc-500">Compiling and running your code...</div>';

            try {
                const response = await fetch('{{ route("practice.run") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ code })
                });

                const result = await response.json();

                if (result.success) {
                    outputStatus.textContent = 'Success';
                    outputStatus.className = 'text-xs text-green-400';
                    outputTerminal.innerHTML = `<div class="text-green-400">${escapeHtml(result.output) || '(No output)'}</div>`;
                } else {
                    outputStatus.textContent = result.error || 'Error';
                    outputStatus.className = 'text-xs text-red-400';
                    outputTerminal.innerHTML = `<div class="text-red-400"><strong>${result.error}</strong>\n${escapeHtml(result.output)}</div>`;
                }
            } catch (error) {
                outputStatus.textContent = 'Error';
                outputStatus.className = 'text-xs text-red-400';
                outputTerminal.innerHTML = `<div class="text-red-400">Network error: ${error.message}</div>`;
            } finally {
                // Re-enable button
                runBtn.disabled = false;
                runBtn.innerHTML = '<svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" /></svg> Run Code';
            }
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Allow Ctrl/Cmd + Enter to run code
        document.getElementById('code-editor').addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                e.preventDefault();
                runCode();
            }

            // Handle Tab key for indentation
            if (e.key === 'Tab') {
                e.preventDefault();
                const start = this.selectionStart;
                const end = this.selectionEnd;
                const value = this.value;

                this.value = value.substring(0, start) + '    ' + value.substring(end);
                this.selectionStart = this.selectionEnd = start + 4;
            }
        });
    </script>

    @fluxScripts
</body>
</html>
