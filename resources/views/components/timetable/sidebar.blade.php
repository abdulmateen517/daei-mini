{{-- Sidebar Navigation Component (Theme Section 2) --}}
<aside
    class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-white flex flex-col justify-between transition-transform duration-300 lg:translate-x-0 shadow-xl border-r border-slate-800"
    :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
>
    <div>
        {{-- Brand / Logo --}}
        <div class="p-6 border-b border-slate-800/80 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-2xl bg-gradient-to-tr from-amber-500 to-yellow-400 p-0.5 shadow-md flex items-center justify-center shrink-0">
                    <div class="h-full w-full bg-slate-950 rounded-[14px] flex items-center justify-center text-amber-400 font-extrabold text-lg">
                        D
                    </div>
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <h1 class="text-base font-extrabold tracking-tight text-white">Daei Mini</h1>
                        <span class="text-[9px] uppercase font-black px-1.5 py-0.2 bg-amber-400/20 text-amber-300 rounded border border-amber-400/30">داعي</span>
                    </div>
                    <p class="text-[11px] text-slate-400">Timetable & Productivity</p>
                </div>
            </div>

            {{-- Close mobile button --}}
            <button
                type="button"
                @click="isSidebarOpen = false"
                class="lg:hidden p-1.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800"
            >
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Nav Items --}}
        <div class="p-4 space-y-1">
            <div class="px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                Main Menu
            </div>

            {{-- Dashboard --}}
            <a
                href="{{ url('/dashboard') }}"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:bg-slate-800/70 hover:text-white transition-colors"
            >
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Dashboard</span>
            </a>

            {{-- Daily Timetable (Active Item) --}}
            <a
                href="#timetable"
                class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold bg-amber-400 text-slate-950 shadow-md shadow-amber-400/10 transition-colors"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-slate-950" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Daily Timetable</span>
                </div>
                {{-- Active conflicts badge in sidebar --}}
                <template x-if="activeConflictsCount > 0">
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-950 text-amber-300" x-text="`${activeConflictsCount} conflict${activeConflictsCount > 1 ? 's' : ''}`"></span>
                </template>
            </a>

            {{-- Activities --}}
            <a
                href="#activities"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:bg-slate-800/70 hover:text-white transition-colors"
            >
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span>Activity Archive</span>
            </a>

            {{-- Schedule Conflicts Center --}}
            <div class="pt-4">
                <div class="px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                    Conflict Monitor
                </div>
                <div class="rounded-2xl bg-slate-800/50 p-3.5 border border-slate-700/60 mx-1">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-200">
                        <span>Overlap Engine</span>
                        <span class="text-[10px] font-bold text-emerald-400 flex items-center gap-1">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            ACTIVE
                        </span>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">
                        Exact mathematical overlap formula: <code class="text-amber-300 font-mono text-[10px]">(startA &lt; endB) &amp;&amp; (endA &gt; startB)</code>
                    </p>
                    <div class="mt-2.5 pt-2 border-t border-slate-700/60 flex items-center justify-between text-[11px]">
                        <span class="text-slate-400">Active Conflicts:</span>
                        <span class="font-extrabold" :class="activeConflictsCount > 0 ? 'text-amber-400' : 'text-emerald-400'" x-text="`${activeConflictsCount} detected`"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom User Profile Section --}}
    <div class="p-4 border-t border-slate-800/80 bg-slate-950/40">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center font-bold text-amber-400 shrink-0">
                ZK
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-xs font-bold text-white truncate">Zayd Ibn Khalid</div>
                <div class="text-[11px] text-slate-400 truncate">Da’ee Member • Youth Circle</div>
            </div>
            <div class="p-1 rounded-lg bg-amber-400/10 text-amber-400 text-[10px] font-bold border border-amber-400/20">
                14d 🔥
            </div>
        </div>
    </div>
</aside>

{{-- Mobile Sidebar Backdrop --}}
<div
    x-show="isSidebarOpen"
    x-cloak
    class="fixed inset-0 z-30 bg-slate-900/60 backdrop-blur-sm lg:hidden"
    @click="isSidebarOpen = false"
    style="display: none;"
></div>
