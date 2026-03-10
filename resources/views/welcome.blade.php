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
        <div class="relative overflow-hidden selection:bg-blue-500/30">
            <!-- Decorative background -->
            <div class="absolute inset-0 -z-10 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] dark:bg-[radial-gradient(#27272a_1px,transparent_1px)] [background-size:16px_16px] [mask-image:radial-gradient(ellipse_50%_50%_at_50%_50%,#000_70%,transparent_100%)]"></div>
            
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[600px] pointer-events-none opacity-60 dark:opacity-40 -z-10">
                <div class="absolute inset-0 bg-radial-at-t from-blue-500/30 via-indigo-500/10 to-transparent"></div>
            </div>

            <header class="relative z-10 max-w-7xl mx-auto px-6 py-8 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <flux:icon.academic-cap class="size-8 text-blue-600 dark:text-blue-400" />
                    <span class="text-xl font-bold tracking-tight">COS 350 <span class="text-blue-600 dark:text-blue-400">Mastery</span></span>
                </div>

                @if (Route::has('login'))
                    <nav class="flex items-center gap-4">
                        <flux:button href="{{ route('exam.history') }}" variant="ghost">History</flux:button>
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

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 xl:gap-8 text-left">
                    <flux:card class="p-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-blue-500/10 bg-white/60 dark:bg-zinc-900/60 backdrop-blur-xl border-zinc-200/60 dark:border-zinc-800/60">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2.5 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 dark:from-blue-900/40 dark:to-blue-800/20 text-blue-600 dark:text-blue-400 ring-1 ring-blue-500/20">
                                <flux:icon.book-open class="size-6" />
                            </div>
                            <h2 class="text-xl font-bold tracking-tight">Comprehensive</h2>
                        </div>
                        <p class="text-zinc-600 dark:text-zinc-400 mb-6 leading-relaxed text-sm">
                            Deep dive into the full pool of questions. Perfect for long study sessions where you want to cover every edge case and lecture concept.
                        </p>
                        <flux:button href="{{ route('exam.index', ['mode' => 'comprehensive']) }}" variant="outline" class="w-full group">
                            Start 50-Question Review
                            <flux:icon.arrow-right class="size-4 ml-2 transition-transform group-hover:translate-x-1" />
                        </flux:button>
                    </flux:card>

                    <flux:card class="p-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-indigo-500/10 bg-white/60 dark:bg-zinc-900/60 backdrop-blur-xl border-indigo-200/60 dark:border-indigo-800/60">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2.5 rounded-xl bg-gradient-to-br from-indigo-100 to-indigo-50 dark:from-indigo-900/40 dark:to-indigo-800/20 text-indigo-600 dark:text-indigo-400 ring-1 ring-indigo-500/20">
                                <flux:icon.clock class="size-6" />
                            </div>
                            <h2 class="text-xl font-bold tracking-tight">Realistic Midterm</h2>
                        </div>
                        <p class="text-zinc-600 dark:text-zinc-400 mb-6 leading-relaxed text-sm">
                            Simulated exam conditions. 20 questions weighted by lecture section importance, designed to mirror the actual exam difficulty and timing.
                        </p>
                        <flux:button href="{{ route('exam.index', ['mode' => 'realistic']) }}" variant="primary" class="w-full group">
                            Start Mock Exam
                            <flux:icon.arrow-right class="size-4 ml-2 transition-transform group-hover:translate-x-1" />
                        </flux:button>
                    </flux:card>

                    <flux:card class="p-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-purple-500/10 bg-white/60 dark:bg-zinc-900/60 backdrop-blur-xl border-purple-200/60 dark:border-purple-800/60">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2.5 rounded-xl bg-gradient-to-br from-purple-100 to-purple-50 dark:from-purple-900/40 dark:to-purple-800/20 text-purple-600 dark:text-purple-400 ring-1 ring-purple-500/20">
                                <flux:icon.academic-cap class="size-6" />
                            </div>
                            <h2 class="text-xl font-bold tracking-tight">Professor Test</h2>
                        </div>
                        <p class="text-zinc-600 dark:text-zinc-400 mb-6 leading-relaxed text-sm">
                            Based on actual professor practice test. 12 targeted questions covering Unix commands, system calls, file permissions, and C programming.
                        </p>
                        <flux:button href="{{ route('exam.index', ['mode' => 'professor']) }}" variant="primary" color="purple" class="w-full group">
                            Start Professor Test
                            <flux:icon.arrow-right class="size-4 ml-2 transition-transform group-hover:translate-x-1" />
                        </flux:button>
                    </flux:card>

                    <flux:card class="p-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-green-500/10 bg-white/60 dark:bg-zinc-900/60 backdrop-blur-xl border-green-200/60 dark:border-green-800/60">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2.5 rounded-xl bg-gradient-to-br from-green-100 to-green-50 dark:from-green-900/40 dark:to-green-800/20 text-green-600 dark:text-green-400 ring-1 ring-green-500/20">
                                <flux:icon.code-bracket class="size-6" />
                            </div>
                            <h2 class="text-xl font-bold tracking-tight">Code Practice</h2>
                        </div>
                        <p class="text-zinc-600 dark:text-zinc-400 mb-6 leading-relaxed text-sm">
                            Write and run real C code in your browser. Practice implementing strlen, strcpy, pointers, arrays, and more with instant feedback.
                        </p>
                        <flux:button href="{{ route('practice.index') }}" variant="outline" class="w-full group">
                            Start Coding
                            <flux:icon.arrow-right class="size-4 ml-2 transition-transform group-hover:translate-x-1" />
                        </flux:button>
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
