<x-daei-layout title="Daily Self-Assessment — Daei Mini">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 text-white p-6 sm:p-8 shadow-md border border-slate-800">
        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-amber-400/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-2.5 py-0.5 rounded-full border border-amber-400/20">
                        Muhasabat an-Nafs • Self-Inventory
                    </span>
                    <span class="text-xs text-slate-400">Daily Evaluation</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Daily Self-Assessment
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    "Take account of yourselves before you are called to account." Rate your inner focus, discipline, and timetable adherence.
                </p>
            </div>

            {{-- Daily Score Badge --}}
            <div class="p-4 rounded-2xl bg-white/5 border border-white/10 text-center shrink-0">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Today's Avg Score</div>
                <div class="text-2xl font-black text-amber-400 mt-0.5" x-text="`${((todaySelfAssessment.spiritualRating + todaySelfAssessment.productivityRating + todaySelfAssessment.disciplineRating) / 3).toFixed(1)} / 5.0`"></div>
            </div>
        </div>
    </div>

    {{-- Interactive Rating Form --}}
    <form @submit.prevent="saveSelfAssessment()" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- 1. Spiritual Focus Rating --}}
            <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-200/90 flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-2xl bg-purple-100 text-purple-900 flex items-center justify-center font-bold text-lg mb-3">
                        ✨
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900">Spiritual Focus & Khushoo'</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                        Punctuality of prayers, presence of heart during Salah, morning/evening adhkar, and Quranic contemplation.
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-700 mb-2">
                        <span>Current Rating:</span>
                        <span class="text-purple-700 text-sm font-black" x-text="`${todaySelfAssessment.spiritualRating} / 5`"></span>
                    </div>
                    <div class="grid grid-cols-5 gap-1.5">
                        <template x-for="val in [1, 2, 3, 4, 5]" :key="val">
                            <button
                                type="button"
                                @click="todaySelfAssessment.spiritualRating = val"
                                class="py-2.5 rounded-xl text-xs font-black transition-all"
                                :class="todaySelfAssessment.spiritualRating === val ? 'bg-slate-900 text-amber-400 shadow-xs ring-2 ring-slate-900' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                                x-text="val"
                            ></button>
                        </template>
                    </div>
                </div>
            </div>

            {{-- 2. Productivity & Timetable Discipline --}}
            <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-200/90 flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-2xl bg-sky-100 text-sky-900 flex items-center justify-center font-bold text-lg mb-3">
                        ⚡
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900">Productivity & Timetable</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                        Adherence to scheduled blocks, avoidance of phone procrastination, and completing planned daily tasks without delay.
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-700 mb-2">
                        <span>Current Rating:</span>
                        <span class="text-sky-700 text-sm font-black" x-text="`${todaySelfAssessment.productivityRating} / 5`"></span>
                    </div>
                    <div class="grid grid-cols-5 gap-1.5">
                        <template x-for="val in [1, 2, 3, 4, 5]" :key="val">
                            <button
                                type="button"
                                @click="todaySelfAssessment.productivityRating = val"
                                class="py-2.5 rounded-xl text-xs font-black transition-all"
                                :class="todaySelfAssessment.productivityRating === val ? 'bg-slate-900 text-amber-400 shadow-xs ring-2 ring-slate-900' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                                x-text="val"
                            ></button>
                        </template>
                    </div>
                </div>
            </div>

            {{-- 3. Character & Mindset Discipline --}}
            <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-200/90 flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-900 flex items-center justify-center font-bold text-lg mb-3">
                        🛡️
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900">Discipline & Character</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                        Patience during difficulties, guarding the tongue from idle speech, maintaining good manners, and evening reflection.
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-700 mb-2">
                        <span>Current Rating:</span>
                        <span class="text-amber-700 text-sm font-black" x-text="`${todaySelfAssessment.disciplineRating} / 5`"></span>
                    </div>
                    <div class="grid grid-cols-5 gap-1.5">
                        <template x-for="val in [1, 2, 3, 4, 5]" :key="val">
                            <button
                                type="button"
                                @click="todaySelfAssessment.disciplineRating = val"
                                class="py-2.5 rounded-xl text-xs font-black transition-all"
                                :class="todaySelfAssessment.disciplineRating === val ? 'bg-slate-900 text-amber-400 shadow-xs ring-2 ring-slate-900' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                                x-text="val"
                            ></button>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        {{-- Notes & Reflection --}}
        <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-200/90 space-y-4">
            <div>
                <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-900 mb-1">Daily Reflection Notes & Lessons Learned</label>
                <p class="text-xs text-slate-500 mb-2">What went well today? What will you do better tomorrow to preserve Barakah?</p>
                <textarea
                    rows="4"
                    x-model="todaySelfAssessment.notes"
                    class="w-full rounded-2xl border border-slate-300 p-3.5 text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900"
                    placeholder="Reflect on your daily challenges and blessings..."
                ></textarea>
            </div>

            <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-3">
                <span class="text-xs text-slate-500">
                    These ratings are included in your mentor's daily report submission.
                </span>

                <div class="flex items-center gap-3">
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors shadow-xs"
                    >
                        Save Evaluation
                    </button>
                    <a
                        href="{{ url('/daily-report') }}"
                        class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs"
                    >
                        Proceed to Daily Report →
                    </a>
                </div>
            </div>
        </div>
    </form>
</x-daei-layout>
