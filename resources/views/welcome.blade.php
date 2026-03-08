<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>COS 350 Exam Mastery</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 font-sans antialiased">
        <div class="relative overflow-hidden">
            <!-- Decorative background -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[500px] pointer-events-none opacity-50 dark:opacity-30">
                <div class="absolute inset-0 bg-radial-at-t from-blue-500/20 to-transparent"></div>
            </div>

            <header class="relative z-10 max-w-7xl mx-auto px-6 py-8 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <flux:icon.academic-cap class="size-8 text-blue-600 dark:text-blue-400" />
                    <span class="text-xl font-bold tracking-tight">COS 350 <span class="text-blue-600 dark:text-blue-400">Mastery</span></span>
                </div>

                @if (Route::has('login'))
                    <nav class="flex items-center gap-4">
                        @auth
                            <flux:button href="{{ route('dashboard') }}" variant="subtle" wire:navigate>Dashboard</flux:button>
                        @else
                            <flux:button href="{{ route('login') }}" variant="ghost">Log in</flux:button>
                            @if (Route::has('register'))
                                <flux:button href="{{ route('register') }}" variant="primary">Register</flux:button>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <main class="relative z-10 max-w-4xl mx-auto px-6 pt-20 pb-32 text-center">
                <flux:badge color="blue" variant="outline" class="mb-6">Spring 2026 Edition</flux:badge>
                <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6">
                    Master Systems Programming <br/>
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-500">With Confidence.</span>
                </h1>
                <p class="text-xl text-zinc-600 dark:text-zinc-400 mb-12 max-w-2xl mx-auto">
                    A comprehensive, randomized practice environment built specifically for the COS 350 midterm and final exams. Don't just study—practice for perfection.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-left">
                    <flux:card class="p-6 transition-all hover:scale-[1.02]">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400">
                                <flux:icon.book-open class="size-6" />
                            </div>
                            <h2 class="text-xl font-bold">Comprehensive Review</h2>
                        </div>
                        <p class="text-zinc-600 dark:text-zinc-400 mb-6">
                            Deep dive into the full pool of questions. Perfect for long study sessions where you want to cover every edge case and lecture concept.
                        </p>
                        <flux:button href="{{ route('exam.index', ['mode' => 'comprehensive']) }}" variant="outline" class="w-full">Start 50-Question Review</flux:button>
                    </flux:card>

                    <flux:card class="p-6 transition-all hover:scale-[1.02] border-blue-200 dark:border-blue-800 shadow-lg">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 rounded-lg bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400">
                                <flux:icon.clock class="size-6" />
                            </div>
                            <h2 class="text-xl font-bold">Realistic Midterm</h2>
                        </div>
                        <p class="text-zinc-600 dark:text-zinc-400 mb-6">
                            Simulated exam conditions. 20 questions weighted by lecture section importance, designed to mirror the actual exam difficulty and timing.
                        </p>
                        <flux:button href="{{ route('exam.index', ['mode' => 'realistic']) }}" variant="primary" class="w-full">Start Mock Exam</flux:button>
                    </flux:card>

                    <flux:card class="p-6 transition-all hover:scale-[1.02] border-green-200 dark:border-green-800">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 rounded-lg bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-400">
                                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold">Code Practice</h2>
                        </div>
                        <p class="text-zinc-600 dark:text-zinc-400 mb-6">
                            Write and run real C code in your browser. Practice implementing strlen, strcpy, pointers, arrays, and more with instant feedback.
                        </p>
                        <flux:button href="{{ route('practice.index') }}" variant="outline" class="w-full">Start Coding</flux:button>
                    </flux:card>
                </div>
            </main>

            <footer class="max-w-7xl mx-auto px-6 py-12 border-t border-zinc-200 dark:border-zinc-800 text-center text-zinc-500 dark:text-zinc-400 text-sm">
                <p>&copy; 2026 COS 350 System Programming Practice. Built with Laravel Flux.</p>
            </footer>
        </div>

        @fluxScripts
    </body>
</html>
