{{-- Dashboard Header Component --}}
<header class="sticky top-0 z-20 bg-white/90 backdrop-blur-md border-b border-slate-200/90 px-4 sm:px-6 lg:px-8 py-3.5 shadow-xs">
    <div class="flex items-center justify-between gap-4">
        {{-- Left: Mobile Toggle & Page Title --}}
        <div class="flex items-center gap-3">
            <button
                type="button"
                @click="isSidebarOpen = true"
                class="lg:hidden p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors"
                title="Toggle Menu"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-slate-500">Daei Mini</span>
                    <span class="text-slate-300">/</span>
                    <span class="text-xs font-bold text-slate-900">User Dashboard</span>
                </div>
                <h1 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Daily Timetable &amp; Schedule
                </h1>
            </div>
        </div>

        {{-- Right: Status pill, Quick Stats, & Add Button --}}
        <div class="flex items-center gap-2.5 sm:gap-4">
            {{-- Conflict Status Indicator --}}
            <div class="hidden sm:flex items-center">
                <template x-if="activeConflictsCount > 0">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-900 border border-amber-300 shadow-xs animate-pulse">
                        <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                        <span x-text="`${activeConflictsCount} Overlap${activeConflictsCount > 1 ? 's' : ''} Detected`"></span>
                    </span>
                </template>
                <template x-if="activeConflictsCount === 0">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        <span>Schedule Conflict-Free</span>
                    </span>
                </template>
            </div>

            {{-- Quick Stats Pills --}}
            <div class="hidden md:flex items-center gap-2 border-l border-slate-200 pl-4">
                <div class="text-right">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Hours</div>
                    <div class="text-xs font-extrabold text-slate-800" x-text="scheduledHoursFormatted"></div>
                </div>
            </div>

            {{-- Primary Add Button --}}
            <button
                type="button"
                @click="openAddModal()"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-slate-900 bg-amber-400 hover:bg-amber-300 transition-colors shadow-sm active:scale-95"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>Add Activity</span>
            </button>
        </div>
    </div>
</header>
