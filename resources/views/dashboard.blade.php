<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex flex-col gap-2">
            <h1 class="text-2xl font-bold tracking-tight">Study Command Center</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm">Welcome back to your COS 350 preparation hub.</p>
        </div>

        <div class="grid auto-rows-min gap-6 md:grid-cols-2 lg:grid-cols-3">
            <flux:card class="p-6 flex flex-col items-start gap-4 hover:shadow-lg transition-shadow">
                <div class="p-3 rounded-xl bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400">
                    <flux:icon.book-open class="size-6" />
                </div>
                <div>
                    <h2 class="text-lg font-bold">Comprehensive Review</h2>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                        Practice with the full question pool (50 questions). Ideal for deep conceptual coverage.
                    </p>
                </div>
                <flux:button href="{{ route('exam.index', ['mode' => 'comprehensive']) }}" variant="outline" size="sm" class="mt-auto">Start Review</flux:button>
            </flux:card>

            <flux:card class="p-6 flex flex-col items-start gap-4 hover:shadow-lg transition-shadow border-indigo-200 dark:border-indigo-800 bg-indigo-50/20">
                <div class="p-3 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400">
                    <flux:icon.clock class="size-6" />
                </div>
                <div>
                    <h2 class="text-lg font-bold">Realistic Mock Exam</h2>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                        A timed, 20-question attempt weighted by section importance to simulate actual exam stress.
                    </p>
                </div>
                <flux:button href="{{ route('exam.index', ['mode' => 'realistic']) }}" variant="primary" size="sm" class="mt-auto">Start Mock Exam</flux:button>
            </flux:card>

            <flux:card class="p-6 flex flex-col items-start gap-4">
                <div class="p-3 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-600">
                    <flux:icon.academic-cap class="size-6" />
                </div>
                <div>
                    <h2 class="text-lg font-bold">Quick Study</h2>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                        Need a quick refresh? Jump into a random 10-question sprint soon. (Coming Soon)
                    </p>
                </div>
                <flux:button variant="ghost" size="sm" class="mt-auto" disabled>Coming Soon</flux:button>
            </flux:card>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <flux:card class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold">Exam Preparation Tips</h3>
                    <flux:icon.sparkles class="size-5 text-amber-500" />
                </div>
                <ul class="space-y-4">
                    <li class="flex gap-3 text-sm">
                        <flux:icon.check-circle class="size-5 text-green-500 shrink-0" />
                        <span>Focus on **Pointers and Memory Allocation**; they often make up 30% of the midterm.</span>
                    </li>
                    <li class="flex gap-3 text-sm">
                        <flux:icon.check-circle class="size-5 text-green-500 shrink-0" />
                        <span>Practice manual **File Descriptor** tracking for multi-pipe problems.</span>
                    </li>
                    <li class="flex gap-3 text-sm">
                        <flux:icon.check-circle class="size-5 text-green-500 shrink-0" />
                        <span>Understand **Signals** and how they interrupt system calls.</span>
                    </li>
                </ul>
            </flux:card>

            <flux:card class="p-6 bg-zinc-50 dark:bg-zinc-800/20 border-dashed">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold">Recent Attempts</h3>
                    <flux:badge size="sm" variant="subtle">Coming Soon</flux:badge>
                </div>
                <div class="flex flex-col items-center justify-center py-10 opacity-30">
                    <flux:icon.document-chart-bar class="size-12 mb-4" />
                    <p class="text-xs uppercase tracking-widest font-bold">Storage not enabled</p>
                </div>
            </flux:card>
        </div>
    </div>
</x-layouts::app>
