<x-daei-layout title="User Dashboard — Daei Mini">
    {{-- User Dashboard Welcome Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 text-white p-6 sm:p-8 shadow-md border border-slate-800">
        <div class="absolute -right-8 -top-8 w-48 h-48 rounded-full bg-amber-400/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-2.5 py-0.5 rounded-full border border-amber-400/20">
                        Assalamu Alaikum • داعي
                    </span>
                    <span class="text-xs text-slate-400" x-text="`${user.gregorianDate} • ${user.hijriDate}`"></span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Welcome back, <span x-text="user.name"></span>!
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1.5 max-w-xl">
                    Review your daily spiritual discipline, manage study blocks, and ensure schedule integrity with automatic overlap collision prevention.
                </p>
                <div class="mt-4 flex flex-wrap items-center gap-3">
                    <a href="{{ url('/timetable') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <span>Open Daily Timetable</span>
                    </a>
                    <a href="{{ url('/daily-report') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-white bg-slate-800 hover:bg-slate-700 transition-colors border border-slate-700">
                        <svg class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        <span>Complete Daily Report</span>
                    </a>
                </div>
            </div>

            {{-- Summary Quick Metrics --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-2 gap-3 shrink-0">
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 text-center">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Streak</div>
                    <div class="text-xl font-black text-amber-400 flex items-center justify-center gap-1 mt-0.5">
                        <span>🔥</span>
                        <span x-text="`${user.streakDays}d`"></span>
                    </div>
                </div>
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 text-center">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Prayers Today</div>
                    <div class="text-xl font-black text-white mt-0.5" x-text="`${completedPrayersCount}/5`"></div>
                </div>
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 text-center">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Activities</div>
                    <div class="text-xl font-black text-white mt-0.5" x-text="totalActivitiesCount"></div>
                </div>
                <div
                    class="p-4 rounded-2xl border text-center transition-colors"
                    :class="activeConflictsCount > 0 ? 'bg-amber-400/20 border-amber-400/40 text-amber-300' : 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300'"
                >
                    <div class="text-[10px] font-bold uppercase tracking-wider">Conflicts</div>
                    <div class="text-xl font-black mt-0.5" x-text="activeConflictsCount"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Five Daily Prayers Quick Bar --}}
    <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-200/80">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-sm font-extrabold uppercase tracking-wider text-slate-900 flex items-center gap-2">
                    <span>🕋 Five Daily Prayers</span>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-900" x-text="`${completedPrayersCount} of 5 completed`"></span>
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Track your daily Salah, congregation attendance, and Sunnah prayers.</p>
            </div>
            <a href="{{ url('/prayers') }}" class="text-xs font-bold text-slate-900 hover:text-amber-600 flex items-center gap-1">
                <span>Detailed Tracker</span>
                <span>→</span>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            <template x-for="p in prayers" :key="p.id">
                <div
                    @click="togglePrayer(p.id)"
                    class="cursor-pointer p-3.5 rounded-2xl border transition-all select-none"
                    :class="p.completed ? 'bg-slate-900 text-white border-slate-900 shadow-xs' : 'bg-slate-50 hover:bg-slate-100/80 text-slate-800 border-slate-200'"
                >
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold" x-text="p.name"></span>
                        <div
                            class="w-5 h-5 rounded-lg flex items-center justify-center text-xs font-black transition-colors"
                            :class="p.completed ? 'bg-amber-400 text-slate-950' : 'border border-slate-300 bg-white text-transparent'"
                        >
                            ✓
                        </div>
                    </div>
                    <div class="mt-2 flex items-center justify-between text-[11px]" :class="p.completed ? 'text-slate-300' : 'text-slate-500'">
                        <span x-text="p.time"></span>
                        <template x-if="p.inJamaah">
                            <span class="text-[9px] font-bold px-1.5 py-0.2 rounded" :class="p.completed ? 'bg-amber-400/20 text-amber-300' : 'bg-slate-200 text-slate-700'">Jamaah</span>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>

    {{-- 2-Column Grid: Today's Timetable Preview & Habits / Guidance --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left: Timetable Snapshot (2 cols) --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-200/80">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-sm font-extrabold uppercase tracking-wider text-slate-900 flex items-center gap-2">
                            <span>📅 Today's Scheduled Activities</span>
                            <span class="text-xs font-bold text-slate-400" x-text="`(${todayActivities.length} total)`"></span>
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">Chronological activities with real-time overlap collision status.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            @click="openAddModal()"
                            class="px-3 py-1.5 rounded-xl text-xs font-bold text-slate-900 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs"
                        >
                            + Add Activity
                        </button>
                        <a href="{{ url('/timetable') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900">
                            Full Timetable →
                        </a>
                    </div>
                </div>

                {{-- Conflict Warning Banner if clashes exist --}}
                <template x-if="activeConflictsCount > 0">
                    <div class="mb-4 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 flex items-start gap-3">
                        <span class="text-lg">⚠️</span>
                        <div class="text-xs">
                            <span class="font-bold" x-text="`${activeConflictsCount} time overlap conflict(s) detected in today's schedule!`"></span>
                            <p class="text-rose-700 mt-0.5">Activities highlighted in red clash. Open the Timetable to adjust start/end times.</p>
                        </div>
                    </div>
                </template>

                {{-- Activities List --}}
                <div class="space-y-3">
                    <template x-if="todayActivities.length === 0">
                        <div class="p-8 text-center rounded-2xl bg-slate-50 border border-dashed border-slate-200 text-slate-500 text-xs">
                            No activities scheduled for today. Click "+ Add Activity" to create one.
                        </div>
                    </template>

                    <template x-for="act in todayActivities.slice(0, 5)" :key="act.id">
                        <div
                            class="p-4 rounded-2xl border transition-all flex items-center justify-between gap-4"
                            :class="highlightedActivityIds.includes(act.id) ? 'bg-rose-50/60 border-rose-400 ring-1 ring-rose-300 shadow-xs' : 'bg-white border-slate-200/90 hover:border-slate-300'"
                        >
                            <div class="flex items-center gap-3.5 min-w-0">
                                <div class="w-2.5 h-10 rounded-full shrink-0" :class="{
                                    'bg-amber-400': act.category === 'Islamic Studies' || act.category === 'Salah',
                                    'bg-sky-500': act.category === 'Work' || act.category === 'Dawah',
                                    'bg-emerald-500': act.category === 'Habit' || act.category === 'Personal',
                                    'bg-rose-500': act.category === 'Health'
                                }"></div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 truncate" x-text="act.name"></h4>
                                        <template x-if="highlightedActivityIds.includes(act.id)">
                                            <span class="px-2 py-0.5 rounded-md text-[9px] font-black uppercase tracking-wider bg-rose-500 text-white">Clashing</span>
                                        </template>
                                    </div>
                                    <div class="text-xs text-slate-500 flex items-center gap-2 mt-0.5">
                                        <span class="font-medium" x-text="`${act.startTime} – ${act.endTime}`"></span>
                                        <span>•</span>
                                        <span class="text-[11px] px-2 py-0.2 rounded-md bg-slate-100 text-slate-600 font-semibold" x-text="act.category"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <span
                                    class="text-[10px] font-bold px-2 py-1 rounded-lg uppercase tracking-wider"
                                    :class="{
                                        'bg-emerald-100 text-emerald-800': act.status === 'Completed',
                                        'bg-amber-100 text-amber-800': act.status === 'Pending',
                                        'bg-rose-100 text-rose-800': act.status === 'Missed'
                                    }"
                                    x-text="act.status"
                                ></span>
                                <button
                                    type="button"
                                    @click="openEditModal(act)"
                                    class="p-1.5 rounded-lg text-slate-400 hover:text-slate-900 hover:bg-slate-100"
                                    title="Edit Activity"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- Right: Habits & Mentor Guidance (1 col) --}}
        <div class="space-y-6">
            {{-- Habits Snapshot --}}
            <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-200/80">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-sm font-extrabold uppercase tracking-wider text-slate-900">Habits Today</h2>
                        <p class="text-xs text-slate-500" x-text="`${completedHabitsToday} of ${habits.length} checked`"></p>
                    </div>
                    <a href="{{ url('/habits') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900">All Habits →</a>
                </div>

                <div class="space-y-2.5">
                    <template x-for="h in habits.slice(0, 4)" :key="h.id">
                        <div
                            @click="toggleHabit(h.id)"
                            class="cursor-pointer p-3 rounded-2xl border transition-all flex items-center justify-between"
                            :class="h.completedToday ? 'bg-amber-50/50 border-amber-200 text-slate-900' : 'bg-slate-50 border-slate-200 text-slate-700'"
                        >
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div
                                    class="w-4 h-4 rounded-md flex items-center justify-center text-[10px] font-bold shrink-0"
                                    :class="h.completedToday ? 'bg-amber-400 text-slate-950' : 'border border-slate-300 bg-white'"
                                >
                                    ✓
                                </div>
                                <span class="text-xs font-bold truncate" :class="h.completedToday ? 'line-through text-slate-400' : ''" x-text="h.title"></span>
                            </div>
                            <span class="text-[10px] font-bold text-amber-700 shrink-0" x-text="`${h.streak}d 🔥`"></span>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Mentor Feedback Advice Snapshot --}}
            <div class="bg-slate-900 text-white rounded-3xl p-6 shadow-xs border border-slate-800">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <span class="text-amber-400">💡</span>
                        <h3 class="text-xs font-black uppercase tracking-wider text-amber-400">Mentor Advice</h3>
                    </div>
                    <span class="text-[10px] text-slate-400" x-text="reports['2026-11-07']?.mentorFeedback?.timestamp || 'Nov 7'"></span>
                </div>
                <p class="text-xs text-slate-200 leading-relaxed italic" x-text="`“${reports['2026-11-07']?.mentorFeedback?.comment || 'Maintain sincerity and protect your morning prayer routines.'}”`"></p>
                <div class="mt-4 pt-3 border-t border-slate-800 flex items-center justify-between text-xs">
                    <span class="text-slate-400 text-[11px]" x-text="reports['2026-11-07']?.mentorFeedback?.mentorName || 'Ustadh Farhan'"></span>
                    <a href="{{ url('/feedback') }}" class="font-bold text-amber-400 hover:text-amber-300">View All Feedback →</a>
                </div>
            </div>
        </div>
    </div>
</x-daei-layout>
