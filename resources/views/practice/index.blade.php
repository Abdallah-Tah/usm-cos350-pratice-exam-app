<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C Programming Practice</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="min-h-screen bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 font-sans antialiased pb-20">

    <div class="sticky top-0 z-50 w-full bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md border-b border-zinc-200 dark:border-zinc-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="font-bold text-lg leading-tight text-zinc-900 dark:text-zinc-100">C Programming Practice</h1>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Interactive Coding Exercises • {{ $exercises->count() }} Challenges</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mb-2">Master C Programming</h2>
            <p class="text-zinc-600 dark:text-zinc-400">Practice implementing common C functions and algorithms. Write code directly in your browser and see results instantly.</p>
        </div>

        @foreach($categories as $category => $categoryExercises)
            <div class="mb-10">
                <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-4 capitalize">{{ str_replace('_', ' ', $category) }}</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($categoryExercises as $exercise)
                        <a href="{{ route('practice.show', $exercise->id) }}" class="group block">
                            <flux:card class="h-full transition-all hover:scale-[1.02] hover:shadow-lg">
                                <div class="p-6">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center gap-2">
                                            <span class="flex items-center justify-center size-8 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 font-bold text-sm">
                                                {{ $exercise->exercise_number }}
                                            </span>
                                        </div>
                                        <flux:badge color="{{ $exercise->difficulty === 'hard' ? 'red' : ($exercise->difficulty === 'medium' ? 'amber' : 'green') }}" variant="subtle" size="sm" class="capitalize">
                                            {{ $exercise->difficulty }}
                                        </flux:badge>
                                    </div>

                                    <h4 class="font-bold text-lg text-zinc-900 dark:text-zinc-100 mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        {{ $exercise->title }}
                                    </h4>

                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 line-clamp-2">
                                        {{ $exercise->description }}
                                    </p>

                                    <div class="mt-4 flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                                        </svg>
                                        <span>Write & Run Code</span>
                                    </div>
                                </div>
                            </flux:card>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    @fluxScripts
</body>
</html>
