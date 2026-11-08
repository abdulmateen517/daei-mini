<x-daei-layout title="Exercise Tracking — Daei Mini">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 text-white p-6 sm:p-8 shadow-md border border-slate-800">
        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-amber-400/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-2.5 py-0.5 rounded-full border border-amber-400/20">
                        Sihhah • Physical Strength
                    </span>
                    <span class="text-xs text-slate-400">Fitness & Vitality</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Exercise & Fitness Tracking
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    "The strong believer is better and more beloved to Allah than the weak believer, while there is good in both." Keep your body healthy for worship.
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <button
                    type="button"
                    @click="isAddExerciseModalOpen = true"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs active:scale-95"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                    <span>+ Log Workout</span>
                </button>
            </div>
        </div>

        {{-- Weekly Metrics Summary --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-6 pt-5 border-t border-slate-800">
            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Workouts Logged</div>
                <div class="text-xl font-black text-white mt-0.5" x-text="exercises.length"></div>
            </div>
            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Avg Duration</div>
                <div class="text-xl font-black text-amber-400 mt-0.5">30 mins</div>
            </div>
            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center col-span-2 sm:col-span-1">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Burned</div>
                <div class="text-xl font-black text-white mt-0.5">~630 kcal</div>
            </div>
        </div>
    </div>

    {{-- Workout Log Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <template x-for="item in exercises" :key="item.id">
            <div class="rounded-3xl p-6 bg-white border border-slate-200/90 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span
                            class="text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full"
                            :class="{
                                'bg-emerald-100 text-emerald-800': item.intensity === 'Low',
                                'bg-amber-100 text-amber-800': item.intensity === 'Moderate',
                                'bg-rose-100 text-rose-800': item.intensity === 'High'
                            }"
                            x-text="`${item.intensity} Intensity`"
                        ></span>
                        <span class="text-xs text-slate-500 font-medium" x-text="item.timeSlot"></span>
                    </div>

                    <h3 class="text-base font-bold text-slate-900 tracking-tight" x-text="item.title"></h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed" x-text="item.notes"></p>

                    <div class="mt-4 flex items-center gap-4 text-xs font-semibold text-slate-700">
                        <div class="flex items-center gap-1.5">
                            <span class="text-amber-500">⏱️</span>
                            <span x-text="item.duration"></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-rose-500">🔥</span>
                            <span x-text="`${item.calories} kcal`"></span>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <span class="text-emerald-700 font-semibold flex items-center gap-1">
                        <span>✓</span>
                        <span>Logged in Timetable</span>
                    </span>
                </div>
            </div>
        </template>
    </div>
</x-daei-layout>
