<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex flex-col gap-2">
            <h1 class="text-2xl font-bold tracking-tight">Study Command Center</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm">Welcome back to your COS 350 preparation hub.</p>
        </div>

        <div class="grid auto-rows-min gap-6 md:grid-cols-2 lg:grid-cols-3">
            <flux:card class="p-6 flex flex-col items-start gap-4 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-500/10 bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md">
                <div class="p-3 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 dark:from-blue-900/40 dark:to-blue-800/20 text-blue-600 dark:text-blue-400 ring-1 ring-blue-500/20">
                    <flux:icon.book-open class="size-6" />
                </div>
                <div>
                    <h2 class="text-lg font-bold tracking-tight">Comprehensive Review</h2>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                        Practice with the full question pool (50 questions). Ideal for deep conceptual coverage.
                    </p>
                </div>
                <flux:button href="{{ route('exam.index', ['mode' => 'comprehensive']) }}" variant="outline" size="sm" class="mt-auto group w-full">
                    Start Review
                    <flux:icon.arrow-right class="size-3 ml-2 transition-transform group-hover:translate-x-1" />
                </flux:button>
            </flux:card>

            <flux:card class="p-6 flex flex-col items-start gap-4 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-500/10 border-indigo-200/60 dark:border-indigo-800/60 bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md">
                <div class="p-3 rounded-xl bg-gradient-to-br from-indigo-100 to-indigo-50 dark:from-indigo-900/40 dark:to-indigo-800/20 text-indigo-600 dark:text-indigo-400 ring-1 ring-indigo-500/20">
                    <flux:icon.clock class="size-6" />
                </div>
                <div>
                    <h2 class="text-lg font-bold tracking-tight">Realistic Mock Exam</h2>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                        A timed, 20-question attempt weighted by section importance to simulate actual exam stress.
                    </p>
                </div>
                <flux:button href="{{ route('exam.index', ['mode' => 'realistic']) }}" variant="primary" size="sm" class="mt-auto group w-full">
                    Start Mock Exam
                    <flux:icon.arrow-right class="size-3 ml-2 transition-transform group-hover:translate-x-1" />
                </flux:button>
            </flux:card>

            <flux:card class="p-6 flex flex-col items-start gap-4 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-zinc-500/10 bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md">
                <div class="p-3 rounded-xl bg-gradient-to-br from-zinc-100 to-zinc-50 dark:from-zinc-800/60 dark:to-zinc-800/20 text-zinc-700 dark:text-zinc-300 ring-1 ring-zinc-500/20">
                    <flux:icon.chart-bar class="size-6" />
                </div>
                <div>
                    <h2 class="text-lg font-bold tracking-tight">Attempt History</h2>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                        Review past scores, compare performance by mode, and track improvement over time.
                    </p>
                </div>
                <flux:button href="{{ route('exam.history') }}" variant="ghost" size="sm" class="mt-auto group w-full">
                    View History
                    <flux:icon.arrow-right class="size-3 ml-2 transition-transform group-hover:translate-x-1" />
                </flux:button>
            </flux:card>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <flux:card class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold tracking-tight">Exam Preparation Tips</h3>
                    <flux:icon.sparkles class="size-5 text-amber-500" />
                </div>
                <ul class="space-y-4">
                    <li class="flex gap-3 text-sm">
                        <flux:icon.check-circle class="size-5 text-green-500 shrink-0" />
                        <span class="text-zinc-600 dark:text-zinc-400">Focus on <strong class="text-zinc-900 dark:text-zinc-100">Pointers and Memory Allocation</strong>; they often make up 30% of the midterm.</span>
                    </li>
                    <li class="flex gap-3 text-sm">
                        <flux:icon.check-circle class="size-5 text-green-500 shrink-0" />
                        <span class="text-zinc-600 dark:text-zinc-400">Practice manual <strong class="text-zinc-900 dark:text-zinc-100">File Descriptor</strong> tracking for multi-pipe problems.</span>
                    </li>
                    <li class="flex gap-3 text-sm">
                        <flux:icon.check-circle class="size-5 text-green-500 shrink-0" />
                        <span class="text-zinc-600 dark:text-zinc-400">Understand <strong class="text-zinc-900 dark:text-zinc-100">Signals</strong> and how they interrupt system calls.</span>
                    </li>
                </ul>
            </flux:card>

            <flux:card class="p-6 bg-zinc-50/50 dark:bg-zinc-800/30 border-dashed border-zinc-300 dark:border-zinc-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold tracking-tight">Recent Attempts</h3>
                    <flux:button href="{{ route('exam.history') }}" variant="subtle" size="sm">Open History</flux:button>
                </div>
                <div class="flex flex-col items-center justify-center py-10 opacity-70 text-center">
                    <flux:icon.document-chart-bar class="size-12 mb-4 text-zinc-400" />
                    <p class="text-xs uppercase tracking-widest font-bold text-zinc-500 dark:text-zinc-400">History Enabled</p>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400 max-w-xs">
                        Each submitted exam is saved so you can review your performance later.
                    </p>
                </div>
            </flux:card>
        </div>
    </div>
</x-layouts::app>
