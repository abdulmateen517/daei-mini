{{-- Daily Timetable Main Component (Section 3) --}}
<div class="space-y-6">
    {{-- Top Action & Title Bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 rounded-2xl bg-white p-5 sm:p-6 border border-slate-200/90 shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-900 text-amber-400 shadow-sm shrink-0">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Daily Timetable & Schedule</h2>
                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200" x-text="`${todayActivitiesCount} items`"></span>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">
                    Plan your daily routines and prevent time collisions with real-time overlap validation.
                </p>
            </div>
        </div>

        {{-- Add Activity Button --}}
        <button
            type="button"
            @click="openAddModal()"
            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-900 bg-amber-400 hover:bg-amber-300 transition-all shadow-sm active:scale-95 shrink-0"
        >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            <span>Add Activity</span>
        </button>
    </div>

    {{-- Interactive Test Scenarios Bar --}}
    <x-timetable.sample-presets-bar />

    {{-- Conflict Warning Summary Banner (if timetable has any conflicts) --}}
    <template x-if="activeConflictsCount > 0">
        <div class="rounded-2xl border-2 border-amber-300 bg-amber-50/80 p-4 sm:p-5 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-start gap-3">
                <div class="p-2 rounded-xl bg-amber-200 text-amber-900 shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-amber-900 flex items-center gap-2">
                        <span>Schedule Conflict Notice</span>
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-extrabold bg-amber-300 text-amber-950" x-text="`${activeConflictsCount} conflicted cards`"></span>
                    </h3>
                    <p class="text-xs text-amber-800 mt-0.5">
                        One or more scheduled activities overlap on this calendar day. Highlighted cards show exact collision boundaries.
                    </p>
                </div>
            </div>

            <button
                type="button"
                @click="openAddModal({ date: selectedDate })"
                class="px-4 py-2 text-xs font-bold rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-900 transition-colors self-start sm:self-auto shrink-0"
            >
                Add Activity
            </button>
        </div>
    </template>

    {{-- Date Selectors & Category Filters --}}
    <div class="rounded-2xl bg-white p-4 sm:p-5 border border-slate-200/90 shadow-sm space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
            {{-- Quick Date Tabs --}}
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0">
                <button
                    type="button"
                    @click="selectedDate = '2026-11-08'"
                    class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap"
                    :class="selectedDate === '2026-11-08' ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                >
                    Today (Nov 8)
                </button>
                <button
                    type="button"
                    @click="selectedDate = '2026-11-09'"
                    class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap"
                    :class="selectedDate === '2026-11-09' ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                >
                    Tomorrow (Nov 9)
                </button>
                <button
                    type="button"
                    @click="selectedDate = 'all'"
                    class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap"
                    :class="selectedDate === 'all' ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                >
                    All Dates
                </button>

                {{-- Specific Date Input --}}
                <div class="flex items-center gap-1.5 ml-2 pl-2 border-l border-slate-200">
                    <span class="text-xs text-slate-500 font-medium hidden sm:inline">Pick Date:</span>
                    <input
                        type="date"
                        x-model="selectedDate"
                        class="rounded-xl border border-slate-300 bg-white px-2.5 py-1.5 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900"
                    />
                </div>
            </div>

            {{-- Search Box --}}
            <div class="relative w-full md:w-64">
                <input
                    type="text"
                    x-model="searchQuery"
                    placeholder="Search activities..."
                    class="w-full rounded-xl border border-slate-300 bg-white pl-9 pr-3 py-1.5 text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900"
                />
                <svg class="absolute left-3 top-2.5 h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        {{-- Category Filters --}}
        <div class="flex items-center gap-1.5 overflow-x-auto pt-2 border-t border-slate-100">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mr-1">Category:</span>
            <template x-for="cat in ['All', 'Work', 'Study', 'Worship', 'Health', 'Habit']" :key="cat">
                <button
                    type="button"
                    @click="filterCategory = cat"
                    class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap"
                    :class="filterCategory === cat ? 'bg-amber-400 text-slate-900 shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                    x-text="cat"
                ></button>
            </template>
        </div>
    </div>

    {{-- Activities Timeline List --}}
    <div class="space-y-3">
        <template x-if="filteredActivities.length === 0">
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-12 text-center shadow-sm">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-50 text-amber-500 border border-amber-100 mb-3">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <h4 class="text-base font-bold text-slate-900">No activities found</h4>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    No scheduled activities match your selected date or category filter. Add an activity or select another date.
                </p>
                <div class="mt-4">
                    <button
                        type="button"
                        @click="openAddModal()"
                        class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-900 text-white hover:bg-slate-800 transition-colors"
                    >
                        + Add Activity
                    </button>
                </div>
            </div>
        </template>

        <template x-for="activity in filteredActivities" :key="activity.id">
            <x-timetable.activity-card />
        </template>
    </div>
</div>
