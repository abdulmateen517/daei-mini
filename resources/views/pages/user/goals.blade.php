<x-daei-layout title="Personal Goals — Daei Mini">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 text-white p-6 sm:p-8 shadow-md border border-slate-800">
        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-amber-400/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-2.5 py-0.5 rounded-full border border-amber-400/20">
                        Himmah • High Aspiration
                    </span>
                    <span class="text-xs text-slate-400">Quarterly & Annual Milestones</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Personal Development Goals
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    Set structured milestones for memorization, academic pursuits, and personal discipline. Track tangible progress week over week.
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <button
                    type="button"
                    @click="isAddGoalModalOpen = true"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs active:scale-95"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                    <span>+ Set New Goal</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Goals Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="goal in goals" :key="goal.id">
            <div class="rounded-3xl p-6 bg-white border border-slate-200/90 shadow-xs flex flex-col justify-between">
                <div>
                    {{-- Category & Target Date --}}
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span
                            class="text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full"
                            :class="{
                                'bg-purple-100 text-purple-900': goal.category === 'Quran & Hifdh',
                                'bg-sky-100 text-sky-900': goal.category === 'Islamic Studies',
                                'bg-amber-100 text-amber-900': goal.category === 'Spiritual Discipline',
                                'bg-emerald-100 text-emerald-900': goal.category === 'Health & Fitness'
                            }"
                            x-text="goal.category"
                        ></span>
                        <span class="text-xs text-slate-500 font-medium" x-text="`Target: ${goal.targetDate}`"></span>
                    </div>

                    <h3 class="text-base font-extrabold text-slate-900 tracking-tight" x-text="goal.title"></h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed" x-text="goal.description"></p>

                    {{-- Progress Bar --}}
                    <div class="mt-5 space-y-2">
                        <div class="flex items-center justify-between text-xs font-bold">
                            <span class="text-slate-700" x-text="`${goal.milestonesCompleted} / ${goal.milestonesTotal} units done`"></span>
                            <span class="text-amber-600 font-extrabold" x-text="`${goal.progress}%`"></span>
                        </div>
                        <div class="h-2.5 w-full bg-slate-100 rounded-full overflow-hidden p-0.5 border border-slate-200">
                            <div
                                class="h-full bg-slate-900 rounded-full transition-all duration-300"
                                :style="`width: ${goal.progress}%`"
                            ></div>
                        </div>
                    </div>
                </div>

                {{-- Interactive Update Actions --}}
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                    <div class="flex items-center gap-1.5">
                        <button
                            type="button"
                            @click="updateGoalProgress(goal.id, goal.milestonesCompleted + 1)"
                            class="px-3 py-1.5 rounded-xl text-xs font-bold text-slate-900 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs active:scale-95"
                            :disabled="goal.milestonesCompleted >= goal.milestonesTotal"
                        >
                            +1 Unit
                        </button>
                        <button
                            type="button"
                            @click="updateGoalProgress(goal.id, Math.max(0, goal.milestonesCompleted - 1))"
                            class="px-2.5 py-1.5 rounded-xl text-xs font-bold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition-colors"
                            :disabled="goal.milestonesCompleted <= 0"
                        >
                            -1
                        </button>
                    </div>

                    <template x-if="goal.progress >= 100">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2 py-1 rounded-lg border border-emerald-200">
                            Achieved 🎉
                        </span>
                    </template>
                </div>
            </div>
        </template>
    </div>
</x-daei-layout>
