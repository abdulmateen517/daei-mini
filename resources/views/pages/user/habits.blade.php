<x-daei-layout title="Habits Tracking — Daei Mini">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 text-white p-6 sm:p-8 shadow-md border border-slate-800">
        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-amber-400/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-2.5 py-0.5 rounded-full border border-amber-400/20">
                        Istiqamah • Consistency
                    </span>
                    <span class="text-xs text-slate-400">Daily Routines</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Habits & Streaks Tracking
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    "The most beloved of deeds to Allah are those that are most consistent, even if they are small." Build lasting spiritual and productivity habits.
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <button
                    type="button"
                    @click="isAddHabitModalOpen = true"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs active:scale-95"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                    <span>+ Add New Habit</span>
                </button>
            </div>
        </div>

        {{-- Habits Metrics Bar --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-6 pt-5 border-t border-slate-800">
            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Habits</div>
                <div class="text-xl font-black text-white mt-0.5" x-text="habits.length"></div>
            </div>
            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Done Today</div>
                <div class="text-xl font-black text-amber-400 mt-0.5" x-text="`${completedHabitsToday}/${habits.length}`"></div>
            </div>
            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Completion</div>
                <div class="text-xl font-black text-white mt-0.5" x-text="habits.length ? `${Math.round((completedHabitsToday / habits.length) * 100)}%` : '0%'"></div>
            </div>
            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Max Streak</div>
                <div class="text-xl font-black text-amber-400 mt-0.5">21d 🔥</div>
            </div>
        </div>
    </div>

    {{-- Habits Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <template x-for="habit in habits" :key="habit.id">
            <div
                class="rounded-3xl p-5 border transition-all flex flex-col justify-between"
                :class="habit.completedToday ? 'bg-amber-50/40 border-amber-300/80 shadow-xs' : 'bg-white border-slate-200/90'"
            >
                <div>
                    {{-- Header & Checkbox --}}
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <span
                                class="text-[10px] font-extrabold uppercase tracking-wider px-2 py-0.5 rounded-full"
                                :class="{
                                    'bg-purple-100 text-purple-800': habit.category === 'Spiritual',
                                    'bg-sky-100 text-sky-800': habit.category === 'Knowledge',
                                    'bg-emerald-100 text-emerald-800': habit.category === 'Health',
                                    'bg-slate-100 text-slate-700': habit.category === 'Mindset'
                                }"
                                x-text="habit.category"
                            ></span>
                            <h3 class="text-base font-bold text-slate-900 mt-2 tracking-tight" x-text="habit.title"></h3>
                        </div>

                        <button
                            type="button"
                            @click="toggleHabit(habit.id)"
                            class="w-9 h-9 rounded-2xl flex items-center justify-center transition-all cursor-pointer active:scale-95 shrink-0"
                            :class="habit.completedToday ? 'bg-amber-400 text-slate-950 font-black shadow-xs' : 'border-2 border-slate-300 hover:border-slate-400 bg-slate-50 text-transparent'"
                            title="Toggle Habit Done"
                        >
                            ✓
                        </button>
                    </div>

                    {{-- Target Frequency --}}
                    <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                        <span>Target: <strong class="text-slate-800" x-text="habit.targetPerWeek"></strong></span>
                        <div class="flex items-center gap-1 font-bold text-amber-700 bg-amber-100/60 px-2 py-0.5 rounded-lg text-xs">
                            <span>🔥</span>
                            <span x-text="`${habit.streak} days streak`"></span>
                        </div>
                    </div>

                    {{-- 7-Day History Dots --}}
                    <div class="mt-4 pt-3 border-t border-slate-100">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Past 7 Days History</div>
                        <div class="flex items-center justify-between gap-1">
                            <template x-for="(day, idx) in habit.history" :key="idx">
                                <div class="flex flex-col items-center gap-1">
                                    <div
                                        class="w-6 h-6 rounded-lg flex items-center justify-center text-[10px] font-bold transition-colors"
                                        :class="day ? 'bg-slate-900 text-amber-400' : 'bg-slate-100 text-slate-400 border border-slate-200'"
                                    >
                                        <template x-if="day"><span>✓</span></template>
                                        <template x-if="!day"><span>•</span></template>
                                    </div>
                                    <span class="text-[9px] text-slate-400 font-medium" x-text="['M','T','W','T','F','S','S'][idx]"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Footer Action --}}
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-semibold" :class="habit.completedToday ? 'text-amber-800 font-bold' : 'text-slate-400'" x-text="habit.completedToday ? 'Completed Today ✓' : 'Pending for Today'"></span>
                    <button
                        type="button"
                        @click="deleteHabit(habit.id)"
                        class="text-xs text-rose-500 hover:text-rose-700 font-semibold"
                        title="Delete Habit"
                    >
                        Remove
                    </button>
                </div>
            </div>
        </template>
    </div>
</x-daei-layout>
