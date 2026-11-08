{{-- User Panel Sidebar Navigation --}}
<aside
    class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-white flex flex-col justify-between transition-transform duration-300 lg:translate-x-0 shadow-2xl border-r border-slate-800"
    :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
>
    <div class="flex-1 overflow-y-auto">
        {{-- Brand / Logo --}}
        <div class="p-5 border-b border-slate-800/80 flex items-center justify-between">
            <a href="{{ url('/dashboard') }}" class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-2xl bg-gradient-to-tr from-amber-500 to-yellow-400 p-0.5 shadow-md flex items-center justify-center shrink-0">
                    <div class="h-full w-full bg-slate-950 rounded-[14px] flex items-center justify-center text-amber-400 font-black text-lg">
                        D
                    </div>
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-base font-extrabold tracking-tight text-white">Daei Mini</span>
                        <span class="text-[9px] uppercase font-black px-1.5 py-0.2 bg-amber-400/20 text-amber-300 rounded border border-amber-400/30">داعي</span>
                    </div>
                    <p class="text-[11px] text-slate-400">User Productivity Suite</p>
                </div>
            </a>

            <button
                type="button"
                @click="isSidebarOpen = false"
                class="lg:hidden p-1.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800"
            >
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        {{-- Navigation Menu --}}
        <div class="p-3.5 space-y-1">
            <div class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                Core Modules
            </div>

            {{-- 1. Dashboard --}}
            <a
                href="{{ url('/dashboard') }}"
                @click="navigateToUserTab('dashboard')"
                class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                :class="activeUserTab === 'dashboard' ? 'bg-amber-400 text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
            >
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                <span>User Dashboard</span>
            </a>

            {{-- 2. Daily Timetable (Task 3) --}}
            <a
                href="{{ url('/timetable') }}"
                @click="navigateToUserTab('timetable')"
                class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                :class="activeUserTab === 'timetable' ? 'bg-amber-400 text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <span>Daily Timetable</span>
                </div>
                <template x-if="activeConflictsCount > 0">
                    <span class="px-1.5 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-500 text-white" x-text="`${activeConflictsCount} clashing`"></span>
                </template>
            </a>

            {{-- 3. Five Daily Prayers --}}
            <a
                href="{{ url('/prayers') }}"
                @click="navigateToUserTab('prayers')"
                class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                :class="activeUserTab === 'prayers' ? 'bg-amber-400 text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>Prayer Tracker</span>
                </div>
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-800 text-amber-300" x-text="`${completedPrayersCount}/5`"></span>
            </a>

            {{-- 4. Habits Tracking --}}
            <a
                href="{{ url('/habits') }}"
                @click="navigateToUserTab('habits')"
                class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                :class="activeUserTab === 'habits' ? 'bg-amber-400 text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" /></svg>
                    <span>Habits & Streaks</span>
                </div>
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-800 text-slate-300" x-text="`${completedHabitsToday}/${habits.length}`"></span>
            </a>

            {{-- 5. Personal Goals --}}
            <a
                href="{{ url('/goals') }}"
                @click="navigateToUserTab('goals')"
                class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                :class="activeUserTab === 'goals' ? 'bg-amber-400 text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
            >
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>Personal Goals</span>
            </a>

            {{-- 6. Exercise & Fitness --}}
            <a
                href="{{ url('/exercise') }}"
                @click="navigateToUserTab('exercise')"
                class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                :class="activeUserTab === 'exercise' ? 'bg-amber-400 text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
            >
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                <span>Exercise Tracking</span>
            </a>

            <div class="pt-3 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                Knowledge & Reflection
            </div>

            {{-- 7. Quran & Tafseer Sessions --}}
            <a
                href="{{ url('/quran-tafseer') }}"
                @click="navigateToUserTab('quran')"
                class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                :class="activeUserTab === 'quran' ? 'bg-amber-400 text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
            >
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                <span>Quran & Tafseer Slots</span>
            </a>

            {{-- 8. Digital Library & Reading --}}
            <a
                href="{{ url('/reading') }}"
                @click="navigateToUserTab('reading')"
                class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                :class="activeUserTab === 'reading' ? 'bg-amber-400 text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
            >
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                <span>Reading Tracking</span>
            </a>

            {{-- 9. Personal Journal (Private) --}}
            <a
                href="{{ url('/journal') }}"
                @click="navigateToUserTab('journal')"
                class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                :class="activeUserTab === 'journal' ? 'bg-amber-400 text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                    <span>Personal Journal</span>
                </div>
                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-slate-800 text-emerald-300">Private 🔒</span>
            </a>

            <div class="pt-3 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                Accountability & Reports
            </div>

            {{-- 10. Self Assessment --}}
            <a
                href="{{ url('/self-assessment') }}"
                @click="navigateToUserTab('self-assessment')"
                class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                :class="activeUserTab === 'self-assessment' ? 'bg-amber-400 text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
            >
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                <span>Daily Self-Assessment</span>
            </a>

            {{-- 11. Daily Reports --}}
            <a
                href="{{ url('/daily-report') }}"
                @click="navigateToUserTab('reports')"
                class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                :class="activeUserTab === 'reports' ? 'bg-amber-400 text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    <span>Daily Reports</span>
                </div>
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded" :class="reports['2026-11-08']?.isSubmitted ? 'bg-emerald-900/60 text-emerald-300' : 'bg-amber-400/20 text-amber-300'" x-text="reports['2026-11-08']?.isSubmitted ? 'Sent ✓' : 'Due'"></span>
            </a>

            {{-- 12. Admin Feedback --}}
            <a
                href="{{ url('/feedback') }}"
                @click="navigateToUserTab('feedback')"
                class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                :class="activeUserTab === 'feedback' ? 'bg-amber-400 text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" /></svg>
                    <span>Mentor Guidance</span>
                </div>
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-800 text-amber-300">1 Advice</span>
            </a>
        </div>
    </div>

    {{-- Bottom Profile & Admin Switcher --}}
    <div class="p-3.5 border-t border-slate-800 bg-slate-950/60 space-y-2">
        <div class="flex items-center gap-3">
            <div class="h-9 w-9 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center font-bold text-amber-400 shrink-0 text-xs">
                ZK
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-xs font-bold text-white truncate" x-text="user.name"></div>
                <div class="text-[11px] text-slate-400 truncate" x-text="user.circle"></div>
            </div>
        </div>

        <a
            href="{{ url('/admin') }}"
            @click="switchRole('admin')"
            class="w-full flex items-center justify-center gap-2 py-2 rounded-xl text-xs font-bold text-slate-900 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs"
        >
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /></svg>
            <span>Open Admin Panel</span>
        </a>
    </div>
</aside>
