{{-- Admin Panel Sidebar Navigation --}}
<aside
    class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-950 text-white flex flex-col justify-between transition-transform duration-300 lg:translate-x-0 shadow-2xl border-r border-slate-800"
    :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
>
    <div class="flex-1 overflow-y-auto">
        {{-- Brand / Logo --}}
        <div class="p-5 border-b border-slate-800/80 flex items-center justify-between bg-slate-900/60">
            <a href="{{ url('/admin') }}" class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-2xl bg-gradient-to-tr from-amber-400 to-amber-600 p-0.5 shadow-md flex items-center justify-center shrink-0">
                    <div class="h-full w-full bg-slate-950 rounded-[14px] flex items-center justify-center text-amber-400 font-black text-lg">
                        🛡️
                    </div>
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-base font-extrabold tracking-tight text-white">Admin Console</span>
                        <span class="text-[9px] uppercase font-black px-1.5 py-0.2 bg-amber-400/20 text-amber-300 rounded border border-amber-400/30">مربّي</span>
                    </div>
                    <p class="text-[11px] text-amber-400/80 font-medium">Mentor Supervisory Panel</p>
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
                Administration
            </div>

            {{-- 1. Admin Overview --}}
            <a
                href="{{ url('/admin') }}"
                @click="navigateToAdminTab('overview')"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all"
                :class="activeAdminTab === 'overview' ? 'bg-amber-400 text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
            >
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                <span>Admin Dashboard</span>
            </a>

            {{-- 2. User Management --}}
            <a
                href="{{ url('/admin/users') }}"
                @click="navigateToAdminTab('users')"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all"
                :class="activeAdminTab === 'users' ? 'bg-amber-400 text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    <span>User Management</span>
                </div>
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-800 text-amber-300" x-text="`${adminUsers.length} Mentees`"></span>
            </a>

            {{-- 3. Group Management --}}
            <a
                href="{{ url('/admin/groups') }}"
                @click="navigateToAdminTab('groups')"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all"
                :class="activeAdminTab === 'groups' ? 'bg-amber-400 text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    <span>Group Circles</span>
                </div>
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-800 text-slate-300" x-text="`${circles.length} Active`"></span>
            </a>

            <div class="pt-3 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                Supervisory & Review
            </div>

            {{-- 4. User Timetables Review --}}
            <a
                href="{{ url('/admin/timetables') }}"
                @click="navigateToAdminTab('timetables')"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all"
                :class="activeAdminTab === 'timetables' ? 'bg-amber-400 text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
            >
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                <span>Timetable Review</span>
            </a>

            {{-- 5. User Progress & Streaks --}}
            <a
                href="{{ url('/admin/progress') }}"
                @click="navigateToAdminTab('progress')"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all"
                :class="activeAdminTab === 'progress' ? 'bg-amber-400 text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
            >
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                <span>Mentee Progress</span>
            </a>

            {{-- 6. Daily Reports Review --}}
            <a
                href="{{ url('/admin/reports') }}"
                @click="navigateToAdminTab('reports')"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all"
                :class="activeAdminTab === 'reports' ? 'bg-amber-400 text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    <span>Reports Review</span>
                </div>
                <span class="text-[10px] font-extrabold px-1.5 py-0.5 rounded bg-amber-500 text-slate-950">1 Review</span>
            </a>

            {{-- 7. Guidance & Comments --}}
            <a
                href="{{ url('/admin/feedback') }}"
                @click="navigateToAdminTab('feedback')"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all"
                :class="activeAdminTab === 'feedback' ? 'bg-amber-400 text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
            >
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" /></svg>
                <span>Provide Feedback</span>
            </a>
        </div>
    </div>

    {{-- Bottom Admin Profile & User Switcher --}}
    <div class="p-3.5 border-t border-slate-800 bg-slate-900/80 space-y-2">
        <div class="flex items-center gap-3">
            <div class="h-9 w-9 rounded-xl bg-amber-400 text-slate-950 flex items-center justify-center font-black shrink-0 text-xs shadow-xs">
                FM
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-xs font-bold text-white truncate" x-text="admin.name"></div>
                <div class="text-[11px] text-amber-400/90 truncate" x-text="admin.title"></div>
            </div>
        </div>

        <a
            href="{{ url('/dashboard') }}"
            @click="switchRole('user')"
            class="w-full flex items-center justify-center gap-2 py-2 rounded-xl text-xs font-bold text-white bg-slate-800 hover:bg-slate-700 transition-colors border border-slate-700"
        >
            <svg class="w-3.5 h-3.5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            <span>Return to User Panel</span>
        </a>
    </div>
</aside>
